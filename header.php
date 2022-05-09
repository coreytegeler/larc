<?php global $post; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php wp_head(); ?>
	</head>

	<?php
	$body_classes = array();
	if( $post ) {
		$body_classes[] = $post->post_name;
	}
	?>

	<body <?php body_class( $body_classes ); ?>>
		<?php wp_body_open(); ?>
		<?php get_header(); ?>

		<a href="#main"
			 id="skip-link"
			 class="sr-only">
			Skip to content
		</a>

		<header id="site-header" class="top-header container">
			<div class="row">
				<div class="col col-12 col-sm-4 order-2">
					<div id="site-title">
						<a href="/"
							 tabindex="0">
							LARC
							<?#= get_bloginfo( 'title' ); ?>
						</a>
					</div>
				</div>
				<div class="col col-12 col-sm-4 order-1">
					<nav id="header-menu">
						<?php if( $header_menu_items = wp_get_nav_menu_items( 'header' ) ) { ?>
							<ul role="menubar"
									aria-label="Main menu"
									class="color-wheel">
								<?php foreach ( $header_menu_items as $menu_item ) { ?>
									<li class="">
										<a role="menuitem"
											 href="<?= $menu_item->url; ?>">
											<?= $menu_item->title; ?>
										</a>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>
					</nav>
				</div>
				<div class="col col-12 col-sm-4 order-3 center-inner">
					<?php get_search_form(); ?>
				</div>
		</header>

		<main id="main">