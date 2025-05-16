<?php
namespace App\Controllers;

use App\Services\SectionService;

/**
 * Controller for the catalog page
 */
class CatalogController
{
    /**
     * Display the catalog page
     */
    public function index()
    {
        // Define page constants
        define("APP_TITLE", "Catalog");
        define("PAGE", "catalog");
        
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