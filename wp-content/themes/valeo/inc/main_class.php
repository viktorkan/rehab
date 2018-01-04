<?php

class VALEO_Main_Class
{
	public $path = '';
	public $url = '';
	public $inc = '';
	public $inc_url = '';
	
	
	function __construct()
	{
		$this->path = get_template_directory().'/';
		$this->url = get_template_directory_uri().'/';
		$this->inc = $this->path.'inc/';
		$this->inc_url = $this->url.'inc/';
	}
	
	function __set_attrib( $attr = array() )
	{
		$res = ' ';
		foreach( $attr as $k => $v )
		{
			$res .= $k.'="'.$v.'" ';
		}
		
		return $res;
	}
	
	function option( $key = '' )
	{
		$theme_options = get_option( 'valeo' . '_theme_options' );
		
		if( $key ) return valeo_set( $theme_options, $key );
		
		return $theme_options;
	}
	
	function includes( $path = '' )
	{
		$child = get_stylesheet_directory().'/';
		if( file_exists( $child.$path ) ) return $child.$path;
		
		return $this->path.$path;
	}
	
	function get_meta( $id = '', $key = '' )
	{
		global $post, $post_type;
		$id = ( $id ) ? $id : valeo_set( $post, 'ID' );
		$key = ( $key ) ? $key : '_valeo_'.$post_type.'_settings';
		
		$meta = get_post_meta( $id, $key, true );
		
		return ( $meta ) ? $meta : false;
	}
	
	function set_meta_key( $post_type )
	{
		if( ! $post_type ) return;
		
		return '_valeo_'.$post_type.'_settings';
		
	}
	
	function get_term_meta( $id = '', $key = '' )
	{
		global $post, $post_type;
		$id = ( $id ) ? $id : valeo_set( $post, 'ID' );
		$key = ( $key ) ? $key : '_valeo_'.$post_type.'_settings';
		
		$meta = get_post_meta( $id, $key, true );
		
		return ( $meta ) ? $meta : false;
	}
	
	function set_term_key( $post_type )
	{
		if( ! $post_type ) return;
		
		return '_valeo_'.$post_type.'_settings';
		
	}
	
	function page_template( $tpl )
	{
		$page = get_pages(array('meta_key' => '_wp_page_template','meta_value' => $tpl));
		if($page) return current( (array)$page);
		else return false;
	}
	
	function user_extra( $extras = array() )
	{
		$this->extras = $extras;
		
		add_filter('user_contactmethods', array( $this, 'newuserfilter' ) );

		
	}

	function newuserfilter($old)
	{
		$array = $this->extras;
		
		$new = array_merge($array, $old);
		return $new;
	}

}

$GLOBALS['valeo_base'] = new VALEO_Main_Class;





