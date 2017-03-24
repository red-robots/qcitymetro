<?php
/**
 * The Template for displaying all single Church Listings
 */

get_header(); ?>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

<!-- 
			Main Content

======================================================== --> 			
			<div class="site-content">
			<?php while ( have_posts() ) : the_post(); 
			
			$founded = get_field('founded'); 
			 $location = get_field('address');
			 $email = get_field('email');
			 $phone = get_field('phone');
			 $website = get_field('website');
			 $postId = get_the_ID();
			 $sizeTerms = get_the_terms( $postId, 'size' );
			 $membership = $sizeTerms[0]->name;
			 $denominationTerms = get_the_terms( $postId, 'denomination' );
			 $denomination = $denominationTerms[0]->name;
			 $pastor = get_field('pastor');
			 $churchImage = get_field('image_of_church');
			 $pastorImage = get_field('image_of_pastor');
			 $size = 'large';
			 $pastorSize = 'small';
        	 $church = $churchImage['sizes'][ $size ];
			 $pastorImg = $pastorImage['sizes'][ $pastorSize ];
			 
             if( $location ) {
    			 $address = $location['address'];
    			 $us = ', United States';
    			 $trimmedAdd = str_replace($us, '', $address);
            }
			?>

				<header class="archive-header">
				<div class="border-title">
                    <h1><?php the_title(); ?></h1>
                </div><!-- border title -->
				</header><!-- .archive-header -->
                
              <?php get_template_part('inc/church-header'); ?>  
                
                <div class="entry-content">
                
                <div class="business-details">
            <?php if( $churchImage != '' ) { ?>
                <div class="col-1">
                <?php }?>
               
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
            	<div class="fe-cost"><strong>Membership:</strong> <?php echo $membership; ?></div>
            <?php } ?>
            <?php if( $denomination != '' ) { ?>
            	<div class="fe-cost"><strong>Denomination:</strong> <?php echo $denomination; ?></div>
            <?php } ?>
            <?php if( $pastor != '' ) { ?>
            	<div class="fe-cost"><strong>Pastor:</strong> <?php echo $pastor; ?></div>
            <?php } ?>
            
            <?php if( $website != '' ) { ?>
            	<div class="fe-cost">
                    <a target="_blank" href="<?php echo $website; ?>">
                    	Visit Website
                    </a>
                </div>
            <?php } ?>
	                <?php if( $churchImage != '' ) { ?>
                        </div><!--.col-1-->
                            <div class="col-2">
                                <img src="<?php echo $church; ?>" />
                            </div>
                        </div><!--.col-2-->
	                <?php } ?>
               
                </div><!-- business details -->
                

                
               <!-- <h1><?php the_title(); ?></h1>
                <div class="clear"></div>-->
                
                <?php if( $pastorImage != '' ) { ?>
                <img src="<?php echo $pastorImg; ?>" class="alignright" />
                <?php } ?>
                
               
                
                
                
                	<?php if(have_rows('services')) : ?>
                    <div class="other-details">
                    <h3>Services</h3>
                    <ul>
                    <?php while(have_rows('services')) : the_row(); ?>
                    	<li class="fe-cost"><?php the_sub_field('service'); ?></li>
                    <?php endwhile; ?>
                    </ul>
                    </div><!-- business details -->
					<?php endif; ?>
                 
                
                	<?php the_content(); ?>
                    <div class="clear"></div>
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