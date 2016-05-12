<?php
/**
* @version 1.0.0 $ 15.07.2015
* @package awesome_instagram_feed
* @copyright (C) 2015 Lawyer Poet Developers
* @license GNU General Public License version 3 or later
* 
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

defined('_JEXEC') or die;
 

require_once __DIR__ . '/helper.php';
 

$document = JFactory::getDocument(); 
$document->addStyleSheet('modules/mod_awesome_instagram_feed/tmpl/style.css');


$AdminPhotoCount = $params->get('AdminPhotoCount');
$CLIENT_ID = $params->get('CLIENT_ID');
$USER_ID = $params->get('USER_ID');
$PHOTO_WIDTH = $params->get('PHOTO_WIDTH');
$USER_NAME = $params->get('USER_NAME');
$DISPLAY_ALL_PHOTOS_LINK = $params->get('DISPLAY_ALL_PHOTOS_LINK');
$DISPLAY_IMG_HOVER_EFFECT = $params->get('DISPLAY_IMG_HOVER_EFFECT');


$InstaPhotos = modAwesomeInstagramFeed::getInstaPhotos($CLIENT_ID, $USER_NAME);


require JModuleHelper::getLayoutPath('mod_awesome_instagram_feed', $params->get('layout', 'default'));