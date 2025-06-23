<?php

namespace App\Services;

use App\Core\Container;
use Exception;

/**
 * Service for rendering template files.
 */
class TemplateService
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Renders a template file, extracting parameters into local variables.
     *
     * @param string $templatePath Absolute path to the template file.
     * @param array $params Associative array of parameters for the template.
     * @return void
     * @throws Exception If the template file does not exist.
     */
    public function render(string $templatePath, array $params = []): void
    {
        if (!file_exists($templatePath)) {
            throw new Exception("Template file not found: " . $templatePath);
        }

        extract($params);
        require $templatePath;
    }
}