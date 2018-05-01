<?php
/**
 * The main template file
 *
 * 
 */

get_header(); 

// Get "today" for all the queries against the post expriator
$today = date('Ymd');
// First Query Homepage to get some featured Posts
$post = get_post(349);
setup_postdata($post);
$sponsoredPost = get_field('sponsored_content');
$featuredPost = get_field('featured_post');
$section1 = get_field('section_1_article');
$section2 = get_field('section_2_article');
	$section3 = get_field('section_3_article');
	$section4 = get_field('section_4_article');
	$section5 = get_field('section_5_article');
	$section6 = get_field('section_6_article');
	$section7 = get_field('section_7_article');

wp_reset_query();
// End Homepage Query
?>
<!-- Used to only show popout newsletter on homepage -->
<!-- <span id="homepage-flag" style="display: none" ></span> -->
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
                <!-- new query -->
                    <div class="inner-content large-post">
                        <section>
                        <?php
							// start an empty array to gather all posts so we don't repeat
							$ids = array();
							
							$posts = $featuredPost; 
							foreach($posts as $post) :
							setup_postdata( $post );
							
							?>
								
							<?php if ( has_post_thumbnail() ) { ?>
                             <div class="postthumb-full">
                                 <?php the_post_thumbnail('large'); ?>
                             </div><!-- post thumb -->
                         <?php }?>
                         <h2><?php the_title(); ?><!-- title --></h2>
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
							   foreach($section1 as $post) : 
									$ids[] = $post->ID;
								endforeach;
								
								// section 2
							   foreach($section2 as $post) : 
									$ids[] = $post->ID;
								endforeach;
								
								// section 3
								foreach($section3 as $post) : 
									 $ids[] = $post->ID;
								 endforeach;							   
							   ?>
                        </section>
                    </div><!-- site content -->
                    
<!-- 
			News & Buzz Small Sections

======================================================== -->
                    
                    <div class="inner-area homebars">
                        <section>
                        <?php 
							// Query latest three posts excluding the previously queried posts
							$wp_query = new WP_Query();
							$wp_query->query(array(
								'post_type' => 'post',
								'posts_per_page' => 1, // 4 if sponsored, 5 if no sponsored
								'category__not_in' => 30,
								'post__not_in' => $ids,
								'no_found_rows' => true,
								'meta_type' => 'NUMERIC',
								// Special Query for Expired Posts
								'meta_query' => array(
									'relation' => 'OR',
							        array(
							            'key' => 'post_expire',
							            'value' => NULL,
							            'compare' => '='
							        ),
							        array(
							            'key' => 'post_expire',
							            // 'value' => 'NOT EXISTS'
							            'compare' => 'NOT EXISTS'
							        ),
							        array(
							            'key' => 'post_expire',
							            'value' => $today,
							            'compare' => '>'
							        )
							    )
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
							endwhile; wp_reset_postdata(); endif; // end query 3 latest
							
							

							// Post Type Order Plugin installed, so get that outta here
							remove_all_filters('posts_orderby');

							// put Sponsored content choices in here.
							if( $sponsoredPost && count($sponsoredPost)===3) :
							
								$posts_array = new WP_Query(array(
									'posts_per_page' => 1, // posts_per_page doesn't work here either.
									'post_type' => 'post',
									'post__in' => array( $sponsoredPost[0]->ID, $sponsoredPost[1]->ID, $sponsoredPost[2]->ID ), // for some reason, post__in doesn't work here.
									'orderby' => 'rand',
									// Special Query for Expired Posts
									'meta_query' => array(
										'relation' => 'OR',
											array(
											'key' => 'post_expire',
											'value' => NULL,
											'compare' => '='
										),
										array(
											'key' => 'post_expire',
											'compare' => 'NOT EXISTS'
										),
										array(
											'key' => 'post_expire',
											'value' => $today,
											'compare' => '>'
										)
									)
									
								));


								if($posts_array->have_posts()): $post_array->the_post();
									
									// Finally - added August 25 2016
									// Don't show expired post. 
									// Can't do this in the query becuase there are so many posts without a datefield
									
									//echo $today;
									$postDate = get_field('post_expire');
									// 
									//if( $postDate > $today || $postDate == '' ) :
										echo '<!-- OK | Today:' .$today . ' | Expires:' . $postDate . '-->';
										get_template_part('cat/sponsored-post');

									//endif; // end comparing post expire to today
									// get more ids
									$ids[] = get_the_ID();
									wp_reset_postdata();
									endif;
							endif;
							?>                    
                            
                            <?php 
							// Query latest three posts excluding the previously queried posts
							$wp_query = new WP_Query();
							$wp_query->query(array(
								'post_type' => 'post',
								'posts_per_page' => '3', // 4 if sponsored, 5 if no sponsored
								'category__not_in' => 30,
								'post__not_in' => $ids,
								'no_found_rows' => true,
								// Special Query for Expired Posts
								'meta_query' => array(
									'relation' => 'OR',
							         array(
							            'key' => 'post_expire',
							            'value' => NULL,
							            'compare' => '='
							        ),
							        array(
							            'key' => 'post_expire',
							            // 'value' => 'NOT EXISTS'
							            'compare' => 'NOT EXISTS'
							        ),
							        array(
							            'key' => 'post_expire',
							            'value' => $today,
							            'compare' => '>'
							        )
							    )
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
							endwhile; wp_reset_postdata(); endif; // end query 3 latest ?>
                            
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
        
        <?php 
            $posts = [];
			$posts[] = $section1 ? $section1[0] : null;
            $posts[] = $section2 ? $section2[0] : null;
			$posts[] = $section3 ? $section3[0] : null;
			if($posts): 
				$i = 0;
				foreach($posts as $post): 
					$i++; ?>
					<section id="third" class="<?php if($i!==3): echo 'third-first'; else: echo 'third-last'; endif;?>">
						<?php $term = get_the_terms($post->ID, 'category');
						$termId = !is_wp_error($term) && !empty($term) && $term !== false ? $term[0]->term_id : '';
						$term_name = !is_wp_error($term) && !empty($term) && $term !== false ? $term[0]->name : get_post_type($post->ID);
						$color = get_field( 'category_color', 'category_'.$termId ) ? get_field( 'category_color', 'category_'.$termId ) : 'black';
					
						?>	
						<div class="solid-border-title" style="border-bottom: 3px solid <?php echo $color; ?>">
							<h2 style="background-color: <?php echo $color; ?>"><?php echo $term_name; ?></h2>
						</div><!-- border title -->
						
						<div class="post-block blocks">

							<?php if ( has_post_thumbnail($post->ID) ) { ?>
								<div class="post-block-image js-titles">
								<?php echo get_the_post_thumbnail($post->ID,'thirds'); ?>
							</div>
						<?php } ?>
							
							<h2><?php echo get_the_title($post->ID); ?></h2>
							<div class="postdate"><?php echo get_the_date('',$post->ID); ?></div>
							<div class="q-readmore"><a href="<?php the_permalink($post->ID); ?>">Read more</a></div>
						</div><!-- post block -->
						
						<?php // get more ids
						$ids[] = $post->ID;?>
					</section>
				<?php endforeach;
			endif; ?>
        
        <div class="clear"></div>

		<!-- 
			Sponsors

======================================================== -->    
        <?php 
			$posts = [];
			$posts[] = $section5 ? $section5[0] : null;
            $posts[] = $section6 ? $section6[0] : null;
            $posts[] = $section7 ? $section7[0] : null;
			if($posts): 
				$i = 0;
				foreach($posts as $post): 
					$i++;?>
				  	<section id="third" class="<?php if($i!==3): echo 'third-first'; else: echo 'third-last'; endif;?>">
						<?php $terms = get_the_terms($post->ID, 'category');
						if(!is_wp_error( $terms )&& !empty($terms) && is_array($terms)):
							$termId = $terms[0]->term_id;
							$color = get_field( 'category_color', 'category_'.$termId ); 
							$sponsors = get_field('sponsors',$post->ID);?>	
							<div class="solid-border-title" style="border-bottom: 3px solid <?php echo $color; ?>">
								<h2 style="background-color: <?php echo $color; ?>">
									Sponsored Content
									<?php /*if($sponsors):
										echo $sponsors[0]->post_title;
									else:
										echo $term[0]->name;
									endif;*/?>
								</h2>
							</div><!-- border title -->
							
							<div class="post-block blocks">

								<?php if ( has_post_thumbnail($post->ID) ) { ?>
									<div class="post-block-image js-titles">
									<?php echo get_the_post_thumbnail($post->ID,'thirds'); ?>
								</div>
							<?php } ?>
								
								<h2><?php echo get_the_title($post->ID); ?></h2>
								<div class="postdate"><?php echo get_the_date('',$post->ID); ?></div>
								<div class="q-readmore"><a href="<?php the_permalink($post->ID); ?>">Read more</a></div>
							</div><!-- post block -->
							
						<?php $ids[] = $post->ID; 
						endif;?>
					</section>
				<?php endforeach;
			endif;?>
        <div class="clear"></div>

        <div class="site-content">

            <div class="border-title">
                <h1>Business Directory</h1>
            </div><!-- border title -->
            <div class="business-listings-wrapper">
                <div class="col-1">
                    <div class="business-directory-search-box">
                        <h3>Search Businesses</h3>
                        <form id="category-select" class="category-select replace"  action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
			                <?php $args = array(
				                'show_option_none'  => 'Select category',
				                'show_count'        => 1,
				                'orderby'       => 'name',
				                'hierarchical'      => 1,
				                'hide_empty'        => 0,
				                'echo'          => 0,
				                'value_field' => 'slug',
				                'taxonomy'           => 'business_category',
				                'name' => 'business_category'
			                ); ?>
			                <?php $select  = wp_dropdown_categories( $args );
			                ?>
			                <?php $replace = "<select$1 onchange='return this.form.submit()' class= 'replace' >"; ?>
			                <?php $select  = preg_replace( '#<select([^>]*)>#', $replace, $select ); ?>
			                <?php echo $select; ?>
                            <noscript>
                                <input type="submit" value="View" />
                            </noscript>
                        </form>
                        <h3>Most Viewed Business Listings</h3>

	                    <?php
	                    $args = array(
		                    'range' => 'weekly',
		                    'post_type' => 'business_listing',
		                    'wpp_start' => '',
		                    'wpp_end' => '',
		                    'limit'=>5,
		                    'post_html' => '<div class="listing"><a href="{url}">{text_title}</a></div>'
	                    );
	                    wpp_get_mostpopular( $args );
	                    ?>
                        <div class="button viewmore-short">
                            <a href="<?php bloginfo('url'); ?>/business-directory/business-directory-sign-up">Add your business to this directory</a>
                        </div><!-- button -->
                    </div><!--.business-directory-search-box-->
                </div><!--.col-1-->
                <div class="col-2">
                    <section class="business-featured-post">
		                <?php
						$post = $section4 ? $section4[0]: null;
		                if($post):?>
                            <div class="post-block blocks">
				                <?php if ( has_post_thumbnail($post->ID) ) { ?>
                                        <div class="post-block-image js-titles">
							                <?php echo get_the_post_thumbnail($post->ID,'thirds'); ?>
                                        </div>
					                <?php }?>

                                <h2><?php echo get_the_title($post->ID); ?></h2>
                                <div class="q-readmore"><a href="<?php the_permalink($post->ID); ?>">Read more</a></div>
                            </div><!-- post block -->

			                <?php // get more ids
			                $ids[] = $post->ID;
		                endif;?>
                    </section>
                </div><!--.col-2-->
            </div><!--.business-listings-wrapper-->

        </div><!-- site content -->
        <div class="widget-area">
	        <?php get_template_part('ads/home-business-directory'); ?>
        </div><!--.widget-area-->
        <div class="clear"></div>
  <!-- 
			Videos & Photos

======================================================== -->      
        <div class="site-content">
            
            <section>
                
                    
                    <div class="clear"></div>

                <!-- Sponsors -->
                <section class="gallery-area-home-left">
                
	                <?php get_template_part('inc/our-partners') ?>

            	</section>
 
                <!-- PHOTO GALLERIES -->
                <section class="gallery-area-home-right">
                	
                	<div class="border-title">
	                    <h2>Videos &amp; Photos</h2>
	                </div><!-- border title -->

	                <div class="clear"></div>

                 <?php 
                 $iCount = 0;
	            $wp_query = new WP_Query();
				$wp_query->query(array(
					'post_type' => 'gallery',
					'posts_per_page' => '2',
					'no_found_rows' => true,

				));
				if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); 
				$main_field = get_field('photos');
				$first_img = $main_field[0]['photo'];
				$size = 'photo';
	        	$thumb = $first_img['sizes'][ $size ];
	        	$iCount++;
	        	if($iCount == 2) {
	        		$iClass = '';
	        		$iCount = 0;
	        	} else {
	        		$iClass = '';
	        	}
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

            <?php endwhile; wp_reset_postdata(); endif; ?>
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