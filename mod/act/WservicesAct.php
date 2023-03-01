<?php


#@0.1@#########################
#	ProgXform version 0.9
#	Propel version 1.6
#	Progexpert
#	build_time: 2016-07-05 14:54:54
# 	emplacement : mod/
###############################

    if($request['ot'] != 's')
        $request = $_REQUEST;


    if(_BASE_DIR != '_BASE_DIR'){
        include 'inc/init.php';
    }else{
        include '../inc/init.php';
    }

    include 'gen/WSservicesActBase.php';

    if($request['mode'] == 'html'){
        echo $output['html'];
        echo "
    <script type='text/javascript'>
    $(document).ready(function() {
    ".$output['onReadyJs']."
    });
    </script>";
    }else{
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        $json = json_encode($output);
        if($jsonError = json_last_error()){
            array_walk_recursive($output, function (&$value) {
                $value = htmlentities($value);
            });
            $json = json_encode($output);
        }
        echo $json;
    }
