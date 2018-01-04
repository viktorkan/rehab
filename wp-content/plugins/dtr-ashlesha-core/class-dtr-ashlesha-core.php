<?php
/* Set constant path to the plugin directory */
define( 'ASHLESHA_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

/* Set the constant path to the plugin directory URI */
define( 'ASHLESHA_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * dtr_ashlesha_core class.
 */
if( ! class_exists( 'dtr_ashlesha_core' ) ) {
class dtr_ashlesha_core {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 */
	protected $version = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since   1.0.0
	 */
	protected $plugin_slug = 'ashlesha';

	/**
	 * Instance of this class.
	 *
     * @since   1.0.0
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since   1.0.0
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin
	 *
	 * @since   1.0.0
	 */
	private function __construct() {
		
		// Make shortcodes available
		require_once( ASHLESHA_DIR . 'includes/shortcodes.php' );

		// Meta Boxes
		if ( file_exists(  ASHLESHA_DIR . '/includes/meta-box/init.php' ) ) {
			require_once  ASHLESHA_DIR . '/includes/meta-box/init.php';
		} 
		require_once ( ASHLESHA_DIR . '/includes/metabox-config.php' );

		add_filter( 'the_content', array( $this, 'dtr_ashlesha_remove_sc_wrapping_spaces' ) );
		
		// init process for button control
		add_action( 'init', array( &$this, 'init' ) );
	 	   
		// Add scripts and styles
		add_action( 'wp_enqueue_scripts', array( &$this, 'dtr_ashlesha_add_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'dtr_ashlesha_add_styles' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'load_admin_style' )  );
	
		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since   1.0.0
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since   1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @since   1.0.0
	 */
	 function init() {
		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	 
		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
			// filter the tinyMCE buttons and add our own
			add_filter( 'mce_external_plugins', array( &$this, 'dtr_ashlesha_add_tinymce_plugin' ) );
			add_filter( 'mce_buttons_3', array( &$this, 'dtr_ashlesha_register_tinymce_buttons' ) );
		}
	}
	
	// Add tinymce
	function dtr_ashlesha_add_tinymce_plugin($plugin_array) {
    	$plugin_array['dtrshortcodes'] = plugins_url( 'includes/tinymce.js', __FILE__ ); 
    	return $plugin_array;
	}

	// Register Buttons
	function dtr_ashlesha_register_tinymce_buttons($buttons) {
	   array_push($buttons, "dtr_layout", "dtr_icon", "dtr_button", "dtr_elements", "dtr_typography");
	   return $buttons;
	}
	
	// Remove spaces wrapping shortcodes
	function dtr_ashlesha_remove_sc_wrapping_spaces( $content ) {
		$array = array(
			'<p>[' => '[',
			']</p>' => ']',
			']<br>' => ']'
		);
		$content = strtr( $content, $array );
		return $content;
	}

	/**
	 *  Enqueue Javascript files
	 *
	 * @since   1.0.0
     */
	function dtr_ashlesha_add_scripts() { 

	} // dtr_ashlesha_add_scripts

	/**
     * Enqueue Style sheets
	 *
	 * @since   1.0.0
     */
	function dtr_ashlesha_add_styles() { 
		
	} // dtr_ashlesha_add_styles
	
	
	function load_admin_style() {
        wp_register_style( 'tinymce-custom-style', ASHLESHA_URI . 'assets/css/tinymce.css' );
		wp_enqueue_style( 'tinymce-custom-style' );
	 	wp_enqueue_script( 'wp-color-picker' ); // the wp-color-picker javascript file
   		wp_enqueue_style( 'wp-color-picker' ); // the wp-color-picker css file
     }

 } 
} // class dtr_ashlesha_core

/**
 * Register font size tinymce button
 *
 */
if ( ! function_exists( 'dtr_ashlesha_tinymce_font_buttons' ) ) {
	function dtr_ashlesha_tinymce_font_buttons( $buttons ) {
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'dtr_ashlesha_tinymce_font_buttons' );

// Custom font sizes
if ( ! function_exists( 'dtr_ashlesha_tinymce_text_sizes' ) ) {
	function dtr_ashlesha_tinymce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 20px 21px 22px 24px 26px 28px 30px";
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'dtr_ashlesha_tinymce_text_sizes' );

// Shortcodes in excerpt
add_filter('get_the_excerpt', 'shortcode_unautop');
add_filter('get_the_excerpt', 'do_shortcode');

// Shortcodes in widget
add_filter('widget_text','do_shortcode');

/**
 * Author bios custom fields
 */
if ( ! function_exists( 'dtr_ashlesha_modified_authorbio_fields' ) ) :
function dtr_ashlesha_modified_authorbio_fields( $contact_methods ){
	$contact_methods['ashlesha_twitter'] 	= esc_html__('Twitter URL', 'ashlesha'); 
	$contact_methods['ashlesha_facebook']	= esc_html__('Facebook URL', 'ashlesha');
	$contact_methods['ashlesha_instagram']	= esc_html__('Instagram URL', 'ashlesha');
	$contact_methods['ashlesha_pinterest']	= esc_html__('Pinterest URL', 'ashlesha'); 
	$contact_methods['ashlesha_linkedin']	= esc_html__('Linkedin URL', 'ashlesha'); 
	$contact_methods['ashlesha_mail']		= esc_html__('Mail to URL', 'ashlesha');
	return $contact_methods;
}
endif; 
add_filter('user_contactmethods', 'dtr_ashlesha_modified_authorbio_fields');
// dtr_ashlesha_modified_authorbio_fields