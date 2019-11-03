<?php
	namespace ITBL\LayoutBlock\kw_carousel;
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
					'name'              => 'kw_carousel',
					'title'             => __('Carousel'),
					'description'       => __('Carousel slider block'),
					'render_callback'   => __NAMESPACE__ . '\\' .'kw_carousel',
					'category'          => 'formatting',
					'icon'              => 'images-alt',
					'align'             => 'full',
					'mode'              => 'auto',
					'keywords'          => array('Carousel', 'slideshow', 'images'),
					'supports'			=> array(
						'align'	=> false,
					),
					'enqueue_assets'    => function(){}
				)
			);
		}
	}
	function kw_carousel( $block, $content, $is_preview, $post_id  ){
		
		$metadata = get_fields();
		$admin    = is_admin();
		$title          = array_search_key('kw_block__title', $metadata );
		$slug_fallback  = array_search_key( 'id', $block );
		$slug           = sanitize_title( $title, $slug_fallback );
		$cta            = array_search_key( 'kw_block__cta', $metadata );
		$images         = array_search_key('kw_block__carousel_images', $metadata);
		
		//debug_to_console( $block );
		//debug_to_console($metadata);
		
		$slick_settings = array(
			'slidesToShow' => 1,
			'infinite'      => false,
			'prevArrow'     => '.kw-c-carousel__left',
			'nextArrow'     => '.kw-c-carousel__right',
			'arrows'        => true
		);
		
		?>
		
		<?php
		
		$enable_carousel = $images > 2; ?>
		
		<section id="<?php echo $slug; ?>" class="kw-c-block kw-c-carousel">
			
			<div class="grid-container">
				
				<div class="grid-x grid-margin-x kw-c-carousel__wrapper">
					
					<header class="cell small-12 medium-4 large-3 kw-c-col__promo">
						
						<?php if ( $title ) : ?>

							<div class="h3 kw-c-block__title" role="heading" aria-level="2"><?php echo $title; ?></div>
						
						<?php endif; ?>
						
						<?php if ( $cta ) : ?>

							<div class="kw-c-cta kw-u-mt-1"><?php echo apply_filters( 'the_content', $cta ); ?></div>
						
						<?php endif; ?>
						
						<?php if ( $enable_carousel ) : ?>

							<div class="kw-c-carousel__action">

								<button class="kw-c-carousel__arrow kw-c-carousel__left"><span class="fas fa-chevron-left "></span></button>
								<button class="kw-c-carousel__arrow kw-c-carousel__right"><span class="fas fa-chevron-right "></span></button>
								
							</div>
						
						<?php endif; ?>

					</header>
					
					<?php if ( $images ) : ?>
						
						<?php $carousel_class = ( $enable_carousel ) ? 'js-promo-carousel' : 'kw-is-static'; ?>

						<div class="cell auto kw-c-carousel__content">

							<div class="kw-c-carousel__slides <?php echo $carousel_class; ?>" data-slick='<?php echo array_to_json_string( $slick_settings ); ?>'>
								
								<?php foreach ( (array) $images as $image_id => $image) :
									
									//debug_to_console($image);
									$caption    = $image['caption'];
									$title      = $image['title'];
									
									?>
									<article class="kw-c-carousel__slide">
									
										<div class="grid-x">
											<div class="cell small-12 large-8 grid-x align-center-middle">
												<?php echo wp_get_attachment_image( $image['ID'], 'full', true, array( 'class'=> 'kw-c-carousel__img' ) ); ?>
											</div>
											
											<?php if( !empty( $caption ) || !empty( $title ) ): ?>
												
												<div class="cell small-12 medium-4 kw-c-carousel__desc">
													<div class="h5"><?php echo $title?></div>
													<p><?php echo $caption; ?></p>
												</div>
											<?php endif; ?>
										</div>

									</article>
								
								<?php endforeach; ?>

							</div>

						</div>
					
					<?php endif; ?>
				</div>
				

			
			</div>
		
		</section>
		
		
		<?php
	}
	return __NAMESPACE__;