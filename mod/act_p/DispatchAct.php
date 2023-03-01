<?php

###############################
#	Progexpert
###############################

$fromQuery = true;
$request = $_REQUEST;
include_once '../../inc/init.php';
if($request['filter']) {
    $filter = is_array($request['filter']) ? $request['filter'] : json_decode($request['filter'],true);
    unset($request['filter'],$request['ot']);
    $request = array_merge($request,$filter);
}

include _INSTALL_PATH.'mod/template_func.php';

//CONVERSION D'UN FORMULAIRE SERIALIZE EN ARRAY
if($request['sw_form']) {
    parse_str($request['sw_form'],$form);
    unset($request['sw_form']);
}

//DÉTECTION DU PATH
$isAdmin = filter_var($request['sw_admin'], FILTER_VALIDATE_BOOLEAN) == true ? '' : '_p';
$actPath = $request['path'] ? $request['path'] : $request['p'];
unset($request['path'],$request['sw_admin']);
if(!$actPath) { die(); }

if(is_file(_INSTALL_PATH.'mod/act'.$isAdmin.'/'.camelize($actPath,true).'Act.php')){
    include _INSTALL_PATH.'mod/act'.$isAdmin.'/'.camelize($actPath,true).'Act.php';
}elseif(is_file(_INSTALL_PATH.'mod/act'.$isAdmin.'/include.php')){
    include _INSTALL_PATH.'mod/act'.$isAdmin.'/include.php';
}

//INCLUSION DES MODULES
if($request['module']){
    foreach($request['module'] as $module => $transition) {
        //INCLUDE DES MODULES AVEC CLASSES
        if(isset($ModuleClasse[$module]) and $ModuleClasse[$module]!=""){
            $Object = $ModuleClasse[$module]['object'];
            $parameterObject = array('transition' => $transition,'fromQuery' => $fromQuery);
            if($ModuleClasse[$module]['parameter']) { $parameterObject['parameter'] = $$ModuleClasse[$module]['parameter']; }
            $buildObject = 'build'.$module;
            $$Object->$buildObject($parameterObject);
            $getObject = 'get'.$module;
            $section[$module] = $$Object->$getObject();
        }else if($fileInclude){
            //INCLUDES AVEC MODULES AVEC FICHIERS
            include $fileInclude.$module.'.php';
        }
    }
}
if(isset($bodyClass)) { $return['bodyClass'] = $bodyClass; }
if($section) { $return['section'] = $section; }
$return['module'] = $return['module'] ? $return['module'] : [];
if($request['module']) { $return['module'] = array_merge($return['module'],$request['module']); }
unset($request['module'],$request['form']);
$return['filter'] = array_filter($request);

//Menu de l'admin
if($_SESSION[_AUTH_VAR]->get('group') == 'Admin' AND count($swMenu) > 0) {
    $return['admin_menu'] = [];

    foreach($swMenu as $key => $menu) {
        if(!is_int($key)) {
            $return['admin_menu']['checkbox'] .=
            li(
                input('checkbox',$key,'',$menu[3].' class="'.$menu[2].'" autocomplete="off" '.$menu[1])
                .label($menu[0],'for="'.$key.'"')
            ,'class="sw-input" data-key="'.$key.'"');
        }
        else {
            $return['admin_menu']['list'] .= li(href($menu[0],$menu[1],'class="no-nav custom-menu '.$menu[2].'" '.$menu[3]),'data-key="'.$key.'"');
        }
    }
}

//SCRIPT JAVASCRIPT A INCLUDE
if($return['script']) { $return['script'] = array_unique($return['script']); }
$return['onReadyJs'] .=  @$_SESSION[_AUTH_VAR]->MemCache;
echo json_encode($return);
die();
