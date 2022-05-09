<?php
function is_dev() {
	return $_SERVER["SERVER_ADDR"] === '::1';
}

function add_scripts() {
	$ver = wp_get_theme()->get( 'Version' );
	$root_path = get_template_directory_uri();
	$style_path = $root_path . '/style.css';
	$script_path = $root_path . '/assets/script' . ( is_dev() ? '' : '.min' ) . '.js';
	wp_enqueue_style( 'mellon-style', $style_path, array(), $ver );
	wp_enqueue_script( 'mellon-script', $script_path, array(), $ver, true );
}
add_action( 'wp_enqueue_scripts', 'add_scripts' );

add_theme_support( 'title-tag' );


//////////////////////////////////////////////
///////////////////ADMIN MENU/////////////////
//////////////////////////////////////////////


function remove_menus() {
	remove_menu_page( 'jetpack' );
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'remove_menus' );

function custom_menu_order() {
	return array(
		'index.php',
		'separator1',
		'edit.php',
		'edit.php?post_type=page',
		'separator2',
		'upload.php',
		'separator3',
	);
}

add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'custom_menu_order' );


function add_admin_menu_separator( $position ) {
	global $menu;
	$menu[$position] = array(
		'',
		'read',
		'separator' . $position,
		'',
		'wp-menu-separator'
	);
}
add_action( 'admin_init', 'add_admin_menu_separator' );

function set_admin_menu_separator() {
	add_admin_menu_separator( 9 );
}
add_action( 'admin_menu', 'set_admin_menu_separator' );


if( function_exists('acf_add_options_page') ) {
	acf_add_options_page( array(
		'page_title' 	=> 'Footer',
		'menu_title'	=> 'Footer',
		'menu_slug' 	=> 'footer-settings',
		'redirect'		=> false
	) );
}


//////////////////////////////////////////////
//////////////////ADMIN EDITOR////////////////
//////////////////////////////////////////////


function disable_editor_fullscreen() {
	if ( is_admin() ) { 
		$script = "jQuery( window ).load(function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } });";
		wp_add_inline_script( 'wp-blocks', $script );
	}
}
add_action( 'enqueue_block_editor_assets', 'disable_editor_fullscreen' );

add_theme_support( 'post-thumbnails', array(
	'post',
	'resource',
	'project',
	'employee',
	'fellow',
) );

function remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'post', 'trackbacks' );
}
add_action( 'init', 'remove_comment_support' );


//////////////////////////////////////////////
/////////////////////MENUS////////////////////
//////////////////////////////////////////////


function register_menus() {
	register_nav_menus( array(
		'header' => 'Header Menu',
		'footer' => 'Footer Menu'
	));
}
add_action( 'after_setup_theme', 'register_menus' );


//////////////////////////////////////////////
/////////////////////EVENTS///////////////////
//////////////////////////////////////////////

function change_post_menu_label() {
	global $menu, $submenu;
	$menu[5][0] = 'Resources';
	$submenu['edit.php'][5][0] = 'Resource';
	$submenu['edit.php'][10][0] = 'New Resource';
	echo '';
}
add_action( 'admin_menu', 'change_post_menu_label' );

function change_post_object_label() {
		global $wp_post_types;
		$labels = &$wp_post_types['post']->labels;
		$labels->name = 'Resources';
		$labels->singular_name = 'Resource';
		$labels->add_new = 'New Resource';
		$labels->add_new_item = 'New Resource';
		$labels->edit_item = 'Edit Resource';
		$labels->new_item = 'New Resource';
		$labels->view_item = 'View Resources';
		$labels->search_items = 'Search Resources';
		return $labels;
}
add_action( 'init', 'change_post_object_label' );

// function register_resources() {
// 	register_post_type( 'resource',
// 		array(
// 			'labels' => array(
// 				'name'               => __( 'Resources', 'post type general name' ),
// 				'singular_name'      => __( 'Resource', 'post type singular name' ),
// 				'menu_name'          => __( 'Resources', 'admin menu' ),
// 				'name_admin_bar'     => __( 'Resource', 'add new on admin bar' ),
// 				'add_new'            => __( 'Add New', 'resource' ),
// 				'add_new_item'       => __( 'Add New Resource' ),
// 				'new_item'           => __( 'New Resource' ),
// 				'edit_item'          => __( 'Edit Resource' ),
// 				'view_item'          => __( 'View Resource' ),
// 				'all_items'          => __( 'All Resources' ),
// 				'search_items'       => __( 'Search Resources' ),
// 				'parent_item_colon'  => __( 'Parent Resources:' ),
// 				'not_found'          => __( 'No Resources found.' ),
// 				'not_found_in_trash' => __( 'No Resources found in Trash.' )
// 			),
// 			'menu_icon' => 'dashicons-calendar-alt',
// 			'public' => true,
// 			'has_archive' => true,
// 			'supports' => array( 'title', 'thumbnail', 'editor' ),
// 			'show_in_rest' => true,
// 		)
// 	);
// }
// add_action( 'init', 'register_resources' );

function register_resource_types() {
	$resource_type_args = array(
		'labels' => array(
			'name'              => _x( 'Resource Type', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Resource Type', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Resource Types', 'textdomain' ),
			'all_items'         => __( 'All Resource Types', 'textdomain' ),
			'parent_item'       => __( 'Parent Resource Type', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Resource Type:', 'textdomain' ),
			'edit_item'         => __( 'Edit Resource Type', 'textdomain' ),
			'update_item'       => __( 'Update Resource Type', 'textdomain' ),
			'add_new_item'      => __( 'Add New Resource Type', 'textdomain' ),
			'new_item_name'     => __( 'New Resource Type Name', 'textdomain' ),
			'menu_name'         => __( 'Resource Types', 'textdomain' ),
		),
		'hierarchical' => true,
		'show_uri' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
	);
	register_taxonomy( 'resource_type', array( 'post' ), $resource_type_args );
}
add_action( 'init', 'register_resource_types' );


//////////////////////////////////////////////
///////////////////EXCERPTS///////////////////
//////////////////////////////////////////////


function custom_excerpt( $excerpt ){
	$limit = 190;
	if( strlen( $excerpt ) > $limit ) {
		$excerpt = substr( $excerpt, 0, strpos( $excerpt, ' ', $limit ) );
		$excerpt = preg_replace( '/[^a-z0-9]+$/i', '', $excerpt );
		$excerpt .= '...';
	}
	return $excerpt;
}

add_filter('get_the_excerpt', 'custom_excerpt');

function custom_excerpt_more() {
	return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more', 999 );


//////////////////////////////////////////////
/////////////////////MEDIA////////////////////
//////////////////////////////////////////////


// update_option( 'thumbnail_size_w', 800 );
// update_option( 'thumbnail_size_h', 450 );
// update_option( 'thumbnail_crop', 1 );
set_post_thumbnail_size( 800, 450, true );


function upscale_thumbnails( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ) {
		if ( !$crop ) return null; 
		$aspect_ratio = $orig_w / $orig_h;
		$size_ratio = max($new_w / $orig_w, $new_h / $orig_h);
		$crop_w = round($new_w / $size_ratio);
		$crop_h = round($new_h / $size_ratio);
		$s_x = floor( ($orig_w - $crop_w) / 2 );
		$s_y = floor( ($orig_h - $crop_h) / 2 );
		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}
add_filter( 'image_resize_dimensions', 'upscale_thumbnails', 10, 6 );


//////////////////////////////////////////////
////////////////////SEARCH////////////////////
//////////////////////////////////////////////


function exclude_pages_from_search() {
  global $wp_post_types;
  if( post_type_exists( 'page' ) ) {
    $wp_post_types['page']->exclude_from_search = true;
  }
}
add_action( 'init', 'exclude_pages_from_search', 99 );


//////////////////////////////////////////////
///////////////////UTILITIES//////////////////
//////////////////////////////////////////////


function slugify( $str ) {
	$slug = urlencode( $str );
	$slug = preg_replace( "/[0-9]+/", "", $str );
	$slug = preg_replace( "/-+/", "-", $slug);
	$slug = preg_replace( "/ +/", "-", $slug);
	$slug = trim( $slug, "/[\n]+/" );
	$slug = strtolower( $slug );
	return $slug;
}

function simple_url( $url ) {
	$strs = array( 'http://', 'https://', 'www.' );
	foreach( $strs as $str ) {
		if(strpos( $url, $str ) === 0) {
			$url = str_replace( $str, '', $url );
		}
	}
	$url = trim( $url, '/');
	return $url;
}

// function trim_text( $text, $limit = 20 ) {
// 	if( $text ) {
// 		return trim( preg_replace( '/((\w+\W*){' . ( $limit - 1 ) . '}(\w+))(.*)/', '${1}', strip_tags( $text ) ) ) . '...';
// 	}
// }

function get_svg( $path ) {
	$options = array(
		"ssl" => array(
			"verify_peer" => false,
			"verify_peer_name" => false,
		),
	);
	return file_get_contents( get_template_directory_uri() . $path, false, stream_context_create( $options ) );
}

?>