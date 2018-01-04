<?php if (!defined('FW')) die( 'Forbidden' );
/**
 * @var $atts
 */
?>
<div class="fw-heading fw-heading-<?php echo esc_attr($atts['heading']); ?> <?php echo !empty($atts['centered']) ? 'fw-heading-center' : ''; ?> <?php echo !empty($atts['subtitle']) ? 'fw-heading-w-subtitle' : ''; ?> <?php echo esc_attr($atts['custom_css_class']); ?>">
	<?php $heading = "<{$atts['heading']} style='font-weight: {$atts['font_weight']}; color: {$atts['text_color']};' class='fw-special-title'>{$atts['title']}</{$atts['heading']}>"; ?>
	<?php echo wp_kses( $heading, valeo_kses_list() ); ?>
	<?php if (!empty($atts['subtitle'])): ?>
		<div class="fw-special-subtitle"><?php echo esc_attr( $atts['subtitle'] ); ?></div>
	<?php endif; ?>
</div>