<?php
	function testing123() {
		$test = new ChisholmMetaBox();
		$test_array = array(
			'name'	=> 'test',
			'id'	=> '1',
		);
		
		$test->update_fields($test_array);
	}
	
	
	
	add_action('get_footer', 'testing123');