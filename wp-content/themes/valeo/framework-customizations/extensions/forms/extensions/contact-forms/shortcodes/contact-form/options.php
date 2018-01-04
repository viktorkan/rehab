<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'main' => array(
		'type'    => 'box',
		'title'   => '',
		'options' => array(
			'id'       => array(
				'type'  => 'unique',
			),
			'builder'  => array(
				'type'    => 'tab',
				'title'   => esc_html__( 'Form Fields', 'valeo' ),
				'options' => array(
					'form' => array(
						'label' => false,
						'type'  => 'form-builder',
						'value' => array(
							'json' => json_encode( array(
								array(
									'type'      => 'form-header-title',
									'shortcode' => 'form_header_title',
									'width'     => '',
									'options'   => array(
										'title'    => '',
										'subtitle' => '',
									)
								)
							) )
						),
						'fixed_header' => true,
					),
				),
			),
			'settings' => array(
				'type'    => 'tab',
				'title'   => esc_html__( 'Settings', 'valeo' ),
				'options' => array(
					'settings-options' => array(
						'title'   => esc_html__( 'Options', 'valeo' ),
						'type'    => 'tab',
						'options' => array(
							'form_text_settings'  => array(
								'type'    => 'group',
								'options' => array(
									'subject-group' => array(
										'type' => 'group',
										'options' => array(
											'subject_message'    => array(
												'type'  => 'text',
												'label' => esc_html__( 'Subject Message', 'valeo' ),
												'desc' => esc_html__( 'This text will be used as subject message for the email', 'valeo' ),
												'value' => esc_html__( 'New message', 'valeo' ),
											),
										)
									),
									'submit-button-group' => array(
										'type' => 'group',
										'options' => array(
											'submit_button_text' => array(
												'type'  => 'text',
												'label' => esc_html__( 'Submit Button', 'valeo' ),
												'desc' => esc_html__( 'This text will appear in submit button', 'valeo' ),
												'value' => esc_html__( 'Send', 'valeo' ),
											),
										)
									),
									'success-group' => array(
										'type' => 'group',
										'options' => array(
											'success_message'    => array(
												'type'  => 'text',
												'label' => esc_html__( 'Success Message', 'valeo' ),
												'desc' => esc_html__( 'This text will be displayed when the form will successfully send', 'valeo' ),
												'value' => esc_html__( 'Message sent!', 'valeo' ),
											),
										)
									),
									'failure_message'    => array(
										'type'  => 'text',
										'label' => esc_html__( 'Failure Message', 'valeo' ),
										'desc' => esc_html__( 'This text will be displayed when the form will fail to be sent', 'valeo' ),
										'value' => esc_html__( 'Oops something went wrong.', 'valeo' ),
									),
								),
							),
							'form_email_settings' => array(
								'type'    => 'group',
								'options' => array(
									'email_to' => array(
										'type'  => 'text',
										'label' => esc_html__( 'Email To', 'valeo' ),
										'help' => esc_html__( 'We recommend you to use an email that you verify often', 'valeo' ),
										'desc'  => esc_html__( 'The form will be sent to this email address.', 'valeo' ),
									),
								),
							),
							'form_type' => array(
								'type'    => 'select',
								'label'   => esc_html__( 'Form Type', 'valeo' ),
								'desc'    => esc_html__( '', 'valeo' ),
								'choices' => array(
									'cf-type1'  => esc_html__( 'Type 1', 'valeo' ),
									'cf-type2' 	=> esc_html__( 'Type 2', 'valeo' ),
									'cf-type3' 	=> esc_html__( 'Type 3', 'valeo' ),
								)
							),
						)
					),
					'mailer-options'   => array(
						'title'   => esc_html__( 'Mailer', 'valeo' ),
						'type'    => 'tab',
						'options' => array(
							'mailer' => array(
								'label' => false,
								'type'  => 'mailer'
							)
						)
					)
				),
			),
		),
	)
);