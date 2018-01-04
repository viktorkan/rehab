<?php if (!defined('FW')) die('Forbidden');

$options = array(
	'orderby' => array(
	'label'   => esc_html__('Order by', 'valeo'),
	'desc'    => esc_html__('Choose the order by', 'valeo'),
	'type'    => 'select',
	'choices' => array(
		'rand'		=> esc_html__('Random order', 'valeo'),
		'ID'		=> esc_html__('Order by post id', 'valeo'),
		'author'	=> esc_html__('Order by author', 'valeo'),
		'title'		=> esc_html__('Order by title', 'valeo'),
		'date'		=> esc_html__('Order by date', 'valeo'),
		'modified'	=> esc_html__('Order by last modified date', 'valeo'),
		'parent'	=> esc_html__('Order by post/page parent id', 'valeo'),
		'none'		=> esc_html__('No order', 'valeo'),
	)
	),
	'order' => array(
		'label'   => esc_html__('Order', 'valeo'),
		'desc'    => esc_html__('Choose the order', 'valeo'),
		'type'    => 'select',
		'choices' => array(
			'DESC'   => esc_html__('DESC', 'valeo'),
			'ASC' 	 => esc_html__('ASC', 'valeo'),
		)
	),
	'posts_per_page' => array(
		'label'   => esc_html__('Posts', 'valeo'),
		'desc'    => esc_html__('Shoose how many post to list', 'valeo'),
		'type'    => 'text',
		'value'	  => 8
	),
	'columns' => array(
		'label'   => esc_html__('Columns', 'valeo'),
		'desc'    => esc_html__('Choose columns', 'valeo'),
		'type'    => 'select',
		'choices' => array(
			'2' => esc_html__( '2', 'valeo' ),
			'3' => esc_html__( '3', 'valeo' ),
			'4' => esc_html__( '4', 'valeo' ),
		)
	),
    'gallery' => array(
        'label'   => esc_html__('Gallery Style', 'valeo'),
        'type'    => 'select',
        'choices' => array(
            'regular' => esc_html__('Gallery Regular', 'valeo'),
            'alternate' => esc_html__('Gallery Alternate', 'valeo'),
            'extended' => esc_html__('Gallery Extended', 'valeo'),
        )
    ),
	'space' => array(
		'label'        => esc_html__('Use Space between ', 'valeo'),
		'type'         => 'switch',
	),
);