<?php
/**
 * @package		 Joomla.Site
 * @subpackage	 mod_clean_fb
 * @copyright    Copyright (C) 2012-2013 Extenstions 4 Joomla. All rights reserved.
 * @license      GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;

// Clean Facebook Module Helper Class
abstract class modCleanFBHelper {
    public static function getFBPlugin(&$params) {
         
		 // Initialize variable
         $fb_data = array();
		 
		 // Get basic parameters
		 $fb_type = $params->get('type');
		 $fb_render = $params->get('render');
		 $fb_url = $params->get('fb_url');
		 $fb_width = $params->get('width');
		 $fb_height = $params->get('height');
		 $fb_color_scheme = $params->get('color_scheme');
		 $fb_faces = $params->get('fb_faces');
		 $fb_verb = $params->get('verb');
		 $fb_font = $params->get('font');
		 $fb_rspsv = $params->get('fb_rspsv');
		 $fb_border_on = $params->get('fb_border_on');
		 $fb_border_color = $params->get('fb_border_color');
		 $fb_border_radius = $params->get('fb_border_rounded');
		 $fb_border_radius_px = $params->get('fb_border_rounded_px');
		 $fb_background_color = $params->get('fb_background_color');
		 $fb_border_padding = $params->get('fb_border_padding');
		 $fb_appid = $params->get('fb_appid');
		 $fb_lang = $params->get('lang');	
		 
		 // Determine plugin type
		 if ($fb_type == 'a.like_btn') {
			
			$mod_type="Like Button"; // <-- Not Needed?
			
			// Get Like Button Options
			$fb_like_btn_layout = $params->get('like_btn_layout');
			$fb_send = $params->get('fb_send');	
			
			// Include plugin
			require("plugins/like_btn.php");
			
		 } elseif ($fb_type == "a.subscribe_btn") {
			 
			 $mod_type = "Subscribe Button"; // <-- Not Needed?
			 
			 // Get Subscribe Button Options
			 $fb_like_btn_layout = $params->get('like_btn_layout');	
			 
			 // Include plugin
			require("plugins/subscribe_btn.php");	
		 
		 } elseif ($fb_type == "a.send_btn") {
			 
			 $mod_type = "Send Button";	 // <-- Not Needed?
			 
			 // Include plugin
			 require("plugins/send_btn.php");	
		 
		 } elseif ($fb_type == "a.like_box") {
			 
			 $mod_type = "Like Box"; // <-- Not Needed?
			 
			 // Get Like Box Options
			 $fb_show_streams = $params->get('fb_show_streams');
			 $fb_show_header = $params->get('fb_show_header');			 
			 
			 // Include plugin
			 require("plugins/like_box.php");	
			 
		 } elseif ($fb_type == "a.comments") {
			 
			 $mod_type = "Comments"; // <-- Not Needed?
			 
			 // Get Comments Options
			 $num_pos = $params->get('num_pos');			 
			 
			 // Include plugin
			 require("plugins/comments.php");
			 
		 } elseif ($fb_type == "a.follow_btn") {
			 
			 $mod_type = "Facebook Follow Icons"; // <-- Not Needed?
			 
			 // Get Follow Button Options
			 $fb_follow_icn = $params->get('fb_follow_icn');
			 $fb_cust_img = $params->get('cust_img');
			 
			 // Include plugin
			 require("plugins/follow_btn.php");
                        
                 } else {
			 $mod_type="Not Selected";	// <-- not needed, should return error instead
		 }	
		 
		 // <-- Should be a check here that $mod_data isn't empty
		 
		 //$fb_data = array("mod_type" => $mod_type, "fb_url" => $fb_url, "mod_data" => $mod_data); // <-- does not need an array, should just return $mod_data
		 return $mod_data;
	}
}