<?php

###############################
#	Progexpert
###############################
class AuthySession{
    public $omMap;
    public $isConnected;
    public $lang;
    private $group;
    private $authyId;
    private $userRights;
    private $groupRights;
    private $adminRights;
    public $loginFormClass;
    private $xRights;
    public $sessVar = array();
    public $config;
    public $config_time;
    public $root_menu;
    public $root_menu_time;
    public $username;
    public $isRoot;
    function __construct(){
        require _BASE_DIR."inc/AddOmMap.php";
        $this->omMap = $omMap;
        if($this->isConnected != 'YES'){
            $this->isConnected = 'NO';
            
            if( defined('DEFAULT_LOCALE') and DEFAULT_LOCALE and empty($this->lang)){
                $this->lang = DEFAULT_LOCALE;
            }else if(empty($this->lang)){
                $langs = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"] ,0,2);
                $ln = explode(",",$_SERVER["HTTP_ACCEPT_LANGUAGE"]);            
                if($ln[0] == 'en-US' or $ln[0] == 'en-CA' or $ln[0] == 'en' or  $langs == 'en' ){ $this->lang = 'en_US';}else if($ln[0] == 'fr-CA'){ $this->lang = 'fr_CA';}
                if($this->lang=="" || $this->lang == NULL){
                    $this->lang = "fr_CA";					
                }
            }
        }
    }
    public function isAdmin(){ if($this->group === 'Admin'){ return true;	} return false;}
    
    public function getRightsCreation($curClass = '',&$q=''){return null;}
    public function hasRights($curClass = '',$needeRight='',$then=null){
        if($this->group === 'Admin'){ return true;}

        if(function_exists('beforeHasRights')){
            $beforeHasRights = beforeHasRights($curClass,$needeRight,$then);
            if(is_array($beforeHasRights) and $beforeHasRights['die']){
                return false;
            }elseif($beforeHasRights){
                return true;
            }
        }


        $userRightsAr = json_decode($this->userRights, true);
        if(is_array($curClass) and count($curClass)>0){
            foreach($curClass as $curClass){if($curClass){if(isset($userRightsAr[$curClass])){ if(strstr($userRightsAr[$curClass],$needeRight)){return true;}}}}
        }else if($curClass){
            if($curClass){if(isset($userRightsAr[$curClass])){ if(strstr($userRightsAr[$curClass],$needeRight)){return true;}}}
        }return false;
    }
    public function get($val){
        switch($val){
            case 'isConnected':return $this->isConnected;break;
            case 'connected':return $this->isConnected;break;
            case 'group':return $this->group;break;
            case 'firstname':return $this->firstname;break;
            case 'lastname':return $this->lastname;break;
            case 'rightsDonnes':return $this->rightsDonnes;break;
            case 'username':return $this->username;break;
            case 'id':return $this->authyId;break;
            case 'id_logged':return $this->idLogged;break;
            case 'pgroup':return $this->pgroup;break;
            case 'fullname':return $this->fullname;break;
            case 'key':return $this->key;break;
            case 'email':return $this->email;break;
            case 'passHash':return $this->passHash;break;
            case 'lang':return $this->lang;break;
            case 'ip':return $this->ip;break;
            case 'lastMsg':return $this->lastMsg;break;
            case 'userRights':return $this->userRights;break;
            case 'groupRights':return $this->groupRights;break;
            case 'adminRights':return $this->adminRights;break;
            case 'xRights':return $this->xRights;break;
            case 'isRoot':return $this->isRoot;break;
            case 'custom':return $this->custom;break;

            default: $this->$val;break;
        }
    }
    public function set($val, $value){
        switch($val){
            case 'isConnected':$this->isConnected = $value;break;
            case 'connected':$this->isConnected = $value;break;
            case 'group':$this->group = $value;break;
            case 'firstname':$this->firstname = $value;break;
            case 'lastname':$this->lastname = $value;break;
            case 'rightsDonnes':$this->rightsDonnes = $value;break;
            case 'username':$this->username = $value;break;
            case 'id':$this->authyId = $value;break;
            case 'id_logged':$this->idLogged = $value;break;
            case 'pgroup':$this->pgroup = $value;break;
            case 'fullname':$this->fullname = $value;break;
            case 'key':$this->key = $value;break;
            case 'email':$this->email = $value;break;
            case 'passHash':$this->passHash = $value;break;
            case 'lang':$this->lang = $value;break;
            case 'ip':$this->ip = $value;break;
            case 'lastMsg':$this->lastMsg = $value;break;
            case 'userRights':$this->userRights = $value;break;
            case 'groupRights':$this->groupRights = $value;break;
            case 'adminRights':$this->adminRights = $value;break;
            case 'xRights':$this->xRights = $value;break;
            case 'isRoot':$this->isRoot = $value;break;
            case 'custom':$this->custom = $value;break;

            default: $this->$val = $value;break;
        }
    }
    function isSecure(){if($this->ip == $_SERVER['REMOTE_ADDR'] && $this->sess_id == md5(session_id())){return true;}else{return false;}}
    public function isConnected(){ if($this->isConnected == 'YES'){return true;}else{return false;}}
}
