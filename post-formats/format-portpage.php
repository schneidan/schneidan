<?php
/**
 * The template for displaying post content
 *
 * @package Reactor
 * @subpackage Post-Formats
 * @since 1.0.0
 */
?>

<li>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-body">

            <?php reactor_post_portpage(); ?>
             
        </div><!-- .entry-body -->
    </article><!-- #post -->
</li>