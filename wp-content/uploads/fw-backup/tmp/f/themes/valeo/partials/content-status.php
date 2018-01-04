<?php
/**
 * The default template for displaying status content inside loop
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

        <div class="author-avatar">
            <?php
            /**
             * Filter the author bio avatar size.
             *
             * @param int $size The avatar height and width size in pixels.
             */
            $author_bio_avatar_size = apply_filters( 'valeo_author_bio_avatar_size', 122 );

            echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
            ?>
        </div><!-- .author-avatar -->

        <?php
        valeo_post_time();
        
        ?>
        <div class="post-content">
            <?php

            echo valeo_excerpt_chat(get_the_content(), 140, false, false, false);

            if ( is_single() ) :

	            // Edit Post Link
	            valeo_edit_post_link();

            endif;

            ?>
        </div>
    </div><!-- .entry-content -->
