<?php

use Services\SectionService;

$item = SectionService::get('info', 'items', 'info-' . PAGE);
?>

<?php if (!empty($item) && is_array($item)): ?>
    <section id="info" class="section info mt-auto">
        <div class="container">
            <div class="inner inner-style text-center info__inner wow pixFadeUp" data-wow-delay="0.2s">
                <h2 class="title">
                    <?= $item['title'] ?>
                </h2>
                <p class="text-justify">
                    <?= $item['text'] ?>
                </p>
            </div>
        </div>
    </section>
<?php endif; ?>
