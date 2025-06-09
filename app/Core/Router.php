<?php

namespace Core;

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
     * Current route parameters
     * @var array<string,mixed>
     */
    private array $params = [];

    /**
     * Router constructor
     * @throws \Exception
     */
    public function __construct()
    {
        $this->basePath = defined('APP_PATH') ? APP_PATH : '/';
        $this->initRoutes();
    }

    /**
     * Initialize default routes
     * @throws \Exception
     */
    private function initRoutes(): void
    {
        if (!defined('PAGES') || !is_array(PAGES)) {
            throw new \Exception("PAGES constant is not defined or invalid");
        }

        foreach (PAGES as $name => $page) {
            $controllerName = ucfirst($name);
            $this->routes[$name] = [
                'path' => $name === 'home' ? '/' : "/{$name}/",
                'controller' => "Controllers\\{$controllerName}Controller",
                'action' => 'index',
                'page' => $name
            ];
        }
    }

    /**
     * Get current request URI
     * @return string Cleaned URI path
     */
    private function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        if ($this->basePath !== '/') {
            $uri = str_replace($this->basePath, '', $uri);
        }
        return trim(parse_url($uri, PHP_URL_PATH), '/');
    }

    /**
     * Match the route to registered routes
     * @param string $uri Request URI to match
     * @return bool Whether route was matched
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
     * @throws \Exception When route/controller not found
     */
    public function resolve(): void
    {
        $uri = $this->getUri();

        if (!$this->matchRoute($uri)) {
            if (!isset($this->routes['error'])) {
                throw new \Exception("Error route is not defined");
            }

            // Redirect to 404 page
            $this->params = $this->routes['error'];
        }

        $controller = $this->params['controller'];
        $action = $this->params['action'];

        if (!class_exists($controller)) {
            throw new \Exception("Controller {$controller} not found");
        }

        $controllerInstance = new $controller($this->params['page']);
        if (!method_exists($controllerInstance, $action)) {
            throw new \Exception("Action {$action} not found in {$controller}");
        }

        $controllerInstance->$action();
    }
}