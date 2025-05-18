<?php

namespace Core;

use Controllers\ErrorController;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        $this->register([
            '' => 'Controllers\HomeController::index',
            'home' => 'Controllers\HomeController::index',
            'contacts' => 'Controllers\ContactsController::index',
            'catalog' => 'Controllers\CatalogController::index'
        ]);
    }

    public function register(array $routes): void
    {
        $this->routes = $routes;
    }

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