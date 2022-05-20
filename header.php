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
	if( ( $locations = get_nav_menu_locations() ) && isset( $locations['header'] ) ) {
		$menu = wp_get_nav_menu_object( $locations['header'] );
    $menu_items = wp_get_nav_menu_items($menu->term_id);
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
				<div class="col col-12 col-lg-6 order-lg-2">
					<div id="site-logo">
						<a href="/"
							 tabindex="0">
							LARC
						</a>
					</div>
					<div id="site-title">
						<?= get_bloginfo( 'title' ); ?>
					</div>
				</div>
				<div class="col col-12 col-sm-6 col-lg-3 order-lg-1">
					<nav id="header-menu">
						<?php if( isset( $menu_items ) && $menu_items ) { ?>
							<ul role="menubar"
									aria-label="Main menu">
								<?php foreach ( $menu_items as $menu_item ) { ?>
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
				<div class="col col-12 col-sm-6 col-lg-3 order-lg-3 center-inner">
					<?php get_search_form(); ?>
				</div>
		</header>

		<main id="main">