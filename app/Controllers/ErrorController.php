<?php
namespace App\Controllers;

use App\Services\SectionService;

/**
 * Controller for the error page
 */
class ErrorController
{
    /**
     * Display the 404 error page
     */
    public function notFound()
    {
        // Define page constants
        define("APP_TITLE", "404 Page");
        define("PAGE", "error");
        
        // Get section data
        $title = SectionService::get(PAGE, 'title');
        $text = SectionService::get(PAGE, 'text');
        $image = SectionService::get(PAGE, 'image');
        $button = SectionService::get(PAGE, 'button');
        
        // Define sections to display
        $sections = [PAGE];
        
        // Include the layout template
        include PROJECT_ROOT . 'app/Views/Layout.php';
    }
}
?>