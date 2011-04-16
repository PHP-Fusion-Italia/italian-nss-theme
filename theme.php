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
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

define("IN_IT_NSS", true);

require_once THEME."config.php";
require_once INCLUDES."theme_functions_include.php";
require_once THEME."functions.php";

function show_it_nss_divider_top(){
	return "<span class='divider_with_top'><a href='#top'>Su</a></span>\n";
}

function render_page($license=false) {
	
	global $settings, $main_style, $locale, $userdata, $aidlink; add_handler("theme_output");
	
	// PHP-Fusion.it
	add_to_head("<meta name='robots' content='all,index,follow' />");
	add_to_head("<meta name='generator' content='PHP-Fusion copyright &copy; 2002 - ".date('Y')." by Nick Jones.' />");
	add_to_head("<meta name='copyright' content='copyright &copy; 2005 - ".date('Y')." by Giovanni Toraldo' />");
	// <head></head>
	add_to_head('<script type="text/javascript" src="'.STATIC_DOMAIN.'js/settings.js"></script>');
	if (SUBNAV) { add_to_head('<script type="text/javascript" src="'.STATIC_DOMAIN.'js/overallmenu.js"></script>'); }
	if (stristr(START_PAGE, "home.php") || (iMEMBER && stristr(START_PAGE, "forum/"))) {
		add_to_head('<script type="text/javascript" src="'.STATIC_DOMAIN.'js/jquery.cycle.min.js"></script>');
	}
	add_to_head('<script type="text/javascript" src="'.STATIC_DOMAIN.'js/cufon-yui.js"></script>');
	add_to_head('<script type="text/javascript" src="'.STATIC_DOMAIN.'js/Futura_Bk_BT_400.font.js"></script>');
	add_to_head('<!--[if IE 7]><link rel="stylesheet" type="text/css" media="all" href="'.STATIC_DOMAIN.'css/ie7.css" /><![endif]-->');
	add_to_head('<!--[if IE 6]><script type="text/javascript" src="'.STATIC_DOMAIN.'js/DD_belatedPNG_0.0.8a-min.js"></script>'."\n".
				'<script type="text/javascript">/*<![CDATA[*/DD_belatedPNG.fix("img, div");/*]]>*/</script><![endif]-->');

	// Header
	echo "<div class='header'>\n\t<div class='header_container'>\n\t\t";
		echo "<div class='header_logo'>\n\t\t\t".showbanners()."\n\t\t</div><!-- .header_logo -->\n\t\t";
		echo "<div class='overallmenu clearfix'>\n\t\t\t".navigation()."\t\t</div><!-- .overallmenu -->\n\t";
	echo "</div><!-- .header_container -->\n</div><!-- .header -->\n";
	
	// SubHeader
	echo "<div class='page_top'>\n\t<div class='page_top_container'>\n\t\t";
		echo "<div class='page_top_content'>\n\t\t\t";
		if (iMEMBER) {
			$msg_count = dbcount("(message_id)", DB_MESSAGES, "message_to='".$userdata['user_id']."' AND message_read='0' AND message_folder='0'"); 
			echo "<span class='page_top_title'>Bentornato/a, <strong><a href='".BASEDIR."profile.php?lookup=".$userdata['user_id']."'>".($userdata['user_name'])."</a></strong></span><br />\n\t\t\t";
			echo "<span class='page_top_desc clearfix'>"; // \n\t\t\t\t
			echo "<a href='".BASEDIR."edit_profile.php'>".$locale['global_120']."</a> - "; // \n\t\t\t\t
		//	echo "<a href='".BASEDIR."members.php'>".$locale['global_122']."</a> - "; // \n\t\t\t\t
		// $locale['global_121'].
			echo "<a href='".BASEDIR."messages.php' class='side'>Messaggi".($msg_count ? " (".$msg_count.")" : "")."</a> - "; // \n\t\t\t\t
		//	".$locale['global_123']."
			echo (iADMIN ? "<a href='".ADMIN."index.php".$aidlink."'>Amministra</a> - " : "").""; // \n\t\t\t\t
		// ".$locale['global_124']."
			echo "<a href='".BASEDIR."members.php'>Iscritti</a> - ";
			echo "<a href='".BASEDIR."setuser.php?logout=yes'>Esci</a>"; // \n\t\t\t
			echo "</span>\n";
		} else {
			echo "<span class='page_top_title'>Benvenuto/a su <strong>php-fusion.it</strong></span><br />\n\t\t\t";
			echo "<span class='page_top_desc clearfix'>Community di aiuto per PHP-Fusion.\n";
			echo "<a href='".BASEDIR."login.php'>Accedi</a>";
			echo ($settings['enable_registration'] ? " - <a href='".BASEDIR."register.php'>Iscriviti</a>\n" : ""); // ".$locale['global_107'].".
			echo "</span>"; 
		}
		echo "\t\t</div><!-- .page_top_content -->\n";
		// Exclude search box on search page and on forum index
	if (!stristr(START_PAGE, "search.php") && !stristr(START_PAGE, "forum/index.php")) {
		$locale['search'] = str_replace($locale['global_200'], "", $locale['global_202']);		
		echo "\t\t<div class='page_top_search'>\n\t\t\t<form action='".BASEDIR."search.php' id='searchform' method='get'>\n\t\t\t\t<div>"; // \t\t
			echo "<input type='text' onblur='if (this.value == \"\") {this.value = \"".$locale['search']."...\";}' onfocus='if (this.value == \"".$locale['search']."...\") {this.value = \"\";}' id='stext' name='stext' value='".$locale['search']."...' />";
		echo "</div>\n\t\t\t</form>\n\t\t</div><!-- .page_top_search -->\n";	
	}
	echo "\t</div><!-- .page_top_container -->\n</div><!-- .page_top -->\n";
	
	// Container
	if (preg_match('/home.php/i',FUSION_SELF)) { // Custom Homepage
		include_once STATIC_DOMAIN."includes/banner.php"; // Banner
		include_once STATIC_DOMAIN."includes/headlines.php"; // Headlines
		include_once STATIC_DOMAIN."includes/home_content.php"; // Homepage grid
	} else { 
		if (iMEMBER && stristr(START_PAGE, "forum/")) { // Show Forum Ruels on forumpages
			include_once STATIC_DOMAIN."includes/forum_rules.php"; // Forum Rules
		}
		echo "<div class='page_container_bg'>\n\t";	
		// Content
		if ((!RIGHT && !LEFT) || !SIDEBAR) {
			echo "<div class='page_full_container'>\n\t\t";
				echo "<div class='page_full_content'>\n\t\t\t";
		} else {
			echo "<div class='page_container'>\n\t\t";
				echo "<div class='page_content'>\n\t\t\t";
		}
				echo "<div class='page_content_text'>\n\t\t\t\t";
				//	echo (defined("ADMIN_PANEL")) ? "ADMIN_PANEL" : "";
					echo U_CENTER.CONTENT.L_CENTER;
				echo "\t\t\t</div><!-- .page_content_text -->\n\t\t"; 
			echo "</div><!-- .page_(full_)content -->\n\t";  // .page_content or .page_full_content
			
		// Sidebar
		if ((RIGHT || LEFT) && SIDEBAR) {
			echo "<div class='page_right_content'>\n\t\t<div class='page_right_sidebars'>\n\t\t\t";
			echo RIGHT.LEFT."\t\t\t</div><!-- .page_right_sidebars -->\n\t\t</div><!-- .page_right_content -->\n\t"; // .page_right_sidebars .page_right_content
		}
			echo "</div><!-- .page_(full_)container -->\n"; // .page_container or .page_full_container
		echo "</div><!-- .page_container_bg -->\n"; 
	}
	
	// Footer
	echo "<div class='footer'>\n\t<div class='footer_widget'>\n\t\t<div class='footer_widgets clearfix'>\n\t\t\t";
		echo "<div class='footer_widgetleft'>\n\t\t\t\t";
			/** NAVIGAZIONE // NETWORK **/
		//	echo "<h3>Navigazione</h3>\n\t\t\t\t";
			echo "<h3>PHP-Fusion Network</h3>\n\t\t\t\t"; // 
		//	echo "<div class='footer_menu'>".footer_navigation()."</div>\n\t\t\t";
			echo "<div class='footer_menu'>\n\t\t\t\t\t"; 
				echo "<ul>\n\t\t\t\t\t\t"; 
					echo "<li><a href='http://www.php-fusion.co.uk/' target='_blank'>PHP-Fusion UK</a></li>\n\t\t\t\t\t\t";
					echo "<li><a href='irc://irc.swc-irc.com/phpfusion'>PHP-Fusion IRC</a></li>\n\t\t\t\t\t\t";
					echo "<li><a href='http://dev.php-fusion.co.uk/' target='_blank'>PHP-Fusion Dev</a></li>\n\t\t\t\t\t\t";
					echo "<li><a href='http://staff.php-fusion.co.uk/' target='_blank'>PHP-Fusion Staff</a></li>\n\t\t\t\t\t\t";
					echo "<li><a href='http://www.cafepress.com/phpfusion/' target='_blank'>PHP-Fusion Store</a></li>\n\t\t\t\t\t\t";
					echo "<li><a href='http://code.starefossen.com/infusions/fusion_functions/' target='_blank'>Fusion Functions</a></li>\n\t\t\t\t\t\t";
					echo "<li><a href='http://themes.php-fusion.co.uk/' target='_blank'><span>Themes</span></a> ".THEME_BULLET." <a href='http://phpfusion-themes.com/' target='_blank'>Fuzed Themes</a></li>\n\t\t\t\t\t\t"; // style='text-decoration:line-through;'
					echo "<li><a href='http://mods.php-fusion.co.uk/' target='_blank'><span>Mods</span></a> ".THEME_BULLET." <a href='http://www.phpfusion-mods.net/' target='_blank'>Fusion Mods.net</a></li>\n\t\t\t\t\t"; //  style='text-decoration:line-through;'
				echo "</ul>\n\t\t\t\t";
			echo "</div>\n\t\t\t";
		echo "</div><!-- .footer_widgetleft -->\n\t\t\t";
		echo "<div class='footer_widgetcenter'>\n\t\t\t\t";
			echo "<div class='footer_widgetcenter_top'>\n\t\t\t\t\t";
				/** PHP-FUSION ITALIA **/
				echo "<h3>PHP-Fusion Italia</h3>\n\t\t\t\t\t";
				echo "Community di aiuto e news sempre fresche riguardo PHP-Fusion, il miglior portale oggi disponibile dalla comunit&agrave; del software libero. PHP-Fusion necessita di un server web come Apache con supporto per PHP e un database MySql dove salvare i contenuti.\n\t\t\t\t";
			echo "</div><!-- .footer_widgetcenter_top -->\n\t\t\t\t";
			echo "<div class='footer_widgetcenter_left'>\n\t\t\t\t\t";
				/** COMMENTI RECENTI **/
				echo "<h3>Commenti Recenti</h3>\n\t\t\t\t\t";
				echo "<div class='footer_comments'>\n\t\t\t\t\t\t";
					include_once STATIC_DOMAIN."includes/latest_comment.php"; // Latest Comment
				echo "\n\t\t\t\t\t</div>\n\t\t\t\t\t";
			echo "</div><!-- .footer_widgetcenter_left -->\n\t\t\t\t";
			echo "<div class='footer_widgetcenter_right'>\n\t\t\t\t\t";
				/** RISPOSTE RECENTI **/
				echo "<h3>Risposte Recenti</h3>\n\t\t\t\t\t";
				echo "<div class='footer_posts'>\n\t\t\t\t\t\t";
					include_once STATIC_DOMAIN."includes/latest_reply.php"; // Latest Reply
				echo "\n\t\t\t\t\t</div>\n\t\t\t\t\t";
			echo "</div><!-- .footer_widgetcenter_right -->\n\t\t\t\t";
		echo "</div><!-- .footer_widgetcenter -->\n\t\t\t";
		echo "<div class='footer_widgetright'>\n\t\t\t\t";
			echo "<div class='footer_widget_firstly'>\n\t\t\t\t\t";
				/** PHP-FUSION CMS OPEN SOURCE **/
				echo "<h3>PHP-Fusion CMS Open Source</h3>\n\t\t\t\t\t";
				echo "".str_replace('<br />','',showcopyright())."\n\t\t\t\t"; // AGPL
			echo "</div>\n\t\t\t\t";
			echo "<div class='footer_widget_firstly'>\n\t\t\t\t\t";
				/** INFORMAZIONI E CONTATTO **/
				echo "<h3>Informazioni e Contatto</h3>\n\t\t\t\t\t";
				echo "<div class='footer_contact'>\n\t\t\t\t\t\t";
					echo "<ul>\n\t\t\t\t\t\t\t";
						echo "<li class='address'>".showcounter()."</li>\n\t\t\t\t\t\t\t"; // Visits
						echo "<li class='phone'><a href='http://staff.php-fusion.co.uk/infusions/crv_report/crv_report.php' rel='nofollow' target='_blank'>Segnala una violazione di copyright</a> sul .co.uk</li>\n\t\t\t\t\t\t\t"; // Report CR Violation
						echo "<li class='email'><a href='mailto:admin@php-fusion.it'>admin@php-fusion.it</a></li>\n\t\t\t\t\t\t\t"; // admin
						echo "<li class='support'><a href='".BASEDIR."contact.php' rel='nofollow'>Scrivici dal modulo contatti online</a> di questo sito</li>\n\t\t\t\t\t\t\t"; // Contact Page
						echo "<li class='support'><a href='http://github.com/gionn/PHP-Fusion-locales-it/archives/master' rel='nofollow' target='_blank'>Stato della traduzione Italiana</a> su GitHub</li>\n\t\t\t\t\t\t"; // GitHub
					echo "</ul>\n\t\t\t\t\t\t";
				echo "</div>\n\t\t\t\t\t";
			echo "</div>\n\t\t\t\t";
		echo "</div><!-- .footer_widgetright -->\n\t\t\t</div><!-- .footer_widgets -->\n\t\t</div><!-- .footer_widget -->\n\t";
		echo "<div class='footer_copyright'>\n\t\t";
			echo "<div class='copyright_container'>\n\t\t\t"; // Theme Copyright
				echo "<div class='copyright_text'><a href='http://themeforest.net/item/overall-premium-wordpress-blog-portfolio-theme/124861' rel='nofollow' target='_blank'>OverAll theme</a> Copyright &copy; 2009 - 2010 <a href='http://themeforest.net/user/Codestar' rel='nofollow' target='_blank'>Codestar</a>, All Rights Reserved - Ported to PHP-Fusion for the Italian <abbr title='National Support Site'>NSS</abbr> (http://php-fusion.it) by <a href='http://www.valeriovendrame.it/' target='_blank'>Valerio Vendrame (lelebart)</a></div>\n\t\t\t";
				echo "<div class='footer_social_networks'>\n\t\t\t\t";
					echo "<ul>\n";	// Social Networks
						echo "\t\t\t\t\t<li><a href='https://twitter.com/PHPFusion'><img src='".STATIC_DOMAIN."images/social_networks/twitter.png' alt='PHP-Fusion su Twitter' /></a></li>\n"; // Official Twitter
						echo "\t\t\t\t\t<li><a href='https://www.facebook.com/group.php?gid=75392069884'><img src='".STATIC_DOMAIN."images/social_networks/facebook.png' alt='PHP-Fusion su Facebook' /></a></li>\n"; // Official Facebook Group
						echo "\t\t\t\t\t<li><a href='https://www.youtube.com/phpfusion'><img src='".STATIC_DOMAIN."images/social_networks/youtube.png' alt='PHP-Fusion su YouTube' /></a></li>\n";  // Official YouTube Channel
					if (RSS) {  // RSS - go to config.php
						echo "\t\t\t\t\t<li><a href='".RSS."'><img src='".STATIC_DOMAIN."images/social_networks/feed.png' alt='RSS' /></a></li>\n";
					}
					echo "\t\t\t\t</ul>\n\t\t\t";	
				echo "</div><!-- .footer_social_networks -->\n\t\t";	
			echo "</div><!-- .copyright_container -->\n\t";	
		echo "</div><!-- .footer_copyright -->\n";	
	echo "</div><!-- .footer -->\n";
	// JavaScript on footer
	echo "<script type='text/javascript' src='".STATIC_DOMAIN."js/custom.js'></script>\n";
	echo "<script type='text/javascript'>/*<![CDATA[*/Cufon.now();/*]]>*/</script>\n";
	// Other Footer Stuffs
	get_footer();
}

function opentable($title) {
	echo "\t\t\t\t<h3>".$title."</h3>\n";
}

function closetable() {
	echo "\n\t\t\t".show_it_nss_divider_top();
}

function openside($title, $collapse = false, $state = "on") {
	global $panel_collapse; $panel_collapse = $collapse;
	echo "\t\t\t<div class='page_sidebar_warp'>\n\t\t\t\t";
	echo "<h3 class='side_box_title'>".$title."</h3>\n\t\t\t\t";
	//echo "<div class='textwidget'>\n";
	if ($collapse == true) {
		$boxname = str_replace(" ", "", $title);
		echo "\t\t\t\t\t<div class='panel-button'>".it_nss_panelbutton($state, $boxname)."</div>\n\t\t\t\t\t";
		echo it_nss_panelstate($state, $boxname);
	} else {
		echo "<div class='textwidget'>\n";	
	}
}

function closeside() {
	global $panel_collapse;
	//if ($panel_collapse == true) { echo "\t\t\t\t\t</div>\n"; }	
	echo "\t\t\t\t</div><!-- .textwidget -->\n\t\t\t</div><!-- .page_sidebar_warp -->\n";
}

function it_nss_panelbutton($state, $bname) {
   $bname = preg_replace("/[^a-zA-Z0-9\s]/", "_", $bname);
   if (isset($_COOKIE[COOKIE_PREFIX."fusion_box_".$bname])) {
      if ($_COOKIE[COOKIE_PREFIX."fusion_box_".$bname] == "none") {
         $state = "off";
      } else {
         $state = "on";
      }
   }
   return "<img src='".get_image("panel_".($state == "on" ? "off" : "on"))."' id='b_".$bname."' class='panelbutton' alt='Apri/Chiudi' onclick=\"javascript:flipBox('".$bname."')\" />";
}

function it_nss_panelstate($state, $bname) {
   $bname = preg_replace("/[^a-zA-Z0-9\s]/", "_", $bname);
   if (isset($_COOKIE[COOKIE_PREFIX."fusion_box_".$bname])) {
      if ($_COOKIE[COOKIE_PREFIX."fusion_box_".$bname] == "none") {
         $state = "off";
      } else {
         $state = "on";
      }
   }
   return "<div id='box_".$bname."'".($state == "off" ? " style='display:none'" : "")." class='textwidget'>\n";
}


/* Renders */

function render_news($subject, $news, $info) {
	global $locale, $settings;
	echo "\t\t\t\t\t<div class='blog_head'>\n";
		echo "\t\t\t\t\t\t<div class='blog_title'><h2>".(isset($_GET['readmore'])?"":"<a href='".FUSION_SELF."?readmore=".$info['news_id']."'>")."".$subject."".(isset($_GET['readmore'])?"":"</a>")."</h2></div>\n";
		echo "\t\t\t\t\t\t<div class='blog_info'>\n\t\t\t\t\t\t\t<ul>\n";
			echo "\t\t\t\t\t\t\t\t<li class='date_icon'>".showdate("%d %b %Y", $info['news_date'])."</li>\n";
			echo "\t\t\t\t\t\t\t\t<li class='written_by'>".profile_link($info['user_id'], $info['user_name'], $info['user_status'])."</li>\n";
			echo "\t\t\t\t\t\t\t\t<li class='category'>";
			if ($info['cat_id']) {
				echo "<a href='".BASEDIR."news_cats.php?cat_id=".$info['cat_id']."'>".$info['cat_name']."</a>";
			} else {
				echo "<a href='".BASEDIR."news_cats.php?cat_id=0'>".$locale['global_080']."</a>";
			}
			echo "</li>\n";
			if ($info['news_allow_comments'] && $settings['comments_enabled'] == "1") {
			echo "\t\t\t\t\t\t\t\t<li class='comment_icon'>";
				$comment_txt = $info['news_comments'] == 0 ? "Nessun Commento" : 
					$info['news_comments'].($info['news_comments'] == 1 ? " Commento" : " Commenti");
				echo "<a href='".FUSION_SELF."?readmore=".$info['news_id']."#comments'>".$comment_txt." &#187;</a>\n";
			echo "</li>\n";
			}
		echo "\t\t\t\t\t\t\t</ul>\n\t\t\t\t\t\t</div>\n";
	echo "\t\t\t\t\t</div>\n";
	$subject = strip_tags($subject);
	echo "\t\t\t\t\t<div class='blog_text'>\n";
		if (!empty($info['cat_image'])) {
			echo "\t\t\t\t\t\t<div class='image_frame_right'><div class='image_skin'><div class='image_inside_border'>";
				echo "<!--div class='image_skin_anime'--><div class='image_holder'>".$info['cat_image']."";
			echo "</div><!--/div--></div></div></div>\n"; 
		}
		echo "\t\t\t\t\t\t<div".(!isset($_GET['readmore']) ? " class='blog_short_text'" : "").">".$news."</div>\n";
		$readmore = "Letta ".$info['news_reads']." volte ".THEME_BULLET." ";
		if (!isset($_GET['readmore'])) {
			echo "\t\t\t\t\t\t<div class='blog_detail_button'><a href='".FUSION_SELF."?readmore=".$info['news_id']."'><span class='details_button'>".$readmore."Leggi il resto della notizia &#187;</span></a></div>\n";
		} else {
			echo "\t\t\t\t\t\t<div class='blog_detail_button'><a href='".BASEDIR."print.php?type=N&amp;item_id=".$info['news_id']."'><span class='details_button'>".$readmore."Stampa questa notizia</span></a></div>\n";
		} 
	echo "\t\t\t\t\t</div>\n";
	echo "\t\t\t\t".show_it_nss_divider_top();
}

function render_article($subject, $article, $info) {
	global $locale, $settings;
	echo "\t\t\t\t\t<div class='blog_head'>\n";
		echo "\t\t\t\t\t\t<div class='blog_title'><h2>".(isset($_GET['article_id'])?"":"<a href='".FUSION_SELF."?article_id=".$info['article_id']."'>")."".$subject."".(isset($_GET['article_id'])?"":"</a>")."</h2></div>\n";
		echo "\t\t\t\t\t\t<div class='blog_info'>\n\t\t\t\t\t\t\t<ul>\n";
			echo "\t\t\t\t\t\t\t\t<li class='date_icon'>".showdate("%d %b %Y", $info['article_date'])."</li>\n";
			echo "\t\t\t\t\t\t\t\t<li class='written_by'>".profile_link($info['user_id'], $info['user_name'], $info['user_status'])."</li>\n";
			echo "\t\t\t\t\t\t\t\t<li class='category'>";
			echo "<a href='".FUSION_SELF."?cat_id?cat_id=".$info['cat_id']."'>".$info['cat_name']."</a>";
			echo "</li>\n";
			if ($info['article_allow_comments'] && $settings['comments_enabled'] == "1") {
			echo "\t\t\t\t\t\t\t\t<li class='comment_icon'>";
				$comment_txt = $info['article_comments'] == 0 ? "Nessun Commento" : 
					$info['article_comments'].($info['article_comments'] == 1 ? " Commento" : " Commenti");
				echo "<a href='".FUSION_SELF."?article_id=".$info['article_id']."#comments'>".$comment_txt." &#187;</a>\n";
			echo "</li>\n";
			}
		echo "\t\t\t\t\t\t\t</ul>\n\t\t\t\t\t\t</div>\n";
	echo "\t\t\t\t\t</div>\n";
	$subject = strip_tags($subject);
	echo "\t\t\t\t\t<div class='blog_text'>\n";
		echo "\t\t\t\t\t\t<div>".($info['article_breaks'] == "y" ? nl2br($article) : $article)."</div>\n";
		$readmore = "Letto ".$info['article_reads']." volte ".THEME_BULLET." ";
		echo "\t\t\t\t\t\t<div class='blog_detail_button'><a href='".BASEDIR."print.php?type=A&amp;item_id=".$info['article_id']."'><span class='details_button'>".$readmore."Stampa questo articolo</span></a></div>\n";
	echo "\t\t\t\t\t</div>\n";
	echo "\t\t\t\t".show_it_nss_divider_top();
}

function render_comments($c_data, $c_info){
	global $locale;
	if (!empty($c_data)){
		echo "<h3 class='comment-title' id='comments'>".$locale['c100'].($c_info['admin_link'] ? " -".$c_info['admin_link'] : "")."</h3>\n";
		if ($c_info['c_makepagenav']) { echo $c_info['c_makepagenav']."\n"; }
		echo "<ol class='comments-list'>\n";
		foreach($c_data as $data) {
			echo "\t<li id='c".$data['comment_id']."'>\n";
			echo "\t\t<p class='comment-author'>\n";
				echo "\t\t\t".($data['edit_dell'] ? "<span class='comment-edit'>".$data['edit_dell']."</span>" : "")."".$data['comment_name'].",\n";
				echo "\t\t\t<span class='comment-time'><a href='".FUSION_REQUEST."#c".$data['comment_id']."'>".$data['comment_datestamp']."</a></span>\n";
			echo "\t\t</p>\n";
			echo "\t\t<p>".$data['comment_message']."</p>\n";
			echo "\t</li>\n";
		}
		echo "</ol>\n";
		if ($c_info['c_makepagenav']) { echo $c_info['c_makepagenav']."\n"; }
		echo show_it_nss_divider_top();
//		if ($c_info['admin_link']) { echo "<div style='padding-top:5px;' class='comment_admin'>".$c_info['admin_link']."</div>\n"; }
		
	}
}

?>