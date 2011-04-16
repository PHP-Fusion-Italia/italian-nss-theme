/* getting fade slider settings */
$fade_slider_speed = 5000;

/* getting nivo slider settings */
$nivo_slider_speed = 5000;
$nivo_slider_effect = 'random';

/* getting headlines settings */
$headlines_delay = 5000;

/* play with jQuery */
jQuery(document).ready(function() {
	jQuery('a').wrap('<span class="js-span"></span>');
	jQuery('.pagenav').addClass('pagenav-js').removeClass('pagenav');
	jQuery('.pagenav-js span').addClass('js-span');
	jQuery('#page-viewthread table .pagenav-js').hide();
});
jQuery(document).ready(function() {
	jQuery('.it_nss_js_show').show().removeClass('it_nss_js_show');
});
jQuery(document).ready(function() {
	jQuery(".forum_table tr:nth-child(odd), .forum_idx_table tr:nth-child(odd)").children("td").addClass("odd");
	jQuery(".forum_table tr, .forum_idx_table tr").hover(function() { jQuery(this).children("td").toggleClass("td_hover") });
});