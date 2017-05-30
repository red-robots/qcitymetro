<?php
	$googleScript = get_field('ad_script_header');
	$enable = get_field('enable_ad_header');
	
	if( $enable == 'Yes' ) :
	echo '<!-- sponsor ad -->';
	echo '<div class="ad-center"><div class="leaderboard">';
	
		if( $googleScript != '' ) {
			echo $googleScript;
		}
	
	echo '</div></div><!-- ad -->';
	endif; // endif the ad is enabled
?>