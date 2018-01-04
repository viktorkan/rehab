<?php

require get_template_directory() . '/inc/main_class.php';

if ( ! function_exists( 'valeo_set' ) ) :
function valeo_set( $var, $key, $def = '' )
{

    if( is_object( $var ) && isset( $var->$key ) ) return $var->$key;
    elseif( is_array( $var ) && isset( $var[$key] ) ) return $var[$key];
    elseif( $def ) return $def;
    else return false;
}
endif;

if ( ! function_exists( 'valeo_printr' ) ) :
function valeo_printr($data)
{
    echo '<pre>'; print_r($data);exit;
}
endif;

if ( ! function_exists( 'valeo_font_awesome' ) ) :
function valeo_font_awesome( $index )
{
	$array = array_values($GLOBALS['valeo_font_awesome']);
	if( $font = valeo_set($array, $index )) return $font;
	else return false;
}
endif;

if ( ! function_exists( 'valeo_load_class' ) ) :
function valeo_load_class($class, $directory = 'inc', $global = true, $prefix = 'valeo_')
{
    $obj = &$GLOBALS['valeo_base'];
    $obj = is_object( $obj ) ? $obj : new stdClass;

    $name = FALSE;

    // Is the request a class extension?  If so we load it too
	$path = get_template_directory() . '/' . $directory . '/' . $class . '.php';
    if( file_exists($path) )
    {
        $name = $prefix.ucwords( $class );

        if (class_exists($name) === FALSE)	require $path;
    }

    // Did we find the class?
    if ($name === FALSE) exit('Unable to locate the specified class: '.$class.'.php');

    if( $global ) $GLOBALS['valeo_base']->$class = new $name();
    else new $name();
}
endif;

require get_template_directory() . '/inc/functions.php';

if( is_admin() )
/** Plugin Activation */
require get_template_directory().DIRECTORY_SEPARATOR.'inc'.DIRECTORY_SEPARATOR.'tgm-plugin-activation'.DIRECTORY_SEPARATOR.'plugins.php';
