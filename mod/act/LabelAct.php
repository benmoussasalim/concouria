<?php


#@0.1@#########################
#	ProgXform version 0.5
#	Propel version 1.6
#	Prgxpert, Frederic Vezina 2011
#	build_time: 2013-07-05 13:33:48
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
	
	
	
	include 'LabelActBase.php';
	
	include 'actOuput.php';
	
	function beforeList(&$obj, &$data, &$search, &$pcol){
		/*	CcToList, CcToListTop, CcToListBottom
		$obj->CcToListJs 
		*/
		/* */
		if($_SESSION[_AUTH_VAR]->get('group') === 'Admin'){
			$obj->CcToListJs  = "
				$('#Etat').append('<option value=\'\' selected=\'\'>"._MESS_SELECTION."</option>'); 
				$('#Etat').val('".$search['ms']['Etat']."'); 
			";
		}
		
		
	}
	function beforeForm(&$obj, &$data, &$output, &$dataset){
		/*	CcToFormRoBottom, CcToFormRoTop, CcToChildTableRoTop, CcToFormTop, CcToFormBottom, CcToFormJs, CcTo[childTableName]ListTop, CcTo[childTableName]ListBottom
		$obj->CcToChildTableRoBottom
		*/
		
		$obj->CcToFormJs="
			$('#printLabel').hide();
			$('#Reference').attr('readonly','readonly');
			$('#Label').attr('readonly','readonly');
			$script
		
		";
		
	}