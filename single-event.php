<?php
/**
 * The Template for displaying all single events
 *
 * @package WordPress
 *
 */

get_header(); ?>

	<div id="primary" >
		<div id="content" role="main" class="wrapper">
		<div class="site-content">
			<header class="archive-header">
				<div class="border-title">
	                <h2 class="single-event">Qcity EVENTS</h1>
	            </div><!-- border title -->
			</header><!-- .archive-header -->

			<div class="single-event-e-links">
				
				    <div class="button button-thirds button-thirds-first">
				    	<a href="<?php bloginfo('url'); ?>/submit-an-event">Submit an event</a>
				    </div>
				    <div class="button button-thirds button-thirds-first">
				    	<a href="<?php bloginfo('url'); ?>/submit-an-event">promote your event</a>
				    </div><!-- -->
				    <div class="button button-thirds button-thirds-last">
				    	<a href="<?php bloginfo('url'); ?>/event-list">view all events</a>
				    </div>
			    
			</div><!-- eb-right -->


			<?php while ( have_posts() ) : the_post(); 
					 $startDate = DateTime::createFromFormat('Ymd', get_field('event_date'));
					 $endDate = DateTime::createFromFormat('Ymd', get_field('end_date'));
					 //$startDateSubmitted = get_field('event_start_date_submitted'); 
					 //$endDateSubmitted = get_field('event_end_date_submitted');
					 $start = get_field('event_start_time');
					 $end = get_field('event_end_time');
					 $contact = get_field('event_contact');
					 $email = get_field('event_email');
					 $phone = get_field('phone');
					 $cost = get_field('cost_of_event');
					 $venueName = get_field('name_of_venue');
					 $location = get_field('venue_address');
					 $tickets = get_field('link_for_tickets_registration');
					 //$tix = get_field('website_link');
					/* if (strpos($tix, 'http://') !== false) {
					 	$tickets = $tix;
					 } else {
						$tickets = 'http://' . $tix; 
					 }*/
					  $weblink = get_field('website_link');
					 /*if (strpos($link, 'http://') !== false) {
					 	$weblink = $link;
					 } else {
						$weblink = 'http://' . $link; 
					 }*/
					 $details = get_field('details');
					 //$categories = get_field('choose_categories');
					 $postId = get_the_ID();
					 $eventCat = get_the_terms( $postId, 'event_cat' );
					 $eventCategory = $eventCat[0]->name;
					 $image = get_field('event_image'); 
					//$imageSubmitted = get_field('event_image_submitted'); 
					 $size = 'large';
					 $thumb = $image['sizes'][ $size ];
					 $eventType = get_field('event_type');
					 // $newD->format('l, F j, Y');
					 
	 				/*echo '<pre>';
					print_r($eventCat);
					echo '</pre>';*/

			?>

				<header class="single-event">
					<h1><?php the_title(); ?></h1>
				</header>

				<?php if( has_excerpt() ) : ?>
                	<div class="single-excerpt"><?php the_excerpt(); ?></div>
            	<?php endif; ?>

            	<?php if ( function_exists( 'sharing_display' ) ) { ?>
				 	<div class="jetpack-social"><?php sharing_display( '', true ); ?></div>
				 <?php } ?>

				<div class="single-event-terms">
					<?php get_template_part('inc/show-primary-category'); ?>
				</div>

				<div class="clear"></div>

				<div class="single-event-date js-first-word-uppercase"><?php 
				
					if ( $endDate != '' ) { 
						echo $startDate->format('l, F j, Y') . ' - ' . $endDate->format('m/d/Y');
					} elseif( $startDate != '' ) { 
						echo ' ' . $startDate->format('l, F j, Y');
					} elseif( $endDateSubmitted != '' ) {
						echo $startDateSubmitted;
					} else {
						echo $startDateSubmitted . ' - ' . $endDateSubmitted;
					}
					?>
	            </div><!-- date -->

	            <?php if( $image != '' ) { ?>
	                <div class="single-eventimage">
	                	<a href="<?php echo $image['url']; ?>"><img src="<?php echo $thumb; ?>" /></a>
	                </div>
                <?php } ?>
                
                <div class="entry-content">
                
   
    <?php 

 //    if(has_term('featured', 'event_category')) {
	// 	$boxClass = '';
	// 	echo '<div class="featured-event-featured-single"><div class="featured-text">FEATURED</div></div>';
	// } 

	?>
    
    
                
                
                
                <div class="clear"></div>

                <div class="event-content blocks">
              		<?php echo $details; ?>
					<?php the_content(); ?>
					<?php if(strcmp(get_field("culture_block"),"yes")===0):?>
						<div class="culture-text">This is a Culture Blocks event, sponsored by <a href="https://www.artsandscience.org/" target="_blank">Arts &amp; Science Council</a>. Culture for All!</div><!--.culture-text-->
						<a href="https://www.artsandscience.org/programs/for-community/culture-blocks/asc-culture-blocks-upcoming-events/" target="_blank">
							<img src="<?php echo get_template_directory_uri()."/images/culture-blocks.jpg";?>" alt="Culture Blocks">
 						</a>
					<?php elseif(strcmp(get_field("charlotte_works_block"),"yes")===0):?>
						<div class="culture-text">This is a Charlotte Works event. Careers4All!</div><!--.culture-text-->
						<a href="https://www.artsandscience.org/programs/for-community/culture-blocks/asc-culture-blocks-upcoming-events/" target="_blank">
							<img src="<?php echo get_template_directory_uri()."/images/charlotte-works-logo.jpg";?>" alt="Charlotte Works">
 						</a>
 					<?php endif;?>
				</div>


			<div class="event-single-details blocks">
                
               <div class="el-date"><?php echo $startDate->format('n/j/y') ?></div>

            	<?php if( $venueName != '' ) { ?>
                	<div class="el-deets">Venue</div>
                	<div class="fe-start"><?php echo $venueName; ?></div>
                <?php } ?>

            	<?php if( $location != '' ) { ?>
            	<div class="el-deets">Address</div>
                <div class="fe-start"><?php echo $location; ?></div>
                <?php } ?>
                
                <?php if( $start != '' ) { ?>
                <div class="el-deets">Start Time</div>
                <div class="fe-start">
                <?php echo $start; ?></div>
                <?php } ?>
                
                <?php if( $end != '' ) { ?>
                <div class="el-deets">End Time</div>
                <div class="fe-start"><?php echo $end; ?></div>
                <?php } ?>
                
                <?php if( $cost != '' ) { ?>
                <div class="el-deets">Cost</div>
                <div class="fe-start"><?php echo $cost; ?></div>
                <?php } ?>
                

                
                <?php if( $eventCat != '' ) { ?>
                <div class="el-deets">Event Category</div>
                <div class="fe-start">
                <?php echo $eventCat[0]->name;
						// count the number of categories, loop through them and echo
						/*$numCat = count($categories);
						$looNum = 0;
						foreach( $eventCat as $cat ) {
						$loopNum++;
							if( $loopNum == $numCat ) {
								echo $cat[0]->name;
							} else {
								echo $cat[0]->name . ', '; 
							}
						}*/
					?>
                
                </div>
                <?php } ?>
                
                <!-- <?php if( $contact != '' ) { ?>
                <div class="fe-start"><strong>Contact:</strong> <?php echo $contact; ?></div>
                <?php } ?>
                
                <?php if( $phone != '' ) { ?>
                <div class="fe-start"><strong>Contact Phone:</strong> <?php echo $phone; ?></div>
                <?php } ?>
                
                <?php if( $email != '' ) { ?>
                <div class="fe-start"><strong>Contact Email:</strong>
                		<a href="mailto:<?php echo antispambot($email); ?>">
                          <?php echo antispambot($email); ?>
                        </a>
                    </div>
                <?php } ?> -->
                
                <?php if( $tickets != '' ) { ?>
                <div class="fe-website"><a target="_blank" href="<?php echo $tickets; ?>">Tickets/Registration</a></div>
                <?php } ?>
                <div class="clear"></div>
                <?php if( $weblink != '' ) { ?>
                <div class="fe-website"><a target="_blank" href="<?php echo $weblink; ?>">visit website</a></div>
                <?php } ?>
                
                
                
                
                </div><!-- event single details -->


               


<div class="clear"></div>

<div class="single-event-nav">
	<nav class="nav-single-event">
		<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
		
		<!-- <span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', 'twentytwelve' ) . '</span> Previous Event' ); ?></span>

		<span class="nav-next"><?php next_post_link( '%link', 'Next Event <span class="meta-nav">' . _x( '', 'Next post link', 'twentytwelve' ) . '</span> ' ); ?></span> -->

		<div class="event-viewall">
            <a href="<?php bloginfo('url'); ?>/events">Return to main Events Page</a>
          </div>

		<div class="event-viewall">
            <a href="<?php bloginfo('url'); ?>/event-list">View all Events</a>
          </div>

          


	</nav><!-- .nav-single -->
</div>



<div class="single-event-dropdown">
<script>
    $(function(){
      // bind change event to select
      $('#eventtype').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
	
</script>                
                <?php 
$url = get_bloginfo('url');
$cDir = $url . '/event-list';
//echo $url;

$denomargs = array(
    'orderby'           => 'name', 
    'order'             => 'ASC',
    'hide_empty'        => true, 
    'fields'            => 'all', 
); 

$dterms = get_terms('event_cat', $denomargs);

/*echo '<pre>';
print_r($dterms);
echo '<pre>';*/
?>
<form id="category-select" class=""  action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">

        <select name='eventtype' id='eventtype' class="eventtype"  >
        	<?php 
			echo '<option class="">View by Event Type</option>';
			echo '<option class="" value="' . $cDir . '">All</option>';
			foreach( $dterms as $dterm ) :
				echo '<option class="level-0" value="'.$url.'/event-category/'.$dterm->slug.'">'.$dterm->name.'</option>';
			endforeach;
			
			?>
        </select>

		<noscript>
			<input type="submit" value="View" />
		</noscript>
</form>
                
</div><!-- signle event dropdown -->               
              
               
                <?php /*$time_date = get_field('event_date');
			$endDate = get_field('end_date');
			$post_date = substr($time_date, 0, 10);
						print_r($post_date);*/ ?>
                
					</div><!-- .entry-content -->


 <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>

 <div class="clear"></div>

 				<div class="goto-comments">
                	<a href="#goto-comments">COMMENTS</a>
                </div>

                <div class="goto-comments">
                	<a href="<?php bloginfo('url'); ?>/email-signup">
                		Join The Community. Receive updates from Qcitymetro &raquo; &raquo; 
                	</a>
                </div>	
 <div class="clear"></div>

				<?php //comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>
            
            </div><!-- site content -->

		

<!-- 
			Ad Zone

======================================================== -->        
        <div class="widget-area">
        	<?php get_template_part('ads/right-big'); ?>
        </div><!-- widget area -->

<div class="clear"></div>
<div id="goto-comments"></div>
            <?php echo do_shortcode('[fbcomments url="" width="375" count="off" num="3" countmsg="wonderful comments!"]'); ?>

        </div><!-- #content -->
	</div><!-- #primary -->
        
<?php get_footer(); ?>