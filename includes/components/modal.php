<div class="modal fade" id="modal" data-bs-toggle="modal" data-bs-target="#modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="sub-title">Modal title</h2>

				<?php
				render_button([
					'class' => 'button button--close button--transparent',
					'attr' => 'data-bs-dismiss="modal" data-dismiss="modal"',
				]);
				?>
			</div>

			<div class="modal-body">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias consectetur doloremque dolores ducimus
				esse est et nesciunt nihil non nostrum officiis placeat, quisquam quo, reiciendis sequi tempora ut
				velit, vitae.
			</div>

			<div class="modal-footer">
				<?php
				render_button([
					'url' => $LINK,
					'class' => 'btn modal-btn',
					'attr' => 'target="_blank" data-bs-dismiss="modal"',
					'content' => 'GitHub',
				]);
				?>
			</div>
		</div>
	</div>
</div>