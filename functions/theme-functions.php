<?php
// This theme uses wp_nav_menu() in one location.

register_nav_menu( 'primary', __( 'Primary Menu', 'twentytwelve' ) );
register_nav_menu( 'sitemap', __( 'Sitemap Menu', 'twentytwelve' ) );
register_nav_menu( 'footer', __( 'Footer Menu', 'twentytwelve' ) );
	
// This theme uses a custom image size for featured images, displayed on "standard" posts.
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
add_image_size('event',150,125,array('center','center'));
add_image_size('photo',800,500,array('center','top'));
add_image_size('thirds',400,278,array('center','top'));
add_image_size('small',250,9999 );

/*-------------------------------------
	Move JetPack Share
---------------------------------------*/
function jptweak_remove_share() {
    remove_filter( 'the_content', 'sharing_display',19 );
    remove_filter( 'the_excerpt', 'sharing_display',19 );
    if ( class_exists( 'Jetpack_Likes' ) ) {
        remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
    }
}
 
add_action( 'loop_start', 'jptweak_remove_share' );
// Guest Author
/*add_filter( 'the_author', 'guest_author_name' );
add_filter( 'get_the_author_display_name', 'guest_author_name' );

function guest_author_name( $name ) {
global $post;

$author = get_field( $post->ID, 'author_name', true );

if ( $author )
$name = $author;

return $name;
}*/
/*-------------------------------------
	Custom client login, link and title.
---------------------------------------*/
function my_login_logo() { ?>
<style type="text/css">
  body.login div#login h1 a {
  	background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png);
  	background-size: 327px 67px;
  	width: 327px;
  	height: 67px;
  }
</style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

// Change Link
function loginpage_custom_link() {
	return the_permalink();
}
add_filter('login_headerurl','loginpage_custom_link');

/*-------------------------------------
	Favicon.
---------------------------------------*/
function mytheme_favicon() { 
 echo '<link rel="shortcut icon" href="' . get_bloginfo('stylesheet_directory') . '/images/favicon.ico" >'; 
} 
add_action('wp_head', 'mytheme_favicon');
// wordpress excerpt
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
// Excerpt Function
function get_excerpt($count){
  // whatever you want to append on the end of the last word
  $words = '...';
  $excerpt = get_the_excerpt();
  $excerpt = strip_tags($excerpt);
  $excerpt = wp_trim_words($excerpt, $count, $words);
  $excerpt = strip_shortcodes($excerpt);
  return $excerpt;
}
/*// Title Function
function ac_get_title($count){
  // whatever you want to append on the end of the last word
  $postId = get_the_ID();
  $words = '...';
  $title = get_the_title($postId);
  $title = strip_tags($title);
  $title = wp_trim_words($title, $count, $words);
  return $title;
}*/

// Title Function
function ac_get_title($count){
  // whatever you want to append on the end of the last word
  $postId = get_the_ID();
  $words = '...';
  $title = get_the_title($postId);
  $title = strip_tags($title);
  $title = substr($title, 0, $count);
  $title = $title . '...';
  return $title;
}

function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News';
    $submenu['edit.php'][5][0] = 'News';
    $submenu['edit.php'][10][0] = 'Add News';
    echo '';
}
function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Newss';
        $labels->singular_name = 'News';
        $labels->add_new = 'Add News';
        $labels->add_new_item = 'Add News';
        $labels->edit_item = 'Edit News';
        $labels->new_item = 'News';
        $labels->view_item = 'View News';
        $labels->search_items = 'Search News';
        $labels->not_found = 'No News found';
        $labels->not_found_in_trash = 'No News found in Trash';
    }
    add_action( 'init', 'change_post_object_label' );
    add_action( 'admin_menu', 'change_post_menu_label' );
	
	
add_filter('gettext','custom_enter_title');

function custom_enter_title( $input ) {

    global $post_type;

    if( is_admin() && 'Enter title here' == $input && 'church_listing' == $post_type )
        return 'Church Name';

    return $input;
}
add_filter( 'acf/get_valid_field', 'change_input_labels');
function change_input_labels($field) {
//$formId = $_POST['acf']['id'];
/*$formId = $_POST['acf']['id'];
echo '<pre>';
print_r($formId);
echo '</pre>';*/
if( is_page(474) ) {
	if($field['name'] == '_post_title') {
		$field['label'] = 'Church Name';
	}
//}
}

if( is_page(219) ) {
	if($field['name'] == '_post_content') {
		$field['label'] = 'Business Details';
	}
//}
}

if( is_page(37205) ) {
    if($field['name'] == '_post_content') {
        $field['label'] = 'Tell us about your business';
	    $field['instructions'] = 'What products or services do your offer? What makes your business special? No more than 150 words.';
    }
	if($field['name'] == '_post_title') {
		$field['label'] = 'Name of Business';
	}
//}
}
	//if($field['name'] == '_post_content') {
		//$field['label'] = 'Custom Content Title';
	//}
		
	return $field;
		
}
/*-------------------------------------------------------------------------------
	Custom Columns
-------------------------------------------------------------------------------*/

function my_page_columns($columns)
{
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' 	=> 'Title',
		'thumbnail'	=>	'Thumbnail',
		'event' 	=> 'Event Date',
		//'author'	=>	'Author',
		//'date'		=>	'Date',
	);
	return $columns;
}

function my_custom_columns($column)
{
	global $post;
	if($column == 'event')
	{
			$date = DateTime::createFromFormat('Ymd', get_field('event_date'));
			$startDateSubmitted = get_field('event_start_date_submitted'); 
			
			/*echo '<pre>';
			print_r($startDateSubmitted);*/
			
			if( $date != '' ) {
				echo $date->format('M/d/Y');
			}  else {
				echo 'No Date, or Pending';	
			}

	} elseif ($column == 'thumbnail'){
		
		$image = get_field('event_image');
		$imageSubmitted = get_field('event_image_submitted'); 
		
		if( $imageSubmitted != '' ) {
			$myUrl = $imageSubmitted;	
		} elseif( $image != '' ) {
			$myUrl = $image['sizes']['thumbnail'];	
		} else {
			$myUrl = '';
		}
		
		if( $myUrl != '' ) {
			echo '<img src="'. $myUrl .'" />';
		} else {
			echo 'no image with this event';	
		}
	}
}

add_action("manage_event_posts_custom_column", "my_custom_columns");
add_filter("manage_edit-event_columns", "my_page_columns");

/*-------------------------------------------------------------------------------
	Sortable Columns
-------------------------------------------------------------------------------*/

function my_column_register_sortable( $columns )
{
	$columns['event'] = 'event';
	return $columns;
}

add_filter("manage_edit-event_sortable_columns", "my_column_register_sortable" );
/*-------------------------------------------------------------------------------
	Sanatize the ACF form inputs

-------------------------------------------------------------------------------*/

// but not if admin because of Ads and Analytics
if( !is_admin() ) :
	function my_kses_post( $value ) {
		
		// is array
		if( is_array($value) ) {
		
			return array_map('my_kses_post', $value);
		
		}
		
		
		// return
		return wp_kses_post( $value );

	}

	add_filter('acf/update_value', 'my_kses_post', 10, 1);
endif;
/*-------------------------------------
	Custom WYSIWYG Styles
---------------------------------------*/
function acc_custom_styles($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_2', 'acc_custom_styles');
/*
* Callback function to filter the MCE settings
*/
 
function my_mce_before_init_insert_formats( $init_array ) {  
 
// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => 'Alternate Title',  
			'block' => 'span',  
			'classes' => 'alternate-title',
			'wrapper' => true,
			
		),
		array(  
			'title' => 'Q',  
			'inline' => 'span',  
			'classes' => 'drop-q',
			'wrapper' => true,
			
		),
		array(  
			'title' => 'Q Large',  
			'inline' => 'span',  
			'classes' => 'drop-q-large',
			'wrapper' => true,
			
		),
		array(  
			'title' => 'Q XL',  
			'inline' => 'span',  
			'classes' => 'drop-q-xl',
			'wrapper' => true,
			
		)
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' ); 
// Add styles to WYSIWYG in your theme's editor-style.css file
function my_theme_add_editor_styles() {
    add_editor_style( 'editor-style.css' );
}
add_action( 'init', 'my_theme_add_editor_styles' );


/*-------------------------------------
	Relavanssi Search for ACF Relationship field or post object
---------------------------------------*/
add_filter('relevanssi_admin_search_ok', 'rlv_acf_related_search');
function rlv_acf_related_search($search_ok) {
    if (defined("DOING_AJAX")) $search_ok = false;
    return $search_ok;
}
/*-------------------------------------
	Resonsive Images with Captions
---------------------------------------*/
function responsive_wp_caption($x = NULL, $attr, $content) {
    extract( shortcode_atts( 
        array(
         'id' => '',
         'align' => 'alignnone',
         'width' => '',
         'caption' => '',
        ), 
        $attr 
      )
    );
 
    if ( intval( $width ) < 1 || empty( $caption ) ) {
        return $content;
    }
 
    $id = $id ? ('id="' . $id . '" ') : '';
 
    $caption = '<div ' . $id . 'class="wp-caption ' . $align . '" style="max-width: ' . $width . 'px; width: 100%;">';
    $caption .= do_shortcode( $content );
    $caption .= '<div class="wp-caption-wrapper"><p class="wp-caption-text">' . $caption . '</p>';
    $caption .= '</div>';
    $caption .= '</div>';
 
    return $ret;
}
 
add_filter( 'img_caption_shortcode', 'responsive_wp_caption', 10, 3 );

/*-------------------------------------
	Jetpack Facebook Fallback Share Image
---------------------------------------*/
// function jeherve_custom_image( $media, $post_id, $args ) {
// 	global $post;
// 	if( has_term( 'standard', 'event_category', $post->ID) ) {
//     if ( $media ) {
//         return $media;
//     } else {
//         $permalink = get_permalink( $post_id );
//         // $imageUrl = get_bloginfo('template_url'). '/images/logo.png';
//         $url = apply_filters( 'jetpack_photon_url', 'http://qcitymetro.com/wp-content/themes/qcity/images/fb-share.png' );
     
//         return array( array(
//             'type'  => 'image',
//             'from'  => 'custom_fallback',
//             'src'   => esc_url( $url ),
//             'href'  => $permalink,
//         ) );
//     }
// }
// }
// add_filter( 'jetpack_images_get_images', 'jeherve_custom_image', 10, 3 );

/*-------------------------------------

	Filters the Plugin, "WordPress Popular Posts"

	Takes ACF field 'post_expire' won't show posts past their expire date.

---------------------------------------*/
add_filter('wpp_query_posts','my_date_checker');
function my_date_checker($result){
	$return = array();
		$max = count($result);
		$count = 0;
		for($i=0;$i<$max;$i++):
			$today = intval(date('Ymd'));
			$postDate = intval(get_field('post_expire', $result[$i]->id ));
			if($postDate > $today || $postDate == '' ){
				$return[] = $result[$i];
				$count++;
				if($count===4)break;
			} else continue;
		endfor;
	return $return; 
}


/**
 * Save ACF image field to post Featured Image
 * @uses Advanced Custom Fields Pro
 */
add_action( 'acf/save_post', 'tsm_save_image_field_to_featured_image', 10 );
function tsm_save_image_field_to_featured_image( $post_id ) {
 
    // Bail if not logged in or not able to post
    // if ( ! ( is_user_logged_in() || current_user_can('publish_posts') ) ) {
    //     return;
    // }
 
    // Bail early if no ACF data
    if( empty($_POST['acf']) ) {
        return;
    }
 
    // ACF image field key
    $image = $_POST['acf']['field_55e5f132f7189'];
 
    // Bail if image field is empty
    if ( empty($image) ) {
        return;
    }
 
    // Add the value which is the image ID to the _thumbnail_id meta data for the current post
    add_post_meta( $post_id, '_thumbnail_id', $image );
 
}

//adding post format support
add_theme_support( 'post-formats', array( 'video' ) );

function bella_signup_embed( $atts ) {
	$header_text = get_field("email_signup_header",21613);
	$copy = get_field("email_signup_copy",21613);
	$button_text = get_field("email_signup_button_text",21613);
	$link = get_the_permalink( 21613);
	return '<div class="signup-embed">
		<div class="col-2">
			<a href="'.$link.'">'.$button_text.'</a>
		</div>
		<div class="col-1">
			<div class="title">'.$header_text.'</div>
			<div class="copy">'.$copy.'</div>
		</div>
		<div class="clear"></div>
	</div><!--.signup-embed-->';
}
add_shortcode( 'signup-embed', 'bella_signup_embed' );

function bella_video_title($title, $id){
	if($id){
		if(has_post_format( 'video', $id)){
			$title .= '&nbsp;<i class="fa fa-play-circle-o"></i>';
		}
	}
	return $title;
}
add_filter( 'the_title', 'bella_video_title', 10, 2 );


/* from https://code.tutsplus.com/tutorials/guide-to-creating-your-own-wordpress-editor-buttons--wp-30182 */
add_action( 'init', 'bella_buttons' );
function bella_buttons() {
    add_filter( "mce_external_plugins", "bella_add_buttons" );
    add_filter( 'mce_buttons', 'bella_register_buttons' );
}
function bella_add_buttons( $plugin_array ) {
    $plugin_array['bella'] = get_template_directory_uri() . '/js/bella-tinymce-plugin.js.php';
    return $plugin_array;
}
function bella_register_buttons( $buttons ) {
    array_push( $buttons, 'signup' ); // dropcap', 'recentposts
    array_push( $buttons, 'bella_slider' ); 
    return $buttons;
}
add_action('admin_head','bella_hide_publish_events');
function bella_hide_publish_events(){
	global $post;
	if(strcmp(get_post_type($post),"event")===0){
		add_filter( 'publicize_checkbox_default',  '__return_false'  );
	}
}