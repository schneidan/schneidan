<?php
/**
 * The template for displaying posts by tag
 *
 * @package Reactor
 * @subpackge Templates
 * @since 1.0.0
 */
?>

<?php get_header(); ?>

	<div id="primary" class="site-content">
    
    	<?php reactor_content_before(); ?>
    
        <div id="content" role="main">
        	<div class="row">
                <div class="<?php reactor_columns( 8, 9, 12 ); ?> large-centered medium-centered">
                
                <?php reactor_inner_content_before(); ?>
                
				<?php if ( have_posts() ) : ?>
                    <header class="archive-header">
                        <h1 <?php post_class('archive-title'); ?>><?php echo single_tag_title( '', false ); ?></h1>
                    </header><!-- .archive-header -->
                <?php endif; // end have_posts() check ?> 
                
				<?php // get the loop
				get_template_part('loops/loop', 'tagpage'); ?>
                
                <?php reactor_inner_content_after(); ?>
                
                </div><!-- .columns -->
                
            </div><!-- .row -->
        </div><!-- #content -->
        
        <?php reactor_content_after(); ?>
        
	</div><!-- #primary -->

<?php get_footer(); ?>