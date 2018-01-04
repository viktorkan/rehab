<?php
/**
 * Plugin options functions.
 *
 * @package    CustomContentTeam
 * @subpackage Includes
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2015, Justin Tadlock
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Returns the team title.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_team_title() {
	return apply_filters( 'cct_get_team_title', cct_get_setting( 'team_title' ) );
}

/**
 * Returns the team description.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_team_description() {
	return apply_filters( 'cct_get_team_description', cct_get_setting( 'team_description' ) );
}

/**
 * Returns the team rewrite base. Used for the member archive and as a prefix for taxonomy,
 * author, and any other slugs.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_team_rewrite_base() {
	return apply_filters( 'cct_get_team_rewrite_base', cct_get_setting( 'team_rewrite_base' ) );
}

/**
 * Returns the member rewrite base. Used for single members.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_member_rewrite_base() {
	return apply_filters( 'cct_get_member_rewrite_base', cct_get_setting( 'member_rewrite_base' ) );
}

/**
 * Returns the category rewrite base. Used for category archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_category_rewrite_base() {
	return apply_filters( 'cct_get_category_rewrite_base', cct_get_setting( 'category_rewrite_base' ) );
}

/**
 * Returns the tag rewrite base. Used for tag archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_tag_rewrite_base() {
	return apply_filters( 'cct_get_tag_rewrite_base', cct_get_setting( 'tag_rewrite_base' ) );
}

/**
 * Returns the author rewrite base. Used for author archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_author_rewrite_base() {
	return apply_filters( 'cct_get_author_rewrite_base', cct_get_setting( 'author_rewrite_base' ) );
}

/**
 * Returns the default category term ID.
 *
 * @since  1.0.0
 * @access public
 * @return int
 */
function cct_get_default_category() {
	return apply_filters( 'cct_get_default_category', 0 );
}

/**
 * Returns the default tag term ID.
 *
 * @since  1.0.0
 * @access public
 * @return int
 */
function cct_get_default_tag() {
	return apply_filters( 'cct_get_default_tag', 0 );
}

/**
 * Returns a plugin setting.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $setting
 * @return mixed
 */
function cct_get_setting( $setting ) {

	$defaults = cct_get_default_settings();
	$settings = wp_parse_args( get_option( 'cct_settings', $defaults ), $defaults );

	return isset( $settings[ $setting ] ) ? $settings[ $setting ] : false;
}

/**
 * Returns the default settings for the plugin.
 *
 * @since  0.1.0
 * @access public
 * @return array
 */
function cct_get_default_settings() {

	$settings = array(
		'team_title'        => __( 'Team', 'custom-content-team' ),
		'team_description'  => '',
		'team_rewrite_base' => 'team',
		'member_rewrite_base'   => 'members',
		'category_rewrite_base'  => 'categories',
		'tag_rewrite_base'       => 'tags',
		'author_rewrite_base'    => 'authors'
	);

	return $settings;
}
