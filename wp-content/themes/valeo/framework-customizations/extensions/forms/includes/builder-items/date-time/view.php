<?php if (!defined('FW')) die('Forbidden');
/**
 * @var array $item
 * @var array $input_value
 */

$options = $item['options'];

wp_enqueue_style('date-timepicker-css', esc_url(get_template_directory_uri()) . '/framework-customizations/extensions/forms/includes/builder-items/date-time/static/css/bootstrap-datetimepicker.min.css', false, null );
wp_enqueue_script('moment-with-locales', esc_url(get_template_directory_uri()) . '/framework-customizations/extensions/forms/includes/builder-items/date-time/static/js/moment-with-locales.min.js', array('jquery'), null );
wp_enqueue_script('bootstrap', esc_url(get_template_directory_uri()) . '/framework-customizations/extensions/forms/includes/builder-items/date-time/static/js/bootstrap.min.js', array('jquery'), null );
wp_enqueue_script('date-timepicker-js', esc_url(get_template_directory_uri()) . '/framework-customizations/extensions/forms/includes/builder-items/date-time/static/js/bootstrap-datetimepicker.min.js', array('jquery', 'bootstrap'), null );
?>
<div class="<?php echo esc_attr(fw_ext_builder_get_item_width('form-builder', $item['width'] .'/frontend_class')) ?>">
	<div class="field-text <?php echo esc_attr( $options['date_time'] )?> <?php echo ( fw_htmlspecialchars( $item['options']['label'] ) == '' ) ? 'label--hide' : ''; ?>">
		<label for="<?php echo esc_attr($attr['id']) ?>" <?php echo ( fw_htmlspecialchars( $item['options']['label'] ) == '' ) ? ' class="label--hide"' : ''; ?>><?php echo fw_htmlspecialchars($item['options']['label']) ?>
			<i class="rt-icon <?php echo esc_attr($options['date_time']) == 'time' ? 'icon-time22 color-pink' : ' icon-calendar3 color-blue'; ?>"></i>
			<?php if ($options['required']): ?><sup>*</sup><?php endif; ?>
		</label>
		<input <?php echo fw_attr_to_html($attr) ?>
			data-pick-date="<?php echo ($options['date_time']) == 'time' ? 'false' : 'true'; ?>"
			data-pick-time="<?php echo ($options['date_time']) == 'date' ? 'false' : 'true'; ?>"
			data-language="<?php echo substr(get_bloginfo( 'language'), 0, 2 ); ?>"
		>
	</div>
</div>