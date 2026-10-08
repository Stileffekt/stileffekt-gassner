<?php


//
// register custom post type faq
//
function stilpress__posttype_faqs() {

	$labels = [
		// Basic
		'name'                     => __( 'FAQs', 'stilpress' ),
		'singular_name'            => __( 'FAQ', 'stilpress' ),
		'menu_name'                => __( 'FAQs', 'stilpress' ),

		// Navigation & Lists
		'all_items'                => __( 'All FAQs', 'stilpress' ),
		'search_items'             => __( 'Search FAQs', 'stilpress' ),
		'not_found'                => __( 'No FAQs found.', 'stilpress' ),
		'not_found_in_trash'       => __( 'No FAQs found in Trash.', 'stilpress' ),

		// Actions
		'add_new'                  => __( 'Add New', 'stilpress' ),
		'add_new_item'             => __( 'Add New FAQ', 'stilpress' ),
		'edit_item'                => __( 'Edit FAQ', 'stilpress' ),
		'new_item'                 => __( 'New FAQ', 'stilpress' ),
		'view_item'                => __( 'View FAQ', 'stilpress' ),
		'view_items'               => __( 'View FAQs', 'stilpress' ),

		// Hierarchy
		'parent_item_colon'        => __( 'Parent FAQ:', 'stilpress' ),

		// Archive
		'archives'                 => __( 'FAQ Archives', 'stilpress' ),

		// Screen Reader / Accessibility
		'filter_items_list'        => __( 'Filter FAQs list', 'stilpress' ),
		'items_list_navigation'    => __( 'FAQs list navigation', 'stilpress' ),
		'items_list'               => __( 'FAQs list', 'stilpress' ),

		// Block Editor Messages
		'item_published'           => __( 'FAQ published.', 'stilpress' ),
		'item_published_privately' => __( 'FAQ published privately.', 'stilpress' ),
		'item_reverted_to_draft'   => __( 'FAQ reverted to draft.', 'stilpress' ),
		'item_trashed'             => __( 'FAQ trashed.', 'stilpress' ),
		'item_scheduled'           => __( 'FAQ scheduled.', 'stilpress' ),
		'item_updated'             => __( 'FAQ updated.', 'stilpress' ),
		'item_link'                => __( 'FAQ Link', 'stilpress' ),
		'item_link_description'    => __( 'A link to a FAQ.', 'stilpress' ),
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
		'capability_type'     => [ 'faq', 'faqs' ],
		'map_meta_cap'        => true,
		'delete_with_user'    => false,
		'show_in_rest'        => true,
		'rest_base'           => 'faqs',
		'menu_position'       => 24,
		'menu_icon'           => 'dashicons-editor-help',
	];

	register_post_type( 'faq', $args );
}

add_action( 'init', 'stilpress__posttype_faqs' );


//
// register custom taxonomy faq
//
function stilpress__taxonomy_faqs_categories() {

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

	register_taxonomy( 'faq-category', array( 'faq' ), array(
		'labels'             => $labels,
		'hierarchical'       => true,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'query_var'          => true,
		'show_in_rest'       => true,
		'publicly_queryable' => false,
		'public'             => false,
		'capabilities'       => [
			'manage_terms' => 'manage_faq_categories',
			'edit_terms'   => 'edit_faq_categories',
			'delete_terms' => 'delete_faq_categories',
			'assign_terms' => 'assign_faq_categories',
		],
	) );
}

add_action( 'init', 'stilpress__taxonomy_faqs_categories' );


//
// Add capabilities for faq post type and taxonomy
//
add_action( 'admin_init', fn() =>
	stilpress__add_posttype_and_taxonomy_capabilities( 'faq', 'faqs', 'faq_categories' )
);
