<div class="border-title">
            	<!-- <div class="smally-text">Qcitymetro is proudly</div> -->
            	<h2>Our Partners</h2>
        	</div><!-- border title -->

					<?php $rows = get_field("top_tier_sponsors","option");
					if($rows) : foreach($rows as $row) : 
	            		$link = $row['link'];
	            		$logo = $row['logo'];
	            		$size = 'large';
	            	?>
	            		<div class="spon-tier-one">
		            		<a target="_blank" href="<?php echo $link; ?>">
		            			<?php echo wp_get_attachment_image( $logo, $size ); ?>
		            		</a>
	            		</div>
					<?php endforeach; endif; ?>

	            	<?php 
					$i=0;
					$rows = get_field("second_tier_sponsors","option");
	            	if($rows) : foreach($rows as $row) : $i++;
	            		$link = $row['sponsor_link'];
	            		$logo = $row['sponsor_logo'];
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
	            	<?php endforeach; endif; ?>

					<?php $rows = have_rows('third_tier_sponsors', 'option');
					if($rows) : foreach($rows as $row) :  
	            		$link = $row['sponsor_link'];
	            		$logo = $row['sponsor_logo'];
	            		$size = 'large';
	            	?>
	            		<div class="spon-tier-three">
		            		<a target="_blank" href="<?php echo $link; ?>">
		            			<?php echo wp_get_attachment_image( $logo, $size ); ?>
		            		</a>
	            		</div>
	            	<?php endforeach; endif; ?>
	            	<div class="clear"></div>

	            	<div class="bar"></div>

	            	<div class="clear"></div>

	            	<!-- <div class="viewmore button"><a href="<?php bloginfo('url'); ?>/sponsors">VIEW SPONSORHIP OPPORTUNITIES</a></div> -->