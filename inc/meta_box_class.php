<?php
	
class ChisholmMetaBox {
		
	protected $fields = array(
		'name'	=> array(
			'nice_name'	=> 'Name',
			'type'		=> 'text'
		),
	);
	protected $screens = array();
	protected $mbid = "metabox";
	protected $title = FALSE;
	protected $to_return = FALSE;
	protected $states = array(
		"Alabama"				=> "AL",
		"Alaska"				=> "AK",
		"Arizona"				=> "AZ",
		"Arkansas"				=> "AR",
		"California"			=> "CA",
		"Colorado"				=> "CO",
		"Connecticut"			=> "CT",
		"Delaware"				=> "DE",
		"Florida"				=> "FL",
		"Georgia"				=> "GA",
		"Hawaii"				=> "HI",
		"Idaho"					=> "ID",
		"Illinois"				=> "IL",
		"Indiana"				=> "IN",
		"Iowa"					=> "IA",
		"Kansas"				=> "KS",
		"Kentucky"				=> "KY",
		"Louisiana"				=> "LA",
		"Maine"					=> "ME",
		"Maryland"				=> "MD",
		"Massachusetts"			=> "MA",
		"Michigan"				=> "MI",
		"Minnesota"				=> "MN",
		"Mississippi"			=> "MS",
		"Missouri"				=> "MO",
		"Montana"				=> "MT",
		"Nebraska"				=> "NE",
		"Nevada"				=> "NV",
		"New Hampshire"			=> "NH",
		"New Jersey"			=> "NJ",
		"New Mexico"			=> "NM",
		"New York"				=> "NY",
		"North Carolina"		=> "NC",
		"North Dakota"			=> "ND",
		"Ohio"					=> "OH",
		"Oklahoma"				=> "OK",
		"Oregon"				=> "OR",
		"Pennsylvania"			=> "PA",
		"Rhode Island"			=> "RI",
		"South Carolina"		=> "SC",
		"South Dakota"			=> "SD",
		"Tennessee"				=> "TN",
		"Texas"					=> "TX",
		"Utah"					=> "UT",
		"Vermont"				=> "VT",
		"Virginia"				=> "VA",
		"Washington"			=> "WA",
		"West Virginia"			=> "WV",
		"Wisconsin"				=> "WI",
		"Wyoming"				=> "WY",
		"American Samoa"		=> "AS",
		"District of Columbia"	=> "DC",
		"Federated States of Micronesia"
								=> "FM",
		"Guam"					=> "GU",
		"Marshall Islands"		=> "MH",
		"Northern Mariana Islands"
								=> "MP",
		"Palau"					=> "PW",
		"Puerto Rico"			=> "PR",
		"Virgin Islands"		=> "VI",
		"Armed Forces Africa"	=> "AE",
		"Armed Forces Americas"	=> "AA",
		"Armed Forces Canada"	=> "AE",
		"Armed Forces Europe"	=> "AE",
		"Armed Forces Middle East"
								=> "AE",
		"Armed Forces Pacific"	=> "AP"
	);
	
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
	
	public function my_meta_box_callback() {
		global $post;
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'myplugin_meta_box', 'myplugin_meta_box_nonce' );
	
		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		 		 
		 
		 echo '<table class="form-table">' . "\n";
		 echo "<tbody>\n";
		 
		 foreach($this->fields as $field_slug => $sub_fields) {
			 $min = 0;
			 $max = 0;
			 
			 echo $this->spit_out_array($sub_fields);
			 extract($sub_fields, EXTR_OVERWRITE);
			 
			 $$field_slug = get_post_meta( $post->ID, '_' . $field_slug, true );
			 
			 if($field_slug == 'price' || $field_slug == 'original_price' && $$field_slug) {
				 $$field_slug = number_format($$field_slug);
			 }
			 
			 echo "<tr>\n";
			 echo "<th>\n";
			 echo '<label for="' . $field_slug . '">' . $nice_name . '</label>';
			 echo "</th>\n";
			 echo "<td>\n";
			 $this->meta_input_type($type, $field_slug, $$field_slug, $min, $max, $increment);
			 echo "</td>\n";
			 echo "</tr>\n";
	
		 }
		 echo "</tbody>\n";
		 echo "</table>\n";
		
	}

	protected function meta_input_type($type="text", $name, $value, $min=1, $max=5, $increment=1) {
		switch ($type) {
			case "text":
				echo '<input type="text" id="' . $name . '" name="' . $name . '" value="' . esc_attr( $value ) . '" style="width: 100%;" />';
				break;
			case "dropdown":
				echo '<select name="' . $name . '" id="' . $name . '">';
				$i = $min;
				while ($i <= $max) {
					if($i == esc_attr($value)) {
						$selected = " selected";
					} else {
						$selected = "";
					}
					echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>' . "\n";
					$i = $i + $increment;
				}
				echo '</select>';
				break;
			case "state_dropdown":
				echo '<select name="' . $name . '" id="' . $name . '">';
				foreach($this->states as $state_name => $state_abbr) {
					if($value == NULL) {
						$value = 'TX';
					}
					if($value == $state_abbr) {
						$selected = " selected";
					} else {
						$selected = NULL;
					}
					echo '<option value="' . $state_abbr . '"' . $selected . '>' . $state_name . '</option>' . "\n";
				}
				echo '</select>';
				break;
			case "textarea":
				echo '<textarea id="' . $name . '" name="' . $name . '" rows=6 style="width: 100%;">' . esc_attr( $value ) . '</textarea>';
				break;
		}
	}
	
	public function add_actions() {
		add_action( 'add_meta_boxes', array($this, 'add_my_meta_box') );
		add_action( 'save_post', array($this, 'save_meta_box_data') );
	}
	
	protected function spit_out_array($the_array) {
		$this->to_return .= "<pre>\n";
		$this->to_return .= print_r($the_array, TRUE);
		$this->to_return .= "</pre>\n";
	}
}