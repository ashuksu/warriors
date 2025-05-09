<section class="section catalog">
	<div class="container">
		<div class="inner catalog__inner">
			<h1 class="title mb-5 text-center wow pixFadeUp" data-wow-delay="0.2s">
				lorem ipsum dolor sit
			</h1>
			<div class="catalog__grid">
				<?php
				$catalog = [
					['image' => '1.png'], ['image' => '2.png'], ['image' => '3.png'],
					['image' => '4.png'], ['image' => '5.png'], ['image' => '6.png'],
					['image' => '7.png'], ['image' => '8.png'], ['image' => '9.png']
				];

				foreach ($catalog as $item) {
					$imageUrl = APP_PATH . 'assets/images/items/' . $item['image'];

					include $dir . 'includes/components/catalog-item.php';
				}
				?>
			</div>
		</div>
	</div>
</section>
