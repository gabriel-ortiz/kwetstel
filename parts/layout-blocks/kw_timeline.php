<?php
	
	namespace ITBL\LayoutBlock\kw_timeline;
	/**
	 * This is an example template with comments on what do do
	 *
	 * @return void
	 */
	
	function setup() {
		$n = function ( $function ) {
			return __NAMESPACE__ . '\\' . $function;
		};
		
		//add the hooks and filters here
		add_action( "init", $n( "register_block" ) );
	}
	
	function register_block() {
		// check function exists
		if ( function_exists( 'acf_register_block_type' ) ) {
			$block_registered = acf_register_block_type( array(
					'name'            => 'timeline',
					'title'           => __( 'Timeline' ),
					'description'     => __( 'Timeline Block for displaying either a date timeline or event timeline' ),
					'render_callback' => __NAMESPACE__ . '\\' . 'kw_timeline',
					'category'        => 'kw-blocks',
					'icon'            => 'editor-ul',
					'align'           => 'full',
					'mode'            => 'auto',
					'keywords'        => array( 'timeline', 'date', 'event' ),
					'supports'        => array(
						'align' => false,
					),
					'enqueue_assets'  => function () {
					}
				)
			);
		}
	}
	
	function kw_timeline( $block, $content, $is_preview, $post_id ) {
		
		$metadata = get_fields();
		$admin    = is_admin();
		$title          = array_search_key('kw_block__title', $metadata );
		$slug_fallback  = array_search_key( 'id', $block );
		$slug           = sanitize_title( $title, $slug_fallback );
		$cta            = array_search_key( 'kw_block__cta', $metadata );
		$timelines      = array_search_key('kw_block_timeline__blocks', $metadata);
		
		//debug_to_console( $metadata );
		
		?>
		
		<section id="<?php echo $slug; ?>" class="kw-c-block kw-c-timeline">
			
			<div class="grid-container">
				<div id="<?php echo $slug; ?>" class="grid-x grid-margin-x grid-margin-y kw-c-block__wrapper">
					<header class="cell small-12 medium-4 large-3 kw-c-col__promo">
						
						<div class="h3 kw-c-block__title" role="heading" aria-level="2"><?php echo $title; ?></div>
						
						<?php if( $cta ): ?>
							<div class="kw-c-cta kw-u-mt-1"><?php echo apply_filters( 'the_content', $cta ); ?></div>
						<?php endif; ?>
					
					</header>
					
					
					<?php if( $timelines ): ?>
						<div class="cell small-12 medium-8 large-9 kw-c-timeline__inner-wrapper">
							<ul>
								
								<?php foreach ($timelines as $key => $timeline):
									
									$timeline_title     = $timeline['kw_block__timeline_block_title'];
									$timeline_subtitle  = $timeline['kw_block__timeline_block_subtitle'];
									$timeline_content   = $timeline['kw_block__timeline_block_content'];
									
									?>

									<li class="kw-c-timeline__block">
										<div class="marker"></div>
										<div class="kw-c-timeline__content">
											<h5><?php echo $timeline_title; ?></h5>
											<?php if( $timeline_subtitle ): ?>
												<div class="kw-c-timeline__subtitle"><?php echo $timeline_subtitle; ?></div>
											<?php endif; ?>
											<p><?php echo apply_filters('the_content', $timeline_content); ?></p>
										</div>
									</li>
								
								<?php endforeach; ?>

							</ul>

						</div>
					
					<?php endif; ?>
				
				</div>

				
			</div>

		</section>
		
		
		<?php
	}
	
	return __NAMESPACE__;