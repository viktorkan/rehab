<?php
/**
 * Registers metadata and related functions for the plugin.
 *
 * @package    CustomContentTeam
 * @subpackage Includes
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2015, Justin Tadlock
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register meta on the 'init' hook.
add_action( 'init', 'cct_register_meta' );

/**
 * Registers custom metadata for the plugin.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function cct_register_meta() {

	register_meta( 'post', 'position',     	'wp_strip_all_tags', '__return_false' );
	register_meta( 'post', 'address',      	'wp_strip_all_tags', '__return_false' );
	register_meta( 'post', 'phone',        	'wp_strip_all_tags', '__return_false' );
	register_meta( 'post', 'email',        	'wp_strip_all_tags', '__return_false' );
	register_meta( 'post', 'skill_1',   	'absint', '__return_false' );
	register_meta( 'post', 'skill_name_1', 	'wp_strip_all_tags', '__return_false' );
	register_meta( 'post', 'skill_2',   	'absint', '__return_false' );
	register_meta( 'post', 'skill_name_2', 	'wp_strip_all_tags', '__return_false' );
	register_meta( 'post', 'skill_3',   	'absint', '__return_false' );
	register_meta( 'post', 'skill_name_3', 	'wp_strip_all_tags', '__return_false' );
	register_meta( 'post', 'skill_4',   	'absint', '__return_false' );
	register_meta( 'post', 'skill_name_4', 	'wp_strip_all_tags', '__return_false' );
	register_meta( 'post', 'social_quote', 'wp_strip_all_tags', '__return_false' );
	register_meta( 'post', 'facebook',     'esc_url', '__return_false' );
	register_meta( 'post', 'twitter',      'esc_url', '__return_false' );
	register_meta( 'post', 'googleplus',   'esc_url', '__return_false' );
	register_meta( 'post', 'linkedin',     'esc_url', '__return_false' );
	register_meta( 'post', 'pinterest',    'esc_url', '__return_false' );
	register_meta( 'post', 'instagram',    'esc_url', '__return_false' );
	register_meta( 'post', 'slide_title', 'wp_strip_all_tags', '__return_false' );
	register_meta( 'post', 'short_desc', 'wp_strip_all_tags', '__return_false' );
}

/**
 * Returns member metadata.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @param  string  $meta_key
 * @return mixed
 */
function cct_get_member_meta( $post_id, $meta_key ) {

	return get_post_meta( $post_id, $meta_key, true );
}

/**
 * Adds/updates member metadata.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @param  string  $meta_key
 * @param  mixed   $meta_value
 * @return bool
 */
function cct_set_member_meta( $post_id, $meta_key, $meta_value ) {

	return update_post_meta( $post_id, $meta_key, $meta_value );
}

/**
 * Deletes member metadata.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @param  string  $meta_key
 * @return mixed
 */
function cct_delete_member_meta( $post_id, $meta_key ) {

	return delete_post_meta( $post_id, $meta_key );
}
