<?php
/*------------------------------------------------------------
 * Table of Contents
 *
 * 1.  Row
 * 2.  Column
 * 3.  Vertical Spacer / Gap
 * 4.  Horizontal Spacer / Gap
 * 5.  Separator
 * 6.  Dropcap	
 * 7.  Highlight
 * 8.  Icons
 * 9.  Blockquote
 * 10. Button
 * 11. Text Style
 * 12. Tooltip
 * 13. Lists
 * 14. Video Wrapper
 * 15. Promobox
 *------------------------------------------------------------*/

/*------------------------------------------------------------
 * Remove extra P tags
 *------------------------------------------------------------*/
add_filter("the_content", "ashlesha_shortcode_format");
function ashlesha_shortcode_format($content) {
	// array of custom shortcodes requiring the fix
	$block = join("|",array( "dtr_row","dtr_column","dtr_spacer","dtr_spacer_wide","dtr_separator","dtr_dropcap","dtr_highlight","dtr_icon","dtr_blockquote","dtr_button","dtr_text_style","dtr_tooltip","dtr_team","dtr_team_styled","dtr_portfolio_grid","list","ordered_list","list_item", "dtr_listicon", "dtr_portfolio_tax", "dtr_social_share", "dtr_video_wrapper", "dtr_checkmark_list", "dtr_circle_list", "dtr_star_list", "dtr_heart_list", "dtr_circle_arrow_list", "dtr_arrow_list", "dtr_checkmark_square_list", "dtr_checkmark_circle_list", "dtr-promobox", "dtr_catbox", "dtr_linkbox" ) );

	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
	return $rep;
}

/*
 * @param $content
 * @param bool $autop
 * @return string
 */
if ( ! function_exists( 'ashlesha_remove_wpautop' ) ) {
	function ashlesha_remove_wpautop( $content, $autop = false ) {
		if ( $autop ) { // Possible to use !preg_match('('.WPBMap::getTagsRegexp().')', $content)
			$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
		}
		return do_shortcode( shortcode_unautop( $content ) );
	}
}

/*------------------------------------------------------------
 * 1. Row
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_row_sc' ) ) {
	function ashlesha_row_sc( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'padding' 		=> '',
			'margin' 		=> '',
			'class'			=> '',
			'return_class'	=> '',
		), $atts ) );
		$output = '';
		// class
		if( $class ) {
			$return_class = ' class="'. esc_attr( $class ) .'"';
		} 
		// style
		$add_style = array();
		if( $padding  ) {
			$add_style[] = 'padding:'. $padding .';';
		} 
		if( $margin ) {
			$add_style[] = 'margin:'. $margin .';';
		} 
		$add_style = implode('', $add_style);
	
		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '"';
		}
		// output
		if ( $class || $add_style ) {
			$output .= '<div' . $return_class . '' . $add_style. '>';
		}
				$output .= '<div class="row">' . do_shortcode( $content ) . '</div>';
		if ( $class || $add_style ) {
			$output .= '</div>';
		}
		// return output
		return $output;
	}
}
add_shortcode( 'dtr_row', 'ashlesha_row_sc' );

/*------------------------------------------------------------
 * 2. Column
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_column_sc' ) ) {
	function ashlesha_column_sc( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'width' 		=> '',
			'class'			=> '',
			'return_class'	=> '',
			), $atts ) );
		
		switch ( $width ) {
			case "span12"   : $default_class = "col-md-12 col-sm-12 col-xs-12"; break;
			case "span11"   : $default_class = "col-md-11 col-sm-11 col-xs-12"; break;
			case "span10"   : $default_class = "col-md-10 col-sm-10 col-xs-12"; break;
			case "span9"	: $default_class = "col-md-9 col-sm-9 col-xs-12"; break;
			case "span8"	: $default_class = "col-md-8 col-sm-8 col-xs-12"; break;
			case "span7"    : $default_class = "col-md-7 col-sm-7 col-xs-12"; break;
			case "span6"    : $default_class = "col-md-6 col-sm-6 col-xs-12"; break;
			case "span5"    : $default_class = "col-md-5 col-sm-5 col-xs-12"; break;
			case "span4"    : $default_class = "col-md-4 col-sm-4 col-xs-12"; break;
			case "span3"    : $default_class = "col-md-3 col-sm-3 col-xs-12"; break;
			case "span2"    : $default_class = "col-md-2 col-sm-2 col-xs-12"; break;
			case "span1"    : $default_class = "col-md-1 col-sm-1 col-xs-12"; break;
			default       	: $default_class = "col-md-12 col-sm-12 col-xs-12";
		}
		
		if( $class ) {
			$return_class = ' '. esc_attr( $class ) .'';
		} 
		// output
		return '<div class="' . $default_class . '' . $return_class . '">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'dtr_column', 'ashlesha_column_sc' );

/*------------------------------------------------------------
 * 3. Vertical Spacer / Gap
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_spacer_sc' ) ) {
	function ashlesha_spacer_sc( $atts, $content ) {
		extract ( shortcode_atts( array(
			'height'	=> '', // in px
		), $atts ) );
		return '<div class="spacer" style="height: ' . esc_attr( $height ) . ';"></div>';
	}
}
add_shortcode( 'dtr_spacer', 'ashlesha_spacer_sc' );
	
/*------------------------------------------------------------
 * 4. Horizontal Spacer / Gap
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_wide_spacer_sc' ) ) {
	function ashlesha_wide_spacer_sc( $atts, $content ) {
		extract ( shortcode_atts( array(
			'width'       => '', // in px
		), $atts ) );
		return '<span class="spacer-wide" style="width: ' . esc_attr( $width ) . ';"></span>';
	}
}
add_shortcode( 'dtr_spacer_wide', 'ashlesha_wide_spacer_sc' );

/*------------------------------------------------------------
 * 5. Separator
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_separator_sc' ) ) {
	function ashlesha_separator_sc( $atts, $content=null ) {
		extract ( shortcode_atts( array(
			'width'			=> '', 
			'color'			=> '', 
			'margin_top'	=> '', 
			'margin_bottom'	=> '', 
			'align'			=> '', 
			'border_style'	=> '', 
			'border_width'	=> '', 
		), $atts ) );
		// align
		if( $align == 'left' ){
			$return_align = ' left-separator';
		} elseif( $align == 'right' ){
			$return_align = ' right-separator';
		} elseif( $align == 'center' ){
			$return_align = '';
		} else {
			$return_align = '';
		}
		// style
		$add_style = array();
		if ( $width ) {
			$add_style[] = 'width: '. $width .';';
		} 
		if ( $border_width ) {
			$add_style[] = 'border-top-width: '. $border_width .';';
		} 
		if ( $border_style ) {
			$add_style[] = 'border-top-style: '. $border_style .';';
		} 
		if ( $color ) {
			$add_style[] = 'border-color: '. $color .';';
		} 
		if ( $margin_top ) {
			$add_style[] = 'margin-top: '. $margin_top .';';
		} 
		if ( $margin_bottom ) {
			$add_style[] = 'margin-bottom: '. $margin_bottom .';';
		} 
		$add_style = implode('', $add_style);
		
		if ( $add_style ) {
		$add_style = wp_kses( $add_style, array() );
		$add_style = ' style="' . esc_attr($add_style) . '"';
		}
		return '<div class="line-separator' . esc_attr( $return_align ) . '"' . $add_style . '></div>';
	}
}
add_shortcode( 'dtr_separator', 'ashlesha_separator_sc' );

/*------------------------------------------------------------
 * 6. Dropcap
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_dropcap_sc' ) ) {
	function ashlesha_dropcap_sc( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'bgcolor'	=> '', 
			'color'		=> '', 
			'style' 	=> '', // default/circle/square
		), $atts ) );

		$add_style = array();
		if( $bgcolor != ''  ) {
			$add_style[] = 'background-color: '. $bgcolor .';';
		} 
		if( $color != ''  ) {
			$add_style[] = 'color: '. $color .';';
		} 
		$add_style = implode('', $add_style);
		
		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '" ';
		}
		return '<span class="dtr-dropcap ' . esc_attr( $style ) . '"' . $add_style . '>' . do_shortcode( $content ) . '</span>';
	}  
}
add_shortcode( 'dtr_dropcap', 'ashlesha_dropcap_sc' ); 
 
/*------------------------------------------------------------
 * 7. Highlight
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_text_highlight_sc' ) ) {
	function ashlesha_text_highlight_sc( $atts, $content = null ) {
	extract ( shortcode_atts( array(
		'bgcolor' 	=> '', 
		'color'   	=> '', 
		'font_size'	=> '', 
	), $atts ) );
	
	$add_style = array();
	if( $bgcolor != ''  ) {
		$add_style[] = 'background-color: '. $bgcolor .';';
	} 
	if( $color != ''  ) {
		$add_style[] = 'color: '. $color .';';
	} 
	if( $font_size != ''  ) {
		$add_style[] = 'font-size: '. $font_size .';';
	} 
	$add_style = implode('', $add_style);
	
	if ( $add_style ) {
		$add_style = wp_kses( $add_style, array() );
		$add_style = ' style="' . esc_attr($add_style) . '" ';
	}
	return '<span class="dtr-highlight"' . $add_style . '>' . do_shortcode( $content ) . '</span>';
	}
}
add_shortcode( 'dtr_highlight', 'ashlesha_text_highlight_sc' );

/*------------------------------------------------------------
 * 8. Icons
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_icon_sc' ) ) {
	function ashlesha_icon_sc( $atts, $content ) {
		extract( shortcode_atts( array(
			'icon_name'	=> '', 
			'color' 	=> '', 
			'size' 		=> '',
		), $atts ) );
		
		$add_style = array();
		if( $color != ''  ) {
			$add_style[] = 'color: '. $color .';';
		} 
		if( $size != ''  ) {
			$add_style[] = 'font-size: '. $size .';';
		} 
		$add_style = implode('', $add_style);
		
		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '" ';
		}
		
		return '<span class=" fa ' . $icon_name . '"' . $add_style . '></span>';
	}
}
add_shortcode( 'dtr_icon', 'ashlesha_icon_sc' );

/*------------------------------------------------------------
 * 9. Blockquote
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_blockquote_sc' ) ) {
	function ashlesha_blockquote_sc( $atts,  $content = null ) {
		extract( shortcode_atts( array(
			'style'			=> '',
			'return_style'	=> '',
			'class'			=> '',
			'source'		=> '',
			'return_source'	=> '',
			'clearfix'		=> '',
		), $atts ) );
		
		$content = ashlesha_remove_wpautop($content, true);
		
		if( $style == 'with_border' ) {
			$return_style = '';
		} elseif ( $style == 'with_right_border' ) {
			$return_style = ' pull-right';
			$clearfix	= ' <div class="clearfix"></div>';
		} elseif ( $style == 'with_icon' ) {
			$return_style = ' dtr-icon-quote';
		} 
		
		if( $source ) {
			$return_source	= '<span class="dtr-quote-source">' . esc_attr ( $source ) . '</span>';	
		}
		
		return '<blockquote class="dtr-blockquote' . $return_style . ' ' . $class . '">' . $content . '' . $return_source . '</blockquote>' . $clearfix . '';
	}
}
add_shortcode( 'dtr_blockquote', 'ashlesha_blockquote_sc' );

/*------------------------------------------------------------
 * 10. Button
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_button_sc' ) ) {
	function ashlesha_button_sc( $atts, $content ) {
		extract ( shortcode_atts( array(
			'size'  				=> '', 
			'target' 				=> '', 
			'return_target' 		=> '', 
			'url'   				=> '', 
			'icon_position'   		=> '', 
			'return_icon_position'	=> '', 
			'icon_name'   			=> '',
			'btn_text'				=> '', 
			'return_size'  			=> '', 
			'color'  				=> '', 
			'bg_color'  			=> '', 
			'add_padding'  			=> '', 
			'class'  				=> '', 
			'return_class' 			=> '',
		), $atts ) );
		
		// color styles
		$add_style = array();
		if( $color != ''  ) {
			$add_style[] = 'color: '. $color .';';
		} 
		if( $bg_color != ''  ) {
			$add_style[] = 'background-color: '. $bg_color .';';
		} 
		$add_style = implode('', $add_style);
		
		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '" ';
		}
		
		// icon_name
		if( $icon_name != '' ) {
			$return_icon = '<i class="' . esc_attr( $icon_name ) . '"></i>';
		} else {
			$return_icon = '';
		}

		// url
		if( $url != ''  ) {
			$return_url = ' href="' . esc_url( $url ) . '"';
		} else {
			$return_url = '';
		}
	
		// target
		if( $target == 'blank' ){
			$return_target = ' target="_blank"';
		} elseif( $target == 'self' ){
			$return_target = ' target="_self"';
		} else {
			$return_target = '';
		}
		
		// size
		if( $size == 'big' ) {
			$return_size = ' themebtn-big';
		} elseif ( $size == 'medium' ) {
			$return_size = ' themebtn-medium';
		} else { 
			$return_size = ''; 
		}

		// Icon Position
		if( $icon_position == 'left' ) {
			$return_icon_position = ' themebtn-left';
		} elseif ( $icon_position == 'right' ) {
			$return_icon_position = ' themebtn-right';
		} else { 
			$return_icon_position = ''; 
		}
		
		// btn text
		if( $btn_text != ''  ) {
			$return_label = '' . esc_attr( $btn_text ) . '';
			$add_padding = '';
		} else {
			$return_label = '';
			$add_padding = ' dtr-icon-btn';
		}

		// output
		return '<a class="themebtn ' . esc_attr( $return_icon_position ) . esc_attr( $return_size ) . '' . esc_attr( $add_padding ) . ' ' . esc_attr( $class ) . '"' . $return_target . ' ' . $return_url . '' . $add_style . '>' . $return_icon . '' . $return_label . '</a>';
	}
}
add_shortcode( 'dtr_button', 'ashlesha_button_sc' );

/*------------------------------------------------------------
 * 11. Text style
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_text_style_sc' ) ) {
	function ashlesha_text_style_sc( $atts, $content = null ) {
		extract ( shortcode_atts( array(
			'size' 				=> '', 
			'line_height'		=> '', 
			'color' 			=> '', 
			'font_weight'		=> '', 
			'letter_spacing'	=> '', 
			'class' 			=> '',
			'return_class' 		=> '',
		), $atts ) );
		
		$content = ashlesha_remove_wpautop($content, true);
		// style
		$add_style = array();
		if ( $size ) {
			$add_style[] = ' font-size: ' . $size . ';';
		} 
		if ( $line_height ) {
			$add_style[] = ' line-height: ' . $line_height . ';';
		} 
		if ( $color ) {
			$add_style[] = ' color: ' . $color . ';';
		} 
		if ( $font_weight ) {
			$add_style[] = ' font-weight: ' . $font_weight . ';';
		} 
		if ( $letter_spacing ) {
			$add_style[] = ' letter-spacing: ' . $letter_spacing . ';';
		} 
		$add_style = implode('', $add_style);
		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '"';
		}
		
		// class
		if( $class ) {
			$return_class = ' class="'. esc_attr( $class ) .'"';
		} 
		
		return '<div' . $add_style . '' . $return_class . '>' . $content . '</div>';
	}
}
add_shortcode( 'dtr_text_style', 'ashlesha_text_style_sc' );

/*------------------------------------------------------------
 * 12. Tooltip
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_tooltip_sc' ) ) {
	function ashlesha_tooltip_sc( $atts, $content = null ) {
		extract ( shortcode_atts( array(
			'url'       => '', 
			'title'     => '', 
			'color'     => '', 
			'font_size' => '', 
			'placement'	=> 'top', // top, bottom, left, right
		), $atts ) );
		
		$add_style = array();
		if( $color != ''  ) {
			$add_style[] = 'color: '. $color .';';
		} 
		if( $font_size != ''  ) {
			$add_style[] = 'font-size: '. $font_size .';';
		} 
		$add_style = implode('', $add_style);
		
		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '" ';
		}
		
		if( $url != ''  ) {
			$return_url = 'href="' . esc_url( $url ) . '" ';
		}
		else{
			$return_url = '';
		}
		return '<a ' . $return_url . 'title="' . esc_attr( $title ) . '" data-placement="' . esc_attr( $placement ) . '" data-toggle="tooltip"' . $add_style . '>' . do_shortcode( $content ) . '</a>';
	}
}
add_shortcode( 'dtr_tooltip', 'ashlesha_tooltip_sc' );

/*------------------------------------------------------------
 * 13. Lists
 * @since 1.0
 *------------------------------------------------------------*/
// ul
if ( ! function_exists( 'ashlesha_list_sc' ) ) {
	function ashlesha_list_sc( $atts, $content = null ) {
		extract ( shortcode_atts( array(
			'color'				=> '', 
			'font_size'			=> '', 
			'line_height'		=> '', 
			'list_style'		=> '', 
		), $atts ) );
		
		// add list style
		$add_style = array();
		if( $color != ''  ) {
			$add_style[] = 'color: '. $color .';';
		} 
		if( $font_size != ''  ) {
			$add_style[] = 'font-size: '. $font_size .';';
		} 
		if( $line_height != ''  ) {
			$add_style[] = 'line-height: '. $line_height .';';
		} 
		if( $list_style != ''  ) {
			$add_style[] = 'list-style-type: '. $list_style .';';
		} 
		$add_style = implode('', $add_style);
		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '"';
		}
		return '<ul class="common-list" ' . $add_style . '>' . do_shortcode( $content ) . '</ul>';
	}
}
add_shortcode( 'dtr_list', 'ashlesha_list_sc' );

// ol
if ( ! function_exists( 'ashlesha_ordered_list_sc' ) ) {
	function ashlesha_ordered_list_sc( $atts, $content = null ) {
		extract ( shortcode_atts( array(
			'color'			=> '', 
			'font_size'		=> '', 
			'line_height'	=> '', 
			'list_style'	=> '', 
		), $atts ) );
		
		// add list style
		$add_style = array();
		if( $color != ''  ) {
			$add_style[] = 'color: '. $color .';';
		} 
		if( $font_size != ''  ) {
			$add_style[] = 'font-size: '. $font_size .';';
		} 
		if( $line_height != ''  ) {
			$add_style[] = 'line-height: '. $line_height .';';
		} 
		if( $list_style != ''  ) {
			$add_style[] = 'list-style-type: '. $list_style .';';
		} 
		$add_style = implode('', $add_style);
		
		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '"';
		}
		return '<ol class="list" ' . $add_style . '>' . do_shortcode( $content ) . '</ol>';
	}
}
add_shortcode( 'dtr_ordered_list', 'ashlesha_ordered_list_sc' );

// Checkmark list
function ashlesha_checkmark_list_sc( $atts, $content = null ) {
	extract ( shortcode_atts( array(
		'color'			=> '', 
		'size'			=> '', 
		'return_size'	=> '', 
    ), $atts ) );
		
   $add_style = array();
	if( $color != ''  ) {
		$add_style[] = 'color: '. $color .';';
	} 
	$add_style = implode('', $add_style);

	if ( $add_style ) {
		$add_style = wp_kses( $add_style, array() );
		$add_style = ' style="' . esc_attr($add_style) . '"';
	}
	
	if( $size == 'medium'  ) {
		$return_size = ' dtr-list-medium';
	} 
		
	return '<ul class="dtr-list-checkmark' . esc_attr ( $return_size ) . '"' . $add_style . '>' . do_shortcode( $content ) . '</ul>';
}
add_shortcode( 'dtr_checkmark_list', 'ashlesha_checkmark_list_sc' );

// Checkmark circle list
function ashlesha_checkmark_circle_list_sc( $atts, $content = null ) {
	extract ( shortcode_atts( array(
		'color'			=> '', 
		'size'			=> '', 
		'return_size'	=> '', 
    ), $atts ) );
		
   $add_style = array();
	if( $color != ''  ) {
		$add_style[] = 'color: '. $color .';';
	} 
	$add_style = implode('', $add_style);

	if ( $add_style ) {
		$add_style = wp_kses( $add_style, array() );
		$add_style = ' style="' . esc_attr($add_style) . '"';
	}
	
	if( $size == 'medium'  ) {
		$return_size = ' dtr-list-medium';
	} 
		
	return '<ul class="dtr-list-checkmark-circle' . esc_attr ( $return_size ) . '"' . $add_style . '>' . do_shortcode( $content ) . '</ul>';
}
add_shortcode( 'dtr_checkmark_circle_list', 'ashlesha_checkmark_circle_list_sc' );

// Checkmark square list
function ashlesha_checkmark_square_list_sc( $atts, $content = null ) {
	extract ( shortcode_atts( array(
		'color'			=> '', 
		'size'			=> '', 
		'return_size'	=> '', 
    ), $atts ) );
		
   $add_style = array();
	if( $color != ''  ) {
		$add_style[] = 'color: '. $color .';';
	} 
	$add_style = implode('', $add_style);

	if ( $add_style ) {
		$add_style = wp_kses( $add_style, array() );
		$add_style = ' style="' . esc_attr($add_style) . '"';
	}
	
	if( $size == 'medium'  ) {
		$return_size = ' dtr-list-medium';
	} 
		
	return '<ul class="dtr-list-checkmark-square' . esc_attr ( $return_size ) . '"' . $add_style . '>' . do_shortcode( $content ) . '</ul>';
}
add_shortcode( 'dtr_checkmark_square_list', 'ashlesha_checkmark_square_list_sc' );

// arrow list
function ashlesha_arrow_list_sc( $atts, $content = null ) {
	extract ( shortcode_atts( array(
		'color'			=> '', 
		'size'			=> '', 
		'return_size'	=> '', 
    ), $atts ) );
		
   $add_style = array();
	if( $color != ''  ) {
		$add_style[] = 'color: '. $color .';';
	} 
	$add_style = implode('', $add_style);

	if ( $add_style ) {
		$add_style = wp_kses( $add_style, array() );
		$add_style = ' style="' . esc_attr($add_style) . '"';
	}
	
	if( $size == 'medium'  ) {
		$return_size = ' dtr-list-medium';
	} 
		
	return '<ul class="dtr-list-arrow' . esc_attr ( $return_size ) . '"' . $add_style . '>' . do_shortcode( $content ) . '</ul>';
}
add_shortcode( 'dtr_arrow_list', 'ashlesha_arrow_list_sc' );

// circle arrow list
function ashlesha_circle_arrow_list_sc( $atts, $content = null ) {
	extract ( shortcode_atts( array(
		'color'			=> '', 
		'size'			=> '', 
		'return_size'	=> '', 
    ), $atts ) );
		
   $add_style = array();
	if( $color != ''  ) {
		$add_style[] = 'color: '. $color .';';
	} 
	$add_style = implode('', $add_style);

	if ( $add_style ) {
		$add_style = wp_kses( $add_style, array() );
		$add_style = ' style="' . esc_attr($add_style) . '"';
	}
	
	if( $size == 'medium'  ) {
		$return_size = ' dtr-list-medium';
	} 
		
	return '<ul class="dtr-list-arrow-circle' . esc_attr ( $return_size ) . '"' . $add_style . '>' . do_shortcode( $content ) . '</ul>';
}
add_shortcode( 'dtr_circle_arrow_list', 'ashlesha_circle_arrow_list_sc' );

// heart list
function ashlesha_heart_list_sc( $atts, $content = null ) {
	extract ( shortcode_atts( array(
		'color'			=> '', 
		'size'			=> '', 
		'return_size'	=> '', 
    ), $atts ) );
		
   $add_style = array();
	if( $color != ''  ) {
		$add_style[] = 'color: '. $color .';';
	} 
	$add_style = implode('', $add_style);

	if ( $add_style ) {
		$add_style = wp_kses( $add_style, array() );
		$add_style = ' style="' . esc_attr($add_style) . '"';
	}
	
	if( $size == 'medium'  ) {
		$return_size = ' dtr-list-medium';
	} 
		
	return '<ul class="dtr-list-heart' . esc_attr ( $return_size ) . '"' . $add_style . '>' . do_shortcode( $content ) . '</ul>';
}
add_shortcode( 'dtr_heart_list', 'ashlesha_heart_list_sc' );

// star list
function ashlesha_star_list_sc( $atts, $content = null ) {
	extract ( shortcode_atts( array(
		'color'			=> '', 
		'size'			=> '', 
		'return_size'	=> '', 
    ), $atts ) );
		
   $add_style = array();
	if( $color != ''  ) {
		$add_style[] = 'color: '. $color .';';
	} 
	$add_style = implode('', $add_style);

	if ( $add_style ) {
		$add_style = wp_kses( $add_style, array() );
		$add_style = ' style="' . esc_attr($add_style) . '"';
	}
	
	if( $size == 'medium'  ) {
		$return_size = ' dtr-list-medium';
	} 
		
	return '<ul class="dtr-list-star' . esc_attr ( $return_size ) . '"' . $add_style . '>' . do_shortcode( $content ) . '</ul>';
}
add_shortcode( 'dtr_star_list', 'ashlesha_star_list_sc' );

// circle list
function ashlesha_circle_list_sc( $atts, $content = null ) {
	extract ( shortcode_atts( array(
		'color'			=> '', 
		'size'			=> '', 
		'return_size'	=> '', 
    ), $atts ) );
		
   $add_style = array();
	if( $color != ''  ) {
		$add_style[] = 'color: '. $color .';';
	} 
	$add_style = implode('', $add_style);

	if ( $add_style ) {
		$add_style = wp_kses( $add_style, array() );
		$add_style = ' style="' . esc_attr($add_style) . '"';
	}
	
	if( $size == 'medium'  ) {
		$return_size = ' dtr-list-medium';
	} 
		
	return '<ul class="dtr-list-circle' . esc_attr ( $return_size ) . '"' . $add_style . '>' . do_shortcode( $content ) . '</ul>';
}
add_shortcode( 'dtr_circle_list', 'ashlesha_circle_list_sc' );

// li
if ( ! function_exists( 'ashlesha_list_item_sc' ) ) {
	function ashlesha_list_item_sc( $atts, $content = null ) {
		return '<li>' . do_shortcode( $content ) . '</li>';
	}
}
add_shortcode( 'dtr_list_item', 'ashlesha_list_item_sc' );


// List with icon
if ( ! function_exists( 'ashlesha_icon_list_sc' ) ) {
	function ashlesha_icon_list_sc( $atts, $content = null ) {
		extract( shortcode_atts( array(
		'icon_type'   		=> '',
		'color'        		=> '',
		'font_size'        => '',
		'line_height'      => '',
		'icon_color'   		=> '',
		'list_content'      => '', 
		), $atts ) );
		
		// style
		$add_style = array();
		if( $color != ''  ) {
			$add_style[] = 'color: '. $color .';';
		} 
		if( $font_size != ''  ) {
			$add_style[] = 'font-size: '. $font_size .';';
			$add_style[] = 'padding-left: '. $font_size .';';
		} 
		if( $line_height != ''  ) {
			$add_style[] = 'line-height: '. $line_height .';';
		} 
		$add_style = implode('', $add_style);
		
		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '"';
		}
		// icon style
		$add_style_icon = array();
		if( $icon_color != ''  ) {
			$add_style_icon[] = 'color: '. $icon_color .';';
		} 
		$add_style_icon = implode('', $add_style_icon);
		
		if ( $add_style_icon ) {
			$add_style_icon = wp_kses( $add_style_icon, array() );
			$add_style_icon = ' style="' . esc_attr($add_style_icon) . '"';
		}

		// icon_type
		if( $icon_type ) {
			$return_icon = '<i class="' . esc_attr( $icon_type ) . '"' . $add_style_icon . '></i>';
		} else {
			$return_icon = '';
		}
		
		return '<p class="dtr-list-icon"' . $add_style . '>' . $return_icon . '<span>' . $list_content . '</span></p>';
	}
}
add_shortcode( 'dtr_listicon', 'ashlesha_icon_list_sc' );

/*------------------------------------------------------------
 * 14. Video Wrapper
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_video_wrapper_sc' ) ) {
	function ashlesha_video_wrapper_sc( $atts, $content = null ) {
		return '<div class="dtr-video-wrapper">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'dtr_video_wrapper', 'ashlesha_video_wrapper_sc' );

/*------------------------------------------------------------
 * 15. Promobox
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_promobox_sc' ) ) {
	function ashlesha_promobox_sc( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'padding' 				=> '',
			'margin' 				=> '',
			'background_color'		=> '',
			'background_img'		=> '',
			'return_background_img'	=> '',
			'background_position'	=> '',
			'background_repeat'		=> '',
			'background_size'		=> '',
			'return_bgsize'			=> '',
			'background_attachment'	=> '',
			'color'					=> '',
			'class'					=> '',
			'return_class'			=> '',
			'align'					=> '',
			), $atts ) );
		
		$content = ashlesha_remove_wpautop($content, true);
		
		if( $class ) {
			$return_class = ' '. esc_attr( $class ) .'';
		} 
		
		if( $background_size ) {
			$return_bgsize = 'background-size: '. esc_attr( $background_size ) .';';
		} 
		
		if( $background_img ) {
			$return_background_img = 'url("'. esc_url( $background_img ) .'")';
		} 
		
		$add_style = array();
		if( $padding  ) {
			$add_style[] = 'padding:'. $padding .';';
		} 
		if( $margin ) {
			$add_style[] = 'margin:'. $margin .';';
		} 
		if( $color ) {
			$add_style[] = 'color:'. $color .';';
		} 
		if( $background_img != '' || $background_color != '' || $background_repeat != '' || $background_position != '' || $background_attachment != '' || $background_size != '' ) {
			$add_style[] = 'background:' .$return_background_img . ' '. esc_attr( $background_color ) .' '. esc_attr( $background_repeat ) .' '. esc_attr( $background_position ) .' '. esc_attr( $background_attachment ) .';' .$return_bgsize . '';
		} 
		
		$add_style = implode('', $add_style);
	
		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '"';
		}

		return '<div class="dtr-promobox ' . esc_attr( $align ) . '' . $return_class . '"' . $add_style. '>' . $content . '</div>';
	}
}
add_shortcode( 'dtr_promobox', 'ashlesha_promobox_sc' );

/*------------------------------------------------------------
 * 16. Category Box
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_catbox_sc' ) ) {
	function ashlesha_catbox_sc( $atts, $content ) {
		extract( shortcode_atts( array(
			'background_color'		=> '',
			'background_color'		=> '',
			'background_img'		=> '',
			'return_background_img'	=> '',
			'background_position'	=> '',
			'background_repeat'		=> '',
			'background_size'		=> '',
			'return_bgsize'			=> '',
			'background_attachment'	=> '',
			'color'					=> '',
			'class'					=> '',
			'return_class'			=> '',
			'category_name'			=> '',
			'category_slug'			=> '',
			), $atts ) );
		
		$content = ashlesha_remove_wpautop($content, true);
		
		if( $class ) {
			$return_class = ' '. esc_attr( $class ) .'';
		} 
		
		if( $background_size ) {
			$return_bgsize = 'background-size: '. esc_attr( $background_size ) .';';
		} 
		
		if( $background_img ) {
			$return_background_img = 'url("'. esc_url( $background_img ) .'")';
		} 
		
		$add_style = array();
		if( $color ) {
			$add_style[] = 'color:'. $color .';';
		} 
		if( $background_img != '' || $background_color != '' || $background_repeat != '' || $background_position != '' || $background_attachment != '' || $background_size != '' ) {
			$add_style[] = 'background:' .$return_background_img . ' '. esc_attr( $background_color ) .' '. esc_attr( $background_repeat ) .' '. esc_attr( $background_position ) .' '. esc_attr( $background_attachment ) .';' .$return_bgsize . '';
		} 
		
		$add_style = implode('', $add_style);
	
		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '"';
		}

		// category link
		/*$category_name = $category_name;
		$category_slug = $category_slug;*/
		$category_id = get_cat_ID( $category_slug );
		$category_link = get_category_link( $category_id );
		
		// count
		$args = array(
			'category_name' => $category_slug
		);
		$the_query = new WP_Query( $args );
		$count = $the_query->found_posts;
		
		// content
		$content = '<a href="' . esc_url( $category_link ) . '" title="' . esc_attr( $category_name ) . '"><span class="dtr-box-subtitle">' . esc_attr( $count ) . ' ' . esc_html__( 'Posts', 'ashlesha' ) . '</span><h3 class="dtr-catbox-title">' . esc_attr( $category_name ) . '</h3></a>';
		
		return '<div class="dtr-catbox ' . $return_class . ' clearfix"' . $add_style. '>' . $content . '</div>';
	}
}
add_shortcode( 'dtr_catbox', 'ashlesha_catbox_sc' );

/*------------------------------------------------------------
 * 16. Link Box
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_linkbox_sc' ) ) {
	function ashlesha_linkbox_sc( $atts, $content ) {
		extract( shortcode_atts( array(
			'background_color'		=> '',
			'background_color'		=> '',
			'background_img'		=> '',
			'return_background_img'	=> '',
			'background_position'	=> '',
			'background_repeat'		=> '',
			'background_size'		=> '',
			'return_bgsize'			=> '',
			'background_attachment'	=> '',
			'color'					=> '',
			'class'					=> '',
			'return_class'			=> '',
			'title'					=> '',
			'sub_title'				=> '',
			'link_url'				=> '',
			), $atts ) );
		
		$content = ashlesha_remove_wpautop($content, true);
		
		if( $class ) {
			$return_class = ' '. esc_attr( $class ) .'';
		} 
		
		if( $background_size ) {
			$return_bgsize = 'background-size: '. esc_attr( $background_size ) .';';
		} 
		
		if( $background_img ) {
			$return_background_img = 'url("'. esc_url( $background_img ) .'")';
		} 
		
		$add_style = array();
		if( $color ) {
			$add_style[] = 'color:'. $color .';';
		} 
		if( $background_img != '' || $background_color != '' || $background_repeat != '' || $background_position != '' || $background_attachment != '' || $background_size != '' ) {
			$add_style[] = 'background:' .$return_background_img . ' '. esc_attr( $background_color ) .' '. esc_attr( $background_repeat ) .' '. esc_attr( $background_position ) .' '. esc_attr( $background_attachment ) .';' .$return_bgsize . '';
		} 
		
		$add_style = implode('', $add_style);
	
		if ( $add_style ) {
			$add_style = wp_kses( $add_style, array() );
			$add_style = ' style="' . esc_attr($add_style) . '"';
		}
		
		// content
		$content = '<a href="' . esc_url( $link_url ) . '" title="' . esc_attr( $title ) . '"><span class="dtr-box-subtitle">' . esc_attr( $sub_title ) . '</span><h3 class="dtr-catbox-title">' . esc_attr( $title ) . '</h3></a>';
		
		return '<div class="dtr-catbox ' . $return_class . ' clearfix"' . $add_style. '>' . $content . '</div>';
	}
}
add_shortcode( 'dtr_linkbox', 'ashlesha_linkbox_sc' );

/*------------------------------------------------------------
 * Recent Posts Carousel
 * @since 1.0
 *------------------------------------------------------------*/
if ( ! function_exists( 'ashlesha_recentpost_sc' ) ) {
	function ashlesha_recentpost_sc( $atts, $content = null ) {
		extract ( shortcode_atts( array(
			'title'     	=> '',
			'image'			=> '',
			'date'   		=> '',
			'limit'     	=> -1,
			'order'     	=> 'DESC',
			'orderby'   	=> 'date',
			'image_size'	=> 'full',
			'cat'			=> '',
			'colums'      	=> '',
		), $atts ) );
	
		$cat = str_replace(' ','-',$cat);
		 
		global $post;
		$args = array(
			'post_type'      		=> '',
			'posts_per_page' 		=> esc_attr( $limit ),
			'order'          		=> esc_attr( $order ), 
			'orderby'        		=> $orderby,
			'post_status'    		=> 'publish',
			'category_name'  		=> $cat, 
			'ignore_sticky_posts'	=> true,
		);
	
		query_posts( $args );
		$output = '';
		if( have_posts() ) : 
			$output .= '<div class="dtr-recentposts-grid dtr-recentposts-grid-4col">';
			while ( have_posts() ) : the_post();
				$output .= '<div class="dtr-recentposts-item">';
				$permalink		= get_permalink();
				$thumb_title	= get_the_title();	

				// thumbnail
				if( $image !== 'yes' && has_post_thumbnail() ) {
						$output .=  '<div class="dtr-recentpost-img"><a href="' . esc_url( $permalink ) . '" rel="bookmark">' . get_the_post_thumbnail($post->ID, $image_size) . '</a></div>';
				}	
				
				if( $title !== 'yes' || $date !== 'yes' ) {
					$output .= '<div class="dtr-recentpost-content">';
				}
					// date
					if( $date !== 'yes' ) {
						$output .= '<span class="dtr-meta">' . esc_attr(get_the_date()) . '</span>';
					}
					// title
					if( $title !== 'yes' ):
						$output .= '<h6 class="dtr-recentpost-title"><a href="' . esc_url( $permalink ) . '" rel="bookmark">' . esc_attr(get_the_title()) . '</a></h6>';
					endif;	
				if( $title !== 'yes' ||  $date !== 'yes' ) {
				$output .= '</div>';
				}
				$output .= '</div>'; // item
			endwhile;
			$output .= '</div><div class="clearfix"></div>';
			wp_reset_query();
		endif;
		return $output;
	}	
}
add_shortcode('dtr_recent_post', 'ashlesha_recentpost_sc');