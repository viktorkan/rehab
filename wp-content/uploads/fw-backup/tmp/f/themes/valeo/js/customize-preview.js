/**
 * Live-update changed settings in real time in the Customizer preview.
 */

( function( $ ) {
	var $style = $( '#valeo-color-scheme-css' ),
		api = wp.customize;

	if ( ! $style.length ) {
		$style = $( 'head' ).append( '<style type="text/css" id="valeo-color-scheme-css" />' )
		                    .find( '#valeo-color-scheme-css' );
	}

	// Site title.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.blogname a' ).text( to );
		} );
	} );

	// Site tagline.
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.blogdescr a' ).text( to );
		} );
	} );

	// Color Scheme CSS.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-color-scheme-css', function( css ) {
			$style.html( css );
		} );
	} );

    // Contact Block -- Contact Phone.
    api( 'contact_block_phone', function( value ) {
        value.bind( function( to ) {
            // caall to analogue of php function: valeo_replace_str( $str )   (see /inc/functions.php)
            to = custom_replace_str( to );
            $( '.header__contact1 .header__contact_content' ).html( to );
        } );
    } );

    // Contact Block -- Contact Email.
    api( 'contact_block_email', function( value ) {
        value.bind( function( to ) {
            // caall to analogue of php function: valeo_replace_str( $str )   (see /inc/functions.php)
            to = custom_replace_str( to );
            $( '.header__contact2 .header__contact_content' ).html( to );
        } );
    } );

    // Copyright.
    api( 'copyright_text', function( value ) {
        value.bind( function( to ) {
            $( '.copyright-text-1' ).html( to );
        } );
    } );

    // Copyright text 2.
    api( 'copyright_text_2', function( value ) {
        value.bind( function( to ) {
            $( '.copyright-text-2' ).html( to );
        } );
    } );

    // 404 Page Title.
    api( 'page_title_404', function( value ) {
        value.bind( function( to ) {
            value.bind( function( to ) {
                $( '.page_title_404' ).text( to );
            } );

        } );
    } );

    // 404 Page Message.
    api( 'page_message_404', function( value ) {
        value.bind( function( to ) {
            value.bind( function( to ) {
                $( '.page_message_404' ).text( to );
            } );

        } );
    } );

    // Hide/Show Home Link.
    api( 'hide_homepage_link', function( value ) {
        value.bind( function( to ) {
            if( to ){
                $( '.homepage_link_block' ).hide();
            } else {
                $( '.homepage_link_block' ).show();
            }

        } );
    } );

} )( jQuery );

function custom_replace_str( value ) {
    var find    = ['\\[',      '\\]',   '{',        '}']; // escape special symbol '['
    var replace = ['<span>', '</span>', '<strong>', '</strong>'];
    value = value.replaceArray(find, replace);

    return value;
}

String.prototype.replaceArray = function(find, replace) {
    var replaceString = this;
    var regex;
    for (var i = 0; i < find.length; i++) {
        regex = new RegExp(find[i], "g");
        replaceString = replaceString.replace(regex, replace[i]);
    }
    return replaceString;
};