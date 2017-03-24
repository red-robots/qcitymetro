<?php
/**
 * Template Name: Church Listings
 */

get_header(); ?>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

			<?php while ( have_posts() ) : the_post(); ?>
				
            <div class="site-content">
            
            <header class="archive-header">
				<div class="border-title">
                    <h1><?php the_title(); ?></h1>
                </div><!-- border title -->
			</header><!-- .archive-header -->
            
<?php get_template_part('inc/church-header'); ?>
                
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
    'post_type'=>'church_listing',
    'posts_per_page' => 30,
    'paged' => $paged,
    'orderby' => 'title',
    'order' => 'ASC'
));
    if ($wp_query->have_posts()) : 
	while ($wp_query->have_posts()) :  $wp_query->the_post(); 
	 $founded = get_field('founded'); 
	 $location = get_field('address');
	 $email = get_field('email');
	 $phone = get_field('phone');
	 $website = get_field('website');
	 /*$membershipObject = get_field('membership');
	 $membership = $membershipObject->name;
	 $denominationObject = get_field('denomination');
	 $denomination = $denominationObject[0]->name;*/
	 $postId = get_the_ID();
	 $sizeTerms = get_the_terms( $postId, 'size' );
	 $membership = $sizeTerms[0]->name;
	 $denominationTerms = get_the_terms( $postId, 'denomination' );
	 $denomination = $denominationTerms[0]->name;
	 $pastor = get_field('pastor');
    if( $location ) {
    	$address = $location['address'];
    	$us = ', United States';
    	$trimmedAdd = str_replace($us, '', $address);
    }
	 
	/* echo '<pre>';
	 print_r($sizeTerms);
	 echo '</pre>';*/
	 //die;
	?>
    
    <div class="featured-event">
    
    <div class="featured-event-content-details">
        	<a href="<?php the_permalink(); ?>">DETAILS</a>
        </div><!-- featured event content -->
    
        <div class="featured-event-content">
        	<h2><?php the_title(); ?></h2>
           <?php if( $founded != '' ) { ?>
            	<div class="fe-cost"><strong>Founded:</strong> <?php echo $founded; ?></div>
            <?php } ?> 
			<?php if( $location != '' ) { ?>
            	<div class="fe-location"><strong>Location:</strong> <?php echo $trimmedAdd; ?></div>
            <?php } ?>
            <?php if( $phone != '' ) { ?>
            	<div class="fe-start"><strong>Phone:</strong> <?php echo $phone; ?></div>
            <?php } ?>
            <?php if( $membership != '' ) { ?>
            	<div class="fe-start"><strong>Size:</strong> <?php echo $membership ?></div>
            <?php } ?>
            <?php if( $denomination != '' ) { ?>
            	<div class="fe-cost"><strong>Denomination:</strong> <?php echo $denomination; ?></div>
            <?php } ?>
            
            <?php if( $pastor != '' ) { ?>
            	<div class="fe-cost"><strong>Pastor:</strong> <?php echo $pastor; ?></div>
            <?php } ?>
            
            <?php if( $website != '' ) { ?>
            	<div class="fe-website">
                    <a target="_blank" href="<?php echo $website; ?>">
                    	Visit Website
                    </a>
                </div>
            <?php } ?>
            
        </div><!-- featured event content -->
        <div class="submit-box-link"><a href="<?php the_permalink(); ?>">DETAILS</a></div>
    </div><!-- featured event -->
    
<?php
endwhile; pagi_posts_nav(); endif; wp_reset_query(); wp_reset_postdata();
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
        
        
                
          
        
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>