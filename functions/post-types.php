<?php 
/* Custom Post Types */

add_action('init', 'js_custom_init');
function js_custom_init() 
{
	
	// Register the Homepage Slides
  
     $labels = array(
	'name' => _x('Events', 'post type general name'),
    'singular_name' => _x('Event', 'post type singular name'),
    'add_new' => _x('Add New', 'Event'),
    'add_new_item' => __('Add New Event'),
    'edit_item' => __('Edit Event'),
    'new_item' => __('New Event'),
    'view_item' => __('View Event'),
    'search_items' => __('Search Events'),
    'not_found' =>  __('No Events found'),
    'not_found_in_trash' => __('No Events found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Events'
  );
  $args = array(
	'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => false, 
    'hierarchical' => false, // 'false' acts like posts 'true' acts like pages
    'menu_position' => 20,
    'supports' => array('title','editor','custom-fields','publicize','thumbnail'),
	
  ); 
  register_post_type('event',$args); // name used in query
  
  
  	// Register the Business Listings
  
     $labels = array(
	'name' => _x('Business Listings', 'post type general name'),
    'singular_name' => _x('Business Listing', 'post type singular name'),
    'add_new' => _x('Add New', 'Listing'),
    'add_new_item' => __('Add New Listing'),
    'edit_item' => __('Edit Listing'),
    'new_item' => __('New Listing'),
    'view_item' => __('View Listing'),
    'search_items' => __('Search Listings'),
    'not_found' =>  __('No Listings found'),
    'not_found_in_trash' => __('No Listings found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Business Listings'
  );
  $args = array(
	'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'business-listing'),
    'capability_type' => 'post',
    'has_archive' => false, 
    'hierarchical' => false, // 'false' acts like posts 'true' acts like pages
    'menu_position' => 20,
    'supports' => array('title','editor','custom-fields','publicize','thumbnail'),
	
  ); 
  register_post_type('business_listing',$args); // name used in query
  
  
    	// Register the Church
  
     $labels = array(
	'name' => _x('Church Listings', 'post type general name'),
    'singular_name' => _x('Church Listing', 'post type singular name'),
    'add_new' => _x('Add New', 'Listing'),
    'add_new_item' => __('Add New Listing'),
    'edit_item' => __('Edit Listing'),
    'new_item' => __('New Listing'),
    'view_item' => __('View Listing'),
    'search_items' => __('Search Listings'),
    'not_found' =>  __('No Listings found'),
    'not_found_in_trash' => __('No Listings found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Church Listings'
  );
  $args = array(
	'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'church-listing'),
    'capability_type' => 'post',
    'has_archive' => false, 
    'hierarchical' => false, // 'false' acts like posts 'true' acts like pages
    'menu_position' => 20,
    'supports' => array('title','editor','custom-fields','thumbnail'),
	
  ); 
  register_post_type('church_listing',$args); // name used in query
  
    	// Register the Homepage Slides
  
     $labels = array(
	'name' => _x('Gallery', 'post type general name'),
    'singular_name' => _x('Gallery', 'post type singular name'),
    'add_new' => _x('Add New', 'Gallery'),
    'add_new_item' => __('Add New Gallery'),
    'edit_item' => __('Edit Gallery'),
    'new_item' => __('New Gallery'),
    'view_item' => __('View Gallery'),
    'search_items' => __('Search Gallery'),
    'not_found' =>  __('No Gallery found'),
    'not_found_in_trash' => __('No Gallery found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Photo Galleries'
  );
  $args = array(
	'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => false, 
    'hierarchical' => false, // 'false' acts like posts 'true' acts like pages
    'menu_position' => 20,
    'supports' => array('title','editor','custom-fields','publicize','thumbnail'),
	
  ); 
  register_post_type('gallery',$args); // name used in query
  	// Register the Homepage Slides
  
     $labels = array(
	'name' => _x('Ads', 'post type general name'),
    'singular_name' => _x('Ad', 'post type singular name'),
    'add_new' => _x('Add New', 'Ad'),
    'add_new_item' => __('Add New Ad'),
    'edit_item' => __('Edit Ad'),
    'new_item' => __('New Ad'),
    'view_item' => __('View Ads'),
    'search_items' => __('Search Ads'),
    'not_found' =>  __('No Ads found'),
    'not_found_in_trash' => __('No Ads found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Ads'
  );
  $args = array(
	'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => false, 
    'hierarchical' => false, // 'false' acts like posts 'true' acts like pages
    'menu_position' => 20,
    'supports' => array('title','editor','custom-fields','thumbnail'),
	
  ); 
  register_post_type('ad',$args); // name used in query
  
  $labels = array(
	'name' => _x('Sponsors', 'post type general name'),
    'singular_name' => _x('Sponsor', 'post type singular name'),
    'add_new' => _x('Add New', 'Sponsor'),
    'add_new_item' => __('Add New Sponsor'),
    'edit_item' => __('Edit Sponsor'),
    'new_item' => __('New Sponsor'),
    'view_item' => __('View Sponsors'),
    'search_items' => __('Search Sponsors'),
    'not_found' =>  __('No Sponsors found'),
    'not_found_in_trash' => __('No Sponsors found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Sponsors'
  );
  $args = array(
	'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => false, 
    'hierarchical' => false, // 'false' acts like posts 'true' acts like pages
    'menu_position' => 20,
    'supports' => array('title','editor','custom-fields','thumbnail'),
	
  ); 
  register_post_type('sponsor',$args); // name used in query
  // Add more between here
  
  // and here
  
  } // close custom post type
  

/*
##############################################
	Custom Taxonomies
*/
add_action( 'init', 'build_taxonomies', 0 );
 
function build_taxonomies() {
    register_taxonomy( 'sponsor_category', 'sponsor',
	 array( 
	'hierarchical' => true, // true = acts like categories false = acts like tags
	'label' => 'Sponsor Type', 
	'query_var' => true, 
	'rewrite' => true ,
	'show_admin_column' => true,
	'public' => true,
	'rewrite' => array( 'slug' => 'sponsor-type' ),
	'_builtin' => true
	) );

// cusotm tax
    register_taxonomy( 'event_category', 'event',
	 array( 
	'hierarchical' => true, // true = acts like categories false = acts like tags
	'label' => 'Event Type', 
	'query_var' => true, 
	'rewrite' => true ,
	'show_admin_column' => true,
	'public' => true,
	'rewrite' => array( 'slug' => 'event-type', 'with_front' => false ),
	'_builtin' => true
	) );
	
	register_taxonomy( 'event_cat', 'event',
	 array( 
	'hierarchical' => true, // true = acts like categories false = acts like tags
	'label' => 'Event Category', 
	'query_var' => true, 
	'rewrite' => true ,
	'show_admin_column' => true,
	'public' => true,
	'rewrite' => array( 'slug' => 'event-category', 'with_front' => false ),
	'_builtin' => true
	) );
	
	register_taxonomy( 'business_category', 'business_listing',
	 array( 
	'hierarchical' => true, // true = acts like categories false = acts like tags
	'label' => 'Business Type', 
	'query_var' => true, 
	'rewrite' => true ,
	'show_admin_column' => true,
	'public' => true,
	'rewrite' => array( 'slug' => 'business-category' ),
	'_builtin' => true
	) );
	
	
	register_taxonomy( 'denomination', 'church_listing',
	 array( 
	'hierarchical' => true, // true = acts like categories false = acts like tags
	'label' => 'Denomination', 
	'query_var' => true, 
	'rewrite' => true ,
	'show_admin_column' => true,
	'public' => true,
	'rewrite' => array( 'slug' => 'denomination' ),
	'_builtin' => true
	) );
	
	register_taxonomy( 'size', 'church_listing',
	 array( 
	'hierarchical' => true, // true = acts like categories false = acts like tags
	'label' => 'Size', 
	'query_var' => true, 
	'rewrite' => true ,
	'show_admin_column' => true,
	'public' => true,
	'rewrite' => array( 'slug' => 'size' ),
	'_builtin' => true
	) );
	
} // End build taxonomies