<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<section id="primary" class="">
		<div id="content" role="main" class="wrapper">

		<div class="site-content">
			<?php if ( have_posts() ) : ?>
				<header class="archive-header">
					<div class="border-title">
						<h1><?php printf( __( 'Tag Archives: %s', 'twentytwelve' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>
					</div><!-- border title -->
				</header><!-- .archive-header -->
				<div class="site-content">
					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="featured-event">
							<div class="entry-content">
								<div class="search-content-link">
									<a href="<?php echo get_the_permalink();?>" class="search-link">DETAILS</a>
									<h2 class="search"><?php the_title(); ?></h2>
									<div class="postdate"><?php echo get_the_date(); ?></div>
									<?php the_excerpt(); ?>
								</div><!--.search-content-link-->
								<?php $terms = get_the_terms(get_the_ID(),'category');
								if(!is_wp_error($terms)&&is_array($terms)&&!empty($terms)):?>
									<div class="featured-cat">
										<h3>Category:</h3>
										<?php $i = 1;
										$max = count($terms);
										foreach($terms as $term):?>
											<div class="featured-cat-link">
												<?php $link = get_term_link($term);
												if(!is_wp_error($link)):?>
													<a href="<?php echo $link;?>">
												<?php endif;?>
													<?php echo $term->name;?>
												<?php if(!is_wp_error($link)):?>
													</a>
												<?php endif;?>
												<?php if($i<$max):?>
													<span>,</span>
												<?php endif;
												$i++;?>
											</div><!--.featured-cat-link-->
										<?php endforeach;?>
									</div><!--.featured-cat-->
								<?php endif;?>
								<?php $tags = get_the_tags(get_the_ID());
								if(!is_wp_error($tags)&&is_array($tags)&&!empty($tags)):?>
									<div class="featured-tags">
										<h3>Tags:</h3>
										<?php $i = 1;
										$max = count($tags);
										foreach($tags as $tag):?>
											<div class="featured-tags-link">
												<?php $link = get_term_link($tag);
												if(!is_wp_error($link)):?>
													<a href="<?php echo $link;?>">
												<?php endif;?>
													<?php echo $tag->name;?>
												<?php if(!is_wp_error($link)):?>
													</a>
												<?php endif;?>
												<?php if($i<$max):?>
													<span>,</span>
												<?php endif;
												$i++;?>
											</div><!--.featured-tags-link-->
										<?php endforeach;?>
									</div><!--.featured-tags-->
								<?php endif;?>
							</div><!-- entry -content -->
						</div><!-- featured event -->
					<?php endwhile; ?>
					<?php pagi_posts_nav(); ?>
				</div><!-- site content -->
			<?php else : ?>
				<article id="post-0" class="site-content post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php printf( __( 'Tag Archives: %s', 'twentytwelve' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>
					</header>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched this tag. Maybe try a search?', 'twentytwelve' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
			<?php endif; ?>
			<div class="search-widget-area widget-area">
				<?php $args = array(
					'post_type'=>'column',
					'posts_per_page'=>-1
				);
				$query = new WP_Query($args);
				if($query->have_posts()):?>
					<div class="search-border-title">
						<h2>Columns</h2>
					</div><!-- border title -->
					<div class="entry-content">
						<?php while($query->have_posts()):$query->the_post();?>
							<div class="search-list">
								<a href="<?php echo get_the_permalink();?>">
									<?php the_title();?>
								</a>
							</div><!--.search-list-->
						<?php endwhile;?>
					</div><!-- .entry-content -->
					<?php wp_reset_postdata(); 
				endif;
				$tags = get_tags(array(
					'orderby' => 'count', 
					'order' => 'DESC',
					'number'=>10
				));
				if(!empty($tags)):?>
					<div class="search-border-title">
						<h2>Top Tags</h2>
					</div><!-- border title -->
					<div class="entry-content">
						<?php foreach($tags as $tag):?>
							<div class="search-list">
								<?php $link = get_term_link($tag);
								if(!is_wp_error($link)):?>
									<a href="<?php echo $link;?>">
								<?php endif;?>
									<?php echo $tag->name;?>
								<?php if(!is_wp_error($link)):?>
									</a>
								<?php endif;?>
							</div><!--.search-list-->
						<?php endforeach;?>
					</div><!-- .entry-content -->
				<?php endif;
				$terms = get_terms( array(
					'taxonomy' => 'category',
				));
				if(!is_wp_error($terms)&&is_array($terms)&&!empty($terms)):?>
					<div class="search-border-title">
						<h2>Categories</h2>
					</div><!-- border title -->
					<div class="entry-content">
						<?php foreach($terms as $term):?>
							<div class="search-list">
								<?php $link = get_term_link($term);
								if(!is_wp_error($link)):?>
									<a href="<?php echo $link;?>">
								<?php endif;?>
									<?php echo $term->name;?>
								<?php if(!is_wp_error($link)):?>
									</a>
								<?php endif;?>
							</div><!--.search-list-->
						<?php endforeach;?>
					</div><!-- .entry-content -->
				<?php endif;?>
       		</div><!-- widget area -->
		</div><!-- site content -->
        
        <!-- 
			Ad Zone

======================================================== -->        
        <div class="widget-area">
        	<?php get_template_part('ads/right-big'); ?>
            
        </div><!-- widget area -->
        
        <div class="clear"></div>

		</div><!-- #content -->
	</section><!-- #primary -->


<?php get_footer(); ?>