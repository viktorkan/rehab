<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	// Group
	// Section width
	'section_width_group'    => array(
		'type'    => 'group',
		'options' => array(
			'is_fullwidth'  => array(
				'label' => esc_html__( 'Full Width', 'valeo' ),
				'type'  => 'switch',
			),
			'no_padding'    => array(
				'label' => esc_html__( 'Full Width no padding', 'valeo' ),
				'type'  => 'switch',
			),
			'has_container' => array(
				'label' => esc_html__( 'Has Container', 'valeo' ),
				'type'  => 'switch',
			),
		)
	),
	// Group
	// Background color
	'background_color_group' => array(
		'type'    => 'group',
		'options' => array(
			'background_color'    => array(
				'label' => esc_html__( 'Background Color', 'valeo' ),
				'desc'  => esc_html__( 'Please select the background color', 'valeo' ),
				'type'  => 'color-picker',
			),
			'has_dark_background' => array(
				'label' => esc_html__( 'Dark Background', 'valeo' ),
				'type'  => 'switch',
			),
		)
	),
	// Group
	// Background image
	'background_image_group' => array(
		'type'    => 'group',
		'options' => array(
			'background_image'         => array(
				'label'         => esc_html__( 'Background Image', 'valeo' ),
				'desc'          => esc_html__( 'Please select the background image', 'valeo' ),
				'type'          => 'background-image',
				'choices'       => array(//	in future may will set predefined images
				),
				'inner-options' => array(
					'option_1' => array( 'type' => 'text' ),
					'option_2' => array( 'type' => 'textarea' ),
				)
			),
			'background_image_overlay' => array(
				'label' => esc_html__( 'Background Image Overlay', 'valeo' ),
				'desc'  => esc_html__( 'Please select the overlay color for background image', 'valeo' ),
				'type'  => 'color-picker',
			),
			'background_repeat'        => array(
				'type'    => 'radio',
				'value'   => 'repeat',
				'label'   => esc_html__( 'Background Repeat', 'valeo' ),
				'choices' => array(
					'no-repeat' => esc_html__( 'No Repeat', 'valeo' ),
					'repeat'    => esc_html__( 'Tile', 'valeo' ),
					'repeat-x'  => esc_html__( 'Tile Horizontally', 'valeo' ),
					'repeat-y'  => esc_html__( 'Tile Vertically', 'valeo' ),
				),
				'inline'  => true,
			),
			'background_position'      => array(
				'type'    => 'radio',
				'value'   => 'center',
				'label'   => esc_html__( 'Background Position', 'valeo' ),
				'choices' => array(
					'left'   => esc_html__( 'Left', 'valeo' ),
					'center' => esc_html__( 'Center', 'valeo' ),
					'right'  => esc_html__( 'Right', 'valeo' ),
				),
				'inline'  => true,
			),
			'background_attachment'    => array(
				'type'    => 'radio',
				'value'   => 'scroll',
				'label'   => esc_html__( 'Background Attachment', 'valeo' ),
				'choices' => array(
					'scroll' => esc_html__( 'Scroll', 'valeo' ),
					'fixed'  => esc_html__( 'Fixed', 'valeo' ),
				),
				'inline'  => true,
			),
			'background_size'          => array(
				'type'    => 'radio',
				'value'   => 'scroll',
				'label'   => esc_html__( 'Background Size', 'valeo' ),
				'choices' => array(
					'initial' => esc_html__( 'Initial', 'valeo' ),
					'contain' => esc_html__( 'Contain', 'valeo' ),
					'cover'   => esc_html__( 'Cover', 'valeo' ),
				),
				'inline'  => true,
			),
			'has_parallax'             => array(
				'label' => esc_html__( 'Background image Parallax', 'valeo' ),
				'type'  => 'switch',
			),
		)
	),
	// Background video
	'video'                  => array(
		'label' => esc_html__( 'Background Video', 'valeo' ),
		'desc'  => esc_html__( 'Insert Video URL to embed this video', 'valeo' ),
		'type'  => 'text',
	),
	'custom_class'           => array(
		'label' => esc_html__( 'Custom Class', 'valeo' ),
		'desc'  => esc_html__( 'Add custom class for section', 'valeo' ),
		'type'  => 'text',
	)
);
