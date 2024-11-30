<?php
automatic_feed_links();

//Add support for post thumbnails
   add_theme_support( 'post-thumbnails' );
   set_post_thumbnail_size( 50, 50, true );
   add_image_size( 'single-post-thumbnail', 425, 280 );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'parallax_enqueue_scripts_styles', 1000 );
function parallax_enqueue_scripts_styles() {
	// Styles
	wp_enqueue_style( 'icomoon-fonts', get_stylesheet_directory_uri() . '/icomoon.css', array() );
	wp_enqueue_style( 'googlefonts', '//fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap', array() );
	
}
   
   
// Register Custom WP Nav.
	register_nav_menus( array(
		'primary' => 'Primary Navigation',
		'footer' => 'Footer Navigation'
	) );

   
//Register Widgets


if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Sidebar-Right',
		'id' => 'sidebar-right',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	));
}


if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Sidebar-Resources',
		'id' => 'sidebar-resources',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	));
}

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Header-Top',
		'id' => 'header-top',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
}

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Header-Bottom',
		'id' => 'header-bottom',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
}

// Content trimmer
function trimmed_content($limit) {
	$content = explode(' ', get_the_content(), $limit);
	if (count($content)>=$limit) {
		array_pop($content);
		$content = implode(" ",$content).'...';
	} else {
		$content = implode(" ",$content);
	}	
	$content = preg_replace('/\[.+\]/','', $content);
	$content = apply_filters('the_content', $content); 
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}

// Custom excerpt length
function the_excerpt_custom_length($charlength) {
	global $post;
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );

		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '...';
	} else { 
		echo $excerpt;
	}
}

//add_filter( 'the_excerpt', 'excerpt_protected' );

function excerpt_protected( $content ) {
	if ( post_password_required() )
		$content = get_the_excerpt($post->ID) .'test';

	return $content;
}


// Changing excerpt more
   function new_excerpt_more($more) {
   global $post;
   return '... <div class="read-more"><a class="read-more" href="'. get_permalink($post->ID) . '">' . 'Read More»' . '</a></div>';
   }
   add_filter('excerpt_more', 'new_excerpt_more');





// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	
// Custom Protected Page Message	
	add_filter( 'the_password_form', 'custom_password_form' );
function custom_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$o = '<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
	
' . __( "<p>This resource has been reserved for Brinson Benefits clients.  If you are a client, please enter your password below.</p>" ) . '
	<label for="' . $label . '">' . __( "<b>Password:</b>" ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" /><input type="submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" />
	</form> <p style="margin-top:20px;">If you are a client and have forgotten your password or need a new one or if you are not a client and would like to request access to this resource, please complete a <a href="/resources/access-request-form/">Resource Access Request Form</a></p>

	';
	return $o;
}

function the_title_trim($title)
{
$pattern[0] = '/Protected: /';
$pattern[1] = '/Private: /';
$replacement[0] = ''; // Enter some text to put in place of Protected:
$replacement[1] = ''; // Enter some text to put in place of Private:

return preg_replace($pattern, $replacement, $title);
}
add_filter('the_title', 'the_title_trim');

	
add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'slider',
    array(
      'labels' => array(
        'name' => __( 'Slider' ),
        'singular_name' => __( 'Slide' ),
		'add_new' => _x('Add New', 'slider'),
		'add_new_item' => __('Add New Slide'),
		'edit_item' => __('Edit Slide'),
		'new_item' => __('New Slide'),
		'view_item' => __('View Slide'),
		'search_items' => __('Search Slides'),
		'not_found' =>  __('No slides found'),
		'not_found_in_trash' => __('No slides found in Trash'), 
		'menu_name' => 'Slider'

      ),
      'public' => true,
	  'capability_type' => 'page',
	  'hierarchical' => true,
	  'supports' => array(
		'title',
		'editor',
		'custom-fields',
		'revisions',
		'thumbnail',
		'page-attributes',)
    )
  );

  register_post_type( 'testimonial',
    array(
      'labels' => array(
        'name' => __( 'Testimonials' ),
        'singular_name' => __( 'Testimonial' ),
        'rewrite' => array('slug' => 'testimonial'),
      ),
      'public' => true,
    )
  );
}


define('EMPTY_TRASH_DAYS', 5 );
	
	function enable_more_buttons($buttons) {
  $buttons[] = 'hr';
 
 
  return $buttons;
}
add_filter("mce_buttons_2", "enable_more_buttons");

		
add_filter('user_contactmethods','hide_profile_fields',10,1);

function hide_profile_fields( $contactmethods ) {
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
  return $contactmethods;
}

/*
 * Remove senseless dashboard widgets for non-admins. (Un)Comment or delete as you wish.
 */
function remove_dashboard_widgets() {
	global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); // Plugins widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // WordPress Blog widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); // Other WordPress News widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // Right Now widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // Quick Press widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // Incoming Links widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); // Recent Drafts widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // Recent Comments widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['w3tc_latest']); // w3tc widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['blc_dashboard_widget']); // broken link checker widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']); // yoast checker widget
	
}
if (!current_user_can('manage_options')) {
	add_action('wp_dashboard_setup', 'remove_dashboard_widgets', 20 );
} 

/**
 * Remove meta boxes from Post and Page Screens
 */
function customize_meta_boxes() {
  /* These remove meta boxes from POSTS */
  remove_meta_box('postcustom','post','normal'); // Hide Custom Fields
  remove_meta_box('trackbacksdiv','post','normal'); // Hide Trackbacks Box
  remove_meta_box('commentstatusdiv','post','normal'); // Hide Discussions Box
  remove_meta_box('commentsdiv','post','normal'); // Hide Comments Box
  remove_meta_box('tagsdiv-post_tag','post','normal'); // Hide Post Tags Box
  remove_meta_box('postexcerpt','post','normal'); // Hide Excerpt Box
  //remove_meta_box('categorydiv','post','normal'); // Hide Category Box
  remove_meta_box('authordiv','post','normal'); // Hide Author Box
  //remove_meta_box('revisionsdiv','post','normal'); // Hide Revisions Box
  //remove_meta_box(' postimagediv','post','normal'); // Hide Featured Image
  
  /* These remove meta boxes from PAGES */
  remove_meta_box('postcustom','page','normal');  // Hide Custom Fields Box
  remove_meta_box('trackbacksdiv','page','normal'); // Hide Trackbacks Box
  remove_meta_box('commentstatusdiv','page','normal'); // Hide Discussion Box
  remove_meta_box('commentsdiv','page','normal'); // Hide Comments Box
  remove_meta_box('authordiv','page','normal'); // Hide Authors Box
  //remove_meta_box('revisionsdiv','page','normal'); // Hide Revisions Box
  remove_meta_box('postaiosp','page','normal'); // Hide All in one SEO
  remove_meta_box('aiosp','page','normal'); // Hide All in one SEO
 //remove_meta_box(' postimagediv','page','normal'); // Hide Featured Image
   remove_meta_box('postexcerpt','page','normal'); // Hide Excerpt Box


}

if (!current_user_can('manage_options')) {
	add_action('admin_init','customize_meta_boxes');
} 

/**
 * Remove code from the <head>
 */
remove_action('wp_head', 'rsd_link'); // Might be necessary if you or other people on this site use remote editors.
remove_action('wp_head', 'wp_generator'); // Hide the version of WordPress you're running
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'index_rel_link'); // Displays relations link for site index
remove_action('wp_head', 'wlwmanifest_link'); // Might be necessary if you or other people on this site use Windows Live Writer.
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_filter( 'the_content', 'capital_P_dangit' ); // Get outta my Wordpress codez dangit!
remove_filter( 'the_title', 'capital_P_dangit' );
remove_filter( 'comment_text', 'capital_P_dangit' );

//This function removes the comment inline css
function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}

function hide_menus() {
global $post;
if (!current_user_can('manage_options')) { 
	echo '<style type="text/css">';
	echo '#yoast_db_widget {display:none;} #descriptiondiv{display:none;} #linkcategorydiv{display:none;} #linktargetdiv{display:none;} #linkxfndiv{display:none;} #linkadvanceddiv{display:none;}';
	echo '.menu-icon-tools {display:none;} .menu-icon-comments{display:none;}';
	echo '#wpseo_meta{display:none;} #revisionsdiv {display:block !important;} #dvk_db_widget{display:block !important;} #postcustom{display:none;}, #acx_plugin_dashboard_widget{display:none;} #pb_backupbuddy{display:none;} .menu-icon-settings{display:none;} .menu-icon-appearance{display:none;}#cpt_info_box{display:none;} #cart66_feature_level_meta{display:none;} .menu-icon-links{display:none;} .toplevel_page_wp-pagenavi-style/.wp-pagenavi-style{display:none;} .wp-pagenavi-style{display:none;}';	
	echo '</style>';
} else {
    echo '<style type="text/css">#yoast_db_widget {display:none;}#revisionsdiv {display:block !important;}#slidedeck-sidebar{display:none;}#cpt_info_box{display:none;}</style>'; 
}}
add_action('admin_head', 'hide_menus');


/*Hide unwanted profile info*/
add_action('admin_head', 'hide_profile_info');
function hide_profile_info() {
global $pagenow; // get what file we're on

if(!current_user_can('manage_options')) { // we want admins and editors to still see it
switch($pagenow) {
case 'profile.php':
$output = "\n\n" . '<script type="text/javascript">' . "\n";
$output .= 'jQuery(document).ready(function() {' . "\n";
$output .= 'jQuery("form#your-profile > h3:first").hide();' . "\n"; // hide "Personal Options" header
$output .= 'jQuery("form#your-profile > h3:eq(2)").hide();' . "\n"; // hide "Contact info" header
$output .= 'jQuery("form#your-profile > h3:eq(3)").hide();' . "\n"; // hide "About Yourself" header
$output .= 'jQuery("form#your-profile > table:first").hide();' . "\n"; // hide "Personal Options" table
$output .= 'jQuery("table.form-table:eq(1) tr:first").hide();' . "\n"; // hide "username"
$output .= 'jQuery("table.form-table:eq(1) tr:eq(3)").hide();' . "\n"; // hide "nickname"
$output .= 'jQuery("table.form-table:eq(1) tr:eq(4)").hide();' . "\n"; // hide "display name publicly as"
$output .= 'jQuery("table.form-table:eq(1)+h3").hide();' . "\n"; // hide "Contact Info" header
//$output .= 'jQuery("table.form-table:eq(2)").hide();' . "\n"; // hide "Contact Info" table
$output .= 'jQuery("table.form-table:eq(3) tr:eq(0)").hide();' . "\n"; // hide "Biographical Info"
$output .= '});' . "\n";
$output .= '</script>' . "\n\n";
break;

default:
$output = '';
}
}
echo $output;
}

//Remove Gutenberg Block Library CSS from loading on the frontend
function smartwp_remove_wp_block_library_css(){
    //wp_dequeue_style( 'wp-block-library' );
    //wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

add_action( 'wp_enqueue_scripts', function() {

    wp_dequeue_script( 'bootstrap' );
    wp_dequeue_script( 'imagesloaded' );
    wp_dequeue_script( 'jquery-fitvids' );
    //wp_dequeue_script( 'jquery-throttle' );
    wp_dequeue_script( 'jquery-waypoints' );
}, 9999 );

/* Site Optimization - Removing several assets from Home page that we dont need */

// Remove Assets from HOME page only
function remove_home_assets() {
  if (is_front_page()) {
      
	  wp_dequeue_style('yoast-seo-adminbar');
	  wp_dequeue_style('espresso-admin-toolbar');
	  wp_dequeue_style('eventespresso-core-blocks-frontend');
	  wp_dequeue_style('scss');
	  
  }
  
};
add_action( 'wp_enqueue_scripts', 'remove_home_assets', 9999 );


//Removing unused Default Wordpress Emoji Script - Performance Enhancer
function disable_emoji_dequeue_script() {
    wp_dequeue_script( 'emoji' );
}
add_action( 'wp_print_scripts', 'disable_emoji_dequeue_script', 100 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); 
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Removes Emoji Scripts 
add_action('init', 'remheadlink');
function remheadlink() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	remove_action('wp_head', 'wp_shortlink_header', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
}

// THIS INCLUDES THE THUMBNAIL IN OUR RSS FEED
function insertThumbnailRSS($content) {
global $post;
if ( has_post_thumbnail( $post->ID ) ){
$content = '' . get_the_post_thumbnail( $post->ID, array(150,150), array( 'alt' => get_the_title(), 'title' => get_the_title(), 'style' => 'float:right;margin:0 0 10px 10px', 'align' => 'right' ) ) . '' . $content;
}
return $content;
}
add_filter('the_excerpt_rss', 'insertThumbnailRSS');
add_filter('the_content_feed', 'insertThumbnailRSS');

function trim_title($title_limit) {
$title = get_the_title();
$limit = $title_limit;
$pad="...";

if(strlen($title) <= $limit) {
echo $title;
} else {
$title = substr($title, 0, $limit) . $pad;
echo $title;
}
}
if(!function_exists('sp_remove_wpmandrill_dashboard'))
{
	function sp_remove_wpmandrill_dashboard() {

	if ( class_exists( 'wpMandrill' ) ) {
	
	remove_action( 'wp_dashboard_setup', array( 'wpMandrill' , 'addDashboardWidgets' ) );
	
	}
	
	}
	
	add_action( 'admin_init', 'sp_remove_wpmandrill_dashboard' );
}
?>