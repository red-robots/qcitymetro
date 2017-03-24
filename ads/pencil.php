<?php
	$post = get_post(9);
	setup_postdata( $post );
	$googleScript = get_field('ad_script');
	$pencilAdImage = get_field('pencil_ad');
	$pencilLink = get_field('pencil_link');
	$size = 'large';
	$pencilAd = $pencilAdImage['sizes'][ $size ];
	$enable = get_field('enable_ad');
	
	if( $enable == 'Yes' ) :
	echo '<!-- pencil -->';
		if( $pencilAdImage != '' ) {
			echo '<div class="pencil-ad">';
			if( $pencilLink != '' ) {echo '<a href="'.$pencilLink.'">';}
			echo '<img src="'.$pencilAdImage.'" />';
			if( $pencilLink != '' ) {echo '</a>';}
			echo '</div>';	
		} else {
			if( $googleScript != '' ) {
				echo '<div class="pencil-ad">';
				echo $googleScript;
				echo '</div><!-- end pencil ad -->';	
			}
		}
	
	endif; // endif the ad is enabled
	
	wp_reset_postdata(); ?>