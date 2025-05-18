<header id="header" class="header">
    <div class="container">
        <div class="header__inner">
            <a href="<?= APP_PATH ?>" class="logo">
                <img src="<?= APP_PATH ?>public/assets/images/logo/logo-1.png" width="30" height="30" alt="logo">
            </a>

            <?php
            render_button([
                'class' => 'button button--menu button--transparent',
                'attr' => 'data-element="menu-open"',
                'content' => '<i></i>',
            ]);

            include PROJECT_ROOT . 'includes/components/menu.php'
            ?>
        </div>
    </div>
</header>
