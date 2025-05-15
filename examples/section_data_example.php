<?php
/**
 * Example of using the universal section data access method
 * 
 * This file demonstrates how to use the BaseSectionService's getSection method
 * to access data from any section in the data.json file.
 */

// Include one of the section services that extends BaseSectionService
require_once __DIR__ . '/../includes/services/sections/CatalogService.php';

// Get an instance of the service
$service = CatalogService::getInstance();

// Examples of accessing different section data using the universal method

// Get catalog items
$catalogItems = $service->getSection('catalog', 'items');
echo "Catalog items count: " . count($catalogItems) . "\n";

// Get catalog title
$catalogTitle = $service->getSection('catalog', 'title');
echo "Catalog title: " . $catalogTitle . "\n";

// Get catalog counter
$catalogCounter = $service->getSection('catalog', 'counter');
echo "Catalog counter: " . $catalogCounter . "\n";

// Get about items
$aboutItems = $service->getSection('about', 'items');
echo "About items count: " . count($aboutItems) . "\n";

// Get about boolean value
$aboutBool = $service->getSection('about', 'bool');
echo "About bool value: " . ($aboutBool ? 'true' : 'false') . "\n";

// Get data from another section
$anotherData = $service->getSection('another');
echo "Another section data count: " . count($anotherData) . "\n";

// You can use any service that extends BaseSectionService
// For example, you could also use AboutService:
require_once __DIR__ . '/../includes/services/sections/AboutService.php';
$anotherService = AboutService::getInstance();

// The same data can be accessed through any service that extends BaseSectionService
$catalogItemsAgain = $anotherService->getSection('catalog', 'items');
echo "Catalog items count (via AboutService): " . count($catalogItemsAgain) . "\n";

echo "\nAll data accessed successfully!\n";