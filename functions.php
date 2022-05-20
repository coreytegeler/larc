<?php
function is_dev() {
	return $_SERVER["SERVER_ADDR"] === '::1';
}

function add_scripts() {
	$ver = wp_get_theme()->get( 'Version' );
	$root_path = get_template_directory_uri();
	$style_path = $root_path . '/style.css';
	$script_path = $root_path . '/assets/script' . ( is_dev() ? '' : '.min' ) . '.js';
	wp_enqueue_style( 'larc-style', $style_path, array(), $ver );
	wp_enqueue_script( 'larc-script', $script_path, array(), $ver, true );

	wp_scripts()->add_data( 'larc-script', 'data', sprintf( 'var settings = %s;', wp_json_encode(  [
		'api' => esc_url_raw( get_rest_url( null, '/wp/v2/' ) ),
		'root' => esc_url_raw( trailingslashit( home_url() ) ),
		'theme' => esc_url_raw( get_template_directory_uri() )
	] ) ) );
}
add_action( 'wp_enqueue_scripts', 'add_scripts' );

add_theme_support( 'title-tag' );


//////////////////////////////////////////////
///////////////////ADMIN MENU/////////////////
//////////////////////////////////////////////

function remove_menus() {
	remove_menu_page( 'edit.php' );
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
) );

function remove_comment_support() {
	remove_post_type_support( 'resource', 'comments' );
	remove_post_type_support( 'resource', 'trackbacks' );
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
///////////////////RESOURCES//////////////////
//////////////////////////////////////////////

// function change_post_menu_label() {
// 	global $menu, $submenu;
// 	$menu[5][0] = 'Resources';
// 	$submenu['edit.php'][5][0] = 'Resource';
// 	$submenu['edit.php'][10][0] = 'New Resource';
// 	echo '';
// }
// add_action( 'admin_menu', 'change_post_menu_label' );

// function change_post_object_label() {
// 		global $wp_post_types;
// 		$labels = &$wp_post_types['post']->labels;
// 		$labels->name = 'Resources';
// 		$labels->singular_name = 'Resource';
// 		$labels->add_new = 'New Resource';
// 		$labels->add_new_item = 'New Resource';
// 		$labels->edit_item = 'Edit Resource';
// 		$labels->new_item = 'New Resource';
// 		$labels->view_item = 'View Resources';
// 		$labels->search_items = 'Search Resources';
// 		return $labels;
// }
// add_action( 'init', 'change_post_object_label' );

function register_resources() {
	register_post_type( 'resource',
		array(
			'labels' => array(
				'name'               => __( 'Resources', 'post type general name' ),
				'singular_name'      => __( 'Resource', 'post type singular name' ),
				'menu_name'          => __( 'Resources', 'admin menu' ),
				'name_admin_bar'     => __( 'Resource', 'add new on admin bar' ),
				'add_new'            => __( 'Add New', 'resource' ),
				'add_new_item'       => __( 'Add New Resource' ),
				'new_item'           => __( 'New Resource' ),
				'edit_item'          => __( 'Edit Resource' ),
				'view_item'          => __( 'View Resource' ),
				'all_items'          => __( 'All Resources' ),
				'search_items'       => __( 'Search Resources' ),
				'parent_item_colon'  => __( 'Parent Resources:' ),
				'not_found'          => __( 'No Resources found.' ),
				'not_found_in_trash' => __( 'No Resources found in Trash.' )
			),
			'menu_icon' => 'dashicons-admin-page',
			'public' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'thumbnail', 'editor' ),
			'show_in_rest' => true,
			'show_in_menu' => true,
		)
	);
}
add_action( 'init', 'register_resources' );

function register_formats() {
	$format_args = array(
		'labels' => array(
			'name'              => _x( 'Formats', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Format', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Formats', 'textdomain' ),
			'all_items'         => __( 'All Formats', 'textdomain' ),
			'parent_item'       => __( 'Parent Format', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Format:', 'textdomain' ),
			'edit_item'         => __( 'Edit Format', 'textdomain' ),
			'update_item'       => __( 'Update Format', 'textdomain' ),
			'add_new_item'      => __( 'Add New Format', 'textdomain' ),
			'new_item_name'     => __( 'New Format Name', 'textdomain' ),
			'menu_name'         => __( 'Formats', 'textdomain' ),
		),
		'hierarchical' => true,
		'show_uri' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
	);
	register_taxonomy( 'format', array( 'resource' ), $format_args );
}
add_action( 'init', 'register_formats' );

function register_practices() {
	$practice_args = array(
		'labels' => array(
			'name'              => _x( 'Practices', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Practice', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Practices', 'textdomain' ),
			'all_items'         => __( 'All Practices', 'textdomain' ),
			'parent_item'       => __( 'Parent Practice', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Practice:', 'textdomain' ),
			'edit_item'         => __( 'Edit Practice', 'textdomain' ),
			'update_item'       => __( 'Update Practice', 'textdomain' ),
			'add_new_item'      => __( 'Add New Practice', 'textdomain' ),
			'new_item_name'     => __( 'New Practice Name', 'textdomain' ),
			'menu_name'         => __( 'Practices', 'textdomain' ),
		),
		'hierarchical' => true,
		'show_uri' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
	);
	register_taxonomy( 'practice', array( 'resource' ), $practice_args );
}
add_action( 'init', 'register_practices' );

function register_locations() {
	$location_args = array(
		'labels' => array(
			'name'              => _x( 'Locations', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Location', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Locations', 'textdomain' ),
			'all_items'         => __( 'All Locations', 'textdomain' ),
			'parent_item'       => __( 'Parent Location', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Location:', 'textdomain' ),
			'edit_item'         => __( 'Edit Location', 'textdomain' ),
			'update_item'       => __( 'Update Location', 'textdomain' ),
			'add_new_item'      => __( 'Add New Location', 'textdomain' ),
			'new_item_name'     => __( 'New Location Name', 'textdomain' ),
			'menu_name'         => __( 'Locations', 'textdomain' ),
		),
		'hierarchical' => true,
		'show_uri' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
	);
	register_taxonomy( 'location', array( 'resource' ), $location_args );
}
add_action( 'init', 'register_locations' );


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

function get_feed( $params ) {
	$args = array();
	$taxonomies = array( 'format', 'practice', 'location' );
	foreach( $taxonomies as $taxonomy ) {
		if( isset( $_GET[$taxonomy] ) ) {
			$args[$taxonomy] = explode( ',', $_GET[$taxonomy] );
		}
	}
	get_template_part( 'parts/feed', null, $args );
	die();
}


//////////////////////////////////////////////
/////////////////////IMPORT///////////////////
//////////////////////////////////////////////

function get_data() {
	$req_url_base = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSJRSOpPjDLiDars413Y_7mhA9DHUaFCs3TjlR6_LXnD1giJ-01rlu8dvaQ3DHYpUdEWzDhl7dvxjro/pub?gid=597194473&single=true&output=csv';
	$ch = curl_init(); 
	curl_setopt( $ch, CURLOPT_URL, $req_url_base );
	$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)'; 
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_VERBOSE, true );
	curl_setopt( $ch, CURLOPT_USERAGENT, $agent );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 15 );
	$output = curl_exec( $ch );
	curl_close( $ch );
	$rows = explode( "\n", $output );
	$headings = explode( ',', $rows[0] );
	array_shift( $rows );
	foreach( $rows as $row ) {
	  insert_resource( array_combine( $headings, array_pad( str_getcsv( $row ), count( $headings ), '' ) ) );
	}
}

function insert_resource( $data ) {
	$keys = array(
		'date' => 'Publication Date/Last Updated',
		'source' => 'Source',
		'author' => 'Author/Username',
		'format' => 'Format',
		'title' => 'Title',
		'summary' => 'Summary',
		'tags' => 'Tags',
		'location' => 'Location',
		'practice' => 'Practice',
		'media' => 'Media',
		'image' => 'Key Image (set permission public)',
		'link' => 'Link',
	);

	$values = array();
	foreach( $keys as $slug => $key ) {
		$values[$slug] = isset( $data[$key] ) ? $data[$key] : null;
	}

	if( !$values['title'] ) return;

	$existing_post = get_page_by_path( sanitize_title( $values['title'] ), OBJECT, 'resource' );

	$post_data = array(
		'ID' => $existing_post ? $existing_post->ID : 0,
		'post_type' => 'resource',
		'post_status' => 'publish',
		'post_title' => $values['title'],
		'post_date' => date( 'Y-m-d H:i:s', strtotime( $values['date'] ) ),
		'post_content' => $values['summary'],
		'tags_input' => $values['tags'],
		'meta_input' => array(
			'link' => $values['link'],
			'author' => $values['author'],
			'source' => $values['source'],
		)
	);

	$post_id = wp_insert_post( $post_data );
	wp_set_object_terms( $post_id, array( $values['format'] ), 'format' );
	wp_set_object_terms( $post_id, array( $values['location'] ), 'location' );
	wp_set_object_terms( $post_id, array( $values['practice'] ), 'practice' );
}

function register_custom_query_vars($vars) {
	$vars[] .= 'format';
	$vars[] .= 'practice';
	$vars[] .= 'location';
	return $vars;
}
add_filter( 'query_vars', 'register_custom_query_vars' );

function register_endpoints() {

	register_rest_route( 'wp/v2', '/get_data', array(
		'methods' => 'GET',
		'callback' => 'get_data',
		'permission_callback' => '__return_true',
	));

	register_rest_route( 'wp/v2', '/get_feed', array(
		'methods' => 'GET',
		'callback' => 'get_feed',
		'permission_callback' => '__return_true',
	));

};

add_action( 'rest_api_init', 'register_endpoints' );


add_filter( 'http_request_host_is_external', '__return_true' );

?>