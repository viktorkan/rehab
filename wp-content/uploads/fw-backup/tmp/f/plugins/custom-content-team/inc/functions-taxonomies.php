<?php
/**
 * File for registering custom taxonomies.
 *
 * @package    CustomContentTeam
 * @subpackage Includes
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2015, Justin Tadlock
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register taxonomies on the 'init' hook.
add_action( 'init', 'cct_register_taxonomies', 9 );

# Filter the term updated messages.
add_filter( 'term_updated_messages', 'cct_term_updated_messages', 5 );

/**
 * Returns the name of the team category taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_category_taxonomy() {

	return apply_filters( 'cct_get_category_taxonomy', 'team_category' );
}

/**
 * Returns the name of the team tag taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_tag_taxonomy() {

	return apply_filters( 'cct_get_tag_taxonomy', 'team_tag' );
}

/**
 * Returns the capabilities for the team category taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function cct_get_category_capabilities() {

	$caps = array(
		'manage_terms' => 'manage_team_categories',
		'edit_terms'   => 'manage_team_categories',
		'delete_terms' => 'manage_team_categories',
		'assign_terms' => 'edit_team_members'
	);

	return apply_filters( 'cct_get_category_capabilities', $caps );
}

/**
 * Returns the capabilities for the team tag taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function cct_get_tag_capabilities() {

	$caps = array(
		'manage_terms' => 'manage_team_tags',
		'edit_terms'   => 'manage_team_tags',
		'delete_terms' => 'manage_team_tags',
		'assign_terms' => 'edit_team_members',
	);

	return apply_filters( 'cct_get_tag_capabilities', $caps );
}

/**
 * Returns the labels for the team category taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function cct_get_category_labels() {

	$labels = array(
		'name'                       => __( 'Categories',                           'custom-content-team' ),
		'singular_name'              => __( 'Category',                             'custom-content-team' ),
		'menu_name'                  => __( 'Categories',                           'custom-content-team' ),
		'name_admin_bar'             => __( 'Category',                             'custom-content-team' ),
		'search_items'               => __( 'Search Categories',                    'custom-content-team' ),
		'popular_items'              => __( 'Popular Categories',                   'custom-content-team' ),
		'all_items'                  => __( 'All Categories',                       'custom-content-team' ),
		'edit_item'                  => __( 'Edit Category',                        'custom-content-team' ),
		'view_item'                  => __( 'View Category',                        'custom-content-team' ),
		'update_item'                => __( 'Update Category',                      'custom-content-team' ),
		'add_new_item'               => __( 'Add New Category',                     'custom-content-team' ),
		'new_item_name'              => __( 'New Category Name',                    'custom-content-team' ),
		'not_found'                  => __( 'No categories found.',                 'custom-content-team' ),
		'no_terms'                   => __( 'No categories',                        'custom-content-team' ),
		'pagination'                 => __( 'Categories list navigation',           'custom-content-team' ),
		'list'                       => __( 'Categories list',                      'custom-content-team' ),

		// Hierarchical only.
		'select_name'                => __( 'Select Category',                      'custom-content-team' ),
		'parent_item'                => __( 'Parent Category',                      'custom-content-team' ),
		'parent_item_colon'          => __( 'Parent Category:',                     'custom-content-team' ),
	);

	return apply_filters( 'cct_get_category_labels', $labels );
}

/**
 * Returns the labels for the team tag taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function cct_get_tag_labels() {

	$labels = array(
		'name'                       => __( 'Tags',                           'custom-content-team' ),
		'singular_name'              => __( 'Tag',                            'custom-content-team' ),
		'menu_name'                  => __( 'Tags',                           'custom-content-team' ),
		'name_admin_bar'             => __( 'Tag',                            'custom-content-team' ),
		'search_items'               => __( 'Search Tags',                    'custom-content-team' ),
		'popular_items'              => __( 'Popular Tags',                   'custom-content-team' ),
		'all_items'                  => __( 'All Tags',                       'custom-content-team' ),
		'edit_item'                  => __( 'Edit Tag',                       'custom-content-team' ),
		'view_item'                  => __( 'View Tag',                       'custom-content-team' ),
		'update_item'                => __( 'Update Tag',                     'custom-content-team' ),
		'add_new_item'               => __( 'Add New Tag',                    'custom-content-team' ),
		'new_item_name'              => __( 'New Tag Name',                   'custom-content-team' ),
		'not_found'                  => __( 'No tags found.',                 'custom-content-team' ),
		'no_terms'                   => __( 'No tags',                        'custom-content-team' ),
		'pagination'                 => __( 'Tags list navigation',           'custom-content-team' ),
		'list'                       => __( 'Tags list',                      'custom-content-team' ),

		// Non-hierarchical only.
		'separate_items_with_commas' => __( 'Separate tags with commas',      'custom-content-team' ),
		'add_or_remove_items'        => __( 'Add or remove tags',             'custom-content-team' ),
		'choose_from_most_used'      => __( 'Choose from the most used tags', 'custom-content-team' ),
	);

	return apply_filters( 'cct_get_tag_labels', $labels );
}

/**
 * Register taxonomies for the plugin.
 *
 * @since  0.1.0
 * @access public
 * @return void.
 */
function cct_register_taxonomies() {

	// Set up the arguments for the team category taxonomy.
	$cat_args = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'query_var'         => cct_get_category_taxonomy(),
		'capabilities'      => cct_get_category_capabilities(),
		'labels'            => cct_get_category_labels(),

		// The rewrite handles the URL structure.
		'rewrite' => array(
			'slug'         => cct_get_category_rewrite_slug(),
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_NONE
		),
	);

	// Set up the arguments for the team tag taxonomy.
	$tag_args = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => false,
		'query_var'         => cct_get_tag_taxonomy(),
		'capabilities'      => cct_get_tag_capabilities(),
		'labels'            => cct_get_tag_labels(),

		// The rewrite handles the URL structure.
		'rewrite' => array(
			'slug'         => cct_get_tag_rewrite_slug(),
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_NONE
		),
	);

	// Register the taxonomies.
	register_taxonomy( cct_get_category_taxonomy(), cct_get_member_post_type(), apply_filters( 'cct_category_taxonomy_args', $cat_args ) );
	register_taxonomy( cct_get_tag_taxonomy(),      cct_get_member_post_type(), apply_filters( 'cct_tag_taxonomy_args',      $tag_args ) );
}

/**
 * Filters the term updated messages in the admin.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $messages
 * @return array
 */
function cct_term_updated_messages( $messages ) {

	$cat_taxonomy = cct_get_category_taxonomy();
	$tag_taxonomy = cct_get_tag_taxonomy();

	// Add the team category messages.
	$messages[ $cat_taxonomy ] = array(
		0 => '',
		1 => __( 'Category added.',       'custom-content-team' ),
		2 => __( 'Category deleted.',     'custom-content-team' ),
		3 => __( 'Category updated.',     'custom-content-team' ),
		4 => __( 'Category not added.',   'custom-content-team' ),
		5 => __( 'Category not updated.', 'custom-content-team' ),
		6 => __( 'Categories deleted.',   'custom-content-team' ),
	);

	// Add the team tag messages.
	$messages[ $tag_taxonomy ] = array(
		0 => '',
		1 => __( 'Tag added.',       'custom-content-team' ),
		2 => __( 'Tag deleted.',     'custom-content-team' ),
		3 => __( 'Tag updated.',     'custom-content-team' ),
		4 => __( 'Tag not added.',   'custom-content-team' ),
		5 => __( 'Tag not updated.', 'custom-content-team' ),
		6 => __( 'Tags deleted.',    'custom-content-team' ),
	);

	return $messages;
}
