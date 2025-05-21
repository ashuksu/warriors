<?php

use App\Helpers\Vite;

?>

<!-- Preconnect to external domains to improve performance -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- Google Fonts - loaded asynchronously -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;900&display=swap"
      media="print" onload="this.media='all'">
<noscript>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;900&display=swap">
</noscript>

<?php if (defined('IS_DEV') && IS_DEV): ?>
    <!-- Vite client (only in dev mode) -->
    <script type="module" src="<?= VITE_DEV_CLIENT ?>"></script>
<?php endif; ?>

<!-- Critical CSS - loaded immediately -->
<link rel="stylesheet" href="<?= Vite::getAssetPath('src/scss/criticalStyles.scss') ?>">

<!-- Async loaded styles -->
<!-- Animation CSS - loaded asynchronously (used by WOW.js) -->
<link rel="stylesheet" href="<?= Vite::getAssetPath('src/css/libs/animate.min.css') ?>" media="print"
      onload="this.media='all'">
<noscript>
    <link rel="stylesheet" href="<?= Vite::getAssetPath('src/css/libs/animate.min.css') ?>">
</noscript>

<!-- Styles -->
<link rel="stylesheet" href="<?= Vite::getAssetPath('src/css/style.css') ?>">
<link rel="stylesheet" href="<?= Vite::getAssetPath('src/css/styleHome.css') ?>">

<!-- Prefetch resources that will be needed soon -->
<link rel="prefetch" href="<?= Vite::getAssetPath('src/js/modules/Popup.js') ?>" as="script">
<link rel="prefetch" href="<?= Vite::getAssetPath('src/js/modules/utils/Toggle.js') ?>" as="script">

<!-- Load WOW.js with defer and low priority to ensure it doesn't block critical resources -->
<script defer src="https://cdn.jsdelivr.net/npm/wowjs@1.1.3/dist/wow.min.js" fetchpriority="low"></script>