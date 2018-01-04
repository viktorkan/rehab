<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$loop_data = get_query_var( 'fw_portfolio_loop_data' );

$thumbnails_params = $loop_data['image_sizes']['featured-image'];
$thumbnails_params_big = $loop_data['image_sizes']['gallery-image'];

$thumbnail_id = get_post_thumbnail_id();
if ( ! empty( $thumbnail_id ) ) {
	$thumbnail       = get_post( $thumbnail_id );
	$image           = fw_resize( $thumbnail->ID, $thumbnails_params['width'], $thumbnails_params['height'], $thumbnails_params['crop'] );
	$image_big       = fw_resize( $thumbnail->ID, $thumbnails_params_big['width'], $thumbnails_params_big['height'], $thumbnails_params_big['crop'] );
	$thumbnail_title = $thumbnail->post_title;
} else {
	$image           = fw()->extensions->get( 'portfolio' )->locate_URI( '/static/img/no-photo.jpg' );
	$image_big       = fw()->extensions->get( 'portfolio' )->locate_URI( '/static/img/no-photo.jpg' );
	$thumbnail_title = $image;
}

?>
<li class="mix category_all <?php echo ( ! empty( $loop_data['listing_classes'][ get_the_ID() ] ) ) ? $loop_data['listing_classes'][ get_the_ID() ] : ''; ?> portfolio-item">
	<div class="portfolio-img">
		<div class="portfolio-hover">

			<div class="div--table">
				<div class="div--table-cell">

					<a class="portfolio-zoom" href="<?php echo esc_url( $image_big ); ?>" title="<?php echo esc_attr( $thumbnail_title ); ?>" data-gal="prettyPhoto"><i class="fa fa-search"></i></a>
					<a class="portfolio-info" href="<?php the_permalink() ?>"><i class="fa fa-info"></i></a>
					<h4 class="portfolio-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>

				</div>
			</div>

		</div>
		<a href="<?php the_permalink() ?>">
			<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $thumbnail_title ); ?>"
			     width="<?php echo esc_attr( $thumbnails_params['width'] ); ?>"
			     height="<?php echo esc_attr( $thumbnails_params['height'] ); ?>"/>
		</a>
	</div>
</li>