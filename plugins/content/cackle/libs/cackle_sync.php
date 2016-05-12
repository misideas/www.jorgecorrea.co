<?php
/**
 * @author Cackle - cackle.me
 * @date: 22.08.13
 *
 * @copyright  Copyright (C) 2013 cackle.me . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die;
include (dirname(__FILE__).'/cackle_api.php');
class Sync {
    function Sync() {
        $cackle_api = new CackleAPI();
        $this->siteId = $cackle_api->cackle_get_param("siteId");
        $this->accountApiKey = $cackle_api->cackle_get_param("accountApiKey");
        $this->siteApiKey = $cackle_api->cackle_get_param("siteApiKey");
    }

    function has_next ($size_comments, $size_pagination = 100) {
        return $size_comments == $size_pagination;
    }
    function push_next_comments($mode,$comment_last_modified, $size_comments){
        $i = 1;
        while($this->has_next($size_comments)){
            if ($mode=="all_comments"){
                $response = $this->get_comments(0,$i) ;
            }
            else{
                $response = $this->get_comments($comment_last_modified,$i) ;
            }
            $size_comments = $this->push_comments($response); // get comment from array and insert it to wp db
            $i++;
        }
    }
    function init($mode = "") {
        $apix = new CackleAPI();
        $comment_last_modified = $apix->cackle_get_param("comment_last_modified");

        if ($mode == "all_comments") {
            $response = $this->get_comments(0);
        }
        else {
            $response = $this->get_comments($comment_last_modified);
        }
        //get comments from Cackle Api for sync
        if ($response==NULL){
            return false;
        }
        $size_comments = $this->push_comments($response); // get comment from array and insert it to wp db, and return size

        if ($this->has_next($size_comments)) {
            $this->push_next_comments($mode,$comment_last_modified, $size_comments);
        }

        return "success";
    }

    function get_comments($comment_last_modified, $cackle_page = 0){
        $this->get_url = "http://cackle.me/api/3.0/comment/list.json?id=$this->siteId&accountApiKey=$this->accountApiKey&siteApiKey=$this->siteApiKey";
        $host = $this->get_url . "&modified=" . $comment_last_modified . "&page=" . $cackle_page . "&size=100";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $host);

        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
        //curl_setopt($ch,CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-type: application/x-www-form-urlencoded; charset=utf-8',


            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
       // var_dump($host);die();

        return $result;

    }

    function to_i($number_to_format){
        return number_format($number_to_format, 0, '', '');
    }


    function cackle_json_decodes($response){

        $obj = json_decode($response,true);

        return $obj;
    }

    function filter_cp1251($string){
        $cackle_api = new CackleAPI();
        if ($cackle_api->cackle_get_param("cackle_encoding") == "cp1251"){
            iconv("utf-8", "windows-1251",$string);
        }
        return $string;
    }
    function insert_comment($comment,$status){

        /*
         * Here you can convert $url to your post ID
         */


        //var_dump($comment);
        if (isset($comment['author'])){
            $author_name = ($comment['author']['name']) ? $comment['author']['name'] : "";
            $author_email=  ($comment['author']['email']) ? $comment['author']['email'] :"";
            $author_www = isset($comment['author']['www']) ? $comment['author']['www'] :"";
            $author_avatar = isset($comment['author']['avatar']) ? $comment['author']['avatar'] :"";
            $author_provider = isset($comment['author']['provider']) ? $comment['author']['provider'] :"";
            $author_anonym_name = "";
            $anonym_email = "";
        }
        else{
            $author_name = ($comment['anonym']['name']) ? $comment['anonym']['name']: "" ;
            $author_email= ($comment['anonym']['email']) ?  $comment['anonym']['email'] : "";
            $author_www = "";
            $author_avatar = "";
            $author_provider = "";
            $author_anonym_name = $comment['anonym']['name'];
            $anonym_email = $comment['anonym']['email'];

        }
        $get_parent_local_id = null;
        $comment_id = $comment['id'];
        $comment_modified = $comment['modified'];
        $cackle_api = new CackleAPI();
        if ($cackle_api->cackle_get_param("last_comment")==0){
            $cackle_api->cackle_db_prepare();
        }
        $date =strftime("%Y-%m-%d %H:%M:%S", $comment['created']/1000);
        $ip = ($comment['ip']) ? $comment['ip'] : "";
        $message = $comment['message'];
        $comment_url = $comment['chan']['url'];
        $user_agent = 'Cackle:' . $comment['id'];
        $comment_rating = $comment['rating'];
        $comment_created = strftime("%Y-%m-%d %H:%M:%S", $comment['created']/1000);
        $comment_ip = $comment['ip'];
        $parent_id = null;

        if (isset($comment['parentId'])) {
            $comment_parent_id = $comment['parentId'];

            $query = "select comment_id from ". PREFIX ."_cackle_comments where user_agent ='Cackle:$comment_parent_id'";
            $parent_id = $cackle_api->db_connect( $query );
            if ($parent_id){
                $parent_id = $parent_id->comment_id;
            }
            else{
                $parent_id = null;
            }

        }

        // Create and populate an object.
        $comments = new stdClass();
        $comments->url = $comment_url;
        $comments->author_name=$author_name;
        $comments->author_email=$author_email;
        $comments->author_www=$author_www;
        $comments->author_avatar=$author_avatar;
        $comments->author_provider=$author_provider;
        $comments->anonym_name=$author_anonym_name;
        $comments->anonym_email=$anonym_email;
        $comments->created=$comment_created;
        $comments->ip=$comment_ip;
        $comments->message=$message;
        $comments->status=$status;
        $comments->user_agent=$user_agent;
        $comments->parent_id=$parent_id;
        $comments->post_id=$comment['chan']['channel'];

//die();

        try {
            // Insert the object into the user profile table.
            $result = JFactory::getDbo()->insertObject('#__cackle_comments', $comments);
        } catch (Exception $e) {
          //  echo "invalid insert -  - " . $e;
        }



        //////////////////////

        $cackle_api->cackle_set_param("last_comment",$comment_id);
        $get_last_modified = $cackle_api->cackle_get_param("last_modified");
        $get_last_modified = (int)$get_last_modified;
        if ($comment['modified'] > $get_last_modified) {
            $cackle_api->cackle_set_param("last_modified",(string)$comment['modified']);
        }

    }

    function comment_status_decoder($comment) {
        $status=0;
        if (strtolower($comment['status']) == "approved") {
            $status = 1;
        }
        elseif (strtolower($comment['status'] == "pending") || strtolower($comment['status']) == "rejected") {
            $status = 0;
        }
        elseif (strtolower($comment['status']) == "spam") {
            $status = 0;
        }
        elseif (strtolower($comment['status']) == "deleted") {
            $status = 0;
        }
        return $status;
    }

    function update_comment_status($comment_id, $status, $modified, $comment_content) {
        $cackle_api = new CackleAPI();
        
        $db = JFactory::getDbo();
$db->setDebug(true);
        $query = $db->getQuery(true);

        // Fields to update.
        $fields = array(
            $db->quoteName('status') . ' = '. $db->quote("$status"),
            $db->quoteName('message') . ' = '. $db->quote("$comment_content")
        );
//var_dump($comment_content);die();
        // Conditions for which records should be updated.
        $conditions = array(
            $db->quoteName('user_agent') . " = 'Cackle:$comment_id'",

        );
		
        $query->update(('#__cackle_comments'))->set($fields)->where($conditions);
        //var_dump($query);die();
        $db->setQuery($query);

        $result = $db->query();
        /////

        //$cackle_api->db_connect("update dle_comments set approve = $status, text = '$comment_content' where user_agent = //'Cackle:$comment_id';");
        $cackle_api->cackle_set_param("last_modified",$modified);

    }

    function push_comments ($response){
        $apix = new CackleAPI();
        $obj = $this->cackle_json_decodes($response,true);
        $obj = $obj['comments'];
        if ($obj) {
            $comments_size = count($obj);
            if ($comments_size != 0){
                foreach ($obj as $comment) {
                    if ($comment['id'] > $apix->cackle_get_param('last_comment')) {
                        $this->insert_comment($comment, $this->comment_status_decoder($comment));
                    } else {
                        // if ($comment['modified'] > $apix->cackle_get_param('cackle_comments_last_modified', 0)) {
                        $this->update_comment_status($comment['id'], $this->comment_status_decoder($comment), $comment['modified'], $comment['message'] );
                        // }
                    }
                }
            }
        }
        return $comments_size;

    }

}
?>