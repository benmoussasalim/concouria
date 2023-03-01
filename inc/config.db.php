<?php

###############################
#	Progexpert
###############################
if(!file_exists(_INSTALL_PATH."inc/config.db.tmp.php")){
    $outputFile = "<?php".PHP_EOL;
    $Configs = ConfigQuery::create()->find();
    if(isset($_SESSION[_AUTH_VAR]->config)){ unset($_SESSION[_AUTH_VAR]->config);}
    foreach($Configs as $Config){
        if(method_exists($Config,'getStatut') === false OR (method_exists($Config,'getStatut') === true and $Config->getStatut()=='Actif')){
            if(!empty($Config->getDescription())){ $outputFile .= "/*".$Config->getDescription()."*/".PHP_EOL; }
            if(!empty($Config->getConfig())){
                if(is_numeric($Config->getValue()) || mb_strtolower($Config->getValue()) == "false" || mb_strtolower($Config->getValue())== "true") {
                    $outputFile .= "define(\"".$Config->getConfig()."\", ".str_replace('"','\"',$Config->getValue()).");".PHP_EOL;
                } else {
                    $outputFile .= "define(\"".$Config->getConfig()."\", \"".str_replace('"','\"',$Config->getValue())."\");".PHP_EOL;
                }
            }
        }
    }
    file_put_contents(_INSTALL_PATH."inc/config.db.tmp.php", $outputFile);
    include(_INSTALL_PATH."inc/config.db.tmp.php");
} else {
    include(_INSTALL_PATH."inc/config.db.tmp.php");
}
