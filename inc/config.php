<?php

###############################
#	Progexpert
###############################
ini_set("display_errors", true);
ini_set("error_reporting",E_ERROR | E_COMPILE_ERROR | E_PARSE);
define("_DATA_SRC", "Concouria");
define("_PROJECT_NAME", "Concouria");
define("_PROJECT_PRFX", "");
define('_DTC_USER','');
define("_CUR_ROOT", "/");
define("_ENTREPRISE_ID", "1");
define("_DATAB","Concouria");
define("_SRC_URL_DATE", "//".$_SERVER['SERVER_NAME']."/");
define("_SITE_URL", "//".$_SERVER['SERVER_NAME']."/");
define("_SITE_URL_HTTP", "https://".$_SERVER['SERVER_NAME']."/");
define("_SITE_URL_NO_S", "//".$_SERVER['SERVER_NAME']."/");
define("_SITE_URL_ADM", "//".$_SERVER['SERVER_NAME']."/");
define("_SRC_URL_TINY", "//cdn.progexpert.com/");
define("_PATH_PROJECT", "/");
/*
define("_SITE_URL", "//".$_SERVER['SERVER_NAME']."/");
define("_SITE_URL_HTTP", "https://".$_SERVER['SERVER_NAME']."/");
define("_SITE_URL_NO_S", "//".$_SERVER['SERVER_NAME']."/");
define("_SITE_URL_ADM", "//".$_SERVER['SERVER_NAME']."/");
*/
define("_INSTALL_PATH", $_SERVER['DOCUMENT_ROOT']."/");
define("_BASE_DIR", __DIR__."/../");
define("_BASE_UPLOAD_PATH", $_SERVER['DOCUMENT_ROOT']."/concouria/css/user/");
define("_REL_UPLOAD_PATH", "/concouria/css/user/");
define("_DOMAINEPROJECT", $_SERVER['HTTP_HOST']);
define("_PROPEL_BASE_PATH", "propel/");
define("_PROPEL_GEN", _PROPEL_BASE_PATH."generator/bin/propel-gen");
define("_PROPEL_RUNTIME_PATH","propel/");
define("_SITE_UPLOAD_PATH", _SITE_URL."css/user/");
define("_SITE_UPLOAD_PATH_ADM", _SITE_URL_ADM."css/user/");
setlocale(LC_MONETARY, 'en_US.UTF-8');
setlocale(LC_NUMERIC, 'en_US.UTF-8');
setlocale(LC_TIME, 'fr_CA.UTF-8');
define("_FCM","https://fcm.googleapis.com/fcm/send");
define("_SRC_URL","//cdn.progexpert.com/");
define("TB_AUTH",_PROJECT_PRFX."authy");
define("TB_AUTH_LOG",_PROJECT_PRFX."authy_log");
define("_AUTH_VAR",'1090cd9effa6ec362504f56211a4d1e7');
define("_CRYPT_KEY",'ef4b60acf6360dca');
define("_CRYPT_IV",'7877ef63cf7ae731');
define("_CRYPT_METHOD", 'aes-256-cbc');


define("_MEM_CACHE_PORT", '11211');
