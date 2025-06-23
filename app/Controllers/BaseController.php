<?php

namespace App\Controllers;

use App\Core\Container;
use App\Views\Layout;
use Exception;

/**
 * Abstract base class for all application controllers.
 * Provides a common constructor to receive the Container instance
 * and a protected render method for consistent page rendering.
 */
abstract class BaseController
{
    protected Container $container;

    /**
     * Constructor.
     *
     * @param Container $container The dependency injection container.
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Renders the page using the main layout.
     *
     * This method passes the Container instance to the Layout, allowing
     * the layout and its embedded sections/components to resolve
     * their own dependencies (e.g., ConfigService, ContentService)
     * from the Container.
     *
     * @param array $sections An array of section names (e.g., 'main', 'about') to be rendered within the layout.
     * @return void
     * @throws Exception
     */
    protected function render(array $sections): void
    {
        Layout::render($this->container, $sections);
    }

    /**
     * Abstract method that must be implemented by concrete controllers.
     * This method typically handles the main logic for a page and calls render().
     *
     * @return void
     */
    abstract public function index(): void;
}