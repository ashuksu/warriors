<?php

namespace App\Controllers;

use App\Core\Container;

/**
 * Controller for the catalog page
 *
 * Handles rendering of the catalog page with its sections
 */
class CatalogController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * Render sections: catalog, info
     *
     * @return void
     */
    public function index(): void
    {
        if (!defined('PAGE')) {
            define('PAGE', 'catalog');
        }

        $this->render([PAGE, 'info']);
    }
}