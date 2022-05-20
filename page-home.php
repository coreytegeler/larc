<?php /* Template Name: Home */
get_header();
$page = $post; ?>

<section id="landing">
	<div class="container-xxl">
		<div class="row">
			<div class="col-12 col-lg-6">
				<?= the_content( $page ); ?>

				<!-- <a href="#">
					Enter
				</a> -->
			</div>
		</div>
	</div>
</section>

<?php
// $features = get_posts( array(
// 	'post_type' => 'post',
// 	'posts_per_page' => 1,
// 	'tax_query' => array(
// 		'taxonomy' => 'resource_type',
// 		'field' => 'slug',
// 		'terms' => 'featured'
// 	)
// ) );
$features = array();
if( sizeof( $features ) ) {
	$feature = $features[0]; ?>
	<section id="featured" class="bg-maize">
		<div class="container-fluid">
			<div class="row no-gutters">
				<div class="col-12 col-md-6 col-meta">
					<article class="post">
						<h2 class="post-title">
							<?= $feature->post_title; ?>
						</h2>
						<div class="post-author">
							by <?= get_field( 'author', $feature ); ?>
						</div>

						<div class="post-excerpt">
							<?= $feature->post_excerpt; ?>
						</div>

						<a href="<?= get_permalink( $feature ); ?>" class="button">
							Read Here
						</a>
					</article>
				</div>
				<div class="col-12 col-md-6 col-image">
					<div class="post-thumbnail">
						<?= get_the_post_thumbnail( $feature ); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>

<?php
$resources_page = get_page_by_path( 'resources' );
$about_page = get_page_by_path( 'about' );
$mission_page = get_page_by_path( 'mission' );

$resources = get_posts( array(
	'post_type' => 'resource',
	'posts_per_page' => 4,
	// 'exclude' => $feature->ID
) );

if( sizeof( $resources ) ) { ?>
	<section id="resources">
		<div class="posts">
			<div class="row no-gutters">
				<div class="col-12 col-lg-6 bg-maize bordered">
					<div class="p-5">
						<!-- <h3 class="mb-5">
							Resources
						</h3> -->
						<div class="text-lg">
							<?= get_field( 'latest_news', $post ); ?>
						</div>
						<div class="mt-5">
							<?php if( $mission_page ) { ?>
							<a href="<?= get_permalink( $resources_page ); ?>">
								<strong class="text-xl bg-svg bg-arrow-right-black">
									View all resources
								</strong>
							</a>
						<?php } ?>
						</div>
					</div>
				</div>
				
				<?php foreach( $resources as $resource ) { ?>
					<div class="col-12 col-sm-6 col-lg-3">
						<article class="post bordered">
							<a href="<?= get_permalink( $post ); ?>" class="article-inner">
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
								<header class="m-auto">
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

				<div class="col-12 col-lg-6 bg-gray text-alabaster bordered">
					<div class="p-5">
						<div class="text-lg">
							<?= get_field( 'mission', $post ); ?>
						</div>
						<br/>
						<?php if( $about_page ) { ?>
							<a href="<?= get_permalink( $about_page ); ?>">
								<strong class="text-xl mb-5 bg-svg bg-arrow-right-alabaster text-alabaster">
									About the project
								</strong>
							</a>
						<?php } ?>
						<br/><br/>
						<?php if( $mission_page ) { ?>
							<a href="<?= get_permalink( $mission_page ); ?>">
								<strong class="text-xl mb-5 bg-svg bg-arrow-right-alabaster text-alabaster">
									Our mission
								</strong>
							</a>
						<?php } ?>
					</div>
				</div>
				
			</div>
		</div>
	</section>
<?php } ?>

<?php get_footer(); ?>