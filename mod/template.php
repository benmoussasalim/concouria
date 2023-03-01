<?php

###############################
#	Progexpert
###############################

if(file_exists('mod/template_func.php')){ include 'mod/template_func.php';}
if(file_exists('mod/template_style.php')){ include 'mod/template_style.php';}

$action_on =" class='hand' onmouseover='action_on(this,\"onmouseover\");' onmouseout='action_on(this,\"onmouseout\");'";
$swMenu = [];

switch($_GET['p']){
    
    case 'page':
            
            if(file_exists("./mod/page/page.php")){
                include("./mod/page/page.php");
            }

    break;
    case 'formulaire':
            
            if(file_exists("./mod/page/formulaire.php")){
                include("./mod/page/formulaire.php");
            }

    break;
    case 'invoice':
            
            if(file_exists("./mod/page/invoice.php")){
                include("./mod/page/invoice.php");
            }

    break;
    case 'rappel':
            
            if(file_exists("./mod/page/rappel.php")){
                include("./mod/page/rappel.php");
            }

    break;
    case '404':
        if(file_exists("./mod/page/404.php")){
            include("./mod/page/404.php");
        }
    break;
    default:
        if(file_exists('./mod/page/page.php')){
                include("./mod/page/page.php");
            }
    break;

}
if(defined('_ANALYTIC_GTA')) {
    $headJs .= "
        <link rel=\"preconnect\" href=\"https://www.google-analytics.com/\" >
        <link rel=\"preconnect\" href=\"https://www.googletagmanager.com/\" >
        <script>dataLayer = [".@$GTMDL."];</script>
        <!-- Google Tag Manager -->
          <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','"._ANALYTIC_GTA."');</script>
        <!-- End Google Tag Manager -->";
    $output['StartBody'] .= '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id='._ANALYTIC_GTA.'" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
}else if(defined('_ANALYTIC')) {
    $headJs .= "
        <script async src='https://www.googletagmanager.com/gtag/js?id="._ANALYTIC."'></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '"._ANALYTIC."');
        </script>

    ";
}



if(file_exists('mod/template_custom.php')){ include_once 'mod/template_custom.php';}

//Traitement SEO
if(count($return['seo'])) {
    foreach($return['seo'] as $type => $seo) {
        switch($type) {
            case 'og': $headJs .= $seo; break;
            case 'schema': $output['EndBody'] .= $seo; break;
            case 'website':
                if($seo['description']) { $siteDescription = $seo['description']; }
                if($seo['keywords']) { $siteKeywords = $seo['keywords']; }
            break;
        }
    }
}



if($_SESSION[_AUTH_VAR]->get('group') === 'Admin' AND $public != 'no' and !@$adminView) {
    $swMenu['sw-shortcut'] = [_('Activer les raccourcis'),true];
    $swMenu['edit-image'] = [_('Éditer les images'),true];
    $swMenu['edit-content'] = [_('Éditer le contenu'),true];
    //$swMenu['sw-menu'] = [_('Menu rapide'),@$_SESSION['memoire']['onglet']['context-menu']];
    if(defined('_LSCACHE') and _LSCACHE=='1'){ $swMenu[] = [_("Flush Cache"),_SITE_URL."lscache?Uri=".$_SERVER['REQUEST_URI']."&OldUri=".$_SERVER['REQUEST_URI'].""];}

    $output['EndBody'] .=
        loadJS(_SRC_URL.'js/ckeditor/ckeditor_4.6.2_standard/ckeditor.js')
        .loadJS(_SRC_URL.'js/ckeditor/ckeditor_4.6.2_standard/adapters/jquery.js')
        .loadJS(_SRC_URL.'js/plupload/plupload.full.min.js')
        .loadJS(_SRC_URL.'js/cropper/cropper.js')
        .loadCSS(_SRC_URL.'js/cropper/cropper.css');

    if(count($swMenu) > 0) {
        foreach($swMenu as $key => $menu) {
            $menuClass = $menu[1] === true ? 'permanent ' : '';

            if(!is_int($key)) {
                if($menu[1] === true) {
                    @$editContent =
                    li(
                        input('checkbox',$key,'',$menu[3].' class="'.$menu[2].'" autocomplete="off" '.$menu[1])
                        .label($menu[0],'for="'.$key.'"')
                    ,'class="'.$menuClass.'sw-input" data-key="'.$key.'"')
                    .@$editContent;
                } else {
                    @$editContent .=
                        li(
                            input('checkbox',$key,'',$menu[3].' class="'.$menu[2].'" autocomplete="off" '.$menu[1])
                            .label($menu[0],'for="'.$key.'"')
                        ,'class="'.$menuClass.'sw-input" data-key="'.$key.'"');
                }
            }
            else {
                @$customMenu .= li(href($menu[0],$menu[1],'class="no-nav '.$menuClass.'no-nav custom-menu '.$menu[2].'" '.$menu[3]),'data-key="'.$key.'"');
            }

        }
    }

    if(@$customMenu or $editContent) { $customMenu = ul($editContent.$customMenu,'class="optional-panel custom-menu-wrapper"'); }

    @$output['html'] .=
    div(
        div(
            div(
                button(_("Fermer le menu"),'class="trigger-sw-menu triggered-menu"')
                .div(
                    href(img($logoAdmin),_SITE_URL.'admin','class="logo-wrapper no-nav"')
                ,'','class="top-nav '.$_SESSION['memoire']['onglet']['optional_menu']['public'].'"')
                .nav(
                    $customMenu
                    .div(
                        button(span(''))
                    ,'','class="hide-optional-wrapper"')
                    .ul(
                        $tabs
                        .li(href(_("Déconnexion"),_SITE_URL.'disconnect','class="disconnect no-nav"'))
                    ,"class='ac-menu' ")
                , 'class="ac-nav"')
            , '','class="left-panel-content"')
         , '','class="left-panel-wrapper"')
         .button(span(_('Simple Web Plus')),'class="trigger-sw-menu sw-mobile-btn"')
    , '', 'class="left-panel in-website" ');

    if(@$_SESSION['sw_image']) {
        unset($_SESSION['sw_image']);
        $output['onReadyJs'] .= "
            var sw_date = new Date();
            var sw_current = sw_date.getTime();

            $('[data-replace=\"img\"]').each(function() {
                $(this).attr('src',$(this).attr('src') + '?' + sw_current);
            });

            $('[data-replace=\"bg\"]').each(function() {
                var sw_url = $(this).css('background-image').replace('url(\"','').replace('\")','');
                sw_url = sw_url.replace(')','');
                sw_url = sw_url.replace('url(','');

                $(this).css('background-image','url(' + sw_url + '?' + sw_current + ')');
            });
        ";
    }
}

@$siteTitle = !empty(trim($seo['title'])) ? $seo['title'] : $siteTitle;
@$siteDescription = $seo['description'] ? $seo['description'] : $siteDescription;
@$siteKeywords = $seo['keywords'] ? $seo['keywords'] : $siteKeywords;

if(@$page) {
    if(!$siteTitle AND $page->getMetaTitle()) { $siteTitle = $page->getMetaTitle(); }
    if(!$siteDescription AND $page->getMetaDescription()) { $siteDescription = $page->getMetaDescription(); }
    if(!$siteKeywords AND $page->getMetaKeyword()) { $siteKeywords = $page->getMetaKeyword(); }

    if(!$siteTitle) {
        $siteTitle = $page->getName();
        if(defined('_SITE_TITLE') AND $siteTitle) { $siteTitle .= ' | '._SITE_TITLE; }
    }
}

@$swContent["main"] = $swContent["main"] ? $swContent["main"] : $output['html'];
if(!$siteTitle AND defined('_SITE_TITLE')) { $siteTitle = _SITE_TITLE; }
if(!$siteDescription) { $siteDescription = getDescription($swContent["main"]); }
if(!$siteKeywords) { $siteKeywords = getKeywords($swContent["main"]); }
