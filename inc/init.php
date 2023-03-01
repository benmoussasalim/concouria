<?php

###############################
#	Progexpert
###############################

ini_set('default_charset', 'utf-8');
require_once __dir__.'/config.php';

set_include_path( __dir__ ."/".PATH_SEPARATOR.get_include_path());
set_include_path( __dir__ ."/../mod/".PATH_SEPARATOR.get_include_path());
set_include_path( __dir__ ."/../mod/gen/".PATH_SEPARATOR.get_include_path());
if(defined('_PEAR_LOG_PATH')){set_include_path( _PEAR_LOG_PATH."/".PATH_SEPARATOR.get_include_path());}


require_once _PROPEL_RUNTIME_PATH.'Propel.php';
Propel::init(__dir__."/gen-conf.php");

if($_SERVER['HTTP_HOST']=='lebuilder.com'){ session_name(_AUTH_VAR);};
session_start();

if(file_exists( __dir__ ."/../mod/vendor/autoload.php")){ require_once __dir__ ."/../mod/vendor/autoload.php"; }
/*
if (class_exists('Tracy\Debugger')) {
    $debug = Tracy\Debugger::PRODUCTION;
    $logDir = __dir__."/../app/Log";

    if(!is_dir($logDir)){ mkdir($logDir); }
    if(strpos($_SERVER['REMOTE_ADDR'] ?? php_uname('n'), "192.168.5.") !== false){ $debug = Tracy\Debugger::DEVELOPMENT; }
    if(strpos($_SERVER['REMOTE_ADDR'] ?? php_uname('n'), "24.37.3.22") !== false){ $debug = Tracy\Debugger::DEVELOPMENT; }

    Tracy\Debugger::$strictMode = FALSE;
    Tracy\Debugger::$logSeverity = E_ERROR;
    Tracy\Debugger::enable($debug, $logDir);



    if (class_exists('Zarganwar\PerformancePanel\Panel') && $debug == Tracy\Debugger::DEVELOPMENT) {
        Tracy\Debugger::getBar()->addPanel(new Zarganwar\PerformancePanel\Panel());
    }
}*/

require_once _INSTALL_PATH.'inc/std_function.php';
require_once _INSTALL_PATH.'inc/std.inc.php';
##RESET Droit
unset($_SESSION['CurrentParent']);
unset($_SESSION['CurrentRights']);

if(file_exists(__dir__ .'/../app/component/')){
    if ($handle = opendir(__dir__ .'/../app/component/')) {
         while (false !== ($filename = readdir($handle))) {
            if (substr($filename, strrpos($filename, '.')) == '.php'){
                include_once(__dir__.'/../app/component/'.$filename);
            }
        }
    }
}
if(file_exists(__dir__ .'/../mod/inc/')){
    if ($handle = opendir(__dir__ .'/../mod/inc/')) {
         while (false !== ($filename = readdir($handle))) {
            if (substr($filename, strrpos($filename, '.')) == '.php'){
                include_once(__dir__.'/../mod/inc/'.$filename);
            }
        }
    }
}
require_once 'header.include.php';
