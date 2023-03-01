<?php

###############################
#	Progexpert
###############################    
if(!isset($request['ot']) || $request['ot'] != 's'){$request = $_REQUEST;}
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$ClasseFileName= basename($path);
$path_info = pathinfo($ClasseFileName);
if(@$path_info['extension'] != 'php' and $menu_choice ){
    $ClasseFileName =$menu_choice."Act.php";
}else if($path_info['extension'] != 'php'){ 
    $ClasseFileName =$request['p']."Act.php";
}

if(file_exists($ClasseFileName)){ 
    include_once($ClasseFileName); 
}else{
    if(!defined('_BASE_DIR')){include_once '../../inc/init.php';}
    $ClasseName =str_replace('Act.php','',$ClasseFileName);
    if($ClasseName=='Authy' and @$_REQUEST['a'] =='auth' ){
        /*login*/
    }else if(!$_SESSION[_AUTH_VAR]->isConnected()){security_redirect(true);}     
    $ClasseName =str_replace('Act.php','',$ClasseFileName);
    if(file_exists(_INSTALL_PATH.'mod/gen/'.$ClasseName.'ActBase.php')){
        include _INSTALL_PATH.'mod/gen/'.$ClasseName.'ActBase.php';
    }
    if(file_exists(_BASE_DIR.'mod/act/actOuput.php')){
        include _BASE_DIR.'mod/act/actOuput.php';
    }
}
