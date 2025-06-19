<?php
use Helpers\Vite;
?>

<!-- External libraries are loaded in Head.php with proper optimization -->

<!-- Main application script loaded as a module (automatically deferred) -->
<script type="module" src="<?= Vite::getAssetPath('src/js/script.js') ?>"></script>