<?php
/**
 * Template Name: Submit Job
 */
acf_form_head();
// sanitize inputs
add_filter('acf/update_value', 'wp_kses_post', 10, 1);

get_header(); ?>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

			<?php while ( have_posts() ) : the_post(); ?>
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
							'new_post'		=> array(
								'post_type'		=> 'job',
								'post_status'		=> 'pending',
								'post_title'    => 'Title',
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
							<?php $copy = get_field("morning_brew_copy",43595);
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