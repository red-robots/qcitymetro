<div class="business-header">
	
    <div class="button viewmore-short">
    <a href="<?php bloginfo('url'); ?>/church-directory/church-directory-sign-up">Add your church to this directory</a>
    </div><!-- button -->

<div class="business-header-right">

<div class="header-select">  
<h3>Search by Denomination</h3>
    <form id="category-select" class="category-select replace"  action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
		<?php $args = array(
			'show_option_none'  => 'Select Denomination',
			'show_count'        => 1,
			'hide_empty'        => 0,
			'orderby'       => 'name',
			'hierarchical'      => 1,
			'echo'          => 0,
			'value_field' => 'slug',
			'taxonomy'           => 'denomination',
			'name' => 'denomination'
		); ?>
		<?php $select  = wp_dropdown_categories( $args );
		?>
		<?php $replace = "<select$1 onchange='return this.form.submit()' class= 'replace' >"; ?>
		<?php $select  = preg_replace( '#<select([^>]*)>#', $replace, $select ); ?>
		<?php echo $select; ?>
        <noscript>
            <input type="submit" value="View" />
        </noscript>
    </form>
</div><!-- header select -->



</div><!-- business header right -->  
</div><!-- business header --> 