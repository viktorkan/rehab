<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'style'   => array(
		'type'    => 'select',
		'label'   => esc_html__('Box Style', 'valeo'),
		'choices' => array(
			'fw-iconbox-1' => esc_html__('Icon above title', 'valeo'),
			'fw-iconbox-2' => esc_html__('Icon in line with title', 'valeo')
		)
	),
	'icon'    => array(
		'type'  => 'icon',
		'label' => esc_html__('Choose an Icon', 'valeo'),
		'set'  => 'theme-icons',
	),
	'title'   => array(
		'type'  => 'text',
		'label' => esc_html__( 'Title of the Box', 'valeo' ),
	),
	'content' => array(
		'type'  => 'textarea',
		'label' => esc_html__( 'Content', 'valeo' ),
		'desc'  => esc_html__( 'Enter the desired content', 'valeo' ),
	),
	'iconbox_type' => array(
		'type'    => 'select',
		'label'   => esc_html__( 'Testimonial Type', 'valeo' ),
		'desc'    => esc_html__( '', 'valeo' ),
		'choices' => array(
			'ib-type1'  => esc_html__( 'Type 1', 'valeo' ),
			'ib-type2' 	=> esc_html__( 'Type 2', 'valeo' ),
		)
	),
	'image'            => array(
		'type'  => 'upload',
		'label' => __( 'Choose Image Icon', 'valeo' ),
		'desc'  => __( 'Either upload a new, or choose an existing image from your media library', 'valeo' )
	),
);