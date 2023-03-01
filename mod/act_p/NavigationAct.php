<?php

$dynamicNav = true;

$url['parse'] = parse_url($request['url']);

if($url['parse']['host'] == $_SERVER['SERVER_NAME']) {
   $url['first'] = 0; //@CHECK
    if(str_replace('www.','',$_SERVER['SERVER_NAME']) == 'lebuilder.com') { $url['first'] = 2; }

    $url['path'] = array_values(array_filter(explode('/',$url['parse']['path'])));

    $request['p'] = $url['path'][$url['first']] ? $url['path'][$url['first']] : strtolower(_('accueil'));

    if(strlen($request['p']) == 2) {
        $url['first'] += 1;
        $request['lg'] = $request['p'];
        $request['p'] = $url['path'][$url['first']] ? $url['path'][$url['first']] : strtolower(_('accueil'));
    }

    if($correctPath[$request['p']]['request']) {
        foreach($correctPath[$request['p']]['request'] as $key => $value) {
            $request[$value] = $url['path'][$key + $url['first']] ? $url['path'][$key + $url['first']] : null;
        }
    }

    if($url['parse']['query']) {
        parse_str($url['parse']['query'],$query);
        $request = array_merge($request,$query);
        unset($query);
    }
} else { die(); }

$return['url'] = $request['url'];
if(file_exists(_INSTALL_PATH.'js/sw/'.$request['p'].'.js')) { $return['script'][] = $request['p']; }

if($request['a']) {
    switch($request['a']) {
        case 'loadContent':
            if($correctPath[$request['p']]['path']) {
                //echo _INSTALL_PATH.'mod/page/'.$correctPath[$request['p']]['path'].'.php';
                ///var/www/html/p/POSREPAIRBOUTIQUE/mod/page/../store/profile.php
                $includeFile = _INSTALL_PATH.'mod/page/'.$correctPath[$request['p']]['path'].'.php';
                if(file_exists($includeFile)) { include $includeFile; }
            } else {
                include _INSTALL_PATH.'mod/page/page.php';
            }
        break;
    }
}

if(!$section['PageContent']) { $section['PageContent'] = '&nbsp;'; }

if(!$return['title']) { $return['title'] = $siteTitle ? $siteTitle : _SITE_TITLE; }

$return['pos'] = $request['pos'] ? $request['pos'] : 0;

if($_SESSION[_AUTH_VAR]->get('group') == 'Admin' AND count($swMenu) > 0) {
    foreach($swMenu as $key => $menu) {
        if(is_int($key)) { $return['admin_menu'] .= li(href($menu[0],$menu[1],'class="custom-menu"'),'data-key="'.$key.'"'); }
    }
}
