<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Page title and favicon -->
    <title><?= APP_TITLE ?></title>
    <link rel="shortcut icon" href="<?= APP_PATH ?>favicon.ico">

    <!-- Preconnect to external domains to improve performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts - loaded asynchronously -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;900&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;900&display=swap">
    </noscript>

    <!-- Critical CSS - loaded immediately -->
    <link rel="stylesheet" href="<?= APP_PATH ?>assets/css/style.css">

    <!-- Animation CSS - loaded asynchronously (used by WOW.js) -->
    <link rel="stylesheet" href="<?= APP_PATH ?>assets/css/libs/animate.min.css" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="<?= APP_PATH ?>assets/css/libs/animate.min.css">
    </noscript>

    <!-- Prefetch resources that will be needed soon -->
    <link rel="prefetch" href="<?= APP_PATH ?>assets/js/modules/Popup.js" as="script">
    <link rel="prefetch" href="<?= APP_PATH ?>assets/js/modules/utils/Toggle.js" as="script">

    <!-- Load WOW.js with defer and low priority to ensure it doesn't block critical resources -->
    <script defer src="https://cdn.jsdelivr.net/npm/wowjs@1.1.3/dist/wow.min.js" fetchpriority="low"></script>
</head>
