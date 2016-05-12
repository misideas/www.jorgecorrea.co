<?php
/**
 * @author Cackle - cackle.me
 * @date: 22.08.13
 *
 * @copyright  Copyright (C) 2013 cackle.me . All rights reserved.
 * @license    GNU/GPL v.3 or later.
 */
defined( '_JEXEC' ) or die;


class CackleHelper  extends JPlugin
{
    public static function time_is_over($cron_time){
        $cackle_api = new CackleAPI();
        $get_last_time = $cackle_api->cackle_get_param("last_time");
        $now=time();
        if ($get_last_time==""){
            $set_time = $cackle_api->cackle_set_param("last_time",$now);
            return time();
        }
        else{
            if($get_last_time + $cron_time > $now){
                return false;
            }
            if($get_last_time + $cron_time < $now){
                $set_time = $cackle_api->cackle_set_param("last_time",$now);
                return $cron_time;
            }
        }
    }

    public static function get_local_comments($mcChannel){
        //getting all comments for special post_id from database.
        $cackle_api = new CackleAPI();
        $post_id = $mcChannel;
        $cackle_api->cackle_db_prepare();
        $get_all_comments = $cackle_api->db_connect("select * from ".PREFIX."_cackle_comments where post_id = '$post_id' and status = 1;",true,true);

        return $get_all_comments;
    }

    public static function list_comments($mcChannel){
        $obj = CackleHelper::get_local_comments($mcChannel);
        if($obj!=null){
            ob_start();
            foreach ($obj as $comment) {
                CackleHelper::cackle_comment($comment);
            }
            $result = ob_get_contents();
            ob_end_clean();
            return $result;
        }

    }
    public static function getTemplatePath($pluginName,$file){

        $mainframe = &JFactory::getApplication();
        $p = new JObject;
        $pluginGroup = 'content';

        if(file_exists(JPATH_SITE.DSС.'templates'.DSС.$mainframe->getTemplate().DSС.'html'.DSС.$pluginName.DSС.str_replace('/',DSС,$file))){
            $p->file = JPATH_SITE.DSС.'templates'.DSС.$mainframe->getTemplate().DSС.'html'.DSС.$pluginName.DSС.$file;
            $p->http = JURI::root(true).'/templates/'.$mainframe->getTemplate().'/html/'.$pluginName.'/'.$file;
        } else {
            if(version_compare(JVERSION,'1.6.0','ge')) {
                // Joomla! 1.6+
                $p->file = JPATH_SITE.DSС.'plugins'.DSС.$pluginGroup.DSС.$pluginName.DSС.$pluginName.DSС.'tmpl'.DSС.$file;
                $p->http = JURI::root(true).'/plugins/'.$pluginGroup.'/'.$pluginName.'/'.$pluginName.'/tmpl/'.$file;
            } else {
                // Joomla! 1.5
                $p->file = JPATH_SITE.DSС.'plugins'.DSС.$pluginGroup.DSС.$pluginName.DSС.'tmpl'.DSС.$file;
                $p->http = JURI::root(true).'/plugins/'.$pluginGroup.'/'.$pluginName.'/tmpl/'.$file;
            }
        }
        return $p;
    }
    public static function cackle_auth($apiId,$userinfo){
        $timestamp = time();
        $siteApiKey = $apiId;

        if ($userinfo->guest==0){
            $user = array(
                'id' => $userinfo->id,
                'name' => $userinfo->name,
                'email' => $userinfo->email,
                'avatar' => ''
            );

            $user_data = base64_encode(json_encode($user));
        }
        else{
            $user = '{}';
            $user_data = base64_encode($user);
        }
        $sign = md5($user_data . $siteApiKey . $timestamp);
        return "$user_data $sign $timestamp";

    }

    public static function cackle_comment( $comment) {

        ?><li  id="cackle-comment-<?php echo $comment->comment_id; ?>">
        <div id="cackle-comment-header-<?php echo $comment->comment_id; ?>" class="cackle-comment-header">
            <cite id="cackle-cite-<?php echo $comment->comment_id;; ?>">
                <?php if(isset($comment->author_name)) : ?>
                    <a id="cackle-author-user-<?php echo $comment->comment_id;; ?>" href="#" target="_blank" rel="nofollow"><?php echo $comment->author_name; ?></a>
                <?php else : ?>
                    <span id="cackle-author-user-<?php echo $comment->comment_id;; ?>"><?php echo $comment->author_name; ?></span>
                <?php endif; ?>
            </cite>
        </div>
        <div id="cackle-comment-body-<?php echo $comment->comment_id;; ?>" class="cackle-comment-body">
            <div id="cackle-comment-message-<?php echo $comment->comment_id;; ?>" class="cackle-comment-message">
                <?php echo $comment->message; ?>
            </div>
        </div>
        </li><?php

    }

	public static function getWidgetHtml($component, $mcChannel, $title='')
	{
        $sync = new Sync();
        if (CackleHelper::time_is_over(CACKLE_TIMER)){

            $sync->init();
        }
        $plugin = JPluginHelper::getPlugin('content', 'cackle');

        $plg_param = json_decode($plugin->params);
        $plg_param->acountApiKey;
        $plg_param->siteApiKey;
        $siteId=$plg_param->siteId;
        $enableZoo = $plg_param->enableZoo;
        //var_dump($contentId);
        if ($plg_param->sso==1) {
            $userinfo = JFactory::getUser();
            $mcSSOAuth	= CackleHelper::cackle_auth($plg_param->siteApiKey,$userinfo);
            $auth=", ssoAuth: '".$mcSSOAuth."'";
        } else {
            $auth="";
        }

        if ($component=='com_zoo'){
            if(!$enableZoo) return;
            $mcChannel = 'com_zoo_'. $mcChannel;
        }
        if ($siteId=="siteId"){
            $comments_html="";
        }
        else{
            $comments_html = CackleHelper::list_comments($mcChannel);
        }

        $chank = <<<HTML
                <div id="mc-container">
                <div id="mc-content">
                    <ul id="cackle-comments">
                    $comments_html
                    </ul>
                </div>
                </div>
				<script type="text/javascript">
				cackle_widget = window.cackle_widget || [];
                cackle_widget.push({widget: 'Comment', id: '$siteId', channel: '$mcChannel'$auth });
				document.getElementById('mc-container').innerHTML = '';
                (function() {
                  var mc = document.createElement('script');
                  mc.type = 'text/javascript';
                  mc.async = true;
                  mc.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cackle.me/widget.js';
                  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mc, s.nextSibling);
                })();
				</script>

HTML;

//var_dump($chank);
		return $chank;
	}

    public static function getCounterHtml() {
        if(!defined('CACKLE_COUNTER_LOADED')) {
            define('CACKLE_COUNTER_LOADED', 1);
            $plugin = JPluginHelper::getPlugin('content', 'cackle');

            $plg_param = json_decode($plugin->params);
            $plg_param->acountApiKey;
            $plg_param->siteApiKey;
            $siteId = $plg_param->siteId;
            //var_dump($contentId);


            $chank = <<<HTML
                <script type="text/javascript">
                //<![CDATA[
                cackle_widget = window.cackle_widget || [];
                cackle_widget.push({widget: 'CommentCount', id: '{$siteId}'});
                (function() {
                  var mc = document.createElement('script');
                  mc.type = 'text/javascript';
                  mc.async = true;
                  mc.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cackle.me/widget.js';
                  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mc, s.nextSibling);
                })();
                //]]>
				</script>

HTML;

//var_dump($chank);
            return $chank;
        }
    }



}