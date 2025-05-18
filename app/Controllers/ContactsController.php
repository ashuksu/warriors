<?php

namespace Controllers;

use Services\SectionService;
use Views\Layout;

class ContactsController
{
    public static function index(): void
    {
        Layout::render([
            'sections' => ['Contacts', 'Info'],
            'title' => SectionService::get(PAGE, 'title'),
            'contacts' => SectionService::get('contacts', 'items'),
            'info' => SectionService::get('info', 'items', 'info-contacts')
        ]);
    }
}