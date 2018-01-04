<?php
/**
 * Recent_Posts_Carousel widget class.0
 */
class VALEO_Widget_Team_Members_Carousel extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_team_members_carousel', 'description' => esc_html__( "Your site&#8217;s team members organized in Slider.", 'valeo') );
		parent::__construct('team-members-carousel', esc_html__('Team Members Carousel', 'valeo'), $widget_ops);
		$this->alt_option_name = 'widget_team_members_carousel';
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
		$show_navigation = isset( $instance['show_navigation'] ) ? $instance['show_navigation'] : false;
		$autoplay = isset( $instance['autoplay'] ) ? $instance['autoplay'] : false;

		$thumbnail_args = array(
			'thumbnail_size' => 'valeo_top-news-3-3',
			'thumbnail_class' => 'valeo_top-news-3-3',
			'use_default' => true,
			'is_widget' => true,
			'no_url' => true,
		);

//		$cat_exclude = '';
//		$main_slider_cat = valeo_get_main_slider_category();
//		if ( $main_slider_cat['id'] ) {
//			$cat_exclude = -$main_slider_cat['id'];
//		}

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
//		$r = new WP_Query(
//			apply_filters( 'widget_posts_args', array(
//					'posts_per_page'      => $number,
//					'no_found_rows'       => true,
//					'post_status'         => 'publish',
//					'category_name'       => $category,
//					'ignore_sticky_posts' => true,
//					'cat'                 => $cat_exclude
//				)
//			)
//		);
		$r = new WP_Query(
			array(
				'post_type' => 'team_member',
				'posts_per_page'      => $number,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'category_name'       => $category,
//				'ignore_sticky_posts' => true,
//				'cat'                 => $cat_exclude
			)
		);

		if ($r->have_posts()) :
			?>
			<?php echo wp_kses_post($args['before_widget']); ?>
			<?php if ( $title ) {
			echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
		} ?>

			<?php if ( function_exists( 'cct_get_member_meta' ) ) : ?>

			<div class="owl-team-members-carousel owl-team-members-carousel<?php echo esc_attr($unique_id)?> owl-carousel tm-carousel tm-show-description <?php echo esc_attr($show_navigation); ?>"
			     data-show_navigation="<?php echo esc_attr( $show_navigation ) ? 'true' : 'false' ?>"
			     data-autoplay="<?php echo esc_attr( $autoplay ) ? 'true' : 'false' ?>"
			     data-unique_id="<?php echo esc_attr( $unique_id ); ?>">
			<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<?php

				$pID = get_the_ID();

				$before = '';
				$after = '';
				$address = cct_get_member_meta( $pID, 'address' );
				$phone = cct_get_member_meta( $pID, 'phone' );
				$email = cct_get_member_meta( $pID, 'email' );

				$facebook = cct_get_member_meta( $pID, 'facebook' );
				$facebook_formatted = cct_get_member_facebook( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
				$twitter = cct_get_member_meta( $pID, 'twitter' );
				$twitter_formatted = cct_get_member_twitter( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
				$googleplus = cct_get_member_meta( $pID, 'googleplus' );
				$googleplus_formatted = cct_get_member_googleplus( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
				$linkedin = cct_get_member_meta( $pID, 'linkedin' );
				$linkedin_formatted = cct_get_member_linkedin( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
				$pinterest = cct_get_member_meta( $pID, 'pinterest' );
				$pinterest_formatted = cct_get_member_pinterest( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
				$instagram = cct_get_member_meta( $pID, 'instagram' );
				$instagram_formatted = cct_get_member_instagram( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );

				$member_position = cct_get_member_meta( $pID, 'position' );

				$member_contacts = ( !empty($address) ) ? '<li class="member-address"><i class="rt-icon icon-location-outline"></i>' . esc_html($address) . '</li>' : '';
				$member_contacts .= ( !empty($phone) ) ? '<li class="member-phone"><i class="rt-icon icon-device-tablet"></i>' . esc_html($phone) . '</li>' : '';
				$member_contacts .= ( !empty($email) ) ? '<li class="member-email"><i class="rt-icon icon-mail2"></i>' . esc_html($email) . '</li>' : '';

				$member_social = ( !empty($facebook) ) ? '<li class="member-facebook">' . $facebook_formatted . '</li>' : '';
				$member_social .= ( !empty($twitter) ) ? '<li class="member-twitter">' . $twitter_formatted . '</li>' : '';
				$member_social .= ( !empty($googleplus) ) ? '<li class="member-googleplus">' . $googleplus_formatted . '</li>' : '';
				$member_social .= ( !empty($linkedin) ) ? '<li class="member-linkedin">' . $linkedin_formatted . '</li>' : '';
				$member_social .= ( !empty($pinterest) ) ? '<li class="member-pinterest">' . $pinterest_formatted . '</li>' : '';
				$member_social .= ( !empty($instagram) ) ? '<li class="member-instagram">' . $instagram_formatted . '</li>' : '';

				?>
				<div class="item">
					<div class="tm-carousel__image"><?php valeo_post_thumbnail($thumbnail_args) ?></div>
					<div class="tm-carousel__content">
						<div class="member-info">
							<h2 class="tm-carousel__title"><a href="<?php the_permalink(); ?>"><?php

									$name = get_the_title();
									$name = preg_replace('/([^ ]+) ([^ ]+)/', '\1 <br />\2', $name, 1);
									echo wp_kses( $name, valeo_kses_init() );
									//get_the_title() ? the_title() : the_ID();
									?></a></h2>
							<?php //the_title('<h3 class="member-title">','</h3>'); ?>
							<?php echo ( ! empty( $member_position ) ) ? '<p class="member-position">' . esc_html( $member_position ) . '</p>' : ''; ?>
							<?php if ( ! empty( $member_contacts ) || ! empty( $member_social ) ) { ?>
								<hr>
							<?php } ?>
							<?php echo ( ! empty( $member_contacts ) ) ? '<ul class="member-contacts">' . $member_contacts . '</ul>' : ''; ?>
							<?php echo ( ! empty( $member_social ) ) ? '<ul class="member-social social-navigation">' . $member_social . '</ul>' : '' ?>
						</div>
					</div>
				</div><!-- .item -->
			<?php endwhile; ?>
			</div>

			<?php endif; ?>

			<?php echo wp_kses_post($args['after_widget']); ?>
			<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_team_members_carousel', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['category'] = $new_instance['category'];
		$instance['show_navigation'] = isset( $new_instance['show_navigation'] ) ? (bool) $new_instance['show_navigation'] : false;
		$instance['autoplay'] = isset( $new_instance['autoplay'] ) ? (bool) $new_instance['autoplay'] : false;

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_team_members_carousel']) )
			delete_option('widget_team_members_carousel');

		return $instance;
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$category  = isset( $instance['category'] ) ? $instance['category'] : '';
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
<!--		<p><label for="--><?php //echo esc_attr( $this->get_field_id('category') ); ?><!--">--><?php //echo wp_kses(__('Category<br><i>posts category</i>', 'valeo'), $allowed_html_array = array( 'br' => array(), 'i' => array() ) ); ?><!--</label>-->
			<?php
			//$categories = get_categories( array( 'type' => 'services_article', 'orderby' => 'name', 'taxonomy' => 'services_category' ) );
//			wp_dropdown_categories( array(
//				'show_option_all' => esc_html__( 'All Categories', 'valeo' ),
//				'hide_empty'      => 0,
//				'selected'        => $category,
//				'name'            => $this->get_field_name( 'category' ),
//				'id'              => $this->get_field_id( 'category' ),
//				'value_field'     => 'slug'
//			) );
			?>
<!--		</p>-->

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

if ( ! function_exists( 'valeo_team_members_carousel_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function valeo_team_members_carousel_setup() {
		if(!has_image_size('valeo_top-news-3-2')){
			add_image_size('valeo_top-news-3-2', 640, 427, true);
		}
		if(!has_image_size('valeo_top-news-3-3')){
			add_image_size('valeo_top-news-3-3', 640, 640, true);
		}
	}
endif; // valeo_top_news_setup
add_action( 'after_setup_theme', 'valeo_team_members_carousel_setup', 20 );

if ( ! function_exists( 'valeo_register_widget_team_members_carousel' ) ) :
	function valeo_register_widget_team_members_carousel() {
		register_widget( 'VALEO_Widget_Team_Members_Carousel' );
	}
endif;
add_action( 'widgets_init', 'valeo_register_widget_team_members_carousel' );

if ( ! function_exists( 'valeo_team_members_carousel_scripts' ) ) :
	function valeo_team_members_carousel_scripts() {
		// Load widget stylesheet.
		wp_enqueue_style( 'valeo-team-members-carousel-widget', get_template_directory_uri() . '/inc/widgets/widget-team-members-carousel/widget-team-members-carousel.css' );

		if ( is_rtl() ) {
			wp_enqueue_style( 'valeo-team-members-carousel-widget-rtl', get_template_directory_uri() . '/inc/widgets/widget-team-members-carousel/widget-team-members-carousel-rtl.css' );
		}
		// Load script for carousel.
		wp_enqueue_script( 'valeo-team-members-carousel-widget-js', get_template_directory_uri() . '/inc/widgets/widget-team-members-carousel/widget-team-members-carousel.js', array( 'jquery' ), "all", true );
	}
endif;
if ( valeo_is_active_widget( 'team-members-carousel' ) ) {
	add_action( 'wp_enqueue_scripts', 'valeo_team_members_carousel_scripts' );
}

if ( ! function_exists( 'valeo_team_members_carousel_admin_scripts' ) ) :
	function valeo_team_members_carousel_admin_scripts() {
		// Load widget admin stylesheet.
		wp_enqueue_style( 'valeo-team-members-carousel-widget-admin', get_template_directory_uri() . '/inc/widgets/widget-team-members-carousel/widget-team-members-carousel-admin.css' );
	}
endif;
add_action( 'admin_print_styles', 'valeo_team_members_carousel_admin_scripts' );