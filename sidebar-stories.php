<?php
/**
 * The sidebar template containing the stories page widget area
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
    if ( is_active_sidebar('sidebar-stories') ) : ?>
    
        <ul id="sidebar-stories" class="large-block-grid-3 medium-block-grid-3 small-block-grid-1">
            <?php dynamic_sidebar('sidebar-stories'); ?>
        </ul><!-- #sidebar-cameras -->
        
    <?php // else show an alert
    else : if ( '1c' != $layout ) : ?>
    
        <div id="sidebar-stories" class="sidebar <?php reactor_columns( 4, 3, 12 ); ?>" role="complementary">
            <div class="alert-box secondary"><p>Add some widgets to this area!</p></div>
        </div><!-- #sidebar --> 
    
    <?php reactor_sidebar_after(); ?>
    
    <?php endif; endif; ?>