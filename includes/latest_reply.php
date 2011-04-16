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
| Filename: latest_reply.php
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

global $lastvisited;

$settings['latest_reply'] = 5;

if (!isset($lastvisited) || !isnum($lastvisited)) { $lastvisited = time(); }

$data = dbarray(dbquery(
	"SELECT tt.thread_lastpost
	FROM ".DB_FORUMS." tf
	INNER JOIN ".DB_THREADS." tt ON tf.forum_id = tt.forum_id
	WHERE ".groupaccess('tf.forum_access')." AND thread_hidden='0'
	ORDER BY tt.thread_lastpost DESC LIMIT ".($settings['latest_reply']-1).", ".$settings['latest_reply']
));

$timeframe = empty($data['thread_lastpost']) ? 0 : $data['thread_lastpost'];

$result = dbquery(
	"SELECT tt.thread_id, tt.thread_subject, tt.thread_views, tt.thread_lastuser, tt.thread_lastpost,
	tt.thread_poll, tf.forum_id, tf.forum_name, tf.forum_access, tt.thread_lastpostid, tt.thread_postcount, tu.user_id, tu.user_name,
	tu.user_status
	FROM ".DB_THREADS." tt
	INNER JOIN ".DB_FORUMS." tf ON tt.forum_id=tf.forum_id
	INNER JOIN ".DB_USERS." tu ON tt.thread_lastuser=tu.user_id
	WHERE ".groupaccess('tf.forum_access')." AND tt.thread_lastpost >= ".$timeframe." AND tt.thread_hidden='0'
	ORDER BY tt.thread_lastpost DESC LIMIT 0,".$settings['latest_reply']
);

if (dbrows($result)) {
	echo "<ul>\n";
	while ($data = dbarray($result)) {
		echo "<li>\n";
			echo profile_link($data['thread_lastuser'], trimlink($data['user_name'], 11), $data['user_status'])." in \n";
			echo "<a href='".FORUM."viewthread.php?thread_id=".$data['thread_id']."&amp;pid=".$data['thread_lastpostid']."#post_".$data['thread_lastpostid']."' title='".$data['forum_name'].": ".$data['thread_subject']."'>".trimlink($data['thread_subject'], 15)."</a>\n";

		echo "</li>\n";
	}
	echo "</ul>\n";
}
?>