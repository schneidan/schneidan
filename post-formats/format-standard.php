<?php
/**
 * The template for displaying post content
 *
 * @package Reactor
 * @subpackage Post-Formats
 * @since 1.0.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-body">
            
            <header class="entry-header">
            	<?php reactor_post_header(); ?>
            </header><!-- .entry-header -->
    
            <?php if ( is_search() || is_archive() ) : // Only display Excerpts for Search ?>
            <div class="entry-summary">
                <?php the_excerpt(); ?>
            </div><!-- .entry-summary -->
            <?php elseif ( is_single() ) : ?>
            <div class="entry-content">
                <div class="post-before hide-for-small">
                    <?php reactor_post_social(); ?>
                </div>
                <?php if (in_category(161)):
                    if ( has_post_thumbnail() ) {
                        $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium');
                    } ?>
                    <div class="catgrid-thumbnail" style="background-image:url('<?php echo $large_image_url[0]; ?>');">
                            <div class="cat-imgholder"></div>
                    </div>
                    <?php $usp_author = get_post_meta($post->ID, 'usp-author', true); if ($usp_author !=''): ?>
                        <p>Submitted by: <strong><?php echo $usp_author; ?></strong></p>
                    <?php endif; ?>
                    <?php $usp_url = get_post_meta($post->ID, 'usp-url', true); if ($usp_url !=''): ?>
                        <p>Link: <strong><a href="<?php echo $usp_url; ?>"><?php echo $usp_url; ?></a></strong></p>
                    <?php endif; ?>
                    <p>About the photo and the film:</p>
                <?php endif; ?>
                <?php the_content(); ?>
                <?php wp_link_pages( array('before' => '<div class="page-links">' . __('Pages:', 'reactor'), 'after' => '</div>') ); ?>
                <div class="post-after">
                    <?php reactor_post_social(); ?>
                </div>
            </div><!-- .entry-content --> 
            <?php else : ?>
            <div class="entry-content">
                <?php the_content(); ?>
            </div><!-- .entry-content -->
            <?php endif; ?>
    
            <footer class="entry-footer">
            	<?php reactor_post_footer(); ?>
            </footer><!-- .entry-footer -->
        </div><!-- .entry-body -->
	</article><!-- #post -->