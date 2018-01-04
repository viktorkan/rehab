<?php
/**
 * Theme meta boxes
 */

/* Post Additional Short Description Field */

/**
 * Display the metabox
 */

if ( ! function_exists( 'valeo_shortdesc_custom_metabox' ) ):
	function valeo_shortdesc_custom_metabox() {
		global $post;
		$shortdesc = get_post_meta( $post->ID, 'shortdesc', true ); ?>

		<label class="screen-reader-text" for="shortdesc">Description:</label>
		<textarea id="shortdesc" name="shortdesc" cols="40" rows="4"><?php if ( $shortdesc ) { echo esc_textarea( $shortdesc ); } ?></textarea>
		<?php
	}
endif;

/**
 * Process the custom metabox fields
 */

if ( ! function_exists( 'valeo_save_custom_shortdesc' ) ):
	// Add action hooks. Without these we are lost
	add_action( 'save_post', 'valeo_save_custom_shortdesc' );
	function valeo_save_custom_shortdesc( $post_id ) {
		global $post;

		if ( ! empty( $_POST['shortdesc'] ) ) {
			update_post_meta( $post->ID, 'shortdesc', trim( $_POST['shortdesc'] ) );
		}
	}
endif;

/**
 * Add meta box
 */

if ( ! function_exists( 'valeo_add_custom_metabox' ) ):
	// Add action hooks. Without these we are lost
	add_action( 'admin_init', 'valeo_add_custom_metabox' );
	function valeo_add_custom_metabox() {
		add_meta_box( 'custom-metabox', esc_html__( 'Short Description', 'valeo' ), 'valeo_shortdesc_custom_metabox', 'post', 'normal', 'high' );
	}
endif;

/**
 * Get and return the values for the short description
 */

if ( ! function_exists( 'valeo_get_custom_shortdesc_box' ) ):
	function valeo_get_custom_shortdesc_box( $id = null ) {
		if ( $id == null ) {
			global $post;
			$id = $post->ID;
		}
		$shortdesc = get_post_meta( $id, 'shortdesc', true );

		return array( $shortdesc );
	}
endif;

/* End */

if (!function_exists('valeo_custom_metabox_admin_scripts')) :
	function valeo_custom_metabox_admin_scripts() {
		// Load matabox admin stylesheet.
		wp_enqueue_style('valeo-custom-metabox-admin-scripts', get_template_directory_uri() . '/inc/mods/mod-metabox/mod-metabox.css');
	}
endif;
add_action('admin_print_styles', 'valeo_custom_metabox_admin_scripts');
