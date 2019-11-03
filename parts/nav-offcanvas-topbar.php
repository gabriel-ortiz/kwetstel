<?php
/**
 * The off-canvas menu uses the Off-Canvas Component
 *
 * For more info: http://jointswp.com/docs/off-canvas-menu/
 */

global $post;
//parse the blocks on the page
$blocks = parse_blocks( $post->post_content );

debug_to_console( $blocks );

?>


<header id="kw-c-top-bar"  class="header top-bar" role="banner" data-sticky-container>
	<div class="kw-c-top-bar__wrapper" data-sticky data-options="marginTop:0;stickyOn:small;" style="width: 100%">
		
		<ul class="breadcrumbs kw-c-top-bar__wrapper-inner kw-u-clean-list" >
			<!-- <li><button class="menu-icon" type="button" data-toggle="off-canvas"></button></li> -->
			<li class="kw-c-menu__trigger"><a data-toggle="menu-off-canvas"><span class="fas fa-th kw-u-font-size-lg"></span></a></li>
			<li class="kw-c-top-bar__site"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></li>
			<?php
				//if this is a regular page, then show the page name
				if(  ! is_front_page() ): ?>
					<li class="kw-c-top-bar__page"><?php echo get_the_title(); ?></li>
			<?php endif; ?>
			
			<?php
				//check to see if blocks exists on this page
				if( has_blocks( $post->ID ) ): ?>
				
				<li class="kw-c-quick-nav">
					<?php
						//call the quick-nav function, and pass it the block data
						get_block( 'quick_nav', $blocks );
					?>
				</li>
				
			<?php endif; ?>
			
			
		</ul>
		
	</div>

</header> <!-- end .header -->