<?php

function meta_input_type($type="text", $name, $value, $min=1, $max=5, $increment=1) {
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
			require ('states.php');
			echo '<select name="' . $name . '" id="' . $name . '">';
			foreach($states as $state_name => $state_abbr) {
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
	}
}