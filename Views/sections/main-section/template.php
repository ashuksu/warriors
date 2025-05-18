<?php

use Services\SectionService;

$mainSection = SectionService::get('main');
$image = $mainSection['image'];
$popups = SectionService::get('popup', 'items');
?>

<section class="section main-section">
    <div class="container">
        <div class="row">
            <div class="col col-lg-5 col-md-6 mb-1 mb-md-0">
                <div class="inner main-section__inner">
                    <h1 class="title main-section__title">
                        <?= $mainSection['title'] ?>
                    </h1>
                    <p class="main-section__text">
                        <?= $mainSection['text'] ?>
                    </p>

                    <?php

                    if (!empty($popups) && is_array($popups)) {
                        foreach ($popups as $index => &$item) {
                            render_button([
                                'url' => '#popup-' . $item['id'],
                                'attr' => 'data-element="popup-open"',
                                'content' => 'Open popup ' . $item['name'],
                            ]);
                        }
                    }

                    ?>
                </div>
            </div>
            <div class="col col-md-6">

                <?php if (!empty($image) && is_array($image)): ?>
                    <div class="image">
                        <img src="<?= APP_PATH ?>public/assets/images/<?= $image['name'] ?>" alt="<?= $image['alt'] ?>"
                             width="<?= $image['width'] ?>" height="<?= $image['height'] ?>">
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
