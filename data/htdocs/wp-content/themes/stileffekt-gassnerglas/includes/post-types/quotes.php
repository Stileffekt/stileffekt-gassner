<?php


//
// register custom post type Quote
//
function stilpress__posttype_quote() {
	$labels = [
		// Basic
		'name'                     => __( 'Quotes', 'stilpress' ),
		'singular_name'            => __( 'Quote', 'stilpress' ),
		'menu_name'                => __( 'Quotes', 'stilpress' ),

		// Navigation & Lists
		'all_items'                => __( 'All Quotes', 'stilpress' ),
		'search_items'             => __( 'Search Quotes', 'stilpress' ),
		'not_found'                => __( 'No quotes found.', 'stilpress' ),
		'not_found_in_trash'       => __( 'No quotes found in Trash.', 'stilpress' ),

		// Actions
		'add_new'                  => __( 'Add New', 'stilpress' ),
		'add_new_item'             => __( 'Add New Quote', 'stilpress' ),
		'edit_item'                => __( 'Edit Quote', 'stilpress' ),
		'new_item'                 => __( 'New Quote', 'stilpress' ),
		'view_item'                => __( 'View Quote', 'stilpress' ),
		'view_items'               => __( 'View Quotes', 'stilpress' ),

		// Hierarchy
		'parent_item_colon'        => __( 'Parent Quote:', 'stilpress' ),

		// Archive
		'archives'                 => __( 'Quote Archives', 'stilpress' ),

		// Screen Reader / Accessibility
		'filter_items_list'        => __( 'Filter quotes list', 'stilpress' ),
		'items_list_navigation'    => __( 'Quotes list navigation', 'stilpress' ),
		'items_list'               => __( 'Quotes list', 'stilpress' ),

		// Block Editor Messages
		'item_published'           => __( 'Quote published.', 'stilpress' ),
		'item_published_privately' => __( 'Quote published privately.', 'stilpress' ),
		'item_reverted_to_draft'   => __( 'Quote reverted to draft.', 'stilpress' ),
		'item_trashed'             => __( 'Quote trashed.', 'stilpress' ),
		'item_scheduled'           => __( 'Quote scheduled.', 'stilpress' ),
		'item_updated'             => __( 'Quote updated.', 'stilpress' ),
		'item_link'                => __( 'Quote Link', 'stilpress' ),
		'item_link_description'    => __( 'A link to a quote.', 'stilpress' ),
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
		'capability_type'     => [ 'quote', 'quotes' ],
		'map_meta_cap'        => true,
		'delete_with_user'    => false,
		'show_in_rest'        => true,
		'rest_base'           => 'quotes',
		'menu_position'       => 27,
		'menu_icon'           => 'dashicons-format-quote',
	];

	register_post_type( 'quote', $args );
}

add_action( 'init', 'stilpress__posttype_quote' );


//
// register custom taxonomy quote
//
function stilpress__taxonomy_quote_categories() {
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

	register_taxonomy( 'quote-category', array( 'quote' ), array(
		'public'            => false,
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'capabilities'      => [
			'manage_terms' => 'manage_quote_categories',
			'edit_terms'   => 'edit_quote_categories',
			'delete_terms' => 'delete_quote_categories',
			'assign_terms' => 'assign_quote_categories',
		],
	) );
}

add_action( 'init', 'stilpress__taxonomy_quote_categories' );


//
// Add capabilities for quote post type and taxonomy
//
add_action( 'admin_init', fn() =>
	stilpress__add_posttype_and_taxonomy_capabilities( 'quote', 'quotes', 'quote_categories' )
);
