<?php
/**
 * The template for displaying the footer. 
 *
 * Comtains closing divs for header.php.
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
	
	$options = get_fields('options');
	
	$menu_img_id    = array_search_key( 'kw_settings__menu_featured_image', $options );
	?>
					
				<footer id="kw-c-footer" class="footer" role="contentinfo">
					
					<?php if( $menu_img_id ): ?>

							<?php echo wp_get_attachment_image( $menu_img_id, 'full', true , array( 'class' => 'kw-c-footer__img' ) ); ?>

					<?php endif; ?>
					
					<div class="grid-container">
						<div class="inner-footer grid-x grid-margin-x grid-padding-x">

							<div class="small-12 medium-12 large-12 cell">
								<nav role="navigation">
									<?php //joints_footer_links(); ?>
								</nav>
							</div>

							<div class="small-12 medium-12 large-12 cell">
								<p class="source-org copyright kw-u-mt-2 kw-u-weight-bold">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.</p>
								<p class="kw-u-font-size-sm"><?php echo get_bloginfo('description'); ?></p>
							</div>

						</div> <!-- end #inner-footer -->
					</div>
					

				
				</footer> <!-- end .footer -->
			
			</div>  <!-- end .off-canvas-content -->
					
		 <!-- end .off-canvas-wrapper -->
		
		<?php wp_footer(); ?>
		
	</body>
	
</html> <!-- end page -->