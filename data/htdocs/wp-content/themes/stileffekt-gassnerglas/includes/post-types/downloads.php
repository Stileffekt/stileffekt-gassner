<?php


//
// register custom post type download
//
function stilpress__posttype_download() {
	$labels = [
		// Basic
		'name'                     => __( 'Downloads', 'stilpress' ),
		'singular_name'            => __( 'Download', 'stilpress' ),
		'menu_name'                => __( 'Downloads', 'stilpress' ),

		// Navigation & Lists
		'all_items'                => __( 'All Downloads', 'stilpress' ),
		'search_items'             => __( 'Search Downloads', 'stilpress' ),
		'not_found'                => __( 'No downloads found.', 'stilpress' ),
		'not_found_in_trash'       => __( 'No downloads found in Trash.', 'stilpress' ),

		// Actions
		'add_new'                  => __( 'Add New', 'stilpress' ),
		'add_new_item'             => __( 'Add New Download', 'stilpress' ),
		'edit_item'                => __( 'Edit Download', 'stilpress' ),
		'new_item'                 => __( 'New Download', 'stilpress' ),
		'view_item'                => __( 'View Download', 'stilpress' ),
		'view_items'               => __( 'View Downloads', 'stilpress' ),

		// Hierarchy
		'parent_item_colon'        => __( 'Parent Download:', 'stilpress' ),

		// Archive
		'archives'                 => __( 'Download Archives', 'stilpress' ),

		// Screen Reader / Accessibility
		'filter_items_list'        => __( 'Filter downloads list', 'stilpress' ),
		'items_list_navigation'    => __( 'Downloads list navigation', 'stilpress' ),
		'items_list'               => __( 'Downloads list', 'stilpress' ),

		// Block Editor Messages
		'item_published'           => __( 'Download published.', 'stilpress' ),
		'item_published_privately' => __( 'Download published privately.', 'stilpress' ),
		'item_reverted_to_draft'   => __( 'Download reverted to draft.', 'stilpress' ),
		'item_trashed'             => __( 'Download trashed.', 'stilpress' ),
		'item_scheduled'           => __( 'Download scheduled.', 'stilpress' ),
		'item_updated'             => __( 'Download updated.', 'stilpress' ),
		'item_link'                => __( 'Download Link', 'stilpress' ),
		'item_link_description'    => __( 'A link to a download.', 'stilpress' ),
	];

	$args = [
		'labels'              => $labels,
		'supports'            => [ 'title', 'author', 'revisions' ],
		'taxonomies'          => [],
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'capability_type'     => [ 'download', 'downloads' ],
		'map_meta_cap'        => true,
		'delete_with_user'    => false,
		'show_in_rest'        => true,
		'rest_base'           => 'downloads',
		'menu_position'       => 22,
		'menu_icon'           => 'dashicons-download',
	];

	register_post_type( 'download', $args );
}

add_action( 'init', 'stilpress__posttype_download' );


//
// register custom taxonomy download-category
//
function stilpress__taxonomy_download_categories() {

	$labels = [
		// Basic
		'name'                       => __( 'Categories', 'stilpress' ),
		'singular_name'              => __( 'Category', 'stilpress' ),
		'menu_name'                  => __( 'Categories', 'stilpress' ),

		// Navigation & Lists
		'all_items'                  => __( 'All Categories', 'stilpress' ),
		'search_items'               => __( 'Search Categories', 'stilpress' ),
		'not_found'                  => __( 'No categories found.', 'stilpress' ),
		'no_terms'                   => __( 'No categories', 'stilpress' ),

		// Hierarchy
		'parent_item'                => __( 'Parent Category', 'stilpress' ),
		'parent_item_colon'          => __( 'Parent Category:', 'stilpress' ),

		// Actions
		'edit_item'                  => __( 'Edit Category', 'stilpress' ),
		'view_item'                  => __( 'View Category', 'stilpress' ),
		'update_item'                => __( 'Update Category', 'stilpress' ),
		'add_new_item'               => __( 'Add New Category', 'stilpress' ),
		'new_item_name'              => __( 'New Category Name', 'stilpress' ),

		// Screen Reader / Accessibility
		'items_list_navigation'      => __( 'Categories list navigation', 'stilpress' ),
		'items_list'                 => __( 'Categories list', 'stilpress' ),
		'most_used'                  => __( 'Most Used', 'stilpress' ),
		'back_to_items'              => __( '← Go to Categories', 'stilpress' ),

		// Filter (Table)
		'filter_by_item'             => __( 'Filter by category', 'stilpress' ),
	];

	register_taxonomy( 'download-category', array( 'download' ), array(
		'labels'             => $labels,
		'hierarchical'       => true,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'query_var'          => true,
		'show_in_rest'       => true,
		'publicly_queryable' => false,
		'public'             => false,
		'capabilities'       => [
			'manage_terms' => 'manage_download_categories',
			'edit_terms'   => 'edit_download_categories',
			'delete_terms' => 'delete_download_categories',
			'assign_terms' => 'assign_download_categories',
		],
	) );
}

add_action( 'init', 'stilpress__taxonomy_download_categories' );


//
// Add capabilities for download post type and taxonomy
//
add_action( 'admin_init', fn() => stilpress__add_posttype_and_taxonomy_capabilities( 'download', 'downloads', 'download_categories' ) );
