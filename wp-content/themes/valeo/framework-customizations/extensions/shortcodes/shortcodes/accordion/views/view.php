<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>

<div class="accordion-wrapper <?php echo esc_attr( $atts['acc_type'] ); ?>">

<?php if ( ! empty( $atts['acc_title'] ) ) { ?>
	<div class="fw-accordion-main-title">
		<h3><?php echo esc_attr( $atts['acc_title'] ); ?></h3>
		<div class="clear"></div>
	</div>
<?php } ?>

	<div class="fw-accordion">
		<?php foreach ( $atts['tabs'] as $tab ) : ?>
			<h3 class="fw-accordion-title"><?php echo esc_attr( $tab['tab_title'] ); ?></h3>
			<div class="fw-accordion-content">
				<p><?php echo do_shortcode( $tab['tab_content'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>

<?php if ( ! empty( $atts['btn_label'] ) ) { ?>
	<div class="fw-accordion-button">
		<a href="<?php echo esc_attr( $atts['btn_link'] ) ?>" class="fw-btn fw-btn-1">
			<span><?php echo esc_attr( $atts['btn_label'] ); ?></span>
		</a>
	</div>
<?php } ?>

</div>
