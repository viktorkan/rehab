<?php
/**
 * The default template for displaying chat content inside loop
 *
 * Used for index/archive/search.
 */

$theme_options = valeo_get_theme_mods();
$valeo_front_posts_layout = valeo_get_customizer_option( 'front_posts_layout' );
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

	$media = valeo_parse_media( get_the_content() );
	if ( valeo_is_builder_post( get_the_ID() ) ) {
		$media = false;
		remove_filter("the_content", "valeo_remove_first_line_media");

	}

	// if 1col
	if ( ( $valeo_front_posts_layout == '1col' && is_home() ) || ( $valeo_front_posts_layout == '1colws' && is_home() ) || ( $valeo_front_posts_layout == '1colwsl' && is_home() ) ) { ?>
		<?php
		$thumbnail_args = array(
			'read_more' => false,
		);
		$thumbnail_args__no_a = array(
			'read_more' => false,
			'no_url'    => true,
		);
		$thumbnail_args__a_bg = array(
			'background' => true,
			'print' => false,
		);
		
		if ( empty( $media ) ) {
			if ( has_post_thumbnail() ) {
				echo '<div class="row post-thumbnail-row">';
				// Post thumbnail.
				echo '<div class="col-md-6 col-media">';
				echo '<div class="post__media">';

				// post thumbnail img
				if ( $valeo_front_posts_layout == '1col' || $valeo_front_posts_layout == '1colws' || $valeo_front_posts_layout == '1colwsl' ) {
					echo '<a href="'. esc_url( get_the_permalink() ) .'" class="post-thumbnail" style="'. valeo_post_thumbnail( $thumbnail_args__a_bg ) . '">';
					valeo_post_thumbnail($thumbnail_args__no_a);
					echo '</a>';
				} else {
					valeo_post_thumbnail($thumbnail_args);
				}

				echo '</div>';
				echo '</div><!-- end: .col-media -->';
				echo '<div class="col-md-6 col-content">';
			} else {
				// no thumbnail
				echo '<div class="col-content">';
			}
		} else {
			echo '<div class="row post-thumbnail-row">';
			// Post video.
			if (!empty($media)) {
				$oembed_with_background = array("twitter.com", "facebook.com");
				foreach ($oembed_with_background as $needle) {
					if (preg_match('/' . $needle . '/', $media)) {
						echo '<div class="col-sm-12 col-media">';
						break;
					}
				}

			} else {
				echo '<div class="col-md-6 col-media">';
			}

			echo valeo_parse_media(get_the_content());
			echo '</div><!-- end: .col-media -->';
			if (!empty($media)) {
				$oembed_with_background = array("twitter.com", "facebook.com");
				foreach ($oembed_with_background as $needle) {
					if (preg_match('/' . $needle . '/', $media)) {
						echo '<div class="col-sm-12 col-content">';
						break;
					}
				}

			} else {
				echo '<div class="col-md-6 col-content">';
			}
		}
		?>
	<?php } // end: if 1col

	do_action( "valeo_before_thumbnail" );

	// if != 1col
	if ( ( $valeo_front_posts_layout == '1col' && is_home() ) || ( $valeo_front_posts_layout == '1colws' && is_home() ) || ( $valeo_front_posts_layout == '1colwsl' && is_home() ) ) {}
	else {
		$thumbnail_args = array(
			//'read_more' => true,
			'read_more' => false,
		);
		
		if ( empty( $media ) ) {
			// Post thumbnail.
			echo '<div class="post__media">';
			valeo_post_thumbnail($thumbnail_args);
			echo '</div>';
		} else {
			// Post video.
			echo valeo_parse_media(get_the_content());
		}

	} // end: if != 1col

	// Post Content wrapper
	echo '<div class="post__inner">';
	do_action( "valeo_after_thumbnail" );

	?>
	<div class="post-content">
		<?php
		if( valeo_is_blog_view_excerpt() && !is_single() ){
			echo valeo_excerpt_chat(get_the_content(), 300, true, false);
			echo apply_filters( 'excerpt_more', 'READ FULL CHAT' );
		} else {
			/* translators: %s: Name of current post */
			the_content( sprintf(
				esc_html__( 'READ FULL CHAT %s', 'valeo' ),
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

		if(is_single()) {

		}

		?>
	</div><!-- .post-content -->
	<?php echo '</div><!-- .post__inner -->'; ?>

	<?php // if 1col [closed tags]
	if ( ( $valeo_front_posts_layout == '1col' && is_home() ) || ( $valeo_front_posts_layout == '1colws' && is_home() ) || ( $valeo_front_posts_layout == '1colwsl' && is_home() ) ) { ?>
		<?php
		if ( empty( $media ) ) {
			if ( has_post_thumbnail() ) {
				echo '</div><!-- end: col-md-6 col-content -->';
				echo '</div><!-- end: row post-thumbnail-row -->';
			} else {
				// no thumbnail
				echo '</div><!-- end: col-content -->';
			}
		} else {
			echo '</div><!-- end: col-md-6 col-content -->';
			echo '</div><!-- end: row post-thumbnail-row -->';
		}
		?>
	<?php } // end: if 1col ?>
</div><!-- .entry-content -->
