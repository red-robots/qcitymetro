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
			 $thumb_thumb = $image['sizes']['thumbnail'];
			 $alt = $image['alt'];
			 $location = get_field('address');
			 $email = get_field('email');
			 $phone = get_field('phone');
			 $website = get_field('website');
			 $category = get_field('category');
			 $viewMap = null;
			 if($location != '') {
			 	$address = $location['address'];
			 	$us = ', United States';
				$trimmedAdd = str_replace($us, '', $address);
                $stringAdd = str_replace(' ', '+', $location['address']);
                $viewMap = 'https://www.google.com/maps/place/'.$stringAdd;
			 }
			//echo '<pre>';
			//print_r($category);
			?>

				<header class="archive-header">
				<div class="border-title">
                    <h1><?php the_title(); ?></h1>
                </div><!-- border title -->
				</header><!-- .archive-header -->
				<?php get_template_part('inc/business-header'); ?>
                
                <div class="entry-content">
                
                
				<div class="business-details">

                    <?php if( $image != '' ) { ?>
                        <div class="col-1">
                    <?php }?>
                       <div class="fe-location"><strong>Address:</strong>

	                       <?php if($viewMap):?>
                               <a href="<?php echo $viewMap;?>" target="_blank">
	                       <?php endif;?>
                                <?php echo $trimmedAdd; ?>
	                       <?php if($viewMap):?>
                               </a>
                            <?php endif;?>
                       </div>
                            <div class="fe-start"><strong>Phone:</strong><a href="tel:<?php echo preg_replace("/[^0-9]/","",$phone);?>"><?php echo $phone; ?></a></div>

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
                            <img src="<?php echo $thumb_thumb; ?>" alt="<?php echo $alt;?>"/>
                        </div><!--.col-2-->
                        <div class="clear"></div>
					<?php } ?>
                </div><!-- business details -->

                
                	<?php the_content(); ?>
                </div><!-- entry content -->
				<?php
				$args = array(
					'post_type'=>'business_listing',
					'posts_per_page' => -1,
                    'orderby'=>'name',
                    'order'=>'DESC'
				);
                $terms = get_the_terms($post->ID,'business_category');
				if(!is_wp_error($terms)&&is_array($terms)&&!empty($terms)):
                    $args['tax_query'] = array(
                        array(
                            'taxonomy'=>'business_category',
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