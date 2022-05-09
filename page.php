<?php get_header();
$page = $post; ?>

<header id="page-header" class="top-header">
	<div class="row no-gutters">
		<div class="col">
			<h1 id="page-title">
				<?= $page->post_title; ?>
			</h1>
		</div>
		<div class="col">
			
		</div>
	</div>
</header>

<article>
	<section>
		<?= the_content( $page ); ?>
	</section>
</article>

<?php get_footer(); ?>