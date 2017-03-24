<?php
/**
 * The main template file
 *
 * 
 */

get_header(); 


// First Query Homepage to get some featured Posts
$wp_query = new WP_Query();
	$wp_query->query(array(
	'post_type'=>'page',
	'pagename' => 'homepage'
));
if ($wp_query->have_posts()) :  while ($wp_query->have_posts()) :  $wp_query->the_post();

$featuredPost = get_field('featured_post');
$section1 = get_field('section_1_article');
$section2 = get_field('section_2_article');
$section3 = get_field('section_3_article');

endwhile; endif; wp_reset_query();
// End Homepage Query

?>
<div class="event-scroll">
<?php
	$wp_query = new WP_Query();
	$wp_query->query(array(
	'post_type'=>'event',
	'posts_per_page' => -1
));
	if ($wp_query->have_posts()) : ?>
	<?php while ($wp_query->have_posts()) :  $wp_query->the_post(); ?>
	
		<?php get_template_part('inc/events'); ?>
		
   <?php endwhile; endif; wp_reset_postdata(); ?>
</div><!-- event scroll -->

<div class="clear"></div>
        
	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">
        
<!-- 
			News & Buzz

======================================================== -->       
        
        <div class="site-content">
        	<section>
                <div class="border-title">
                    <h2>News &amp; Buzz</h2>
                </div><!-- border title -->
                    <div class="inner-content large-post">
                        <section>
                        <?php
							// start an empty array to gather all posts so we don't repeat
							$ids = array();
							
							
								$wp_query = new WP_Query();
								$wp_query->query(array(
								'post_type'=>'post',
								'posts_per_page' => 1,
								'category__not_in' => 30
							));
								if ($wp_query->have_posts()) : ?>
								<?php while ($wp_query->have_posts()) :  $wp_query->the_post(); ?>
								
									<?php if ( has_post_thumbnail() ) { ?>
                                <div class="postthumb-full">
                                     <?php the_post_thumbnail('large'); ?>
                                 </div><!-- post thumb -->
                             <?php } ?>
                            		 <h2><?php the_title(); ?></h2>
                            		 <div class="author">By <?php echo get_the_author(); ?></div>
                           		 <div class="entry-content"><?php echo get_excerpt(20); ?></div>
                            		<div class="q-readmore-gold"><a href="<?php the_permalink(); ?>">Read more</a></div>
									
							   <?php 
							   // get the id
							   $ids[] = get_the_ID();
							   endwhile; endif; wp_reset_postdata(); ?>
                        </section>
                    </div><!-- site content -->
                    
<!-- 
			News & Buzz Small Sections

======================================================== -->
                    
                    
                    <div class="inner-area homebars">
                        <section>
                        <?php 
							
                        $categories = array (
								'people', 
								'news', 
								'faith',
							);
							
							foreach ( $categories as $category ) :
							$wp_query = new WP_Query();
							$wp_query->query(array(
								'category_name' => $category,
								'post_type' => 'post',
								'posts_per_page' => '1',
								'category__not_in' => 30,
								'post__not_in' => $ids
							));
							if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); 
							if ( has_post_thumbnail() ) {
								$smallClass = 'small-post-content';
							} else {
								$smallClass = 'small-post-content-full';
							}
							
							?>
							
							
							
                            <div class="small-post">
                            		<a href="<?php the_permalink(); ?>">
                            		<div class="small-post-thumb">
                                    <?php if ( has_post_thumbnail() ) {
													the_post_thumbnail('thumbnail');
												} ?>
                                    </div><!-- small post thumb -->
                                    <div class="<?php echo $smallClass; ?>">
                                    	<h3><?php echo $category; ?></h3>
                                        <div class="clear"></div>
                                        <h2><?php the_title(); ?></h2>
                                    </div><!-- small post content -->
                            		</a>
                            </div><!-- smalll post -->
                            
							<?php 
							// get more ids
							   $ids[] = get_the_ID();
							endwhile; endif;  endforeach; //end for each category 
							
							$wp_query = new WP_Query();
							$wp_query->query(array(
								'category_name' => $category,
								'post_type' => 'post',
								'posts_per_page' => '1',
								'post__not_in' => $ids,
								'category_name' => 'sponsored'
							));
							if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                          
                            
                          <div class="small-post-sponsored"> 
                         		 <a href="<?php the_permalink(); ?>">
                            		<div class="small-post-thumb">
                                    <?php if ( has_post_thumbnail() ) {
													the_post_thumbnail('thumbnail');
												} ?>
                                    </div><!-- small post thumb -->
                                    <div class="small-post-content">
                                    	<h3>Sponsored</h3>
                                        <div class="clear"></div>
                                        <h2><?php the_title(); ?></h2>
                                    </div><!-- small post content -->
                            		</a>
                          </div><!-- small post sponsored --> 
                          
                          <?php 
							// get more ids
							   $ids[] = get_the_ID();
							endwhile; endif;  //end for each category ?>
                            
                        </section>
                    </div><!-- widget area -->
            </section>
            
            
        		
        </div><!-- site content -->
<!-- 
			Ad Zone

======================================================== -->        
        <div class="widget-area">
        	<?php get_template_part('ads/right-big'); ?>
            
        </div><!-- widget area -->
        
        <div class="clear"></div>
  <!-- 
			News Categories People Entertainment and Health

======================================================== -->      
        <section id="third" class="third-first ">
        	
            <div class="solid-border-title people">
                <h2 class="people-bg">People</h2>
            </div><!-- border title -->
            
            <div class="post-block blocks">
            <?php 
            $wp_query = new WP_Query();
			$wp_query->query(array(
				'category_name' => 'people',
				'post_type' => 'post',
				'posts_per_page' => '1',
				'category__not_in' => 30,
				'post__not_in' => $ids
			));
			if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
            
            
				<?php if ( has_post_thumbnail() ) { ?>
                	<div class="post-block-image">
                       <?php  the_post_thumbnail('thirds'); ?>
                   </div>
               <?php } ?>
                
            	<h2><?php the_title(); ?></h2>
            	<div class="postdate"><?php echo get_the_date(); ?></div>
            	<div class="entry-content"><?php the_excerpt(); ?></div>
            	<div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
            </div><!-- post block -->
            
            <?php // get more ids
				   $ids[] = get_the_ID();
				   endwhile; endif; wp_reset_postdata(); wp_reset_query(); ?>
        </section>
        
        <section id="third" class="third-first ">
        	<div class="solid-border-title entertainment">
                <h2 class="entertainment-bg">Entertainment</h2>
            </div><!-- border title -->
            <div class="post-block blocks">
            <?php 
            $wp_query = new WP_Query();
			$wp_query->query(array(
				'category_name' => 'entertainment',
				'post_type' => 'post',
				'posts_per_page' => '1',
				'category__not_in' => 30,
				'post__not_in' => $ids
			));
			if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
            
            
				<?php if ( has_post_thumbnail() ) { ?>
                	<div class="post-block-image">
                       <?php  the_post_thumbnail('thirds'); ?>
                   </div>
               <?php } ?>
                
            	<h2><?php the_title(); ?></h2>
            	<div class="postdate"><?php echo get_the_date(); ?></div>
            	<div class="entry-content"><?php the_excerpt(); ?></div>
            	<div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
            </div><!-- post block -->
            
            <?php // get more ids
				   $ids[] = get_the_ID();
				   endwhile; endif; wp_reset_postdata(); wp_reset_query(); ?>
        </section>
        
        <section id="third" class="third-last">
        	<div class="solid-border-title health">
                <h2 class="health-bg">Health</h2>
            </div><!-- border title -->
            <div class="post-block blocks">
            <?php 
            $wp_query = new WP_Query();
			$wp_query->query(array(
				'category_name' => 'health',
				'post_type' => 'post',
				'posts_per_page' => '1',
				'category__not_in' => 30,
				'post__not_in' => $ids
			));
			if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
            
            
				<?php if ( has_post_thumbnail() ) { ?>
                	<div class="post-block-image">
                       <?php  the_post_thumbnail('thirds'); ?>
                   </div>
               <?php } ?>
                
            	<h2><?php the_title(); ?></h2>
            	<div class="postdate"><?php echo get_the_date(); ?></div>
            	<div class="entry-content"><?php the_excerpt(); ?></div>
            	<div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
            </div><!-- post block -->
            
            <?php // get more ids
				   $ids[] = get_the_ID();
				   endwhile; endif; wp_reset_postdata(); wp_reset_query(); ?>
        </section>
        
        <div class="clear"></div>
  <!-- 
			Videos & Photos

======================================================== -->      
        <div class="site-content">
            <section>
                <div class="border-title">
                    <h2>Videos &amp; Photos</h2>
                    </div><!-- border title -->
                    
                    <!-- VIDEO GALLERIES -->
                    <div class="inner-content">
                    <iframe width="590" height="332" src="http://launch.newsinc.com/?type=VideoPlayer/Section=qcitystudio_hom_non_sec&video&autoplay=0" frameborder="no" scrolling="no" noresize marginwidth="0" marginheight="0"></iframe>
                    
                    <?php //get_template_part('inc/video'); ?>
                    
                		</div><!-- inner content -->    
                
                <div class="inner-area">
                <!-- PHOTO GALLERIES -->
                <section>
                 <?php 
            $wp_query = new WP_Query();
			$wp_query->query(array(
				'post_type' => 'gallery',
				'posts_per_page' => '2'
			));
			if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); 
			$main_field = get_field('photos');
			$first_img = $main_field[0]['photo'];
			$size = 'photo';
        	$thumb = $first_img['sizes'][ $size ];
			/*echo '<pre>';
			print_r($main_field);*/
			?>
			 
             <div class="gallery-thumb">
             <a href="<?php the_permalink(); ?>">
             <div class="gallery-thumb-overlay">
             	<div class="gallery-thumb-content">
                	<div class="gallery-thumb-title"><?php the_title(); ?></div>
                    <div class="gallery-thumb-date"><?php echo get_the_date(); ?></div>
                    <div class="gallery-thumb-more">MORE ></div>
                </div><!-- gallery thumb content -->
             </div><!-- gallery-thumb-overlay -->
			 <?php if ( has_post_thumbnail() ) { 
             			 the_post_thumbnail(); 
             		 } else { ?>
            <?php  echo '<img src="'.$thumb.'" />'; }?>
            </a>
             </div><!-- gallery thumb -->
            
            <?php endwhile; endif; ?>
                <div class="viewmore button"><a href="<?php bloginfo('url'); ?>/media-gallery">VIEW MORE GALLERIES</a></div>
                </section>
                </div><!-- inner area -->
                <section>
                </section>
            </section>
        </div><!-- site content -->
        
        <div class="widget-area">
        	<?php get_template_part('ads/right-small'); ?>
        	<?php get_template_part('inc/event-box'); ?>
        </div><!-- widget area -->
        
        <div class="clear"></div>
		

		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>