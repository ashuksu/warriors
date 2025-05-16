<div class="about__card inner-style row wow pixFadeUp" data-reverse="<?= $isReverse ?>" data-wow-delay="0.2s">
    <div class="row">
        <div class="col-md-6 mb-3 mt-md-0">
            <div class="image">
                <img src="<?= $imageUrl ?>" alt="<?= $item['name'] ?>"
                     width="600" height="600">
            </div>
        </div>
        <div class="col-md-6 mb-md-0">
            <div class="inner about__card-inner">
                <h3 class="sub-title"><?= $item['title'] ?></h3>
                <p class="text-justify"><?= $item['text'] ?></p>
            </div>
        </div>
    </div>
</div>