<?php
/**
 * Plugin rewrite functions.
 *
 * @package    CustomContentTeam
 * @subpackage Includes
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2015, Justin Tadlock
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Add custom rewrite rules.
add_action( 'init', 'cct_rewrite_rules', 5 );

/**
 * Adds custom rewrite rules for the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cct_rewrite_rules() {

	$member_type = cct_get_member_post_type();
	$author_slug  = cct_get_author_rewrite_slug();

	// Where to place the rewrite rules.  If no rewrite base, put them at the bottom.
	$after = cct_get_author_rewrite_base() ? 'top' : 'bottom';

	add_rewrite_rule( $author_slug . '/([^/]+)/page/?([0-9]{1,})/?$', 'index.php?post_type=' . $member_type . '&author_name=$matches[1]&paged=$matches[2]', $after );
	add_rewrite_rule( $author_slug . '/([^/]+)/?$',                   'index.php?post_type=' . $member_type . '&author_name=$matches[1]',                   $after );
}

/**
 * Returns the member rewrite slug used for single members.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_member_rewrite_slug() {
	$team_base = cct_get_team_rewrite_base();
	$member_base   = cct_get_member_rewrite_base();

	$slug = $member_base ? trailingslashit( $team_base ) . $member_base : $team_base;

	return apply_filters( 'cct_get_member_rewrite_slug', $slug );
}

/**
 * Returns the category rewrite slug used for category archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_category_rewrite_slug() {
	$team_base = cct_get_team_rewrite_base();
	$category_base  = cct_get_category_rewrite_base();

	$slug = $category_base ? trailingslashit( $team_base ) . $category_base : $team_base;

	return apply_filters( 'cct_get_category_rewrite_slug', $slug );
}

/**
 * Returns the tag rewrite slug used for tag archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_tag_rewrite_slug() {
	$team_base = cct_get_team_rewrite_base();
	$tag_base       = cct_get_tag_rewrite_base();

	$slug = $tag_base ? trailingslashit( $team_base ) . $tag_base : $team_base;

	return apply_filters( 'cct_get_tag_rewrite_slug', $slug );
}

/**
 * Returns the author rewrite slug used for author archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_author_rewrite_slug() {
	$team_base = cct_get_team_rewrite_base();
	$author_base  = cct_get_author_rewrite_base();

	$slug = $author_base ? trailingslashit( $team_base ) . $author_base : $team_base;

	return apply_filters( 'cct_get_author_rewrite_slug', $slug );
}
