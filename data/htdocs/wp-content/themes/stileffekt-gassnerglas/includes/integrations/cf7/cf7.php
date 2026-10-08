<?php

// only run if Contact Form 7 is active
if ( ! defined( 'WPCF7_VERSION' ) ) {
	return;
}

//
// filter cf7 output
//
function stilpress_cf7_output( $content ) {
	$content = preg_replace( '/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content );
	$content = str_replace( '<br />', '', $content );


	return $content;
}

add_filter( 'wpcf7_form_elements', 'stilpress_cf7_output' );

// deactivate auto paragraphs
add_filter( 'wpcf7_autop_or_not', '__return_false' );

// remove cf7 styles
add_filter( 'wpcf7_load_css', '__return_false' );


add_filter( 'shortcode_atts_wpcf7', 'custom_shortcode_atts_wpcf7_filter', 10, 3 );


function custom_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
	$my_attr = 'file';

	if ( isset( $atts[ $my_attr ] ) ) {
		$out[ $my_attr ] = $atts[ $my_attr ];
	}

	return $out;
}