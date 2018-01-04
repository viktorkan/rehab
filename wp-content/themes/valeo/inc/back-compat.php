<?php
/**
 * Valeo back compat functionality
 *
 * Prevents Valeo from running on WordPress versions prior to 4.1,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.1.
 */

if ( ! function_exists( 'valeo_switch_theme' ) ) :
/**
 * Prevent switching to Valeo on old versions of WordPress.
 *
 * Switches to the default theme.
 */
function valeo_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'valeo_upgrade_notice' );
}
endif;
add_action( 'after_switch_theme', 'valeo_switch_theme' );

if ( ! function_exists( 'valeo_upgrade_notice' ) ) :
/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Valeo on WordPress versions prior to 4.1.
 */
function valeo_upgrade_notice() {
	$message = sprintf( esc_html__( 'Valeo requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'valeo' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}
endif;

if ( ! function_exists( 'valeo_customize' ) ) :
/**
 * Prevent the Customizer from being loaded on WordPress versions prior to 4.1.
 */
function valeo_customize() {
	wp_die( sprintf( esc_html__( 'Valeo requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'valeo' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
endif;
add_action( 'load-customize.php', 'valeo_customize' );

if ( ! function_exists( 'valeo_preview' ) ) :
/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 4.1.
 */
function valeo_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( esc_html__( 'Valeo requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'valeo' ), $GLOBALS['wp_version'] ) );
	}
}
endif;
add_action( 'template_redirect', 'valeo_preview' );
