<?php

/**
 * register custom block editor category
 */
function stilpress__register_block_categories( $categories ) {
	return array_merge( $categories, array(
		array(
			'slug'  => 'stilpress-all',
			'title' => __( 'Custom Blocks', 'stilpress' ),
		),
	) );
}

add_filter( 'block_categories_all', 'stilpress__register_block_categories', 10, 2 );


/**
 * Get block configuration
 *
 * Reads the $block_config global defined in includes.php.
 *
 * @return array Configuration array with active blocks and widgets
 * @since 1.0.0
 */
function stilpress__get_block_config(): array {
	global $block_config;

	return $block_config ?? [
		'blocks'  => [],
		'widgets' => [],
	];
}

/**
 * Get all active block folders based on configuration
 *
 * Only blocks listed in blocks-config.php will be registered.
 * All other blocks remain in filesystem but are not loaded.
 *
 * @param string $path Path to blocks directory.
 *
 * @return array Array of block data for registration
 * @since 1.0.0
 */
function stilpress__get_block_folders( $path ): array {

	// Load configuration
	$config        = stilpress__get_block_config();
	$active_blocks = array_merge(
		$config['blocks'] ?? [],
		$config['widgets'] ?? []
	);

	$blocks = [];
	foreach ( $active_blocks as $folder ) {
		$block_path = $path . '/' . $folder;

		// check if block directory exists
		if ( ! is_dir( $block_path ) ) {
			continue;
		}

		// check if block.json exists
		if ( ! file_exists( $block_path . '/block.json' ) ) {
			continue;
		}

		$blocks[] = [
			'name'     => $folder,
			'register' => $block_path,
		];
	}

	return $blocks;
}

function stilpress__register_block_types(): void {
	$blocks = stilpress__get_block_folders( __DIR__ );
	foreach ( $blocks as $block ) {
		register_block_type( $block['register'] );
	}
}

add_action( 'init', 'stilpress__register_block_types', 10 );


/**
 * Register layout-based image sizes
 *
 * Reads the $image_config global defined in includes.php.
 *
 * @return void
 * @since 1.0.0
 */
function stilpress__register_layout_image_sizes() {
	global $image_config;

	if ( empty( $image_config ) ) {
		return;
	}

	foreach ( $image_config as $size_name => $size_config ) {
		add_image_size(
			$size_name,
			$size_config['width'],
			$size_config['height'],
			$size_config['crop'] ?? false
		);
	}
}

add_action( 'after_setup_theme', 'stilpress__register_layout_image_sizes' );


// return allowed block editor elements
function stilpress__allowed_blocks( $allowed_block_types, $block_editor_context ) {

	$blocks = stilpress__get_block_folders( __DIR__ );

	$widget_blocks = $editor_blocks = [
		'core/block',
		'core/paragraph',
	];

	if ( ! empty( $blocks ) ) {

		foreach ( $blocks as $block ) {

			if ( str_starts_with( $block['name'], 'w-' ) ) {
				$widget_blocks[] = 'stilpress/' . $block['name'];
			}
			if ( str_starts_with( $block['name'], 'b-' ) ) {
				$editor_blocks[] = 'stilpress/' . $block['name'];
			}
		}
	}

	if ( 'core/edit-widgets' === $block_editor_context->name || 'core/customize-widgets' === $block_editor_context->name ) {
		return $widget_blocks;
	}

	return $editor_blocks;
}

add_filter( 'allowed_block_types_all', 'stilpress__allowed_blocks', 10, 2 );


//add bock to content types
function stilpress__default_content( $content, $post ) {
	$content = '';

	if ( 'page' === $post->post_type ) {
		$content .= "<!-- wp:stilpress/b-page-title /-->";
	}

	return $content;
}

//add_filter( 'default_content', 'stilpress__default_content', 10, 2 );
