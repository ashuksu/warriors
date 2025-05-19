<section id="<?= $section ?? '' ?>" class="section contacts <?= $section ?? '' ?>">
    <div class="container">
        <div class="inner">
            <h1 class="title text-center mb-3 wow pixFadeUp" data-wow-delay="0.2s">
                <?= $title ?? '' ?>
            </h1>

            <div class="row contacts__list wow pixFadeUp" data-wow-delay="0.3s">

                <?php

                use function Helpers\renderTemplate;

                if (!empty($contacts) && is_array($contacts)) {
                    foreach ($contacts as $item) {
                        renderTemplate($itemPath, [
                            'item' => $item,
                        ]);
                    }
                }
                ?>

            </div>
        </div>
    </div>
</section>