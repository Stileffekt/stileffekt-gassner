<?php


//
// register custom post type accommodation
//
function stilpress__posttype_accommodation() {
	$labels = [
		// Basic
		'name'                     => __( 'Accommodations', 'stilpress' ),
		'singular_name'            => __( 'Accommodation', 'stilpress' ),
		'menu_name'                => __( 'Accommodations', 'stilpress' ),

		// Navigation & Lists
		'all_items'                => __( 'All Accommodations', 'stilpress' ),
		'search_items'             => __( 'Search Accommodations', 'stilpress' ),
		'not_found'                => __( 'No accommodations found.', 'stilpress' ),
		'not_found_in_trash'       => __( 'No accommodations found in Trash.', 'stilpress' ),

		// Actions
		'add_new'                  => __( 'Add New', 'stilpress' ),
		'add_new_item'             => __( 'Add New Accommodation', 'stilpress' ),
		'edit_item'                => __( 'Edit Accommodation', 'stilpress' ),
		'new_item'                 => __( 'New Accommodation', 'stilpress' ),
		'view_item'                => __( 'View Accommodation', 'stilpress' ),
		'view_items'               => __( 'View Accommodations', 'stilpress' ),

		// Hierarchy
		'parent_item_colon'        => __( 'Parent Accommodation:', 'stilpress' ),

		// Archive
		'archives'                 => __( 'Accommodation Archives', 'stilpress' ),

		// Screen Reader / Accessibility
		'filter_items_list'        => __( 'Filter accommodations list', 'stilpress' ),
		'items_list_navigation'    => __( 'Accommodations list navigation', 'stilpress' ),
		'items_list'               => __( 'Accommodations list', 'stilpress' ),

		// Block Editor Messages
		'item_published'           => __( 'Accommodation published.', 'stilpress' ),
		'item_published_privately' => __( 'Accommodation published privately.', 'stilpress' ),
		'item_reverted_to_draft'   => __( 'Accommodation reverted to draft.', 'stilpress' ),
		'item_trashed'             => __( 'Accommodation trashed.', 'stilpress' ),
		'item_scheduled'           => __( 'Accommodation scheduled.', 'stilpress' ),
		'item_updated'             => __( 'Accommodation updated.', 'stilpress' ),
		'item_link'                => __( 'Accommodation Link', 'stilpress' ),
		'item_link_description'    => __( 'A link to an accommodation.', 'stilpress' ),
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
		'capability_type'     => [ 'accommodation', 'accommodations' ],
		'map_meta_cap'        => true,
		'delete_with_user'    => false,
		'show_in_rest'        => true,
		'rest_base'           => 'accommodations',
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-building',
	];

	register_post_type( 'accommodation', $args );
}

add_action( 'init', 'stilpress__posttype_accommodation' );


//
// register custom taxonomy accommodation
//
function stilpress__taxonomy_accommodation_categories() {

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

	register_taxonomy( 'accommodation-category', array( 'accommodation' ), array(
		'labels'             => $labels,
		'hierarchical'       => true,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'query_var'          => true,
		'show_in_rest'       => true,
		'publicly_queryable' => false,
		'public'             => false,
		'capabilities'       => [
			'manage_terms' => 'manage_accommodation_categories',
			'edit_terms'   => 'edit_accommodation_categories',
			'delete_terms' => 'delete_accommodation_categories',
			'assign_terms' => 'assign_accommodation_categories',
		],
	) );
}

add_action( 'init', 'stilpress__taxonomy_accommodation_categories' );


//
// Add capabilities for accommodation post type and taxonomy
//
add_action( 'admin_init', fn() =>
	stilpress__add_posttype_and_taxonomy_capabilities( 'accommodation', 'accommodations', 'accommodation_categories' )
);
