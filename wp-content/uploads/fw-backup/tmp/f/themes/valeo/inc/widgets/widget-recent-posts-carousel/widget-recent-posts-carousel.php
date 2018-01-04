<?php
/**
 * Recent_Posts_Carousel widget class.0
 */
class VALEO_Widget_Recent_Posts_Carousel extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_recent_entries_carousel', 'description' => esc_html__( "Your site&#8217;s most recent Posts organized in Slider.", 'valeo') );
		parent::__construct('recent-posts-carousel', esc_html__('Recent Posts Carousel', 'valeo'), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries_carousel';
	}

	public function widget($args, $instance) {

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		$unique_id = uniqid();

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$category = isset( $instance['category'] ) ? $instance['category'] : '';
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$show_category = isset( $instance['show_category'] ) ? $instance['show_category'] : false;
		$show_description = isset( $instance['show_description'] ) ? $instance['show_description'] : false;
		$show_navigation = isset( $instance['show_navigation'] ) ? $instance['show_navigation'] : false;
		$autoplay = isset( $instance['autoplay'] ) ? $instance['autoplay'] : false;

		$thumbnail_args = array(
			'thumbnail_size' => 'valeo_top-news-3-2',
			'thumbnail_class' => 'valeo_top-news-3-2',
			'use_default' => true,
			'is_widget' => true,
			'no_url' => true,
		);

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
			'category_name'        => $category,
			'ignore_sticky_posts' => true,
			'cat'                 => $cat_exclude
		) ) );

		if ($r->have_posts()) :
			?>
			<?php echo wp_kses_post($args['before_widget']); ?>
			<?php if ( $title ) {
			echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
		} ?>

			<?php if ( $show_description ) { ?>

			<div class="owl-recent-post-carousel owl-recent-post-carousel<?php echo esc_attr($unique_id)?> owl-carousel rp-carousel rp-show-description <?php echo esc_attr($show_navigation); ?>"
			     data-show_navigation="<?php echo esc_attr( $show_navigation ) ? 'true' : 'false' ?>"
			     data-autoplay="<?php echo esc_attr( $autoplay ) ? 'true' : 'false' ?>"
			     data-unique_id="<?php echo esc_attr( $unique_id ); ?>"
			     data-show_description="<?php echo esc_attr( $show_description ); ?>">
			<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<div class="item">
					<div class="rp-carousel__image"><?php valeo_post_thumbnail($thumbnail_args) ?></div>
					<div class="rp-carousel__content">
						<?php /* Post Category */
						if ( $show_category ) : ?>
							<div class="rp-carousel__category"><?php echo valeo_get_first_category( get_the_ID() ); ?></div>
						<?php endif; ?>
						<h2 class="rp-carousel__title"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h2>
						<?php /* Post Date */
						if ( $show_date ) : ?>
							<span class="rp-carousel__date"><?php echo get_the_date('d.m.Y'); ?></span>
						<?php endif; ?>
						<span class="rp-carousel__desc">
							<?php echo valeo_truncate_words( strip_tags( get_the_content() ), apply_filters( 'excerpt_length', false ) ); ?>
						</span>
						<span class="rp-carousel__more">
							<a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'valeo' ) ?></a>
						</span>
					</div>
				</div><!-- .item -->
			<?php endwhile; ?>
			</div><?php

			} else { ?>

			<div class="owl-recent-post-carousel owl-recent-post-carousel<?php echo esc_attr($unique_id)?> owl-carousel rp-carousel <?php echo esc_attr($show_navigation); ?>"
			     data-show_navigation="<?php echo esc_attr( $show_navigation ) ? 'true' : 'false' ?>"
			     data-autoplay="<?php echo esc_attr( $autoplay ) ? 'true' : 'false' ?>"
			     data-unique_id="<?php echo esc_attr( $unique_id ); ?>"
			     data-show_description="<?php echo esc_attr( $show_description ); ?>">
				<?php while ( $r->have_posts() ) : $r->the_post(); ?>
					<div class="item">
						<div class="overlay"></div>
						<div class="rp-carousel__content">
							<?php /* Post Category */
							if ( $show_category ) : ?>
								<div class="rp-carousel__category"><?php echo valeo_get_first_category( get_the_ID() ); ?></div>
							<?php endif; ?>
							<h2 class="rp-carousel__title"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h2>
							<?php /* Post Date */
							if ( $show_date ) : ?>
								<span class="rp-carousel__date"><?php echo get_the_date('d.m.Y'); ?></span>
							<?php endif; ?>
						</div>
						<div class="rp-carousel__image"><?php valeo_post_thumbnail($thumbnail_args) ?></div>
					</div><!-- .item -->
				<?php endwhile; ?>
			</div><?php

			} ?>
			<?php echo wp_kses_post($args['after_widget']); ?>
			<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_recent_posts_carousel', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['category'] = $new_instance['category'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $instance['show_category'] = isset( $new_instance['show_category'] ) ? (bool) $new_instance['show_category'] : false;
        $instance['show_description'] = isset( $new_instance['show_description'] ) ? (bool) $new_instance['show_description'] : false;
		$instance['show_navigation'] = isset( $new_instance['show_navigation'] ) ? (bool) $new_instance['show_navigation'] : false;
		$instance['autoplay'] = isset( $new_instance['autoplay'] ) ? (bool) $new_instance['autoplay'] : false;

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries_carousel']) )
			delete_option('widget_recent_entries_carousel');

		return $instance;
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$category  = isset( $instance['category'] ) ? $instance['category'] : '';
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		$show_category   = isset( $instance['show_category'] ) ? (bool) $instance['show_category'] : false;
		$show_description   = isset( $instance['show_description'] ) ? (bool) $instance['show_description'] : false;
		$show_navigation = isset( $instance['show_navigation'] ) ? (bool) $instance['show_navigation'] : false;
		$autoplay = isset( $instance['autoplay'] ) ? (bool) $instance['autoplay'] : false;

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo wp_kses( __( 'Title<br><i>carousel title</i>', 'valeo' ), $allowed_html_array = array( 'br' => array(), 'i' => array() ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php echo wp_kses(__( 'Number of posts<br><i>to show</i>', 'valeo' ), $allowed_html_array = array( 'br' => array(), 'i' => array() ) ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" value="<?php echo absint( $number ); ?>" size="3" /></p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('category') ); ?>"><?php echo wp_kses(__('Category<br><i>posts category</i>', 'valeo'), $allowed_html_array = array( 'br' => array(), 'i' => array() ) ); ?></label>
			<?php wp_dropdown_categories(array( 'show_option_all' => esc_html__('All Categories', 'valeo'), 'hide_empty'=>0, 'selected'=>$category, 'name'=>$this->get_field_name('category'), 'id'=>$this->get_field_id('category'), 'value_field'=>'slug')); ?>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Display post date?', 'valeo' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_category ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_category' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_category' ) ); ?>"><?php esc_html_e( 'Display post category?', 'valeo' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_description ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_description' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_description' ) ); ?>"><?php esc_html_e( 'Show short description?', 'valeo' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_navigation ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_navigation' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_navigation' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_navigation' ) ); ?>"><?php esc_html_e( 'Show navigation?', 'valeo' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $autoplay ); ?> id="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'autoplay' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>"><?php esc_html_e( 'Auto play', 'valeo' ); ?></label>
		</p>

		<?php
	}
}

if ( ! function_exists( 'valeo_recent_posts_carousel_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function valeo_recent_posts_carousel_setup() {
		if(!has_image_size('valeo_top-news-3-2')){
			add_image_size('valeo_top-news-3-2', 640, 427, true);
		}
	}
endif; // valeo_top_news_setup
add_action( 'after_setup_theme', 'valeo_recent_posts_carousel_setup', 20 );

if ( ! function_exists( 'valeo_register_widget_recent_posts_carousel' ) ) :
	function valeo_register_widget_recent_posts_carousel() {
		register_widget( 'VALEO_Widget_Recent_Posts_Carousel' );
	}
endif;
add_action( 'widgets_init', 'valeo_register_widget_recent_posts_carousel' );

if ( ! function_exists( 'valeo_recent_posts_carousel_scripts' ) ) :
	function valeo_recent_posts_carousel_scripts() {
		// Load widget stylesheet.
		wp_enqueue_style( 'valeo-recent-posts-carousel-widget', get_template_directory_uri() . '/inc/widgets/widget-recent-posts-carousel/widget-recent-posts-carousel.css' );
		if ( is_rtl() ) {
			wp_enqueue_style( 'valeo-recent-posts-carousel-widget-rtl', get_template_directory_uri() . '/inc/widgets/widget-recent-posts-carousel/widget-recent-posts-carousel-rtl.css' );
		}
		// Load script for carousel.
		wp_enqueue_script( 'valeo-recent-posts-carousel-widget-js', get_template_directory_uri() . '/inc/widgets/widget-recent-posts-carousel/widget-recent-posts-carousel.js', array( 'jquery' ), "all", true );
	}
endif;
if ( valeo_is_active_widget( 'recent-posts-carousel' ) ) {
	add_action( 'wp_enqueue_scripts', 'valeo_recent_posts_carousel_scripts' );
}

if ( ! function_exists( 'valeo_recent_posts_carousel_admin_scripts' ) ) :
	function valeo_recent_posts_carousel_admin_scripts() {
		// Load widget admin stylesheet.
		wp_enqueue_style( 'valeo-recent-posts-carousel-widget-admin', get_template_directory_uri() . '/inc/widgets/widget-recent-posts-carousel/widget-recent-posts-carousel-admin.css' );
	}
endif;
add_action( 'admin_print_styles', 'valeo_recent_posts_carousel_admin_scripts' );