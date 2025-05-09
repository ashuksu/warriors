<section id="about" class="section about">
	<div class="container">
		<?php
		$about = [
			[
				'image' => 'w1.svg',
				'name' => 'w1',
				'title' => 'Lorem ipsum dolor sit amet.',
				'text' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, nisl eget consectetur adipiscing'
			],
			[
				'image' => 'w12.svg',
				'name' => 'w12',
				'title' => 'Lorem ipsum dolor sit amet, consectetur.',
				'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem commodi, dicta distinctio dolorum eos inventore ipsum laboriosam magni minima neque officiis placeat quam quisquam quod similique sit soluta vel voluptatum?'
			],
			[
				'image' => 'w2.svg',
				'name' => 'w2',
				'title' => 'Lorem ipsum dolor sit.',
				'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque dicta explicabo, nisi omnis possimus quia quis sapiente. Alias animi atque, autem enim esse eveniet expedita id illum molestias non voluptatem.'
			]
		];

		foreach ($about as $index => $item) {
			$imageUrl = APP_PATH . 'assets/images/' . $item['image'];
			$isReverse = $index % 2 !== 0;

			include $dir . 'includes/components/about-card.php';
		}
		?>
	</div>
</section>
