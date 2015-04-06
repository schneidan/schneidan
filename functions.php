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
	
	/* Support for sidebars
	Note: this doesn't change layout options */
	remove_theme_support('reactor-sidebars');
	add_theme_support(
		'reactor-sidebars',
	   array( 'secondary', 'front-primary', 'footer-one', 'footer-two' )
	);
	
	/* Support for layouts
	Note: this doesn't remove sidebars */
	// remove_theme_support('reactor-layouts');
	// add_theme_support(
	// 	'reactor-layouts',
	// 	array('1c', '2c-l', '2c-r', '3c-l', '3c-r', '3c-c')
	// );
	
	/* Support for custom post types */
	// remove_theme_support('reactor-post-types');
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
        $content = get_the_post_thumbnail($post->ID, 'full', array('style' => 'margin-bottom:10px;')) . $content;
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
function my_categories_filter($cat_args){
    $cat_args['title_li'] = '';
    $cat_args['exclude_tree'] = 1;
    $cat_args['exclude'] = 1;
    $cat_args['use_desc_for_title'] = 0;
    return $cat_args;
}

add_filter('widget_categories_args', 'my_categories_filter', 10, 2);

// Add contact methods fields to user profile
function modify_contact_methods($profile_fields) {

    // Add new fields
    $profile_fields['publication'] = 'Publication';

    return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');

// Add photographer credit to caption output
function my_caption_html( $current_html, $attr, $content ) {
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
                    <li><a href="http://twitter.com/schneidan"><img src="' . get_stylesheet_directory_uri() . '/images/icon-twitter.png" alt="Follow on Twitter" /></a></li>
                    <li><a href="http://facebook.com/schneidan"><img src="' . get_stylesheet_directory_uri() . '/images/icon-facebook.png" alt="Follow on Facebook" /></a></li>
                    <li><a href="http://plus.google.com/+DanielJSchneider"><img src="' . get_stylesheet_directory_uri() . '/images/icon-gplus.png" alt="Follow on Google+" /></a></li>
                    <li><a href="http://flickr.com/schneidan"><img src="' . get_stylesheet_directory_uri() . '/images/icon-flickr.png" alt="Follow on Flickr" /></a></li>
                    <li><a href="http://schneidan.tumblr.com"><img src="' . get_stylesheet_directory_uri() . '/images/icon-tumblr.png" alt="Follow on Tumblr" /></a></li>
                    <li><a href="' . get_home_url() . '/feed/"><img src="' . get_stylesheet_directory_uri() . '/images/icon-rss.png" alt="Follow via RSS" /></a></li>
                </ul>
            </div>';
            echo $args['after_widget'];
    }
}
function registerfollow_me_widget() { register_widget('follow_me_widget'); }
add_action( 'widgets_init', 'registerfollow_me_widget' );