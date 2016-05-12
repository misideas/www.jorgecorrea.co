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

// Show Faces
$fb_faces_boolean = substr($fb_faces, 2);

// Set Layout
$fb_layout = substr($fb_like_btn_layout, 2);

// Set Color
$fb_color = substr($fb_color_scheme, 2);

// Set Font Family
$fb_font_fam = substr($fb_font, 2);

// Show Border
$fb_border_boolean = substr($fb_border_on, 2);

// Show Border Radius
$fb_border_radius_boolean = substr($fb_border_radius, 2);

// Set Responsive CSS and Add Border Div
$rspsv_style = "";

if ($fb_rspsv_boolean == "true") {
	$rspsv_style = "<style type=\"text/css\">#fb-root {display: none;} .fb_iframe_widget, .fb_iframe_widget span, .fb_iframe_widget span iframe[style] {width: 100% !important; } .fb_border { width: 100%; padding: " . $fb_border_padding . "px; background-color: " . $fb_background_color . "; overflow: hidden; ";
	$fb_width = "";
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

// Create Facebook Like Button
if ($fb_render == 'a.iframe') {
	$spec_char = array(':', '/', '#');
	$html_ent = array('%3A', '%2F', '%23');
	$fb_url_dec = str_replace($spec_char, $html_ent, $fb_url);
	$fb_bcolor_dec = str_replace($spec_char, $html_ent, $fb_border_color);
	$mod_data = $rspsv_style . "<iframe src=\"//www.facebook.com/plugins/follow.php?locale=" . $fb_locale . "&amp;href=" . $fb_url_dec . "&amp;width=" . $fb_width . "&amp;height=" . $fb_height . "&amp;colorscheme=" . $fb_color . "&amp;layout=" . $fb_layout . "&amp;font=" . $fb_font_fam . "&amp;show_faces=" . $fb_faces_boolean . "&amp;appId=" . $fb_appid . "\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; overflow:hidden; width:300px; height:65px;\" allowTransparency=\"true\"></iframe></div>";

} elseif ($fb_render == 'a.html5') {
	$mod_data = $rspsv_style . "<div id=\"fb-root\"></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = \"//connect.facebook.net/" . $fb_locale . "/all.js#xfbml=1&appId=" . $fb_appid . "\";  fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script><div class=\"fb-follow\" data-href=\"" . $fb_url . "\" data-width=\"" . $fb_width . "\" data-height=\"" . $fb_height . "\" data-colorscheme=\"" . $fb_color . "\" data-font=\"" . $fb_font_fam . "\" data-layout=\"" . $fb_layout . "\" data-show-faces=\"" . $fb_faces_boolean . "\"></div></div>";

} elseif ($fb_render == 'a.xfbml') {
	$mod_data = $rspsv_style . "<div id=\"fb-root\"></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = \"//connect.facebook.net/" . $fb_locale . "/all.js#xfbml=1&appId=" . $fb_appid . "\";  fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script><fb:follow href=\"" . $fb_url . "\" width=\"" . $fb_width . "\" height=\"" . $fb_height . "\" colorscheme=\"" . $fb_color . "\" layout=\"" . $fb_layout . "\" font=\"" . $fb_font_fam . "\" show_faces=\"" . $fb_faces_boolean . "\"></fb:follow></div>";
} else {
	$mod_data="Error: Rendering mode does not exist. Please re-save module using a known rendering method.";
}