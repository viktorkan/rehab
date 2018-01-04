<?php
/**
 * Plugin uninstall file.
 *
 * @package    CustomContentTeam
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2015, Justin Tadlock
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Make sure we're actually uninstalling the plugin.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	wp_die( sprintf( __( '%s should only be called when uninstalling the plugin.', 'custom-content-team' ), '<code>' . __FILE__ . '</code>' ) );

/* === Delete plugin options. === */

// Remove pre-1.0.0 options.
delete_option( 'plugin_custom_content_team' );

// Remove 1.0.0+ options.
delete_option( 'cct_settings'        );
delete_option( 'cct_sticky_members' );

/* === Remove capabilities added by the plugin. === */

// Get the administrator role.
$role = get_role( 'administrator' );

// If the administrator role exists, remove added capabilities for the plugin.
if ( ! is_null( $role ) ) {

	// Remove pre-1.0.0 caps.
	$role->remove_cap( 'manage_team'       );
	$role->remove_cap( 'create_team_items' );
	$role->remove_cap( 'edit_team_items'   );

	// Taxonomy caps.
	$role->remove_cap( 'manage_team_categories' );
	$role->remove_cap( 'manage_team_tags'       );

	// Post type caps.
	$role->remove_cap( 'create_team_members'           );
	$role->remove_cap( 'edit_team_members'             );
	$role->remove_cap( 'edit_others_team_members'      );
	$role->remove_cap( 'publish_team_members'          );
	$role->remove_cap( 'read_private_team_members'     );
	$role->remove_cap( 'delete_team_members'           );
	$role->remove_cap( 'delete_private_team_members'   );
	$role->remove_cap( 'delete_published_team_members' );
	$role->remove_cap( 'delete_others_team_members'    );
	$role->remove_cap( 'edit_private_team_members'     );
	$role->remove_cap( 'edit_published_team_members'   );
}
