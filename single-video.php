<?php
/**
 * Template Name: Video Template
 *
 */

get_header();?>


<div class="clear"></div>

<div id="primary" class="">
	<div id="content" role="main" class="wrapper">
    <div class="template-video">
		<!--
					Main Content

		======================================================== -->
		<div class="site-content">
			<?php while ( have_posts() ) : the_post();
				$id         = get_the_ID();
				$terms      = get_the_terms( $id, 'category' );
				$video      = get_field( 'video_single_post' );
				$storyImage = get_field( 'story_image' );
				$title      = $storyImage['title'];
				$alt        = $storyImage['alt'];
				$size       = 'large';
				$thumb      = $storyImage['sizes'][ $size ];
				?>

				<header class="archive-header">
					<div class="border-title">
						<div class="catname">
							<?php $category = get_the_category( $id );
							echo $category[0]->cat_name; ?>
						</div>
					</div><!-- border title -->
				</header><!-- .archive-header -->

				<div class="entry-content">

					<?php $column = get_field("column");
						if($column):?>
							<div class="column-section">
								<div class="col-1">
									<?php $chooseAuthor = get_field( 'choose_author' );
									$size        = 'thumbnail';
									$authorPhoto = null;
									if ( $chooseAuthor != '' ):
										$authorID   = $chooseAuthor['ID'];
										$authorPhoto = get_field( 'custom_picture', 'user_' . $authorID );
									else:
										$authorPhoto = get_field('custom_picture','user_'.get_the_author_meta('ID'));
									endif;
									if ( $authorPhoto ):
										echo wp_get_attachment_image( $authorPhoto, $size );
									endif; //  if photo ?>
								</div><!--.col-1-->
								<?php $post = get_post($column);
								setup_postdata($post);?>
								<div class="col-2">
									<h2><?php the_title();?></h2>
									<div class="copy">
										<?php the_content();?>
									</div><!--.copy-->
								</div><!--.col-2-->
							</div><!--.column-section-->
							<?php wp_reset_postdata();
						endif;?>
					<?php
					if ( $video != '' ) : ?>
                        <div class="video-holder">
                            <div class="video-wrapper">
                                <?php echo $video;?>
                            </div><!--.video-wrapper-->
                        </div>
					<?php else:
						if ( $storyImage != '' ) {

							/*echo '<pre>';
							print_r($storyImage);
							echo '</pre>';*/

							?>
							<div class="f_image">
								<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>"
								     title="<?php echo $title; ?>"/>

								<?php echo $storyImage['caption'] ?>

							</div>
						<?php } endif; ?>
						<?php $column_description = get_field("column_description");
						if($column_description):?>
							<div class="column-description">
								<?php echo $column_description;?>
							</div><!--.column-description-->
						<?php endif;?>
                </div><!-- entry content -->
                <div class="entry-content mobile-visible">
                    <h1><?php the_title();?></h1>
                    <div class="clear"></div>
					<?php the_content(); ?>
                    <div class="clear"></div>
					<?php if ( function_exists( 'sharing_display' ) ) { ?>
                        <div class="jetpack-social"><?php sharing_display( '', true ); ?></div>
					<?php } ?>
                </div><!--.entry-content-->
                <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="standard" data-action="like"
                     data-size="small" data-show-faces="true" data-share="true"></div>

                <div class="clear"></div>


                <div class="goto-comments">
                    <a href="#goto-comments">COMMENTS</a>
                </div>

                <div class="goto-comments">
                    <a href="<?php bloginfo( 'url' ); ?>/email-signup">
                        Join The Community. Receive updates from Qcitymetro &raquo; &raquo;
                    </a>
                </div>
            <div class="clear"></div>
                <!--  <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="standard" data-action="recommend" data-show-faces="true" data-share="true"></div> -->




                <!--<div class="footer-meta">
                	Categorized: <?php the_category( ', ' ); ?>
                </div> footer meta -->

                <!-- Your like button code -->


				<?php
				// Author info, pic, link to Author posts.
				// Removed 9/2016
				//get_template_part('inc/author-info')
				?>


                <!-- <nav class="nav-single">
					<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', 'twentytwelve' ) . '</span> previous' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', 'next <span class="meta-nav">' . _x( '', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
				</nav>.nav-single -->

				<?php //get_template_part('inc/author-comments') ?>


				<?php

			endwhile; // end of the loop.

			get_template_part( 'inc/extra-click' );
			?>
			<div class="clear"></div>
            <div id="goto-comments"></div>
			<?php echo do_shortcode( '[fbcomments url="" width="375" count="off" num="3" countmsg="wonderful comments!"]' ); ?>
        </div><!--.site-content-->
        <div class="widget-area">
            <div class="entry-content mobile-hidden">
                <h1><?php the_title();?></h1>
                <div class="clear"></div>
                <?php the_content(); ?>
                <div class="clear"></div>
	            <?php if ( function_exists( 'sharing_display' ) ) { ?>
                    <div class="jetpack-social"><?php sharing_display( '', true ); ?></div>
	            <?php } ?>
            </div><!--.entry-content-->
	        <?php
			$offers_ids = get_field("offers_and_invites",349);
			if($offers_ids):
				// Query latest three posts excluding the previously queried posts
				$wp_query = new WP_Query();
				$wp_query->query( array(
					//'category_name' => $category,
					'post_type'      => 'post',
					'post__in'=>$offers_ids,
					'posts_per_page' => '-1', // 4 if sponsored, 5 if no sponsored

				) );
				if ( $wp_query->have_posts() ) : ?>
				<section class="sponsored-posts">
					<!-- <div class="about-sponsored">
						<div class="about-sponsored-tab"><?php the_field( 'sponsored_content_title', 'option' ); ?></div>
							<?php the_field( 'sponsored_content_verbiage', 'option' ); ?>
						</div> -->

					<div class="border-title">
						<h2><?php the_field( 'sponsored_content_title', 'option' ); ?></h2>
					</div><!-- border title -->
					<div class="about-sponsored">
						<?php the_field( 'sponsored_content_verbiage', 'option' ); ?>
					</div>
					<?php
					while ( $wp_query->have_posts() ) : $wp_query->the_post();
						if ( has_post_thumbnail() ) {
							$smallClass = 'small-post-content';
						} else {
							$smallClass = 'small-post-content-full';
						}
						$pId      = get_the_ID();
						$term     = get_the_terms( $pId, 'category' );
						$termName = $term[0]->name;

						// Finally - added August 25 2016
						// Don't show expired post.
						// Can't do this in the query becuase there are so many posts without a datefield
						$today = date( 'Ymd' );
						//echo $today;
						$postDate = get_field( 'post_expire' );


						//
						if ( $postDate > $today || $postDate == '' ) :
							echo '<!-- OK | Today:' . $today . ' | Expires:' . $postDate . '-->';

							?>
							<div class="small-post">
								<a href="<?php the_permalink(); ?>">
									<div class="small-post-thumb">
										<?php if ( has_post_thumbnail() ) {
											the_post_thumbnail( 'thumbnail' );
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

					endwhile;
				endif; // end sponsored posts category

			wp_reset_postdata();
			wp_reset_query(); 
			endif;//if for post picker ids exists
			?>
            </section>

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
        </div><!--.widget-area-->
        <div class="clear"></div>
    </div><!--.template-video-->

	</div><!-- #content -->
</div><!-- #primary -->


<!--
			Events

======================================================== -->
<?php //get_template_part('inc/events'); ?>


<?php get_footer(); ?>
