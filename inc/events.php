
<?php
$i=0;
$today = date("Ymd"); 
$post__in = array();

//tax query
$prepare_string = "SELECT DISTINCT tr.object_id as ID FROM $wpdb->term_relationships as tr INNER JOIN $wpdb->term_taxonomy as tt ON tt.term_taxonomy_id = tr.term_taxonomy_id INNER JOIN $wpdb->terms as t ON t.term_id = tt.term_id WHERE t.slug LIKE 'premium';";
$results = $wpdb->get_results( $prepare_string );
if($results):
    foreach($results as $result):
        $post__in[] = $result->ID;
    endforeach;
else:
    $post__in[] = -1;
endif;

//meta query
$temp__in = array();
$prepare_string = "SELECT DISTINCT ID FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id ) LEFT JOIN $wpdb->postmeta AS mt1 ON ( $wpdb->posts.ID = mt1.post_id ) WHERE ( ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value >= %d ) OR ( ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value < %d ) AND ( mt1.meta_key = 'end_date' AND mt1.meta_value >= %d ) ) OR ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value = '' ) ) ORDER BY CAST($wpdb->postmeta.meta_value as SIGNED) ASC";
                        
$prepare_args = array();
array_unshift($prepare_args,$today);
array_unshift($prepare_args,$today);
array_unshift($prepare_args,$today);
array_unshift($prepare_args,$prepare_string);
$results = $wpdb->get_results( call_user_func_array(array($wpdb, "prepare"),$prepare_args) );
if($results):
    foreach($results as $result):
        if(in_array($result->ID,$post__in)):
            $temp__in[] = $result->ID;
        endif;
    endforeach;
endif;
if(empty($temp__in)):
    $temp__in = array(-1);
endif;
$post__in = $temp__in;

$wp_query = new WP_Query();
$wp_query->query(array(
    'post_type'=>'event',
    'post__in'=> $post__in,
    'orderby' => 'post__in'
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
