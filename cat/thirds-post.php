<?php

?>

<section id="third" class="<?php echo $tClass; ?> blocks thirds-cat">
    <div class="post-block">
        <h2><?php the_title(); ?></h2>
        <div class="postdate"><?php echo get_the_date(); ?></div>
        <div class="entry-content"><?php //echo get_excerpt(17); ?><?php the_excerpt(); ?></div>
        <div class="q-readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
    </div><!-- post block -->
</section>