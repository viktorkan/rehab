<?php
function valeo_in_widget_form($t,$return,$instance){
	$instance = wp_parse_args( (array) $instance, array( 'width' => 'col-md-12') );
	if ( !isset($instance['width']) ) { $instance['width'] = 'col-md-12'; }
    $offset_left = isset( $instance['offset_left'] ) ? (bool) $instance['offset_left'] : false;
    $offset_right = isset( $instance['offset_right'] ) ? (bool) $instance['offset_right'] : false;
    $offset_top = isset( $instance['offset_top'] ) ? (bool) $instance['offset_top'] : false;
	?>
	<div class="widget-options-block">
	<p class="widget-options-title">
		<strong><?php esc_html_e('Widget options:','valeo'); ?></strong>
	</p>
	<p class="widget-options-select">
		<label class="label--block" for="<?php echo esc_attr( $t->get_field_id('width') ); ?>"><?php esc_html_e('Width','valeo') ?></label>
		<select id="<?php echo esc_attr( $t->get_field_id('width') ); ?>" name="<?php echo esc_attr( $t->get_field_name('width') ); ?>">
			<option <?php selected( $instance['width'], 'col-md-12 col-sm-12' ); ?> value="col-md-12 col-sm-12"><?php esc_html_e( '1/1', 'valeo' ) ?></option>
			<option <?php selected( $instance['width'], 'col-md-6 col-sm-12' );  ?> value="col-md-6 col-sm-12"><?php  esc_html_e( '1/2', 'valeo' ) ?></option>
			<option <?php selected( $instance['width'], 'col-md-4 col-sm-6' );   ?> value="col-md-4 col-sm-6"><?php   esc_html_e( '1/3', 'valeo' ) ?></option>
			<option <?php selected( $instance['width'], 'col-md-3 col-sm-6' );   ?> value="col-md-3 col-sm-6"><?php   esc_html_e( '1/4', 'valeo' ) ?></option>
			<option <?php selected( $instance['width'], 'col-md-8 col-sm-12' );  ?> value="col-md-8 col-sm-12"><?php  esc_html_e( '2/3', 'valeo' ) ?></option>
			<option <?php selected( $instance['width'], 'col-md-9 col-sm-12' );  ?> value="col-md-9 col-sm-12"><?php  esc_html_e( '3/4', 'valeo' ) ?></option>
		</select>
	</p>
    <p class="widget-options-checkbox">
	    <input class="checkbox" type="checkbox" <?php checked( $offset_left ); ?> id="<?php echo esc_attr( $t->get_field_id( 'offset_left' ) ); ?>" name="<?php echo esc_attr( $t->get_field_name( 'offset_left' ) ); ?>" />
        <label for="<?php echo esc_attr( $t->get_field_id( 'offset_left' ) ); ?>"><?php esc_html_e( 'Left offset', 'valeo' ); ?></label>
    </p>
	<p class="widget-options-checkbox">
	    <input class="checkbox" type="checkbox" <?php checked( $offset_right ); ?> id="<?php echo esc_attr( $t->get_field_id( 'offset_right' ) ); ?>" name="<?php echo esc_attr( $t->get_field_name( 'offset_right' ) ); ?>" />
        <label for="<?php echo esc_attr( $t->get_field_id( 'offset_right' ) ); ?>"><?php esc_html_e( 'Right offset', 'valeo' ); ?></label>
    </p>
	<p class="widget-options-checkbox">
	    <input class="checkbox" type="checkbox" <?php checked( $offset_top ); ?> id="<?php echo esc_attr( $t->get_field_id( 'offset_top' ) ); ?>" name="<?php echo esc_attr( $t->get_field_name( 'offset_top' ) ); ?>" />
        <label for="<?php echo esc_attr( $t->get_field_id( 'offset_top' ) ); ?>"><?php esc_html_e( 'Top offset', 'valeo' ); ?></label>
    </p>
	</div>

    <?php
	$return = null;
	return array($t,$return,$instance);
}

function valeo_in_widget_form_update($instance, $new_instance, $old_instance){
	$instance['width'] = $new_instance['width'];
	$instance['offset_left'] = $new_instance['offset_left'];
	$instance['offset_right'] = $new_instance['offset_right'];
	$instance['offset_top'] = $new_instance['offset_top'];
	return $instance;
}

function valeo_dynamic_sidebar_params($params){
	global $wp_registered_widgets;
	$widget_id = $params[0]['widget_id'];
	$widget_obj = $wp_registered_widgets[$widget_id];
	$widget_opt = get_option($widget_obj['callback'][0]->option_name);
	$widget_num = $widget_obj['params'][0]['number'];

    if(isset($widget_opt[$widget_num]['width']))
		$width = $widget_opt[$widget_num]['width'];
	else
		$width = 'col-md-12';

    if(isset($widget_opt[$widget_num]['offset_left']))
        if(true == $widget_opt[$widget_num]['offset_left'])
            $left = ' '.'mod-widget-grid--offset-left';
        else
            $left = '';
    else
        $left = '';

    if(isset($widget_opt[$widget_num]['offset_right']))
        if(true == $widget_opt[$widget_num]['offset_right'])
            $right = ' '.'mod-widget-grid--offset-right';
        else
            $right = '';
    else
        $right = '';

    if(isset($widget_opt[$widget_num]['offset_top']))
        if(true == $widget_opt[$widget_num]['width'])
            $top = ' '.'mod-widget-grid--offset-top';
        else
            $top = '';
    else
        $top = '';

	$params[0]['before_widget'] = preg_replace('/class="/', 'class="'.$width.$left.$right.$top.' ',  $params[0]['before_widget'], 1);
	return $params;
}

//Add input fields(priority 5, 3 parameters)
add_action('in_widget_form', 'valeo_in_widget_form',5,3);
//Callback function for options update (priority 5, 3 parameters)
add_filter('widget_update_callback', 'valeo_in_widget_form_update',5,3);
//add class names (default priority, one parameter)
add_filter('dynamic_sidebar_params', 'valeo_dynamic_sidebar_params');


if ( ! function_exists( 'valeo_widget_grid_enqueue' ) ) :
// Add the JS
	function valeo_widget_grid_enqueue() {
		wp_enqueue_style( 'valeo-widget-grid', get_template_directory_uri() . '/inc/mods/mod-widget-grid/mod-widget-grid.css' );
	}
endif;
add_action( 'wp_enqueue_scripts', 'valeo_widget_grid_enqueue' );