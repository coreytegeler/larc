<?php /* Template Name: Posts */
get_header();
$page = $post; ?>
<?php
$resources = get_posts( array(
	'post_type' => 'post',
	'posts_per_page' => 4
) );
if( sizeof( $resources ) ) { ?>
	<section id="resources">
		<div class="posts">
			<div class="row no-gutters <?= sizeof( $resources ) < 3 ? 'justify-content-center' : '';?>">
				<?php foreach( $resources as $resource ) { ?>
					<div class="col-12 col-md-6 col-lg-4 col-xl-3">
						<article class="post bordered">
							<a href="<?= get_permalink( $resource ); ?>" class="article-inner">
								<div class="post-meta">
									<div class="row">
										<div class="col col-12 col-sm-auto">
											<?= get_the_date( '', $post ); ?>
										</div>
										<div class="col col-12 col-sm-auto">
											<div class="post-author">
												
											</div>
										</div>
									</div>
								</div>
								<header>
									<div class="post-thumbnail">
										<?= get_the_post_thumbnail( $resource ); ?>
									</div>
									<h2 class="post-title">
										<?= $resource->post_title; ?>
									</h2>
								</header>
								<div class="post-meta">
									<div class="row">
										<div class="col col-12 col-sm-auto">
											
										</div>
										<div class="col col-12 col-sm-auto">
											<div class="post-author">
												<?= get_field( 'author', $resource ); ?>
											</div>
										</div>
									</div>
								</div>
							</a>
						</article>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
<?php } ?>

<?php get_footer(); ?>