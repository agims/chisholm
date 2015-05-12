<?php
	
	function initiate_meta_boxes() {
		$show_code = new ChisholmMetaBox();
		
		$show_code->update_type_of_box('info');
		$show_code->update_screens(array('chisholm_cta'));
		$show_code->update_meta_box_title('Shortcode');
		$show_code->update_meta_box_id('cta_shortcode');
		
		$show_code->add_box();
		
	}
	
	add_action('add_meta_boxes', 'initiate_meta_boxes');
	