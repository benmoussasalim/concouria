<?php

if(is_file("/opt/Minifier.php")){include_once("/opt/Minifier.php");}

$array_search;
function clean($string, $more=false){
    $string = str_replace("\'","'",$string);
    $string = str_replace("'","''",$string);
    if($more){$string = str_replace("\"","”",$string);}
    return $string;
}

function htmlLink($name, $link, $options="", $title=""){
    if(!empty($title)) {
        if($title === true) { $title = ' title="'.strip_tags($name).'" ';}
        else { $title = ' title="'.$title.'" '; }
    }
    $optionsContent = generateData($options);
    $lang="lang='fr'";
    $rel = '';
    if(defined('_LOCAL_LC_HREF') and _LOCAL_LC_HREF!= '_LOCAL_LC_HREF'){ $lang =" lang='"._LOCAL_LC_HREF."'";}
    if(strpos($link,_SITE_URL) === false){$rel = 'nofollow';}
    if(strpos($optionsContent,'_blank')){if($rel != ''){ $rel .= ' noopener noreferrer';} else {$rel = 'noopener noreferrer';}}
    $rel = 'rel="'.$rel.'"';
    $optionsContent .= $rel;
    return "<a href=\"$link\" $optionsContent $title $lang>$name</a>";
}

function href($name, $link, $options="", $title=""){ return htmlLink($name, $link, $options, $title);}

function getFilter($filter,$otherfilter="") {
    if(!empty($filter) AND $filter != 'all' AND ((!empty($otherfilter) and $otherfilter!=$filter ) or empty($otherfilter))){
        return true;
    }else{ return false;}
}

function div($content, $id="", $options=""){
    if($id) $id = "id=\"$id\"";
    $optionsContent = generateData($options);
    return "<div $id $optionsContent>$content</div>";
}

function ndiv($content, $options="") { return div($content,"", $options="");}

function fieldset($content, $options=""){
    $optionsContent = generateData($options);
    return "<fieldset $optionsContent>$content</fieldset>";
}

function legend($content, $options=""){
    $optionsContent = generateData($options);
    return "<legend $optionsContent>$content</legend>";
}

function input($type, $name, $value="", $options="", $id=""){
    if($id == ""){$id = $name;}
    $optionsContent = generateData($options);
    if(strtolower($type) != 'button'){ $value =htmlspecialchars($value, ENT_QUOTES, "UTF-8");}
    return "<input type=\"$type\" name=\"$name\" id=\"$id\" value=\"".$value."\" $optionsContent/>";
}

function webpapp($path, $css = false){
    if(defined('_WEBP_PATH') /*and $browser and $browser->getBrowser() !='Internet Explorer' and $browser->getBrowser() !='Safari' */) {
        $original_path="";
        if(defined('_SITE_URL_HTTP') and strpos($path,_SITE_URL_HTTP) !== false){
            $original_path = str_replace(_SITE_URL_HTTP,_INSTALL_PATH,$path);
        } else if(strpos($path,_SITE_URL) !== false){
            $original_path = str_replace(_SITE_URL,_INSTALL_PATH,$path);
        }

        if(!$css){
            if($original_path and is_file($original_path)){
                $path_parts = pathinfo(_INSTALL_PATH.'css/img/'.$path);
                $path_webp = str_replace(".".$path_parts['extension'],'.webp',$original_path);
                if($path_webp and ( !is_file($path_webp) || ( is_file($path_webp) and filemtime($path_webp) < filemtime($original_path) ))){
                    exec(_WEBP_PATH." ".$original_path." -o ".$path_webp."");
                }
            }
        }
    }
    if(!$css){ return $path;}
}

function img($path, $height="", $width="", $options="", $alt="", $title=""){
    if(function_exists('before_image_traitement')){before_image_traitement($path);}
    $expire='';
    $optionsContent = generateData($options);
    $path =webpapp($path);
    if(!empty($other)) { $other = ' '.$other; }
    if(!empty($height)) {
        if($height === true) { $path = _SITE_URL.'css/img/'.$path; }
        else {  $height =  ' height="'.$height.'" '; }
    }
    if(!empty($width)) { $width = ' width="'.$width.'" '; }
    if(!empty($alt)) {
        if($title == '') {
            $title = ' title="'.$alt.'" ';
        } else { $title = ' title="'.$title.'" '; }

        $alt = ' alt="'.$alt.'" ';
    }
    if(strpos($path,'?') === false and $path){
        if(function_exists('custom_cache_path_traitement') and !$expire){custom_cache_path_traitement($path,$expire);}
        if(defined('_SITE_URL_HTTP') and strpos($path,_SITE_URL_HTTP) !== false){ $expire ='?'.filemtime(str_replace(_SITE_URL_HTTP,_INSTALL_PATH,$path));}
        if(strpos($path,_SITE_URL) !== false){ $expire ='?'.filemtime(str_replace(_SITE_URL,_INSTALL_PATH,$path));}
    }
    $attrSrc=" src=\"".$path.$expire."\"  ";
    if(defined('_DEFER_IMG') and _DEFER_IMG==2){

    }else{
        $imgDefer=_SRC_URL."img/defer.png";
        if(defined('_DEFER_IMG_DEFAUT') and _DEFER_IMG_DEFAUT){$imgDefer=_SITE_URL._DEFER_IMG_DEFAUT;}
        $attrSrc=" src=\"".$imgDefer."\" data-defer=\"".$path.$expire."\" ";
    }
    return "<img $attrSrc $width  $height $optionsContent $alt $title />";
}

function bgImgDefer($path,$url=null){
    if(function_exists('before_image_traitement')){before_image_traitement($path);}
    $expire="";
    $path =webpapp($path);
    if($url){
        if(is_file($path)){ $expire = "?".filemtime($path); }
        $path=$url;
    }else if($path){
        if(function_exists('custom_cache_path_traitement') and !$expire){ custom_cache_path_traitement($path,$expire); }
        if(is_file(str_replace(_SITE_URL_HTTP,_INSTALL_PATH,$path))){
            if(strpos($path,_SITE_URL_HTTP) !== false and !$expire){ $expire = '?'.filemtime(str_replace(_SITE_URL_HTTP,_INSTALL_PATH,$path));}
            if(strpos($path,_SITE_URL) !== false and !$expire){ $expire = '?'.filemtime(str_replace(_SITE_URL,_INSTALL_PATH,$path));}
        }
    }
    $path = str_replace(' ','%20',$path);
    $return ="background-image: url('".$path.$expire."');";
    //if(defined('_DEFER_IMG') and _DEFER_IMG){
        $imgDefer="'"._SRC_URL."img/defer.png'";
        if(defined('_DEFER_IMG_DEFAUT') and _DEFER_IMG_DEFAUT){$imgDefer="'"._SITE_URL._DEFER_IMG_DEFAUT."'";}
        $return ="background-image: url(".$imgDefer.");--background-defer:url('".$path.$expire."');";
    //}
    return $return;
}

function p($content, $options=""){
    $optionsContent = generateData($options);
    return "<p $optionsContent>$content</p>";
}

function b($content, $options=""){ return "<b $options>$content</b>";}

function strong($content, $options=""){
    $optionsContent = generateData($options);
    return "<strong $optionsContent>$content</strong>";
}

function i($content, $options=""){return "<i $options>$content</i>";}

function h1($content, $options=""){
    $optionsContent = generateData($options);
    return "<h1 $optionsContent>$content</h1>";
}

function h2($content, $options=""){
    $optionsContent = generateData($options);
    return "<h2 $optionsContent>$content</h2>";
}

function h3($content, $options=""){
    $optionsContent = generateData($options);
    return "<h3 $optionsContent>$content</h3>";
}

function h4($content, $options=""){
    $optionsContent = generateData($options);
    return "<h4 $optionsContent>$content</h4>";
}

function h5($content, $options=""){
    $optionsContent = generateData($options);
    return "<h5 $optionsContent>$content</h5>";
}

function ul($content, $options=""){
    $optionsContent = generateData($options);
    return "<ul $optionsContent>$content</ul>";
}

function li($content, $options=""){
    $optionsContent = generateData($options);
    return "<li $optionsContent>$content</li>";
}

function span($content="", $options=""){
    $optionsContent = generateData($options);
    return "<span $optionsContent>$content</span>";
}

function tr($content, $options=""){
    $optionsContent = generateData($options);
    return "<tr $optionsContent>$content</tr>";
}

function td($content, $options=""){
    $optionsContent = generateData($options);
    return "<td $optionsContent>$content</td>";
}

function th($content, $options=""){
    $optionsContent = generateData($options);
    return "<th $optionsContent>$content</th>";
}

function thead($content, $option=""){ return "<thead $option>$content</thead>";}

function body($content, $option=""){
    return "<body $option>
$content</body>";
}

function tbody($content, $option=""){ return "<tbody $option>$content</tbody>";}

function tfoot($content, $option=""){ return "<tfoot $option>$content</tfoot>";}

function table($content, $options=""){
    $optionsContent = generateData($options);
    return "<table $optionsContent>$content</table>";
}

function form($content, $options=""){
    $optionsContent = generateData($options);
    return "<form $optionsContent>$content</form>";
}

function select($name, $options, $selOption="", $idSelected="", $id="",$opt_re=false,$null_in_sel=false){
    if(empty($id))
        $id = $name;
    if($null_in_sel){
        $null_in_sel_tab = array('0'=> _MESS_SELECTION,'1'=> '');
        if($options){
            array_unshift($options,$null_in_sel_tab);
        }else{
            $options=array($null_in_sel_tab);
        }
    }
    if(is_array($options)){
        $option="";
        for($i=0, $c=count($options); $i<$c; $i++){
            if(!empty($options[$i][0])){
                // handle multiple selected id
                if(!isset($options[$i][2])){$options[$i][2]="";}
                if(is_array($idSelected)){
                    if(array_search($options[$i][1], $idSelected) !== false){
                        $option .= option($options[$i][0], $options[$i][1], "v='".$options[$i][2]."' selected=\"yes\"");
                    }else
                        $option .= option($options[$i][0], $options[$i][1], "v='".$options[$i][2]."'");
                }else{
                    // handle standard selected id
                    if($idSelected == $options[$i][1]){
                        $option .= option($options[$i][0], $options[$i][1], "v='".$options[$i][2]."' selected=\"yes\"");
                    }else
                        $option .= option($options[$i][0], $options[$i][1], "v='".$options[$i][2]."'");
                }
            }
        }$options = $option;
    }
    if(!$opt_re)
         return "<select name=\"$name\" id=\"$id\" $selOption>$options</select>";
    else
        return $options;
}

function selectbox($name,$select,$valeur='',$class=''){
    $placeholder= $name;
    if($valeur){$name = $valeur;}
    return label(span($name, ' placeholder="'.$placeholder.'" class="select-label-span"').$select, '  class="select-label js-select-label '.$class.'"');
}

function optionListeSelect($options,$selectedValue,$defaultLabel=NULL){
    $optionsList="";
     if ($options) {
        $selectedLabel = "";
        foreach ($options as $option) {
            $class = "";
            if(is_array($selectedValue)){
                if(array_search($option[1], $selectedValue) !== false){
                    $class = ' class="selected"';
                    $selectedLabel .= $option[0].',';
                    $valueRemplace[]=$option[1];
                    //$inputValue[]=$option[0];
                    @$inputValue=set_var($inputValue,$option[1],",",false,true,null,null);
                }
            }else{
                if($selectedValue == $option[1]){
                    $class = ' class="selected"';
                    $selectedLabel .= $option[0].',';
                    $valueRemplace=set_var($valueRemplace,$option[1],",",false,true,null,null);
                    @$inputValue=set_var($inputValue,$option[1],",",false,true,null,null);
                }
            }
            if(!isset($option[2])){ $option[2]="";}
            $optionsList .=
                li(
                    strong(ucfirst($option[0]), 'unselectable="on"')
                , 'v="'.$option[2].'" unselectable="on" data-label="'.$option[0].'" data-value="'.$option[1].'"'.$class);
        }
    }
    if (empty($selectedLabel)) {
        if (!empty($defaultLabel)) {
            $selectedLabel = $defaultLabel;
        }
        else {
            /* mets rien esti */
           /* $selectedLabel = $options[0][0];
            $inputValue = $options[0][1];*/
        }
    }else {
        $selectedLabel = substr($selectedLabel, 0, -1);
    }
    $return['optionsList']=@$optionsList;
    $return['selectedLabel']=@$selectedLabel;
    $return['valueRemplace']=@$valueRemplace;
    $return['inputValue']=@$inputValue;
    return $return;
}

function selectboxCustomArray($name,$options,$defaultLabel='',$attr='',$selectedValue='default',$classParam='',$null_in_sel=false) {
    $placeholder = $name;
    $tabindex = "";
    $multiple = false;
    if(is_array($selectedValue)){ $selectedValue = implode(',', $selectedValue);}
    $inputValue = $selectedValue;
    if(!is_array($selectedValue)){ $selectedValue = explode(',', $selectedValue);}
    if($selectedValue){foreach ($selectedValue as $value) {$valuesList[] = $value;}}
    if($null_in_sel){
        $null_in_sel_tab = array('0'=> _MESS_SELECTION,'1'=> '');
        if($options){
            array_unshift($options,$null_in_sel_tab);
        }else{
            $options=array($null_in_sel_tab);
        }
    }
    $attr = str_replace('otherTabs=1','',$attr);
    if (!preg_match('/disabled/',$attr))
        $tabindex = ' tabindex="0" othertabs="1"';
    if (preg_match('/multiple/',$attr))
        $multiple = true;

    $rOption = optionListeSelect($options,$selectedValue,$defaultLabel);
    $optionsList =$rOption['optionsList'];
    $selectedLabel=$rOption['selectedLabel'];
    $selectedValue =$rOption['valueRemplace'];
    $inputValue =$rOption['inputValue'];


    if (!empty($defaultLabel)) {
        $defaultLabel = li(span($defaultLabel, 'unselectable="on"'), 'class="default" unselectable="on" data-label="'.$defaultLabel.'" data-value="default"');
    }
    $grayClass=" gray "; if($inputValue){ $grayClass = "";}
    $mobileHeader = "";
    if ($multiple) {$mobileHeader = div(span('x', 'class="select-close-button js-select-close-button"'), '', 'class="mobile-header"'); }
    $findme='SearchTabs';$SearchTabs=" SearchTabs='1' ";if(strpos($attr, $findme) === false){$SearchTabs=''; }
    $list = ul(
        $defaultLabel
        .$optionsList
    , 'class="scrollable select-element '.$name.'" data-default-selected=\''.json_encode($valuesList).'\'')
            .input('hidden', $name, $inputValue, 'class="selextbox-input NC'.str_replace('[]','',$name).'"  '.$SearchTabs.' s="d"');

    return label(span($selectedLabel, ' placeholder="'.$placeholder.'"  class="select-label-span'.$grayClass.'"'.$tabindex).$mobileHeader.$list
    ,
    str_replace('SearchTabs=\'1\'','',str_replace('s=\'d\'','',$attr.' data-child-select="'.str_replace('[]','',$name).'" data-name="'.$name.'" class="select-label js-select-label"'.$classParam.'"'))
    );
}

function arrayToOptions($options, $idSelected=''){
    if(is_array($options)){
        for($i=0, $c=count($options); $i<$c; $i++){
            if(!empty($options[$i][0])){
                // handle multiple selected id
                if(is_array($idSelected)){
                    if(array_search($options[$i][1], $idSelected)){
                        $option .= option($options[$i][0], $options[$i][1], "v='".$options[$i][2]."' selected=\"yes\"");
                    }else
                        $option .= option($options[$i][0], $options[$i][1], "v='".$options[$i][2]."'");
                }else{
                    // handle standard selected id
                    if($idSelected == $options[$i][1]){
                        $option .= option($options[$i][0], $options[$i][1], "v='".$options[$i][2]."' selected=\"yes\"");
                    }else
                        $option .= option($options[$i][0], $options[$i][1], "v='".$options[$i][2]."'");
                }
            }
        }
        $options = $option;
    }
    return $options;
}

function arrayToJson($options, $idSelected=''){
    if(is_array($options)){
        for($i=0, $c=count($options); $i<$c; $i++){
            if(!empty($options[$i][0])){
                // handle multiple selected id
                if(is_array($idSelected)){
                    if(array_search($options[$i][1], $idSelected)){
                        $option[$options[$i][1]] = li($options[$i][0], "data-label='".$options[$i][0]."' data-value='".$options[$i][1]."' v='".$options[$i][2]."' class='selected'");
                    }else
                       $option[$options[$i][1]] = li($options[$i][0], "data-label='".$options[$i][0]."' data-value='".$options[$i][1]."' v='".$options[$i][2]."'");
                }else{
                    // handle standard selected id
                    if($idSelected == $options[$i][1]){
                        $option[$options[$i][1]] = li($options[$i][0], "data-label='".$options[$i][0]."' data-value='".$options[$i][1]."' v='".$options[$i][2]."' class='selected'");
                    }else
                        $option[$options[$i][1]] = li($options[$i][0], "data-label='".$options[$i][0]."' data-value='".$options[$i][1]."' v='".$options[$i][2]."'");
                }
            }
        }
    }
    return json_encode($option);
}

function option($caption, $value, $options=""){ return "<option value=\"$value\" $options>$caption</option>";}

function iframe($src, $options=""){ return "<iframe src=\"$src\" $options></iframe>";}

function textarea($id, $value="", $options=""){
    $optionsContent = generateData($options);
    $value = str_replace(array('\r\n', '\n', '\r','<br/>','<br>',chr(13).chr(10),chr(10)),'&#13;&#10;',$value);
    return "<textarea id=\"$id\" name=\"$id\" $optionsContent >$value</textarea>";
}

function customCheckInput($input, $label) {
    return span(
        $input
        .span('', 'class="placeholder-input"')
        .span(
            $label
        , 'class="checkbox-label"')
    , 'class="custom-input"');
}

function checkbox($id, $value, $options=""){ return "<input type=\"checkbox\" id=\"$id\" name=\"$id\" value=\"$value\" $options>";}

function radio($id, $value, $options=""){ return "<input type=\"radio\" id=\"$id\" name=\"$id\" value=\"$value\" $options>";}

function bgImg($path,$url=null){
    if(function_exists('before_image_traitement')){before_image_traitement($path);}
    $expire="";
    $path =webpapp($path);
    if($url){
        if(is_file($path)){ $expire = "?".filemtime($path); }
        $path=$url;
    }else if($path){
        if(function_exists('custom_cache_path_traitement') and !$expire){ custom_cache_path_traitement($path,$expire); }
        if(is_file(str_replace(_SITE_URL_HTTP,_INSTALL_PATH,$path))){
            if(strpos($path,_SITE_URL_HTTP) !== false and !$expire){ $expire = '?'.filemtime(str_replace(_SITE_URL_HTTP,_INSTALL_PATH,$path));}
            if(strpos($path,_SITE_URL) !== false and !$expire){ $expire = '?'.filemtime(str_replace(_SITE_URL,_INSTALL_PATH,$path));}
        }

    }
    $path = str_replace(' ','%20',$path);
    return $path.$expire;
}

function loadCss($style, $options="", $async = false){
    $expire="";$original_path="";

    if(defined('_SITE_URL_HTTP') and strpos($style,_SITE_URL_HTTP) !== false){
        $original_path = str_replace(_SITE_URL_HTTP,_INSTALL_PATH,$style);
    } else if(strpos($style,_SITE_URL) !== false){
        $original_path = str_replace(_SITE_URL,_INSTALL_PATH,$style);
    }
    if($original_path and $style and is_file($original_path) and strpos($style,'.min.css') === false){
        $path_parts = pathinfo($original_path);
        $path_min = str_replace(".".$path_parts['extension'],'.min.css',$original_path);
        if($path_min and ( !is_file($path_min) || ( is_file($path_min) and filemtime($path_min) < filemtime($original_path) ))){
           file_put_contents($path_min,preg_replace("/\s+/", " ",trim(file_get_contents($original_path))));
        }
        $styleUrlMin=str_replace(_INSTALL_PATH,_SITE_URL,$path_min);
        if(is_file($path_min)){ $style=$styleUrlMin;}
    }

    $optionAsync = " rel=\"stylesheet\" ";
    if($async){ $optionAsync = " rel=\"preload\" as=\"style\" onload=\"this.rel='stylesheet'\" "; }

    $expire="";if($original_path and is_file($original_path)){ $expire ="?".filemtime($original_path);}

    return "<link href=\"".$style.$expire."\" ".$optionAsync." ".$options." />";
}

function loadjs($js, $async = false, $defer = true){
    if($js){
        $original_path="";
        if(defined('_SITE_URL_HTTP') and strpos($js,_SITE_URL_HTTP) !== false){
            $original_path = str_replace(_SITE_URL_HTTP,_INSTALL_PATH,$js);
        } else if(strpos($js,_SITE_URL) !== false){
            $original_path = str_replace(_SITE_URL,_INSTALL_PATH,$js);
        }

        if($original_path and $js and is_file($original_path) and strpos($js,'.min.js') === false){
            $path_parts = pathinfo($original_path);
            $path_min = str_replace(".".$path_parts['extension'],'.min.js',$original_path);
            if($path_min and ( !is_file($path_min) || ( is_file($path_min) and filemtime($path_min) < filemtime($original_path) ))){
                file_put_contents($path_min,Minifier::minify(file_get_contents($original_path)));
            }
            $jsUrlMin=str_replace(_INSTALL_PATH,_SITE_URL,$path_min);
            if(is_file($path_min)){ $js=$jsUrlMin;}
        }

        $expire="";if($original_path and is_file($original_path)){ $expire ="?".filemtime($original_path);}
        if(!defined('_LOAD_JS_DEFERE') || _LOAD_JS_DEFERE !=1){
            if($async){ $asyncT = " async"; }
            if($defer){ $deferT = " defer"; }
        }
        return "<script src=\"".$js.$expire."\"".@$asyncT.@$deferT." ></script>";
    }
}
function htmlHeader($title="", $style="", $desciption="",$keywords="", $others="", $favicon="favicon.ico", $author='Progexpert.com'){
    $Html_head = "<head>";
    $Html_head .= "<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=5,viewport-fit=cover'><meta name='google' content='notranslate'>";
    $Html_head .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
    if(!empty($desciption))
        $Html_head .= "<meta name=\"description\" content=\"$desciption\" />";
    if(!empty($keywords))
        $Html_head .= "<meta name=\"keywords\" content=\"$keywords\" />";
    if(!empty($author))
        $Html_head .= "<meta name='author' content='".$author."' />";

    if(!empty($title))
        $Html_head .= "<title>$title</title>";
    if(empty($favicon)){ $favicon="favicon.ico"; }
        $Html_head .= "<link rel=\"icon\" type=\"image/png\" href=\""._SITE_URL.$favicon."\" />";
    if(!empty( $style))
        $Html_head .= $style;

    $Html_head .= $others;

    $Html_head .= "<link rel='dns-prefetch' href='//cdn.progexpert.com/' />";
    $Html_head .= "</head>";
    return $Html_head;
}

function docType(){
    return "<!DOCTYPE HTML>";
}

function htmlTag($content,$option=""){
    $lang= "fr";if($_SESSION[_AUTH_VAR]->lang == 'en_US'|| $_SESSION[_AUTH_VAR]->lang == 'en_CA'){ $lang= "en";}
    $Html = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"".$lang."\" lang=\"".$lang."\" dir=\"ltr\"  ".$option.">";
    $Html .= $content;
    $Html .= "</html>";
    return $Html;
}

function startHtml(){
    $Html = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\" dir=\"ltr\">";
    return $Html;
}

function closeHtml(){ return "</html>";}

function br($nbr){$br=""; for($i=0;$i<$nbr;$i++){$br .= "<br/>";} return $br;}

function htmlSpace($nbr){ $space ="";for($i=0;$i<$nbr;$i++){$space .= "&nbsp;";} return $space;}

function req($val){
    if(isset($_REQUEST[$val])){
return str_replace('\\', '\\\\', strip_tags(trim(htmlspecialchars((stripslashes($_REQUEST[$val])), ENT_QUOTES))));
    }
}

function cleanString($str){ return str_replace("script","", $str);}

function getUrlParamsJSON($arrayParams="", $asUrl=false){
    $keys = array_keys($_REQUEST);
    if($asUrl){
        foreach($keys as $key){
            if(in_array($key, $arrayParams)){
                $urlParams .= "&".$key."=".urlencode($_REQUEST[$key]);
            }
        }
        return $urlParams;
    }
    $urlParams .= "'dum':'z'";
    if($arrayParams[0] != ""){
        foreach($keys as $key){
            if(in_array($key, $arrayParams)){
                $urlParams .= ",\"".$key."\":\"".urlencode($_REQUEST[$key])."\"";
            }
        }
    }else{
        foreach($keys as $key){
            if($key != "__utma" && $key != "__utmz" && $key != "PHPSESSID" && !strstr($key, "SESS") && $key != "dum"){
                $urlParams .= ",'".$key."':'".urlencode($_REQUEST[$key])."'";
            }
        }
    }
    return $urlParams;
}

function message($message){ return "<script>$(document).ready(function() {message('".$message."');});</script>";}

function script($data, $option=""){return "<script ".$option.">".$data."</script>";}

function scriptReady($data, $option=""){
    return "<script ".$option.">
$(document).ready(function(){
    ".$data."
});</script>";
}

function style($data, $option=""){ return "<style $option>".trim(preg_replace("/\s+/", " ",$data))."</style>";}

function generate_password($length = 20){
   $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
            '0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';
   $str = '';
   $max = strlen($chars) - 1;
   for ($i=0; $i < $length; $i++){$str .= $chars[mt_rand(0, $max)];}
   return $str;
}

function createRandomKey($amount){
    $keyset = "abcdefghijklmABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $randkey = "";
    for ($i=0; $i<$amount; $i++)
    $randkey .= substr($keyset, rand(0, strlen($keyset)-1), 1);
    return $randkey;
}

function ynToStr($yn, $lang='fr'){
    if($lang == 'fr'){ return ($yn == 'y')?"Oui":"Non"; }
    if($lang == 'en'){ return ($yn == 'y')?"Yes":"No";}
}

function selectYN($name, $selected='', $options=''){ return select($name, array(0=>array('Oui', 'y'), 1=>array('Non', 'n')), $options, $selected);}

function selectYesNo($name, $selected='', $options=''){ return select($name, array(0=>array('Oui', 'yes'), 1=>array('Non', 'no')), $options, $selected);}

function selectIntYN($name, $selected='', $options='', $null=false){
    if($null)
        $choices = array(0=>array('Choisir', '0'), 1=>array('Oui', '1'), 2=>array('Non', '2'));
    else
        $choices = array(0=>array('Oui', '1'), 1=>array('Non', '0'));
    return select($name, $choices, $options." s='".$selected."'", $selected);
}

function selectLang($name, $selected='', $options=''){
    return select($name, array(0=>array('Francais', 'FR'), 1=>array('English', 'EN')), $options, $selected);
}

function assocToNumDef($array, $addDefault=false, $valeur=_MESS_SELECTION){
    $arrValues = array_values($array);
    $len = count($arrValues);
    /*if($addDefault){
        $num[] = array(1=> NULL, 0=> $valeur);
    }*/
    for($i=0;$i<$len;$i++){
        $val =  array_values($arrValues[$i]);
        $num[] =$val;
    }
    return $num;
}

function assocToNumWidthNull($array, $addDefault=false){ return assocToNumDef($array, $addDefault=false);}

function assocToNum($array, $addDefault=false){
    $arrValues = array_values($array);
    $len = count($arrValues);
   /* if($addDefault){
        $num[] = array(1=> NULL, 0=> _MESS_SELECTION, 2=>'_MESS_SELECTION');
    }*/
    for($i=0;$i<$len;$i++){
        $val =  array_values($arrValues[$i]);
        $num[] =$val;
    }
    return @$num;
}

function assocToNumV($array, $addDefault=false){
    $arrValues = array_values($array);
    $len = count($arrValues);
    /*if($addDefault){
        $num[] = array(1=> NULL, 0=> _MESS_SELECTION, 2=>'_MESS_SELECTION');
    }*/
    for($i=0;$i<$len;$i++){
        $val =  array_values($arrValues[$i]);
        $num[] =$val;
    }
    return $num;
}

function message_label($label,$local= ''){
    if($label){
        global $array_search;
        if(!$local and defined('_LOCAL_LC')){
            $local =_LOCAL_LC;
        }else{
            $local = 'fr_CA';
        }
        if(empty($array_search[$label.$local])){
            $data =
                MessageQuery::create()
                ->filterByLabel($label)
                ->joinWithI18n($local)
                ->setFormatter(ModelCriteria::FORMAT_ARRAY)
                ->findOne();
            $data['Text'.$local] =$data['MessageI18ns'][0]['Text'];
        }else{
            $data['Text'.$local] = $array_search[$label.$local];
        }
        if(@$data['Text'.$local]){
            $array_search[$label.$local]= str_replace("'","&#39;",$data['Text'.$local]);
        } else if(@$data['Text'.$local] =="" and @$data['IdMessage'] and !@$data['MessageI18ns'][0]['IdMessage']){
            $e = MessageQuery::create()->findPk($data['IdMessage']);
            $mt = new MessageI18n();
            $mt->setLocale($local);
            $mt->setText($label==''?null:$label);
            $e->addMessageI18n($mt);
            $e->save();
        } else if(!isset($data['Text'.$local]) and !@$data['IdMessage']){
            if(isset($data['IdMessage'])) unset($data['IdMessage']);
            $data['IdCreation'] = $_SESSION[_AUTH_VAR]->get('id');
            $data['DateCreation'] = date('Y-m-d H:i:s');
            $data['IdModification'] = $_SESSION[_AUTH_VAR]->get('id');
            $data['DateModification'] = date('Y-m-d H:i:s');
            $data['Label'] = $label;
            $data['Text'] = $label;
            $e = new Message();
            $e->fromArray($data);
            $e->setIdCreation($data['IdCreation']==''?null:$data['IdCreation']);
            $e->setIdModification($data['IdModification']==''?null:$data['IdModification']);
            $e->setLocale('fr_CA');
                $e->setText($label==''?null:$label);
                $e->setLocale('en_US');
                $e->setText($label==''?null:$label);

            $e->save();
        }
        if(@$data['Text'.$local])
            return preg_replace("/\s+/", " ",trim($data['Text'.$local]));
        else
            return $label;
    }
}

function handleNotOkResponse($msg, $ui='', $print=false, $text_title='Message'){
    $ui = (!empty($ui))?'#'.$ui:'';
    $msg = message_label($msg);
    $error['txt'] .= $msg;
    //$error['onReadyJs'] .= "
    //	$(\"".$ui." [w='msgD']\").removeClass('ui-state-highlight').addClass('ui-state-error');
        //$(\"".$ui." [w='msgD']\").show('slow').delay('4000').hide('slow');";

    if($print){
        $error['onReadyJs'] = "
        <script>$('#ui-dialog-title-alertDialog').html('".str_replace("'"," ",$text_title)."');
        $('#alert_texte').html('".str_replace("'"," ",$msg)."');
        beforeOpenDialog('alertDialog');</script>

    ";
    }else{
        $error['onReadyJs'] = "
        $('#ui-dialog-title-alertDialog').html('".str_replace("'"," ",$text_title)."');
        $('#alert_texte').html('".str_replace("'"," ",$msg)."');
        beforeOpenDialog('alertDialog');";
        $error['error'] = 'yes';

    }

    return $error;
}

function handleValidationError($objValidationFails, $ui='', $text_title='Message', $extValidationErr=''){
    $error['error'] = 'yes';$red_flag="";$fields=array();
     if(is_array($extValidationErr)){
        foreach ($extValidationErr as $failure=>$field) {
            $msg = message_label($failure);
            $error['txt'] .= $msg . "<br>";
            $fields = array_merge($fields, $field['fields']);
        }
    }
    foreach ($objValidationFails->getValidationFailures() as $failure) {
        $msg = message_label($failure->getMessage());
        $error['txt'] .= $msg . "<br>";
        $fields[] = $failure->getColumn();
    }
    $ui = (!empty($ui))?"#".$ui:"";
    $error['onReadyJs'] .="
    $('".$ui." .error_field').removeClass('error_field');";
    foreach($fields as $field){
        if(!empty($field)){
            if(strstr($field, '.')){
                $input = explode('.', $field);
                $fieldName = $input[1];
            }else
                $fieldName = $field;
            $error['onReadyJs'] .= "
                if($('".$ui." [v=".addslashes(strtoupper($fieldName))."] .select-label-span').length > 0){
                     $('".$ui." [v=".addslashes(strtoupper($fieldName))."] .select-label-span').addClass('error_field');
                }else{
                     $('".$ui." [v=".addslashes(strtoupper($fieldName))."]').addClass('error_field');
                }
            ";
        }
    }
    $error['onReadyJs'] .= "

        $('#ui-dialog-title-alertDialog').html('".addslashes($text_title)."');
        $('#alert_texte').html('".addslashes($error['txt'])."');
        beforeOpenDialog('alertDialog');
        alert_close = '$(\'".$ui." .error_field\').first().focus();';
    ";
    return $error;
}

function camelize($string, $pascalCase = false){
  if(strpos($string, '_') !== false){$string = strtolower($string);}
  $string = str_replace(array('-', '_'), ' ', $string);
  $string = ucwords($string);
  $string = str_replace(' ', '', $string);

  if (!$pascalCase) {
    return lcfirst($string);
  }
  return $string;
}

function unCamelize($input,$separator = '_') {
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
    $ret = $matches[0];
    foreach ($ret as &$match) {
        $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    }
    return implode($separator,$ret);
}

function format_phone($phone){
   return format_phone_v2($phone);
}

function format_phone_v2($phone){
    $phone = preg_replace("/[^0-9]/", "", $phone);
    if($phone!=""){
        $area = substr($phone, 0, 3);
        $part1 = substr($phone, 3, 3);
        $part2 = substr($phone, 6,4);
        $poste = substr($phone, 10);

        $phone = ''.$area.' '.$part1.'-'.$part2;
        if($poste)
            $phone = $phone."x".$poste;

    }
    return  $phone;
}

function return_jour($id){
    $tab_jour[0]="Samedi";
    $tab_jour[1]="Dimanche";
    $tab_jour[2]="Lundi";
    $tab_jour[3]="Mardi";
    $tab_jour[4]="Mercredi";
    $tab_jour[5]="Jeudi";
    $tab_jour[6]="Vendredi";
    return substr($tab_jour[$id],0,3);
}

function label($text, $options=""){
    $optionsContent = generateData($options);
    return "<label $optionsContent>$text</label>";
}

function article($text, $options=""){
    $optionsContent = generateData($options);
    return "<article $optionsContent>$text</article>";
}

function button($text, $options=""){
    $optionsContent = generateData($options);
    return "<button $optionsContent>$text</button>";
}

function section($text, $options=""){
    $optionsContent = generateData($options);
    return "<section $optionsContent>$text</section>";
}

function canvas($text, $options=""){ return "<canvas $options>$text</canvas>";}

function headerTag($text, $options=""){ return "<header $options>$text</header>";}

function nav($text, $options=""){
    $optionsContent = generateData($options);
    return "<nav $optionsContent>$text</nav>";
}

function footer($text, $options=""){ return "<footer $options>$text</footer>";}

function encrypt_decrypt($action, $string) {
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
    }
    return $output;
}

function generateData($options) {
    $optionsContent = "";
    if(is_array($options)) {
        if(@$options[0] === null) { $dataArray = $options; }
        else {
            $dataArray = $options[1];
            @$optionsContent .= $options[0];
        }
        if(count($dataArray) > 0  AND ($_SESSION[_AUTH_VAR]->get('group') == 'Admin')) {
            $isColumn = false;
            foreach($dataArray as $key => $data) {
                @$optionsContent .= 'data-'.$key.'=\''.$data.'\' ';
                if($key == 'column') { $isColumn = true; }
            }
            if($isColumn == true) { @$optionsContent .= ' contenteditable="false"'; }
        }
    }else{ $optionsContent = " ".$options." "; }
    return $optionsContent;
}
