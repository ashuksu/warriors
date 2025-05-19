<section id="<?= $section ?? '' ?>" class="section main <?= $section ?? '' ?>">
    <div class="container">
        <div class="row">
            <div class="col col-lg-5 col-md-6 mb-1 mb-md-0">
                <div class="inner main__inner">
                    <h1 class="title main__title">
                        <?= $item['title'] ?? '' ?>
                    </h1>
                    <p class="main__text">
                        <?= $item['text'] ?? '' ?>
                    </p>

                    <?php

                    use Views\Components\Button;

                    if ($isPopups) {
                        foreach ($popups as $item) {
                            Button::render([
                                'url' => '#popup-' . ($item['id'] ?? ''),
                                'attr' => 'data-element="popup-open"',
                                'content' => 'Open popup ' . ($item['name'] ?? '')
                            ]);
                        }
                    }
                    ?>

                </div>
            </div>
            <div class="col col-md-6">
                <div class="image">

                    <?php

                    use Views\Components\Image;

                    Image::render([
                        'url' => $imagePath,
                        'alt' => $image['alt'],
                        'width' => $image['width'],
                        'height' => $image['height'],
                        'noLazy' => true
                    ]);
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>
