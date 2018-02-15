<?php
/**
   Taxonomy template
 
	To create different taxonomy templates, copy
	this file and create a new...
	
	Ex: taxonomy-my_custom_tax.php
 	
*/
get_header(); ?>
 
 	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">
<?php 
// get some info about the term queried
$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id;
$term_name = $queried_object->name; 
$term_slug = $queried_object->slug; 

?>
 
<?php //Get the correct taxonomy ID by id
$term = get_term_by( 'id', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>
 
<?php // use the term to echo the description of the term 
echo term_description( $term, $taxonomy ) ?>
 <div class="site-content">
            
    <header class="archive-header">
        <div class="border-title">
            <h1>Events - <?php echo $term_name; ?></h1>
        </div><!-- border title -->
    </header><!-- .archive-header -->	
    
<?php get_template_part('inc/event-header-searchby'); ?>


<?php
$today = date('Ymd');
$wp_query = new WP_Query();
	$wp_query->query(array(
	'post_type'=>'event',
	'posts_per_page' => -1,
	'meta_key' => 'event_date',
	'orderby' => 'event_date',
    'meta_value' => $today,
    'meta_compare' => '>=',
	'tax_query' => array(
		array(
			'taxonomy' => 'event_cat', // your custom taxonomy
			'field' => 'slug',
			'terms' => array( $term_slug ) // the terms (categories) you created
		)
	)
));
	if ($wp_query->have_posts()) :  while ($wp_query->have_posts()) :  $wp_query->the_post(); 


/*	$wp_query = new WP_Query();
	$wp_query->query(array(
	'post_type'=>'church_listing',
	'posts_per_page' => 10,
	'paged' => $paged,
	'orderby' => 'title',
	'order' => 'ASC',
	'tax_query' => array(
		array(
			'taxonomy' => 'denomination', // your custom taxonomy
			'field' => 'slug',
			'terms' => array( $term_name ) // the terms (categories) you created
		)
	)
));
if ($wp_query->have_posts()) :*/ ?>
<?php //while ($wp_query->have_posts()) : ?>
<?php //$wp_query->the_post();  

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
	 $charlotte_works_block = get_field("charlotte_works_block");
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
		'culture'=> $culture_block,
        'cw'=>$charlotte_works_block
	 );
	 
	 $newQuery[] = $mySort;
	
	endwhile; 
	else:
	echo 'All Events for this Event Type have passed.';
	endif;
// end of loop	


// Now we sort by date with the sort function

function cmp($a, $b) {
   $result = 0;
   // Sort rank for names.
   $rank['premium']  = 3;
   $rank['featured'] = 2;
   $rank['standard'] = 1;
 
   if ( $a['date'] == $b['date'] ) {
      // Dates are same so compare names within the date.
      if(!empty($a['terms'])&&!empty($b['terms'])){
		$aname = strtolower($a['terms']['0']->slug['0']);
		$bname = strtolower($b['terms']['0']->slug['0']);
		$arank = (isset($rank[$aname])) ? $rank[$aname] : 0;
		$brank = (isset($rank[$bname])) ? $rank[$bname] : 0;
		if ( $arank < $brank )
			$result = -1;
		else
			if ( $arank > $brank )

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


// sort
usort($newQuery,'cmp');

// loop through results
	
	$prevMonth = '';
	foreach ($newQuery as $value) : 
	
	$currentTerm = !empty($value['terms']) ? $value['terms']['0']->slug : '';
	// set the month
	$newEd = $value['date'];
	$eD = DateTime::createFromFormat('Ymd', $newEd);
	$month = $eD->format('F');
	
	// set the date
	$getDate = $value['date'];
	$newD = DateTime::createFromFormat('Ymd', $getDate);
	$day = $newD->format('l, F j, Y');
	 $daynum = $newD->format('n/j/y');

	if( $month != $prevMonth ) {
	
	?>
    <div class="event-page-date"><?php echo $month; ?></div>
    <?php 
	$prevMonth = $month;
	} // if month is not empty
	
	$image = $value['image']['sizes']['thumbnail'];
	
	/*echo '<pre>';
	print_r($value);
	echo '</pre>';*/
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
		<?php elseif(strcmp($value['cw'],'yes')===0):?>
			<div class="culture cw">
				<div class="circle">
					?
				</div><!--.circle-->
				<a href="https://www.artsandscience.org/programs/for-community/culture-blocks/asc-culture-blocks-upcoming-events/" target="_blank">
					<img src="<?php echo get_template_directory_uri()."/images/charlotte-works-logo.jpg";?>" alt="Charlotte Works">
				</a>
				<?php $desc = get_field("charlotte_works_block_rollover",54);
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
        <div class="featured-event-content-details-text">DETAILS</div><!-- featured event content -->
    
       <div class="featured-event-content">
        	<h2><?php echo $value['title']; ?></h2>
          	<div class="el-date"><?php echo $daynum; ?></div>
          	<div class="el-deets">Venue</div>
          <div class="fe-start"><?php echo $value['venue']; ?></div>
          	<div class="el-deets">Address</div>
            <div class="fe-location"><?php echo $value['location']; ?></div>
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
        <div class="clear"></div>
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
		<?php elseif(strcmp($value['cw'],'yes')===0):?>
			<div class="culture cw">
				<div class="circle">
					?
				</div><!--.circle-->
				<a href="https://www.artsandscience.org/programs/for-community/culture-blocks/asc-culture-blocks-upcoming-events/" target="_blank">
					<img src="<?php echo get_template_directory_uri()."/images/charlotte-works-logo.jpg";?>" alt="Charlotte Works">
				</a>
				<?php $desc = get_field("charlotte_works_block_rollover",54);
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
        	<div class="featured-event-content-details-text">DETAILS</div><!-- featured event content -->
        	<h2><?php echo $value['title']; ?></h2>
          <div class="el-date"><?php echo $daynum; ?></div>
          <div class="el-deets">Venue</div>
          <div class="fe-start"><?php echo $value['venue']; ?></div>
          <div class="el-deets">Address</div>
            <div class="fe-location"><?php echo $value['location']; ?></div>
            <div class="el-deets">Time</div>
            <div class="fe-start"><?php echo $value['time']; ?></div>
        <div class="clear"></div>
        </div><!-- featured event content -->
     </div><!-- event list -->
    
    <?php endif; ?>
            
<?php endforeach; 
?>	

<div class="clear"></div>
 
<?php 
// references pagination function in your functions.php file
	//pagi_posts_nav(); ?>	
    </div><!-- site content -->

<!-- 
			Ad Zone

======================================================== -->        
        <div class="widget-area">
        	<?php get_template_part('ads/right-big'); ?>
        </div><!-- widget area -->
        
        
                
          

		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>