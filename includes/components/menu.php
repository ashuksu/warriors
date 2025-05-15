<nav id="menu" class="menu">
	<?php
	render_button([
		'class' => 'button button--close button--transparent',
		'attr' => 'data-button="menu-close"',
	]);
	?>

	<div class="menu__list" data-menu="list">
		<a class="menu__link link" data-menu="link" href="<?= APP_PATH ?>#about">About</a>
		<a class="menu__link link" data-menu="link" href="<?= APP_PATH ?>catalog">Catalog</a>
		<a class="menu__link link" data-menu="link" href="<?= APP_PATH ?>#faq">FAQ</a>
		<a class="menu__link link" data-menu="link" href="<?= APP_PATH ?>#info">Info</a>
		<a class="menu__link link" data-menu="link" href="<?= APP_PATH ?>contacts">Contacts</a>
	</div>

    <?php
    render_button([
        'url'=> '#popup-first',
        'attr' => 'data-element="popup-open"',
        'content' => 'Open POPUP 1',
    ]);
    ?>
</nav>