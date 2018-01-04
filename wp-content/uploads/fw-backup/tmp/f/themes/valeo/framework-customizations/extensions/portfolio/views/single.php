<?php
/**
 * The template for displaying all single posts and attachments
 */

$theme_options = valeo_get_theme_mods();

$fw_ext_projects_gallery_image = fw()->extensions->get( 'portfolio' )->get_config( 'image_sizes' );
$fw_ext_projects_gallery_image = $fw_ext_projects_gallery_image['gallery-image'];

get_header(); ?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'valeo' ); ?></a>

	<div class="entry-header-wrapper container-fluid">
		<header class="entry-header">
            <div class="container">
			<div class="entry-title-wrap">
				<?php

				// Page Title
				the_title( '<h2 class="entry-title">', '</h2>' );

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

						<?php
						// Start the Loop.
						while ( have_posts() ) : the_post(); ?>

							<div id="post-<?php the_ID(); ?>" <?php post_class('entry-content'); ?>>
								<?php
								$thumbnails = fw_ext_portfolio_get_gallery_images();

								$captions = array();
								if ( ! empty( $thumbnails ) ) :
									?>
									<section class="wrap-nivoslider theme-default">
										<div id="slider" class="nivoslider">
											<?php foreach ( $thumbnails as $thumbnail ) :
												$attachment = get_post( $thumbnail['attachment_id'] );

												$captions[ $thumbnail['attachment_id'] ] = $attachment->post_title;

												$image = fw_resize( $thumbnail['attachment_id'], $fw_ext_projects_gallery_image['width'], $fw_ext_projects_gallery_image['height'], $fw_ext_projects_gallery_image['crop'] );
												?>
												<img src="<?php echo esc_url( $image ); ?>"
												     class="nivoslider-image"
												     alt="<?php echo esc_attr( $attachment->post_title ); ?>"
												     title="#nivoslider-caption-<?php echo esc_attr( $attachment->ID ); ?>"
												     width="<?php echo esc_attr( $fw_ext_projects_gallery_image['width'] ); ?>"
												     height="<?php echo esc_attr( $fw_ext_projects_gallery_image['height'] ); ?>"
												/>
											<?php endforeach ?>
										</div>
										<div class="nivo-html-caption">
											<?php foreach ( $captions as $attachment_id => $post_title ) : ?>
												<div id="nivoslider-caption-<?php echo esc_attr( $attachment_id ); ?>"><?php echo esc_attr( $post_title ); ?></div>
											<?php endforeach ?>
										</div>
									</section>
								<?php

								else :

									// post thumbnail img settings
									$media = valeo_parse_media( get_the_content() );
									$thumbnail_args = array(
										'read_more' => false,
									);
									// post thumbnail img
									valeo_post_thumbnail($thumbnail_args);

								endif ?>

								<?php
								the_content();
								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) {
									comments_template();
								}
								?>

							</div><!-- .entry-content -->

						<?php endwhile; ?>

					</div>

				</div>
			</div>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
</div><!-- .container -->

<?php get_footer(); ?>
