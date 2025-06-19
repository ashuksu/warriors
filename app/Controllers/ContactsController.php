<?php

namespace App\Controllers;

use App\Core\Container;

/**
 * Controller for the contacts page
 *
 * Handles rendering of the contacts page with its sections
 */
class ContactsController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * Render sections: contacts, info
     *
     * @return void
     */
    public function index(): void
    {
        if (!defined('PAGE')) {
            define('PAGE', 'contacts');
        }

        $this->render([PAGE, 'info']);
    }
}