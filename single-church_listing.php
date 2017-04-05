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
                $church_thumb = $churchImage['sizes'][ 'thumbnail' ];
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
                <div class="fe-start"><strong>Phone:</strong><a href="tel:<?php echo preg_replace("/[^0-9]/","",$phone);?>"><?php echo $phone; ?></a></div>
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
                                <img src="<?php echo $church_thumb; ?>" />
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

			<?php
			$args = array(
				'post_type'=>'church_listing',
				'posts_per_page' => -1,
				'orderby'=>'name',
				'order'=>'DESC'
			);
			$terms = get_the_terms($post->ID,'denomination');
			if(!is_wp_error($terms)&&is_array($terms)&&!empty($terms)):
				$args['tax_query'] = array(
					array(
						'taxonomy'=>'denomination',
						'field'=>'term_id',
						'terms'=> $terms[0]->term_id
					)
				);
			endif;
			$posts = get_posts($args);
			$index = array_search($post,$posts);
			if($index !== false && count($posts)>1):?>
                <nav class="nav-single">
                    <h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
					<?php if(count($posts) >2):?>
						<?php $previous_index = $index > 0 ? $index -1 : count($posts) -1;?>
                        <span class="nav-previous">
                                <a href="<?php echo get_the_permalink($posts[$previous_index]);?>"><span class="meta-nav">&larr;</span><?php echo $posts[$previous_index]->post_title;?></a>
                            </span>
					<?php endif;?>
					<?php $next_index = $index < (count($posts) -1) ? $index +1 : 0; ?>
                    <span class="nav-next">
                            <a href="<?php echo get_the_permalink($posts[$next_index]);?>"><?php echo $posts[$next_index]->post_title;?><span class="meta-nav">&rarr;</span></a>
                        </span>
                </nav><!-- .nav-single -->
			<?php endif;?>
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