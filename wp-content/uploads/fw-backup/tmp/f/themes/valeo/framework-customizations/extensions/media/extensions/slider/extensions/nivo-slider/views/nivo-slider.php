<?php if (!defined('FW')) die('Forbidden'); ?>

<?php if ( valeo_get_customizer_option( 'main_slider_autoplay' ) == '' ) {
	$autoplay = false;
} else {
	$autoplay = true;
} ?>

<?php if (isset($data['slides'])): ?>
	<section class="wrap-nivoslider theme-default">
		<div class="nivoSlider" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
			<?php foreach ($data['slides'] as $id => $slide): ?>
			<img  width="<?php echo esc_attr($dimensions['width']); ?>"
			      height="<?php echo esc_attr($dimensions['height']); ?>"
			      src="<?php echo esc_attr(fw_resize($slide['src'], $dimensions['width'], $dimensions['height'], true)); ?>"
			      alt="<?php echo esc_attr($slide['title']); ?>"
			      title="#nivo-<?php echo esc_attr($id); ?>" />
			<?php endforeach; ?>
		</div>
		<?php foreach ($data['slides'] as $id => $slide): ?>
		<div id="nivo-<?php echo esc_attr($id) ?>" class="nivo-html-caption">
			<div class="nivo-caption-inner">
				<h1><?php echo wp_kses( $slide['desc'], valeo_kses_init() ) ?></h1>
				<span><?php echo wp_kses( $slide['title'], valeo_kses_init() ) ?></span>
			</div>
		</div>
		<?php endforeach; ?>
	</section>
	<!--/Slider-->
<?php endif; ?>
