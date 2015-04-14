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
