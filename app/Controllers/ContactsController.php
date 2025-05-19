<?php

namespace Controllers;

use Views\Layout;
use Services\SectionService;

class ContactsController
{
    public static function index(): void
    {
        define("APP_TITLE", PAGES['main']['title']);
        define("PAGE", "contacts");

        Layout::render([
            'sections' => ['Contacts', 'Info'],
            'title' => SectionService::get(PAGE, 'title'),
            'contacts' => SectionService::get('contacts', 'items'),
            'info' => SectionService::get('info', 'items', 'info-contacts')
        ]);
    }
}