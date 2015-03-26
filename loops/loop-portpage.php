<?php
/**
 * The loop for displaying posts on the category page template
 *
 * @package reverb
 * @subpackage loops
 * @since 0.1
 */
?>

<?php // the get options
$number_posts = 25;

    $args = array(
        'post_type' => 'page',
        'posts_per_page' => $number_posts,
        'post_parent' => $post->ID,
        );
    
    global $wp_query; 
    $wp_query = new WP_Query( $args ); ?>

    <?php if ( $wp_query->have_posts() ) : ?>
    
    <?php reactor_loop_before(); ?>

    <ul class="large-block-grid-3 medium-block-grid-2 small-block-grid-1">
    	
        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

            <?php get_template_part('post-formats/format', 'portpage'); ?>

        <?php endwhile; // end of the post loop ?>

    </ul>

	<?php endif; ?>
        
    <?php reactor_loop_after(); ?>