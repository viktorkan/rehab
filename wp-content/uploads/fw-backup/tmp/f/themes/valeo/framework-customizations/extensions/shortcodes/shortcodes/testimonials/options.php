<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'title'         => array(
		'label' => esc_html__( 'Title', 'valeo' ),
		'desc'  => esc_html__( 'Option Testimonials Title', 'valeo' ),
		'type'  => 'text',
	),
	'testimonials' => array(
		'label'         => esc_html__( 'Testimonials', 'valeo' ),
		'popup-title'   => esc_html__( 'Add/Edit Testimonial', 'valeo' ),
		'desc'          => esc_html__( 'Here you can add, remove and edit your Testimonials.', 'valeo' ),
		'type'          => 'addable-popup',
		'template'      => '{{=author_name}}',
		'popup-options' => array(
			'content'       => array(
				'label' => esc_html__( 'Quote', 'valeo' ),
				'desc'  => esc_html__( 'Enter the testimonial here', 'valeo' ),
				'type'  => 'textarea',
				'teeny' => true
			),
			'author_avatar' => array(
				'label' => esc_html__( 'Image', 'valeo' ),
				'desc'  => esc_html__( 'Either upload a new, or choose an existing image from your media library', 'valeo' ),
				'type'  => 'upload',
			),
			'author_name'   => array(
				'label' => esc_html__( 'Name', 'valeo' ),
				'desc'  => esc_html__( 'Enter the Name of the Person to quote', 'valeo' ),
				'type'  => 'text'
			),
			'author_job'    => array(
				'label' => esc_html__( 'Position', 'valeo' ),
				'desc'  => esc_html__( 'Can be used for a job description', 'valeo' ),
				'type'  => 'text'
			),
			'site_name'     => array(
				'label' => esc_html__( 'Website Name', 'valeo' ),
				'desc'  => esc_html__( 'Linktext for the above Link', 'valeo' ),
				'type'  => 'text'
			),
			'site_url'      => array(
				'label' => esc_html__( 'Website Link', 'valeo' ),
				'desc'  => esc_html__( 'Link to the Persons website', 'valeo' ),
				'type'  => 'text'
			)
		)
	),
	'testimonial_type' => array(
		'type'    => 'select',
		'label'   => esc_html__( 'Testimonial Type', 'valeo' ),
		'desc'    => esc_html__( '', 'valeo' ),
		'choices' => array(
			'tm-type1'  => esc_html__( 'Type 1', 'valeo' ),
			'tm-type2' 	=> esc_html__( 'Type 2', 'valeo' ),
		)
	),
);