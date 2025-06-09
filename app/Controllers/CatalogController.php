<?php

namespace Controllers;

/**
 * Controller for the catalog page
 *
 * Handles rendering of the catalog page with its sections
 */
class CatalogController extends BaseController
{
    /**
     * Render sections: catalog, info
     *
     * @return void
     */
    public function index(): void
    {
        $this->render([PAGE, 'info']);
    }
}