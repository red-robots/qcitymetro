<?php
/**
 * Taxonomy template
 *
 * To create different taxonomy templates, copy
 * this file and create a new...
 *
 * Ex: taxonomy-my_custom_tax.php
 */
get_header(); ?>

    <div id="primary" class="">
        <div id="content" role="main" class="wrapper">
			<?php
			// get some info about the term queried
			$queried_object = get_queried_object();
			$taxonomy       = $queried_object->taxonomy;
			$term_id        = $queried_object->term_id;
			?>

			<?php //Get the correct taxonomy ID by id
			$term = get_term_by( 'id', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>

			<?php // use the term to echo the description of the term
			echo term_description( $term, $taxonomy ) ?>
            <div class="site-content">

                <header class="archive-header">
                    <div class="border-title">
                        <h1><?php echo get_cat_name( $term_id ); ?></h1>
                    </div><!-- border title -->
                </header><!-- .archive-header -->

				<?php get_template_part( 'inc/business-header' ); ?>


				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post();

						$image       = get_field( 'business_thumbnail' );
						$size        = 'thumbnail';
						$thumb       = $image['sizes'][ $size ];
						$location    = get_field( 'address' );
						$email       = get_field( 'email' );
						$phone       = get_field( 'phone' );
						$website     = get_field( 'website' );
						$category    = get_field( 'category' );
						$description = get_field( 'description' );
						$trimmedAdd = "";
						if($location != '') {
							$address    = $location['address'];
							$us         = ', United States';
							$trimmedAdd = str_replace( $us, '', $address );
						}
						?>


                        <div class="featured-event">

                            <div class="featured-event-content-details">
                                <a href="<?php the_permalink(); ?>">DETAILS</a>
                            </div><!-- featured event content -->

                            <div class="featured-event-image-business">
								<?php if ( $image != '' ) { ?>
                                    <img src="<?php echo $thumb; ?>"/>
								<?php } ?>
                            </div><!-- featured event image -->
                            <div class="featured-event-content">
                                <h2><?php the_title(); ?></h2>
								<?php if ( $trimmedAdd != '' ) { ?>
                                    <div class="fe-location">
										<?php echo $trimmedAdd; ?>
                                    </div>
								<?php } ?>
								<?php if ( $phone != '' ) { ?>
                                    <div class="fe-start"><?php echo $phone; ?></div>
								<?php } ?>
								<?php if ( $description != '' ) { ?>
                                    <div class="fe-desc"><?php echo $description; ?></div>
								<?php } ?>
                            </div><!-- featured event content -->

                        </div><!-- featured event -->


					<?php endwhile; ?>
                    <div class="clear"></div>

					<?php
// references pagination function in your functions.php file
					pagi_posts_nav(); ?>
				<?php else:
					$post = get_post(21);
					setup_postdata( $post );
					$fallback_text = get_field( 'fallback_text' );
					if ( $fallback_text ):?>
                        <div class="featured-event">
                            <?php echo $fallback_text; ?>
                        </div><!-- featured event -->
					<?php endif;
					wp_reset_postdata();
				endif; // end of the loop. ?>

            </div><!-- site content -->
            <!--
						Ad Zone

			======================================================== -->
            <div class="widget-area">
                <?php get_template_part('ads/right-business-directory'); ?>
            </div><!-- widget area -->


        </div><!-- #content -->
    </div><!-- #primary -->
<?php get_footer(); ?>