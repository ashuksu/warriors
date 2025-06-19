<?php

namespace Controllers;

use Core\Container;

/**
 * Controller for the error page (404)
 *
 * Handles rendering of the error page
 */
class ErrorController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * Render error section
     *
     * @return void
     */
    public function index(): void
    {
        if (!defined('PAGE')) {
            define('PAGE', 'error');
        }

        $this->render([PAGE]);
    }
}