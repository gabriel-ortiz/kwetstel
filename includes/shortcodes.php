<?php
namespace KW\Includes\Shortcodes;

//Shortcode template
/**
function shortcode_item($attributes = false, $content = null ){
//extend default attrs with values passed in
$data = shortcode_atts( array(
), $attributes );
//output buffering start
ob_start();
//then HTML goes here
?>
<?php
$html = ob_get_contents();
ob_get_clean();
return $html;
}
 */

function setup() {
	$n = function ( $function ) {
		return __NAMESPACE__ . '\\' . $function;
	};
	// NOTE: Uncomment to activate shortcode
	//add_shortcode( 'example_shortcode', $n( 'example_shortcode' ) );
	add_shortcode( 'sidebar', $n( 'sidebar_fn' ) );

}

function sidebar_fn($attributes = false, $content = null ){
//extend default attrs with values passed in
	$data = shortcode_atts( array(
		'id'    => ''
	), $attributes );
	

	
	//output buffering start
	ob_start();
	
	if( empty( $data['id'] ) ){
		$html = ob_get_contents();
		ob_get_clean();
		echo $content;
		return $html;
	}
	
	//then HTML goes here
	?>
	
		<a class="kw-c-sidebar__trigger has-content" href="#sidebar-<?php echo $data['id'] ?>" data-sidebar-open title="Learn more about <?php echo $content ?>" ><?php echo $content ?><span class="fas fa-window-restore kw-u-ml-nudge"></span></a>
	
	<?php
	
	$html = ob_get_contents();
	ob_get_clean();
	return $html;
}