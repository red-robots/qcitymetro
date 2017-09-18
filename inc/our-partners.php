<div class="border-title">
            	<!-- <div class="smally-text">Qcitymetro is proudly</div> -->
            	<h2>Our Partners</h2>
        	</div><!-- border title -->

			<?php if(have_rows('top_tier_sponsors', 'option')) : while(have_rows('top_tier_sponsors', 'option')) : the_row(); 
	            		$link = get_sub_field('link', 'option');
	            		$logo = get_sub_field('logo', 'option');
	            		$size = 'large';
	            	?>
	            		<div class="spon-tier-one">
		            		<a target="_blank" href="<?php echo $link; ?>">
		            			<?php echo wp_get_attachment_image( $logo, $size ); ?>
		            		</a>
	            		</div>
	            	<?php endwhile; wp_reset_postdata();endif; ?>

	            	<?php 
	            	$i=0;
	            	if(have_rows('second_tier_sponsors', 'option')) : while(have_rows('second_tier_sponsors', 'option')) : the_row(); $i++;
	            		$link = get_sub_field('sponsor_link', 'option');
	            		$logo = get_sub_field('sponsor_logo', 'option');
	            		$size = 'large';

	            		if($i == 2) {
	            			$class = 'spon-last';
	            			$i=0;
	            		} else {
	            			$class = 'spon-first';
	            		}
	            	?>
	            		<div class="spon-tier-two <?php echo $class; ?> blocks">
	            		<div class="helper">
		            		<a target="_blank" href="<?php echo $link; ?>">
		            			<?php echo wp_get_attachment_image( $logo, $size ); ?>
		            		</a>
		            		</div>
	            		</div>
	            	<?php endwhile; wp_reset_postdata();endif; ?>

	            	<?php if(have_rows('third_tier_sponsors', 'option')) : while(have_rows('third_tier_sponsors', 'option')) : the_row(); 
	            		$link = get_sub_field('sponsor_link', 'option');
	            		$logo = get_sub_field('sponsor_logo', 'option');
	            		$size = 'large';
	            	?>
	            		<div class="spon-tier-three">
		            		<a target="_blank" href="<?php echo $link; ?>">
		            			<?php echo wp_get_attachment_image( $logo, $size ); ?>
		            		</a>
	            		</div>
	            	<?php endwhile; wp_reset_postdata();endif; ?>
	            	<div class="clear"></div>

	            	<div class="bar"></div>

	            	<div class="clear"></div>

	            	<!-- <div class="viewmore button"><a href="<?php bloginfo('url'); ?>/sponsors">VIEW SPONSORHIP OPPORTUNITIES</a></div> -->