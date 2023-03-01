<?php

###############################
#	Progexpert
###############################

include_once '../inc/init.php';
$p = req('p');
$sw = req('sw');
$type = req('type');
$act = req('act');
$i = req('i');
$a = req('a');
$ms = req('ms');
$d = req('d');
$tog = req('tog');
$ogf = req('ogf');
$v = req('v');
$w = req('w');
$h = req('h');
$x = req('x');
$y = req('y');
$nomem = req('nomem');
$Autoc = @$_POST['Autoc'];
$who = req('who');
$ui = req('ui');
$cc = req('cc');
$win = req('win');
$ml = req('ml');
/* pour la memoire des formulaire vide */
if($a == 'ml') { echo message_label($ml,$_SESSION[_AUTH_VAR]->lang);die();} 
if($a == 'context-menu') { $_SESSION['memoire']['onglet']['context-menu'] = $sw == 'true' ? 'checked' : '' ;die();} 
if($a=='ixmenu'){ $_SESSION['memoire']['onglet']['ixmenu'] = $v;die();}
if($a=='getUiED'){ echo json_encode($_SESSION['memoire']['onglet']['uiED'],true); die(); }
if($a=='uiED'){
    $_SESSION['memoire']['onglet']['uiED'][$win][$act][$cc]['w'] = $w;
    $_SESSION['memoire']['onglet']['uiED'][$win][$act][$cc]['h'] = $h;
    $_SESSION['memoire']['onglet']['uiED'][$win][$act][$cc]['y'] = $y;
    $_SESSION['memoire']['onglet']['uiED'][$win][$act][$cc]['x'] = $x;
    die();
}
if($a=='ixsamem'){
    $Authy = AuthyQuery::create()->filterByIdAuthy($_SESSION[_AUTH_VAR]->get('id'))->findOne();
    if($Authy) {
        $arrayRaccourci = unserialize($Authy->getOnglet());
        //$_SESSION['memoire']['onglet']['clipboard']=$arrayRaccourci['onglet']['clipboard'];

        if(is_array(@$arrayRaccourci['onglet']['clipboard'])){
            $_SESSION['memoire']['onglet']['clipboard'] = array_merge($arrayRaccourci['onglet']['clipboard'],$_SESSION['memoire']['onglet']['clipboard']);
        }
        AuthyQuery::create()->filterByIdAuthy($_SESSION[_AUTH_VAR]->get('id'))->update(array('Onglet' => serialize($_SESSION['memoire'])));
    }
    die();
}
if($a=='ixiconel'){ $_SESSION['memoire']['onglet']['vl'] = $v;die();}
if($a=='ixiconer'){$_SESSION['memoire']['onglet']['vr'] = $v;die();}
if($a=='ixiconet'){$_SESSION['memoire']['onglet']['vt'] = $v;die();}
if($a=='ixogf'){
    if($p and $ogf){
        $_SESSION['memoire']['onglet'][$p]['ogf'] = $ogf;
    }die();
}
if($a=='ixtog'){
    if($p){
        $_SESSION['memoire']['onglet'][$p]['tog'] = $tog;
    }die();
}
if($a=='ixoptional'){if($sw){ $_SESSION['memoire']['onglet']['optional_menu'][$type] = $sw;}die();}
if($a=='ixmem'){if($d and $p){$_SESSION['memoire']['onglet'][$p]['mem'] = $d;}die();}
if($a=='ixmemautoc'){if($p and $Autoc){$_SESSION['memoire']['onglet'][$p]['ixmemautoc'] = $Autoc;} die();}
/* pour la suppresion des menu */
if($a=='ixkill'){
    if($p == 'delfull'){
        unset($_SESSION['memoire']['onglet']);
        unset($_SESSION['memoire']['search']);
    }
    if($p and $i=='all' and $act == 'edit'){
        unset($_SESSION['memoire']['onglet'][$p]);
    }else if($p and $i !='' and $act == 'edit'){
        $_SESSION['memoire']['onglet'][$p]['i'] = rmv_var($_SESSION['memoire']['onglet'][$p]['i'],$i,',',false);
        if(!$_SESSION['memoire']['onglet'][$p]['i']){
            unset($_SESSION['memoire']['onglet'][$p]['edit']);
            unset($_SESSION['memoire']['onglet'][$p]['para']['edit'][$i]);
        }
    }else if($p and !$i and $act == 'list'){
        unset($_SESSION['memoire']['onglet'][$p]);
        if($_SESSION['memoire']['onglet']['current'] ==$p ){
            unset($_SESSION['memoire']['onglet']['current']);
        }unset($_SESSION['memoire']['search']);
    }
    AuthyQuery::create()->filterByIdAuthy($_SESSION[_AUTH_VAR]->get('id'))->update(array('Onglet' => serialize($_SESSION['memoire'])));
    die();
}
