<?php
/**
 * Footer Navigation Walker
 *
 * Renders a flat, single-level navigation for the footer area.
 * Features: No submenus, optional separators, minimal markup, accessible.
 *
 * @package Stilpress
 * @since 2.0.0
 */

declare( strict_types=1 );

class Stilpress_Walker_Footer extends Walker_Nav_Menu {

	/**
	 * Separator between items (plain string or icon name for stilpress__return_icon).
	 *
	 * @var string
	 */
	private string $separator;

	/**
	 * Tracks first item to avoid leading separator.
	 *
	 * @var bool
	 */
	private bool $is_first_item = true;

	/**
	 * Constructor.
	 *
	 * @param string $separator Optional. Plain text ('|', '/') or icon name. Default empty.
	 */
	public function __construct( string $separator = '' ) {
		$this->separator = $separator;
	}

	/**
	 * Starts the element output.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ): void {
		// Only render top-level items.
		if ( $depth > 0 ) {
			return;
		}

		// Add separator before item (except first).
		$output .= $this->maybe_render_separator();

		// Build item with BEM classes.
		$classes   = [ 'c-navigation__item' ];
		if ( $item->current ) {
			$classes[] = 'c-navigation__item--active';
		}

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$classes    = apply_filters( 'nav_menu_css_class', $classes, $item, $args, $depth );
		$li_classes = implode( ' ', array_filter( $classes ) );

		$link_markup = $this->build_link( $item, $args, $depth );

		$output .= "<li class=\"{$li_classes}\">{$link_markup}";
	}

	/**
	 * Ends the element output.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ): void {
		if ( $depth > 0 ) {
			return;
		}
		$output .= '</li>';
	}

	/**
	 * Starts the list before the elements are added - disabled for flat nav.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ): void {
		// Intentionally empty - no submenus.
	}

	/**
	 * Ends the list after the elements are added - disabled for flat nav.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ): void {
		// Intentionally empty - no submenus.
	}

	/**
	 * Reset state when walk() is called (for reusability).
	 *
	 * @param array $elements  Menu items.
	 * @param int   $max_depth Maximum depth.
	 * @param mixed ...$args   Additional arguments.
	 * @return string The output.
	 */
	public function walk( $elements, $max_depth, ...$args ): string {
		$this->is_first_item = true;
		return parent::walk( $elements, $max_depth, ...$args );
	}

	/**
	 * Render separator if needed.
	 *
	 * @return string Separator markup or empty string.
	 */
	private function maybe_render_separator(): string {
		if ( $this->is_first_item ) {
			$this->is_first_item = false;
			return '';
		}

		if ( empty( $this->separator ) ) {
			return '';
		}

		$separator_content = $this->resolve_separator();

		return '<li class="c-navigation__separator" aria-hidden="true">' . $separator_content . '</li>';
	}

	/**
	 * Resolve separator: try icon first, fallback to escaped string.
	 *
	 * @return string Separator HTML.
	 */
	private function resolve_separator(): string {
		if ( function_exists( 'stilpress__return_icon' ) ) {
			$icon = stilpress__return_icon( $this->separator );
			if ( ! empty( $icon ) ) {
				return $icon;
			}
		}

		return esc_html( $this->separator );
	}

	/**
	 * Build the anchor element.
	 *
	 * @param WP_Post $item Menu item.
	 * @return string Anchor HTML.
	 */
	private function build_link( WP_Post $item, $args = null, int $depth = 0 ): string {
		$attributes = $this->build_link_attributes( $item, $args, $depth );
		$title      = esc_html( $item->title );
		$new_tab    = '';

		if ( '_blank' === $item->target ) {
			$new_tab = '<span class="screen-reader-text">' . esc_html__( '(opens in a new tab)', 'stilpress' ) . '</span>';
		}

		return "<a class=\"c-navigation__link\"{$attributes}>{$title}{$new_tab}</a>";
	}

	/**
	 * Build link attributes string.
	 *
	 * @param WP_Post $item Menu item.
	 * @return string Attributes HTML.
	 */
	private function build_link_attributes( WP_Post $item, $args = null, int $depth = 0 ): string {
		$atts = [
			'href' => esc_url( $item->url ),
		];

		// Accessibility: mark current page.
		if ( $item->current ) {
			$atts['aria-current'] = 'page';
		}

		// External links: security attributes.
		if ( '_blank' === $item->target ) {
			$atts['target'] = '_blank';
			$atts['rel']    = 'noopener noreferrer';
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
