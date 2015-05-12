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
	protected $type_of_box = 'input';
	protected $info_box_content = NULL;
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
	
	public function update_type_of_box($type_of_box = 'input') {
		switch ($type_of_box) {
			case "info":
				$this->type_of_box = 'info';
				break;
			default:
				$this->type_of_box = 'input';
		}
	}
	
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
//		global $post;
				
		
		// Add an nonce field so we can check for it later.
		wp_nonce_field( $this->mbid . '_meta_box', $this->mbid . '_meta_box_nonce' );
	
		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		 		
		
		if($this->type_of_box == 'input') {
			echo '<table class="form-table">' . "\n";
			echo "<tbody>\n";
		
			foreach($this->fields as $field_slug => $sub_fields) {
				$min = 0;
				$max = 0;
				$increment = 0;
				
				extract($sub_fields, EXTR_OVERWRITE);
				
				$$field_slug = get_post_meta( $post->ID, '_' . $field_slug, true );
								
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

		} elseif($this->type_of_box == 'info') {
			echo "Info Box here";
		}
		
	}
	
	/*
		Meta Input Type
			Type:
				text
					$name - the ID and Name for the input
					$value - the initial value of the field
					$disabled - whether or not the input is disabled

				dropdown
					$name - the ID and Name for the input
					$value - the initial value of the field
					$values - an array with the following structure (can be multiple):
						'$nicename'	=> '$value_to_be_stored'
							Store it where the nicename is stored as the key and
							the value to be stored as the value
						example:
						array(
							'Rob'		=> 'rob',
							'Chris'		=> 'chris',
							'W. Gene'	=> 'gene',
							'Sherry'	=> 'sherry'
						)
					$disabled - whether or not the input is disabled

				number_dropdown
					$name - the ID and Name for the input
					$value - the initial value of the field
					$values - an array with the following:
						'min'		=> Minimum Value
						'max'		=> Maximum Value
						'increment'	=> How do you want it incremented?
					$disabled - whether or not the input is disabled

				state_dropdown
					$name - the ID and Name for the input
					$value - the initial value of the field
					$disabled - whether or not the input is disabled

				textarea
					$name - the ID and Name for the input
					$value - the initial value of the field
					$disabled - whether or not the input is disabled
					
	*/
	protected function meta_input_type($type="text", $name, $value=NULL, $values = array(), $disabled = FALSE) {
		switch ($type) {

			case "text":
				echo '<input type="text" id="' . $name . '" name="' . $name . '" value="' . esc_attr( $value ) . '" style="width: 100%;" />';
				break;

			case "dropdown":
				echo '<select name="' . $name . '" id="' . $name . '">';
				foreach ($values as $key => $dvalue) {
					if($dvalue == $value) {
						$selected = " selected";
					} else {
						$selected = "";
					}
					echo '<option value="' . $dvalue . '"' . $selected . '>' . $key . '</option>' . "\n";
				}
				break;			

			case "number_dropdown":
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
	
	public function save_meta_box_data($post_id) {
		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */
	
		// Check if our nonce is set.
		
		$nonce_name = $this->mbid . '_meta_box';
		$nonce_value = $this->mbid . '_meta_box_nonce';
		
		if ( ! isset( $_POST[$nonce_value] ) ) {
			return;
		}
	
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST[$nonce_value], $nonce_name ) ) {
			return;
		}
	
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
	
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
	
		} else {
	
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
	
		/* OK, it's safe for us to save the data now. */
		
		foreach($this->fields as $field => $sub_fields) {
			
			$fieldname = '_' . $field;
			
			// Make sure that it is set.
			if ( ! isset( $_POST[$field] ) ) {
				return;
			}
			
			
			// Sanitize user input.
			$data = sanitize_text_field( $_POST[$property_field] );
			
			// Update the meta field in the database.
			update_post_meta( $post_id, $fieldname, $data );
		}
		
	
	}
	
	public function add_box() {
		add_action( 'add_meta_boxes', array($this, 'add_my_meta_box') );
		add_action( 'save_post', array($this, 'save_meta_box_data') );
	}
	
	public function spit_out_array($the_array) {
		$this->to_return .= "<pre>\n";
		$this->to_return .= print_r($the_array, TRUE);
		$this->to_return .= "</pre>\n";
	}
}