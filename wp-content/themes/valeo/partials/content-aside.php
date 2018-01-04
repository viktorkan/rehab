<?php
/**
 * The default template for displaying aside content inside loop
 *
 * Used for index/archive/search.
 */
$theme_options = valeo_get_theme_mods();
$thumbnail_args = array(
    'background' => true,
    'print' => true,
);
?>


    <?php
    // Sticky Label
    $classes = get_post_class();
    if ( in_array( 'sticky', $classes ) && is_sticky() && !is_single() ) {
        do_action( 'valeo_sticky_label' );
    }

    ?>
    <div class="entry-content" style="<?php
    if ( ! is_single() ) {
        valeo_post_thumbnail( $thumbnail_args );
    }
    ?>">

            <?php

            if ( is_single() ) :
                the_title( '<h1 class="page-title">', '</h1>' );
            else :
                the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
            endif;

            valeo_post_time();

            ?>

        <div class="post-content">
            <?php

            the_content();

            if ( ! valeo_is_blog_view_excerpt() || is_single() ) {

                // Edit Post Link
                valeo_edit_post_link();

                // Post Categories
                valeo_post_categories();

                // Post Tags
                valeo_post_tags();
            }
            
            ?>
            <div class="clear"></div>
        </div>
    </div><!-- .entry-content -->
