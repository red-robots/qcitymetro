<?php
/**
 * Template Name: Church Submit
 */
// sanitize inputs
acf_form_head();
add_filter('acf/update_value', 'wp_kses_post', 10, 1);

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main" class="wrapper">

			<?php while ( have_posts() ) : the_post(); ?>
				
				<div class="entry-content">
                <h1 class="pagetitle"><?php the_title(); ?></h1>
                
				<?php //the_content();
				$return = get_bloginfo('url') . '/church-directory/church-directory-sign-up/thanks-for-submitting';  
                $formArg = array (
					'id' => 'acf-church-form',
					'post_id'	=> 'new_post',
					'post_title' => true,
					'return' => $return,
					///'post_content' => true,
					'form' => true,
					/*'fields' => array (
						0 =>'field_55e8549ede923',
						1 => 'field_55e854afde924'
					),*/
					'fields' => array(
						'founded',
						'phone',
						'website',
						'membership',
						'denomination',
						'pastor',
						'image_of_church',
						'image_of_pastor',
						'services',
                        'church_special',
						//'service',
						'address',
						'field_561688a693209',
						'church_contact_name',
						'church_contact_phone_number',
						'church_contact_email',
						'captcha'
						//'membership_drodown'
						
					),
					'new_post'		=> array(
						'post_type'		=> 'church_listing',
						'post_status'		=> 'pending',
						'post_title'    => 'My Church post',
						'tax_input'      => 'standard'
						),
					'submit_value'		=> 'Submit a Church'
					);
                //echo '<p>Start Date: ' . the_field("event_date") . '</p>';
                acf_form($formArg);
				
				
				/*$formId = $_POST['acf'];
				echo '<pre>';
				print_r($formId);
				echo '</pre>';
                */
                ?>
                            
                </div><!-- entry content -->
                
                
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>