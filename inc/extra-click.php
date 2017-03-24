<section class="extraclick">
	<h2 class="headline">More Stories from Qcitymetro</h2>

<?php 
/* 

	Get the 4 main stories from the 4 main sections. 

*/

// Categort ID's
$healthID = 'category_6';
$peopleID = 'category_4';
$newsID = 'category_1';
$faithID = 'category_2';

// Get selected Posts
$healthFeaturedPost = get_field('post', $healthID);
$peopleFeaturedPost = get_field('post', $peopleID);
$newsFeaturedPost = get_field('post', $newsID);
$faithFeaturedPost = get_field('post', $faithID);

// Show 4 posts 
if( $healthFeaturedPost )  :
$post = $healthFeaturedPost;
setup_postdata( $post ); 

// $term = get_the_terms($section1->ID, 'category');
// $termId = $term[0]->term_id;
$color = get_field( 'category_color', 'category_6');
?>
	<div class="extra-click blocks">
		<div class="solid-border-title" style="border-bottom: 3px solid <?php echo $color; ?>">
            <h2 style="background-color: <?php echo $color; ?>">Health</h2>
        </div><!-- border title -->
		<a href="<?php the_permalink(); ?>">
			<div class="post-block-image">
               <?php  the_post_thumbnail('thirds'); ?>
           </div>
           <h2 class="ctitle js-titles"><?php the_title(); ?></h2>
		</a>
	</div><!-- extra click -->
<?php 
endif; 
wp_reset_postdata();

if( $peopleFeaturedPost )  :
$post = $peopleFeaturedPost;
setup_postdata( $post ); 
// $term = get_the_terms($section1->ID, 'category');
// $termId = $term[0]->term_id;
$color = get_field( 'category_color', 'category_4' );
?>
	<div class="extra-click blocks">
		<div class="solid-border-title" style="border-bottom: 3px solid <?php echo $color; ?>">
            <h2 style="background-color: <?php echo $color; ?>">People</h2>
        </div><!-- border title -->
		<a href="<?php the_permalink(); ?>">
			<div class="post-block-image">
               <?php  the_post_thumbnail('thirds'); ?>
           </div>
           <h2 class="ctitle js-titles"><?php the_title(); ?></h2>
		</a>
	</div><!-- extra click -->
<?php 
endif; 
wp_reset_postdata();

if( $newsFeaturedPost )  :
$post = $newsFeaturedPost;
setup_postdata( $post ); 
// $term = get_the_terms($section1->ID, 'category');
// $termId = $term[0]->term_id;
$color = get_field( 'category_color', 'category_1' );
?>
	<div class="extra-click blocks">
		<div class="solid-border-title" style="border-bottom: 3px solid <?php echo $color; ?>">
            <h2 style="background-color: <?php echo $color; ?>">News &amp; Buzz</h2>
        </div><!-- border title -->
		<a href="<?php the_permalink(); ?>">
			<div class="post-block-image">
               <?php  the_post_thumbnail('thirds'); ?>
           </div>
           <h2 class="ctitle js-titles"><?php the_title(); ?></h2>
		</a>
	</div><!-- extra click -->
<?php 
endif; 
wp_reset_postdata();

if( $faithFeaturedPost )  :
$post = $faithFeaturedPost;
setup_postdata( $post ); 
// $term = get_the_terms($section1->ID, 'category');
// $termId = $term[0]->term_id;
$color = get_field( 'category_color', 'category_2' );
?>
	<div class="extra-click blocks">
		<div class="solid-border-title" style="border-bottom: 3px solid <?php echo $color; ?>">
            <h2 style="background-color: <?php echo $color; ?>">Faith</h2>
        </div><!-- border title -->
		<a href="<?php the_permalink(); ?>">
			<div class="post-block-image">
               <?php  the_post_thumbnail('thirds'); ?>
           </div>
           <h2 class="ctitle js-titles"><?php the_title(); ?></h2>
		</a>
	</div><!-- extra click -->
<?php 
endif; 
wp_reset_postdata();?>
</section>