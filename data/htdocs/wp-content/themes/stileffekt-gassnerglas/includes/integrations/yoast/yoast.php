<?php

// only run if Yoast SEO is active
if ( ! defined( 'WPSEO_VERSION' ) ) {
	return;
}

// replace seperator icon
add_filter( 'wpseo_breadcrumb_separator', function ( $separator ): string {

	$separator = '/';

	return '<li class="c-breadcrumb__seperator" aria-hidden="true">' . $separator . '</li>';

} );

// replace first item with home icon
add_filter( 'wpseo_breadcrumb_links', function ( $links ) {

	if ( ! empty( $links[0] ) ) {
		$icon             = stilpress__return_icon( 'House--Streamline-Ultimate' );
		$links[0]['text'] = $icon;
	}

	return $links;

} );


// Convert the Yoast Breadcrumbs output wrapper into an ordered list.
add_filter( 'wpseo_breadcrumb_output_wrapper', function () {
	return 'ol';
} );

// Convert the Yoast Breadcrumbs single items into list items.
add_filter( 'wpseo_breadcrumb_single_link_wrapper', function () {
	return 'li';
} );


function remove_current_page( $link ): string {

	if ( strpos( $link, 'breadcrumb_last' ) !== false ) {
		$link = str_replace( 'breadcrumb_last', 'c-breadcrumb__last', $link );
	}

	return $link;
}

add_filter( 'wpseo_breadcrumb_single_link', 'remove_current_page' );
