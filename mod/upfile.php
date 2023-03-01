<?php
include '../inc/init.php';		

$css = loadCss(_SRC_URL.'jui/aristo/css/jquery-ui-1.8.17.custom.css').
		loadCss(_SITE_URL.'css/default.css').
		loadCss(_SITE_URL.'css/tablesorter/style.css').
		loadCss(_SITE_URL.'css/auth.css');

		
if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
	exit(0);
}else{								
	$poids= round($_FILES["Filedata"]["size"] / 1024, 2);				
	$tab_style = getimagesize($_FILES['Filedata']['tmp_name']);	
	
	$path_info = pathinfo($_FILES['Filedata']['name']);
	
	$path_info["extension"] =strtolower($path_info["extension"]);
	if(
		($path_info["extension"] == 'rar' 
		or $path_info["extension"] == 'png' 
		or $path_info["extension"] == 'doc' 
		or $path_info["extension"] == 'docx' 
		or $path_info["extension"] == 'pdf' 
		or $path_info["extension"] == 'gif' 
		or $path_info["extension"] == 'jpg' 
		or $path_info["extension"] == 'xls'
		or $path_info["extension"] == 'xlsx'

		)
		AND isset($_GET['id_user'])
		AND isset($_GET['id'])
		AND isset($_GET['entite'])
	){
	
		
		if($_GET['entite'] != ""){	
			unset($data);
			$data['IdCreation'] = $_GET['id_user'];
			$data['DateCreation'] = date('Y-m-d H:i:s');
			$data['IdModification'] = $_GET['id_user'];
			$data['DateModification'] = date('Y-m-d H:i:s');
			$data['Name'] = $_FILES['Filedata']['name'];
			$data['Size'] = $poids;
			$data['Height'] =$tab_style[1];
			$data['Width'] = $tab_style[0];
			$data['IdEnfant'] = $_GET['id'];
			$data['Entite'] = $_GET['entite'];
			$data['Ext'] = $path_info["extension"];
			$e = new FichierSwf();
			if($_GET['blob']){
				/* si on le mets dans la db dans un champs blob */
				
				$data['Blob'] = file_get_contents($_FILES['Filedata']['tmp_name']);
				$e->fromArray($data);
				$e->save();

			}else{
				/* si on garde les fichiers*/
				if(!is_dir(_INSTALL_PATH."mod/file/")){
					mkdir(_INSTALL_PATH."mod/file/");
					$fp = fopen(_INSTALL_PATH."mod/file/index.php","w"); 
					fwrite($fp, '<?php header(\'Location:'._SITE_URL.'\'); ');
					fclose($fp);
				}
				if(!is_dir(_INSTALL_PATH."mod/file/".$_GET['entite']."")){
					mkdir(_INSTALL_PATH."mod/file/".$_GET['entite']."");
					$fp = fopen(_INSTALL_PATH."mod/file/".$_GET['entite']."/index.php","w"); 
					fwrite($fp, '<?php header(\'Location:'._SITE_URL.'\'); ');
					fclose($fp); 
				}
				
				$e->fromArray($data);
				$e->save();
				$data['idPk'] = $e->getPrimaryKey();
				move_uploaded_file($_FILES['Filedata']['tmp_name'], _INSTALL_PATH.'mod/file/'.$_GET['entite'].'/'.md5($data['idPk']).".".$path_info["extension"]."");
			}	
		}
	}
}


?>