<?php

namespace App\Core;

use App\Services\CacheService;
use App\Services\DatabaseService;
use App\Services\ConfigService;
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

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->configService = $this->container->get(ConfigService::class);
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
            /** @var DatabaseService $db */
            $db = $this->container->get(DatabaseService::class);
            $pages = $db->query("SELECT * FROM pages");

            if (empty($pages)) {
                throw new Exception("Router: No pages found in database. Run 'make seed'."); // Improved exception message
            }

            foreach ($pages as $page) {
                $routeName = $page['name'];
                $routes[$routeName] = [
                    'path'       => $routeName === 'home' ? '/' : "/{$routeName}/",
                    'controller' => "App\\Controllers\\" . ucfirst($routeName) . "Controller",
                    'metadata'   => $this->processPageMetadata($page)
                ];
            }
            // Use configurable cache TTL from ConfigService
            $cache->set($cacheKey, $routes, $this->configService->get('cache_ttl'));
            error_log("Router: Routes loaded from database and cached.");
        } else {
            $routes = $cachedRoutes;
            error_log("Router: Routes loaded from cache.");
        }

        $this->routes = $routes;
    }

    /**
     * Processes raw page data from the database into a structured metadata array.
     *
     * @param array $page The raw page data from the database.
     * @return array Structured metadata for the page.
     */
    private function processPageMetadata(array $page): array
    {
        return [
            'name'        => $page['name'] ?? null,
            'title'       => $page['title'] ?? null,
            'description' => $page['description'] ?? null,
            'keywords'    => $page['keywords'] ?? null,
            'h1'          => $page['h1'] ?? null,
            'schema'      => [
                'type'      => $page['schema_type'] ?? null,
                'category'  => $page['schema_category'] ?? null,
                'address'   => !empty($page['schema_address']) ? (json_decode($page['schema_address'], true) ?: null) : null,
                'sameAs'    => !empty($page['schema_same_as']) ? (json_decode($page['schema_same_as'], true) ?: null) : null,
            ],
            'noindex'     => (bool)$page['noindex'],
        ];
    }

    /**
     * Extracts the clean URI from the server request, removing query string.
     *
     * @return string The cleaned URI.
     */
    private function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];

        // Remove query string from URI
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
            // Normalize paths for matching (e.g., /about and /about/ should match)
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
     * sets page metadata, and executes the corresponding controller.
     *
     * @throws Exception If no route is matched or controller class not found.
     */
    public function resolve(): void
    {
        $uri = $this->getUri();
        $route = $this->matchRoute($uri);

        // If no route found, attempt to load the 'error' route for 404 handling
        if ($route === null) {
            if (!isset($this->routes['error'])) {
                throw new Exception("Router: Critical: 'error' page not defined in routes. Ensure 'error' page exists in database."); // Improved error message
            }
            $route = $this->routes['error'];
            http_response_code(404);
            error_log("Router: No route matched for '{$uri}', falling back to 'error' page (404).");
        }

        // Set page-specific metadata in the container for later access
        $this->container->setPageMetadata($route['metadata']);

        $controllerName = $route['controller'];

        // Check if the controller class exists before attempting to instantiate
        if (!class_exists($controllerName)) {
            // If the error controller itself is missing, that's a critical application error
            if ($route['name'] === 'error') {
                throw new Exception("Router: Critical: Error controller '{$controllerName}' not found. Application cannot handle errors gracefully.");
            }
            // For other missing controllers, fall back to the error page
            error_log("Router: Controller '{$controllerName}' not found for route '{$route['path']}'. Falling back to error page.");
            http_response_code(500); // Internal Server Error for missing controller
            $route = $this->routes['error'];
            $this->container->setPageMetadata($route['metadata']); // Update metadata to error page's
            $controllerName = $route['controller']; // Set controller to error controller
        }

        // Instantiate and execute the controller's index method
        $controllerInstance = new $controllerName($this->container);
        $controllerInstance->index();
    }
}