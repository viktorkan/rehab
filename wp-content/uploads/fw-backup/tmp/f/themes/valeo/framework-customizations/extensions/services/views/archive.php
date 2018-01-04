<?php
get_header();
global $wp_query;

$ext_services_instance = fw()->extensions->get( 'services' );
$ext_services_settings = $ext_services_instance->get_settings();

$taxonomy   = $ext_services_settings['taxonomy_name'];
$term       = get_term_by( 'slug', get_query_var( 'term' ), $taxonomy );
$term_id    = ( ! empty( $term->term_id ) ) ? $term->term_id : 0;
$categories = fw_ext_services_get_listing_categories( $term_id );

$listing_classes = fw_ext_services_get_sort_classes( $wp_query->posts, $categories );
$loop_data       = array(
	'settings'        => $ext_services_instance->get_settings(),
	'categories'      => $categories,
	'image_sizes'     => $ext_services_instance->get_image_sizes(),
	'listing_classes' => $listing_classes
);
set_query_var( 'fw_services_loop_data', $loop_data );
?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'valeo' ); ?></a>

	<div class="entry-header-wrapper container-fluid">
		<header class="entry-header"><?php
			// Unyson Breadcrumbs
			if ( function_exists( 'fw_ext_breadcrumbs' ) ) {
				fw_ext_breadcrumbs();
			} ?>
		</header><!-- .entry-header -->
	</div><!-- .entry-header-wrapper.container-fluid -->

	<div id="content" class="site-content">

	<div class="container">

		<div id="primary" class="content-area">
			<main id="main" class="site-main">

				<div class="post-container snone">
					<div class="row">
						<div class="col-sm-12">

							<?php
							// Page Title
							if ( ! empty( $term ) ) {
								echo '<h2 class="entry-title">' . esc_html( $term->name ) . '</h2>';
							} else {
								echo '<h2 class="entry-title">' . esc_html__( 'Our Departments', 'valeo' ) . '</h2>';
							} ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-md-12' ); ?>>
								<section class="services row" id="Container">
									<?php if ( have_posts() ) : ?>
										<?php // services categories ?>
										<?php if ( ! empty( $categories ) ) : ?>
											<div class="wrapp-categories-services">
												<ul id="categories-services" class="services-categories">
													<li class="filter categories-item" data-filter=".category_all">
														<a href='#'><?php esc_attr_e( 'All', 'valeo' ); ?></a>
													</li>
													<?php foreach ( $categories as $category ) : ?>
														<span class="separator">/</span>
														<li class="filter categories-item"
														    data-filter=".category_<?php echo esc_attr( $category->term_id ); ?>">
															<a href='#'><?php echo esc_html( $category->name ); ?></a>
														</li>
													<?php endforeach; ?>
												</ul>
											</div><!-- .wrapp-categories-services -->
										<?php endif ?>
										<ul id="services-list" class="services-list">
											<?php
											while ( have_posts() ) : the_post();
												include( fw()->extensions->get( 'services' )->locate_view_path( 'loop-item' ) );
											endwhile;
											?>
											<li class="clear"></li>
										</ul>
									<?php else : ?>
										<?php get_template_part( 'content', 'none' ); ?>
									<?php endif; ?>
									<div class="clear"></div>
								</section><!-- .services -->
							</article><!-- #post-## -->
							<div class="clear"></div>

						</div><!-- .col-md-## -->
						<?php
						unset( $ext_services_instance );
						unset( $ext_services_settings );
						set_query_var( 'fw_services_loop_data', '' );
						?>

					</div><!-- .row -->
				</div><!-- .post-container -->
			</main><!-- .site-main -->
		</div><!-- .content-area -->
	</div><!-- .container -->

<?php get_footer(); ?>