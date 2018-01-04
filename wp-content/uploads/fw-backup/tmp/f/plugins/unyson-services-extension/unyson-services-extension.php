<?php
/**
 * Plugin Name: [Unyson Extension] Services
 * Plugin URI:  http://themehybrid.com/plugins/custom-content-reviews
 * Description: Reviews manager for WordPress.  This plugin allows you to manage, edit, and create new reviews items in an unlimited number of reviewss.
 * Version:     1.0.1
 * Author:      Justin Tadlock
 * Author URI:  http://themehybrid.com
 * Text Domain: fw-services
 * Domain Path: /languages
 *
 * The Custom Content Reviews plugin was created to solve the problem of theme developers continuing
 * to incorrectly add custom post types to handle reviewss within their themes.  This plugin allows
 * any theme developer to build a "reviews" theme without having to code the functionality.  This
 * gives more time for design and makes users happy because their data isn't lost when they switch to
 * a new theme.  Oh, and, this plugin lets creative folk put together a reviews of their work on
 * their site.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package   FWServices
 * @version   1.0.1
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2013-2015, Justin Tadlock
 * @link      http://themehybrid.com/plugins/custom-content-reviews
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */


function _fw_filter_services_extension($locations) {
    $locations[ dirname(__FILE__) . '/core-extensions' ]
    = plugin_dir_url( __FILE__ ) . 'core-extensions';

    $locations[ dirname(__FILE__) . '/theme-extensions' ]
    = plugin_dir_url( __FILE__ ) . 'theme-extensions';

    return $locations;
}
add_filter('fw_extensions_locations', '_fw_filter_services_extension');