<section id="<?= $section ?? '' ?>" class="section mt-auto info <?= $section ?? '' ?>">
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