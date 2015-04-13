<?php
/**
 * The template for displaying the header
 *
 * @package Reactor
 * @subpackge Templates
 * @since 1.0.0
 */?><!DOCTYPE html>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if ( IE 7 )&!( IEMobile )]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if ( IE 8 )&!( IEMobile )]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<head profile="http://gmpg.org/xfn/11">
<?php

function convert_smart_quotes($string)  { 
    $search = array('&lsquo;','&rsquo;','&ldquo;','&rdquo;');
    $replace = array('&#039;','&#039;','&#034;','&#034;');
    return str_replace($search, $replace, $string); 
} 

//Twitter Cards
$twitter_thumbs = '';
$ogtype = 'blog';
$twitter_desc = ( is_front_page() ) ? get_bloginfo('description') : '';
$twitter_desc = ( is_category() ) ? category_description() : '';
$twitter_desc = ( is_tag() ) ? tag_description() : '';
if ( is_singular() && ! is_front_page() ) {
    $twitter_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
    $temp_post = get_post($post->ID);
    $ogtype = 'article';
    $twitter_desc = strip_tags(get_the_excerpt());
    $twitter_desc = convert_smart_quotes(htmlentities($twitter_desc, ENT_QUOTES, 'UTF-8'));
}
$twitter_url    = get_permalink();
$twitter_title  = get_the_title();
$twitter_thumb = ( ($twitter_thumbs != '') ? $twitter_thumbs[0] : get_stylesheet_directory_uri() . '/images/schneidan-D-logo-fb.png' );
?>
<link rel="publisher" href="http://plus.google.com/111763340133522077402" />

<meta name="twitter:card" content="<?php echo ( is_single() ) ? 'summary_large_image' : 'summary'; ?>" />
<meta name="twitter:url" content="<?php echo $twitter_url; ?>" />
<meta name="twitter:title" content="<?php echo $twitter_title; ?>" />
<meta name="twitter:description" content="<?php echo $twitter_desc; ?>" />
<meta name="twitter:image" content="<?php echo $twitter_thumb; ?>" />
<meta name="twitter:site" content="@schneidan" />
<meta name="twitter:domain" content="schneidan.com" />
<meta name="twitter:creator" content="@schneidan" />

<meta property="og:title" content="<?php if ( is_single() ) { wp_title(); } else { get_bloginfo('name'); } ?>" />
<meta property="og:type" content="<?php echo $ogtype; ?>" />
<meta property="og:url" content="<?php echo get_permalink() ?>" />
<meta property="og:image" content="<?php echo $twitter_thumb; ?>" />
<meta property="og:site_name" content="<?php echo get_bloginfo('name') . ' ' . get_bloginfo('description'); ?>" />
<meta property="og:description" content="<?php echo $twitter_desc; ?>" />
<meta property="article:publisher" content="http://www.facebook.com/schneidan" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="distribution" content="global" />
<meta name="robots" content="follow, all" />
<meta name="language" content="en, sv" />
<meta name="Copyright" content="Copyright &copy; Daniel J. Schneider." />
<meta name="keywords" content="<?php
if (has_tag() ) {
    $posttags = get_the_tags();
    foreach($posttags as $tag) { echo $tag->name . ', '; }
} ?>photograpy, denver, colorado, rocky mountain, film" />

<!-- WordPress head -->
<?php wp_head(); ?>
<!-- end WordPress head -->
<?php reactor_head(); ?>

<link href='http://fonts.googleapis.com/css?family=Noto+Serif:400,700,400italic,700italic|Oswald:900|Voltaire:400|Open+Sans:400,300' rel='stylesheet' type='text/css'>

</head>

<body <?php body_class(); ?>>

	<?php reactor_body_inside(); ?>

    <div id="page" class="hfeed site"> 
    
        <?php reactor_header_before(); ?>
    
        <header id="header" class="site-header hide-for-small" role="banner">
            <div class="row">
                <div class="<?php reactor_columns( 12 ); ?>">
                    
                    <?php reactor_header_inside(); ?>
                    
                </div><!-- .columns -->
            </div><!-- .row -->
        </header><!-- #header -->
        
        <?php reactor_header_after(); ?>
        
        <div id="main" class="wrapper">
