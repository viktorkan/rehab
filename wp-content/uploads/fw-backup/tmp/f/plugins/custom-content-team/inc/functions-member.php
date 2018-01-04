<?php
/**
 * Plugin functions related to the member post type.
 *
 * @package    CustomContentTeam
 * @subpackage Includes
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2015, Justin Tadlock
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Adds a member to the list of sticky members.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $member_id
 * @return bool
 */
function cct_add_sticky_member( $member_id ) {
	$member_id = cct_get_member_id( $member_id );

	if ( ! cct_is_member_sticky( $member_id ) )
		return update_option( 'cct_sticky_members', array_unique( array_merge( cct_get_sticky_members(), array( $member_id ) ) ) );

	return false;
}

/**
 * Removes a member from the list of sticky members.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $member_id
 * @return bool
 */
function cct_remove_sticky_member( $member_id ) {
	$member_id = cct_get_member_id( $member_id );

	if ( cct_is_member_sticky( $member_id ) ) {
		$stickies = cct_get_sticky_members();
		$key      = array_search( $member_id, $stickies );

		if ( isset( $stickies[ $key ] ) ) {
			unset( $stickies[ $key ] );
			return update_option( 'cct_sticky_members', array_unique( $stickies ) );
		}
	}

	return false;
}

/**
 * Returns an array of sticky members.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function cct_get_sticky_members() {
	return apply_filters( 'cct_get_sticky_members', get_option( 'cct_sticky_members', array() ) );
}


if ( ! function_exists( 'cct_team_scripts' ) ) :
    function cct_team_scripts() {
        // Load plugin stylesheet.
        wp_enqueue_style( 'cct-team', plugins_url( '../css/team.css', __FILE__ ) );
	    // Load plugin javascript.
	    //wp_enqueue_script( 'cct-team-js', plugins_url( '../js/team.js', __FILE__ ), array(), 1, true );
	    wp_enqueue_script( 'cct-team-js', plugins_url( '../js/team.js', __FILE__ ), array( 'jquery' ), "all", true );

	    // in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
	    wp_localize_script( 'cct-team-js', 'script_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'cct_team_scripts' );