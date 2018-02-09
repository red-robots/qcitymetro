<?php
/**
 * Template Name: Event Submit No Promo
 */
acf_form_head();
// sanitize inputs
add_filter('acf/update_value', 'wp_kses_post', 10, 1);

get_header(); ?>


<style type="text/css">
		.acf-field .acf-label p {display: none !important;}
</style>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

			<?php while ( have_posts() ) : the_post(); ?>
				
				<div class="entry-content">
                <h1 class="pagetitle"><?php the_title(); ?></h1>
                
				<?php the_content(); 
$return = get_bloginfo('url').'/submit-no-promotion-event/success-no-promotion-event-submitted';
                $formArg = array (
					'id' => 'acf-standard-event-form',
					'post_id'		=> 'new_post',
					'return' => $return,
					'post_title' => true,
					///'post_content' => true,
					'form' => true,
					'fields' => array(
						'event_date',
						'event_start_time',
						'event_end_time',
						// 'event_contact',
						// 'event_email',
						// 'phone',
						'cost_of_event',
						'name_of_venue',
						'venue_address',
						'link_for_tickets_registration',
						'website_link',
						'details',
						'choose_categories',
						'field_561bc0f76f014', // submitter message
						'event_contact_name',
						'event_contact_phone_number',
						'event_contact_email',
						// 'request_start_showing'
						'event_image'
					),
					'new_post'		=> array(
						'post_type'		=> 'event',
						'post_status'		=> 'pending',
						// 'post_title'    => '',
						'tax_input'      => array('event_category'=>'standard')
						),
					'submit_value'		=> 'Add My Event'
					);
                //echo '<p>Start Date: ' . the_field("event_date") . '</p>';
                acf_form($formArg);
                
                ?>
                            
                </div><!-- entry content -->
                
                
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>