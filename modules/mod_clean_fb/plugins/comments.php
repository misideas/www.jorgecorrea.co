<?php
/**
 * @package		 Joomla.Site
 * @subpackage	 mod_clean_fb
 * @copyright    Copyright (C) 2012-2013 Extenstions 4 Joomla. All rights reserved.
 * @license      GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;
// Set width
if ($fb_width == '') {
	$fb_width = "450";
}
// Set URL
if ($fb_url == '') {
	$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https')
       === FALSE ? 'http' : 'https';
	$host     = $_SERVER['HTTP_HOST'];
	$uri   = $_SERVER['REQUEST_URI'];
	$fb_url = $protocol . '://' . $host . $uri;
}
//Set App ID
if ($fb_appid == "") {
	$fb_appid = "480580252049577";
}
// Show Border
$fb_border_boolean = substr($fb_border_on, 2);
// Show Border Radius
$fb_border_radius_boolean = substr($fb_border_radius, 2);
// Responsive
if ($fb_rspsv == "0") {
	$fb_rspsv_boolean = "false";
} else {
	$fb_rspsv_boolean = "true";
}
// Set Responsive CSS and Add Border Div
$rspsv_style = "";
if ($fb_rspsv_boolean == "true") {
	$rspsv_style = "<style type=\"text/css\">.fb_iframe_widget span[style]{width:100% !important;} .fb_border { width: 100%; padding: " . $fb_border_padding . "px; background-color: " . $fb_background_color . "; overflow: hidden; ";
	$fb_width = "100%";
} else {
	$rspsv_style = "<style type=\"text/css\"> .fb_border { width: " . $fb_width . "px; padding: " . $fb_border_padding . "px; background-color: " . $fb_background_color . "; overflow: hidden; ";
}
if ($fb_border_boolean == "true") {
	$rspsv_style .= "border-width: 1px; border-style: solid; border-color: " . $fb_border_color . "; ";
}
if ($fb_border_radius_boolean == "true") {
	$rspsv_style .= "border-radius: " . $fb_border_radius_px . "px; ";
}
$rspsv_style .= "} </style><div class=\"fb_border\">";
// Set Language
$fb_locale = substr($fb_lang, 2);
// Create Facebook Comments Box
if ($fb_render == 'a.iframe') {
	$mod_data="Error: Comments Box unavailable for this render setting.";
} elseif ($fb_render == 'a.html5') {
	$mod_data = $rspsv_style . "<div id=\"fb-root\"></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;  js.src = \"//connect.facebook.net/" . $fb_locale . "/all.js#xfbml=1&appId=" . $fb_appid . "\";  fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script><div class=\"fb-comments\" data-href=\"" . $fb_url . "\" data-width=\"" . $fb_width . "\" data-numposts=\"" . $num_pos . "\" data-colorscheme=\"" . $fb_color . "\"></div></div>";
} elseif ($fb_render == 'a.xfbml') {
	$mod_data =  $rspsv_style . "<div id=\"fb-root\"></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = \"//connect.facebook.net/" . $fb_locale . "/all.js#xfbml=1&appId=" . $fb_appid . "\"; fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script> <fb:comments href=\"" . $fb_url . "\" colorscheme=\"" . $fb_color . "\" numposts=\"" . $num_pos . "\" width=\"" . $fb_width . "\"></fb:comments></div>";
} else {
	$mod_data = "Error: Rendering mode does not exist. Please re-save module using a known rendering method.";
}