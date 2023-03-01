<?php

 ###############################
#	Progexpert
###############################

//@@INCLUDE | HEADER CUSTOM
if(file_exists(_BASE_DIR.'inc/before_header.include_custom.php')) { include _BASE_DIR.'inc/before_header.include_custom.php'; }


redirection_form();
//@@LANG | LANGUES SUPPORTÉES

$supportedLangs = array( 
array('code' => 'fr_CA', 'label' => Locale::getDisplayLanguage("fr_CA")),
array('code' => 'en_US', 'label' => Locale::getDisplayLanguage("en_US")));
                                
if(!is_object($_SESSION[_AUTH_VAR]) or (get_class($_SESSION[_AUTH_VAR]) != 'AuthySession')){
    session_regenerate_id();
    $_SESSION['vr_val']  = session_id();
    unset($_SESSION[_AUTH_VAR]);
    $_SESSION[_AUTH_VAR] = new AuthySession();
}

if($_SESSION[_AUTH_VAR]->get('connected') != 'YES'){automat_connect();}
if($_SESSION[_AUTH_VAR]->get('connected') == 'YES'){
    
    if($_SESSION[_AUTH_VAR]->get('id') and is_file(_INSTALL_PATH.'mod/tmp/'.$_SESSION[_AUTH_VAR]->get('id').'.authy')){
        $authyObj = AuthyQuery::create()->filterByIdAuthy($_SESSION[_AUTH_VAR]->get('id'))->findOne();
        if($authyObj and $authyObj->getIdAuthy()){
            $AuthyForm = new AuthyForm();
            $isRoot=false;if($_SESSION[_AUTH_VAR]->get('isRoot')){ $isRoot=true;}
            $AuthyForm->setSession($authyObj, $authyObj->getUsername());
            if($isRoot){ $_SESSION[_AUTH_VAR]->set('isRoot', true);}
        }unlink(_INSTALL_PATH.'mod/tmp/'.$_SESSION[_AUTH_VAR]->get('id').'.authy');
    }
}
if(strlen($_REQUEST['lg']) == 2){ if($_REQUEST['lg'] == "fr"){ $_REQUEST['lg'] = "fr_CA"; } elseif($_REQUEST['lg'] == "en"){ $_REQUEST['lg'] = "en_US"; } }

if(isset($_REQUEST['lg']) and $_REQUEST['lg'] == 'fr_CA' ){ $_SESSION[_AUTH_VAR]->lang = "fr_CA"; setcookie(_PROJECT_NAME."_lang",$_SESSION[_AUTH_VAR]->lang,time() + (10 * 365 * 24 * 60 * 60), '/');}
if(isset($_REQUEST['lg']) and $_REQUEST['lg'] == 'en_US' ){ $_SESSION[_AUTH_VAR]->lang = "en_US"; setcookie(_PROJECT_NAME."_lang",$_SESSION[_AUTH_VAR]->lang,time() + (10 * 365 * 24 * 60 * 60), '/');}

$struri_uri= $_SERVER['REQUEST_URI'];

$struri_uri= str_replace('?lg=fr_CA','',$struri_uri);
$struri_uri= str_replace('?lg=en_US','',$struri_uri);
if(isset($_REQUEST['IdAuthy']) and $_REQUEST['IdAuthy']) {
    $struri_uri = str_replace('?IdAuthy='.$_REQUEST['IdAuthy'],'',$struri_uri);
    $struri_uri = str_replace('&IdAuthy='.$_REQUEST['IdAuthy'],'',$struri_uri);
}
if($_SESSION[_AUTH_VAR]->lang =='') {
    $_SESSION[_AUTH_VAR]->lang ="fr_CA";
}
$struri = str_replace(_SITE_URL,'','http'.@$s.'://'.$_SERVER['SERVER_NAME'].$struri_uri);
$struri2 = $struri;
if(isset($_REQUEST['iarc']) and $_REQUEST['iarc']){
    $struri2 = str_replace('?iarc='.$_REQUEST['iarc'],'',$struri2);
    $struri2 = str_replace('&iarc='.$_REQUEST['iarc'],'',$struri2);
}

$symbole = "?";
$pos = strpos($struri,$symbole);
if($pos !== false) { $symbole = "&"; }
$symbole2 = "?";
$pos = strpos($struri2,$symbole2);
if($pos !== false){ $symbole2 = "&"; }

//@@LANG | LANGAGE DU CK_EDITOR
if($_SESSION[_AUTH_VAR]->lang == "fr_CA") { $lang_ckeditor = 'fr'; } else { $lang_ckeditor = 'en';  }
/* ne pas mettre cela sa fait tout planter je les enlevé define('_LOCAL_LC','en'); define('_LOCAL_LC','fr');  */

//@@LANG | CONFIGURATION DE LA LANGUE
setcookie("_lang",$_SESSION[_AUTH_VAR]->lang,time() + (10 * 365 * 24 * 60 * 60), '/');

if($_SESSION[_AUTH_VAR]->lang == 'fr_CA') {
    setlocale(LC_ALL, "fr_CA.utf8");
    setlocale(LC_TIME, "fr_CA.utf8"); 
    putenv('LC_ALL=fr_CA');
    define('_LOCAL_LC','fr_CA');
    define('_LOCAL_LC_HREF','fr');
    bindtextdomain("messages", _INSTALL_PATH."mod/locale");
    textdomain("messages");
    $lgChange = li(htmlLink(Locale::getDisplayLanguage("en_US"),_SITE_URL.$struri.$symbole.'lg=en_US'));
}
else if($_SESSION[_AUTH_VAR]->lang == 'en_US') {
    setlocale(LC_ALL, "en_US.utf8");
    setlocale(LC_TIME, "en_US.utf8"); 
    putenv('LC_ALL=en_US');
    define('_LOCAL_LC','en_US');
    define('_LOCAL_LC_HREF','en');
    bindtextdomain("messages", _INSTALL_PATH."mod/locale");
    textdomain("messages");
    $lgChange = li(htmlLink(Locale::getDisplayLanguage("fr_CA"),_SITE_URL.$struri.$symbole.'lg=fr_CA'));
}
if(defined('_LC_NUMERIC')){setlocale(LC_NUMERIC,_LC_NUMERIC);}else{setlocale(LC_NUMERIC, 'en_CA');}

//@@SELECT @@LANG | TEXTE PAR DÉFAUT DU SELECT BOX
define("_MESS_SELECTION",_("Sélectionner"));

//@@INCLUDE | HEADER CUSTOM
if(file_exists(_BASE_DIR.'inc/header.include_custom.php')) { include _BASE_DIR.'inc/header.include_custom.php'; }

if(!$_SESSION[_AUTH_VAR]->sessVar['IdAuthy']) { $_SESSION[_AUTH_VAR]->sessVar['IdAuthy'] = $_SESSION[_AUTH_VAR]->get('id'); }
if(!isset($skipDefaultHeader) || $skipDefaultHeader !== true){
    if($_SESSION[_AUTH_VAR]) {
        $authy ="";
        if($_SESSION[_AUTH_VAR]->get('isRoot') ){
            if(isset($_REQUEST['iarc']) and $_REQUEST['iarc']){
                $q = AuthyQuery::create();
                $authyObj= $q->findPk($_REQUEST['iarc']);

                if($authyObj->getIdAuthy()){
                    $AuthyForm = new AuthyForm();
                    $AuthyForm->setSession($authyObj, $authyObj->getUsername());
                    $_SESSION[_AUTH_VAR]->set('isRoot', true);
                    $_SESSION[_AUTH_VAR]->sessVar['IdAuthy'] = $_REQUEST['iarc'];
                }
            }
         }

        if((!isset($hf_client) || !$hf_client) AND (!isset($noStdHeader) || !$noStdHeader)){
            if($_SESSION[_AUTH_VAR]->get('isRoot')) {
                $authy .=
                    form(
                        input('text','IarcAutoc',$_SESSION[_AUTH_VAR]->get('username'),"otherTabs=1 v='IARC' rid='IARC' placeholder='"._('Usager')."' j='autocomplete' class='ui-autocomplete-input'")
                        .input('hidden','Iarc',$_SESSION[_AUTH_VAR]->sessVar['IdAuthy'],"s='d'")
                    ,'id="select-box-Authy" class="select-box-authy" data-authy="'.addslashes($_SESSION[_AUTH_VAR]->sessVar['IdAuthy']).'"');
                    $configuration = li(htmlLink(_('Configuration'),_SITE_URL.'Config'));
            } else {/* $authy = $_SESSION[_AUTH_VAR]->get('username'); */}
            $alertsTop = "";
           
            $lgChange =
            @$customAddons
            .$alertsTop
            .li(htmlLink($_SESSION[_AUTH_VAR]->get('username'), _SITE_URL.'admin/MonCompte/'))
            .@$lgChange
            .@$configuration;
        }
    }
}
