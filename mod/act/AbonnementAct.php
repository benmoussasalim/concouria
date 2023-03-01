<?php


#@0.1@#########################
#	Progexpert
###############################

    if($request['ot'] != 's')
        $request = $_REQUEST;


    if(_BASE_DIR != '_BASE_DIR'){
        include 'inc/init.php';
    }else{
        include '../../inc/init.php';
    }


    if(!$_SESSION[_AUTH_VAR]->isConnected()){
        security_redirect(true);
    }

    #@custom##############
    #		reset $request['a'] after new case


    $printJs = loadJs(_SRC_URL."js/jquery/jquery-1.7.1.min.js");
    $printCss = loadCss(_SITE_URL."css/print.css");

    include 'SaleRelatedAct.php';
    include 'AbonnementActBase.php';

	function beforeForm(&$obj, &$data, &$output, &$dataset){
        if (empty($dataset['Status']))
            $dataset['Status'] = "Brouillon";

		if(isset($data["i"])) {
			$url = href("Voir la facture",_SITE_URL.'invoice?cmd='.md5($data["i"]."CONCOURIA"),'target="_blank" class=" ac-button ac-light-red"').' ';
		}


        $obj->CcPrintLinkDiv.= $url;

    }

    if(file_exists(_BASE_DIR.'mod/act/actOuput.php'))
        include _BASE_DIR.'mod/act/actOuput.php';
