<?php
/**
 * The template used for displaying page content
 */
?>


	<div class="entry-content">
		<?php
        the_content();
        wp_link_pages( array(
            'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'valeo' ) . '</span>',
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
            'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'valeo' ) . ' </span>%',
            'separator'   => '<span class="screen-reader-text">, </span>',
        ) );
		?>
        <div class="clear"></div>
	</div><!-- .entry-content -->

	<?php

	if ( valeo_is_builder_post( get_the_ID() ) ) {
	} else {
		// Edit Post Link
		valeo_edit_post_link();
	}

	if ( valeo_is_builder_post( get_the_ID() ) ) {
	}

    ?>


