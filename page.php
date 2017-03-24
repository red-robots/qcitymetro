<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

			<?php while ( have_posts() ) : the_post(); ?>
				
				<div class="entry-content">
                <h1 class="pagetitle"><?php the_title(); ?></h1>
                
                	 <?php if(is_page('sitemap')) {
								the_content(); 
								wp_nav_menu( array( 'theme_location' => 'sitemap' ) );
							} else {
                    		 	the_content();
							} ?>
                            
                </div><!-- entry content -->
                
                
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>