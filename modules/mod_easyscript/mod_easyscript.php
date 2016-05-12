<?php 

/**
 * Easy Family System - Easy Script module
 * Module Version 3.0.0 - Joomla! Version 3.x
 * Author: Ciro Artigot
 * info@aixeena.org
 * http://aixeena.org
 * Copyright (c) 2011 Ciro Artigot. All Rights Reserved. 
 * License: GNU/GPL 2, http://www.gnu.org/licenses/gpl-2.0.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

$code = $params->get( 'Code','');
$php_ = $params->get( 'php',0);

require(JModuleHelper::getLayoutPath('mod_easyscript'));