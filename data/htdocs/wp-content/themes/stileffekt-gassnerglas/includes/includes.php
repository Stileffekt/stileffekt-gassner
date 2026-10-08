<?php

// block configuration – must be defined before ACF integration loads
$block_config = [
	// content blocks (b-*)
	'blocks'  => [
		'b-anchor-navigation',
		'b-content-boxes',
		'b-countdown',
		'b-counter',
		'b-cta',
		'b-customers',
		'b-downloads',
		'b-downloads-accordion',
		'b-employees',
		'b-employees-slider',
		'b-faqs',
		'b-form',
		'b-guide',
		'b-hero',
		'b-history',
		'b-icon-list',
		'b-iframe',
		'b-image',
		'b-image-boxes',
		'b-image-gallery',
		'b-image-slider',
		'b-infobox',
		'b-jobs',
		'b-link',
		'b-logo-slider',
		'b-page-links',
		'b-page-title',
		'b-prices',
		'b-posts',
		'b-products',
		'b-quote',
		'b-quotes-slider',
		'b-references',
		'b-number-list-image',
		'b-text',
		'b-text-image',
		'b-video',
	],

	// widget blocks (w-*)
	'widgets' => [
		'w-logo',
		'w-logos',
		'w-navigation',
		'w-contact-information',
		'w-social-media',
		'w-text',
	],
];

// integrations
$integrations = [
	'acf',
	'cf7',
	'yoast',
	'wpml',
];
foreach ( $integrations as $integration ) {
	require_once get_theme_file_path( '/includes/integrations/' . $integration . '/' . $integration . '.php' );
}

// helper functions
require_once get_theme_file_path( '/includes/helpers.php' );

// shortcodes
require_once get_theme_file_path( '/includes/shortcodes.php' );

// navigation walkers
$walkers = [
	'main',
	'footer',
];

foreach ( $walkers as $walker ) {
	require_once get_theme_file_path( '/includes/walkers/' . $walker . '.php' );
}


// post types
$posttypes = [
//	'downloads',
//	'employees',
//	'accommodations',
//	'customers',
//	'faqs',
//	'jobs',
//	'prices',
//	'quotes',
//	'references',
//	'seminars',
];

foreach ( $posttypes as $posttype ) {
	require_once get_theme_file_path( '/includes/post-types/' . $posttype . '.php' );
}

// cleanup
require_once get_theme_file_path( '/includes/cleanup.php' );

// blocks
require_once get_theme_file_path( '/includes/blocks/blocks-helper.php' );
require_once get_theme_file_path( '/includes/blocks/blocks.php' );

// image sizes – breakpoint-based for responsive srcset
// Each size corresponds to breakpoint upper-bound at 100vw
// Run `wp media regenerate --yes` after changes
$image_config = [
	'image-xs'  => [ 'width' => 576, 'height' => 0, 'crop' => false ],  // xs → sm
	'image-sm'  => [ 'width' => 768, 'height' => 0, 'crop' => false ],  // sm → md
	'image-md'  => [ 'width' => 1024, 'height' => 0, 'crop' => false ],  // md → lg
	'image-lg'  => [ 'width' => 1280, 'height' => 0, 'crop' => false ],  // lg → xl
	'image-xl'  => [ 'width' => 1440, 'height' => 0, 'crop' => false ],  // xl → xxl
	'image-xxl' => [ 'width' => 1664, 'height' => 0, 'crop' => false ],  // max container
];

// debug
require_once get_theme_file_path( '/includes/debug.php' );
