<?php
/**
* Featured Youtube Slider - Joomla Module
* Version			: 3.1
* Created by		: RBO - http://www.rumahbelanja.com & AppsNity - http://www.appsnity.com
* Created on		: Oct 2009 (Joomla 1.5.x), Dec 2010 (Joomla 1.6.x), Sept 30th, 2011 (For Joomla 1.7.x), August 27th, 2012 (For Joomla 2.5.x), March 9th, 2013 (For Joomla 3.0.x)
* Updated			: Nov 20th, 2014 (For Joomla 3.x.x)
* Package			: Joomla 3.x.x
* License			: http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

// get helper
require_once (dirname(__FILE__).'/helper.php');
$document 		= JFactory::getDocument();
$baseurl 		= JURI::base();
$modulefield	= ''.JURI::base(true).'/modules/mod_featured_youtube_slider/';

//Get this module id
$featytslide	= $module->id;
//Add For J!3.x.x Native
$nummod			= $featytslide;

$youtubecode 		= $params->get( 'youtubecode' );
$width		 		= $params->get( 'width', 250 );
$height		 		= $params->get( 'height', 220 );
$inner_padding 		= $params->get( 'inner_padding', 5 );
$outer_color 		= $params->get( 'outer_color', '#000' );
$inner_color 		= $params->get( 'inner_color', '#fff' );
$fullsc_btn			= $params->get( 'fullsc_btn', 1 );
$pagination_color 	= $params->get( 'pagination_color', '#0f0f0f' );
$pagination_hover	= $params->get( 'pagination_hover', '#ccc' );
$num_vid			= $params->get( 'num_vid');
$thumb_align		= $params->get( 'thumb_align');
$autoplay			= $params->get( 'autoplay',0);

$height_thumbs			= "auto";
$thumb_respon_correction=3;
$show_info				= $params->get( 'show_info', 0);
$player_ctrl_auto		= $params->get( 'player_ctrl_auto', 'visible');
$player_ctrl_theme		= $params->get( 'player_ctrl_theme', 'light');
$player_ctrl_progress	= $params->get( 'player_ctrl_progress', 'red');
$thumb_correction		= $params->get( 'thumb_correction', 0);
$thumb_correction_m470	= $params->get( 'thumb_correction_m470', 1);
$thumb_correction_m780	= $params->get( 'thumb_correction_m780', 0);
$thumb_correction_m990	= -25;
$use_responsive			= $params->get( 'use_responsive', 1);

if ($player_ctrl_auto=="visible"): $player_ctrl=0; endif;
if ($player_ctrl_auto=="slidein"): $player_ctrl=1; endif;
if ($player_ctrl_auto=="fadeout"): $player_ctrl=2; endif;

//Calculation YouTube Code
$youtubelist 	= explode( ',', $youtubecode );
$numyoutube 	= count($youtubelist);

$width_thumb			= (100/$num_vid) - (3 + $thumb_correction);
$width_thumb470			= (100/$num_vid) - (3 + $thumb_correction_m470);
$width_thumb780			= (100/$num_vid) - (3 + $thumb_correction_m780);
$width_thumb990			= (100/$num_vid) - (3 + $thumb_correction_m990);

$document->addScript($modulefield.'library/contentslider.js');
$document->addStylesheet($modulefield.'css/style-responsive.css');
$cssinline = '
	.responsive.modfytslider{
		background: '.$outer_color.';
	}
	
	.responsive .sliderwrapper{
		background: '.$outer_color.';
	}
	
	.responsive .sliderwrapper .contentdiv{
		background: '.$inner_color.';
	}

	.responsive .paginationfytslide{
		background: '.$pagination_color.';
	}
	
	.responsive .paginationfytslide a img,.paginationfytslide a:visited img{
		background: '.$outer_color.';
	}
	
	.responsive .paginationfytslide a:hover img{
		background: '.$pagination_hover.';
	}
	
	@media screen and (min-width: 378px) and (max-width: 470px){
		.responsive .paginationfytslide-inner a img,
		.responsive .paginationfytslide-inner img{
			width:'.$width_thumb470.'%!important;
		}
	}
	
	@media screen and (min-width: 471px) and (max-width: 780px){
		.responsive .paginationfytslide-inner a img,
		.responsive .paginationfytslide-inner img{
			width:'.$width_thumb780.'%!important;
		}
	}
	
	@media screen and (min-width: 781px) and (max-width: 991px){
		.responsive .paginationfytslide-inner a img,
		.responsive .paginationfytslide-inner img{
			width:'.$width_thumb990.'%!important;
		}
	}
';

$document->addStyleDeclaration($cssinline, 'text/css');	

//$list = modFeaturedYouTubeSliderHelper::getList($params);
require JModuleHelper::getLayoutPath('mod_featured_youtube_slider', $params->get('layout', 'default'));


?>