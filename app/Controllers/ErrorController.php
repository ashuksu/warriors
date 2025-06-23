<?php

namespace App\Controllers;

use App\Core\Container;
use Exception;

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
     * @throws Exception
     */
    public function index(): void
    {
        $this->render(['error']);
    }
}