<?php

namespace App\Controllers;

use App\Core\Container;
use App\Views\Layout;

abstract class BaseController
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function render(array $sections): void
    {
        $data = [];
        Layout::render($this->container, $sections);
    }

    abstract public function index(): void;
}