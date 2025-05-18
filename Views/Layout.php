<?php
include PROJECT_ROOT . 'Views/head.php';

/**
 * Includes the button component, which provides the render_button() function
 * for rendering configurable anchor-based buttons.
 */
include PROJECT_ROOT . 'Views/components/button.php';
?>

<body data-style="default" class="<?= 'page-' . PAGE ?>">

<div class="wrapper">

    <?php
    include PROJECT_ROOT . 'Views/components/preloader.php';

    include PROJECT_ROOT . 'Views/header.php';
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
                include PROJECT_ROOT . 'Views/sections/' . $section . '/template.php';
            }
        }
        ?>
    </main>

    <?php
    include PROJECT_ROOT . 'Views/footer.php';
    ?>
</div>


<?php
render_button([
    'url' => '#content',
    'class' => 'button--up',
    'attr' => 'data-element="link" data-action="up"',
]);

include PROJECT_ROOT . 'Views/Popup.php';

include PROJECT_ROOT . 'Views/footer-links.php';
?>

</body>
</html>
