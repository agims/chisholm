<?php
	
class ChisholmMetaBox {
		
	private $fields = array();
	
	public function update_fields($fields) {
		if(is_array($fields)) {
			$this->fields = $fields;
			spit_out_array($this->fields);
		}
	}

	public function add_actions() {
		add_action( 'add_meta_boxes', array($this, 'add_meta_box') );
		add_action( 'save_post', array($this, 'save_meta_box_data') );
	}
	
	private function spit_out_array($the_array) {
		echo "<pre>\n";
		print_r($the_array);
		echo "</pre>\n";
	}
}