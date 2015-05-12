<?php
/*
Plugin Name:		Chisholm
Plugin URI:			https://github.com/agims/chisholm
Description:		This is a WordPress Plugin to allow for adding a call to action (CTA) into your site either by injecting it into <code>the_content()</code> or having the user use a shortcode. - <strong>Version 0.2 - Elm</strong>
Version:			0.2
Author:				Chris G. Clapp
Author URI:			http://www.chrisclapp.com
Text Domain:		chisholm
GitHub Plugin URI:	https://github.com/agims/chisholm
GitHub Branch:		master
*/
 
 defined('ABSPATH') or die("Dude seriously?");
 
 if (!defined('CHISHOLM_VERSION_KEY'))
    define('CHISHOLM_VERSION_KEY', 'chisholm_version');

if (!defined('CHISHOLM_VERSION_NUM'))
    define('CHISHOLM_VERSION_NUM', '0.2');


 
 
 // Set up required files
 $files_to_require = array(
	 'checks.php',
	 'options-page.php',
	 'chisholm_cta.php',
	 'meta_box_class.php',
	 'add_meta_box.php',
	 'content_filter.php',
	 'shortcode.php',
	 'do-shortcode-widget.php',
 );
 
 foreach($files_to_require as $file_to_require) {
	 $filename = 'inc/' . $file_to_require;
	 require_once($filename);
 }
 
 
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'my_plugin_action_links' );

function my_plugin_action_links( $links ) {
   $links[] = '<a href="'. get_admin_url(null, 'options-general.php?page=chisholm-options') .'">Settings</a>';
   $links[] = '<a href="http://www.agims.com" target="_blank">AGI Marketing</a>';
   return $links;
}