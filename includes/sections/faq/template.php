<section id="faq" class="section faq">
	<div class="container">
		<div class="inner inner-style faq__inner">
			<h2 class="title text-center wow pixFadeUp" data-wow-delay="0.2s">
				Lorem ipsum dolor
			</h2>

			<div class="faq__list">
				<?php
				$faq = [
					[
						'title' => 'Lorem ipsum dolor sit amet.',
						'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi illo natus numquam qui quidem quod, sit? Adipisci a'
					],
					[
						'title' => 'Lorem ipsum dolor sit.',
						'text' => 'Lorem ipsum dolor sit amet, consectetur adipi'
					],
					[
						'title' => 'Lorem ipsum dolor sit amet, consectetur.',
						'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aliquam cum, dicta dolor ducimus eius, eos excepturi fugiat ipsam magni minus perspiciatis provident quisquam suscipit tempore ut vero voluptas voluptatum!'
					]];

				foreach ($faq as $index => $item) {
					include PROJECT_ROOT . 'includes/sections/faq/item.php';
				}
				?>
			</div>
		</div>
	</div>
</section>