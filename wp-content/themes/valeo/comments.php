<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php
if ( valeo_is_builder_post( get_the_ID() ) ) {
	echo '<div class="container is_unyson_page_builder unyson_content">';
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

		<div class="comment-list-wrap">
			<h2 class="comments-title">
				<?php printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'valeo' ),
					number_format_i18n( get_comments_number() ), get_the_title() ); ?>
			</h2>

			<?php
			// Older Comments / Newer Comments Arrows
			valeo_comment_nav();
			?>

			<ol class="comment-list">
				<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 90,
					'callback'    => 'valeo_comment_callback',
				) );
				?>
			</ol><!-- .comment-list -->

			<nav class="navigation comment-navigation">
				<?php paginate_comments_links( array(
					'prev_text' => esc_html__( 'PREV', 'valeo' ),
					'next_text' => esc_html__( 'NEXT', 'valeo' )
				) ); ?>
			</nav>
		</div>

	<?php endif; // have_comments() ?>

	<?php // If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'valeo' ); ?></p>
	<?php endif; ?>

    <div class="comment-form-wrap"><?php
        $commenter = wp_get_current_commenter();
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $required_text = "";

        $fields =  array(

            'author' =>
	            '<div class="row">' .
	            '<div class="col-sm-4">' .
	            '<div class="comment-form-author">' .
	            '<input id="author" name="author" type="text" placeholder="' . esc_html__( 'Full Name', 'valeo' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
	            '" size="30"' . $aria_req . ' />' .
	            '</div>' .
	            '</div>',

            'email' =>
	            '<div class="col-sm-4">' .
	            '<div class="comment-form-email">' .
	            '<input id="email" name="email" type="text" placeholder="' . esc_html__( 'Email Address', 'valeo' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) .
	            '" size="30"' . $aria_req . ' />' .
	            '</div>' .
	            '</div>',

            'url' =>
	            '<div class="col-sm-4">' .
	            '<div class="comment-form-url">' .
	            '<input id="url" name="url" type="text" placeholder="' . esc_html__( 'Website', 'valeo' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) .
	            '" size="30" />' .
	            '</div>' .
	            '</div>' .
	            '</div>',
        );

        $args = array(
            'id_form'           => 'commentform',
            'id_submit'         => 'submit',
            'class_submit'      => 'submit button comment-submit',
            'name_submit'       => 'submit',
            'submit_button'     => '<a name="%1$s" href="#" id="%2$s" class="%3$s">%4$s</a>',
            'title_reply'       => esc_html__( ' ', 'valeo' ),
            'title_reply_to'    => esc_html__( 'Leave a Reply to %s', 'valeo' ),
            'cancel_reply_link' => esc_html__( 'Cancel Reply', 'valeo' ),
            'label_submit'      => esc_html__( 'Send Comment', 'valeo' ),
            'format'            => 'xhtml',

            'comment_field' =>  '<p class="comment-form-comment">'.
                                '<textarea id="comment" name="comment" cols="45" rows="6" aria-required="true" placeholder="' .
                                esc_html__( 'Comment...', 'valeo' ) . '" >' .
                                '</textarea>' .
                                '</p>',

            'must_log_in' => '<p class="must-log-in">' .
                sprintf(
                    wp_kses( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'valeo' ), $allowed_html_array = array(
                        'a' => array( // on allow a tags
                            'href' => array() // and those anchors can only have href attribute
                        )
                    )),
                    wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
                ) . '</p>',

            'logged_in_as' => '<p class="logged-in-as">' .
                sprintf(
                    wp_kses( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'valeo' ), $allowed_html_array = array(
                    'a' => array( // on allow a tags
                        'href' => array() // and those anchors can only have href attribute
                    )
                )),
                    admin_url( 'profile.php' ),
                    $user_identity,
                    wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
                ) . '</p>',

            'comment_notes_before' => '',

            'comment_notes_after' => '',

            'fields' => apply_filters( 'comment_form_default_fields', $fields ),
        );

        comment_form($args);
    ?></div><!-- .comment-form-wrap -->

</div><!-- .comments-area -->
<?php
if ( valeo_is_builder_post( get_the_ID() ) ) {
	echo '</div><!-- container.is_unyson_page_builder -->';
}
?>
