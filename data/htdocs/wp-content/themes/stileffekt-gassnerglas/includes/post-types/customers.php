<?php


//
// register custom post type customer
//
function stilpress__posttype_customer() {
	$labels = [
		// Basic
		'name'                     => __( 'Customers', 'stilpress' ),
		'singular_name'            => __( 'Customer', 'stilpress' ),
		'menu_name'                => __( 'Customers', 'stilpress' ),

		// Navigation & Lists
		'all_items'                => __( 'All Customers', 'stilpress' ),
		'search_items'             => __( 'Search Customers', 'stilpress' ),
		'not_found'                => __( 'No customers found.', 'stilpress' ),
		'not_found_in_trash'       => __( 'No customers found in Trash.', 'stilpress' ),

		// Actions
		'add_new'                  => __( 'Add New', 'stilpress' ),
		'add_new_item'             => __( 'Add New Customer', 'stilpress' ),
		'edit_item'                => __( 'Edit Customer', 'stilpress' ),
		'new_item'                 => __( 'New Customer', 'stilpress' ),
		'view_item'                => __( 'View Customer', 'stilpress' ),
		'view_items'               => __( 'View Customers', 'stilpress' ),

		// Hierarchy
		'parent_item_colon'        => __( 'Parent Customer:', 'stilpress' ),

		// Archive
		'archives'                 => __( 'Customer Archives', 'stilpress' ),

		// Screen Reader / Accessibility
		'filter_items_list'        => __( 'Filter customers list', 'stilpress' ),
		'items_list_navigation'    => __( 'Customers list navigation', 'stilpress' ),
		'items_list'               => __( 'Customers list', 'stilpress' ),

		// Block Editor Messages
		'item_published'           => __( 'Customer published.', 'stilpress' ),
		'item_published_privately' => __( 'Customer published privately.', 'stilpress' ),
		'item_reverted_to_draft'   => __( 'Customer reverted to draft.', 'stilpress' ),
		'item_trashed'             => __( 'Customer trashed.', 'stilpress' ),
		'item_scheduled'           => __( 'Customer scheduled.', 'stilpress' ),
		'item_updated'             => __( 'Customer updated.', 'stilpress' ),
		'item_link'                => __( 'Customer Link', 'stilpress' ),
		'item_link_description'    => __( 'A link to a customer.', 'stilpress' ),
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
		'capability_type'     => [ 'customer', 'customers' ],
		'map_meta_cap'        => true,
		'delete_with_user'    => false,
		'show_in_rest'        => true,
		'rest_base'           => 'customers',
		'menu_position'       => 21,
		'menu_icon'           => 'dashicons-groups',
	];

	register_post_type( 'customer', $args );
}

add_action( 'init', 'stilpress__posttype_customer' );


//
// register custom taxonomy quote
//
function stilpress__taxonomy_customer_categories() {
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

	register_taxonomy( 'customer-category', array( 'customer' ), array(
		'public'            => false,
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'capabilities'      => [
			'manage_terms' => 'manage_customer_categories',
			'edit_terms'   => 'edit_customer_categories',
			'delete_terms' => 'delete_customer_categories',
			'assign_terms' => 'assign_customer_categories',
		],
	) );
}

add_action( 'init', 'stilpress__taxonomy_customer_categories' );


//
// Add capabilities for customer post type and taxonomy
//
add_action( 'admin_init', fn() =>
	stilpress__add_posttype_and_taxonomy_capabilities( 'customer', 'customers', 'customer_categories' )
);
