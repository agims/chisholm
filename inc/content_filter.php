<?php
	
	function chisholm_content_filter($content) {
		
		global $chisholm_needed_options;
		
		foreach($chisholm_needed_options as $option => $value) {
			$$option = get_option($option);
		}
		
		if((is_single() || is_home() || is_archive()) && $chisholm_use_cta_posts == 'on') {
			$bob = "It's a single";
			$content = chisholm_add_cta($content, $chisholm_cta_id_for_posts, "</" . $chisholm_html_hook_posts . ">", $chisholm_which_hook_posts);
		} elseif(is_page() && $chisholm_use_cta_pages == 'on') {
			$bob = "It's a page";
			$content = chisholm_add_cta($content, $chisholm_cta_id_for_pages, "</" . $chisholm_html_hook_pages . ">", $chisholm_which_hook_pages);
		}
		
		
		return $content;
	}
	
	add_filter('the_content', 'chisholm_content_filter');
	
	function chisholm_add_cta($content, $cta_id = FALSE, $needle = "</p>", $which_hook = 2) {
		
		$lastPos = 0;
		$positions = array();
		
		while (($lastPos = strpos($content, $needle, $lastPos))!== false) {
		    $positions[] = $lastPos;
		    $lastPos = $lastPos + strlen($needle);
		}

		$position = $which_hook - 1;
		$offset = strlen($needle);
		
		if(isset($positions[$position])) {
			$location = $positions[$position] + $offset;
		} else {
			$location = strlen($content);
		}
		
		$cta_post = get_post($cta_id);
		$cta_content = apply_filters('the_content', $cta_post->post_content);
		//$cta_content = str_replace(']]>', ']]&gt;', $cta_content);


		
		$content = substr_replace($content, $cta_content, $location, 0);
		
		return $content;

	}