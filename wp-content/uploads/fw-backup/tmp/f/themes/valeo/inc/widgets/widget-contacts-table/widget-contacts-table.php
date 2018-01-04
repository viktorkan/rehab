<?php
/**
 * Contacts table widget class
 *
 * @since 3.0.0
 */
class VALEO_Contacts_table_Widget extends WP_Widget {

	private $array_icon_class = array(
		'at',
		'group',
		'home-outline',
		'location-outline',
		'link-outline',
		'cross',
		'star-outline',
		'mail2',
		'heart-outline',
		'flash-outline',
		'watch',
		'time2',
		'map2',
		'key-outline',
		'globe-outline',
		'eye-outline',
		'pin-outline',
		'pencil3',
		'thumbs-up',
		'compass3',
		'device-tablet',
		'device-phone',
		'device-laptop',
		'flag-outline',
		'contacts',
		'coffee3',
		'shopping-cart'
	);

	public function __construct() {
        $widget_ops = array( 'classname' => 'widget_contacts_table', 'description' => esc_html__('Add contacts table to your site.', 'valeo') );
        parent::__construct( 'contacts-table', esc_html__('Contacts Table', 'valeo'), $widget_ops );
        $this->alt_option_name = 'widget_contacts_table';
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {

        /** This filter is documented in wp-includes/default-widgets.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$title_1 = ( ! empty( $instance['title_1'] ) ) ? $instance['title_1'] : '';
		$icon_class_1 = ( ! empty( $instance['icon_class_1'] ) ) ? $instance['icon_class_1'] : $this->array_icon_class[0];
		$text_1 = ( ! empty( $instance['text_1'] ) ) ? $instance['text_1'] : '';

		$title_2 = ( ! empty( $instance['title_2'] ) ) ? $instance['title_2'] : '';
		$icon_class_2 = ( ! empty( $instance['icon_class_2'] ) ) ? $instance['icon_class_2'] : $this->array_icon_class[0];
        $text_2 = ( ! empty( $instance['text_2'] ) ) ? $instance['text_2'] : '';

		$title_3 = ( ! empty( $instance['title_3'] ) ) ? $instance['title_3'] : '';
		$icon_class_3 = ( ! empty( $instance['icon_class_3'] ) ) ? $instance['icon_class_3'] : $this->array_icon_class[0];
		$text_3 = ( ! empty( $instance['text_3'] ) ) ? $instance['text_3'] : '';

		$title_4 = ( ! empty( $instance['title_4'] ) ) ? $instance['title_4'] : '';
		$icon_class_4 = ( ! empty( $instance['icon_class_4'] ) ) ? $instance['icon_class_4'] : '';
		$text_4 = ( ! empty( $instance['text_4'] ) ) ? $instance['text_4'] : '';

        //if( !$title_1 && !$title_2 && !$title_3 )
            //return;

        $contacts_item_array = array();
        if( $icon_class_1 && ( $title_1 || $text_1 ) ) {
            $contacts_item_array[0]['icon-class'] = $icon_class_1;
            $contacts_item_array[0]['title'] = $title_1;
            $contacts_item_array[0]['text'] = $text_1;
        }
		if( $icon_class_2 && ( $title_2 || $text_2 ) ) {
            $contacts_item_array[1]['icon-class'] = $icon_class_2;
            $contacts_item_array[1]['title'] = $title_2;
            $contacts_item_array[1]['text'] = $text_2;
        }
		if( $icon_class_3 && ( $title_3 || $text_3 ) ) {
            $contacts_item_array[2]['icon-class'] = $icon_class_3;
            $contacts_item_array[2]['title'] = $title_3;
            $contacts_item_array[2]['text'] = $text_3;
        }
        if( $icon_class_4 && ( $title_4 || $text_4 ) ) {
            $contacts_item_array[3]['icon-class'] = $icon_class_4;
            $contacts_item_array[3]['title'] = $title_4;
            $contacts_item_array[3]['text'] = $text_4;
        }

	    $btn_text = ( ! empty( $instance['btn_text'] ) ) ? $instance['btn_text'] : '';
	    $btn_link = ( ! empty( $instance['btn_link'] ) ) ? $instance['btn_link'] : '';


        echo wp_kses_post($args['before_widget']);

        if ( !empty($instance['title']) )
            echo wp_kses_post($args['before_title'] . $instance['title'] . $args['after_title']);

	    if ( ! empty( $contacts_item_array ) || ! empty( $btn_text ) ) : ?>

            <ul class="widget-contacts-table"><?php
                if ( ! empty( $contacts_item_array ) ) :
				    foreach ( $contacts_item_array as $contact_item ) : ?>
                        <li>
                            <p class="item-title"><span class="rt-icon icon-<?php echo esc_attr( $contact_item['icon-class'] ) ?>"></span><?php echo esc_html( $contact_item['title'] ) ?></p>
                            <p class="item-content"><?php echo esc_html( $contact_item['text'] ) ?></p>
                        </li><?php
                    endforeach;
                endif;
			    if ( ! empty( $btn_text ) ) : ?>
                    <li class="item-button">
                        <a href="<?php echo esc_url( $btn_link ); ?>">
						<span>
							<span>
								<?php echo esc_attr( $btn_text ); ?>
							</span>
						</span>
                        </a>
                    </li><?php
			    endif; ?>
            </ul>

	    <?php endif; ?>

        <?php  echo wp_kses_post($args['after_widget']);
    }

    /**
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = trim(strip_tags($new_instance['title']));

		$instance['title_1'] = trim(strip_tags($new_instance['title_1']));
		$instance['title_2'] = trim(strip_tags($new_instance['title_2']));
		$instance['title_3'] = trim(strip_tags($new_instance['title_3']));
		$instance['title_4'] = trim(strip_tags($new_instance['title_4']));

		$instance['icon_class_1'] = esc_attr($new_instance['icon_class_1']);
		$instance['icon_class_2'] = esc_attr($new_instance['icon_class_2']);
		$instance['icon_class_3'] = esc_attr($new_instance['icon_class_3']);
		$instance['icon_class_4'] = esc_attr($new_instance['icon_class_4']);

		$instance['text_1'] = trim(strip_tags($new_instance['text_1']));
		$instance['text_2'] = trim(strip_tags($new_instance['text_2']));
		$instance['text_3'] = trim(strip_tags($new_instance['text_3']));
		$instance['text_4'] = trim(strip_tags($new_instance['text_4']));

	    $instance['btn_text'] = trim(strip_tags($new_instance['btn_text']));
	    $instance['btn_link'] = trim(strip_tags($new_instance['btn_link']));

        return $instance;
    }

    /**
     * @param array $instance
     */
    public function form( $instance ) {

			$title = isset( $instance['title'] ) ? $instance['title'] : '';

			$title_1 = isset($instance['title_1']) ? $instance['title_1'] : '';
			$title_2 = isset($instance['title_2']) ? $instance['title_2'] : '';
			$title_3 = isset($instance['title_3']) ? $instance['title_3'] : '';
			$title_4 = isset($instance['title_4']) ? $instance['title_4'] : '';

			$icon_class_1 = isset($instance['icon_class_1']) ? $instance['icon_class_1'] : $this->array_icon_class[0];
			$icon_class_2 = isset($instance['icon_class_2']) ? $instance['icon_class_2'] : $this->array_icon_class[0];
			$icon_class_3 = isset($instance['icon_class_3']) ? $instance['icon_class_3'] : $this->array_icon_class[0];
			$icon_class_4 = isset($instance['icon_class_4']) ? $instance['icon_class_4'] : $this->array_icon_class[0];

			$text_1 = isset($instance['text_1']) ? $instance['text_1'] : '';
			$text_2 = isset($instance['text_2']) ? $instance['text_2'] : '';
			$text_3 = isset($instance['text_3']) ? $instance['text_3'] : '';
			$text_4 = isset($instance['text_4']) ? $instance['text_4'] : '';

	        $btn_text = isset($instance['btn_text']) ? $instance['btn_text'] : '';
	        $btn_link = isset($instance['btn_link']) ? $instance['btn_link'] : '';

        ?>
        <div class="contact-table">
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'valeo' ) ?></label>
                <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr( $title ); ?>"/>
            </p>
			<div class="select-icon">
				<legend><?php esc_html_e( 'Set icon for 1st item:', 'valeo' ); ?></legend>
				<?php foreach($this->array_icon_class as $icon_class) : ?>
					<?php $is_checked = ($icon_class == $icon_class_1) ? true : false; ?>
					<input id="<?php echo esc_attr( $this->get_field_id( 'icon_class_1_'.$icon_class ) ); ?>"
						   name="<?php echo esc_attr( $this->get_field_name( 'icon_class_1' ) ); ?>"
						   type="radio" <?php checked( $is_checked ); ?>
						   value="<?php echo esc_attr($icon_class); ?>"/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'icon_class_1_'.$icon_class ) ); ?>"><i class="rt-icon icon-<?php echo esc_attr($icon_class); ?>"></i></label>
				<?php endforeach; ?>
			</div>
            <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title_1' ) ); ?>"><?php esc_html_e( '1st Item Title: ', 'valeo' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'title_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_1' ) ); ?>" type="text" value="<?php echo esc_attr( $title_1 ); ?>" size="36" />
			</p>
			<p>
                <label for="<?php echo esc_attr($this->get_field_name( 'text_1' )); ?>"><?php esc_html_e( '1st Item Text:', 'valeo' ); ?></label><br>
                <textarea name="<?php echo esc_attr($this->get_field_name( 'text_1' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'text_1' )); ?>" ><?php echo esc_attr( $text_1 ); ?></textarea>
			</p><hr>

			<div class="select-icon">
				<legend><?php esc_html_e( 'Set icon for 2st item:', 'valeo' ); ?></legend>
				<?php foreach($this->array_icon_class as $icon_class) : ?>
					<?php $is_checked = ($icon_class == $icon_class_2) ? true : false; ?>
					<input id="<?php echo esc_attr( $this->get_field_id( 'icon_class_2_'.$icon_class ) ); ?>"
						   name="<?php echo esc_attr( $this->get_field_name( 'icon_class_2' ) ); ?>"
						   type="radio" <?php checked( $is_checked ); ?>
						   value="<?php echo esc_attr($icon_class); ?>"/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'icon_class_2_'.$icon_class ) ); ?>"><i class="rt-icon icon-<?php echo esc_attr($icon_class); ?>"></i></label>
				<?php endforeach; ?>
			</div>
            <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title_2' ) ); ?>"><?php esc_html_e( '2st Item Title: ', 'valeo' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'title_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_2' ) ); ?>" type="text" value="<?php echo esc_attr( $title_2 ); ?>" size="36" />
			</p>
			<p>
                <label for="<?php echo esc_attr($this->get_field_name( 'text_2' )); ?>"><?php esc_html_e( '2st Item Text:', 'valeo' ); ?></label><br>
                <textarea name="<?php echo esc_attr($this->get_field_name( 'text_2' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'text_2' )); ?>"><?php echo esc_attr( $text_2 ); ?></textarea>
			</p><hr>

			<div class="select-icon">
				<legend><?php esc_html_e( 'Set icon for 3st item:', 'valeo' ); ?></legend>
				<?php foreach($this->array_icon_class as $icon_class) : ?>
					<?php $is_checked = ($icon_class == $icon_class_3) ? true : false; ?>
					<input id="<?php echo esc_attr( $this->get_field_id( 'icon_class_3_'.$icon_class ) ); ?>"
						   name="<?php echo esc_attr( $this->get_field_name( 'icon_class_3' ) ); ?>"
						   type="radio" <?php checked( $is_checked ); ?>
						   value="<?php echo esc_attr($icon_class); ?>"/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'icon_class_3_'.$icon_class ) ); ?>"><i class="rt-icon icon-<?php echo esc_attr($icon_class); ?>"></i></label>
				<?php endforeach; ?>
			</div>
            <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'tittle_3' ) ); ?>"><?php esc_html_e( '3st Item Title: ', 'valeo' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'tittle_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_3' ) ); ?>" type="text" value="<?php echo esc_attr( $title_3 ); ?>" size="36" />
			</p>
			<p>
                <label for="<?php echo esc_attr($this->get_field_name( 'text_3' )); ?>"><?php esc_html_e( '3st Item Text:', 'valeo' ); ?></label><br>
                <textarea name="<?php echo esc_attr($this->get_field_name( 'text_3' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'text_3' )); ?>"><?php echo esc_attr( $text_3 ); ?></textarea>
			</p><hr>

			<div class="select-icon">
				<legend><?php esc_html_e( 'Set icon for 4st item:', 'valeo' ); ?></legend>
				<?php foreach($this->array_icon_class as $icon_class) : ?>
					<?php $is_checked = ($icon_class == $icon_class_4) ? true : false; ?>
					<input id="<?php echo esc_attr( $this->get_field_id( 'icon_class_4_'.$icon_class ) ); ?>"
						   name="<?php echo esc_attr( $this->get_field_name( 'icon_class_4' ) ); ?>"
						   type="radio" <?php checked( $is_checked ); ?>
						   value="<?php echo esc_attr($icon_class); ?>"/>
					<label for="<?php echo esc_attr( $this->get_field_id( 'icon_class_4_'.$icon_class ) ); ?>"><i class="rt-icon icon-<?php echo esc_attr($icon_class); ?>"></i></label>
				<?php endforeach; ?>
			</div>
            <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'tittle_4' ) ); ?>"><?php esc_html_e( '4st Item Title: ', 'valeo' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'tittle_4' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_4' ) ); ?>" type="text" value="<?php echo esc_attr( $title_4 ); ?>" size="36" />
			</p>
			<p>
                <label for="<?php echo esc_attr($this->get_field_name( 'text_4' )); ?>"><?php esc_html_e( '4st Item Text:', 'valeo' ); ?></label><br>
                <textarea name="<?php echo esc_attr($this->get_field_name( 'text_4' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'text_4' )); ?>"><?php echo esc_attr( $text_4 ); ?></textarea>
			</p>

	        <p>
		        <label for="<?php echo esc_attr( $this->get_field_id( 'btn_text' ) ); ?>"><?php esc_html_e( 'Button Text: ', 'valeo' ); ?></label>
		        <input id="<?php echo esc_attr( $this->get_field_id( 'btn_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'btn_text' ) ); ?>" type="text" value="<?php echo esc_attr( $btn_text); ?>" size="36" />
	        </p>
	        <p>
		        <label for="<?php echo esc_attr( $this->get_field_id( 'btn_link' ) ); ?>"><?php esc_html_e( 'Button Link: ', 'valeo' ); ?></label>
		        <input id="<?php echo esc_attr( $this->get_field_id( 'btn_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'btn_link' ) ); ?>" type="text" value="<?php echo esc_attr( $btn_link ); ?>" size="36" />
	        </p>

        </div>
        <?php
    }
}

if (!function_exists( 'valeo_register_widget_contacts_table')) :
    function valeo_register_widget_contacts_table() {
        register_widget('VALEO_Contacts_Table_Widget');
    }
endif;
add_action('widgets_init', 'valeo_register_widget_contacts_table');

if (!function_exists('valeo_contacts_table_scripts')) :
    function valeo_contacts_table_scripts() {
        // Load widget stylesheet.
	    wp_enqueue_style( 'valeo-contacts-table-widget', get_template_directory_uri() . '/inc/widgets/widget-contacts-table/widget-contacts-table.css' );
	    if ( is_rtl() ) {
		    wp_enqueue_style( 'valeo-table-widget-rtl', get_template_directory_uri() . '/inc/widgets/widget-contacts-table/widget-contacts-table-rtl.css' );
	    }
	    // Add icomoon icon font stylesheet. (rt-icons-4)
		wp_enqueue_style( 'valeo-icomoon', get_template_directory_uri() . '/vendors/icomoon/style.css', array(), '2' );
    }
endif;

if( is_active_widget( false, false, 'contacts-table' ) ) {
	add_action( 'wp_enqueue_scripts', 'valeo_contacts_table_scripts' );
}

if (!function_exists('valeo_contacts_table_admin_scripts')) :
    function valeo_contacts_table_admin_scripts() {
        // Load widget admin stylesheet.
        wp_enqueue_style( 'valeo-contacts-table-widget-admin', get_template_directory_uri() . '/inc/widgets/widget-contacts-table/widget-contacts-table-admin.css' );
	    // Add icomoon icon font stylesheet. (rt-icons-4)
		wp_enqueue_style( 'valeo-icomoon', get_template_directory_uri() . '/vendors/icomoon/style.css', array(), '2' );
    }
endif;
add_action('admin_print_styles', 'valeo_contacts_table_admin_scripts');