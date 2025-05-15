<section class="section error">
    <div class="container">
        <div class="inner error__inner text-center">
            <h1 class="title mb-5 wow pixFadeUp" data-wow-delay="0.2s">
                404
            </h1>
            <p class="error__text error__text wow pixFadeUp" data-wow-delay="0.3s">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum cupiditate dicta earum enim ipsum iure
                pariatur porro possimus
            </p>
            <div class="image error__image mb-5 mx-auto wow pixFadeUp" data-wow-delay="0.4s">
                <img src="<?= APP_PATH ?>assets/images/w4.gif" alt="image"
                     class="error-image" width="600" height="600">
            </div>

            <?php
            render_button([
                'url' => APP_PATH,
                'class' => 'error-button wow pixFadeUp',
                'attr' => 'data-wow-delay="0.5s" target="_blank"',
                'content' => 'to the Home page',
            ]);
            ?>
        </div>
    </div>
</section>
