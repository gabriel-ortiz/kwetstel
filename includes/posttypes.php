<?php
namespace KW\PostTypes;
/**
 * Set up post types
 *
 * @return void
 */
function setup() {
	$n = function ( $function ) {
		return __NAMESPACE__ . '\\' . $function;
	};
	// NOTE: Uncomment to activate post type
	//add_action( 'init', $n( 'register_my_post_type' ) );
}
/**
 * Register the 'my_post_type' post type
 *
 * See https://github.com/johnbillion/extended-cpts for more information
 * on registering post types with the extended-cpts library.
 */
function register_my_post_type() {
	register_extended_post_type( 'stories', array(
		'menu_icon' 		=> 'dashicons-layout',
		'supports' 			=> array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'names'				=> array(
								//Override the base names used for labels:
								'singular' => 'Story',
								'plural'   => 'Stories',
								'slug'     => 'stories'
								)
	) );
}