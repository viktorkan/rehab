<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$shortcodes_extension = fw_ext( 'shortcodes' );

$ext_instance = fw()->extensions->get( 'portfolio' );

fw_include_file_isolated( $ext_instance->get_path( '/static.php' ) );

if ( ! is_admin() ) {

	$settings = $ext_instance->get_settings();

	if ( !empty($settings) ) {

		wp_enqueue_script(
			'fw-extension-' . $ext_instance->get_name() . '-mixitup',
			get_template_directory_uri(). '/framework-customizations/extensions/shortcodes/shortcodes/portfolio/static/js/jquery.mixitup.min.js',
			array( 'jquery' ),
			$ext_instance->manifest->get_version(),
			true
		);
		wp_enqueue_script(
			'fw-extension-' . $ext_instance->get_name() . '-script',
			get_template_directory_uri(). '/framework-customizations/extensions/shortcodes/shortcodes/portfolio/static/js/portfolio-script.js' ,
			array( 'fw-extension-' . $ext_instance->get_name() . '-mixitup' ),
			$ext_instance->manifest->get_version(),
			true
		);
		wp_enqueue_style(
			$ext_instance->get_name() . '-portfolio',
			get_template_directory_uri(). '/framework-customizations/extensions/shortcodes/shortcodes/portfolio/static/css/portfolio-style.css'
		);

	}
}