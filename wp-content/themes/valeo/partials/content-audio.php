<?php
/**
 * The default template for displaying audio content inside loop
 *
 * Used for index/archive/search.
 */
$theme_options = valeo_get_theme_mods();
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

            if( empty($media) ){
	            // Post thumbnail.
	            echo '<div class="post__media">';
	            valeo_post_thumbnail();
	            echo '</div>';
            } else {
	            if( valeo_check_simple_player($media) ) {
		            // Post audio.
                    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                    $url = $thumb['0'];
                    echo '<div class="wp-audio-image" style="background-image: url(' . $url . ');">';
                    echo '<div class="wp-audio-bgcolor">';
                    echo valeo_parse_media(get_the_content());
                    echo '</div>';
                    echo '</div>';
	            } else {
		            // Post audio.
                    echo valeo_parse_media(get_the_content());
	            }
            }

            // Post Content wrapper
            echo '<div class="post__inner">';
            do_action( "valeo_after_thumbnail" );

            ?>
            <div class="post-content">
                <?php
                if( valeo_is_blog_view_excerpt() && !is_single() ){
                    if(empty($media)) {
                        the_excerpt();
                    }
                    echo apply_filters( 'excerpt_more', false );
                } else {
                    /* translators: %s: Name of current post */
                    the_content( sprintf(
                        esc_html__( 'CONTINUE READING %s', 'valeo' ),
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