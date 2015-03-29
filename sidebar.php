<?php
/**
 * The sidebar template containing the main widget area
 *
 * @package Reactor
 * @subpackge Templates
 * @since 1.0.0
 */
?>
	<?php // get the page layout
	wp_reset_postdata(); 
	$default = reactor_option('page_layout', '2c-l');
	$layout = reactor_option('', $default, '_template_layout'); ?>

    <?php // if layout has two sidebars and second sidear is active
    if ( is_active_sidebar('sidebar-2') ) : ?>
    
    <?php reactor_sidebar_before(); ?>
    
        <div id="sidebar-2" class="sidebar <?php reactor_columns(12,12,12); ?>" role="complementary">
            <?php dynamic_sidebar('sidebar-2'); ?>
        </div><!-- #sidebar-2 -->
        
    <?php // else show an alert
    else : if ( '1c' != $layout ) : ?>
    
        <div id="sidebar-2" class="sidebar <?php reactor_columns(12,12,12); ?>" role="complementary">
            <div class="alert-box secondary"><p>Add some widgets to this area!</p></div>
        </div><!-- #sidebar-2 -->
        
    <?php reactor_sidebar_after(); ?>
        
    <?php endif; endif; ?>