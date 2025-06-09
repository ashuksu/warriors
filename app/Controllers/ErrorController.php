<?php

namespace Controllers;

/**
 * Controller for the error page (404)
 *
 * Handles rendering of the error page
 */
class ErrorController extends BaseController
{
    /**
     * Render error section
     *
     * @return void
     */
    public function index(): void
    {
        $this->render([PAGE]);
    }
}