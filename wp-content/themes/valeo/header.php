<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 */

$theme_options = valeo_get_theme_mods();
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php if ( ! valeo_get_customizer_option( 'hide_preloader' ) ) { ?>
<!-- PRELOADER -->
<div id="preloader">
	<div id="preloader-status">
		<div class="spinner">
			<div class="rect1"></div>
			<div class="rect2"></div>
			<div class="rect3"></div>
			<div class="rect4"></div>
			<div class="rect5"></div>
		</div>
		<div id="preloader-title"><?php esc_html_e('Loading', 'valeo')?></div>
	</div>
</div>
<!-- /PRELOADER -->
<?php } ?>

<div class="body-overlay"></div>

<?php #var_dump(valeo_get_customizer_option('header_use_thin_style')); exit;
// before header
if ( valeo_is_frontpage() ) {
	do_action( 'valeo_before_header' );
}
if ( is_front_page() && valeo_get_customizer_option( 'homepage_header' ) != '' ) {
	// header with main slider ('Boxed' style)
	valeo_print_header( 'header3', $theme_options );

} elseif ( valeo_get_customizer_option('header_use_thin_style') ) {
	// header 'Thin' style
	valeo_print_header( 'header1', $theme_options );

} else {
	// header default  ('Thick' style)
	$page_header = valeo_get_customizer_option('main_menu_style');
	valeo_print_header( $page_header, $theme_options );
}
// after header
if ( valeo_is_frontpage() ) {
	do_action( 'valeo_after_header' );
}
?>
