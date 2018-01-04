<?php
/**
 * Valeo functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 */

define('VALEO_VERSION', '1.2.14');
define('VALEO_DIR', get_template_directory().'/');
define('VALEO_PATH', get_template_directory_uri().'/');

include(get_template_directory() . '/inc/init.php');

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 960;
}

if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'valeo_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function valeo_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on valeo, use a find and replace
	 * to change 'valeo' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'valeo', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 768, 511, true );
	add_image_size( 'valeo_post-slider', 640, 428, true );
	add_image_size( 'valeo_post-slider-single', 1170, 530, true );
	add_image_size( 'valeo_main-slider', 1170, 609, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'valeo' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = valeo_get_color_scheme();

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'valeo_custom_background_args', array(
		'default-color'      => $color_scheme[1],
		'default-image'      => valeo_get_customizer_option('background_image'),
		'default-repeat'     => valeo_get_customizer_option('background_image_repeat'),
		'default-position_x' => valeo_get_customizer_option('background_image_position_x'),
		'default-attachment' => valeo_get_customizer_option('background_image_attachment'),
		'wp-head-callback' => 'valeo_custom_background_cb'
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'vendors/genericons/genericons.css', valeo_fonts_url() ) );
}
endif; // valeo_setup
add_action( 'after_setup_theme', 'valeo_setup' );

if ( ! function_exists( 'valeo_widgets_init' ) ) :
/**
 * Register widget area.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function valeo_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'valeo' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'valeo' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

    register_sidebar( array(
        'name'          => esc_html__( 'Widgets Before Header (Full-Width)', 'valeo' ),
        'id'            => 'sidebar-before-header',
        'description'   => esc_html__( 'Add widgets here to appear full-width before header.', 'valeo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Widgets After Header (Full-Width)', 'valeo' ),
        'id'            => 'sidebar-after-header',
        'description'   => esc_html__( 'Add widgets here to appear full-width after header.', 'valeo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>',
    ) );


    register_sidebar( array(
        'name'          => esc_html__( 'Widgets Before Content', 'valeo' ),
        'id'            => 'sidebar-top',
        'description'   => esc_html__( 'Add widgets here to appear over content.', 'valeo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>',
    ) );

	register_sidebar( array(
		'name'          => esc_html__( 'Widgets Before Loop (Loop-Width)', 'valeo' ),
		'id'            => 'sidebar-before-loop',
		'description'   => esc_html__( 'Add widgets here to appear over loop.', 'valeo' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Widgets After Loop (Loop-Width)', 'valeo' ),
		'id'            => 'sidebar-after-loop',
		'description'   => esc_html__( 'Add widgets here to appear after loop.', 'valeo' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

    register_sidebar( array(
        'name'          => esc_html__( 'Widgets After Content', 'valeo' ),
        'id'            => 'sidebar-after-content',
        'description'   => esc_html__( 'Add widgets here to appear under content.', 'valeo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Widgets Before Footer (Full-Width)', 'valeo' ),
        'id'            => 'sidebar-before-footer',
        'description'   => esc_html__( 'Add widgets here to appear full-width before footer.', 'valeo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>',
    ) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Wide', 'valeo' ),
		'id'            => 'sidebar-footer-widget-wide',
		'description'   => esc_html__( 'Add Footer Widget Wide.', 'valeo' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget 1', 'valeo' ),
        'id'            => 'footer-widget-1',
        'description'   => esc_html__( 'Add Footer Widget 1.', 'valeo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget 2', 'valeo' ),
        'id'            => 'footer-widget-2',
        'description'   => esc_html__( 'Add Footer Widget 2.', 'valeo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget 3', 'valeo' ),
        'id'            => 'footer-widget-3',
        'description'   => esc_html__( 'Add Footer Widget 3.', 'valeo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget 4', 'valeo' ),
        'id'            => 'footer-widget-4',
        'description'   => esc_html__( 'Add Footer Widget 4.', 'valeo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget 4', 'valeo' ),
        'id'            => 'footer-widget-4',
        'description'   => esc_html__( 'Add Footer Widget 4.', 'valeo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

	if ( valeo_get_customizer_option( 'main_slider_info_blocks' ) != '' ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Main Slider Widget 1', 'valeo' ),
			'id'            => 'sidebar-main-slider-widget-1',
			'description'   => esc_html__( 'Add Main Slider Widget 1', 'valeo' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		) );
	}

	if ( valeo_get_customizer_option( 'main_slider_info_blocks' ) != '' ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Main Slider Widget 2', 'valeo' ),
			'id'            => 'sidebar-main-slider-widget-2',
			'description'   => esc_html__( 'Add Main Slider Widget 2', 'valeo' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		) );
	}

	if ( valeo_get_customizer_option( 'main_slider_info_blocks' ) != '' ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Main Slider Widget 3', 'valeo' ),
			'id'            => 'sidebar-main-slider-widget-3',
			'description'   => esc_html__( 'Add Main Slider Widget 3', 'valeo' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		) );
	}

}
endif;
add_action( 'widgets_init', 'valeo_widgets_init' );

if ( ! function_exists( 'valeo_footer' ) ) :
function valeo_footer() {
	$theme_options = valeo_get_theme_mods();
    $footer_widgets = valeo_get_customizer_option( 'footer_widgets_layout' );
    $widget_widths = array('','','','');
    switch($footer_widgets){
        case '1':   $widget_widths = array_replace($widget_widths, array('col-md-12 widget-width__container')); break;
        case '2':   $widget_widths = array_replace($widget_widths, array('col-md-6 col-sm-6 widget-width__loop','col-md-6 col-sm-6 widget-width__loop')); break;
        case '3':   $widget_widths = array_replace($widget_widths, array('col-md-4 col-sm-6 widget-width__side','col-md-4 col-sm-6 widget-width__side','col-md-4 col-sm-6 widget-width__side')); break;
        case '4':   $widget_widths = array_replace($widget_widths, array('col-md-3 col-sm-6 widget-width__side','col-md-3 col-sm-6 widget-width__side','col-md-3 col-sm-6 widget-width__side','col-md-3 col-sm-6 widget-width__side')); break;
        case '12':  $widget_widths = array_replace($widget_widths, array('col-md-4 col-sm-6 widget-width__side','col-md-8 col-sm-12 widget-width__loop')); break;
        case '21':  $widget_widths = array_replace($widget_widths, array('col-md-8 col-sm-12 widget-width__loop','col-md-4 col-sm-6 widget-width__side')); break;
        case '112': $widget_widths = array_replace($widget_widths, array('col-md-3 col-sm-6 widget-width__side','col-md-3 col-sm-6 widget-width__side','col-md-6 col-sm-12 widget-width__loop')); break;
        case '121': $widget_widths = array_replace($widget_widths, array('col-md-3 col-sm-6 widget-width__side','col-md-6 col-sm-12 widget-width__loop','col-md-3 col-sm-6 widget-width__side')); break;
        case '211': $widget_widths = array_replace($widget_widths, array('col-md-6 col-sm-12 widget-width__loop','col-md-3 col-sm-6 widget-width__side','col-md-3 col-sm-6 widget-width__side')); break;
        case '13':  $widget_widths = array_replace($widget_widths, array('col-md-3 col-sm-6 widget-width__side','col-md-9 col-sm-12 widget-width__loop')); break;
        case '31':  $widget_widths = array_replace($widget_widths, array('col-md-9 col-sm-12 widget-width__loop','col-md-3 col-sm-6 widget-width__side')); break;
        default: break;
    }
    ?>
	<?php //if ( is_active_sidebar('footer-widget-1') || is_active_sidebar('footer-widget-2') || is_active_sidebar('footer-widget-3') || is_active_sidebar('footer-widget-4') || is_active_sidebar('sidebar-footer-widget-wide') ) { ?>
	<footer class="footer">
		<?php if ( ( valeo_get_customizer_option( 'fgm_block_apikey' ) != '' ) && (
					is_active_sidebar('footer-widget-1') ||
					is_active_sidebar('footer-widget-2') ||
					is_active_sidebar('footer-widget-3') ||
					is_active_sidebar('footer-widget-4') ||
					is_active_sidebar('sidebar-footer-widget-wide') ) ) { ?>
        <!-- Google map -->
        <div class="footer-google-map-close">
            <i class="fa fa-close"></i>
        </div>
        <div class="footer-google-map"
             data-domain="<?php echo esc_attr( get_template_directory_uri() ); ?>"
             data-apikey="<?php echo esc_attr( valeo_get_customizer_option('fgm_block_apikey') ); ?>"
             data-center="<?php echo esc_attr( valeo_get_customizer_option('fgm_block_center') ); ?>"
             data-marker="<?php echo esc_attr( valeo_get_customizer_option('fgm_block_marker') ); ?>">
            <div id="map-canvas"></div>
        </div>
        <!-- /Google map -->
		<?php } ?>
		<div class="container">
			<?php
			$logo_class  = 'logo ';
			$header_logo = '';
			if ( get_theme_mod( 'header_use_logo' ) ) {
				$logo_class .= 'logo-use-image';
				$header_logo = 'header-logo-image';
			} else {
				$logo_class .= 'logo-use-text';
				$header_logo = 'header-logo-text';
			} ?>
			<div class="header__row1">
				<div class="container">
					<div class="row">

						<!-- Header Logo -->
						<?php if ( valeo_get_customizer_option( 'hide_footer_contacts' ) == '' ) { ?>
						<div class="header__logo col-md-4 col-sm-4 col-xs-12 col-md-push-4 col-sm-push-4">
						<?php } else { ?>
						<div class="header__logo col-md-12">
						<?php } ?>
							<div class="header__logo-inner">
								<!-- Logo -->
								<div class="<?php echo esc_attr( $logo_class ); ?>">
									<?php if ( get_theme_mod( 'header_use_logo' ) ) { ?>
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
											<img alt="Logo" class="logo logo_big"
											     src="<?php echo apply_filters( 'valeo_header_logo_alt', $theme_options['header_logo_alt'] ); ?>"/>
										</a>
									<?php } else { ?>
										<div class="text-logo">
											<div class="blogname">
												<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
													$site_name = apply_filters( "valeo_logo_site_name", get_bloginfo( 'name', 'display' ) );
													if ( ! empty( $site_name ) ) {
														echo valeo_logo_highlight( esc_attr( $site_name ) );
													} ?>
												</a>
											</div>
											<div class="blogdescr">
												<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
													$site_description = apply_filters( "valeo_logo_site_name", get_bloginfo( 'description', 'display' ) );
													if ( ! empty( $site_description ) ) {
														echo valeo_replace_str_blogdescr( esc_attr( $site_description ) );
													} ?>
												</a>
											</div>
										</div>
									<?php } ?>
								</div><!-- .logo-->
							</div><!-- .header__logo-inner -->
						</div><!-- .header__logo -->

						<?php if ( valeo_get_customizer_option( 'hide_footer_contacts' ) == '' ) { ?>

						<!-- Header Contact 1 -->
						<div class="header__contact header__contact1 col-md-4 col-sm-4 col-xs-6 col-md-pull-4 col-sm-pull-4">
							<div class="header__contact_wrapper">
								<div class="header__contact_inner">
									<div class="header__contact_content">
										<?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'contact_block_phone' ) ) ); ?>
									</div>
								</div>
							</div>
						</div><!-- .header__contact1 -->

						<!-- Header Contact 2 -->
						<div class="header__contact header__contact2 col-md-4 col-sm-4 col-xs-6">
							<div class="header__contact_wrapper">
								<div class="header__contact_inner">
									<div class="header__contact_content">
										<?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'contact_block_email' ) ) ); ?>
									</div>
								</div>
							</div>
						</div><!-- .header__contact2 -->

						<?php } ?>

					</div>
				</div>
			</div>
			<!-- .header__row1 -->
            <?php if ( is_active_sidebar( 'footer-widget-1' ) || is_active_sidebar( 'footer-widget-2' ) || is_active_sidebar( 'footer-widget-3' ) || is_active_sidebar( 'footer-widget-4' ) || is_active_sidebar( 'sidebar-footer-widget-wide' ) ) : ?>
                <?php do_action('valeo_footer_widget_wide'); ?>
                <?php if ( ! empty( $widget_widths[0] ) ): ?>
                    <div class="row footer-widgets">
                        <div class="footer-widgets-border"></div>
                        <div class="col1 <?php echo esc_attr( $widget_widths[0] ); ?>"><?php dynamic_sidebar( 'footer-widget-1' ); ?></div>
                        <?php if ( ! empty( $widget_widths[1] ) ): ?>
                            <div class="col2 <?php echo esc_attr( $widget_widths[1] ); ?>"><?php dynamic_sidebar( 'footer-widget-2' ); ?></div>
                        <?php endif; ?>
                        <?php if ( ! empty( $widget_widths[2] ) ): ?>
                            <div class="col3 <?php echo esc_attr( $widget_widths[2] ); ?>"><?php dynamic_sidebar( 'footer-widget-3' ); ?></div>
                        <?php endif; ?>
                        <?php if ( ! empty( $widget_widths[3] ) ): ?>
                            <div class="col4 <?php echo esc_attr( $widget_widths[3] ); ?>"><?php dynamic_sidebar( 'footer-widget-4' ); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
		</div>
	</footer>
	<?php //} ?>
	<?php if ( valeo_get_customizer_option( 'hide_copyright' ) == '' ) { ?>
		<?php /* Block wide */

		$col = 'col-md-12 ';

		if ( valeo_get_customizer_option( 'hide_copyright_social' ) == '' ) {

			if ( valeo_get_customizer_option( 'copyright_text' ) == '' || valeo_get_customizer_option( 'copyright_text_2' ) == '' ) {
				$col = 'col-md-6 ';
			} elseif ( valeo_get_customizer_option( 'copyright_text' ) == '' && valeo_get_customizer_option( 'copyright_text_2' ) == '' ) {
				$col = 'col-md-12 ';
			} else {
				$col = 'col-md-4 '; //
			}

		} else {

			if ( valeo_get_customizer_option( 'copyright_text' ) == '' || valeo_get_customizer_option( 'copyright_text_2' ) == '' ) {
				$col = 'col-md-12 ';
			} elseif ( valeo_get_customizer_option( 'copyright_text' ) == '' && valeo_get_customizer_option( 'copyright_text_2' ) == '' ) {
				$col = 'col-md-12 ';
			} else {
				$col = 'col-md-6 '; //
			}
		}

		?>
		<div class="copyright">
			<div class="container">
				<div class="row copyright-row">
					<div class="<?php echo esc_attr( $col ); ?> copyright-text-1"><?php echo wp_kses_post( valeo_get_customizer_option( 'copyright_text' ) ); ?></div>
					<?php if ( valeo_get_customizer_option( 'hide_copyright_social' ) == '' ) { ?>
						<div class="<?php echo esc_attr( $col ); ?> copyright-social">
							<?php echo valeo_footer_social_links(); ?>
						</div>
					<?php } ?>
					<div class="<?php echo esc_attr( $col ); ?> copyright-text-2"><?php echo wp_kses_post( valeo_get_customizer_option( 'copyright_text_2' ) ); ?></div>
				</div>
			</div>
		</div>
	<?php } ?>
    <?php
}
endif;
add_action('wp_footer', 'valeo_footer');

if( !has_action( 'valeo_before_header' ) ) {
    // Add the widget area to the bottom
    add_action('valeo_before_header', 'valeo_add_before_header_widget');
    function valeo_add_before_header_widget() {
        if ( valeo_is_frontpage() ) {
            echo '<div class="sidebar-before-header widget-width__full"><div class="row mod-widget-grid">';

			$theme_options = valeo_get_theme_mods();

	        // Main slider active print logo
	        if ( valeo_main_slider_active() ) {

		        $logo_class = 'logo ';
		        if ( get_theme_mod( 'header_use_logo' ) ) {
			        $logo_class .= 'logo-use-image';
		        } ?>

		        <div class="logo-before-header">
			        <div class="<?php echo esc_attr( $logo_class ); ?>">
				        <?php if ( get_theme_mod( 'header_use_logo' ) ) { ?>
					        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						        <img alt="Logo" class="logo logo_big"
						             src="<?php echo apply_filters( 'valeo_header_logo_big', $theme_options['header_logo_big'] ); ?>"/>
					        </a>
				        <?php } else { ?>
					        <div class="text-logo">
						        <div class="blogname">
							        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
								        $site_name = apply_filters( "valeo_logo_site_name", get_bloginfo( 'name', 'display' ) );
								        if ( ! empty( $site_name ) ) {
									        echo valeo_logo_highlight( esc_attr( $site_name ) );
								        } ?>
							        </a>
						        </div>
						        <div class="blogdescr">
							        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
								        $site_description = apply_filters( "valeo_logo_site_name", get_bloginfo( 'description', 'display' ) );
								        if ( ! empty( $site_description ) ) {
									        echo esc_attr( $site_description );
								        } ?>
							        </a>
						        </div>
					        </div>
				        <?php } ?>
			        </div><!-- .logo-->
		        </div><?php

	        }

	        if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( esc_html__( 'Widgets Before Header (Full-Width)', 'valeo' ) ) ) :
            endif;
            echo '</div></div><!-- .sidebar-before-header -->';
        }
    }
}

if( !has_action( 'valeo_after_header' ) ) {
    // Add the widget area to the bottom
    add_action('valeo_after_header', 'valeo_add_after_header_widget');
    function valeo_add_after_header_widget() {
	    if ( valeo_is_frontpage() ) {
            echo '<div class="sidebar-after-header widget-width__full"><div class="row mod-widget-grid">';
		    if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( esc_html__( 'Widgets After Header (Full-Width)', 'valeo' ) ) ) :
            endif;
		    do_action( 'valeo_main_slider' );
            echo '</div></div><!-- .sidebar-after-header -->';
        }
    }
}

if ( ! has_action( 'valeo_main_slider' ) ) {
	// Add the widget area
	add_action( 'valeo_main_slider', 'valeo_add_after_header_blocks' );
	function valeo_add_after_header_blocks() {
		if ( is_front_page() ) {

			// Main Slider
			if ( defined( "FW" ) && fw_ext( 'slider' ) ) {
				echo do_shortcode( '[slider slider_id="' . valeo_get_customizer_option( 'main_slider_select' ) . '" width="1920" height="778"][/slider]' ); ?>

				<div class="msi-blocks main-slider-info-blocks widget-width__full">
				<div class="row mod-widget-grid"><?php

				// Main Slider Info Blocks
				if ( valeo_get_customizer_option( 'main_slider_select' ) != -1 && valeo_get_customizer_option( 'main_slider_info_blocks' ) != '' ) { ?>
				<div class="container">
					<div class="msi-blocks__row row">
						<div class="msi-blocks__col msi-blocks__col-1 col-md-4">
							<div class="msi-blocks__wrapper">
								<div class="msi-blocks__inner"><?php

								// Info Block 1
								if ( valeo_get_customizer_option( 'msi_block1_title' ) == '' ) {

									// Show Widget
									if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( esc_html__( 'Main Slider Widget 1', 'valeo' ) ) ) :
									endif;

								} else {

									// Show customizer data ?>
									<div class="widget widget_working_hours">
										<h3 class="widget-title"><span><?php echo wp_kses_post( valeo_get_customizer_option( 'msi_block1_title' ) ); ?></span></h3>
										<div class="working-hours">
											<ul>
												<?php if ( valeo_get_customizer_option( 'msi_block1_wh1' ) != '' ) { ?>
												<li>
													<div><?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'msi_block1_wh1' ) ) ); ?></div>
												</li>
												<?php } ?>
												<?php if ( valeo_get_customizer_option( 'msi_block1_wh2' ) != '' ) { ?>
												<li>
													<div><?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'msi_block1_wh2' ) ) ); ?></div>
												</li>
												<?php } ?>
												<?php if ( valeo_get_customizer_option( 'msi_block1_wh3' ) != '' ) { ?>
												<li>
													<div><?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'msi_block1_wh3' ) ) );?></div>
												</li>
												<?php } ?>
											</ul>
										</div><!-- .working-hours -->
									</div><!-- .widget.widget_working_hours --><?php

								} ?>
								</div>
							</div>
						</div>
						<div class="msi-blocks__col msi-blocks__col-2 col-md-4 col-sm-6">
							<div class="msi-blocks__wrapper">
								<div class="msi-blocks__inner"><?php

								// Info Block 2
								if ( valeo_get_customizer_option( 'msi_block2_title' ) == '' ) {

									// Show Widget
									if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( esc_html__( 'Main Slider Widget 2', 'valeo' ) ) ) :
									endif;

								} else {

									// Show customizer data ?>
									<aside class="widget widget_contacts_table">
										<h2 class="widget-title"><span><?php echo wp_kses_post( valeo_get_customizer_option( 'msi_block2_title' ) );?></span></h2>
										<ul class="widget-contacts-table">
											<li>
												<p class="item-title"><span class="rt-icon icon-location-outline"></span><?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'msi_block2_text' ) ) ); ?></p>
											</li>
											<?php if ( valeo_get_customizer_option( 'msi_block3_btn_text' ) != '' ) { ?>
											<li class="item-button">
												<a href="<?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'msi_block2_btn_url' ) ) ); ?>">
													<span>
													<span>
													<?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'msi_block2_btn_text' ) ) ); ?>
													</span>
													</span>
												</a>
											</li>
											<?php } ?>
										</ul>
									</aside><?php

								} ?>
								</div>
							</div>
						</div>
						<div class="msi-blocks__col msi-blocks__col-3 col-md-4 col-sm-6">
							<div class="msi-blocks__wrapper">
								<div class="msi-blocks__inner"><?php

								// Info Block 3
								if ( valeo_get_customizer_option( 'msi_block2_title' ) == '' ) {

									// Show Widget
									if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( esc_html__( 'Main Slider Widget 2', 'valeo' ) ) ) :
									endif;
								} else {

									// Show customizer data ?>
									<aside class="widget widget_contacts_table">
										<h2 class="widget-title"><span><?php echo wp_kses_post( valeo_get_customizer_option( 'msi_block3_title' ) );?></span></h2>
										<ul class="widget-contacts-table">
											<li>
												<p class="item-title"><span class="rt-icon icon-calender-outline"></span><?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'msi_block3_text' ) ) ); ?></p>
											</li>
											<?php if ( valeo_get_customizer_option( 'msi_block3_btn_text' ) != '' ) { ?>
												<li class="item-button">
													<a href="<?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'msi_block3_btn_url' ) ) ); ?>">
														<span>
														<span>
														<?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'msi_block3_btn_text' ) ) ); ?>
														</span>
														</span>
													</a>
												</li>
											<?php } ?>
										</ul>
									</aside><?php

								} ?>
								</div>
							</div>
						</div>
					</div>
				</div><?php
				} ?>

				</div><!-- .row -->
				</div><!-- .msi-blocks --><?php
			}
		}
	}
}

if( !has_action( 'valeo_before_content' ) ) {

    // Add the widget area to the top
    function valeo_add_top_widget() {
	    if ( valeo_is_frontpage() && !( valeo_is_builder_post( get_the_ID() ) && get_page_template() == 'page-wo-sidebar.php' ) ) {
	        // check if a sidebar is active and in use
            if (is_active_sidebar('sidebar-top')) {
                echo '<div class="container">';
                echo '<div class="sidebar-before-content widget-width__container"><div class="row mod-widget-grid">';
	            if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( esc_html__( 'Widgets Before Content', 'valeo' ) ) ) :
                endif;
                echo '</div></div>';
                echo '</div>';
            }
        }
    }
    add_action('valeo_before_content', 'valeo_add_top_widget');
}

if( !has_action( 'valeo_before_loop' ) ) {
	// Add the widget area to the start of the loop
	add_action('valeo_before_loop', 'valeo_add_before_loop_widget');
	function valeo_add_before_loop_widget() {
		if ( valeo_is_frontpage() && !( valeo_is_builder_post( get_the_ID() ) && get_page_template() == 'page-wo-sidebar.php' ) ) {
			// check if a sidebar is active and in use
			if (is_active_sidebar('sidebar-before-loop')) {
				$widget_width = valeo_sidebar_class("container");
				if ($widget_width == 'snone') {
					$widget_width = 'widget-width__container';
				} else {
					$widget_width = 'widget-width__loop';
				}
				echo '<div class="sidebar-before-loop ' . esc_attr($widget_width) . '"><div class="row mod-widget-grid">';
				if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( esc_html__( 'Widgets Before Loop (Loop-Width)', 'valeo' ) ) ) :
				endif;
				echo '</div></div>';
			}
		}
	}
}

if( !has_action( 'valeo_after_loop' ) ) {
	// Add the widget area to the end of the loop
	add_action('valeo_after_loop', 'valeo_add_after_loop_widget');
	function valeo_add_after_loop_widget() {
		if ( valeo_is_frontpage() && !( valeo_is_builder_post( get_the_ID() ) && get_page_template() == 'page-wo-sidebar.php' ) ) {
			// check if a sidebar is active and in use
			if (is_active_sidebar('sidebar-after-loop')) {
				$widget_width = valeo_sidebar_class("container");
				if ($widget_width == 'snone') {
					$widget_width = 'widget-width__container';
				} else {
					$widget_width = 'widget-width__loop';
				}
				echo '<div class="sidebar-after-loop ' . esc_attr($widget_width) . '"><div class="row mod-widget-grid">';
				if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( esc_html__( 'Widgets After Loop (Loop-Width)', 'valeo' ) ) ) :
				endif;
				echo '</div></div>';
			}
		}
	}
}

if( !has_action( 'valeo_after_content' ) ) {
    // Add the widget area to the bottom
    add_action('valeo_after_content', 'valeo_add_bottom_widget');
    function valeo_add_bottom_widget() {
	    if ( valeo_is_frontpage() && !( valeo_is_builder_post( get_the_ID() ) && get_page_template() == 'page-wo-sidebar.php' ) ) {
		    // check if a sidebar is active and in use
		    if (is_active_sidebar('sidebar-after-content')) {
		    	echo '<div class="container">';
			    echo '<div class="sidebar-after-content widget-width__container"><div class="row mod-widget-grid">';
			    if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( esc_html__( 'Widgets After Content', 'valeo' ) ) ) :
			    endif;
			    echo '</div></div>';
			    echo '</div>';
		    }
	    }
    }

}

if( !has_action( 'valeo_before_footer' ) ) {
    // Add the widget area to the bottom
    add_action('valeo_before_footer', 'valeo_add_before_footer_widget');
    function valeo_add_before_footer_widget() {
	    if ( valeo_is_frontpage() ) {
	        // check if a sidebar is active and in use
	        if (is_active_sidebar('sidebar-before-footer')) {
		        echo '<div class="sidebar-before-footer widget-width__full"><div class="row mod-widget-grid">';
		        if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( esc_html__( 'Widgets Before Footer (Full-Width)', 'valeo' ) ) ) :
		        endif;
		        echo '</div></div>';
	        }
        }
    }
}

if( !has_action( 'valeo_footer_widget_wide' ) ) {
	// Add the widget area to the bottom
	add_action('valeo_footer_widget_wide', 'valeo_add_footer_widget_wide');
	function valeo_add_footer_widget_wide() {
		// check if a sidebar is active and in use
		if (is_active_sidebar('sidebar-footer-widget-wide')) {
			echo '<div class="sidebar-footer-widget-wide widget-width__content"><div class="row mod-widget-grid">';
			if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( esc_html__( 'Footer Widget Wide', 'valeo' ) ) ) :
			endif;
			echo '</div></div>';
		}
	}
}

if( !has_action( 'valeo_404_page' ) ) {
    // Add the widget area to the 404 page
    add_action('valeo_404_page', 'valeo_add_404_page_widget');
    function valeo_add_404_page_widget() {
        if ( is_404() ) {
	        if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( esc_html__( 'Widgets for 404 Page', 'valeo' ) ) ) :
            endif;
        }
    }
}

// Remove Open Sans that WP adds from frontend

if (!function_exists('valeo_remove_wp_open_sans')) :
    function valeo_remove_wp_open_sans() {
        wp_deregister_style( 'open-sans' );
        wp_register_style( 'open-sans', false );
    }
endif;
add_action('wp_enqueue_scripts', 'valeo_remove_wp_open_sans');

if ( ! function_exists( 'valeo_fonts_url' ) ) :
/**
 * Register Google fonts.
 *
 * @return string Google fonts URL for the theme.
 */
function valeo_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'valeo' ) ) {
		$fonts[] = 'Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic';
	}

	$fonts[] = 'Yantramanav:300,400,500,700'; // font-family: 'Yantramanav', sans-serif; [ light / regular / medium / bold ]

	/* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'valeo' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

if ( ! function_exists( 'valeo_scripts' ) ) :
/**
 * Enqueue scripts and styles.
 */
function valeo_scripts() {

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'valeo-fonts', valeo_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	if ( file_exists( get_template_directory() . '/vendors/genericons/genericons.min.css' ) ) {
		wp_enqueue_style( 'genericons', get_template_directory_uri() . '/vendors/genericons/genericons.min.css', array(), '3.2' );
	} else {
		wp_enqueue_style( 'genericons', get_template_directory_uri() . '/vendors/genericons/genericons.css', array(), '3.2' );
	}

    // Add Fontello, used in the main stylesheet.
	if ( file_exists( get_template_directory() . '/vendors/fontello/css/fontello.min.css' ) ) {
		wp_enqueue_style( 'valeo-fontello', get_template_directory_uri() . '/vendors/fontello/css/fontello.min.css', array(), '3.2' );
	} else {
		wp_enqueue_style( 'valeo-fontello', get_template_directory_uri() . '/vendors/fontello/css/fontello.css', array(), '3.2' );
	}

	// Load flaticon stylesheet.
	if ( file_exists( get_template_directory() . '/vendors/flaticon/medicine/font/flaticon.min.css' ) ) {
		wp_enqueue_style( 'valeo-flaticon', get_template_directory_uri() . '/vendors/flaticon/medicine/font/flaticon.min.css' );
	} else {
		wp_enqueue_style( 'valeo-flaticon', get_template_directory_uri() . '/vendors/flaticon/medicine/font/flaticon.css' );
	}

	// Add icomoon icon font stylesheet. (rt-icons-4)
	if ( file_exists( get_template_directory() . '/vendors/icomoon/style.min.css' ) ) {
		wp_enqueue_style( 'valeo-icomoon', get_template_directory_uri() . '/vendors/icomoon/style.min.css', array(), '4' );
	} else {
		wp_enqueue_style( 'valeo-icomoon', get_template_directory_uri() . '/vendors/icomoon/style.css', array(), '4' );
	}

	// Load Twitter Bootstrap stylesheet.
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/vendors/bootstrap/css/bootstrap.min.css' );

    // Load Owl Carousel stylesheet.
    wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/vendors/owl-carousel/css/owl.carousel.min.css' );

    // Load Bootstrap Select stylesheet.
	wp_enqueue_style( 'bootstrap-select', get_template_directory_uri() . '/vendors/bootstrap-select/css/bootstrap-select.min.css' );

	// Load PrettyPhoto stylesheet.
	wp_enqueue_style( 'prettyphoto', get_template_directory_uri() . '/vendors/prettyphoto/css/prettyPhoto.min.css' );

	if ( class_exists( 'SC_Class' ) ) {
		// Load Social counter stylesheet.
		wp_enqueue_style( 'valeo-apsc', get_template_directory_uri() . '/css/social-counter.css' );
	}

	if ( class_exists( 'booked_plugin' ) ) {
		// Load Booked stylesheet.
		wp_enqueue_style( 'valeo-booked', get_template_directory_uri() . '/css/booked.css' );
	}

	if ( class_exists( 'Mp_Time_Table' ) ) {
		// Load Timetable stylesheet.
		wp_enqueue_style( 'valeo-timetable', get_template_directory_uri() . '/css/timetable.css' );
	}

	if ( class_exists( 'CCT_Plugin' ) ) {
		// Load Team stylesheet.
		wp_enqueue_style( 'valeo-team', get_template_directory_uri() . '/css/team.css' );
	}

	// Load FontAwesome stylesheet.
	if ( ! defined( 'FW' ) ) {
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/vendors/font-awesome/css/font-awesome.min.css', array(), "all" );
	} else {
		if ( ! fw_ext( 'megamenu' ) ) {
			wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/vendors/font-awesome/css/font-awesome.min.css', array(), "all" );
		}
	}

    // Load animate stylesheet.
    wp_enqueue_style( 'animate', get_template_directory_uri() . '/vendors/animate/animate.min.css', array(), "all" );

    // Load script to make Menu sticky.
	wp_enqueue_script( 'valeo-sticky-script', get_template_directory_uri() . '/vendors/jquery.sticky.min.js', array( 'jquery' ), "all", true );

    // Load script to make Sidebar sticky.
    wp_enqueue_script( 'valeo-sticky-kit', get_template_directory_uri() . '/vendors/jquery.sticky-kit.min.js', array( 'jquery' ), "all", true );

	// Load jQuery Appear javascript.
	wp_enqueue_script( 'valeo-jquery-appear', get_template_directory_uri() . '/vendors/jquery.appear.min.js', array( 'jquery' ), "all", true );

    // Load Owl Carousel script.
    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/vendors/owl-carousel/js/owl.carousel.min.js', array(), "all", true );

    // Load Bootstrap javascripts.
    wp_enqueue_script( 'bootstrap-dropdown', get_template_directory_uri() . '/vendors/bootstrap/js/dropdown.js', array( 'jquery' ), "all", true );
    wp_enqueue_script( 'bootstrap-tabs', get_template_directory_uri() . '/vendors/bootstrap/js/tab.js', array( 'jquery' ), "all", true );
    wp_enqueue_script( 'bootstrap-transition', get_template_directory_uri() . '/vendors/bootstrap/js/transition.js', array( 'jquery' ), "all", true );

    // Load Bootstrap select script.
    wp_enqueue_script( 'bootstrap-select', get_template_directory_uri() . '/vendors/bootstrap-select/js/bootstrap-select.min.js', array(), "all", true );

	// Load PrettyPhoto script.
	wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/vendors/prettyphoto/js/jquery.prettyPhoto.js', array(), "all", true );

	if ( file_exists( get_template_directory() . '/js/skip-link-focus-fix.min.js' ) ) {
		wp_enqueue_script( 'valeo-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.min.js', array(), "all", true );
	} else {
		wp_enqueue_script( 'valeo-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), "all", true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'valeo-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), "all" );
	}

	wp_localize_script( 'valeo-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . esc_html__( 'expand child menu', 'valeo' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . esc_html__( 'collapse child menu', 'valeo' ) . '</span>',
	) );

	if ( ( valeo_get_customizer_option( 'fgm_block_apikey' ) != '' ) && (
			is_active_sidebar('footer-widget-1') ||
			is_active_sidebar('footer-widget-2') ||
			is_active_sidebar('footer-widget-3') ||
			is_active_sidebar('footer-widget-4') ||
			is_active_sidebar('sidebar-footer-widget-wide') ) ) {

		$valeo_api_key = valeo_get_customizer_option( 'fgm_block_apikey' );
		$valeo_api_key = '&amp;key=' . $valeo_api_key;

		wp_enqueue_script(
			'google-maps-api-v3',
			'https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false' . $valeo_api_key, array(), "all", true
		);
	}

	// Move jQuery to the footer
	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
	wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

	if ( file_exists( get_template_directory() . '/js/main.min.js' ) ) {
		wp_enqueue_script( 'valeo-main-script', get_template_directory_uri() . '/js/main.min.js', array( 'jquery' ), "all", true );
	} else {
		wp_enqueue_script( 'valeo-main-script', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), "all", true );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'valeo_scripts' );

if ( ! function_exists( 'valeo_main_style_enqueue' ) ) :
	function valeo_main_style_enqueue() {
		// Load our main stylesheet.
		if ( ! is_child_theme() ) {
			wp_enqueue_style( 'valeo-style', get_stylesheet_uri() );
		}
		else {
			wp_enqueue_style( 'valeo-style', get_template_directory_uri() . '/style.css' );
		}
	}
endif;
add_action( 'wp_enqueue_scripts', 'valeo_main_style_enqueue', 100 );

if ( ! function_exists( 'pure_admin_style' ) ) :
	function pure_admin_style() {
		// Load admin stylesheet.
		wp_enqueue_style( 'admin-customize', get_template_directory_uri() . '/css/admin-customize.css' );
	}
endif;
add_action( 'admin_print_styles', 'pure_admin_style' );

if ( ! function_exists( 'valeo_customizer_enqueue' ) ) :
function valeo_customizer_enqueue() {
    // Load Customizer script.
    wp_enqueue_script( 'valeo-customizer-script', get_template_directory_uri() . '/js/customizer.js', array(), "all", true );
	// Load Image Upload script.
	wp_enqueue_style('thickbox');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_script( 'valeo-widget-image-upload', get_template_directory_uri() . '/js/widget.image.upload.js', array(), "all", true );
}
endif;
add_action( 'admin_print_styles', 'valeo_customizer_enqueue' );


if ( ! function_exists( 'valeo_post_nav_background' ) ) :
	/**
	 * Add featured image as background image to post navigation elements.
	 *
	 * @see wp_add_inline_style()
	 */
	function valeo_post_nav_background() {
		if ( ! is_single() ) {
			return;
		}

		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
		$css      = '';

		if ( is_attachment() && 'attachment' == $previous->post_type ) {
			return;
		}

		if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
			$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
			$css .= '.post-navigation .nav-previous a { background-image: url(' . esc_url( $prevthumb[0] ) . '); }';
		}

		if ( $next && has_post_thumbnail( $next->ID ) ) {
			$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
			$css .= '.post-navigation .nav-next a { background-image: url(' . esc_url( $nextthumb[0] ) . '); }';
		}

		wp_add_inline_style( 'valeo-style', $css );
	}
endif;
add_action( 'wp_enqueue_scripts', 'valeo_post_nav_background' );


if ( ! function_exists( 'valeo_comment_callback' ) ) :
/**
 * Callback for customizing comments template.
 *
 * @param array   $comment	   Comment to display.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 */
function valeo_comment_callback($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ('div' == $args['style']) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
	?>
	<<?php echo esc_attr( $tag ); ?> <?php comment_class(!empty( $args['has_children'] ) ? 'parent' : ''); ?> id="comment-<?php comment_ID(); ?>">
	<?php if ('div' != $args['style']) : ?>
	<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
		<?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
		<?php printf(__('%s <span class="says">says:</span>', 'valeo'), get_comment_author_link()); ?>
	</div>
	<span class="comment-meta">
		<?php if ('0' == $comment->comment_approved) : ?>
		<em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'valeo') ?></em>
		<br/>
		<?php endif; ?>

		<div class="comment-metadata">
			<a href="<?php echo esc_url(get_comment_link($comment->comment_ID, $args)); ?>">
				<?php
				/* translators: 1: date, 2: time */
				printf(__('<time datetime="%1$s">%2$s</time>', 'valeo'), esc_attr( get_comment_date( 'c' ) ), get_comment_date('M j, Y - G:i')); ?></a><?php edit_comment_link(__('(Edit)', 'valeo'), '&nbsp;&nbsp;', '');
			?>
			<?php
			comment_reply_link(array_merge($args, array(
				'add_below' => $add_below,
				'depth' => $depth,
				'max_depth' => $args['max_depth'],
				'before' => '<span class="reply">',
				'after' => '</span>',
				'reply_text' => ' <i class="fa fa-share fa-flip-horizontal"></i>',
			)));
			?>
		</div>
	</span><!-- .comment-meta -->

	<div class="comment-content">
		<?php comment_text(get_comment_id(), array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
	</div>

	<?php if ('div' != $args['style']) : ?>
	</article>
<?php endif; ?>
	<?php
}
endif;

if ( ! function_exists( 'valeo_reorder_comment_fields' ) ) :
/**
 * Change comment form inputs order.
 */
	function valeo_reorder_comment_fields( $fields ) {
		$new_fields = array(); // fields in new order
		$myorder    = array( 'author', 'email', 'url', 'comment' );

		foreach ( $myorder as $key ) {
			if ( ! empty( $fields[ $key ] ) ) {
				$new_fields[ $key ] = $fields[ $key ];
				unset( $fields[ $key ] );
			}
		}

		return $new_fields;
	}
endif;
add_filter( 'comment_form_fields', 'valeo_reorder_comment_fields' );

if ( ! function_exists( 'valeo_wp_head' ) ) :
function valeo_wp_head()
{
    echo '<script type="text/javascript"> if( ajaxurl === undefined ) var ajaxurl = "'.admin_url('admin-ajax.php').'";</script>';
}
endif;
add_action( 'wp_head', 'valeo_wp_head' );

if ( ! function_exists( 'valeo_excerpt_length' ) ) :
/**
 * Cut excerpt length to 55 words.
 */
function valeo_excerpt_length( $length ) {
    return 25;
}
endif;
add_filter( 'excerpt_length', 'valeo_excerpt_length', 999 );

if ( ! function_exists( 'valeo_excerpt_length_wide' ) ) :
    /**
     * Cut excerpt length to 55 words.
     */
    function valeo_excerpt_length_wide( $length ) {
        return 55;
    }
endif;

if ( ! function_exists( 'valeo_init_excerpt_on_publish' ) ) :
/**
 * Auto Init excerpt on wp_insert_post.
 */
function valeo_init_excerpt_on_publish( $data , $postarr ) {
	if ( !$data['post_excerpt'] ) {
		//$data['post_excerpt'] = wp_trim_words( strip_tags( trim( strip_shortcodes( $data['post_content'] ) ) ), 55, __('&hellip;', 'valeo') ); // 55 words by default
		$data['post_excerpt'] = wp_trim_words( strip_tags( trim( strip_shortcodes( $data['post_content'] ) ) ) ); // 55 words by default
	}
    return $data;
}
endif;
// now we don't need to automaticalli fill this field
#add_filter( 'wp_insert_post_data', 'valeo_init_excerpt_on_publish', '99', 2 );

if ( ! function_exists( 'valeo_search_form_modify' ) ) :
/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function valeo_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
endif;
add_filter( 'get_search_form', 'valeo_search_form_modify' );

if ( ! function_exists( 'valeo_build_gallery_content' ) ) :
/**
 * Replace gallery shortcode with owl carousel
 */

function valeo_build_gallery_content( $attrs ){
    global $post;
    static $instance = 0;
    $instance++;

    /*
    Limiting what the user can do by
    locking down most short code options.
    */
    extract(shortcode_atts(array(
        'id'         => $post->ID,
        'include'    => '',
        'exclude'    => ''
    ), $attrs));

    $id = intval($id);

    if ( !empty($include) ) {
        $params = array(
            'include' => $include,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => 'ASC',
            'orderby' => 'menu_order ID');
        $_attachments = get_posts( $params );
        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $params = array(
            'post_parent' => $id,
            'exclude' => $exclude,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => 'ASC',
            'orderby' => 'menu_order ID');
        $attachments = get_children( $params );
    } else {
        $params = array(
            'post_parent' => $id,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => 'ASC',
            'orderby' => 'menu_order ID');
        $attachments = get_children( $params );
    }

    if ( empty($attachments) )
        return '';

    $selector = "gallery-{$instance}";

    $gallery_div = sprintf("<div id='%s' class='owl-gallery owl-carousel gallery galleryid-%d gallery-columns-1 gallery-size-full'>", $selector, $id);
    $output = $gallery_div;


    foreach ( $attachments as $id => $attachment ) {
        /*
        Use wp_get_attachment_link to return a photo + link
        to attachment page or image
        http://codex.wordpress.org/Function_Reference/wp_get_attachment_link
        */
        $img = wp_get_attachment_image( $id, 'full', false);

        $caption = '';

        /*
        Set the caption string if there is one.
        */

        if( !empty($captiontag) && trim($attachment->post_excerpt) ){
            $caption = sprintf("<figcaption class='wp-caption-text gallery-caption'><div>%s</div></figcaption>", wptexturize($attachment->post_excerpt));
        }

        /*
        Set the output for each slide.
        */
        $output .= sprintf("<figure class='gallery-icon'>%s\n\t%s</figure>", $img, $caption);
    }
    $output .= '</div>';
    return $output;
}
endif;

if ( ! function_exists( 'valeo_custom_gallery_shortcode' ) ) :
function valeo_custom_gallery_shortcode( $output = '', $attrs){
    $return = $output;

    if(!empty($attrs) && (!empty($attrs['type']) || !empty($attrs['columns']))) {

    } else {
        # Gallery function that returns new markup.
        $gallery = valeo_build_gallery_content( $attrs );


        if( !empty( $gallery ) ) {
            $return = $gallery;
        }
    }
    return $return;
}
endif;
add_filter( 'post_gallery', 'valeo_custom_gallery_shortcode', 10, 2);

if ( ! function_exists( 'valeo_add_oembed_soundcloud' ) ) :
// Add SoundCloud oEmbed
function valeo_add_oembed_soundcloud(){
    wp_oembed_add_provider( 'https://soundcloud.com/*', 'https://soundcloud.com/oembed' );
}
endif;
add_action('init','valeo_add_oembed_soundcloud');

if ( ! function_exists( 'valeo_sticky_label' ) ) :
// Sticky Post Label
function valeo_sticky_label()
{
    echo '<div class="featured-wrap"><div class="featured">
		<i class="icon-pin"></i>
	</div></div>';
}
endif;
add_action('valeo_sticky_label', 'valeo_sticky_label');

if ( ! function_exists( 'valeo_kses_init' ) ) :
	/**
	 * Initiates allowed tags array for wp_kses functions
	 */
	function valeo_kses_init() {

		$allowed_atts = array(
			'align'       => true,
			'aria-hidden' => true,
			'class'       => true,
			'clear'       => true,
			'dir'         => true,
			'id'          => true,
			'lang'        => true,
			'name'        => true,
			'style'       => true,
			'title'       => true,
			'xml:lang'    => true,
		);

		$kses_list = array(
			'address'    => $allowed_atts,
			'a'          => array(
				                'href'         => true,
				                'rel'          => true,
				                'rev'          => true,
				                'target'       => true,
				                'data-content' => true,
			                ) + $allowed_atts,
			'abbr'       => $allowed_atts,
			'acronym'    => $allowed_atts,
			'area'       => array(
				                'alt'    => true,
				                'coords' => true,
				                'href'   => true,
				                'nohref' => true,
				                'shape'  => true,
				                'target' => true,
			                ) + $allowed_atts,
			'aside'      => $allowed_atts,
			'b'          => $allowed_atts,
			'bdo'        => $allowed_atts,
			'big'        => $allowed_atts,
			'blockquote' => array(
				                'cite' => true,
			                ) + $allowed_atts,
			'br'         => $allowed_atts,
			'cite'       => $allowed_atts,
			'code'       => $allowed_atts,
			'del'        => array(
				                'datetime' => true,
			                ) + $allowed_atts,
			'dd'         => $allowed_atts,
			'dfn'        => $allowed_atts,
			'details'    => array(
				                'open' => true,
			                ) + $allowed_atts,
			'div'        => $allowed_atts,
			'dl'         => $allowed_atts,
			'dt'         => $allowed_atts,
			'em'         => $allowed_atts,
			'form'      => array(
				               'action'                 => true,
				               'method'                 => true,
				               'data-fw-ext-forms-type' => true,
			               ) + $allowed_atts,
			'h1'         => $allowed_atts,
			'h2'         => $allowed_atts,
			'h3'         => $allowed_atts,
			'h4'         => $allowed_atts,
			'h5'         => $allowed_atts,
			'h6'         => $allowed_atts,
			'hr'         => array(
				                'noshade' => true,
				                'size'    => true,
				                'width'   => true,
			                ) + $allowed_atts,
			'i'          => $allowed_atts,
			'img'        => array(
				                'alt'      => true,
				                'border'   => true,
				                'height'   => true,
				                'hspace'   => true,
				                'longdesc' => true,
				                'vspace'   => true,
				                'src'      => true,
				                'usemap'   => true,
				                'width'    => true,
			                ) + $allowed_atts,
			'ins'        => array(
				                'datetime' => true,
				                'cite'     => true,
			                ) + $allowed_atts,
			'kbd'        => $allowed_atts,
			'li'         => array(
				                'value' => true,
			                ) + $allowed_atts,
			'map'        => $allowed_atts,
			'mark'       => $allowed_atts,
			'p'          => $allowed_atts,
			'pre'        => array(
				                'width' => true,
			                ) + $allowed_atts,
			'q'          => array(
				                'cite' => true,
			                ) + $allowed_atts,
			's'          => $allowed_atts,
			'samp'       => $allowed_atts,
			'span'       => array(
				                'data-content' => true,
			                ) + $allowed_atts,
			'small'      => $allowed_atts,
			'strike'     => $allowed_atts,
			'strong'     => $allowed_atts,
			'sub'        => $allowed_atts,
			'summary'    => $allowed_atts,
			'sup'        => $allowed_atts,
			'time'       => array(
				                'datetime' => true,
			                ) + $allowed_atts,
			'tt'         => $allowed_atts,
			'u'          => $allowed_atts,
			'ul'         => array(
				                'type' => true,
			                ) + $allowed_atts,
			'ol'         => array(
				                'start'    => true,
				                'type'     => true,
				                'reversed' => true,
			                ) + $allowed_atts,
			'label'      => array(
				                'for'         => true,
				                'type'        => true,
				                'value'       => true,
				                'required'    => true,
				                'placeholder' => true,
			                ) + $allowed_atts,
			'input'      => array(
				                'for'         => true,
				                'type'        => true,
				                'value'       => true,
				                'required'    => true,
				                'placeholder' => true,
			                ) + $allowed_atts,
			'textarea'   => array(
				                'for'         => true,
				                'type'        => true,
				                'value'       => true,
				                'required'    => true,
				                'placeholder' => true,
			                ) + $allowed_atts,
			'var'        => $allowed_atts,
		);

		return $kses_list;
	}
endif;

if ( ! function_exists( 'valeo_kses' ) ) :
	/**
	 * Returns allowed tags array for wp_kses functions
	 */
	function valeo_kses_list() {
		return valeo_kses_init();
	}
endif;

// Dropcaps
if ( ! function_exists( 'valeo_add_dropcaps' ) ) :
	function valeo_add_dropcaps( $classes ) {
		$dropcaps_style = absint( valeo_get_customizer_option( 'dropcaps_style' ) );
		if ( ! empty( $dropcaps_style ) ) {
			$classes[] = 'dropcaps' . $dropcaps_style;
		}

		return $classes;
	}
endif;
add_filter( 'body_class', 'valeo_add_dropcaps', 99 );

// Remove <p>&nbsp</p> from content
function valeo_remove_empty_tags_recursive( $str, $repto = null ) {

	$str = force_balance_tags( $str );

	// Return if string not given or empty.
	if ( ! is_string( $str ) || trim( $str ) == '' ) {
		return $str;
	}

	// Recursive empty HTML tags.
	return preg_replace(
		'~\s?<p>(\s|&nbsp;)+</p>\s?~',
		! is_string( $repto ) ? '' : $repto,
		$str
	);
}
add_filter( 'the_content', 'valeo_remove_empty_tags_recursive', 20, 1 );

// Unyson CSS
if ( ! function_exists( 'valeo_unyson_scripts' ) ) :
	function valeo_unyson_scripts() {
		// check if unyson exist
		if ( class_exists( '_Fw' ) ) :
			// Load unyson stylesheet.
			if ( file_exists( get_template_directory() . '/css/unyson.min.css' ) ) {
				wp_enqueue_style( 'valeo-unyson', get_template_directory_uri() . '/css/unyson.min.css' );
			} else {
				wp_enqueue_style( 'valeo-unyson', get_template_directory_uri() . '/css/unyson.css' );
			}
			if ( file_exists( get_template_directory() . '/css/unyson-grid.min.css' ) ) {
				wp_enqueue_style( 'valeo-unyson-grid', get_template_directory_uri() . '/css/unyson-grid.min.css' );
			} else {
				wp_enqueue_style( 'valeo-unyson-grid', get_template_directory_uri() . '/css/unyson-grid.css' );
			}
			if ( is_rtl() ) {
				wp_enqueue_style( 'valeo-unyson-rtl', get_template_directory_uri() . '/css/unyson-rtl.css' );
			}
		endif;
	}
endif;
add_action( 'wp_enqueue_scripts', 'valeo_unyson_scripts', 9999 );

/**
 * Filter a few parameters into YouTube oEmbed requests
 *
 * @link http://goo.gl/yl5D3
 */
function valeo_iweb_modest_youtube_player( $html, $url, $args ) {
    $html = str_replace( '?feature=oembed', '?feature=oembed&amp;modestbranding=0&amp;showinfo=0&amp;rel=0', $html );
    $html = str_replace( 'frameborder="0"', '', $html );
    return $html;
}
add_filter( 'oembed_result', 'valeo_iweb_modest_youtube_player', 10, 3 );

// Blog post visibility classes
if ( ! function_exists( 'valeo_blog_post_visibility' ) ) :
	function valeo_blog_post_visibility() {

		$blog_post_visibility = valeo_get_customizer_option( 'blog_post_visibility' );
		if ( defined( "FW" ) && valeo_is_unyson_page_builder_for_post_type() ) {
			$blog_post_visibility = 'content';
		}
		$blog_post_visibility = 'blog_post_visibility__' . $blog_post_visibility;
		$body_class           = 'valeo ' . $blog_post_visibility;

		return $body_class;
	}
endif;

// Add specific CSS class to body
if ( ! function_exists( 'valeo_body_classes' ) ) :
	function valeo_body_classes( $classes ) {

		$hide_header_search = '';
		$valeo_get_customizer_option_hide_header_search = valeo_get_customizer_option( 'hide_header_search' );
		if ( ! empty( $valeo_get_customizer_option_hide_header_search ) ) {
			$hide_header_search = 'hide_header_search__true';
		} else {
			$hide_header_search = 'hide_header_search__false';
		}


		array_push( $classes,

			$hide_header_search,
			valeo_blog_post_visibility(),
			'post_id_' . get_the_ID()

		);

		return $classes;
	}
endif;
add_filter( 'body_class', 'valeo_body_classes' );

/**
 * Add new item in navigation
 */
//function new_nav_menu_items( $items, $args ) {
//	if ( $args->theme_location == 'social' ) {
//		$new_item = '<li class="spec" style="border: solid 1px red;"><a href="#" title="title">title</a></li>';
//		$items    = $items . $new_item;
//	}
//	return $items;
//}
//add_filter( 'wp_nav_menu_items', 'new_nav_menu_items', 10, 2 );

/**
 * Remove UL on wp_nav_menu
 */
function wp_nav_menu_no_ul() {
	$options = array(
		'menu_class'     => 'social-navigation',
		'container'      => false,
		'items_wrap'     => '%3$s',
		'link_before'    => '<span class="screen-reader-text">',
		'link_after'     => '</span>',
		'theme_location' => 'social',
		'depth'          => 1
	);

	$menu = wp_nav_menu( $options );
	echo preg_replace( array(
		'#^<ul[^>]*>#',
		'#</ul>$#'
	), '', $menu );

}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom widgets.
 */
require get_template_directory() . '/inc/widgets.php';

include_once(get_template_directory() . '/inc/header_styles.php');
include_once(get_template_directory() . '/inc/mods.php');
