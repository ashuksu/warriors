<?php
$bodyClass = $bodyClass ?? '';
$sections = $sections ?? [];

/**
 * Includes the head section of the HTML document.
 */
include PROJECT_ROOT . 'includes/head.php';

/**
 * Includes the button component, which provides the render_button() function
 * for rendering configurable anchor-based buttons.
 */
include PROJECT_ROOT . 'includes/components/button.php';
?>

<body data-style="default" class="<?= $bodyClass ?>">

<div class="wrapper">

    <?php
    /**
     * Includes the preloader component for page loading animation.
     */
    include PROJECT_ROOT . 'includes/components/preloader.php';

    /**
     * Includes the header section of the page.
     */
    include PROJECT_ROOT . 'includes/header.php';
    ?>

    <main id="content" class="content">
        <?php
        /**
         * Dynamically includes section templates based on the $sections array.
         * Each section is loaded from its corresponding template file.
         */
        foreach ($sections as $section) {
            include PROJECT_ROOT . 'includes/sections/' . $section . '/template.php';
        }
        ?>
    </main>

    <?php
    /**
     * Includes the footer section of the page.
     */
    include PROJECT_ROOT . 'includes/footer.php';
    ?>
</div>


<?php
render_button([
    'url' => '#content',
    'class' => 'button--up',
    'attr' => 'data-element="link" data-action="up"',
]);

/**
 * Includes the popup component for modal dialogs.
 */
include PROJECT_ROOT . 'includes/Popup.php';

/**
 * Includes the footer links and scripts.
 */
include PROJECT_ROOT . 'includes/footer-links.php';
?>

</body>
</html>
