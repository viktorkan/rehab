<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Option_Type_Form_Builder_Item_Email extends FW_Option_Type_Form_Builder_Item {
	public function get_type() {
		return 'email';
	}

	private function get_uri( $append = '' ) {
		return fw_get_framework_directory_uri( '/extensions/forms/includes/option-types/' . $this->get_builder_type() . '/items/' . $this->get_type() . $append );
	}

	public function get_thumbnails() {
		return array(
			array(
				'html' =>
					'<div class="item-type-icon-title" data-hover-tip="' . esc_html__( 'Add an Email field', 'valeo' ) . '">' .
					'<div class="item-type-icon">' .
					'<img src="' . esc_attr( $this->get_uri( '/static/images/icon.png' ) ) . '" />' .
					'</div>' .
					'<div class="item-type-title">' . esc_html__( 'Email', 'valeo' ) . '</div>' .
					'</div>'
			)
		);
	}

	public function enqueue_static() {
		wp_enqueue_style(
			'fw-builder-' . $this->get_builder_type() . '-item-' . $this->get_type(),
			$this->get_uri( '/static/css/styles.css' )
		);

		wp_enqueue_script(
			'fw-builder-' . $this->get_builder_type() . '-item-' . $this->get_type(),
			$this->get_uri( '/static/js/scripts.js' ),
			array(
				'fw-events',
			),
			false,
			true
		);

		wp_localize_script(
			'fw-builder-' . $this->get_builder_type() . '-item-' . $this->get_type(),
			'fw_form_builder_item_type_' . $this->get_type(),
			array(
				'l10n'     => array(
					'item_title'      => esc_html__( 'Email', 'valeo' ),
					'label'           => esc_html__( 'Label', 'valeo' ),
					'toggle_required' => esc_html__( 'Toggle mandatory field', 'valeo' ),
					'edit'            => esc_html__( 'Edit', 'valeo' ),
					'delete'          => esc_html__( 'Delete', 'valeo' ),
					'edit_label'      => esc_html__( 'Edit Label', 'valeo' ),
				),
				'options'  => $this->get_options(),
				'defaults' => array(
					'type'    => $this->get_type(),
					'width'   => fw_ext( 'forms' )->get_config( 'items/width' ),
					'options' => fw_get_options_values_from_input( $this->get_options(), array() )
				)
			)
		);

		fw()->backend->enqueue_options_static( $this->get_options() );
	}

	private function get_options() {
		return array(
			array(
				'g1' => array(
					'type'    => 'group',
					'options' => array(
						array(
							'label' => array(
								'type'  => 'text',
								'label' => esc_html__( 'Label', 'valeo' ),
								'desc'  => esc_html__( 'Enter field label (it will be displayed on the web site)', 'valeo' ),
								'value' => esc_html__( 'Email', 'valeo' ),
							)
						),
						array(
							'required' => array(
								'type'  => 'switch',
								'label' => esc_html__( 'Mandatory Field', 'valeo' ),
								'desc'  => esc_html__( 'Make this field mandatory?', 'valeo' ),
								'value' => true,
							)
						),
					)
				)
			),
			array(
				'g2' => array(
					'type'    => 'group',
					'options' => array(
						array(
							'placeholder' => array(
								'type'  => 'text',
								'label' => esc_html__( 'Placeholder', 'valeo' ),
								'desc'  => esc_html__( 'This text will be used as field placeholder', 'valeo' ),
							)
						),
					)
				)
			),
			array(
				'g4' => array(
					'type'    => 'group',
					'options' => array(
						array(
							'info' => array(
								'type'  => 'textarea',
								'label' => esc_html__( 'Instructions for Users', 'valeo' ),
								'desc'  => esc_html__( 'The users will see these instructions in the tooltip near the field',
									'valeo' ),
							)
						),
					)
				)
			),
		);
	}

	protected function get_fixed_attributes( $attributes ) {
		// do not allow sub items
		unset( $attributes['_items'] );

		$default_attributes = array(
			'type'      => $this->get_type(),
			'shortcode' => false, // the builder will generate new shortcode if this value will be empty()
			'width'     => '',
			'options'   => array()
		);

		// remove unknown attributes
		$attributes = array_intersect_key( $attributes, $default_attributes );

		$attributes = array_merge( $default_attributes, $attributes );

		/**
		 * Fix $attributes['options']
		 * Run the _get_value_from_input() method for each option
		 */
		{
			$only_options = array();

			foreach ( fw_extract_only_options( $this->get_options() ) as $option_id => $option ) {
				if ( array_key_exists( $option_id, $attributes['options'] ) ) {
					$option['value'] = $attributes['options'][ $option_id ];
				}
				$only_options[ $option_id ] = $option;
			}

			$attributes['options'] = fw_get_options_values_from_input( $only_options, array() );

			unset( $only_options, $option_id, $option );
		}

		return $attributes;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_value_from_attributes( $attributes ) {
		return $this->get_fixed_attributes( $attributes );
	}

	/**
	 * {@inheritdoc}
	 */
	public function frontend_render( array $item, $input_value ) {
		$options = $item['options'];

		// prepare attributes
		{
			$attr = array(
				'type'        => 'text',
				'name'        => $item['shortcode'],
				'placeholder' => $options['placeholder'],
				'value'       => is_null( $input_value ) ? '' : $input_value,
				'id'          => 'id-' . fw_unique_increment(),
			);

			if ( $options['required'] ) {
				$attr['required'] = 'required';
			}
		}

		return fw_render_view(
			$this->locate_path( '/views/view.php', get_template_directory() . '/framework-customization/extensions/forms/form-builder/items/email/view.php' ),
			array(
				'item' => $item,
				'attr' => $attr,
			)
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function frontend_validate( array $item, $input_value ) {
		$options = $item['options'];

		$messages = array(
			'required'  => str_replace(
				array( '{label}' ),
				array( $options['label'] ),
				__( 'The {label} field is required', 'valeo' )
			),
			'incorrect' => str_replace(
				array( '{label}' ),
				array( $options['label'] ),
				__( 'The {label} field must contain a valid email', 'valeo' )
			),
		);

		if ( $options['required'] && ! fw_strlen( trim( $input_value ) ) ) {
			return $messages['required'];
		}

		if ( ! empty( $input_value ) && ! filter_var( $input_value, FILTER_VALIDATE_EMAIL ) ) {
			return $messages['incorrect'];
		}
	}
}

FW_Option_Type_Builder::register_item_type( 'FW_Option_Type_Form_Builder_Item_Email' );
