<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$loop_data = get_query_var( 'fw_services_loop_data' );

$thumbnails_params = $loop_data['image_sizes']['featured-image'];
$thumbnails_params_big = $loop_data['image_sizes']['gallery-image'];

$thumbnail_id = get_post_thumbnail_id();
if ( ! empty( $thumbnail_id ) ) {
	$thumbnail       = get_post( $thumbnail_id );
	$image           = fw_resize( $thumbnail->ID, $thumbnails_params['width'], $thumbnails_params['height'], $thumbnails_params['crop'] );
	$image_big       = fw_resize( $thumbnail->ID, $thumbnails_params_big['width'], $thumbnails_params_big['height'], $thumbnails_params_big['crop'] );
	$thumbnail_title = $thumbnail->post_title;
} else {
	$image           = fw()->extensions->get( 'services' )->locate_URI( '/static/img/no-photo.jpg' );
	$image_big       = fw()->extensions->get( 'services' )->locate_URI( '/static/img/no-photo.jpg' );
	$thumbnail_title = $image;
}

$service_small_desc = fw_get_db_post_option( get_the_ID(), 'small-description' );

?>
<li class="mix category_all col-sm-6 col-md-4 <?php echo ( ! empty( $loop_data['listing_classes'][ get_the_ID() ] ) ) ? $loop_data['listing_classes'][ get_the_ID() ] : ''; ?>">
	<div class="services-item">
		<div class="services-item--image">
			<a href="<?php the_permalink() ?>">
				<img src="<?php echo esc_url( $image ); ?>"
				     alt="<?php echo esc_attr( $thumbnail_title ); ?>"
				     width="<?php echo esc_attr( $thumbnails_params['width'] ); ?>"
				     height="<?php echo esc_attr( $thumbnails_params['height'] ); ?>"/>
			</a>
		</div>
		<div class="services-item--inner">
			<div class="services-item--name">
				<h3 class="services-item--title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
			</div>
			<?php if ( ! empty( $service_small_desc ) ) { ?>
				<div class="services-item--text">
					<p><?php echo esc_attr( $service_small_desc ); ?></p>
				</div>
			<?php } ?>
		</div>
	</div>
</li>