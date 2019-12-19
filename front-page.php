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
	$metadata   = get_fields();
	$carousel   = array_search_key( 'kw_front_page__carousel', $metadata );
	
	debug_to_console( $carousel );
	
	$slick_settings = array(
		'slidesToShow' => 1,
		'infinite'      => false,
		'prevArrow'     => '.kw-front-page__carousel-left',
		'nextArrow'     => '.kw-front-page__carousel-right',
		'arrows'        => true,
		'dots'          => false,
		'variableWidth' => true,
	);
	
	$enable_carousel = $carousel > 2;
	$carousel_class = ( $enable_carousel ) ? 'js-promo-carousel' : 'kw-is-static';
	
	?>
	<section id="page-hero" class="front-page-hero">
		
		<div class="kw-front-page__title-wrapper">
			<h1 class="kw-font-page__title"><?php echo $site; ?></h1>
			<?php if( $excerpt ): ?>
				<div class="kw-front-page__summary kw-u-mt-1">
					<?php echo $excerpt; ?>
				</div>
			<?php endif; ?>
			
			<?php if ( $enable_carousel ) : ?>
				<div class="kw-c-carousel__action kw-u-mt-1">
	
					<button class="kw-c-carousel__arrow kw-front-page__carousel-left"><span class="fas fa-chevron-left "></span></button>
					<button class="kw-c-carousel__arrow kw-front-page__carousel-right"><span class="fas fa-chevron-right "></span></button>
	
				</div>
			<?php endif; ?>

		</div>
		
		<?php if( $enable_carousel ): ?>
			<section class="kw-front-page__carousel-wrapper">

				<div class="kw-front-page__carousel <?php echo $carousel_class; ?>" data-slick='<?php echo array_to_json_string( $slick_settings ); ?>' >
				
				<?php foreach ( (array) $carousel as $key => $slide):
					
					$slide_type = array_search_key( 'kw_front_page__media_type', $slide );
					$slide_slug = array_search_key( 'kw_front_page__slide_content', $slide );
					$slide_cta  = array_search_key( 'kw_front_page__slide_cta', $slide );
					
					//debug_to_console( $slide_cta );
					
				?>

					<article class="kw-front-page-carousel__slide <?php echo $slide_type; ?>">
					
						<?php
							//if this is an image, run this UI
							if( $slide_type == 'front_page_img' ):
								
								$slide_img  = array_search_key( 'kw_front_page__image_slide', $slide );
							?>
								<div class="kw-front-page__carousel-img" style="background-image: url(<?php echo wp_get_attachment_image_url( $slide_img['ID'], 'full' ); ?>)" >
									
									<?php if( $slide_slug ): ?>
										<div class="kw-front-page__carousel-cta">
											<?php echo apply_filters( 'the_content', $slide_slug ); ?>
											
											<?php if( !empty( $slide_cta ) ): ?>
												<a class="button light-blue kw-u-weight-bold" href="<?php echo $slide_cta['url'] ?>"><?php echo $slide_cta['title']; ?></a>
											<?php endif; ?>
										</div>
	
									<?php endif; ?>
									

								</div>
								
								
						<?php
							//we have a video, so run this UI responsive-embed widescreen
							else: ?>

								<?php $slide_video = array_search_key( 'kw_front_page__video_slide', $slide ); ?>
								<div class="kw-front-page__carousel-video">
<!--									<iframe src="--><?php //echo $slide_video; ?><!--" style="border-radius: 4px;" allowfullscreen></iframe>-->
									<object style="width:100%;height:100%; float: none; clear: both;" data="<?php echo $slide_video; ?>">
									</object>
								</div>
					
						<?php endif; ?>
						
					</article>
					
				<?php endforeach; ?>
				
				</div>
				
			</section>
		<?php endif; ?>
		
		<?php if( has_blocks($post->ID) ): ?>
			<a href="#front-page-main" data-smooth-scroll data-options="offset:0" class="kw-front-page__continue">Continue <span class="kw-u-ml-3 fas fa-long-arrow-alt-down animated bounce" aria-hidden="true"></span></a>
		<?php endif; ?>
		
	</section>
	
	<section id="front-page-main" <?php post_class( 'kw-c-main' ) ?> aria-label="<?php the_title(); ?>" role="main"><?php the_content(); ?></section> <!-- end #main -->

<?php endwhile; ?>

</main> <!-- end #content -->

<?php get_footer(); ?>