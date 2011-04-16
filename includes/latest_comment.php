<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Theme Name: Italian NSS
| Theme URI: http://themeforest.net/item/
|   overall-premium-wordpress-blog-portfolio-theme/124861
| Version: 1.00
| Author: Codestar
| Author URI: http://themeforest.net/user/Codestar
| Converted to PHP-Fusion by: Valerio Vendrame (lelebart) 
|                           http://www.valeriovendrame.it
+--------------------------------------------------------+
| Filename: latest_comment.php
| Author: Valerio Vendrame (lelebart)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_IT_NSS")) { die("Access Denied"); } 

if (!function_exists('remove_bbcodes')) {
	function remove_bbcodes ($str) {
		if (!is_string($str)) { return $str; }
		return preg_replace ('/\[[^\]]*\]/', '', $str);
	}
}

$display_Comments = 5;
$trim = 28;

$result = dbquery("	SELECT comment_id, comment_item_id, comment_type, comment_message
					FROM ".DB_COMMENTS."
					WHERE comment_hidden='0'
					ORDER BY comment_datestamp DESC
					");
if (dbrows($result)) {
	$output = "";
	$i = 0;
	while($data = dbarray($result)) {
		if ($i == $display_Comments) { break; }
		switch ($data['comment_type']) {
			case "N":
				$access = dbcount(	"(news_id)", DB_NEWS,
									"news_id='".$data['comment_item_id']."' AND
									".groupaccess('news_visibility')." AND
									(news_start='0'||news_start<=".time().") AND
									(news_end='0'||news_end>=".time().") AND
									news_draft='0'
									");
				if ($access > 0) {
					$comment = $comment = trimlink(remove_bbcodes($data['comment_message']), $trim);
					$output .= "<li><a href='".BASEDIR."news.php?readmore=".$data['comment_item_id']."#c".$data['comment_id']."' title='".$comment."' class='side'>".$comment."</a></li>\n";
					$i++;
				}
				continue;
			case "A":
				$access = dbquery("	SELECT article_id FROM ".DB_ARTICLES." a, ".DB_ARTICLE_CATS." c WHERE
									a.article_id='".$data['comment_item_id']."' AND
									a.article_cat=c.article_cat_id AND
									".groupaccess('c.article_cat_access')." AND
									a.article_draft='0'
									");
				if (dbrows($access) > 0) {
					$comment = $comment = trimlink(remove_bbcodes($data['comment_message']), $trim);
					$output .= "<li><a href='".BASEDIR."articles.php?article_id=".$data['comment_item_id']."#c".$data['comment_id']."' title='".$comment."' class='side'>".$comment."</a></li>\n";
					$i++;
				}
				continue;
			case "P":
				$access = dbquery("	SELECT photo_id FROM ".DB_PHOTOS." p, ".DB_PHOTO_ALBUMS." a WHERE
									p.photo_id='".$data['comment_item_id']."' AND
									p.album_id=a.album_id AND
									".groupaccess('a.album_access')
									);
				if (dbrows($access) > 0) {
					$comment = $comment = trimlink(remove_bbcodes($data['comment_message']), $trim);
					$output .= "<li><a href='".BASEDIR."photogallery.php?photo_id=".$data['comment_item_id']."#c".$data['comment_id']."' title='".$comment."' class='side'>".$comment."</a></li>\n";
					$i++;
				}
				continue;
			case "C":
				$access = dbcount("(page_id)", DB_CUSTOM_PAGES, "page_id='".$data['comment_item_id']."' AND ".groupaccess('page_access'));
				if ($access > 0) {
					$comment = $comment = trimlink(remove_bbcodes($data['comment_message']), $trim);
					$output .= "<li><a href='".BASEDIR."viewpage.php?page_id=".$data['comment_item_id']."#c".$data['comment_id']."' title='".$comment."' class='side'>".$comment."</a></li>\n";
					$i++;
				}
				continue;
			case "D":
				$access = dbquery("	SELECT download_id FROM ".DB_DOWNLOADS." d, ".DB_DOWNLOAD_CATS." c WHERE
									d.download_id='".$data['comment_item_id']."' AND
									d.download_cat=c.download_cat_id AND
									".groupaccess('c.download_cat_access')
									);
				if (dbrows($access) > 0) {
					$comment = $comment = trimlink(remove_bbcodes($data['comment_message']), $trim);
					$output .= "<li><a href='".BASEDIR."downloads.php?download_id=".$data['comment_item_id']."#c".$data['comment_id']."' title='".$comment."' class='side'>".$comment."</a></li>\n";
					$i++;
				}
				continue;
		}
	}
	echo "<ul>\n".$output."</ul>\n";
}
?>