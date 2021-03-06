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
$sponsoredPost = get_field('sponsored_content', 349);
$featuredPost = get_field('featured_post');
$section1 = get_field('section_1_article');
$section2 = get_field('section_2_article');
$section3 = get_field('section_3_article');

endwhile; endif; wp_reset_query();
// End Homepage Query

?>
<!-- Used to only show popout newsletter on homepage -->
<span id="homepage-flag" style="display: none" ></span>
<?php get_template_part('inc/events'); ?>


<div class="clear"></div>
        
	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">
        
<!-- 
			News & Buzz

======================================================== -->       
        
        <div class="site-content">
        	<section>
                <header class="archive-header">
                <div class="border-title">
                    <h2>News &amp; Buzz</h2>
                </div><!-- border title -->
                </header>
                
                    <div class="inner-content large-post">
                        <section>
                        <?php
							// start an empty array to gather all posts so we don't repeat
							$ids = array();
							
							$posts = $featuredPost; 
							foreach($posts as $post) :
							setup_postdata( $post ); 
							$video = get_field( 'video_single_post' );
							
							?>
								
							<?php if( $video != '' ) :
									echo $video;
									else:
								if ( has_post_thumbnail() ) { ?>
                             <div class="postthumb-full">
                                 <?php the_post_thumbnail('large'); ?>
                             </div><!-- post thumb -->
                         <?php } endif;?>
                         <h2><?php the_title(); ?></h2>
                         <div class="author">
                         <?php $guestAuthor = get_field('author_name');
									if( $guestAuthor != '' ) {
										echo $guestAuthor;
									} else { ?>
								By <?php echo get_the_author(); } ?>
                         </div><!-- author -->
                     		<div class="entry-content">
								<?php //echo get_excerpt(20); ?>
                                <?php the_excerpt(); ?>
                            </div>
                       	 <div class="q-readmore-gold"><a href="<?php the_permalink(); ?>">Read more</a></div>
									
							   <?php 
							   
							   // get the id
							   $ids[] = get_the_ID();
							   endforeach;
							   wp_reset_postdata(); 
							   
							   /* 	
							   		we are going to query these later below but we need to get
							    	their ID's first so we don't repeat oursleves. 
								*/
								// section 1
							   $posts = $section1; 
							   foreach($posts as $post) :
									setup_postdata( $post ); 
									$ids[] = get_the_ID();
								endforeach;
								wp_reset_postdata();
								
								// section 2
								$posts = $section2; 
								foreach($posts as $post) :
									setup_postdata( $post ); 
									$ids[] = get_the_ID();
								endforeach;
								wp_reset_postdata();
								
								// section 3
								$posts = $section3; 
								foreach($posts as $post) :
									setup_postdata( $post ); 
									$ids[] = get_the_ID();
								endforeach;
								wp_reset_postdata(); wp_reset_query();
								// Finally get all "Sponsored" category posts
								$myposts = get_posts(array(
									'posts_per_page'   => -1, // get all posts.
									'cat' => 30,
									/*'tax_query'     => array(
										array(
											'taxonomy'  => 'category',
											'field'     => 'term_id',
											'terms'     => 30,
										),
									),*/
									'fields'        => 'ids', // Only get post IDs
								));
								// now loop through them
								foreach( $myposts as $mypost ) :
								   //$ids[] = get_the_ID();
								endforeach;
							   wp_reset_postdata();
							   
							   ?>
                        </section>
                    </div><!-- site content -->
                    
<!-- 
			News & Buzz Small Sections

======================================================== -->
                    <?php
						
					?>
                    
                    <div class="inner-area homebars">
                        <section>
                        <?php 
							wp_reset_query();
							// Query latest three posts excluding the previously queried posts
							$wp_query = new WP_Query();
							$wp_query->query(array(
								//'category_name' => $category,
								'post_type' => 'post',
								'posts_per_page' => 1, // 4 if sponsored, 5 if no sponsored
								'category__not_in' => 30,
								'post__not_in' => $ids,
								'no_found_rows' => true
							));
							if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); 

							// if ( in_array( get_the_ID(), $ids ) ) {
					  //           continue;
					  //       }


							if ( has_post_thumbnail() ) {
								$smallClass = 'small-post-content';
							} else {
								$smallClass = 'small-post-content-full';
							}
							$pId = get_the_ID();
							$term = get_the_terms($pId, 'category');
			 				$termName = $term[0]->name;
							?>
							
							
							
                            <div class="small-post">
                            		<a href="<?php the_permalink(); ?>">
                            		<div class="small-post-thumb">
                                    <?php if ( has_post_thumbnail() ) {
													the_post_thumbnail('thumbnail');
												} ?>
                                    </div><!-- small post thumb -->
                                    <div class="<?php echo $smallClass; ?>">
                                    	<h3><?php echo $termName; ?></h3>
                                        <div class="clear"></div>
                                        <h2><?php the_title(); ?></h2>
                                    </div><!-- small post content -->
                            		</a>
                            </div><!-- smalll post -->
                            
							<?php 
							// get more ids
							   $ids[] = get_the_ID();
							endwhile; endif; // end query 3 latest
							
							// $wp_query = new WP_Query();
							// $wp_query->query(array(
							// 	'category_name' => $category,
							// 	'post_type' => 'post',
							// 	'posts_per_page' => '1',
							// 	//'post__not_in' => $ids,
							// 	'category_name' => 'sponsored'
							// ));
							// if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); 

						// Post Type Order Plugin installed, so get that outta here
										remove_all_filters('posts_orderby');

										// put Sponsored content choices in here.
										$pickedids = array();
										$pickedids[] = $sponsoredPost[0]->ID;
										$pickedids[] = $sponsoredPost[1]->ID;
										$pickedids[] = $sponsoredPost[2]->ID;
										$myIDs = implode(', ', $pickedids);
										//echo $myIDs;
										if( $sponsoredPost ) :

											$posts_array = get_posts(array(
												'numberposts' => 1, // posts_per_page doesn't work here either.
												'post_type' => 'post',
												'include' => $myIDs, // for some reason, post__in doesn't work here.
												'orderby' => 'rand',
											));

											$numSponsPost = 0;

											foreach( $posts_array as $post ) : $numSponsPost++;
												//global $post;
												setup_postdata( $post ); 
												//echo $post->ID .'<br>';
													get_template_part('cat/sponsored-post'); 
												// get more ids
							   					$ids[] = get_the_ID();
												wp_reset_postdata();
												// after 1 get out.
												if( $numSponsPost == 1 ) {break;}
											endforeach;

										endif;

							?>
                          
                            
                          <!-- 1-18-16 -->
                          
                          <?php 
							// get more ids
							   $ids[] = get_the_ID();
							//endwhile; endif;  //end for each category ?>
                            
                            <?php 
							// Query latest three posts excluding the previously queried posts
							$wp_query = new WP_Query();
							$wp_query->query(array(
								'category_name' => $category,
								'post_type' => 'post',
								'posts_per_page' => '3', // 4 if sponsored, 5 if no sponsored
								'category__not_in' => 30,
								'post__not_in' => $ids,
								'no_found_rows' => true
							));
							if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); 
							if ( has_post_thumbnail() ) {
								$smallClass = 'small-post-content';
							} else {
								$smallClass = 'small-post-content-full';
							}
							$pId = get_the_ID();
							$term = get_the_terms($pId, 'category');
			 				$termName = $term[0]->name;
							?>
							
							
							
                            <div class="small-post">
                            		<a href="<?php the_permalink(); ?>">
                            		<div class="small-post-thumb">
                                    <?php if ( has_post_thumbnail() ) {
													the_post_thumbnail('thumbnail');
												} ?>
                                    </div><!-- small post thumb -->
                                    <div class="<?php echo $smallClass; ?>">
                                    	<h3><?php echo $termName; ?></h3>
                                        <div class="clear"></div>
                                        <h2><?php the_title(); ?></h2>
                                    </div><!-- small post content -->
                            		</a>
                            </div><!-- smalll post -->
                            
							<?php 
							// get more ids
							   $ids[] = get_the_ID();
							endwhile; endif; // end query 3 latest ?>
                            
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
        <?php 
            $posts = $section1;
            foreach( $posts as $post): 
			 setup_postdata( $post ); 
			 $term = get_the_terms($section1->ID, 'category');
			 $termId = $term[0]->term_id;
			 $color = get_field( 'category_color', 'category_'.$termId );
			 $video = get_field( 'video_single_post' ); 
			 // echo '<pre>';
			 // print_r($section1);
			 ?>	
            <div class="solid-border-title" style="border-bottom: 3px solid <?php echo $color; ?>">
                <h2 style="background-color: <?php echo $color; ?>"><?php echo $term[0]->name; ?></h2>
            </div><!-- border title -->
            
            <div class="post-block blocks">
            
            
            
				<?php 
				if( $video != '' ) :
						echo $video;
					else:
				if ( has_post_thumbnail() ) { ?>
                	<div class="post-block-image">
                       <?php  the_post_thumbnail('thirds'); ?>
                   </div>
               <?php } endif; ?>
                
            	<h2><?php the_title(); ?></h2>
            	<div class="postdate"><?php echo get_the_date(); ?></div>
            	<div class="entry-content home-content"><?php the_excerpt(); ?></div>
            	<div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
            </div><!-- post block -->
            
            <?php // get more ids
				   $ids[] = get_the_ID();
				   endforeach;
				   wp_reset_postdata(); ?>
        </section>
        
        <section id="third" class="third-first ">
        	<?php 
            $posts = $section2; 
            foreach( $posts as $post):
			 setup_postdata( $post ); 
			 $term = get_the_terms($section2->ID, 'category');
			 $termId = $term[0]->term_id;
			 $color = get_field( 'category_color', 'category_'.$termId ); 
			 $video = get_field( 'video_single_post' );
		
			 ?>	
            <div class="solid-border-title" style="border-bottom: 3px solid <?php echo $color; ?>">
                <h2 style="background-color: <?php echo $color; ?>"><?php echo $term[0]->name; ?></h2>
            </div><!-- border title -->
            
            <div class="post-block blocks">
            
            
				<?php 
				if( $video != '' ) :
						echo $video;
					else:
				if ( has_post_thumbnail() ) { ?>
                	<div class="post-block-image">
                       <?php  the_post_thumbnail('thirds'); ?>
                   </div>
               <?php } endif; ?>
                
            	<h2><?php the_title(); ?></h2>
            	<div class="postdate"><?php echo get_the_date(); ?></div>
            	<div class="entry-content home-content"><?php the_excerpt(); ?></div>
            	<div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
            </div><!-- post block -->
            
            <?php // get more ids
				   $ids[] = get_the_ID();
				   endforeach;
				   wp_reset_postdata(); ?>
        </section>
        
        <section id="third" class="third-last">
        	<?php 
            $posts = $section3; 
            foreach( $posts as $post):
			 setup_postdata( $post ); 
			 $term = get_the_terms($section3->ID, 'category');
			 $termId = $term[0]->term_id;
			 $color = get_field( 'category_color', 'category_'.$termId ); 
			 $video = get_field( 'video_single_post' );
			/* echo '<pre>';
			 print_r($color);*/
			 ?>	
            <div class="solid-border-title" style="border-bottom: 3px solid <?php echo $color; ?>">
                <h2 style="background-color: <?php echo $color; ?>"><?php echo $term[0]->name; ?></h2>
            </div><!-- border title -->
            
            <div class="post-block blocks">
            
            
				<?php 
				if( $video != '' ) :
						echo $video;
					else:
				if ( has_post_thumbnail() ) { ?>
                	<div class="post-block-image">
                       <?php  the_post_thumbnail('thirds'); ?>
                   </div>
               <?php } endif; ?>
                
            	<h2><?php the_title(); ?></h2>
            	<div class="postdate"><?php echo get_the_date(); ?></div>
            	<div class="entry-content home-content"><?php the_excerpt(); ?></div>
            	<div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
            </div><!-- post block -->
            
            <?php // get more ids
				   $ids[] = get_the_ID();
				   endforeach;
				   wp_reset_postdata(); ?>
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
                    
                    <div class="clear"></div>
                    
                    <!-- VIDEO GALLERIES -->
                    <?php 

                    // This previously showed a auto play video... annoying.


						// $post = get_post(349); 
						//  setup_postdata( $post ); 
						//  $video = get_field('video'); 
						//  echo $video; 
						//  wp_reset_postdata();
						 ?>
                        
                
                
                <!-- PHOTO GALLERIES -->
                <section>
                 <?php 
                 $iCount = 0;
	            $wp_query = new WP_Query();
				$wp_query->query(array(
					'post_type' => 'gallery',
					'posts_per_page' => '4',
					'no_found_rows' => true
				));
				if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); 
				$main_field = get_field('photos');
				$first_img = $main_field[0]['photo'];
				$size = 'photo';
	        	$thumb = $first_img['sizes'][ $size ];
	        	$iCount++;
	        	if($iCount == 2) {
	        		$iClass = 'gallery-area-home-right';
	        		$iCount = 0;
	        	} else {
	        		$iClass = 'gallery-area-home-left';
	        	}
				/*echo '<pre>';
				print_r($main_field);*/
				?>
			 
			 <div class="<?php echo  $iClass; ?>">
	             <div class="gallery-thumb">
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
	             			 the_post_thumbnail(); 
	             		 } else { ?>
	            <?php  echo '<img src="'.$thumb.'" />'; }?>
	            </a>
	             </div><!-- gallery thumb -->
            </div><!-- inner area -->

            <?php endwhile; endif; ?>
            <div class="clear"></div>
            
                <div class="viewmore button"><a href="<?php bloginfo('url'); ?>/media-gallery">VIEW MORE GALLERIES</a></div>
                </section>
            
               
            </section>
        </div><!-- site content -->
        
        <div class="widget-area">
        	<?php get_template_part('inc/event-box'); ?>
        </div><!-- widget area -->
        
        <div class="clear"></div>
		

		</div><!-- #content -->
	</div><!-- #primary -->
    
    <?php get_template_part('ads/leaderboard-home'); ?>


<?php get_footer(); ?>