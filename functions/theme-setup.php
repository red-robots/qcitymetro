<?php 
// setup theme
function twentytwelve_setup() {

// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	//add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );
	
	
}
add_action( 'after_setup_theme', 'twentytwelve_setup' );
// OPtions page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}
/**
 * Return the Google font stylesheet URL if available.
 *
 * The use of Open Sans by default is localized. For languages that use
 * characters not supported by the font, the font can be disabled.
 */
function twentytwelve_get_font_url() {
	$font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Open Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'twentytwelve' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language,
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'twentytwelve' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		$font_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles for front-end.
 */
function twentytwelve_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Adds JavaScript for handling the navigation menu hide-and-show behavior.
	wp_enqueue_script( 'twentytwelve-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );

	$font_url = twentytwelve_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'twentytwelve-fonts', esc_url_raw( $font_url ), array(), null );

	// Loads our main stylesheet.
	wp_enqueue_style( 'twentytwelve-style', get_stylesheet_uri() , array(), "3456");
	
	// Loads the Flexslider
	wp_enqueue_style( 'twentytwelve-flex', get_template_directory_uri() . '/css/flexslider.css', array( 'twentytwelve-style' ), '20121010' );


// Loads the Colorbox
	wp_enqueue_style( 'twentytwelve-color', get_template_directory_uri() . '/css/colorbox.css', array( 'twentytwelve-style' ), '20121010' );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentytwelve-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentytwelve-style' ), '20121010' );
	$wp_styles->add_data( 'twentytwelve-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'twentytwelve_scripts_styles' );

/**
 * Filter TinyMCE CSS path to include Google Fonts.

 */
function twentytwelve_mce_css( $mce_css ) {
	$font_url = twentytwelve_get_font_url();

	if ( empty( $font_url ) )
		return $mce_css;

	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $font_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'twentytwelve_mce_css' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 */
function twentytwelve_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link
 */
function twentytwelve_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );

/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 
 */
function twentytwelve_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'twentytwelve' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentytwelve_widgets_init' );

if ( ! function_exists( 'twentytwelve_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 
 */
function twentytwelve_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentytwelve' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;

if ( ! function_exists( 'twentytwelve_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentytwelve_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.

 */
function twentytwelve_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwelve' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'twentytwelve' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'twentytwelve' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'twentytwelve_entry_meta' ) ) :
/**
 * Set up post entry meta.
 *
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *

 */
function twentytwelve_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'twentytwelve' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'twentytwelve' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;


/**
 * Register postMessage support.
 *
 * Add postMessage support for site title and description for the Customizer.
 
 */
function twentytwelve_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'twentytwelve_customize_register' );

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 */
function twentytwelve_customize_preview_js() {
	wp_enqueue_script( 'twentytwelve-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130301', true );
}
add_action( 'customize_preview_init', 'twentytwelve_customize_preview_js' );

add_action( 'wp_ajax_bella_get_jobs_count', 'bella_ajax_get_jobs_count' );
add_action( 'wp_ajax_nopriv_bella_get_jobs_count', 'bella_ajax_get_jobs_count' );
function bella_ajax_get_jobs_count() {
	$today = date('Ymd');
	$args = array(
		'post_type'=>'job',
		'posts_per_page'=>-1,
		'post_status'=>'publish',
		'meta_query' => array(
			'relation' => 'OR',
			array(
				'key' => 'post_expire',
				'value' => $today,
				'compare' => '>'
			),
			array(
				'key' => 'post_expire',
				'value' => '',
				'compare' => '='
			),
			array(
				'key' => 'post_expire',
				'compare' => 'NOT EXISTS'
			),
		)
	);
	$query = new WP_Query($args);
	$response    = array(
		'what'   => 'count',
		'action' => 'bella_get_jobs_count',
		'data'   => $query->post_count,
	);
	$xmlResponse = new WP_Ajax_Response( $response );
	$xmlResponse->send();
	die( 0 );
}

add_action( 'wp_ajax_bella_get_events_count', 'bella_ajax_get_events_count' );
add_action( 'wp_ajax_nopriv_bella_get_events_count', 'bella_ajax_get_events_count' );
function bella_ajax_get_events_count() {
	global $wpdb;

	$today = date('Ymd');
	$prepare_string = "SELECT DISTINCT ID FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id ) LEFT JOIN $wpdb->postmeta AS mt1 ON ( $wpdb->posts.ID = mt1.post_id ) WHERE ( ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value >= %d ) OR ( ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value < %d ) AND ( mt1.meta_key = 'end_date' AND mt1.meta_value >= %d ) ) OR ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value = '' ) )";

	$prepare_args = array();
	array_unshift($prepare_args,$today);
	array_unshift($prepare_args,$today);
	array_unshift($prepare_args,$today);
	array_unshift($prepare_args,$prepare_string);
	$results = $wpdb->get_results( call_user_func_array(array($wpdb, "prepare"),$prepare_args) );
	$count = 0;
	if($results):
		$count = count($results);
	endif;
	$response    = array(
		'what'   => 'count',
		'action' => 'bella_get_events_count',
		'data'   => $count,
	);
	$xmlResponse = new WP_Ajax_Response( $response );
	$xmlResponse->send();
	die( 0 );
}

function bella_acf_save_post( $post_id )
{
	$direct = get_field("application_direct", $post_id);
	$email = get_field("application_email", $post_id);
	if((!empty($direct)||!empty($email))&&!is_admin()):
		wp_redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=RTGB4KW6XD2GN'); 
		exit;
	endif;
}
add_action('acf/save_post', 'bella_acf_save_post', 100,1);

//More posts - first for logged in users, other for not logged in
add_action('wp_ajax_bella_ajax_next_event', 'bella_ajax_next_event');
add_action('wp_ajax_nopriv_bella_ajax_next_event', 'bella_ajax_next_event');

function bella_ajax_next_event() {

	global $wpdb;
	//Build query
	
    $today = date('Ymd');
	$future = null;
	if(isset($_GET['date'])&&!empty($_GET['date'])):
		$add = null;
		if(strcmp($_GET['date'],'today')==0):
			$add = 'P1D';
		elseif(strcmp($_GET['date'],'week')==0):
			$add = 'P7D';
		elseif(strcmp($_GET['date'],'month')==0):
			$add = 'P1M';
		elseif(strcmp($_GET['date'],'year')==0):
			$add = 'P1Y';
		endif;
		if($add!==null):
			$enddate = new DateTime('NOW');
			$enddate->add(new DateInterval($add));
			$future = $enddate->format('Ymd');
		endif;//if add not null
	endif;//if for date set
	
	$args = array(
		'post_type'=>'event',
		'posts_per_page' => 6,
		'orderby'=>'meta_value',
		'meta_key'=>'event_date',
		'order'=>'ASC'
	);
    if( ! empty( $_GET['post_offset'] ) ) {
		$args['offset'] = $_GET['post_offset'];
	}
	$post__in = array();
	if($future!==null):
		//old queries for reference (didn't work generated from wordpress)

		//LEFT JOIN qcqcq_postmeta ON ( qcqcq_posts.ID = qcqcq_postmeta.post_id ) LEFT JOIN qcqcq_postmeta AS mt1 ON ( qcqcq_posts.ID = mt1.post_id ) LEFT JOIN qcqcq_postmeta AS mt2 ON ( qcqcq_posts.ID = mt2.post_id ) LEFT JOIN qcqcq_postmeta AS mt3 ON ( qcqcq_posts.ID = mt3.post_id ) LEFT JOIN qcqcq_postmeta AS mt4 ON (qcqcq_posts.ID = mt4.post_id AND mt4.meta_key = 'event_date' ) LEFT JOIN qcqcq_postmeta AS mt5 ON ( qcqcq_posts.ID = mt5.post_id )

		//AND ( ( ( qcqcq_postmeta.meta_key = 'event_date' AND qcqcq_postmeta.meta_value >= '20180419' ) AND ( mt1.meta_key = 'event_date' AND mt1.meta_value < '20180420' ) ) OR ( ( mt2.meta_key = 'event_date' AND mt2.meta_value < '20180419' ) AND ( mt3.meta_key = 'end_date' AND mt3.meta_value >= '20180420' ) ) OR mt4.post_id IS NULL OR ( mt5.meta_key = 'event_date' AND mt5.meta_value = '' ) )

		$prepare_string = "SELECT DISTINCT ID FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id ) LEFT JOIN $wpdb->postmeta AS mt1 ON ( $wpdb->posts.ID = mt1.post_id ) WHERE ( ( ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value >= %d ) AND ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value < %d ) ) OR ( ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value < %d ) AND ( mt1.meta_key = 'end_date' AND mt1.meta_value >= %d ) ) )";
		
		$prepare_args = array();
		array_unshift($prepare_args,$future);
		array_unshift($prepare_args,$today);
		array_unshift($prepare_args,$future);
		array_unshift($prepare_args,$today);
		array_unshift($prepare_args,$prepare_string);
		$results = $wpdb->get_results( call_user_func_array(array($wpdb, "prepare"),$prepare_args) );
		if($results):
			foreach($results as $result):
				$post__in[] = $result->ID;
			endforeach;
		else:
			$post__in[] = -1;
		endif;
	else: 
		//old queries for reference (generated from wordpress, worked, but bad)

		//LEFT JOIN qcqcq_postmeta ON ( qcqcq_posts.ID = qcqcq_postmeta.post_id ) LEFT JOIN qcqcq_postmeta AS mt1 ON (qcqcq_posts.ID = mt1.post_id AND mt1.meta_key = 'event_date' )
		//AND ( ( qcqcq_postmeta.meta_key = 'event_date' AND qcqcq_postmeta.meta_value >= '20180419' ) OR mt1.post_id IS NULL OR ( qcqcq_postmeta.meta_key = 'event_date' AND qcqcq_postmeta.meta_value = '' ) )*/
		
		//$prepare_string = "SELECT DISTINCT ID FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id ) WHERE ( ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value >= %d ) OR ($wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value = '' ) )";
		
		$prepare_string = "SELECT DISTINCT ID FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id ) LEFT JOIN $wpdb->postmeta AS mt1 ON ( $wpdb->posts.ID = mt1.post_id ) WHERE ( ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value >= %d ) OR ( ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value < %d ) AND ( mt1.meta_key = 'end_date' AND mt1.meta_value >= %d ) ) OR ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value = '' ) )";
			
		$prepare_args = array();
		array_unshift($prepare_args,$today);
		array_unshift($prepare_args,$today);
		array_unshift($prepare_args,$today);
		array_unshift($prepare_args,$prepare_string);
		$results = $wpdb->get_results( call_user_func_array(array($wpdb, "prepare"),$prepare_args) );
		if($results):
			foreach($results as $result):
				$post__in[] = $result->ID;
			endforeach;
		else:
			$post__in[] = -1;
		endif;
	endif;
	$temp__in = array();
	if(isset($_GET['search'])&&!empty($_GET['search'])):
		$prepare_string = "SELECT ID FROM $wpdb->posts WHERE post_title LIKE '%%%s%%' AND post_type = 'event' ";
		$prepare_string .= "UNION SELECT object_id FROM $wpdb->term_relationships as r INNER JOIN $wpdb->terms as t ON t.term_id = r.term_taxonomy_id WHERE t.name LIKE '%%%s%%'";
		$prepare_args[] = $_GET['search'];
		array_unshift($prepare_args,$_GET['search']);
		array_unshift($prepare_args,$prepare_string);
		$results = $wpdb->get_results(  call_user_func_array(array($wpdb, "prepare"),$prepare_args));
		if($results):
			foreach($results as $result):
				if(in_array($result->ID,$post__in)):
					$temp__in[] = $result->ID;
				endif;
			endforeach;
		else: 
			$temp__in[] = -1;
		endif;
	endif;
	if(!empty($temp__in)):
		$post__in = $temp__in;
	endif;
	if(isset($_GET['category'])&&!empty($_GET['category'])):
		$args['meta_query'] = array(
			'key'     => 'category',
			'value'   => '"'.$_GET['category'].'"',
			'compare' => 'LIKE'
		);
	endif;
	$args['post__in']= $post__in;

    $count_results = '0';

    $query_results = new WP_Query( $args );

    //Results found
    if ( $query_results->have_posts() ) {

        $count_results = $query_results->post_count;

        //Start "saving" results' HTML
        $results_html = '';
		ob_start();
		
		$i=0;
        while ( $query_results->have_posts() ) { 
			$query_results->the_post();
			
			$date = get_field("event_date");
			$display_date = null;
			if($date):
				$display_date = (new DateTime($date))->format('l, F j, Y');
			endif;
			$venue = get_field("name_of_venue");
			$image = get_field("event_image");
			$terms = wp_get_post_terms( get_the_ID(), 'event_cat' );?>
			<div class="tile blocks <?php if($i%3==0) echo "first";?> <?php if(($i+1)%3==0) echo "last";?>">
				<div class="inner-wrapper">
					<?php $culture_block = get_field("culture_block");
					if(strcmp($culture_block,'yes')==0):?>
						<div class="culture">
							<div class="circle">
								?
							</div><!--.circle-->
							<a href="https://www.artsandscience.org/programs/for-community/culture-blocks/asc-culture-blocks-upcoming-events/" target="_blank">
								<img src="<?php echo get_template_directory_uri()."/images/culture-blocks-title.jpg";?>" alt="Culture Blocks">
							</a>
							<?php $desc = get_field("culture_block_rollover",54);
							if($desc):?>
								<div class="rollover">
									<?php echo $desc;?>	
								</div><!--.rollover-->
							<?php endif;?>
						</div><!--.culture-->
					<?php endif;?>
					<a href="<?php echo get_permalink();?>">
						<div class="row-1">
							<?php if($image):?>
								<img src="<?php echo $image['sizes']['medium'];?>" alt="<?php echo $image['alt'];?>">
							<?php endif;?>
							<h2><?php the_title();?></h2>
							<?php if($display_date):?>
								<div class="date">
									<?php echo $display_date;?>
								</div><!--.date-->
							<?php endif;
							if($venue):?>
								<div class="venue">
									<?php echo $venue;?>
								</div><!--.venue-->
							<?php endif;?>
						</div><!--.row-1-->
						<div class="row-2">
							<div class="col-1">
								<!--<i class="fa fa-share-alt"></i>-->
							</div><!--.col-1-->
							<?php if(!is_wp_error($terms) && is_array($terms)&&!empty($terms)):?>
								<div class="col-2">
									<?php echo $terms[0]->name;?> 
								</div><!--.col-2-->
							<?php endif;?>
						</div><!--.row-2-->
					</a>
				</div><!--.inner-wrapper-->
			</div>
		<?php $i++;
		}    
        //"Save" results' HTML as variable
        $results_html = ob_get_clean();  
    }

    //Build ajax response
    $response = array();

    //1. value is HTML of new posts and 2. is total count of posts
    array_push ( $response, $results_html, $count_results );
    echo json_encode( $response );

    //Always use die() in the end of ajax functions
    die();  
}