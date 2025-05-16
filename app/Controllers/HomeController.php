<?php
namespace App\Controllers;

use App\Services\SectionService;

/**
 * Controller for the home page
 */
class HomeController
{
    /**
     * Display the home page
     */
    public function index()
    {
        // Define sections to display
        $sections = ['main-section', 'about', 'faq', 'info'];

        // Include the layout template
        include PROJECT_ROOT . 'app/Views/Layout.php';
    }
}
?>
