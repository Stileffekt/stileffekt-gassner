<?php

/**
 * return logo from theme settings
 *
 */
function stilpress__return_logo( string $position ): string {

	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$logo = get_field( 'logo_' . $position, 'option' );

	if ( empty( $logo ) ) {
		return '';
	}

	if ( is_home() || is_front_page() ) {
		$output = '<span class="logo-' . $position . '"><img src="' . esc_url( $logo['url'] ) . '" alt="' . get_bloginfo( 'name' ) . '" width="' . $logo['width'] . '" height="' . $logo['height'] . '"></span>' . "\r";
	} else {
		$output = '<a class="logo-' . $position . '" href="' . get_bloginfo( 'url' ) . '"><img src="' . esc_url( $logo['url'] ) . '" alt="' . get_bloginfo( 'name' ) . '" width="' . $logo['width'] . '" height="' . $logo['height'] . '"></a>' . "\r";
	}

	return $output;
}


/**
 * return slogan from theme settings
 *
 */
function stilpress__return_slogan(): string {

	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$slogan = get_field( 'slogan', 'option' );

	if ( empty( $slogan ) ) {
		return '';
	}

	return $slogan;
}


/**
 * return copyright
 *
 * @return string
 */

function stilpress__get_copyright(): string {

	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$copyright = get_field( 'copyright', 'option' );

	if ( empty( $copyright ) ) {
		return '';
	}

	return do_shortcode( $copyright );
}

function stilpress__adjust_body_classes( $classes ): array {

	$queried_object_id = get_queried_object_id();

	if ( isset( $queried_object_id ) ) {
		$post_type = get_post_type( $queried_object_id );
		if ( isset( $post_type ) ) {
			if ( function_exists( 'get_field' ) ) {
				$classes[] = 'body';
			}
		}
	}

	return $classes;
}

add_filter( 'body_class', 'stilpress__adjust_body_classes' );


function stilpress__return_icon( $name = '' ): string {

	if ( empty( $name ) ) {
		return '';
	}

	$uploads_url = wp_upload_dir();
	$file        = $uploads_url['basedir'] . '/' . $name . '.svg';

	if ( file_exists( $file ) ) {
		$svg = file_get_contents( $file );
	} else {
		$file = get_template_directory() . '/assets/images/icons/regular/' . $name . '.svg';

		if ( file_exists( $file ) ) {
			$svg = file_get_contents( $file );
		} else {
			return '';
		}
	}

	return '<span class="c-icon">' . $svg . '</span>';
}


function stilpress__breadcrumb(): void {

	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<nav class="c-breadcrumb" id="breadcrumbs" aria-label="' . __( 'Breadcrumb navigation', 'stilpress' ) . '">', '</nav>' );
	}

	return;
}


// Add custom post type and taxonomy capabilities to administrator role
function stilpress__add_posttype_and_taxonomy_capabilities( string $singular, string $plural, ?string $taxonomy_slug = null ): void {

	$admin = get_role( 'administrator' );

	if ( ! $admin ) {
		return;
	}

	// Post Type Capabilities
	$posttype_caps = [
		"edit_{$singular}",
		"read_{$singular}",
		"delete_{$singular}",
		"edit_{$plural}",
		"edit_others_{$plural}",
		"publish_{$plural}",
		"read_private_{$plural}",
		"delete_{$plural}",
		"delete_others_{$plural}",
		"delete_private_{$plural}",
		"delete_published_{$plural}",
		"edit_private_{$plural}",
		"edit_published_{$plural}",
	];

	foreach ( $posttype_caps as $cap ) {
		$admin->add_cap( $cap );
	}

	// Taxonomy Capabilities (optional)
	if ( $taxonomy_slug ) {
		$taxonomy_caps = [
			"manage_{$taxonomy_slug}",
			"edit_{$taxonomy_slug}",
			"delete_{$taxonomy_slug}",
			"assign_{$taxonomy_slug}",
		];

		foreach ( $taxonomy_caps as $cap ) {
			$admin->add_cap( $cap );
		}
	}
}


function stilpress__header_cta(): string {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$button = get_field( 'button_1', 'option' );

	if ( empty( $button ) ) {
		return '';
	}

	return '<a href="' . $button['url'] . '" class="c-button" target="' . $button['target'] . '"><span>' . $button['title'] . '</span><span class="c-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" version="1.1">
  <path d="M12.488567999999999 0.792504C12.326496 0.8567520000000001 12.157464 1.008168 12.077088 1.161048C12.020808 1.268088 12.012432 1.31196 12.012384 1.5C12.01236 1.6795200000000001 12.021816 1.7342400000000002 12.068352 1.824C12.107928000000001 1.900296 13.488696000000001 3.296976 16.77216 6.582L21.419952000000002 11.232000000000001 11.098392 11.232000000000001C3.7457520000000004 11.232000000000001 0.7360800000000001 11.239536000000001 0.6351600000000001 11.258184C0.448824 11.292624 0.343536 11.348832 0.20820000000000002 11.486088C-0.070848 11.769143999999999 -0.070848 12.230856000000001 0.20820000000000002 12.513912000000001C0.343536 12.651167999999998 0.448824 12.707376000000002 0.6351600000000001 12.741816C0.7360800000000001 12.760464 3.7457520000000004 12.768 11.098392 12.768L21.419952000000002 12.768 16.77216 17.418C13.488696000000001 20.703024 12.107928000000001 22.099704000000003 12.068352 22.176000000000002C12.021816 22.26576 12.01236 22.32048 12.012384 22.5C12.012432 22.68804 12.020808 22.731912 12.077088 22.838952000000003C12.160248000000001 22.997136 12.328920000000002 23.144808 12.500471999999998 23.209584C12.672192 23.274432 12.90036 23.26428 13.071432000000001 23.184216C13.165752 23.140056 14.210016 22.107456 18.541968 17.774808C23.028024 13.288056 23.902824000000003 12.402503999999999 23.93844 12.312C23.961816 12.2526 23.990616000000003 12.185256 24.002472 12.162336C24.030264 12.108528 24.030672000000003 11.80104 24.002928 11.818200000000001C23.991336 11.825352 23.975832 11.801688 23.968488 11.765616C23.961144 11.72952 23.922504 11.6514 23.882640000000002 11.592C23.842776 11.5326 21.420168 9.095952 18.49908 6.17724C14.188368 1.870056 13.165872 0.860136 13.07052 0.815424C12.903863999999999 0.7373040000000001 12.652752 0.7274160000000001 12.488567999999999 0.792504M0.008064 12C0.008064 12.099 0.012312 12.139512 0.017472 12.09C0.022656 12.040512 0.022656 11.959512 0.017472 11.91C0.012312 11.860512 0.008064 11.901 0.008064 12" stroke="none" fill="#000000" fill-rule="evenodd" stroke-width="0.024"></path>
</svg></span></a>';
}

