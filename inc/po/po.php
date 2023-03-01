<?php

/*if($request['ot'] != 's')
	$request = $_REQUEST;*/

//include '../inc/init.php';

switch($request['a']){
	case 'rescan':
		checkDest();
		if (is_dir(_BASE_DIR)) {
                   //echo "find "._BASE_DIR." -iname \"*.php\" | xargs /opt/xgettext --from-code=UTF-8 -L PHP -j -p "._BASE_DIR."mod/locale/en_US/LC_MESSAGES";
				   //die();
				   //die();
				   /*
				   find "._BASE_DIR." -iname "*.php" | xargs /opt/xgettext --from-code=UTF-8 -L PHP -j -p "._BASE_DIR."mod/locale/en_US/LC_MESSAGES/
				   */
	exec("find "._BASE_DIR." -iname \"*.php\" | xargs /opt/xgettext --from-code=UTF-8 -L PHP -j -p "._BASE_DIR."mod/locale/en_US/LC_MESSAGES",$retour,$output);
			copy(_BASE_DIR.'mod/locale/en_US/LC_MESSAGES/messages.po',_BASE_DIR.'mod/locale/fr_CA/LC_MESSAGES/messages.po');
			//scanFolder(_BASE_DIR, _BASE_DIR);
			//copy(_BASE_DIR.'mod/locale/en_US/LC_MESSAGES/messages.po',_BASE_DIR.'mod/locale/fr_CA/LC_MESSAGES/messages.po');
		}
	break;//   find /home/relaisxtreme/public_html/inc/../ -iname "*.php" | xargs /opt/xgettext --from-code=UTF-8 -L PHP -j -p /home/relaisxtreme/public_html/inc/../mod/locale/en_US/LC_MESSAGES/
	case 'mo_fr':
		//exec("msgfmt -o "._BASE_DIR."mod/locale/en_US/LC_MESSAGES/messages.mo -v "._BASE_DIR."mod/locale/en_US/LC_MESSAGES/messages.po");
		//exec("msgfmt -o "._BASE_DIR."mod/locale/fr_CA/LC_MESSAGES/messages.mo -v "._BASE_DIR."mod/locale/fr_CA/LC_MESSAGES/messages.po");
	break;
}

function checkDest(){
	if(!file_exists(_BASE_DIR."mod/locale"))
		mkdir(_BASE_DIR."mod/locale");
	if(!file_exists(_BASE_DIR."mod/locale/en_US")){
		mkdir(_BASE_DIR."mod/locale/en_US");
	}
	if(!file_exists(_BASE_DIR."mod/locale/en_US/LC_MESSAGES")){
		mkdir(_BASE_DIR."mod/locale/en_US/LC_MESSAGES");
	}
	if(file_exists(_BASE_DIR.'mod/locale/en_US/LC_MESSAGES/messages.po'))
		unlink(_BASE_DIR.'mod/locale/en_US/LC_MESSAGES/messages.po');
	touch(_BASE_DIR."mod/locale/en_US/LC_MESSAGES/messages.po");

	if(!file_exists(_BASE_DIR."mod/locale/fr_CA")){
		mkdir(_BASE_DIR."mod/locale/fr_CA");
	}
	if(!file_exists(_BASE_DIR."mod/locale/fr_CA/LC_MESSAGES")){
		mkdir(_BASE_DIR."mod/locale/fr_CA/LC_MESSAGES");
	}
	touch(_BASE_DIR."mod/locale/fr_CA/LC_MESSAGES/messages.po");

}

function scanFolder($dir, $baseDir){
	if ($dh = opendir($dir)){
		//echo $dir."<br>";
		while (($file = readdir($dh)) !== false){
			//&& false === array_search($file, $excluded_files) && false === array_search($dir, $excluded_dirs)
			if (!is_dir($dir ."/". $file) && is_file($dir ."/". $file) && $file != "." && $file != ".."){
				$ext=substr($file,-3,3);
				if ($ext=="php"){
					//echo $dir ."/".$file."<br>";
					if( $dir==$baseDir.'/mod/page' or  $dir==$baseDir.'/mod/act_p'){
						////echo $baseDir."mod/locale/en_US/LC_MESSAGES/ ".$dir ."/".$file."<br>";
						//echo ."<br>";
						//echo "xgettext --from-code=UTF-8 -L PHP -j -p ".$baseDir."mod/locale/en_US/LC_MESSAGES/ ".$dir ."".$file."<br>";
						exec( "xgettext --from-code=UTF-8 -L PHP -j -p ".$baseDir."mod/locale/en_US/LC_MESSAGES ".str_replace("//","/",$dir."/".$file),$outPut);
						//print_r($outPut);
					}
				}
			}elseif(is_dir($dir ."/". $file) && $file != "." && $file != ".."){
				if( $dir != $baseDir.'/mod/import'
						and $dir != $baseDir.'/mod/locale'
						and $dir != $baseDir.'/mod/tmp'
						and $dir != $baseDir.'/mod/file'
						and $dir != $baseDir.'/mod/upload'
						and $dir != $baseDir.'/inc/sendmail'
						and $dir != $baseDir.'/inc/po'
						and $dir != $baseDir.'/inc/gen'
						and $dir != $baseDir.'/inc/act'
						and $dir != $baseDir.'/js'
						//and $dir != $baseDir.'/gen'
					)
				{
					scanFolder($dir ."/". $file, $baseDir);
				}
			}
		}
	}
}