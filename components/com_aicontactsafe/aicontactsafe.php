<?php
/**
 * @version     $Id$ 2.0.0 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 * 
 * Modified by NVYush on 03.2014
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// start the session if no session was started
if ( session_id() == '' ) {
	session_start();
}

// load the main controller
require_once( JPATH_ROOT.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_aicontactsafe'.DIRECTORY_SEPARATOR.'controller.php' );

// load the main model
require_once( JPATH_ROOT.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_aicontactsafe'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'default.php' );

// load the main view
require_once( JPATH_ROOT.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_aicontactsafe'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'view.html.php' );

// include the table directory
JTable::addIncludePath(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_aicontactsafe'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'tables');

// get the current view
$view = JFactory::getApplication()->input->get('view', 'message');
// get the current task, default is 'display'
$task = JFactory::getApplication()->input->get('task', 'display');
// get the section of the component
$sTask = JFactory::getApplication()->input->get('sTask', '');
// if no sTask is defined use the value in $view
if (strlen(trim($sTask)) == 0) {
	$sTask = $view;
}

// it the sTask variable is 'default' or '' reset it to 'projects'
if ($sTask == 'default' or $sTask == '' or ( $sTask != 'message' && $sTask != 'captcha' && $sTask != 'messages' )){
	$sTask = 'message';
}

if(strlen(trim($task)) == 0) {
	$task = 'display';
}

// if a section is selected the coresponding controller is loaded
if (strlen($sTask) > 0){
	require_once( JPATH_COMPONENT.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$sTask.'.php' );
}
$controllerName = 'AiContactSafeController'.$sTask;

// generate the parameters for the controller
$controller_parameters = array('task'=>$task,'sTask'=>$sTask);
// load the controller and execute the current task
$controller = new $controllerName($controller_parameters);
$controller->execute( $task );
$controller->redirect();
