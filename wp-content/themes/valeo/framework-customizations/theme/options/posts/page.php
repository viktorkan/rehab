<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'page-sidebar-section' => array(
		'title'   => esc_html__('Sidebar Position', 'valeo'),
		'type'    => 'box',
		'context' => 'normal',
		//'context' => 'normal|advanced|side',
		//'priority' => 'default|high|core|low',
		'options' => array(
			'sidebar_position' => array(
				'label'   => esc_html__( 'Sidebar position in category', 'valeo' ),
				'type'    => 'image-picker',
				'value'   => '',
				'desc'    => esc_html__( 'Select sidebar position for certain category.', 'valeo' ),
				'attr'    => array(
					'data-height' => 100,
				),
				'choices' => array(
					'default' => array(
						'small' => array(
							'height' => 100,
							'src'    => esc_url(get_template_directory_uri()) . '/images/sidebar_default.png'
						),
					),
					'right' => array(
						'small' => array(
							'height' => 100,
							'src'    => esc_url(get_template_directory_uri()) . '/images/sidebar_right.png'
						),
					),
					'left' => array(
						'small' => array(
							'height' => 100,
							'src'    => esc_url(get_template_directory_uri()) . '/images/sidebar_left.png'
						),
					),
					'none' => array(
						'small' => array(
							'height' => 100,
							'src'    => esc_url(get_template_directory_uri()) . '/images/sidebar_no.png'
						),
					),
				),
				'help'    => sprintf( "%s \n\n<br/><br/>\n\n <b>%s</b>",
					esc_html__( 'You can select sidebar position for certain category.', 'valeo' ),
					esc_html__( 'If chosen, global value will be overridden.', 'valeo' )
				),
			),
		),
	),
);