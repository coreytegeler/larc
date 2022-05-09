<div id="latest-posts">
	<h3>
		The Latest
	</h3>
	<?php
	$latest_posts = get_posts( array(
		'posts_per_page' => 4,
		'exclude' => $post->ID,
	) );
	?>

	<ul>
		<?php foreach ( $latest_posts as $latest_post ) { ?>
			<li>
				<a href="<?= get_permalink( $latest_post ); ?>">
					<?= $latest_post->post_title; ?>
				</a>
			</li>
		<?php } ?>
	</ul>
</div>