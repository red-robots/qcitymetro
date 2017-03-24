<?php
		if ( has_post_thumbnail() ) {
			$smallClass = 'small-post-content';
		} else {
			$smallClass = 'small-post-content-full';
		}

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