<?php
defined('_JEXEC') or die;
define("PREFIX","#_");

class CackleAPI extends JPlugin{

    function __construct(){
        $plugin = JPluginHelper::getPlugin('content', 'cackle');
        $this->last_error = null;
        $plg_param = json_decode($plugin->params);
        $this->accountApiKey = $plg_param->acountApiKey;
        $this->siteApiKey = $plg_param->siteApiKey;
        $this->siteId = $plg_param->siteId;


    }
    function db_connect($query,$return=true,$list=false){
        try {
            $db = JFactory::getDBO();
            $db->setQuery($query);
            $db->setDebug(false);
            if($return){
                if($list){
                    return $db->loadObjectList();
                }
                else{
                    return $db->loadObject();
                }


            }
            return $db->query();
        }
        catch (Exception $e) {
            echo "invalid sql -  - " . $e;
        }


    }
    function conn(){
        try {
            $db    = JFactory::getDBO();
            return $db;
        }
        catch (Exception $e) {
          //  echo "invalid sql -  - " . $e;
        }
    }
    function db_table_exist($table){
        $app = JFactory::getApplication();
		//if ( version_compare( JVERSION, '3.0', '<' ) == 1) {  
		$prefix = $app->getCfg('dbprefix');
		//}
		//else{
        //$prefix = $app->get('dbprefix');
		//}
		//var_dump($prefix);die();
        $tables = JFactory::getDbo()->getTableList();
        //print_r($tables);print_r("and my is_=".$prefix.$table);die();
        if(in_array($prefix.$table, $tables)){
            //print_r("true");die();
            return true;

        }
        else {
           // print_r("false");die();
            return false;
        }
    }

    function cackle_set_param($param, $value){
       if ($this->db_table_exist("cackle")){
            $this->db_connect("delete from ".PREFIX."_cackle where param = '$param'",false);
           $this->db_connect("insert into ".PREFIX."_cackle (param, value) values ('$param','$value')",false);
        }
        else{
            $this->db_connect("CREATE TABLE ".PREFIX."_cackle (param VARCHAR(100) NOT NULL DEFAULT '',value VARCHAR(100) NOT NULL DEFAULT '')",false);
        }
    }

    public function  cackle_get_param($param){
        if ($param == "siteId" || $param == "accountApiKey" || $param == "siteApiKey" || $param == "sso" ){
            return $this->$param;
        }
        else{
            if ($this->db_table_exist("cackle")){
                $ex = $this->db_connect("select value from ".PREFIX."_cackle where param = '$param'");

                if ($ex){
                    return $ex->value;
                }
                else{
                    return null;
                }

            }
            else{
                $this->db_connect("CREATE TABLE ".PREFIX."_cackle (param VARCHAR(100) NOT NULL DEFAULT '',value VARCHAR(100) NOT NULL DEFAULT '')",false);
            }
        }

    }


        function cackle_db_prepare(){

            if ($this->db_table_exist("cackle_comments")){
            //    $this->db_connect("ALTER TABLE ".PREFIX."_comments ADD user_agent VARCHAR(64) NOT NULL default ''");
               // $this->db_connect("ALTER TABLE ".PREFIX."_comments MODIFY 'user_agent' varchar(64) NOT NULL default ''");
            }
            else{
                $this->db_connect("CREATE TABLE ".PREFIX."_cackle_comments (
                    comment_id BIGINT(20) NOT NULL AUTO_INCREMENT,
                    parent_id BIGINT(20) NULL DEFAULT NULL,
                    post_id VARCHAR(500) NULL DEFAULT NULL,
                    url VARCHAR(20) NULL DEFAULT NULL,
                    message TEXT NULL,
                    status VARCHAR(11) NULL DEFAULT NULL,
                    user_agent VARCHAR(200) NOT NULL,
                    ip VARCHAR(39) NULL DEFAULT NULL,
                    author_name VARCHAR(60) NULL DEFAULT NULL,
                    author_email VARCHAR(100) NULL DEFAULT NULL,
                    author_avatar VARCHAR(200) NULL DEFAULT NULL,
                    author_www VARCHAR(200) NULL DEFAULT NULL,
                    author_provider VARCHAR(32) NULL DEFAULT NULL,
                    anonym_name VARCHAR(60) NULL DEFAULT NULL,
                    anonym_email VARCHAR(100) NULL DEFAULT NULL,
                    created DATETIME NULL DEFAULT NULL,
                    PRIMARY KEY (comment_id)
                )",false);
            }

        }



    function import_wordpress_comments(&$wxr, $timestamp, $eof) {
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'http://import.cackle.me/api/import-wordpress-comments');

            curl_setopt ($curl, CURLOPT_TIMEOUT, 60);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt ($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
           // curl_setopt ($curl, CURLOPT_REFERER, "localhost");
            curl_setopt ($curl, CURLOPT_ENCODING, "gzip, deflate");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    "Content-type" => "application/x-www-form-urlencoded; charset='windows-1251'",

                    "Accept" =>	"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"

                )
            );
            $data = array(

                'siteId' =>$this->cackle_get_param("site_id"),
                'accountApiKey' => $this->cackle_get_param("account_api"),
                'siteApiKey' => $this->cackle_get_param("site_api"),

                'wxr' => $wxr,

                'eof' => (int)$eof

            );
            $query = http_build_query($data, '', '&');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $query

            );
            $response = curl_exec($curl);
            curl_close($curl);
        }





        if ($response['body']=='fail') {
            $this->api->last_error = $response['body'];
            return -1;
        }
        $data = $response;
        if (!$data || $data== 'fail') {
            return -1;
        }

        return $data;
    }
    function get_last_error() {
        if (empty($this->last_error)) return;
        if (!is_string($this->last_error)) {
            return var_export($this->last_error);
        }
        return $this->last_error;
    }
    function curl($url) {
        $ch = curl_init();
        $php_version = phpversion();
        $useragent = "Drupal";
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("referer" =>  "localhost"));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}