<?php


//
// register custom post type references
//
function stilpress__posttype_references() {
	$labels = [
		// Basic
		'name'                     => __( 'References', 'stilpress' ),
		'singular_name'            => __( 'Reference', 'stilpress' ),
		'menu_name'                => __( 'References', 'stilpress' ),

		// Navigation & Lists
		'all_items'                => __( 'All References', 'stilpress' ),
		'search_items'             => __( 'Search References', 'stilpress' ),
		'not_found'                => __( 'No references found.', 'stilpress' ),
		'not_found_in_trash'       => __( 'No references found in Trash.', 'stilpress' ),

		// Actions
		'add_new'                  => __( 'Add New', 'stilpress' ),
		'add_new_item'             => __( 'Add New Reference', 'stilpress' ),
		'edit_item'                => __( 'Edit Reference', 'stilpress' ),
		'new_item'                 => __( 'New Reference', 'stilpress' ),
		'view_item'                => __( 'View Reference', 'stilpress' ),
		'view_items'               => __( 'View References', 'stilpress' ),

		// Hierarchy
		'parent_item_colon'        => __( 'Parent Reference:', 'stilpress' ),

		// Archive
		'archives'                 => __( 'Reference Archives', 'stilpress' ),

		// Screen Reader / Accessibility
		'filter_items_list'        => __( 'Filter references list', 'stilpress' ),
		'items_list_navigation'    => __( 'References list navigation', 'stilpress' ),
		'items_list'               => __( 'References list', 'stilpress' ),

		// Block Editor Messages
		'item_published'           => __( 'Reference published.', 'stilpress' ),
		'item_published_privately' => __( 'Reference published privately.', 'stilpress' ),
		'item_reverted_to_draft'   => __( 'Reference reverted to draft.', 'stilpress' ),
		'item_trashed'             => __( 'Reference trashed.', 'stilpress' ),
		'item_scheduled'           => __( 'Reference scheduled.', 'stilpress' ),
		'item_updated'             => __( 'Reference updated.', 'stilpress' ),
		'item_link'                => __( 'Reference Link', 'stilpress' ),
		'item_link_description'    => __( 'A link to a reference.', 'stilpress' ),
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
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => [ 'reference', 'references' ],
		'map_meta_cap'        => true,
		'delete_with_user'    => false,
		'show_in_rest'        => true,
		'rest_base'           => 'references',
		'rewrite'             => [
			'slug'       => 'reference',
			'with_front' => false,
		],
		'menu_position'       => 28,
		'menu_icon'           => 'dashicons-portfolio',
	];

	register_post_type( 'reference', $args );
}

add_action( 'init', 'stilpress__posttype_references' );

//
// register custom taxonomy reference
//
function stilpress__taxonomy_reference_categories() {

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

	register_taxonomy( 'reference-category', array( 'reference' ), array(
		'labels'             => $labels,
		'hierarchical'       => true,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'query_var'          => true,
		'show_in_rest'       => true,
		'publicly_queryable' => false,
		'public'             => false,
		'capabilities'       => [
			'manage_terms' => 'manage_reference_categories',
			'edit_terms'   => 'edit_reference_categories',
			'delete_terms' => 'delete_reference_categories',
			'assign_terms' => 'assign_reference_categories',
		],
	) );
}

add_action( 'init', 'stilpress__taxonomy_reference_categories' );


//
// Add capabilities for reference post type and taxonomy
//
add_action( 'admin_init', fn() =>
	stilpress__add_posttype_and_taxonomy_capabilities( 'reference', 'references', 'reference_categories' )
);
