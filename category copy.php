<?php
/**
 * The template for displaying Category pages
 *
 * Used to display archive-type pages for posts in a category.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); 
if( is_category('6') ) {
	$cat = 'HEALTH';
} else {
	$cat = '';
}
if( is_category('6') ) {
	get_template_part('ads/leaderboard-interior-health');
} else {
	get_template_part('ads/leaderboard-interior');
}
?>


<section id="primary" class="">
		<div id="content" role="main" class="wrapper">

		<?php 
		//our counters
		$i=0;
		$bars=0;
		$thirds=0;
		$thirdsection=0;
		$page2=0;
		$postCount = 0;
		
		// Which category is this?
		$category = get_queried_object()->slug;
		$categoryName = get_queried_object()->name;
		$categoryId = get_queried_object()->term_id;
		$term = 'category_'.$categoryId;
		$sponsoredPost = get_field('sponsored_post', $term);
		$featuredPost = get_field('post', $term);
		if( is_category(6) ) {
			$hCat = 'health-cat';
		}
		/// get the ID of the post that's chosen so you don't repeat yourself
		if( $featuredPost )  :
		// override $post
		$post = $featuredPost;
		setup_postdata( $post );
			$ids[] = get_the_ID();
		endif; wp_reset_postdata();
		
		// make sure we query the right number if a post is chosen
		if( $featuredPost != '' ) {
			$numPosts = '15';
		} elseif( $paged < 2 ) {
			$numPosts = '15';
		} else {
			$numPosts = '15';
		}
		if ($paged < 2) { // if is page 1?>
     		<div class="site-content">
     	<?php } else { ?>
			<div class="news-thirds">
		<?php } ?>
     
       <header class="archive-header">
            <div class="border-title">
                <h1><?php echo $categoryName ?></h1>
            </div><!-- border title -->
		</header><!-- .archive-header -->
		

<?php
	$health = 0;
	$wp_query = new WP_Query();
	$wp_query->query(array(
	'post_type'=>'post',
	'posts_per_page' => $numPosts,
	'paged' => $paged,
	'post__not_in' => $ids,
	'tax_query' => array(
		array(
			'taxonomy' => 'category', // your custom taxonomy
			'field' => 'slug',
			'terms' => array( $category ) // the terms (categories) you created
		)
	)
));
if ($wp_query->have_posts()) : while ($wp_query->have_posts()) :  $wp_query->the_post();	
$postcount = $wp_query->post_count;
//         This is page ONE contents ONLY

//   __________________________________________________
if ($paged < 2) : 
$i++;

	if( $i == 1 )  :
		if( $featuredPost )  :
		// override $post
		$post = $featuredPost;
		setup_postdata( $post ); 
		
			get_template_part('cat/large-post');
		
		 wp_reset_postdata();
		 // since we picked one, don't show this post format again
		 $i = 2;
		endif;
	endif;
	
	
// 			if no featured, still show the big post
//   __________________________________________________
		if ( $i == 1 ) {
			
			get_template_part('cat/large-post');
			
		} elseif ( 2 <= $i && $i <= 5) { 
		
		// need to count again, we'll count up to 4
		 $bars++;
		 $health++;
		 if ( $bars == 1 ) { 
?>
		<div class="inner-area homebars">
           <section>
        <?php } ?>
        
        <?php
		if ( has_post_thumbnail() ) {
			$smallClass = 'small-post-content';
		} else {
			$smallClass = 'small-post-content-full';
		}
		
		// 		Only Health Category
		//   ______________________________________________________________
		if( $hCat == 'health-cat' ) :
		if ( $health == 1 ) {
		if( $sponsoredPost ) :
		//$post = get_post($sponsoredPost); 
			foreach( $sponsoredPost as $post ) :
				setup_postdata( $post ); 
				
					get_template_part('cat/sponsored-post'); 
				
				wp_reset_postdata();
			endforeach;
		endif;
		}
		endif; // endif is health category

?>
<div class="small-post">
	<a href="<?php the_permalink(); ?>">

	<?php if ( has_post_thumbnail() ) { ?>
	        <div class="small-post-thumb">
	        <?php the_post_thumbnail('thumbnail'); ?>
	      </div><!-- small post thumb -->
	     <?php } ?>

	<div class="<?php echo $smallClass; ?>">
	    <h3><?php echo $categoryName; ?></h3>
	    <div class="clear"></div>
	    <h2><?php the_title(); ?></h2>
	</div><!-- small post content -->
	</a>
</div><!-- small post -->
        
        <?php
       
		// echo 'bars -'.$bars;
		// echo 'postcount -'.$postcount;
		// echo 'i -'.$i;
        //if ( $bars == 4 || $i == $postcount ) { // after 4 we break out. 
        if ( $bars == 1  ) { // break to show sponsored. 
		
		
		// 			Before close, grab sponsored content if there is one.
		//			But not Health category
		//   ______________________________________________________________
			if( $hCat !== 'health-cat' ) :

				// Post Type Order Plugin installed, so get that outta here
				remove_all_filters('posts_orderby');

				// put Sponsored content choices in here.
				$ids = array();
				$ids[] = $sponsoredPost[0]->ID;
				$ids[] = $sponsoredPost[1]->ID;
				$ids[] = $sponsoredPost[2]->ID;
				$myIDs = implode(', ', $ids);
				
				if( $sponsoredPost ) :

					$posts_array = get_posts(array(
						'numberposts' => 1, // posts_per_page doesn't work here either.
						'post_type' => 'post',
						'include' => $myIDs, // for some reason, post__in doesn't work here.
						'orderby' => 'rand',
					));

					$numSponsPost = 0;

					foreach( $posts_array as $post ) : $numSponsPost++;
						//global $post;
						setup_postdata( $post ); 
						//echo $post->ID .'<br>';
							get_template_part('cat/sponsored-post'); 
						
						wp_reset_postdata();
						// after 1 get out.
						if( $numSponsPost == 1 ) {break;}
					endforeach;

				endif;
			endif; // endif is not health category

} elseif ( $bars == 4 || $i == $postcount ) { // after 4 we break out. { ?>
			
			


			</section>
	 </div><!-- homebars -->



</div><!-- site content -->
     <!-- 
			Ad Zone right big 

======================================================== -->        
        <div class="widget-area">
        	<?php 
			if( $cat == 'HEALTH' ) {
				echo '<!-- FIRST WIDGET AREA -->';
				get_template_part('ads/right-big-health'); 
			} else {
				//echo 'health';
				get_template_part('ads/right-big'); 
			} ?>
        </div><!-- widget area -->
        
        <div class="clear"></div>
     
     <?php } // endif bars == 4 ?>
        
        
        <?php } else { // end small bars 
		if($i < $postcount) :
		//    Else we go into the small News Thirds
		//   __________________________________________________
		$thirds++;
		$thirdsection++;
		if ( $thirds == 3 ) {
			$tClass = 'third-last';
			$thirds=0;
		} else {
			$tClass = 'third-first';
		}
		?>
        
        <?php if( $thirdsection == 1 ) { echo '<div class="news-thirds">'; } ?>
        
        <section id="third" class="<?php echo $tClass; ?> blocks thirds-cat">
            <div class="post-block">
                <h2><?php the_title(); ?></h2>
                <div class="postdate"><?php echo get_the_date(); ?></div>
                <div class="entry-content">
						<?php //echo get_excerpt(20); ?>
                      <?php the_excerpt(); ?>
                 </div>
                <div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
            </div><!-- post block -->
        </section>
        
        <?php if( $thirdsection == $numPosts ) { echo '</div><!-- news-thirds -->'; } ?>

		<?php 
		endif; // check to make sure you have posts
		} // end news thirds section loop ?>
<?php 
//         All other page contents

//   __________________________________________________
else : ?>

	<?php 
	$thirds++;
					
	if ( $thirds == 3 ) {
		$tClass = 'third-last';
		$thirds=0;
	} else {
		$tClass = 'third-first';
	}
	//get_template_part('cat/thirds-post'); ?>
    <section id="third" class="<?php echo $tClass; ?> blocks thirds-cat">
        <div class="post-block">
            <h2><?php the_title(); ?></h2>
            <div class="postdate"><?php echo get_the_date(); ?></div>
            <div class="entry-content">
			<?php //echo get_excerpt(20); ?>
            <?php the_excerpt(); ?>
            </div>
            <div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
        </div><!-- post block -->
	</section>

<?php endif; // end what number pages ?>

<?php endwhile; // loop ?>

<?php pagi_posts_nav(); ?>



<?php endif; ?>

<?php if ($paged < 2) { // if is page 1?>
     
<?php } else { ?>
	</div><!-- news thirds -->
<?php } ?>


<!-- 
			Videos and Other Category News

======================================================== -->        
        <div class="clear"></div>
        
        <div class="site-content">
        	<div class="videos"></div><!-- videos -->
        	<div class="extra-cat-posts">
                <?php get_template_part('inc/categoryposts'); ?>
             </div><!-- related category posts -->
        </div><!-- site content -->
        
        
        <div class="widget-area">
        	<?php 
				if( $cat == 'HEALTH' )  {
					echo '<!-- SECOND WIDGET AREA -->';
					get_template_part('ads/right-small-health'); 
				} else {
					get_template_part('ads/right-small'); 
				} ?>
        	<?php 
if( $cat == 'HEALTH' )  {
	get_template_part('ads/right-rail-health'); 
} else {
	get_template_part('ads/right-rail');
} ?>

<header class="archive-header">
    <div class="border-title floatright">
        <h2>QcityEVENTS</h2>
    </div><!-- border title -->
</header><!-- .archive-header -->

<div class="clear"></div>

<div class="event-box">
<?php
 $thedate = date("Ymd"); 
$wp_query = new WP_Query();
	$wp_query->query(array(
	'post_type'=>'event',
	'posts_per_page' => 5,
	'meta_key' => 'event_date',
    'meta_value' => $thedate,
    'meta_compare' => '>=',
	'orderby' => 'meta_value_num',
	'order' => 'ASC'
));
if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();

$startDate = DateTime::createFromFormat('Ymd', get_field('event_date'));

?>	
	<div class="event-box-event">
    	<div class="event-box-date"><?php echo $startDate->format('n.j'); ?></div>
        <div class="event-box-title"><?php the_title(); ?></div>
        <div class="event-box-link">
        	<a href="<?php the_permalink(); ?>">See Event</a>
        </div><!-- evnent box link -->
    </div><!-- event box event -->
    
<?php endwhile; endif; wp_reset_query(); wp_reset_postdata(); ?>
    
    <div class="event-box-button"><a href="<?php bloginfo('url'); ?>/events-entertainment">More Events</a></div><!-- event box button -->
    <div class="event-box-button"><a href="<?php bloginfo('url'); ?>/submit-an-event">Submit an Event</a></div><!-- event box button -->
    
</div><!-- event box -->
        </div><!-- widget area --> 


		</div><!-- #content -->
	</section><!-- #primary -->


<?php get_footer(); ?>