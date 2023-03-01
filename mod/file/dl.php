<?php
include '../../inc/init.php';


/*sécurité*/
if($_SESSION[_AUTH_VAR]->get('connected') != 'YES'){
	die();
}

if(empty($_GET['id']) || empty($_GET['e'])){
	die();
}
$e= urldecode($_GET['e']);
$id = urldecode($_GET['id']);

$query = $e."Query";
$pc = $query::create()->findPk($id) ;

$f = ($_GET['f'])?urldecode($_GET['f']):_BASE_UPLOAD_PATH.$pc->getFichier();
$name = ($_GET['name'])?str_replace(' ','',urldecode($_GET['name'])):$pc->getName();

switch(strrchr(basename($f), ".")) {
	case ".gz": $type = "application/x-gzip"; break;
	case ".tgz": $type = "application/x-gzip"; break;
	case ".zip": $type = "application/zip"; break;
	case ".pdf": $type = "application/pdf"; break;
	case ".png": $type = "image/png"; break;
	case ".gif": $type = "image/gif"; break;
	case ".jpg": $type = "image/jpeg"; break;
	case ".txt": $type = "text/plain"; break;
	case ".htm": $type = "text/html"; break;
	case ".html": $type = "text/html"; break;
	default: $type = "application/octet-stream"; break;
}


//header("Content-Length: ".filesize($f));
header("Content-disposition: attachment; filename=".$name."");
header("Content-Type: application/force-download");
header("Content-Transfer-Encoding: $type\n"); // Surtout ne pas enlever le \n
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
header("Expires: 0");

echo file_get_contents(_BASE_DIR.$pc->getFichier());



