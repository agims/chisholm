<?php
/*
Plugin Name:		Chisholm
Plugin URI:			https://github.com/agims/chisholm
Description:		This is a WordPress Plugin to inject extra content into <code>the_content()</code> - <strong>Version 0.1 - Jonah</strong>
Version:			0.1
Author:				Chris G. Clapp
Author URI:			http://www.chrisclapp.com
Text Domain:		chisholm
GitHub Plugin URI:	https://github.com/agims/chisholm
GitHub Branch:		master
*/
 
 defined('ABSPATH') or die("Dude seriously?");
 
 if (!defined('MYPLUGIN_VERSION_KEY'))
    define('MYPLUGIN_VERSION_KEY', 'chisholm_version');

if (!defined('MYPLUGIN_VERSION_NUM'))
    define('MYPLUGIN_VERSION_NUM', '0.1');


 
 
 // Set up required files
 $files_to_require = array(
	 'chisholm_cta.php',
	 'meta_box_class.php',
	 'add_meta_box.php',
//	 'scripts.php',
//	 'styles.php',
//	 'checks.php',
//	 'modal.php',
//	 'options-page.php',
//	 'session-setup.php',
	 // Uncomment while testing
	 //'temp.php',
 );
 
 foreach($files_to_require as $file_to_require) {
	 $filename = 'inc/' . $file_to_require;
	 require_once($filename);
 }
 
 
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'my_plugin_action_links' );

function my_plugin_action_links( $links ) {
   //$links[] = '<a href="'. get_admin_url(null, 'options-general.php?page=agi-modal-options') .'">Settings</a>';
   $links[] = '<a href="http://www.agims.com" target="_blank">AGI Marketing</a>';
   return $links;
}