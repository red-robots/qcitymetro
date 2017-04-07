<?php
/**
 * Template Name: Church Listings
 */

get_header();
$featured_post = get_field('featured_post');
?>

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
                <?php the_content();?>
            </div>
            <div class="church-listings-wrapper">
                <div class="col-1">
                    <div class="church-directory-search-box">
                        <h3>Search Denominations</h3>
                        <form id="category-select" class="category-select replace"  action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
				            <?php $args = array(
					            'show_option_none'  => 'Select Denomination',
					            'show_count'        => 1,
					            'hide_empty'        => 0,
					            'orderby'       => 'name',
					            'hierarchical'      => 1,
					            'echo'          => 0,
					            'value_field' => 'slug',
					            'taxonomy'           => 'denomination',
					            'name' => 'denomination'
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
                        <h3>Most Viewed Church Listings</h3>
			            <?php
			            $query  = "SELECT posts.ID AS ID, posts.post_title AS title FROM $wpdb->postmeta AS meta 
                                    INNER JOIN $wpdb->posts AS posts ON meta.post_id = posts.ID 
                                    WHERE meta.meta_key='views' AND posts.post_type='church_listing'
                                    ORDER BY CAST(meta.meta_value as UNSIGNED) DESC LIMIT 20";
			            $results = $wpdb->get_results( $query );
			            $used = [];
			            if(count($results)>4) {
				            for ( $i = 0; $i < 5; $i ++ ) {
					            do {
						            $index  = rand( 0, count( $results ) - 1 );
					            } while (in_array($index,$used));
					            $used[] = $index;
					            $result = $results[ $index ]; ?>
                                <div class="listing">
                                    <a href="<?php echo get_the_permalink( $result->ID ); ?>"><?php echo $result->title; ?></a>
                                </div>
				            <?php }
			            }?>
                        <div class="button viewmore-short">
                            <a href="<?php bloginfo('url'); ?>/church-directory/church-directory-sign-up">Add your church to this directory</a>
                        </div><!-- button -->
                    </div><!--.business-directory-search-box-->
                </div><!--.col-1-->
                <div class="col-2">
                    <section class="church-featured-post">
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
            </div><!--.church-listings-wrapper-->
            
            </div><!-- site content -->
            
<!-- 
			Ad Zone

======================================================== -->        
        <div class="widget-area">
        	<?php
	        get_template_part('ads/right-church-directory');
			get_template_part('ads/right-church-directory-small');
			?>
        </div><!-- widget area -->
        
        
                
          
        
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>