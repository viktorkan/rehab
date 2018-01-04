<?php
/**
 * The template for displaying search results pages.
 */

get_header(); ?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'valeo' ); ?></a>

	<div class="entry-header-wrapper container-fluid">
		<header class="entry-header">
			<div class="entry-title-wrap">
			<?php

			// Page Title ?>
			<h2 class="entry-title"><?php printf( esc_html__( 'Search Results for: %s', 'valeo' ), get_search_query() ); ?></h2>
			<?php
			echo '<span class="postnum">' . apply_filters( 'valeo_plural_text', $GLOBALS['wp_query']->found_posts, 'post', 'posts' ) . '</span>';
			?>
			</div>
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
                    // Start the loop.
                    while ( have_posts() ) : the_post();

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
					?>
					<div class="post-container <?php echo valeo_sidebar_class("container"); ?>">
						<div class="row">
							<div class="<?php echo valeo_sidebar_class("content"); ?>">
								<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-12'); ?>>
									<?php get_template_part('partials/content', 'none'); ?>
								</article>
								<div class="clear"></div>
								<?php
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
