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
            <div class="entry-content">
                <?php the_content();?>
            </div>
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
	                    $args = array(
		                    'range' => 'weekly',
		                    'post_type' => 'business_listing',
		                    'wpp_start' => '',
		                    'wpp_end' => '',
		                    'limit'=>5,
		                    'post_html' => '<div class="listing"><a href="{url}">{text_title}</a></div>'
	                    );
	                    wpp_get_mostpopular( $args );
	                    ?>
                        <div class="button viewmore-short">
                            <a href="<?php bloginfo('url'); ?>/business-directory/business-directory-sign-up">Add your business to this directory</a>
                        </div><!-- button -->
                    </div><!--.business-directory-search-box-->
                </div><!--.col-1-->
                <div class="col-2">
                    <section class="business-featured-post">
		                <?php
		                $posts = $featured_post;
		                if($posts):
                            foreach( $posts as $post):
			                setup_postdata( $post );
			                $video = get_field( 'video_single_post' );

			                ?>

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
                                <div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
                            </div><!-- post block -->

			                <?php // get more ids
			                $ids[] = get_the_ID();
		                endforeach;
		                wp_reset_postdata();
		                endif;?>
                    </section>
                </div><!--.col-2-->
            </div><!--.business-listings-wrapper-->
            <div class="business-listings-coupons">
				<?php for($i=0;$i<9;$i++):?>
					<div class="coupon">
						<broadstreet zone-id=“63936”></broadstreet-zone>
					</div><!--.coupon-->
				<?php endfor;?>
            </div><!--.business-listings-coupons-->
			</div><!-- site content -->
            
<!-- 
			Ad Zone

======================================================== -->        
        <div class="widget-area">
        	<?php 
			get_template_part('ads/right-business-directory');
			get_template_part('ads/right-business-directory-small');
			?>
        </div><!-- widget area -->
        
        
                
          

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>