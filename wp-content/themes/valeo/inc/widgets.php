<?php
$widgets = valeo_scan_for_mods( VALEO_DIR . 'inc/widgets/' );
foreach ( $widgets as $widget ) {
	include_once( get_template_directory() . '/inc/widgets/' . $widget );
}

if ( !function_exists('valeo_get_main_slider_category') ) :
function valeo_get_main_slider_category() {
	$category = array('id'=>0,'slug'=>'','count'=>0,'name'=>'');
	if ( is_admin() ) { 
		$category['id'] = wp_create_category( 'Main Slider' );
	}

	if ( $cat = get_term_by( 'slug', 'main-slider', 'category' ) ) {
		$category['id'] = $cat->term_id;
		$category['count'] = $cat->count;
		$category['name'] = $cat->name;
		$category['slug'] = 'main-slider';
	}
	
	return $category;
}
endif;

if ( !function_exists('valeo_main_slider_active') ) :
	function valeo_main_slider_active() {
		global $sidebars_widgets;
		if ( ! empty( $sidebars_widgets['sidebar-before-header'][0] ) ) {
			if (preg_match('/^valeo-main-slider/',$sidebars_widgets['sidebar-before-header'][0])){
				return true;
			}
		}
		return false;
	}
endif;