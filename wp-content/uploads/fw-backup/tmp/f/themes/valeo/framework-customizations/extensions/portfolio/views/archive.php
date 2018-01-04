<?php
get_header();
global $wp_query;
$ext_portfolio_instance = fw()->extensions->get( 'portfolio' );
$ext_portfolio_settings = $ext_portfolio_instance->get_settings();

$taxonomy        = $ext_portfolio_settings['taxonomy_name'];
$term            = get_term_by( 'slug', get_query_var( 'term' ), $taxonomy );
$term_id         = ( ! empty( $term->term_id ) ) ? $term->term_id : 0;

if ( $term_id ) {
	$cat = array(
		array(
			'taxonomy' => 'fw-portfolio-category',
			'field' => 'term_id',
			'terms' => $term_id
		)
	);
} else {
	$cat = '';
}

$portfolio_query = new WP_Query(array(
	'posts_per_page' => -1,
	'post_type' => 'fw-portfolio',
	'tax_query' => $cat
));

$categories      = fw_ext_portfolio_get_listing_categories( $term_id );

$listing_classes = fw_ext_portfolio_get_sort_classes( $portfolio_query->posts, $categories );
$loop_data       = array(
	'settings'        => $ext_portfolio_instance->get_settings(),
	'categories'      => $categories,
	'image_sizes'     => $ext_portfolio_instance->get_image_sizes(),
	'listing_classes' => $listing_classes
);
set_query_var( 'fw_portfolio_loop_data', $loop_data );
?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'valeo' ); ?></a>

	<div class="entry-header-wrapper container-fluid">
		<header class="entry-header">
			<div class="container">
			<div class="entry-title-wrap">
				<?php

				// Page Title
				if ( ! empty( $term ) ) {
					echo '<h2 class="entry-title">' . $term->name . '</h2>';
				} else {
					echo '<h2 class="entry-title">' . esc_html__( 'Portfolios', 'valeo' ) . '</h2>';
				}

				?>
			</div>

			<?php
			// Unyson Breadcrumbs
			if ( function_exists( 'fw_ext_breadcrumbs' ) ) {
				fw_ext_breadcrumbs();
			}

			// Unyson Feedback
			if ( function_exists( 'fw_ext_feedback' ) ) {
				fw_ext_feedback();
			}

			?>
            </div>
		</header><!-- .entry-header -->
	</div><!-- .entry-header-wrapper.container-fluid -->

	<div id="content" class="site-content">
		<?php do_action( 'valeo_before_content' ); ?>

<div class="container">

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="post-container snone">
				<div class="row">
					<div class="col-sm-12">

						<article id="post-<?php the_ID(); ?>" <?php post_class('portfolio-listing'); ?>>

							<section class="portfolio" id="Container">
								<?php if ( have_posts() ) : ?>

									<?php // portfolio categories ?>
									<?php if ( ! empty( $categories ) ) : ?>
										<div class="wrapp-categories-portfolio">
											<ul id="categories-portfolio" class="portfolio-categories">
												<li class="filter categories-item" data-filter=".category_all">
													<a href='#'><?php esc_attr_e( 'All', 'valeo' ); ?></a>
												</li>
												<?php foreach ( $categories as $category ) : ?>
													<span class="separator">/</span>
													<li class="filter categories-item" data-filter=".category_<?php echo esc_attr( $category->term_id ); ?>">
														<a href='#'><?php echo esc_attr( $category->name ); ?></a>
													</li>
												<?php endforeach; ?>
											</ul>
										</div>
									<?php endif ?>

									<ul id="portfolio-list" class="portfolio-list">
										<?php
										while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
											include(  fw()->extensions->get( 'portfolio' )->locate_view_path('loop-item') );
										endwhile;
										?>
										<li class="clear"></li>
									</ul>
								<?php else : ?>
									<?php get_template_part( 'content', 'none' ); ?>
								<?php endif; ?>
								<div class="clear"></div>
							</section>

						</article><!-- #post-## -->

					</div>
					<?php
					unset( $ext_portfolio_instance );
					unset( $ext_portfolio_settings );
					set_query_var( 'fw_portfolio_loop_data', '' );
					?>

				</div>
			</div>
		</main><!-- .site-main -->
	</div><!-- .content-area -->
</div><!-- .container -->

<?php get_footer(); ?>
