<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$id = uniqid( 'testimonials-' );
?>
<div class="fw-testimonials fw-testimonials-2 <?php echo esc_attr( $atts['testimonial_type'] ); ?>"
     data-id="<?php echo esc_attr( $id ) ?>">
	<?php if (!empty($atts['title'])): ?>
		<h3 class="fw-testimonials-title"><?php echo esc_attr( $atts['title'] ); ?></h3>
	<?php endif; ?>

	<div class="fw-testimonials-list" id="<?php echo esc_attr($id); ?>">
		<?php foreach ($atts['testimonials'] as $testimonial): ?>
			<div class="fw-testimonials-item clearfix">
				<div class="fw-testimonials-text">
					<p><?php echo esc_attr( $testimonial['content'] ); ?></p>
				</div>
				<div class="fw-testimonials-meta">
					<div class="fw-testimonials-avatar">
						<?php
						$author_image_url = !empty($testimonial['author_avatar']['url'])
											? $testimonial['author_avatar']['url']
											: fw_get_framework_directory_uri('/static/img/no-image.png');
						?>
						<?php if ( !empty($testimonial['author_avatar']['url']) ) { ?>
						<img src="<?php echo esc_attr($author_image_url); ?>" alt="<?php echo esc_attr($testimonial['author_name']); ?>"/>
						<?php } ?>
					</div>
					<div class="fw-testimonials-author">
						<span class="author-name"><?php echo esc_attr( $testimonial['author_name'] ); ?></span>
						<em><?php echo esc_attr( $testimonial['author_job'] ); ?></em>
						<span class="fw-testimonials-url">
							<a href="<?php echo esc_url($testimonial['site_url']); ?>"><?php echo esc_attr( $testimonial['site_name'] ); ?></a>
						</span>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="fw-testimonials-arrows">
		<a class="prev" id="<?php echo esc_attr($id); ?>-prev" href="#"><i class="fa"></i></a>
		<a class="next" id="<?php echo esc_attr($id); ?>-next" href="#"><i class="fa"></i></a>
	</div>

	<div class="fw-testimonials-pagination" id="<?php echo esc_attr($id); ?>-controls"></div>
</div>