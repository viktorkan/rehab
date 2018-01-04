<?php
$mods = valeo_scan_for_mods( VALEO_DIR . 'inc/mods/' );
foreach ( $mods as $mod ) {
	include_once( get_template_directory() . '/inc/mods/' . $mod );
}

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function valeo_menu_list_customize_register( $wp_customize ){
	if( function_exists( 'valeo_get_header_styles' ) ){
		$menu_styles = valeo_get_header_styles();
		if( count( $menu_styles ) > 1 ) {

			// Add Main Menu Style section.
			$wp_customize->add_section( 'main_menu_pos' , array(
				'title'       => esc_html__( 'Main Menu Style', 'valeo' ),
				'priority'    => 980,
				'description' => '',
				'panel'       => 'menu-settings',
			) );

			$wp_customize->add_setting(
				'main_menu_style',
				array(
					'default' => 'header1',
					'sanitize_callback' => 'esc_attr',
				)
			);

			$wp_customize->add_control(
				'main_menu_style',
				array(
					'type' => 'select',
					'label' => 'Main Menu Style',
					'section' => 'main_menu_pos',
					'choices' => valeo_get_header_styles(),
				)
			);
			// Move social settings into menu styling panel
			$wp_customize->get_section( 'social_settings' )->panel = 'menu-settings';
			$wp_customize->get_section( 'social_settings' )->priority = 981; //Menu selection priority=980
		}
	}
}

add_action( 'customize_register', 'valeo_menu_list_customize_register', 19 );