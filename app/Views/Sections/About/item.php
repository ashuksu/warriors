<div class="about__card inner-style wow pixFadeUp" data-reverse="<?= $isReverse ?? '' ?>" data-wow-delay="0.2s">
    <div class="row">
        <div class="col col-md-6 mb-1 mb-md-0">
            <div class="image">
                <img src="<?= $image ?? '#' ?>" alt="<?= $item['alt'] ?? 'image' ?>"
                     width="<?= $item['width'] ?? 600 ?>" height="<?= $item['height'] ?? 600 ?>">
            </div>
        </div>
        <div class="col col-md-6 mb-md-0">
            <div class="inner about__card-inner">
                <h3 class="sub-title"><?= $item['title'] ?? '' ?></h3>
                <p class="text-justify"><?= $item['text'] ?? '' ?></p>
            </div>
        </div>
    </div>
</div>