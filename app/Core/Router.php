<?php

namespace Core;

use Controllers\ErrorController;

/**
 * Router class handles URL routing to appropriate controllers
 * 
 * This class maps URL paths to controller methods and resolves
 * incoming requests to the appropriate controller action
 */
class Router
{
    /**
     * Array of registered routes
     * 
     * @var array Associative array where keys are URL paths and values are controller::method strings
     */
    private array $routes = [];

    /**
     * Constructor initializes the router with default routes
     */
    public function __construct()
    {
        $this->register([
            '' => 'Controllers\HomeController::index',
            'home' => 'Controllers\HomeController::index',
            'contacts' => 'Controllers\ContactsController::index',
            'catalog' => 'Controllers\CatalogController::index'
        ]);
    }

    /**
     * Register routes with the router
     * 
     * @param array $routes Associative array of routes to register
     * @return void
     */
    public function register(array $routes): void
    {
        $this->routes = $routes;
    }

    /**
     * Resolve the current request to a controller action
     * 
     * Extracts the path from the request URI, looks up the corresponding
     * controller and method, and calls it. If no matching route is found,
     * the error controller is called.
     * 
     * @return void
     */
    public function resolve(): void
    {
        $path = $_SERVER['REQUEST_URI'];
        $path = trim($path, '/');
        $path = $path === '' ? '' : $path;

        if (isset($this->routes[$path])) {
            [$controller, $method] = explode('::', $this->routes[$path]);
            $controller::$method();
            return;
        }

        ErrorController::index();
    }
}