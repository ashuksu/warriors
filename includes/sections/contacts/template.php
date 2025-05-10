<section class="section contacts">
	<div class="container">
		<div class="inner">
			<h1 class="title text-center mb-5 wow pixFadeUp" data-wow-delay="0.2s">
				Contacts
			</h1>
			<div class="row contacts__list wow pixFadeUp" data-wow-delay="0.3s">
				<?php
				$contacts = [
					[
						'title' => 'Email',
						'text' => 'lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium ',
						'url' => 'mailto:' . $EMAIL,
					],
					[
						'title' => 'Telegram',
						'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam assumenda consequatur dolore eum fuga itaque quasi qui quisquam sequi tenetur.',
						'url' => 'tel:' . $PHONE,
					]
				];
				foreach ($contacts as $index => $item) {
					include $dir . 'includes/sections/contacts/item.php';
				}
				?>
			</div>
		</div>
	</div>
</section>
