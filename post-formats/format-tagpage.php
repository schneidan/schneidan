<?php
/**
 * The template for displaying tag archive content
 *
 * @package Reactor
 * @subpackage Post-Formats
 * @since 1.0.0
 */
?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-body">

            <?php reactor_post_tagpage(); ?>
             
        </div><!-- .entry-body -->
    </article><!-- #post -->