<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'valeo' ); ?></a>

	<div class="entry-header-wrapper container-fluid">
		<header class="entry-header">
			<div class="entry-title-wrap">
			<?php

			// Page Title
			the_archive_title( '<h2 class="entry-title">', '</h2>' );
			echo '<span class="postnum">' . apply_filters( 'valeo_plural_text', $GLOBALS['wp_query']->found_posts, 'post', 'posts' ) . '</span>';

			?>
			</div>

			<?php
			// Unyson Breadcrumbs
			if ( function_exists( 'fw_ext_breadcrumbs' ) ) {
				fw_ext_breadcrumbs();
			} 

			?>
		</header><!-- .entry-header -->
	</div><!-- .entry-header-wrapper.container-fluid -->

	<div id="content" class="site-content">
		<?php do_action( 'valeo_before_content' ); ?>

    <div class="container">

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>
            <div class="post-container <?php echo valeo_sidebar_class( "container" ); ?>">
                <div class="row">
                    <div class="<?php echo valeo_sidebar_class( "content" ); ?>">
                        <?php
                        // Start the Loop.
                        while ( have_posts() ) : the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('col-md-12'); ?>>
                                <?php
                                get_template_part( 'partials/content', get_post_format() );
                                ?>
                            </article><!-- #post-## -->
                            <?php

                            // End the loop.
                        endwhile;

                        ?><div class="clear"></div><?php
                        // Previous/next page navigation.
                        the_posts_pagination( array(
                            'prev_text'          => esc_html__( 'PREV', 'valeo' ),
                            'next_text'          => esc_html__( 'NEXT', 'valeo' ),
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'valeo' ) . ' </span>',
                        ) );

                    // If no content, include the "No posts found" template.
                    else :
                        get_template_part( 'partials/content', 'none' );

                    endif;
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
