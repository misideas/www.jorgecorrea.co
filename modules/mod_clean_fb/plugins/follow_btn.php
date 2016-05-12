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

// Set URL
if ($fb_url == '') {
	$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https')
       === FALSE ? 'http' : 'https';
	$host     = $_SERVER['HTTP_HOST'];
	$uri   = $_SERVER['REQUEST_URI'];
	$fb_url = $protocol . '://' . $host . $uri;
}

// Create Facebook Follow Us Icon
if ($fb_follow_icn == 'a.ic_fb_16') {
	$spec_char = array(':', '/', '#');
	$html_ent = array('%3A', '%2F', '%23');
	$fb_url_dec = str_replace($spec_char, $html_ent, $fb_url);
	$mod_data = $rspsv_style . "<a href=\"" . $fb_url . "\" target=\"_blank\"><img src=\"modules/mod_clean_fb/plugins/images/follow_btn/ic_fbk_16.png\" /></a></div>";

} elseif ($fb_follow_icn == 'a.ic_fb_22') {
	$spec_char = array(':', '/', '#');
	$html_ent = array('%3A', '%2F', '%23');
	$fb_url_dec = str_replace($spec_char, $html_ent, $fb_url);
	$mod_data = $rspsv_style . "<a href=\"" . $fb_url . "\" target=\"_blank\"><img src=\"modules/mod_clean_fb/plugins/images/follow_btn/ic_fbk_22.png\" /></a></div>";

} elseif ($fb_follow_icn == 'a.ic_fb_36') {
	$spec_char = array(':', '/', '#');
	$html_ent = array('%3A', '%2F', '%23');
	$fb_url_dec = str_replace($spec_char, $html_ent, $fb_url);
	$mod_data = $rspsv_style . "<a href=\"" . $fb_url . "\" target=\"_blank\"><img src=\"modules/mod_clean_fb/plugins/images/follow_btn/ic_fbk_36.png\" /></a></div>";

} elseif ($fb_follow_icn == 'a.btn_fb_100') {
	$spec_char = array(':', '/', '#');
	$html_ent = array('%3A', '%2F', '%23');
	$fb_url_dec = str_replace($spec_char, $html_ent, $fb_url);
	$mod_data = $rspsv_style . "<a href=\"" . $fb_url . "\" target=\"_blank\"><img src=\"modules/mod_clean_fb/plugins/images/follow_btn/btn_fbk_100_a.png\" /></a></div>";
        
} elseif ($fb_follow_icn == 'a.btn_fb_160') {
	$spec_char = array(':', '/', '#');
	$html_ent = array('%3A', '%2F', '%23');	
	$fb_url_dec = str_replace($spec_char, $html_ent, $fb_url);
	$mod_data = $rspsv_style . "<a href=\"" . $fb_url . "\" target=\"_blank\"><img src=\"modules/mod_clean_fb/plugins/images/follow_btn/btn_fbk_160_a.png\" /></a></div>";
	
} elseif ($fb_follow_icn == 'a.btn_fb_cust') {
	$spec_char = array(':', '/', '#');
	$html_ent = array('%3A', '%2F', '%23');
	$fb_url_dec = str_replace($spec_char, $html_ent, $fb_url);
	$fb_cust_img_url = str_replace($spec_char, $html_ent, $fb_cust_img);
	$mod_data = $rspsv_style . "<a href=\"" . $fb_url . "\" target=\"_blank\"><img src=\"images/" . $fb_cust_img_url . "\" /></a></div>";
        
} else {
        echo "error: missing options. Please check module settings.";
}