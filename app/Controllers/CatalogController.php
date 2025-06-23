<?php

namespace App\Controllers;

use App\Core\Container;
use Exception;

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
     * @throws Exception
     */
    public function index(): void
    {
        $this->render(['catalog', 'info']);
    }
}