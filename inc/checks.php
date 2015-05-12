<?php
	
	$chisholm_needed_options = array(
		'chisholm_use_cta_posts'	=> FALSE,
		'chisholm_cta_id_for_posts'	=> '',
		'chisholm_html_hook_posts'	=> 'p',
		'chisholm_which_hook_posts'	=> 2,
		'chisholm_use_cta_pages'	=> FALSE,
		'chisholm_cta_id_for_pages'	=> '',
		'chisholm_html_hook_pages'	=> 'p',
		'chisholm_which_hook_pages'	=> 2,
	);
	
	foreach($chisholm_needed_options as $option => $value) {
		if(!get_option($option)) {
			add_option($option, $value);
		}
	}
	
	if(!get_option(CHISHOLM_VERSION_KEY)) {
		add_option(CHISHOLM_VERSION_KEY, CHISHOLM_VERSION_NUM);
	} else {
		update_option(CHISHOLM_VERSION_KEY, CHISHOLM_VERSION_NUM);
	}
