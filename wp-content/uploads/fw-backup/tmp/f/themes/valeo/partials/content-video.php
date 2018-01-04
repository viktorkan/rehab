<?php
/**
 * The default template for displaying video content inside loop
 *
 * Used for index/archive/search.
 */
$theme_options = valeo_get_theme_mods();

$video_position = valeo_get_customizer_option( 'single_post_video' );

?>


        <?php
        // Sticky Label
        $classes = get_post_class();
        if ( in_array( 'sticky', $classes ) && is_sticky() && !is_single() ) {
            do_action( 'valeo_sticky_label' );
        }

        ?>
        <div class="entry-content">
            <?php

            do_action( "valeo_before_thumbnail" );

            $media = valeo_parse_media( get_the_content() );
            if ( valeo_is_builder_post( get_the_ID() ) ) {
	            $media = false;
	            remove_filter("the_content", "valeo_remove_first_line_media");
            }

            $thumbnail_args = array(
                'background' => true,
                'print'=>false
            );
            
            if( empty($media) ){
	            // Post thumbnail.
	            echo '<div class="post__media">';
	            valeo_post_thumbnail();
	            echo '</div>';
            } else {
	            // Post video.
                echo '<div class="post__media">';
                if ( is_single() && ($video_position == 'wide') ) {
                    // no video
                } else {
                    echo valeo_parse_media(get_the_content());
                }
                if (has_post_thumbnail()) {
                    // Post thumbnail.
                    if ( is_single() ) {
                        // no thumbnail
                    } else {
                        echo '<div class="post__thumbnail" style="' . valeo_post_thumbnail($thumbnail_args) . '"></div>';
                    }
                }
                echo '</div>';
            }

            // Post Content wrapper
            echo '<div class="post__inner">';
            do_action( "valeo_after_thumbnail" );

            ?>
            <div class="post-content">
                <?php
                if( valeo_is_blog_view_excerpt() && !is_single() ){
                    if(empty($media)) {
                        echo "<p>".valeo_truncate_words( strip_tags( get_the_content() ), apply_filters( 'excerpt_length', false ) )."</p>";
                    } else {
                        echo "<p>".valeo_truncate_words( strip_tags( valeo_remove_first_line_media( get_the_content() ) ), apply_filters( 'excerpt_length', false ) )."</p>";
                    }
                    echo apply_filters( 'excerpt_more', false );
                } else {
                    /* translators: %s: Name of current post */
                    the_content( sprintf(
                        esc_html__( 'Read more %s', 'valeo' ),
                        the_title( '<span class="screen-reader-text">', '</span>', false )
                    ) );

                    wp_link_pages( array(
                        'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'valeo' ) . '</span>',
                        'after'       => '</div>',
                        'link_before' => '<span>',
                        'link_after'  => '</span>',
                        'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'valeo' ) . ' </span>%',
                        'separator'   => '<span class="screen-reader-text">, </span>',
                    ) );
                    ?>

                    <?php

                    // Edit Post Link
                    valeo_edit_post_link();

	                // Post Categories
	                valeo_post_categories();

                    // Post Tags
                    valeo_post_tags();
	                
                }

                ?>
            </div><!-- .post-content -->
            <?php echo '</div><!-- .post__inner -->'; ?>
            
        </div><!-- .entry-content -->

<?php
// Author bio.
if ( is_single() && get_the_author_meta( 'description' ) ) :
    get_template_part( 'author-bio' );
endif;
?>