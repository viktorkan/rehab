<?php
/**
 * The default template for displaying link content inside loop
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
            the_title( '<h1 class="page-title">', '</h1>' );
        else :
        endif;

        valeo_post_time();

        the_content();

        // Post Categories
        //valeo_post_categories();
        
        ?>

    </div><!-- .entry-content -->
