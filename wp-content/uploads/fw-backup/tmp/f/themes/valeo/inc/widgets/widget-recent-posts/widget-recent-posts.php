<?php
/**
 * Recent_Posts customized widget class.0
 */
if ( ! function_exists( 'valeo_recent_posts_display_callback' ) ) :
function valeo_recent_posts_display_callback($instance, $widget, $args) {
	if ( 'recent-posts' == $widget->id_base ) {

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $widget->id;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( '', 'valeo' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title    = apply_filters( 'widget_title', $title, $instance, $widget->id_base );
		$category = isset( $instance['valeo_rp_category'] ) ? $instance['valeo_rp_category'] : '';

		$layout = isset( $instance['valeo_rp_layout'] ) ? absint( $instance['valeo_rp_layout'] ) : 1;

		$bg_image = get_template_directory() . "/images/recent_posts_bg.jpg";
		$background = 1;
		if ( file_exists( $bg_image ) ) {
			$background = isset( $instance['valeo_rp_background'] ) ? absint( $instance['valeo_rp_background'] ) : 1;
		}

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}

		$show_date  = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$show_views = function_exists( 'valeo_get_post_views' ) && isset( $instance['valeo_rp_show_views'] ) ? $instance['valeo_rp_show_views'] : false;
		$show_likes = function_exists( 'valeo_get_post_likes' ) && isset( $instance['valeo_rp_show_likes'] ) ? $instance['valeo_rp_show_likes'] : false;

		$cat_exclude = '';
		$main_slider_cat = valeo_get_main_slider_category();
		if ( $main_slider_cat['id'] ) {
			$cat_exclude = -$main_slider_cat['id'];
		}

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'category_name'       => $category,
			'ignore_sticky_posts' => true,
			'cat'                 => $cat_exclude,
		) ) );

		if ( $r->have_posts() ) :

			$thumbnail_args = array(
				'background'      => false,
				'print'           => true,
				'thumbnail_size'  => 'valeo_top-news-3-2',
				'thumbnail_class' => 'recent-posts__media',
				'use_default'     => true,
				'is_widget'       => true,
				'no_url'          => true,
			);

			$thumbnail_args_bg = array(
				'background'      => true,
				'print'           => false,
				'thumbnail_size'  => 'valeo_top-news-3-2',
				'thumbnail_class' => 'recent-posts__media',
				'use_default'     => true,
				'is_widget'       => true,
				'no_url'          => true,
			);

			if ( file_exists( $bg_image ) && $background == 2 ) {
				$rp_search = array(
					'">',
					'>'
				);
				$rp_replace = array(
					' rp-with-bg">',
					' style="background-image: url(\'' . get_template_directory_uri() . '/images/recent_posts_bg.jpg\');">'
				);
				echo str_replace( $rp_search, $rp_replace, $args['before_widget'] );
			} else {
				echo wp_kses_post($args['before_widget']);
			}
			?>
			<?php if ( $title ) {
			echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
		} ?>
			<ul <?php echo 'class="recent-posts layout-' . $layout . '"'; ?>><!--
				<?php while ( $r->have_posts() ) : $r->the_post(); ?>
					--><li>
						<div class="recent-posts__inner"><?php

							$pID = get_the_ID();

			                if ( $layout == '1' || $layout == '2' ) {

				                if ( $layout == '2' ) {
					                echo '<a class="recent-posts__media" href="' . get_the_permalink( $pID ) . '"><span class="overlay ' . get_post_format() . '"></span>';
					                /* Post Likes Count */
					                if ( function_exists( 'valeo_get_post_likes' ) && $show_likes ) :
						                echo '<span class="recent-posts__likes"><i class="recent-posts__icon fa fa-heart-o"></i>' . valeo_get_post_likes( $pID ) . '</span>';
					                endif;
					                valeo_post_thumbnail( $thumbnail_args );
					                echo '</a>';
				                } else {
					                echo '<a class="recent-posts__media" style="' . valeo_post_thumbnail( $thumbnail_args_bg ) . '" href="' . esc_url( get_the_permalink( $pID ) ) . '"><span class="overlay ' . get_post_format() . '"></span>';
					                /* Post Likes Count */
					                if ( function_exists( 'valeo_get_post_likes' ) && $show_likes ) {
						                echo '<span class="recent-posts__likes"><i class="recent-posts__icon fa fa-heart-o"></i>' . valeo_get_post_likes( $pID ) . '</span>';
					                }
					                echo '</a>';
				                } ?>


                                <span class="recent-posts__content">
                                <a class="recent-posts__title" href="<?php esc_url( the_permalink() ); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
					                <?php /* Post Date */
					                if ( $show_date ) { ?>
                                        <span class="recent-posts__date"><?php echo get_the_date( 'd.m.Y' ); ?></span>
					                <?php } ?>
					                <?php /* Post Views Count */
					                if ( function_exists( 'valeo_get_post_views' ) && $show_views ) {
						                $post_views = valeo_get_post_views( $pID ); ?>
                                        <span class="recent-posts__views"><?php echo valeo_plural_text( $post_views, esc_html__( 'view', 'valeo' ), esc_html__( 'views', 'valeo' ) ); ?></span>
					                <?php } ?>
                            </span><!-- .recent-posts__content --><?php
                            } ?>

                            <?php

                            if ( $layout == '3' ) {
	                            valeo_post_thumbnail( $thumbnail_args ); ?>
                                <div class="recent-posts__content"><?php
                                    /* Post Date */
                                    if ( $show_date ) { ?>
                                        <div class="recent-posts__date"><?php echo get_the_date( 'd.m.Y' ); ?></div>
                                    <?php } ?>
                                    <a class="recent-posts__title" href="<?php esc_url( the_permalink() ); ?>">
                                        <?php get_the_title() ? the_title() : the_ID(); ?>
                                    </a>
                                    <div class="recent-posts__description"><?php echo get_the_excerpt(); ?></div>
                                    <div class="recent-posts__meta">
                                        <?php /* Post Views Count */
                                        if ( function_exists( 'valeo_get_post_views' ) && $show_views ) {
                                            $post_views = valeo_get_post_views( $pID ); ?>
                                            <span class="recent-posts__views"><i class="recent-posts__icon fa fa-eye"></i><?php echo valeo_plural_text( $post_views, esc_html__( '', 'valeo' ), esc_html__( '', 'valeo' ) ); ?></span>
                                        <?php } ?>
                                        <?php /* Post Likes Count */
                                        if ( function_exists( 'valeo_get_post_likes' ) && $show_likes ) {
                                            echo '<span class="recent-posts__likes"><i class="recent-posts__icon fa fa-heart-o"></i>' . valeo_get_post_likes( $pID ) . '</span>';
                                        } ?>
                                        <?php /* Excerpt / Read more link */ ?>
                                        <span class="recent-posts__comments"><i class="recent-posts__icon fa fa-comment-o"></i><?php comments_number( '0', '1', '%' ); ?></span>
                                    </div>
                                </div><?php
                            } ?>
						</div>
					</li><!--
				<?php endwhile; ?>
			--></ul>
			<?php echo wp_kses_post($args['after_widget']); ?>
			<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();

		endif;

		if ( ! $widget->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_recent_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
		return false;
	}
	return $instance;
}
endif;
add_filter( 'widget_display_callback', 'valeo_recent_posts_display_callback', 10, 3 );

if ( ! function_exists( 'valeo_save_recent_posts_custom_options' ) ) :
function valeo_save_recent_posts_custom_options( $instance, $new_instance ) {

	$instance['valeo_rp_category'] = $new_instance['valeo_rp_category'];
	if( function_exists( 'valeo_get_post_views' ) ) {
		$instance['valeo_rp_show_views'] = isset( $new_instance['valeo_rp_show_views'] ) ? (bool) $new_instance['valeo_rp_show_views'] : false;
	}
	if( function_exists( 'valeo_get_post_likes' ) ) {
		$instance['valeo_rp_show_likes'] = isset( $new_instance['valeo_rp_show_likes'] ) ? (bool) $new_instance['valeo_rp_show_likes'] : false;
	}
	$instance['valeo_rp_layout'] = (int) $new_instance['valeo_rp_layout'];
	if (file_exists( get_template_directory() . "/images/recent_posts_bg.jpg" )) {
		$instance['valeo_rp_background'] = (int) $new_instance['valeo_rp_background'];
	}

	return $instance;
}
endif;
add_filter( 'widget_update_callback', 'valeo_save_recent_posts_custom_options', 10, 2 );

if ( ! function_exists( 'valeo_add_recent_posts_custom_options' ) ) :
function valeo_add_recent_posts_custom_options( $widget, $return, $instance ) {

	if ( 'recent-posts' == $widget->id_base ) {

		$category  = isset( $instance['valeo_rp_category'] ) ? $instance['valeo_rp_category'] : '';

		if( function_exists( 'valeo_get_post_views' ) ) {
			$show_views = isset( $instance['valeo_rp_show_views'] ) ? (bool) $instance['valeo_rp_show_views'] : false;
		}
		if( function_exists( 'valeo_get_post_likes' ) ) {
			$show_likes = isset( $instance['valeo_rp_show_likes'] ) ? (bool) $instance['valeo_rp_show_likes'] : false;
		}
		$layout      = isset( $instance['valeo_rp_layout'] ) ? absint( $instance['valeo_rp_layout'] ) : 1;

		$bg_image = get_template_directory() . "/images/recent_posts_bg.jpg";
		if (file_exists( $bg_image )) {
			$background = isset( $instance['valeo_rp_background'] ) ? absint( $instance['valeo_rp_background'] ) : 1;
		}
		?>
		<p>
			<strong><?php esc_attr_e( 'Layout:', 'valeo' ); ?></strong><br>
			<label for="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_list' ) ); ?>" class="recent-posts-radio-label">
				<input class="recent-posts-radio" type="radio" <?php checked( $layout == 1 ); ?> id="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_list' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'valeo_rp_layout' ) ); ?>" value="1" />
				<img src="<?php echo get_template_directory_uri().'/inc/widgets/widget-recent-posts/images/recent-posts-list.gif'; ?>" alt="<?php echo esc_html__('List', 'valeo'); ?>">
			</label>
			<label for="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_grid-1' ) ); ?>" class="recent-posts-radio-label">
				<input class="recent-posts-radio" type="radio" <?php checked( $layout == 2 ); ?> id="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_grid-1' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'valeo_rp_layout' ) ); ?>" value="2" />
				<img src="<?php echo get_template_directory_uri().'/inc/widgets/widget-recent-posts/images/recent-posts-grid-big.gif'; ?>" alt="<?php echo esc_html__('Grid 1', 'valeo'); ?>">
			</label>
			<label for="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_grid-2' ) ); ?>" class="recent-posts-radio-label">
				<input class="recent-posts-radio" type="radio" <?php checked( $layout == 3 ); ?> id="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_grid-2' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'valeo_rp_layout' ) ); ?>" value="3" />
				<img src="<?php echo get_template_directory_uri().'/inc/widgets/widget-recent-posts/images/recent-posts-grid.gif'; ?>" alt="<?php echo esc_html__('Grid 2', 'valeo'); ?>">
			</label>
		</p>
		<?php
		if (file_exists( $bg_image )) { ?>
			<p>
				<strong><?php esc_attr_e( 'Background:', 'valeo' ); ?></strong><br>
				<label for="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_nobg' ) ); ?>" class="recent-posts-radio-label">
					<input class="recent-posts-radio" type="radio" <?php checked( $background == 1 ); ?> id="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_nobg' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'valeo_rp_background' ) ); ?>" value="1" />
					<img src="<?php echo get_template_directory_uri().'/inc/widgets/widget-recent-posts/images/recent-posts-no-bg.png'; ?>" alt="<?php echo esc_html__('No Background', 'valeo'); ?>">
				</label>
				<label for="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_usebg' ) ); ?>" class="recent-posts-radio-label">
					<input class="recent-posts-radio" type="radio" <?php checked( $background == 2 ); ?> id="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_usebg' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'valeo_rp_background' ) ); ?>" value="2" />
					<img src="<?php echo get_template_directory_uri().'/inc/widgets/widget-recent-posts/images/recent-posts-with-bg.png'; ?>" alt="<?php echo esc_html__('Use Background', 'valeo'); ?>" style="background: transparent url('<?php echo get_template_directory_uri() . "/images/recent_posts_bg.jpg"; ?>') no-repeat center; background-size: cover;">
				</label>
			</p>
		<?php } ?>

		<p>
			<label for="<?php echo esc_attr( $widget->get_field_id('valeo_rp_category') ); ?>"><?php esc_attr_e('Category:', 'valeo');?></label>
			<?php wp_dropdown_categories(array( 'show_option_all' => esc_html__('All Categories', 'valeo'), 'hide_empty'=>0, 'selected'=>$category, 'name'=>$widget->get_field_name('valeo_rp_category'), 'id'=>$widget->get_field_id('valeo_rp_category'), 'value_field'=>'slug')); ?>
		</p>

		<?php if( function_exists( 'valeo_get_post_views' ) ) { ?>
			<p><input class="checkbox" type="checkbox" <?php checked( $show_views ); ?> id="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_show_views' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'valeo_rp_show_views' ) ); ?>" />
				<label for="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_show_views' ) ); ?>"><?php esc_attr_e( 'Display post views?', 'valeo' ); ?></label></p>
			<?php
		}

		if( function_exists( 'valeo_get_post_likes' ) ) { ?>
			<p><input class="checkbox" type="checkbox" <?php checked( $show_likes ); ?> id="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_show_likes' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'valeo_rp_show_likes' ) ); ?>" />
				<label for="<?php echo esc_attr( $widget->get_field_id( 'valeo_rp_show_likes' ) ); ?>"><?php esc_attr_e( 'Display post likes?', 'valeo' ); ?></label></p>

			<?php
		}
		?>

		<?php
	}
}
endif;
add_filter('in_widget_form', 'valeo_add_recent_posts_custom_options', 9, 3 );

if (!function_exists('valeo_recent_posts_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function valeo_recent_posts_setup() {
        if(!has_image_size('valeo_top-news-3-2')){
            add_image_size('valeo_top-news-3-2', 640, 427, true );
        }
    }
endif; // valeo_recent_posts_setup
add_action('after_setup_theme', 'valeo_recent_posts_setup', 20);

if (!function_exists('valeo_recent_posts_scripts')) :
    function valeo_recent_posts_scripts() {
        // Load widget stylesheet.
	    wp_enqueue_style('valeo-recent-posts-widget', get_template_directory_uri() . '/inc/widgets/widget-recent-posts/widget-recent-posts.css');
	    if ( is_rtl() ) {
		    wp_enqueue_style('valeo-recent-posts-widget-rtl', get_template_directory_uri() . '/inc/widgets/widget-recent-posts/widget-recent-posts-rtl.css');
	    }
    }
endif;
add_action('wp_enqueue_scripts', 'valeo_recent_posts_scripts');

if (!function_exists('valeo_recent_posts_admin_scripts')) :
    function valeo_recent_posts_admin_scripts() {
        // Load widget admin stylesheet.
        wp_enqueue_style('valeo-recent-posts-widget-admin', get_template_directory_uri() . '/inc/widgets/widget-recent-posts/widget-recent-posts-admin.css');
    }
endif;
add_action('admin_print_styles', 'valeo_recent_posts_admin_scripts');