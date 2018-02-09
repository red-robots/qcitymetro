<?php
/**
 * Template Name: Submit Job
 */
acf_form_head();
// sanitize inputs
add_filter('acf/update_value', 'wp_kses_post', 10, 1);

get_header(); ?>

	<div id="primary" class="">
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
				<a href="<?php echo get_permalink(43625);?>">Post a Job</a>
				<a href="<?php echo get_permalink();?>">Find a Job</a>
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
		<div id="content" role="main" class="wrapper">

			<?php while ( have_posts() ) : the_post();?>
				<div class="site-content">
					<header class="archive-header">
						<div class="border-title">
							<h1><?php the_title(); ?></h1>
						</div><!-- border title -->
					</header><!-- .archive-header -->
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- entry-content -->
					<div class="entry-content">
						<?php $return = get_bloginfo('url') . '/business-directory/business-directory-sign-up/business-directory-pay/';
						$formArg = array (
							'id' => 'acf-business-form',
							'post_id'	=> 'new_post',
							'return' => $return,
							'form' => true,
							'post_title'=>true,
							'new_post'		=> array(
								'post_type'		=> 'job',
								'post_status'		=> 'pending',
							),
							'submit_value'		=> 'Post and Pay'
							);
						acf_form($formArg);?>
					</div><!-- entry-content -->
				</div><!--.site-content-->
				<div class="widget-area">
					<?php get_template_part('inc/job-board-partners') ?>
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
							<a href="<?php echo get_permalink(21613);?>">Signup</a>
						</div><!--.wrapper-->
					</div><!--.brew-sidebar-->
				</div><!--.widget-area-->
			<?php endwhile; // end of the loop. ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>