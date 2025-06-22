<?php

namespace App\Core;

use App\Services\ConfigService;
use App\Services\CacheService;
use App\Services\DatabaseService;
//use App\Services\ViteService;
//use App\Services\DeviceService;
//use App\Services\SectionProvider;
//use App\Services\TemplateService;
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
    private array $pageContext = [];

    /**
     * Private constructor for a Singleton pattern.
     */
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
//        TODO: temporarily commented out services
//        $this->singleton(ViteService::class, fn($c) => new ViteService($c->get(ConfigService::class)));
//        $this->singleton(DeviceService::class, fn($c) => new DeviceService());
//        $this->singleton(SectionProvider::class, fn($c) => new SectionProvider(
//            $c->get(DatabaseService::class),
//            $c->get(CacheService::class)
//        ));
//        $this->singleton(TemplateService::class, fn($c) => new TemplateService($c));
        $this->singleton(Router::class, fn($c) => new Router($c));
    }

    /**
     * Binds a service factory to be resolved as a new instance each time.
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
     * Sets page-specific metadata.
     *
     * @param array $metadata Page metadata.
     */
    public function setPageMetadata(array $metadata): void
    {
        $this->pageContext = $metadata;
    }

    /**
     * Retrieves page-specific metadata.
     *
     * @return array Page metadata.
     */
    public function getPageMetadata(): array
    {
        return $this->pageContext;
    }
}