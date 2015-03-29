<?php 
/**
 * Reactor Post Meta
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @credit TewentyTwelve Theme
 * @usees $post
 * @param $args Optional. Override defaults.
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * Meta information for current post: categories, tags, author, and date
 */
if ( !function_exists('reactor_post_meta') ) {
	function reactor_post_meta( $args = '' ) {
		
		do_action('reactor_post_meta', $args);
		
		global $post; $meta = ''; $output = '';
		
		$defaults = array( 
			'show_author' => true,
			'show_date'   => true,
			'link_date'		=> true,
			'show_cat'    => true,
			'show_tag'    => true,
			'show_icons'  => false,
			'show_uncategorized' => false,
			'comments' => false,
			'catpage' => false,
			'date_only' => false,
		 );
        $args = wp_parse_args( $args, $defaults );
		
		if ( 'portfolio' == get_post_type() ) {
			$categories_list = get_the_term_list( $post->ID, 'portfolio-category', '', ', ', '' );
		} else {
			// $categories_list = get_the_category_list(', ');
			$count = 0;
			$categories_list = '';
			$categories = get_the_category();			
			foreach ( $categories as $category ) {
				$count++;
				if ( $args['show_uncategorized'] ) {
					$categories_list .= '<a href="' . get_category_link( $category->term_id ) . '" title="'.sprintf( __('View all posts in %s', 'reactor'), $category->name ) . '">' . $category->name . '</a>';
					if ( $count != count( $categories ) ){
						$categories_list .= ', ';
					}
				} else {
					if ( $category->slug != 'uncategorized' || $category->name != 'Uncategorized' ) {
						$categories_list .= '<a href="' . get_category_link( $category->term_id ) . '" title="'.sprintf( __('View all posts in %s', 'reactor'), $category->name ) . '">' . $category->name . '</a>';
						if ( $count != count( $categories ) ){
							$categories_list .= ', ';
						}
					}
				}
					
			}
		}
		
		if ( 'portfolio' == get_post_type() ) {
			$tag_list = get_the_term_list( $post->ID, 'portfolio-tag', '', ', ', '' );
		} else {
			$tag_list = get_the_tag_list( '', ', ', '' );
		}
	
		$posted_on = ( $args['date_only'] ) ? 'Posted: ' : '';
		$raw_date = ( $args['link_date'] ) ? $posted_on . '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>' : $posted_on . '<time class="entry-date" datetime="%3$s">%4$s</time>';
		$date = sprintf( $raw_date,
			esc_url( get_month_link( get_the_time('Y'), get_the_time('m') ) ),
			esc_attr( sprintf( __('View all posts from %s %s', 'reactor'), get_the_time('M'), get_the_time('Y') ) ),
			esc_attr( get_the_date('c') ),
			esc_html( get_the_date() )
		 );
	
		$authorraw = 'By <a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a>';
		$author = sprintf($authorraw,
			esc_url( get_author_posts_url( get_the_author_meta('ID') ) ),
			esc_attr( sprintf( __('View all posts by %s', 'reactor'), get_the_author() ) ),
			get_the_author()
		 );

		$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
		if ( $num_comments == 0 ) {
			$comments = __('No Comments');
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . __(' Comments');
		} else {
			$comments = __('1 Comment');
		}
		$comments = '<span class="comments fi-comment right"><a href="' . get_comments_link() .'"><span>'. $comments.'</span></a></span>';

		/**
		 * 1	category
		 * 2	tag
		 * 3	date
		 * 4 	author's name
		 * 5	comments
		 */
		if ( $date || $categories_list || $author || $tag_list ) {
			if ( $args['catpage'] ) {
				$meta .= ( $author && $args['show_author'] ) ? '<span class="by-author">%4$s</span> ' : '';
				$meta .= ( $date && $args['show_date'] ) ? '<span class="posted-time">%3$s</span>' : '';
				$meta .= ( $comments && $args['comments'] ) ? '%5$s ' : '';
				$meta .= ( $categories_list && $args['show_cat'] ) ? __('in', 'reactor') . ' %1$s' : '';
				$meta .= ( $tag_list && $args['show_tag'] ) ? '<div class="entry-tags">' . __('Tags:', 'reactor') . ' %2$s</div>' : '';

				if ( $meta ) {
					$output = '<div class="entry-meta">' . $meta . '</div>';
				}
			} else if ( $args['show_icons'] ) {
				$meta .= ( $author && $args['show_author'] ) ? '<i class="social foundicon-torso" title="Written by"></i> <span class="by-author">%4$s</span>' : '';
				$meta .= ( $date && $args['show_date'] ) ? '<i class="general foundicon-calendar" title="Publish on"></i> %3$s' : '';
				$meta .= ( $categories_list && $args['show_cat'] ) ? '<i class="general foundicon-folder" title="Posted in"></i> %1$s' : '';
				$meta .= ( $tag_list && $args['show_tag'] ) ? '<div class="entry-tags"><i class="general foundicon-flag" title="Tagged with"></i> %2$s</div>' : '';
				
				if ( $meta ) {
					$output = '<div class="entry-meta icons">' . $meta . '</div>';
				}
			} else if ( $args['show_tag'] ) {
				$meta .= ( $tag_list ) ? '<div class="entry-tags">Topics: %2$s</div>' : '';
				
				if ( $meta ) {
					$output = '<div class="entry-meta">' . $meta . '</div>';
				}
			}
	
			$post_meta = sprintf( $output, $categories_list, $tag_list, $date, $author, $comments );

			echo apply_filters('reactor_post_meta', $post_meta, $defaults);
		}
	}
}