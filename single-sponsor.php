<?php 
/*
* Single page for sponsors
*/
$display_to_public = get_field("display_to_public");
if(strcmp($display_to_public,"no")===0){
	$temp_post = get_post(39809);
	if($temp_post):
		wp_redirect( get_the_permalink( 39809) );
		exit;
	endif;
}
get_header(); 
get_template_part('ads/sponsor-header');
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
				<div class="sponsored-row">
					<?php $today = date('Ymd');
					$args = array(
						'post_type'=>'post',
						'posts_per_page'=>1,
						'orderby'=>'date',
						'order'=>'ASC',
						'paged'=>$paged,
						'tax_query' => array(
							array(
								'taxonomy' => 'category', // your custom taxonomy
								'field' => 'slug',
								'terms' => 'offers-invites'
							)
						),
						'meta_query' => array(
							'relation' => 'AND',
							array(
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
							),
							array(
								'key'=>'sponsors',
								'value'=>'"'.get_the_ID().'"',
								'compare'=>"LIKE"
							)
						)
					);
					$most_recent_id = null;
					$query = new WP_Query($args);
					if($query->have_posts()):
						$query->the_post();
						$most_recent_id = get_the_ID();?>
						<section>
							<div class="post-block blocks">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="post-block-image js-titles">
									<?php  the_post_thumbnail('thirds'); ?>
								</div>
							<?php endif; ?>
								
								<h2><?php the_title(); ?></h2>
								<div class="postdate"><?php echo get_the_date(); ?></div>
								<div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
							</div><!-- post block -->	
						</section>
					<?php wp_reset_postdata();
					endif;?>
				</div><!--.sponsored-row-->
				<div class="sponsored-row">
					<?php $args = array(
						'post_type'=>'post',
						'posts_per_page'=>12,
						'orderby'=>'date',
						'order'=>'ASC',
						'paged'=>$paged,
						'tax_query' => array(
							array(
								'taxonomy' => 'category', // your custom taxonomy
								'field' => 'slug',
								'terms' => 'offers-invites'
							)
						),
						'meta_query' => array(
							'relation' => 'AND',
							array(
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
									// 'value' => 'false',
									'compare' => 'NOT EXISTS'
								),
							),
							array(
								'key'=>'sponsors',
								'value'=>'"'.get_the_ID().'"',
								'compare'=>"LIKE"
							)
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
								<div class="post-block blocks">

									<?php if ( has_post_thumbnail() ): ?>
										<div class="post-block-image js-titles">
										<?php  the_post_thumbnail('thirds'); ?>
									</div>
								<?php endif; ?>
									
									<h2><?php the_title(); ?></h2>
									<div class="postdate"><?php echo get_the_date(); ?></div>
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
				</div><!--.sponsored-row-->
			</div><!--.site-content-->
			<div class="widget-area">
				<?php get_template_part( 'ads/sponsor' );?>
			</div><!--.widget-area-->
		</div><!-- #content -->
	</section><!-- #primary -->
<?php get_footer(); ?>