<?php
if (!defined("IN_FUSION")) { die("Access Denied"); }

/*
 * Render time, MySQL queries (true or false).
 */
define("DEBUG", true);

/*
 * Host for static content.
 */
define("STATIC_DOMAIN", THEMES."italian_nss/");

/*
 * RSS Widget (false or rss url)
 */
define("RSS", "http://php-fusion.it/infusions/rss_feed_panel/rss_news.php");

/*
 * Multiple-level dropdown menus (true or false)
 */
define("SUBNAV", true);

/*
 * Sidebar (true or false)
 */
define("SIDEBAR", true);

/*
 * Analytics settings.
 * 1. Analytics on or off.
 * 2. Account trackcode.
 * 3. Turn multi subdomain on or off.
 * 4. Analytics Domain name.
 * 5. Add javascript to header tag.
 */
define("ANALYTICS", false);
define("ANALYTICS_ACCOUNT", "UA-107557-4");
define("ANALYTICS_MULTI", false);
define("ANALYTICS_DOMAIN", ".yourdomain.com");
define("ANALYTICS_TO_HEAD", true);
/*
 * Set custom images
 */
define("THEME_BULLET", "<span class='bullet'>&bull;</span>"); // &middot; <!-- • --> 
define("THEME_BULLET2", "<span class='bullet'>&bull;</span>"); // &middot; <!-- • --> 
set_image("up", STATIC_DOMAIN."images/up.png");
set_image("down", STATIC_DOMAIN."images/down.png");
set_image("left", STATIC_DOMAIN."images/left.png");
set_image("right", STATIC_DOMAIN."images/right.png");
set_image("pollbar", STATIC_DOMAIN."images/pollbar.gif");
set_image("folder", STATIC_DOMAIN."images/forum/folder.png");
set_image("foldernew", STATIC_DOMAIN."images/forum/foldernew.png");
set_image("folderlock", STATIC_DOMAIN."images/forum/folderlock.png");
set_image("stickythread", STATIC_DOMAIN."images/forum/stickythread.png");
set_image("printer", STATIC_DOMAIN."images/printer.png");
// set_image("panel_on", STATIC_DOMAIN."images/panel_on.gif");
// set_image("panel_off", STATIC_DOMAIN."images/panel_off.gif");
set_image("panel_on", STATIC_DOMAIN."images/panel_on.png");
set_image("panel_off", STATIC_DOMAIN."images/panel_off.png");
set_image("edit", STATIC_DOMAIN."images/edit.png");
set_image("reply", "reply");
set_image("newthread", "newthread");
set_image("web", "web");
set_image("pm", "pm");
set_image("quote", "quote");
set_image("forum_edit", "forum_edit");

?>