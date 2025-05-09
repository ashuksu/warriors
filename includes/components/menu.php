<nav id="menu" class="menu">
	<?php
	render_button([
		'class' => 'button button--close',
		'attr' => 'data-button="menu-close"',
	]);
	?>

	<div class="menu__list" data-menu="list">
		<a class="menu__link link" data-menu="link" href="<?= APP_PATH ?>#about">About</a>
		<a class="menu__link link" data-menu="link" href="<?= APP_PATH ?>catalog">Catalog</a>
		<a class="menu__link link" data-menu="link" href="<?= APP_PATH ?>#info">Info</a>
		<a class="menu__link link" data-menu="link" href="<?= APP_PATH ?>contacts">Contacts</a>
	</div>

	<?php
	render_button([
		'class' => 'mx-auto',
		'attr' => 'data-toggle="modal" data-target="#modal"',
		'content' => 'Open MODAL',
	]);
	?>
</nav>