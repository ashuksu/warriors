<div class="contacts__card col-md-6 mt-md-0">
    <div class="inner contacts__card-inner mx-auto">
        <h3 class="sub-title contacts__card-title"><?= $item['title'] ?></h3>

        <p class="contacts__card-text "><?= $item['text'] ?></p>

        <?php
        render_button([
            'url' => $item['url'],
            'class' => 'mt-auto',
            'content' => $item['title'],
        ]);
        ?>
    </div>
</div>