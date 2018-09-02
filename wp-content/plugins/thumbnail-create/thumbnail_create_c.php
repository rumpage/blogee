<?php
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
require_once( TC_THUMBNAIL_PLUGIN_DIR . 'vendor/autoload.php' );
require_once ( ABSPATH.WPINC . '/pluggable.php');
use Goutte\Client;
add_action ( 'thumbnail_create_new', 'add_tc_getthumbnail' );

function add_tc_getthumbnail($post_id){
     $filename = date("Ymdhis");
    static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
     $str = '';
     for ($i = 0; $i < 5; ++$i) {
         $str .= $chars[mt_rand(0, 61)];
     }
    $urlnum = rand(2, 4);
    $client = new Client();
    $geturl = "https://pixabay.com/ja/editors_choice/?media_type=photo&pagi=".$urlnum;
    $crawler = $client->request('GET', $geturl);
    $anum = rand(1, 59);
    $anump = rand(0, 59);
    $pagelink = $crawler->filter('.item > a')->eq($anump)->attr('href');
    $imgurl = "https://pixabay.com".$pagelink;
    $crawler2 = $client->request('GET', $imgurl);
    $imglink =  $crawler2->filter('#media_container > img')->attr('src');
    static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
    $str = '';
    for ($i = 0; $i < 8; ++$i) {
        $str .= $chars[mt_rand(0, 61)];
    }
    $upload_dir = wp_upload_dir();
    $arr = explode('.', $imglink);
    $ext = end($arr);
    $src = $upload_dir['baseurl'] . "/" . $filename . $str . "." . $ext;
    $srcpath = $upload_dir['basedir'] . "/" . $filename . $str . "." . $ext;
$filename35 = basename($srcpath);
$upload_file35 = wp_upload_bits($filename35, null, file_get_contents($imglink));


   $wp_filetype35 = wp_check_filetype($filename35, null); 
  $upload_file35['file'];
$attachment = array(
  'guid'  => $upload_dir['url'] . '/' . basename( $filename35 ), 
  'post_mime_type' => $wp_filetype35['type'],
  'post_title' => preg_replace('/\.[^.]+$/', '', $filename35),
  'post_content' => '',
  'post_status' => 'inherit'
);
$attach_id = wp_insert_attachment( $attachment, $upload_file35['file'], $post_id );

if($attach_id) {
  require_once(ABSPATH . "wp-admin" . '/includes/image.php'); 
  $attach_data = wp_generate_attachment_metadata( $attach_id, $upload_file35['file'] );
  wp_update_attachment_metadata( $attach_id,  $attach_data );

  
  update_post_meta($post_id, '_thumbnail_id', $attach_id);
  sleep(1);
}
}


