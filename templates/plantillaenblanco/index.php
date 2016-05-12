<?php  
 // no direct access 
 defined( '_JEXEC' ) or die( 'Restricted access' );?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
	<meta name="viewport" content="width=device-width , initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="google-site-verification" content="y9hUhYGftETszcdM8UAULiZaA-PBiBpf4mqRt-QsN2E" />
    
    <jdoc:include type="head" /> 
     <link rel="stylesheet" href="<?php echo $this->baseurl ;?>/templates/system/css/system.css" type="text/css" /> 
     <link rel="stylesheet" href="<?php echo $this->baseurl ;?>/templates/system/css/general.css" type="text/css" /> 
    <link rel="stylesheet" href="<?php echo $this->baseurl ;?>/templates/jorgecorrea/css/main.css" type="text/css" />

<!-- Fuentes -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    
<!-- Código que recoge la información del sufijo de clase del item para aplicarla al body Joomla 2.5 y 3.0 -->
<?php
    $app = JFactory::getApplication();
 
    $cparams =  $app->getParams('com_content');
	$clasebody = $cparams->get('pageclass_sfx');
?>
   
<!--Código que añade cifra del "item" al body Joomla 3.0-->
<?php
	$itemid = JRequest::getVar('Itemid');
	$application = JFactory::getApplication();
	$menu = $application->getMenu();
	$item = $menu->getItem($itemid);
	$link = new JURI($item->link);
	$link->setVar('ItemId', $itemid);
?>
</head>
<div id="main">
	<div class="wrapper">
        <jdoc:include type="component" />
        <jdoc:include type="modules" name="bottom" style="xhtml" />
    </div>
</div>
</body>
</html>
