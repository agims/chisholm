<?php
	
class ChisholmMetaBox {
		
	private $fields = array();
	private $to_return = '';
	
	public function update_fields($fields) {
		if(is_array($fields)) {
			$this->fields = $fields;
			$this->spit_out_array($this->fields);
			return $this->$to_return;
		} else {
			return "Not an array";
		}
	}

	public function add_actions() {
		add_action( 'add_meta_boxes', array($this, 'add_meta_box') );
		add_action( 'save_post', array($this, 'save_meta_box_data') );
	}
	
	private function spit_out_array($the_array) {
		$this->to_return .= "<pre>\n";
		$this->to_return .= print_r($the_array, TRUE);
		$this->to_return .= "</pre>\n";
	}
}