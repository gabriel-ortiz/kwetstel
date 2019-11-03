<?php
	
	namespace KW\Includes\ThemeSettings;
	/**
	 * This is an example template with comments on what do do
	 *
	 * @return void
	 */
	
	function setup() {
		$n = function ( $function ) {
			return __NAMESPACE__ . '\\' . $function;
		};
		
		register_theme_settings();
		
		//add the hooks and filters here
		//add_action( "", "" );
	}
	
	function register_theme_settings(){
		
		if ( function_exists( 'acf_add_options_page' ) ) {
			
			acf_add_options_page( array(
				'page_title' => 'Theme General Settings',
				'menu_title' => 'Theme Settings',
				'menu_slug'  => 'theme-general-settings',
				'capability' => 'edit_posts',
				'redirect'   => false
			) );
			
			acf_add_options_sub_page( array(
				'page_title'  => 'Theme Header Settings',
				'menu_title'  => 'Header',
				'parent_slug' => 'theme-general-settings',
			) );
			
			acf_add_options_sub_page( array(
				'page_title'  => 'Theme Footer Settings',
				'menu_title'  => 'Footer',
				'parent_slug' => 'theme-general-settings',
			) );
			
		}
}

