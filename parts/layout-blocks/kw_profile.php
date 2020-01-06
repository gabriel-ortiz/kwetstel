<?php
	namespace ITBL\LayoutBlock\kw_profile;
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
		add_action( "init", $n("register_profile_block") );
	}
	
	function register_profile_block() {
		// check function exists
		if( function_exists('acf_register_block_type') ) {
			$block_registered = acf_register_block_type( array(
					'name'              => 'kw_profile',
					'title'             => __('User Profile'),
					'description'       => __('Block for showing one user profile from the Users list'),
					'render_callback'   => __NAMESPACE__ . '\\' .'kw_profile',
					'category'          => 'kw-blocks',
					'icon'              => 'admin-users',
					'align'             => 'full',
					'mode'              => 'auto',
					'keywords'          => array('profile', 'biography', 'info'),
					'supports'			=> array(
						'align'	=> false,
					),
					'enqueue_assets'    => function(){}
				)
			);
		}
	}
	function kw_profile( $block, $content, $is_preview, $post_id  ){
		
		//setup some variables
		$metadata           = get_fields();
		$title              = array_search_key('kw_block__title', $metadata );
		$slug_fallback      = array_search_key( 'id', $block );
		$slug               =  sanitize_title( $title, $slug_fallback );
		$cta                = array_search_key( 'kw_block__cta', $metadata );
		$display_name       = array_search_key( 'display_name', $metadata );
		$user_description   = array_search_key( 'user_description', $metadata );
		$user_email         = array_search_key( 'user_email', $metadata );
		$user               = array_search_key(  'kw_block__user', $metadata );
		$user_id            = array_search_key( 'ID', $user );
		$user_title         = get_field( 'kw_user__title', "user_${user_id}"  );
		$user_img           = get_field( 'kw_user__profile_img', "user_${user_id}" );
		
		
		//debug_to_console( gettype( $user ) );
		
		
		?>
		<section id="<?php echo $slug; ?>" class="kw-c-block kw-c-profile">
			
			<div class="grid-container">
				
				<div class="grid-x grid-margin-x grid-margin-y kw-c-profile__wrapper">
					
					<header class="cell small-12 medium-4 large-3 kw-c-profile__promo">
						
						<?php if( $user_img ): ?>
							<div class="kw-c-profile__img-wrapper">
								<?php echo wp_get_attachment_image( $user_img['ID'], 'full', true  ); ?>
							</div>
						<?php endif; ?>
						
						<?php if( $display_name ): ?>
							<div class="h3 kw-c-block__title kw-u-mt-1" role="heading" aria-level="2"><?php echo $display_name; ?></div>
						<?php endif; ?>
						
						<?php if( $user_title ): ?>
							<div class="kw-c-profile__user-title kw-u-weight-bold kw-u-mt-nudge"><?php echo $user_title; ?></div>
						<?php endif; ?>
						
						<?php if( $cta ): ?>
							<div class="kw-c-cta kw-u-mt-1"><?php echo apply_filters( 'the_content', $cta ); ?></div>
						<?php endif; ?>
					
					</header>
					
					<?php if( $user_description ): ?>
						<div class="cell small-12 medium-7 kw-c-col__main"><?php echo apply_filters( 'the_content', $user_description ); ?></div>
					<?php endif; ?>
				
				</div>
			
			</div>
		
		
		</section>
		
		
		<?php
	}
	return __NAMESPACE__;