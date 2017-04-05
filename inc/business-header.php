<div class="business-header">
	
    <div class="button viewmore-short">
    <a href="<?php bloginfo('url'); ?>/business-directory/business-directory-sign-up">Add your business to this directory</a>
    </div><!-- button -->

<div class="business-header-right">  
<h3>Search by Category</h3>  
<?php $args = array(
	'taxonomy'      => 'category',
	'show_option_none'  => 'Select category',
	'show_count'        => 1,
	'orderby'       => 'name',
	'hierarchical'      => 1,
    'hide_empty'        =>0,
	'echo'          => 0,
	'value_field' => 'slug',
	'taxonomy'           => 'business_category',
	'name' => 'business_category'
); 


?>
<form id="category-select" class="category-select replace"  action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">

		<?php $select  = wp_dropdown_categories( $args ); 
		?>
		<?php $replace = "<select$1 onchange='return this.form.submit()' class= 'replace' >"; ?>
		<?php $select  = preg_replace( '#<select([^>]*)>#', $replace, $select ); ?>
		<?php echo $select; ?>

		<noscript>
			<input type="submit" value="View" />
		</noscript>
</form>
</div><!-- business header right -->  
</div><!-- business header --> 