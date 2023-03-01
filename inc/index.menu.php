<?php

require _BASE_DIR."inc/AddOmMap.php";
if(file_exists(_BASE_DIR.'/inc/index.menu.custom.php')) { include _BASE_DIR.'inc/index.menu.custom.php'; }


if(file_exists(_INSTALL_PATH.'css/img/logo-admin.png')) { $logoAdmin = _SITE_URL.'css/img/logo-admin.png'; }

if($_SESSION[_AUTH_VAR]->get('connected') != 'YES' && @$request['wbsLog']){
    $authyForm = new AuthyForm();
    $authyForm->wbsLogin($request);
}


$class_li = 'onglet_simple';
$class_active = 'onglet_simple_active';


if(count($omMap)>0){
    foreach($omMap as $c=>$key){$index[] = $key['index'];}
    array_multisort($index, SORT_ASC,$omMap,SORT_NUMERIC);
    foreach($omMap as $Menu){
        if(
            isset($Menu['file']) and isset($Menu['action'])
            and !empty($Menu['file']) and !empty($Menu['action'])
            and ($Menu['action']=='no_menu' || $Menu['action'] =='add')
            or (isset($Menu['entite']) and $Menu['entite']=='1')
        ){
            if(isset($Menu['file']) and $Menu['file']){$arrayFileManager[$Menu['name']]=$Menu['file'];}
            $arrayAdminLink[]=$Menu['name'];
        }
        //@@SUBMENU
        if(!isset($Menu['cright']) and isset($Menu['parent_menu']) and $Menu['parent_menu']){
            $arrayAdminLink[]=$Menu['name'];
            if($_SESSION[_AUTH_VAR]->hasRights($Menu['name'], 'm')){
                $class = '';if(req('p') == $Menu['name']) { $class='active'; }
                $cnt=0;if(isset($subTabs[$Menu['parent_menu']])){ $cnt = count($subTabs[$Menu['parent_menu']]);}
                $subTabs[$Menu['parent_menu']][$cnt][0] = li(href(_($Menu['desc']), _SITE_URL.$Menu['name'],"class='no-nav ".$class."' j=sm_a ",true),"j='sm'  id='menu_".$Menu['name']."'");
                $subTabs[$Menu['parent_menu']][$cnt][1] = $Menu['sub_menu'];
            }
        }
    }
    foreach($omMap as $Menu){
        if(
            (!isset($Menu['cright']) and (!isset($Menu['parent_menu']) || empty($Menu['parent_menu'])) and isset($Menu['action']) and $Menu['action'] =='add')
            or ( (!isset($Menu['parent_menu']) || empty($Menu['parent_menu']) ) and $Menu['name'] and (!isset($Menu['action']) || $Menu['action'] !='no_menu'))
            or (isset($Menu['parent_menu']) and isset($Menu['name']) and $Menu['name'] and $Menu['parent_menu'] == $Menu['name'])
        ){
            //@@MENU
            $arrayAdminLink[]=$Menu['name'];
            if($_SESSION[_AUTH_VAR]->hasRights($Menu['name'], 'm') and $Menu['index'] and $Menu['desc'] and !isset($Menu['cright'])){
                $tabsSub='';$attr_menu='';$parentClass='';
                $link = _SITE_URL.$Menu['name'].'/list/';
                if(req('p') == $Menu['name']) { $parentClass = 'active'; }
                if(@$subTabs[$Menu['name']]){
                    $tabsSub = ul(sm_tri($subTabs[$Menu['name']]),'class="sub-menu"');
                    $link = 'javascript:';$attr_menu = " jhera=act ";
                }
                $mapFile='';if(@$Menu['file']){ $mapFile = "entite='".$Menu['name']."'";}
                @$tabs .= li(href($Menu['desc'],$link,"data-nav='1.' j='menu' ".$attr_menu." ".$mapFile." name_entite='".$Menu['name']."'",true).$tabsSub,'class="no-nav '.$parentClass.'" id="menu_'.$Menu['name'].'"');
            }
        }
    }
}



if(in_array($menu_choice,$arrayAdminLink)){
    $css = $adminCss;
    if(empty($request['a'])){ if(isset($_GET['act']) AND $_GET['act'] != '') { $request['a'] = $_GET['act']; } else { $request['a'] = 'list'; } }
    if(empty($request['ui'])) $request['ui'] = 'tabsContain';
    if(isset($arrayFileManager[$menu_choice]) and $arrayFileManager[$menu_choice]){
        if(file_exists(_INSTALL_PATH.'mod/'.$arrayFileManager[$menu_choice].'.php')){ include _INSTALL_PATH.'mod/'.$arrayFileManager[$menu_choice].'.php';}
    }else{
        if(file_exists(_INSTALL_PATH.'mod/act/'.$menu_choice.'Act.php')){ include _INSTALL_PATH.'mod/act/'.$menu_choice.'Act.php';}else{ include _INSTALL_PATH.'mod/act/actInput.php';}
    }
} else {
    switch($menu_choice){
        
                case 'Support':
                    $css = $adminCss;
                    $request['ui'] = 'tabsContain';
                    include 'mod/support.php';
                break;

        case 'Deconnection': case 'Disconnect': case 'deconnection': case 'deconnexion': case 'disconnect': case 'logout':
            $auth = AuthyQuery::create()->filterByIdAuthy($_SESSION[_AUTH_VAR]->get('id'))->findOne();
            if($auth){
                AuthyQuery::create()->filterByIdAuthy($_SESSION[_AUTH_VAR]->get('id'))->update(array('Onglet' => serialize($_SESSION['memoire'])));
                if($_SESSION['token'] and class_exists('AuthyToken')){
                    $AuthyToken =AuthyTokenQuery::create()->filterByToken($_SESSION['token'])->filterByIdAuthy($_SESSION[_AUTH_VAR]->get('id'))->findOne();
                    if($AuthyToken){$AuthyToken->delete();}
                }
                $e = new AuthyLogForm();
                $data_log['IdAuthy'] = $_SESSION[_AUTH_VAR]->get('id');
                $data_log['Ip'] = $_SERVER['REMOTE_ADDR'];
                $data_log['Timestamp'] = time();
                $data_log['Login'] = $_SESSION[_AUTH_VAR]->get('username');
                $data_log['Type'] = 'Déconnexion';
                $e->fromArray($data_log );
                $e->save();
            }
            $Token =$_SESSION['token'];
            unset($_COOKIE[_PROJECT_NAME.'_authy']);
            setcookie(_PROJECT_NAME.'_authy',NULL,-1, '/');
            session_destroy();
            $_SESSION['token']=$Token;
            $redirect="";if($_GET['callback']){ $redirect=$_GET['callback'];}
            $message="";if($_GET['message']){ $message= "?message=".urlencode($_GET['message']);}else{$message= "?1=1";}
            die("<script>document.location = '"._SITE_URL.$redirect.$message."&lg=".urlencode($_SESSION[_AUTH_VAR]->lang)."';</script>");
        break;
        default:
            
        if(req('p') != 'admin') {
            //@@TEMPLATE
            require_once _BASE_DIR.'/mod/template.php';
            if(@$public != 'no') { $public = 'yes'; }
        }

            if(1 && req('p') == 'admin') {
                $css = $adminCss;
                //@@UTILITY | REVOIR POUR UNE MISE EN PAGE D'UN NAVIGATEUR OBSOLÈTE
                if($_SESSION[_AUTH_VAR]->get('connected') != 'YES') {
                    $siteTitle = 'Simple Web +';
                    
                    $authyFormObj = new AuthyForm();
                    $output = $authyFormObj->logForm();
                    $bodyClass = 'ac-login';
                } else if(empty($output['html']) || req('p') == 'admin') {
                    
                if(file_exists(_INSTALL_PATH.'mod/dashboard.php') AND $_SESSION[_AUTH_VAR]->hasRights("dashbord", 'r') ) {
                    include _INSTALL_PATH.'mod/dashboard.php';
                    $output['html'] = div($output['html'],"", "class='dashboard-wrapper'");
                } else {
                    
                    /*$text = file_get_contents('https://cdn.progexpert.com/sw_text.html');*/
                    $text = "<h1>Simple Web +</h1>
<p>Avec Simple Web + gérer votre site Web n’aura jamais été si facile! Plus épuré et performant, profitez de ce gestionnaire de contenu maintenant adapté sur mobile.</p>";

                    $output['html'] =
                    div(href(span(_("Ouvrir/Fermer le menu")),'javascript:','class="toggle-menu trigger-menu"'),'','class="sw-header"')
                    .div($text,"", "class='default-home'");
            
                }

                }
            }
        break;
    }
}
if(@$request['act'] == 'MonCompte' AND file_exists('mod/act_p/myAccount.php')) { include 'mod/act_p/myAccount.php'; }
if($_SESSION[_AUTH_VAR]->get('connected') == 'YES'){

    $p = req('p');		//PARENT
    $act = req('act');	//ACTION
    $i = req('i');		//ID
    $a = req('a');
    $ms = req('ms');	//RECHERCHE
    $d = req('d');
    $ogf = req('ogf');
    $v = req('v');
    $nomem = req('nomem');
    $Autoc=""; if(isset($_POST['Autoc'])){$Autoc = $_POST['Autoc'];}
    $who = req('who');
    $h = req('h');

    if($p){
        if(@$omMapDesc[$p]['dm'] and strtoupper($p) != 'DECONNECTER' and strtoupper($p) != 'DISCONNECT' and strtoupper($p) != 'DECONNECTION') {
            if(!$act){ $act = 'list'; }
            if(isset($_SESSION['memoire']['onglet'][$p])){
                $tmp = $_SESSION['memoire']['onglet'][$p];
                unset($_SESSION['memoire']['onglet'][$p]);
                $_SESSION['memoire']['onglet'][$p]=$tmp;
            }

            $_SESSION['memoire']['onglet'][$p][$act] = 1;
            if(count($_SESSION['memoire']['onglet']) > _onglet_maximum) { array_shift($_SESSION['memoire']['onglet']); }

            if(!$i and $act == 'edit') { $i= '0'; }
            if($i and $act == 'edit' and !$nomem) {
                $txp = explode('?',$_SERVER['REQUEST_URI']);
                @$_SESSION['memoire']['onglet'][$p]['para']['edit'][$i] = $txp[1];
                if(@$omMapDesc[$p]['onc'] and $i) {
                    $table = $p;
                    if(!empty($omMapDesc[$p]['oncTable'])) { $table = $omMapDesc[$p]['oncTable']; }

                    $query = $table."Query";
                    $q = new $query();
                    $onctab = $q::create()->setFormatter(ModelCriteria::FORMAT_ARRAY)->findPk(json_decode($i));

                    if(@$omMapDesc[$p]['onc']){
                        $onc = "";
                        foreach(json_decode($omMapDesc[$p]['onc'], true) as $champ){ $onc .= $onctab[camelize($champ, true)]; }
                        if($onc){ $_SESSION['memoire']['onglet'][$p]['onc'][$i] = substr(str_replace(' ', '',mb_convert_case($onc, MB_CASE_LOWER,'UTF-8')), 0,15).".."; }
                    }
                }

                $_SESSION['memoire']['onglet'][$p]['i'] = rmv_var($_SESSION['memoire']['onglet'][$p]['i'], $i, ',', false);
                $_SESSION['memoire']['onglet'][$p]['i'] = set_var($_SESSION['memoire']['onglet'][$p]['i'], $i, ',', false, true, _onglet_formulaire);

            } else if($act == 'list' and !$nomem) { $_SESSION['memoire']['onglet'][$p]['ms']['list'] = str_replace('&amp;', '%26', $ms); }
            $_SESSION['memoire']['onglet']['current'] = $p;
            if($act == 'edit') { $_SESSION['memoire']['onglet']['currentI'] = $i; }
        }
        //AuthyQuery::create()->filterByIdAuthy($_SESSION[_AUTH_VAR]->get('id'))->update(array('Onglet'=>serialize($_SESSION['memoire'])));
    }
}
