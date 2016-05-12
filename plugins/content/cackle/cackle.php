<?php
/**
 * @author Cackle - cackle.me
 * @date: 22.08.13
 *
 * @copyright  Copyright (C) 2013 cackle.me . All rights reserved.
 * @license    GNU/GPL v.3 or later.
 */
// no direct access
defined('_JEXEC') or die;
define("CACKLE_TIMER",300);
define("DSÑ","/");
define("K2_CHANNEL","200000");
define("VIRT_CHANNEL","300000");

jimport('joomla.plugin.plugin');

require_once dirname(__FILE__).'/libs/cackle_sync.php';
require_once dirname(__FILE__).'/helpers/cackle.php';

class plgContentCackle extends JPlugin
{
    public function onContentBeforeDisplay($context, &$row, &$params, $limitstart = 0 ){
    // RequestsF
    $option = JRequest::getCmd('option');
    $view 	= JRequest::getCmd('view');

    if($view == 'category' || $view == 'featured'){
     //   $this->onContentPrepare('com_content.article', $row, $params, $limitstart,$execute=false);
    }
        if(isset($row->text)){
            $row->introtext = $row->text;
        }
}


    public function onContentPrepare($context, &$row, &$params, $page = 0, $execute=true) {
        $view = JRequest::getCmd('view');

        if ($view=='productdetails'){
            if(!isset($row->id)) return;
        }

        if (!$execute) return;
        if ($context != "com_virtuemart.productdetails"){
            $this->renderCackle($row, $params, $page = 0, $context);
        }
        //
    }

    function onContentAfterDisplay($context, &$item, &$params, $limitstart) {
        if ($context == "com_virtuemart.productdetails"){
            return $this->renderCackle($item, $params, $page = 0, $context='');
        }
    }
    function onK2AfterDisplayContent( & $item, & $params, $limitstart) {

       return $this->renderCackle($item, $params, $page = 0, $context='');
    }

    public function renderCackle(&$row, $params, $page, $context){
        $view 	= JRequest::getCmd('view');
        $option 		= JRequest::getCmd('option');
        $enableContent = $this->params->def('enableContent');
        $enableK2 = $this->params->def('enableK2');
        $enableVirtuemart = $this->params->def('enableVirtuemart');

        if (($option=='com_content' && $view=='article' && $enableContent) || ($view == 'item' && $enableK2) || ($view == 'productdetails' && $enableVirtuemart)) {

            if (!isset($row->catid)) {
                $row->catid = '';
            }
            if ($view == 'article'){
                if(isset($row->id))
                    $mcChannel = $row->id;
            }
            if ($view == 'item'){
                if(isset($row->id))
                    $mcChannel = K2_CHANNEL . $row->id;
            }
            if ($view == 'productdetails'){

                $mcChannel = VIRT_CHANNEL . $row->virtuemart_product_id;
            }


            $cat = is_array($this->params->def('categories')) ? $this->params->def('categories') : array($this->params->def('categories'));
           
            if (!in_array($row->catid, $cat)&& $row->catid!=''||$view == 'productdetails') {
                $chank = CackleHelper::getWidgetHtml('com',$mcChannel);

                if ($view == 'article' || $view == 'productdetails'){
                    if (preg_match("/{nocackle}/i", $row->text)) {
                        //echo 'z31';
                        $row->text=str_replace("{nocackle}","",$row->text);

                    }
                    else{
                        $row->text .= $chank;
                    }
                }
                if ($view == 'item'){

                    if (preg_match("/{nocackle}/i", $row->text)) {
                        $row->text=str_replace("{nocackle}","",$row->text);
                        return "";
                    }
                    else{
                        //echo "z34";
                        return $chank;
                    }

                }


                //$article->text = str_replace("{Cackle}",$chank,$article->text);

            } else {

                $row->text = str_replace("{Cackle}", "", $row->text);
            }
        }
        elseif(($option=='com_content' && $enableContent && ($view=='frontpage' || $view=="featured" || $view=='section' || $view=='category')) || ($option=='com_k2' && $enableK2 && $view=='itemlist')) {
            $cat = is_array($this->params->def('categories')) ? $this->params->def('categories') : array($this->params->def('categories'));
            $enableCounter = $this->params->def('enableCounter');

            if ((isset($row->catid)) && !in_array($row->catid, $cat) && $enableCounter) {
           // if(version_compare(JVERSION,'2.6.0','ge')) $row->text = $row->introtext;

            $mainframe = JFactory::getApplication();
            $jinput = $mainframe->getPathway();

            require_once(JPATH_SITE.DSÑ.'components'.DSÑ.'com_content'.DSÑ.'helpers'.DSÑ.'route.php');

            // Output object
            $output = new JObject;
            $user				= JFactory::getUser();
            // Article URLs
            $websiteURL = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") ? "https://".$_SERVER['HTTP_HOST'] : "http://".$_SERVER['HTTP_HOST'];

            if(version_compare(JVERSION,'1.6.0','ge')) {
                //$levels = $user->authorisedLevels();
                $row->access=true;
                //if (in_array($row->access, $levels)) {

                    if($view == 'article' && isset($row->readmore_link)){
                        $itemURL = $row->readmore_link;
                    }
                    if($view == 'itemlist'){
                        $itemURL = $row->link;
                    }
                    else {
                        $itemURL = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catid));
                    }
               // }
            } else {
                $itemURL = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
            }

            $itemURLbrowser = explode("#",$websiteURL.$_SERVER['REQUEST_URI']);
            $itemURLbrowser = $itemURLbrowser[0];

            // Article URL assignments
            $output->itemURL 		    = $websiteURL.$itemURL;
            $output->itemURLrelative 	= $itemURL;
            $output->itemURLbrowser		= $itemURLbrowser;

            $pluginGroup = 'content';
            $pluginName = 'cackle';
            $list_url = $output->itemURL;
            if ($view == 'itemlist'){
                $row_id = K2_CHANNEL . $row->id;
            }
            else{
                $row_id = $row->id;
            }
            $getListingTemplate = <<<HTML
            <a class="jsCackleCounterLink" href="$list_url#mc-container" data-cackle-channel="$row_id">
            Comments
            </a>
HTML;

            if ($view=='frontpage' || $view=="featured" || $view=='section' || $view=='category'){
                if (preg_match("/{nocackle}/i", $row->text)) {

                    $row->text=str_replace("{nocackle}","",$row->text);
                }
                else{

                    $row->text .= $getListingTemplate;
                }

            }

            if ($view == 'itemlist'){
                if (preg_match("/{nocackle}/i", $row->text)) {
                    $row->text=str_replace("{nocackle}","",$row->text);
                }
                else{

                    return $getListingTemplate;
                }

            }
        }
        }
    }
    function onAfterRender() {

        // API
        $mainframe	= JFactory::getApplication();
        $document 	= JFactory::getDocument();

        // Assign paths
        $sitePath = JPATH_SITE;
        $siteUrl  = JURI::root(true);

        // Requests
        $option 		= JRequest::getCmd('option');
        $view 			= JRequest::getCmd('view');
        $layout 		= JRequest::getCmd('layout');
        $page 			= JRequest::getCmd('page');
        $secid 			= JRequest::getInt('secid');
        //$catid 			= JRequest::getInt('catid');
        $catid=JRequest::getVar( 'catid','' );
        $itemid 		= JRequest::getInt('Itemid');
        if(!$itemid) $itemid = 999999;
        $plugin = JPluginHelper::getPlugin('content', 'cackle');
        $pluginParams=json_decode($plugin->params);
        $enableCounter = $pluginParams->enableCounter;
            if(strpos(JResponse::getBody(),'#mc-container')===false) return;
            if($mainframe->isAdmin()) return;
            if(!$enableCounter){
                return;
            }

            $siteId = $pluginParams->siteId;
            // Append head includes only when the document is in HTML mode
            if(JRequest::getCmd('format')=='html' || JRequest::getCmd('format')==''){
                $elementToGrab = '</body>';
                $htmlToInsert = CackleHelper::getCounterHtml();

                // Output
                $buffer = JResponse::getBody();
                $buffer = str_replace($elementToGrab, $htmlToInsert."\n\n".$elementToGrab, $buffer);
                JResponse::setBody($buffer);
            }


    }

}

?>
