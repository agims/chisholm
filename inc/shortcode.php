<?php
	
	// Creating a shortcode to display contents of a custom post
	function chisholm_display_cta_shortcode($atts) {
		$defaults = array(
			'id'	=> FALSE,
		);
		
		$shortcode_atts = shortcode_atts($defaults, $atts);
		
		if(!empty($shortcode_atts['id'])) {
			
			if(in_the_loop()) {
				
				// The Query
				$cta_query = new WP_Query('p=' . $shortcode_atts['id'] . '&post_type=chisholm_cta');
				
				
				// The Loop
				if($cta_query->have_posts()) {
					while ($cta_query->have_posts() ) {
						$cta_query->the_post();
						$cta_content = get_the_content();
						if(!empty($cta_content)) {
							return do_shortcode($cta_content);
						} else {
							return $shortcode_atts['id'] . " was empty.";
						}
					}
				} else {
					return "There is no such CTA as " . $shortcode_atts['id'];
				}
				
				// Restore original Post Data
				
				wp_reset_postdata();

			} else {
				
				$args = array(
					'post_type'		=> 'chisholm_cta',
					'p'				=> $shortcode_atts['id'],
				);
				
				$single_cta = new WP_Query($args);
				
				if($single_cta->have_posts()) {
					while($single_cta->have_posts()) {
						$single_cta->the_post();
						
						$to_return = get_the_content();
						if(!empty($to_return)) {
							return do_shortcode($to_return);
						} else {
							return $shortcode_atts['id'] . " was empty.";
						}
					}
					return "There is no such CTA as " . $shortcode_atts['id'];
				}
				
				wp_reset_postdata();
				
			}
		} else {
			return 'No ID given';
		}
	}
	
	// Add the shortcode in
	add_shortcode('chisholm_cta', 'chisholm_display_cta_shortcode');