<?php
/**
 * Custom template tags for Valeo
 *
 * Eventually, some of the functionality here could be replaced by core features.
 */

if ( ! function_exists( 'valeo_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 */
function valeo_comment_nav() {
	global $wp_query, $post;

	if ( !is_singular() )
		return;

	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 ) :
	?>
	<nav class="navigation comment-navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'valeo' ); ?></h2>
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'valeo' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments', 'valeo' ) ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .comment-navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'valeo_after_content_meta' ) ) :
	/**
	 * Prints post information after content.
	 */
	function valeo_after_content_meta() {

		echo '<div class="after-content">';

		// Edit Post Link
		valeo_edit_post_link();

		// Post Categories
		valeo_post_categories();

		// Post Tags
		valeo_post_tags();

		echo '</div>';

	}
endif;

if ( ! function_exists( 'valeo_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 */
function valeo_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured', 'valeo' ) );
	}

	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date( 'M j, Y - G:i' ),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date( 'M j, Y - G:i' )
		);

		printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			_x( 'Posted on', 'Used before publish date.', 'valeo' ),
            esc_url( get_day_link(get_the_date('Y'), get_the_date('m'), get_the_date('d')) ),
			$time_string
		);
	}

	if ( 'post' == get_post_type() ) {
		if ( is_singular() || is_multi_author() ) {
			printf( '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span>by <a class="url fn n" href="%2$s">%3$s</a></span></span>',
				_x( 'Author', 'Used before post author name.', 'valeo' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_the_author()
			);
		}

		$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'valeo' ) );
		if ( $categories_list && valeo_categorized_blog() ) {
			printf( '<span class="cat-links">in <span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Categories', 'Used before category names.', 'valeo' ),
				$categories_list
			);
		}

        if ( is_attachment() && wp_attachment_is_image() ) {
            // Retrieve attachment metadata.
            $metadata = wp_get_attachment_metadata();

            printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
                _x( 'Full size', 'Used before full size attachment link.', 'valeo' ),
                esc_url( wp_get_attachment_url() ),
                $metadata['width'],
                $metadata['height']
            );
        }

        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<span class="comments-link">| ';
            comments_popup_link( esc_html__( 'Leave a comment', 'valeo' ), esc_html__( '1 Comment', 'valeo' ), esc_html__( '% Comments', 'valeo' ) );
            echo '</span>';
        }

		$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'valeo' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">| tags: <span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Tags', 'Used before tag names.', 'valeo' ),
				$tags_list
			);
		}
	}
}
endif;

if ( ! function_exists( 'valeo_post_time' ) ) :
    /**
     * Prints HTML with meta time information for posts.
     */
    function valeo_post_time() {
        if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
            $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

            if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
                $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
            }

            $time_string = sprintf( $time_string,
                esc_attr( get_the_date( 'c' ) ),
                get_the_date( 'F j, Y' ),
                esc_attr( get_the_modified_date( 'c' ) ),
                get_the_modified_date( 'F j, Y - G:i' )
            );

            printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
                _x( 'Posted on', 'Used before publish date.', 'valeo' ),
                esc_url( get_day_link(get_the_date('Y'), get_the_date('m'), get_the_date('d')) ),
                $time_string
            );
        }
    }
endif;

if ( ! function_exists( 'valeo_post_time_block' ) ) :
	/**
	 * Prints HTML with meta time information for posts.
	 */
	function valeo_post_time_block() {
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				get_the_date( 'F j, Y' ),
				esc_attr( get_the_modified_date( 'c' ) ),
				get_the_modified_date( 'F j, Y - G:i' )
			);

			printf( '<div class="posted-on posted-on-block"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark"><span class="posted-day">'.get_the_date('d').'</span><span class="posted-month">'.get_the_date('M').'</span><span>%3$s</span></a><span class="comments-line"><i class="fa fa-comment-o"></i>'.get_comments_number().'</span></div>',
				_x( 'Posted on', 'Used before publish date.', 'valeo' ),
				esc_url( get_day_link(get_the_date('Y'), get_the_date('m'), get_the_date('d')) ),
				$time_string
			);
		}
	}
endif;

if ( ! function_exists( 'valeo_post_controls' ) ) :
	/**
	 * Prints HTML with meta comments information for posts.
	 */
	function valeo_post_controls() { ?>
		<div class="post-controls clearfix">
			<div class="pctrl-social-btn pctrl-left">
					<i class="fa fa-share"></i>
			</div>
			<div class="pctrl-social pctrl-left">
				<?php valeo_share_this(); ?>
			</div>
			<div class="pctrl-like-btn pctrl-left">
				<?php if ( function_exists( 'valeo_get_post_likes' ) ) {
					valeo_post_like_button( get_the_ID() );
				} ?>
			</div>
			<div class="pctrl-like pctrl-left">
				<div>
					<?php if ( function_exists( 'valeo_get_post_likes' ) ) {
						do_action( 'valeo_post_like_number', get_the_ID() );
						echo valeo_plural_text_no_number(
							valeo_get_post_likes( get_the_ID() ),
							esc_html__( 'like', 'valeo' ),
							esc_html__( 'likes', 'valeo' )
						);
					} ?>
				</div>
			</div>
			<div class="pctrl-view pctrl-right">
				<div>
					<?php if ( function_exists( 'valeo_get_post_views' ) ) {
						echo valeo_plural_text(
							valeo_get_post_views( get_the_ID() ),
							esc_html__( 'view', 'valeo' ),
							esc_html__( 'views', 'valeo' )
						);
					} ?>
				</div>
			</div>
		</div>
	<?php }
endif;

if ( ! function_exists( 'valeo_share_this' ) ) :
    /**
     * Share article through social networks.
     */
    function valeo_share_this() {

	    $social_sites = valeo_social_media_array();

	    $output = '';
	    $social_live_number = 0;

	    foreach ( $social_sites as $social_site ) {
		    $social_live = valeo_get_customizer_option( 'share_'.$social_site );
		    if ( ! empty( $social_live ) ) {
			    $social_live_number ++;
			    $output .= '<!-- ' . $social_site . ' -->';
			    switch ( $social_site ) {
				    case 'facebook':
					    $output .= '<li><a href="https://www.facebook.com/sharer/sharer.php?u=' . esc_url( get_permalink() ) . '" onclick="window.open(this.href, \'facebook-share\',\'width=580,height=296\');return false;"><i class="fa fa-facebook"></i></a></li>';
					    break;
				    case 'twitter':
					    $output .= '<li><a href="https://twitter.com/share?text=' . urlencode( get_the_title() ) . '&amp;url=' . esc_url( get_permalink() ) . '" onclick="window.open(this.href, \'twitter-share\', \'width=550,height=235\');return false;"><i class="fa fa-twitter"></i></a></li>';
					    break;
				    case 'google-plus':
					    $output .= '<li><a href="https://plus.google.com/share?url=' . esc_url( get_permalink() ) . '" onclick="window.open(this.href, \'google-plus-share\', \'width=490,height=530\');return false;"><i class="fa fa-google-plus"></i></a></li>';
					    break;
				    case 'pinterest':
					    $output .= '<li><a href="javascript:void((function()%7Bvar%20e=document.createElement(\'script\');e.setAttribute(\'type\',\'text/javascript\');e.setAttribute(\'charset\',\'UTF-8\');e.setAttribute(\'src\',\'http://assets.pinterest.com/js/pinmarklet.js?r=\'+Math.random()*99999999);document.body.appendChild(e)%7D)());"><i class="fa fa-pinterest"></i></a></li>';
					    break;
				    case 'linkedin':
					    $output .= '<li><a href="https://www.linkedin.com/shareArticle?mini=true%26url=' . esc_url( get_permalink() ) . '%26source=" onclick="window.open(this.href, \'linkedin-share\', \'width=490,height=530\');return false;"><i class="fa fa-linkedin"></i></a></li>';
					    break;
				    default:
					    break;
			    }
		    }
	    }

	    if ( ! empty( $output ) ) {
		    $output = '
            <div class="share-this share-icons-live-'. $social_live_number . '">
                <ul class="share-icons clearfix">' . $output . '</ul>
            </div>';
	    }

	    echo balanceTags( $output );

    }
endif;

if ( ! function_exists( 'valeo_footer_social_links' ) ) :
	/**
	 * Footer social networks.
	 */
	function valeo_footer_social_links() {

		$footer_social_sites = valeo_footer_social_media_array();

		$footer_output = '';
		$footer_social_live_number = 0;

		$footer_facebook_link = valeo_get_customizer_option( 'footer_facebook_link' );
		if ( empty( $footer_facebook_link ) ) {
			$footer_facebook_link = '';
		}
		$footer_twitter_link = valeo_get_customizer_option( 'footer_twitter_link' );
		if ( empty( $footer_twitter_link ) ) {
			$footer_twitter_link = '';
		}
		$footer_youtube_link = valeo_get_customizer_option( 'footer_youtube_link' );
		if ( empty( $footer_youtube_link ) ) {
			$footer_youtube_link = '';
		}
		$footer_google_plus_link = valeo_get_customizer_option( 'footer_google-plus_link' );
		if ( empty( $footer_google_plus_link ) ) {
			$footer_google_plus_link = '';
		}
		$footer_pinterest_link = valeo_get_customizer_option( 'footer_pinterest_link' );
		if ( empty( $footer_pinterest_link ) ) {
			$footer_pinterest_link = '';
		}
		$footer_linkedin_link = valeo_get_customizer_option( 'footer_linkedin_link' );
		if ( empty( $footer_linkedin_link ) ) {
			$footer_linkedin_link = '';
		}

		foreach ( $footer_social_sites as $footer_social_site ) {
			$footer_social_live = valeo_get_customizer_option( 'footer_'.$footer_social_site );
			if ( ! empty( $footer_social_live ) ) {
				$footer_social_live_number ++;
				$footer_output .= '<!-- ' . $footer_social_site . ' -->';
				switch ( $footer_social_site ) {
					case 'facebook':
						if ( ! empty( $footer_facebook_link ) ) {
							$footer_output .= '<li><a href="' . $footer_facebook_link . '" target="_blank"><i class="fa fa-facebook"></i></a></li>';
						}
						break;
					case 'twitter':
						if ( ! empty( $footer_twitter_link ) ) {
							$footer_output .= '<li><a href="' . $footer_twitter_link . '" target="_blank"><i class="fa fa-twitter"></i></a></li>';
						}
						break;
					case 'youtube':
						if ( ! empty( $footer_youtube_link ) ) {
							$footer_output .= '<li><a href="' . $footer_youtube_link . '" target="_blank"><i class="fa fa-youtube-play"></i></a></li>';
						}
						break;
					case 'google-plus':
						if ( ! empty( $footer_google_plus_link ) ) {
							$footer_output .= '<li><a href="' . $footer_google_plus_link . '" target="_blank"><i class="fa fa-google-plus"></i></a></li>';
						}
						break;
					case 'pinterest':
						if ( ! empty( $footer_pinterest_link ) ) {
							$footer_output .= '<li><a href="' . $footer_pinterest_link . '" target="_blank"><i class="fa fa-pinterest"></i></a></li>';
						}
						break;
					case 'linkedin':
						if ( ! empty( $footer_linkedin_link ) ) {
							$footer_output .= '<li><a href="' . $footer_linkedin_link . '" target="_blank"><i class="fa fa-linkedin"></i></a></li>';
						}
						break;
					default:
						break;
				}
			}
		}

		if ( ! empty( $footer_output ) ) {
			$footer_output = '
                <ul class="social-navigation footer-social-navigation footer-social-icons-live-'. $footer_social_live_number . '">' . $footer_output . '</ul>
            ';
		}

		echo balanceTags( $footer_output );

	}
endif;

if ( ! function_exists( 'valeo_header_social_links' ) ) :
	/**
	 * Header social networks.
	 */
	function valeo_header_social_links() {

		$header_social_sites = valeo_header_social_media_array();

		$header_output = '';
		$header_social_live_number = 0;

		$header_facebook_link = valeo_get_customizer_option( 'header_facebook_link' );
		if ( empty( $header_facebook_link ) ) {
			$header_facebook_link = '';
		}
		$header_twitter_link = valeo_get_customizer_option( 'header_twitter_link' );
		if ( empty( $header_twitter_link ) ) {
			$header_twitter_link = '';
		}
		$header_youtube_link = valeo_get_customizer_option( 'header_youtube_link' );
		if ( empty( $header_youtube_link ) ) {
			$header_youtube_link = '';
		}
		$header_google_plus_link = valeo_get_customizer_option( 'header_google-plus_link' );
		if ( empty( $header_google_plus_link ) ) {
			$header_google_plus_link = '';
		}
		$header_pinterest_link = valeo_get_customizer_option( 'header_pinterest_link' );
		if ( empty( $header_pinterest_link ) ) {
			$header_pinterest_link = '';
		}
		$header_linkedin_link = valeo_get_customizer_option( 'header_linkedin_link' );
		if ( empty( $header_linkedin_link ) ) {
			$header_linkedin_link = '';
		}

		foreach ( $header_social_sites as $header_social_site ) {
			$header_social_live = valeo_get_customizer_option( 'header_'.$header_social_site );
			if ( ! empty( $header_social_live ) ) {
				$header_social_live_number ++;
				$header_output .= '<!-- ' . $header_social_site . ' -->';
				switch ( $header_social_site ) {
					case 'facebook':
						if ( ! empty( $header_facebook_link ) ) {
							$header_output .= '<li><a href="' . $header_facebook_link . '" target="_blank"><i class="fa fa-facebook"></i></a></li>';
						}
						break;
					case 'twitter':
						if ( ! empty( $header_twitter_link ) ) {
							$header_output .= '<li><a href="' . $header_twitter_link . '" target="_blank"><i class="fa fa-twitter"></i></a></li>';
						}
						break;
					case 'youtube':
						if ( ! empty( $header_youtube_link ) ) {
							$header_output .= '<li><a href="' . $header_youtube_link . '" target="_blank"><i class="fa fa-youtube-play"></i></a></li>';
						}
						break;
					case 'google-plus':
						if ( ! empty( $header_google_plus_link ) ) {
							$header_output .= '<li><a href="' . $header_google_plus_link . '" target="_blank"><i class="fa fa-google-plus"></i></a></li>';
						}
						break;
					case 'pinterest':
						if ( ! empty( $header_pinterest_link ) ) {
							$header_output .= '<li><a href="' . $header_pinterest_link . '" target="_blank"><i class="fa fa-pinterest"></i></a></li>';
						}
						break;
					case 'linkedin':
						if ( ! empty( $header_linkedin_link ) ) {
							$header_output .= '<li><a href="' . $header_linkedin_link . '" target="_blank"><i class="fa fa-linkedin"></i></a></li>';
						}
						break;
					default:
						break;
				}
			}
		}

		if ( ! empty( $header_output ) ) {
			$header_output = '' . $header_output . '';
		}

		echo balanceTags( $header_output );

	}
endif;

if ( ! function_exists( 'valeo_edit_post_link' ) ) :
    /**
     * Prints edit post tags.
     */
    function valeo_edit_post_link() {
        edit_post_link( esc_html__( 'Edit', 'valeo' ), '<span class="edit-link">', '</span>' );
    }
endif;

if ( ! function_exists( 'valeo_post_categories' ) ) :
	/**
	 * Prints post categories.
	 */
	function valeo_post_categories() {
		$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'valeo' ) );
		if ( $categories_list && valeo_categorized_blog() ) {
			printf( '<div class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</div>',
				_x( 'Categories', 'Used before category names.', 'valeo' ),
				$categories_list
			);
		}

	}
endif;

if ( ! function_exists( 'valeo_post_tags' ) ) :
    /**
     * Prints post tags.
     */
    function valeo_post_tags() {
        $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'valeo' ) );
        if ( $tags_list ) {
            printf( '<div class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</div>',
                _x( 'Tags', 'Used before tag names.', 'valeo' ),
                $tags_list
            );
        }
    }
endif;

if ( ! function_exists( 'valeo_categorized_blog' ) ) :
/**
 * Determine whether blog/site has more than one category.
 *
 * @return bool True of there is more than one category, false otherwise.
 */
function valeo_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'valeo_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'valeo_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so valeo_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so valeo_categorized_blog should return false.
		return false;
	}
}
endif;

if ( ! function_exists( 'valeo_category_transient_flusher' ) ) :
/**
 * Flush out the transients used in {@see valeo_categorized_blog()}.
 */
function valeo_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'valeo_categories' );
}
endif;
add_action( 'edit_category', 'valeo_category_transient_flusher' );
add_action( 'save_post',     'valeo_category_transient_flusher' );

if ( ! function_exists( 'valeo_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function valeo_post_thumbnail( $args=array() ) {
    global $post;
    extract($args);
    $background = isset($background) ? $background : false;
    $print = isset($print) ? $print : true;
    $thumbnail_size = isset($thumbnail_size) ? $thumbnail_size : 'post-thumbnail';
    $thumbnail_class = isset($thumbnail_class) ? $thumbnail_class : 'post-thumbnail';
    $read_more = isset($read_more) ? $read_more : false;
    $use_default = isset($use_default) ? $use_default : false;
    $no_url = isset($no_url) ? $no_url : false;
    $is_widget = isset($is_widget) ? $is_widget : false;
    $post_obj = isset($post_obj) ? $post_obj : $post;

	if ( post_password_required( $post_obj ) || is_attachment() || ( ! has_post_thumbnail( $post_obj ) && ! $use_default ) ) {
		return;
	}

    $post_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post_obj->ID), $thumbnail_size);
    if (empty($post_thumbnail[0]) && $use_default) :
        $theme_options = valeo_get_theme_mods();
        $post_thumbnail = array(esc_url($theme_options['default_thumbnail']));
    endif;

    $post_img = esc_url($post_thumbnail[0]);

    if ($background) :

        if (!empty($post_img)) :
            if ($print) :
                echo "background: url('" . $post_img . "') 50% 50% no-repeat; background-size: cover;";
            else :
                return "background: url('" . $post_img . "') 50% 50% no-repeat; background-size: cover;";
            endif;
        endif;

    elseif (!$is_widget && is_singular()) : ?>

        <div class="<?php echo esc_attr($thumbnail_class); ?>">
            <?php the_post_thumbnail(); ?>
        </div><!-- .post-thumbnail -->

    <?php else : ?>

        <?php
        if ($print) {
            if (!$no_url) { ?>
	            <a class="<?php echo esc_attr( $thumbnail_class ); ?>" href="<?php esc_url( the_permalink( $post_obj ) ); ?>" aria-hidden="true">
                <?php if ($read_more) { ?>
                    <span class="post-thumbnail--link"><span><?php esc_html_e('Read More', 'valeo'); ?></span></span>
                <?php }
            }
	        echo '<img class="' . esc_attr( $thumbnail_class ) . '" src="' . esc_url( $post_img ) . '" alt="' . get_the_title( $post_obj ) . '" />';
            if (!$no_url) { ?>
                </a>
            <?php }
        } else {
            $output = '';
            if (!$no_url) {
	            $output .= '<a class="' . esc_attr( $thumbnail_class ) . '" href="' . esc_url( get_the_permalink( $post_obj ) ) . '" aria-hidden="true">';
                if ($read_more) {
                    $output .= '<span class="post-thumbnail--link"><span>' . esc_html('Read More', 'valeo') . '</span></span>';
                }
            }
	        $output .= '<img class="' . esc_attr( $thumbnail_class ) . '" src="' . esc_url( $post_img ) . '" alt="' . get_the_title( $post_obj ) . '" />';
            if (!$no_url) {
                $output .= '</a>';
            }
            return $output;
        }
        ?>


    <?php endif; // End is_singular()
}
endif;

if ( ! function_exists( 'valeo_get_link_url' ) ) :
/**
 * Return the post URL.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @see get_url_in_content()
 *
 * @return string The Link format URL.
 */
function valeo_get_link_url() {
	$has_url = get_url_in_content( get_the_content() );

	return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}
endif;

if ( ! function_exists( 'valeo_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function valeo_excerpt_more( $more ) {
    if(empty($more)){
        $more = 'Read more';
    }

	$link = sprintf( '<span class="excerpt-more"> <a href="%1$s" class="more-link">'.$more.' %2$s</a></span>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( esc_html__( '%s', 'valeo' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
		);
	return $link;
}
add_filter( 'excerpt_more', 'valeo_excerpt_more' );
endif;

if ( ! function_exists( 'valeo_truncate_words' ) ) :
function valeo_truncate_words($text, $maxLength = 200)
{
    // explode the text into an array of words
    $wordArray = explode(' ', $text);

    // do we have too many?
    if( sizeof($wordArray) > $maxLength )
    {
        // remove the unwanted words
        $wordArray = array_slice($wordArray, 0, $maxLength);

        // turn the word array back into a string
        return implode(' ', $wordArray);
    }

    // if our array is under the limit, just send it straight back
    return $text;
}
endif;

if ( ! function_exists( 'valeo_excerpt_chat' ) ) :
/**
 * trims text to a space then adds ellipses if desired
 * @param string $input text to trim
 * @param int $length in characters to trim to
 * @param bool $ellipses if ellipses (...) are to be added
 * @param bool $strip_html if html tags are to be stripped
 * @return string
 */
function valeo_excerpt_chat($input, $length, $ellipses = true, $strip_html = true, $is_chat = true) {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }

    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }

    if( $is_chat ) {
        //find last break within length
        $last_break = strrpos(substr($input, 0, $length), "\n");
        if( !$last_break ) {
            $last_break = strpos($input, "\n");
        }
        $trimmed_text = str_replace( "\n", "<br>", substr($input, 0, $last_break));
    } else {
        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), " ");
        $trimmed_text = substr($input, 0, $last_space);
    }

    if( !$trimmed_text ) {
        $trimmed_text = $input;
    }

    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }

    return '<p>'.$trimmed_text.'</p>';
}
endif;

if ( ! function_exists( 'valeo_get_between' ) ) :
function valeo_get_between($content,$start,$end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}
endif;

if ( ! function_exists( 'valeo_parse_media' ) ) :
function valeo_parse_media( $content ){
    $first_line = valeo_excerpt_chat($content, 1, false, false, true);

    $shortcode = valeo_get_between($first_line, "[", "]");

    if( empty($shortcode) ) {
        $media = wp_oembed_get(trim(strip_tags($first_line)));
    } else {
        $media = do_shortcode("[".$shortcode."]");
    }

    if( !empty($media) && ( is_single() || !valeo_is_blog_view_excerpt() ) ){
        add_filter("the_content", "valeo_remove_first_line_media");
    } else {
        remove_filter("the_content", "valeo_remove_first_line_media");
    }

	if ( ! empty( $media ) && empty($shortcode) ) {
        $oembed_with_background = array( "twitter.com", "facebook.com" );
        foreach($oembed_with_background as $needle){
            if( preg_match('/'.$needle.'/', $media)){
                $thumbnail_args = array(
                    'background' => true,
                    'print' => false,
                );
                $media = '<div class="featured-media status-wrap" style="'.valeo_post_thumbnail( $thumbnail_args ).'">'.$media."</div>";
                break;
            }
        }

    }

    return $media;
}
endif;

if ( ! function_exists( 'valeo_remove_first_line_media' ) ) :
function valeo_remove_first_line_media( $content ){

    if(!strpos($content, "\n")){
        $content = '';
    } else {
        $content = preg_replace('/^.+\n/', '', $content);
    }

    return $content;
}
endif;

if ( ! function_exists( 'valeo_check_simple_player' ) ) :
function valeo_check_simple_player($media) {
    if( strpos( $media, 'wp-audio-shortcode' ) ) {
        return true;
    }

    return false;
}
endif;

if ( ! function_exists( 'valeo_print_post_header' ) ) :
	function valeo_print_post_header() {

		if ( is_single() ) :

			echo '<div class="before-title">';

			// Post time
			valeo_post_time();

			// Post Author
			printf( '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span>by <a class="url fn n" href="%2$s">%3$s</a></span></span>',
				_x( 'Author', 'Used before post author name.', 'valeo' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_the_author()
			);
			echo '</div>';

			// Post Title
			the_title( '<h1 class="page-title">', '</h1>' );

			// Post Controls / share icons
			valeo_post_controls();

		else :

			echo '<div class="before-title">';

			// Post time
			valeo_post_time();

			// Post Author
			printf( '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span>by <a class="url fn n" href="%2$s">%3$s</a></span></span>',
				_x( 'Author', 'Used before post author name.', 'valeo' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_the_author()
			);
			echo '</div>';

			//valeo_post_categories();
			//valeo_post_tags();
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

		endif;

	}
endif;
add_action( 'valeo_after_thumbnail', 'valeo_print_post_header', 999 );

if ( ! function_exists( 'valeo_get_first_category' ) ) :
	function valeo_get_first_category( $post_id, $class = '' ){
		$categories_list = wp_get_post_categories( $post_id, array('orderby'=> 'slug', 'fields' => 'all'));
		$first_cat_id = $categories_list[0]->term_id;
		$first_cat_name = $categories_list[0]->name;
		$first_cat_link = get_category_link( $first_cat_id );

		if ( $categories_list && valeo_categorized_blog() ) {
			if(!empty($class)) {
				$class = ' class="'.$class.'"';
			}
			$first_cat_name = '<a href="' . $first_cat_link . '"'.$class.'>' . $first_cat_name . '</a>';
		} else {
			$first_cat_name = '';
		}

		return $first_cat_name;
	}
endif;


if ( ! function_exists( 'valeo_is_builder_post' ) ) :
	function valeo_is_builder_post( $post_id ){

		return defined( "FW" ) && fw_ext('page-builder') && fw_ext_page_builder_is_builder_post( $post_id );
	}
endif;