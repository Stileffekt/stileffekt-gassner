<?php

if ( ! class_exists( 'ACF' ) ) {
	return false;
}

//require_once __DIR__ . '/toolbars.php';

require_once __DIR__ . '/extensions/navigation/acf-navigation.php';
require_once __DIR__ . '/extensions/icon/acf-icon-picker.php';
require_once __DIR__ . '/extensions/form/acf-form.php';

//
// acf backend visibility
//
function stilpress__acf_visibility() {

	$users = array(
		'christoph@stileffekt.de',
		'sebastian@stileffekt.de',
		'it@stileffekt.de',
	);

	$current_user = wp_get_current_user();

	if ( in_array( $current_user->user_email, $users ) ) {
		return true;
	}

	return false;
}

add_filter( 'acf/settings/show_admin', 'stilpress__acf_visibility' );
add_filter( 'acf/settings/show_updates', 'stilpress__acf_visibility', 100 );


/**
 * Enable ACF JSON Save
 *
 * Tells ACF to save field groups as JSON files.
 * The actual save path is controlled by stilpress__acf_json_save_file().
 *
 * @param string $path Default save path.
 *
 * @return string Modified save path.
 * @since 1.0.0
 */
function stilpress__acf_json_save_point( $path ) {
	// Return a base path - the actual path per field group is handled by acf/json/save_file filter
	return get_template_directory() . '/includes/integrations/acf/_settings';
}

add_filter( 'acf/settings/save_json', 'stilpress__acf_json_save_point' );


/**
 * ACF JSON Save Paths - per Field Group
 *
 * Saves block-specific field groups in their respective block folders as fields.json.
 * Theme settings are saved in _settings folder with semantic names.
 *
 * Auto-creates block folders if they don't exist (with validation).
 * Only creates folders for valid block names matching: b-* or w-*
 *
 * @param array $paths Array of possible save paths.
 * @param array $post Field group data.
 *
 * @return array Modified paths array.
 * @since 1.0.0
 */
function stilpress__acf_json_save_paths( $paths, $post ) {

	if ( empty( $post['location'] ) ) {
		return $paths;
	}

	// Check if field group belongs to a block
	foreach ( $post['location'] as $location_group ) {
		foreach ( $location_group as $rule ) {
			if ( 'block' === $rule['param'] && ! empty( $rule['value'] ) ) {

				// Extract block name from "stilpress/b-page-title"
				$block_name = str_replace( 'stilpress/', '', str_replace( '\/', '/', $rule['value'] ) );

				// Save in block folder
				$block_path = get_template_directory() . '/includes/blocks/' . $block_name;

				// Auto-create block folder if it doesn't exist
				if ( ! is_dir( $block_path ) ) {
					// Validate block name pattern (b-* or w-*)
					if ( preg_match( '/^[bw]-[a-z0-9-]+$/', $block_name ) ) {
						// Create folder
						wp_mkdir_p( $block_path );

						// Log creation in debug mode
						if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
							error_log( sprintf(
								'[ACF] Auto-created block folder "%s". Remember to add: block.json, block.php, view.php',
								$block_name
							) );
						}
					} else {
						// Invalid block name - log warning and save to _settings
						if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
							error_log( sprintf(
								'[ACF] Invalid block name "%s". Field group saved to _settings. Block names must match pattern: b-* or w-*',
								$block_name
							) );
						}

						return array( get_template_directory() . '/includes/integrations/acf/_settings' );
					}
				}

				if ( is_dir( $block_path ) ) {
					// Return block path for saving
					return array( $block_path );
				}
			}
		}
	}

	// Default: ACF integration folder for global settings (theme, CPTs, etc.)
	return array( get_template_directory() . '/includes/integrations/acf/_settings' );
}

add_filter( 'acf/json/save_paths', 'stilpress__acf_json_save_paths', 10, 2 );


/**
 * ACF JSON Save Filename
 *
 * Controls the filename when saving ACF field groups.
 * Block field groups are saved as "fields.json".
 * Settings field groups are saved as "fields-[sanitized-title].json".
 *
 * @param string $filename The default filename (key.json).
 * @param array $post The field group data.
 * @param string $load_path The path the field group was loaded from.
 *
 * @return string Modified filename.
 * @since 1.0.0
 */
function stilpress__acf_json_save_filename( $filename, $post, $load_path ) {

	// If field group has no location, use default
	if ( empty( $post['location'] ) ) {
		return $filename;
	}

	// Check if field group belongs to a block
	foreach ( $post['location'] as $location_group ) {
		foreach ( $location_group as $rule ) {
			if ( 'block' === $rule['param'] && ! empty( $rule['value'] ) ) {
				// Block field groups always use fields.json
				return 'fields.json';
			}
		}
	}

	// Default: Settings field groups use fields-[title].json
	if ( ! empty( $post['title'] ) ) {
		return 'fields-' . sanitize_title( $post['title'] ) . '.json';
	}

	// Fallback: Use default filename
	return $filename;
}

add_filter( 'acf/json/save_file_name', 'stilpress__acf_json_save_filename', 10, 3 );


/**
 * ACF JSON Load
 *
 * Loads field groups from:
 * 1. Active block folders (from blocks-config.php) - only fields.json files
 * 2. _settings folder (theme settings)
 *
 * Only field groups for active blocks are loaded, reducing backend overhead.
 * Only loads fields.json to avoid conflicts with block.json files.
 *
 * @param array $paths Array of paths to load JSON from.
 *
 * @return array Modified paths array.
 * @since 1.0.0
 */
function stilpress__acf_load_json( $paths ) {
	global $block_config;

	unset( $paths[0] );

	if ( empty( $block_config ) ) {
		$paths[] = get_template_directory() . '/includes/integrations/acf/_settings';

		return $paths;
	}

	$active_blocks = array_merge(
		$block_config['blocks'] ?? [],
		$block_config['widgets'] ?? []
	);

	foreach ( $active_blocks as $block_name ) {
		$block_path = get_template_directory() . '/includes/blocks/' . $block_name;
		if ( is_dir( $block_path ) ) {
			$paths[] = $block_path;
		}
	}

	$paths[] = get_template_directory() . '/includes/integrations/acf/_settings';

	return $paths;
}

add_filter( 'acf/settings/load_json', 'stilpress__acf_load_json' );

//
// register admin menus
//
function stileffekt__acf_admin() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page( array(
		'page_title' => 'Theme Settings',
		'menu_title' => 'Theme Settings',
		'menu_slug'  => 'theme-settings',
		'capability' => 'manage_options',
		'redirect'   => true,
	) );

	acf_add_options_sub_page( array(
		'page_title'  => 'Header',
		'menu_title'  => 'Header',
		'parent_slug' => 'theme-settings',
		'menu_slug'   => 'theme-settings-header',
		'capability'  => 'manage_options',
	) );

	acf_add_options_sub_page( array(
		'page_title'  => 'Footer',
		'menu_title'  => 'Footer',
		'parent_slug' => 'theme-settings',
		'menu_slug'   => 'theme-settings-footer',
		'capability'  => 'manage_options',
	) );

	acf_add_options_sub_page( array(
		'page_title'  => 'Icons',
		'menu_title'  => 'Icons',
		'parent_slug' => 'theme-settings',
		'menu_slug'   => 'theme-settings-icons',
		'capability'  => 'manage_options',
	) );

	acf_add_options_sub_page( array(
		'page_title'  => 'Sticky Icons',
		'menu_title'  => 'Sticky Icons',
		'parent_slug' => 'theme-settings',
		'menu_slug'   => 'theme-settings-sticky-icons',
		'capability'  => 'manage_options',
	) );
}

add_action( 'acf/init', 'stileffekt__acf_admin' );


function stilpress__acf_wysiwyg_admin_height(): void {
	?>
	<style>
		.acf-field-wysiwyg .mce-edit-area iframe,
		.acf-field-wysiwyg textarea.wp-editor-area {
			min-height: 200px !important;
			height: 200px !important;
		}
	</style>
	<?php
}

add_action( 'acf/input/admin_head', 'stilpress__acf_wysiwyg_admin_height' );


// todo: test hotfix for scrollposition bug
function stilpress__hotfix_acf_scroll_position(): void {
	echo <<< HTML
    <script> jQuery(document).off('tinymce-editor-init.keep-scroll-position'); </script>
    HTML;
}

add_action( 'acf/input/admin_footer', 'stilpress__hotfix_acf_scroll_position' );
