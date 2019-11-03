<?php
/**
 * Front Page Template
 */
global $post;

get_header(); ?>

<main id="kw-c-content" class="content">

<?php while ( have_posts() ) : the_post(); ?>
	
	<?php
	
	$excerpt    = get_the_excerpt();
	$metadata   = get_fields();
	$site       = get_bloginfo('name');
	
	
	?>
	<section id="page-hero" class="front-page-hero">
		
		<div class="kw-front-page__title-wrapper">
			<h1 class="kw-font-page__title"><?php echo $site; ?></h1>
			<?php if( $excerpt ): ?>
				<div class="kw-front-page__summary kw-u-mt-1">
					<?php echo $excerpt; ?>
				</div>
			<?php endif; ?>

		</div>
		<div class="kw-front-page__carousel"></div>
		<?php if( has_blocks($post->ID) ): ?>
			<a href="#front-page-main" data-smooth-scroll data-options="offset:0" class="kw-front-page__continue">Continue <span class="kw-u-ml-3 fas fa-long-arrow-alt-down animated bounce" aria-hidden="true"></span></a>
		<?php endif; ?>
		
	</section>
	
	<section id="front-page-main" <?php post_class( 'kw-c-main' ) ?> aria-label="<?php the_title(); ?>" role="main"><?php the_content(); ?></section> <!-- end #main -->

<?php endwhile; ?>

</main> <!-- end #content -->

<?php get_footer(); ?>