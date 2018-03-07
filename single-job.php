<?php
/**
 * The Template for displaying all single posts
 *
 */
get_header();?>
    <div id="primary" class="single-job">
		<?php $banner_image = get_field("banner_image",46657);
		$banner_copy = get_field("banner_copy",46657);?>
		<div class="jobs-banner">
			<?php if($banner_image) echo '<div class="background" style="background-image: url('.$banner_image['url'].');"></div>';?>
			<?php if($banner_copy):?>
				<div class="row-1">
					<?php echo $banner_copy;?>
				</div><!--.row-1-->
			<?php endif;?>
			<div class="row-2">
				<a class="banner-button" href="<?php echo get_permalink(46635);?>">Post a Job</a>
				<div class="banner-button find">Find a Job</div>
			</div><!--.row-1-->
			<div class="row-3">
				<form action="<?php echo get_permalink(46657);?>" method="GET">
					<div class="row-1">
						<input type="text" name="search" placeholder="Search">
						<button type="submit">
							<i class="fa fa-search"></i>
						</button>
						<div class="clear"></div>
					</div><!--.row-1-->
					<div class="row-2">
						<?php $terms = get_field("categories_to_show",46657);
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
        <div id="content" role="main" class="wrapper template-single-news">
			<?php while ( have_posts() ) : the_post(); ?>
				<!--
							Main Content

				======================================================== -->
				<div class="site-content">
					<header class="archive-header">
						<div class="border-title">
							<h1>
								<?php $job_title = get_field("job_title");
								if($job_title):
									echo $job_title;
								endif; ?>
							</h1>
						</div><!-- border title -->
					</header><!-- .archive-header -->
					<div class="entry-content">
						<?php if ( function_exists( 'sharing_display' ) ) : ?>
							<div class="jetpack-social"><?php sharing_display( '', true ); ?></div>
						<?php endif; ?>
						<div class="job-company-row">	
							<?php $image = get_field('image');
							$company_name = get_field("company_name");?>								
							<?php if ( $image ): ?>
								<div class="image">
									<img src="<?php echo $image['url']; ?>" alt="<?php $image['alt'];?>">
								</div><!--.image-->
							<?php endif; ?>
							<?php if (function_exists('wpp_get_views')):?>
								<div class="data"> 
									<header>
										<h2>
											<?php echo $company_name;?>
										</h2>
									</header>
									<div class="date"><?php echo get_the_date(); ?></div><!--.date-->
									<div class="views">
										Views:&nbsp;<?php echo wpp_get_views( get_the_ID() );?>
									</div><!--.views-->
								</div><!--.data-->
							<?php endif;?>
							<div class="clear"></div>
						</div><!--.job-company-row-->
						<?php $job_description = get_field("job_description");
						if($job_description):?>
							<div class="copy">
								<?php echo $job_description; ?>
							</div><!--.copy-->
						<?php endif;?>	
						<?php $how_to_apply = get_field("how_to_apply");
						$application_direct = get_field("application_direct");
						$application_email = get_field("application_email");?>
						<?php if(strcmp($how_to_apply,"direct")==0&&$application_direct):?>
							<div class="application button">
								<a class="button" href="<?php echo $application_direct;?>" target="_blank">
									Apply
								</a>
							</div><!--.application-->
						<?php elseif($application_email):?>
							<div class="application button">
								<a class="button" href="mailto:<?php echo $application_email;?>">
									Email Resume
								</a>
							</div><!--.application-->
						<?php endif;
						$mailto_subject = get_field("mailto_subject",46657);
						$mailto_body = get_field("mailto_body",46657);
						$mailto_button_text = get_field("mailto_button_text",46657);
						if($mailto_body&&$mailto_button_text&&$mailto_subject):?>
							<div class="mail button">
								<a class="button" href="mailto:?subject=<?php echo str_replace(" ","%20",$mailto_subject);?>&amp;body=<?php echo str_replace(" ","%20",$mailto_body);?>%20<?php echo get_permalink();?>"><?php echo $mailto_button_text;?></a>
							</div>
						<?php endif;?>
						<div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="standard" data-action="like"
						data-size="small" data-show-faces="true" data-share="true"></div>
					</div><!-- entry content -->
					<?php $args = array(
						'post_type'=>'job',
						'posts_per_page' => -1,
						'orderby'=>'name',
						'order'=>'DESC'
					);
					$posts = get_posts($args);
					$index = array_search($post,$posts);
					if($index !== false && count($posts)>1):?>
						<div class="clear"></div>
						<nav class="nav-single">
							<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
							<h3 class="show">View Next Job</h3>
							<?php if(count($posts) >2):?>
								<?php $previous_index = $index > 0 ? $index -1 : count($posts) -1;?>
								<span class="nav-previous">
									<a href="<?php echo get_the_permalink($posts[$previous_index]);?>"><span class="meta-nav">&larr;</span><?php echo $posts[$previous_index]->post_title;?></a>
								</span>
							<?php endif;?>
							<?php $next_index = $index < (count($posts) -1) ? $index +1 : 0; ?>
							<span class="nav-next">
								<a href="<?php echo get_the_permalink($posts[$next_index]);?>"><?php echo $posts[$next_index]->post_title;?><span class="meta-nav">&rarr;</span></a>
							</span>
						</nav><!-- .nav-single -->
					<?php endif;?>
				</div><!-- site content -->
			<?php endwhile; // end of the loop.?>
			<div class="widget-area">
            	<?php get_template_part('ads/right-small'); 
				$popular_posts_title = get_field("popular_posts_title", 46657);
				if($popular_posts_title):?>
					<div class="border-title">
						<h2><?php echo $popular_posts_title;?></h2>
					</div><!-- border title -->
				<?php endif;
				$popular_posts = get_field("popular_posts", 46657);
				$args = array(
					'post__in'=>$popular_posts
				);
				$query = new WP_Query($args);
				if($query->have_posts()):?>
					<div class="small-post">
						<?php while($query->have_posts()): $query->the_post();?>
							<a href="<?php the_permalink();?>">
								<div class="small-post-thumb"><?php the_post_thumbnail();?></div>
								<div class="small-post-content">
									<h2><?php the_title();?></h2>
								</div>
							</a>
						<?php endwhile;?>
					</div>
					<?php wp_reset_postdata();
				endif;?>
				<div class="brew-sidebar">
					<div class="border-title">
						<h2>Morning Brew</h2>
					</div><!-- border title -->
					<div class="brew-wrapper">
						<?php $copy = get_field("morning_brew_copy",46657);
						if($copy):?>
							<div class="copy">
								<?php echo $copy;?>
							</div><!--.copy-->
						<?php endif;?>
						<a class="button" href="<?php echo get_permalink(21613);?>">Signup</a>
					</div><!--.wrapper-->
				</div><!--.brew-sidebar-->
			</div><!-- widget area -->
            <div class="clear"></div>
        </div><!-- #content -->
    </div><!-- #primary -->
<?php get_footer(); ?>