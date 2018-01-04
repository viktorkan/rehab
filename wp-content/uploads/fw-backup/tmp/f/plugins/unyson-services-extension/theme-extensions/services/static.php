<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

if ( ! is_admin() ) {
	global $template;
	/**
	 * @var FW_Extension_Services $services
	 */
	$services = fw()->extensions->get( 'services' );

	if ( is_singular( $services->get_post_type_name() ) ) {
		wp_enqueue_style(
			'fw-extension-' . $services->get_name() . '-nivo-default',
			$services->locate_css_URI( 'NivoSlider/themes/default/default' ),
			array(),
			$services->manifest->get_version()
		);

		wp_enqueue_style(
			'fw-extension-' . $services->get_name() . '-nivo-dark',
			$services->locate_css_URI( 'NivoSlider/themes/dark/dark' ),
			array(),
			$services->manifest->get_version()
		);

		wp_enqueue_style(
			'fw-extension-' . $services->get_name() . '-nivo-slider',
			$services->locate_css_URI( 'nivo-slider' ),
			array(),
			$services->manifest->get_version()
		);

		wp_enqueue_script(
			'fw-extension-' . $services->get_name() . '-nivoslider',
			$services->locate_js_URI( 'jquery.nivo.slider' ),
			array( 'jquery' ),
			$services->manifest->get_version(),
			true
		);

		wp_enqueue_script(
			'fw-extension-' . $services->get_name() . '-script',
			$services->locate_js_URI( 'services-script' ),
			array( 'fw-extension-' . $services->get_name() . '-nivoslider' ),
			$services->manifest->get_version(),
			true
		);
	}
}



