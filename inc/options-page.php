<?php
	
	// Register our settings
	function chisholm_register_settings() {
	
		global $chisholm_needed_options;
		
		foreach($chisholm_needed_options as $option => $value) {
			register_setting('chisholm', $option);
		}
		
	}
	
	// Make it so
	add_action( 'admin_init', 'chisholm_register_settings');
	

	
	// Add our options page.  Will be off of the settings page.
	function chisholm_option_menu() {
		add_options_page('Chisholm Options Page', 'Chisholm Options', 'edit_theme_options', 'chisholm-options', 'chisholm_option_page');
	}
	
	// Make it so
	add_action('admin_menu', 'chisholm_option_menu');
	
	
	
	// Create the actual options page
	function chisholm_option_page() {
		if( !current_user_can('edit_theme_options')) {
			wp_die( __('Umm, what are you doing?', 'chisholm'));
		}
				
		global $chisholm_needed_options;
		
		foreach($chisholm_needed_options as $option => $value) {
			$$option = get_option($option);
		}

		$args = array(
			'post_type'			=> 'chisholm_cta',	
			'posts_per_page'	=> '-1',
			'order'				=> 'ASC',
			'orderby'			=> 'ID',
		);
		
		$ctas = new WP_Query($args);
//		print_r($ctas);
		
		$cta_array = array();
		
		if($ctas->have_posts()) {
			while($ctas->have_posts()) {
				$ctas->the_post();
				
				$cta_array[get_the_ID()] = get_the_title();
			}
		}

		?>
		<div class="wrap">
			<h2>Chisholm Plugin Options</h2>
			Chisholm v<?php echo CHISHOLM_VERSION_NUM; ?> <a href="https://github.com/agims/chisholm" target="_blank"><small>Documentation</small></a>
		</div>
		<?php
			// Put into a variable so that if we need to change it for testing we don't lose the original
			$form_location = 'options.php';
		?>
		<form method="post" action="<?=$form_location?>">
			<?php settings_fields('chisholm'); ?>
			<hr />
			<h3><span style="color: #009900;"><span class="dashicons-before dashicons-admin-post">&nbsp;</span>Posts</span> <small>These are the values that control the CTAs that show up on all <big>posts</big>.</small></h3>
			
			<table class="form-table">
				<tbody>
					<tr id="use_cta_posts">
						<th scope="row">
							<label for="chisholm_use_cta_posts">Show a single CTA on all posts?</label>
						</th>
						<td>
							<?php $checked = ($chisholm_use_cta_posts ? 'checked' : ''); ?>
							<input name="chisholm_use_cta_posts" id="chisholm_use_cta_posts" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="cta_id_for_posts">
						<th scope="row">
							<label for="chisholm_cta_id_for_posts">Which CTA should we use?</label>
						</th>
						<td>
							<select name="chisholm_cta_id_for_posts" id="chisholm_cta_id_for_posts">
								<?php
									foreach($cta_array as $cta_id => $cta_title) {
										if($chisholm_cta_id_for_posts == $cta_id) {
											$selected = " selected='selected'";
										} else {
											$selected = '';
										}
										echo '<option value="' . $cta_id . '" ' . $selected . '>' . $cta_title . '</option>' . "\n";
									}
								?>
							</select>
						</td>
					</tr>
					<tr id="html_hook_posts">
						<th scope="row">
							<label for="chisholm_html_hook_posts">What HTML Element should we hook to?</label>
						</th>
						<td>
							<select name="chisholm_html_hook_posts" id="chisholm_html_hook_posts">
								<?php
									$elements = array(
										'Paragraph'		=> 'p',
										'Div'			=> 'div',
										'Section'		=> 'section',	
									);
									
									foreach($elements as $element_name => $element_tag) {
										if($chisholm_html_hook_posts == $element_tag) {
											$selected = " selected='selected'";
										} else {
											$selected = '';
										}
										echo '<option value="' . $element_tag . '" ' . $selected . '>' . $element_name . '</option>' . "\n";
									}
								?>
							</select>
						</td>
					</tr>
					<tr id="which_hook_posts">
						<th scope="row">
							<label for="chisholm_which_hook_posts">After how many of hooks should the CTA Show up?</label><br />
							<small>Note:  If there are less than the number specified, it will show up at the end.</small>
						</th>
						<td>
							<select name="chisholm_which_hook_posts" id="chisholm_which_hook_posts">
								<?php
									$numbers = array(1, 2, 3, 4, 5, 6, 7, 8);
									
									foreach($numbers as $number) {
										if($chisholm_which_hook_posts == $number) {
											$selected = " selected='selected'";
										} else {
											$selected = '';
										}
										echo '<option value="' . $number . '" ' . $selected . '>' . $number . '</option>' . "\n";
									}
								?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<?php submit_button(); ?>
			<hr />
			<h3><span style="color: #000099;"><span class="dashicons-before dashicons-admin-page">&nbsp;</span>Pages</span> <small>These are the values that control the CTAs that show up on all <big>pages</big>.</small></h3>
			
			<table class="form-table">
				<tbody>
					<tr id="use_cta_pages">
						<th scope="row">
							<label for="chisholm_use_cta_pages">Show a single CTA on all pages?</label>
						</th>
						<td>
							<?php $checked = ($chisholm_use_cta_pages ? 'checked' : ''); ?>
							<input name="chisholm_use_cta_pages" id="chisholm_use_cta_pages" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="cta_id_for_pages">
						<th scope="row">
							<label for="chisholm_cta_id_for_pages">Which CTA should we use?</label>
						</th>
						<td>
							<select name="chisholm_cta_id_for_pages" id="chisholm_cta_id_for_pages">
								<?php
									foreach($cta_array as $cta_id => $cta_title) {
										if($chisholm_cta_id_for_pages == $cta_id) {
											$selected = " selected='selected'";
										} else {
											$selected = '';
										}
										echo '<option value="' . $cta_id . '" ' . $selected . '>' . $cta_title . '</option>' . "\n";
									}
								?>
							</select>
						</td>
					</tr>
					<tr id="html_hook_pages">
						<th scope="row">
							<label for="chisholm_html_hook_pages">What HTML Element should we hook to?</label>
						</th>
						<td>
							<select name="chisholm_html_hook_pages" id="chisholm_html_hook_pages">
								<?php
									$elements = array(
										'Paragraph'		=> 'p',
										'Div'			=> 'div',
										'Section'		=> 'section',	
									);
									
									foreach($elements as $element_name => $element_tag) {
										if($chisholm_html_hook_pages == $element_tag) {
											$selected = " selected='selected'";
										} else {
											$selected = '';
										}
										echo '<option value="' . $element_tag . '" ' . $selected . '>' . $element_name . '</option>' . "\n";
									}
								?>
							</select>
						</td>
					</tr>
					<tr id="which_hook_pages">
						<th scope="row">
							<label for="chisholm_which_hook_pages">After how many of hooks should the CTA Show up?</label><br />
							<small>Note:  If there are less than the number specified, it will show up at the end.</small>
						</th>
						<td>
							<select name="chisholm_which_hook_pages" id="chisholm_which_hook_pages">
								<?php
									$numbers = array(1, 2, 3, 4, 5, 6, 7, 8);
									
									foreach($numbers as $number) {
										if($chisholm_which_hook_pages == $number) {
											$selected = " selected='selected'";
										} else {
											$selected = '';
										}
										echo '<option value="' . $number . '" ' . $selected . '>' . $number . '</option>' . "\n";
									}
								?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<?php submit_button(); ?>
			<hr />
		</form>
		<?php

	}
	
	function toolbar_link_to_chisholm($wp_admin_bar) {
		$add_chisholm_node_args = array(
			'id'			=> 'wp-admin-bar-chisholm',
			'title'			=> 'Chisholm Options',
			'href'			=> get_option('siteurl') . '/wp-admin/options-general.php?page=chisholm-options',
			//'parent'		=> 'wp-admin-bar-root-default',
		);
		
		$wp_admin_bar->add_node($add_chisholm_node_args);
	}
	
	add_action('admin_bar_menu', 'toolbar_link_to_chisholm', 999);
	
	function add_options_page_to_chisholm($wp_admin_bar) {
		$add_chisholm_node_args = array(
			'id'			=> 'wp-admin-bar-chisholm-cta',
			'title'			=> 'Chisholm CTAs',
			'href'			=> get_option('siteurl') . '/wp-admin/edit.php?post_type=chisholm_cta',
			'parent'		=> 'wp-admin-bar-chisholm',
		);
		
		$wp_admin_bar->add_node($add_chisholm_node_args);
	}
	
	add_action('admin_bar_menu', 'add_options_page_to_chisholm', 1);