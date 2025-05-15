<?php
$dir = $dir ?? '';

include $dir . 'config.php';

include $dir . 'includes/head.php';

/**
 * Includes the button component, which provides the render_button() function
 * for rendering configurable anchor-based buttons.
 */
include $dir . 'includes/components/button.php';
?>

<body data-style="default" class="<?= $bodyClass ?>">

<div class="wrapper">

    <?php
    include $dir . 'includes/components/preloader.php';

    include $dir . 'includes/header.php';
    ?>

    <main id="content" class="content">
        <?php
        foreach ($sections as $section) {
            include $dir . 'includes/sections/' . $section . '/template.php';
        }
        ?>
    </main>

    <?php
    include $dir . 'includes/footer.php';
    ?>
</div>


<?php
render_button([
    'url' => '#content',
    'class' => 'button--up',
    'attr' => 'data-element="link" data-element="up"',
]);

include $dir . 'includes/Popup.php';

include $dir . 'includes/footer-links.php';
?>

</body>
</html>