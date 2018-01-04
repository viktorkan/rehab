<?php
/**
 * The template for displaying all single posts and attachments
 */

$theme_options = valeo_get_theme_mods();

get_header(); ?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'valeo' ); ?></a>

	<?php if ( function_exists( 'fw_ext_breadcrumbs' ) ) { ?>
		<div class="entry-header-wrapper container-fluid">
			<header class="entry-header"><?php

				// Page Title
				// the_title( '<h1 class="page-title">', '</h1>' );

				// Unyson Breadcrumbs
				if ( function_exists( 'fw_ext_breadcrumbs' ) ) {
					fw_ext_breadcrumbs();
				} ?>

			</header><!-- .entry-header -->
		</div><!-- .entry-header-wrapper.container-fluid -->
	<?php } ?>

    <?php // Post Wide Video
    $video_position = $theme_options['single_post_video'];

    if ( ! empty ( $GLOBALS['wp_customize'] ) ) {
        global $wp_customize;
        $post_values = $wp_customize->unsanitized_post_values();
        if ( ! empty( $post_values['single_post_video'] ) ) {
            $video_position = $post_values['single_post_video'];
        }
    }

    $media = valeo_parse_media( get_post_field('post_content', get_the_ID()) );
    if ( empty ( $media ) ) {
        //
    } else {
        // Post video.
        echo '<div class="post__media_wide">';
        echo '<div class="container">';
        if ( is_single() && ( $video_position == 'wide' ) ) {
            echo valeo_parse_media( get_post_field('post_content', get_the_ID()) );
        }
        echo '</div><!-- /class="container" -->';
        echo '</div>';
    }
    ?>

	<div id="content" class="site-content">
		<?php do_action( 'valeo_before_content' ); ?>

    <div class="container">

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
            <div class="post-container <?php echo valeo_sidebar_class( "container" ); ?>">
                <div class="row">
                    <div class="<?php echo valeo_sidebar_class( "content" ); ?>">

                    <?php
                    // Start the loop.
                    while ( have_posts() ) : the_post();

	                    echo '<div class="entry-content__inner">';

                        /*
                         * Include the post format-specific template for the content. If you want to
                         * use this in a child theme, then include a file called called content-___.php
                         * (where ___ is the post format) and that will be used instead.
                         */
                        get_template_part( 'partials/content', get_post_format() );

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;

	                    echo '</div><!-- .entry-content__inner -->';

                        // Previous/next post navigation.
                        the_post_navigation( array(
                            'next_text' =>
                                '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'valeo' ) . '</span> ' .
                                '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Next', 'valeo' ) . '</span>' .
                                '<span class="post-title">%title</span>',
                            'prev_text' =>
                                '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'valeo' ) . '</span> ' .
                                '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Previous', 'valeo' ) . '</span>' .
                                '<span class="post-title">%title</span>',
                        ) );

                    // End the loop.
                    endwhile;
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
