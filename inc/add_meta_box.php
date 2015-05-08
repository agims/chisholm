<?php
	function testing123() {
		$test = new ChisholmMetaBox();
		$test_array = array(
			'name'	=> array(
				'nice_name'	=> 'Name',
				'type'		=> 'text'
			),
		);
		
		$test->update_fields($test_array);
		echo $test->my_meta_box_callback();
		echo $test->spit_out_array($post);
	}
	
	
	
	add_action('get_footer', 'testing123');