<?php
/**
 * Custom Header functionality for Valeo
 */

if ( ! function_exists( 'valeo_custom_header_setup' ) ) :
/**
 * Set up the WordPress core custom header feature.
 *
 * @uses valeo_header_style()
 */
function valeo_custom_header_setup() {
	$color_scheme        = valeo_get_color_scheme();
	$default_text_color  = trim( $color_scheme[4], '#' );

	/**
	 * Filter Valeo custom-header support arguments.
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default_text_color     Default color of the header text.
	 *     @type int    $width                  Width in pixels of the custom header image. Default 954.
	 *     @type int    $height                 Height in pixels of the custom header image. Default 1300.
	 *     @type string $wp-head-callback       Callback function used to styles the header image and text
	 *                                          displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'valeo_custom_header_args', array(
		'default-text-color'     => $default_text_color,
		'width'                  => 1920,
		'height'                 => 120,
		'wp-head-callback'       => 'valeo_header_style',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'valeo_custom_header_setup' );

if ( ! function_exists( 'valeo_hex2rgb' ) ) :
/**
 * Convert HEX to RGB.
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function valeo_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) == 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) == 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}
endif;

if ( ! function_exists( 'valeo_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see valeo_custom_header_setup()
 */
function valeo_header_style() {
	$header_image = get_header_image();

	// If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && display_header_text() ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css" id="valeo-header-css">
	<?php
		// Has a Custom Header been added?
		if ( ! empty( $header_image ) ) :
	?>
		div.header__row {
			background: url(<?php header_image(); ?>) no-repeat 50% 50%;
			-webkit-background-size: cover;
			-moz-background-size:    cover;
			-o-background-size:      cover;
			background-size:         cover;
		}


	<?php endif; ?>
	</style>
	<?php
}
endif; // valeo_header_style

if ( ! function_exists( 'valeo_header_background_color_css' ) ) :
/**
 * Enqueues front-end CSS for the header background color.
 *
 * @see wp_add_inline_style()
 */
function valeo_header_background_color_css() {
	$color_scheme            = valeo_get_color_scheme();
	$default_color           = $color_scheme[1];
	$header_background_color = get_theme_mod( 'header_background_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $header_background_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Header Background Color */
		body:before
		/*div.header__row*/
		{
			background-color: %1$s;
		}

		@media screen and (min-width: 59.6875em) {
			.secondary {
				background-color: transparent;
			}

			.widget button,
			.widget input[type="button"],
			.widget input[type="reset"],
			.widget input[type="submit"],
			.widget_calendar tbody a,
			.widget_calendar tbody a:hover,
			.widget_calendar tbody a:focus {
				color: %1$s;
			}
		}
	';

	wp_add_inline_style( 'valeo-style', sprintf( $css, $header_background_color ) );
}
endif;
add_action( 'wp_enqueue_scripts', 'valeo_header_background_color_css', 11 );

if ( ! function_exists( 'valeo_sidebar_text_color_css' ) ) :
/**
 * Enqueues front-end CSS for the sidebar text color.
 */
function valeo_sidebar_text_color_css() {
	$color_scheme       = valeo_get_color_scheme();
	$default_color      = $color_scheme[4];
	$sidebar_link_color = get_theme_mod( 'sidebar_textcolor', $default_color );

	// Don't do anything if the current color is the default.
	if ( $sidebar_link_color === $default_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	$sidebar_link_color_rgb     = valeo_hex2rgb( $sidebar_link_color );
	$sidebar_text_color         = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.7)', $sidebar_link_color_rgb );
	$sidebar_border_color       = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.1)', $sidebar_link_color_rgb );
	$sidebar_border_focus_color = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.3)', $sidebar_link_color_rgb );

	$css = '
		/* Custom Sidebar Text Color */
		.site-title a,
		.site-description,
		.secondary-toggle:before {
			color: %1$s;
		}

		.site-title a:hover,
		.site-title a:focus {
			color: %1$s; /* Fallback for IE7 and IE8 */
			color: %2$s;
		}

		.secondary-toggle {
			border-color: %1$s; /* Fallback for IE7 and IE8 */
			border-color: %3$s;
		}

		.secondary-toggle:hover,
		.secondary-toggle:focus {
			border-color: %1$s; /* Fallback for IE7 and IE8 */
			border-color: %4$s;
		}

		.site-title a {
			outline-color: %1$s; /* Fallback for IE7 and IE8 */
			outline-color: %4$s;
		}

		@media screen and (min-width: 59.6875em) {
			.secondary a,
			.dropdown-toggle:after,
			.widget-title,
			.widget blockquote cite,
			.widget blockquote small {
				color: %1$s;
			}

			.widget button,
			.widget input[type="button"],
			.widget input[type="reset"],
			.widget input[type="submit"],
			.widget_calendar tbody a {
				background-color: %1$s;
			}

			.textwidget a {
				border-color: %1$s;
			}

			.secondary a:hover,
			.secondary a:focus,
			.main-navigation .menu-item-description,
			.widget,
			.widget blockquote,
			.widget .gallery-caption {
				color: %2$s;
			}

			.widget button:hover,
			.widget button:focus,
			.widget input[type="button"]:hover,
			.widget input[type="button"]:focus,
			.widget input[type="reset"]:hover,
			.widget input[type="reset"]:focus,
			.widget input[type="submit"]:hover,
			.widget input[type="submit"]:focus,
			.widget_calendar tbody a:hover,
			.widget_calendar tbody a:focus {
				background-color: %2$s;
			}

			.widget blockquote {
				border-color: %2$s;
			}

			.main-navigation ul,
			.main-navigation li,
			.secondary-toggle,
			.widget input,
			.widget textarea,
			.widget table,
			.widget th,
			.widget td,
			.widget pre,
			.widget li,
			.widget_categories .children,
			.widget_nav_menu .sub-menu,
			.widget_pages .children,
			.widget abbr[title] {
				border-color: %3$s;
			}

			.dropdown-toggle:hover,
			.dropdown-toggle:focus,
			.widget hr {
				background-color: %3$s;
			}

			.widget input:focus,
			.widget textarea:focus {
				border-color: %4$s;
			}

			.sidebar a:focus,
			.dropdown-toggle:focus {
				outline-color: %4$s;
			}
		}
	';

	wp_add_inline_style( 'valeo-style', sprintf( $css, $sidebar_link_color, $sidebar_text_color, $sidebar_border_color, $sidebar_border_focus_color ) );
}
endif;
add_action( 'wp_enqueue_scripts', 'valeo_sidebar_text_color_css', 11 );



/**
 * Redefine Default custom background callback.
 *
 * @since 3.0.0
 * @access protected
 */
function valeo_custom_background_cb() {
	// $background is the saved custom image, or the default image.
	$background = set_url_scheme( get_background_image() );

	// $color is the saved custom color.
	// A default has to be specified in style.css. It will not be printed here.
	$color = get_background_color();

	if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
		$color = false;
	}

	if ( ! $background && ! $color )
		return;
	$color = false;

	$style = $color ? "background-color: #$color;" : '';

	if ( $background ) {
		$image = " background-image: url('$background');";

		$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
		$repeat = " background-repeat: $repeat;";

		$position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'left';
		$position = " background-position: top $position;";

		$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'scroll';
		$attachment = " background-attachment: $attachment;";

		$style .= $image . $repeat . $position . $attachment;
	}
	?>
	<style type="text/css" id="custom-background-css">
		/* See redefined _custom_background_cb() */
		body.custom-background { <?php echo trim( $style ); ?> }
	</style>
	<?php
}