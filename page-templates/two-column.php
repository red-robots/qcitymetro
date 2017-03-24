<?php
/**
 * Template Name: Two Column
 */

get_header(); ?>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

			<?php while ( have_posts() ) : the_post(); 
			
			$right = get_field('right_content');
			?>
            
            <header class="archive-header">
				<div class="border-title">
                    <h1><?php the_title(); ?></h1>
                </div><!-- border title -->
				</header><!-- .archive-header -->
				
                <div class="column-left">
                	<div class="entry-content">
                    	<?php the_content(); ?>
                	</div><!-- entry-content -->
                </div><!-- column left -->
                
                <div class="column-right">
                	<div class="entry-content">
                    	<?php echo $right; ?>
                	</div><!-- entry-content -->
                </div><!-- column left -->
                
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>