<?php
	
	// Creating a shortcode to display contents of a custom post
	function chisholm_display_cta_shortcode($atts) {
		$defaults = array(
			'id'	=> FALSE,
		);
		
		$shortcode_atts = shortcode_atts($defaults, $atts);
		
		if(!empty($shortcode_atts['id'])) {

			global $wp_query;
			
			$temp_query = clone $wp_query;
			
			// The Query
			query_posts('p=' . $shortcode_atts['id'] . '&post_type=chisholm_cta');
			
			// The Loop
			if ( have_posts() ) {
				while (have_posts() ) {
					the_post();
					$cta_content = get_the_content();
					if(empty($cta_content)) {
						return $shortcode_atts['id'] . " was empty.";
					} else {
						//return $cta_content;
						remove_filter('the_content', 'chisholm_content_filter');
						return apply_filters('the_content', $cta_content);
						add_filter('the_content', 'chisholm_content_filter');
					}
				}
			} else {
				return "There is no such CTA as " . $shortcode_atts['id'];
			}
			
			// Restore original Post Data
			
			$wp_query = clone $temp_query;			
		} else {
			return 'No ID given';
		}
	}
	
	// Add the shortcode in
	add_shortcode('chisholm_cta', 'chisholm_display_cta_shortcode');