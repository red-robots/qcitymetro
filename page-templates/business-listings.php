<?php
/**
 * Template Name: Business Listings
 */

get_header(); ?>

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
                    <?php $args    = array(
                        'taxonomy'   => "business_category",
                        'order'      => 'ASC',
                        'orderby'    => 'term_order',
                        'hide_empty' => 0
                    );
                    $terms         = get_terms( $args );
                    if ( ! is_wp_error( $terms ) && is_array( $terms ) && ! empty( $terms ) ): ?>
                        <?php foreach($terms as $term):?>
                            <div class="category">
                                <a href="<?php echo get_term_link($term->term_id);?>">
                                    <?php echo $term->name;?>
                                </a>
                            </div><!--.category-->
                        <?php endforeach;?>
                    <?php endif;?>
                </div><!--.col-1-->
                <div class="col-2">
                    <?php the_content();?>
                </div><!--.col-2-->
            </div><!--.business-listings-wrapper-->
            
            </div><!-- site content -->
            
<!-- 
			Ad Zone

======================================================== -->        
        <div class="widget-area">
        	<?php 
			get_template_part('ads/right-big'); 
			get_template_part('ads/right-small');
			get_template_part('ads/right-rail');
			?>
        </div><!-- widget area -->
        
        
                
          

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>