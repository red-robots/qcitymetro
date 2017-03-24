<?php 
$video = get_field( 'video_single_post' ); ?>
<div class="inner-content large-post">
    <section>
            <?php 
            if( $video != '' ) :
                echo $video;
            else:
            if ( has_post_thumbnail() ) { ?>
            <div class="postthumb-full">
                 <?php the_post_thumbnail('large'); ?>
             </div><!-- post thumb -->
         <?php } endif; ?>
         <h2><?php the_title(); ?></h2>
         <div class="postdate"><?php echo get_the_date(); ?></div>
        <div class="entry-content"><?php //echo get_excerpt(20); ?><?php the_excerpt(); ?></div>
        <div class="q-readmore-gold"><a href="<?php the_permalink(); ?>">Read more</a></div>
    </section>
</div><!-- inner content -->