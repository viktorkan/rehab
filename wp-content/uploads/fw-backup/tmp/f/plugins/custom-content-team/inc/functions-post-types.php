<?php
/**
 * File for registering custom post types.
 *
 * @package    CustomContentTeam
 * @subpackage Includes
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2015, Justin Tadlock
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register custom post types on the 'init' hook.
add_action( 'init', 'cct_register_post_types' );

# Filter the "enter title here" text.
add_filter( 'enter_title_here', 'cct_enter_title_here', 10, 2 );

# Filter the bulk and post updated messages.
add_filter( 'bulk_post_updated_messages', 'cct_bulk_post_updated_messages', 5, 2 );
add_filter( 'post_updated_messages',      'cct_post_updated_messages',      5    );

/**
 * Returns the name of the member post type.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_member_post_type() {

	return apply_filters( 'cct_get_member_post_type', 'team_member' );
}

/**
 * Returns the capabilities for the member post type.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function cct_get_member_capabilities() {

	$caps = array(

		// meta caps (don't assign these to roles)
		'edit_post'              => 'edit_team_member',
		'read_post'              => 'read_team_member',
		'delete_post'            => 'delete_team_member',

		// primitive/meta caps
		'create_posts'           => 'create_team_members',

		// primitive caps used outside of map_meta_cap()
		'edit_posts'             => 'edit_team_members',
		'edit_others_posts'      => 'edit_others_team_members',
		'publish_posts'          => 'publish_team_members',
		'read_private_posts'     => 'read_private_team_members',

		// primitive caps used inside of map_meta_cap()
		'read'                   => 'read',
		'delete_posts'           => 'delete_team_members',
		'delete_private_posts'   => 'delete_private_team_members',
		'delete_published_posts' => 'delete_published_team_members',
		'delete_others_posts'    => 'delete_others_team_members',
		'edit_private_posts'     => 'edit_private_team_members',
		'edit_published_posts'   => 'edit_published_team_members'
	);

	return apply_filters( 'cct_get_member_capabilities', $caps );
}

/**
 * Returns the labels for the member post type.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function cct_get_member_labels() {

	$labels = array(
		'name'                  => __( 'Members',                   'custom-content-team' ),
		'singular_name'         => __( 'Member',                    'custom-content-team' ),
		'menu_name'             => __( 'Team',                     'custom-content-team' ),
		'name_admin_bar'        => __( 'Member',                    'custom-content-team' ),
		'add_new'               => __( 'New Member',                'custom-content-team' ),
		'add_new_item'          => __( 'Add New Member',            'custom-content-team' ),
		'edit_item'             => __( 'Edit Member',               'custom-content-team' ),
		'new_item'              => __( 'New Member',                'custom-content-team' ),
		'view_item'             => __( 'View Member',               'custom-content-team' ),
		'search_items'          => __( 'Search Members',            'custom-content-team' ),
		'not_found'             => __( 'No members found',          'custom-content-team' ),
		'not_found_in_trash'    => __( 'No members found in trash', 'custom-content-team' ),
		'all_items'             => __( 'Members',                   'custom-content-team' ),
		'featured_image'        => __( 'Member Image',              'custom-content-team' ),
		'set_featured_image'    => __( 'Set member image',          'custom-content-team' ),
		'remove_featured_image' => __( 'Remove member image',       'custom-content-team' ),
		'use_featured_image'    => __( 'Use as member image',       'custom-content-team' ),
		'insert_into_item'      => __( 'Insert into member',        'custom-content-team' ),
		'uploaded_to_this_item' => __( 'Uploaded to this member',   'custom-content-team' ),
		'views'                 => __( 'Filter members list',       'custom-content-team' ),
		'pagination'            => __( 'Members list navigation',   'custom-content-team' ),
		'list'                  => __( 'Members list',              'custom-content-team' ),

		// Custom labels b/c WordPress doesn't have anything to handle this.
		'archive_title'         => cct_get_team_title(),
	);

	return apply_filters( 'cct_get_member_labels', $labels );
}

/**
 * Registers post types needed by the plugin.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function cct_register_post_types() {

	// Set up the arguments for the team member post type.
	$member_args = array(
		'description'         => cct_get_team_description(),
		'public'              => true,
		'publicly_queryable'  => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'exclude_from_search' => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-universal-access',
		'can_export'          => true,
		'delete_with_user'    => false,
		'hierarchical'        => false,
		'has_archive'         => cct_get_team_rewrite_base(),
		'query_var'           => cct_get_member_post_type(),
		'capability_type'     => 'team_member',
		'map_meta_cap'        => true,
		'capabilities'        => cct_get_member_capabilities(),
		'labels'              => cct_get_member_labels(),

		// The rewrite handles the URL structure.
		'rewrite' => array(
			'slug'       => cct_get_member_rewrite_slug(),
			'with_front' => false,
			'pages'      => true,
			'feeds'      => true,
			'ep_mask'    => EP_PERMALINK,
		),

		// What features the post type supports.
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'author',
			'thumbnail',
			'post-formats',
			//'comments',
			'revisions',

			// Theme/Plugin feature support.
			'custom-background', // Custom Background Extended
			'custom-header',     // Custom Header Extended
		)
	);

	// Register the post types.
	register_post_type( cct_get_member_post_type(), apply_filters( 'cct_member_post_type_args', $member_args ) );
}

/**
 * Custom "enter title here" text.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $title
 * @param  object  $post
 * @return string
 */
function cct_enter_title_here( $title, $post ) {

	return cct_get_member_post_type() === $post->post_type ? esc_html__( 'Enter member name', 'custom-content-team' ) : '';
}

/**
 * Adds custom post updated messages on the edit post screen.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $messages
 * @global object $post
 * @global int    $post_ID
 * @return array
 */
function cct_post_updated_messages( $messages ) {
	global $post, $post_ID;

	$member_type = cct_get_member_post_type();

	if ( $member_type !== $post->post_type )
		return $messages;

	// Get permalink and pteam URLs.
	$permalink   = get_permalink( $post_ID );
	$pteam_url = function_exists( 'get_pteam_post_link' ) ? get_pteam_post_link( $post ) : apply_filters( 'pteam_post_link', add_query_arg( array( 'pteam' => true ), $permalink ), $post );

	// Translators: Scheduled member date format. See http://php.net/date
	$scheduled_date = date_i18n( __( 'M j, Y @ H:i', 'custom-content-team' ), strtotime( $post->post_date ) );

	// Set up view links.
	$pteam_link   = sprintf( ' <a target="_blank" href="%1$s">%2$s</a>', esc_url( $pteam_url ), esc_html__( 'Pteam member', 'custom-content-team' ) );
	$scheduled_link = sprintf( ' <a target="_blank" href="%1$s">%2$s</a>', esc_url( $permalink ),   esc_html__( 'Pteam member', 'custom-content-team' ) );
	$view_link      = sprintf( ' <a href="%1$s">%2$s</a>',                 esc_url( $permalink ),   esc_html__( 'View member',    'custom-content-team' ) );

	// Post updated messages.
	$messages[ $member_type ] = array(
		 1 => esc_html__( 'Member updated.', 'custom-content-team' ) . $view_link,
		 4 => esc_html__( 'Member updated.', 'custom-content-team' ),
		 // Translators: %s is the date and time of the revision.
		 5 => isset( $_GET['revision'] ) ? sprintf( esc_html__( 'Member restored to revision from %s.', 'custom-content-team' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		 6 => esc_html__( 'Member published.', 'custom-content-team' ) . $view_link,
		 7 => esc_html__( 'Member saved.', 'custom-content-team' ),
		 8 => esc_html__( 'Member submitted.', 'custom-content-team' ) . $pteam_link,
		 9 => sprintf( esc_html__( 'Member scheduled for: %s.', 'custom-content-team' ), "<strong>{$scheduled_date}</strong>" ) . $scheduled_link,
		10 => esc_html__( 'Member draft updated.', 'custom-content-team' ) . $pteam_link,
	);

	return $messages;
}

/**
 * Adds custom bulk post updated messages on the manage members screen.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $messages
 * @param  array  $counts
 * @return array
 */
function cct_bulk_post_updated_messages( $messages, $counts ) {

	$type = cct_get_member_post_type();

	$messages[ $type ]['updated']   = _n( '%s member updated.',                             '%s members updated.',                               $counts['updated'],   'custom-content-team' );
	$messages[ $type ]['locked']    = _n( '%s member not updated, somebody is editing it.', '%s members not updated, somebody is editing them.', $counts['locked'],    'custom-content-team' );
	$messages[ $type ]['deleted']   = _n( '%s member permanently deleted.',                 '%s members permanently deleted.',                   $counts['deleted'],   'custom-content-team' );
	$messages[ $type ]['trashed']   = _n( '%s member moved to the Trash.',                  '%s members moved to the trash.',                    $counts['trashed'],   'custom-content-team' );
	$messages[ $type ]['untrashed'] = _n( '%s member restored from the Trash.',             '%s members restored from the trash.',               $counts['untrashed'], 'custom-content-team' );

	return $messages;
}
