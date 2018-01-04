<?php
/**
 * Beautiful Posts Banner widget class
 *
 * @since 3.0.0
 */
class VALEO_Working_Hours_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'widget_working_hours', 'description' => esc_html__('Add Working Hours block to your sidebar.', 'valeo') );
        parent::__construct( 'working-hours', esc_html__('Working Hours', 'valeo'), $widget_ops );
        $this->alt_option_name = 'widget_working_hours';
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
	    /** This filter is documented in wp-includes/default-widgets.php */
	    $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

	    for( $i = 0; $i < 7; $i++ ){
		    $line_var = 'line'.$i;
		    ${$line_var} = isset( $instance[$line_var] ) ? $instance[$line_var] : '';
	    }


	    echo wp_kses_post($args['before_widget']);

	    if ( ! empty( $instance['title'] ) ) {
		    echo wp_kses_post($args['before_title'] . $instance['title'] . $args['after_title']);
	    }

	    echo '<div class="working-hours">';
	    $empty = true;
	    for ( $i = 0; $i < 7; $i ++ ) {
		    $line_var = 'line' . $i;
		    if ( ! empty( ${$line_var} ) ) {
			    if ( $empty ) {
				    $empty = false;
				    echo '<ul>';
			    }
			    ?>
			    <li>
				    <div>
				    <?php
				    //echo wp_kses( ${$line_var}, $allowed_html_array = array( 'span' => array(), 'i' => array() ) );
				    echo wp_kses_post( valeo_replace_str( ${$line_var} ) );
				    ?>
				    </div>
			    </li>
			    <?php
		    }
		    if ( $i == 6 && ! $empty ) {
			    echo '</ul>';
		    }
	    }
	    echo '</div><!-- .working-hours -->';

	    echo wp_kses_post($args['after_widget']);
    }

    /**
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
	    $instance['title'] = strip_tags($new_instance['title']);

	    for( $i = 0; $i < 7; $i++ ) {
		    $line_var    = 'line' . $i;
		    $instance[$line_var] = isset( $new_instance[ $line_var ] ) ? $new_instance[ $line_var ] : '';
	    }
        return $instance;
    }

    /**
     * @param array $instance
     */
    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : '';


        ?>
        <div class="nav-menu-widget-form-controls">

            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e( 'Title:', 'valeo' ) ?></label>
                <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr( $title ); ?>"/>
            </p>

	        <?php for( $i = 0; $i < 7; $i++ ){
		        $line_var = 'line'.$i;
		        ${$line_var} = isset( $instance[$line_var] ) ? $instance[$line_var] : '';
		        ?>
		        <p>
			        <label for="<?php echo esc_attr($this->get_field_id( $line_var )); ?>"><?php esc_attr_e( 'Line', 'valeo' ); ?> <?php echo absint( $i + 1 ); ?>:</label>
			        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( $line_var )); ?>" name="<?php echo esc_attr($this->get_field_name( $line_var )); ?>" value="<?php echo esc_attr( ${$line_var} ); ?>"/>
		        </p>
			<?php } ?>
        </div>
        <?php
    }
}

if (!function_exists( 'valeo_register_widget_working_hours')) :
    function valeo_register_widget_working_hours() {
        register_widget('VALEO_Working_Hours_Widget');
    }
endif;
add_action('widgets_init', 'valeo_register_widget_working_hours');

if (!function_exists('valeo_working_hours_scripts')) :
    function valeo_working_hours_scripts() {
        // Load widget stylesheet.
        wp_enqueue_style('valeo-working-hours-widget', get_template_directory_uri() . '/inc/widgets/widget-working-hours/widget-working-hours.css');
    }
endif;
if( valeo_is_active_widget( 'working-hours' ) ) {
	add_action('wp_enqueue_scripts', 'valeo_working_hours_scripts');
}

if (!function_exists('valeo_working_hours_admin_scripts')) :
    function valeo_working_hours_admin_scripts() {
        // Load widget admin stylesheet.
        wp_enqueue_style('valeo-working-hours-widget-admin', get_template_directory_uri() . '/inc/widgets/widget-working-hours/widget-working-hours-admin.css');
    }
endif;
add_action('admin_print_styles', 'valeo_working_hours_admin_scripts');