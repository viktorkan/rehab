<?php
/**
 * Admin-related functions and filters.
 *
 * @package    CustomContentTeam
 * @subpackage Admin
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2015, Justin Tadlock
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register scripts and styles.
add_action( 'admin_enqueue_scripts', 'cct_admin_register_scripts', 0 );
add_action( 'admin_enqueue_scripts', 'cct_admin_register_styles',  0 );

# Registers member details box sections, controls, and settings.
add_action( 'cct_member_details_manager_register', 'cct_member_details_register', 5 );

# Filter post format support for members.
add_action( 'load-post.php',     'cct_post_format_support_filter' );
add_action( 'load-post-new.php', 'cct_post_format_support_filter' );
add_action( 'load-edit.php',     'cct_post_format_support_filter' );

/**
 * Registers admin scripts.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cct_admin_register_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_register_script( 'cct-edit-member', cct_plugin()->js_uri . "edit-member{$min}.js", array( 'jquery' ), '', true );

	// Localize our script with some text we want to pass in.
	$i18n = array(
		'label_sticky'     => esc_html__( 'Sticky',     'custom-content-team' ),
		'label_not_sticky' => esc_html__( 'Not Sticky', 'custom-content-team' ),
	);

	wp_localize_script( 'cct-edit-member', 'cct_i18n', $i18n );
}

/**
 * Registers admin styles.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cct_admin_register_styles() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_register_style( 'cct-admin', cct_plugin()->css_uri . "admin{$min}.css" );
}

/**
 * Registers the default cap groups.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cct_member_details_register( $manager ) {

	/* === Register Sections === */

	// Contacts section.
	$manager->register_section( 'contacts',
		array(
			'label' => esc_html__( 'Contacts', 'custom-content-team' ),
			'icon'  => 'dashicons-email'
		)
	);

	// Measurements section.
	$manager->register_section( 'measurements',
		array(
			'label' => esc_html__( 'Skills', 'custom-content-team' ),
			'icon'  => 'dashicons-leftright'
		)
	);

	// Social Networks section.
	$manager->register_section( 'social',
		array(
			'label' => esc_html__( 'Social Networks', 'custom-content-team' ),
			'icon'  => 'dashicons-share'
		)
	);

	// 	Additional info section.
	$manager->register_section( 'additional_info',
		array(
			'label' => esc_html__( 'Additional info', 'custom-content-team' ),
			'icon'  => 'dashicons-clipboard'
		)
	);

	/* === Register Controls === */

	$position_args = array(
		'section'     => 'contacts',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __('Member\'s position') ),
		'label'       => esc_html__( 'Member\'s position', 'custom-content-team' ),
	);

	$address_args = array(
		'section'     => 'contacts',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __('PO Box 97845 Baker 567, San Diego, California, US' ) ),
		'label'       => esc_html__( 'Address', 'custom-content-team' ),
		'description' => esc_html__( 'Team\'s address.' , 'custom-content-team' )
	);

	$phone_args = array(
		'section'     => 'contacts',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( '8(800) 456-2696', 'custom-content-team' ) ),
		'label'       => esc_html__( 'Phone', 'custom-content-team' ),
		'description' => esc_html__( 'Enter team\'s phone number.', 'custom-content-team' )
	);

	$email_args = array(
		'section'     => 'contacts',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'agency@email.com', 'custom-content-team' ) ),
		'label'       => esc_html__( 'Email', 'custom-content-team' ),
		'description' => esc_html__( 'Enter team\'s email address.', 'custom-content-team' )
	);

	$skill_name_1_args = array(
		'section'     => 'measurements',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Skill Name' ) ),
		'label'       => esc_html__( 'Skill 1', 'custom-content-team' ),
		'description' => esc_html__( 'Skill name.', 'custom-content-team' )
	);
	$skill_1_args = array(
		'section'     => 'measurements',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Skill Value' ) ),
		'description' => esc_html__( 'Skill value.', 'custom-content-team' )
	);

	$skill_name_2_args = array(
		'section'     => 'measurements',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Skill Name' ) ),
		'label'       => esc_html__( 'Skill 2', 'custom-content-team' ),
		'description' => esc_html__( 'Skill name.', 'custom-content-team' )
	);
	$skill_2_args = array(
		'section'     => 'measurements',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Skill Value' ) ),
		'description' => esc_html__( 'Skill value.', 'custom-content-team' )
	);

	$skill_name_3_args = array(
		'section'     => 'measurements',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Skill Name' ) ),
		'label'       => esc_html__( 'Skill 3', 'custom-content-team' ),
		'description' => esc_html__( 'Skill name.', 'custom-content-team' )
	);
	$skill_3_args = array(
		'section'     => 'measurements',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Skill Value' ) ),
		'description' => esc_html__( 'Skill value.', 'custom-content-team' )
	);

	$skill_name_4_args = array(
		'section'     => 'measurements',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Skill Name' ) ),
		'label'       => esc_html__( 'Skill 4', 'custom-content-team' ),
		'description' => esc_html__( 'Skill name.', 'custom-content-team' )
	);
	$skill_4_args = array(
		'section'     => 'measurements',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Skill Value' ) ),
		'description' => esc_html__( 'Skill value.', 'custom-content-team' )
	);


//	$management_args = array(
//		'section'     => 'measurements',
//		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( '185' ) ),
//		'label'       => esc_html__( 'Management', 'custom-content-team' ),
//		'description' => esc_html__( 'Member\'s skill Management.', 'custom-content-team' )
//	);
//
//	$psychology_args = array(
//		'section'     => 'measurements',
//		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( '79' ) ),
//		'label'       => esc_html__( 'Psychology', 'custom-content-team' ),
//		'description' => esc_html__( 'Member\'s skill Psychology.', 'custom-content-team' )
//	);
//
//	$nurcing_args = array(
//		'section'     => 'measurements',
//		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( '69' ) ),
//		'label'       => esc_html__( 'Nurcing', 'custom-content-team' ),
//		'description' => esc_html__( 'Member\'s skill Nurcing.', 'custom-content-team' )
//	);
//
//	$medical_help_args = array(
//		'section'     => 'measurements',
//		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( '87' ) ),
//		'label'       => esc_html__( 'First Medical Help', 'custom-content-team' ),
//		'description' => esc_html__( 'Member\'s skill First Medical Help.', 'custom-content-team' )
//	);

	/*

	$height_args
	$eyes_args = array(
		'section'     => 'measurements',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Blue' ) ),
		'label'       => esc_html__( 'Eyes', 'custom-content-team' ),
		'description' => esc_html__( 'Team\'s eye color.', 'custom-content-team' )
	);*/

	$social_quote_args = array(
		'section'     => 'social',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Social Quote', 'custom-content-team' ) ),
		'label'       => esc_html__( 'Social Quote', 'custom-content-team' ),
		'type'		  => 'textarea',
	);
	$facebook_args = array(
		'section'     => 'social',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Jane Doe', 'custom-content-team' ) ),
		'label'       => esc_html__( 'Facebook', 'custom-content-team' ),
		'description' => esc_html__( 'Team\'s Facebook Member Address.', 'custom-content-team' )
	);

	$twitter_args = array(
		'section'     => 'social',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Jane Doe', 'custom-content-team' ) ),
		'label'       => esc_html__( 'Twitter', 'custom-content-team' ),
		'description' => esc_html__( 'Team\'s Twitter Member Address.', 'custom-content-team' )
	);

	$googleplus_args = array(
		'section'     => 'social',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Jane Doe', 'custom-content-team' ) ),
		'label'       => esc_html__( 'Google+', 'custom-content-team' ),
		'description' => esc_html__( 'Team\'s Google+ Member Address.', 'custom-content-team' )
	);

	$linkedin_args = array(
		'section'     => 'social',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Jane Doe', 'custom-content-team' ) ),
		'label'       => esc_html__( 'LinkedIn', 'custom-content-team' ),
		'description' => esc_html__( 'Team\'s LinkedIn Member Address.', 'custom-content-team' )
	);

	$pinterest_args = array(
		'section'     => 'social',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Jane Doe', 'custom-content-team' ) ),
		'label'       => esc_html__( 'Pinterest', 'custom-content-team' ),
		'description' => esc_html__( 'Team\'s Pinterest Member Address.', 'custom-content-team' )
	);

	$instagram_args = array(
		'section'     => 'social',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Jane Doe', 'custom-content-team' ) ),
		'label'       => esc_html__( 'Instagram', 'custom-content-team' ),
		'description' => esc_html__( 'Team\'s Instagram Member Address.', 'custom-content-team' )
	);

	$slide_title = array(
		'section'     => 'additional_info',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Screened, Qualif ied & Responsible Nanny', 'custom-content-team' ) ),
		'label'       => esc_html__( 'Slide title', 'custom-content-team' ),
		//'description' => esc_html__( '', 'custom-content-team' )
	);

	$short_desc = array(
		'section'     => 'additional_info',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'Short description', 'custom-content-team' ) ),
		'label'       => esc_html__( 'Short description', 'custom-content-team' ),
		//'description' => esc_html__( '', 'custom-content-team' )
	);

	$manager->register_control( new CCT_Fields_Control( $manager, 'position',    $position_args    ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'address',    $address_args    ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'phone',      $phone_args      ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'email',      $email_args      ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'skill_name_1',     $skill_name_1_args     ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'skill_1',     $skill_1_args     ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'skill_name_2',     $skill_name_2_args     ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'skill_2',     $skill_2_args     ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'skill_name_3',     $skill_name_3_args     ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'skill_3',     $skill_3_args     ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'skill_name_4',     $skill_name_4_args     ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'skill_4',     $skill_4_args     ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'social_quote',   $social_quote_args   ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'facebook',   $facebook_args   ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'twitter',    $twitter_args    ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'googleplus', $googleplus_args ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'linkedin',   $linkedin_args   ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'pinterest',  $pinterest_args  ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'instagram',  $instagram_args  ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'slide_title',  $slide_title  ) );
	$manager->register_control( new CCT_Fields_Control( $manager, 'short_desc',  $short_desc  ) );

	/* === Register Settings === */

	$manager->register_setting( 'position',    array( 'sanitize_callback' => 'wp_strip_all_tags'  ) );
	$manager->register_setting( 'address',     array( 'sanitize_callback' => 'wp_strip_all_tags'  ) );
	$manager->register_setting( 'phone',       array( 'sanitize_callback' => 'wp_strip_all_tags'  ) );
	$manager->register_setting( 'email',       array( 'sanitize_callback' => 'wp_strip_all_tags'  ) );
	$manager->register_setting( 'skill_name_1',      array( 'sanitize_callback' => 'wp_strip_all_tags' ) );
	$manager->register_setting( 'skill_1',      array( 'sanitize_callback' => 'absint' ) );
	$manager->register_setting( 'skill_name_2',      array( 'sanitize_callback' => 'wp_strip_all_tags' ) );
	$manager->register_setting( 'skill_2',      array( 'sanitize_callback' => 'absint' ) );
	$manager->register_setting( 'skill_name_3',      array( 'sanitize_callback' => 'wp_strip_all_tags' ) );
	$manager->register_setting( 'skill_3',      array( 'sanitize_callback' => 'absint' ) );
	$manager->register_setting( 'skill_name_4',      array( 'sanitize_callback' => 'wp_strip_all_tags' ) );
	$manager->register_setting( 'skill_4',      array( 'sanitize_callback' => 'absint' ) );
	$manager->register_setting( 'social_quote',array( 'sanitize_callback' => 'wp_strip_all_tags' ) );
	$manager->register_setting( 'facebook',    array( 'sanitize_callback' => 'esc_url' ) );
	$manager->register_setting( 'twitter',     array( 'sanitize_callback' => 'esc_url' ) );
	$manager->register_setting( 'googleplus',  array( 'sanitize_callback' => 'esc_url' ) );
	$manager->register_setting( 'linkedin',    array( 'sanitize_callback' => 'esc_url' ) );
	$manager->register_setting( 'pinterest',   array( 'sanitize_callback' => 'esc_url' ) );
	$manager->register_setting( 'instagram',   array( 'sanitize_callback' => 'esc_url' ) );
	$manager->register_setting( 'slide_title', array( 'sanitize_callback' => 'wp_strip_all_tags'  ) );
	$manager->register_setting( 'short_desc', array( 'sanitize_callback' => 'wp_strip_all_tags'  ) );
}

function cct_sanitize_textarea($content){
	$content = htmlentities( str_replace("\n", "{cct_break}", $content), ENT_QUOTES);
	return $content;
}

/*
function cct_sanitize_textarea($text){
    return nl2br(htmlentities($text, ENT_QUOTES));

}*/

/**
 * Returns an array of post formats allowed for the member post type.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function cct_get_allowed_member_formats() {

	return apply_filters( 'cct_get_allowed_member_formats', array( /*'audio', 'gallery', 'image', 'video'*/ ) );
}

/**
 * If a theme supports post formats, limit member to only only the audio, image,
 * gallery, and video formats.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cct_post_format_support_filter() {

	$screen       = get_current_screen();
	$member_type = cct_get_member_post_type();

	// Bail if not on the members screen.
	if ( empty( $screen->post_type ) || $member_type !== $screen->post_type )
		return;

	// Check if the current theme supports formats.
	if ( current_theme_supports( 'post-formats' ) ) {

		$formats = get_theme_support( 'post-formats' );

		// If we have formats, add theme support for only the allowed formats.
		if ( isset( $formats[0] ) ) {
			$new_formats = array_intersect( $formats[0], cct_get_allowed_member_formats() );

			// Remove post formats support.
			remove_theme_support( 'post-formats' );

			// If the theme supports the allowed formats, add support for them.
			if ( $new_formats )
				add_theme_support( 'post-formats', $new_formats );
		}
	}

	// Filter the default post format.
	add_filter( 'option_default_post_format', 'cct_default_post_format_filter', 95 );
}

/**
 * Filters the default post format to make sure that it's in our list of supported formats.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $format
 * @return string
 */
function cct_default_post_format_filter( $format ) {

	return in_array( $format, cct_get_allowed_member_formats() ) ? $format : 'standard';
}

/**
 * Help sidebar for all of the help tabs.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function cct_get_help_sidebar_text() {

	// Get docs and help links.
	$docs_link = sprintf( '<li><a href="http://themehybrid.com/docs">%s</a></li>', esc_html__( 'Documentation', 'custom-cotent-team' ) );
	$help_link = sprintf( '<li><a href="http://themehybrid.com/board/topics">%s</a></li>', esc_html__( 'Support Forums', 'custom-content-team' ) );

	// Return the text.
	return sprintf(
		'<p><strong>%s</strong></p><ul>%s%s</ul>',
		esc_html__( 'For more information:', 'custom-content-team' ),
		$docs_link,
		$help_link
	);
}

