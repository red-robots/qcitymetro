<?php
	$post = get_post(48792);
	setup_postdata( $post );
	$googleScript = get_field('ad_script');
	$enable = get_field('enable_ad');
	
	if( $enable == 'Yes' ) :
	echo '<!-- job-board-home -->';
	echo '<div class="ad-center"><div class="leaderboard">';
	
		if( $googleScript != '' ) {
			echo $googleScript;
		}
	
	echo '</div></div><!-- ad -->';
	endif; // endif the ad is enabled
	
	wp_reset_postdata();
?>