<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'acc_title'   => array(
		'label' => esc_html__( 'Title of the Accordion', 'valeo' ),
		'type'  => 'text',
		'value' => ''
	),
	'tabs' => array(
		'type'          => 'addable-popup',
		'label'         => __( 'Tabs', 'valeo' ),
		'popup-title'   => __( 'Add/Edit Tabs', 'valeo' ),
		'desc'          => __( 'Create your tabs', 'valeo' ),
		'template'      => '{{=tab_title}}',
		'popup-options' => array(
			'tab_title'   => array(
				'type'  => 'text',
				'label' => __('Title', 'valeo')
			),
			'tab_content' => array(
				'type'  => 'textarea',
				'label' => __('Content', 'valeo')
			)
		)
	),
	'btn_label'  => array(
		'label' => esc_html__( 'Button Label', 'valeo' ),
		'desc'  => esc_html__( 'This is the text that appears on your button', 'valeo' ),
		'type'  => 'text',
		'value' => ''
	),
	'btn_link'   => array(
		'label' => esc_html__( 'Button Link', 'valeo' ),
		'desc'  => esc_html__( 'Where should your button link to', 'valeo' ),
		'type'  => 'text',
		'value' => '#'
	),
	'acc_type' => array(
		'type'    => 'select',
		'label'   => esc_html__( 'Accordion Type', 'valeo' ),
		'desc'    => esc_html__( '', 'valeo' ),
		'choices' => array(
			'acc-type1'  => esc_html__( 'Type 1', 'valeo' ),
			'acc-type2' 	=> esc_html__( 'Type 2', 'valeo' ),
		)
	),
);