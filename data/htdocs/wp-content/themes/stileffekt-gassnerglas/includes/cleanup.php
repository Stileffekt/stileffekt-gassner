<?php
/**
 * WordPress Cleanup
 *
 * @package Stilpress
 */


// --- Comments ---

function stilpress__remove_admin_menus() {
	remove_menu_page( 'edit-comments.php' );
}

add_action( 'admin_menu', 'stilpress__remove_admin_menus' );


function stilpress__remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}

add_action( 'init', 'stilpress__remove_comment_support', 100 );


function stilpress__remove_admin_bar_comments() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
}

add_action( 'wp_before_admin_bar_render', 'stilpress__remove_admin_bar_comments' );


// --- Customizer ---

// remove admin menu entry Theme -> Customizer
add_action( 'admin_menu', function () {
	remove_submenu_page( 'themes.php', 'customize.php?return=' . urlencode( $_SERVER['SCRIPT_NAME'] ) );
}, 999 );


// permit opening customizer via url
add_action( 'admin_init', function () {
	if ( is_customize_preview() ) {
		wp_die();
	}
} );


// --- Emojis ---

/**
 * deactivate WordPress emoji support
 */
function stilpress__emoji_support_remove() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'embed_head', 'print_emoji_detection_script' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	add_filter( 'tiny_mce_plugins', function ( $plugins ) {
		if ( is_array( $plugins ) ) {
			$plugins = array_diff( $plugins, array( 'wpemoji' ) );
		}

		return $plugins;
	} );

	if ( (int) get_option( 'use_smilies' ) === 1 ) {
		update_option( 'use_smilies', 0 );
	}
}

add_action( 'init', 'stilpress__emoji_support_remove' );


// --- HTML Head ---

add_action( 'init', function () {
	// remove discovery service link
	remove_action( 'wp_head', 'rsd_link' );

	// Remove Windows Live Writer manifest link
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// remove the general feeds
	remove_action( 'wp_head', 'feed_links', 2 );

	// remove the extra feeds, such as category feeds
	remove_action( 'wp_head', 'feed_links_extra', 3 );

	remove_action( 'wp_head', 'wc_products_rss_feed' );

	// remove the displayed XHTML generator
	remove_action( 'wp_head', 'wp_generator' );

	// remove the REST API link tag
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );

	// remove oEmbed discovery links
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

	// remove rel next/prev links
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10 );

	// remove prefetch url
	remove_action( 'wp_head', 'wp_resource_hints', 2 );

	// remove meta robots
	remove_action( 'wp_head', 'wp_robots', 1 );

	// add meta charset
	add_action( 'wp_head', 'stilpress__meta_charset', 0 );

	// add meta robots
	add_action( 'wp_head', 'stilpress__robots', 0 );

	// add meta viewport
	add_action( 'wp_head', 'stilpress__meta_viewport', 0 );

} );

function stilpress__meta_charset() {
	echo "\n" . '<meta charset="' . get_bloginfo( 'charset' ) . '">' . "\n";
}

function stilpress__meta_viewport() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n\n";
}

function stilpress__robots() {

	$robots = apply_filters( 'wp_robots', array() );

	$robots_strings = array();
	foreach ( $robots as $directive => $value ) {
		if ( is_string( $value ) ) {
			// If a string value, include it as value for the directive.
			$robots_strings[] = "{$directive}:{$value}";
		} elseif ( $value ) {
			// Otherwise, include the directive if it is truthy.
			$robots_strings[] = $directive;
		}
	}

	if ( empty( $robots_strings ) ) {
		return;
	}

	echo '<meta name="robots" content="' . esc_attr( implode( ', ', $robots_strings ) ) . '">' . "\n";
}


// Remove wpml meta generator tag

function stilpress__remove_wpml_generator() {
	if ( ! empty( $GLOBALS['sitepress'] ) ) {
		remove_action( current_filter(), array( $GLOBALS['sitepress'], 'meta_generator_tag' ) );
	}
}

add_action( 'wp_head', 'stilpress__remove_wpml_generator', 0 );


// --- jQuery ---

/**
 * move jQuery to footer
 */
function stilpress__jquery_move_footer() {
	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
	wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
}

add_action( 'wp_enqueue_scripts', 'stilpress__jquery_move_footer' );


/**
 * remove jQuery migrate
 */
function stilpress__jquery_migrate_remove( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$script = $scripts->registered['jquery'];
		if ( $script->deps ) {
			$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
		}
	}
}

add_action( 'wp_default_scripts', 'stilpress__jquery_migrate_remove' );


// --- Media ---

// unregister specific predefined image sizes
function stilpress__filter_image_sizes( $sizes ) {

	unset( $sizes['medium_large'] );
	unset( $sizes['1536x1536'] );
	unset( $sizes['2048x2048'] );

	return $sizes;
}

add_filter( 'intermediate_image_sizes_advanced', 'stilpress__filter_image_sizes' );


// set theme settings on theme activation
function stilpress__set_media_options() {

	// set height and width of predefined image sizes to 0
	update_option( 'medium_size_h', 0 );
	update_option( 'medium_size_w', 0 );

	update_option( 'large_size_h', 0 );
	update_option( 'large_size_w', 0 );

	// deactivate year and month based folder structure
	update_option( 'uploads_use_yearmonth_folders', 0 );
}

add_action( 'after_switch_theme', 'stilpress__set_media_options' );


// adjust mime types
// - allow svg on upload
function stilpress__adjust_mime_types( $mime_types ) {

	// add svg mime type
	$mime_types['svg']  = 'image/svg+xml';
	$mime_types['svgz'] = 'image/svg+xml';

	return $mime_types;
}

add_filter( 'upload_mimes', 'stilpress__adjust_mime_types', 10, 1 );


// --- Block Patterns ---

// remove admin menu entry Theme -> Patterns
add_action( 'admin_menu', function () {
	remove_submenu_page( 'themes.php', 'site-editor.php?path=/patterns' );
}, 999 );
