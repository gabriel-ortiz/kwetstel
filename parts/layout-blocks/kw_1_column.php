<?php

namespace ITBL\LayoutBlock\kw_1_column;

/**
 * This is an example template with comments on what do do
 *
 * @return void
 */

function setup()
{
	$n = function ($function) {
		return __NAMESPACE__ . '\\' . $function;
	};

	//add the hooks and filters here
	add_action("init", $n("register_block"));
}

function register_block()
{
	// check function exists
	if (function_exists('acf_register_block_type')) {
		$block_registered = acf_register_block_type(
			array(
				'name'              => 'kw_1_column',
				'title'             => __('One Column '),
				'description'       => __('Main column for blocks of content'),
				'render_callback'   => __NAMESPACE__ . '\\' . 'kw_1_column',
				'category'          => 'kw-blocks',
				'icon'              => 'text',
				'align'             => 'full',
				'mode'              => 'auto',
				'keywords'          => array(),
				'supports'			=> array(
					'align'	=> false,
				),
				'enqueue_assets'    => function () {
				}
			)
		);
	}
}
function kw_1_column($block, $content, $is_preview, $post_id)
{

	//		debug_to_console(  $block );

	//get all metadata fields
	$metadata       = get_fields();
	$title          = array_search_key('kw_block__title', $metadata);
	$slug_fallback  = array_search_key('id', $block);
	$slug           =  sanitize_title($title, $slug_fallback);
	$cta            = array_search_key('kw_block__cta', $metadata);
	$main           = array_search_key('kw_block__1_col_main', $metadata);


	if (!$metadata) return;

?>

	<section id="<?php echo $slug; ?>" class="kw-c-block kw-c-col">

		<div class="grid-container">

			<div class="grid-x grid-margin-x grid-margin-y kw-c-col__wrapper">

				<header class="cell small-12 medium-4 large-3 kw-c-col__promo">

					<div class="h3 kw-c-block__title" role="heading" aria-level="2"><?php echo $title; ?></div>

					<?php if ($cta) : ?>
						<div class="kw-c-cta kw-u-mt-1"><?php echo apply_filters('the_content', $cta); ?></div>
					<?php endif; ?>

				</header>

				<div class="cell small-12 medium-8 large-9 kw-c-col__main"><?php echo apply_filters('the_content', $main); ?></div>

			</div>

		</div>


	</section>



<?php
}
return __NAMESPACE__;
