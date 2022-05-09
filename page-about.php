<?php /* Template Name: About */
get_header();
$page = $post; ?>

<header id="page-header" class="top-header">
	<div class="row no-gutters">
		<div class="col">
			<h1 id="page-title">
				<?= $page->post_title; ?>
			</h1>
		</div>
	</div>
</header>

<article>
	<section>
		<div class="row">
			<div class="col-12 col-md-6">
				<?= the_content( $page ); ?>
			</div>
			<div class="col-12 col-md-6">
				<?= get_field( 'about_more', $page ); ?>
			</div>
		</div>
	</section>
</article>

<?php get_footer(); ?>