<?php
/**
 * Template tags related to team members for theme authors to use in their theme templates.
 *
 * @package    CustomContentTeam
 * @subpackage Includes
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2015, Justin Tadlock
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Makes sure the post ID is an absolute integer if passed in.  Else, returns the result
 * of `get_the_ID()`.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @return int
 */
function cct_get_member_id( $post_id = '' ) {

	return $post_id ? absint( $post_id ) : get_the_ID();
}

/**
 * Checks if viewing a single member.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $post
 * @return bool
 */
function cct_is_single_member( $post = '' ) {

	$is_single = is_singular( cct_get_member_post_type() );

	if ( $is_single && $post )
		$is_single = is_single( $post );

	return apply_filters( 'cct_is_single_member', $is_single, $post );
}

/**
 * Checks if viewing the member archive.
 *
 * @since  1.0.0
 * @access public
 * @return bool
 */
function cct_is_member_archive() {

	return apply_filters( 'cct_is_member_archive', is_post_type_archive( cct_get_member_post_type() ) && ! cct_is_author() );
}

/**
 * Checks if the current post is a member.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @return bool
 */
function cct_is_member( $post_id = '' ) {

	$post_id = cct_get_member_id( $post_id );

	return apply_filters( 'cct_is_member', cct_get_member_post_type() === get_post_type( $post_id ), $post_id );
}

/**
 * Conditional check to see if a member has the "sticky" type.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $member_id
 * @return bool
 */
function cct_is_member_sticky( $member_id = 0 ) {
	$member_id = cct_get_member_id( $member_id );

	return apply_filters( 'cct_is_member_sticky', in_array( $member_id, cct_get_sticky_members() ), $member_id );
}

/**
 * Displays the member position.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_position( $args = array() ) {
	echo cct_get_member_position( $args );
}

/**
 * Returns the member post.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_position( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$position = cct_get_member_meta( $args['post_id'], 'position' );

	if ( $position ) {

		$text = sprintf( $args['text'], sprintf( '<span class="member-data">%s</span>', $position ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="member-position"', $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member_position', $html, $args['post_id'] );
}
/**
 * Displays the member address.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_address( $args = array() ) {
	echo cct_get_member_address( $args );
}

/**
 * Returns the member address.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_address( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$address = cct_get_member_meta( $args['post_id'], 'address' );

	if ( $address ) {

		$text = sprintf( $args['text'], sprintf( '<span class="member-data">%s</span>', $address ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="member-address"', $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member_address', $html, $args['post_id'] );
}

/**
 * Prints the member phone.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_phone( $args = array() ) {
	echo cct_get_member_phone( $args );
}

/**
 * Returns the member phone.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_phone( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$phone = cct_get_member_meta( $args['post_id'], 'phone' );

	if ( $phone ) {

		$text = sprintf( $args['text'], sprintf( '<span class="member-data">%s</span>', $phone ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="member-phone"', $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member_phone', $html, $args['post_id'] );
}

/**
 * Prints the member email.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_email( $args = array() ) {
	echo cct_get_member_email( $args );
}

/**
 * Returns the member email.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_email( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span class="member-email">%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$email = cct_get_member_meta( $args['post_id'], 'email' );

	if ( $email ) {

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], $email );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member_email', $html, $args['post_id'] );
}

//Skills members

/**
 * Prints the member skill 1.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_skill_1 ( $args = array() ) {
	echo cct_get_member_member_skill_1( $args );
}

/**
 * Returns the member skill 1.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_member_skill_1( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'format'  => '',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$skill_1 = cct_get_member_meta( $args['post_id'], 'skill_1' );

	if ( $skill_1 ) {

		$text = sprintf( '<div class="member-data">%s</div>', $skill_1 );

		$text = sprintf( $args['text'], str_replace( '{cct_break}', '<br>', $text ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="member-skill"', $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member__skill_1', $html, $args['post_id'] );
}
/**
 * Prints the member skill name 1.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_skill_name_1 ( $args = array() ) {
	echo cct_get_member_member_skill_name_1( $args );
}

/**
 * Returns the member skill name 1.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_member_skill_name_1( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'format'  => '',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$skill_name_1 = cct_get_member_meta( $args['post_id'], 'skill_name_1' );

	if ( $skill_name_1 ) {

		$text = sprintf( '<div class="member-data">%s</div>', $skill_name_1 );

		$text = sprintf( $args['text'], str_replace( '{cct_break}', '<br>', $text ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="member-skill-name"', $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member__skill_name_1', $html, $args['post_id'] );
}


/**
 * Prints the member skill 2.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_skill_2 ( $args = array() ) {
	echo cct_get_member_member_skill_2( $args );
}

/**
 * Returns the member skill 2.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_member_skill_2( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'format'  => '',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$skill_2 = cct_get_member_meta( $args['post_id'], 'skill_2' );

	if ( $skill_2 ) {

		$text = sprintf( '<div class="member-data">%s</div>', $skill_2 );

		$text = sprintf( $args['text'], str_replace( '{cct_break}', '<br>', $text ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="member-skill"', $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member__skill_2', $html, $args['post_id'] );
}
/**
 * Prints the member skill name 2.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_skill_name_2 ( $args = array() ) {
	echo cct_get_member_member_skill_name_2( $args );
}

/**
 * Returns the member skill name 2.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_member_skill_name_2( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'format'  => '',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$skill_name_2 = cct_get_member_meta( $args['post_id'], 'skill_name_2' );

	if ( $skill_name_2 ) {

		$text = sprintf( '<div class="member-data">%s</div>', $skill_name_2 );

		$text = sprintf( $args['text'], str_replace( '{cct_break}', '<br>', $text ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="member-skill-name"', $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member__skill_name_2', $html, $args['post_id'] );
}

/**
 * Prints the member skill 3.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_skill_3 ( $args = array() ) {
	echo cct_get_member_member_skill_3( $args );
}

/**
 * Returns the member skill 3.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_member_skill_3( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'format'  => '',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$skill_3 = cct_get_member_meta( $args['post_id'], 'skill_3' );

	if ( $skill_3 ) {

		$text = sprintf( '<div class="member-data">%s</div>', $skill_2 );

		$text = sprintf( $args['text'], str_replace( '{cct_break}', '<br>', $text ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="member-skill"', $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member__skill_3', $html, $args['post_id'] );
}
/**
 * Prints the member skill name 3.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_skill_name_3 ( $args = array() ) {
	echo cct_get_member_member_skill_name_3( $args );
}

/**
 * Returns the member skill name 3.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_member_skill_name_3( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'format'  => '',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$skill_name_3 = cct_get_member_meta( $args['post_id'], 'skill_name_3' );

	if ( $skill_name_3 ) {

		$text = sprintf( '<div class="member-data">%s</div>', $skill_name_3 );

		$text = sprintf( $args['text'], str_replace( '{cct_break}', '<br>', $text ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="member-skill-name"', $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member__skill_name_3', $html, $args['post_id'] );
}


/**
 * Prints the member skill 4.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_skill_4 ( $args = array() ) {
	echo cct_get_member_member_skill_4( $args );
}

/**
 * Returns the member skill 4.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_member_skill_4( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'format'  => '',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$skill_4 = cct_get_member_meta( $args['post_id'], 'skill_4' );

	if ( $skill_3 ) {

		$text = sprintf( '<div class="member-data">%s</div>', $skill_4 );

		$text = sprintf( $args['text'], str_replace( '{cct_break}', '<br>', $text ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="member-skill"', $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member__skill_4', $html, $args['post_id'] );
}
/**
 * Prints the member skill name 4.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_skill_name_4 ( $args = array() ) {
	echo cct_get_member_member_skill_name_4( $args );
}

/**
 * Returns the member skill name 3.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_member_skill_name_4( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'format'  => '',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$skill_name_4 = cct_get_member_meta( $args['post_id'], 'skill_name_4' );

	if ( $skill_name_4 ) {

		$text = sprintf( '<div class="member-data">%s</div>', $skill_name_4 );

		$text = sprintf( $args['text'], str_replace( '{cct_break}', '<br>', $text ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="member-skill-name"', $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member__skill_name_4', $html, $args['post_id'] );
}


/**
 * Displays the member Social Quote.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_social_quote( $args = array() ) {
	echo cct_get_member_social_quote( $args );
}

/**
 * Returns the member Social Quote.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_social_quote( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$social_quote = cct_get_member_meta( $args['post_id'], 'social-quote' );

	if ( $social_quote ) {

		$text = sprintf( $args['text'], $social_quote );
		$attr = sprintf( 'class="member-social-quote" href="%s"', esc_html( $social_quote ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], $attr, $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member_social_quote', $html, $args['post_id'] );
}


/**
 * Displays the member facebook link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_facebook( $args = array() ) {
	echo cct_get_member_facebook( $args );
}

/**
 * Returns the member facebook link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_facebook( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<a %s>%s</a>',
	);

	$args = wp_parse_args( $args, $defaults );

	$facebook = cct_get_member_meta( $args['post_id'], 'facebook' );

	if ( $facebook ) {

		$text = sprintf( $args['text'], $facebook );
		$attr = sprintf( 'class="member-facebook" href="%s"', esc_url( $facebook ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], $attr, $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member_facebook', $html, $args['post_id'] );
}

/**
 * Displays the member twitter link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_twitter( $args = array() ) {
	echo cct_get_member_twitter( $args );
}

/**
 * Returns the member twitter link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_twitter( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<a %s>%s</a>',
	);

	$args = wp_parse_args( $args, $defaults );

	$twitter = cct_get_member_meta( $args['post_id'], 'twitter' );

	if ( $twitter ) {

		$text = sprintf( $args['text'], $twitter );
		$attr = sprintf( 'class="member-twitter" href="%s"', esc_url( $twitter ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], $attr, $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member_twitter', $html, $args['post_id'] );
}

/**
 * Displays the member googleplus link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_googleplus( $args = array() ) {
	echo cct_get_member_googleplus( $args );
}

/**
 * Returns the member googleplus link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_googleplus( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<a %s>%s</a>',
	);

	$args = wp_parse_args( $args, $defaults );

	$googleplus = cct_get_member_meta( $args['post_id'], 'googleplus' );

	if ( $googleplus ) {

		$text = sprintf( $args['text'], $googleplus );
		$attr = sprintf( 'class="member-googleplus" href="%s"', esc_url( $googleplus ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], $attr, $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member_googleplus', $html, $args['post_id'] );
}

/**
 * Displays the member linkedin link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_linkedin( $args = array() ) {
	echo cct_get_member_linkedin( $args );
}

/**
 * Returns the member linkedin link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_linkedin( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<a %s>%s</a>',
	);

	$args = wp_parse_args( $args, $defaults );

	$linkedin = cct_get_member_meta( $args['post_id'], 'linkedin' );

	if ( $linkedin ) {

		$text = sprintf( $args['text'], $linkedin );
		$attr = sprintf( 'class="member-linkedin" href="%s"', esc_url( $linkedin ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], $attr, $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member_linkedin', $html, $args['post_id'] );
}

/**
 * Displays the member pinterest link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_pinterest( $args = array() ) {
	echo cct_get_member_pinterest( $args );
}

/**
 * Returns the member pinterest link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_pinterest( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<a %s>%s</a>',
	);

	$args = wp_parse_args( $args, $defaults );

	$pinterest = cct_get_member_meta( $args['post_id'], 'pinterest' );

	if ( $pinterest ) {

		$text = sprintf( $args['text'], $pinterest );
		$attr = sprintf( 'class="member-pinterest" href="%s"', esc_url( $pinterest ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], $attr, $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member_pinterest', $html, $args['post_id'] );
}

/**
 * Displays the member instagram link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_instagram( $args = array() ) {
	echo cct_get_member_instagram( $args );
}

/**
 * Returns the member instagram link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_instagram( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<a %s>%s</a>',
	);

	$args = wp_parse_args( $args, $defaults );

	$instagram = cct_get_member_meta( $args['post_id'], 'instagram' );

	if ( $instagram ) {

		$text = sprintf( $args['text'], $instagram );
		$attr = sprintf( 'class="member-instagram" href="%s"', esc_url( $instagram ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], $attr, $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member_instagram', $html, $args['post_id'] );
}

/**
 * Displays the member slide title.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_slide_title( $args = array() ) {
	echo cct_get_member_slide_title( $args );
}

/**
 * Returns the member slide title.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_slide_title( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<a %s>%s</a>',
	);

	$args = wp_parse_args( $args, $defaults );

	$slide_title = cct_get_member_meta( $args['post_id'], 'slide_title' );

	if ( $slide_title ) {

		$text = sprintf( $args['text'], $slide_title );
		$attr = sprintf( 'class="member-slide-title" href="%s"', esc_url( $slide_title ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], $attr, $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member_slide_title', $html, $args['post_id'] );
}

/**
 * Displays the member short description.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_short_desc( $args = array() ) {
	echo cct_get_member_short_desc( $args );
}

/**
 * Returns the member short description.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_short_desc( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$short_desc = cct_get_member_meta( $args['post_id'], 'short_desc' );

	if ( $short_desc ) {

		$text = sprintf( $args['text'], $short_desc );
		$attr = sprintf( 'class="member-short-desc" href="%s"', esc_attr( $short_desc ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], $attr, $text );
		$html .= $args['after'];
	}

	return apply_filters( 'cct_get_member_short_desc', $html, $args['post_id'] );
}

/**
 * Displays the member contact form.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function cct_member_contact_form( $args = array() ) {
	echo cct_get_member_contact_form( $args );
}

/**
 * Returns the member contact form.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function cct_get_member_contact_form( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => cct_get_member_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	//$contact_form = cct_get_member_meta( $args['post_id'], 'contact_form' );

	//if ( $contact_form ) {

		$html .= $args['before'];

		$html .= '<div>';
			$html .= '<div id="cct_contact_error"></div>';
			$html .= '<form id="cctContactForm" method="post">
				<ul>';
			$html .= '<li>
						<label for="cctContactName">Name:</label>';
			$html .= '<input type="text" name="cctContactName" id="cctContactName" value="'.(isset($_POST['cctContactName'])? $_POST['cctContactName']:"").'" />';
			$html .= '</li>';
			$html .= '<li>
						<label for="cctEmail">Email</label>';
			$html .= '<input type="text" name="cctEmail" id="cctEmail" value="'.(isset($_POST['cctEmail']) ? $_POST['cctEmail']:"").'" />';
			$html .= '</li>
					<li><label for="cctCommentsText">Message:</label>';
			$html .= '<textarea name="cctCommentsText" id="cctCommentsText" rows="10" cols="30">'.(isset($_POST['cctComments']) ? stripslashes($_POST['cctComments']) : '').'</textarea>';
			$html .= '</li>
					<li>
						<input type="submit" value="Send email">
					</li>
				</ul>
				<input type="hidden" name="submitted" id="submitted" value="true" />
				<input type="hidden" name="action" value="contact_send" />
				<input type="hidden" name="post_id" value="'.$args['post_id'].'" />
			</form>';
		$html .= $args['after'];
	//}
	return apply_filters( 'cct_get_member_contact_form', $html, $args['post_id'] );
}

function cct_ajax_send_contact_form () {
	try {
		$get_cctContactName = trim( $_POST['cctContactName'] );
		if ( empty( $get_cctContactName ) ) {
			throw new Exception('Please enter your name.');
		}

		if ( !is_email($_POST['cctEmail']) ) {
			throw new Exception('Email address not formatted correctly.');
		}

		$get_cctCommentsText = trim( $_POST['cctCommentsText'] );
		if ( empty( $get_cctCommentsText ) ) {
			throw new Exception('Please enter a message.');
		}

		$send_to = cct_get_member_meta( $_POST['post_id'], 'email' );
		if ( ! isset( $send_to ) || ( $send_to == '' ) ) {
			$send_to = get_option( 'admin_email' );
			$message = "Message About: ".get_permalink($_POST['post_id'])."\n\nMessage from ".$_POST['cctContactName'].": \n\n ". $_POST['cctCommentsText'] . " \n\n Reply to: " . $_POST['cctEmail'];
		} else {
			$message = "Message from ".$_POST['cctContactName'].": \n\n ". $_POST['cctCommentsText'] . " \n\n Reply to: " . $_POST['cctEmail'];
		}

		$subject = 'Contact Form: '.$_POST['cctContactName'];
		$headers = 'From: '.$_POST['cctContactName'].' <'.$_POST['cctEmail'].'>'."\n".'Reply-To: '.$_POST['cctEmail']."\n";

		if (wp_mail($send_to, $subject, $message, $headers)) {
			echo json_encode(array('status' => 'success', 'message' => 'Contact message sent.'));
			exit;
		} else {
			throw new Exception('Failed to send email.');
		}
	} catch (Exception $e) {
		echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
		exit;
	}
}
add_action("wp_ajax_contact_send", "cct_ajax_send_contact_form");
add_action("wp_ajax_nopriv_contact_send", "cct_ajax_send_contact_form");