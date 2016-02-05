<?php
/**
 * The loop for displaying posts on the front page template
 *
 * @package Reactor
 * @subpackage loops
 * @since 1.0.0
 */
?>

<?php // get the options
$post_category = reactor_option('frontpage_post_category', '');
if ( -1 == $post_category ) { $post_category = ''; } // fix customizer -1
$number_posts = reactor_option('frontpage_number_posts', 1);
$post_columns = reactor_option('frontpage_post_columns', 3);
$exclude_cat = array(161);
$page_links = 0;
$args = array(
	'post_type'           => 'post',
	'cat'                 => $post_category,
	'category__not_in'	  => $exclude_cat,
	'posts_per_page'      => $number_posts
	);

global $frontpage_query;
$frontpage_query = new WP_Query( $args ); ?>
      
<?php if ( $frontpage_query->have_posts() ) : ?>

	<?php reactor_loop_before(); ?>
	    
	    <?php $runonce = false; 
	    while ( $frontpage_query->have_posts() && $runonce == false ) : $frontpage_query->the_post(); global $more; $more = 0;global $frontpage_post_id; $frontpage_post_id = get_the_id(); ?>
	    	
	        <?php reactor_post_before(); ?>
	            
	            <?php // display frontpage post format
				get_template_part('post-formats/format', 'frontpage');
				$runonce = true; ?>
	        
	        <?php reactor_post_after(); ?>

	    <?php endwhile; // end of the loop ?>

	<?php reactor_loop_after(); ?>
	        
<?php // if no posts are found
else : reactor_loop_else(); ?>

<?php endif; // end have_posts() check ?>