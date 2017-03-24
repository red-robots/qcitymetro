<?php
/**
 * Template Name: Email Signup
 */

get_header(); ?>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

			<?php while ( have_posts() ) : the_post(); ?>
				<div class="entry-content">
                <h1 class="pagetitle"><?php the_title(); ?></h1>
					<?php the_content(); ?>
                    
						<?php the_field('email_signup_code') ?>
                    
					</div><!-- .entry-content -->
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>