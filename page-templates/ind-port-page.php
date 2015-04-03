<?php
/**
 * Template Name: Ind Port Page
 *
 * @package Reactor
 * @subpackge Templates
 * @since 1.0.0
 */
?>

<?php get_header(); ?>

	<div id="primary" class="site-content">
    
        <div id="content" role="main">
        	<div class="row">
                <?php reactor_content_before(); ?>

                <div class="<?php reactor_columns(10,12,11); ?> large-centered medium-centered">
                
                <?php reactor_inner_content_before(); ?>
                 
					<?php // get the page loop
                    get_template_part('loops/loop', 'page'); ?>
                    
                <?php get_sidebar('secondary'); ?>

                <?php reactor_inner_content_after(); ?>
                
                </div><!-- .columns -->
                
            </div><!-- .row -->
        </div><!-- #content -->
        
        <?php reactor_content_after(); ?>
        
	</div><!-- #primary -->

<?php get_footer(); ?>