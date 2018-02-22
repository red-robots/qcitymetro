<div class="border-title no-top-margin">
	<h2>Used By</h2>
</div><!-- border title -->

<?php $rows = get_field("job_board_top_tier_sponsors","option");
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
$rows = get_field("job_board_second_tier_sponsors","option");
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


<div class="clear"></div>