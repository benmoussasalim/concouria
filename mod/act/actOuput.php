<?php

###############################
#	Progexpert
###############################

if($request['a'] == 'select'){
    echo $output['html'];
    echo script("
        $(document).ready(function() {".$output['onReadyJs']." });
        ".$output['js']."
    ");
}else if(!empty($fromQuery)){
    $output['onReadyJs'] .= "deferImg(50);";
    $return['form'] =preg_replace("/\s+/"," ",trim($output['html'].script("
        if('".addslashes(substr(strip_tags($output['pagerRow']),0,10))."'){
            if($('#".$request['ui']."').parents('.ui-dialog').length > 0){
                if($('#".$request['ui']." #cntPagerRow').length > 0){
                    $('#cntPagerRow').html('".addslashes(@$output['pagerRow'])."');
                }else{
                    $('#".$request['ui']."').append('".addslashes(div(@$output['pagerRow'],'cntPagerRow'))."');
                }
            }else{
                $('#cntPagerRow').remove();
                $('.center-panel').append('".addslashes(@$output['pagerRow'])."');
            }
        }
        $(document).ready(function() { ".$output['onReadyJs']." });
        ".$output['js']."
        CurrentClass='".$CurrentClass."';
        currentA='".$request['a']."';
        function onDialogClose(){}
        setDivContent();
        statmemesave();
        if($('.left-panel #sw-shortcut').prop('checked')){ initDrag(true);}
    ")));
}else if(empty($request['ot']) || $request['ot'] != 's'){
    $output['onReadyJs'] .= "deferImg(50);";
    echo preg_replace("/\s+/"," ",trim($output['html'].script("
        if('".addslashes(substr(strip_tags(@$output['pagerRow']),0,10))."'){
            if($('#".$request['ui']."').parents('.ui-dialog').length > 0){
                if($('#".$request['ui']." #cntPagerRow').length > 0){
                    $('#cntPagerRow').html('".addslashes(@$output['pagerRow'])."');
                }else{
                    $('#".$request['ui']."').append('".addslashes(div(@$output['pagerRow'],'cntPagerRow'))."');
                }
            }else{
                $('#cntPagerRow').remove();
                $('.center-panel').append('".addslashes(@$output['pagerRow'])."');
            }
        }
        $(document).ready(function() { ".$output['onReadyJs']." });
        ".$output['js']."
        CurrentClass='".$CurrentClass."';
        currentA='".$request['a']."';
        function onDialogClose(){}
        setDivContent();
        statmemesave();
        if($('.left-panel #sw-shortcut').prop('checked')){ initDrag(true);}
    ")));
}
if($request['a'] == 'print'){
    echo docType()
        .htmlTag(
            htmlHeader(_SITE_FULLNAME, $printCss, '', '', $printJs)
            .body(
                $printHeader
                .$output['html']
                .$printFooter
            )
        )."
<script type='text/javascript'>
$(document).ready(function() {
    ".$output['onReadyJs']."
});</script>";
    die();
}
