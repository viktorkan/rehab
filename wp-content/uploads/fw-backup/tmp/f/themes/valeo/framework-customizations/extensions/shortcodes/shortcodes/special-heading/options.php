<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'title'    => array(
		'type'  => 'text',
		'label' => esc_html__( 'Heading Title', 'valeo' ),
		'desc'  => esc_html__( 'Write the heading title content', 'valeo' ),
	),
	'subtitle' => array(
		'type'  => 'text',
		'label' => esc_html__( 'Heading Subtitle', 'valeo' ),
		'desc'  => esc_html__( 'Write the heading subtitle content', 'valeo' ),
	),
	'heading' => array(
		'type'    => 'select',
		'label'   => esc_html__('Heading Size', 'valeo'),
		'choices' => array(
            'h1' => 'H1',
            'h2' => 'H2',
            'h3' => 'H3',
            'h4' => 'H4',
            'h5' => 'H5',
            'h6' => 'H6',
            'p' => 'p',
        )
	),
    'font_weight' => array(
        'type'  => 'text',
        'label' => esc_html__( 'Font Weight', 'valeo' ),
        'desc'  => esc_html__( '', 'valeo' ),
    ),
    'text_color' => array(
        'label' => esc_html__('Text Color', 'valeo'),
        'desc'  => esc_html__('Please select the text color', 'valeo'),
        'type'  => 'color-picker',
    ),
	'centered' => array(
		'type'    => 'switch',
		'label'   => esc_html__('Centered', 'valeo'),
	),
	'custom_css_class'   => array(
		'type'  => 'text',
		'label' => esc_html__( 'Custom CSS Classes', 'valeo' ),
	),
);
