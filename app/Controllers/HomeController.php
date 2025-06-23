<?php

namespace App\Controllers;

use App\Core\Container;
use Exception;

/**
 * Controller for the home page
 *
 * Handles rendering of the home page with its sections
 */
class HomeController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * Render sections: main, about, faq, info
     *
     * @return void
     * @throws Exception
     */
    public function index(): void
    {
        $this->render(['main', 'about', 'faq', 'info']);
    }
}