<?php
//子テーマのCSSの読み込み
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  wp_enqueue_style( 'child-style',
  	get_stylesheet_directory_uri() . '/style.css',
  	array('sng-stylesheet','sng-option')
	);
}
/************************
 *function.phpへの追記は以下に
 *************************/
 // 記事IDを指定して抜粋文を取得する
 // function ltl_get_the_excerpt($post_id){
 //   global $post;
 //   $post_bu = $post;
 //   $post = get_post($post_id);
 //   $output = get_the_excerpt();
 //   $post = $post_bu;
 //   return $output;
 // }
 //
 // //内部リンクをはてなカード風にするショートコード
 // function nlink_scode($atts) {
 // 	extract(shortcode_atts(array(
 // 		'url'=>"",
 // 		'title'=>"",
 // 		'excerpt'=>""
 // 	),$atts));
 //
 // 	$id = url_to_postid($url);//URLから投稿IDを取得
 //
 // 	$img_width ="90";//画像サイズの幅指定
 // 	$img_height = "90";//画像サイズの高さ指定
 // 	$no_image = 'noimageに指定したい画像があればここにパス';//アイキャッチ画像がない場合の画像を指定
 //
 // 	//タイトルを取得
 // 	if(empty($title)){
 // 		$title = esc_html(get_the_title($id));
 // 	}
 //     //抜粋文を取得
 // 	if(empty($excerpt)){
 // 		$excerpt = esc_html(ltl_get_the_excerpt($id));
 // 	}
 //
 //     //アイキャッチ画像を取得
 //     if(has_post_thumbnail($id)) {
 //         $img = wp_get_attachment_image_src(get_post_thumbnail_id($id),array($img_width,$img_height));
 //         $img_tag = "<img src='" . $img[0] . "' alt='{$title}' width=" . $img[1] . " height=" . $img[2] . " />";
 //     }else{
 //     $img_tag ='<img src="'.$no_image.'" alt="" width="'.$img_width.'" height="'.$img_height.'" />';
 //     }
 //
 // 	$nlink .='
 // <div class="blog-card">
 //   <a href="'. $url .'">
 //       <div class="blog-card-thumbnail">'. $img_tag .'</div>
 //       <div class="blog-card-content">
 //           <div class="blog-card-title">'. $title .' </div>
 //           <div class="blog-card-excerpt">'. $excerpt .'</div>
 //       </div>
 //       <div class="clear"></div>
 //   </a>
 // </div>';
 //
 // 	return $nlink;
 // }
 //
 // add_shortcode("nlink", "nlink_scode");
 //
 // // get_id_val関数の定義
 // function get_id_val() {
 //   // パラメーター「id」の値を取得
 //   $val = (isset($_GET['key']) && $_GET['key'] != '') ? $_GET["key"] : '';
 //   // エスケープ処理
 //   $val = htmlspecialchars($val, ENT_QUOTES);
 //
 //   // $valを戻り値として設定（ショートコードの値となる）
 //   return $val;
 // }

 // ショートコード[id]にget_id_val関数をセット
 // add_shortcode('id', 'get_id_val');
 //
 // function custom_rewrite_basic() {
 //   add_rewrite_rule('blogee/([0-9]+)/?', '/blogee/?page_id=$matches[1]', 'top');
 // }
 // add_action('init', 'custom_rewrite_basic');

// function show_recentEntry() {
//     global $post;
//
//     $val = (isset($_GET['key']) && $_GET['key'] != '') ? $_GET["key"] : '';
//     $val = htmlspecialchars($val, ENT_QUOTES);
//
//      $target_post = "";
//
//      $output = "<dl>\n";
//
//      $lists = get_posts( array(
//          'posts_per_page' => 10,
//          'post__not_in' => array($val)
//        )
//      );
//
//      foreach( $lists as $post ){
//          // $output .= "<dt>".get_the_date()."</dt>\n<dd><a href=\"".get_the_permalink()."\">".get_the_title()."</a></dd>\n";
//          // $output .= "<dt>".get_the_date()."</dt>\n<dd><a href=\"".get_the_permalink()."\">".get_the_title()."</a></dd>\n";
//          $url = get_the_permalink();
//          $output .= "<dt>".get_the_date()."</dt>\n<dd>".do_shortcode("[blogcard url=$url]")."</dd>\n";
//          // $output .= "<dt>".get_the_date()."</dt>\n<dd>".do_shortcode("[sanko href=$aa title='松下' site='apple']")."</dd>\n";
//      }
//
//      $output = $target_post.$output."</dl>\n";
//
//      return $output;
//  }
//  add_shortcode('entryList', 'show_recentEntry');
/************************
 *function.phpへの追記はこの上に
 *************************/
?>
