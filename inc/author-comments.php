<div class="author">
<?php $guestAuthor = get_field('author_name');
    if( $guestAuthor != '' ) {
        echo $guestAuthor;
    } else { ?>
By <?php echo get_the_author(); } ?>
</div><!-- author -->
<div class="postdate"><?php echo get_the_date(); ?></div>
    <?php the_content(); ?>
</div><!-- entry content -->

 <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="standard" data-action="recommend" data-show-faces="true" data-share="true"></div>
 
 <div class="clear"></div>
 
<div class="footer-meta">
    Categorized: <?php the_category(', '); ?>
</div><!-- footer meta -->

<!-- Your like button code -->

<div class="author-info">
<?php 
        if( $guestAuthor != '' ) { ?>
            <div class="author-description">
                <h2><?php echo $guestAuthor; ?></h2>
          </div><!-- author desc -->
        <?php } else { ?>
    <div class="author-avatar">
        <?php
        /** This filter is documented in author.php */
        $author_bio_avatar_size = apply_filters( 'twentytwelve_author_bio_avatar_size', 68 );
        echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
        ?>
    </div><!-- .author-avatar -->
    <div class="author-description">
        <h2><?php printf( __( 'About %s', 'twentytwelve' ), get_the_author() ); ?></h2>
        <p><?php the_author_meta( 'description' ); ?></p>
        <div class="author-link">
            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                <?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentytwelve' ), get_the_author() ); ?>
            </a>
        </div><!-- .author-link -->
    </div><!-- .author-description -->
    <?php } ?>
</div><!-- .author-info -->


<nav class="nav-single">
    <h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
    <span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', 'twentytwelve' ) . '</span> previous' ); ?></span>
    <span class="nav-next"><?php next_post_link( '%link', 'next <span class="meta-nav">' . _x( '', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
</nav><!-- .nav-single -->

<?php //comments_template( '', true );
echo do_shortcode('[fbcomments width="375" count="off" num="5" countmsg="comments!"]');

 ?>