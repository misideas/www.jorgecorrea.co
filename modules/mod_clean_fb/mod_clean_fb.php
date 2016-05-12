<?php

/**
 * @package		 Joomla.Site
 * @subpackage	 mod_clean_fb
 * @copyright    Copyright (C) 2012-2015 Extenstions 4 Joomla. All rights reserved.
 * @license      GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$list = modCleanFBHelper::getFBPlugin($params);

// Only show module if there is something to show
if (isset($list)) {
    $moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
    require JModuleHelper::getLayoutPath('mod_clean_fb', $params->get('layout', 'default'));
}