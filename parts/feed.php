<?php
$tax_query = array(
	'condition' => 'OR'
);

foreach( $args as $tax => $terms ) {
	$tax_query[] = array(
		'taxonomy' => $tax,
		'terms' => $terms,
		'field' => 'slug'
	);
}

$resources = get_posts( array(
	'post_type' => 'resource',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'tax_query' => $tax_query
) );

if( sizeof( $resources ) ) { ?>

	<div class="row no-gutters <?= sizeof( $resources ) < 3 ? 'justify-content-center' : '';?>">
		<?php foreach( $resources as $resource ) {
			$url = get_field( 'link', $resource );
			$date = get_the_date( '', $resource );
			$author = get_field( 'author', $resource );
			$practices = get_the_terms( $resource, 'practice' );
			$locations = get_the_terms( $resource, 'location' ); ?>
			<div class="col-12 col-md-6 col-lg-4 col-xl-3">
				<article class="post bordered">
					<?php if( $url ) { ?><a href="<?= $url; ?>" target="_blank"><?php }?>
						<div class="article-inner">
							<div class="post-meta">
								<div class="row">
									<div class="col col-12 col-sm-auto">
										<?= $date; ?>
									</div>
									<div class="col col-12 col-sm-auto">
										<div class="post-author">
											<?= $author; ?>
										</div>
									</div>
								</div>
							</div>
							<header class="post-header">
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
										<?php if( $locations ) {
											foreach( $locations as $location ) {
												echo $location->name;
											}
										} ?>
									</div>
									<div class="col col-12 col-sm-auto">
										<?php if( $practices ) {
											foreach( $practices as $practice ) {
												echo $practice->name;
											}
										} ?>
									</div>
								</div>
							</div>
						</div>
					<?php if( $url ) { ?></a><?php } ?>
				</article>
			</div>
		<?php } ?>
	</div>
	
<?php } ?>