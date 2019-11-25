<?php


function quick_nav( $blocks ){
	
	?>
	
		<section class="kw-c-quick-nav__wrapper">
			<div class="kw-c-quick-nav__scrollspy">
				<span class="fas fa-exchange-alt"></span>
				<a class="kw-c-quick-nav__item-text" data-toggle="dropdown-block-list">
					<span class="kw-is-active" data-target="page-hero">On This Page</span>
					<?php foreach( $blocks as $key => $block ):
						
						if( array_search_key('blockName', $block) == null ) continue;
						
						$text   = array_search_key( 'kw_block__title', $block );
						$id     = sanitize_title( $text );
						
						if( $text ): ?>
							<span data-target="<?php echo $id; ?>"><?php echo $text; ?></span>
						
						<?php endif;
					
					endforeach; ?>
				</a>
			</div>
			
			<div id="dropdown-block-list" class="dropdown-pane kw-c-quick-nav__dropdown-content">
				<div class="kw-c-quick-nav__menu">

					<a class="kw-c-quick-nav__menu-item" data-smooth-scroll data-options="offset:0" href="#page-hero">On This Page</a>
					<?php foreach( $blocks as $index => $item ):
						
						if( array_search_key('blockName', $item) == null ) continue;
						
						$text   = array_search_key( 'kw_block__title', $item );
						$id     = sanitize_title( $text );

						?>
							<a class="kw-c-quick-nav__menu-item" data-smooth-scroll data-options="offset:40" href="#<?php echo $id ?>"><?php echo $text; ?></a>
					<?php endforeach; ?>
					
				</div>
			</div>

		
		</section>

	<?php
	
}
