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
if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $number_posts,
        'cat' => get_queried_object_id(),
        'paged' => get_query_var( 'paged' ),
        );
    
    global $wp_query; 
    $wp_query = new WP_Query( $args ); ?>

    <?php if ( $wp_query->have_posts() ) : ?>
    
    <?php reactor_loop_before(); ?>

        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

            <?php get_template_part('post-formats/format', 'catpage'); ?>

        <?php endwhile; // end of the post loop ?>

	<?php endif; ?>
        
    <?php reactor_loop_after(); ?>