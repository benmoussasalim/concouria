<?php


#@0.1@#########################
#	ProgXform version 0.865
#	Propel version 1.6
#	Prgxpert, Frederic Vezina 2011
#	build_time: 2014-11-06 14:51:31
###############################
    
    if($request['ot'] != 's')
        $request = $_REQUEST;
    
    
    if(_BASE_DIR != '_BASE_DIR'){
        include 'inc/init.php';	
    }else{
        include '../../inc/init.php';	
    }
    
    
    
    #@custom##############
    #		reset $request['a'] after new case

    
    $printJs = loadJs(_SRC_URL."js/jquery/jquery-1.7.1.min.js");
    $printCss = loadCss(_SITE_URL."css/print.css");
    
    
    include 'ConfigActBase.php';
        
    if(file_exists(_BASE_DIR.'mod/act/actOuput.php'))
        include _BASE_DIR.'mod/act/actOuput.php';

	
	/**
     * @param class $obj This object, accessibles variables (uiTabsId, ajaxPageActParent,ajaxPageAct,search,arrayData,ListActionRow, CcEvalToList,CcToListTop,CcToListBottom)
     * @param array $data $_REQUEST vraiable
     * @param array $search Search variable as array
     * @param void $pcol
     * @return void
    */
    function beforeList(&$obj, &$data, &$search, &$pcol){

        $button = div(button(_("Générer le fichier js"), 'type="button" class="ac-button ac-light-blue create-js"'), '', 'class="dPrintLink"');

        $obj->CcToListJs ="
            $('.ac-list-form-header.ac-static .ac-left-action-buttons').after('".addslashes($button)."');
            $('.create-js').click(function() {
                $.post('"._SITE_URL."mod/act/SaleAct.php',
                    {'a':'createJs'},
                    function(data){}
                );
            });
        ";
    }