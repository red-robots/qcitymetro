<?php 
	$permalink = get_the_permalink(39809);
	if($permalink):
		wp_redirect( $permalink );
	else:
		wp_redirect(get_bloginfo('url'));
	endif;
	exit;
?>