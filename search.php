<?php
/**
 * The template for displaying search results
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
                
			<?php query_posts('showposts=25');
			if ( have_posts() ) : ?>
			
				<?php reactor_loop_before(); ?>
				
                	        <header class="page-header">
                        	<h1 class="page-title"><span class="searchresults">Search results for:</span> <?php echo get_search_query(); ?></h1>
                    		</header> 

				<?php // start the loop
				while ( have_posts() ) : the_post(); ?>
				
					<?php // get post format and display template for that format
					if ( !get_post_format() ) : get_template_part('post-formats/format', 'catpage');
					else : get_template_part('post-formats/catpage', get_post_format()); endif; ?>
					
				<?php endwhile; ?>
				
				<?php reactor_loop_after(); ?>
				
				<?php // if no posts are found
				else : reactor_loop_else(); ?>
				
			<?php endif; // end have_posts() check ?> 
                
                <?php reactor_inner_content_after(); ?>
                
                </div><!-- .columns -->
                
            </div><!-- .row -->
        </div><!-- #content -->
        
        <?php reactor_content_after(); ?>
        
	</div><!-- #primary -->

<?php get_footer(); ?>
