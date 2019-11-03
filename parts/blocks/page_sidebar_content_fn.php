<?php


function page_sidebar_content_fn( $obj ){
	
	if( empty( $obj ) ){
		return;
	}
	
	//debug_to_console( $obj );
	
	?>
	
	<div class="kw-c-sidebar__wrapper">
		
		<?php foreach( $obj as $key => $sidebar ):
			
			$sidebar_id         = sanitize_title( "sidebar-${sidebar['kw_page__sidebar_id']}" );
			$sidebar_title      = $sidebar['kw_page__sidebar_title'];
			$sidebar_content    = $sidebar['kw_page__sidebar_content'];
			
			?>
			
			<section class="kw-c-sidebar__inner" id="<?php echo $sidebar_id ?>">
				
				<?php if( $sidebar_title ): ?>
					<div class="h4 kw-c-sidebar__title"><?php echo $sidebar_title; ?></div>
				<?php endif; ?>
				
				<?php if( $sidebar_content ): ?>
					<div class="kw-c-sidebar__content"><?php echo apply_filters('the_content', $sidebar_content ); ?></div>
				<?php endif; ?>
				
				
			</section>
			
			
		<?php endforeach; ?>
		
	</div>
	
	<?php
}