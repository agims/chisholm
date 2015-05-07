<?php

$property_fields = array(
	'address'	=> array(
		'nice_name'	=> 'Address',
		'type'		=> 'text'
	),
	'city'		=> array(
		'nice_name'	=> 'City',
		'type'		=> 'text'
	),
	'state'		=> array(
		'nice_name'	=> 'State',
		'type'		=> 'state_dropdown'
	),
	'zipcode'	=> array(
		'nice_name'	=> 'Zip Code',
		'type'		=> 'text'
	),
	'price'		=> array(
		'nice_name'	=> 'Price',
		'type'		=> 'text'
	),
	'original_price'	=> array(
		'nice_name'	=> 'Original Price',
		'type'		=> 'text'
	),
	'size'		=> array(
		'nice_name'	=> 'House Size (in sq. ft.)',
		'type'		=> 'text'
	),
	'prop_size'	=> array(
		'nice_name'	=> 'Property Size (in sq. ft.)',
		'type'		=> 'text'
	),
	'beds'		=> array(
		'nice_name'	=> 'Beds',
		'type'		=> 'dropdown',
		'min'		=> '1',
		'max'		=> '5',
		'increment'	=> '0.5'
	),
	'baths'		=> array(
		'nice_name'	=> 'Baths',
		'type'		=> 'dropdown',
		'min'		=> '1',
		'max'		=> '5',
		'increment'	=> '0.5'
	),
	'cars'		=> array(
		'nice_name'	=> 'Cars',
		'type'		=> 'dropdown',
		'min'		=> '1',
		'max'		=> '3',
		'increment'	=> '1'
	),
	'stage'		=> array(
		'nice_name'	=> 'Stage',
		'type'		=> 'text'
	),
	'status'	=> array(
		'nice_name'	=> 'Status',
		'type'		=> 'text'
	),
	'amenities'	=> array(
		'nice_name'	=> 'Amenities (one per line)',
		'type'		=> 'textarea'
	),
	'county'	=> array(
		'nice_name'	=> 'County',
		'type'		=> 'text'
	),
	'neighborhood'	=> array(
		'nice_name'	=> 'Neighborhood',
		'type'		=> 'text'
	),
	'latlong'	=> array(
		'nice_name'	=> 'Latitude and Longtide',
		'type'		=> 'text'
	)
);

/**
 * Adds a box to the main column on the floor_plan edit screens.
 */
function add_property_meta_box() {

	$screens = array( 'property' );

	foreach ( $screens as $screen ) {

		add_meta_box('property_meta', __( 'Property Information', 'kalesa' ), 'property_meta_box_callback', $screen, 'normal', 'high');
	}
}
add_action( 'add_meta_boxes', 'add_property_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function property_meta_box_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'myplugin_meta_box', 'myplugin_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	 
	 global $property_fields;
	 
	 
	 echo '<table class="form-table">' . "\n";
	 echo "<tbody>\n";
	 
	 foreach($property_fields as $property_field => $property_sub_fields) {
		 $property_min = 0;
		 $property_max = 0;
		 
		 extract($property_sub_fields, EXTR_PREFIX_ALL, "property");
		 
		 $$property_field = get_post_meta( $post->ID, '_' . $property_field, true );
		 
		 if($property_field == 'price' || $property_field == 'original_price' && $$property_field) {
			 $$property_field = number_format($$property_field);
		 }
		 
		 echo "<tr>\n";
		 echo "<th>\n";
		 echo '<label for="' . $property_field . '">' . $property_nice_name . '</label>';
		 echo "</th>\n";
		 echo "<td>\n";
		 meta_input_type($property_type, $property_field, $$property_field, $property_min, $property_max, $property_increment);
		 echo "</td>\n";
		 echo "</tr>\n";

	 }
	 echo "</tbody>\n";
	 echo "</table>\n";
}


/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function property_save_meta_box_data( $post_id ) {
	
	global $property_fields;
	

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_meta_box' ) ) {
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
	
	foreach($property_fields as $property_field => $property_sub_fields) {
		
		$fieldname = '_' . $property_field;
		
		// Make sure that it is set.
		if ( ! isset( $_POST[$property_field] ) ) {
			return;
		}
		
		
		// Sanitize user input.
		if($property_field == 'amenities') {
			$data = $_POST[$property_field];
		} else {
			$data = sanitize_text_field( $_POST[$property_field] );
		}

		if($property_field == 'price' || $property_field == 'original_price') {
			$data = str_replace(' ', '', $data);
			$data = str_replace(',', '', $data);
			$data = str_replace('$', '', $data);
		}
		
		// Update the meta field in the database.
		update_post_meta( $post_id, $fieldname, $data );
	}
	
	$info_obj = get_object_from_url(get_geocode_url($post_id));
	$address_elements = $info_obj->results[0]->address_components;
	$test = array(
		'street_number'					=>	'Street Number',
		'route'							=>	'Route',
		'neighborhood'					=>	'Neighborhood',
		'locality'						=>	'City',
		'administrative_area_level_2'	=>	'County',
		'administrative_area_level_1'	=>	'State',
		'country'						=>	'Country',
		'postal_code'					=>	'Zip Code',
		'postal_code_suffix'			=>	'Zip Code Suffix'
	);
	foreach($address_elements as $element) {
		foreach($test as $key => $name) {
			if ($element->types[0] == $key) {
				$$key = $element->short_name;
			}	
		}
	}
	
	update_post_meta( $post_id, '_county', $administrative_area_level_2);
	update_post_meta( $post_id, '_neighborhood', $neighborhood);
	update_post_meta( $post_id, '_latlong', $info_obj->results[0]->geometry->location->lat . ',' . $info_obj->results[0]->geometry->location->lng);
	if(empty($zipcode)) {
		update_post_meta( $post_id, '_zipcode', $postal_code);
	}

}
add_action( 'save_post', 'property_save_meta_box_data' );