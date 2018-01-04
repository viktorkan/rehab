<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * @var string $form_id
 * @var string $form_html
 * @var array $extra_data
 */
?>
<div class="form-wrapper contact-form <?php echo esc_attr( $extra_data['form_type'] ); ?>">
	<?php //echo wp_kses( $form_html, valeo_kses_list() ); ?>
	<?php echo $form_html ?>
</div>