<?php
/**
 * Template Name: Submit Business
 */
acf_form_head();
// sanitize inputs
add_filter('acf/update_value', 'wp_kses_post', 10, 1);

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


				<!-- 

				edit 3/6/2017 

				- get rid of columns and go full width separating form on second page.

				<div class="column-left">
				</div>

				<div class="column-right">
				</div> 


				-->
				
                
                	<div class="entry-content">
                    	<?php the_content(); ?>
                    	<?php if( !is_page( 37205 ) ) { ?>
	                    	<div class="button viewmore-short">
	                    		<a href="<?php echo get_permalink(37205); ?>">Submit your Business</a>
	                    	</div>
                    	<?php } ?>
                	</div><!-- entry-content -->
                
                
                <?php if(is_page( 37205 )) : // form page ?>
                	<div class="entry-content">
                    	<h5>SIGN-UP HERE</h5>
		               <?php //the_content(); 
					   $return = get_bloginfo('url') . '/business-directory/business-directory-sign-up/business-directory-pay/';
					   //echo $return;
		                $formArg = array (
							'id' => 'acf-business-form',
							'post_id'	=> 'new_post',
							'post_title' => true,
							'return' => $return,
							
							'form' => true,
							/*'fields' => array(
								'email',
								'phone',
                                'description',
								'website',
								'category',
								'business_thumbnail',
								'business_photo',
								'address',
								'captcha'
								
							),*/
							'post_content' => true,
							'new_post'		=> array(
								'post_type'		=> 'business_listing',
								'post_status'		=> 'pending',
								'post_title'    => 'Title',
								//'tax_input'      => 'standard'
								),
							'submit_value'		=> 'Submit a Business'
							);
		                
		                acf_form($formArg);
						
		                ?>
                	</div><!-- entry-content -->
                <?php endif; ?>
                
                
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>