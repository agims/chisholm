<?php
if ( ! function_exists('chisholm_cta_cpt') ) {

	// Register Custom Post Type
	function chisholm_cta_cpt() {
	
		$labels = array(
			'name'                => _x( 'CTAs', 'Post Type General Name', 'chisholm' ),
			'singular_name'       => _x( 'CTA', 'Post Type Singular Name', 'chisholm' ),
			'menu_name'           => __( 'CTAs', 'chisholm' ),
			'name_admin_bar'      => __( 'CTAs', 'chisholm' ),
			'parent_item_colon'   => __( 'Parent Item:', 'chisholm' ),
			'all_items'           => __( 'All CTAs', 'chisholm' ),
			'add_new_item'        => __( 'Add New CTA', 'chisholm' ),
			'add_new'             => __( 'Add New', 'chisholm' ),
			'new_item'            => __( 'New CTA', 'chisholm' ),
			'edit_item'           => __( 'Edit CTA', 'chisholm' ),
			'update_item'         => __( 'Update CTA', 'chisholm' ),
			'view_item'           => __( 'View CTA', 'chisholm' ),
			'search_items'        => __( 'Search CTA', 'chisholm' ),
			'not_found'           => __( 'Not found', 'chisholm' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'chisholm' ),
		);
		$args = array(
			'label'               => __( 'chisholm_cta', 'chisholm' ),
			'description'         => __( 'A call to action to be included in posts / pages', 'chisholm' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'revisions', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 29,
			'menu_icon'           => 'dashicons-format-chat',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( 'chisholm_cta', $args );
	
	}
	
	// Hook into the 'init' action
	add_action( 'init', 'chisholm_cta_cpt', 0 );

	/**
	 * Filter to disable the visual editor on specific post types
	 */
	function my_disable_visual_editor() {
		if ( 'chisholm_cta' == get_post_type() ) {
			return false;
		}
		return true;
	}
	 
	add_filter( 'user_can_richedit', 'my_disable_visual_editor' );


}