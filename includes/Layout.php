<?php
include PROJECT_ROOT . 'includes/head.php';

/**
 * Includes the button component, which provides the render_button() function
 * for rendering configurable anchor-based buttons.
 */
include PROJECT_ROOT . 'includes/components/button.php';
?>

<body data-style="default" class="<?= 'page-' . PAGE ?>">

<div class="wrapper">

    <?php
    include PROJECT_ROOT . 'includes/components/preloader.php';

    include PROJECT_ROOT . 'includes/header.php';
    ?>

    <main id="content" class="content">
        <?php
        if (!empty($sections) && is_array($sections)) {
            /**
             * Set configuration values.
             *
             * @param array $config Array of configuration options.
             * @param string $config ['key'] The key to configure.
             * @param mixed $config ['value'] The value for the given key.
             */
            foreach ($sections as $section) {
                include PROJECT_ROOT . 'includes/sections/' . $section . '/template.php';
            }
        }
        ?>
    </main>

    <?php
    include PROJECT_ROOT . 'includes/footer.php';
    ?>
</div>


<?php
render_button([
    'url' => '#content',
    'class' => 'button--up',
    'attr' => 'data-element="link" data-action="up"',
]);

include PROJECT_ROOT . 'includes/Popup.php';

include PROJECT_ROOT . 'includes/footer-links.php';
?>

</body>
</html>
