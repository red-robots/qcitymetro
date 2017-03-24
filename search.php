<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<section id="primary" class="">
		<div id="content" role="main" class="wrapper">

		<?php if ( have_posts() ) : ?>

			
            
            <header class="archive-header">
				<div class="border-title">
                    <h1><?php printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                </div><!-- border title -->
			</header><!-- .archive-header -->

			<div class="site-content">

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				    <div class="featured-event">
    
   
        
        <div class="entry-content">
        	<h2 class="search"><?php the_title(); ?></h2>
            <div class="postdate"><?php echo get_the_date(); ?></div>
            <?php the_excerpt(); ?>
            <div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
        </div><!-- entry -content -->
        
    </div><!-- featured event -->
			<?php endwhile; ?>

			<?php pagi_posts_nav(); ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		<?php endif; ?>
        </div><!-- site content -->
        
        <!-- 
			Ad Zone

======================================================== -->        
        <div class="widget-area">
        	<?php get_template_part('ads/right-big'); ?>
            
        </div><!-- widget area -->
        
        <div class="clear"></div>

		</div><!-- #content -->
	</section><!-- #primary -->


<?php get_footer(); ?>