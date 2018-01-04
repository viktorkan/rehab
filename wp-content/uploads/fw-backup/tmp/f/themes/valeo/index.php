<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 */
$theme_options           = valeo_get_theme_mods();
$valeo_front_posts_layout = valeo_get_customizer_option( 'front_posts_layout' ); // none 1col 2col nonews 1colws 2colws nonewsl 1colwsl 2colwsl
get_header(); ?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'valeo' ); ?></a>

	<?php // Hide Page Title and Breadcrumbs on Homepage
	if ( ! valeo_is_frontpage() ) { ?>
		<div class="entry-header-wrapper container-fluid">
			<header class="entry-header">
				<?php

				// Page Title
//				echo '<h1 class="page-title">';
//				esc_attr_e('Blog', 'valeo');
//				echo '</h1>';

				// Unyson Breadcrumbs
				if ( function_exists( 'fw_ext_breadcrumbs' ) ) {
					fw_ext_breadcrumbs();
				}

				?>
			</header><!-- .entry-header -->
		</div><!-- .entry-header-wrapper.container-fluid -->
	<?php } ?>


	<div id="content" class="site-content">
		<?php 
		if ( valeo_is_frontpage() && ! is_paged() ) {
			do_action( 'valeo_before_content' );
		}
		?>

<div class="container">

<div id="primary" class="content-area two-columns <?php echo 'front-posts-layout--' . $valeo_front_posts_layout; ?>">
	<main id="main" class="site-main">

		<?php if ( have_posts() ) { ?>

		<?php if ( is_home() && ! valeo_is_frontpage() ) : ?>
			<header>
				<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
			</header>
		<?php endif; ?>

		<?php do_action( 'valeo_content_header', $theme_options ); ?>

		<div class="post-container <?php echo valeo_sidebar_class( "container" ); ?>">
			<div class="row">
				<div class="<?php echo valeo_sidebar_class( "content" ); ?>">
					<?php
					if ( valeo_is_frontpage() && is_home() ) {
						do_action( 'valeo_before_loop' );
					}

					if ( $valeo_front_posts_layout == 'none' || $valeo_front_posts_layout == 'nonews' || $valeo_front_posts_layout == 'nonewsl' ) { /* no post */ }
					else {

						$cat_exclude = '';
						$main_slider_cat = valeo_get_main_slider_category();
						if ( $main_slider_cat['id'] ) {
							$cat_exclude = -$main_slider_cat['id'];
						}

						$per_page   = get_option( "posts_per_page" );
						$paged      = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
						$query_args = array(
							"posts_per_page" => $per_page,
							"paged"          => $paged,
							"cat"            => $cat_exclude,
						);

						$listedPosts = new WP_Query( $query_args );

						// the loop

						echo '<div class="row row-post-wrap">';

						if ( $listedPosts->have_posts() ) {

							// Start the loop.
							$i = - 1;
							$n = 0;

							while ( $listedPosts->have_posts() ) {
								$listedPosts->the_post();
								$n ++;
								if ( (int) $listedPosts->current_post === 0 || ( ! ( $listedPosts->post_count % 2 ) && $listedPosts->post_count == $n ) ) {
									
									remove_filter( 'excerpt_length', 'valeo_excerpt_length', 999 );
									add_filter( 'excerpt_length', 'valeo_excerpt_length_wide', 999 );
									?>
									<article
										id="post-<?php the_ID(); ?>" <?php post_class( 'col-md-12 first-post' ); ?>>
										<?php
										get_template_part( 'partials/content', get_post_format() );
										?>
									</article><!-- #post-## -->
									<?php

								} else {
									/*
									 * Include the Post-Format-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
									 */
									remove_filter( 'excerpt_length', 'valeo_excerpt_length_wide', 999 );
									add_filter( 'excerpt_length', 'valeo_excerpt_length', 999 );
									?>
									<article id="post-<?php the_ID(); ?>" <?php
										if ( $valeo_front_posts_layout == '1col' || $valeo_front_posts_layout == '1colws' || $valeo_front_posts_layout == '1colwsl' ) {
											post_class( 'col-md-12 half-post' );
										} else {
											post_class( 'col-md-6 half-post' );
										} ?>>
										<?php
										get_template_part( 'partials/content', get_post_format() );
										?>
									</article><!-- #post-## -->
									<?php
								}

								// End the loop.
								$i ++;
								if ( $i == 2 ) {
									$i = 0;
									echo '<div class="clear"></div>';
								}

							}

						}

						echo '</div> <!-- end: .row -->';
						echo '<div class="clear"></div>';

						// Previous/next page navigation.
						the_posts_pagination( array(
							'prev_text'          => esc_html__( 'PREV', 'valeo' ),
							'next_text'          => esc_html__( 'NEXT', 'valeo' ),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'valeo' ) . ' </span>',
						) );
					}
					// If no content, include the "No posts found" template.
					} else {
						get_template_part( 'partials/content', 'none' );
					}

					if ( valeo_is_frontpage() && is_home() ) {
						do_action( 'valeo_after_loop' );
					}
					?>
				</div>
				<?php if ( valeo_sidebar_visible() ) : ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
			</div>
		</div>

	</main><!-- .site-main -->


</div><!-- .content-area -->
</div><!-- .container -->

<?php get_footer(); ?>
