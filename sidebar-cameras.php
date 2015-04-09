<?php
/**
 * The sidebar template containing the cameras page widget area
 *
 * @package Reactor
 * @subpackge Templates
 * @since 1.0.0
 */
?>

	<?php // get the front page layout
	wp_reset_postdata();
    $layout =  reactor_option('', '1c', '_template_layout'); ?>
    
    <?php // if front page has one sidebar and the sidebar is active
    if ( is_active_sidebar('sidebar-cameras') ) : ?>
    
        <ul id="sidebar-cameras" class="large-block-grid-4 medium-block-grid-4 small-block-grid-1">
            <?php dynamic_sidebar('sidebar-cameras'); ?>
        </ul><!-- #sidebar-cameras -->
        
    <?php // else show an alert
    else : if ( '1c' != $layout ) : ?>
    
        <div id="sidebar-cameras" class="sidebar <?php reactor_columns( 4, 3, 12 ); ?>" role="complementary">
            <div class="alert-box secondary"><p>Add some widgets to this area!</p></div>
        </div><!-- #sidebar --> 
    
    <?php reactor_sidebar_after(); ?>
    
    <?php endif; endif; ?>