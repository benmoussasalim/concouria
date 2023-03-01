<?php


#@0.1@#########################
#	Progexpert
###############################
    if($_SESSION[_AUTH_VAR]->get('connected') !== 'YES' AND $request['a'] != 'auth' AND $request['a'] != 'passReset' AND $request['a'] != 'file'){ security_redirect(false);}
    $CurrentClass= 'ContentFile';
    
    
    switch($request['a']){
        
            case 'selectBox':
                if($request['who'] AND $request['ctb_name'] and $request['ch_name'] and $request['chp_name']){
                    $ctb_name =json_decode($request['ctb_name']);
                    $e = new ContentFileForm();
                    $whos =json_decode($request['who']);
                    $ch_name =json_decode($request['ch_name']);
                    $chp_name =json_decode($request['chp_name']);
                    $ch_desc =json_decode($request['ch_desc']);
                    if($whos){
                        $fw=0;
                        $dataObj = ContentFileQuery::create()->findPk($request['i']);
                        if(!$dataObj){ $dataObj = new ContentFile();}
                        foreach($whos as $who){
                            $func ="selectBox".$who;
                            $query = $e->$func($dataObj,$data,false,false);
                            if($chp_name[$fw]){
                                $filter ="filterBy".$chp_name[$fw];
                                if($request['ip']){$query->$filter($request['ip']);}
                            }
                            $pcDataO =$query->find();
                            $array = assocToNum($pcDataO->toArray() , true);
                            $return[$ch_name[$fw]]= selectboxCustomArray($ch_name[$fw],$array,$ch_desc[$fw], " v='".strtoupper(unCamelize($ch_name[$fw]))."' s='d' otherTabs=1  val='".$request['i_'.$fw]."'",$request['i_'.$fw]);
                            $fw++;
                        }
                    }echo json_encode($return);
                }die();
            break;
        
        case 'ForceDl':
            if($_SESSION[_AUTH_VAR]->hasRights('ContentFile','r')
            || $_SESSION[_AUTH_VAR]->hasRights($request['pc']."ContentFile",'r')
            ){
                $dataObj= ContentFileQuery::create()->findPk($request['i']);
                if($dataObj and is_file(_INSTALL_PATH.$dataObj->getFichier())){
                    /*$user_agent = getenv('HTTP_USER_AGENT');
                    if($_SESSION['token'] and strpos($user_agent, 'Mac') !== FALSE){
                        header('Location: '._SITE_URL.$dataObj->getFichier());
                    }else */
                    if($_SESSION['token']){
                        header('Content-Description: File Transfer');
                        header('Content-Type: '.mime_content_type(_INSTALL_PATH.$dataObj->getFichier()));
                        header('Content-Disposition: attachment; filename="'.str_replace('#','',basename($dataObj->getName())).'"');
                        header('Content-Transfer-Encoding: binary');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize(_INSTALL_PATH.$dataObj->getFichier()));
                        //ob_clean();
                        //flush();
                        readfile(_INSTALL_PATH.$dataObj->getFichier());
                    
                    }else{
                        header('Content-Type:'.mime_content_type(_INSTALL_PATH.$dataObj->getFichier()));
                        header('Content-Disposition: attachment; filename="'.str_replace('#','',basename($dataObj->getName())).'"');
                        readfile(_INSTALL_PATH.$dataObj->getFichier());
                    }
                }
            }die();
        break;
        case 'file':
        if(!is_array($_FILES["file"]["tmp_name"])){ $files[] = $_FILES["file"];
        }else{
           $f=0;
            while($f < count($_FILES["file"]["tmp_name"]) and $f <30){
                if($_FILES["file"]["name"][$f]){
                    $files[] =
array('name'=>$_FILES["file"]["name"][$f],'size'=>$_FILES["file"]["size"][$f],'type'=>$_FILES["file"]["type"][$f],'tmp_name'=>$_FILES["file"]["tmp_name"][$f],'error'=>$_FILES["file"]["error"][$f]);
                }
               $f++;
           }
        }

        if(count($files)>0){
            foreach($files as $fileArr){
                if (!isset($fileArr["name"]) || !is_file($fileArr["tmp_name"]) || $fileArr["error"] != 0) {
                    exit(0);
                }else{

                    $poids= round($fileArr["size"] / 1024, 2);
                    $tab_style = getimagesize($fileArr['tmp_name']);
                    $path_info = pathinfo($fileArr['name']);
                    $path_info["extension"] = strtolower($path_info["extension"]);
                    if( $path_info["extension"] ){
                        if(count($_GET)==0){ $data = $request; }else{ $data = $_GET;}

                        $data['IdCreation'] = $_REQUEST['IdUser'];
                        $data['IdModification'] = $_REQUEST['IdUser'];
                        $data['Name'] = $fileArr['name'];
                        $data['Size'] = $poids;
                        $data['Height'] =$tab_style[1];
                        $data['Width'] = $tab_style[0];
                        $data['Ext'] = $path_info["extension"];
                        $tabIp = explode(',',$data['ip']);
                        if($tabIp){
                            foreach(array_unique($tabIp) as $ip){
                                $e = save_create_ContentFile($data, $request);
                                $e->setIdContent($ip);
                                $path_rep_fichier = 'mod/file/';
                                $path_fichier = 'mod/file/ContentFile/';
                                
                                if(@$data['error'] == ''){
                                    if($_GET['blob']==1){
                                        /* si on le mets dans la db dans un champs blob */
                                        $data['Blob'] = file_get_contents($fileArr['tmp_name']);
                                        $e->fromArray($data);
                                        $e->save();
                                    }else{
                                        /* si on garde les fichiers*/
                                        if(!is_dir(_INSTALL_PATH.$path_rep_fichier)){
                                            mkdir(_INSTALL_PATH.$path_rep_fichier);
                                            $fp = fopen(_INSTALL_PATH."mod/file/index.php","w");
                                            fwrite($fp, '<?php header(\'Location:'._SITE_URL.'\'); ');
                                            fclose($fp);
                                        }
                                        if(!is_dir(_INSTALL_PATH.$path_fichier)){
                                            mkdir(_INSTALL_PATH.$path_fichier);
                                            $fp = fopen(_INSTALL_PATH.$path_fichier."/index.php","w");
                                            fwrite($fp, '<?php header(\'Location:'._SITE_URL.'\'); ');
                                            fclose($fp);
                                        }

                                        /* rights*/
                                        unset($_SESSION['CurrentRights']);
                                        if($request['jet'] == 'id_popup'){ $_SESSION['CurrentRights'][]=$request['pc'].$request['SelectTableName']."SelectBox".$request['SelectChamps'];}
                                        if($request['jet'] == 'id_popup'){ $_SESSION['CurrentRights'][]=$request['pc'].$request['req']['SelectTableName'];}
                                        if($request['jet'] != 'id_popup'){ $_SESSION['CurrentRights'][]=$request['pc'].'ContentFile';}
                                        $e->fromArray($data);
                                        if ($e->validate()){
                                            $e->save();
                                            $data['idPk'] = $e->getPrimaryKey();
                                            copy($fileArr['tmp_name'], _INSTALL_PATH.$path_fichier.md5($data['idPk']).".".$path_info["extension"]."");
                                            $data['Fichier'] = $path_fichier.md5($data['idPk']).".".$path_info["extension"];
                                            
                                            $e->fromArray($data);
                                            $e->save();
                                            
                                            
                                            
                                        }
                                    }
                                }
                            }
                            if(is_file($fileArr['tmp_name'])){
                                unlink($fileArr['tmp_name']);
                            }
                        }
                        
                    }
                }
            }
            header('Content-Type: application/json');
            die( json_encode( $data) );
        }
        break;
        ##############	##############
        #	Main Object Setter
            case 'save':
                
                $extValidationErr = false;
                parse_str ($request['d'],$data );
                
                $edialog = 'editDialog';
                if($request['ui']){ $edialog = $request['ui'];}
                if(@$request['diag'] != 'noclose'){
                    $closeDiag = "$('body').css('cursor', 'auto'); $('#".$edialog."').dialog('close');";
                }else{if($request['ui']){ $closeDiag = "$('body').css('cursor', 'auto');";}$parentContainer = $edialog;}
                
                
                $data['i'] = urldecode($data['idPk']);
                $data['ip'] = urldecode($request['ip']);
                $data['pc'] = urldecode($request['pc']);
                $pkPresent = json_decode($data['i']);

                unset($_SESSION['CurrentRights']);
                if($request['jet'] == 'id_popup'){ $_SESSION['CurrentRights'][]=$request['pc'].$request['SelectTableName']."SelectBox".$request['SelectChamps'];}
                if($request['jet'] == 'id_popup'){ $_SESSION['CurrentRights'][]=$request['pc'].$request['req']['SelectTableName'];}
                if($request['jet'] != 'id_popup'){ $_SESSION['CurrentRights'][]=$request['pc'].'ContentFile';}
                if(!empty($pkPresent)){
                    
                    ## Save
                    
                    
                     $e = save_update_ContentFile($data, $request);
                    
                     
                    
                    
                    
                    
                    if ($e->validate() && !$extValidationErr && !@$error) {
                        
                        $e->save();
                        
                        $data['i'] = json_encode($e->getPrimaryKey());
                        $error = handleOkResponse(" "._('Enregistré à')." <span>".date("H:i:s")."</span>",$request['ui'],'',_('Upload d\'images'));
                        
                        
                    }else{
                        $error = handleValidationError($e, $request['ui'],_('Upload d\'images'), $extValidationErr);
                        $previousData = $data;
                    }
                    
                    
                    
                    
                }else{
                    ## Create
                    
                    
                    $e = save_create_ContentFile($data, $request);
                    
                    
                        
                        
                        
                    if ($e->validate() && !$extValidationErr && !@$error) {
                        $e->save();
                        
                        unset($_SESSION['memoire']['onglet']['ContentFile']['mem']);
                        $returnMem =rmv_var($_SESSION['memoire']['onglet']['ContentFile']['i'],0,',',false);
                        if($returnMem ){$_SESSION['memoire']['onglet']['ContentFile']['i']=$returnMem;}
                        if(!$data['ip']){
                               $_SESSION['memoire']['onglet']['ContentFile']['i'] = set_var($_SESSION['memoire']['onglet']['ContentFile']['i'],$e->getPrimaryKey(),',',false,true,_onglet_formulaire);

                        }
                        
                        
                        $data['i'] = json_encode($e->getPrimaryKey());
                        $data['IdContent'] = json_encode($e->getIdContent());
                        
                        if(@$_REQUEST['sa'] != 'qf'){
                            $error = handleOkResponse(" "._('Ajouté à')." <span>".date("H:i:s")."</span>",$request['ui'],'',_('Upload d\'images'));
                        }

                    }else{
                        $error = handleValidationError($e, $request['ui'],_('Upload d\'images'), $extValidationErr);
                        $previousData = $data;
                    }
                    
                    
                    if($request['ui'] == 'tabsContain'){ $request['je'] = 'created';$request['jet'] = 'createReload';}
                    if(!$request['pathEntite']){ $request['pathEntite'] = 'ContentFile';}
                }
                #	Child Form Return, Ajax update
                ##############	##############
                if(empty($error['error']) && !empty($request['je'])){
                    switch($request['jet']){
                        
                    case 'tr':
                        /*What! $data exists meme pas ...*//* sa dois dependre tu dois le setter dans le act surment une patch pour TZ*/
                        if(!$data['IdContent'] && !$request['ip'] or ($request['je'] =='ContentFileTable' and !$request['ip']) ){
                            $output['onReadyJs'] .= "$('#formMsContentFile #msContentFileBt').click();".$closeDiag."";
                        }else{
                            $output['onReadyJs'] .= "$('.child_pannel [p=\"ContentFile\"]').click();".$closeDiag."";
                        }
                    break;
                        
                        case 'id_popup':
                        case 'sel':
                            $selectHtml = '';
                            if($request['jet'] == 'id_popup'){
                                $tex = explode(':editPopup:',$request['je']);
                                $request['je'] = $tex[0];
                                if($tex[1]){
                                    $tex = explode(',',$tex[1]);
                                    foreach($tex as $dtext){if(!$str_input){$str_input = $data[$dtext];}else{$str_input .= ' '.$data[$dtext];}}
                                    if($str_input){ $selectHtml= ' $("'.$request['je'].'Autoc").focus(); $("'.$request['je'].'Autoc").val("'.$str_input.'");';}
                                }
                            }
                            if(!$selectHtml){
                                $e = new ContentFileForm();
                                $e->ContentFile['request'] = $request;
                                $e->ContentFile['parentId'] = $request['ip'];
                                $rOption = optionListeSelect($e->getSelectOptions($request['ip'], $e->getPrimaryKey(),true),$data['i']);
                                $selectHtml ="
                                    if($('".$request['je']."').parent('label.js-select-label').length > 0){
                                        li = $('".$request['je']."').parent('label.js-select-label').find('ul li[data-value=".$data['i']."]');
                                        if(li){
                                           $('".$request['je']."').parent('label.js-select-label').find('ul li[data-value=".$data['i']."]').remove();
                                        }
                                        $('".$request['je']."').parent('label.js-select-label')
                                            .children('ul').html('".addslashes($rOption['optionsList'])."');
                                        $('".$request['je']."').parent('label.js-select-label').children('span').removeClass('gray');

                                    }
                                ";
                            }
                            $output['onReadyJs'] .= "
                                $('body').css('cursor','auto');
                                ".$selectHtml."
                                if('".$data['i']."'){
                                     $('".$request['je']."').parent('label.js-select-label').removeClass('gray');
                                }
                                $('".$request['je']."').val('".$data['i']."');
                                $('".$request['je']."').change(); "
                                .$closeDiag;
                        break;
                        case 'id': echo $data['i'];die();break;
                        case 'rSEC': die();
                        break;
                        case 'createReload':echo script("window.location.href = '"._SITE_URL.$request['pathEntite']."/edit/".$data['i']."?crt'");die();break;
                        case 'costumAct':if(!empty($request['je'])){echo script(" eval('".addslashes($request['je'])."'); ");}die();break;
                        case 'autoc':
                                $output['onReadyJs'] .= "
    $('#".$request['je']."').val('".$data['i']."');
    ".$closeDiag."
    setTimeout(function (){ $('#".$request['je']."').trigger('change'); }, 200);
                                ";
                        break;
                        case 'close':$output['onReadyJs'] .= " $('body').css('cursor', 'auto'); $('#".$edialog."').dialog('close');";break;
                    }
                }else{
                    if(@$_REQUEST['sa'] != 'qf'){
                        
                unset($e);
                if(is_array(@$previousData))
                        $previousData['locale'] = $locale;
                $f = new ContentFileForm();
                $f->ContentFile['request'] = $request;
                if(!empty($request['ip'])){$f->ContentFile['parentId'] = $request['ip'];}
                
                
                if(!empty($pkPresent)){
                    @$output['onReadyJs'] .=  $error['onReadyJs'];
                }else{
                    $tmpReadyJs = $output['onReadyJs'];
                    $previousData['req'] = $request;
                    $output = $f->getEditForm(@$data['i'], @$request['ui'], @$previousData, $error, @$request['je'], @$request['jet']);
                    $siteTitle =$f->siteTitle;
                    $output['onReadyJs'] = $tmpReadyJs.$output['onReadyJs'];
                }
                if(empty($error['error']) and @$_SESSION['memoire']['onglet']['ContentFile']['ixmemautoc']){
                    $autoc_temp = @$_SESSION['memoire']['onglet']['ContentFile']['ixmemautoc'];
                    $autoc_temp['i'] = $data['i'];
                    $autoc_temp['pk'] = 'IdContentFile';
                    if($autoc_temp['SelParent']){
                        $SelEntit=$autoc_temp['SelParent'];}else{$SelEntit = $autoc_temp['SelEnt'];
                    }
                    $_SESSION['memoire']['onglet'][$SelEntit]['ixmemautocapp'] = $autoc_temp;
                    $output['onReadyJs'] .= "
                        confirm('".message_label('redirect_autoc_champ')."','document.location=\""._SITE_URL.$SelEntit."/edit/".$autoc_temp['IdTemp']."?Autocapp=1\";');";
                    unset($_SESSION['memoire']['onglet']['ContentFile']['ixmemautoc']);
                }

        
                    }else{
                        if($error){echo script($error['onReadyJs']);}
                        die();
                    }
                }
                $IdCurrentContentFile = $data['i'];
                
            $q = ContentFileQuery::create()->filterByIdContentFile($IdCurrentContentFile)->setFormatter(ModelCriteria::FORMAT_ARRAY)->findOne();

            @$output['onReadyJs'] .= "
                $('#formContentFile .divtr.readonly .divtd[in=\"inSize\"] label.readonly').text('".addslashes($q['Size'])."');
                $('#formContentFile #Size').val('".addslashes($q['Size'])."');
                $('#formContentFile .divtr.readonly .divtd[in=\"inName\"] label.readonly').text('".addslashes($q['Name'])."');
                $('#formContentFile #Name').val('".addslashes($q['Name'])."');
            ";
                $output['onReadyJs'] .= "$('body').css('cursor', 'auto');";
                $output['onReadyJs'] =  preg_replace ("/\s+/", " ",trim($output['onReadyJs']));
                $output['js'] = preg_replace ("/\s+/", " ",trim(@$output['js']));
                $output['html'] = preg_replace ("/\s+/", " ",trim(@$output['html']));
            break;
            ##############	##############
            #	supression
            case 'delete':
                if($request['pc']){ $_SESSION['CurrentParent'] = $request['pc'];}
                
                $obj = ContentFileQuery::create()->findPk($request['i']);
                
                
                
                
        if(is_file(_INSTALL_PATH.$obj->getFichier())){
            unlink(_INSTALL_PATH.$obj->getFichier());
        }
                $_SESSION['CurrentRights'] = $_SESSION['CurrentParent'].'ContentFile';
                if(!$obj->delete()){
                    $error = handleValidationError($obj, $request['ui'],_('Code'),NULL);
                    die(script($error['onReadyJs']));
                }
                unset($_SESSION['CurrentParent']);
                unset($_SESSION['CurrentRights']);
                
                
                
                
                if(@$request['diag'] != 'noclose'){$closeDiag = "$('body').css('cursor', 'auto'); $('#editDialog').dialog('close');";
                }else{$parentContainer = "editDialog";}
                switch($request['jet']){
                    
                    case 'tr':
                        /*What! $data exists meme pas ...*//* sa dois dependre tu dois le setter dans le act surment une patch pour TZ*/
                        if(!$data['IdContent'] && !$request['ip'] or ($request['je'] =='ContentFileTable' and !$request['ip']) ){
                            $output['onReadyJs'] .= "$('#formMsContentFile #msContentFileBt').click();".$closeDiag."";
                        }else{
                            $output['onReadyJs'] .= "$('.child_pannel [p=\"ContentFile\"]').click();".$closeDiag."";
                        }
                    break;
                    
                }
                if($output['onReadyJs'] =='' and $output['html'] =='' ){die();}
            break;
        ##############	##############
        #	Main Object Select Options call
        case 'select':
            $e = new ContentFileForm();
            $e->ContentFile['request'] = $request;
            $e->ContentFile['parentId'] = $request['ip'];
            $output['html'] = $e->getSelectOptions($request['ip'], $request['sel']);
        break;
        case 'select2':
            $e = new ContentFileForm();
            $e->ContentFile['request'] = $request;
            $e->ContentFile['parentId'] = $request['ip'];
            $json = $e->getSelectJson($request['ip'], $request['sel']);
            header('Content-Type: application/json');
            die($json);
        break;
        $listChild=false;
        
        
        
    }
    if($request['a'] == 'edit'){
        ##############	##############
        #	Main Object Form call
        #		include child list
        #	$request['d'] : data to insert for new object
        #
        if($_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."ContentFile",'w')
            or $_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."ContentFile",'a')
            or $_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."ContentFile",'r')
            or ($_SESSION[_AUTH_VAR]->hasRights(@$request['pc'].$request['SelectTableName']."SelectBox".$request['SelectChamps'],'a') and !$request['i'])
            or ($_SESSION[_AUTH_VAR]->hasRights(@$request['pc'].$request['SelectTableName']."SelectBox".$request['SelectChamps'],'w') and $request['i'])
        ){
            $f = new ContentFileForm();
            $f->ContentFile['request'] = $request;
            if(!empty($request['ip'])){$f->ContentFile['parentId'] = $request['ip'];}
            
            if(!empty($request['ip'])){
                $relData['IdContent'] = $request['ip'];
                /* pour savoir qu'elle est l'ip dans l'action ajouter */
                $relData['ip'] = json_decode($request['ip']);
                $relData['pc'] = $request['pc'];
            }
            
            if(!empty($request['d']) and is_array($request['d'])){ $relData = $request['d'];}
            $relData['req'] = $request;
            
            
        $output = $f->getEditForm(@$request['i'], @$request['ui'], $relData, '', @$request['je'], @$request['jet']);
        $siteTitle =$f->siteTitle;
    
        }
    }
    if($request['a'] == 'list'){
        if($_SESSION[_AUTH_VAR]->hasRights("ContentFile",'r')){
            init_list_base($request,$search,'ContentFile','','','','');
            $e = new ContentFileForm();
            $e->ContentFile['request'] = $request;
            if(!empty($request['ip'])){$e->ContentFile['parentId'] = $request['ip'];}
            
            $output = $e->getList(@$request['ui'],$request['pg'], json_decode(@$request['ip']), @$pmpoData, @$search);
            $siteTitle =$e->siteTitle;
            if($e->searchOrder){ $_SESSION['memoire']['search']['formOrderContentFile']=$e->searchOrder;}
            if($e->searchMs){ $_SESSION['memoire']['search']['formMsContentFile'] = http_build_query($e->searchMs);}
        }
    }
    
    function save_update_ContentFile($data, $request=array()){
        $e = new ContentFileForm();
        $e->ContentFile['request'] = $request;
        return $e->save_update_ContentFile($data);
    }
    function save_create_ContentFile($data, $request=array()){
        $e = new ContentFileForm();
        $e->ContentFile['request'] = $request;
        return $e->save_create_ContentFile($data);
    }
    if(file_exists(_BASE_DIR.'inc/ControlBase_after.php') and !$request['Autoc']['SelId'] and $request['a'] != 'select' and $request['a'] != 'quickForm' and $request['jet'] != 'sel' and $request['jet'] != 'id_popup'){ include _BASE_DIR.'inc/ControlBase_after.php';}
