<?php
/**
 * The Template for displaying all single posts
 *
 */
if(have_posts()): the_post();
	$sponsors = get_field('sponsors');
	if($sponsors):
		$post = get_post($sponsors[0]->ID);
		setup_postdata( $post );
		get_template_part('ads/sponsor-header');
		wp_reset_postdata();
	endif;

?>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper template-single-news">

<!-- 
			Main Content

======================================================== --> 			
			
			<?php 
			$id = get_the_ID();
			$terms = get_the_terms($id, 'category');
			$video = get_field( 'video_single_post' );
			$storyImage = get_field( 'story_image' );
			$title = $storyImage['title'];
			$alt = $storyImage['alt'];
			$size = 'large';
			$thumb = $storyImage['sizes'][ $size ];
			?>

				<header class="archive-header">
					<div class="border-title">
	                    <div class="catname">
	                    	<?php $category = get_the_category( $id );
							$sponsors = get_field("sponsors");
							if($sponsors):
								echo $sponsors[0]->post_title;
							else:
								echo $category[0]->cat_name;
							endif;?>
						</div><!-- cat name -->
	                </div><!-- border title -->
				</header><!-- .archive-header -->
                
                <div class="entry-content">
					<h1 class="posttitle"><?php the_title(); ?></h1>
					<?php if( get_the_excerpt() != '' ) : ?>
	                	<div class="single-excerpt"><?php the_excerpt(); ?></div>
	            	<?php endif; ?>

				</div><!-- entry-content -->


				<div class="author">
                <?php
                 $chooseAuthor = get_field('choose_author');
                 $guestAuthor = get_field('author_name');
                if($chooseAuthor != '') {
                	$authorID = $chooseAuthor['ID'];
					$authorName = $chooseAuthor['display_name'];
					// echo $authorID;
					$authorPhoto = get_field('custom_picture', 'user_' . $authorID );
					$size = 'thumbnail';
					if($authorPhoto) { ?>

						<div class="top-author-photo">
							<?php echo wp_get_attachment_image( $authorPhoto, $size ); ?>
						</div>
						<div class="byline">
							<div class="top-author-name">By <?php echo $authorName; ?></div>
							<div class="postdate"><?php echo get_the_date(); ?></div>
						</div>
					<?php } else { ?>
						<div class="byline">
							<div class="top-author-name">By <?php echo $authorName; ?></div>
							<div class="postdate"><?php echo get_the_date(); ?></div>
						</div>
					<?php } //  if photo
                
					// Else use the Legacy Guest Author Field
                } elseif( $guestAuthor != '' ) { 

                	?>
                	<div class="byline">
						<div class="top-author-name">By <?php echo $guestAuthor; ?></div>
						<div class="postdate"><?php echo get_the_date(); ?></div>
					</div>
                <?php } else { ?>
                	<div class="byline">
						<div class="top-author-name">By <?php echo get_the_author();  ?></div>
						<div class="postdate"><?php echo get_the_date(); ?></div>
					</div>
                	
                <?php } ?>
 				</div><!-- author -->
                <div class="clear"></div>

                <div class="big-story-image">
            		<?php if($storyImage != '') { ?>
            			<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>" />
            		<?php 
            			}  
                    ?>
            	</div>
                    
              

			
			<div class="site-content">
				<?php if ( function_exists( 'sharing_display' ) ) { ?>
				 	<div class="jetpack-social"><?php sharing_display( '', true ); ?></div>
				 <?php } ?>
				<div class="clear"></div>
                
               


                <div class="entry-content">
                	<?php the_content(); ?>
                </div><!-- entry content -->
                
                <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                 
                 <div class="clear"></div>

                 <div class="goto-comments">
                	<a href="#goto-comments">COMMENTS</a>
                </div>

                <div class="goto-comments">
                	<a href="<?php bloginfo('url'); ?>/email-signup">
                	
                		Join The Community. Receive updates from Qcitymetro &raquo; &raquo; 
                	</a>
                </div>	
                 
                <!--<div class="footer-meta">
                	Categorized: <?php the_category(', '); ?>
                </div> footer meta -->
                
                <!-- Your like button code -->
   
                
                
                <?php 
                // Author info, pic, link to Author posts. 
                // Removed 9/2016
                //get_template_part('inc/author-info') 
                ?>
                

				<!--<nav class="nav-single">
					<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', 'twentytwelve' ) . '</span> previous' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', 'next <span class="meta-nav">' . _x( '', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
				</nav> .nav-single -->

				
				<?php  

				get_template_part('inc/extra-click');
				?>
				<div class="clear"></div>
				
				<div id="goto-comments"></div>
				<?php echo do_shortcode('[fbcomments url="" width="375" count="off" num="3" countmsg="wonderful comments!"]'); ?>
            </div><!-- site content -->
            
<!-- 
			Ad Zone

======================================================== -->        
        <div class="widget-area">
        	<?php if($sponsors):
				$post = get_post($sponsors[0]->ID);
				setup_postdata( $post );
				get_template_part('ads/sponsor');
				wp_reset_postdata();
			endif;
        	// If is IN the Sponsored Content... Show sponsored content posts
			if( in_category(30) ): 
				$offers_ids = get_field("offers_and_invites",349);
				if($offers_ids):?>
					<div class="about-sponsored">
						<div class="border-title">
							<h2><?php the_field('sponsored_content_title', 'option'); ?></h2>
						</div><!-- border title -->
						<!-- <div class="about-sponsored-tab"><?php the_field('sponsored_content_title', 'option'); ?></div> -->
						<?php the_field('sponsored_content_verbiage', 'option'); ?>
					</div>


					<?php 
					wp_reset_postdata();
					wp_reset_query();
				
				
				
					// get_post_meta();
					// Query latest three posts excluding the previously queried posts
					$wp_query = new WP_Query();
					$wp_query->query(array(
						//'category_name' => $category,
						'post_type' => 'post',
						'posts_per_page' => '-1', // 4 if sponsored, 5 if no sponsored
						'post__in'=>$offers_ids
						// 'meta_query' => array(
						// 	array(
						//         'key'		=> 'post_expire',
						//         'compare'	=> '>=',
						//         'value'		=> $today,
						//     )),
					));
					if ($wp_query->have_posts()) : ?>
					<section class="sponsored-posts">
					<?php  
					while ($wp_query->have_posts()) : $wp_query->the_post(); 
						if ( has_post_thumbnail() ) {
							$smallClass = 'small-post-content';
						} else {
							$smallClass = 'small-post-content-full';
						}
						$pId = get_the_ID();
						$term = get_the_terms($pId, 'category');
						$termName = $term[0]->name;

						// Finally - added August 25 2016
						// Don't show expired post. 
						// Can't do this in the query becuase there are so many posts without a datefield
						$today = date('Ymd');
						//echo $today;
						$postDate = get_field('post_expire');
						// 
						if( $postDate > $today || $postDate == '' ) :
							echo '<!-- OK | Today:' .$today . ' | Expires:' . $postDate . '-->';
						
						
					?>
					<div class="small-post">
						<a href="<?php the_permalink(); ?>">
							<div class="small-post-thumb">
							<?php if ( has_post_thumbnail() ) {
										the_post_thumbnail('thumbnail');
									} ?>
							</div><!-- small post thumb -->
							<div class="<?php echo $smallClass; ?>">
								<!-- <h3><?php echo $termName; ?></h3> -->
								<div class="clear"></div>
								<h2><?php the_title(); ?></h2>
							</div><!-- small post content -->
						</a>
					</div><!-- smalll post -->
				<?php 

						endif; // end comparing post expire to today

				endwhile; endif; // end sponsored posts category
				endif; // end the sponored categoyr post 
        		wp_reset_postdata();
				wp_reset_query();
			endif;?>
        	</section>
        	<?php 
        	// If is not in Sponsored Content, proceed
        	if(!in_category(30)) :
				if( in_category('6') ) {
					get_template_part('ads/right-big-health'); 
				} else {
					get_template_part('ads/right-big'); 
				} ?>
	            <?php 
				if( in_category('6') ) {
					get_template_part('ads/right-small-health'); 
				} else {
					get_template_part('ads/right-small'); 
				} 
			endif; // if not in sponsored Cat

			
			// if not in health category, show another add below Qcity Curious
			if( !in_category('6') ) { 
			
				get_template_part('ads/single-right-ad-below-curious');

			} ?>
				<div class="business-directory-search">
                    <div class="border-title">
                        <h2>Business Directory</h2>
                    </div>
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
                </div><!--.business-directory-search-->
			<?php
			    if (function_exists('wpp_get_mostpopular')) : ?>
			   
			   
	        	<div class="border-title">
	            	<h2>Most Popular</h2>
	        	</div><!-- border title -->

			    <?php 
					$args = array(
					    'wpp_start' => '<div class="small-post">',
					    'wpp_end' => '</div>',
					    'stats_category' => 0,
					    'post_html' => '<a href="{url}"><div class="small-post-thumb">{thumb_img}</div><div class="small-post-content"><h2>{text_title}</h2></div></a>',
					    'thumbnail_width' => 100,
    					'thumbnail_height' => 100,
    					'limit' => -1,
    					'range' => 'weekly',
    					'freshness' => 1,
    					'order_by' => 'views',
    					'post_type' => 'post'

					);
			        wpp_get_mostpopular( $args );

			    endif;
			?>

			<?php get_template_part('inc/our-partners') ?>
			
        </div><!-- widget area -->

        
            
            
</div><!-- #content -->
	</div><!-- #primary -->
    
    <?php endif;?>
<!-- 
			Events

======================================================== --> 
<?php // get_template_part('inc/events'); ?>
	

<?php get_footer(); ?>