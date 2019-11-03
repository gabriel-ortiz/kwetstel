<?php
/** 
 * For more info: https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */		

// Useful global constants
define( 'KW_VERSION',      '0.1.0' );
define( 'KW_URL',          get_stylesheet_directory_uri() );
define( 'KW_TEMPLATE_URL', get_template_directory_uri() );
//define( 'KW_PATH',         get_template_directory() . '/' );
define( 'KW_PATH',         dirname( __FILE__ ) . '/' );
define( 'KW_INC',          KW_PATH . 'includes/' );
define( 'KW_FN',          KW_PATH . 'functions/' );
define( 'KW_ASSETS',       KW_TEMPLATE_URL . '/assets/' );
define( 'KW_PARTS',       KW_PATH . '/parts/' );
define( 'COMPOSER_PATH', KW_PATH .'vendor/' );

if ( ! defined( 'DAY_IN_SECONDS' ) ) {
    define( 'DAY_IN_SECONDS', 24 * 60 * 60 );
}

//define( 'DB_NAME', 'wp_iterabledev' );
if(defined('DB_NAME') && DB_NAME == 'wp_iterabledev'){
	define( 'WP_LOCAL', false );
}else{
	define( 'WP_LOCAL', true );
}
	
// Theme support options
require_once(get_template_directory().'/functions/theme-support.php'); 

// WP Head and other cleanup functions
require_once(get_template_directory().'/functions/core.php');

// Register scripts and stylesheets
require_once(get_template_directory().'/functions/enqueue-scripts.php'); 

// Register custom menus and menu walkers
require_once(get_template_directory().'/functions/menu.php'); 

// Register sidebars/widget areas
require_once(get_template_directory().'/functions/sidebar.php'); 

// Makes WordPress comments suck less
require_once(get_template_directory().'/functions/comments.php'); 

// Replace 'older/newer' post links with numbered navigation
require_once(get_template_directory().'/functions/page-navi.php'); 

// Adds support for multiple languages
require_once(get_template_directory().'/functions/translation/translation.php'); 

// Adds site styles to the WordPress editor
// require_once(get_template_directory().'/functions/editor-styles.php'); 

// Remove Emoji Support
// require_once(get_template_directory().'/functions/disable-emoji.php'); 

// Related post function - no need to rely on plugins
// require_once(get_template_directory().'/functions/related-posts.php'); 

// Use this as a template for custom post types
// require_once(get_template_directory().'/functions/custom-post-type.php');

// Customize the WordPress login menu
// require_once(get_template_directory().'/functions/login.php'); 

// Customize the WordPress admin
// require_once(get_template_directory().'/functions/admin.php'); 

//Inlcude helpers
require_once 	COMPOSER_PATH . 'autoload.php';
require_once 	KW_INC . 'helpers.php';
include 		KW_INC . 'libraries/html.php' ;
require_once    KW_INC . 'theme-settings.php';


//determine Local/Prod
debug_to_console(WP_LOCAL, 'LOCAL' );

//include custom WP Modules
require_once 	KW_INC . 'ajax-cb.php';
require_once 	KW_INC . 'shortcodes.php';
require_once	KW_FN . 'gutenberg.php';


//Run the Setup Functions
KW\Includes\AjaxCB\setup();
KW\Includes\Shortcodes\setup();
KW\Functions\Gutenberg\setup();
KW\Includes\ThemeSettings\setup();

/*
 * Load all blocks
 */

load_blocks( 'parts/layout-blocks' );
	
	remove_filter ('the_content', 'wpautop');