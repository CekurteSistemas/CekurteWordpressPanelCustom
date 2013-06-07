<?php

if( !defined('ABSPATH') ) exit;

function cekurte_wordpress_panel_custom_autoloader() {
	spl_autoload_register( function( $className )
	{
		$data = explode('\\', $className);
	
		$file = dirname( __FILE__ );
			
		foreach( $data as $name )
		{
			if( ($name == 'Cekurte') ) {
				continue;
			}
			
			$file .= DIRECTORY_SEPARATOR . $name;
		}
		
		$file .= '.php';
		
		if( realpath( $file ) !== false )
		{
			require_once $file;
		}
	});
}

add_action('init', 'cekurte_wordpress_panel_custom_autoloader');