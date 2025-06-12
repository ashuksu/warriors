<?php

namespace Core;

use Services\Database;
use Exception;

/**
 * Router class handles URL routing and request dispatching
 */
class Router
{
    /**
     * Registered routes array
     * @var array<string,array>
     */
    private array $routes = [];

    /**
     * Base path for routing
     * @var string
     */
    private string $basePath;

    /**
     * Current route parameters, including page metadata
     * @var array<string,mixed>
     */
    private array $params = [];

    /**
     * Router constructor
     * @throws Exception
     */
    public function __construct()
    {
        $this->basePath = defined('APP_PATH') ? APP_PATH : '/';
        $this->initRoutes();
    }

    /**
     * Initialize routes by fetching page data from the database.
     * This replaces the static PAGES constant.
     *
     * @throws Exception If a database query fails or no error page is defined.
     */
    private function initRoutes(): void
    {
        try {
            $db = Database::getInstance();
            $pages = $db->query("SELECT * FROM pages ORDER BY name ASC");

            if (empty($pages)) {
                throw new Exception("No pages found in the database. Please run db-seed.");
            }

            foreach ($pages as $page) {
                // Decode JSONB fields back into arrays/objects
                if (isset($page['schema_address'])) {
                    $page['schema']['address'] = json_decode($page['schema_address'], true);
                    unset($page['schema_address']);
                }

                if (isset($page['schema_same_as'])) {
                    $page['schema']['sameAs'] = json_decode($page['schema_same_as'], true);
                    unset($page['schema_same_as']);
                }

                // Reconstruct schema array for consistency with old PAGES structure
                $page['schema'] = [
                    'type'     => $page['schema_type'] ?? null,
                    'category' => $page['schema_category'] ?? null,
                    'address'  => $page['schema']['address'] ?? null,
                    'sameAs'   => $page['schema']['sameAs'] ?? null,
                ];
                unset($page['schema_type'], $page['schema_category']);

                $controllerName = ucfirst($page['name']);
                $this->routes[$page['name']] = [
                    'path'       => $page['name'] === 'home' ? '/' : "/{$page['name']}/",
                    'controller' => "Controllers\\{$controllerName}Controller",
                    'action'     => 'index',
                    'page_name'  => $page['name'],
                    'metadata'   => $page
                ];
            }

            // Ensure an 'error' route exists
            if (!isset($this->routes['error'])) {
                // If 'error' page is not in DB, define a fallback or throw.
                // For now, let's assume it MUST be in DB as per previous PAGES constant.
                throw new Exception("Error page not defined in the database.");
            }

        } catch (Exception $e) {
            error_log("Failed to initialize routes from database: " . $e->getMessage());
            throw new Exception("Application setup error: Unable to load page definitions. " . $e->getMessage());
        }
    }

    /**
     * Get current request URI
     * @return string Cleaned a URI path
     */
    private function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $uri = strtok($uri, '?');

        if ($this->basePath !== '/') {
            $uri = str_replace($this->basePath, '', $uri);
        }
        return trim($uri, '/');
    }

    /**
     * Match the route to registered routes
     * @param string $uri Request URI to match
     * @return bool Whether the route was matched
     */
    private function matchRoute(string $uri): bool
    {
        foreach ($this->routes as $route) {
            if (!isset($route['path'])) {
                continue;
            }
            $path = trim($route['path'], '/');
            if ($uri === $path) {
                $this->params = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * Resolve and dispatch the current route
     * @throws Exception When route/controller wasn't found
     */
    public function resolve(): void
    {
        $uri = $this->getUri();

        if (!$this->matchRoute($uri)) {
            // Route wasn't found, use the 'error' page defined in the database
            $this->params = $this->routes['error'];
            // Set HTTP 404 response code
            http_response_code(404);
        }

        $controller = $this->params['controller'];
        $action = $this->params['action'];
        // Pass the full metadata to the controller
        $pageMetadata = $this->params['metadata'] ?? [];

        if (!class_exists($controller)) {
            throw new Exception("Controller {$controller} not found");
        }

        // Pass the page metadata directly to the BaseController constructor
        $controllerInstance = new $controller($pageMetadata);
        if (!method_exists($controllerInstance, $action)) {
            throw new Exception("Action {$action} not found in {$controller}");
        }

        $controllerInstance->$action();
    }
}