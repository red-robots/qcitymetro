<?php
	$post = get_post(15955);
	setup_postdata( $post );

	$googleScript = get_field('ad_script');
	$enable = get_field('enable_ad');
	
	if( $enable == 'Yes' ) :
	echo '<!-- right big -->';
	echo '<div class="ad">';
	
		if( $googleScript != '' ) {
			echo $googleScript;
		}
	
	echo '</div><!-- ad -->';
	endif; // endif the ad is enabled

	wp_reset_postdata(); 
	
	/*
			Optional Ad
	_____________________________________*/
	$post = get_post(15956);
	setup_postdata( $post );

	$googleScript = get_field('ad_script');
	$enable = get_field('enable_ad');
	
	if( $enable == 'Yes' ) :
	echo '<!-- right big -->';
	echo '<div class="ad">';
	
		if( $googleScript != '' ) {
			echo $googleScript;
		}
	
	echo '</div><!-- ad -->';
	endif; // endif the ad is enabled

	wp_reset_postdata();

?>