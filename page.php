<?php
	/**
	 * The template for displaying all pages
	 *
	 * This is the template that displays all pages by default.
	 */
	global $post;
	
	get_header(); ?>

	<main id="kw-c-content" class="content">
		
		<?php while ( have_posts() ) : the_post(); ?>
			
			<?php
			
			$thumb_url  = get_the_post_thumbnail_url( $post, 'full' );
			$hero_class = ( $thumb_url ) ? 'kw-c-hero kw-c-hash-img' : 'kw-c-hero';
			$excerpt    = get_the_excerpt();
			$metadata   = get_fields();

			
			?>
			<section id="page-hero" class="<?php echo $hero_class ?>" style="background-image:url(<?php echo esc_url( $thumb_url ); ?>)">
				
				<div class="grid-container">
					
					<div class="grid-x align-center-middle kw-c-hero__inner text-center">
						
						<?php the_title( '<h1 class=" cell small-12 medium-10 large-8 kw-c-hero__title js-e-gsap__self-slideup--onload">', '</h1>' ); ?>
						
						<?php if( $excerpt ):?>

							<div class="cell small-12 medium-10 large-8 kw-c-hero__excerpt"><?php echo $excerpt; ?></div>
						
						<?php endif; ?>
						
					</div>
					
				</div>
				
			</section>

			<section <?php post_class( 'kw-c-main' ) ?> aria-label="<?php the_title(); ?>" role="main"><?php the_content(); ?></section> <!-- end #main -->
		
		<?php endwhile; ?>

	</main> <!-- end #content -->

<?php get_footer(); ?>