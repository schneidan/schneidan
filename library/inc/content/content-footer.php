<?php
/**
 * Footer Content
 * hook in the content for footer.php
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * Footer widgets
 * in footer.php
 * 
 * @since 1.0.0
 */
function reactor_do_footer_widgets() { ?>
	<div class="row">
		<div class="<?php reactor_columns( array( 8, 12, 12 ) ); ?>">
			<div class="inner-footer">
				<?php dynamic_sidebar('footer'); ?>       
				</div><!-- .inner-footer -->
			</div><!-- .columns -->
		</div><!-- .row -->
<?php 
}
//add_action('reactor_footer_inside', 'reactor_do_footer_widgets', 1);

/**
 * Footer links and site info
 * in footer.php
 * 
 * @since 1.0.0
 */
function reactor_do_footer_content() { ?>
	<div class="site-info">
		<div class="row">
	        <div class="<?php reactor_columns( array( 8, 12, 8 ) ); ?>">
				<div class="inner-footer">
					<?php dynamic_sidebar('footer'); ?>       
				</div><!-- .inner-footer -->
			</div><!-- .columns -->
                    
			<div class="<?php reactor_columns( array( 4, 12, 4) ); ?>">
				<div id="colophon">                      
					<?php if ( reactor_option('footer_siteinfo') ) : echo reactor_option('footer_siteinfo'); else : ?>
					<p>All contents <strong>Copyright &#169; 1996-<?php echo date_i18n('Y'); ?> Daniel J. Schneider</strong>. All rights reserved.</p>
					<p>This material may not be copied, published, broadcast, rewritten, redistributed or manipulated without permission for any purpose.</p>
					<p><a href="<?php echo get_site_url(); ?>/disclaimer-and-copyright-notice/">Disclaimer and Copyright Notice</a></p>
					<?php endif; ?>
				</div><!-- #colophon -->
			</div><!-- .columns -->
            
		</div><!-- .row -->
	</div><!-- #site-info -->
<?php 
}
add_action('reactor_footer_inside', 'reactor_do_footer_content', 2);
?>
