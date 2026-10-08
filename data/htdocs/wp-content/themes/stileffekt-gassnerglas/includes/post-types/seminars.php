<?php


//
// register custom post type seminars
//
function stilpress__posttype_seminars() {
	$labels = [
		// Basic
		'name'                     => __( 'Seminars', 'stilpress' ),
		'singular_name'            => __( 'Seminar', 'stilpress' ),
		'menu_name'                => __( 'Seminars', 'stilpress' ),

		// Navigation & Lists
		'all_items'                => __( 'All Seminars', 'stilpress' ),
		'search_items'             => __( 'Search Seminars', 'stilpress' ),
		'not_found'                => __( 'No seminars found.', 'stilpress' ),
		'not_found_in_trash'       => __( 'No seminars found in Trash.', 'stilpress' ),

		// Actions
		'add_new'                  => __( 'Add New', 'stilpress' ),
		'add_new_item'             => __( 'Add New Seminar', 'stilpress' ),
		'edit_item'                => __( 'Edit Seminar', 'stilpress' ),
		'new_item'                 => __( 'New Seminar', 'stilpress' ),
		'view_item'                => __( 'View Seminar', 'stilpress' ),
		'view_items'               => __( 'View Seminars', 'stilpress' ),

		// Hierarchy
		'parent_item_colon'        => __( 'Parent Seminar:', 'stilpress' ),

		// Archive
		'archives'                 => __( 'Seminar Archives', 'stilpress' ),

		// Screen Reader / Accessibility
		'filter_items_list'        => __( 'Filter seminars list', 'stilpress' ),
		'items_list_navigation'    => __( 'Seminars list navigation', 'stilpress' ),
		'items_list'               => __( 'Seminars list', 'stilpress' ),

		// Block Editor Messages
		'item_published'           => __( 'Seminar published.', 'stilpress' ),
		'item_published_privately' => __( 'Seminar published privately.', 'stilpress' ),
		'item_reverted_to_draft'   => __( 'Seminar reverted to draft.', 'stilpress' ),
		'item_trashed'             => __( 'Seminar trashed.', 'stilpress' ),
		'item_scheduled'           => __( 'Seminar scheduled.', 'stilpress' ),
		'item_updated'             => __( 'Seminar updated.', 'stilpress' ),
		'item_link'                => __( 'Seminar Link', 'stilpress' ),
		'item_link_description'    => __( 'A link to a seminar.', 'stilpress' ),
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
		'capability_type'     => [ 'seminar', 'seminars' ],
		'map_meta_cap'        => true,
		'delete_with_user'    => false,
		'show_in_rest'        => true,
		'rest_base'           => 'seminars',
		'rewrite'             => [
			'slug'       => 'seminar',
			'with_front' => false,
		],
		'menu_position'       => 29,
		'menu_icon'           => 'dashicons-welcome-learn-more',
	];

	register_post_type( 'seminar', $args );
}

add_action( 'init', 'stilpress__posttype_seminars' );


//
// Add capabilities for seminar post type
//
add_action( 'admin_init', fn() =>
	stilpress__add_posttype_and_taxonomy_capabilities( 'seminar', 'seminars' )
);