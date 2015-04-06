<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package Reactor
 * @subpackage Post-Formats
 * @since 1.0.0
 */
?>

	<article id="post-0" class="post no-results not-found">
		<header class="entry-header">
			<h1 class="entry-title"><?php _e('Error 404 - Not Found', 'reactor'); ?></h1>
		</header>

		<div class="entry-content">
			<h3>Cause that's not really a thing...</h3>
			<p><?php _e('That page does not appear to actually exist. This error has been logged and will be investigated.', 'reactor'); ?></p>
			<p><?php _e('Would you like to try searching for something else?', 'reactor'); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-0 -->

	<div id="sidebar-2" class="sidebar large-12 small-12 columns" role="complementary">
        <div id="related_widget-2" class="widget related_widget">
        	<h4 class="widget-title">Related articles</h4>
	        <?php global $related; echo $related->show( '2929' ); ?>
        </div>
	</div>