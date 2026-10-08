<?php


//
// register custom post type jobs
//
function stilpress__posttype_jobs() {
	$labels = [
		// Basic
		'name'                     => __( 'Jobs', 'stilpress' ),
		'singular_name'            => __( 'Job', 'stilpress' ),
		'menu_name'                => __( 'Jobs', 'stilpress' ),

		// Navigation & Lists
		'all_items'                => __( 'All Jobs', 'stilpress' ),
		'search_items'             => __( 'Search Jobs', 'stilpress' ),
		'not_found'                => __( 'No jobs found.', 'stilpress' ),
		'not_found_in_trash'       => __( 'No jobs found in Trash.', 'stilpress' ),

		// Actions
		'add_new'                  => __( 'Add New', 'stilpress' ),
		'add_new_item'             => __( 'Add New Job', 'stilpress' ),
		'edit_item'                => __( 'Edit Job', 'stilpress' ),
		'new_item'                 => __( 'New Job', 'stilpress' ),
		'view_item'                => __( 'View Job', 'stilpress' ),
		'view_items'               => __( 'View Jobs', 'stilpress' ),

		// Hierarchy
		'parent_item_colon'        => __( 'Parent Job:', 'stilpress' ),

		// Archive
		'archives'                 => __( 'Job Archives', 'stilpress' ),

		// Screen Reader / Accessibility
		'filter_items_list'        => __( 'Filter jobs list', 'stilpress' ),
		'items_list_navigation'    => __( 'Jobs list navigation', 'stilpress' ),
		'items_list'               => __( 'Jobs list', 'stilpress' ),

		// Block Editor Messages
		'item_published'           => __( 'Job published.', 'stilpress' ),
		'item_published_privately' => __( 'Job published privately.', 'stilpress' ),
		'item_reverted_to_draft'   => __( 'Job reverted to draft.', 'stilpress' ),
		'item_trashed'             => __( 'Job trashed.', 'stilpress' ),
		'item_scheduled'           => __( 'Job scheduled.', 'stilpress' ),
		'item_updated'             => __( 'Job updated.', 'stilpress' ),
		'item_link'                => __( 'Job Link', 'stilpress' ),
		'item_link_description'    => __( 'A link to a job.', 'stilpress' ),
	];

	$args = [
		'labels'              => $labels,
		'supports'            => [ 'title', 'editor', 'author', 'revisions' ],
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
		'publicly_queryable'  => true,
		'capability_type'     => [ 'job', 'jobs' ],
		'map_meta_cap'        => true,
		'delete_with_user'    => false,
		'show_in_rest'        => true,
		'rest_base'           => 'jobs',
		'rewrite'             => [
			'slug'       => 'job',
			'with_front' => false,
		],
		'menu_position'       => 25,
		'menu_icon'           => 'dashicons-megaphone',
	];

	register_post_type( 'job', $args );
}

add_action( 'init', 'stilpress__posttype_jobs' );


//
// register taxonomy job-category
//
function stilpress__taxonomy_jobs() {

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

	register_taxonomy( 'job-category', array( 'job' ), array(
		'labels'             => $labels,
		'hierarchical'       => true,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'query_var'          => true,
		'show_in_rest'       => true,
		'publicly_queryable' => false,
		'public'             => false,
		'capabilities'       => [
			'manage_terms' => 'manage_job_categories',
			'edit_terms'   => 'edit_job_categories',
			'delete_terms' => 'delete_job_categories',
			'assign_terms' => 'assign_job_categories',
		],
	) );
}

add_action( 'init', 'stilpress__taxonomy_jobs' );


//
// Add capabilities for job post type and taxonomy
//
add_action( 'admin_init', fn() =>
	stilpress__add_posttype_and_taxonomy_capabilities( 'job', 'jobs', 'job_categories' )
);