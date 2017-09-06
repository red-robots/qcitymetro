<?php
/**
 * Template Name: Events & Entertainment
 */

get_header(); 

?>

<?php get_template_part('inc/events'); ?>
<?php 
 ?>
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
	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

<?php while ( have_posts() ) : the_post(); ?>

<div class="site-content">

    <header class="archive-header">
        <div class="border-title">
        	<h1><?php the_title(); ?></h1>
        </div><!-- border title -->
    </header><!-- .archive-header -->



<div class="event-page-links">

    <div class="button button-thirds button-thirds-first">
    	<a href="<?php bloginfo('url'); ?>/submit-an-event">Submit an event</a>
    </div>
    <!--<div class="button button-thirds button-thirds-first">
    	<a href="<?php bloginfo('url'); ?>/submit-an-event">promote your event</a>
    </div>-->
    <div class="button button-thirds button-thirds-last">
    	<a href="<?php bloginfo('url'); ?>/event-list">view all events</a>
    </div>

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
<form id="category-select" class="button button-thirds button-thirds-first"  action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">

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



<?php endwhile; // end of the loop. ?>


</div><!-- grey box -->

<?php 
// for query of today and forward
$today = date('Ymd');
$i = 0;
// Set the date to break out of loop at the bottom
$enddate = new DateTime(date("Ymd"));
$enddate->modify('+10 day');
$stop = $enddate->format('Ymd');
/*

	Query for the Next 10 days
		
---------------------------------
*/
// Start query
	$wp_query = new WP_Query();
    $wp_query->query(array(
    'post_type'=>'event',
    'posts_per_page' => -1,
	'meta_key' => 'event_date',
    'meta_value' => $today,
    'meta_compare' => '>='
));
    if ($wp_query->have_posts()) : 
	while ($wp_query->have_posts()) :  $wp_query->the_post(); 
	
	 // our Event variables
	 $title = get_the_title();
	 $permalink = get_the_permalink();
	 $image = get_field('event_image'); 
	 $location = get_field('venue_address');
	 $start = get_field('event_start_time');
	 $cost = get_field('cost_of_event');
   $venueName = get_field('name_of_venue');
	 $postId = get_the_ID();
	 $culture_block = get_field("culture_block");
	 $terms = wp_get_post_terms( $postId, 'event_category' );
	 $date = DateTime::createFromFormat('Ymd', get_field('event_date')); 
	 $eDate = $date->format('Ymd');
	 // create the array
	 
	 $mySort = array (
	 	'date' => $eDate,
		'title' => $title,
		'permalink' => $permalink,
		'location' => $location,
		'time' => $start,
		'cost' => $cost,
		'image' => $image,
		'terms' => $terms,
    'venue' => $venueName,
    'culture'=> $culture_block
	 );
	 
	 // put in new array
	 $newQuery[] = $mySort;
	 
	 endwhile; 
	endif; // end loop query

/*
		Comparison function for the sort
	
===========================================*/	
function cmp($a, $b) {
   $result = 0;
   
   if ( $a['date'] == $b['date'] ) {
      // Dates are same so compare names within the date.
      if(!empty($a['terms'])&&!empty($b['terms'])){
        if ( $a['terms']['0']->slug['0'] < $b['terms']['0']->slug['0'] )
            $result = -1;
        else
            if ( $a['terms']['0']->slug['0'] > $b['terms']['0']->slug['0'] )
                $result = 1;
      }
   }
   else {
      // Dates differ so just compare on date.
      if ( $a['date'] < $b['date'] )
         $result = -1;
      else
         $result = 1;
   }
   return $result;
}


// sort the Query
usort($newQuery,'cmp');

$prevDay = '';

	foreach ($newQuery as $value) : 
	// get the term
	$currentTerm = !empty($value['terms']) ? $value['terms']['0']->slug : '';
	// set the date
	$getDate = $value['date'];
	$newD = DateTime::createFromFormat('Ymd', $getDate);
	$day = $newD->format('l, F j, Y');
  $daynum = $newD->format('n/j/y');
	// set image
	$image = $value['image']['sizes']['thumbnail'];
	// Fill in the day
	if( $getDate != $prevDay ) {
	?>
    <div class="event-page-date js-first-word"><?php echo $day; ?></div>
    <?php 
	$prevDay = $getDate;
	} // if month is not empty
	// Show different if premium or featuerd
	if( $currentTerm == 'premium' || $currentTerm == 'featured' ) :
	?>
    
    <div class="featured-event">
        <?php if(strcmp($value['culture'],"yes")===0):?>
            <div class="culture">
                <div class="circle">
                    ?
                </div><!--.circle-->
                <a href="https://www.artsandscience.org/programs/for-community/culture-blocks/asc-culture-blocks-upcoming-events/" target="_blank">
				    <img src="<?php echo get_template_directory_uri()."/images/culture-blocks-title.jpg";?>" alt="Culture Blocks">
                </a>
                <?php $desc = get_field("culture_block_rollover",54);
                if($desc):?>
                    <div class="rollover">
                        <?php echo $desc;?>	
                    </div><!--.rollover-->
                <?php endif;?>
            </div><!--.culture-->
            <div class="clear"></div>
        <?php endif;?>
      <div class="featured-event-content-details">
      	<a href="<?php echo $value['permalink']; ?>">DETAILS</a>

      <div class="featured-event-content-details-text">DETAILS ></div><!-- featured event content -->
      
       <div class="featured-event-content">
        	<h2><?php echo $value['title']; ?></h2>
          <!-- <div class="el-date"><?php echo $daynum; ?></div> -->
          <div class="el-deets">Venue</div>
          <div class="fe-start"><?php echo $value['venue']; ?></div>
         <!--  <div class="el-deets">Address</div>
            <div class="fe-location"><?php echo $value['location']; ?></div> -->
            <div class="el-deets">Time</div>
            <div class="fe-start"><?php echo $value['time']; ?></div>
            <div class="el-deets">Cost</div>
            <div class="fe-cost"><?php echo $value['cost']; ?></div>

        </div><!-- featured event content -->

        <div class="featured-event-image">
            <div class="featured-event-featured">
              <div class="featured-text">FEATURED</div>
            </div><!-- featured-event-featured -->
            <?php if( $image != '' ) { ?>
                    <img src="<?php echo $image; ?>" />
            <?php } ?>
        </div><!-- featured event image -->

        <div class="daynum">
          <?php echo $daynum; ?>
        </div>
      </div><!-- featured event content -->

     </div><!-- featured event -->
    
    <?php else: ?>
    
    <div class="eventlist <?php if(strcmp($value['culture'],"yes")===0) echo "culture";?>">
		<?php if(strcmp($value['culture'],"yes")===0):?>
			<div class="culture">
				<div class="circle">
					?
				</div><!--.circle-->
				<a href="https://www.artsandscience.org/programs/for-community/culture-blocks/asc-culture-blocks-upcoming-events/" target="_blank">
				    <img src="<?php echo get_template_directory_uri()."/images/culture-blocks-title.jpg";?>" alt="Culture Blocks">
                </a>
                <?php $desc = get_field("culture_block_rollover",54);
				if($desc):?>
					<div class="rollover">
						<?php echo $desc;?>	
					</div><!--.rollover-->
				<?php endif;?>
			</div><!--.culture-->
			<div class="clear"></div>
		<?php endif;?>
    	<div class="featured-event-content-details">
        	<a href="<?php echo $value['permalink']; ?>">DETAILS ></a>
            <div class="featured-event-content-details-text">DETAILS ></div><!-- featured event content -->
        	<h2><?php echo $value['title']; ?></h2>
          <!-- <div class="el-date"><?php echo $daynum; ?></div> -->
          <div class="el-deets">Venue</div>
           <div class="fe-start"><?php echo $value['venue']; ?></div>
          <!-- <div class="el-deets">Address</div>
            <div class="fe-location"><?php echo $value['location']; ?></div> -->
            <div class="el-deets">Time</div>
            <div class="fe-start"><?php echo $value['time']; ?></div>

          <div class="daynum">
              <?php echo $daynum; ?>
          </div>
        </div><!-- featured event content -->

     </div><!-- event list -->
    
    <?php endif; ?>
    
<?php
// Only go out 10 days..., then get out.
if( $value['date'] >= $stop ) {break;}
// end resorted loop
endforeach;
?>


    <div class="button button-thirds button-thirds-first">
    	<a href="<?php bloginfo('url'); ?>/submit-an-event">Submit an event</a>
    </div>
    <div class="button button-thirds button-thirds-first">
    	<a href="<?php bloginfo('url'); ?>/submit-an-event">promote your event</a>
    </div>
    <div class="button button-thirds button-thirds-last">
    	<a href="<?php bloginfo('url'); ?>/event-list">view all events</a>
    </div> 




            
</div><!-- site content -->
            
<!-- 
			Ad Zone

======================================================== -->        
        <div class="widget-area">
        	<?php 
			get_template_part('ads/right-big'); 
			get_template_part('ads/right-small');
			get_template_part('ads/right-rail');
			?>
        </div><!-- widget area -->
        
        </div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>