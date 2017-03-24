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
		</div><!-- .author-link	-->
	</div><!-- .author-description -->
    <?php } ?>
</div><!-- .author-info -->