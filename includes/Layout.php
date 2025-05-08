<?php
$dir = $dir ?? '';

include $dir . 'includes/head.php';
?>

<body data-style="default" class="<?= $bodyClass ?>">

<div class="wrapper">

	<?php
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
</body>
</html>