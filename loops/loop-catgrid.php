<?php
/**
 * The loop for displaying posts on the category page template
 *
 * @package schneidan
 * @subpackage loops
 * @since 0.1
 */
?>

<?php // the get options
$number_posts = (in_category(161)) ? 100 : 40;
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

        <ul class="large-block-grid-4 medium-block-grid-3 small-block-grid-2">

        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

            <?php get_template_part('post-formats/format', 'catgrid'); ?>

        <?php endwhile; // end of the post loop ?>

        </ul>

	<?php endif; ?>
        
    <?php reactor_loop_after(); ?>