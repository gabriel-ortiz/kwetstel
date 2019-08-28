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
}