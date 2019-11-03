<?php
	namespace ITBL\LayoutBlock\kw_quote;
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
					'name'              => 'quote_summary',
					'title'             => __('Quote Summary'),
					'description'       => __(''),
					'render_callback'   => __NAMESPACE__ . '\\' .'kw_quote',
					'category'          => 'kw-blocks',
					'icon'              => 'format-quote',
					'align'             => 'full',
					'mode'              => 'auto',
					'keywords'          => array('Quote', 'Pull quote'),
					'supports'			=> array(
						'align'	=> false,
					),
					'enqueue_assets'    => function(){}
				)
			);
		}
	}
	function kw_quote( $block, $content, $is_preview, $post_id  ){
		
		$metadata       = get_fields();
		$admin          = is_admin();
		$title          = array_search_key('kw_block__title', $metadata );
		$slug_fallback  = array_search_key( 'id', $block );
		$slug           = sanitize_title( $title, $slug_fallback );
		$quote_body     = array_search_key('kw_block_quote__body', $metadata );
		$quote_author   = array_search_key( 'kw_block_quote__author', $metadata );
		
		//debug_to_console( $metadata );
		
		?>
		
		<section id="<?php echo $slug; ?>" class="kw-c-block kw-c-quote">
			
			<div class="grid-container">
				
				<div class="grid-x align-center-middle kw-c-block__wrapper">
					
					<?php if( $quote_body ): ?>
				
						<div class="cell small-10 medium-8 large-7 kw-c-quote__wrapper">
						
							<div class="kw-c-quote__body"><?php echo apply_filters( 'the_content', $quote_body ); ?></div>
							
							<?php if( $quote_author ): ?>
				
								<p class="kw-c-quote__author"><?php echo $quote_author; ?></p>
								
							<?php endif; ?>
						</div>
						
					<?php endif; ?>
					
				</div>
			
			
			</div>
		
		</section>
		
		
		<?php
	}
	return __NAMESPACE__;