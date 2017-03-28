<?php
/**
 * The Template for displaying all single posts
 *
 */

get_header(); ?>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

<!-- 
			Main Content

======================================================== --> 			
			<div class="site-content">
			<?php while ( have_posts() ) : the_post(); 
			
			$image = get_field('business_photo'); 
			 $size = 'large';
			 $thumb = $image['sizes'][ $size ];
			 $location = get_field('address');
			 $email = get_field('email');
			 $phone = get_field('phone');
			 $website = get_field('website');
			 $category = get_field('category');
			 if($location != '') {
			 	$address = $location['address'];
			 	$us = ', United States';
				$trimmedAdd = str_replace($us, '', $address);
			 }
				$google_maps_link = get_field('google_maps_link');
			 
			
			//echo '<pre>';
			//print_r($category);
			?>

				<header class="archive-header">
				<div class="border-title">
                    <h1><?php the_title(); ?></h1>
                </div><!-- border title -->
				</header><!-- .archive-header -->
                
                <div class="entry-content">
                
                
				<div class="business-details">

                    <?php if( $image != '' ) { ?>
                        <div class="col-1">
                    <?php }?>
                       <div class="fe-location"><strong>Address:</strong>

	                       <?php if($google_maps_link):?>
                               <a href="<?php echo $google_maps_link;?>" target="_blank">
	                       <?php endif;?>
                                <?php echo $trimmedAdd; ?>
	                       <?php if($google_maps_link):?>
                               </a>
                            <?php endif;?>
                       </div>
                        <div class="fe-start"><strong>Phone:</strong> <?php echo $phone; ?></div>

                        <div class="fe-start"><strong>Email:</strong> <a href="<?php echo 'mailto:'.antispambot($email); ?>"><?php echo antispambot($email); ?></a></div>
                        <div class="fe-cost"><strong>Business Category:</strong> <?php echo $category[0]->name; ?></div>

                        <div class="fe-cost">
                            <a target="_blank" href="<?php echo $website; ?>">
                                <strong>View Website</strong>
                            </a>
                        </div>
					<?php if( $image != '' ) { ?>
                        </div><!--.col-1-->
                        <div class="col-2">
                            <img src="<?php echo $thumb; ?>" />
                        </div><!--.col-2-->
                        <div class="clear"></div>
					<?php } ?>
                </div><!-- business details -->

                
                	<?php the_content(); ?>
                </div><!-- entry content -->

				<nav class="nav-single">
					<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
				</nav><!-- .nav-single -->

				<?php //comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>
            </div><!-- entry content -->
            
<!-- 
			Ad Zone

======================================================== -->        
        <div class="widget-area">
        	<?php get_template_part('ads/right-big'); ?>
            <?php get_template_part('ads/right-small'); ?>
        </div><!-- widget area -->
        
        <div class="clear"></div>
        
<!-- 
			Related Posts

======================================================== --> 
 			<?php  wp_related_posts(); ?>
            <div class="clear"></div>
            
            
</div><!-- #content -->
	</div><!-- #primary -->
    
    
<!-- 
			Events

======================================================== --> 
<?php get_template_part('inc/events'); ?>
		

<?php get_footer(); ?>