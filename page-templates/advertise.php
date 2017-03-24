<?php
/**
 * Template Name: Advertise
 */

get_header(); ?>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

			<div class="entry-content">
                <h1 class="pagetitle"><?php the_title(); ?></h1>
                <?php the_content(); ?>
           </div>

			<div class="site-content">
			<?php while ( have_posts() ) : the_post(); ?>
				
				<div class="entry-content">
                    <h2 class="advertise-h2">Please complete the form below to discuss our advertising options.</h2> 
                    <div class="advertise-list">
                    <ul>
                    	<li>Inquire About Qcitymetro Demographics</li>
                        <li>Place A Digital Or Newsletter Ad</li>
                        <li>Request A Custom Advertising Package</li>
                        <li>Submit a "Sponsored" Article</li>
                        <li>Request Photo Coverage Of Your Event</li>
                    </ul></div>
                     <?php echo do_shortcode('[gravityform id="7" title="false" description="false"]'); ?>
                            
                </div><!-- entry content -->
                
                
			<?php endwhile; // end of the loop. ?>
			</div><!--  site content -->
            
            <div class="side-advertise">
            <div class="entry-content">
            	<h2 class="advertise-h2">Other Opportunities</h2>
            </div> 
            		<div class="button-advertise blocks">
                    	<h3>Submit your business to the directory</h3>
                        <p>Get your business listed</p>
                        <div class="submit-box-link">
                        		<a href="<?php bloginfo('url'); ?>/business-directory/business-directory-sign-up">></a>
                        </div><!-- event box link -->
                    </div><!-- button -->
                    <div class="button-advertise blocks">
                    	<h3>Promote an Event</h3>
                        <p>Submit your event online for promotion on our website and newsletter</p>
                        <div class="submit-box-link">
                        		<a href="<?php bloginfo('url'); ?>/submit-an-event">></a>
                        </div><!-- event box link -->
                    </div><!-- button -->
            </div><!-- widget area -->
            
		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>