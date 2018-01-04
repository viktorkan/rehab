<?php
/**
 * Navigation Menu widget class
 *
 * @since 3.0.0
 */
class VALEO_Nav_Menu_Widget extends WP_Nav_Menu_Widget {

	public function __construct() {
		$widget_ops = array( 'description' => esc_html__('Add a custom menu to your sidebar.', 'valeo') );
		parent::__construct( 'valeo_nav_menu', esc_html__('Custom Menu', 'valeo'), $widget_ops );
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// Get menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		if ( !$nav_menu )
			return;

		$social_icons = isset( $instance['social_icons'] ) ? $instance['social_icons'] : false;

		/** This filter is documented in wp-includes/default-widgets.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo wp_kses_post($args['before_widget']);

		if ( !empty($instance['title']) )
			echo wp_kses_post($args['before_title'] . $instance['title'] . $args['after_title']);

		$nav_menu_args = array(
			'fallback_cb' => '',
			'menu'        => $nav_menu,
			'menu_class'  => $social_icons ? 'social-navigation' : 'menu',
			'link_before' => $social_icons ? '<span class="screen-reader-text">' : '',
			'link_after'  => $social_icons ? '</span>' : ''
		);

		/**
		 * Filter the arguments for the Custom Menu widget.
		 *
		 * @since 4.2.0
		 *
		 * @param array    $nav_menu_args {
		 *     An array of arguments passed to wp_nav_menu() to retrieve a custom menu.
		 *
		 *     @type callback|bool $fallback_cb Callback to fire if the menu doesn't exist. Default empty.
		 *     @type mixed         $menu        Menu ID, slug, or name.
		 * }
		 * @param stdClass $nav_menu      Nav menu object for the current menu.
		 * @param array    $args          Display arguments for the current widget.
		 */
		wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args ) );

		echo wp_kses_post($args['after_widget']);
	}

	/**
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		}
		if ( ! empty( $new_instance['nav_menu'] ) ) {
			$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		}
		$instance['social_icons'] = isset( $new_instance['social_icons'] ) ? (bool) $new_instance['social_icons'] : false;
		return $instance;
	}

	/**
	 * @param array $instance
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
		$social_icons = isset( $instance['social_icons'] ) ? (bool) $instance['social_icons'] : false;

		// Get menus
		$menus = wp_get_nav_menus();

		// If no menus exists, direct the user to go and create some.
		?>
		<p class="nav-menu-widget-no-menus-message" <?php if ( ! empty( $menus ) ) { echo ' style="display:none" '; } ?>>
			<?php
			if ( isset( $GLOBALS['wp_customize'] ) && $GLOBALS['wp_customize'] instanceof WP_Customize_Manager ) {
				$url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
			} else {
				$url = admin_url( 'nav-menus.php' );
			}
			?>
			<?php echo sprintf( wp_kses( __( 'No menus have been created yet. <a href="%s">Create some</a>.', 'valeo' ), esc_attr( $url ) ), $allowed_html_array = array(
				'a' => array( // on allow a tags
					'href' => array() // and those anchors can only have href attribute
				)
			)); ?>
		</p>
		<div class="nav-menu-widget-form-controls" <?php if ( empty( $menus ) ) { echo ' style="display:none" '; } ?>>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'valeo' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'nav_menu' )); ?>"><?php esc_html_e( 'Select Menu:', 'valeo' ); ?></label>
				<select id="<?php echo esc_attr($this->get_field_id( 'nav_menu' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'nav_menu' )); ?>">
					<option value="0"><?php esc_html_e( '&mdash; Select &mdash;', 'valeo' ); ?></option>
					<?php foreach ( $menus as $menu ) : ?>
						<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $nav_menu, $menu->term_id ); ?>>
							<?php echo esc_html( $menu->name ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</p>
			<p><input class="checkbox" type="checkbox" <?php checked( $social_icons ); ?> id="<?php echo esc_attr( $this->get_field_id( 'social_icons' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_icons' ) ); ?>" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'social_icons' ) ); ?>"><?php esc_html_e( 'Use Social Icons', 'valeo' ); ?></label></p>
		</div>
		<?php
	}
}

if ( ! function_exists( 'valeo_register_widget_custom_menu' ) ) :
	function valeo_register_widget_custom_menu() {
        if ( ! is_active_widget( false, false, 'monster' ) ) {
            unregister_widget( 'WP_Nav_Menu_Widget' );
        }
		register_widget( 'VALEO_Nav_Menu_Widget' );
	}
endif;
add_action( 'widgets_init', 'valeo_register_widget_custom_menu' );