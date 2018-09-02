<?php
/*
Plugin Name: Thumbnail_Create
Plugin URI:
Description: Plug-in to set thumbnails automatically
Version:     1.1
Author:      melo
Author URI:  https://milkycocoa.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

/*  Copyright 2017 melo (email : info@milkycocoa.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
     published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
load_plugin_textdomain('your-unique-name', false, basename( dirname( __FILE__ ) ) . '/languages' );
define( 'TC_THUMBNAIL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );



add_action('admin_menu', 'thumbnail_create_menu');
add_action('thumbnail_create_add', 'thumbnail_create_action');

function thumbnail_create_menu() {
    add_options_page('サムネ取得', 'サムネ取得', 'manage_options', 'thumbnail_create_menu', 'thumbnail_create_options');
}

function thumbnail_create_options() {
if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    ?>

   <div class="wrap">
        <h2>サムネイル自動取得、作成</h2>
        <p>サムネイルがない記事に画像素材サイトから画像をダウンロードして設定します</p>



        <form id="genethum" method="post" action="">
<?php wp_nonce_field( 'tcn','tcn_non' ); ?>

                    <p><input type="submit" class="button" name="genethum" id="genethum" value="サムネイルを作成する" /></p>



                </form>

                <p>
                  寄付にご協力していただける方はこちら<br />
                  -開発資金に使用されます-
                  donation here <br />
                  - Used for development -
                </p>
                <p>
                  amazon
                  <a href="http://amzn.asia/inFG9o0" target="_blank">ほしいものリスト</a><br />
                  bit coin<br />
                  1BAoUeFVthwb4YX9X9oepf8GgEFb9HpFvW
                </p>
    </div>
    <?php
}
?>
<?php
require_once( TC_THUMBNAIL_PLUGIN_DIR . 'thumbnail_create_c.php' );

function thumbnail_create_action(){

    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
     check_admin_referer( 'tcn','tcn_non');
    global $wpdb;
    $getpost = $wpdb->get_results("
    SELECT ID
    FROM $wpdb->posts
    WHERE post_status = 'publish'
    AND post_type = 'post'
    ");
    foreach ($getpost as $post) {
     $getpost_id = $post->ID;
    if ( has_post_thumbnail($getpost_id) ) {
    }else{
        echo $getpost_id;
       do_action( 'thumbnail_create_new',$getpost_id );
    }
}
}

if ( !empty($_POST['genethum']) ) {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
     check_admin_referer( 'tcn','tcn_non');

do_action( 'thumbnail_create_add');
}

register_uninstall_hook( __FILE__, 'newgeneratethum' );
