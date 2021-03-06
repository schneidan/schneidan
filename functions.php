<?php
/**
 * Reactor Child Theme Functions
 *
 * @package schneidan 
 * @author Daniel J. Schneider (@schneidan / schneidan.com)
 * @version 0.0.1
 * @since 0/0/1
 * @copyright Copyright (c) 2014, Daniel J. Schneider
 */

/**
 * Child Theme Features
 * The following function will allow you to remove features included with Reactor
 *
 * Remove the comment slashes (//) next to the functions
 * For add_theme_support, remove values from arrays to disable parts of the feature
 * remove_theme_support will disable the feature entirely
 * Reference the functions.php file in Reactor for add_theme_support functions
 */
add_action('after_setup_theme', 'reactor_child_theme_setup', 11);

function reactor_child_theme_setup() {

    /* Support for menus */
	// remove_theme_support('reactor-menus');
	// add_theme_support(
	// 	'reactor-menus',
	// 	array('top-bar-l', 'top-bar-r', 'main-menu', 'side-menu', 'footer-links')
	// );
	
    add_theme_support( 'html5', array( 'caption' ) );

	/* Support for sidebars
	Note: this doesn't change layout options */
	remove_theme_support('reactor-sidebars');
	add_theme_support(
		'reactor-sidebars',
	   array( 'secondary', 'front-primary', 'footer-one', 'footer-two', 'cameras', 'stories' )
	);
	
	/* Support for layouts
	Note: this doesn't remove sidebars */
	// remove_theme_support('reactor-layouts');
	// add_theme_support(
	// 	'reactor-layouts',
	// 	array('1c', '2c-l', '2c-r', '3c-l', '3c-r', '3c-c')
	// );
	
	/* Support for custom post types */
	remove_theme_support('reactor-post-types');
	// add_theme_support(
	// 	'reactor-post-types',
	// 	array('slides', 'portfolio')
	// );
	
	/* Support for page templates */
	// remove_theme_support('reactor-page-templates');
	// add_theme_support(
	// 	'reactor-page-templates',
	// 	array('front-page', 'news-page', 'portfolio', 'contact')
	// );
	
	/* Remove support for background options in customizer */
	// remove_theme_support('reactor-backgrounds');
	
	/* Remove support for font options in customizer */
	// remove_theme_support('reactor-fonts');
	
	/* Remove support for custom login options in customizer */
	// remove_theme_support('reactor-custom-login');
	
	/* Remove support for breadcrumbs function */
	// remove_theme_support('reactor-breadcrumbs');
	
	/* Remove support for page links function */
	// remove_theme_support('reactor-page-links');
	
	/* Remove support for page meta function */
	// remove_theme_support('reactor-post-meta');
	
	/* Remove support for taxonomy subnav function */
	// remove_theme_support('reactor-taxonomy-subnav');
	
	/* Remove support for shortcodes */
	// remove_theme_support('reactor-shortcodes');
	
	/* Remove support for tumblog icons */
	// remove_theme_support('reactor-tumblog-icons');
	
	/* Remove support for other langauges */
	// remove_theme_support('reactor-translation');
		
}

// add a favicon to the admin
function add_favicon() {
    $favicon_url = get_stylesheet_directory_uri() . '/favicon.ico';
    echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
}
add_action('login_head', 'add_favicon');
add_action('admin_head', 'add_favicon');

// Hide the Wordpress admin bar for everyone
function my_function_admin_bar(){ return false; }
add_filter( 'show_admin_bar' , 'my_function_admin_bar');

// Add MRSS content for images to RSS feed
function flipboard_namespace() {
    echo 'xmlns:media="http://search.yahoo.com/mrss/"
    xmlns:georss="http://www.georss.org/georss"';
}
add_filter( 'rss2_ns', 'flipboard_namespace' );

function flipboard_attached_images() {
    global $post;
    $attachments = get_posts( array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'posts_per_page' => -1,
        'post_parent' => $post->ID
    ) );
    if ( $attachments ) {
        foreach ( $attachments as $att ) {
            $img_attr = wp_get_attachment_image_src( $att->ID, 'full' );
            ?>
            <media:content url="<?php echo $img_attr[0]; ?>" width="<?php echo $img_attr[1]; ?>" height="<?php echo $img_attr[2]; ?>" medium="image" type="<?php echo $att->post_mime_type; ?>">
                <media:title type="plain"><![CDATA[<?php echo $att->post_title; ?>]]></media:title>
                <media:copyright>The Denver Post</media:copyright>
                <media:description type="plain"><![CDATA[<?php echo $att->post_excerpt; ?>]]></media:description>
            </media:content>
            <media:thumbnail url="<?php echo $img_attr[0]; ?>" width="<?php echo $img_attr[1]; ?>" height="<?php echo $img_attr[2]; ?>" />
            <?php
        }
    }
}
add_filter( 'rss2_item', 'flipboard_attached_images' );

// Function to add featured image in RSS feeds
function featured_image_in_rss($content)
{
    // Global $post variable
    global $post;
    // Check if the post has a featured image
    if (has_post_thumbnail($post->ID))
    {
        $content = get_the_post_thumbnail($post->ID, 'large', array('style' => 'margin-bottom:10px;')) . $content;
    }
    return $content;
}
// Add the filter for RSS feeds Excerpt
add_filter('the_excerpt_rss', 'featured_image_in_rss');
//Add the filter for RSS feed content
add_filter('the_content_feed', 'featured_image_in_rss');

// add a full-text RSS feed as an option
function full_feed() {
    add_filter('pre_option_rss_use_excerpt', '__return_zero');
    load_template( ABSPATH . WPINC . '/feed-rss2.php' );
}
add_feed('full', 'full_feed');

// Disable those annoying pingbacks from our own posts
function disable_self_trackback( &$links ) {
  foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, get_option( 'home' ) ) )
            unset($links[$l]);
}
add_action( 'pre_ping', 'disable_self_trackback' );

// Suppress 'Uncategorized' in category widget
function my_categories_filter( $cat_args ){
    $cat_args['title_li'] = '';
    $cat_args['exclude_tree'] = 1;
    $cat_args['exclude'] = 1;
    $cat_args['use_desc_for_title'] = 0;
    return $cat_args;
}

add_filter( 'widget_categories_args', 'my_categories_filter', 10, 2 );

// Exclude EFD posts from RSS
function sd_exclude_from_rss( $query ) {
    // Categories to exclude - by ID
    $cats_to_exclude = array( 161 );

    if ( $query->is_feed && !$query->is_category( $cats_to_exclude ) ) {
        set_query_var( 'category__not_in', $cats_to_exclude );
    }

    return $query;
}
add_filter( 'pre_get_posts', 'sd_exclude_from_rss' );

// Hide Jetpack's Feedback menu item
function jp_rm_menu() {
    if( class_exists( 'Jetpack' ) ) {
        remove_menu_page( 'edit.php?post_type=feedback' );
    }
}
add_action( 'admin_init', 'jp_rm_menu' );

// Add contact methods fields to user profile
function modify_contact_methods( $profile_fields ) {

    // Add new fields
    $profile_fields['publication'] = 'Publication';

    return $profile_fields;
}
add_filter( 'user_contactmethods', 'modify_contact_methods' );

/**
 * Add photographer credit to caption output // THIS DOESN'T WORK
 *
 * function my_caption_html( $current_html, $attr, $content ) {
        extract(shortcode_atts(array(
            'id'    => '',
            'align' => 'alignnone',
            'width' => '',
            'caption' => ''
        ), $attr));
        if ( 1 > (int) $width || empty($caption) )
            return $content;

        if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

        return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . (10 + (int) $width) . 'px">'
    . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '<span class="photo-credit">(' . get_post_meta( $id, 'photographer_name', true) . ')</span></p></div>';
    }
    add_filter( 'img_caption_shortcode', 'my_caption_html', 1, 3 );
 */

// Add Photographer Name and URL fields to media uploader
function attachment_field_credit( $form_fields, $post ) {
    $form_fields['photographer-name'] = array(
        'label' => 'Photographer',
        'input' => 'text',
        'value' => get_post_meta( $post->ID, 'photographer_name', true ),
    );

    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'attachment_field_credit', 10, 2 );

// Save values of Photographer Name and URL in media uploader
function attachment_field_credit_save( $post, $attachment ) {
    if( isset( $attachment['photographer-name'] ) )
        update_post_meta( $post['ID'], 'photographer_name', $attachment['photographer-name'] );

    return $post;
}
add_filter( 'attachment_fields_to_save', 'attachment_field_credit_save', 10, 2 );

/**
 * Exclude Expired Film Day posts from Search
 */
add_filter( 'pre_get_posts' , 'search_exc_cats' );
function search_exc_cats( $query ) {
    if( $query->is_admin || !$query->is_search )
        return $query;
    $query->set( 'category__not_in' , array( 161 ) );
    return $query;
}

/**
 * Include posts from authors in the search results where
 * either their display name or user login matches the query string
 *
 * @author danielbachhuber
 */
add_filter( 'posts_search', 'db_filter_authors_search' );

function db_filter_authors_search( $posts_search ) {

    // Don't modify the query at all if we're not on the search template
    // or if the LIKE is empty
    if ( !is_search() || empty( $posts_search ) )
        return $posts_search;

    global $wpdb;
    // Get all of the users of the blog and see if the search query matches either
    // the display name or the user login
    add_filter( 'pre_user_query', 'db_filter_user_query' );
    $search = sanitize_text_field( get_query_var( 's' ) );
    $args = array(
        'count_total' => false,
        'search' => sprintf( '*%s*', $search ),
        'search_fields' => array(
            'display_name',
            'user_login',
        ),
        'fields' => 'ID',
    );
    $matching_users = get_users( $args );
    remove_filter( 'pre_user_query', 'db_filter_user_query' );
    // Don't modify the query if there aren't any matching users
    if ( empty( $matching_users ) )
        return $posts_search;
    // Take a slightly different approach than core where we want all of the posts from these authors
    $posts_search = str_replace( ')))', ")) OR ( {$wpdb->posts}.post_author IN (" . implode( ',', array_map( 'absint', $matching_users ) ) . ")))", $posts_search );
    return $posts_search;
}

/**
 * Modify get_users() to search display_name instead of user_nicename
 */
function db_filter_user_query( &$user_query ) {

    if ( is_object( $user_query ) )
        $user_query->query_where = str_replace( "user_nicename LIKE", "display_name LIKE", $user_query->query_where );
    return $user_query;
}

/**
 * Last Modified date support for Dashboard
 * 
 * - Adds a Last Modified column to the Posts and Pages lists in wp-admin,
 * displays the date, time and user who last modified, and is sortable.
 * - Adds a Last Modified item to the Publish meta box on the Post and 
 * Page editor screens.
 * - Adds CSS to admin pages to style the additions.
 * 
 */
if ( is_admin() ) {
    function sd_get_modified_data( $post_id ) {
        $m_orig     = get_post_field( 'post_modified', $post_id, 'raw' );
        $m_stamp    = strtotime( $m_orig );
        $modr_id    = get_post_meta( $post_id, '_edit_last', true );
        $auth_id    = get_post_field( 'post_author', $post_id, 'raw' );
        $user_id    = ! empty( $modr_id ) ? $modr_id : $auth_id;
        $user_info  = get_userdata( $user_id );
        $user_name  = $user_info->display_name;
        return array( 'user_name'=>$user_name,'modified_date'=>$m_stamp );
    }

    function sd_post_columns_data( $column, $post_id ) {
        switch ( $column ) {
            case 'modified':
                $modified   = sd_get_modified_data( $post_id );
                echo sprintf( '<p class="mod-date">%1$s<br /><em>by</em> %2$s</p>',
                    date( 'Y/m/d H:i', $modified['modified_date'] ),
                    $modified['user_name']
                );
                break;
        }
    }

    function sd_post_columns_display( $columns ) {
        $columns['modified'] = 'Last Modified';
        return $columns;
    }

    function sd_last_modified_register_sortable( $columns ) {
        $columns["modified"] = "modified";
        return $columns;
    }

    function sd_last_modified_publish_box( $post_id ) {
        $modified = sd_get_modified_data( $post_id );
        echo sprintf( '<div class="misc-pub-section misc-pub-section-last"><span id="modifiedtimestamp">Last modified: <strong>%1$s</strong></span></div>',
            date( 'M j, Y @ G:i', $modified['modified_date'] )
            );
    }
    
    function sd_print_admin_css() {
        echo '<style type="text/css">.fixed .column-modified{width:10%;}#message .last-modified-timestamp{font-weight:bold;}.misc-pub-section #modifiedtimestamp:before{content: \'\f145\';font: 400 20px/1 dashicons;speak: none;display: inline-block;padding: 0 5px 0 0;top: -1px;left: -1px;position: relative;vertical-align: top;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;text-decoration: none!important;color:#888;}</style>'."\n";
    }

    add_action ( 'post_submitbox_misc_actions', 'sd_last_modified_publish_box', 1 );
    add_action ( 'admin_print_styles-edit.php', 'sd_print_admin_css' );
    add_action ( 'admin_print_styles-post.php', 'sd_print_admin_css' );
    add_action ( 'admin_print_styles-post-new.php', 'sd_print_admin_css' );
    add_action ( 'manage_posts_custom_column', 'sd_post_columns_data', 10, 2 );
    add_action ( 'manage_pages_custom_column', 'sd_post_columns_data', 10, 2 );
    add_filter ( 'manage_edit-post_columns', 'sd_post_columns_display' );
    add_filter ( 'manage_edit-page_columns', 'sd_post_columns_display' );
    add_filter ( 'manage_edit-post_sortable_columns', 'sd_last_modified_register_sortable' );
    add_filter ( 'manage_edit-page_sortable_columns', 'sd_last_modified_register_sortable' );
}

class follow_me_widget extends WP_Widget
{
    public function __construct()
    {
            parent::__construct(
                'follow_me_widget',
                __('Follow Me Widget', 'follow_me_widget'),
                array('description' => __('People most follow me on social media for success!', 'follow_me_widget'), )
            );
    }

    public function widget($args, $instance)
    {
        // It's a big ad.
        echo $args['before_widget'];
        echo '
            <h4 class="widget-title">Follow Me</h4>
            <div id="socialrow" class="large-10 medium-10 small-11 centered">
                <ul class="inline-list">
                    <li><a href="https://twitter.com/schneidan"><img src="' . get_stylesheet_directory_uri() . '/images/icon-twitter.png" alt="Follow on Twitter" /></a></li>
                    <li><a href="https://facebook.com/schneidan"><img src="' . get_stylesheet_directory_uri() . '/images/icon-facebook.png" alt="Follow on Facebook" /></a></li>
                    <li><a href="https://plus.google.com/+DanielJSchneider"><img src="' . get_stylesheet_directory_uri() . '/images/icon-gplus.png" alt="Follow on Google+" /></a></li>
                    <li><a href="https://flickr.com/schneidan"><img src="' . get_stylesheet_directory_uri() . '/images/icon-flickr.png" alt="Follow on Flickr" /></a></li>
                    <li><a href="https://schneidan.tumblr.com"><img src="' . get_stylesheet_directory_uri() . '/images/icon-tumblr.png" alt="Follow on Tumblr" /></a></li>
                    <li><a href="' . get_home_url() . '/feed/"><img src="' . get_stylesheet_directory_uri() . '/images/icon-rss.png" alt="Follow via RSS" /></a></li>
                </ul>
            </div>';
            echo $args['after_widget'];
    }
}
function registerfollow_me_widget() { register_widget('follow_me_widget'); }
add_action( 'widgets_init', 'registerfollow_me_widget' );

// Disable both Twitter Cards and OG tags
add_filter( 'jetpack_enable_open_graph', '__return_false', 99 );

// Disable only the Twitter Cards
add_filter( 'jetpack_disable_twitter_cards', '__return_true', 99 );

// Leave this here so we can use it other places...
function convert_smart_quotes($string)  { 
    $search = array('&lsquo;','&rsquo;','&ldquo;','&rdquo;');
    $replace = array('&#039;','&#039;','&#034;','&#034;');
    return str_replace($search, $replace, $string); 
}

// Remove category description paragraph tags
remove_filter('term_description','wpautop');

/**
 * Widget Custom Classes
 */
function sd_widget_form_extend( $instance, $widget ) {
    if ( !isset($instance['classes']) )
    $instance['classes'] = null;
    $row = "<p>\n";
    $row .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-classes'>Class:\n";
    $row .= "\t<input type='text' name='widget-{$widget->id_base}[{$widget->number}][classes]' id='widget-{$widget->id_base}-{$widget->number}-classes' class='widefat' value='{$instance['classes']}'/>\n";
    $row .= "</label>\n";
    $row .= "</p>\n";
    echo $row;
    return $instance;
}
add_filter('widget_form_callback', 'sd_widget_form_extend', 10, 2);

function sd_widget_update( $instance, $new_instance ) {
    $instance['classes'] = $new_instance['classes'];
        return $instance;
    }
add_filter( 'widget_update_callback', 'sd_widget_update', 10, 2 );

function sd_dynamic_sidebar_params( $params ) {
    global $wp_registered_widgets;
    $widget_id    = $params[0]['widget_id'];
    $widget_obj    = $wp_registered_widgets[$widget_id];
    $widget_opt    = get_option($widget_obj['callback'][0]->option_name);
    $widget_num    = $widget_obj['params'][0]['number'];
    if ( isset($widget_opt[$widget_num]['classes']) && !empty($widget_opt[$widget_num]['classes']) )
        $params[0]['before_widget'] = preg_replace( '/class="/', "class=\"{$widget_opt[$widget_num]['classes']} ", $params[0]['before_widget'], 1 );
    return $params;
}
add_filter( 'dynamic_sidebar_params', 'sd_dynamic_sidebar_params' );

/**
 * dequeue Gallery Slideshow scripts when not necessary
 */
function sd_dequeue_scripts() {
    $load_scripts = false;
    if( is_singular() ) {
        $post = get_post();
        if ( has_shortcode( $post->post_content, 'gss' ) ) {
            $load_scripts = true;
        }
    }
    if( ! $load_scripts ) {
        wp_dequeue_script( 'cycle2' );
        wp_dequeue_script( 'cycle2_center' );
        wp_dequeue_script( 'cycle2_carousel' );
        wp_dequeue_script( 'gss_js' );
        wp_dequeue_script( 'gss_custom_js' );
        wp_dequeue_style( 'gss_css' );
    }
}
add_action( 'wp_enqueue_scripts', 'sd_dequeue_scripts', 99 );

/**
 * Remove jquery migrate and move jquery to footer
 */
function remove_jquery_migrate( &$scripts) {
    if ( ! is_admin() ) {
        $scripts->remove( 'jquery');
        $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
    }
}
add_filter( 'wp_default_scripts', 'remove_jquery_migrate' );

/**
 * deregister stupid wP emoji BS
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * deregister unused Jetpack CSS
 */
function jeherve_remove_all_jp_css() {
  wp_deregister_style( 'AtD_style' ); // After the Deadline
  wp_deregister_style( 'jetpack_likes' ); // Likes
  wp_deregister_style( 'jetpack_related-posts' ); //Related Posts
  wp_deregister_style( 'jetpack-carousel' ); // Carousel
  wp_deregister_style( 'the-neverending-homepage' ); // Infinite Scroll
  wp_deregister_style( 'infinity-twentyten' ); // Infinite Scroll - Twentyten Theme
  wp_deregister_style( 'infinity-twentyeleven' ); // Infinite Scroll - Twentyeleven Theme
  wp_deregister_style( 'infinity-twentytwelve' ); // Infinite Scroll - Twentytwelve Theme
  wp_deregister_style( 'noticons' ); // Notes
  wp_deregister_style( 'post-by-email' ); // Post by Email
  wp_deregister_style( 'publicize' ); // Publicize
  wp_deregister_style( 'sharedaddy' ); // Sharedaddy
  wp_deregister_style( 'sharing' ); // Sharedaddy Sharing
  wp_deregister_style( 'stats_reports_css' ); // Stats
  wp_deregister_style( 'jetpack-widgets' ); // Widgets
  wp_deregister_style( 'jetpack-slideshow' ); // Slideshows
  wp_deregister_style( 'presentations' ); // Presentation shortcode
  wp_deregister_style( 'tiled-gallery' ); // Tiled Galleries
  wp_deregister_style( 'widget-conditions' ); // Widget Visibility
  wp_deregister_style( 'jetpack_display_posts_widget' ); // Display Posts Widget
  wp_deregister_style( 'gravatar-profile-widget' ); // Gravatar Widget
  wp_deregister_style( 'widget-grid-and-list' ); // Top Posts widget
  wp_deregister_style( 'jetpack-widgets' ); // Widgets
}
if ( ! is_admin() ) {
    add_filter( 'jetpack_implode_frontend_css', '__return_false' );
    add_action('wp_print_styles', 'jeherve_remove_all_jp_css' );
}

/**
 * Hide all admin notices from Yoast SEO plugin
 */
if ( class_exists( 'Yoast_Notification_Center' ) ) {
    remove_action( 'admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );
    remove_action( 'all_admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );
}

// Attempts to exclude the frontpage post fro flexible-post-widget's query
function exclude_flexible_posts($query_args) {
    global $frontpage_post_id;
    $query_args['post__not_in'] = array($frontpage_post_id);
    return $query_args;
}
add_filter('dpe_fpw_args', 'exclude_flexible_posts');

// Attempt to prevent "Password field is empty" errors on login window
function sd_kill_wp_attempt_focus_start() {
    ob_start("sd_kill_wp_attempt_focus_replace");
}
add_action("login_form", "sd_kill_wp_attempt_focus_start");
function sd_kill_wp_attempt_focus_replace($html) {
    return preg_replace("/d.value = '';/", "", $html);
}
function sd_kill_wp_attempt_focus_end() {
    ob_end_flush();
}
add_action("login_footer", "sd_kill_wp_attempt_focus_end");

// Disable cover images in Facebook Instant Articles plugin to avoid duplication
function sd_filter_instant_articles_remove_featured_image($image_data) {
    return array(
        'src' => '',
        'caption' => '',
    );
}
add_filter('instant_articles_featured_image', 'sd_filter_instant_articles_remove_featured_image');