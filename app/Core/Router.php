<?php

namespace App\Core;

use App\Services\{CacheService, Database};
use Exception;

class Router
{
    private array $routes = [];
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->loadRoutes();
    }

    /**
     * @throws Exception
     */
    private function loadRoutes(): void
    {
        /** @var CacheService $cache */
        $cache = $this->container->get(CacheService::class);
        $cacheKey = 'app_routes';

        // Clear cache for testing purposes
        if (getenv('CACHE_CLEAR') === 'true') {
            $cache->delete($cacheKey);
            error_log("Cache cleared for routes.");
        }

        $routes = $cache->get($cacheKey);

        if ($routes === false) {
            /** @var Database $db */
            $db = $this->container->get(Database::class);
            $pages = $db->query("SELECT * FROM pages");

            if (empty($pages)) {
                throw new Exception("No pages found in database. Run 'make seed'.");
            }

            $routes = [];
            foreach ($pages as $page) {
                $routeName = $page['name'];
                $routes[$routeName] = [
                    'path'       => $routeName === 'home' ? '/' : "/{$routeName}/",
                    'controller' => "Controllers\\" . ucfirst($routeName) . "Controller",
                    'metadata'   => $this->processPageMetadata($page)
                ];
            }

            // Cache routes for 1 hour
            $cache->set($cacheKey, $routes, 3600);
        } else {
            error_log("Routes loaded from cache.");
        }

        $this->routes = $routes;
    }

    private function processPageMetadata(array $page): array
    {
        return [
            'name'        => $page['name'],
            'title'       => $page['title'],
            'description' => $page['description'],
            'keywords'    => $page['keywords'],
            'h1'          => $page['h1'],
            'schema'      => [
                'type'     => $page['schema_type'] ?? null,
                'category' => $page['schema_category'] ?? null,
                'address'  => !empty($page['schema_address']) ? json_decode($page['schema_address'], true) : null,
                'sameAs'   => !empty($page['schema_same_as']) ? json_decode($page['schema_same_as'], true) : null,
            ],
            'noindex'     => (bool)$page['noindex'],
        ];
    }

    private function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        // Strip query parameters
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        return $uri;
    }

    private function matchRoute(string $uri): ?array
    {
        foreach ($this->routes as $route) {
            if ($route['path'] === $uri || $route['path'] === $uri . '/') {
                error_log("Route matched: " . $route['path']);
                return $route;
            }
        }
        error_log("No route matched for URI: " . $uri);
        return null;
    }

    public function resolve(): void
    {
        $uri = $this->getUri();
        $route = $this->matchRoute($uri);

        if ($route === null) {
            $route = $this->routes['error'] ?? null;
            if ($route === null) throw new Exception("Critical: 'error' page not defined.");
            http_response_code(404);
        }

        $this->container->setPageMetadata($route['metadata']);

        $controllerName = $route['controller'];
        if (!class_exists($controllerName)) {
            throw new Exception("Controller {$controllerName} not found.");
        }

        // Pass the container to the controller (Dependency Injection)
        $controllerInstance = new $controllerName($this->container);
        $controllerInstance->index();
    }
}