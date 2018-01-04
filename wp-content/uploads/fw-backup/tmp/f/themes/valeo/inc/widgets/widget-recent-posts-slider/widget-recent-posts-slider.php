<?php
/**
 * Recent_Posts_Slider widget class.0
 */
class VALEO_Widget_Recent_Posts_Slider extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'widget_recent_entries_slider', 'description' => esc_html__( "Your site&#8217;s most recent Posts organized in Slider.", 'valeo') );
        parent::__construct('recent-posts-slider', esc_html__('Recent Posts Slider', 'valeo'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries_slider';
    }

    public function widget($args, $instance) {

        $unique_id = uniqid();

        ob_start();

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $category  = isset( $instance['category'] ) ? $instance['category'] : '';

        $show_category = isset( $instance['show_category'] ) ? $instance['show_category'] : false;
        $show_navigation = isset( $instance['show_navigation'] ) ? $instance['show_navigation'] : false;
        $autoplay = isset( $instance['autoplay'] ) ? $instance['autoplay'] : false;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        $thumbnail_args = array(
            'background' => true,
            'print' => true,
            'thumbnail_size' => 'valeo_recent-posts-slider',
            'thumbnail_class' => 'valeo_recent-posts-slider',
            'use_default' => true,
            'is_widget' => true,
        );

        $thumbnail_args_img = array(
            'background' => false,
            'print' => true,
            'no_url' => true,
            'thumbnail_size' => 'valeo_recent-posts-slider',
            'thumbnail_class' => 'valeo_recent-posts-slider',
            'use_default' => true,
            'is_widget' => true,
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
            <div class="posts-slider owl-widget-single<?php echo esc_attr($unique_id)?> owl-slider <?php echo esc_attr($show_navigation); ?>"
                 data-show_category="<?php echo esc_attr( $show_category ) ? 'true' : 'false' ?>"
                 data-show_navigation="<?php echo esc_attr( $show_navigation ) ? 'true' : 'false' ?>"
                 data-autoplay="<?php echo esc_attr( $autoplay ) ? 'true' : 'false' ?>"
                 data-unique_id="<?php echo esc_attr( $unique_id ); ?>">
                <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                    <div class="posts-slider__slide item">
                        <?php
                            $pID = get_the_ID();
                            $category = valeo_get_first_category( $pID );
                        ?>
                        <div class="posts-slider__content">
                            <div class="posts-slider__table">
                                <div class="posts-slider__cell">
                                    <?php if ($show_category) { ?>
                                    <div class="posts-slider__category"><?php echo wp_kses_post($category) ?></div>
                                    <?php } ?>
                                    <div class="posts-slider__title">
                                        <a href="<?php the_permalink() ?>"><?php the_title() ? the_title() : get_the_ID() ?></a>
                                    </div>
                                    <?php if ($show_date) { ?>
                                        <span class="posts-slider__date"><?php echo get_the_date("F d, Y"); ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="posts-slider__image" style="<?php valeo_post_thumbnail($thumbnail_args) ?>">
                            <div class="posts-slider__overlay"></div>
                            <?php valeo_post_thumbnail($thumbnail_args_img) ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php echo wp_kses_post($args['after_widget']); ?>
            <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;

        ob_end_flush();

    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['category'] = $new_instance['category'];
        $instance['show_category'] = isset( $new_instance['show_category'] ) ? (bool) $new_instance['show_category'] : false;
        $instance['show_navigation'] = isset( $new_instance['show_navigation'] ) ? (bool) $new_instance['show_navigation'] : false;
        $instance['autoplay'] = isset( $new_instance['autoplay'] ) ? (bool) $new_instance['autoplay'] : false;
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries_slider']) )
            delete_option('widget_recent_entries_slider');

        return $instance;
    }

    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
        $category  = isset( $instance['category'] ) ? $instance['category'] : '';
        $show_category = isset( $instance['show_category'] ) ? (bool) $instance['show_category'] : false;
        $show_navigation = isset( $instance['show_navigation'] ) ? (bool) $instance['show_navigation'] : false;
        $autoplay = isset( $instance['autoplay'] ) ? (bool) $instance['autoplay'] : false;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'valeo' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_attr_e( 'Number of posts to show:', 'valeo' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo absint( $number ); ?>" size="3" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_category ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_category' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_category' ) ); ?>"><?php esc_html_e( 'Show category?', 'valeo' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_navigation ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_navigation' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_navigation' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_navigation' ) ); ?>"><?php esc_html_e( 'Show navigation?', 'valeo' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $autoplay ); ?> id="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'autoplay' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>"><?php esc_html_e( 'Auto play', 'valeo' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Display post date?', 'valeo' ); ?></label>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id('category') ); ?>"><?php esc_attr_e('Category:', 'valeo');?></label>
            <?php wp_dropdown_categories(array( 'show_option_all' => esc_html__('All Categories', 'valeo'), 'hide_empty'=>0, 'selected'=>$category, 'name'=>$this->get_field_name('category'), 'id'=>$this->get_field_id('category'), 'value_field'=>'slug')); ?>
        </p>

        <?php
    }
}

if ( ! function_exists( 'valeo_recent_posts_slider_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     * Add a comment to this line
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function valeo_recent_posts_slider_setup() {
        if ( ! has_image_size( 'valeo_recent-posts-slider' ) ) {
            add_image_size( 'valeo_recent-posts-slider', 1170, 600, true );
        }
    }
endif; // valeo_recent_posts_slider_setup
add_action( 'after_setup_theme', 'valeo_recent_posts_slider_setup', 20 );

if ( ! function_exists( 'valeo_register_widget_recent_posts_slider' ) ) :
    function valeo_register_widget_recent_posts_slider() {
        register_widget( 'VALEO_Widget_Recent_Posts_Slider' );
    }
endif;
add_action( 'widgets_init', 'valeo_register_widget_recent_posts_slider' );

if ( ! function_exists( 'valeo_recent_posts_slider_scripts' ) ) :
    function valeo_recent_posts_slider_scripts() {
        // Load widget stylesheet.
	    wp_enqueue_style( 'recent-posts-slider-widget', get_template_directory_uri() . '/inc/widgets/widget-recent-posts-slider/widget-recent-posts-slider.css' );

        // Load script for news tabs.
	    wp_enqueue_script( 'recent-posts-slider-widget-js', get_template_directory_uri() . '/inc/widgets/widget-recent-posts-slider/widget-recent-posts-slider.js', array( 'jquery' ), "all", true );

    }
endif;
if( valeo_is_active_widget( 'recent-posts-slider' ) ) {
	add_action( 'wp_enqueue_scripts', 'valeo_recent_posts_slider_scripts' );
}

if ( ! function_exists( 'valeo_recent_posts_slider_admin_scripts' ) ) :
    function valeo_recent_posts_slider_admin_scripts() {
        // Load widget admin stylesheet.
        wp_enqueue_style( 'recent-posts-slider-widget-admin', get_template_directory_uri() . '/inc/widgets/widget-recent-posts-slider/widget-recent-posts-slider-admin.css' );
    }
endif;
add_action( 'admin_print_styles', 'valeo_recent_posts_slider_admin_scripts' );