<?php
	/**
	 * Template part for displaying posts
	 *
	 * Used for single, index, archive, search.
	 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'grid-x kw-u-mt-2 grid-margin-x' ); ?> role="article">

	<section class="entry-content cell small-3 medium-6 large-4" itemprop="text">
		<a class="kw-c-archive__thumbnail" href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'full' ); ?></a>
	</section> <!-- end article section -->

	<header class="article-header cell small-9 medium-6 large-8">
		<h2><a href="<?php the_permalink() ?>" rel="bookmark"
		       title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		<?php the_excerpt(); ?>
	</header> <!-- end article header -->


</article> <!-- end article -->
