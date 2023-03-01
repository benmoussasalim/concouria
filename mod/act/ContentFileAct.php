<?php


#@0.1@#########################
#	ProgXform version 0.861
#	Propel version 1.6
#	Prgxpert, Frederic Vezina 2011
#	build_time: 2014-08-26 12:06:21
###############################
    
    if($request['ot'] != 's')
        $request = $_REQUEST;
    
    
    if(_BASE_DIR != '_BASE_DIR'){
        include 'inc/init.php';	
    }else{
        include '../../inc/init.php';	
    }
    
    switch($request['a']) {
        case 'update-list':

            if(isset($_SESSION[_AUTH_VAR]) && $_SESSION[_AUTH_VAR]->get('isConnected') == 'YES'){
                
                ContentFileQuery::create()->filterByIdContentFile($request['p'])->update(array('InList' => ($request['type'] == 'add' ? 0 : 1)));

            }

            die();
        break;
    }
    
    #@custom##############
    #		reset $request['a'] after new case

    
    $printJs = loadJs(_SRC_URL."js/jquery/jquery-1.7.1.min.js");
    $printCss = loadCss(_SITE_URL."css/print.css");
    
    include 'ContentRelatedAct.php';
    include 'ContentFileActBase.php';
        
    if(file_exists(_BASE_DIR.'mod/act/actOuput.php'))
        include _BASE_DIR.'mod/act/actOuput.php';
        