(function() {
	tinymce.PluginManager.add('dtrshortcodes', function( editor, url ) {
		
		// Layout shortcode Starts
		editor.addButton( 'dtr_layout', {
            title: 'Layout',
            type: 'menubutton',
            image: url + '/img/icon-sc-layout.png',
            menu: [
          
			// column start
			 {
				text: 'Columns',
				menu: [
			// span6 + span6
			{
				text: 'span6 + span6',
				value: '[dtr_row padding="" margin="" class=""]<br>[dtr_column width="span6"]</p><p>First Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span6"]</p><p>Second Column - Content goes here</p><p>[/dtr_column]<br>[/dtr_row]',
				onclick: function(e) {
					e.stopPropagation();
					editor.insertContent(this.value());
				}       
			}, // span6 + span6 ends
			
			// span4 + span4 + span4
			{
				text: 'span4 + span4 + span4',
				value: '[dtr_row padding="" margin="" class=""]<br>[dtr_column width="span4"]</p><p>First Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span4"]</p><p>Second Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span4"]</p><p>Third Column - Content goes here</p><p>[/dtr_column]<br>[/dtr_row]',
				onclick: function(e) {
					e.stopPropagation();
					editor.insertContent(this.value());
				}       
			}, // span4 + span4 + span4 ends
			
			// span4 + span8
			{
				text: 'span4 + span8',
				value: '[dtr_row padding="" margin="" class=""]<br>[dtr_column width="span4"]</p><p>First Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span8"]</p><p>Second Column - Content goes here</p><p>[/dtr_column]<br>[/dtr_row]',
				onclick: function(e) {
					e.stopPropagation();
					editor.insertContent(this.value());
				}       
			}, // span4 + span8 ends
			
			// span8 + span4
			{
				text: 'span8 + span4',
				value: '[dtr_row padding="" margin="" class=""]<br>[dtr_column width="span8"]</p><p>First Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span4"]</p><p>Second Column - Content goes here</p><p>[/dtr_column]<br>[/dtr_row]',
				onclick: function(e) {
					e.stopPropagation();
					editor.insertContent(this.value());
				}       
			}, // span8 + span4 ends
			
			// span3 + span3 + span3 + span3
			{
				text: 'span3 + span3 + span3 + span3',
				value: '[dtr_row padding="" margin="" class=""]<br>[dtr_column width="span3"]</p><p>First Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span3"]</p><p>Second Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span3"]</p><p>Third Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span3"]</p><p>Fourth Column - Content goes here</p><p>[/dtr_column]<br>[/dtr_row]',
				onclick: function(e) {
					e.stopPropagation();
					editor.insertContent(this.value());
				}       
			}, // span3 + span3 + span3 + span3 ends

			// span3 + span6 + span3
			{
				text: 'span3 + span6 + span3',
				value: '[dtr_row padding="" margin="" class=""]<br>[dtr_column width="span3"]</p><p>First Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span6"]</p><p>Second Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span3"]</p><p>Third Column - Content goes here</p><p>[/dtr_column]<br>[/dtr_row]',
				onclick: function(e) {
					e.stopPropagation();
					editor.insertContent(this.value());
				}       
			}, // span3 + span6 + span3 ends
			
			// span3 + span3 + span6
			{
				text: 'span3 + span3 + span6',
				value: '[dtr_row padding="" margin="" class=""]<br>[dtr_column width="span3"]</p><p>First Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span3"]</p><p>Second Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span6"]</p><p>Third Column - Content goes here</p><p>[/dtr_column]<br>[/dtr_row]',
				onclick: function(e) {
					e.stopPropagation();
					editor.insertContent(this.value());
				}       
			}, // span3 + span3 + span6 ends
			
			// span6 + span3 + span3
			{
				text: 'span6 + span3 + span3',
				value: '[dtr_row padding="" margin="" class=""]<br>[dtr_column width="span6"]</p><p>First Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span3"]</p><p>Second Column - Content goes here</p><p>[/dtr_column]<br>[dtr_column width="span3"]</p><p>Third Column - Content goes here</p><p>[/dtr_column]<br>[/dtr_row]',
				onclick: function(e) {
					e.stopPropagation();
					editor.insertContent(this.value());
				}       
			}, // span6 + span3 + span3 ends
			
		]
	}, // column ends
		
			// vertical spacer starts
			{
				text: 'Vertical spacer / gap',
				value: '<p>[dtr_spacer height="20px"]</p>',
				onclick: function(e) {
					e.stopPropagation();
					editor.insertContent(this.value());
				}   
			}, // vertical spacer ends 
			
			// horizontal spacer starts
			{
				text: 'Horizontal spacer / gap',
				value: '<p>[dtr_spacer_wide width="20px"]</p>',
				onclick: function(e) {
					e.stopPropagation();
					editor.insertContent(this.value());
				}   
			}, // horizontal spacer ends 
			
			// Separator start
			{
			 text: 'Separator',
			 onclick: function() {
			 editor.windowManager.open( {
				title: 'Insert Separator',
				width: 500,
				height: 400,
				autoScroll: true, 
				classes: 'dtr-tinymce-modal',
				body: [
				// Separator attr starts
				{
					 type: 'textbox', /* field type */
					 name: 'color', /* field name */
					 label: 'Separator Color',
					 classes: 'colorpicker', /* field class */
				},
				// note
				{   type: 'container',
					html: '<p><small>* Leave blank for default</small></p>'
				}, // note ends  
				{
					type: 'textbox',
					name: 'width',
					label: 'Divider Width'
				},
				// note
				{   type: 'container',
					html: '<p><small>* Provide unit to width. Ex. 50%</small></p>'
				}, // note ends  
				{
					type: 'textbox',
					name: 'border_width',
					label: 'Border Width'
				},
				{   type: 'container',
					html: '<p><small>* Provide unit to border width. Ex. 2px</small></p>'
				}, // note ends  
				{
				type: 'listbox', 
				name: 'border_style', 
				label: 'Border Style', 
				'values': [
					{text: 'Default - Solid', value: ''},
					{text: 'Dashed', value: 'dashed'},
					{text: 'Dotted', value: 'dotted'},
				]
				},
				{
					type: 'textbox',
					name: 'margin_top',
					label: 'Margin Top'
				},
				{
					type: 'textbox',
					name: 'margin_bottom',
					label: 'Margin Bottom'
				},
				// note
				{   type: 'container',
					html: '<p><small>* Provide unit to margins. Ex. 20px</small></p>'
				}, // note ends  
				{
				type: 'listbox', 
				name: 'align', 
				label: 'Align', 
				'values': [
					{text: 'Default - Left', value: 'left'},
					{text: 'Right', value: 'right'},
					{text: 'Center', value: 'center'},
				]
				},
				// note
				{   type: 'container',
					html: '<div style="height: 100px;"></div>'
				}, // note ends  
				 // Separator attr ends
				 ], // body
			onsubmit: function( e ) {
			editor.insertContent( '<p>[dtr_separator  width="'+e.data.width+'" margin_top="'+e.data.margin_top+'" margin_bottom="'+e.data.margin_bottom+'" align="'+e.data.align+'" border_width="'+e.data.border_width+'" border_style="'+e.data.border_style+'" color="'+e.data.color+'"]</p>');
			}
			});
			/* Initialize our colorpicker */
			var windows = editor.windowManager.getWindows()[0]; 
			var $el = jQuery( windows.$el[0] ); 
			if( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ) {
				$el.find( '.mce-colorpicker' ).wpColorPicker();
			} // colorpicker
			
		  }
		},  // Separator ends

           ]
        }); // Layout shortcode ends

		/* Icon Shortcode */
		// Register the command for icons
       editor.addCommand('dtr_icon', function () {
			editor.windowManager.open({
			title: "Icons",
			url: url + '/icon-shortcode-popup.php',
			width: 500,
			height: 400
			});
        });

		// Register button for icons
		editor.addButton('dtr_icon', {
			title: 'Icons',
			cmd: 'dtr_icon',
			image: url + '/img/icon-sc-icons.png'
        }); // icons button
		/* Icon Shortcode ends */	

	// Typography shortcode starts
	editor.addButton( 'dtr_typography', {
		// title: 'Typography',
		text: 'Typography',
		type: 'menubutton',
		// drpdown level 1 starts
		menu: [
		{
			text: 'Text Style',
			value: '[dtr_text_style size="" color="" font_weight="" line_height="" letter_spacing="" class=""]Content here[/dtr_text_style]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}   
		}, // Text Style ends 
		// Blockquote starts
		{
			text: 'Blockquote',
			value: '',
			onclick: function() {
				editor.insertContent(this.value());
			},
		// level 2
		menu: [
		{
			text: 'Blockquote - Left Border',
			value: '[dtr_blockquote style="with_border" source="" class=""]Content here[/dtr_blockquote]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		},
		{
			text: 'Blockquote - Right Border',
			value: '[dtr_blockquote style="with_right_border" source="" class=""]Content here[/dtr_blockquote]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		},
		{
			text: 'Blockquote - Quote Icon',
			value: '[dtr_blockquote style="with_icon" source="" class=""]Content here[/dtr_blockquote]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		},
		] // level 2 ends
		},
		// Blockquote ends
		{
			text: 'Text With Icon',
			value: '[dtr_listicon color="" font_size="" line_height="" icon_type="icon-glass" icon_color="" list_content="Some Text Here"]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		}, // Text With Icon ends
		{
			text: 'Dropcap',
			value: '',
			onclick: function() {
				editor.insertContent(this.value());
			},
		// level 2
		menu: [
		{
			text: 'Dropcap Style - Default',
			value: '[dtr_dropcap bgcolor="" color=""]T[/dtr_dropcap]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		},
		{
			text: 'Dropcap Style - Circle',
			value: '[dtr_dropcap style="dtr-dropcap-circle" bgcolor="" color=""]T[/dtr_dropcap]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		},
		{
			text: 'Dropcap Style - Square',
			value: '[dtr_dropcap style="dtr-dropcap-square" bgcolor="" color=""]T[/dtr_dropcap]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		},
		] // level 2 ends
		}, // dropcap ends
		{
			text: 'Highlight',
			value: '[dtr_highlight bgcolor="" color="" font_size=""]Content here[/dtr_highlight]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}   
		}, // highlight ends 
		
		] // drpdown level 1 ends
	}); // Typography shortcode ends

	// Button shortcode ends
	editor.addButton( 'dtr_button', {
		title : 'Button Shortcode',
	    image: url + '/img/icon-sc-button.png',
		onclick: function() {
			editor.windowManager.open( {
				title: 'Insert Button',
				autoScroll: true, 
				width: 520, // size of window
				height: 400, // size of window
				classes: 'dtr-tinymce-modal', 
				body: [
				{
					type: 'textbox',
					name: 'btn_text',
					label: 'Button Text'
				}, 
				{
					type: 'textbox',
					name: 'url',
					label: 'Button Link URL'
				}, 
				{
					 type: 'textbox',
					 name: 'bg_color', 
					 label: 'Button Background Color',
					 classes: 'colorpicker', 
				},
				{
					 type: 'textbox', 
					 name: 'color', 
					 label: 'Button Text Color',
					 classes: 'colorpicker',
				},
				{
					type: 'textbox',
					name: 'icon_name',
					label: 'Icon Name'
				},
				{
					type: 'listbox', 
					name: 'icon_position', 
					label: 'Icon Position', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'Icon To Left', value: 'left'},
						{text: 'Icon To Right', value: 'right'},
					]
				 },
				{
					type: 'listbox', 
					name: 'target', 
					label: 'Open Link in', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'New Window', value: 'blank'},
						{text: 'Same Window', value: 'self'},
					]
				 },
				 {
					type: 'listbox', 
					name: 'size', 
					label: 'Button Size', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'Medium', value: 'medium'},
						{text: 'Big', value: 'big'},
					]
				 },
				{
					type: 'textbox',
					name: 'class',
					label: 'Custom Class'
				},
				// note
				{   type: 'container',
					 html: '<p><small>* Leave Text field blank for Icon Only Button <br> * Leave Icon field blank for Text Only Button <br> * Leave color fields blank for default colors</small></p>'
				}, // note ends  
				], // body
			onsubmit: function( e ) {
				editor.insertContent( '[dtr_button color="'+e.data.color+'" bg_color="'+e.data.bg_color+'" url="'+e.data.url+'" btn_text="'+e.data.btn_text+'" icon_name="'+e.data.icon_name+'"  icon_position="'+e.data.icon_position+'"  color="'+e.data.color+'" size="'+e.data.size+'" target="'+e.data.target+'" class="'+e.data.class+'" ]');
			}
			});
			/* Initialize our Colorpicker */
			var windows = editor.windowManager.getWindows()[0]; 
			var $el = jQuery( windows.$el[0] ); 
			if( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ) {
				$el.find( '.mce-colorpicker' ).wpColorPicker();
			} // colorpicker
		}
	}); // Button shortcode	ends	
	
	// Elements shortcode Starts
		editor.addButton( 'dtr_elements', {
            title: 'Elements',
            type: 'menubutton',
            image: url + '/img/icon-sc-elements.png',
            menu: [
			
		// List starts
		{
			text: 'Lists',
			value: '',
			onclick: function() {
				editor.insertContent(this.value());
			},
		// level 2
		menu: [
		{
			text: 'Ordered List',
			value: '[dtr_ordered_list color="" font_size="" line_height="" list_style="decimal / lower-alpha"]<p>[dtr_list_item]List item one[/dtr_list_item]</p><p>[dtr_list_item]List item two[/dtr_list_item]</p><p>[dtr_list_item]List item three[/dtr_list_item]</p>[/dtr_ordered_list]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		},
		{
			text: 'Unordered List',
			value: '[dtr_list color="" font_size="" line_height="" list_style="square / disc"]<p>[dtr_list_item]List item one[/dtr_list_item]</p><p>[dtr_list_item]List item two[/dtr_list_item]</p><p>[dtr_list_item]List item three[/dtr_list_item]</p>[/dtr_list]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		},
		{
			text: 'Checkmark List',
			value: '[dtr_checkmark_list color="" size="default / medium"]<p>[dtr_list_item]List item one[/dtr_list_item]</p><p>[dtr_list_item]List item two[/dtr_list_item]</p><p>[dtr_list_item]List item three[/dtr_list_item]</p>[/dtr_checkmark_list]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		}, // list with checkmark
		{
			text: 'Circle Checkmark List',
			value: '[dtr_checkmark_circle_list color="" size="default / medium"]<p>[dtr_list_item]List item one[/dtr_list_item]</p><p>[dtr_list_item]List item two[/dtr_list_item]</p><p>[dtr_list_item]List item three[/dtr_list_item]</p>[/dtr_checkmark_circle_list]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		}, // list with Circle Checkmark
		{
			text: 'Square Checkmark List',
			value: '[dtr_checkmark_square_list color="" size="default / medium"]<p>[dtr_list_item]List item one[/dtr_list_item]</p><p>[dtr_list_item]List item two[/dtr_list_item]</p><p>[dtr_list_item]List item three[/dtr_list_item]</p>[/dtr_checkmark_square_list]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		}, // list with Square Checkmark
		{
			text: 'Circle List',
			value: '[dtr_circle_list color="" size="default / medium"]<p>[dtr_list_item]List item one[/dtr_list_item]</p><p>[dtr_list_item]List item two[/dtr_list_item]</p><p>[dtr_list_item]List item three[/dtr_list_item]</p>[/dtr_circle_list]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		}, // list Circle
		{
			text: 'Heart List',
			value: '[dtr_heart_list color="" size="default / medium"]<p>[dtr_list_item]List item one[/dtr_list_item]</p><p>[dtr_list_item]List item two[/dtr_list_item]</p><p>[dtr_list_item]List item three[/dtr_list_item]</p>[/dtr_heart_list]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		}, // list Heart
		{
			text: 'Star List',
			value: '[dtr_star_list color="" size="default / medium"]<p>[dtr_list_item]List item one[/dtr_list_item]</p><p>[dtr_list_item]List item two[/dtr_list_item]</p><p>[dtr_list_item]List item three[/dtr_list_item]</p>[/dtr_star_list]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		}, // list Star
		{
			text: 'Arrow List',
			value: '[dtr_arrow_list color="" size="default / medium"]<p>[dtr_list_item]List item one[/dtr_list_item]</p><p>[dtr_list_item]List item two[/dtr_list_item]</p><p>[dtr_list_item]List item three[/dtr_list_item]</p>[/dtr_arrow_list]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		}, // list Arrow
		{
			text: 'Circle Arrow List',
			value: '[dtr_circle_arrow_list color="" size="default / medium"]<p>[dtr_list_item]List item one[/dtr_list_item]</p><p>[dtr_list_item]List item two[/dtr_list_item]</p><p>[dtr_list_item]List item three[/dtr_list_item]</p>[/dtr_circle_arrow_list]',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}         
		}, // list Circle Arrow
		] // level 2 ends
		},
		// List ends
		// tooltip
		{
			text: 'Tooltip',
			value: '<p>[dtr_tooltip url="" title="Content inside tooltip" placement="top/bottom/left/right"]Link text[/dtr_tooltip]</p>',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}   
		}, // tooltip ends
		// catbox start
			{
			 text: 'Category box',
			 onclick: function() {
			 editor.windowManager.open( {
				title: 'Insert Category box',
				autoScroll: true, 
				width: 500, 
				height: 420, 
				classes: 'dtr-tinymce-modal',
				body: [
				 {
						type: 'textbox',
						name: 'category_name',
						label: 'Category Name To Display'
				 },
				 {
					type: 'textbox',
					name: 'category_slug',
					label: 'Category Slug'
				 },
				{
					 type: 'textbox', 
					 name: 'color', 
					 label: 'Text Color',
					 classes: 'colorpicker', 
				},
				{
                     type: 'textbox', 
                     name: 'background_color', 
					 label: 'Background Color',
                     classes: 'colorpicker', 
                },
				{
					type: 'textbox',
					name: 'background_img',
					label: 'Background Image URL'
				},
				{
					type: 'listbox', 
					name: 'background_repeat', 
					label: 'Background Repeat', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'No Repeat', value: 'no-repeat'},
						{text: 'Repeat', value: 'repeat'},
						{text: 'Repeat X', value: 'repeat-x'},
						{text: 'Repeat Y', value: 'repeat-y'},
					]
				 },
				 {
					type: 'listbox', 
					name: 'background_size', 
					label: 'Background Size', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'Cover', value: 'cover'},
						{text: 'Contain', value: 'contain'},
					]
				 }, 
				 {
					type: 'listbox', 
					name: 'background_position', 
					label: 'Background Position', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'Center', value: 'center'},
						{text: 'Top', value: 'top'},
						{text: 'Right', value: 'right'},
						{text: 'Bottom', value: 'bottom'},
						{text: 'Left', value: 'left'},
					]
				 }, 
				 {
					type: 'listbox', 
					name: 'background_attachment', 
					label: 'Background Attachment', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'Fixed', value: 'fixed'},
						{text: 'Scroll', value: 'scroll'},
					]
				 },
				  // note
				 {   type: 'container',
					html: '<small>In case dark overlay not needed, add class :: dtr-overlay-none :: in below custom class textarea.</small>'
				 }, // note ends
				 {
					type: 'textbox',
					name: 'class',
					label: 'Custom Class'
				 } 
				 ], // body
			onsubmit: function( e ) {
				editor.insertContent( '[dtr_catbox category_name="'+e.data.category_name+'" category_slug="'+e.data.category_slug+'" color="'+e.data.color+'" background_img="'+e.data.background_img+'" background_color="'+e.data.background_color+'" background_repeat="'+e.data.background_repeat+'" background_size="'+e.data.background_size+'" background_position="'+e.data.background_position+'" background_attachment="'+e.data.background_attachment+'" class="'+e.data.class+'"]');
			}
			});
			/* Initialize our Colorpicker */
			var windows = editor.windowManager.getWindows()[0]; 
			var $el = jQuery( windows.$el[0] ); 
			if( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ) {
				$el.find( '.mce-colorpicker' ).wpColorPicker();
			} // colorpicker
				
		}
			}, // catbox ends    
		// linkbox start
			{
			 text: 'Link box',
			 onclick: function() {
			 editor.windowManager.open( {
				title: 'Insert Link box',
				autoScroll: true, 
				width: 500, 
				height: 420, 
				classes: 'dtr-tinymce-modal',
				body: [
				 {
						type: 'textbox',
						name: 'title',
						label: 'Title'
				 },
				 {
					type: 'textbox',
					name: 'sub_title',
					label: 'Sub Ttle'
				 },
				 {
					type: 'textbox',
					name: 'link_url',
					label: 'Link URL'
				 },
				{
					 type: 'textbox', 
					 name: 'color', 
					 label: 'Text Color',
					 classes: 'colorpicker', 
				},
				{
                     type: 'textbox', 
                     name: 'background_color', 
					 label: 'Background Color',
                     classes: 'colorpicker', 
                },
				{
					type: 'textbox',
					name: 'background_img',
					label: 'Background Image URL'
				},
				{
					type: 'listbox', 
					name: 'background_repeat', 
					label: 'Background Repeat', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'No Repeat', value: 'no-repeat'},
						{text: 'Repeat', value: 'repeat'},
						{text: 'Repeat X', value: 'repeat-x'},
						{text: 'Repeat Y', value: 'repeat-y'},
					]
				 },
				 {
					type: 'listbox', 
					name: 'background_size', 
					label: 'Background Size', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'Cover', value: 'cover'},
						{text: 'Contain', value: 'contain'},
					]
				 }, 
				 {
					type: 'listbox', 
					name: 'background_position', 
					label: 'Background Position', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'Center', value: 'center'},
						{text: 'Top', value: 'top'},
						{text: 'Right', value: 'right'},
						{text: 'Bottom', value: 'bottom'},
						{text: 'Left', value: 'left'},
					]
				 }, 
				 {
					type: 'listbox', 
					name: 'background_attachment', 
					label: 'Background Attachment', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'Fixed', value: 'fixed'},
						{text: 'Scroll', value: 'scroll'},
					]
				 },
				  // note
				 {   type: 'container',
					html: '<small>In case dark overlay not needed, add class :: dtr-overlay-none :: in below custom class textarea.</small>'
				 }, // note ends
				 {
					type: 'textbox',
					name: 'class',
					label: 'Custom Class'
				 } 
				 ], // body
			onsubmit: function( e ) {
				editor.insertContent( '[dtr_linkbox title="'+e.data.title+'" sub_title="'+e.data.sub_title+'" link_url="'+e.data.link_url+'" color="'+e.data.color+'" background_img="'+e.data.background_img+'" background_color="'+e.data.background_color+'" background_repeat="'+e.data.background_repeat+'" background_size="'+e.data.background_size+'" background_position="'+e.data.background_position+'" background_attachment="'+e.data.background_attachment+'" class="'+e.data.class+'"]');
			}
			});
			/* Initialize our Colorpicker */
			var windows = editor.windowManager.getWindows()[0]; 
			var $el = jQuery( windows.$el[0] ); 
			if( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ) {
				$el.find( '.mce-colorpicker' ).wpColorPicker();
			} // colorpicker
				
		}
			}, // catbox ends    
		// promobox start
			{
			 text: 'Promobox',
			 onclick: function() {
			 editor.windowManager.open( {
				title: 'Insert Promobox',
				autoScroll: true, 
				width: 500, 
				height: 420, 
				classes: 'dtr-tinymce-modal',
				body: [
				{
					 type: 'textbox', 
					 name: 'color', 
					 label: 'Text Color',
					 classes: 'colorpicker', 
				},
				{
                     type: 'textbox', 
                     name: 'background_color', 
					 label: 'Background Color',
                     classes: 'colorpicker', 
                },
				
				
				
				{
					type: 'textbox',
					name: 'background_img',
					label: 'Background Image URL'
				},
				{
					type: 'listbox', 
					name: 'background_repeat', 
					label: 'Background Repeat', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'No Repeat', value: 'no-repeat'},
						{text: 'Repeat', value: 'repeat'},
						{text: 'Repeat X', value: 'repeat-x'},
						{text: 'Repeat Y', value: 'repeat-y'},
					]
				 },
				 {
					type: 'listbox', 
					name: 'background_size', 
					label: 'Background Size', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'Cover', value: 'cover'},
						{text: 'Contain', value: 'contain'},
					]
				 }, 
				 {
					type: 'listbox', 
					name: 'background_position', 
					label: 'Background Position', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'Center', value: 'center'},
						{text: 'Top', value: 'top'},
						{text: 'Right', value: 'right'},
						{text: 'Bottom', value: 'bottom'},
						{text: 'Left', value: 'left'},
					]
				 }, 
				 {
					type: 'listbox', 
					name: 'background_attachment', 
					label: 'Background Attachment', 
					'values': [
						{text: 'Default', value: ''},
						{text: 'Fixed', value: 'fixed'},
						{text: 'Scroll', value: 'scroll'},
					]
				 },
				 {
						type: 'textbox',
						name: 'padding',
						label: 'Padding'
				 },
				 {
					type: 'textbox',
					name: 'margin',
					label: 'Margin'
				 },
				 // note
				 {   type: 'container',
					html: '<small>Padding / Margin : Give it in the order - Top Right Bottom Left. <br>Example: 20px 0 20px 0<br>Leave blank for default. Refer help doc for more info.</small>'
				 }, // note ends
				  {
					type: 'listbox', 
					name: 'align', 
					label: 'Text Align', 
					'values': [
						{text: 'Default - Center', value: 'text-center'},
						{text: 'Left', value: 'text-left'},
						{text: 'Right', value: 'text-center'},
					]
				 },
				 {
					type: 'textbox',
					name: 'class',
					label: 'Custom Class'
				 } 
				 ], // body
			onsubmit: function( e ) {
				editor.insertContent( '[dtr_promobox color="'+e.data.color+'" background_img="'+e.data.background_img+'" background_color="'+e.data.background_color+'" background_repeat="'+e.data.background_repeat+'" background_size="'+e.data.background_size+'" background_position="'+e.data.background_position+'" background_attachment="'+e.data.background_attachment+'" padding="'+e.data.padding+'" margin="'+e.data.margin+'" align="'+e.data.align+'" class="'+e.data.class+'"]</p><p>Promobox Content goes here</p><p>[/dtr_promobox]');
			}
			});
			/* Initialize our Colorpicker */
			var windows = editor.windowManager.getWindows()[0]; 
			var $el = jQuery( windows.$el[0] ); 
			if( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ) {
				$el.find( '.mce-colorpicker' ).wpColorPicker();
			} // colorpicker
				
		}
			}, // promobox ends    
		// Video Wrapper starts
		{
			text: 'Video Wrapper',
			value: '<p>[dtr_video_wrapper] Video Embed Code Here [/dtr_video_wrapper]</p>',
			onclick: function(e) {
				e.stopPropagation();
				editor.insertContent(this.value());
			}   
		}, // Video Wrapper ends 
		
           ] 
        }); // Elements shortcode ends

	
/* tinymce ends */
	}); // tinymce.PluginManager.add
})(); // end