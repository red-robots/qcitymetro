<?php
/**
 * Template Name: Business Listings
 */

get_header(); ?>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

			
			<div class="site-content">
            
            <header class="archive-header">
				<div class="border-title">
                    <h1><?php the_title(); ?></h1>
                </div><!-- border title -->
			</header><!-- .archive-header -->
			
<?php get_template_part('inc/business-header'); ?> 		
			
<!-- 
			Events Query 3 days
           

======================================================== --> 
<?php 
$today = date('Ymd');
$i = 0;
/*

		TODAY  FEATURED
---------------------------------
*/
// Start query
	$wp_query = new WP_Query();
    $wp_query->query(array(
    'post_type'=>'business_listing',
    'posts_per_page' => 30,
    
    'orderby' => 'title',
    'order' => 'ASC'
));
    if ($wp_query->have_posts()) : 
	while ($wp_query->have_posts()) :  $wp_query->the_post(); 
	 $image = get_field('business_thumbnail'); 
	 $size = 'thumbnail';
	 $thumb = $image['sizes'][ $size ];
	 $location = get_field('address');
	 $email = get_field('email');
	 $phone = get_field('phone');
	 $website = get_field('website');
	 $category = get_field('category');
	 
     if( $location ) {
    	$address = $location['address'];
    	$us = ', United States';
    	$trimmedAdd = str_replace($us, '', $address);
    }

    // echo '<pre>';
    // print_r($address);
    // echo '</pre>';
	 
	?>
    
    <div class="featured-event">
    
    <div class="featured-event-content-details">
        	<a href="<?php the_permalink(); ?>">DETAILS</a>
        </div><!-- featured event content -->
    
    	<div class="featured-event-image">
        <?php if( $image != '' ) { ?>
        		<img src="<?php echo $thumb; ?>" />
        <?php } ?>
        </div><!-- featured event image -->
        <div class="featured-event-content">
        	<h2><?php the_title(); ?></h2>
            <?php if( $location != '' ) { ?>
            	<div class="fe-location"><?php echo $trimmedAdd; ?></div>
            <?php } ?>
            <?php if( $phone != '' ) { ?>
            	<div class="fe-start"><?php echo $phone; ?></div>
            <?php } ?>
            <?php if( $website != '' ) { ?>
            	<div class="fe-website"><a target="_blank" href="<?php echo $website; ?>">view website</a></div>
            <?php } ?>
        </div><!-- featured event content -->
        
        <div class="submit-box-link"><a href="<?php the_permalink(); ?>">DETAILS</a></div>
        
    </div><!-- featured event -->
    
<?php
endwhile; endif; wp_reset_query(); wp_reset_postdata();
?>
           
            
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