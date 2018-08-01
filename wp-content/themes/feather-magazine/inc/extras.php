<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package feather Lite
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function feather_magazine_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'feather_magazine_body_classes' );

add_action( 'admin_menu', 'feather_magazine_register_backend' );
function feather_magazine_register_backend() {
	add_theme_page( __('Feather Magazine', 'feather-magazine'), __('Feather Magazine', 'feather-magazine'), 'edit_theme_options', 'about-feather_magazine.php', 'feather_magazine_backend');
}

function feather_magazine_backend(){ ?>
<div class="theme-info-wrapper">
	<div class="theme-info-inner">
		<div class="theme-info-left">
			<div class="theme-info-left-inner">
				<a href="https://wordpress.org/support/theme/feather-magazine/reviews/?filter=5" target="_blank">
					<img src="<?php echo get_template_directory_uri(); ?>/interface-img/interface-img.png">
				</a>
				<h2><?php echo esc_html('Plugin or WordPress issues?', 'feather-magazine') ?></h2>
				<p>
					<?php echo esc_html('If you are experiencing issues with plugins, please contact the plugin author. If you are experiencing issues with WordPress functionality then please visit the', 'feather-magazine') ?> <a href="https://wordpress.org/support/" target="_blank"><?php echo esc_html('WordPress Support Forum', 'feather-magazine') ?></a>.
				</p>
				<h2><?php echo esc_html('Theme issues?', 'feather-magazine') ?></h2>
				<p>
					<?php echo esc_html('If you are having theme related problems then please contact us through our', 'feather-magazine') ?>
					<a href="http://admirablethemes.com/contact/" target="_blank"><?php echo esc_html(' contact form', 'feather-magazine') ?></a><?php echo esc_html(', which can be found at', 'feather-magazine') ?> 
					<a href="http://admirablethemes.com/contact/" target="_blank"><?php echo esc_html('http://admirablethemes.com/contact/', 'feather-magazine') ?></a>
				</p>	

				<h2><?php echo esc_html('Need more help?', 'feather-magazine') ?></h2>
				<ul>
					<li><a href="http://admirablethemes.com/feather-mag/" target="_blank"><?php echo esc_html('Feather Magazine Premium', 'feather-magazine') ?></a></li>
					<li><a href="http://admirablethemes.com/contact/" target="_blank"><?php echo esc_html('Contact AdmirableThemes', 'feather-magazine') ?></a></li>
					<li><a href="https://wordpress.org/support/" target="_blank"><?php echo esc_html('WordPress Support Forum', 'feather-magazine') ?></a></li>
				</ul>
			</div>
		</div>
		<div class="theme-info-right">
			<a href="http://admirablethemes.com/feather-mag/" target="_blank" style="display:block;">
					<img src="<?php echo get_template_directory_uri(); ?>/interface-img/feathermag.png">
			</a>
		</div>
	</div>
</div>
<?php }



/**
 * Extras
 */

function feather_magazine_load_custom_wp_admin_style( $hook ) {
	if ( 'appearance_page_about-feather_magazine' !== $hook ) {
		return;
	}
	wp_enqueue_style( 'feather_magazine-custom-admin-css', get_template_directory_uri() . '/css/themeinfo.css', false, '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'feather_magazine_load_custom_wp_admin_style' );
