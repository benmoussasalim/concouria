<?php


#@0.1@#########################
#	Progexpert
###############################
    if($_SESSION[_AUTH_VAR]->get('connected') !== 'YES' AND $request['a'] != 'auth' AND $request['a'] != 'passReset' AND $request['a'] != 'file'){ security_redirect(false);}
    $CurrentClass= 'Label';
    
    
    switch($request['a']){
        
                case 'next':
                    parse_str($_SESSION['memoire']['search']['formMsLabel'], $search['ms']);
                    $search['order'] =$_SESSION['memoire']['search']['formOrderLabel'];
                    $conn = Propel::getConnection(_DATA_SRC);
                    $stmt = $conn->prepare("SET @curRow=0;")->execute();
                    $f = new LabelForm();
                    $f->searchMs=$search['ms'];
                    $f->searchOrder=$search['order'];
                    $q = $f->getListSearch($data['ip'], $search);
                    $q->select(array('IdLabel','RowNumber'));
                    $postab = LabelQuery::create()
                        ->select(array('RowNumber','Label.IdLabel'))
                        ->withColumn('@curRow := @curRow + 1', 'RowNumber')
                        ->addSelectQuery($q,'Label')
                        ->find();
                    $Labels = $postab->getArrayCopy('Label.IdLabel');
                    if($Labels[$request['i']]){$pos=$Labels[$request['i']]['RowNumber'];}
                    if($pos){
                        $stmt = $conn->prepare("SET @curRow=0;")->execute();
                        $tab = LabelQuery::create()
                            ->addSelectQuery($q,'Label')
                            ->withColumn('@curRow := @curRow + 1', 'RowNumber')
                            ->select(array('IdLabel'))
                            ->where(' (@curRow := @curRow + 1) ="'.($pos+1).'" ')->findOne();
                        die($tab['IdLabel']);
                    }else{
                        die();
                    }
                break;
                case 'previous':
                    parse_str($_SESSION['memoire']['search']['formMsLabel'], $search['ms']);
                    $search['order']=$_SESSION['memoire']['search']['formOrderLabel'];
                    $conn = Propel::getConnection(_DATA_SRC);
                    $stmt = $conn->prepare("SET @curRow=0;")->execute();
                    $f = new LabelForm();
                    $f->searchMs=$search['ms'];
                    $f->searchOrder=$search['order'];
                    $q = $f->getListSearch($data['ip'], $search);
                    $q->withColumn('@curRow := @curRow + 1', 'RowNumber');
                    $q->select(array('IdLabel','RowNumber'));
                    $postab = LabelQuery::create()
                        ->select(array('RowNumber','Label.IdLabel'))
                        ->withColumn('@curRow := @curRow + 1', 'RowNumber')
                        ->addSelectQuery($q,'Label')
                        ->find();
                    $Labels = $postab->getArrayCopy('Label.IdLabel');
                    if($Labels[$request['i']]){$pos=$Labels[$request['i']]['RowNumber'];}
                    if($pos){
                        $stmt = $conn->prepare("SET @curRow=0;")->execute();
                        $tab = LabelQuery::create()
                            ->addSelectQuery($q,'Label')
                            ->withColumn('@curRow := @curRow + 1', 'RowNumber')
                            ->select(array('IdLabel'))
                            ->where(' (@curRow := @curRow + 1) ="'.($pos-1).'" ')->findOne();
                        die($tab['IdLabel']);
                    }else{
                        die();
                    }
                break;
                
            case 'selectBox':
                if($request['who'] AND $request['ctb_name'] and $request['ch_name'] and $request['chp_name']){
                    $ctb_name =json_decode($request['ctb_name']);
                    $e = new LabelForm();
                    $whos =json_decode($request['who']);
                    $ch_name =json_decode($request['ch_name']);
                    $chp_name =json_decode($request['chp_name']);
                    $ch_desc =json_decode($request['ch_desc']);
                    if($whos){
                        $fw=0;
                        $dataObj = LabelQuery::create()->findPk($request['i']);
                        if(!$dataObj){ $dataObj = new Label();}
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
                if($request['jet'] != 'id_popup'){ $_SESSION['CurrentRights'][]=$request['pc'].'Label';}
                if(!empty($pkPresent)){
                    
                    ## Save
                    
                    
                     $e = save_update_Label($data, $request);
                    
                     
                    
                    
                    
                    
                    if ($e->validate() && !$extValidationErr && !@$error) {
                        
                        $e->save();
                        
                        try{
                            $e->setLocale('fr_CA');
                            if(isset($data['LabelI18n_Text_frCA'])){$e->setText($data['LabelI18n_Text_frCA']);}
                            $e->save();
                        }catch (Exception $f){
                            $mt = new LabelI18n();
                            $mt->setLocale('fr_CA');
                            
                            if(isset($data['LabelI18n_Text_frCA'])){$mt->setText($data['LabelI18n_Text_frCA']);}
                            $e->addLabelI18n($mt);$e->save();
                        }
                    
                        try{
                            $e->setLocale('en_US');
                            if(isset($data['LabelI18n_Text_enUS'])){$e->setText($data['LabelI18n_Text_enUS']);}
                            $e->save();
                        }catch (Exception $f){
                            $mt = new LabelI18n();
                            $mt->setLocale('en_US');
                            
                            if(isset($data['LabelI18n_Text_enUS'])){$mt->setText($data['LabelI18n_Text_enUS']);}
                            $e->addLabelI18n($mt);$e->save();
                        }
                    
                        $data['i'] = json_encode($e->getPrimaryKey());
                        $error = handleOkResponse(" "._('Enregistré à')." <span>".date("H:i:s")."</span>",$request['ui'],'',_('Label'));
                        
                        
                    }else{
                        $error = handleValidationError($e, $request['ui'],_('Label'), $extValidationErr);
                        $previousData = $data;
                    }
                    
                    
                    
                    
                }else{
                    ## Create
                    
                    
                    $e = save_create_Label($data, $request);
                    
                    
                        
                        
                        
                    $e->setLocale('fr_CA');$e->setText($data['LabelI18n_Text_frCA']);
                    $e->setLocale('en_US');$e->setText($data['LabelI18n_Text_enUS']);
                    if ($e->validate() && !$extValidationErr && !@$error) {
                        $e->save();
                        
                        unset($_SESSION['memoire']['onglet']['Label']['mem']);
                        $returnMem =rmv_var($_SESSION['memoire']['onglet']['Label']['i'],0,',',false);
                        if($returnMem ){$_SESSION['memoire']['onglet']['Label']['i']=$returnMem;}
                        if(!$data['ip']){
                               $_SESSION['memoire']['onglet']['Label']['i'] = set_var($_SESSION['memoire']['onglet']['Label']['i'],$e->getPrimaryKey(),',',false,true,_onglet_formulaire);

                        }
                        
                        
                        $data['i'] = json_encode($e->getPrimaryKey());
                        
                        
                        if(@$_REQUEST['sa'] != 'qf'){
                            $error = handleOkResponse(" "._('Ajouté à')." <span>".date("H:i:s")."</span>",$request['ui'],'',_('Label'));
                        }

                    }else{
                        $error = handleValidationError($e, $request['ui'],_('Label'), $extValidationErr);
                        $previousData = $data;
                    }
                    
                    
                    if($request['ui'] == 'tabsContain'){ $request['je'] = 'created';$request['jet'] = 'createReload';}
                    if(!$request['pathEntite']){ $request['pathEntite'] = 'Label';}
                }
                #	Child Form Return, Ajax update
                ##############	##############
                if(empty($error['error']) && !empty($request['je'])){
                    switch($request['jet']){
                        
                        
                    case 'tr':
                        $request['a'] = 'list';
                        $request['highlight'] .= '['.$data['IdLabel'].']';
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
                                $e = new LabelForm();
                                $e->Label['request'] = $request;
                                $e->Label['parentId'] = $request['ip'];
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
                $f = new LabelForm();
                $f->Label['request'] = $request;
                if(!empty($request['ip'])){$f->Label['parentId'] = $request['ip'];}
                
                if(function_exists('beforeForm')){beforeForm($f,$data,$output,$previousData);}
                if(!empty($pkPresent)){
                    @$output['onReadyJs'] .=  $error['onReadyJs'];
                }else{
                    $tmpReadyJs = $output['onReadyJs'];
                    $previousData['req'] = $request;
                    $output = $f->getEditForm(@$data['i'], @$request['ui'], @$previousData, $error, @$request['je'], @$request['jet']);
                    $siteTitle =$f->siteTitle;
                    $output['onReadyJs'] = $tmpReadyJs.$output['onReadyJs'];
                }
                if(empty($error['error']) and @$_SESSION['memoire']['onglet']['Label']['ixmemautoc']){
                    $autoc_temp = @$_SESSION['memoire']['onglet']['Label']['ixmemautoc'];
                    $autoc_temp['i'] = $data['i'];
                    $autoc_temp['pk'] = 'IdLabel';
                    if($autoc_temp['SelParent']){
                        $SelEntit=$autoc_temp['SelParent'];}else{$SelEntit = $autoc_temp['SelEnt'];
                    }
                    $_SESSION['memoire']['onglet'][$SelEntit]['ixmemautocapp'] = $autoc_temp;
                    $output['onReadyJs'] .= "
                        confirm('".message_label('redirect_autoc_champ')."','document.location=\""._SITE_URL.$SelEntit."/edit/".$autoc_temp['IdTemp']."?Autocapp=1\";');";
                    unset($_SESSION['memoire']['onglet']['Label']['ixmemautoc']);
                }

        
                    }else{
                        if($error){echo script($error['onReadyJs']);}
                        die();
                    }
                }
                $IdCurrentLabel = $data['i'];
                
            $q = LabelQuery::create()->filterByIdLabel($IdCurrentLabel)->setFormatter(ModelCriteria::FORMAT_ARRAY)->findOne();

            @$output['onReadyJs'] .= "
                $('#formLabel .divtr.readonly .divtd[in=\"inLabelText\"] label.readonly').text('".addslashes($q['LabelText'])."');
                $('#formLabel #LabelText').val('".addslashes($q['LabelText'])."');
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
                $request['ot'] = 's';
                $obj = LabelQuery::create()->findPk($request['i']);
                
                
                
                
                $_SESSION['CurrentRights'] = $_SESSION['CurrentParent'].'Label';
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
                        $request['a'] = 'list';
                        $request['highlight'] .= '['.$data['IdLabel'].']';
                    break;
                }
                if($output['onReadyJs'] =='' and $output['html'] =='' ){die();}
            break;
        ##############	##############
        #	Main Object Select Options call
        case 'select':
            $e = new LabelForm();
            $e->Label['request'] = $request;
            $e->Label['parentId'] = $request['ip'];
            $output['html'] = $e->getSelectOptions($request['ip'], $request['sel']);
        break;
        case 'select2':
            $e = new LabelForm();
            $e->Label['request'] = $request;
            $e->Label['parentId'] = $request['ip'];
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
        if($_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."Label",'w')
            or $_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."Label",'a')
            or $_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."Label",'r')
            or ($_SESSION[_AUTH_VAR]->hasRights(@$request['pc'].$request['SelectTableName']."SelectBox".$request['SelectChamps'],'a') and !$request['i'])
            or ($_SESSION[_AUTH_VAR]->hasRights(@$request['pc'].$request['SelectTableName']."SelectBox".$request['SelectChamps'],'w') and $request['i'])
        ){
            $f = new LabelForm();
            $f->Label['request'] = $request;
            if(!empty($request['ip'])){$f->Label['parentId'] = $request['ip'];}
            
            
            if(!empty($request['d']) and is_array($request['d'])){ $relData = $request['d'];}
            $relData['req'] = $request;
            if(function_exists('beforeForm')){beforeForm($f,$request,$output, $relData);}
            
        $output = $f->getEditForm(@$request['i'], @$request['ui'], $relData, '', @$request['je'], @$request['jet']);
        $siteTitle =$f->siteTitle;
    
        }
    }
    if($request['a'] == 'list'){
        if($_SESSION[_AUTH_VAR]->hasRights("Label",'r')){
            init_list_base($request,$search,'Label','','','','');
            $e = new LabelForm();
            $e->Label['request'] = $request;
            if(!empty($request['ip'])){$e->Label['parentId'] = $request['ip'];}
            if(function_exists('beforeList')){beforeList($e, $request, $search, $pmpoData);}
            $output = $e->getList(@$request['ui'],$request['pg'], json_decode(@$request['ip']), @$pmpoData, @$search);
            $siteTitle =$e->siteTitle;
            if($e->searchOrder){ $_SESSION['memoire']['search']['formOrderLabel']=$e->searchOrder;}
            if($e->searchMs){ $_SESSION['memoire']['search']['formMsLabel'] = http_build_query($e->searchMs);}
        }
    }
    
    function save_update_Label($data, $request=array()){
        $e = new LabelForm();
        $e->Label['request'] = $request;
        return $e->save_update_Label($data);
    }
    function save_create_Label($data, $request=array()){
        $e = new LabelForm();
        $e->Label['request'] = $request;
        return $e->save_create_Label($data);
    }
    if(file_exists(_BASE_DIR.'inc/ControlBase_after.php') and !$request['Autoc']['SelId'] and $request['a'] != 'select' and $request['a'] != 'quickForm' and $request['jet'] != 'sel' and $request['jet'] != 'id_popup'){ include _BASE_DIR.'inc/ControlBase_after.php';}
