/* global colorScheme, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api ) {
	var cssTemplate = wp.template( 'valeo-color-scheme' ),
		colorSchemeKeys = [
			'header_textcolor',
			'background_color',
			'sidebar_background',
			'menu_background',
			'accent_color',
			'meta_textcolor',
			'content_textcolor',
            'accent_color_2',

			'header_textcolor__hover',
			'accent_color__hover',
			'meta_textcolor__hover',
            'menu_background__hover',
		],
		colorSettings = [
			'header_textcolor',
			'background_color',
			'sidebar_background',
			'menu_background',
            'accent_color',
            'meta_textcolor',
            'content_textcolor',
            'accent_color_2',
		];

	api.controlConstructor.select = api.Control.extend( {
		ready: function() {
			if ( 'color_scheme' === this.id ) {
				this.setting.bind( 'change', function( value ) {
					// Update Headers Text Color.
					api( 'header_textcolor' ).set( colorScheme[value].colors[0] );
					api.control( 'header_textcolor' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[0] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[0] );

					// Update Background Color.
					api( 'background_color' ).set( colorScheme[value].colors[1] );
					api.control( 'background_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[1] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[1] );

					// Update Background Color.
					api( 'sidebar_background' ).set( colorScheme[value].colors[2] );
					api.control( 'sidebar_background' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[2] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[2] );

					// Update Menu Background Color.
					api( 'menu_background' ).set( colorScheme[value].colors[3] );
					api.control( 'menu_background' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

					// Update Main Theme Color.
					api( 'accent_color' ).set( colorScheme[value].colors[4] );
					api.control( 'accent_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[4] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[4] );

					// Update Meta Text Color.
					api( 'meta_textcolor' ).set( colorScheme[value].colors[5] );
					api.control( 'meta_textcolor' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[5] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[5] );

                    // Update Content Text Color.
                    api( 'content_textcolor' ).set( colorScheme[value].colors[6] );
                    api.control( 'content_textcolor' ).container.find( '.color-picker-hex' )
                        .data( 'data-default-color', colorScheme[value].colors[6] )
                        .wpColorPicker( 'defaultColor', colorScheme[value].colors[6] );

                    // Update Main Theme Color.
                    api( 'accent_color_2' ).set( colorScheme[value].colors[7] );
                    api.control( 'accent_color_2' ).container.find( '.color-picker-hex' )
                        .data( 'data-default-color', colorScheme[value].colors[7] )
                        .wpColorPicker( 'defaultColor', colorScheme[value].colors[7] );

				} );
			}
		}
	} );

	// Generate the CSS for the current Color Scheme.
	function updateCSS() {
		var scheme = api( 'color_scheme' )(), css,
			colors = _.object( colorSchemeKeys, colorScheme[ scheme ].colors );

		// Merge in color scheme overrides.
		_.each( colorSettings, function( setting ) {
			var color = api( setting )();
			if( ( setting == 'header_textcolor'
                 || setting == 'background_color'
                ) && color.charAt(0)== '#') {
				colors[ setting ] = color.substring(1, 7);
			} else {
				colors[ setting ] = color;
			}

		});

		// Add additional colors.
		colors.header_textcolor__hover = Color( colors.header_textcolor ).toCSS( 'rgba', 0.5 );
		colors.accent_color__hover     = Color( colors.accent_color ).toCSS( 'rgba', 0.5 );
		colors.meta_textcolor__hover   = Color( colors.meta_textcolor ).toCSS( 'rgba', 0.5 );
        colors.menu_background__hover  = Color( colors.menu_background ).toCSS( 'rgba', 0.5 );

		css = cssTemplate( colors );

		api.previewer.send( 'update-color-scheme-css', css );
	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateCSS );
		} );
	} );
} )( wp.customize );
