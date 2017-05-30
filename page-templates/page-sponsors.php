<?php 
/*
* Template Name: Sponsors
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
					'post_type'=>'sponsor',
					'posts_per_page'=>12,
					'order'=>'ASC',
					'orderby'=>'menu_order',
					'paged'=>$paged,
				);
				$query = new WP_Query($args);
				if($query->have_posts()):
					$i = 1;?>
					<?php while($query->have_posts()):$query->the_post();?>
						<section id="third" class="<?php if($i%3===0) echo "third-last"; else echo "third-first";?>">
							<?php $logo = get_field('logo');
							$description = get_field("description");?>	
								<div class="solid-border-title" style="border-bottom: 3px solid #7E3518;">
									<h2 style="background-color: #7E3518;">
									<?php the_title();?>
									</h2>
								</div><!-- border title -->
								
								<div class="post-block blocks">

									<?php if ( $logo ): ?>
										<div class="post-block-image js-titles">
											<img src="<?php echo $logo['sizes']['large']; ?>" alt="<?php $logo['alt'];?>">
										</div>
									<?php endif; ?>
									
									<h2><?php the_title(); ?></h2>
									<div class="postdate"><?php echo get_the_date(); ?></div>
									<?php if($description):?>
										<div class="entry-content home-content"><?php echo $description; ?></div>
									<?php endif;?>
									<div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
								</div><!-- post block -->	
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