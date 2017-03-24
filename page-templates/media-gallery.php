<?php
/**
 * Template Name: Media Gallery
 */

get_header(); 

get_template_part('ads/leaderboard-interior');
?>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

			<?php while ( have_posts() ) : the_post(); 
			
			$video = get_field('media_gallery_video');
			
			?>
				
				
                
                
    <div class="site-content">
     
        
        <header class="archive-header">
            <div class="border-title">
                <h1><?php the_title(); ?></h1>
            </div><!-- border title -->
		</header><!-- .archive-header -->
       <?php endwhile; // end of the loop. ?>
       <section class="mg-top">         
        <div class="entry-content">
         
         <h2>Videos</h2>       
         
         <?php if( $video != '' ) { 
		 		echo '<div class="mg-video">';
				echo $video; 
				echo '</div>';
			} ?>
                	
        </div><!-- entry content -->
    <div class="viewmore-short button"><a href="http://video.qcitymetro.com">See Qcity Metro Videos</a></div> 
    </section>
    
    
    
    <section>
    <div class="entry-content">
    <h2>Photo Galleries</h2> 
    <div class="clear"></div>
    
      <?php 
	  $i=0;
            $wp_query = new WP_Query();
			$wp_query->query(array(
				'post_type' => 'gallery',
				'posts_per_page' => '4'
			));
			if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); 
			$i++;
			$main_field = get_field('photos');
			$first_img = $main_field[0]['photo'];
			$size = 'photo';
        	$thumb = $first_img['sizes'][ $size ];
			/*echo '<pre>';
			print_r($main_field);*/
			if( $i == 2 ) {
				$class = 'theright';
				$i =0;
			} else {
				$class = 'theleft';
			}
			?>
			 
             <div class="gallery-thumb-page <?php echo $class; ?>">
             <a href="<?php the_permalink(); ?>">
             <div class="gallery-thumb-overlay">
             	<div class="gallery-thumb-content">
                	<div class="gallery-thumb-title">
                    <div class="div-expand">
					<?php the_title(); ?>
                    </div></div>
                    <div class="gallery-thumb-date"><?php echo get_the_date(); ?></div>
                    <div class="gallery-thumb-more">MORE ></div>
                </div><!-- gallery thumb content -->
             </div><!-- gallery-thumb-overlay -->
			 <?php if ( has_post_thumbnail() ) { 
             			 the_post_thumbnail('photo'); 
             		 } else { ?>
            <?php  echo '<img src="'.$thumb.'" />'; }?>
            </a>
             </div><!-- gallery thumb -->
            
            <?php endwhile; endif; ?>
    
    <div class="clear"></div>
    <div class="viewmore-short button"><a href="<?php bloginfo('url'); ?>/media-gallery/photos">view all galleries</a></div> 
    </div><!-- enty- content -->
    </section>           
     </div><!-- site content -->
     
     
     <div class="widget-area">
     <?php get_template_part('ads/right-big'); ?>
     <?php get_template_part('inc/event-box'); ?>
     </div><!-- widget-area -->
                
                
			

		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>