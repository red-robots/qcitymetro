<?php
/**
 * Template Name: Business Listings
 */

get_header();

$featured_post = get_field('featured_post');
?>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

			
			<div class="site-content">
            
            <header class="archive-header">
				<div class="border-title">
                    <h1><?php the_title(); ?></h1>
                </div><!-- border title -->
			</header><!-- .archive-header -->
			<div class="business-listings-wrapper">
                <div class="col-1">
                    <div class="business-directory-search-box">
                        <h3>Search Businesses</h3>
                        <form id="category-select" class="category-select replace"  action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
			                <?php $args = array(
				                'show_option_none'  => 'Select category',
				                'show_count'        => 1,
                                'hide_empty'        => 0,
				                'orderby'       => 'name',
				                'hierarchical'      => 1,
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
		                $query  = "SELECT posts.ID AS ID, posts.post_title AS title FROM $wpdb->postmeta AS meta 
                                    INNER JOIN $wpdb->posts AS posts ON meta.post_id = posts.ID 
                                    WHERE meta.meta_key='views' AND posts.post_type='business_listing'
                                    ORDER BY CAST(meta.meta_value as UNSIGNED) DESC LIMIT 5";
		                $results = $wpdb->get_results( $query );
		                for($i=1;$i<=count($results);$i++){
			                $result = $results[$i-1];?>
                            <div class="listing">
				                <?php echo $i.". ";?><a href="<?php echo get_the_permalink($result->ID);?>"><?php echo $result->title;?></a>
                            </div>
		                <?php } ?>
                        <div class="button viewmore-short">
                            <a href="<?php bloginfo('url'); ?>/business-directory/business-directory-sign-up">Add your business to this directory</a>
                        </div><!-- button -->
                    </div><!--.business-directory-search-box-->
                </div><!--.col-1-->
                <div class="col-2">
                    <section class="business-featured-post">
		                <?php
		                $posts = $featured_post;
		                foreach( $posts as $post):
			                setup_postdata( $post );
			                $term = get_the_terms($post->ID, 'category');
			                $termId = $term[0]->term_id;
			                $color = get_field( 'category_color', 'category_'.$termId );
			                $video = get_field( 'video_single_post' );

			                ?>
                            <div class="solid-border-title" style="border-bottom: 3px solid <?php echo $color; ?>">
                                <h2 style="background-color: <?php echo $color; ?>"><?php echo $term[0]->name; ?></h2>
                            </div><!-- border title -->

                            <div class="post-block blocks">


				                <?php
				                if( $video != '' ) :
					                echo $video;
				                else:
					                if ( has_post_thumbnail() ) { ?>
                                        <div class="post-block-image js-titles">
							                <?php  the_post_thumbnail('thirds'); ?>
                                        </div>
					                <?php } endif; ?>

                                <h2><?php the_title(); ?></h2>
                                <div class="postdate"><?php echo get_the_date(); ?></div>
                                <div class="entry-content home-content"><?php the_excerpt(); ?></div>
                                <div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
                            </div><!-- post block -->

			                <?php // get more ids
			                $ids[] = get_the_ID();
		                endforeach;
		                wp_reset_postdata(); ?>
                    </section>
                </div><!--.col-2-->
            </div><!--.business-listings-wrapper-->
            
            </div><!-- site content -->
            
<!-- 
			Ad Zone

======================================================== -->        
        <div class="widget-area">
        	<?php 
			get_template_part('ads/right-business-directory');
			get_template_part('ads/right-small');
			get_template_part('ads/right-rail');
			?>
        </div><!-- widget area -->
        
        
                
          

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>