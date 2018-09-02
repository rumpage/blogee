=== Thumbnail_Create ===
Contributors: melo
Donate link: http://amzn.asia/inFG9o0
Tags: Thumbnail
Requires at least: 3.3
Tested up to: 4.9.4
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

記事のサムネイルを自動で作成。画像を素材サイトから自動でダウンロードします。

== Description ==

投稿にサムネイルが設定されているかチェックします。
サムネイルが設定されていない場合、自動でフリーの画像素材サイトからランダムで画像をダウンロードしてサムネイルに設定します。
ダウンロードする素材サイトはpixabayです
ダウンロードできる画像の種類は100種類前後
負荷対策で投稿数が多い場合は時間がかかることがあります

Make sure thumbnails are set for posts. If there are no thumbnails in the post, download the image randomly from the free image material site and set it as a thumbnail.
The image to be downloaded is acquired from pixabay.
Pixabay is a free material site that can also be used for commercial purposes.

The image to download is random
The downloaded image can be checked from the media.
If there are many posts, the thumbnail images may be duplicated.
There are about 100 images to download.
We will execute it at regular intervals with load balancing to the server.
Recommended environment is PHP 7.0 or higher.

== Installation ==

1. Upload `thumbnail_create` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently asked questions ==



== Screenshots ==

1. Thumbnail_create

== Changelog ==

= 1.1 =
* Release date: February 14, 2018
= 1.0 =
* Release date: May 26, 2017

== Upgrade notice ==



== Arbitrary section 1 ==
