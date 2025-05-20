<!-- External libraries are loaded in head.php with proper optimization -->

<!-- Main application script loaded as a module (automatically deferred) -->
<!--<script type="module" src="--><?php //= APP_PATH ?><!--src/js/script.js"></script>-->

<?php

use App\Helpers\Vite;

/**
 * Footer links section
 *
 * This file contains the footer links and scripts for the application.
 * It includes external libraries and custom scripts.
 *
 * @package    App
 * @subpackage Views
 */
$assets = Vite::assets();
?>

<?php foreach ($assets['scripts'] as $script): ?>
    <script src="<?= htmlspecialchars($script['src']) ?>" type="<?= htmlspecialchars($script['type']) ?>"></script>
<?php endforeach; ?>

