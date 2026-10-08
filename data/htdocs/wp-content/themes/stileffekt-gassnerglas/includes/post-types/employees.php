<?php

//
// register post type employee
//
function stilpress__posttype_employee() {
	$labels = [
		// Basic
		'name'                     => __( 'Employees', 'stilpress' ),
		'singular_name'            => __( 'Employee', 'stilpress' ),
		'menu_name'                => __( 'Employees', 'stilpress' ),

		// Navigation & Lists
		'all_items'                => __( 'All Employees', 'stilpress' ),
		'search_items'             => __( 'Search Employees', 'stilpress' ),
		'not_found'                => __( 'No employees found.', 'stilpress' ),
		'not_found_in_trash'       => __( 'No employees found in Trash.', 'stilpress' ),

		// Actions
		'add_new'                  => __( 'Add New', 'stilpress' ),
		'add_new_item'             => __( 'Add New Employee', 'stilpress' ),
		'edit_item'                => __( 'Edit Employee', 'stilpress' ),
		'new_item'                 => __( 'New Employee', 'stilpress' ),
		'view_item'                => __( 'View Employee', 'stilpress' ),
		'view_items'               => __( 'View Employees', 'stilpress' ),

		// Hierarchy
		'parent_item_colon'        => __( 'Parent Employee:', 'stilpress' ),

		// Archive
		'archives'                 => __( 'Employee Archives', 'stilpress' ),

		// Screen Reader / Accessibility
		'filter_items_list'        => __( 'Filter employees list', 'stilpress' ),
		'items_list_navigation'    => __( 'Employees list navigation', 'stilpress' ),
		'items_list'               => __( 'Employees list', 'stilpress' ),

		// Block Editor Messages
		'item_published'           => __( 'Employee published.', 'stilpress' ),
		'item_published_privately' => __( 'Employee published privately.', 'stilpress' ),
		'item_reverted_to_draft'   => __( 'Employee reverted to draft.', 'stilpress' ),
		'item_trashed'             => __( 'Employee trashed.', 'stilpress' ),
		'item_scheduled'           => __( 'Employee scheduled.', 'stilpress' ),
		'item_updated'             => __( 'Employee updated.', 'stilpress' ),
		'item_link'                => __( 'Employee Link', 'stilpress' ),
		'item_link_description'    => __( 'A link to an employee.', 'stilpress' ),
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
		'capability_type'     => [ 'employee', 'employees' ],
		'map_meta_cap'        => true,
		'delete_with_user'    => false,
		'show_in_rest'        => true,
		'rest_base'           => 'employees',
		'menu_position'       => 23,
		'menu_icon'           => 'dashicons-businessperson',
	];

	register_post_type( 'employee', $args );
}

add_action( 'init', 'stilpress__posttype_employee' );


//
// register taxonomy employee-category
//
function stilpress__taxonomy_employees() {

	$labels = [
		// Basic
		'name'                  => __( 'Categories', 'stilpress' ),
		'singular_name'         => __( 'Category', 'stilpress' ),
		'menu_name'             => __( 'Categories', 'stilpress' ),

		// Navigation & Lists
		'all_items'             => __( 'All Categories', 'stilpress' ),
		'search_items'          => __( 'Search Categories', 'stilpress' ),
		'not_found'             => __( 'No categories found.', 'stilpress' ),
		'no_terms'              => __( 'No categories', 'stilpress' ),

		// Hierarchy
		'parent_item'           => __( 'Parent Category', 'stilpress' ),
		'parent_item_colon'     => __( 'Parent Category:', 'stilpress' ),

		// Actions
		'edit_item'             => __( 'Edit Category', 'stilpress' ),
		'view_item'             => __( 'View Category', 'stilpress' ),
		'update_item'           => __( 'Update Category', 'stilpress' ),
		'add_new_item'          => __( 'Add New Category', 'stilpress' ),
		'new_item_name'         => __( 'New Category Name', 'stilpress' ),

		// Screen Reader / Accessibility
		'items_list_navigation' => __( 'Categories list navigation', 'stilpress' ),
		'items_list'            => __( 'Categories list', 'stilpress' ),
		'most_used'             => __( 'Most Used', 'stilpress' ),
		'back_to_items'         => __( '← Go to Categories', 'stilpress' ),

		// Filter (Table)
		'filter_by_item'        => __( 'Filter by category', 'stilpress' ),
	];

	register_taxonomy( 'employee-category', array( 'employee' ), array(
		'labels'             => $labels,
		'hierarchical'       => true,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'query_var'          => true,
		'show_in_rest'       => true,
		'publicly_queryable' => false,
		'public'             => false,
		'capabilities'       => [
			'manage_terms' => 'manage_employee_categories',
			'edit_terms'   => 'edit_employee_categories',
			'delete_terms' => 'delete_employee_categories',
			'assign_terms' => 'assign_employee_categories',
		],
	) );
}

add_action( 'init', 'stilpress__taxonomy_employees' );


//
// Add capabilities for employee post type and taxonomy
//
add_action( 'admin_init', fn() => stilpress__add_posttype_and_taxonomy_capabilities( 'employee', 'employees', 'employee_categories' )
);
