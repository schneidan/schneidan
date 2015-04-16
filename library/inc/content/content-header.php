<?php
/**
 * Header Content
 * hook in the content for header.php
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * Site meta, title, and favicon
 * in header.php
 * 
 * @since 1.0.0
 */
function reactor_do_reactor_head() { ?>
<meta charset="<?php bloginfo('charset'); ?>" />
<title><?php wp_title('-', true, 'right'); ?></title>

<!-- google chrome frame for ie -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
   
<!-- mobile meta -->
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<link href='http://fonts.googleapis.com/css?family=Raleway:400,500,100,200,300,600,700,800,900' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() . '/favicon.ico'; ?>">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php

//Twitter Cards
$twitter_thumbs = '';
$twitter_desc = get_bloginfo('description');
if ( is_home() || is_front_page() ) {
	$twitter_url = get_bloginfo( 'site_url' );
	$twitter_title = get_bloginfo( 'name' );
} else if ( is_category() ) {
	$id = get_query_var( 'cat' );
    $twitter_desc = category_description( $id );
    $twitter_url = get_category_link( $id );
    $twitter_title = get_cat_name( $id ) . ' - ' . get_bloginfo( 'name' );
} else if ( is_tag() ) {
	$tag_slug = get_query_var( 'tag' );
	$tag = get_term_by('slug', $tag_slug, 'post_tag');
    $twitter_desc = 'Articles related to '. $tag->name;
    $twitter_url = get_tag_link( (int)$tag->term_id );
    $twitter_title = $tag->name . ' - ' . get_bloginfo( 'name' );
} else if ( is_singular() ) {
    $twitter_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
    $twitter_desc   = strip_tags(get_the_excerpt());
    $twitter_desc   = convert_smart_quotes(htmlentities($twitter_desc, ENT_QUOTES, 'UTF-8'));
    $twitter_url    = get_permalink();
    $twitter_title  = get_the_title();
}
$twitter_thumb = ( ($twitter_thumbs != '') ? $twitter_thumbs[0] : get_stylesheet_directory_uri() . '/images/schneidan-D-logo-fb.png' );
?>
<link rel="publisher" href="http://plus.google.com/111763340133522077402" />

<meta name="twitter:card" content="<?php echo ( is_singular() ) ? 'summary_large_image' : 'summary'; ?>" />
<meta name="twitter:url" content="<?php echo $twitter_url; ?>" />
<meta name="twitter:title" content="<?php echo $twitter_title; ?>" />
<meta name="twitter:description" content="<?php echo $twitter_desc; ?>" />
<meta name="twitter:image" content="<?php echo $twitter_thumb; ?>" />
<meta name="twitter:site" content="@schneidan" />
<meta name="twitter:domain" content="schneidan.com" />
<meta name="twitter:creator" content="@schneidan" />

<meta property="og:title" content="<?php echo $twitter_title; ?>" />
<meta property="og:type" content="<?php echo ( is_singular() ) ? 'article' : 'blog'; ?>" />
<meta property="og:url" content="<?php echo $twitter_url; ?>" />
<meta property="og:image" content="<?php echo $twitter_thumb; ?>" />
<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />
<meta property="og:description" content="<?php echo $twitter_desc; ?>" />
<meta property="article:publisher" content="http://www.facebook.com/schneidan" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="distribution" content="global" />
<meta name="robots" content="follow, all" />
<meta name="language" content="en, sv" />
<meta name="Copyright" content="Copyright &copy; Daniel J. Schneider." />
<meta name="description" content="<?php echo $twitter_desc; ?>" />
<meta name="keywords" content="<?php
if (has_tag() ) {
    $posttags = get_the_tags();
    foreach($posttags as $tag) { echo $tag->name . ', '; }
} ?>photograpy, denver, colorado, rocky mountain, film" />

<?php 
}
add_action('wp_head', 'reactor_do_reactor_head', 1);

/**
 * Top bar
 * in header.php
 * 
 * @since 1.0.0
 */
function reactor_do_top_bar() {
	if ( has_nav_menu('top-bar-l') || has_nav_menu('top-bar-r') ) {
		$topbar_args = array(
			'title'     => reactor_option('topbar_title', get_bloginfo('name')),
			'title_url' => reactor_option('topbar_title_url', home_url()),
			'fixed'     => reactor_option('topbar_fixed', 0),
			'contained' => reactor_option('topbar_contain', 1),
		);
		reactor_top_bar( $topbar_args );
	}
}
add_action('reactor_header_before', 'reactor_do_top_bar', 1);

/**
 * Site title, tagline, logo, and nav bar
 * in header.php
 * 
 * @since 1.0.0
 */
function reactor_do_title_logo() { ?>
	<div class="inner-header">
		<div class="row">
			<div class="column">
				<?php if ( reactor_option('logo_image') ) : ?>
                <div class="site-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<img src="<?php echo reactor_option('logo_image') ?>" alt="<?php echo esc_attr( get_bloginfo('name', 'display') ); ?> logo">
					</a>
				</div><!-- .site-logo -->
				<?php endif; // end if logo ?>
				<div class="title-area">
					<?php if ( is_front_page() ) : ?>
					<h1 class="site-title"><?php bloginfo('name'); ?></h1>
					<h2 class="site-description"><?php bloginfo('description'); ?></h2>
				<?php else : ?>
					<p class="site-title"><?php bloginfo('name'); ?></p>
					<p class="site-description"><?php bloginfo('description'); ?></p>
				<?php endif; ?>
				</div>
			</div><!-- .column -->
		</div><!-- .row -->
	</div><!-- .inner-header -->  
<?php 
}
add_action('reactor_header_inside', 'reactor_do_title_logo', 1);

/**
 * Nav bar and mobile nav button
 * in header.php
 * 
 * @since 1.0.0
 */
function reactor_do_nav_bar() { 
	if ( has_nav_menu('main-menu') ) {
		$nav_class = ( reactor_option('mobile_menu', 1) ) ? 'class="hide-for-small" ' : ''; ?>
		<div class="main-nav">
			<nav id="menu" <?php echo $nav_class; ?>role="navigation">
				<div class="section-container horizontal-nav" data-section="horizontal-nav" data-options="one_up:false;">
					<?php reactor_main_menu(); ?>
				</div>
			</nav>
		</div><!-- .main-nav -->
		
	<?php	
	if ( reactor_option('mobile_menu', 1) ) { ?>       
		<div id="mobile-menu-button" class="show-for-small">
			<button class="secondary button" id="mobileMenuButton" href="#mobile-menu">
				<span class="mobile-menu-icon"></span>
				<span class="mobile-menu-icon"></span>
				<span class="mobile-menu-icon"></span>
			</button>
		</div><!-- #mobile-menu-button -->             
	<?php }
	}
}
add_action('reactor_header_inside', 'reactor_do_nav_bar', 2);

/**
 * Mobile nav
 * in header.php
 * 
 * @since 1.0.0
 */
function reactor_do_mobile_nav() {
	if ( reactor_option('mobile_menu', 1) && has_nav_menu('main-menu') ) { ?> 
		<nav id="mobile-menu" class="show-for-small" role="navigation">
			<div class="section-container accordion" data-section="accordion" data-options="one_up:false">
				<?php reactor_main_menu(); ?>
			</div>
		</nav>
<?php }
}
add_action('reactor_header_after', 'reactor_do_mobile_nav', 1);
?>
