<?php
/**
 * WPML Integration
 *
 * @package Stilpress
 */

// only run if WPML is active
if ( ! defined( 'ICL_SITEPRESS_VERSION' ) ) {
	return;
}

/**
 * Language switcher with two display variants
 *
 * @param array $args {
 *     Optional. Configuration options.
 *
 * @type string $variant Display variant: 'dropdown' or 'inline'. Default 'dropdown'.
 * @type string $separator Separator for inline variant. Default '|'.
 * @type string $display What to show: 'code' (DE), 'name' (Deutsch), 'native' (Deutsch). Default 'code'.
 * @type bool $show_current Show current language in inline variant. Default true.
 * @type string $id Unique ID for dropdown menu (required if multiple on page). Default 'lang-menu'.
 * }
 */
function stilpress__language_switcher_wpml( array $args = [] ): void {

	$languages = apply_filters( 'wpml_active_languages', null, [
		'skip_missing' => 0,
		'orderby'      => 'code',
	] );

	if ( empty( $languages ) || ! is_array( $languages ) ) {
		return;
	}

	$defaults = [
		'variant'      => 'inline',
		'separator'    => '|',
		'display'      => 'code',
		'show_current' => true,
		'id'           => 'lang-menu',
	];
	$args     = wp_parse_args( $args, $defaults );

	$active_language = null;
	foreach ( $languages as $l ) {
		if ( $l['active'] ) {
			$active_language = $l;
			break;
		}
	}

	if ( 'dropdown' === $args['variant'] ) {
		stilpress__language_switcher_dropdown( $languages, $active_language, $args );
	} else {
		stilpress__language_switcher_inline( $languages, $active_language, $args );
	}
}

/**
 * Get display text for a language
 */
function stilpress__language_switcher_get_display( array $language, string $display ): string {
	switch ( $display ) {
		case 'name':
			return $language['translated_name'] ?? strtoupper( $language['code'] );
		case 'native':
			return $language['native_name'] ?? strtoupper( $language['code'] );
		case 'code':
		default:
			return strtoupper( $language['code'] );
	}
}

/**
 * Dropdown variant - Button with expandable menu
 *
 * WCAG: Uses aria-expanded, aria-controls, role="menu", role="menuitem"
 * Requires JavaScript for toggle functionality
 */
function stilpress__language_switcher_dropdown( array $languages, ?array $active_language, array $args ): void {
	$menu_id = esc_attr( $args['id'] );

	echo '<div class="c-lang-switcher c-lang-switcher--dropdown">';

	if ( $active_language ) {
		$icon            = stilpress__return_icon( 'chevron-down' );
		$current_display = stilpress__language_switcher_get_display( $active_language, $args['display'] );

		echo '<button class="c-lang-switcher__toggle" type="button" aria-expanded="false" aria-controls="' . $menu_id . '" aria-label="' . esc_attr__( 'Sprache wechseln', 'stileffekt' ) . '">';
		echo '<span class="c-lang-switcher__current">' . esc_html( $current_display ) . '</span>';
		echo '<span class="c-lang-switcher__icon" aria-hidden="true">' . $icon . '</span>';
		echo '</button>';
	}

	echo '<ul class="c-lang-switcher__menu" id="' . $menu_id . '" role="menu" hidden>';

	foreach ( $languages as $item ) {
		$item_class   = 'c-lang-switcher__item';
		$link_class   = 'c-lang-switcher__link';
		$display_text = stilpress__language_switcher_get_display( $item, 'native' );

		if ( $item['active'] ) {
			$link_class .= ' c-lang-switcher__link--active';
		}

		echo '<li class="' . esc_attr( $item_class ) . '" role="none">';

		if ( ! $item['active'] ) {
			echo '<a class="' . esc_attr( $link_class ) . '" href="' . esc_url( $item['url'] ) . '" role="menuitem" lang="' . esc_attr( $item['language_code'] ) . '" hreflang="' . esc_attr( $item['language_code'] ) . '">';
			echo esc_html( $display_text );
			echo '</a>';
		} else {
			echo '<span class="' . esc_attr( $link_class ) . '" role="menuitem" aria-current="true">';
			echo esc_html( $display_text );
			echo '</span>';
		}

		echo '</li>';
	}

	echo '</ul>';
	echo '</div>';
}

/**
 * Inline variant - Horizontal list with separator
 *
 * WCAG: Uses nav landmark, aria-label, lang/hreflang attributes
 */
function stilpress__language_switcher_inline( array $languages, ?array $active_language, array $args ): void {
	$separator    = $args['separator'];
	$show_current = $args['show_current'];

	// Filter languages if not showing current
	if ( ! $show_current ) {
		$languages = array_filter( $languages, function ( $l ) {
			return ! $l['active'];
		} );
	}

	if ( empty( $languages ) ) {
		return;
	}

	echo '<nav class="c-lang-switcher c-lang-switcher--inline" aria-label="' . esc_attr__( 'Sprache wählen', 'stileffekt' ) . '">';
	echo '<ul class="c-lang-switcher__list">';

	$i     = 0;
	$total = count( $languages );

	foreach ( $languages as $item ) {
		$link_class   = 'c-lang-switcher__link';
		$display_text = stilpress__language_switcher_get_display( $item, $args['display'] );

		if ( $item['active'] ) {
			$link_class .= ' c-lang-switcher__link--active';
		}

		echo '<li class="c-lang-switcher__item">';

		if ( ! $item['active'] ) {
			echo '<a class="' . esc_attr( $link_class ) . '" href="' . esc_url( $item['url'] ) . '" lang="' . esc_attr( $item['language_code'] ) . '" hreflang="' . esc_attr( $item['language_code'] ) . '">';
			echo esc_html( $display_text );
			echo '</a>';
		} else {
			echo '<span class="' . esc_attr( $link_class ) . '" aria-current="page">';
			echo esc_html( $display_text );
			echo '</span>';
		}

		echo '</li>';

		// Add separator between items (not after last)
		if ( $separator && ++ $i < $total ) {
			echo '<li class="c-lang-switcher__separator" aria-hidden="true">';
			echo '<span>' . esc_html( $separator ) . '</span>';
			echo '</li>';
		}
	}

	echo '</ul>';
	echo '</nav>';
}
