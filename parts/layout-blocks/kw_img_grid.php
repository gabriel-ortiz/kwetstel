<?php
	namespace ITBL\LayoutBlock\image_grid;
	/**
	 * This is an example template with comments on what do do
	 *
	 * @return void
	 */
	
	function setup(){
		$n = function( $function ){
			return __NAMESPACE__ . '\\' . $function;
		};
		
		//add the hooks and filters here
		add_action( "init", $n("register_block") );
	}
	
	function register_block() {
		// check function exists
		if( function_exists('acf_register_block_type') ) {
			$block_registered = acf_register_block_type( array(
					'name'              => 'image_grid',
					'title'             => __('Image Grid Slideshow'),
					'description'       => __('Group of images displayed in a slideshow'),
					'render_callback'   => __NAMESPACE__ . '\\' .'image_grid',
					'category'          => 'kw-blocks',
					'icon'              => 'images-alt',
					'align'             => 'full',
					'mode'              => 'auto',
					'keywords'          => array(),
					'supports'			=> array(
						'align'	=> false,
					),
					'enqueue_assets'    => function(){}
				)
			);
		}
	}
	function image_grid( $block, $content, $is_preview, $post_id  ){
		
		$metadata = get_fields();
		$admin          = is_admin();
		$title          = array_search_key('kw_block__title', $metadata );
		$slug_fallback  = array_search_key( 'id', $block );
		$slug           = sanitize_title( $title, $slug_fallback );
		$cta            = array_search_key( 'kw_block__cta', $metadata );
		$imgs           = array_search_key( 'kw_block__imgs', $metadata );
		$featured_img   = array_search_key( 'kw_block__imgs_featured', $metadata );
		
		//debug_to_console( $block );
		
		?>
		
		<section id="<?php echo $slug; ?>" class="kw-c-block kw-c-img-grid">
			
			<div class="grid-container">
				
				<div class="grid-x grid-margin-x grid-margin-y kw-c-block__wrapper">
					
					<header class="cell small-12 medium-4 large-3 kw-c-col__promo">
						
						<div class="h3 kw-c-block__title" role="heading" aria-level="2"><?php echo $title; ?></div>
						
						<?php if( $cta ): ?>
							<div class="kw-c-cta kw-u-mt-1"><?php echo apply_filters( 'the_content', $cta ); ?></div>
						<?php endif; ?>
					
					</header>
					
					<?php if( $imgs ): ?>
					
						<div class="cell small-12 medium-8 large-9 kw-c-img-grid__img-wrapper">
						
						<?php foreach( $imgs as $key => $img ):
							
							$featured_class     =  ($img === reset($imgs ) && $featured_img ) ? 'kw-c-img-grid__featured' : '';
							$img_thumb          = $img['sizes']['medium_large'];
							$img_url            = $img['url'];
							$caption            = $img['description'];
							$alt                = $img['alt'];
							$title              = $img['title'];
							
							//debug_to_console( $img );
							
							?>

							<a class="kw-c-img-grid__img fancybox <?php echo $featured_class; ?>"
							   href="<?php echo $img_url ?>"
							   data-type="image"
							   data-caption="<?php echo $caption; ?>"
							   alt="<?php echo $alt ?>"
							   <?php echo ( ! $admin ) ? "data-fancybox='${slug}_group'" : ''; ?>
							>
								<img src="<?php echo $img_thumb ?>" />
								
								<div class="kw-c-img-grid__title kw-u-capitalize kw-u-weight-bold"><?php echo $title; ?></div>
								
								<span class="fas fa-expand kw-c-img-expand"></span>
							</a>
							
						<?php endforeach; ?>
						
						</div>
			
					<?php endif; ?>
				
				</div>
			
			</div>
		
		</section>
		
		
		<?php
	}
	return __NAMESPACE__;