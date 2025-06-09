<?php

namespace Controllers;

/**
 * Controller for the home page
 *
 * Handles rendering of the home page with its sections
 */
class HomeController extends BaseController
{
    /**
     * Render sections: main, about, faq, info
     *
     * @return void
     */
    public function index(): void
    {
        $this->render(['main', 'about', 'faq', 'info']);
    }
}