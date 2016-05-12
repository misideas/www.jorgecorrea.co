<?php  
 // no direct access 
 defined( '_JEXEC' ) or die( 'Restricted access' );?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
	<meta name="viewport" content="width=device-width , initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="google-site-verification" content="y9hUhYGftETszcdM8UAULiZaA-PBiBpf4mqRt-QsN2E" />
    
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="apple-touch-fullscreen" content="yes" />
    
    <script src="<?php echo $this->baseurl ;?>/templates/<?php echo $this->template ;?>/js/example-jRespond.min.js"></script>
    <jdoc:include type="head" /> 
     <link rel="stylesheet" href="<?php echo $this->baseurl ;?>/templates/system/css/system.css" type="text/css" /> 
     <link rel="stylesheet" href="<?php echo $this->baseurl ;?>/templates/system/css/general.css" type="text/css" /> 
    <link rel="stylesheet" href="<?php echo $this->baseurl ;?>/templates/<?php echo $this->template ;?>/css/main.css" type="text/css" />

	<link rel="apple-touch-icon" href="<?php echo $this->baseurl ;?>/templates/<?php echo $this->template ;?>/images/apple-touch-icon.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $this->baseurl ;?>/templates/<?php echo $this->template ;?>/images/apple-touch-icon-144x144-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->baseurl ;?>/templates/<?php echo $this->template ;?>/images/apple-touch-icon-114x114-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->baseurl ;?>/templates/<?php echo $this->template ;?>/images/apple-touch-icon-72x72-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo $this->baseurl ;?>/templates/<?php echo $this->template ;?>/images/apple-touch-icon-57x57-precomposed.png" />

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
<body id="body_<?php echo $itemid; ?>" class="<?php echo $clasebody; ?>">
<div id="icono-menu">
	<a href="#menu" class="menu-trigger ss-icon">≡</a>
</div>
<div id="banner">
	<jdoc:include type="modules" name="banner" style="xhtml" />
</div>
<div id="menu">
	<div class="wrapper">
    	<jdoc:include type="modules" name="menu" style="xhtml" />
    </div>
</div>
<div id="redes">
	<jdoc:include type="modules" name="redes" style="xhtml" />
</div>
<div id="slogan">
	<jdoc:include type="modules" name="slogan" style="xhtml" />
</div>
<div id="main">
	<div class="wrapper">
    	<div id="main-left">
            <jdoc:include type="modules" name="top" style="xhtml" />
            <jdoc:include type="component" />
            <jdoc:include type="modules" name="bottom" style="xhtml" />
        </div>
        <div id="main-right">
            <jdoc:include type="modules" name="right" style="xhtml" />
        </div>
    </div>
</div>
<div id="iniciativas">
	<div class="wrapper">
    	<h2>Iniciativas de Gestión</h2>
    	<jdoc:include type="modules" name="iniciativas" style="xhtml" />
    </div>
</div>
<div id="menufooter">
	<div class="wrapper">
    	<jdoc:include type="modules" name="menu-footer" style="xhtml" />
    </div>
</div>
<div id="mapa">
	<jdoc:include type="modules" name="mapa" style="xhtml" />
</div>
<div id="contacto">
	<div class="wrapper">
    	<jdoc:include type="modules" name="contacto" style="xhtml" />
    </div>
</div>
</body>
</html>
