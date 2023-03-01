<?php

###############################
#	Progexpert
###############################
if(is_file("/opt/Browser.php")){include_once("/opt/Browser.php");}

function slugify($string){
    $table = array(
            'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
            'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', '/' => '-', ' ' => '-', '(' => '', ')' => ''
    );
    $string =html_entity_decode($string);
    
    // -- Remove duplicated spaces
    $stripped = preg_replace(array('/\s{2,}/', '/[
]/'), ' ', $string);
    // -- Returns the slug
    return strtolower(strtr($string, $table));
}

/*
    exemple 1
        $arrayd =array(1,2);
        feach($arrayd,function($arr,$args){
            echo $arr."<br>";
        },$args);
    exemple 2
    $args= array($MoveIdModuleDonnees);
    feach($ModuleDonneesValeurs,function($ModuleDonneesValeur,$args){
        $ModuleDonneesValeurCopy = $ModuleDonneesValeur->copy(false);
        $ModuleDonneesValeurCopy->setIdModuleDonnees($args[0]);
        $ModuleDonneesValeurCopy->save();
        $ModuleDonneesValeur->delete();
    },$args);
*/
function feach(&$arrs,$func,$args=array()){if(count($arrs)>0){foreach($arrs as $arr){if(is_callable($func)){$func($arr,$args);}}}}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function mail_log_form($to, $subject, $multipartEmail, $additional_headers,$add_header){
    if(class_exists('MailLogForm')){
        $e = new MailLogForm();
        $data_log['IdCreation'] = $_SESSION[_AUTH_VAR]->get('id');
        $data_log['DateCreation'] = time();
        $data_log['To'] = $to;
        $data_log['Sujet'] = $subject;
        $data_log['Header'] = $additional_headers;
        $data_log['AddHeader'] = $add_header;
        $data_log['Description'] = $multipartEmail;
        $e->fromArray($data_log);
        $e->save(); 
    }
}

function redirection_form(){
    if(class_exists('RedirectionForm')){
        $redirs = RedirectionQuery::create()->filterByStatus('Actif')->find();
        if($redirs){
            foreach($redirs as $redir){
                $message = '';
                $type = '';
                if($redir->getOldLink() != '' && $redir->getNewLink() != ''){
                    if($redir->getType() == '301 permanente'){
                        $message = 'Status: 301 Moved Permanetnly';
                        $type = 301;
                    } else if($redir->getType() == '307 temporaire'){
                        $message = 'Status: 307 Temporary Redirect';
                        $type = 307;
                    }
                    if($_SERVER['REQUEST_URI'] == str_replace(_SITE_URL_HTTP,'/',str_replace('www.','',$redir->getOldLink()))
                      ||   $_SERVER['REQUEST_URI'] == str_replace(_SITE_URL_HTTP,'/',$redir->getOldLink())
                    ){
                        header($message, false, $type);
                        header('Location: '.$redir->getNewLink());      
                        exit();
                    }
                }
            }
        }
    }
}

function automat_connect($reload=false){
    if(@$_COOKIE[_PROJECT_NAME.'_authy']){
       $login = json_decode(en_de('decrypt',$_COOKIE[_PROJECT_NAME.'_authy']));
       if( class_exists ('AuthyForm')){
            $e = new AuthyForm();
            if($_SESSION[_AUTH_VAR]->get('isConnected') == 'NO'){
                $e->tryLog($login[0], $login[1]);
                
                if($_SESSION[_AUTH_VAR]->get('isConnected') != 'NO' and $reload){
                    die(
                        docType()
                        .htmlTag(
                            htmlHeader($request['p']."-".$request['a'], $css.$uiCss.loadCss(_SITE_URL.'mod/page/template_css.css'), _SITE_DESCRIPTION, _SITE_KEYWORDS, $headJs)
                            .div(_("Connexion automatique encours ! Vous allez être redirige."))
                            .script("setTimeout(function (){ document.location.reload(); }, 1000);")
                        )
                    );
                }
                if($_COOKIE[_PROJECT_NAME."_lang"]){ $_SESSION[_AUTH_VAR]->lang =$_COOKIE[_PROJECT_NAME."_lang"];}
                if( class_exists ('AuthyLogForm')){
                    $e = new AuthyLogForm();
                    $data_log['IdAuthy'] = $_SESSION[_AUTH_VAR]->get('id');
                    $data_log['Ip'] = $_SERVER['REMOTE_ADDR'];
                    $data_log['Timestamp'] = time();
                    $data_log['Login'] = $login[0];
                    $data_log['Type'] = 'Auto-Connect';
                    $e->fromArray($data_log);
                    $e->save(); 
                }
            }
        }
    }
}

function security_redirect($redirect=true,$class='',$right=''){
    if (function_exists(beforeSecurityRedirect)) {beforeSecurityRedirect();}
    $log = true;
    if($log){
        if($class){
            die(
                docType()
                .htmlTag(
                    htmlHeader($request['p']."-".$request['a'], $css.$uiCss.loadCss(_SITE_URL.'mod/page/template_css.css'), _SITE_DESCRIPTION, _SITE_KEYWORDS, $headJs)
                    .div(_("Droit insuffisant pour afficher cette page.").htmlSpace(1)._($class).htmlSpace(1)._("Droit ".$right))
                )
            );
        }else{
            die(
                docType()
                .htmlTag(
                    htmlHeader($request['p']."-".$request['a'], $css.$uiCss.loadCss(_SITE_URL.'mod/page/template_css.css'), _SITE_DESCRIPTION, _SITE_KEYWORDS, $headJs)
                    .div(_("Connexion requise ! Vous allez etre redirige."))
                    .script("setTimeout(function (){ window.location.href = '"._SITE_URL."admin' }, 1000);")
                )
            );
        }
        
    }
}

function en_de($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = _CRYPT_KEY;
    $secret_iv = _CRYPT_IV;
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }return $output;
}

function sm_tri($subTabs){
    $subTabsLi='';
    if($subTabs){
        foreach ($subTabs as $key => $row) {$pos_t[$key]  = $row['1'];$str_t[$key] = $row['0'];}
        array_multisort($pos_t, SORT_NUMERIC,$subTabs);
        foreach ($subTabs as $key => $row) {$subTabsLi .= $row['0'];}
    }return $subTabsLi;
}

function set_var($string,$add_string,$sep,$space=true,$unique=false,$max_var=null,$sens=null){
    $unique_ok = true;
    if($unique){
        if($string){
            foreach(explode($sep,$string) as $val){
                if($add_string == $val){$unique_ok = false;}
            }
        }
    }
    if($unique_ok){
        if(!$sens){
            if($space){
                if($string){
                    $string = $add_string." ".$sep." ".$string;
                }else{
                    $string = " ".$add_string;
                }
            }else{
                if($string){
                    $string = $add_string."".$sep."".$string;
                }else{
                    $string = "".$add_string;
                }
            }
        }else{
            if($space){
                if($string){
                    $string = $string." ".$sep." ".$add_string;
                }else{
                    $string = " ".$add_string;
                }
            }else{
                if($string){
                    $string = $string."".$sep."".$add_string;
                }else{
                    $string = "".$add_string;
                }
            }
        }
    }
    if($max_var){
        $tab = explode($sep,$string);
        if(count($tab)>$max_var)
            array_shift($tab);
        if(count($tab)>$max_var)
            array_shift($tab);
        $string = implode($sep,$tab);
    }
    return $string;
}

function rmv_var($stringIn,$rmv_string,$sep,$space=true){
    $stringOut = "";
    foreach(explode($sep,$stringIn) as $val){
        if($rmv_string != $val){
            if($space){
                if($stringOut){
                    $stringOut .= " ".$sep." ".$val;
                }else{
                    $stringOut = " ".$val;
                }
            }else{
                if($stringOut){
                    $stringOut .= "".$sep."".$val;
                }else{
                    $stringOut = "".$val;
                }
            }
        }
    }return $stringOut;
}

function serializeRights($data, $fieldName){
    require _BASE_DIR."inc/AddOmMap.php";
    $arrRight =array("m","r","w","a","d","b");
    $arrayRights= array();
    foreach($omMap as $c=>$key) { $index[] = $key['index'];	}
    array_multisort($index, SORT_ASC,$omMap ,SORT_NUMERIC);
    $omMapSubMenu=$omMap;$omMapChild=$omMap;
    foreach($omMap as $oMentry){
        if($oMentry['name']){    
            if(count($arrRight)>0){
                foreach($arrRight as $letter){
                    if(!empty($data[$fieldName.'-'.$oMentry['name'].$letter]) and $data[$fieldName.'-'.$oMentry['name'].$letter] == $letter){
                        $arrayRights[$oMentry['name']]=str_replace($letter,'',$arrayRights[$oMentry['name']]);
                        $arrayRights[$oMentry['name']] .= $letter;
                    }
                }
            }
            foreach($omMapSubMenu as $key => $row){ $name[$key]=$row['parent_menu'];$sub_menu[$key]=$row['sub_menu']; }
            array_multisort($name,SORT_ASC,$sub_menu,SORT_ASC,$omMapSubMenu);
            foreach($omMapSubMenu as $oSubMenu){
                if($oSubMenu['parent_menu'] == $oMentry['name'] || (camelize($oSubMenu['parent_table'],true) == $oMentry['name'])){
                    if($oMentry['index'] or $oMentry['action']=="add"){
                        if(!empty($data[$fieldName.'-'.$oSubMenu['name'].'m']) and $data[$fieldName.'-'.$oSubMenu['name'].'m'] == 'm'){
                            $arrayRights[$oSubMenu['name']]=str_replace("m",'',$arrayRights[$oSubMenu['name']]);
                            $arrayRights[$oSubMenu['name']] .= "m";
                        }
                    } 
                    if(count($arrRight)>0){
                        foreach($arrRight as $letter){
                            if(!empty($data[$fieldName.'-'.$oSubMenu['name'].$letter]) and $data[$fieldName.'-'.$oSubMenu['name'].$letter] == $letter){
                                $arrayRights[$oSubMenu['name']]=str_replace($letter,'',$arrayRights[$oSubMenu['name']]);
                                $arrayRights[$oSubMenu['name']] .= $letter;
                            }
                        }
                    }
                    if($oSubMenu['add_select_popup']){
                        $ArrAddSelect= json_decode($oSubMenu['add_select_popup'], true);
                        if(count($ArrAddSelect)){
                            foreach($ArrAddSelect as $key => $select){
                                if($key){
                                    $NameSelect=camelize($oSubMenu['name'],true)."SelectBox".camelize(_($key),true);
                                    if(count($arrRight)>0){
                                        foreach($arrRight as $letter){
                                            if(!empty($data[$fieldName.'-'.$NameSelect.$letter]) and $data[$fieldName.'-'.$NameSelect.$letter] == $letter){
                                                $arrayRights[$NameSelect]=str_replace($letter,'',$arrayRights[$NameSelect]);
                                                $arrayRights[$NameSelect] .= $letter;
                                            }
                                        }
                                    }
                                }
                            }
                        }    
                    }
                    foreach($omMapChild as $childMenu){
                        if(@$childMenu['parent_table'] /*and camelize($childMenu['parent_table'],true) == $oSubMenu['name']*/){
                            $childMenu['parent_table'] = $oSubMenu['name'];
                            $oSubMenuName = camelize($childMenu['parent_table'],true)."".$childMenu['name'];
                            if(count($arrRight)>0){
                                foreach($arrRight as $letter){
                                    if(!empty($data[$fieldName.'-'.$oSubMenuName.$letter]) and $data[$fieldName.'-'.$oSubMenuName.$letter] ==$letter){
                                        $arrayRights[$oSubMenuName]=str_replace($letter,'',$arrayRights[$oSubMenuName]);
                                        $arrayRights[$oSubMenuName] .= $letter;
                                    }
                                }
                            }
                            if($childMenu['add_select_popup']){
                                $ArrAddSelect= json_decode($childMenu['add_select_popup'], true);
                                if(count($ArrAddSelect)){
                                    foreach($ArrAddSelect as $key => $select){
                                        if($key){
                                            $NameSelect=camelize($childMenu['parent_table'],true).camelize($childMenu['name'],true)."SelectBox".camelize(_($key),true);
                                            if(count($arrRight)>0){
                                                foreach($arrRight as $letter){
                                                    if(!empty($data[$fieldName.'-'.$NameSelect.$letter]) and $data[$fieldName.'-'.$NameSelect.$letter] == $letter){
                                                        $arrayRights[$NameSelect]=str_replace($letter,'',$arrayRights[$NameSelect]);
                                                        $arrayRights[$NameSelect] .= $letter;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }    
                            }
                        }
                    }
                }    
            }  
        } 
    }return json_encode($arrayRights);
}

function evaluate_math_clean($val){
    if($val[0]=='.'){$val = '0'.$val;}
    $ok_debut=false;$ok_fin=false;$ok_all=false;
    $i=0;
    if($val)
        while($val[$i] and !$ok_all and $i <=strlen($val)){
            if(!is_numeric($val[strlen($val)-1]) and !$ok_debut){
                $val = substr($val, 0, strlen($val)-1);
            }else{
                $ok_debut =true;
            }
            if(!is_numeric($val[0]) and !$ok_fin){
                $val = substr($val, 1, strlen($val)-1);
            }else{
                $ok_fin =true;
            }
            if($ok_fin and $ok_debut){
                $ok_all=true;
            }
            $i++;
        }
    return $val;
}

function evaluate_math($val,$zero=false,$espace=' '){
    $val =evaluate_math_clean($val);
    if($val){
        try {
            $m = new EvalMath;
            $val = $m->evaluate($val);
        } catch (Exception $exep) {
            $val=0;
        }
    }else{
        $val=0;
    }
    if($val==0 and !$zero){
        $val =0;
    }elseif($val==0){$val ='';}
    return number_format_with_null($val,2,'.',$espace,true);
}

function number_format_with_null($number ,$decimals,$dec_point,$thousands_sep,$accept_null=false){
    if($accept_null and $number == ''){return null;}
    return number_format($number,$decimals,$dec_point,$thousands_sep);
}

function number_format_truncate($number ,$decimals,$dec_point,$thousands_sep,$accept_null=false){
    if($accept_null and $number == ''){return null;}
    $number = str_replace(',','.',$number);
    $tabN = explode('.',$number);
    $number = $tabN[0].".".substr($tabN[1],0,$decimals);
    return number_format($number,$decimals,$dec_point,$thousands_sep);
}

function number_format_return_x($mont,$rem='X'){
    $mont = number_format_with_null($mont,2,'.',' ',false);
    $nombre = array('0','1','2','3','4','5','6','7','8','9');
    $mont = str_replace($nombre,$rem,$mont);
    return str_replace('-','', $mont);
}
/*
    depricate  ne plus utiliser get browser...
    Utiliser : $browser = new Browser();
    Il est deja inclus en haut ; )!
    if(is_file("/opt/Browser.php")){include_once("/opt/Browser.php");}
 */
function getBrowser(){
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
       $platform = 'mac';
    }elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }elseif(preg_match('/Firefox/i',$u_agent)){
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }elseif(preg_match('/Chrome/i',$u_agent)){
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }elseif(preg_match('/Safari/i',$u_agent)){
       $bname = 'Apple Safari';
        $ub = "Safari";
    }elseif(preg_match('/Opera/i',$u_agent)){
        $bname = 'Opera';
        $ub = "Opera";
    }elseif(preg_match('/Netscape/i',$u_agent)){
        $bname = 'Netscape';
        $ub = "Netscape";
    }
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {}
    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }else {
            $version= $matches['version'][1];
        }
    }else{
        $version= $matches['version'][0];
    }

    if ($version==null || $version=="") {$version="?";}
    if (strpos($u_agent, 'Trident/7.0; rv:11.0') !== false) {
        $bname = 'Internet Explorer';
         $ub = "MSIE";
          $version=11;
    }
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

function isntPo($str){if(!is_null($str)){return _($str);}else{ return NULL;}}

function sub_menu_tri($subTabs){
    $subTabsLi='';
    if($subTabs){
        foreach ($subTabs as $key => $row) {$pos_t[$key]  = $row['1'];$str_t[$key] = $row['0'];}
        array_multisort($pos_t, SORT_NUMERIC,$subTabs);
        foreach ($subTabs as $key => $row) {$subTabsLi .= $row['0'];}
    }return $subTabsLi;
}

function string2url($in){
    $in = html_entity_decode($in, ENT_QUOTES, 'UTF-8');
    $in = urldecode($in);
    $in = trim(strip_tags($in));
    $in = preg_replace('/[^a-z\\d]+/i', '-', $in);
    $ret = strtolower(transliterateString($in));
    return $ret;
}

function transliterateString($txt) {
    $transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');
    return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
}

function swData(...$data) { 
    $finalData = [];
    if(count($data)>0){ foreach($data as $dataArray){ $finalData = array_merge($finalData,$dataArray);}}
    return " data-sw='".str_replace('\'','"',json_encode($finalData))."' "; 
}

function swClick(...$data) { 
    $finalData = [];
    if(count($data)>0){ foreach($data as $dataArray){ $finalData = array_merge($finalData,$dataArray);}}
    return " data-click='".str_replace('\'','"',json_encode($finalData))."' "; 
}

function swSubmit(...$data) { 
    $finalData = [];
    if(count($data)>0){ foreach($data as $dataArray){ $finalData = array_merge($finalData,$dataArray);}}
    return " data-submit='".str_replace('\'','"',json_encode($finalData))."' "; 
}

function swChange(...$data) { 
    $finalData = [];
    if(count($data)>0){ foreach($data as $dataArray){ $finalData = array_merge($finalData,$dataArray);}}
    return " data-change='".str_replace('\'','"',json_encode($finalData))."' "; 
}

function swEdit($table,$id = null,$edit = null) {
    if($table === 'img' OR $table === 'bg') { 
        $returnArray['replace'] = $table; 
        $returnArray['hook'] = str_replace('\'','"',$id);
    } else if($id == null OR $id === true) {
        if($id === true) { $returnArray['text'] = 'yes';  }
        $returnArray['column'] = $table;
    }else{ $returnArray = ['table' => $table,'id' => $id,'edit' => addslashes($edit)]; }
    return $returnArray;
}

function swPlus($table,$id = null,$edit = null) {
    $isEdit = false;
    $returnData = '';$parent="";
    $Arpt =explode('.',$table);
    if(count($Arpt)>1){$parent=$Arpt[0];$table=$Arpt[1];}
    if($table === 'img' OR $table === 'bg') { 
        $editArray['replace'] = $table; 
        $editArray['hook'] = str_replace('\'','"',$id);
    } else if($id == null OR $id === true) {
        $isEdit = true;
        if($id === true) { $editArray['text'] = 'yes';  }
        $editArray['column'] = $table;
    }else if($_SESSION[_AUTH_VAR]->hasRights($parent.$table,'w')) {
        if(!$edit) { $edit = $table.' #'.$id; }
        if($parent){
           $editArray = ['pc'=>$parent,'table' => $table,'id' => $id,'edit' => $edit]; 
        }else{
           $editArray = ['table' => $table,'id' => $id,'edit' => $edit];  
        } 
    }
    if(count($editArray)) {
        $returnData = ' '; 
        foreach($editArray as $label => $value) { $returnData .= " data-".$label."='".$value."' "; }
    }
    if($isEdit) { $returnData .= 'contenteditable="false" '; }

    return $returnData; 
}

function returnDefault($message = "Une erreur est survenue.",$error = true,$class = 'default-return') {
    $return['message'] = $message;
    $return['error'] = $error;
    $return['class'] = $class;
    return $return;
}

$pageSlug = [];
function getSlug($slug = '',$filter_lg = null) {
    if($slug != '') {
        global $lang_sql;
        global $pageSlug;

        $filter_lg = $filter_lg ? $filter_lg : $lang_sql;

        if($pageSlug[$slug][$filter_lg]) { return $pageSlug[$slug][$filter_lg]; }
        else {
            $slugObj = 
                ContentQuery::create()
                ->join('ContentI18n')
                ->addJoinCondition("ContentI18n","ContentI18n.Slug = '".$slug."'")
                ->findOne()
            ;

            if(count($slugObj)) {
                $pageSlug[$slug][$filter_lg] = $slugObj->getTranslation($filter_lg)->getSlug();
                return $pageSlug[$slug][$filter_lg];
            } else { return $slug; }
        }
    }
}


function sendHTMLemail($message, $from, $to, $subject,$reply="", $attachment=array(),$bcc=""){
    if (defined('_BY_PASS_MAIL_TO') and filter_var(_BY_PASS_MAIL_TO, FILTER_VALIDATE_EMAIL)){ $to = _BY_PASS_MAIL_TO; }
    if (defined('_BY_PASS_MAIL_FROM') and filter_var(_BY_PASS_MAIL_FROM, FILTER_VALIDATE_EMAIL)){ $from = _BY_PASS_MAIL_FROM; }
    $message =str_replace('%%_SITE_URL_HTTP%%',_SITE_URL_HTTP,$message);

    $Email_boundary = "".md5(uniqid())."";
    $mimeType = "multipart/alternative;";
    $Email_boundaryAlt = "alt-".$Email_boundary;
    $Email_boundaryMain = $Email_boundaryAlt;
    $EmailBoundaryMixedHead ="";
    $eol = "
";

    if(!empty($attachment) and (!empty($attachment['name']) or !empty($attachment[0]['name']))) {
        $mimeType = "multipart/mixed;";
        $Email_boundaryMixed = "mix-".$Email_boundary;
        $Email_boundaryMain = $Email_boundaryMixed;
        $EmailBoundaryMixedHead = "--".$Email_boundaryMixed.$eol."Content-Type: multipart/alternative; boundary=\"".$Email_boundaryAlt."\"".$eol.$eol;
    }

    $additional_headers = 'X-Mailer: PHP/'.phpversion().$eol;
    $additional_headers .= 'MIME-Version: 1.0'.$eol;
    $additional_headers .= "Content-Type: ".$mimeType." boundary=\"".$Email_boundaryMain."\"".$eol;
    if($reply){$additional_headers .= "Reply-To: ".$reply.$eol;}
    if($bcc){$additional_headers .= "Bcc: ".$bcc.$eol;}
    $additional_headers .= "From: ".$from.$eol;
    $additional_headers .= "Errors-To: ".$from.$eol;
    $additional_headers .= "Return-Path: ".$from.$eol;
    $additional_headers .= "List-Unsubscribe: <mailto:".$from.">".$eol;  


    $htmlMessage = docType().startHtml().body($message).closeHtml();

    $multipartEmail =
$EmailBoundaryMixedHead
."--".$Email_boundaryAlt.$eol
.'Content-Type: text/plain; charset="UTF-8"'.$eol
.'Content-Transfer-Encoding: 8bit'.$eol.$eol
.rtrim(strip_tags(preg_replace('~<style[^>]*>[^<]*</style>~','',$htmlMessage))).$eol.$eol
."--".$Email_boundaryAlt."
Content-Type: text/html; charset='UTF-8'
Content-Transfer-Encoding: 8bit".$eol.$eol
.rtrim($htmlMessage).$eol.$eol
."--".$Email_boundaryAlt."--";
    if($attachment) {
        if($attachment['name']){
            $multipartEmail .= $eol."
--".$Email_boundaryMixed."
Content-Type: ".$attachment['mime']."; name=\"".$attachment['name']."\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment".$eol.$eol;
            $multipartEmail .= chunk_split(base64_encode($attachment['data'])).$eol.$eol."--".$Email_boundaryMixed."--";
        }else if($attachment[0]['name']){
            foreach($attachment as $attach){
                $multipartEmail .= $eol."
--".$Email_boundaryMixed."
Content-Type: ".$attach['mime']."; name=\"".$attach['name']."\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"".$attach['name']."\"".$eol.$eol;
                $multipartEmail .= chunk_split(base64_encode($attach['data'])).$eol.$eol."--".$Email_boundaryMixed."--";
            }  
        }
    }
    $add_header = "";if($from){$add_header = "-f ".$from;}
    if(strstr($to, ";")){
        $recipient = explode(";", $to);
        foreach($recipient as $to){
            $return = mail($to, $subject, $multipartEmail, $additional_headers,$add_header);
            mail_log_form($to, $subject, $message, $additional_headers,$add_header);
        }
    }else{
        $return=  mail($to, $subject, $multipartEmail, $additional_headers,$add_header);
        mail_log_form($to, $subject, $message, $additional_headers,$add_header);
    }

    if($return)
        return true;
    else
        return false;
            
}

function templateEmail($content,$color,$title,$logo) {
    $email = 
    style('@import url(https://fonts.googleapis.com/css?family=Roboto:400,700); table a:hover { text-decoration: underline !important; } .table tr td phone-fix-top, .table tr td phone-fix-top a { color: #FFF !important; text-decoration: none !important; } .phone-fix, .phone-fix a { color: #2f2f2f !important; text-decoration: none !important; }')
    .div(
        '<center>
            '.
            div(
                div(
                    table(
                        tbody(
                            tr(
                                td(href(img($logo,null,250,'','Logo'),_SITE_URL_HTTP,'','Logo'),'style="padding: 20px 0 20px 20px; width: 50%; vertical-align: middle;"')
                                .td($title,'style="padding: 20px 20px 20px 0; width: 50%; vertical-align: middle; text-align: right; font-weight: bold; text-transform: uppercase; font-size: 16px; color: #FFF;"')
                            )
                        )
                    ,'bgcolor="'.$color.'" style="width: 100%;"')
                ,'','style="width: 680px; margin: 0 auto; padding: 0 20px;"')
            ,'','style="background: '.$color.'; padding: 0; font-family: \'Roboto\', sans-serif;"')
        
            .div($content,'','style="width: 600px; margin: 50px auto; text-align: left;"')
            .'
        </center>'
    );
    return $email;
}

/* $ccsearch[0]['f'] =champs$ccsearch[0]['vuse'] = table$ccsearch[0]['v'] = valeur$ccsearch[0]['vf'] =or*/
function getSelectFilter($filter,&$q){
    foreach($filter as $ccsearch){
        if($ccsearch['f']){
            if($ccsearch['vf'] =='or')
                $q->_or();
            if($ccsearch['vuse']){
                $useStr = "use".$ccsearch['vuse']."Query";
                $filterStr = "filterBy".$ccsearch['f'];
                $q->leftJoinWith($ccsearch['vuse']);
                $q->$useStr()->$filterStr($ccsearch['v'])->endUse();
            }else{
                $filterStr = "filterBy".$ccsearch['f'];
                $q->$filterStr($ccsearch['v']);
            }
        }
    }
}

function handleOkResponse($msg, $ui='', $print=false,$text_title='Message'){
    $ui = (!empty($ui))?'#'.$ui:'';
    @$error['txt'] .= $msg;
    $error['onReadyJs'] = "
        $('body').css('cursor', 'progress');
        $('input').css('cursor', 'progress');
        setTimeout(function (){ $('body').css('cursor', 'auto'); $('input').css('cursor', 'pointer'); },200);
        sw_message('".addslashes($msg)."',false,'complete-save');
    ";
    return $error;
}

function search_array_multi($arrays, $field, $value){foreach($arrays as $key => $array){if ( intval($array[$field]) === $value ){return $key;}}return false;}
function extractCommonWords($string, $locale){
    /*$stopWords = StopWordQuery::create()->select(array('MotVide'))->filterByLocale($locale)->find();
    $stopWords = $stopWords->toArray();

    $string = html_entity_decode($string, ENT_HTML5, "UTF-8");
    $string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
    $string = trim($string); // trim the string
    $string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
    $string = strtolower($string); // make it lowercase

    preg_match_all('/\b.*?\b/i', $string, $matchWords);
    $matchWords = $matchWords[0];

    foreach ( $matchWords as $key=>$item ) {
        if ( $item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 ) {
            unset($matchWords[$key]);
        }
    }
    $wordCountArr = array();
    if ( is_array($matchWords) ) {
        foreach ( $matchWords as $key => $val ) {
            $val = strtolower($val);
            if ( isset($wordCountArr[$val]) ) {
                $wordCountArr[$val]++;
            } else {
                $wordCountArr[$val] = 1;
            }
        }
    }
    arsort($wordCountArr);
    $wordCountArr = implode(',', array_keys(array_slice($wordCountArr, 0, 10)));


    return $wordCountArr;*/
}
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
function stdForm($content,$NameClasse,$CustomControls="",$DefaultControls=""){
    return 
        div(
            div($DefaultControls,'','class="default-controls"')
            .div($CustomControls,'','class="custom-controls"')
        ,'',' class="sw-header"')
        .form(
            div(
                $content
            ,"divCnt".$NameClasse."s","class='divStdform' CntTabs=1 ")
        ,"id='form".$NameClasse."s' class='mainForm formContent' ");
}
function stdNoForm($content,$NameClasse,$CustomControls="",$DefaultControls=""){
    return 
        div(
            div($DefaultControls,'','class="default-controls"')
            .div($CustomControls,'','class="custom-controls"')
        ,'',' class="sw-header"')
        .div(
            div(
                $content
            ,"divCnt".$NameClasse."s","class='divStdform' CntTabs=1 ")
        ,"form".$NameClasse."s"," class='mainForm formContent' ");
}
// @FORMFIELD
function stdFieldRow($label, $input, $name='', $formUnit='', $comments='', $comments_css='', $addClass='', $options='', $isCheckbox = 'no', $addClassDivtd=''){
    $checkboxLabel = '';
    $hasUnit = '';
    if($formUnit != '') { $hasUnit = 'has-unit'; }
    if($formUnit != '') { $hasUnit = 'has-unit'; }
    if($isCheckbox == 'yes') { $checkboxLabel = label('', "for='".$name."'");}
    return
        div(
            label($label, "for='".$name."'")
            .div($input.$formUnit.$comments.$checkboxLabel, "", " class='divtd ".$hasUnit." ".$addClassDivtd."'  in='in".$name."'")
        ,"", " class='divtr ".$comments_css.$addClass."' ".$options." " );
}

if(!function_exists('array_column')){
    function array_column($array,$column_name){
        return array_map(function($element) use($column_name){return $element[$column_name];}, $array);
    }
}

function create_preview($text,$qty = 100) {
    $text = html_entity_decode(strip_tags($text), ENT_COMPAT, 'UTF-8');
    if (strlen($text) > $qty) {
        $lastWord = strpos($text, ' ', $qty);
        if ($lastWord) {
            $text = substr($text, 0, $lastWord);
            $last_character = (substr($text, -1, 1));
            $text = $last_character == '.' ? $text : $text . '...';
        }
    }
    return $text;
} 

function send_push($device, $title, $message, $token = null, $url = "",$nb_badge="1") {
    ignore_user_abort();
    ob_start();
    if($token != null && count($token) == 1){
        $to = "to";
        $var = $token[0];
    }elseif(is_array($token)){
        $to = "registration_ids";
        $var = $token;
    }else{
        die("BAD_SYNTAXE");
    }
    $fields = array($to=> $var);
    if($device == "IOS"){ $fields['notification'] = array('title' => $title, 'body' => $message,'sound'=>'Default');}
    $fields['data' ] = array('title'=> $title, 'message' => $message, 'url' => $url,'badge'=>$nb_badge,'sound'=>'Default');
    $headers = array('Authorization: key='._GOOGLE_KEY,'Content-Type: application/json');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, _FCM);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    if($result === false)
    die('Curl failed ' . curl_error());
    curl_close($ch);
    return $result;
}

function log_action($action,$id,$table_name,$table_db) {
    if(class_exists('AuthyActionForm')) {
        $authyAction = new AuthyActionForm();
        $authyActionData['IdAuthy'] = $_SESSION[_AUTH_VAR]->get('id');
        $authyActionData['Date'] = date('Y-m-d H:i:s');
        $authyActionData['Type'] = $action;
        $authyActionData['IdAction'] = $id;
        $authyActionData['TableAction'] = $table_name;
        $authyActionData['TableDatabase'] = $table_db;
        $authyActionSave = $authyAction->save_create_AuthyAction($authyActionData);
        $authyActionSave->save();
    }
}

function getDescription($content,$limit = 300) {
    $content = str_replace('>','> ',$content);
    $content = str_replace('"',"'",$content);
    $content = strip_tags(html_entity_decode($content));
    $content = preg_replace('/\s+/', ' ', trim($content));
    if(strlen($content) > $limit) { $text = substr($content, 0, strpos($content, ' ',$limit));  }
    return $content;
}

function getKeywords($content,$limit = 20) {    

    $text = str_replace('>','> ',$content);
    $text = strip_tags($text);
    $text = html_entity_decode($text, ENT_HTML5, "UTF-8");
    $text = filter_var($text, FILTER_SANITIZE_STRING);
    $text = preg_replace("#[[:punct:]]#"," ",$text);
    $text = trim(preg_replace('/\s+/',' ',$text));
    $text = strtolower($text);
    $text = explode(' ',strip_tags($text));
    $text = array_count_values(array_values($text));
    asort($text);
    $text = array_reverse($text);
    $text = array_filter($text,function($key) { if(is_numeric($key) OR strlen($key) <= 2) { return false; } else { return true; } },ARRAY_FILTER_USE_KEY);
    if(class_exists('StopWord')) {
        $words = StopWordQuery::create()->filterByLocale($_SESSION[_AUTH_VAR]->lang)->find();
        if($words) {
            foreach($words as $word) {
                $searchWord = trim($word->getMotVide());
                if(array_key_exists($searchWord,$text) == true) { unset($text[$searchWord]); }
            }
        }
    }
    if(count($text) < $limit) { $limit = count($text); }
    $text = array_slice($text, 0, $limit);
    if(count($text)>0){foreach($text as $key => $keyword) { @$listKeyword .= $key.','; }}
    return  rtrim(@$listKeyword,',');
}

    
function strip_punctuation( $text ){
    $urlbrackets    = '\[\]\(\)';
    $urlspacebefore = ':;\'_\*%@&?!' . $urlbrackets;
    $urlspaceafter  = '\.,:;\'\-_\*@&\/\\\\\?!#' . $urlbrackets;
    $urlall         = '\.,:;\'\-_\*%@&\/\\\\\?!#' . $urlbrackets;

    $specialquotes  = '\'"\*<>\x{0060}';

    $fullstop       = '\x{002E}\x{FE52}\x{FF0E}';
    $comma          = '\x{002C}\x{FE50}\x{FF0C}';
    $arabsep        = '\x{066B}\x{066C}';
    $numseparators  = $fullstop . $comma . $arabsep;

    $numbersign     = '\x{0023}\x{FE5F}\x{FF03}';
    $percent        = '\x{066A}\x{0025}\x{066A}\x{FE6A}\x{FF05}\x{2030}\x{2031}';
    $prime          = '\x{2032}\x{2033}\x{2034}\x{2057}';
    $nummodifiers   = $numbersign . $percent . $prime;

    return preg_replace(
        array(
            '/[\p{Z}\p{Cc}\p{Cf}\p{Cs}\p{Pi}\p{Pf}]/u',
            '/\p{Po}(?<![' . $specialquotes .
                $numseparators . $urlall . $nummodifiers . '])/u',
            '/[\p{Ps}\p{Pe}](?<![' . $urlbrackets . '])/u',
            '/[' . $specialquotes . $numseparators . $urlspaceafter .
                '\p{Pd}\p{Pc}]+((?= )|$)/u',
            '/((?<= )|^)[' . $specialquotes . $urlspacebefore . '\p{Pc}]+/u',
            '/((?<= )|^)\p{Pd}+(?![\p{N}\p{Sc}])/u',
            '/ +/',
        ),
        ' ',
        $text );
}


/*
     * @method array requestWs(array $data)
     * for all request require auth + action specific

     * Auth
    $data = array(
            'url' => 'http://192.168.5.5/p/StLaurentws'
            'a' => 'action',
            'u'	=> 'username',
            'p'	=> 'passHash',
            'debug' => false,
            'ssl_no_check' => false
        );

     * action : getOne
    $data = array(
            'a' => 'getOne',
            'f'	=> 'column',
            'i'	=> 'value',
            'filters' => array(array('column', 'value', 'NE|LT|GT'), ...),
        );

     * action : get
    $data = array(
        'a' => 'get',
        'f'	=> 'filterBy',
        'i'	=> 'value',

        'fo' => 'NE|LT|GT',
        'select' => array('column', ...) || array(array('column', 'alias'), ...),
        'filters' => array(array('column', 'value', 'NE|LT|GT'), ...),
        'join' => array('Entity', ...),
        'order' => array(array('column', 'ASC|DESC'), ...)
    );

    * action set
    $data = array(
        'a' => 'set',
        'i'	=> 'id' || array('id1', ...) || none,	* 'none' for insert
        'f'	=> 'column' || array( array ('column', 'value'), ... )
        'v'	=> 'value'	* if 'f' is only one column
    );
*/
function requestWs($data,$file="",$post=""){
    $url = $data['url'];unset($data['url']);
    $ssl_no_check = $data['ssl_no_check'];unset($data['ssl_no_check']);
    $param = http_build_query($data);

    if($data['debug'] > 0){
        $verbose = fopen('php://temp', 'rw+');
        echo "*****<br>";
        echo $url.'/mod/WservicesAct.php?<br>';
        echo urldecode($param)."<br>";

    }

    if($data['dry'] !== true){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.'/mod/WservicesAct.php?'.$param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($ssl_no_check === true){ curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);}
        if($data['debug'] > 1){ curl_setopt($ch, CURLOPT_STDERR, $verbose); }
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        if($post){
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }else if($file['file']){
             curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
            curl_setopt($ch, CURLOPT_POST, true);
            $file = array('file' => curl_file_create($file['file'], $_FILES['image']['type'], $file['name']));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
        }else{
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: x-www-form-urlencoded'));
        }
        $response = curl_exec($ch);
        curl_close($ch);
        if (!$response) {
            printf("cUrl error (#%d): %s<br>", curl_errno($ch),
            htmlspecialchars(curl_error($ch)));
        }else{
            $decoded = json_decode($response, true);
        }
    }
    if($data['debug'] > 0){
        rewind($verbose);
        if($verbose && $data['debug'] > 1){
            $verboseLog = stream_get_contents($verbose);
            echo "Verbose information:<pre>", htmlspecialchars($verboseLog), "</pre>";
        }
        echo var_dump($response);
        echo "*****<br><br><br><br>";
    }
    if(!$decoded){
        return array('r' => 'error', 'd' => $response);
    }else{
        return $decoded;
    }
}
/*
    exemple call
    $SearchWords= 'Lorem vitae';
    $Columns=array('BlogI18n.Name','BlogI18n.Text');
    $str =split_like_query($SearchWords,$Columns);
 */
function split_like_query($SearchWords,$Columns=array()){
    if(!empty($SearchWords) and !empty($Columns) and count($Columns)>0){
        unset($str);$SearchWords = explode(' ',$SearchWords);
        if(!empty($SearchWords) and count($SearchWords)>0){
            foreach($SearchWords as $SearchWord) {
                unset($ColumnsStr);
                foreach($Columns as $Column){
                    $SearchWord =RTRIM($SearchWord,'s');
                    $add_string =
                        " lower(".$Column.') LIKE lower("'.$SearchWord.'") 
                        OR  lower('.$Column.') LIKE lower("%'.$SearchWord.'") 
                        OR  lower('.$Column.') LIKE lower("%'.$SearchWord.'%") 
                        OR  lower('.$Column.') LIKE lower("'.$SearchWord.'%") ';
                    $ColumnsStr= set_var($ColumnsStr,$add_string,'OR',true,true);
                }if($ColumnsStr){ $str=set_var($str,'('.$ColumnsStr.')',' AND ',true,false);}
            }return "(".$str.")";
        }
    }return false;
}

function split_name($name) {
    $parts = array();

    while ( strlen( trim($name)) > 0 ) {
        $name = trim($name);
        $string = preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $parts[] = $string;
        $name = trim( preg_replace('#'.$string.'#', '', $name ) );
    }

    if (empty($parts)) {
        return false;
    }

    $parts = array_reverse($parts);
    $name = array();
    $name['first_name'] = $parts[0];
    $name['middle_name'] = (isset($parts[2])) ? $parts[1] : '';
    $name['last_name'] = (isset($parts[2])) ? $parts[2] : ( isset($parts[1]) ? $parts[1] : '');

    return $name;
}
//replace_all_table('beta.signemariepierre.ca','signemariepierre.ca','signemariepierre');
function replace_all_table($_find,$_replce,$_indb){
    $count=0;
    $conn = Propel::getConnection(_DATA_SRC);
    $stmt = $conn->prepare("
        SELECT t.TABLE_NAME, c.COLUMN_NAME 
        FROM information_schema.tables t
            ,information_schema.columns c
        WHERE t.TABLE_SCHEMA='".$_indb."'
            AND c.TABLE_SCHEMA='".$_indb."'
            AND t.TABLE_NAME=c.TABLE_NAME
    ");
    $stmt->execute();
    while($finds[]=$stmt->fetch(PDO::FETCH_ASSOC)); 
    if(count($finds)){
        foreach($finds as $find){
            if($find['TABLE_NAME'] and $find['COLUMN_NAME']){
                $SearchWords= $_find;
                $Columns=array("`".$find['TABLE_NAME']."`.`".$find['COLUMN_NAME']."`");
                $str =split_like_query($SearchWords,$Columns);
                $sql= " 
                    UPDATE `".$_indb."`.`".$find['TABLE_NAME']."` 
                        SET `".$find['COLUMN_NAME']."`
                            = replace(`".$find['COLUMN_NAME']."`,'".$_find."','".$_replce."') 
                        WHERE ".$str."
                ";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                if($stmt->rowCount()>0){
                    echo $sql."<br>"."<br>".$stmt->rowCount()."<br>";
                    $count = $count+$stmt->rowCount();
                }
            }
        }
    }echo "Modifier table column =".$count;
    die();
}
/*  
    permet d'initialiser la cache avec meme cache doit avoir le port, mettre la function dans str_ince avant 
    exemple apres config.db.php
    require_once $realPath.'/config.db.php';
    mem_init();
*/
function mem_init(){
    if(defined('_MEM_CACHE_PORT')){
        $_SESSION[_AUTH_VAR]->MemCacheObject = new Memcache;
        $_SESSION[_AUTH_VAR]->MemCacheObject->connect('localhost', _MEM_CACHE_PORT);
        $_SESSION[_AUTH_VAR]->MemCache="";
        if($_SESSION[_AUTH_VAR]->MemCacheObject and !empty($_GET['flushCache'])){
            $_SESSION[_AUTH_VAR]->MemCacheObject->flush();
            $_SESSION[_AUTH_VAR]->MemCache .=" console.log('MemcachedServer flush cache'); ";
        }
    }
}
/*clean key by entite*/
function mem_clean($entite){
    if($entite and $_SESSION[_AUTH_VAR]->MemCacheObject){
        if(is_file(_INSTALL_PATH.'mod/tmp/'.$entite.'.mem')){
            $f=0;
            if ($file = fopen(_INSTALL_PATH.'mod/tmp/'.$entite.'.mem', "r")) {
                while(!feof($file) and $f<20) {
                    $_SESSION[_AUTH_VAR]->MemCacheObject->delete(fgets($file));
                    $f++;
                }fclose($file);
            }unlink(_INSTALL_PATH.'mod/tmp/'.$entite.'.mem');
        }
    }
}
/*
    permet de gérer la cache par fichier
    exemple de call
    Simple = $htmlOutput = mem_function($file,'mod/page/'.$file.'.php','htmlOutput');
    Complexe = $section = mem_function('p'.$page->getSlug(),'mod/page/'.$page->getSlug().'.php','section',array('page'=>$page));
*/
function mem_function($key_mem,$file,$nameReturn,$params=array(),$paramsFlush=array(),$serialize=false){
    global $lang_sql;
    if(count($params)>0){foreach($params as $key =>$param){$$key = $param;}}
    if(@$_SESSION[_AUTH_VAR]->MemCacheObject){
        if($_SESSION[_AUTH_VAR]->get('isConnected')=='YES'){
            $key_cache = md5($key_mem.$lang_sql.$_SERVER['SERVER_NAME'].$_SESSION[_AUTH_VAR]->get('isConnected').$_SESSION[_AUTH_VAR]->get('group'));
        }else{
            $key_cache = md5($key_mem.$lang_sql.$_SERVER['SERVER_NAME'].$_SESSION[_AUTH_VAR]->get('isConnected'));
        }
        
        $cache_html =  $_SESSION[_AUTH_VAR]->MemCacheObject->get($key_cache);
        if($cache_html){
            $_SESSION[_AUTH_VAR]->MemCache .=" console.log('MemcachedServer en cache ".$file."'); ";
            return $cache_html;
        }else{
            if(is_file(_INSTALL_PATH.$file)){include _INSTALL_PATH.$file;}
            if($serialize){
                $_SESSION[_AUTH_VAR]->MemCacheObject->set($key_cache,$$nameReturn,MEMCACHE_COMPRESSED);
            }else{
                $_SESSION[_AUTH_VAR]->MemCacheObject->set($key_cache,$$nameReturn);
            }
           // $_SESSION[_AUTH_VAR]->MemCache .=" console.log('MemcachedServer pas cache ".$file."'); ";
            if(count($paramsFlush)>0){
                foreach($paramsFlush as $key =>$param){
                    $write = $key_cache;if(is_file(_INSTALL_PATH.'mod/tmp/'.$param.'.mem')){$write = "\n".$key_cache;}
                    $fp=fopen(_INSTALL_PATH.'mod/tmp/'.$param.'.mem','a');
                    fwrite($fp,$write);
                    fclose($fp);
                }
            }
            return $$nameReturn;
        }
    }else{
        if(is_file(_INSTALL_PATH.$file)){include _INSTALL_PATH.$file;}
        //$_SESSION[_AUTH_VAR]->MemCache .=" console.log('MemcachedServer pas de serveur d\'initialisé'); ";
        return $$nameReturn;
    }
}

/* cleanup des array dans les recherches multiple*/
function clean_search_array($array){
    if(!is_array($array) and $array){$array = array($array);}
    if($array[0]){
        $array =explode(',',$array[0]);
    }else{
        unset($array);
    }
    return $array;
}

##############	##############
##configure list search/paginate/order/memoire
function init_list_base(&$request,&$search,$class,$rights_special_memoire="",$multiple_patch_search="",$mem_all_php_A="",$mem_all_php_B=""){
    if($rights_special_memoire){
        $memoireSearch =$_SESSION['memoire']['search'][$rights_special_memoire];
        $memoireOnglet =$_SESSION['memoire']['onglet'][$rights_special_memoire];
    }else{
        $memoireSearch =$_SESSION['memoire']['search'];
        $memoireOnglet =$_SESSION['memoire']['onglet'];
    }
    
    if(!empty($request['s'])){ $search = unserialize(rawurldecode($request['s']));}
    if(isset($request['ms']) and $request['ms'] == 'clear'){
        $request['ms'] = '';$request['order'] = '';
        unset($memoireSearch['formMs'.$class.'']);
        unset($memoireSearch['formOrder'.$class.'']);
        unset($memoireOnglet[''.$class.'']['pg']);
    }
    if(!empty($request['ms'])){parse_str($request['ms'], $search['ms']);}
    if($multiple_patch_search){eval($multiple_patch_search);}
    if(!empty($request['order'])){
        $search['order'] = json_decode($request['order'],true);
        $memoireSearch['formOrder'.$class.''][$search['order']['col']] = $search['order']['sens'];
        $search['order']= $memoireSearch['formOrder'.$class.''];
    }else if(!empty($memoireSearch['formOrder'.$class.''])){
        $search['order'] = $memoireSearch['formOrder'.$class.''];
    }
    if(!empty($request['ms'])){
        if($memoireSearch['formMs'.$class.''] != $request['ms']){ unset($memoireOnglet[''.$class.'']['pg']);}
        $memoireSearch['formMs'.$class.''] = $request['ms'];
        if($mem_all_php_A){eval($mem_all_php_A);}
    }else if(!empty($memoireSearch['formMs'.$class.''])){
        parse_str($memoireSearch['formMs'.$class.''], $search['ms']);
    }
    if(!empty($request['pg'])){ $memoireOnglet[''.$class.'']['pg'] = $request['pg'];}
    if($mem_all_php_B){eval($mem_all_php_B);}
    if(isset($request['Autoc'])){ @$search['Autoc'] = $request['Autoc'];	/*auto complete*/}
    if(!empty($request['highlight'])){ @$search['highlight'] = json_decode($request['highlight'], true);}
    
    if($rights_special_memoire){
        $_SESSION['memoire']['search'][$rights_special_memoire]=$memoireSearch;
        $_SESSION['memoire']['onglet'][$rights_special_memoire]=$memoireOnglet;
    }else{
        $_SESSION['memoire']['search']=$memoireSearch;
        $_SESSION['memoire']['onglet']=$memoireOnglet;
    }
}
