<?php

/** Include the TGM_Plugin_Activation class. */
require_once get_template_directory() . '/inc/tgm-plugin-activation/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'valeo_theme_register_required_plugins' );

function valeo_theme_register_required_plugins()
{

	$plugins = array(
		array(
			'name'     				=> 'Booked',
			'slug'     				=> 'booked',
			'source'   				=> get_template_directory() . '/inc/tgm-plugin-activation/plugins/booked.zip',
			'required' 				=> false,
			'version' 				=> '1.9.10',
			'file_path'			    =>  ABSPATH.'wp-content/plugins/booked/booked.php'
		),
		array(
			'name'     				=> 'Instagram Feed',
			'slug'     				=> 'instagram-feed',
			'required' 				=> true,
		),
        array(
            'name'     				=> 'MailChimp for WordPress',
            'slug'     				=> 'mailchimp-for-wp',
            'required'              => true,
        ),
		array(
			'name'     				=> 'AccessPress Social Counter',
			'slug'     				=> 'accesspress-social-counter',
			'required'              => false,
		),
		array(
			'name'     				=> 'Timetable and Event Schedule',
			'slug'     				=> 'mp-timetable',
			'required'              => false,
		),
		array(
			'name'     				=> 'Custom Content Team',
			'slug'     				=> 'custom-content-team',
			'source'   				=> get_template_directory() . '/inc/tgm-plugin-activation/plugins/custom-content-team.zip',
			'required' 				=> true,
			'file_path'			    =>  ABSPATH.'wp-content/plugins/custom-content-team/team.php'
		),
		array(
			'name'     				=> '[Unyson Extension] Services',
			'slug'     				=> 'unyson-services-extension',
			'source'   				=> get_template_directory() . '/inc/tgm-plugin-activation/plugins/unyson-services-extension.zip',
			'required' 				=> true,
			'file_path'			    =>  ABSPATH.'wp-content/plugins/unyson-services-extension/unyson-services-extension.php'
		),
        array(
            'name'     				=> 'Unyson',
            'slug'     				=> 'unyson',
            'required'              => true,
        ),
        array(
            'name'     				=> 'WooCommerce',
            'slug'     				=> 'woocommerce',
            'required'              => false,
        ),
		// include a plugin from an arbitrary external source in your theme.
		array(
			'name'     				=> 'Envato Market',
			'slug'     				=> 'envato-market',
			// local source:
			//'source'   				=> get_template_directory() . '/inc/tgm-plugin-activation/plugins/envato-market.zip',
			// remote source:
			'source'                => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required.
			// hide link to download plugin, couse we set 'source' link
			//'external_url'          => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip', // If set, overrides default API URL and points to an external URL.
		),
	);

	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'valeo';

	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> esc_html__( 'Install Required Plugins', 'valeo' ),
			'menu_title'                       			=> esc_html__( 'Install Plugins', 'valeo' ),
			'installing'                       			=> esc_html__( 'Installing Plugin: %s', 'valeo' ), // %1$s = plugin name
			'oops'                             			=> esc_html__( 'Something went wrong with the plugin API.', 'valeo' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'valeo' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'valeo' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'valeo' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'valeo' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'valeo' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'valeo' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'valeo' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'valeo' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'valeo' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'valeo' ),
			'return'                           			=> esc_html__( 'Return to Required Plugins Installer', 'valeo' ),
			'plugin_activated'                 			=> esc_html__( 'Plugin activated successfully.', 'valeo' ),
			'complete' 									=> esc_html__( 'All plugins installed and activated successfully. %s', 'valeo' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa($plugins, $config);
}