<?php

use Services\SectionService;

require_once PROJECT_ROOT . 'app/Services/SectionService.php';
$title = SectionService::get('popup', 'title');
$popups = SectionService::get('popup', 'items');

foreach ($popups as $index => &$item) {
    if (isset($item['button'])) {
        ob_start();
        render_button($item['button']);
        $item['button'] = ob_get_clean();
    }

    include PROJECT_ROOT . 'includes/sections/popup/template.php';
}

?>
