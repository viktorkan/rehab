<?php
/**
 * Include and setup custom metaboxes and fields.
 */
add_action( 'cmb2_admin_init', 'ashlesha_metaboxes' );
/**
 * Hook in and add a metabox
 */
function ashlesha_metaboxes() {
	
	// Prefix
	$prefix = '_ashlesha_';
	
	// Display metaboxes according to post format
	add_action( 'admin_print_scripts', 'ashlesha_display_metaboxes', 1000 );
    function ashlesha_display_metaboxes() {
    	if ( get_post_type() == "post" ) :
        ?>
	<script type="text/javascript">
		jQuery( document ).ready( function($) {
	
		var	$pfaudio = $('#format-post-audio').hide(),
			$pflink = $('#format-post-link').hide(),
			$pfquote = $('#format-post-quote').hide(),
			$pfvideo = $('#format-post-video').hide(),
			$pfgallery = $('#format-post-gallery').hide(),
			$post_format = $('input[name="post_format"]');
	
		$post_format.each(function() {
			var $this = $(this);
			if( $this.is(':checked') )
				change_post_format( $this.val() );
		});
	
		$post_format.change(function() {
			change_post_format( $(this).val() );
		});
	
		function change_post_format( val ) {
			$pfaudio.hide();
			$pflink.hide();
			$pfquote.hide();
			$pfvideo.hide();
			$pfgallery.hide();
			
			if( val === 'audio' ) {
				$pfaudio.show();
			} else if( val === 'link' ) {
				$pflink.show();
			} else if( val === 'quote' ) {
				$pfquote.show();
			} else if( val === 'gallery' ) {
				$pfgallery.show();
			} else if( val === 'video' ) {
				$pfvideo.show();
			}
		}
	});
     </script>
	<?php
    	endif;
	 }

	// Page Layout
	$page_layout = array(
		'' 					=> esc_html__( 'Default', 'ashlesha' ),
		'dtr-fullwidth'		=> esc_html__( 'No Sidebar', 'ashlesha' ),
		'dtr-right-sidebar'	=> esc_html__( 'Right Sidebar', 'ashlesha' ),
		'dtr-left-sidebar' 	=> esc_html__( 'Left Sidebar', 'ashlesha' ),
	);
	
	/**
	 * Post Settings
	 */
	$ashlesha_post_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'post-settings-metabox',
		'title'         => esc_html__( 'Post Settings', 'ashlesha' ),
		'object_types'  => array( 'post', ), // Post type
		'context'    	=> 'normal',
		'priority'   	=> 'high',
	) );
	
	$ashlesha_post_metabox->add_field( array(
		'name' =>  esc_html__('Add this post in Featured Post Slider', 'ashlesha'),
		 'id'  => $prefix . 'featured_post',
		'type' => 'checkbox',
		'std'  => 0,
	) );

	/**
	 * Page Settings
	 */
	$ashlesha_page_metabox = new_cmb2_box( array(
		'id'            => $prefix . 'page-settings-metabox',
		'title'         => esc_html__( 'Page Settings', 'ashlesha' ),
		'object_types'  => array( 'page', 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
	) );

	$ashlesha_page_metabox->add_field( array(
		'id'   		=> $prefix . 'page_layout_meta',
		'name' 		=> esc_html__( 'Sidebar Position', 'ashlesha' ),
		'type' 		=> 'select',
		'options'	=> $page_layout,
	) );
	
	/**
	 * Post formats
	 */
	// Gallery Post Format
	$ashlesha_gallery_pf_metabox = new_cmb2_box( array(
		'id'            => 'format-post-gallery',
		'title'      	=> esc_html__( 'Upload Gallery Images', 'ashlesha' ),
		'object_types'	=> array( 'post', ), // Post type
		'context'    	=> 'normal',
		'priority'   	=> 'high',
	) );
	
	$ashlesha_gallery_pf_metabox->add_field( array(
		'id'   	=> $prefix . 'pf_gallery',
		'type' => 'file_list',
		'text' => array(
		//'add_upload_files_text' => 'Replacement', // default: "Add or Upload Files"
//		'remove_image_text' => 'Replacement', // default: "Remove Image"
//		'file_text' => 'Replacement', // default: "File:"
//		'file_download_text' => 'Replacement', // default: "Download"
//		'remove_text' => 'Replacement', // default: "Remove"
	),
	
	) );
	
	
	// Audio Post Format
	$ashlesha_audio_pf_metabox = new_cmb2_box( array(
		'id'            => 'format-post-audio',
		'title'         => esc_html__( 'Audio Embed Code', 'ashlesha' ),
		'object_types'	=> array( 'post', ), // Post type
		'context'    	=> 'normal',
		'priority'   	=> 'high',
	) );
	
	$ashlesha_audio_pf_metabox->add_field( array(
		'id'   => $prefix . 'pf_audio_embed',
		'type' 	=> 'textarea_code',
	) );
	
	// Video Post Format
	$ashlesha_video_pf_metabox = new_cmb2_box( array(
		'id'            => 'format-post-video',
		'title'         => esc_html__( 'Video Embed Code', 'ashlesha' ),
		'object_types'	=> array( 'post', ), // Post type
		'context'    	=> 'normal',
		'priority'   	=> 'high',
	) );
	
	$ashlesha_video_pf_metabox->add_field( array(
		'id'   => $prefix . 'pf_video_embed',
		'type' 	=> 'textarea_code',
	) );
	
	// Quote Post Format
	$ashlesha_quote_pf_metabox = new_cmb2_box( array(
		'id'            => 'format-post-quote',
		'title'      	=> esc_html__( 'Quote', 'ashlesha' ),
		'object_types'	=> array( 'post', ), // Post type
		'context'    	=> 'normal',
		'priority'   	=> 'high',
	) );
	
	$ashlesha_quote_pf_metabox->add_field( array(
		'name'	=> esc_html__( 'Quote text', 'ashlesha' ),
		'id'   	=> $prefix . 'pf_quote',
		'type'	=> 'textarea',
	) );
	
	$ashlesha_quote_pf_metabox->add_field( array(
		'name'	=> esc_html__( 'Quote Source', 'ashlesha' ),
		'id'   	=> $prefix . 'pf_quote_source',
		'type'	=> 'text',
	) );
	
	// Link Post Format
	$ashlesha_link_pf_metabox = new_cmb2_box( array(
		'id'            => 'format-post-link',
		'title'      	=> esc_html__( 'Link Text and URL', 'ashlesha' ),
		'object_types'	=> array( 'post', ), // Post type
		'context'    	=> 'normal',
		'priority'   	=> 'high',
	) );
	
	$ashlesha_link_pf_metabox->add_field( array(
		'name'	=> esc_html__( 'Link text', 'ashlesha' ),
		'id'   	=> $prefix . 'pf_link_text',
		'type'	=> 'text',
	) );
	
	$ashlesha_link_pf_metabox->add_field( array(
		'name'	=> esc_html__( 'Link URL', 'ashlesha' ),
		'id'   	=> $prefix . 'pf_link_url',
		'type'	=> 'text',
	) );

} // ashlesha_metaboxes