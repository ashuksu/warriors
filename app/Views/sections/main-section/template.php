<section class="hero" id="hero">
    <div class="container">
        <div class="hero__inner">
            <div class="hero__content">
                <h1 class="hero__title">Warriors Project</h1>
                <p class="hero__subtitle">A modern PHP application with MVC pattern and Vite</p>
                <div class="hero__buttons">
                    <?php
                    render_button([
                        'url' => APP_PATH . 'catalog.php',
                        'text' => 'View Catalog',
                        'class' => 'button--primary',
                        'attr' => 'data-element="link" data-action="view-catalog"',
                    ]);
                    
                    render_button([
                        'url' => APP_PATH . 'contacts.php',
                        'text' => 'Contact Us',
                        'class' => 'button--secondary',
                        'attr' => 'data-element="link" data-action="contact-us"',
                    ]);
                    ?>
                </div>
            </div>
            <div class="hero__image">
                <img src="<?= APP_PATH ?>assets/images/hero.jpg" alt="Warriors Project" class="hero__img">
            </div>
        </div>
    </div>
</section>