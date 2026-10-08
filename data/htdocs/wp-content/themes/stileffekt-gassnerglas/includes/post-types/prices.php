<?php


//
// register custom post type Price
//
function stilpress__posttype_price() {
	$labels = [
		// Basic
		'name'                     => __( 'Prices', 'stilpress' ),
		'singular_name'            => __( 'Price', 'stilpress' ),
		'menu_name'                => __( 'Prices', 'stilpress' ),

		// Navigation & Lists
		'all_items'                => __( 'All Prices', 'stilpress' ),
		'search_items'             => __( 'Search Prices', 'stilpress' ),
		'not_found'                => __( 'No prices found.', 'stilpress' ),
		'not_found_in_trash'       => __( 'No prices found in Trash.', 'stilpress' ),

		// Actions
		'add_new'                  => __( 'Add New', 'stilpress' ),
		'add_new_item'             => __( 'Add New Price', 'stilpress' ),
		'edit_item'                => __( 'Edit Price', 'stilpress' ),
		'new_item'                 => __( 'New Price', 'stilpress' ),
		'view_item'                => __( 'View Price', 'stilpress' ),
		'view_items'               => __( 'View Prices', 'stilpress' ),

		// Hierarchy
		'parent_item_colon'        => __( 'Parent Price:', 'stilpress' ),

		// Archive
		'archives'                 => __( 'Price Archives', 'stilpress' ),

		// Screen Reader / Accessibility
		'filter_items_list'        => __( 'Filter prices list', 'stilpress' ),
		'items_list_navigation'    => __( 'Prices list navigation', 'stilpress' ),
		'items_list'               => __( 'Prices list', 'stilpress' ),

		// Block Editor Messages
		'item_published'           => __( 'Price published.', 'stilpress' ),
		'item_published_privately' => __( 'Price published privately.', 'stilpress' ),
		'item_reverted_to_draft'   => __( 'Price reverted to draft.', 'stilpress' ),
		'item_trashed'             => __( 'Price trashed.', 'stilpress' ),
		'item_scheduled'           => __( 'Price scheduled.', 'stilpress' ),
		'item_updated'             => __( 'Price updated.', 'stilpress' ),
		'item_link'                => __( 'Price Link', 'stilpress' ),
		'item_link_description'    => __( 'A link to a price.', 'stilpress' ),
	];

	$args = [
		'labels'              => $labels,
		'supports'            => [ 'title', 'author', 'revisions' ],
		'taxonomies'          => [],
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'capability_type'     => [ 'price', 'prices' ],
		'map_meta_cap'        => true,
		'delete_with_user'    => false,
		'show_in_rest'        => true,
		'rest_base'           => 'prices',
		'menu_position'       => 26,
		'menu_icon'           => 'dashicons-money-alt',
	];

	register_post_type( 'price', $args );
}

add_action( 'init', 'stilpress__posttype_price' );


//
// register custom taxonomy price
//
function stilpress__taxonomy_price_categories() {
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

	register_taxonomy( 'price-category', array( 'price' ), array(
		'public'            => false,
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'capabilities'      => [
			'manage_terms' => 'manage_price_categories',
			'edit_terms'   => 'edit_price_categories',
			'delete_terms' => 'delete_price_categories',
			'assign_terms' => 'assign_price_categories',
		],
	) );
}

add_action( 'init', 'stilpress__taxonomy_price_categories' );


//
// Add capabilities for price post type and taxonomy
//
add_action( 'admin_init', fn() =>
	stilpress__add_posttype_and_taxonomy_capabilities( 'price', 'prices', 'price_categories' )
);
