<?php
/**
 * The default template for displaying quote content inside loop
 *
 * Used for index/archive/search.
 */
$theme_options = valeo_get_theme_mods();
$thumbnail_args = array(
    'background' => true,
    'print' => true,
);
?>

    <div class="entry-content" style="<?php
    if ( ! is_single() ) {
	    valeo_post_thumbnail( $thumbnail_args );
    }
    ?>">

        <?php

        if ( is_single() ) :
        else :
            the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
        endif;

        valeo_post_time();
        ?>

        <div class="post-content">
            <?php
            
            the_content();

            if ( is_single() ) :

	            // Edit Post Link
	            valeo_edit_post_link();

	            // Post Categories
	            valeo_post_categories();

	            // Post Tags
	            valeo_post_tags();

            endif;
            
            ?>
        </div>
    </div><!-- .entry-content -->
