<?php

namespace Controllers;

use Views\Layout;

class ContactsController
{
    public static function index(): void
    {
        define("APP_TITLE", PAGES['main']['title']);
        define("PAGE", "contacts");

        Layout::render([
            'sections' => ['Contacts', 'Info']
        ]);
    }
}