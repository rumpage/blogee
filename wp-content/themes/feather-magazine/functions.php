<?php
/**
 * feather Lite functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package feather Lite
 */

if ( ! function_exists( 'feather_magazine_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */


function feather_magazine_setup() {
    /*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on feather, use a find and replace
	 * to change 'feather-magazine' to the name of your theme in all the template files.
	 */
    load_theme_textdomain( 'feather-magazine', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true );
	add_image_size( 'feather-magazine-related', 200, 125, true ); //related

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'feather-magazine' ),
   ) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
   ) );

	// Set up the WordPress core custom background feature.
  add_theme_support( 'custom-background', apply_filters( 'feather_magazine_custom_background_args', array(
    'default-color' => '#fff',
    'default-image' => '',
    ) ) );
}
endif;
add_action( 'after_setup_theme', 'feather_magazine_setup' );

function feather_magazine_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'feather_magazine_content_width', 678 );
}
add_action( 'after_setup_theme', 'feather_magazine_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function feather_magazine_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'feather-magazine' ),
		'id'            => 'sidebar',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
   ) );

	// Header Ad sidebar
  register_sidebar(array(
    'name' => __('Header Ad', 'feather-magazine'),
    'description'   => __( '728x90 Ad Area', 'feather-magazine' ),
    'id' => 'widget-header',
    'before_widget' => '<div id="%1$s" class="widget-header">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ));

    // First Footer 
  register_sidebar( array(
    'name'          => __( 'Footer 1', 'feather-magazine' ),
    'description'   => __( 'First footer column', 'feather-magazine' ),
    'id'            => 'footer-first',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );

	// Second Footer 
  register_sidebar( array(
    'name'          => __( 'Footer 2', 'feather-magazine' ),
    'description'   => __( 'Second footer column', 'feather-magazine' ),
    'id'            => 'footer-second',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );

	// Third Footer 
  register_sidebar( array(
    'name'          => __( 'Footer 3', 'feather-magazine' ),
    'description'   => __( 'Third footer column', 'feather-magazine' ),
    'id'            => 'footer-third',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'feather_magazine_widgets_init' );

function feather_magazine_custom_sidebar() {
  $sidebar = 'sidebar';
  return $sidebar;
}

/**
 * Enqueue scripts and styles.
 */
function feather_magazine_scripts() {
	wp_enqueue_style( 'feather-magazine-style', get_stylesheet_uri() );

	$handle = 'feather-magazine-style';

  wp_enqueue_script( 'feather-magazine-customscripts', get_template_directory_uri() . '/js/customscripts.js',array('jquery'),'',true); 

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'feather_magazine_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Copyrights
 */
if ( ! function_exists( 'feather_magazine_copyrights_credit' ) ) {
  function feather_magazine_copyrights_credit() { 
    global $feathermagazine_options
    ?>
    <!--start copyrights-->
    <div class="copyrights">
      <div class="container">
        <div class="row" id="copyright-note">
          <span>

            <?php
            $feather_magazine_copyright_text = get_theme_mod('feather_magazine_copyright_text', 'Copyright 2017 - Powered By WordPress ');
            echo esc_html($feather_magazine_copyright_text); 
            ?>
            <?php echo esc_html(' - Design By', 'feather-mag')?> <a href="<?php echo esc_url('http://admirablethemes.com/')?>"><?php echo esc_html('Admirable Themes', 'feather-mag')?></a>
          </span>
          <div class="top">

            <a href="#top" class="toplink"><?php esc_html_e('Back to Top','feather-magazine'); ?> &uarr;</a>
          </div>
        </div>
      </div>
    </div>
    <!--end copyrights-->
    <?php }
  }

/**
 * Custom Comments template
 */
if ( ! function_exists( 'feather_magazine_comments' ) ) {
	function feather_magazine_comment($comment, $args, $depth) { ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
   <div id="comment-<?php comment_ID(); ?>" style="position:relative;" itemscope itemtype="http://schema.org/UserComments">
    <div class="comment-author vcard">
     <?php echo get_avatar( $comment->comment_author_email, 70 ); ?>
     <div class="comment-metadata">
      <?php printf('<span class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s</span>', get_comment_author_link()) ?>
      <span class="comment-meta">
        <?php edit_comment_link(__('(Edit)', 'feather-magazine'),'  ','') ?>
      </span>
    </div>
  </div>
  <?php if ($comment->comment_approved == '0') : ?>
  <em><?php esc_html_e('Your comment is awaiting moderation.', 'feather-magazine') ?></em>
  <br />
<?php endif; ?>
<div class="commentmetadata" itemprop="commentText">
 <?php comment_text() ?>
 <time><?php comment_date(get_option( 'date_format' )); ?></time>
 <span class="reply">
  <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
</span>
</div>
</div>
</li>
<?php }
}

/*
 * Excerpt
 */
function feather_magazine_excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt);
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

/**
 * Shorthand function to check for more tag in post.
 *
 * @return bool|int
 */
function feather_magazine_post_has_moretag() {
  return strpos( get_the_content(), '<!--more-->' );
}

if ( ! function_exists( 'feather_magazine_readmore' ) ) {
    /**
     * Display a "read more" link.
     */
    function feather_magazine_readmore() {
      ?>
      <div class="readMore">
        <a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
          <?php esc_html_e( 'Read More', 'feather-magazine' ); ?>
        </a>
      </div>
      <?php 
    }
  }

/**
 * Breadcrumbs
 */
if (!function_exists('feather_magazine_the_breadcrumb')) {
  function feather_magazine_the_breadcrumb() {
    if ( is_front_page() ) {
      return;
    }
    echo '<span typeof="v:Breadcrumb" class="root"><a rel="v:url" property="v:title" href="';
    echo esc_url( home_url() );
    echo '">'.esc_html(sprintf( __( "Home", 'feather-magazine' )));
    echo '</a></span><span><i class="feather-icon icon-angle-double-right"></i></span>';
    if (is_single()) {
      $categories = get_the_category();
      if ( $categories ) {
        $level = 0;
        $hierarchy_arr = array();
        foreach ( $categories as $cat ) {
          $anc = get_ancestors( $cat->term_id, 'category' );
          $count_anc = count( $anc );
          if (  0 < $count_anc && $level < $count_anc ) {
            $level = $count_anc;
            $hierarchy_arr = array_reverse( $anc );
            array_push( $hierarchy_arr, $cat->term_id );
          }
        }
        if ( empty( $hierarchy_arr ) ) {
          $category = $categories[0];
          echo '<span typeof="v:Breadcrumb"><a href="'. esc_url( get_category_link( $category->term_id ) ).'" rel="v:url" property="v:title">'.esc_html( $category->name ).'</a></span><span><i class="feather-icon icon-angle-double-right"></i></span>';
        } else {
          foreach ( $hierarchy_arr as $cat_id ) {
            $category = get_term_by( 'id', $cat_id, 'category' );
            echo '<span typeof="v:Breadcrumb"><a href="'. esc_url( get_category_link( $category->term_id ) ).'" rel="v:url" property="v:title">'.esc_html( $category->name ).'</a></span><span><i class="feather-icon icon-angle-double-right"></i></span>';
          }
        }
      }
      echo "<span><span>";
      the_title();
      echo "</span></span>";
    } elseif (is_page()) {
      $parent_id  = wp_get_post_parent_id( get_the_ID() );
      if ( $parent_id ) {
        $breadcrumbs = array();
        while ( $parent_id ) {
          $page = get_page( $parent_id );
          $breadcrumbs[] = '<span typeof="v:Breadcrumb"><a href="'.esc_url( get_permalink( $page->ID ) ).'" rel="v:url" property="v:title">'.esc_html( get_the_title($page->ID) ). '</a></span><span><i class="feather-icon icon-angle-double-right"></i></span>';
          $parent_id  = $page->post_parent;
        }
        $breadcrumbs = array_reverse( $breadcrumbs );
        foreach ( $breadcrumbs as $crumb ) { echo esc_html($crumb); }
      }
      echo "<span><span>";
      the_title();
      echo "</span></span>";
    } elseif (is_category()) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $this_cat_id = $cat_obj->term_id;
      $hierarchy_arr = get_ancestors( $this_cat_id, 'category' );
      if ( $hierarchy_arr ) {
        $hierarchy_arr = array_reverse( $hierarchy_arr );
        foreach ( $hierarchy_arr as $cat_id ) {
          $category = get_term_by( 'id', $cat_id, 'category' );
          echo '<span typeof="v:Breadcrumb"><a href="'.esc_url( get_category_link( $category->term_id ) ).'" rel="v:url" property="v:title">'.esc_html( $category->name ).'</a></span><span><i class="feather-icon icon-angle-double-right"></i></span>';
        }
      }
      echo "<span><span>";
      single_cat_title();
      echo "</span></span>";
    } elseif (is_author()) {
      echo "<span><span>";
      if(get_query_var('author_name')) :
        $curauth = get_user_by('slug', get_query_var('author_name'));
      else :
        $curauth = get_userdata(get_query_var('author'));
      endif;
      echo esc_html( $curauth->nickname );
      echo "</span></span>";
    } elseif (is_search()) {
      echo "<span><span>";
      the_search_query();
      echo "</span></span>";
    } elseif (is_tag()) {
      echo "<span><span>";
      single_tag_title();
      echo "</span></span>";
    }
  }
}

/*
 * Customizer button
 */

require_once( trailingslashit( get_template_directory() ) . 'trt-customizer-pro/class-customize.php' );

/*
 * Google Fonts
 */
function feather_magazine_fonts_url() {
  $fonts_url = '';

    /* Translators: If there are characters in your language that are not
    * supported by Monda, translate this to 'off'. Do not translate
    * into your own language.
    */
    $monda = _x( 'on', 'Monda font: on or off', 'feather-magazine' );

    if ( 'off' !== $monda ) {
      $font_families = array();

      if ( 'off' !== $monda ) {
        $font_families[] = urldecode('Roboto:400,500,700,900');
      }

      $query_args = array(
        'family' => urlencode( implode( '|', $font_families ) ),
            //'subset' => urlencode( 'latin,latin-ext' ),
        );

      $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }

    return $fonts_url;
  }

  function feather_magazine_scripts_styles() {
    wp_enqueue_style( 'feather-magazine-fonts', feather_magazine_fonts_url(), array(), null );
  }
  add_action( 'wp_enqueue_scripts', 'feather_magazine_scripts_styles' );

/**
 * WP Mega Menu Plugin Support
 */
function feather_magazine_megamenu_parent_element( $selector ) {
  return '.primary-navigation .container';
}
add_filter( 'wpmm_container_selector', 'feather_magazine_megamenu_parent_element' );

/**
 * Post Layout for Archives
 */
if ( ! function_exists( 'feather_magazine_archive_post' ) ) {
    /**
     * Display a post of specific layout.
     * 
     * @param string $layout
     */
    function feather_magazine_archive_post( $layout = '' ) { 
       ?>
      <article class="post excerpt">
       
       <?php if ( has_post_thumbnail() ) { ?>
        <div class="post-blogs-container-thumbnails">
       <?php } else { ?>
        <div class="post-blogs-container">
       <?php } ?>
     
        <?php if ( empty($feather_magazine_full_posts) ) : ?>


        <?php if ( has_post_thumbnail() ) { ?>
        <div class="featured-thumbnail-container">
          <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" id="featured-thumbnail">
              <?php  $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');  
              echo '<div class="blog-featured-thumbnail" style="background-image:url('.esc_url($featured_img_url).')"></div>';
              ?>
          </a>
        </div>
        <div class="thumbnail-post-content">
        <?php } else { ?>
         <div class="nothumbnail-post-content">
        <?php } ?>


        <h2 class="title">
          <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h2>

    <span class="entry-meta">
      <?php echo get_the_date(); ?>
   <?php
        if ( is_sticky() && is_home() && ! is_paged() ) {
          printf( ' / <span class="sticky-text">%s</span>', __( 'Featured', 'feather-magazine' ) );
        } ?>
    </span>
        <div class="post-content">
          <?php echo esc_html(feather_magazine_excerpt(26)); ?><?php echo __('...','feather-magazine'); ?>
        </div>
      <?php else : ?>
      <?php if (feather_magazine_post_has_moretag()) : ?>
      <?php feather_magazine_readmore(); ?>
      </div>
    </div>
    <?php endif; ?>
  <?php endif; ?>

</article>
<?php }
}
