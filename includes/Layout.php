<?php
$dir = $dir ?? '';

include $dir . 'config.php';

include $dir . 'includes/head.php';

//helpers
include $dir . 'includes/components/button.php';
?>

<body data-style="default" class="<?= $bodyClass ?>">

<div class="wrapper">

	<?php
	include $dir . 'includes/components/preloader.php';

	include $dir . 'includes/header.php';
	?>

	<main id="content" class="content">
		<?php
		foreach ($sections as $section) {
			include $dir . 'includes/sections/' . $section . '.php';
		}
		?>
	</main>

	<?php
	include $dir . 'includes/footer.php';
	?>
</div>

<?php
render_button([
	'url' => "#",
	'class' => 'link',
	'attr' => 'target="_blank"',
	'content' => 'Link',
]);

include $dir . 'includes/footer-links.php';
?>

</body>
</html>