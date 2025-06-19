<?php

namespace App\Core;

use App\Services\{CacheService, Database};
use Exception;

/**
 * A simple Dependency Injection Container to manage services and application state.
 */
class Container
{
    private static ?self $instance = null;
    private array $services = [];
    private array $pageMetadata = [];

    private function __construct()
    {
        $this->registerServices();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function registerServices(): void
    {
        // Register services with a factory function to instantiate them only when needed.
        $this->services[Database::class] = fn() => Database::getInstance();
        $this->services[CacheService::class] = fn() => new CacheService();
    }

    /**
     * Get a service from the container.
     * @param string $class
     * @return mixed
     * @throws Exception
     */
    public function get(string $class): mixed
    {
        if (!isset($this->services[$class])) {
            throw new Exception("Service {$class} is not registered.");
        }
        // The service is stored as a function, call it to get the instance.
        return $this->services[$class]();
    }

    // --- Page Context Methods ---

    /**
     * @param array $metadata
     * @return void
     */
    public function setPageMetadata(array $metadata): void
    {
        $this->pageMetadata = $metadata;
    }

    /**
     * @return array
     */
    public function getPageMetadata(): array
    {
        return $this->pageMetadata;
    }

    /**
     * @return string
     */
    public function getPageName(): string
    {
        return $this->pageMetadata['name'] ?? 'error';
    }

    /**
     * @return string
     */
    public function getPageTitle(): string
    {
        return $this->pageMetadata['title'] ?? 'Error';
    }
}