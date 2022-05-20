<?php
get_header();
$resource = $post;
?>

<div class="row">
	<div class="col-12 col-lg-6 col-xxl-5">
		<div class="mb-5">
			<?php the_post_thumbnail( 'medium' ); ?>
		</div>

		<div class="d-none d-lg-block d-xxl-none pt-lg-5">
			<?php get_template_part( 'parts/latest' ); ?>
		</div>
	</div>
	<div class="col-12 col-lg-6 col-xxl-5">
		<header id="post-header">
			<h1 id="post-title">
				<?= $resource->post_title; ?>
			</h1>
			<div id="post-meta" class="row">
				<div class="col-auto">
					<?= get_field( 'author', $resource ); ?>
				</div>
				<div class="col-auto">
					<?= date_format( date_create( $resource->post_date ), 'j F Y' ); ?>
				</div>
			</div>
		</header>
		<?= the_content( $resource ); ?>
	</div>
	<div class="col-12 col-xxl-2">
		<div class="d-block d-lg-none d-xxl-block pt-5 pt-xxl-0">
			<?php get_template_part( 'parts/latest' ); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>