<?php
/**
 * Plugin Name: Ashlesha Core
 * Description: Creates Shortcodes and Custom Post Types
 * Version:     1.0.0
 * Author:      designtrail
 * Author URI:  http://themeforest.net/user/designtrail
 * Text Domain: ashlesha_core
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once( plugin_dir_path( __FILE__ ) . 'class-dtr-ashlesha-core.php' );
dtr_ashlesha_core::get_instance();