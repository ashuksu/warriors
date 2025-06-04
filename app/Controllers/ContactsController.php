<?php

namespace Controllers;

/**
 * Controller for the contacts page
 *
 * Handles rendering of the contacts page with its sections
 */
class ContactsController extends BaseController
{
    /**
     * Render sections: contacts, info
     *
     * @return void
     */
    public function index(): void
    {
        $this->render([PAGE, 'info']);
    }
}