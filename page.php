<?php
get_header();
$page = $post;
$author = get_field( 'author', $page );
$date = date_format( date_create( $page->post_date ), 'j F Y' );
?>

<div class="row">
	<div class="col-12 col-lg-6 col-xxl-5 mx-auto">
		<header id="post-header">
			<h1 id="post-title">
				<?= $page->post_title; ?>
			</h1>
		</header>
		<?= the_content( $page ); ?>
	</div>
</div>

<?php get_footer(); ?>