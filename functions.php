<?php
if (!defined("IN_FUSION")) { die("Access Denied"); }

function theme_output($output) {
	global $main_style;
	$search = array(
		"@<link rel='shortcut icon' href='".IMAGES."favicon.ico' type='image/x-icon' />@si",
		"@<script type='text/javascript' src='".INCLUDES."jquery.js'></script>@si",
		"@<script type='text/javascript' src='".INCLUDES."jquery/jquery.js'></script>@si",
		"@<a id='content' name='content'></a>\n@si",
		"@<a id='comments' name='comments'></a>@si",
		"@><img src='reply' alt='(.*?)' style='border:0px' />@si",
		"@><img src='newthread' alt='(.*?)' style='border:0px;?' />@si",
		"@><img src='web' alt='(.*?)' style='border:0;vertical-align:middle' />@si",
		"@><img src='pm' alt='(.*?)' style='border:0;vertical-align:middle' />@si",
		"@><img src='quote' alt='(.*?)' style='border:0px;vertical-align:middle' />@si",
		"@><img src='forum_edit' alt='(.*?)' style='border:0px;vertical-align:middle' />@si",
		"@<ul class='clearfix' id='main-nav'>\n<li\b[^>]*><a href='".BASEDIR."index.php'@si",
		"@<body>@si",
		"@<table[^>]*width='(.*?)'(.*?)>@si",
		"@<!--sub_forum_post_message-->(.*?)<hr /><div class='forum_sig'>(.*?)</div>(.*?)<!--sub_forum_post-->(.*?)<!--forum_thread_userbar-->@si",
		"@<a href='#top'><img (.*?) /></a>@si",
		"@<div style='width: 500px;' class='panels(.*?)'>@si",
		"@<select name='maintenance' class='textbox' style='width:(.*?);'>@si",
		"@<link rel='stylesheet' href='".INCLUDES."jquery/colorbox/colorbox.css' type='text/css' media='screen' />@si",
		"@<script type='text/javascript' src='".INCLUDES."jquery/colorbox/jquery.colorbox.js'></script>@si",
		"@										current: 'Immagine {current} di {total}', width:'80%', height:'80%'@si",
	//	"@<!--pre_forum_thread-->(.*?)</div>(.*?)<td style='padding:(.*?)'><div class='pagenav'>(.*?)</div>@si",
	//	"@<!--pre_forum_thread-->(.*?)</div>(.*?)<td style='padding:[^>]*'><div class='pagenav'>(.*?)</div>@si",
		"@<br /><br /><br /></code>@si",
	);
	//$page = str_replace(".php", "", FUSION_SELF);
	$replace = array(
		'<link rel="shortcut icon" href="'.BASEDIR.'images/favicon.ico" type="image/x-icon" />',
		'<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script><script type="text/javascript">/*<![CDATA[*/!window.jQuery && document.write("<script type=\"text/javascript\" src=\"'.INCLUDES.'jquery.js\"><\/script>")/*]]>*/</script>',
		'<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script><script type="text/javascript">/*<![CDATA[*/!window.jQuery && document.write("<script type=\"text/javascript\" src=\"'.INCLUDES.'jquery/jquery.js\"><\/script>")/*]]>*/</script>',
		'',
		'',
		' class="button"><span class="reload icon"><!--[icon]--></span><span>$1</span>',
		' class="button"><span class="plus icon"><!--[icon]--></span><span>$1</span>',
		' class="button blue" rel="nofollow"><span class="pin icon"><!--[icon]--></span><span>Web</span>',
		' class="button blue"><span class="mail icon"><!--[icon]--></span><span>PM</span>',
		' class="button blue"><span class="comments icon"><!--[icon]--></span><span>$1</span>',
		' class="button blue"><span class="pen icon"><!--[icon]--></span><span>$1</span>',
		"<ul class='clearfix' id='main-nav'>\n<li class='home'><a href='".BASEDIR."index.php'",
		"<body".(defined("ADMIN_PANEL") ? " id='admin_panel'" : " id='page-".str_replace(".php", "", FUSION_SELF)."'").">",
		'<table width="98%"$2>', // '<table$1$2>'
		'<!--sub_forum_post_message-->$1$3<!--sub_forum_post-->$4<!--forum_thread_userbar--></div><div class="replaced_signature">$2</div><span class="forum_sig_replace"><span class="signature">Firma</span></span><div style="float:left;white-space:nowrap" class="small">',
		'<a href="#top">Torna su</a>',
		'<div style="width: 100%;" class="panels tbl-border center floatfix">',
		'<select name="maintenance" class="textbox">',
		"<link rel='stylesheet' href='".STATIC_DOMAIN."colorbox/colorbox.css' type='text/css' media='screen' />", 
		"<script type='text/javascript' src='".STATIC_DOMAIN."colorbox/jquery.colorbox.js'></script>", 
		"										current: 'Immagine {current} di {total}', width:'75%', height:'75%', 
 next: 'succ.', previous: 'prec.', close: 'chiudi',",
	//	'<!--pre_forum_thread-->$1</div><div class="pagenav">$4</div>$2<td><!--[pagenav]-->',
	//	'<!--pre_forum_thread-->$1</div><div class="pagenav">$3</div>$2<td><!--[pagenav]-->',
		'</code>',
	);
	$output = preg_replace($search, $replace, $output);
	return $output;
}

function navigation() {
	$result = dbquery(
		"SELECT link_name, link_url, link_window, link_visibility FROM ".DB_SITE_LINKS."
		 WHERE link_position='3'".(SUBNAV ? "" : " OR link_position='2'")." ORDER BY link_order"
	 );
	$link = array();
	while ($data = dbarray($result)) {
		$link[] = $data;
	}
	$res = "<ul class='overallmenu clearfix' id='main-nav'>\n";
	foreach($link as $data) {
		if (checkgroup($data['link_visibility'])) {
			$link_target = $data['link_window'] == "1" ? " target='_blank'" : "";
			//$li_class = preg_match("/^".preg_quote(START_PAGE, '/')."/i", $data['link_url']) ? " class='current_page_item'" : "";
			$li_class = stristr(START_PAGE, $data['link_url']) ? " class='current_page_item'" : "";
			if (!strstr($data['link_url'], "http://") && !strstr($data['link_url'], "https://")) {
				$data['link_url'] = BASEDIR.$data['link_url'];
			}
			if (strstr($data['link_name'], "%submenu% ") && SUBNAV) {
				$res .= "\t\t\t\t<li$li_class><a href='".$data['link_url']."'$link_target>".parseubb(str_replace("%submenu% ", "",$data['link_name']), "b|i|u|color")."</a>\n\t\t\t<ul class='sub-menu'>\n";
			} elseif (strstr($data['link_name'], "%endmenu% ") && SUBNAV) {
				$res .= "\t\t\t\t<li$li_class><a href='".$data['link_url']."'$link_target>".parseubb(str_replace("%endmenu% ", "",$data['link_name']), "b|i|u|color")."</a></li>\n\t\t\t</ul>\n</li>\n";
			} else {
				$res .= "\t\t\t\t<li$li_class><a href='".$data['link_url']."'$link_target>".parseubb($data['link_name'], "b|i|u|color")."</a></li>\n";
			}
		}
	}
	$res .= "\t\t\t</ul>\n";
	return $res;
}

function footer_navigation() {
	$result = dbquery(
		"SELECT link_name, link_url, link_window, link_visibility FROM ".DB_SITE_LINKS."
		 WHERE link_position='3' OR link_position='2' ORDER BY link_order"
	 );
	$link = array();
	while ($data = dbarray($result)) {
		$link[] = $data;
	}
	$res = "<ul class='footer_menu'>\n";
	foreach($link as $data) {
		if (checkgroup($data['link_visibility'])) {
			$link_target = $data['link_window'] == "1" ? " target='_blank'" : "";
			$li_class = stristr(START_PAGE, $data['link_url']) ? " class='current_page_item'" : "";
			if (!strstr($data['link_url'], "http://") && !strstr($data['link_url'], "https://")) {
				$data['link_url'] = BASEDIR.$data['link_url'];
			}
			if (strstr($data['link_name'], "%submenu% ") && SUBNAV) {
				$res .= "\t\t\t\t<li$li_class><a href='".$data['link_url']."'$link_target>".parseubb(str_replace("%submenu% ", "",$data['link_name']), "b|i|u|color")."</a>\n\t\t\t<ul class='sub-menu'>\n";
			} elseif (strstr($data['link_name'], "%endmenu% ") && SUBNAV) {
				$res .= "\t\t\t\t<li$li_class><a href='".$data['link_url']."'$link_target>".parseubb(str_replace("%endmenu% ", "",$data['link_name']), "b|i|u|color")."</a></li>\n\t\t\t</ul>\n</li>\n";
			} else {
				$res .= "\t\t\t\t<li$li_class><a href='".$data['link_url']."'$link_target>".parseubb($data['link_name'], "b|i|u|color")."</a></li>\n";
			}
		}
	}
	$res .= "\t\t\t</ul>\n";
	return $res;
}

function get_footer() {
	global $settings;
	if (!isset($settings['rendertime_enabled'])) $settings['rendertime_enabled'] = 1;
	if ($settings['rendertime_enabled'] == 1 || ($settings['rendertime_enabled'] == 2 && iADMIN)) {
		echo (DEBUG ? "<div id='debug'>" : "<!-- ").showrendertime().(DEBUG ? "</div>": " -->")."\n";
	}
	if (ANALYTICS) {
		$ga  = "<script type='text/javascript'>"."\n";
		$ga .= "/*<![CDATA[*/"."\n";
		$ga .= "var _gaq = [['_setAccount', '".ANALYTICS_ACCOUNT."'], ".(ANALYTICS_MULTI ? "['_setDomainName', '".ANALYTICS_DOMAIN."'], " : "")."['_trackPageview']];"."\n";
		$ga .= "(function(d, t) {"."\n\t";
			$ga .= "var g = d.createElement(t), s = d.getElementsByTagName(t)[0];"."\n\t";
			$ga .= "g.async = true; g.src = '//www.google-analytics.com/ga.js'; s.parentNode.insertBefore(g, s);"."\n";
		$ga .= "})(document, 'script');"."\n";
		$ga .= "/*]]>*/"."\n";
		$ga .= "</script>";
		if (ANALYTICS_TO_HEAD) { add_to_head($ga); } else { echo $ga."\n"; }
	}
}

?>