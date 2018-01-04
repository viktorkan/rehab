<?php
/**
 * Various functions, filters, and actions used by the plugin.
 *
 * @package    CustomContentTeam
 * @subpackage Includes
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2015, Justin Tadlock
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Check theme support.
add_action( 'wp_loaded', 'cct_check_theme_support', 0 );

# Template hierarchy.
add_filter( 'template_include', 'cct_template_include', 5 );

# Add sticky posts to the front of the line.
add_filter( 'the_posts', 'cct_posts_sticky_filter', 10, 2 );

# Filter the document title.
add_filter( 'document_title_parts', 'cct_document_title_parts', 5 );

# Filter the post type archive title.
add_filter( 'post_type_archive_title', 'cct_post_type_archive_title', 5, 2 );

# Filter the archive title and description.
add_filter( 'get_the_archive_title',       'cct_get_the_archive_title',       5 );
add_filter( 'get_the_archive_description', 'cct_get_the_archive_description', 5 );

# Filter the post type permalink.
add_filter( 'post_type_link', 'cct_post_type_link', 10, 2 );

# Filter the post author link.
add_filter( 'author_link', 'cct_author_link_filter', 10, 3 );

# Force taxonomy term selection.
add_action( 'save_post', 'cct_force_term_selection' );

# Filter the Breadcrumb Trail plugin args.
add_filter( 'breadcrumb_trail_args', 'cct_breadcrumb_trail_args', 15 );

#add Thumbnail image size
add_action( 'after_setup_theme', 'cct_image_size_setup', 20 );

/**
 * Checks if the theme supports `custom-content-team`.  If not, it runs specific filters
 * to make themes without support work a little better.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cct_check_theme_support() {

	if ( ! current_theme_supports( 'custom-content-team' ) )
		add_filter( 'the_content', 'cct_the_content_filter', 25 );
}

/**
 * Basic top-level template hierarchy. I generally prefer to leave this functionality up to
 * themes.  This is just a foundation to build upon if needed.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $template
 * @return string
 */
function cct_template_include( $template ) {

	// Bail if not a team page.
	if ( ! cct_is_team() )
		return $template;

	$templates = array();

	// Author archive.
	if ( cct_is_author() ) {
		$templates[] = 'team-author.php';
		$templates[] = 'team-archive.php';

	// Category archive.
	} else if ( cct_is_category() ) {
		$templates[] = 'team-category.php';
		$templates[] = 'team-archive.php';

	// Tag archive.
	} else if ( cct_is_tag() ) {
		$templates[] = 'team-tag.php';
		$templates[] = 'team-archive.php';

	// Member archive.
	} else if ( cct_is_member_archive() ) {
		$templates[] = 'team-archive.php';

	// Single member.
	} else if ( cct_is_single_member() ) {
		$templates[] = 'team-member.php';
	}

	// Fallback template.
	$templates[] = 'team.php';

	// Check if we have a template.
	$has_template = locate_template( apply_filters( 'cct_template_hierarchy', $templates ) );

	// Return the template.
	return $has_template ? $has_template : $template;
}

/**
 * Filter on `the_content` for themes that don't support the plugin.  This filter outputs the basic
 * member metadata only.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $content
 * @return string
 */
function cct_the_content_filter( $content ) {

	if ( in_the_loop() && cct_is_single_member() && cct_is_member() && ! post_password_required() ) {

		$categories = get_categories( array( 'type' => 'team_member', 'orderby' => 'name', 'taxonomy' => 'team_category' ) );
		$tags = get_categories( array( 'type' => 'team_member', 'orderby' => 'name', 'taxonomy' => 'team_tag' ) );

		$before = '';
		$after = '';
		$position = cct_get_member_meta( get_the_ID(), 'position' );
		$position_formatted = cct_get_member_position( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$address = cct_get_member_meta( get_the_ID(), 'address' );
		$address_formatted = cct_get_member_address( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$phone = cct_get_member_meta( get_the_ID(), 'phone' );
		$phone_formatted = cct_get_member_phone( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$email = cct_get_member_meta( get_the_ID(), 'email' );
		$email_formatted = cct_get_member_phone( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );


		$skill_1 = cct_get_member_meta( get_the_ID(), 'skill_1' );
		$skill_1_formatted = cct_get_member_skill_1( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$skill_2 = cct_get_member_meta( get_the_ID(), 'skill_2' );
		$skill_2_formatted = cct_get_member_skill_2( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$skill_3 = cct_get_member_meta( get_the_ID(), 'skill_3' );
		$skill_3_formatted = cct_get_member_skill_3( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$skill_4 = cct_get_member_meta( get_the_ID(), 'skill_4' );
		$skill_4_formatted = cct_get_member_skill_4( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );

		$skill_name_1 = cct_get_member_meta( get_the_ID(), 'skill_1' );
		$skill_name_1_formatted = cct_get_member_skill_1( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$skill_name_2 = cct_get_member_meta( get_the_ID(), 'skill_2' );
		$skill_name_2_formatted = cct_get_member_skill_2( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$skill_name_3 = cct_get_member_meta( get_the_ID(), 'skill_3' );
		$skill_name_3_formatted = cct_get_member_skill_3( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$skill_name_4 = cct_get_member_meta( get_the_ID(), 'skill_4' );
		$skill_name_4_formatted = cct_get_member_skill_4( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );

		$social_quote = cct_get_member_meta( get_the_ID(), 'social_quote' );
		$social_quote_formatted = cct_get_member_social_quote( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$facebook = cct_get_member_meta( get_the_ID(), 'facebook' );
		$facebook_formatted = cct_get_member_facebook( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$twitter = cct_get_member_meta( get_the_ID(), 'twitter' );
		$twitter_formatted = cct_get_member_twitter( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$googleplus = cct_get_member_meta( get_the_ID(), 'googleplus' );
		$googleplus_formatted = cct_get_member_googleplus( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$linkedin = cct_get_member_meta( get_the_ID(), 'linkedin' );
		$linkedin_formatted = cct_get_member_linkedin( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$pinterest = cct_get_member_meta( get_the_ID(), 'pinterest' );
		$pinterest_formatted = cct_get_member_pinterest( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
		$instagram = cct_get_member_meta( get_the_ID(), 'instagram' );
		$instagram_formatted = cct_get_member_instagram( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );

		//$additional_info = cct_get_member_meta( get_the_ID(), 'additional_info' );
		//$additional_info_formated = cct_get_member_additional_info( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );

		$output = '';

		if( !empty($position) ) {
			$output .= '<div class="team-post-member">';
			$output .= esc_html__( 'Post: ', 'custom-content-team' ).esc_html__($position);
			$output .= '</div>';
		}

		if( !empty($address) ) {
			$output .= '<div class="team-address">';
			$output .= esc_html__( 'Address: ', 'custom-content-team' ).esc_html__($address);
			$output .= '</div>';
		}

		if( !empty($phone) ) {
			$output .= '<div class="team-phone">';
			$output .= esc_html__( 'Phone: ', 'custom-content-team' ).esc_html__($phone);
			$output .= '</div>';
		}

		if( !empty($email) ) {
			$output .= '<div class="team-email">';
			$output .= esc_html__( 'Email: ', 'custom-content-team' ).esc_html__($email);
			$output .= '</div>';
		}


		if( !empty($social_quote) ) {
			$output .= '<div class="team-social_quote">';
			$output .= esc_html__( 'Social Quote: ', 'custom-content-team' ). $social_quote_formatted;
			$output .= '</div>';
		}

		if( !empty($facebook) ) {
			$output .= '<div class="team-facebook">';
			$output .= esc_html__( 'Facebook: ', 'custom-content-team' ).$facebook_formatted;
			$output .= '</div>';
		}

		if( !empty($twitter) ) {
			$output .= '<div class="team-twitter">';
			$output .= esc_html__( 'Twitter: ', 'custom-content-team' ).$twitter_formatted;
			$output .= '</div>';
		}

		if( !empty($googleplus) ) {
			$output .= '<div class="team-googleplus">';
			$output .= esc_html__( 'Google+: ', 'custom-content-team' ).$googleplus_formatted;
			$output .= '</div>';
		}

		if( !empty($linkedin) ) {
			$output .= '<div class="team-linkedin">';
			$output .= esc_html__( 'LinkedIn: ', 'custom-content-team' ).$linkedin_formatted;
			$output .= '</div>';
		}

		if( !empty($pinterest) ) {
			$output .= '<div class="team-pinterest">';
			$output .= esc_html__( 'Pinterest: ', 'custom-content-team' ).$pinterest_formatted;
			$output .= '</div>';
		}

		if( !empty($instagram) ) {
			$output .= '<div class="team-instagram">';
			$output .= esc_html__( 'Instagram: ', 'custom-content-team' ).$instagram_formatted;
			$output .= '</div>';
		}



		if( !empty($categories) ) {
			$output .= '<div class="team-categories"><ul>';

			$output .= '<li>'.esc_html__( 'Categories: ', 'custom-content-team' ).'</li>';

			foreach ($categories as $category) {
				$output .= '<li><a href="'.get_term_link($category).'">'.$category->name.'</a></li>';
			}

			$output .= '</ul></div>';
		}

		if( !empty($tags) ) {
			$output .= '<div class="team-categories"><ul>';

			$output .= '<li>'.esc_html__( 'Tags: ', 'custom-content-team' ).'</li>';

			foreach ($tags as $tag) {
				$output .= '<li><a href="'.get_term_link($tag).'">'.$tag->name.'</a></li>';
			}

			$output .= '</ul></div>';
		}

		$output .= cct_get_member_contact_form();

		if ( $output )
			$content .= sprintf( '<span class="member-meta">%s</span>', $output );
	}

	return $content;
}

/**
 * Filter on `the_posts` for the member archive. Moves sticky posts to the top of
 * the member archive list.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $posts
 * @param  object $query
 * @return array
 */
function cct_posts_sticky_filter( $posts, $query ) {

	// Allow devs to filter when to show sticky members.
	$show_stickies = apply_filters( 'cct_show_stickies', $query->is_main_query() && ! is_admin() && cct_is_member_archive() && ! is_paged() );

	// If we should show stickies, let's get them.
	if ( $show_stickies ) {

		remove_filter( 'the_posts', 'cct_posts_sticky_filter' );

		$posts = cct_add_stickies( $posts, cct_get_sticky_members() );
	}

	return $posts;
}

/**
 * Adds sticky posts to the front of the line with any given set of posts and stickies.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $posts         Array of post objects.
 * @param  array  $sticky_posts  Array of post IDs.
 * @return array
 */
function cct_add_stickies( $posts, $sticky_posts ) {

	// Only do this if on the first page and we indeed have stickies.
	if ( ! empty( $sticky_posts ) ) {

		$num_posts     = count( $posts );
		$sticky_offset = 0;

		// Loop over posts and relocate stickies to the front.
		for ( $i = 0; $i < $num_posts; $i++ ) {

			if ( in_array( $posts[ $i ]->ID, $sticky_posts ) ) {

				$sticky_post = $posts[ $i ];

				// Remove sticky from current position.
				array_splice( $posts, $i, 1);

				// Move to front, after other stickies.
				array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );

				// Increment the sticky offset. The next sticky will be placed at this offset.
				$sticky_offset++;

				// Remove post from sticky posts array.
				$offset = array_search( $sticky_post->ID, $sticky_posts );

				unset( $sticky_posts[ $offset ] );
			}
		}

		// Fetch sticky posts that weren't in the query results.
		if ( ! empty( $sticky_posts ) ) {

			$args = array(
					'post__in'    => $sticky_posts,
					'post_type'   => cct_get_member_post_type(),
					'post_status' => 'publish',
					'nopaging'    => true
			);

			$stickies = get_posts( $args );

			foreach ( $stickies as $sticky_post ) {
				array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );
				$sticky_offset++;
			}
		}
	}

	return $posts;
}

/**
 * Filter on `document_title_parts` (WP 4.4.0).
 *
 * @since  1.0.0
 * @access public
 * @param  array  $title
 * @return array
 */
function cct_document_title_parts( $title ) {

	if ( cct_is_author() )
		$title['title'] = cct_get_single_author_title();

	return $title;
}

/**
 * Filter on 'post_type_archive_title' to allow for the use of the 'archive_title' label that isn't supported
 * by WordPress.  That's okay since we can roll our own labels.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $title
 * @param  string  $post_type
 * @return string
 */
function cct_post_type_archive_title( $title, $post_type ) {

	$member_type = cct_get_member_post_type();

	return $member_type === $post_type ? get_post_type_object( cct_get_member_post_type() )->labels->archive_title : $title;
}

/**
 * Filters the archive title. Note that we need this additional filter because core WP does
 * things like add "Archives:" in front of the archive title.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $title
 * @return string
 */
function cct_get_the_archive_title( $title ) {

	if ( cct_is_author() )
		$title = cct_get_single_author_title();

	else if ( cct_is_member_archive() )
		$title = post_type_archive_title( '', false );

	return $title;
}

/**
 * Filters the archive description.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $desc
 * @return string
 */
function cct_get_the_archive_description( $desc ) {

	if ( cct_is_author() )
		$desc = get_the_author_meta( 'description', get_query_var( 'author' ) );

	else if ( cct_is_member_archive() && ! $desc )
		$desc = cct_get_team_description();

	return $desc;
}

/**
 * Filter on `post_type_link` to make sure that single team members have the correct
 * permalink.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $post_link
 * @param  object  $post
 * @return string
 */
function cct_post_type_link( $post_link, $post ) {

	// Bail if this isn't a team member.
	if ( cct_get_member_post_type() !== $post->post_type )
		return $post_link;

	$cat_taxonomy = cct_get_category_taxonomy();
	$tag_taxonomy = cct_get_tag_taxonomy();

	$author = $category = $tag = '';

	// Check for the category.
	if ( false !== strpos( $post_link, "%{$cat_taxonomy}%" ) ) {

		// Get the terms.
		$terms = get_the_terms( $post, $cat_taxonomy );

		// Check that terms were returned.
		if ( $terms ) {

			usort( $terms, '_usort_terms_by_ID' );

			$category = $terms[0]->slug;
		}
	}

	// Check for the tag.
	if ( false !== strpos( $post_link, "%{$tag_taxonomy}%" ) ) {

		// Get the terms.
		$terms = get_the_terms( $post, $tag_taxonomy );

		// Check that terms were returned.
		if ( $terms ) {

			usort( $terms, '_usort_terms_by_ID' );

			$tag = $terms[0]->slug;
		}
	}

	// Check for the author.
	if ( false !== strpos( $post_link, '%author%' ) ) {

		$authordata = get_userdata( $post->post_author );
		$author     = $authordata->user_nicename;
	}

	$rewrite_tags = array(
		'%team_category%',
		'%team_tag%',
		'%author%'
	);

	$map_tags = array(
		$category,
		$tag,
		$author
	);

	return str_replace( $rewrite_tags, $map_tags, $post_link );
}

/**
 * Filter on `author_link` to change the URL when viewing a team member. The new link
 * should point to the team author archive.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $url
 * @param  int     $author_id
 * @param  string  $nicename
 * @return string
 */
function cct_author_link_filter( $url, $author_id, $nicename ) {

	return cct_is_member() ? cct_get_author_url( $author_id ) : $url;
}

/**
 * If a member has `%team_category%` or `%team_tag%` in its permalink structure,
 * it must have a term set for the taxonomy.  This function is a callback on `save_post`
 * that checks if a term is set.  If not, it forces the first term of the taxonomy to be
 * the selected term.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $post_id
 * @return void
 */
function cct_force_term_selection( $post_id ) {

	if ( cct_is_member( $post_id ) ) {

		$member_base = cct_get_member_rewrite_base();
		$cat_tax      = cct_get_category_taxonomy();
		$tag_tax      = cct_get_tag_taxonomy();

		if ( false !== strpos( $member_base, "%{$cat_tax}%" ) )
			cct_set_term_if_none( $post_id, $cat_tax, cct_get_default_category() );

		if ( false !== strpos( $member_base, "%{$tag_tax}%" ) )
			cct_set_term_if_none( $post_id, $tag_tax, cct_get_default_tag() );
	}
}

/**
 * Checks if a post has a term of the given taxonomy.  If not, set it with the first
 * term available from the taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @param  string  $taxonomy
 * @param  int     $default
 * @return void
 */
function cct_set_term_if_none( $post_id, $taxonomy, $default = 0 ) {

	// Get the current post terms.
	$terms = wp_get_post_terms( $post_id, $taxonomy );

	// If no terms are set, let's roll.
	if ( ! $terms ) {

		$new_term = false;

		// Get the default term if set.
		if ( $default )
			$new_term = get_term( $default, $taxonomy );

		// If no default term or if there's an error, get the first term.
		if ( ! $new_term || is_wp_error( $new_term ) ) {
			$available = get_terms( $taxonomy, array( 'number' => 1 ) );

			// Get the first term.
			$new_term = $available ? array_shift( $available ) : false;
		}

		// Only run if there are taxonomy terms.
		if ( $new_term ) {
			$tax_object = get_taxonomy( $taxonomy );

			// Use the ID for hierarchical taxonomies. Use the slug for non-hierarchical.
			$slug_or_id = $tax_object->hierarchical ? $new_term->term_id : $new_term->slug;

			// Set the new post term.
			wp_set_post_terms( $post_id, $slug_or_id, $taxonomy, true );
		}
	}
}

/**
 * Filters the Breadcrumb Trail plugin arguments.  We're basically just telling it to show the
 * `team_category` taxonomy when viewing single team members.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return array
 */
function cct_breadcrumb_trail_args( $args ) {

	$member_type = cct_get_member_post_type();
	$member_base = cct_get_member_rewrite_base();

	if ( false === strpos( $member_base, '%' ) && ! isset( $args['post_taxonomy'][ $member_type ] ) )
		$args['post_taxonomy'][ $member_type ] = cct_get_category_taxonomy();

	return $args;
}

if ( ! function_exists( 'cct_image_size_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function cct_image_size_setup() {
		if(!has_image_size('cct-team-thumbnail')){
			add_image_size( 'cct-team-thumbnail', 1140, 640, true );
		}
	}
endif;