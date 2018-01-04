<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

if ( 'line' === $atts['style']['ruler_type'] ): ?>
	<div class="fw-divider-line"><hr/></div>
<?php endif; ?>

<?php if ( 'space' === $atts['style']['ruler_type'] ): ?>
	<div class="fw-divider-space" style="margin-top: <?php echo (int) $atts['style']['space']['height']; ?>px;"></div>
<?php endif; ?>

<?php if (
	'space--05x' === $atts['style']['ruler_type'] ||
	'space-05x' === $atts['style']['ruler_type'] ||
	'space-10x' === $atts['style']['ruler_type'] ||
	'space-15x' === $atts['style']['ruler_type'] ||
	'space-18x' === $atts['style']['ruler_type'] ||
	'space-20x' === $atts['style']['ruler_type'] ||
	'space-25x' === $atts['style']['ruler_type'] ||
	'space-30x' === $atts['style']['ruler_type'] ||
	'space-40x' === $atts['style']['ruler_type'] ||
	'space-45x' === $atts['style']['ruler_type'] ||
	'space-50x' === $atts['style']['ruler_type'] ||
	'space-52x' === $atts['style']['ruler_type'] ||
	'space-55x' === $atts['style']['ruler_type'] ||
	'space-56x' === $atts['style']['ruler_type'] ||
	'space-60x' === $atts['style']['ruler_type'] ||
	'space-65x' === $atts['style']['ruler_type'] ||
	'space-68x' === $atts['style']['ruler_type'] ||
	'space-70x' === $atts['style']['ruler_type'] ||
	'space-72x' === $atts['style']['ruler_type']
	) : ?>
	<div class="fw-divider-space <?php echo esc_attr( $atts['style']['ruler_type'] ); ?>"></div>
<?php endif; ?>
