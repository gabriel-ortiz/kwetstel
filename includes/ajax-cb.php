<?php


namespace KW\Includes\AjaxCB;

function setup(){
    $n = function( $function ){
        return __NAMESPACE__ . '\\' . $function;
    };

	//add the hooks and filters here
//     add_action('wp_ajax_load_posts_by_ajax', $n( 'load_posts_by_ajax_callback' ) );
//     add_action('wp_ajax_nopriv_load_posts_by_ajax', $n( 'load_posts_by_ajax_callback' ) ) ;
}

function load_posts_by_ajax_callback() {
    $results = array();
	
    //get the args for the WP_query
    $args =  $_POST['args'];
    $more_posts = new \WP_Query($args);
    $more_posts = json_decode(json_encode($more_posts), true);
    //get the post count and post found
    $results['found_posts'] = (int)$more_posts['found_posts'];
    $results['post_count']  = $more_posts['post_count'];
    //debug
    //echo json_encode( $more_posts ); wp_die();
    if( $more_posts['posts'] ):
        foreach( $more_posts['posts']  as $key => $post ){
            $terms          = get_the_terms( $post['ID'], 'category');
            //$excerpt = get_the_excerpt( $post['ID'] );
            //get all metadata fields
            $post['terms']        = $terms;
            $post['metadata']     = get_fields( $post['ID'] );
            $post['permalink']    = get_permalink( $post['ID'] );
            $post['terms']        = get_terms( $post['ID'] );
            $post['excerpt']      =  apply_filters( 'the_content', wp_trim_words( $post['post_content'] , 20 ) );
			
            //check for images
            if( has_post_thumbnail( $post['ID']) ){
                $post['thumbnail'] = get_the_post_thumbnail_url( $post['ID'], 'medium');
            }else{
                $post['thumbnail'] = '';
            }
            $results['posts'][] =  $post;
        }
    else:
        $results = count( $more_posts['posts'] );
    endif;
    wp_send_json( $results );
}