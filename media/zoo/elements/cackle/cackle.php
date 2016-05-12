<?php
/**
 * @author Cackle - cackle.me
 * @date: 22.08.13
 *
 * @copyright  Copyright (C) 2013 cackle.me . All rights reserved.
 * @license    GNU/GPL v.3 or later.
 */
defined('_JEXEC') or die('Restricted access');
require_once JPATH_ROOT . '/plugins/content/cackle/helpers/cackle.php';

class ElementCackle extends Element implements iSubmittable  {

    public function edit() {

    }
    public function render($params = array()) {
        $plugin =JPluginHelper::getPlugin('content', 'cackle');
        $plg_param = json_decode($plugin->params);
        $enableZoo = $plg_param->enableZoo;
        if (!empty($plugin)){
            if(JFactory::getApplication()->input->get('view') == 'item') {
                return CackleHelper::getWidgetHtml('com_zoo', $this->_item->id);
            }
            else{
                if($enableZoo){
                    $item_route = JRoute::_($this->app->route->item($this->_item, false), true, -1).'#mc-container';
                    $html = '<a cackle-channel="com_zoo_'.$this->_item->id.'" href="'.$item_route.'">Cackle</a>';
                    return $html.CackleHelper::getCounterHtml();
                }
            }
        }

    else  {

        }

    }

    public function renderSubmission($params = array()) {
        return $this->edit();
    }


    public function validateSubmission($value, $params) {
        return $this->edit();
    }
}
?>