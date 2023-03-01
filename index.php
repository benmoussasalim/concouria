<?php

###############################
#	Progexpert
###############################
//if(isset($_REQUEST['p']) and $_REQUEST['p'] == 'favicon.ico'){ die(); }
include_once 'inc/init.php';
if(file_exists(_BASE_DIR.'inc/index.custom.php')) { include _BASE_DIR.'inc/index.custom.php'; }
$request = $_REQUEST;
$request['ot'] = 's';
$output = array();

/*module cache*/
if(defined('_LSCACHE') and _LSCACHE=='1' and $request['p']=='lscache'){
    $request['Uri'] = ltrim($request['Uri'],'/');
    /*echo 'curl --cookie '.
        escapeshellarg('_lang='.$_SESSION[_AUTH_VAR]->lang).' -isX PURGE '.
        escapeshellarg(_SITE_URL_HTTP.$request['Uri']);*/
    exec('curl --cookie '.
        escapeshellarg('_lang='.$_SESSION[_AUTH_VAR]->lang).' -isX PURGE '.
        escapeshellarg(_SITE_URL_HTTP.$request['Uri'])
    ,$output);
    if(!isset($request['OldUri'])){echo "asd";$request['OldUri']=$request['Uri'];}
    $request['OldUri'] = ltrim($request['OldUri'],'/');
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
    if($request['OldUri']){header('Location:'.$actual_link."/".$request['OldUri']); }
    die();
}
//@@MENU
$menu_choice = req('p');
include _BASE_DIR.'inc/index.menu.php';

if($_SESSION[_AUTH_VAR]->get('connected') == 'YES') {
    $calledPage['menu'] = ul($tabs.@$configTab.li(href(_("Déconnexion"),_SITE_URL.'disconnect','class="disconnect"')),"class='ac-menu'");
    setcookie("_login",$_SESSION[_AUTH_VAR]->get('connected'));
}else{unset($_COOKIE['_login']);setcookie('_login', '', 1); }

if(empty($stdHeader['html']) and (!isset($hf_client) || !$hf_client)) { include _BASE_DIR.'inc/std.header.php'; }
if(empty($stdFooter['html']) and (!isset($hf_client) || !$hf_client)) { include _BASE_DIR.'./inc/std.footer.php'; }
if(@$noStdHeader == 'all') { $stdHeader['html'] = ''; }

$headJs = $headJs.style("#menu_Disconnect { display: none; }");
$headJs .= loadJS("//cdn.progexpert.com/js/loadcss.js");

// @@CLIPBOARD | SYSTÈME DE RACCOURCIS
if($_SESSION[_AUTH_VAR]->get('group') == 'Admin') {
    $shortcutAdmin = $shortcut  =
        div(
            div(p(_("Récupération de vos raccourcis en cours.")),'','class="sw-shortcut-content"')
            .button(span(_("Afficher les raccourcis")),'class="sw-shortcut-btn"')
        ,'','class="sw-shortcut-wrapper" id="sw-list-shortcut"')
    ;
}


//@@JS | INCLUDE DU JAVASCRIPT
if(isset($output['windowScroll'])) { $output['onReadyJs'] .= '$(window).scroll(function() { '.$output['windowScroll'].' }); $(window).scroll();'; }
if(isset($output['windowResize'])) { $output['onReadyJs'] .= '$(window).resize(function() { '.$output['windowResize'].' }); $(window).resize();'; }
if(!isset($output['onReadyJs'])) { $output['onReadyJs'] = ''; }
if(!isset($calledPage['onReadyJs'])) { $calledPage['onReadyJs'] = ''; }
if(!isset($stdHeader['onReadyJs'])) { $stdHeader['onReadyJs']=''; }
if(!isset($stdFooter['onReadyJs'])) { $stdFooter['onReadyJs']=''; }
$stdFooter['js'] .= "var _DEFER_IMG = '"._DEFER_IMG."';";$stdFooter['onReadyJs'] .= "deferImg(0);";  //if(defined('_DEFER_IMG') and _DEFER_IMG){ }


@$js_index .=
@$calledPage['jssrc']
.$jscript
."<script >
    var _SITE_URL = '".addslashes(_SITE_URL)."';
    var _SRC_URL = '".addslashes(_SRC_URL)."';
    var _CONNECTED= '".$_SESSION[_AUTH_VAR]->get('connected')."';
    var _SRC_URL_TINY = '".addslashes(_SRC_URL_TINY)."';
    var _SITE_URL_NO_S = '".addslashes(_SITE_URL_NO_S)."';
    var session_id = '".addslashes(session_id())."';
    var _BASE_DIR = '".addslashes(_BASE_DIR)."';
    var _CANT_CLOSE_POPOP = '".addslashes(_('Une modification a été apportée dans le formulaire courant. Utilisez le X pour fermer la fenêtre.'))."';
    var _SUPPORT_POSSI_FRAIS = '".addslashes(_('Veuillez accepter la possibilitée de frais.'))."';
    var _SUPPORT_INSERT_MESSAGE = '".addslashes(_('Veuillez entrer un message.'))."';
    var _UPLOAD_MESSAGE = '".addslashes(_('Téléversement en cours... (<span></span>%)'))."';
    var _LANG = '".$lang_ckeditor."';
    var _SERVER_DATE = '".time()."';
    var _isMobile = '".isMobile()."';
    var inactivityTime = '".addslashes(@_INACTIVITY_DELAY)."';
    var _VAR_OUI = '".addslashes(_('Oui'))."';
    var _VAR_NON = '".addslashes(_('Non'))."';
    var _VAR_FERMER = '".addslashes(_('Fermer'))."';
    var _COPY_MESSAGE = '".addslashes(_('Le texte a été copié dans votre clipboard!'))."';
    var _TITLE_MESSAGE_INFO = '".addslashes(_('Message d\'information!'))."';
    var _lastSupportCheck = '".$_SESSION[_AUTH_VAR]->lastSupportCheck."';
    var traductionList = {};
    traductionList['messageClear'] = '".addslashes(_('Remise à zéro de la recherche...'))."';
    traductionList['messageBt'] = '".addslashes(_('Recherche en cours...'))."';
    traductionList['messageIdentifiant'] = '".addslashes(_('Identifiant de la recherche'))."';
    traductionList['insertIdentifiant'] = '".addslashes(_('Veuillez entrer un identifiant.'))."';
    traductionList['confirm'] = '".addslashes(_('Confirmer'))."';
    traductionList['recherche'] = '".addslashes(_('Recherche'))."';
    traductionList['attention'] = '".addslashes(_('Attention'))."';
    traductionList['copylink'] = '".addslashes(_('Copier le lien'))."';
    traductionList['liencopie'] = '".addslashes(_('Lien copié'))."';
    traductionList['impliencopie'] = '".addslashes(_('Impossible de copier le lien'))."';
    traductionList['telecharger'] = '".addslashes(_('Télécharger'))."';
    traductionList['cocherMin'] = '".addslashes(_('Cocher au moins une ligne a mettre à jour.'))."';
    traductionList['lightbox_prev'] = '".addslashes(_('Précédent'))."';
    traductionList['lightbox_next'] = '".addslashes(_('Suivant'))."';

    $(document).ready(function() {
        if(typeof(statmemesave) !== 'undefined' && _CONNECTED =='YES'){statmemesave();}
    "
        .trim($output['onReadyJs'])
        .$calledPage['onReadyJs']
        .$stdHeader['onReadyJs']
        .$stdFooter['onReadyJs']
        ."
    });
    ".@$output['js']
    .@$calledPage['js']
    .@$stdHeader['js']
    .@$stdFooter['js']
    .@$js
    ."
</script>";

        $traductionsArray = ["fr_CA" => "Français","en_US" => "Anglais"];
         foreach($traductionsArray as $lang => $traductions) {
             $currentLg = '';
             if($lang == $_SESSION[_AUTH_VAR]->lang) { $currentLg = 'current'; }
             @$listLang .= li(href(_($traductions),_SITE_URL.'admin?lg='.$lang,'class="button-link-blue '.$currentLg.'"',true));
         }

//@@SEO | RÉFÉRENCEMENT DE BASE
@$siteTitle .= ' '.@$output['siteTitle'];
@$siteDescription .= @$output['siteDescription'];
@$siteKeywords .= @$output['siteKeywords'];
if(empty(trim($siteTitle))) { $siteTitle = ucfirst(@$request['p'])." ".@$request['a']." | Simple Web +"; }

//@@LANG | DÉTECTION DE LA LANGUE
if(@$_REQUEST['lg'] != ''){ $_SESSION[_AUTH_VAR]->lang = $_REQUEST['lg']; }

//@@ toogle memoiremenu

if(@$_SESSION['memoire']['onglet']['ixmenu'] =='true' and !isMobile()){@$bodyClass.=' toggle-left-panel';}

//@@INCLUDE CRÉATION DE LA PAGE
if(!@$htmlHeader){ $htmlHeader = htmlHeader(@$siteTitle,@$css.@$uiCss.@$calledPage['css'],@$siteDescription,@$siteKeywords,@$headJs.@$adminJs,@$favicon,@$headAuthor); }
if(($_SESSION[_AUTH_VAR]->get('connected') == 'YES' && (empty($public) || $public != 'yes')) or @$adminView) {
    @$bodyClass .= ' sw-admin ';

    $topNav[0] = li(href(span(_("Accueil")),_SITE_URL,'class="icon home"'),'data-tooltip="'._("Accueil").'"');

    if($_SESSION[_AUTH_VAR]->hasRights('Authy','r')) {
        $topNav[1] = li(href(span(_("Mon profil")),_SITE_URL.'Authy/edit/'.$_SESSION[_AUTH_VAR]->get('id'),'class="icon user"'),'data-tooltip="'._("Mon profil").'"');
    }

    $shortcutBtn =
        li(
            input('checkbox','sw-shortcut','','autocomplete="off"')
            .label(_("Activer les raccourcis"),'for="sw-shortcut"')
        ,'data-key="sw-shortcut"')
    ;
    //@$output['EndBody'] .= loadJS(_SITE_URL.'SimpleWeb/simple_web.js');

    
                if($_SESSION[_AUTH_VAR]->get('group') == 'Admin') {
                    $topNav[2] = li(href(span(_("Support")),_SITE_URL.'Support/','class="icon support"'),'class="support-link '.$_SESSION[_AUTH_VAR]->support.'" data-tooltip="'._("Support").'"');
                }


    $topNav[3] = li(href(span(_("Tableau de bord")),_SITE_URL.'admin','class="icon dashboard"'),'data-tooltip="'._("Tableau de bord").'"');

    if(is_file(_INSTALL_PATH.'inc/custom.top_nav.php')) { include _INSTALL_PATH.'inc/custom.top_nav.php'; }

    foreach($topNav as $navElement) { @$fastNav .= $navElement; }
    @$print .=
    docType()
    .htmlTag(
        $htmlHeader
        .body(
            $cssBody
            .$output['StartBody']
            .div(
                div(
                    div(
                        div(
                            href(img($logoAdmin),_SITE_URL,'class="logo-wrapper"')
                            .ul(
                                $fastNav
                                .li(href(span(_("Menu")),'#','class="icon menu trigger-menu"'),'data-tooltip="'._("Cacher le menu").'"')
                            ,'class="nav"')
                            .div(
                                $authy
                                .ul(@$listLang,'class="language-selection"')

                                .ul(
                                    $shortcutBtn
                                    /*.li(
                                        input('checkbox','sw-menu','','autocomplete="off" '.$_SESSION['memoire']['onglet']['context-menu'])
                                        .label(_("Menu rapide"),'for="sw-menu"')
                                    ,'data-key="sw-shortcut"')*/
                                ,'class="custom-menu-wrapper"')

                            ,'','class="optional-panel"')
                            .div(button(span('')),'','class="sw-version"')
                        ,'','class="top-nav '.$_SESSION['memoire']['onglet']['optional_menu']['admin'].'"')
                        .nav($calledPage['menu'].(isset($showNavMenu) ? $showNavMenu : ''), 'class="ac-nav"')
                    , '', 'class="left-panel-content" ')
                 , '', 'class="left-panel-wrapper" ')
           , '', 'class="left-panel sw-admin" ')
           .div(
               div(
                div($output['html'], 'tabsContain')
                .$shortcutAdmin
               ,'','class="content-wrapper"')
               .$output['pagerRow']
           ,'', 'class="center-panel"')

            //@@DIALOG | AJOUT HTML DES DIALOGS
            .div('','editDialog','class="hide"')
            .div('','editPopupDialog','class="hide"')
            .div(div('<svg class="hourglass" xmlns="//www.w3.org/2000/svg" viewBox="0 0 120 206" preserveAspectRatio="none"><path class="middle" d="M120 0H0v206h120V0zM77.1 133.2C87.5 140.9 92 145 92 152.6V178H28v-25.4c0-7.6 4.5-11.7 14.9-19.4 6-4.5 13-9.6 17.1-17 4.1 7.4 11.1 12.6 17.1 17zM60 89.7c-4.1-7.3-11.1-12.5-17.1-17C32.5 65.1 28 61 28 53.4V28h64v25.4c0 7.6-4.5 11.7-14.9 19.4-6 4.4-13 9.6-17.1 16.9z"/><path class="outer" d="M93.7 95.3c10.5-7.7 26.3-19.4 26.3-41.9V0H0v53.4c0 22.5 15.8 34.2 26.3 41.9 3 2.2 7.9 5.8 9 7.7-1.1 1.9-6 5.5-9 7.7C15.8 118.4 0 130.1 0 152.6V206h120v-53.4c0-22.5-15.8-34.2-26.3-41.9-3-2.2-7.9-5.8-9-7.7 1.1-2 6-5.5 9-7.7zM70.6 103c0 18 35.4 21.8 35.4 49.6V192H14v-39.4c0-27.9 35.4-31.6 35.4-49.6S14 81.2 14 53.4V14h92v39.4C106 81.2 70.6 85 70.6 103z"/></svg>').p(_("Veuillez patienter...")),'loadingDialog','class="hide"')
            .div(p('',"id='confirm_text'"),'confirmDialog')
            .div(p('','id="alert_texte"'),'alertDialog',"class='hide' title='Message'")

            .$js_index
            .$output['EndBody']
        ," id='body' ".(isset($bodyClass) ? 'class="'.$bodyClass.'"' : ''))
    ," id='html_build' ");
} else if(isset($customOutputIndex)) {
    if($_SESSION[_AUTH_VAR]->get('group') == 'Admin') {
        $output['EndBody'] .= loadJS(_SITE_URL.'SimpleWeb/simple_web.js');
    }
    @$print .=
    docType()
    .htmlTag(
        $htmlHeader
        .body(
            $cssBody
            .$output['StartBody']
            .$stdHeader['html']
            .$output['html']
            .$shortcut
            .$stdFooter['html']
            .$js_index
            .$output['EndBody']
        ," id='body' ".(isset($bodyClass) ? 'class="'.$bodyClass.'"' : ''))
    );
} else {
    if($_SESSION[_AUTH_VAR]->get('group') == 'Admin') {
        $output['EndBody'] .= loadJS(_SITE_URL.'SimpleWeb/simple_web.js');
    }
    @$print .=
    docType()
    .htmlTag(
        $htmlHeader
        .body(
            $cssBody
            .$output['StartBody']
            .$stdHeader['html']
            .$output['html'].$shortcut
            .$js_index
            .$output['EndBody']
        ," id='body' ".(isset($bodyClass) ? 'class="'.$bodyClass.'"' : '')."")
    ," id='html'");
}

//@@INCLUDE
if(file_exists(__dir__ .'/mod/inc/')){
    if($handle = opendir(__dir__ .'/mod/inc/')) {
        while(false !== ($filename = readdir($handle))) {
            if(substr($filename, strrpos($filename, '.')) == '.js') { $print .= loadJs(_SITE_URL.'mod/inc/'.$filename); }
            if(substr($filename, strrpos($filename, '.')) == '.css'){ $print .= loadCss(_SITE_URL.'mod/inc/'.$filename); }
        }
    }
}

if(file_exists(_BASE_DIR.'inc/index.custom_end.php')) { include _BASE_DIR.'inc/index.custom_end.php'; }
$print =
    str_replace(
        array('https://lebuilder.com/p/'._PROJECT_NAME.'/'
            ,'//lebuilder.com/p/'._PROJECT_NAME.'/'
            ,'http://lebuilder.com/p/'._PROJECT_NAME.'/'
        )
    ,_SITE_URL,$print);
echo preg_replace("/\s+/", " ",trim($print));
