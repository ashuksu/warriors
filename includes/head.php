<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?= APP_TITLE ?></title>
    <link rel="shortcut icon" href="<?= APP_PATH ?>favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;900&display=swap">

    <!-- Critical CSS - loaded immediately -->
    <link rel="stylesheet" href="<?= APP_PATH ?>assets/css/style.css">

    <!-- Animation CSS - loaded asynchronously (used by WOW.js) -->
    <link rel="stylesheet" href="<?= APP_PATH ?>assets/css/libs/animate.min.css" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="<?= APP_PATH ?>assets/css/libs/animate.min.css">
    </noscript>
</head>

