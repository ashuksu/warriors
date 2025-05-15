<?php
$title = SectionService::get('faq', 'title');
$faq = SectionService::get('faq', 'items');

if (!is_array($faq) || empty($faq)) {
    $faq = [];
    $isHidden = 'hidden';
}
?>

<section id="faq" class="section faq" <?= $isHidden ?? "" ?>>
    <div class="container">
        <div class="inner inner-style faq__inner">
            <h2 class="title text-center wow pixFadeUp" data-wow-delay="0.2s">
                <?= $title ?>
            </h2>

            <div class="faq__list">
                <?php
                foreach ($faq as $index => $item) {
                    $setActiveClass = $index === 0 ? 'active' : '';

                    include __DIR__ . '/item.php';
                }
                ?>
            </div>
        </div>
    </div>
</section>