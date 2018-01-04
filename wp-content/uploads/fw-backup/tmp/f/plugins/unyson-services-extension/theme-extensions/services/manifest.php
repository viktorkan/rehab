<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = __( 'Services', 'fw' );
$manifest['description'] = __(
	'This extension will add a fully fledged services module that will let you display your services'
	.' using the built in services pages.',
	'fw'
);
$manifest['version'] = '1.0.6';
$manifest['display'] = true;
$manifest['standalone'] = true;

//$manifest['github_update'] = 'ThemeFuse/Unyson-Services-Extension';
