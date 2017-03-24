<script>
    $(function(){
      // bind change event to select
      $('#denomination').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
	
	 $(function(){
      // bind change event to select
      $('#size').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
</script>
<div class="business-header">
	
    <div class="button viewmore-short">
    <a href="<?php bloginfo('url'); ?>/church-directory/church-directory-sign-up">Add your church to this directory</a>
    </div><!-- button -->

<div class="business-header-right">

<div class="header-select">  
<h3>Search by Denomination</h3> 
<?php 
$url = get_bloginfo('url');
$cDir = $url . '/church-directory';
//echo $url;

$denomargs = array(
    'orderby'           => 'name', 
    'order'             => 'ASC',
    'hide_empty'        => true, 
    'fields'            => 'all', 
); 

$dterms = get_terms('denomination', $denomargs);

?>
<form id="category-select" class="category-select"  action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">

        <select name='denomination' id='denomination'  >
        	<?php 
			echo '<option class="">Select a Denomination</option>';
			echo '<option class="" value="' . $cDir . '">All</option>';
			foreach( $dterms as $dterm ) :
				echo '<option class="level-0" value="'.$url.'/denomination/'.$dterm->slug.'">'.$dterm->name.'</option>';
			endforeach;
			
			?>
        </select>

		<noscript>
			<input type="submit" value="View" />
		</noscript>
</form>
</div><!-- header select -->

<div class="header-select">
<h3>Search by Size</h3>  
<?php 

$sizeargs = array(
    'orderby'           => 'name', 
    'order'             => 'ASC',
    'hide_empty'        => true, 
    'fields'            => 'all', 
); 

$sterms = get_terms('size', $sizeargs);
?>
<form id="category-select" class="category-select"  action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">

        <select name='size' id='size'  >
        	<?php 
			echo '<option class="">Select a Size</option>';
			echo '<option class="" value="' . $cDir . '">All</option>';
			foreach( $sterms as $sterm ) :
				echo '<option class="level-0" value="'.$url.'/size/'.$sterm->slug.'">'.$sterm->name.'</option>';
			endforeach;
			
			?>
        </select>

		<noscript>
			<input type="submit" value="View" />
		</noscript>
</form>
</div><!-- header select -->

</div><!-- business header right -->  
</div><!-- business header --> 