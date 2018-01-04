<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$bg_color = '';
if ( ! empty( $atts['background_color'] ) ) {
	$bg_color = 'background-color:' . $atts['background_color'] . ';';
}

$bg_image = '';
if ( ! empty( $atts['background_image'] ) && ! empty( $atts['background_image']['data']['icon'] ) ) {
	$bg_image = 'background-image:url(' . $atts['background_image']['data']['icon'] . ');';
}

$bg_image_overlay = '';
if ( ! empty( $atts['background_image_overlay'] ) ) {
	$bg_image_overlay = 'background-color:' . $atts['background_image_overlay'] . ';';
}

$bg_position = '';
if ( ! empty( $atts['background_position'] ) ) {
	$bg_position = 'background-position: top ' . $atts['background_position'] . ';';
}

$bg_repeat = '';
if ( ! empty( $atts['background_repeat'] ) ) {
	$bg_repeat = 'background-repeat: ' . $atts['background_repeat'] . ';';
}

$bg_attachment = '';
if ( ! empty( $atts['background_attachment'] ) ) {
	$bg_attachment = 'background-attachment:' . $atts['background_attachment'] . ';';
}

$bg_size = '';
if ( ! empty( $atts['background_size'] ) ) {
	$bg_size = 'background-size:' . $atts['background_size'] . ';';
}

$parallax = '';
if ( ! empty( $atts['has_parallax'] ) ) {
	$parallax = ' section-bg-image-parallax';
}

$dark_bg = '';
if ( ! empty( $atts['has_dark_background'] ) ) {
	$dark_bg = ' section-dark-bg';
}

$bg_video_data_attr    = '';
$section_extra_classes = '';
if ( ! empty( $atts['video'] ) ) {
	$filetype           = wp_check_filetype( $atts['video'] );
	$filetypes          = array( 'mp4' => 'mp4', 'ogv' => 'ogg', 'webm' => 'webm', 'jpg' => 'poster' );
	$filetype           = array_key_exists( (string) $filetype['ext'], $filetypes ) ? $filetypes[ $filetype['ext'] ] : 'video';
	$bg_video_data_attr = 'data-wallpaper-options="' . fw_htmlspecialchars( json_encode( array( 'source' => array( $filetype => $atts['video'] ) ) ) ) . '"';
	$section_extra_classes .= ' background-video';
}
if ( ! empty( $atts['custom_class'] ) ) {
	$section_extra_classes = ' '.$atts['custom_class'];
}

$section_style   = ( $bg_color || $bg_image ) ? 'style="' . esc_attr($bg_color . $bg_image . $bg_position . $bg_repeat . $bg_attachment . $bg_size) . '"' : '';

$section_extra_classes .= $parallax . $dark_bg ;

$container_class = '';

if ( isset( $atts['is_fullwidth'] ) && $atts['is_fullwidth'] ) {
	if ( $atts['no_padding'] ) {
		$container_class = 'fw-container-fluid-no unyson_fullwidth';
	} else {
		$container_class = 'fw-container-fluid unyson_fullwidth';
	}
} else {
	$container_class = 'fw-container unyson_content';
}

?>
<section class="fw-main-row <?php echo esc_attr($section_extra_classes); ?>" <?php echo wp_kses_post($section_style); ?> <?php echo wp_kses_post($bg_video_data_attr); ?>>
	<span class="bg-image-overlay" style="<?php echo esc_attr( $bg_image_overlay ); ?>"></span>
	<div class="<?php echo esc_attr($container_class); ?>">
		<?php if(!empty( $atts['has_container'])) { ?>
		<div class="container">
		<?php } ?>
		<?php echo do_shortcode( $content ); ?>
		<?php if(!empty( $atts['has_container'])) { ?>
		</div>
		<?php } ?>
	</div>
</section>
