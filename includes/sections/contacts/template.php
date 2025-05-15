<section class="section contacts">
    <div class="container">
        <div class="inner">
            <h1 class="title text-center mb-5 wow pixFadeUp" data-wow-delay="0.2s">
                <?= $title ?>
            </h1>

            <div class="row contacts__list wow pixFadeUp" data-wow-delay="0.3s">
                <?php
                foreach ($contacts as $index => $item) {
                    include __DIR__ . '/item.php';
                }
                ?>
            </div>
        </div>
    </div>
</section>
