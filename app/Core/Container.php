<?php

namespace App\Core;

use App\Services\ConfigService;
use App\Services\CacheService;
use App\Services\DatabaseService;
use App\Services\DataLoaderService;
use App\Services\TemplateService;
use App\Services\ContentService;
use App\Services\PathService;
use App\Services\DeviceService;
use App\Core\Router;
use Exception;

/**
 * A simple Dependency Injection Container.
 */
class Container
{
    private static ?self $instance = null;
    private array $factories = [];
    private array $instances = [];
    private array $currentPageData = [];

    private function __construct() {}

    /**
     * Get the single instance of the Container.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Registers application services.
     */
    public function registerServices(): void
    {
        $this->singleton(ConfigService::class, fn($c) => new ConfigService());
        $this->singleton(CacheService::class, fn($c) => new CacheService());
        $this->singleton(DatabaseService::class, fn($c) => new DatabaseService($c->get(ConfigService::class)));
        $this->singleton(DataLoaderService::class, fn($c) => new DataLoaderService($c->get(DatabaseService::class)));
        $this->singleton(TemplateService::class, fn($c) => new TemplateService($c));
        $this->singleton(ContentService::class, fn($c) => new ContentService(
            $c->get(DataLoaderService::class),
            $c->get(CacheService::class),
            $c->get(ConfigService::class)
        ));
        $this->singleton(PathService::class, fn($c) => new PathService(
            $c->get(ConfigService::class),
            $c->get(CacheService::class)
        ));
        $this->singleton(DeviceService::class, fn($c) => new DeviceService());
        $this->singleton(Router::class, fn($c) => new Router($c));
    }

    /**
     * Binds a service factory to be resolved as a fresh instance each time.
     *
     * @param string $class The class name or identifier.
     * @param callable $factory The factory function.
     */
    public function bind(string $class, callable $factory): void
    {
        $this->factories[$class] = $factory;
        unset($this->instances[$class]);
    }

    /**
     * Binds a service factory to be resolved as a singleton.
     * The instance is created once and reused.
     *
     * @param string $class The class name or identifier.
     * @param callable $factory The factory function.
     */
    public function singleton(string $class, callable $factory): void
    {
        $this->factories[$class] = $factory;
    }

    /**
     * Gets a service instance from the container.
     *
     * @param string $class The class name or identifier.
     * @return mixed
     * @throws Exception If the service is not registered.
     */
    public function get(string $class): mixed
    {
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }

        if (!isset($this->factories[$class])) {
            throw new Exception("Service '{$class}' not registered.");
        }

        $instance = $this->factories[$class]($this);
        $this->instances[$class] = $instance;

        return $instance;
    }

    /**
     * Sets the complete data for the current page.
     * This includes metadata, content, and any other page-specific attributes.
     *
     * @param array $pageData The associative array of page data.
     */
    public function setPageData(array $pageData): void
    {
        $this->currentPageData = $pageData;
    }

    /**
     * Retrieves the complete data for the current page.
     *
     * @return array The associative array of page data.
     */
    public function getPageData(): array
    {
        return $this->currentPageData;
    }
}