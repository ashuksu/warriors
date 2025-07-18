<div class="catalog__item wow pixFadeUp" data-wow-delay="0.3s">
	<div class="catalog__item-inner">

        <?php

        use App\Views\Components\Image;

        echo Image::render([
            'url' => $image ?? '#',
            'alt' => $item['alt'] ?? 'Catalog item',
            'width' => $item['width'] ?? 150,
            'height' => $item['height'] ?? 150,
        ]);
        ?>

	</div>
</div>