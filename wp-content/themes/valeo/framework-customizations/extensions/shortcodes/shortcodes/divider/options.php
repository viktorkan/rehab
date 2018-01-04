<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'style' => array(
		'type'     => 'multi-picker',
		'label'    => false,
		'desc'     => false,
		'picker' => array(
			'ruler_type' => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Ruler Type', 'valeo' ),
				'desc'    => esc_html__( 'Here you can set the styling and size of the HR element', 'valeo' ),
				'choices' => array(
					'line'  	=> esc_html__( 'Line', 'valeo' ),
					'space' 	=> esc_html__( 'Whitespace', 'valeo' ),
					'space--05x' => esc_html__( 'Predefined -0.5x', 'valeo' ),
					'space-05x' => esc_html__( 'Predefined 0.5x', 'valeo' ),
					'space-10x' => esc_html__( 'Predefined 1.0x', 'valeo' ),
					'space-15x' => esc_html__( 'Predefined 1.5x', 'valeo' ),
					'space-18x' => esc_html__( 'Predefined 1.8x', 'valeo' ),
					'space-20x' => esc_html__( 'Predefined 2.0x', 'valeo' ),
					'space-25x' => esc_html__( 'Predefined 2.5x', 'valeo' ),
					'space-30x' => esc_html__( 'Predefined 3.0x', 'valeo' ),
					'space-40x' => esc_html__( 'Predefined 4.0x', 'valeo' ),
					'space-45x' => esc_html__( 'Predefined 4.5x', 'valeo' ),
					'space-50x' => esc_html__( 'Predefined 5.0x', 'valeo' ),
					'space-52x' => esc_html__( 'Predefined 5.2x', 'valeo' ),
					'space-55x' => esc_html__( 'Predefined 5.5x', 'valeo' ),
					'space-56x' => esc_html__( 'Predefined 5.6x', 'valeo' ),
					'space-60x' => esc_html__( 'Predefined 6.0x', 'valeo' ),
					'space-65x' => esc_html__( 'Predefined 6.5x', 'valeo' ),
					'space-68x' => esc_html__( 'Predefined 6.8x', 'valeo' ),
					'space-70x' => esc_html__( 'Predefined 7.0x', 'valeo' ),
					'space-72x' => esc_html__( 'Predefined 7.2x', 'valeo' ),
				)
			)
		),
		'choices'     => array(
			'space' => array(
				'height' => array(
					'label' => esc_html__( 'Height', 'valeo' ),
					'desc'  => esc_html__( 'How much whitespace do you need? Enter a pixel value. Positive value will increase the whitespace, negative value will reduce it. eg: \'50\', \'-25\', \'200\'', 'valeo' ),
					'type'  => 'text',
					'value' => '50'
				)
			)
		)
	)
);
