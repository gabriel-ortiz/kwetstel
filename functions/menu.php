<?php
// Register menus
register_nav_menus(
	array(
		'main-nav'		=> __( 'The Main Menu', 'jointswp' ),		// Main nav in header
		'offcanvas-nav'	=> __( 'The Off-Canvas Menu', 'jointswp' ),	// Off-Canvas nav
		'footer-links'	=> __( 'Footer Links', 'jointswp' )			// Secondary nav in footer
	)
);

// The Top Menu
function joints_top_nav() {
	wp_nav_menu(array(
		'container'			=> false,						// Remove nav container
		'menu_id'			=> 'main-nav',					// Adding custom nav id
		'menu_class'		=> 'medium-horizontal menu',	// Adding custom nav class
		'items_wrap'		=> '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>',
		'theme_location'	=> 'main-nav',					// Where it's located in the theme
		'depth'				=> 5,							// Limit the depth of the nav
		'fallback_cb'		=> false,						// Fallback function (see below)
		'walker'			=> new Topbar_Menu_Walker()
	));
}

// Big thanks to Brett Mason (https://github.com/brettsmason) for the awesome walker
class Topbar_Menu_Walker extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth = 0, $args = Array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"menu\">\n";
	}
}

// The Off Canvas Menu
function joints_off_canvas_nav() {
	wp_nav_menu(array(
		'container'			=> false,							// Remove nav container
		'menu_id'			=> 'offcanvas-nav',					// Adding custom nav id
		'menu_class'		=> 'vertical menu accordion-menu',	// Adding custom nav class
		'items_wrap'		=> '<ul id="%1$s" class="%2$s" data-accordion-menu>%3$s</ul>',
		'theme_location'	=> 'offcanvas-nav',					// Where it's located in the theme
		'depth'				=> 5,								// Limit the depth of the nav
		'fallback_cb'		=> false,							// Fallback function (see below)
		'walker'			=> new Off_Canvas_Menu_Walker()
	));
}


class Off_Canvas_Menu_Walker extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth = 0, $args = Array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"vertical menu\">\n";
	}
}


function render_kw_menu(){
	
	$args = array(
		'menu'          => 'main-nav',
		'container'     => false,
		'menu_id'       => 'kw-menu',
		'menu_class'    => 'kw-c-menu__items-wrapper kw-u-clean-list',
		'depth'         => 1,
		'walker'        => new kw_blocks_menu()
	);
	
	wp_nav_menu( $args );
	
}

class kw_blocks_menu extends Walker_Nav_Menu {
	
	function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
		
		/**
		 * Uses the html.class.php library to simplify the element building process
		 */
		global $post;
		
		//setup some variables
		$formatted_el   = ''; //final result returned to walker class
		$indent         = ( $depth ) ? str_repeat("\t",$depth) : ''; //for indenting the html
		$has_children   = $args->walker->has_children; //bool to check for link
		$object_id      = intval( $item->object_id );
		$has_blocks     = has_blocks($object_id );
		
		$li_attributes = '';
		$class_names = $value = '';

		
		$non_link       = ($item->url == '#'); //bool to check if this is a non link item
		
		//get the native WP css classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = ( $has_children ) ? 'dropdown' : ''; //saying this parent has dropdown
		$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : ''; //check for active class
		$classes[] = 'menu-item-' . $item->ID; //create a unique class with ID
		if( $depth && $args->walker->has_children ){
			$classes[] = 'dropdown-submenu'; //if there is depth - start submenu
		}
		//build the class names
		$class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr($class_names) . '"';
		
		/**
		 * Let's start building the elements inside the li tag
		 */
		//build the li's ID
		$id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
		
		//start the output -
		// it's important to leave this tag open, and concatenate as a string
		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';
		
		//attrs for the href
		$href_attrs = array(
			'title'     => esc_attr($item->attr_title),
			'target'    => esc_attr($item->target),
			'rel'       => esc_attr($item->xfn),
			'href'      => ($non_link) ? '': esc_attr($item->url),
			'class'     => ( $item->url == '#' ) ? 'kw-non-link' : 'kw-c-menu-link',
			'text'      => $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after,
			'aria-disabled' => ($non_link) ? 'true' : ''
		
		);
		//remove any empty array keys from attrs
		$href_attrs = array_filter($href_attrs, function($value) { return !empty( $value ); });
		$href           = new html( 'a', $href_attrs );
		
		//setup href classes
		//if this is the active page, the add the active class to this CTA
		$href_classes = array(
			'fas fa-plus js-section-toggle',
			( $item->current ) ? 'section--active' : ''
		);
		
		//create the chrevron element
		$block_href        = new html('a',
			array(
				'href'          => '#',
				'class'         => implode( ' ', $href_classes ),
				'aria-label'    => 'Show blocks for page',
				'data-trigger'  => $object_id
			)
		);
		
		//build the dropdown wrapper el
		$dropdown_wrapper = new html( 'div',
			array(
				'class' => 'kw-c-menu__item-wrapper'
			)
		);
		
		//if this has children - then we wrap the link and chevron in the dropdown wrapper
		//!IMPORTANT cast as string
		if( $has_blocks ){
			$formatted_el = (string) $dropdown_wrapper->append( $href, $block_href );
		}else{
			$formatted_el = (string) $dropdown_wrapper->append( $href );
			
		}
		
		//build the output result
		$item_output    = $args->before;
		$item_output   .= $formatted_el;
		$item_output   .= $args->after;
		
		$output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		
		
		
	}
	
}



class Off_Canvas_Menu_Walker_rendered extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = Array() ) {
	    $indent = str_repeat("\t",$depth);
	    $submenu = ($depth > 0) ? ' sub-menu' : '';
	    $output .= "\n$indent<ul class=\"kw-mobile-dropdown-menu$submenu depth_$depth\">\n";
    }

	function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {

		/**
		 * Uses the html.class.php library to simplify the element building process
		 */


        //setup some variables
        $formatted_el   = ''; //final result returned to walker class
		$indent         = ( $depth ) ? str_repeat("\t",$depth) : ''; //for indenting the html
		$has_children   = $args->walker->has_children; //bool to check for link
		$non_link       = ($item->url == '#'); //bool to check if this is a non link item

		$li_attributes = '';
		$class_names = $value = '';

		//get the native WP css classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = ( $has_children ) ? 'dropdown' : ''; //saying this parent has dropdown
		$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : ''; //check for active class
		$classes[] = 'menu-item-' . $item->ID; //create a unique class with ID
		if( $depth && $args->walker->has_children ){
			$classes[] = 'dropdown-submenu'; //if there is depth - start submenu
		}
		//build the class names
		$class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr($class_names) . '"';

		//build the li's ID
		$id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		//start the output -
        // it's important to leave this tag open, and concatenate as a string
		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

		/**
		 * Let's start building the elements inside the li tag
		 */
		//attrs for the href
        $href_attrs = array(
                'title'     => esc_attr($item->attr_title),
                'target'    => esc_attr($item->target),
                'rel'       => esc_attr($item->xfn),
                'href'      => ($non_link) ? '': esc_attr($item->url),
                'class'     => ( $item->url == '#' ) ? 'kw-non-link' : 'kw-mobile-menu-link',
                'text'      => $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after,
                'aria-disabled' => ($non_link) ? 'true' : ''

        );
        //remove any empty array keys from attrs
		$href_attrs = array_filter($href_attrs, function($value) { return !empty( $value ); });
		$href           = new html( 'a', $href_attrs );

		//create the chrevron element
		$chevron        = new html('a',
            array(
                    'href'          => '#',
                    'class'         => 'fas fa-chevron-down js-mobile-toggle',
                    'aria-label'    => 'Toggle Dropdown menu'
            )
        );

		//build the dropdown wrapper el
		$dropdown_wrapper = new html( 'div',
            array(
                    'class' => 'kw-c-mobile__dropdown-wrapper'
            )
        );

        //if this has children - then we wrap the link and chevron in the dropdown wrapper
        //!IMPORTANT cast as string
		if( $has_children ){
		    $formatted_el = (string) $dropdown_wrapper->append( $href, $chevron );
        }else{
		    $formatted_el = (string) $href;
        }

		//build the output result
		$item_output    = $args->before;
		$item_output   .= $formatted_el;
		$item_output   .= $args->before;


		$output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

// The Footer Menu
function joints_footer_links() {
	wp_nav_menu(array(
		'container'			=> 'false',				// Remove nav container
		'menu_id'			=> 'footer-links',		// Adding custom nav id
		'menu_class'		=> 'menu',				// Adding custom nav class
		'theme_location'	=> 'footer-links',		// Where it's located in the theme
		'depth'				=> 0,					// Limit the depth of the nav
		'fallback_cb'		=> ''					// Fallback function
	));
} /* End Footer Menu */

// Header Fallback Menu
function joints_main_nav_fallback() {
	wp_page_menu( array(
		'show_home'		=> true,
		'menu_class'	=> '',		// Adding custom nav class
		'include'		=> '',
		'exclude'		=> '',
		'echo'			=> true,
		'link_before'	=> '',		// Before each link
		'link_after'	=> ''		// After each link
	));
}

// Footer Fallback Menu
function joints_footer_links_fallback() {
	/* You can put a default here if you like */
}

// Add Foundation active class to menu
function required_active_nav_class( $classes, $item ) {
	if ( $item->current == 1 || $item->current_item_ancestor == true ) {
		$classes[] = 'active';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'required_active_nav_class', 10, 2 );

function footer_custom_menu( $theme_location ) {
    if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
        $menu = get_term( $locations[$theme_location], 'nav_menu' );
        $menu_items = wp_get_nav_menu_items($menu->term_id);

        //debug_to_console( $menu_items );

        // $menu_list  = '<nav>' ."\n";
        // $menu_list .= '<ul class="main-nav">' ."\n";
        $menu_list = '';
        $count = 0;
        $submenu = false;
        $class_names = '';
        foreach( $menu_items as $menu_item ) {

            $link = $menu_item->url;
            $title = $menu_item->title;

            if ( !$menu_item->menu_item_parent ) {
                $parent_id = $menu_item->ID;
                $menu_list .= '<div class="cell small-6 medium-6 large-3">' ."\n";
                $menu_list .= '<h5>'.$title.'</h5>' ."\n";
            }

            if ( $parent_id == $menu_item->menu_item_parent ) {

                if ( !$submenu ) {
                    $submenu = true;
                    $menu_list .= '<div><ul>' ."\n";


                }

                $menu_list .= '<li class="item '.$class_names.'">' ."\n";
                $menu_list .= '<a href="'.$link.'" class="title">'.$title.'</a>' ."\n";
                $menu_list .= '</li>' ."\n";



                if ( !isset( $menu_items[ $count + 1 ]->menu_item_parent ) || ( $menu_items[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ) ){
                    $menu_list .= '</ul></div>' ."\n";
                    $submenu = false;
                }

            }

            if ( !isset( $menu_items[ $count + 1 ]->menu_item_parent ) || ( $menu_items[ $count + 1 ]->menu_item_parent != $parent_id ) ){
                $menu_list .= '</div>' ."\n";
                $submenu = false;
            }

            $count++;
        }

        // $menu_list .= '</ul>' ."\n";
        // $menu_list .= '</nav>' ."\n";

    } else {
        $menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
    }
    echo $menu_list;
}



add_filter( 'wp_get_nav_menu_items', 'kw_nav_menu_classes', 10, 3 );

function kw_nav_menu_classes($items, $menu, $args) {
    _wp_menu_item_classes_by_context($items);
    return $items;
}


/*
 * return a list of top level menu items
 *
 * $menu (string) menu name or ID
 */
function header_menu( $menu_id, $classname = '' ) {

    if ( empty( $menu_id ) ) {
        return;
    }

    $menu_items = (array) get_sorted_menu_items( $menu_id );
    if ( empty( $menu_items ) ) {
        return;
    }

    //debug_to_console( $menu_items );


    $classname = is_string( $classname ) ? $classname : '';
    ob_start(); ?>

    <ul class="kw-c-menu <?php echo $classname; ?>">

        <?php foreach( $menu_items as $item ) :

            if( $item->current ) $item->classes[] = 'active';

            $item_classes = ( !empty( $item->classes ) ) ? implode( ' ', (array) $item->classes ) : '';

            $menu_item_class = array( "menu-item", "menu-item-type-{$item->type}", "menu-item-object-{$item->object}", "menu-item-{$item->ID}", $item_classes );
            $link_class = '';

            $has_children = isset( $item->children ) && count( $item->children );

            if ( $has_children ) {
                $menu_item_class[] = 'menu-item-has-children';

            } ?>

            <li class="<?php echo implode( ' ', $menu_item_class ); ?>">
                <a tabindex="0" href="<?php echo $item->url; ?>" ><?php echo $item->title; ?></a>

                <?php if( $has_children ): ?>
                    <svg style="position: absolute; width: 0; height: 0;" width="0" height="0" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <defs>
                            <svg id="icon-chevron" viewBox="0 0 1024 1024">
                                <title>Show More</title>
                                <path class="path1" d="M316 334l196 196 196-196 60 60-256 256-256-256z"></path>

                            </svg>
                        </defs>
                    </svg>
                    <button type="button"  class="js-toggle-header-menu kw-b-btn" data-toggle="sub-menu-<?php echo $item->ID; ?>">
                        <svg class="btn__icon btn__icon--bottom"><use xlink:href="#icon-chevron" /></svg><svg class="btn__icon btn__icon--top"><use xlink:href="#icon-chevron" /></svg>
                    </button>
                <?php endif; ?>


            </li>

        <?php endforeach; ?>

    </ul>

    <?php
    $html = ob_get_contents();
    ob_get_clean();
    return $html;
}

/*
 * Sort and nest nav menu items
 *
 * $menu (string) menu name or ID
 */
function get_sorted_menu_items( $menu_id ) {

    if ( empty( $menu_id ) ) {
        return;
    }

    $menu_items = (array) wp_get_nav_menu_items( $menu_id );

    if ( empty( $menu_items ) ) {
        return;
    }
    $items_with_children = array();

    foreach ( $menu_items as $item ) {
        if ( ! empty( $item->menu_item_parent ) ) {
            $parent_key = $item->menu_item_parent;

            if ( empty( $items_with_children[$parent_key] ) ) {
                $items_with_children[$parent_key] = array();
            }
            $items_with_children[$parent_key][] = $item;
        }
    }

    $sorted = array();
    foreach ( $menu_items as $item ) {
        if ( empty( $item->menu_item_parent ) ) {
            if ( isset( $items_with_children[$item->ID] ) ) {
                $item->children = sort_and_populate( $items_with_children[$item->ID], $items_with_children );

            }

            $sorted[] = $item;
        }
    }
    return $sorted;
}

/*
 * Loops through an array of any depth to build a tree of items based on a map of parents and their children
 * Used recursively to sort and nest menu items
 *
 * $items (array) array of menu items
 * $children_map (array) a map of menu item IDs that contain their children
 */
function sort_and_populate( $items, $children_map ) {

    $sorted_menu_items = array();
    foreach ( $items as $item ) {
        $children = isset( $children_map[$item->ID] ) ? $children_map[$item->ID] : array();
        if ( ! empty( $children ) ) {
            $item->children = sort_and_populate( $children, $children_map );

        }

        $sorted_menu_items[] = $item;
    }
    return $sorted_menu_items;
}

/*
 * Loops through an array of any depth to build a tree of items
 * Used recursively to build menu items
 *
 * $items (array) array of menu items
 */
function build_sub_menu_items( $items ) {

    //debug_to_console( $items, 'building sub menu' );

    foreach( $items as $item ) :

        $has_children = ( !empty( $item->children ) ) ? 'kw-c-submenu__has-children' : '';

        $item_class = array( "menu-item", "menu-item-type-{$item->type}", "menu-item-object-{$item->object}", "menu-item-{$item->ID}", $has_children, );

        $custom_menu_meta   = get_field( 'kw_menu_meta', $item->ID );
        $menu_item          = array_search_key( 'kw_menu__icon', $custom_menu_meta );

        //debug
        //debug_to_console( $item );

        ?>

        <li class="<?php echo implode( ' ', $item_class ); ?>">

            <?php if ( $item->url == '#' ) : ?>
                <div class="kw-non-link">

                    <?php if( !empty( $menu_item ) ): ?>
                        <img class="kw-c-non-link__icon" src="<?php echo $menu_item['url'] ?>" aria-hidden="true"/>
                    <?php endif; ?>
                    <div>
                        <div class="kw-non-link__title h5"><?php echo $item->title; ?></div>
                        <?php if( !empty( $item->description ) ): ?>
                            <p><?php echo $item->description; ?></p>
                        <?php endif; ?>
                    </div>

                </div>
            <?php else : ?>
                <a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
            <?php endif; ?>

            <?php if ( ! empty( $item->children ) ) : ?>
                <ul class="kw-c-sub-menu ">
                    <?php build_sub_menu_items( $item->children ); ?>
                </ul>
            <?php endif; ?>

        </li>

    <?php endforeach;
}

/*
 * return HTML for child menu items
 *
 * $menu (string) menu name or ID
 */
function header_sub_menu( $menu_id, $classname = '' ) {

    if ( empty( $menu_id ) ) {
        return;
    }

    $menu_items = (array) get_sorted_menu_items( $menu_id );
    if ( empty( $menu_items ) ) {
        return;
    }
    $classname = is_string( $classname ) ? $classname : '';
    ob_start(); ?>


    <?php foreach( $menu_items as $key => $item ) :

        //debug_to_console( $item );

        $has_children = ( ! empty( $item->children ) );
        $menu_item_class = array( "menu-item", "menu-item-type-{$item->type}", "menu-item-object-{$item->object}", "menu-item-{$item->ID}","grid-x" );
        ?>

        <?php if ( $has_children ) : ?>

        <div id="sub-menu-<?php echo $item->ID; ?>" class="dropdown-pane animated fadeIn fast <?php echo $classname; ?>"  data-options="vOffset:15; position:bottom; alignment:center; trapFocus: true; autoFocus:true; closeOnClick:true; hoverPane:true" data-dropdown >

            <ul class="kw-c-sub-menu">

                <?php build_sub_menu_items( $item->children ); ?>

            </ul>

        </div>

    <?php endif; ?>

    <?php endforeach; ?>

    <?php
    $html = ob_get_contents();
    ob_get_clean();
    return $html;
}