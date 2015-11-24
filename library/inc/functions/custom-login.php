<?php
/**
 * Customize Login
 * Portfolio, Slider and custom taxonomies
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @link http://wp.smashingmagazine.com/2012/05/17/customize-wordpress-admin-easily/
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * 1. Change logo on login page
 * 2. Custom logo link url
 * 3. Logo title attribute text
 * 4. Change the order of admin menu items
 */

/**
 * 1. Change logo on login page
 *
 * @since 1.0.0
 */
function reactor_login_logo() {
	if ( reactor_option('login_logo') ) {
		$output  = "\n" . '<style type="text/css">';
		$output .= "\n\t" . 'h1 a { background-image: url("' . reactor_option('login_logo') . '") !important;' . "\n\t" . 'background-size: 84px 84px !important; }' . "\n";
		$output .= "\n\t" . 'body, html { background:#fff!important; }' . "\n";
		$output .= "\n\t" . '.login form { -webkit-box-shadow:none!important;box-shadow:none!important; }' . "\n";
		$output .= "\n\t" . '.wp-core-ui .button-primary { background: #d1d1d1!important;border-color: #858585!important;-webkit-box-shadow: inset 0 1px 0 #d1d1d1,0 1px 0 #d1d1d1!important;box-shadow: inset 0 1px 0 #d1d1d1,0 1px 0 #d1d1d1!important;color: #444!important; }' . "\n";
		$output .= '</style>' . "\n";
				
		echo $output;
	}
}
add_action('login_head', 'reactor_login_logo');

/**
 * 2. Custom logo link url
 *
 * @since 1.0.0
 */
function reactor_login_logo_url() {
	if ( reactor_option('login_logo_url') ) {
		return reactor_option('login_logo_url'); 
	}
}
add_filter('login_headerurl', 'reactor_login_logo_url');

/**
 * 3. Logo title attribute text
 *
 * @since 1.0.0
 */
function reactor_login_logo_title() {
	if ( reactor_option('login_logo_title') ) {
		return reactor_option('login_logo_title'); 
	}
}
add_filter('login_headertitle', 'reactor_login_logo_title');

/**
 * 4. Login message
 *
 * @since 1.0.0
 */
function reactor_login_message() {
	if ( reactor_option('login_message') ) {
		return '<p style="text-align:center;font-size:150%;">' . reactor_option('login_message') . '</p>'; 
	}
}
add_filter('login_message', 'reactor_login_message');

?>