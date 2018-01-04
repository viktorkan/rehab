<?php
/**
 * Recent_Comments custom widget class
 */

if ( ! function_exists( 'valeo_recent_comments_display_callback' ) ) :
function valeo_recent_comments_display_callback($instance, $widget, $args) {
	if ( 'recent-comments' == $widget->id_base ) {
		global $comments, $comment;

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $widget->id;

		$output = '';

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recent Comments', 'valeo' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $widget->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_avatar = isset( $instance['valeo_rc_show_avatar'] ) ? $instance['valeo_rc_show_avatar'] : false;

		/**
		 * Filter the arguments for the Recent Comments widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Comment_Query::query() for information on accepted arguments.
		 *
		 * @param array $comment_args An array of arguments used to retrieve the recent comments.
		 */
		$comments = get_comments( apply_filters( 'widget_comments_args', array(
			'number'      => $number,
			'status'      => 'approve',
			'post_status' => 'publish'
		) ) );

		$output .= $args['before_widget'];
		if ( $title ) {
			$output .= $args['before_title'] . $title . $args['after_title'];
		}

		$output .= '<ul id="recentcomments">';
		if ( $comments ) {
			// Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
			$post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
			_prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

			foreach ( (array) $comments as $comment) {
				$author_bio_avatar_size = apply_filters( 'valeo_author_bio_avatar_size', 60 );
				if( $show_avatar ) {
					$output .= '<li class="recentcomments with-avatar">';
				} else {
					$output .= '<li class="recentcomments">';
				}
				if( $show_avatar ) {
					$output .= '<div class="author-avatar">' . get_avatar( $comment->comment_author_email, $author_bio_avatar_size ) . '</div>';
				}
				/* translators: comments widget: 1: comment author, 2: post link */
				$output .= sprintf( _x( '<div class="comment-head">%1$s %2$s %3$s</div>', 'widgets', 'valeo' ),
					'<span class="comment-author-link">' . get_comment_author_link() . ', </span>',
					'<span class="comment-datetime">' . get_comment_date( 'F jS, Y', $comment->comment_ID ) . '</span><br>',
					'<a class="comment-title" href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">' . get_the_title( $comment->comment_post_ID ) . '</a>'
				);
				$output .= '</li>';
				$output .= '</li>';
			}
		}
		$output .= '</ul>';
		$output .= $args['after_widget'];

		echo wp_kses_post($output);

		if ( ! $widget->is_preview() ) {
			$cache[ $args['widget_id'] ] = $output;
			wp_cache_set( 'widget_recent_comments', $cache, 'widget' );
		}
		return false;
	}
	return $instance;
}
endif;
add_filter( 'widget_display_callback', 'valeo_recent_comments_display_callback', 10, 3 );

if ( ! function_exists( 'valeo_save_recent_comments_custom_options' ) ) :
function valeo_save_recent_comments_custom_options( $instance, $new_instance ) {
		$instance['valeo_rc_show_avatar'] = isset( $new_instance['valeo_rc_show_avatar'] ) ? (bool) $new_instance['valeo_rc_show_avatar'] : false;
	return $instance;
}
endif;
add_filter( 'widget_update_callback', 'valeo_save_recent_comments_custom_options', 10, 2 );

if ( ! function_exists( 'valeo_add_recent_comments_custom_options' ) ) :
function valeo_add_recent_comments_custom_options( $widget, $return, $instance ) {

	if ( 'recent-comments' == $widget->id_base ) {

		$show_avatar = isset( $instance['valeo_rc_show_avatar'] ) ? (bool) $instance['valeo_rc_show_avatar'] : false;
		?>
		<p><input class="checkbox" type="checkbox" <?php checked( $show_avatar ); ?> id="<?php echo esc_attr( $widget->get_field_id( 'valeo_rc_show_avatar' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'valeo_rc_show_avatar' ) ); ?>" />
			<label for="<?php echo esc_attr( $widget->get_field_id( 'valeo_rc_show_avatar' ) ); ?>"><?php esc_attr_e( 'Display avatars?', 'valeo' ); ?></label></p>

		<?php
	}
}
endif;
add_filter('in_widget_form', 'valeo_add_recent_comments_custom_options', 9, 3 );