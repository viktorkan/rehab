<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'label'  => array(
		'label' => esc_html__( 'Button Label', 'valeo' ),
		'desc'  => esc_html__( 'This is the text that appears on your button', 'valeo' ),
		'type'  => 'text',
		'value' => 'Submit'
	),
	'link'   => array(
		'label' => esc_html__( 'Button Link', 'valeo' ),
		'desc'  => esc_html__( 'Where should your button link to', 'valeo' ),
		'type'  => 'text',
		'value' => '#'
	),
	'target' => array(
		'type'  => 'switch',
		'label'   => esc_html__( 'Open Link in New Window', 'valeo' ),
		'desc'    => esc_html__( 'Select here if you want to open the linked page in a new window', 'valeo' ),
		'right-choice' => array(
			'value' => '_blank',
			'label' => esc_html__('Yes', 'valeo'),
		),
		'left-choice' => array(
			'value' => '_self',
			'label' => esc_html__('No', 'valeo'),
		),
	),
	'color'  => array(
		'label'   => esc_html__( 'Button Color', 'valeo' ),
		'desc'    => esc_html__( 'Choose a color for your button', 'valeo' ),
		'type'    => 'select',
		'choices' => array(
			''      => esc_html__('Default', 'valeo'),
			'black' => esc_html__( 'Black', 'valeo' ),
			'blue'  => esc_html__( 'Blue', 'valeo' ),
			'green' => esc_html__( 'Green', 'valeo' ),
			'red'   => esc_html__( 'Red', 'valeo' ),
		)
	),
	'centered' => array(
		'type'    => 'switch',
		'label'   => esc_html__('Centered', 'valeo'),
	),
);