<?php if (!defined('FW')) die( 'Forbidden' ); ?>
<?php $color_class = !empty($atts['color']) ? "fw-btn-{$atts['color']}" : ''; ?>
<?php if ( ! empty( $atts['centered'] ) && $atts['centered'] ) {
	echo '<p style="text-align: center">';
} ?>
<a href="<?php echo esc_attr($atts['link']) ?>" target="<?php echo esc_attr($atts['target']) ?>" class="fw-btn fw-btn-1 <?php echo esc_attr($color_class); ?>">
	<span><?php echo wp_kses( $atts['label'], valeo_kses_init() ); ?></span>
</a>
<?php if ( ! empty( $atts['centered'] ) && $atts['centered'] ) {
	echo '</p>';
} ?>