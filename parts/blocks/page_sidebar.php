<?php

function page_sidebar( $args=array() ){
	
//	if( empty( $args ) ){
//		return;
//	}
	$defaults = array(
		'id'        => 'sidebar-off-canvas',
		'render_fn' => '',
		'data'      => ''
	);
	
	$options = recursive_parse_args( $args, $defaults );
	
	if( empty( $options['render_fn'] ) ){
		return;
	}
	
	
	?>
	<div class="kw-c-sidebar off-canvas position-right" id="<?php echo $options['id']?>" data-off-canvas data-transition="overlap">

		<button class="close-button" aria-label="Close Sidebar" type="button" data-close>
			<span aria-hidden="true">&times;</span>
		</button>
		
		<?php get_block( $options['render_fn'], $options['data'] ); ?>
		
	</div>
	
	<?php
	
}