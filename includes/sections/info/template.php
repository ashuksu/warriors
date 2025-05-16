<?php
$title = SectionService::get('info', 'title');
$text = SectionService::get('info', 'text');
?>

<section id="info" class="section info mt-auto">
    <div class="container">
        <div class="inner inner-style text-center info__inner wow pixFadeUp" data-wow-delay="0.2s">
            <h2 class="title">
                <?= $title ?>
            </h2>
            <p class="text-justify">
                <?= $text ?>
            </p>
        </div>
    </div>
</section>
