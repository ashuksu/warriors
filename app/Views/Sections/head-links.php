<?php

use Helpers\Vite;

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


<!-- Styles: critical (loaded immediately, blocks' rendering) -->
<link rel="stylesheet" href="<?= Vite::getAssetPath('src/styles/critical.scss') ?>">

<!-- Styles: main, not important and interactive elements, popup (async loaded, lower priority than "high", be applied before "high") -->
<link rel="preload" href="<?= Vite::getAssetPath('src/styles/main.scss') ?>" as="style" onload="this.rel='stylesheet'"
	  fetchpriority="low">
<noscript>
	<link rel="stylesheet" href="<?= Vite::getAssetPath('src/styles/main.scss') ?>">
</noscript>

<!-- Styles: page, important elements (async loaded, higher priority than "low", be applied after "low") -->
<link rel="preload" href="<?= Vite::getAssetPath('src/styles/page_home.scss') ?>" as="style"
	  onload="this.rel='stylesheet'">
<noscript>
	<link rel="stylesheet" href="<?= Vite::getAssetPath('src/styles/page_home.scss') ?>">
</noscript>

<!-- Styles: first-screen, important elements (blocks rendering) -->
<link rel="stylesheet" href="<?= Vite::getAssetPath('src/styles/page_home_critical.scss') ?>">


<!-- Prefetch resources that will be needed soon -->
<link rel="prefetch" href="<?= Vite::getAssetPath('src/js/modules/Popup.js') ?>" as="script">
<link rel="prefetch" href="<?= Vite::getAssetPath('src/js/modules/utils/Toggle.js') ?>" as="script">

<!-- Load WOW.js with defer and low priority to ensure it doesn't block critical resources -->
<script defer src="https://cdn.jsdelivr.net/npm/wowjs@1.1.3/dist/wow.min.js" fetchpriority="low"></script>