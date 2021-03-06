<?php 
/*
* Template Name: Job Board
*/
get_header(); 
?>
	<div id="primary" class="">
		<?php $banner_image = get_field("banner_image");
		$banner_copy = get_field("banner_copy");?>
		<div class="jobs-banner">
			<?php if($banner_image) echo '<div class="background" style="background-image: url('.$banner_image['url'].');"></div>';?>
			<?php if($banner_copy):?>
				<div class="row-1">
					<?php echo $banner_copy;?>
				</div><!--.row-1-->
			<?php endif;?>
			<div class="row-2">
				<a class="banner-button" href="<?php echo get_permalink(48786);?>">Post a Job</a>
				<div class="banner-button find">Find a Job</div>
			</div><!--.row-1-->
			<div class="row-3">
				<form action="<?php echo get_permalink();?>" method="GET">
					<div class="row-1">
						<input type="text" name="search" placeholder="Search">
						<button type="submit">
							<i class="fa fa-search"></i>
						</button>
						<div class="clear"></div>
					</div><!--.row-1-->
					<div class="row-2">
						<?php $terms = get_field("categories_to_show");
						if(is_array($terms)&&!empty($terms)):?>
							<ul>
								<li>Popular categories:</li>
								<?php foreach($terms as $term):?>
									<li>
										<input type="radio" name="category" id="<?php echo $term->slug;?>" value="<?php echo $term->term_id;?>"><label for="<?php echo $term->slug;?>"><?php echo $term->name;?></label>
									</li>
								<?php endforeach;?>
							</ul>
						<?php endif;?>
					</div><!--.row-2-->
					<div class="row-3">
						<?php $terms = get_terms(array('taxonomy'=>'level','hide_empty'=>false));
						if(!is_wp_error($terms)&&is_array($terms)&&!empty($terms)):?>
							<ul>
								<li>level:</li>
								<?php foreach($terms as $term):?>
									<li>
										<input type="radio" name="level" id="<?php echo $term->slug;?>" value="<?php echo $term->term_id;?>"><label for="<?php echo $term->slug;?>"><?php echo $term->name;?></label>
									</li>
								<?php endforeach;?>
							</ul>
						<?php endif;?>
					</div><!--.row-3-->
				</form>
			</div><!--.row-1-->
		</div><!--.jobs-banner-->
		<div id="content" role="main" class="wrapper">
			<div class="site-content job-board">
				<header class="archive-header">
					<div class="border-title">
						<div class="catname">
							<?php the_title();?>
						</div>
					</div><!-- border title -->
				</header><!-- .archive-header -->
				<?php $today = date('Ymd');
				$args = array(
					'post_type'=>'job',
					'posts_per_page'=>12,
					'order'=>'DESC',
					'orderby'=>'date',
					'paged'=>$paged
				);
				$meta = array('relation'=>'AND');
				$meta_sub = array('relation'=>'OR');
				$meta_cat = null;
				$meta_level = null;
				$meta_sub[] = array(
					'key' => 'post_expire',
					'value' => $today,
					'compare' => '>'
				);
				$meta_sub[] = array(
					'key' => 'post_expire',
					'value' => '',
					'compare' => '='
				);
				$meta_sub[] = array(
					'key' => 'post_expire',
					'compare' => 'NOT EXISTS'
				);
				if(isset($_GET['category'])&&!empty($_GET['category'])):
					$meta_cat = array(
						'key'     => 'category',
						'value'   => '"'.$_GET['category'].'"',
						'compare' => 'LIKE'
					);
				endif;
				if(isset($_GET['level'])&&!empty($_GET['level'])):
					$meta_level = array(
						'key'=>'job_level',
						'value'   => '"'.$_GET['level'].'"',
						'compare' => 'LIKE'
					);
				endif;
				if(!empty($meta_cat)&&!empty($meta_level)):
					$meta_sub_2 = array('relation'=>'AND');
					$meta_sub_2[] = $meta_cat;
					$meta_sub_2[] = $meta_level;
					$meta[] = $meta_sub;
					$meta[] = $meta_sub_2;
				elseif(!empty($meta_cat)):
					$meta[] = $meta_sub;
					$meta[] = $meta_cat;
				elseif(!empty($meta_level)):
					$meta[] = $meta_sub;
					$meta[] = $meta_level;
				else:
					$meta = $meta_sub;
				endif;
				$args['meta_query'] = $meta;
				$query = new WP_Query($args);
				if($query->have_posts()):?>
					<section class="jobs">
						<?php while($query->have_posts()):$query->the_post();?>
							<div class="job">
								<?php $image = get_field('image');?>								
								<?php if ( $image ): ?>
									<div class="image">
										<a href="<?php the_permalink();?>">
											<img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php $image['alt'];?>">
										</a>
									</div><!--.image-->
								<?php endif; ?>
								<div class="copy">
									<?php $job_title = get_field("job_title");
									$company_name = get_field("company_name");
									if($job_title):?>
										<h2><?php echo $job_title;?></h2>
									<?php endif;
									if($company_name):?>
										<div class="excerpt"><?php echo $company_name; ?></div><!--.excerpt-->
									<?php endif;?>
								</div><!-- copy -->	
								<div class="clear"></div>
								<?php if (function_exists('wpp_get_views')):?>
									<div class="data"> 
										<div class="date"><?php echo get_the_date(); ?></div><!--.date-->
										<div class="views">
											Views:&nbsp;<?php echo wpp_get_views( get_the_ID() );?>
										</div><!--.views-->
									</div><!--.data-->
								<?php endif;?>
								<div class="button">
									<a href="<?php the_permalink();?>">View</a>
								</div><!--.button-->
								<div class="clear"></div>
							</div><!--.job-->
						<?php endwhile;?>
					</section><!--.jobs-->
					<?php pagi_posts_nav_modified($query); ?>
					<?php wp_reset_postdata();
				else:?> 
					<header class="alternate"><h2>Oops! Nothing was found, please try another search!</h2></header>
				<?php endif;?>
			</div><!--.site-content-->
			<div class="widget-area">
				<?php get_template_part('ads/job-board-home');?>
				<?php //get_template_part('inc/job-board-partners') ?>
				<?php if (function_exists('wpp_get_views')):?>
					<div class="job-views">
						Total Montly Job Board Views:&nbsp;<?php echo wpp_get_views( get_the_ID() );?>
					</div><!--.views-->
				<?php endif;?>
				<div class="job-sidebar">
					<a class="button" href="<?php echo get_permalink(48786);?>">Post a Job</a>
					<?php $copy = get_field("post_job_copy");
					if($copy):?>
						<div class="copy">
							<?php echo $copy;?>
						</div><!--.copy-->
					<?php endif;?>
				</div>
				<div class="brew-sidebar">
					<div class="border-title">
						<h2>Morning Brew</h2>
					</div><!-- border title -->
					<div class="brew-wrapper">
						<?php $copy = get_field("morning_brew_copy");
						if($copy):?>
							<div class="copy">
								<?php echo $copy;?>
							</div><!--.copy-->
						<?php endif;?>
						<a class="button" href="<?php echo get_permalink(21613);?>">Signup</a>
					</div><!--.wrapper-->
				</div><!--.brew-sidebar-->
			</div><!--.widget-area-->
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>