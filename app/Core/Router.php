<?php

namespace App\Core;

use App\Services\CacheService;
use App\Services\DatabaseService;
use App\Services\ConfigService;
use App\Services\ContentService;
use Exception;

/**
 * Handles incoming requests and routes them to the appropriate controller.
 * Manages application routes, loading them from cache or database.
 */
class Router
{
    private array $routes = [];
    private Container $container;
    private ConfigService $configService;
    private ContentService $contentService;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->configService = $this->container->get(ConfigService::class);
        $this->contentService = $this->container->get(ContentService::class);
        $this->loadRoutes();
    }

    /**
     * Loads application routes from cache or database.
     *
     * @throws Exception If no pages are found in the database.
     */
    private function loadRoutes(): void
    {
        /** @var CacheService $cache */
        $cache = $this->container->get(CacheService::class);
        $cacheKey = 'app_routes';
        $routes = [];

        // Clear cache if in development mode and cache clearing is enabled in config
        if ($this->configService->get('is_dev') && $this->configService->get('cache_clear')) {
            $cache->delete($cacheKey);
            error_log("Router: Cache cleared for routes.");
        }

        $cachedRoutes = $cache->get($cacheKey);

        if ($cachedRoutes === false || $cachedRoutes === null) {
            $pages = $this->contentService->getAll('page');

            if (empty($pages)) {
                throw new Exception("Router: No pages found in database. Run 'make seed'.");
            }

            foreach ($pages as $page) {
                $routeName = $page['name'];
                $routes[$routeName] = [
                    'path'       => $routeName === 'home' ? '/' : "/{$routeName}/",
                    'controller' => "App\\Controllers\\" . ucfirst($routeName) . "Controller",
                    'pageData'   => $page
                ];
            }
            $cache->set($cacheKey, $routes, $this->configService->get('cache_ttl'));
            error_log("Router: Routes loaded from database and cached.");
        } else {
            $routes = $cachedRoutes;
        }

        $this->routes = $routes;
    }

    /**
     * Extracts the clean URI from the server request, removing query string.
     *
     * @return string The cleaned URI.
     */
    private function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        $pos = strpos($uri, '?');
        if ($pos !== false) {
            $uri = substr($uri, 0, $pos);
        }
        return $uri;
    }

    /**
     * Matches the given URI to an available route.
     *
     * @param string $uri The URI to match.
     * @return array|null The matched route array, or null if no route is found.
     */
    private function matchRoute(string $uri): ?array
    {
        foreach ($this->routes as $route) {
            $normalizedRoutePath = rtrim($route['path'], '/');
            $normalizedUri = rtrim($uri, '/');

            if ($normalizedRoutePath === $normalizedUri) {
                error_log("Router: Route matched: " . $route['path']);
                return $route;
            }
        }
        error_log("Router: No route matched for URI: " . $uri);
        return null;
    }

    /**
     * Resolves the current request, finds the matching route,
     * sets page data in the container, and executes the corresponding controller.
     *
     * @throws Exception If no route is matched or controller class not found.
     */
    public function resolve(): void
    {
        $uri = $this->getUri();
        $route = $this->matchRoute($uri);

        if ($route === null) {
            if (!isset($this->routes['error'])) {
                throw new Exception("Router: Critical: 'error' page not defined in routes. Ensure 'error' page exists in database.");
            }
            $route = $this->routes['error'];
            http_response_code(404);
            error_log("Router: No route matched for '{$uri}', falling back to 'error' page (404).");
        }

        // Set complete page data in the Container
        $this->container->setPageData($route['pageData']);

        $controllerName = $route['controller'];

        if (!class_exists($controllerName)) {
            if ($route['name'] === 'error') {
                throw new Exception("Router: Critical: Error controller '{$controllerName}' not found. Application cannot handle errors gracefully.");
            }
            error_log("Router: Controller '{$controllerName}' not found for route '{$route['path']}'. Falling back to error page.");
            http_response_code(500);
            $route = $this->routes['error'];
            // Update page data to error page's data if fallback occurs
            $this->container->setPageData($route['pageData']);
            $controllerName = $route['controller'];
        }

        $controllerInstance = new $controllerName($this->container);
        $controllerInstance->index();
    }
}