<?php

// shortcode shy
if ( ! function_exists( 'stilpress__sc_shy' ) ) {
	function stilpress__sc_shy( $atts ) {
		return '&shy;';
	}

	add_shortcode( 'shy', 'stilpress__sc_shy' );
}


// shortcode year
if ( ! function_exists( 'stilpress__sc_year' ) ) {
	function stilpress__sc_year( $atts ) {
		return date( 'Y' );
	}

	add_shortcode( 'year', 'stilpress__sc_year' );
}


// shortcode tooltip
function stilpress__sc_tooltip( $atts, $content = null ) {

	static $tooltip_id = 0;
	$tooltip_id ++;

	$id = 'tooltip-' . $tooltip_id;

	$atts = shortcode_atts(
		array(
			'explanation' => '',
		),
		$atts,
		'tooltip'
	);

	$icon = stilpress__return_icon( 'Information-Circle-Streamline-Ultimate' );

	return '<span class="c-tooltip" aria-describedby="' . esc_attr( $id ) . '" tabindex="0" data-explanation="' . esc_attr( $atts['explanation'] ) . '" data-width="' . esc_attr( $atts['width'] ) . '">' . esc_html( $content ) . $icon . '</span>
    <span id="' . esc_attr( $id ) . '" role="tooltip" hidden aria-hidden="true">' . esc_html( $atts['explanation'] ) . '</span>';
}

add_shortcode( 'tooltip', 'stilpress__sc_tooltip' );
