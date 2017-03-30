<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
 wp_reset_postdata();
 if( !is_front_page() ) {
	 
 } elseif ( !is_single() ) {
	 
 } elseif ( !is_page(52) ) {
	 
 } else  {
 	// If is not in Sponsored Content, proceed
	if(!in_category(30)) :
 		get_template_part('ads/leaderboard-interior');
 	endif;
 }
?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo" class="">
		<div class="site-info">
        
        <?php 
		$footerbio = get_field( 'footer_bio', 'option' );
		$pnl = get_field( 'privacy_link', 'option' );
		$legal = get_field( 'legal_link', 'option' );
		$sitemap = get_field( 'sitemap_link', 'option' );
		
		?>
        <?php get_template_part('inc/email-modal'); ?>
        <div class="footer-left">
			<div class="footer-bio"><?php echo $footerbio; ?></div>
            <nav class="footermenu"><?php wp_nav_menu( array( 'theme_location' => 'footer' ) ); ?></nav>
        </div><!-- footer left -->
        
        
        <div class="footer-right">
			<div class="email-signup">
			JOIN OUR COMMUNITY TO RECEIVE EMAIL UPDATES FROM Q<span class="lowercase">citymetro</span>
            </div><!-- email signup -->
            <div class="clear"></div>
			<?php //get_template_part( 'inc/emailsignup' ); ?>
            <div class="footer-signup"><a href="<?php bloginfo('url'); ?>/email-signup">Sign Up</a></div>
            
            <div class="clear"></div>
            <div class="pnl">
            	<a href="<?php echo $pnl; ?>">privacy</a> &amp; <a href="<?php echo $legal; ?>">legal</a> | <a href="<?php echo $sitemap; ?>">sitemap</a>
            </div><!-- pnl -->
            <div class="clear"></div>
           <div class="pnl"> site by <a href="http://bellaworksweb.com">bellaworks</a></div>
        </div><!-- footer left -->
        
        
        
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php the_field('google_analytics','option'); ?>
<?php 
acf_enqueue_uploader();
wp_footer(); ?>

<!-- liquid web -->
</body>
</html>