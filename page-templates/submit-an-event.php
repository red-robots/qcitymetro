<?php
/**
 * Template Name: Submit an Event
 */

get_header(); ?>

	<div id="primary" class="">
		<div id="content" role="main" class="wrapper">

			<?php 
            // $i=0;

            while ( have_posts() ) : the_post();
            // $i++; 
            // if( $i == 2 ) {
            //     $postclass = 'first-event';
            //     $i=0;
            // } else {
            //     $postclass = 'last-event';
            // }
            $topContent = get_field('top_of_page_text');
			$premiumBenefits = get_field('premium_benefits');
            $premiumCost = get_field('premium_cost');
            $premiumLink = get_field('premium_link');
            $featuredBenefits = get_field('featured_benefits');
            $featuredCost = get_field('featured_cost');
            $featuredLink = get_field('featured_link');
			$standardBenefits = get_field('benefits');
			$standardCost = get_field('cost');
			$standardLink = get_field('link');
            $noBenefits = get_field('benefits_no_pro');
            $noCost = get_field('cost_no_pro');
            $noLink = get_field('link_no_pro');

			$title_text_slider = get_field('title_text_slider');
            $title_text_eblast = get_field('title_text_eblast');
			$button_text_newsletter = get_field('button_text_newsletter');
            $button_text_slider = get_field('button_text_slider');
            $button_text_both = get_field('button_text_both');
            $button_text_no_pro = get_field('button_text_no_pro');
			
			
			?>
				<header class="archive-header">
				<div class="border-title">
                    <h1><?php the_title(); ?></h1>
                </div><!-- border title -->
			</header><!-- .archive-header -->
            
            <div class="entry-content">
            <?php echo $topContent; ?>
            <div class="clear"></div>


           <!--  <section class="event-submit first-event blocks">
                <h5>Newsletter</h5>
                <div class="clear"></div>
                <h4>Cost: <?php echo $standardCost; ?></h4>
                    <?php echo $standardBenefits; ?>
                    <div class="clear"></div>
                <div class="button viewmore-short left">
                    <a href="<?php echo $standardLink; ?>"><?php echo $button_text_newsletter; ?></a>
                </div>
            </section>

            <section class="event-submit last-event blocks">
                <h5>Slider</h5>
                <div class="clear"></div>
                <h4>Cost: <?php echo $featuredCost; ?></h4>
                    <?php echo $featuredBenefits; ?>
                    <div class="clear"></div>
                <div class="button viewmore-short left">
                    <a href="<?php echo $featuredLink; ?>"><?php echo $button_text_slider; ?></a>
                </div> -->
            </section>

            <section class="event-submit first-event blocks">
                <h5><?php echo $title_text_slider;?></h5>
                <div class="clear"></div>
                <h4>Cost: <?php echo $premiumCost; ?></h4>
                    <?php echo $premiumBenefits; ?>
                    <div class="clear"></div>
            </section>

            <section class="event-submit last-event blocks">
                <h5><?php echo $title_text_eblast;?></h5>
                <div class="clear"></div>
                <h4>Cost: <?php echo $noCost; ?></h4>
                    <?php echo $noBenefits; ?>
                    <div class="clear"></div>
            </section>
            
            <div class="clear"></div>

            <?php the_content(); ?>
            
            </div><!-- entry content -->
            
            
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>