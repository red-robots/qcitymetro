<?php
 /**
 * Bring in some Custom Functions
 */
// Enqueues Custom Theme Scripts
require( get_template_directory() . '/functions/theme-setup.php' );

// Enqueues Custom Theme Scripts
require( get_template_directory() . '/functions/scripts.php' );

// Custom Post Types
require( get_template_directory() . '/functions/post-types.php' );

// Custom Theme Functions
require( get_template_directory() . '/functions/theme-functions.php' );

// Social Media Links function
//	To use in template => acc_social_links();
require( get_template_directory() . '/functions/social-media-links.php' );

// Pagination
//	pagi_posts_nav();
require( get_template_directory() . '/functions/pagination.php' );