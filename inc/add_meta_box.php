<?php
	function testing123() {
		$test = new ChisholmMetaBox();
		$test_array = array(
			'name'	=> 'test',
			'id'	=> '1',
		);
		
		echo $test->update_fields($test_array);
		echo "It Ran";
	}
	
	
	
	add_action('get_footer', 'testing123');