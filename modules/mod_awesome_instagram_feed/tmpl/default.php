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

$i=1;
echo '<div class="insta_container">';
foreach ($InstaPhotos as $item) : 
    echo '<a class = "insta_link" rel="nofollow" target=_blank href = "'.$item["link"].'"><img style = "width: '.$PHOTO_WIDTH.';" class= "instagram_image ';
    if($DISPLAY_IMG_HOVER_EFFECT==1)
      echo 'instagram_hover';
     echo '" src = "'.$item["standard_resolution"].'"></a>';
    $i++;
    if($i>$AdminPhotoCount) break;
endforeach;
echo'</div>';

if($DISPLAY_ALL_PHOTOS_LINK==1)
  echo '<div><a rel="nofollow" target="_blank" href = "http://instagram.com/'.$USER_NAME.'">'.JText::_('MOD_AWESOME_INSTAGRAM_FEED_ALL_PHOTOS').'</a></div>';
?>