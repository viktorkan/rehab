<?php if (!defined('FW')) die('Forbidden');

/**
 * @var $atts The shortcode attributes
 */

$order = $atts['order'];
$order_by = $atts['orderby'];
$posts_per_page = $atts['posts_per_page'];
$columns = 'columns-' . $atts['columns'];
$space = '';
if ( $atts['space'] ) {
	$space = 'space-yes';
} else {
	$space = 'space-no';
}

$gallery = 'gallery-' . $atts['gallery'];

$ext_portfolio_instance = fw()->extensions->get( 'portfolio' );
$ext_portfolio_settings = $ext_portfolio_instance->get_settings();

$taxonomy        = $ext_portfolio_settings['taxonomy_name'];
$term            = get_term_by( 'slug', get_query_var( 'term' ), $taxonomy );
$term_id         = ( ! empty( $term->term_id ) ) ? $term->term_id : 0;
$categories      = fw_ext_portfolio_get_listing_categories( $term_id );



$unique_id = uniqid();
$args = array(
	'posts_per_page'   => $posts_per_page,
	'orderby'          => $order_by,
	'order'            => $order,
	'post_type'        => 'fw-portfolio',
);
$posts_array = get_posts( $args );
$listing_classes = fw_ext_portfolio_get_sort_classes( $posts_array, $categories );

$loop_data = array(
	'image_sizes' => array(
		'featured-image' => array(
			'width'  => 570,
			'height' => 380,
			'crop'   => true
		),
		'gallery-image'  => array(
			'width'  => 1170,
			'height' => 780,
			'crop'   => true
		)
	),
	'listing_classes' => $listing_classes,
);
$thumbnails_params = $loop_data['image_sizes']['featured-image'];
$thumbnails_params_big = $loop_data['image_sizes']['gallery-image'];

?>

<div class="row">
	<div class="col-sm-12">
		<section class="portfolio portfolio-container portfolio-container-<?php echo esc_attr( $unique_id ); ?> <?php echo esc_attr( $columns . ' ' . $space . ' ' . $gallery ); ?>"
		         id="portfolio-container-<?php echo esc_attr( $unique_id ); ?>"
		         data-unique_id="<?php echo esc_attr( $unique_id ); ?>">

			<?php // portfolio categories ?>
			<?php if ( ! empty( $categories ) ) : ?>
				<div class="wrapp-categories-portfolio">
					<ul id="categories-portfolio" class="portfolio-categories">
						<li class="filter_<?php echo esc_attr( $unique_id ); ?> categories-item" data-filter=".category_all">
							<a href='#'><?php esc_html_e( 'All', 'valeo' ); ?></a>
						</li>
						<?php foreach ( $categories as $category ) : ?>
							<li class="filter_<?php echo esc_attr( $unique_id ); ?> categories-item" data-filter=".category_<?php echo esc_attr( $category->term_id ); ?>">
								<a href='#'><?php echo esc_attr( $category->name ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<ul id="portfolio-list" class="portfolio-list"><?php

			foreach ($posts_array as $post) {
			$thumbnail_id = get_post_thumbnail_id($post);
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

				$category_name = '';
				$post_excerpt = $post->post_excerpt;
//				$categories = get_terms( $taxonomy, $args );
//				fw_print($gallery);

				?>
				<li class="mix_<?php echo esc_attr( $unique_id ); ?> category_all <?php echo ( ! empty( $loop_data['listing_classes'][ $post->ID ] ) ) ? $loop_data['listing_classes'][ $post->ID ] : ''; ?> portfolio-item">
					<div class="portfolio-img">
						<div class="portfolio-hover">
							<div class="div--table">
								<div class="div--table-cell">
									<a class="portfolio-zoom" href="<?php echo esc_url( $image_big ) ?>" title="<?php echo esc_attr( $thumbnail_title ) ?>" data-gal="prettyPhoto"><i class="fa fa-search"></i></a>
									<a class="portfolio-info" href="<?php the_permalink( $post->ID ) ?>"><i class="fa fa-info"></i></a>
									<?php if ( $gallery == 'gallery-' || $gallery == 'gallery-regular' ) { ?>
										<h4 class="portfolio-title"><a href="<?php the_permalink( $post->ID ) ?>"><?php echo get_the_title( $post->ID ); ?></a></h4>
									<?php } ?>
								</div>
							</div>
						</div><!-- .portfolio-hover -->
						<a href="<?php the_permalink($post->ID) ?>">
							<img src="<?php echo esc_url( $image ) ?>"
							     alt="<?php echo esc_attr( $thumbnail_title ) ?>"
							     width="<?php echo esc_attr( $thumbnails_params['width'] ) ?>"
							     height="<?php echo esc_attr( $thumbnails_params['height'] ) ?>"/>
						</a>
						<?php // portfolio categories
						if ( $gallery == 'gallery-alternate' || $gallery == 'gallery-extended' ) {
							$terms = wp_get_post_terms( $post->ID, 'fw-portfolio-category' );
							if ( ! empty( $terms ) ) { ?>
								<ul class="portfolio-categories--single">
								<?php foreach ( $terms as $cat ) {
									echo '<li class="categories-item"><a href="' . get_term_link( $cat ) . '">' . $cat->name . '</a></li>';
								} ?>
								</ul><?php
							}
						} ?>
					</div><!-- .portfolio-img -->
				<?php if ( $gallery == 'gallery-alternate' || $gallery == 'gallery-extended' ) { ?>
					<h4 class="portfolio-title">
						<a href="<?php the_permalink( $post->ID ) ?>"><?php echo get_the_title( $post->ID ); ?></a>
					</h4>
				<?php } ?>
				<?php if ( $gallery == 'gallery-extended' ) { ?>
					<div class="portfolio-excerpt"><?php echo esc_attr( $post_excerpt ); ?></div>
				<?php } ?>
				</li><?php
			} ?>
				<li class="clear"></li>
			</ul>
			<div class="clear"></div>

		</section>
	</div><!-- .col-sm-12 -->
</div><!-- .row -->

<?php
unset( $ext_portfolio_instance );
unset( $ext_portfolio_settings );
set_query_var( 'fw_portfolio_loop_data', '' );
?>