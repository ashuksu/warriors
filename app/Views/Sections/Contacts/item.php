<?php

use Views\Components\Button;

?>

<div class="contacts__card col col-md-6">
	<div class="inner contacts__card-inner mx-auto">
		<h3 class="sub-title contacts__card-title"><?= $item['title'] ?? '' ?></h3>

		<p class="contacts__card-text "><?= $item['text'] ?? '' ?></p>

        <?php
        echo Button::render([
            'url' => $item['url'] ?? '#',
            'class' => 'mt-auto',
            'attr' => 'data-element="link"',
            'content' => $item['title'] ?? 'Contact',
            'aria-label' => 'Contact via ' . ($item['title'] ?? ''),
            'role' => 'button'
        ]);
        ?>

	</div>
</div>