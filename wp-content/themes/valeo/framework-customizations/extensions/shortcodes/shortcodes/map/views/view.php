<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * @var $map_data_attr
 * @var $atts
 * @var $content
 * @var $tag
 */
?>
<div class="fw-map" <?php echo fw_attr_to_html($map_data_attr); ?> data-template-uri="<?php echo get_template_directory_uri (); ?>">
	<div class="fw-map-canvas"></div>
</div>