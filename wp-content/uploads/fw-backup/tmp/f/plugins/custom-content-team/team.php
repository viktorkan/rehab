<?php
/**
 * Plugin Name: Custom Content Team
 * Description: Team manager for WordPress.  This plugin allows you to manage, edit, and create new team items in an unlimited number of teams.
 * Version:     1.0.1
 * Author:      Justin Tadlock
 * Author URI:  http://themehybrid.com
 * Text Domain: custom-content-team
 * Domain Path: /languages
 *
 * The Custom Content Team plugin was created to solve the problem of theme developers continuing
 * to incorrectly add custom post types to handle team within their themes.  This plugin allows
 * any theme developer to build a "team" theme without having to code the functionality.  This
 * gives more time for design and makes users happy because their data isn't lost when they switch to
 * a new theme.  Oh, and, this plugin lets creative folk put together a team of their work on
 * their site.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package   CustomContentTeam
 * @version   1.0.1
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2013-2015, Justin Tadlock
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Singleton class that sets up and initializes the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
final class CCT_Plugin {

	/**
	 * Directory path to the plugin folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_path = '';

	/**
	 * Directory URI to the plugin folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_uri = '';

	/**
	 * JavaScript directory URI.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $js_uri = '';

	/**
	 * CSS directory URI.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $css_uri = '';

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup();
			$instance->includes();
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Magic method to output a string if trying to use the object as a string.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __toString() {
		return 'custom-content-team';
	}

	/**
	 * Magic method to keep the object from being cloned.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Whoah, partner!', 'custom-content-team' ), '1.0.0' );
	}

	/**
	 * Magic method to keep the object from being unserialized.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Whoah, partner!', 'custom-content-team' ), '1.0.0' );
	}

	/**
	 * Magic method to prevent a fatal error when calling a method that doesn't exist.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __call( $method = '', $args = array() ) {
		_doing_it_wrong( "Custom_Content_Team::{$method}", __( 'Method does not exist.', 'custom-content-team' ), '1.0.0' );
		unset( $method, $args );
		return null;
	}

	/**
	 * Initial plugin setup.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup() {

		$this->dir_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->dir_uri  = trailingslashit( plugin_dir_url(  __FILE__ ) );

		$this->js_uri  = trailingslashit( $this->dir_uri . 'js'  );
		$this->css_uri = trailingslashit( $this->dir_uri . 'css' );
	}

	/**
	 * Loads include and admin files for the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function includes() {

		// Load functions files.
		require_once( $this->dir_path . 'inc/functions-filters.php'    );
		require_once( $this->dir_path . 'inc/functions-options.php'    );
		require_once( $this->dir_path . 'inc/functions-meta.php'       );
		require_once( $this->dir_path . 'inc/functions-rewrite.php'    );
		require_once( $this->dir_path . 'inc/functions-post-types.php' );
		require_once( $this->dir_path . 'inc/functions-taxonomies.php' );
		require_once( $this->dir_path . 'inc/functions-member.php'    );
		require_once( $this->dir_path . 'inc/functions-deprecated.php' );

		// Load template files.
		require_once( $this->dir_path . 'inc/template-member.php'  );
		require_once( $this->dir_path . 'inc/template-general.php'  );

		// Load admin files.
		if ( is_admin() ) {
			require_once( $this->dir_path . 'admin/functions-admin.php'       );
			require_once( $this->dir_path . 'admin/class-manage-members.php' );
			require_once( $this->dir_path . 'admin/class-member-edit.php'    );
			require_once( $this->dir_path . 'admin/class-settings.php'        );
		}
	}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Internationalize the text strings used.
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 2 );

		// Register activation hook.
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
	}

	/**
	 * Loads the translation files.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function i18n() {

		load_plugin_textdomain( 'custom-content-team', false, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) . 'languages' );
	}

	/**
	 * Method that runs only when the plugin is activated.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global $wpdb
	 * @return void
	 */
	public function activation() {

		// Temp. code to make sure post types and taxonomies are correct.
		global $wpdb;

		$wpdb->query( "UPDATE {$wpdb->posts}         SET post_type = 'team_member'  WHERE post_type = 'team_item'" );
		$wpdb->query( "UPDATE {$wpdb->postmeta}      SET meta_key  = 'team_item_url' WHERE meta_key  = 'url'"            );
		$wpdb->query( "UPDATE {$wpdb->term_taxonomy} SET taxonomy  = 'team_category' WHERE taxonomy  = 'team'"      );

		// Get the administrator role.
		$role = get_role( 'administrator' );

		// If the administrator role exists, add required capabilities for the plugin.
		if ( ! is_null( $role ) ) {

			// Remove old caps.
			$role->remove_cap( 'manage_team'       );
			$role->remove_cap( 'create_team_items' );
			$role->remove_cap( 'edit_team_items'   );

			// Taxonomy caps.
			$role->add_cap( 'manage_team_categories' );
			$role->add_cap( 'manage_team_tags'       );

			// Post type caps.
			$role->add_cap( 'create_team_members'           );
			$role->add_cap( 'edit_team_members'             );
			$role->add_cap( 'edit_others_team_members'      );
			$role->add_cap( 'publish_team_members'          );
			$role->add_cap( 'read_private_team_members'     );
			$role->add_cap( 'delete_team_members'           );
			$role->add_cap( 'delete_private_team_members'   );
			$role->add_cap( 'delete_published_team_members' );
			$role->add_cap( 'delete_others_team_members'    );
			$role->add_cap( 'edit_private_team_members'     );
			$role->add_cap( 'edit_published_team_members'   );
		}
	}
}

/**
 * Gets the instance of the `CCT_Plugin` class.  This function is useful for quickly grabbing data
 * used throughout the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function cct_plugin() {
	return CCT_Plugin::get_instance();
}

// Let's do this thang!
cct_plugin();
