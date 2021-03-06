<?php
/**
 * Flexible Posts Widget: Default widget template
 */

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

echo $before_widget;

if ( !empty($title) )
	echo $before_title . $title . $after_title;

if( $flexible_posts->have_posts() ):
	$catquery = get_term_by('id',$flexible_posts->query['tax_query'][0]['terms'][0],'category');
?>
	<ul class="dpe-flexible-posts">
	<?php while( $flexible_posts->have_posts() ) : $flexible_posts->the_post(); global $post; ?>
		<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php
					if( $thumbnail == true ) {
						// If the post has a feature image, show it
						if( has_post_thumbnail() ) { 
							$thumb_size = ( is_category( 'cameras') || is_category( 'stories') ) ? 'large' : 'medium';
							$medium_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $thumb_size); ?>
							<a href="<?php the_permalink(); ?>" rel="bookmark" class="title-link" title="<?php the_title_attribute(); ?>">
								<div class="cat-thumbnail" style="background-image:url('<?php echo $medium_image_url[0]; ?>');">
									<div class="cat-imgholder"></div>
									<h5 class="category-title"><a href="<?php echo get_category_link(intval($catquery->term_id)); ?>" title="<?php echo $catquery->name; ?>"><?php echo $catquery->name; ?></a></h5>
									<a href="<?php the_permalink(); ?>" rel="bookmark" class="title-link" title="<?php the_title_attribute(); ?>">
										<h4 class="title cat-<?php echo $catquery->slug; ?>"><?php the_title(); ?></h4>
									</a>
								</div>
							</a>
					<?php } ?>
				<?php } ?>
		</li>
	<?php endwhile; ?>
	</ul><!-- .dpe-flexible-posts -->
<?php else: // We have no posts ?>
	<div class="dpe-flexible-posts no-posts">
		<p><?php _e( 'No post found', 'flexible-posts-widget' ); ?></p>
	</div>
<?php	
endif; // End have_posts()
	
echo $after_widget;
