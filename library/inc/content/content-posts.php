<?php
/**
 * Post Content
 * hook in the content for post formats
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * Front page main format
 * in format-standard
 * 
 * @since 1.0.0
 */
function reactor_post_frontpage_format() {

	$categories_list = '';
	$categories_link = '';
	$categories = get_the_category();
	end($categories);
	foreach($categories as $category) {
		if ( strtolower($category->slug) != 'uncategorized' && $category->category_parent == 0) {
			$categories_list = $category->name;
			$categories_link = get_category_link( $category->term_id );
		}
	}

	if ( has_post_thumbnail() ) {
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
	} ?>
		<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __('%s', 'reactor'), the_title_attribute('echo=0') ) ); ?>" rel="bookmark">
	<?php if (isset($large_image_url) && strlen($large_image_url[0]) >= 1) { ?>
			<div class="frontpage-image frontpage-post" style="background-image:url('<?php echo $large_image_url[0]; ?>');">
				<div class="front-thumbnail">
				</div>
	<?php } else { ?>
		<div class="frontpage-post">
	<?php }
	if ( is_front_page() ) { ?>
				<a href="<?php echo $categories_link; ?>" title="<?php echo esc_attr( sprintf( __('All posts in %s', 'reactor'), $categories_list ) ); ?>" rel="bookmark"><h3 class="entry-category"><?php echo $categories_list; ?></h3></a>
	<?php } ?>
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __('%s', 'reactor'), the_title_attribute('echo=0') ) ); ?>" rel="bookmark">
					<h2 class="entry-title"><?php the_title(); ?></h2>
				</a>
			</div>
		</a>
<?php }
add_action('reactor_post_frontpage', 'reactor_post_frontpage_format', 1);
add_action('reactor_post_portpage', 'reactor_post_frontpage_format', 1);

/**
 * Achive pages format
 * in format-standard
 * 
 * @since 1.0.0
 */
function reactor_post_catpage_format() {

	$categories_list = '';
	$categories_link = '';
	$categories = get_the_category();
	end($categories);
	foreach($categories as $category) {
		if ( strtolower($category->slug) != 'uncategorized' && $category->category_parent == 0) {
			$categories_list = $category->name;
			$categories_link = get_category_link( $category->term_id );
		}
	}

	if ( has_post_thumbnail() ) {
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium');
	}
	if (isset($large_image_url) && strlen($large_image_url[0]) >= 1) { ?>
		<div class="catpage-post clearfix">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __('%s', 'reactor'), the_title_attribute('echo=0') ) ); ?>" rel="bookmark">
				<div class="cat-thumbnail" style="background-image:url('<?php echo $large_image_url[0]; ?>');">
					<div class="cat-imgholder"></div>
				</div>
			</a>
	<?php } else { ?>
		<div class="catpage-post">
	<?php } ?>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __('%s', 'reactor'), the_title_attribute('echo=0') ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<h3 class="entry-subtitle"><?php the_subtitle(); ?></h3>
	<?php reactor_post_meta(array('show_author'=>true,'show_cat'=>false,'show_tag'=>false,'comments'=>false,'catpage'=>true,'link_date'=>false,'date_only'=>true)); ?>
	</div>
<?php }
add_action('reactor_post_catpage', 'reactor_post_catpage_format', 1);
add_action('reactor_post_tagpage', 'reactor_post_catpage_format', 1);

/**
 * Post featured tag
 * in format-standard
 * 
 * @since 1.0.0
 */
function reactor_do_standard_format_sticky() { 
	if ( is_sticky() ) { ?>
		<div class="entry-featured">
			<span class="label secondary"><?php echo apply_filters('reactor_featured_post_title', __('Featured Post', 'reactor')); ?></span>
		</div>
<?php }
}
//add_action('reactor_post_header', 'reactor_do_standard_format_sticky', 2);

/**
 * Post header
 * in format-standard
 * 
 * @since 1.0.0
 */
function reactor_do_standard_header_titles() {

	$categories_list = '';
	$categories_link = '';
	$categories = get_the_category();
	end($categories);
	foreach($categories as $category) {
		if ( strtolower($category->slug) != 'uncategorized' && $category->category_parent == 0) {
			$categories_list = $category->name;
			$categories_link = get_category_link( $category->term_id );
		}
	}

	$show_titles = reactor_option('frontpage_show_titles', 1);
	$link_titles = reactor_option('frontpage_link_titles', 0);
	
	if ( is_page_template('page-templates/front-page.php') && $show_titles ) { ?>
		<?php if ( !$link_titles ) { ?>
		<h2 class="entry-title"><?php the_title(); ?></h2>
		<?php } else { ?>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __('%s', 'reactor'), the_title_attribute('echo=0') ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<?php }
	}
    elseif ( !get_post_format() && !is_page_template('page-templates/front-page.php') ) {  ?>    
		<?php if ( is_single() ) { ?>
		<a href="<?php echo $categories_link; ?>" title="<?php echo esc_attr( sprintf( __('All posts in %s', 'reactor'), $categories_list ) ); ?>" rel="bookmark"><h3 class="entry-category"><?php echo $categories_list; ?></h3></a>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<h2 class="entry-subtitle"><?php the_subtitle(); ?></h2>
		<?php } else { ?>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __('%s', 'reactor'), the_title_attribute('echo=0') ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php } ?>
<?php }
}
add_action('reactor_post_header', 'reactor_do_standard_header_titles', 3);

/**
 * Post header meta
 * in all formats
 * 
 * @since 1.0.0
 */
function reactor_do_post_header_meta() {

	if ( is_single() ) {
		reactor_post_meta(array('show_author'=>true,'show_cat'=>false,'show_tag'=>false,'comments'=>false,'catpage'=>true,'link_date'=>false,'date_only'=>true));
	}
}
add_action('reactor_post_header', 'reactor_do_post_header_meta', 4);

/**
 * Post footer meta
 * in all formats
 * 
 * @since 1.0.0
 */
function reactor_do_post_footer_meta() {
	if ( is_single() && current_theme_supports('reactor-post-meta') ) {
		reactor_post_meta(array('show_author'=>false,'show_cat'=>false,'show_tag'=>true,'comments'=>false,'catpage'=>false,'link_date'=>false,'date_only'=>false));
	}
}
add_action('reactor_post_footer', 'reactor_do_post_footer_meta', 1);

/**
 * Post after social links
 * in single.php
 * 
 * @since 1.0.0
 */
function reactor_do_page_single() {
	wp_reset_query();
	if ( is_front_page() || is_page_template( 'page-templates/port-page.php' ) ) { ?>
		<div class="row" id="socialrow">
			<div class="large-3 large-centered medium-5 medium-centered small-8 small-centered columns">
				<ul class="inline-list">
					<li><a href="http://twitter.com/schneidan"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-twitter.png" alt="Follow on Twitter" /></a></li>
					<li><a href="http://facebook.com/schneidan"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-facebook.png" alt="Follow on Facebook" /></a></li>
					<li><a href="http://plus.google.com/+DanielJSchneider"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-gplus.png" alt="Follow on Google+" /></a></li>
					<li><a href="http://flickr.com/schneidan"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-flickr.png" alt="Follow on Flickr" /></a></li>
					<li><a href="http://tumblr.com/schneidan"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-tumblr.png" alt="Follow on Tumblr" /></a></li>
					<li><a href="<?php echo get_home_url(); ?>/feed/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-rss.png" alt="Follow via RSS" /></a></li>
				</ul>
			</div>
		</div>
	<?php }
}
add_action('reactor_content_after', 'reactor_do_page_single', 1);

/**
 * Post social
 * in single.php
 * 
 * @since 1.0.0
 */
function reactor_do_post_social() {
	if ( is_single() ) {
		global $wp;
		global $post;

		$text = html_entity_decode( get_the_title() );
		if ( (is_single() || is_page() ) && has_post_thumbnail( $post->ID ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
		}
		$desc = ( get_the_excerpt() != '' ? get_the_excerpt() : get_bloginfo( 'description' ) );
		$social_string = '<div class="post-body-social"><ul class="inline-list">';
		//Twitter button
		$social_string .= sprintf(
		    '<li class="post-meta-social pm-twitter"><a href="javascript:void(0)" onclick="javascript:window.open(\'http://twitter.com/share?text=%1$s&amp;url=%2$s&amp;via=%3$s\', \'twitwin\', \'left=20,top=20,width=500,height=500,toolbar=1,resizable=1\');"><img src="%4$s" alt="Share on Twitter" /></a></li>',
		    urlencode(html_entity_decode($text, ENT_COMPAT, 'UTF-8') . ':'),
		    rawurlencode( get_permalink() ),
		    'schneidan',
		    get_stylesheet_directory_uri() . '/images/icon-twitter-round.png'
		);
		//Facebook share
		$social_string .= sprintf(
		    '<li class="post-meta-social pm-facebook"><a href="javascript:void(0)" onclick="javascript:window.open(\'http://www.facebook.com/sharer/sharer.php?s=100&amp;p[url]=%1$s&amp;p[images][0]=%2$s&amp;p[title]=%3$s&amp;p[summary]=%4$s\', \'fbwin\', \'left=20,top=20,width=500,height=500,toolbar=1,resizable=1\');"><img src="%5$s" alt="Share on Facebook" /></a></li>',
		    rawurlencode( get_permalink() ),
		    rawurlencode( $image[0] ),
		    urlencode( html_entity_decode($text, ENT_COMPAT, 'UTF-8') ),
		    urlencode( html_entity_decode( $desc, ENT_COMPAT, 'UTF-8' ) ),
		    get_stylesheet_directory_uri() . '/images/icon-facebook-round.png'
		);
		//Google plus share
		$social_string .= sprintf(
		    '<li class="post-meta-social pm-googleplus"><a href="javascript:void(0)" onclick="javascript:window.open(\'http://plus.google.com/share?url=%1$s\', \'gpluswin\', \'left=20,top=20,width=500,height=500,toolbar=1,resizable=1\');"><img src="%2$s" alt="Share on Google Plus" /></a></li>',
		    rawurlencode( get_permalink() ),
		    get_stylesheet_directory_uri() . '/images/icon-gplus-round.png'
		);
		//Email This
		$social_string .= sprintf(
		    '<li class="post-meta-social pm-email"><a href="%1$s"><img src="%2$s" alt="Share by Email" /></a></li>',
		    get_permalink() . '/email',
		    get_stylesheet_directory_uri() . '/images/icon-email-round.png'
		);
		$social_string .= '</div>';
		echo $social_string;
	}
}
add_action('reactor_post_social', 'reactor_do_post_social', 1);

/**
 * Single post nav 
 * in single.php
 * 
 * @since 1.0.0
 */
function reactor_do_nav_single() {
    if ( is_single() ) { 
    $exclude = ( reactor_option('frontpage_exclude_cat', 1) ) ? reactor_option('frontpage_post_category', '') : ''; ?>
        <nav class="nav-single">
            <span class="nav-previous alignleft">
            <?php previous_post_link('%link', '<span class="meta-nav">' . _x('&larr;', 'Previous post link', 'reactor') . '</span> %title', false, $exclude); ?>
            </span>
            <span class="nav-next alignright">
            <?php next_post_link('%link', '%title <span class="meta-nav">' . _x('&rarr;', 'Next post link', 'reactor') . '</span>', false, $exclude); ?>
            </span>
        </nav><!-- .nav-single -->
<?php }
}
//add_action('reactor_post_after', 'reactor_do_nav_single', 1);

/**
 * Comments 
 * in single.php
 * 
 * @since 1.0.0
 */
function reactor_do_post_comments() {      
	// If comments are open or we have at least one comment, load up the comment template
	if ( is_single() && ( comments_open() || '0' != get_comments_number() ) ) {
		comments_template('', true);
	}
}
add_action('reactor_post_after', 'reactor_do_post_comments', 2);

/**
 * No posts format
 * loop else in page templates
 * 
 * @since 1.0.0
 */
function reactor_do_loop_else() {
	get_template_part('post-formats/format', 'none');
}
add_action('reactor_loop_else', 'reactor_do_loop_else', 1);
?>
