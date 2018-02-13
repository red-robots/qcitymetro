<?php 
/*
* Template Name: How This Works - Jobs
*/
get_header(); 
?>
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
			<?php $statistics = get_field("statistics",46657);
			if($statistics):?>
				<div class="statistics">
					<ul>
						<?php foreach($statistics as $stat):?>
							<li><?php echo $stat['copy'];?></li>
						<?php endforeach;?>
					</ul>
				</div><!--.statistics-->
			<?php endif;?>
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
				<div class="entry-content">
					<?php the_content();?>
				</div><!--.entry-content-->
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
						<a class="button" href="<?php echo get_permalink(21613);?>">Signup</a>
					</div><!--.wrapper-->
				</div><!--.brew-sidebar-->
			</div><!--.widget-area-->
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>