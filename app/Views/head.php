<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_TITLE ?? 'Warriors Project' ?></title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?= APP_PATH ?>favicon.ico" type="image/x-icon">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= APP_PATH ?>assets/css/style.css">
    
    <!-- Meta tags -->
    <meta name="description" content="Warriors Project - A modern PHP application">
    <meta name="keywords" content="warriors, php, mvc, vite">
    <meta name="author" content="ashuksu">
    
    <!-- Open Graph tags -->
    <meta property="og:title" content="<?= APP_TITLE ?? 'Warriors Project' ?>">
    <meta property="og:description" content="Warriors Project - A modern PHP application">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://<?= $DOMAIN ?? 'warriors.example.com' ?>">
    
    <!-- Additional head content -->
    <?php if (defined('PAGE') && PAGE === 'main'): ?>
    <!-- Main page specific head content -->
    <?php endif; ?>
</head>