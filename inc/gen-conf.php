<?php
// This file generated by Propel 1.7.2-dev convert-conf target
// from XML runtime conf file /var/www/html/p/Concouria/runtime-conf.xml
$conf = array (
  'datasources' => 
  array (
    'Concouria' => 
    array (
      'adapter' => 'mysql',
      'connection' => 
      array (
        'dsn' => 'mysql:host=localhost;dbname=concouria;',
        'user' => 'root',
        'password' => 'concouria',
      ),
    ),
    'default' => 'concouria',
  ),
  'generator_version' => '',
);
$conf['classmap'] = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classmap-gen-conf.php');
return $conf;