<?php
/**
 * Main Navigation Walker
 *
 * Renders the primary navigation with multi-level submenus, disclosure pattern
 * (WAI-ARIA), BEM class names, and ACF field support.
 *
 * @package Stilpress
 * @since   2.0.0
 */

declare( strict_types=1 );

class Stilpress_Walker_Main extends Walker_Nav_Menu {

	/**
	 * Whether the next submenu should render a back button.
	 *
	 * @var bool
	 */
	private bool $show_back_button = false;

	/**
	 * Whether the current parent item is a mega menu.
	 *
	 * @var bool
	 */
	private bool $parent_is_megamenu = false;

	/**
	 * ID of the current parent item (for submenu aria-controls linking).
	 *
	 * @var int
	 */
	private int $current_parent_id = 0;

	/**
	 * Starts the element output.
	 *
	 * @param string   $output            Used to append additional content (passed by reference).
	 * @param WP_Post  $data_object       Menu item data object.
	 * @param int      $depth             Depth of menu item.
	 * @param stdClass $args              An object of wp_nav_menu() arguments.
	 * @param int      $current_object_id Current item ID.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 ): void {
		$item = $data_object;

		// --- ACF fields -----------------------------------------------------------
		$item_style = '';
		$item_icon  = '';
		$item_type  = '';

		if ( function_exists( 'get_field' ) ) {
			$item_style = (string) get_field( 'item_style', $item->ID );
			$item_icon  = (string) get_field( 'item_icon', $item->ID );
			$item_type  = (string) get_field( 'item_type', $item->ID );
		}

		$has_children = in_array( 'menu-item-has-children', $item->classes, true );
		$is_button    = 'button' === $item_style;
		$is_mega      = 'mega' === $item_type && $has_children && 0 === $depth;

		// Track state for start_lvl().
		if ( $has_children ) {
			$this->current_parent_id = $item->ID;
		}
		if ( $is_mega ) {
			$this->parent_is_megamenu = true;
		}

		// --- BEM classes on <li> --------------------------------------------------
		$classes = [ 'c-navigation__item' ];

		if ( $item->current ) {
			$classes[] = 'c-navigation__item--active';
		}
		if ( $item->current_item_ancestor ) {
			$classes[] = 'c-navigation__item--ancestor';
		}
		if ( $has_children ) {
			$classes[] = 'c-navigation__item--has-children';
		}
		if ( $is_mega ) {
			$classes[] = 'c-navigation__item--mega';
		}
		if ( $is_button ) {
			$classes[] = 'c-navigation__item--button';
		}

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$classes    = apply_filters( 'nav_menu_css_class', $classes, $item, $args, $depth );
		$li_classes = implode( ' ', array_filter( $classes ) );

		// --- Back button (rendered before <li> inside the submenu) ----------------
		$back = '';
		if ( $this->show_back_button ) {
			$back_icon = function_exists( 'stilpress__return_icon' )
				? stilpress__return_icon( 'Arrow-Down-1--Streamline-Ultimate' )
				: '';

			$back = sprintf(
				'<li class="c-navigation__back"><button type="button">%s<span>%s</span></button></li>',
				$back_icon,
				esc_html__( 'Back', 'stilpress' ),
			);

			$this->show_back_button = false;
		}

		// --- Build link / button markup ------------------------------------------
		$icon_markup = '';
		if ( ! empty( $item_icon ) && function_exists( 'stilpress__return_icon' ) ) {
			$icon_markup = stilpress__return_icon( $item_icon );
		}

		if ( $has_children && empty( $item->url ) ) {
			// No URL → single toggle button acts as both label and disclosure trigger.
			$link_markup   = '';
			$toggle_markup = $this->build_toggle( $item, $icon_markup, esc_html( $item->title ) );
		} else {
			$link_markup   = $this->build_link( $item, $args, $depth, $is_button, $icon_markup );
			$toggle_markup = $has_children ? $this->build_toggle( $item ) : '';
		}

		$output .= $back;
		$output .= "<li class=\"{$li_classes}\">";
		$output .= $link_markup;
		$output .= $toggle_markup;
	}

	/**
	 * Ends the element output.
	 *
	 * @param string   $output      Used to append additional content (passed by reference).
	 * @param WP_Post  $data_object Menu item data object.
	 * @param int      $depth       Depth of menu item.
	 * @param stdClass $args        An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = [] ): void {
		$output .= '</li>';
	}

	/**
	 * Starts the list before the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ): void {
		$this->show_back_button = true;

		$classes = [ 'c-navigation__submenu' ];

		if ( $this->parent_is_megamenu ) {
			$classes[]                = 'c-navigation__submenu--mega';
			$this->parent_is_megamenu = false;
		}

		$class_attr = implode( ' ', $classes );
		$id_attr    = $this->current_parent_id ? ' id="submenu-' . esc_attr( (string) $this->current_parent_id ) . '"' : '';

		$output .= "<ul class=\"{$class_attr}\"{$id_attr}>";
	}

	/**
	 * Ends the list after the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ): void {
		$output .= '</ul>';
	}

	// -------------------------------------------------------------------------
	// Private helpers
	// -------------------------------------------------------------------------

	/**
	 * Build the anchor (or button for items without URL) markup.
	 *
	 * @param WP_Post  $item        Menu item.
	 * @param stdClass $args        wp_nav_menu() arguments.
	 * @param int      $depth       Depth.
	 * @param bool     $is_button   Whether item is styled as a CTA button.
	 * @param string   $icon_markup Pre-rendered icon HTML.
	 * @return string HTML.
	 */
	private function build_link( WP_Post $item, $args, int $depth, bool $is_button, string $icon_markup ): string {
		$title   = esc_html( $item->title );
		$new_tab = '';

		if ( '_blank' === $item->target ) {
			$new_tab = '<span class="screen-reader-text">' . esc_html__( '(opens in a new tab)', 'stilpress' ) . '</span>';
		}

		if ( empty( $item->url ) ) {
			$class = $is_button ? 'c-button' : 'c-navigation__link';
			return "<button class=\"{$class}\">{$icon_markup}<span>{$title}</span></button>";
		}

		$attributes = $this->build_link_attributes( $item, $args, $depth, $is_button );

		return "<a{$attributes}>{$icon_markup}<span>{$title}</span>{$new_tab}</a>";
	}

	/**
	 * Build link attributes string.
	 *
	 * @param WP_Post  $item      Menu item.
	 * @param stdClass $args      wp_nav_menu() arguments.
	 * @param int      $depth     Depth.
	 * @param bool     $is_button Whether item is styled as a CTA button.
	 * @return string Attributes HTML.
	 */
	private function build_link_attributes( WP_Post $item, $args, int $depth, bool $is_button ): string {
		$atts = [
			'href'  => esc_url( $item->url ),
			'class' => $is_button ? 'c-button' : 'c-navigation__link',
		];

		// Accessibility: mark current page.
		if ( $item->current ) {
			$atts['aria-current'] = 'page';
		}

		// External links.
		if ( '_blank' === $item->target ) {
			$atts['target'] = '_blank';
			$atts['rel']    = 'noopener noreferrer';
		} elseif ( ! empty( $item->xfn ) ) {
			$atts['rel'] = $item->xfn;
		}

		// Optional title attribute.
		if ( ! empty( $item->attr_title ) ) {
			$atts['title'] = esc_attr( $item->attr_title );
		}

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		return $this->attributes_to_string( $atts );
	}

	/**
	 * Build the disclosure toggle button for items with children.
	 *
	 * @param WP_Post $item Menu item.
	 * @return string HTML.
	 */
	private function build_toggle( WP_Post $item, string $icon_markup = '', string $title = '' ): string {
		$dropdown_icon = function_exists( 'stilpress__return_icon' )
			? stilpress__return_icon( 'Arrow-Down-1--Streamline-Ultimate' )
			: '';

		$submenu_id = 'submenu-' . $item->ID;

		$label = sprintf(
			/* translators: %s: menu item title */
			esc_attr__( 'Submenu for %s', 'stilpress' ),
			esc_attr( $item->title ),
		);

		// Title set → combined label + disclosure button (for items without URL).
		if ( ! empty( $title ) ) {
			return sprintf(
				'<button class="c-navigation__toggle" aria-expanded="false" aria-controls="%s">%s<span>%s</span>%s</button>',
				esc_attr( $submenu_id ),
				$icon_markup,
				$title,
				$dropdown_icon,
			);
		}

		// Icon-only toggle (for items with their own link).
		return sprintf(
			'<button class="c-navigation__toggle" aria-expanded="false" aria-controls="%s" aria-label="%s">%s</button>',
			esc_attr( $submenu_id ),
			$label,
			$dropdown_icon,
		);
	}

	/**
	 * Convert associative array to HTML attributes string.
	 *
	 * @param array<string, string> $atts Attributes.
	 * @return string HTML attributes.
	 */
	private function attributes_to_string( array $atts ): string {
		$html = '';

		foreach ( $atts as $key => $value ) {
			if ( '' !== $value ) {
				$html .= ' ' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
			}
		}

		return $html;
	}
}
