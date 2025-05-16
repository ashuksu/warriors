<?php
namespace App\Controllers;

use App\Services\SectionService;

/**
 * Controller for the contacts page
 */
class ContactsController
{
    /**
     * Display the contacts page
     */
    public function index()
    {
        // Define page constants
        define("APP_TITLE", "Contacts");
        define("PAGE", "contacts");
        
        // Get section data
        $title = SectionService::get(PAGE, 'title');
        $items = SectionService::get(PAGE, 'items');
        
        // Define sections to display
        $sections = [PAGE, 'info'];
        
        // Include the layout template
        include PROJECT_ROOT . 'app/Views/Layout.php';
    }
}
?>