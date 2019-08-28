<?php
namespace KW\Functions\Gutenberg;
use WP_Block_Type_Registry;
/**
 * Gutenberg Settings for initial setup
 *
 * @return void
 */
function setup(){
	$n = function( $function ){
		return __NAMESPACE__ . '\\' . $function;
	};
	add_action('admin_head', $n('editor_full_width_gutenberg' ) );


	add_filter( 'allowed_block_types', $n('allowed_blocks' ) );

	add_filter( 'block_categories', $n('enqueue_kw_block_category'), 10, 2 );
}
/**
 *
 * Enables editor to be full width for selected custom post types
 *
 * @return void
 *
 */
function editor_full_width_gutenberg() {
	global $post;
	//get current post type

	if( !$post ){
		return;
	}

	$current_post = $post->post_type;

	//if the current post type is in array, cancel function
	if( in_array( $current_post, array( 'post' ) ) ){
		return;
	}
	//else echo classes to widen the gutenberg editor
	echo '<style>
    body.gutenberg-editor-page .editor-post-title__block, body.gutenberg-editor-page .editor-default-block-appender, body.gutenberg-editor-page .editor-block-list__block {
        max-width: none !important;
    }
    .block-editor__container .wp-block {
        max-width: none !important;
    }
  </style>';
}
/**
 *
 * Filters out unwanted blocks, to whitelist a block, add it the merge_array array
 *
 * @param $allowed_blocks
 *
 * @return array
 */
function allowed_blocks( $allowed_blocks ) {
	// get widget blocks and registered by plugins blocks
	$registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
	// in case we do not need widgets
	unset( $registered_blocks[ 'core/latest-comments' ] );
	unset( $registered_blocks[ 'core/archives' ] );
	unset( $registered_blocks[ 'core/rss'] );
	unset( $registered_blocks[ 'core/calendar'] );
	unset( $registered_blocks[ 'core/categories'] );
	unset( $registered_blocks[ 'core/latest-posts'] );
	unset( $registered_blocks[ 'core/search' ] );
	unset( $registered_blocks[ 'core/tag-cloud' ] );
	// now $registered_blocks contains only blocks registered by plugins, but we need keys only
	$registered_blocks = array_keys( $registered_blocks );
	// merge the whitelist with plugins blocks
	return array_merge( array(
		'core/image',
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/freeform',
		'core-embed/youtube',
		'core-embed/twitter',
		'core/video'
	), $registered_blocks );
}

/**
 *
 * Adds a customized group for Iterable blocks
 * Note: by default this will exclude posts
 *
 * @param $categories
 * @param $post
 *
 * @return array
 */
function enqueue_kw_block_category( $categories, $post ) {
	$current_post = $post->post_type;
	//return if gutenberg is not enabled, or if this post type is in the array of posts
	if ( in_array( $current_post, array( 'post' ) ) ) {
		return $categories;
	}
	return array_merge(
		array(
			array(
				'slug' => 'kw-blocks',
				'title' => __( 'Kw\'ets\'tel Layout Blocks', 'kw' ),
				'icon'  => 'tagcloud',
			),
		),
		$categories
	);
}
