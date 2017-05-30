<?php 
/*
* Template Name: Sponsored Posts
*/
get_header(); 
get_template_part('ads/leaderboard-interior');
?>
	<section id="primary" class="">
		<div id="content" role="main" class="wrapper">
			<div class="site-content">
				<header class="archive-header">
					<div class="border-title">
						<div class="catname">
							<?php the_title();?>
						</div>
					</div><!-- border title -->
				</header><!-- .archive-header -->
				<div class="entry-content">
					<?php the_content();?>
				</div><!--.entry-content-->
				<?php $today = date('Ymd');
				$args = array(
					'post_type'=>'post',
					'posts_per_page'=>1,
					'order'=>'ASC',
					'orderby'=>'date',
					'paged'=>$paged,
					'tax_query' => array(
						array(
							'taxonomy' => 'category', // your custom taxonomy
							'field' => 'slug',
							'terms' => 'offers-invites'
						)
					),
					'meta_query' => array(
						'relation' => 'OR',
						array(
							'key' => 'post_expire',
							'value' => $today,
							'compare' => '>'
						),
						array(
							'key' => 'post_expire',
							'value' => '',
							'compare' => '='
						),
						array(
							'key' => 'post_expire',
							'compare' => 'NOT EXISTS'
						),
					)
				);
				$most_recent_id = null;
				$query = new WP_Query($args);
				if($query->have_posts()):
					$query->the_post();
					$most_recent_id = get_the_ID();?>
					<section>
						<?php $terms = get_the_terms($post->ID, 'category');
						if(!is_wp_error( $terms )&& !empty($terms) && is_array($terms)):
							$termId = $terms[0]->term_id;
							$color = get_field( 'category_color', 'category_'.$termId ); 
							$sponsors = get_field('sponsors');?>	
							<div class="solid-border-title" style="border-bottom: 3px solid <?php echo $color; ?>">
								<h2 style="background-color: <?php echo $color; ?>"><?php 
									if($sponsors):
										echo $sponsors[0]->post_title;
									else:
										echo $terms[0]->name;
									endif;?>
								</h2>
							</div><!-- border title -->
							
							<div class="post-block blocks">

								<?php if ( has_post_thumbnail() ) { ?>
									<div class="post-block-image js-titles">
									<?php  the_post_thumbnail('thirds'); ?>
								</div>
							<?php } ?>
								
								<h2><?php the_title(); ?></h2>
								<div class="postdate"><?php echo get_the_date(); ?></div>
								<div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
							</div><!-- post block -->	
						<?php endif;?>
					</section>
				<?php wp_reset_postdata();
				endif;?>
				<?php $args = array(
					'post_type'=>'post',
					'posts_per_page'=>12,
					'order'=>'ASC',
					'orderby'=>'date',
					'paged'=>$paged,
					'tax_query' => array(
						array(
							'taxonomy' => 'category', // your custom taxonomy
							'field' => 'slug',
							'terms' => 'offers-invites'
						)
					),
					'meta_query' => array(
						'relation' => 'OR',
						array(
							'key' => 'post_expire',
							'value' => $today,
							'compare' => '>'
						),
						array(
							'key' => 'post_expire',
							'value' => '',
							'compare' => '='
						),
						array(
							'key' => 'post_expire',
							'compare' => 'NOT EXISTS'
						),
					)
				);
				if($most_recent_id):
					$args['post__not_in']= array($most_recent_id);
				endif;
				$query = new WP_Query($args);
				if($query->have_posts()):
					$i = 1;?>
					<?php while($query->have_posts()):$query->the_post();?>
						<section id="third" class="<?php if($i%3===0) echo "third-last"; else echo "third-first";?>">
							<?php $terms = get_the_terms($post->ID, 'category');
							if(!is_wp_error( $terms )&& !empty($terms) && is_array($terms)):
								$termId = $terms[0]->term_id;
								$color = get_field( 'category_color', 'category_'.$termId ); 
								$sponsors = get_field('sponsors');?>	
								<div class="solid-border-title" style="border-bottom: 3px solid <?php echo $color; ?>">
									<h2 style="background-color: <?php echo $color; ?>"><?php 
										if($sponsors):
											echo $sponsors[0]->post_title;
										else:
											echo $terms[0]->name;
										endif;?>
									</h2>
								</div><!-- border title -->
								
								<div class="post-block blocks">

									<?php if ( has_post_thumbnail() ) { ?>
										<div class="post-block-image js-titles">
										<?php  the_post_thumbnail('thirds'); ?>
									</div>
								<?php } ?>
									
									<h2><?php the_title(); ?></h2>
									<div class="postdate"><?php echo get_the_date(); ?></div>
									<div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
								</div><!-- post block -->	
							<?php endif;?>
						</section>
						<?php if($i%3===0):?>
							<div class="clear"></div>
						<?php endif;?>
						<?php $i++;
					endwhile;?>
					<?php pagi_posts_nav_modified($query); ?>
				<?php wp_reset_postdata();
				endif;?>
			</div><!--.site-content-->
			<div class="widget-area">
	        	<?php get_template_part('ads/home-business-directory'); ?>
			</div><!--.widget-area-->			
		</div><!-- #content -->
	</section><!-- #primary -->
<?php get_footer(); ?>