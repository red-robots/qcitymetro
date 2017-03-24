<?php 
wp_reset_query();

// Which category is this?
$category = get_queried_object()->slug;
$categoryName = get_queried_object()->name;
$categoryId = get_queried_object()->term_id;
		
 $categories = array(
 	'news',
	'entertainment',
	'commentary',
	'health',
	'faith',
	'people'
 );
 
 // Get some Id's first
/*$categoryId = get_queried_object()->term_id;
*/
		
		
$i=0;
// Start the loop
foreach( $categories as $kitty ) :
$i++;



// get the term object so we can get the ID... by slug
$termObject = get_term_by('slug', $kitty, 'category');
// get the term so we can pull the featured post
$term = 'category_'.$termObject->term_id;
// now we can pull the post from the field
$featuredPost = get_field('post', $term);

// Don't pull current category
if( $kitty !== $category ):
// how many items we got?
$ii=0;
$numItems = count($categories);
// see if we have a featured post first
/*
// testing 
echo '<pre>';
print_r($termObject);
echo '<pre>';*/
if( $featuredPost )  :
// override $post
$post = $featuredPost;
setup_postdata( $post );
	
	$color = get_field( 'category_color', $term );
	if(++$ii === $numItems) {
    	$catClass = 'extra-cat-last';
	  } else {
		  $catClass = 'extra-cat-first';
	  }
?>
<div class="extra-cat-post <?php echo $catClass; ?> blocks">
<h3 style="
	color: <?php echo $color; ?>; 
    border-bottom: 2px solid <?php echo $color; ?>
    " >
	<?php echo $termObject->name; ?>
</h3>
    
<?php if ( has_post_thumbnail() ) {
          the_post_thumbnail('thumbnail');
		} ?>
        <h4><?php the_title(); ?></h4>
        <div class="postdate"><?php echo get_the_date(); ?></div>
        <?php echo get_excerpt(20); ?><?php //the_excerpt(); ?>
        <div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
</div><!-- extra cat post -->

<?php 

wp_reset_postdata(); // reset the post data
// else we do the latest post
else: 
	$wp_query = new WP_Query();
	$wp_query->query(array(
	'post_type'=>'post',
	'posts_per_page' => 1,
	'tax_query' => array(
		array(
			'taxonomy' => 'category', // your custom taxonomy
			'field' => 'slug',
			'terms' => array( $kitty ) // the terms (categories) you created
		)
	)
));


if ($wp_query->have_posts()) :
while ($wp_query->have_posts()) :  $wp_query->the_post(); 
	$queried_object = get_queried_object(); 
	$term_id = $queried_object->term_id;
	$color = get_field( 'category_color', 'category_'.$term_id );
	if(++$ii === $numItems) {
    	$catClass = 'extra-cat-last';
	  } else {
		  $catClass = 'extra-cat-first';
	  }
?>
<div class="extra-cat-post <?php echo $catClass; ?> blocks">
<h3 style="
	color: <?php echo $color; ?>; 
    border-bottom: 2px solid <?php echo $color; ?>
    " >
	<?php echo $queried_object->name; ?>
</h3>
    
<?php if ( has_post_thumbnail() ) {
          the_post_thumbnail('thumbnail');
		} ?>
        <h4><?php the_title(); ?></h4>
        <div class="postdate"><?php echo get_the_date(); ?></div>
        <?php echo get_excerpt(20); ?><?php //the_excerpt(); ?>
        <div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
</div><!-- extra cat post -->
<?php endwhile; ?>

<?php endif; // end of latest post

endif; // end if featured post
endif; // endif not kitty

endforeach; 
?>