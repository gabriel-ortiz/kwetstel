<?php
function site_scripts()
{
	global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
	$enqueue_filetime = filemtime(get_template_directory() . '/functions/enqueue-scripts.php');

	// Adding scripts file in the footer
	wp_enqueue_script(
		'vendor',
		get_template_directory_uri() . '/assets/scripts/vendor-scripts.js',
		array('jquery'),
		filemtime(get_template_directory() . '/assets/scripts/vendor-scripts.js'),
		true
	);
	

	wp_localize_script('main', 'KW', array(
		'site_url' => site_url('/'),
		'assets' => KW_ASSETS,
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('kw_nonce'),
		'is_admin' => is_admin()
	));

	// Register main stylesheet
	wp_enqueue_style('site',
		get_template_directory_uri() . '/assets/styles/style.css',
		array(),
		filemtime(get_template_directory() . '/assets/styles/scss'),
		'all'
	);

	// Comment reply script for threaded comments
	if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
		wp_enqueue_script('comment-reply');
	}
	
}

add_action('wp_enqueue_scripts', 'site_scripts', 999);

function only_mount_editor_scripts() {
	wp_localize_script( 'kw-gutenberg', 'KW', array(
		'site_url' 	        => site_url('/'),
		'assets' 	        => KW_ASSETS,
		'ajax_url' 	        => admin_url( 'admin-ajax.php' ),
		'nonce'    	        => wp_create_nonce( 'kw_nonce' ),

	) );

	// Register main stylesheet
	wp_enqueue_style(
		'itbl-gutenberg-styles',
		get_template_directory_uri() . '/assets/styles/gutenberg-styles.css',
		array(),
		filemtime(get_template_directory() . '/assets/styles/gutenberg-styles.css'),
		'all' );
}
add_action( 'enqueue_block_editor_assets', 'only_mount_editor_scripts' );
	
	/**
	 * Enqueue frontend and editor JavaScript and CSS
	 */
	function both_frontend_and_editor_assets() {
		// Adding scripts file in the footer
		wp_enqueue_script(
			'main',
			get_template_directory_uri() . '/assets/scripts/scripts.js',
			array('jquery'),
			filemtime(get_template_directory() . '/assets/scripts/scripts.js'),
			true
		);
		
		//register font awesome CDN
		wp_enqueue_style(
			'font-awesome',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css',
			array(),
			'',
			'all'
		);
	}

// Hook the enqueue functions into the frontend and editor
	add_action( 'enqueue_block_assets', 'both_frontend_and_editor_assets', 999 );