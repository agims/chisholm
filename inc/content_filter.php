<?php
	
	function chisholm_content_filter($content) {

		$needle = "</p>";
		$lastPos = 0;
		$positions = array();
		
		while (($lastPos = strpos($content, $needle, $lastPos))!== false) {
		    $positions[] = $lastPos;
		    $lastPos = $lastPos + strlen($needle);
		}

		//$content = "<pre>\n" . print_r($positions, false) . "</pre>\n" . $content;
		
		if(isset($positions[1])) {
			$location = $positions[1] + 4;
		} else {
			$location = strlen($content);
		}
		
		
		$added_text = '<div style="background-color: #FF9999; border: 1px solid #FF0000; border-radius: 8px; box-sizing: border-box; margin-bottom: 1.6842em; margin-left: -0.5em; margin-right: -0.5em; padding: 0.25em 0.5em 0;">This is the added text. It was placed at character ' . $location . '.  I know I am excited.  Are you?</div>';
		
		$content = substr_replace($content, $added_text, $location, 0);
		
		return $content;
	}
	
	add_filter('the_content', 'chisholm_content_filter');