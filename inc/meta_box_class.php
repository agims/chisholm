<?php
	
class ChisholmMetaBox {
		
	private $fields = array();
	private $screens = array();
	private $mbid = "metabox" . rand(0,100000);
	private $title = FALSE;
	private $to_return = FALSE;
	
	public function update_fields($fields) {
		if(is_array($fields)) {
			$this->fields = $fields;
			return TRUE;
		} else {
			return "Not an array";
		}
	}
	
	public function update_screens($screens) {
		if(is_array($screens)) {
			$this->screens = $screens;
			return TRUE;
		} else {
			return "Not an array";
		}
	}
	
	public function update_meta_box_title($title = "Meta Box") {
		$this->title = $title;
	}
	
	public function update_meta_box_id($id) {
		$this->mbid = $id;
	}
	
	public function update_all($fields, $screens, $title = "Meta Box", $id) {
		if($this->update_fields($fields) != TRUE) {
			return FALSE;
		}
		if($this->update_screens($screens) != TRUE) {
			return FALSE;
		}
		$this->update_meta_box_title($title);
		$this->update_meta_box_id($id);
	}
	
	public function add_my_meta_box() {
		
		foreach($this->screens as $screen) {
			add_meta_box($this->mbid, __( $this->title, 'chisholm' ), array($this, 'my_meta_box_callback'), $screen, 'normal', 'high');
		}
		
	}
	
	public function my_meta_box_callback($post) {
		
		
		
	}
	
	public function add_actions() {
		add_action( 'add_meta_boxes', array($this, 'add_my_meta_box') );
		add_action( 'save_post', array($this, 'save_meta_box_data') );
	}
	
	private function spit_out_array($the_array) {
		$this->to_return .= "<pre>\n";
		$this->to_return .= print_r($the_array, TRUE);
		$this->to_return .= "</pre>\n";
	}
}