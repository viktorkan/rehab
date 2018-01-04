<?php
/**
 * The template for displaying all single posts and attachments
 */

$theme_options = valeo_get_theme_mods();

$fw_ext_projects_gallery_image = fw()->extensions->get( 'services' )->get_config( 'image_sizes' );
$fw_ext_projects_gallery_image = $fw_ext_projects_gallery_image['gallery-image'];

$thumbnail_args = array(
	'thumbnail_class' => 'post-thumbnail services--thumbnail',
);
$service_small_desc = fw_get_db_post_option( get_the_ID(), 'small-description' );

get_header(); ?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'valeo' ); ?></a>

	<div class="entry-header-wrapper container-fluid">
		<header class="entry-header">
			<?php

			// Page Title
			//the_title( '<h1 class="page-title">', '</h1>' );

			// Unyson Breadcrumbs
			if ( function_exists( 'fw_ext_breadcrumbs' ) ) {
				fw_ext_breadcrumbs();
			}

			?>
		</header><!-- .entry-header -->
	</div><!-- .entry-header-wrapper.container-fluid -->

	<div id="content" class="site-content">

	<div class="container">

		<div id="primary" class="content-area">
			<main id="main" class="site-main">
				<div class="post-container snone">
					<div class="row">
						<div class="services-singular--menu col-md-4 col-xs-12 <?php if ( is_rtl() ) { ?>col-md-push-8<?php } ?>"><?php
							$ID        = get_the_ID();
							$all_items = new WP_Query( array(
								'posts_per_page' => - 1,
								'post_type'      => 'fw-services'
							) ); ?>
							<div class="services-menu"><?php
								while ( $all_items->have_posts() ) : $all_items->the_post();
									$class = $ID == get_the_ID() ? ' active' : ''; ?>
									<a class="services-menu--item<?php echo esc_attr( $class ); ?>" href="<?php echo esc_url( get_permalink() ); ?>"><?php
										$get_fw_ext_services_get_icon = fw_ext_services_get_icon( get_the_ID() );
										if ( empty( $get_fw_ext_services_get_icon ) ) { ?>
											<i class="fa fa-circle fa--empty"></i>
										<?php } else { ?>
											<i class="<?php echo esc_attr( fw_ext_services_get_icon( get_the_ID() ) ); ?>"></i>
										<?php } ?>
										<?php echo esc_html( get_the_title() ); ?>
									</a><?php
								endwhile; ?>
							</div><!-- .services-menu -->
						</div>

						<div class="services-singular--content col-md-8 col-xs-12 <?php if ( is_rtl() ) { ?>col-md-pull-4<?php } ?>"><?php
							// Start the Loop.
							while ( have_posts() ) : the_post(); ?>
								<div id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content' ); ?>>
									<div class="services--title-wrapper"><?php
										the_title( '<h1 class="services--title">', '</h1>' ); ?>
										<?php if ( ! empty( $service_small_desc ) ) { ?>
											<p class="services--small-description"><?php echo esc_attr( $service_small_desc ); ?></p>
										<?php } ?>
									</div><?php
									// Featured Image
									valeo_post_thumbnail( $thumbnail_args );
									// Content
									the_content();
									// Edit Post Link
									echo '<div class="after-content">' . valeo_edit_post_link() . '</div>'; ?>
								</div><!-- .entry-content --><?php
							endwhile; ?>
						</div>
					</div><!-- .row -->
				</div><!-- .post-container -->

			</main><!-- .site-main -->
		</div><!-- .content-area -->
	</div><!-- .container -->

<?php get_footer(); ?>