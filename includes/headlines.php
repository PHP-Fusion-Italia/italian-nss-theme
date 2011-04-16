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
| Filename: headlines.php
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
$rows = dbcount("(news_id)", DB_NEWS,
		groupaccess('news_visibility')." AND (news_start='0'||news_start<=".time().")
										 AND (news_end='0'||news_end>=".time().")
										 AND news_draft='0'");
if ($rows) : ?><!-- begin headlines text -->
<div class="headlines">
	<div class="headlines_content">
		<div class="headlines_image">
			<div class="headlines_icon">
				<img src="<?php echo STATIC_DOMAIN; ?>images/icons/started.png" width="43" alt="Importante, "/>
			</div>

			<div class="headlines_icon_text">
				<h4>Ultimi Aggiornamenti:</h4>
			</div>
		</div>
		<div class="headlines_text">
			<ul id="news_ticker">
<?php
	$result = dbquery(
		"SELECT tn.*, tc.*
		FROM ".DB_NEWS." tn
		LEFT JOIN ".DB_NEWS_CATS." tc ON tn.news_cat=tc.news_cat_id
		WHERE ".groupaccess('news_visibility')." AND (news_start='0'||news_start<=".time().")
			AND (news_end='0'||news_end>=".time().") AND news_draft='0'
		GROUP BY news_id
		ORDER BY news_sticky DESC, news_datestamp DESC LIMIT 0,5"
	);
	while ($data = dbarray($result)) {
		echo "\t\t\t\t<li id='news_".$data['news_id']."'><a href='".BASEDIR."news.php?readmore=".$data['news_id']."'><span>[".showdate("%d/%m/%Y", $data['news_datestamp'])."] ".stripslashes($data['news_subject']);
		echo $data['news_sticky'] ? "<span class='bullhorn'><img src='".STATIC_DOMAIN."images/icons/bullhorn.png' alt='In Rilievo!'/></span>" : "";
		echo "</span></a></li>\n";
	}
?>
			</ul>
		</div>
	</div>
</div>
<!-- end headlines text -->
<?php endif; ?>