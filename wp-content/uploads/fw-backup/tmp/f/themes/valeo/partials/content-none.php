<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 */
?>


    <div class="entry-content">
        <div class="post-content">
            <section class="no-results not-found">
                <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'valeo' ); ?></h1>

                <div class="page-content">

                    <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

                        <p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'valeo' ), $allowed_html_array = array(
                                'a' => array( // on allow a tags
                                    'href' => array() // and those anchors can only have href attribute
                                )
                            )), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

                    <?php elseif ( is_search() ) : ?>

                        <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'valeo' ); ?></p>
                        <?php get_search_form(); ?>

                    <?php else : ?>

                        <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'valeo' ); ?></p>
                        <?php get_search_form(); ?>

                    <?php endif; ?>

                </div><!-- .page-content -->
            </section><!-- .no-results -->
        </div>
    </div><!-- .entry-content -->

