<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package feather Lite
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function feather_magazine_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'content',
		'render'    => 'feather_magazine_infinite_scroll_render',
		'footer'    => 'site-footer',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'feather_magazine_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function feather_magazine_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
		    feather_magazine_archive_post();
		else :
		    feather_magazine_archive_post();
		endif;
	}
}
