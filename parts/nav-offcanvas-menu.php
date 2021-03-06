<?php
/**
 * The off-canvas menu uses the Off-Canvas Component
 *
 * For more info: http://jointswp.com/docs/off-canvas-menu/
 */

	/**
	 * The template part for displaying offcanvas content
	 *
	 * For more info: http://jointswp.com/docs/off-canvas-menu/
	 */
	

	
	$options = get_fields('options');
	
	$menu_img_id    = array_search_key( 'kw_settings__menu_featured_image', $options );
	$menu_img_bool  = array_search_key( 'kw_settings__menu_featured_image_bool', $options );
	
	?>

<div class="kw-c-menu off-canvas position-top" id="menu-off-canvas" data-off-canvas data-transition="overlap">


	
	<div class="kw-c-menu__wrapper" id="menu-wrapper">
		<!--Masthead-->
		<div class="kw-c-menu__masthead">
			
			<!--Background Image-->
			<div class="kw-c-masthead_bg-img" style="background-image: url(<?php echo wp_get_attachment_url( $menu_img_id ); ?>)"></div>
			
			<!--close button-->
			<button id="kw-c-menu__close" class="close-button" aria-label="Close menu" type="button" data-close>
				<span aria-hidden="true">&times;</span>
				<span class="kw-u-weight-medium kw-u-ml-nudge">close</span>
			</button>

			<div class="kw-c-menu__masthead-inner">
				
				<div class="kw-c-menu__home-url">
					<a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
				</div>

				<div class="kw-c-menu__tagline"><?php bloginfo('description'); ?></div>
				
				<?php if( $menu_img_bool ): ?>
					<div class="kc-c-menu__masthead-img-wrapper flex-container align-center-middle kw-u-mt-1">
						<?php echo wp_get_attachment_image( $menu_img_id, 'medium-large', true , array( 'class' => 'kw-c-menu__masthead-img show-for-large' ) ); ?>
					</div>
				<?php endif; ?>

			</div>
			


		</div>
		
		<!--Main menu list-->
		<div class="kw-c-menu__inner">
			
			<div class="h5 kw-c-menu__list-title">Menu</div>
			
			<?php
				if( has_nav_menu( 'main-nav' ) ){
					render_kw_menu();
				}
				

			
			?>
		</div>
		
		<!--Page Sections-->
		<div class="kw-c-menu__sections">
		
			<?php
				if( has_nav_menu( 'main-nav' ) ){
					
					get_block( 'menu_page_sections', 'main-nav' );
				}
			?>
		
		</div>
	</div>

</div>