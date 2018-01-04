<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 */

get_header();
$extra_class = '';
if ( valeo_is_builder_post( get_the_ID() ) ) {
	if ( valeo_is_frontpage() ) {
		$extra_class = ' homepage';
	} else {
		$extra_class = ' unyson-layout';
	}
}
?>

<div id="page" class="hfeed site<?php echo esc_attr( $extra_class ); ?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'valeo' ); ?></a>

	<?php // Hide Page Title and Breadcrumbs on Homepage
	if ( ! valeo_is_frontpage() ) {
		if ( function_exists( 'fw_ext_breadcrumbs' ) ) { ?>
			<div class="entry-header-wrapper container-fluid">
				<header class="entry-header"><?php

					// Page Title
					// the_title( '<h1 class="page-title">', '</h1>' );

					// Unyson Breadcrumbs
					if ( function_exists( 'fw_ext_breadcrumbs' ) ) {
						fw_ext_breadcrumbs();
					} ?>

				</header><!-- .entry-header -->
			</div><!-- .entry-header-wrapper.container-fluid --><?php
		}
	} ?>

	<div id="content" class="site-content">
		<?php if ( valeo_is_frontpage() && ! valeo_is_builder_post( get_the_ID() ) ) {
			do_action( 'valeo_before_content' );
		} ?>

    <div class="container">

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
            <div class="post-container <?php echo valeo_sidebar_class( "container" ); ?>">
                <div class="row">
                    <div class="<?php echo valeo_sidebar_class( "content" ); ?>">

		<?php
		if ( valeo_is_frontpage() && ! valeo_is_builder_post( get_the_ID() ) ) {
			do_action( 'valeo_before_loop' );
		}
		// Start the loop.
		while ( have_posts() ) : the_post();

			echo '<div class="entry-content__inner">';

			// Include the page content template.
			get_template_part( 'partials/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			echo '</div><!-- .entry-content__inner -->';

		// End the loop.
		endwhile;
		if ( valeo_is_frontpage() ) {
			do_action( 'valeo_after_loop' );
		}
		?>
        </div>

		<?php if(valeo_sidebar_visible()) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>

                    </div>
                </div>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
    </div><!-- .container -->

<?php get_footer(); ?>
