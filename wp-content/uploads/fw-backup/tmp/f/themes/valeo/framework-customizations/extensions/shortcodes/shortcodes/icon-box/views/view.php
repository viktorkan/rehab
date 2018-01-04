<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * @var array $atts
 */
?>
<?php
/*
 * `.fw-iconbox` supports 3 styles:
 * `fw-iconbox-1`, `fw-iconbox-2` and `fw-iconbox-3`
 */
if ( empty( $atts['image'] ) ) {

	$img_attributes = array();

} else {

	$width = '';
	$height = '';

	if ( ! empty( $width ) && ! empty( $height ) ) {
		$image = fw_resize( $atts['image']['attachment_id'], $width, $height, true );
	} else {
		$image = $atts['image']['url'];
	}

	$alt = get_post_meta( $atts['image']['attachment_id'], '_wp_attachment_image_alt', true );

	$img_attributes = array(
		'src' => $image,
		'alt' => $alt ? $alt : ''
	);

	if ( ! empty( $width ) ) {
		$img_attributes['width'] = $width;
	}

	if ( ! empty( $height ) ) {
		$img_attributes['height'] = $height;
	}
}
?>
<div class="fw-iconbox clearfix <?php echo esc_attr($atts['style']); ?> <?php echo esc_attr( $atts['iconbox_type'] ); ?>">
	<div class="fw-iconbox-image"><?php
		if ( empty( $atts['image'] ) ) { ?>
		<i class="<?php echo esc_attr( $atts['icon'] ); ?>"></i><?php
		} else {
			echo fw_html_tag( 'img', $img_attributes );
		} ?>
	</div>
	<div class="fw-iconbox-aside">
		<div class="fw-iconbox-title">
			<h3><?php echo wp_kses( $atts['title'], valeo_kses_init() ); ?></h3>
		</div>
		<?php if ( ! empty( $atts['content'] ) ) { ?>
		<div class="fw-iconbox-text">
			<p><?php echo esc_attr( $atts['content'] ); ?></p>
		</div>
		<?php } ?>
	</div>
</div>