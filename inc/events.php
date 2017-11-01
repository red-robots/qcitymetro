
<?php
$i=0;
$thedate = date("Ymd"); 
	$wp_query = new WP_Query();
	$wp_query->query(array(
	'post_type'=>'event',
	'posts_per_page' => -1,
	'meta_key' => 'event_date', // Date picker Custom Field "start_date"
    'meta_value' => $thedate, // set a value to compare your date with
    'meta_compare' => '>=', // Greater than
    'orderby' => 'meta_value', // order by date
    'order' => 'ASC',
	'tax_query' => array(
		array(
			'taxonomy' => 'event_category',
			'field'    => 'slug',
			'terms'    => 'premium',
		),
	),
));
	if ($wp_query->have_posts()) : ?>
<div class="event-scroll">    
<div class="flexslider carousel">
          <ul class="slides">
 
<?php while ($wp_query->have_posts()) :  $wp_query->the_post();

// num of posts
$numPosts = $wp_query->post_count;
$i++;
$date = DateTime::createFromFormat('Ymd', get_field('event_date'));
$newdate = DateTime::createFromFormat('Ymd', get_field('event_date'));
/*echo '<pre>';
print_r($date);*/
$image = get_field('event_image'/*, $term*/ ); 
$url = $image['url'];
$title = $image['title'];
$alt = $image['alt'];
// which size?
$size = 'thirds';
$thumb = $image['sizes'][ $size ];
?>
<li>
<div class="event blocks">
	
    <div class="event-image">
    	<div class="event-image-date"></div>
        <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>" />
    </div><!-- event image -->
    
	<div class="event-right">
        <div class="event-day">
        <?php if( $numPosts != $i && $numPosts - 1 != $i ) { ?>
        	<?php echo $date->format('l'); ?>   <?php echo $date->format('n/d'); ?>
        <?php } ?>
        </div>
        <!-- <div class="event-month-num"></div> -->
        <div class="event-title"><?php the_title(); //echo ac_get_title(38); ?></div>
    </div><!-- envent right -->
    
    <div class="event-link"><a href="<?php the_permalink(); ?>">View Event</a></div>
    
</div><!-- event -->
</li>
<?php endwhile; ?>

</ul>
</div><!-- flexslider -->
</div><!-- event-scroll -->
<?php endif; wp_reset_postdata(); wp_reset_query(); ?>
