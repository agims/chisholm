<?php
	function test() {
		$test = new ChisholmMetaBox();
		$test_array = array(
			'name'	=> 'test',
			'id'	=> '1',
		);
		
		echo $test->update_fields($test_array);
		
	}
	
	
	
	add_action('get_footer', 'test');