<?php

class Stilpress_Block_Helper {

	protected array $block;
	protected array $raw_data = [];

	function __construct( array $block ) {

		if ( empty( $block ) ) {
			return;
		}

		$this->block = $block;

		$fields = get_fields();
		if ( $fields ) {
			$this->raw_data = $this->return_raw_data_with_semantic_aliases( $fields );
		}
	}

	protected function return_raw_data_with_semantic_aliases( array $raw_data, string $parent_repeater_name = '' ): array {
		$data = [];

		foreach ( $raw_data as $field_name => $field_value ) {
			$semantic_field_name = is_string( $field_name )
				? $this->return_semantic_field_name( $field_name, $parent_repeater_name )
				: $field_name;

			if ( is_array( $field_value ) ) {
				$child_parent_repeater_name = is_string( $semantic_field_name )
					? $semantic_field_name
					: $parent_repeater_name;

				$field_value = $this->return_raw_data_with_semantic_aliases( $field_value, $child_parent_repeater_name );
			}

			$data[ $field_name ] = $field_value;

			if ( $semantic_field_name !== $field_name && ! array_key_exists( $semantic_field_name, $data ) ) {
				$data[ $semantic_field_name ] = $field_value;
			}
		}

		return $data;
	}

	protected function return_semantic_field_name( string $field_name, string $parent_repeater_name = '' ): string {
		$prefix = $this->return_name() . '__';

		if ( ! str_starts_with( $field_name, $prefix ) ) {
			return $field_name;
		}

		$field_name = substr( $field_name, strlen( $prefix ) );

		if ( empty( $parent_repeater_name ) ) {
			return $field_name;
		}

		$repeater_item_prefix = $this->return_repeater_singular_name( $parent_repeater_name ) . '_';
		if ( str_starts_with( $field_name, $repeater_item_prefix ) ) {
			return substr( $field_name, strlen( $repeater_item_prefix ) );
		}

		return $field_name;
	}

	protected function return_name(): string {
		return str_replace( 'stilpress/', '',
			$this->block['name']
		);
	}

	protected function return_repeater_singular_name( string $name ): string {
		if ( str_ends_with( $name, 'ies' ) ) {
			return substr( $name, 0, - 3 ) . 'y';
		}

		if ( str_ends_with( $name, 's' ) ) {
			return substr( $name, 0, - 1 );
		}

		return $name;
	}

	/**
	 * return url to block folder
	 *
	 * @return string
	 */
	public function return_url(): string {
		return get_stylesheet_directory_uri() . '/' . $this->return_name() . '/';
	}

	/**
	 * return block id
	 *
	 * @return string
	 */
	public function return_id(): string {

		$id = $this->block['id'] . '-' . str_replace( '_', '-',
				$this->return_name() );
		if ( ! empty( $this->block['anchor'] ) ) {
			$id = $this->block['anchor'];
		}

		return $id;
	}

	/**
	 * return classes
	 *
	 * @return string
	 */
	public function return_classes(): string {

		$classes = $this->return_type() . ' ' . str_replace( '_', '-', $this->return_name() );

		if ( ! empty( $this->block['className'] ) ) {
			$classes .= ' ' . $this->block['className'];
		}
		$style = $this->return_raw_data_value( 'style' );
		if ( ! empty( $style ) ) {
			$classes .= ' style-' . $style;
		}
		$alignment = $this->return_raw_data_value( 'alignment' );
		if ( ! empty( $alignment ) ) {
			$classes .= ' alignment-' . $alignment;
		}
		$text_alignment = $this->return_raw_data_value( 'text_alignment' );
		if ( ! empty( $text_alignment ) ) {
			$classes .= ' text-alignment-' . $text_alignment;
		}
		$text_size = $this->return_raw_data_value( 'text_size' );
		if ( ! empty( $text_size ) ) {
			$classes .= ' text-size-' . $text_size;
		}
		$background_color = $this->return_raw_data_value( 'background_color' );
		if ( ! empty( $background_color ) ) {
			$classes .= ' l-background-' . $background_color;
			if ( $background_color != '2' ) {
				$classes .= ' l-padding-top l-padding-bottom';
			}
		}
		$media_position = $this->return_raw_data_value( 'media_position' );
		if ( ! empty( $media_position ) ) {
			$classes .= ' media-position-' . $media_position;
		}

		return $classes;
	}

	protected function return_type(): string {

		$name = str_replace( 'stilpress/', '',
			$this->block['name']
		);

		$type = '';

		if ( str_starts_with( $name, 'w-' ) ) {
			$type = 'w';
		}

		if ( str_starts_with( $name, 'b-' ) ) {
			$type = 'b';
		}

		return $type;
	}

	protected function return_raw_data_value( string $field_name, mixed $default = '' ): mixed {
		if ( array_key_exists( $field_name, $this->raw_data ) ) {
			return $this->raw_data[ $field_name ];
		}

		$namespaced_field_name = $this->return_namespaced_field_name( $field_name );
		if ( array_key_exists( $namespaced_field_name, $this->raw_data ) ) {
			return $this->raw_data[ $namespaced_field_name ];
		}

		return $default;
	}

	protected function return_namespaced_field_name( string $field_name ): string {
		$prefix = $this->return_name() . '__';

		if ( str_starts_with( $field_name, $prefix ) ) {
			return $field_name;
		}

		return $prefix . $field_name;
	}

	public function output( string $field_name, string $field_type, array $field_arguments = [] ): mixed {

		if ( empty( $field_name ) ) {
			return '';
		}

		if ( ! method_exists( $this, 'output_' . $field_type ) ) {
			return '';
		}

		$field_data = $this->return_raw_data_value( $field_name );

		if ( ! empty( $field_arguments['raw'] ) && (bool) $field_arguments['raw'] ) {
			return $field_data;
		}

		$data = [
			'name'      => $field_name,
			'value'     => $field_data,
			'arguments' => $field_arguments
		];

		return call_user_func( array(
			$this,
			'output_' . $field_type
		), $data );

	}

	public function output_raw( string $name ): mixed {
		$field_data = $this->return_raw_data_value( $name );

		if ( empty( $field_data ) ) {
			return '';
		}

		return $field_data;
	}

	protected function output_icon( array $data ): string {
		if ( empty( $data['value'] ) ) {
			return '';
		}

		return stilpress__return_icon( $data['value'] );
	}

	protected function output_headline( array $data ): string {

		$value = $data['value'];

		if ( empty( $value ) && $this->is_editor_preview() ) {
			$value = __( 'Beispielüberschrift', 'stilpress' );
		}

		if ( empty( $value ) ) {
			return '';
		}

		$style         = $classes = '';
		$type          = 'h2';
		$headline_type = ! empty( $data['name'] ) ? $this->return_raw_data_value( $data['name'] . '_type' ) : '';
		if ( ! empty( $headline_type ) ) {
			$type = $headline_type;
		}
		if ( ! empty( $data['arguments']['type'] ) ) {
			$type = $data['arguments']['type'];
		}
		$headline_style = ! empty( $data['name'] ) ? $this->return_raw_data_value( $data['name'] . '_style' ) : '';
		if ( ! empty( $headline_style ) ) {
			$style = ' class="' . $headline_style . '"';
		}
		if ( ! empty( $data['arguments']['style'] ) ) {
			$style = ' class="' . $data['arguments']['style'] . '"';
		}
		if ( ! empty( $data['arguments']['classes'] ) ) {
			$classes = ' ' . $data['arguments']['classes'];
		}
		$tag_before = '<' . $type . $style . '>';
		$tag_after  = '</' . $type . '>';

		return '<div class="c-headline' . $classes . '">' . $tag_before . '<span>' . $value . '</span>' . $tag_after . '</div>';
	}

	protected function is_editor_preview(): bool {
		return (
			       is_admin()
			       && function_exists( 'acf_is_block_editor' )
			       && acf_is_block_editor()
		       ) || doing_action( 'wp_ajax_acf/ajax/fetch-block' );
	}

	protected function output_text( array $data ): string {
		$value = $data['value'];

		if ( empty( $value ) && $this->is_editor_preview() ) {
			$value = '<p>' . __( 'At vero eos et accusam et justo duo dolores et ea rebum. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.', 'stilpress' ) . '</p>';
		}

		if ( empty( $value ) ) {
			return '';
		}

		return '<div class="c-text">' . $value . '</div>';
	}

	protected function output_overline( array $data ): string {

		$value = $data['value'];

		if ( empty( $value ) && $this->is_editor_preview() ) {
			$value = __( 'Beispieloverline', 'stilpress' );
		}

		if ( empty( $value ) ) {
			return '';
		}

		$classes = 'c-overline';

		if ( ! empty( $data['arguments']['classes'] ) ) {
			$classes .= ' ' . $data['arguments']['classes'];
		}

		return '<div class="' . $classes . '"><span>' . $value . '</span></div>';
	}

	protected function output_underline( array $data ): string {

		if ( empty( $data['value'] ) ) {
			return '';
		}

		return '<div class="c-underline">' . $data['value'] . '</div>';
	}

	/**
	 * Output image (legacy version)
	 *
	 * Legacy implementation with manual HTML generation.
	 * Kept for backwards compatibility while testing new version.
	 *
	 * @param array $data Image data array with value, name, and arguments.
	 *
	 * @return string HTML figure element with image
	 * @see output_image_responsive() for new responsive version
	 */
	protected function output_image( array $data ): string {

		if ( empty( $data['value'] ) ) {
			return $this->return_empty_image_preview( $data );
		}

		$image_size = '';
		if ( ! empty( $data['arguments']['image_size'] ) ) {
			$image_size = $data['arguments']['image_size'];
		}

		$image_size = ! empty( $image_size ) ? $image_size : 'full';

		if ( ! empty( $data['value']['sizes'][ $image_size ] ) ) {
			$url    = $data['value']['sizes'][ $image_size ];
			$width  = $data['value']['sizes'][ $image_size . '-width' ];
			$height = $data['value']['sizes'][ $image_size . '-height' ];
		} else {
			$url    = ! empty( $data['value']['url'] ) ? $data['value']['url'] : '';
			$width  = ! empty( $data['value']['width'] ) ? $data['value']['width'] : '';
			$height = ! empty( $data['value']['height'] ) ? $data['value']['height'] : '';
		}

		$alt = ! empty( $data['value']['alt'] ) ? ' alt="' . $data['value']['alt'] . '"' : ' alt=""';

		$overlay = $overlay_icon = '';

		if ( ! empty( $data['arguments']['overlay'] ) ) {

			if ( ! empty( $data['arguments']['overlay_icon'] ) ) {
				$overlay_icon = stilpress__return_icon( $data['arguments']['overlay_icon'] );
			}

			$overlay = '<div class="c-media__overlay">' . $overlay_icon . '</div>';
		}

		$media_classes = $this->return_media_classes( $data );

		return '<figure class="' . $media_classes . '"><img class="c-media__image" src="' . $url . '" width="' . $width . '" height="' . $height . '"' . $alt . '>' . $overlay . '</figure>';
	}

	protected function return_empty_image_preview( array $data ): string {
		if ( ! $this->is_editor_preview() ) {
			return '';
		}

		return '<figure class="' . $this->return_media_classes( $data ) . ' is-preview"></figure>';
	}

	/**
	 * Output responsive image with WordPress native function
	 *
	 * Uses wp_get_attachment_image() for automatic responsive images with
	 * srcset and sizes attributes optimized for PageSpeed Insights.
	 *
	 * Usage with columns (recommended):
	 * $image = $block->output( 'image', 'image_responsive', [
	 *     'columns' => [
	 *         'lg'      => 10,   // Ab 1280px: 10 von 24 Spalten
	 *         'sm'      => 20,   // Ab 768px: 20 von 24 Spalten
	 *         'default' => 24,   // Unter 768px: volle Breite
	 *     ],
	 *     'is_lcp' => false,     // Set true for above-fold hero images
	 * ] );
	 *
	 * Usage with explicit sizes (fallback):
	 * $image = $block->output( 'image', 'image_responsive', [
	 *     'sizes'      => '(min-width: 1920px) 693px, (min-width: 1280px) 42vw, 100vw',
	 *     'image_size' => 'image-xxl',
	 * ] );
	 *
	 * @param array $data Image data array with value, name, and arguments.
	 *
	 * @return string HTML figure element with image
	 */
	protected function output_image_responsive( array $data ): string {

		if ( empty( $data['value'] ) ) {
			return $this->return_empty_image_preview( $data );
		}

		$attachment_id = is_array( $data['value'] ) ? ( $data['value']['ID'] ?? 0 ) : $data['value'];

		if ( empty( $attachment_id ) ) {
			return $this->return_empty_image_preview( $data );
		}

		$image_size = $data['arguments']['image_size'] ?? 'image-xxl';

		$sizes = '100vw';
		if ( ! empty( $data['arguments']['columns'] ) ) {
			$sizes = $this->calculate_sizes( $data['arguments']['columns'] );
		} elseif ( ! empty( $data['arguments']['sizes'] ) ) {
			$sizes = $data['arguments']['sizes'];
		}

		$attr = [
			'class'    => 'c-media__image',
			'sizes'    => $sizes,
			'decoding' => 'async',
		];

		$is_lcp = $data['arguments']['is_lcp'] ?? false;
		if ( $is_lcp ) {
			$attr['loading']       = 'eager';
			$attr['fetchpriority'] = 'high';
		}

		$image = wp_get_attachment_image( $attachment_id, $image_size, false, $attr );

		if ( empty( $image ) ) {
			return '';
		}

		$overlay = $data['arguments']['overlay'] ?? false;
		if ( $overlay ) {
			$overlay = '<div class="c-media__overlay"></div>';
		}

		$media_classes = $this->return_media_classes( $data );

		return '<figure class="' . $media_classes . '">' . $image . $overlay . '</figure>';
	}

	/**
	 * Calculate sizes attribute from column configuration
	 *
	 * Converts column-based layout definition to proper sizes attribute.
	 * Uses theme breakpoints for accurate viewport matching.
	 *
	 * @param array $columns Column configuration per breakpoint.
	 *                       Example: ['lg' => 10, 'sm' => 20, 'default' => 24]
	 *
	 * @return string The sizes attribute value
	 */
	protected function calculate_sizes( array $columns ): string {
		// Theme breakpoints (must match _breakpoints.scss)
		$breakpoints = [
			'xxl' => 1920,
			'xl'  => 1440,
			'lg'  => 1280,
			'md'  => 1024,
			'sm'  => 768,
			'xs'  => 576,
			'xxs' => 400,
		];

		$total_columns = 24;
		$max_container = 1920 - ( 96 * 2 ); // 1920px - 256px offset (2 * 128px)

		$sizes_parts = [];

		// Special case: At 1920px+ the container is capped
		// Use the largest defined column count for this calculation
		$largest_bp_cols = null;
		foreach ( [ 'xxl', 'xl', 'lg', 'md', 'sm', 'xs', 'xxs' ] as $bp ) {
			if ( isset( $columns[ $bp ] ) ) {
				$largest_bp_cols = $columns[ $bp ];
				break;
			}
		}
		if ( null === $largest_bp_cols ) {
			$largest_bp_cols = $columns['default'] ?? 24;
		}

		$width_at_max  = round( $max_container / $total_columns * $largest_bp_cols );
		$sizes_parts[] = "(min-width: 1920px) {$width_at_max}px";

		// For each defined breakpoint: calculate vw value
		// Sort breakpoints descending (largest first)
		$defined_breakpoints = [];
		foreach ( $columns as $bp => $cols ) {
			if ( 'default' === $bp ) {
				continue;
			}
			if ( ! isset( $breakpoints[ $bp ] ) ) {
				continue;
			}
			$defined_breakpoints[ $bp ] = [
				'min_width' => $breakpoints[ $bp ],
				'cols'      => $cols,
			];
		}

		// Sort by min_width descending
		uasort( $defined_breakpoints, function ( $a, $b ) {
			return $b['min_width'] <=> $a['min_width'];
		} );

		foreach ( $defined_breakpoints as $bp => $config ) {
			$vw            = round( 100 / $total_columns * $config['cols'] );
			$sizes_parts[] = "(min-width: {$config['min_width']}px) {$vw}vw";
		}

		// Default (mobile) - use default columns or full width
		$default_cols  = $columns['default'] ?? 24;
		$default_vw    = round( 100 / $total_columns * $default_cols );
		$sizes_parts[] = "{$default_vw}vw";

		return implode( ', ', $sizes_parts );
	}


	protected function return_media_classes( array $data ): string {
		$classes = [
			'c-media',
			'c-media--fit-' . $this->return_image_behaviour_value( $data ),
			'c-media--pos-' . $this->return_image_position_value( $data ),
		];

		if ( ! empty( $data['arguments']['media_classes'] ) ) {
			$classes[] = $data['arguments']['media_classes'];
		}

		return implode( ' ', array_filter( $classes ) );
	}

	protected function return_image_behaviour_value( array $data ): string {
		$behaviour = ! empty( $data['name'] ) ? $this->return_raw_data_value( $data['name'] . '_behaviour' ) : '';
		$behaviour = $behaviour ?: ( $data['arguments']['behaviour'] ?? '' );
		$behaviour = $behaviour ?: ( $data['arguments']['image_behaviour'] ?? '' );
		$behaviour = $behaviour ?: 'natural';
		$behaviour = strtolower( str_replace( '_', '-', (string) $behaviour ) );

		if ( ! in_array( $behaviour, [ 'natural', 'cover', 'contain' ], true ) ) {
			return 'natural';
		}

		return $behaviour;
	}

	protected function return_image_position_value( array $data ): string {
		$position = ! empty( $data['name'] ) ? $this->return_raw_data_value( $data['name'] . '_position' ) : '';
		$position = $position ?: ( $data['arguments']['position'] ?? '' );
		$position = $position ?: ( $data['arguments']['image_position'] ?? '' );
		$position = $position ?: 'center-center';
		$position = strtolower( str_replace( '_', '-', (string) $position ) );

		$allowed_positions = [
			'top-left',
			'top-center',
			'top-right',
			'center-left',
			'center-center',
			'center-right',
			'bottom-left',
			'bottom-center',
			'bottom-right',
		];

		if ( ! in_array( $position, $allowed_positions, true ) ) {
			return 'center-center';
		}

		return $position;
	}

	protected function output_cf7form( array $data ): string {

		if ( empty( $data['value'] ) ) {
			return '';
		}

		return do_shortcode( '[contact-form-7 id="' . $data['value'] . '"]' );
	}

	protected function output_navigation( array $data ): string {

		if ( empty( $data['value'] ) ) {
			return '';
		}

		if ( is_nav_menu( $data['value'] ) ) {

			return wp_nav_menu( array(
				'menu'       => $data['value'],
				'container'  => false,
				'items_wrap' => '<ul>%3$s</ul>',
				'echo'       => 0,
			) );

		}

		return '';
	}


	protected function output_video_selfhosted( array $data ): string {

		$output = '';

		if ( empty( $data['value']['url'] ) ) {
			return '';
		}

		if ( empty( $data['value']['mime_type'] ) ) {
			return '';
		}

		$autoplay = '';
		$preload  = ' preload="none"';
		if ( ! empty( $data['name'] ) && ! empty( $this->return_raw_data_value( $data['name'] . '_autoplay' ) ) ) {
			$autoplay .= ' autoplay';
			$preload  = '';
		} elseif ( ! empty( $data['arguments']['autoplay'] ) ) {
			$autoplay = ' autoplay';
			$preload  = '';
		}

		$controls = '';
		if ( ! empty( $data['name'] ) && ! empty( $this->return_raw_data_value( $data['name'] . '_controls' ) ) ) {
			$controls .= ' controls';
		} elseif ( ! empty( $data['arguments']['controls'] ) ) {
			$controls = ' controls';
		}

		$loop = '';
		if ( ! empty( $data['name'] ) && ! empty( $this->return_raw_data_value( $data['name'] . '_loop' ) ) ) {
			$loop .= ' loop';
		} elseif ( ! empty( $data['arguments']['loop'] ) ) {
			$loop = ' loop';
		}

		$muted = '';
		if ( ! empty( $data['name'] ) && ! empty( $this->return_raw_data_value( $data['name'] . '_muted' ) ) ) {
			$muted .= ' muted';
		} elseif ( ! empty( $data['arguments']['muted'] ) ) {
			$muted = ' muted';
		}

		$poster      = '';
		$poster_data = ! empty( $data['name'] ) ? $this->return_raw_data_value( $data['name'] . '_poster', [] ) : [];
		if ( ! empty( $poster_data['url'] ) ) {
			$poster .= ' poster="' . $poster_data['url'] . '"';
		} elseif ( ! empty( $data['arguments']['poster'] ) ) {
			$poster = ' poster="' . $data['arguments']['poster'] . '"';
		}

		$overlay = $data['arguments']['overlay'] ?? false;
		if ( $overlay ) {
			$overlay = '<div class="c-media__overlay"></div>';
		}

		$output = '<figure class="c-media c-media--fit-cover">';
		$output .= '<video' . $preload . ' class="c-media__video" playsinline' . $controls . $autoplay . $loop . $muted . $poster . '>';
		$output .= '<source src="' . $data['value']['url'] . '" type="' . $data['value']['mime_type'] . '">';
		$output .= '</video>';
		$output .= $overlay;
		$output .= '</figure>';

		return $output;
	}


	protected function output_video_oembed( array $data ): string {

		if ( empty( $data['value'] ) ) {
			return '';
		}

		$iframe = $data['value'];

		preg_match( '/src="(.+?)"/', $iframe, $matches );
		$src = $matches[1];

		$params  = array(
			'controls' => 1,
			'hd'       => 1,
			'autohide' => 1,
		);
		$new_src = add_query_arg( $params, $src );
		$iframe  = str_replace( $src, $new_src, $iframe );

		$attributes = 'class="c-media__video"';
		$iframe     = str_replace( '></iframe>',
			' ' . $attributes . '></iframe>', $iframe );

		$iframe = '<figure class="c-media c-media--fit-cover">' . $iframe . '</figure>';

		return $iframe;

	}

	protected function output_link( array $data ): string {

		if ( empty( $data['value'] ) ) {
			return '';
		}

		$url    = ! empty( $data['value']['url'] ) ? ' href="' . $data['value']['url'] . '"' : '';
		$target = ! empty( $data['value']['target'] ) ? ' target="' . $data['value']['target'] . '"' : '';
		$title  = ! empty( $data['value']['title'] ) ? $data['value']['title'] : '';

		$icon = '';
		if ( ! empty( $data['arguments']['icon'] ) ) {
			$icon = stilpress__return_icon( $data['arguments']['icon'] );
		}

		$icon_before = 'left';
		if ( ! empty( $data['arguments']['icon_position'] ) ) {
			$icon_before = $data['arguments']['icon_position'];
		}

		return '<a class="c-link"' . $url . $target . '>' . ( $icon_before == 'left' ? $icon : '' ) . '<span>' . $title . '</span>' . ( $icon_before == 'right' ? $icon : '' ) . '</a>';
	}

	protected function output_button( array $data ): string {
		if ( empty( $data['value'] ) ) {
			return '';
		}

//		$inline_toolbar = is_admin()
//		                  && function_exists( 'acf_inline_toolbar_editing_attrs' )
//		                  && ! empty( $data['name'] )
//		                  && ! empty( $data['arguments']['inline_toolbar'] );

		$url    = '';
		$target = '';
//		if ( ! $inline_toolbar ) {
//			$url    = ! empty( $data['value']['url'] ) ? ' href="' . $data['value']['url'] . '"' : '';
//			$target = ! empty( $data['value']['target'] ) ? ' target="' . $data['value']['target'] . '"' : '';
//		}
		$title = ! empty( $data['value']['title'] ) ? $data['value']['title'] : '';

		$inline_attrs = '';
//		if ( $inline_toolbar ) {
//			$inline_attrs = ' ' . acf_inline_toolbar_editing_attrs(
//					[
//						[
//							'field_name'  => $this->return_namespaced_field_name( $data['name'] ),
//							'field_label' => __( 'Button bearbeiten', 'stilpress' ),
//						]
//					],
//					[
//						'toolbar_title' => __( 'Button bearbeiten', 'stilpress' ),
//					]
//				);
//		}

		$icon_before = false;
		if ( ! empty( $data['arguments']['position'] ) ) {
			$icon_before = $data['arguments']['position'];
		}

		$icon = '';
		if ( ! empty( $data['arguments']['icon'] ) ) {
			$icon = stilpress__return_icon( $data['arguments']['icon'] );

			if ( ! empty( $data['value']['url'] ) ) {
				$file_extension = pathinfo( $data['value']['url'], PATHINFO_EXTENSION );
				if ( ! empty( $file_extension ) ) {
					if ( $file_extension == 'pdf' ) {
						$icon = stilpress__return_icon( 'file-pdf' );
					}
				}

			}
		}

		$classes = 'c-button';
		if ( ! empty( $data['arguments']['classes'] ) ) {
			$classes .= ' ' . $data['arguments']['classes'];
		}

		return '<a class="' . $classes . '"' . $url . $target . $inline_attrs . '>' . ( $icon_before === true ? $icon : '' ) . '<span>' . $title . '</span>' . ( $icon_before === false ? $icon : '' ) . '</a>';
	}

	private function output_select( array $data ): string {

		if ( empty( $data['value'] ) ) {
			return '';
		}

		return $data['value'];
	}

}
