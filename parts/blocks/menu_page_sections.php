<?php

function menu_page_sections( $menu='' ){
	global $post;
	
	$ids = array();
	
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu ] ) ) {
		$menu = get_term( $locations[ $menu ] );
		
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		
	}
	
	if( empty( $menu_items ) ){
		debug_to_console( 'no menu found' );
		return;
		
	}
	
	foreach ( $menu_items as $item ) {
		$ids[] = get_post_meta( $item->ID, '_menu_item_object_id', true );
	}
	
	if ( isset( $ids ) ){
		$args = array(
			'post_type' => array( 'post', 'page' ), // Post types
			'post__in' => $ids,
			'orderby' => 'post__in'
		);
		
		$query = new WP_Query( $args );
	}
	
	debug_to_console( $query );

	if( !$query->found_posts ){
		debug_to_console( 'no posts found' );
		return;
	}
	
	?>
	<a href="#" id="kw-c-menu__sections-close" aria-label="Close menu" type="button" >
		<span class="fas fa-chevron-left kw-u-mr-nudge" aria-hidden="true"></span>
		<span>Back to Menu</span>
	</a>
	<div class="h5 kw-c-menu__list-title">Sections</div>
	<div class="kw-c-menu__sections-wrapper">
		
		<?php
		
		foreach ( $query->posts as $key => $page ):
			
			$blocks = parse_blocks( $page->post_content );
		
			if( $blocks ):
				$classes = array('kw-c-menu__section-page');
				$classes[] = 'kw-u-clean-list';
				$classes[] = ($page->ID == $post->ID ) ? 'menu-section--active': '';
				
				?>
				
				<ul id="menu-section-<?php echo $page->ID ?>" class="<?php echo implode( ' ', $classes);  ?>" data-menu="<?php echo $page->ID ?>">
					<?php
						
						foreach( $blocks as $index => $block ):
							
							if( array_search_key('blockName', $block) == null ) continue;
							
							$text   = array_search_key( 'kw_block__title', $block );
							$id     = sanitize_title( $text );
							$url    = get_permalink( $page->ID ) . "#${id}";
							
							debug_to_console( $url );
							
							?>
							
								<?php if( $text ): ?>
									<li>
										<a class="kw-c-menu__sections-link" href="<?php echo $url  ?>"><?php echo $text ?></a>
	
									</li>
							
								<?php endif; ?>
							
							<?php
						
						endforeach;
					?>
					
				</ul>
				
	
			<?php endif;
			
		endforeach;
		?>
	</div>
	<?php
	
}