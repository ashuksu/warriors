<?php

namespace App\Controllers;

use App\Core\Container;
use Exception;

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
     * @throws Exception
     */
    public function index(): void
    {
        $this->render(['contacts', 'info']);
    }
}