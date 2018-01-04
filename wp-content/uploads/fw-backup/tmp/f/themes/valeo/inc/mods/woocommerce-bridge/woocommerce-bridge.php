<?php
function valeo_woocommerce_enabled()
{
    if ( class_exists( 'woocommerce' ) ){ return true; }
    return false;
}

if ( ! function_exists( 'woocommerce_support' ) ) :
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
endif;
add_action( 'after_setup_theme', 'woocommerce_support' );

//check if the plugin is enabled, otherwise stop the script
if(!valeo_woocommerce_enabled()) { return false; }

//product thumbnails
if ( ! function_exists( 'valeo_woocommerce_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function valeo_woocommerce_setup() {
        if(!has_image_size('shop_catalog')) {
            add_image_size('shop_catalog', 300, 300, true);
        }
        if(!has_image_size('shop_single')){
            add_image_size( 'shop_single', 600, 600, true );
        }
        if(!has_image_size('shop_thumbnail')){
            add_image_size( 'shop_thumbnail', 150, 150, true );
        }

        register_sidebar( array(
            'name'          => esc_html__( 'Woocommerce', 'valeo' ),
            'id'            => 'woocommerce',
            'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'valeo' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title"><span>',
            'after_title'   => '</span></h2>',
        ) );
    }
endif; // valeo_news_tabs_setup
add_action( 'after_setup_theme', 'valeo_woocommerce_setup', 20 );

if( !has_action( 'valeo_before_loop' ) ) {
    // Add the widget area to the start of the loop
    add_action('valeo_before_loop', 'valeo_add_before_loop_widget');
    function valeo_add_before_loop_widget() {
        if ( valeo_is_frontpage() && is_home() ) {
        	$widget_width = valeo_sidebar_class("container");
				if ($widget_width == 'snone') {
					$widget_width = 'widget-width__container';
				} else {
					$widget_width = 'widget-width__loop';
				}
            echo '<div class="sidebar-before-loop' . esc_attr($widget_width) . '"><div class="row mod-widget-grid">';
            if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( esc_html__( 'Widgets Before Loop (Loop-Width)', 'valeo' ) ) ) :
            endif;
            echo '</div></div>';
        }
    }
}

//remove woo defaults
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);

//add theme actions && filter
add_action( 'woocommerce_before_main_content', 'valeo_woocommerce_before_main_content', 10);
add_action( 'woocommerce_after_main_content', 'valeo_woocommerce_after_main_content', 10);

#
# creates turbo framework container around the shop pages
#
if ( ! function_exists( 'valeo_woocommerce_before_main_content' ) ):
    function valeo_woocommerce_before_main_content()
    {
         ?>

	    <div id="page" class="hfeed site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'valeo' ); ?></a>

		<?php // Hide Page Title and Breadcrumbs on Homepage ?>
		<div class="entry-header-wrapper container-fluid">
			<header class="entry-header">
				<?php

				// Page Title
				if ( is_shop() ) {
					echo '<h1 class="page-title">';
					//woocommerce_page_title();
					echo '</h1>';
				} else {
					if ( ! is_single() ) {
						//the_title( '<h1 class="page-title">', '</h1>' );
					}
				}

				// Woocommerce Breadcrumbs
				woocommerce_breadcrumb();

				?>
			</header><!-- .entry-header -->
		</div><!-- .entry-header-wrapper.container-fluid -->
		<?php ?>

		<div id="content" class="site-content">
			<?php do_action( 'valeo_before_content' ); ?>

        <div class="container">
        <div class="content-area">
        <div class="post-container <?php echo valeo_sidebar_class( "container", "woocommerce_sidebar" ); ?>">
            <div class="row">
                <div class="<?php echo valeo_sidebar_class( "content", "woocommerce_sidebar" ); ?>">
    <?php }
endif;


#
# closes turbo framework container around the shop pages
#
if ( ! function_exists( 'valeo_woocommerce_after_main_content' ) ):
function valeo_woocommerce_after_main_content()
{
    wp_reset_query();
	?>
                </div>
                <?php if(valeo_woocommerce_sidebar_visible()) : ?>
                <?php get_sidebar('woocommerce'); ?>
                <?php endif; ?>
            </div>
        </div>
        </div>
        </div>
	<?php
}
endif;

if ( ! function_exists('valeo_woocommerce_customize_register') ) :
    /**
     * Add postMessage support for site title and description for the Customizer.
     *
     * @param WP_Customize_Manager $wp_customize Customizer object.
     */
    function valeo_woocommerce_customize_register( $wp_customize ) {
        $defaults = valeo_get_theme_mod_defaults();
        // Add 404 Page Settings section.
        $wp_customize->add_section( 'woocommerce' , array(
            'title'       => esc_html__( 'Woocommerce', 'valeo' ),
            'priority'    => 900,
            'description' => esc_html__( '', 'valeo' ),
        ) );

        $wp_customize->add_setting(
            "woocommerce_sidebar",
            array(
                'default' => $defaults["woocommerce_sidebar"],
                'sanitize_callback' => 'valeo_sanitize_sidebar',
            )
        );

        $wp_customize->add_control( new WP_Customize_Layout_Picker_Control( $wp_customize, "woocommerce_sidebar",
            array(
                'label' => esc_html__( 'Sidebar Position', 'valeo' ),
                'section' => 'woocommerce',
            )
        ));
    }
endif;
add_action( 'customize_register', 'valeo_woocommerce_customize_register', 50 );

if ( ! function_exists('valeo_woocommerce_sidebar_visible') ) :
    /**
     * Check if sidebar should be displayed.
     *
     * @return bool $value.
     */
    function valeo_woocommerce_sidebar_visible() {
	    $woocommerce_sidebar = valeo_get_customizer_option( 'woocommerce_sidebar' );

        $value = true;

        if( $woocommerce_sidebar == "none" || is_singular( 'product' ) ) {
            $value = false;
        }

        return $value;
    }
endif; // valeo_woocommerce_sidebar_visible

if ( ! function_exists('valeo_woocommerce_loop_thumbnail_open') ) :
    function valeo_woocommerce_loop_thumbnail_open() {
        echo '<span class="product__thumbnail">';
    }
endif; // valeo_woocommerce_loop_thumbnail_open
add_action( 'woocommerce_before_shop_loop_item', 'valeo_woocommerce_loop_thumbnail_open' );

if ( ! function_exists('valeo_woocommerce_loop_thumbnail_close') ) :
    function valeo_woocommerce_loop_thumbnail_close() {
        echo '</span>';
    }
endif; // valeo_woocommerce_loop_thumbnail_close
add_action( 'woocommerce_before_shop_loop_item_title', 'valeo_woocommerce_loop_thumbnail_close' );

// Remove woocommerce breadcrumbs
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// Rating Placement
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_rating', 20 );

// Change breadcrumb delimiter
if ( ! function_exists('valeo_change_breadcrumb_delimiter') ) :
function valeo_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = '';
	return $defaults;
}
endif;
add_filter( 'woocommerce_breadcrumb_defaults', 'valeo_change_breadcrumb_delimiter' );

// Remove page title
if ( ! function_exists('valeo_woocommerce_remove_page_title') ) :
    function valeo_woocommerce_remove_page_title() {
        return '';
    }
endif;
add_filter( 'woocommerce_show_page_title', 'valeo_woocommerce_remove_page_title' );

// Change number or products per row to 3
if ( ! function_exists('valeo_woocommerce_loop_columns') ) :
    function valeo_woocommerce_loop_columns() {
        $woocommerce_sidebar = valeo_get_customizer_option( 'woocommerce_sidebar' );
        if ( $woocommerce_sidebar == "none" ) {
            return 4; // 4 products per row
        }
        return 3; // 3 products per row
    }
endif;
add_filter( 'loop_shop_columns', 'valeo_woocommerce_loop_columns' );

// Display 24 products per page.
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

// WooCommerce CSS
if ( ! function_exists( 'valeo_woocommerce_scripts' ) ) :
    function valeo_woocommerce_scripts() {
        // check if woocommerce exist
        if ( class_exists( 'woocommerce' ) ) :
            // Load woocommerce stylesheet
            wp_enqueue_style( 'valeo-woocommerce', get_template_directory_uri() . '/inc/mods/woocommerce-bridge/woocommerce.css' );
            wp_enqueue_script( 'valeo-woocommerce-js', get_template_directory_uri() . '/inc/mods/woocommerce-bridge/woocommerce.js', array('jquery'), 1, true);
            if ( is_rtl() ) {
                wp_enqueue_style( 'valeo-woocommerce-rtl', get_template_directory_uri() . '/inc/mods/woocommerce-bridge/woocommerce-rtl.css' );
            }
        endif;
    }
endif;
add_action( 'wp_enqueue_scripts', 'valeo_woocommerce_scripts' );

// Shopping Cart Dropdown in the main menu
if ( ! function_exists( 'valeo_woocommerce_cart_dropdown' ) ) :
	function valeo_woocommerce_cart_dropdown() {
	
		global $woocommerce;
		$cart_subtotal = $woocommerce->cart->get_cart_subtotal();
		$link = $woocommerce->cart->get_cart_url();
		$output = '';
	
		ob_start();
		the_widget(
			'WC_Widget_Cart',
			'',
			array(
				'widget_id'=>'cart-dropdown',
				'before_widget' => '',
				'after_widget' => '',
				'before_title' => '<span class="hidden">',
				'after_title' => '</span>'
			    )
	    );

		$widget = ob_get_clean();

		$output .= ''.
		'<span class="header-button header-button__shop"><span class="cart__subtotal"><a href="' . esc_url( $link ) . '">'.$cart_subtotal.'</a></span><i class="fa fa-shopping-cart"></i></span>' .
		'<div class="cart__dropdown" data-success="Product added">'.
			'<div class="cart__dropdown_inner">' . $widget . '</div>' .
		'</div>'.
		'<span class="header-button header-button__divider"></span>' .
		'';

		return $output;
	}
endif;