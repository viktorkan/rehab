<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();

$theme_options = valeo_get_theme_mods();
?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'valeo' ); ?></a>

	<div id="content" class="site-content">
		<?php do_action( 'valeo_before_content' ); ?>

    <div class="container">

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

            <article class="hentry hentry-404">
                <div class="entry-content">
                    <section class="error-404 not-found">

	                    <?php // Page 404 image
	                    if ( $theme_options['page_image_404'] != '' ): ?>
		                    <img class="error-image" src="<?php echo esc_url( $theme_options['page_image_404'] ); ?>" alt="error">
	                    <?php endif; ?>

	                    <?php // Page 404 title
	                    if ( $theme_options['page_title_404'] != '' ): ?>
		                    <h1 class="page_title_404 page-title"><?php echo esc_attr( $theme_options['page_title_404'] ); ?></h1>
	                    <?php elseif ( $theme_options['page_title_404'] == ' ' ): ?>
	                    <?php else: ?>
		                    <h1 class="page_title_404 page-title"><?php esc_html_e( 'Oops, page not found!', 'valeo' ); ?></h1>
	                    <?php endif; ?>

	                    <?php // Page Message
	                    if ( $theme_options['page_message_404'] != '' ): ?>
		                    <p class="page_message_404"><?php echo esc_attr( $theme_options['page_message_404'] ); ?></p>
		                    <p class="search_404_label"><?php esc_html_e( 'You can search what interested:', 'valeo' ); ?></p>
		                    <?php get_search_form(); ?>
	                    <?php elseif ( $theme_options['page_message_404'] == ' ' ): ?>
		                    <p class="search_404_label"><?php esc_html_e( 'You can search what interested:', 'valeo' ); ?></p>
		                    <?php get_search_form(); ?>
	                    <?php else: ?>
		                    <p class="page_message_404"><?php esc_html_e( 'The page you are looking for does not exist; it may have been moved, or removed altogether. You might want to try the search function. Alternatively, return to the front page.', 'valeo' ); ?></p>
		                    <p class="search_404_label"><?php esc_html_e( 'You can search what interested:', 'valeo' ); ?></p>
		                    <?php get_search_form(); ?>
	                    <?php endif; ?>

	                    <?php // Link to homepage
	                    if ( $theme_options['hide_homepage_link'] == '' ): ?>
		                    <div class="homepage_link_block">
			                    <p class="homepage_link_or"><?php esc_html_e( 'or', 'valeo' ); ?></p>
			                    <p class="homepage_link">
				                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
				                       title="<?php esc_html_e( 'Go to Home', 'valeo' ); ?>">
					                    <?php esc_html_e( 'Go to Home', 'valeo' ); ?>
				                    </a>
			                    </p>
		                    </div>
	                    <?php endif; ?>

                    </section><!-- .error-404 -->
            </article><!-- #post-## -->

            <?php do_action( 'valeo_after_loop' ); ?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
	</div><!-- .container -->

<?php get_footer(); ?>
