<?php


#@0.1@#########################
#	Progexpert
###############################
    if($_SESSION[_AUTH_VAR]->get('connected') !== 'YES' AND $request['a'] != 'auth' AND $request['a'] != 'passReset' AND $request['a'] != 'file'){ security_redirect(false);}
    $CurrentClass= 'Content';
    
    
    switch($request['a']){
        
            case 'selectBox':
                if($request['who'] AND $request['ctb_name'] and $request['ch_name'] and $request['chp_name']){
                    $ctb_name =json_decode($request['ctb_name']);
                    $e = new ContentForm();
                    $whos =json_decode($request['who']);
                    $ch_name =json_decode($request['ch_name']);
                    $chp_name =json_decode($request['chp_name']);
                    $ch_desc =json_decode($request['ch_desc']);
                    if($whos){
                        $fw=0;
                        $dataObj = ContentQuery::create()->findPk($request['i']);
                        if(!$dataObj){ $dataObj = new Content();}
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
                if($request['jet'] != 'id_popup'){ $_SESSION['CurrentRights'][]=$request['pc'].'Content';}
                if(!empty($pkPresent)){
                    
                    ## Save
                    
                    beforeSave($e, $data, false, $output, $extValidationErr);
                     $e = save_update_Content($data, $request);
                    
                     
                    
                    
                    
                    
                    if ($e->validate() && !$extValidationErr && !@$error) {
                        
                        $e->save();
                        
                        try{
                            $e->setLocale('fr_CA');
                            if(isset($data['ContentI18n_Name_frCA'])){$e->setName($data['ContentI18n_Name_frCA']);}
                            if(isset($data['ContentI18n_Text_frCA'])){$e->setText($data['ContentI18n_Text_frCA']);}
                            if(isset($data['ContentI18n_MetaKeyword_frCA'])){$e->setMetaKeyword($data['ContentI18n_MetaKeyword_frCA']);}
                            if(isset($data['ContentI18n_MetaDescription_frCA'])){$e->setMetaDescription($data['ContentI18n_MetaDescription_frCA']);}
                            if(isset($data['ContentI18n_MetaTitle_frCA'])){$e->setMetaTitle($data['ContentI18n_MetaTitle_frCA']);}
                            if(isset($data['ContentI18n_Version_frCA'])){$e->setVersion($data['ContentI18n_Version_frCA']);}
                            $e->save();
                        }catch (Exception $f){
                            $mt = new ContentI18n();
                            $mt->setLocale('fr_CA');
                            
                            if(isset($data['ContentI18n_Name_frCA'])){$mt->setName($data['ContentI18n_Name_frCA']);}
                            if(isset($data['ContentI18n_Text_frCA'])){$mt->setText($data['ContentI18n_Text_frCA']);}
                            if(isset($data['ContentI18n_MetaKeyword_frCA'])){$mt->setMetaKeyword($data['ContentI18n_MetaKeyword_frCA']);}
                            if(isset($data['ContentI18n_MetaDescription_frCA'])){$mt->setMetaDescription($data['ContentI18n_MetaDescription_frCA']);}
                            if(isset($data['ContentI18n_MetaTitle_frCA'])){$mt->setMetaTitle($data['ContentI18n_MetaTitle_frCA']);}
                            if(isset($data['ContentI18n_Version_frCA'])){$mt->setVersion($data['ContentI18n_Version_frCA']);}
                            $e->addContentI18n($mt);$e->save();
                        }
                    
                        try{
                            $e->setLocale('en_US');
                            if(isset($data['ContentI18n_Name_enUS'])){$e->setName($data['ContentI18n_Name_enUS']);}
                            if(isset($data['ContentI18n_Text_enUS'])){$e->setText($data['ContentI18n_Text_enUS']);}
                            if(isset($data['ContentI18n_MetaKeyword_enUS'])){$e->setMetaKeyword($data['ContentI18n_MetaKeyword_enUS']);}
                            if(isset($data['ContentI18n_MetaDescription_enUS'])){$e->setMetaDescription($data['ContentI18n_MetaDescription_enUS']);}
                            if(isset($data['ContentI18n_MetaTitle_enUS'])){$e->setMetaTitle($data['ContentI18n_MetaTitle_enUS']);}
                            if(isset($data['ContentI18n_Version_enUS'])){$e->setVersion($data['ContentI18n_Version_enUS']);}
                            $e->save();
                        }catch (Exception $f){
                            $mt = new ContentI18n();
                            $mt->setLocale('en_US');
                            
                            if(isset($data['ContentI18n_Name_enUS'])){$mt->setName($data['ContentI18n_Name_enUS']);}
                            if(isset($data['ContentI18n_Text_enUS'])){$mt->setText($data['ContentI18n_Text_enUS']);}
                            if(isset($data['ContentI18n_MetaKeyword_enUS'])){$mt->setMetaKeyword($data['ContentI18n_MetaKeyword_enUS']);}
                            if(isset($data['ContentI18n_MetaDescription_enUS'])){$mt->setMetaDescription($data['ContentI18n_MetaDescription_enUS']);}
                            if(isset($data['ContentI18n_MetaTitle_enUS'])){$mt->setMetaTitle($data['ContentI18n_MetaTitle_enUS']);}
                            if(isset($data['ContentI18n_Version_enUS'])){$mt->setVersion($data['ContentI18n_Version_enUS']);}
                            $e->addContentI18n($mt);$e->save();
                        }
                    
                        $data['i'] = json_encode($e->getPrimaryKey());
                        $error = handleOkResponse(" "._('Enregistré à')." <span>".date("H:i:s")."</span>",$request['ui'],'',_('Contenu'));
                        
                        
                    }else{
                        $error = handleValidationError($e, $request['ui'],_('Contenu'), $extValidationErr);
                        $previousData = $data;
                    }
                    
                    
                    
                    
                }else{
                    ## Create
                    
                    beforeSave($e, $data, true, $output, $extValidationErr);
                    $e = save_create_Content($data, $request);
                    
                    
                        
                        
                        
                    $e->setLocale('fr_CA');$e->setName($data['ContentI18n_Name_frCA']);
                    $e->setLocale('fr_CA');$e->setText($data['ContentI18n_Text_frCA']);
                    $e->setLocale('fr_CA');$e->setMetaKeyword($data['ContentI18n_MetaKeyword_frCA']);
                    $e->setLocale('fr_CA');$e->setMetaDescription($data['ContentI18n_MetaDescription_frCA']);
                    $e->setLocale('fr_CA');$e->setMetaTitle($data['ContentI18n_MetaTitle_frCA']);
                    $e->setLocale('fr_CA');$e->setVersion($data['ContentI18n_Version_frCA']);
                    $e->setLocale('en_US');$e->setName($data['ContentI18n_Name_enUS']);
                    $e->setLocale('en_US');$e->setText($data['ContentI18n_Text_enUS']);
                    $e->setLocale('en_US');$e->setMetaKeyword($data['ContentI18n_MetaKeyword_enUS']);
                    $e->setLocale('en_US');$e->setMetaDescription($data['ContentI18n_MetaDescription_enUS']);
                    $e->setLocale('en_US');$e->setMetaTitle($data['ContentI18n_MetaTitle_enUS']);
                    $e->setLocale('en_US');$e->setVersion($data['ContentI18n_Version_enUS']);
                    if ($e->validate() && !$extValidationErr && !@$error) {
                        $e->save();
                        
                        unset($_SESSION['memoire']['onglet']['Content']['mem']);
                        $returnMem =rmv_var($_SESSION['memoire']['onglet']['Content']['i'],0,',',false);
                        if($returnMem ){$_SESSION['memoire']['onglet']['Content']['i']=$returnMem;}
                        if(!$data['ip']){
                               $_SESSION['memoire']['onglet']['Content']['i'] = set_var($_SESSION['memoire']['onglet']['Content']['i'],$e->getPrimaryKey(),',',false,true,_onglet_formulaire);

                        }
                        
                        
                        $data['i'] = json_encode($e->getPrimaryKey());
                        
                        
                        if(@$_REQUEST['sa'] != 'qf'){
                            $error = handleOkResponse(" "._('Ajouté à')." <span>".date("H:i:s")."</span>",$request['ui'],'',_('Contenu'));
                        }

                    }else{
                        $error = handleValidationError($e, $request['ui'],_('Contenu'), $extValidationErr);
                        $previousData = $data;
                    }
                    
                    
                    if($request['ui'] == 'tabsContain'){ $request['je'] = 'created';$request['jet'] = 'createReload';}
                    if(!$request['pathEntite']){ $request['pathEntite'] = 'Content';}
                }
                #	Child Form Return, Ajax update
                ##############	##############
                if(empty($error['error']) && !empty($request['je'])){
                    switch($request['jet']){
                        
                        
                    case 'tr':
                        $request['a'] = 'list';
                        $request['highlight'] .= '['.$data['IdContent'].']';
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
                                $e = new ContentForm();
                                $e->Content['request'] = $request;
                                $e->Content['parentId'] = $request['ip'];
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
                $f = new ContentForm();
                $f->Content['request'] = $request;
                if(!empty($request['ip'])){$f->Content['parentId'] = $request['ip'];}
                
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
                if(empty($error['error']) and @$_SESSION['memoire']['onglet']['Content']['ixmemautoc']){
                    $autoc_temp = @$_SESSION['memoire']['onglet']['Content']['ixmemautoc'];
                    $autoc_temp['i'] = $data['i'];
                    $autoc_temp['pk'] = 'IdContent';
                    if($autoc_temp['SelParent']){
                        $SelEntit=$autoc_temp['SelParent'];}else{$SelEntit = $autoc_temp['SelEnt'];
                    }
                    $_SESSION['memoire']['onglet'][$SelEntit]['ixmemautocapp'] = $autoc_temp;
                    $output['onReadyJs'] .= "
                        confirm('".message_label('redirect_autoc_champ')."','document.location=\""._SITE_URL.$SelEntit."/edit/".$autoc_temp['IdTemp']."?Autocapp=1\";');";
                    unset($_SESSION['memoire']['onglet']['Content']['ixmemautoc']);
                }

        
                    }else{
                        if($error){echo script($error['onReadyJs']);}
                        die();
                    }
                }
                $IdCurrentContent = $data['i'];
                
            $q = ContentQuery::create()->filterByIdContent($IdCurrentContent)->setFormatter(ModelCriteria::FORMAT_ARRAY)->findOne();

            @$output['onReadyJs'] .= "
                $('#formContent .divtr.readonly .divtd[in=\"inSlug\"] label.readonly').text('".addslashes($q['Slug'])."');
                $('#formContent #Slug').val('".addslashes($q['Slug'])."');
                $('#formContent .divtr.readonly .divtd[in=\"inStatus\"] label.readonly').text('".addslashes($q['Status'])."');
                $('#formContent #Status').val('".addslashes($q['Status'])."');
                $('#formContent .divtr.readonly .divtd[in=\"inIdContent\"] label.readonly').text('".addslashes($q['IdContent'])."');
                $('#formContent #IdContent').val('".addslashes($q['IdContent'])."');
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
                $obj = ContentQuery::create()->findPk($request['i']);
                
                
                
                
                $_SESSION['CurrentRights'] = $_SESSION['CurrentParent'].'Content';
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
                        $request['highlight'] .= '['.$data['IdContent'].']';
                    break;
                }
                if($output['onReadyJs'] =='' and $output['html'] =='' ){die();}
            break;
        ##############	##############
        #	Main Object Select Options call
        case 'select':
            $e = new ContentForm();
            $e->Content['request'] = $request;
            $e->Content['parentId'] = $request['ip'];
            $output['html'] = $e->getSelectOptions($request['ip'], $request['sel']);
        break;
        case 'select2':
            $e = new ContentForm();
            $e->Content['request'] = $request;
            $e->Content['parentId'] = $request['ip'];
            $json = $e->getSelectJson($request['ip'], $request['sel']);
            header('Content-Type: application/json');
            die($json);
        break;
        $listChild=false;
        
        case 'getContentFileList':
            if($_SESSION[_AUTH_VAR]->hasRights("ContentContentFile",'r')){
                $listChild=true;

                $_SESSION['memoire']['onglet']['Content']['child']['list'][$request['ip']]= 'ContentFile';
                if(!empty($request['ip'])){$IdCurrentContent = $request['ip'];}
                $IdSplit=""; 
                if(isset($request['ms']) and $request['ms'] == 'clear'){
                    $request['ms'] = '';$request['order'] = '';
                    unset($_SESSION['memoire']['search']['formMsContentContentFile'.$IdSplit]);
                    unset($_SESSION['memoire']['search']['formOrderContentContentFile']);
                    unset($_SESSION['memoire']['onglet']['ContentContentFile']['pg']);
                    
                }
                if(!empty($request['order'])){
                    $search['order'] = json_decode($request['order'], true);
                    $_SESSION['memoire']['search']['formOrderContentContentFile'][$search['order']['col']] = $search['order']['sens'];
                    $search['order']= $_SESSION['memoire']['search']['formOrderContentContentFile'];
                }else if(!empty($_SESSION['memoire']['search']['formOrderContentContentFile'])){
                    $search['order']=$_SESSION['memoire']['search']['formOrderContentContentFile'];
                }
                if(!empty($request['ms'])){
                    parse_str($request['ms'], $search['ms']);
                    if($_SESSION['memoire']['search']['formMsContentContentFile'.$IdSplit] != $request['ms']){
                        unset($_SESSION['memoire']['onglet']['ContentContentFile']['pg']);
                    }
                    $_SESSION['memoire']['search']['formMsContentContentFile'.$IdSplit] = $request['ms'];
                }else if(!empty($_SESSION['memoire']['search']['formMsContentContentFile'.$IdSplit])){
                    parse_str($_SESSION['memoire']['search']['formMsContentContentFile'.$IdSplit], $search['ms']);
                }
                if(!empty($request['pg'])){ $_SESSION['memoire']['onglet']['ContentContentFile']['pg'] = $request['pg'];}
                
                $f = new ContentForm();
                $f->ContentFile['request'] = $request;
                if(!empty($request['ip'])){
                    $f->ContentFile['parentId'] = $request['ip'];
                    $data['IdContent'] = $request['ip'];
                }
                
                if(!empty($request['noHeader'])){$params['noHeader'] = $request['noHeader'];}
                $_SESSION['CurrentParent'] = 'Content';
                $childTableData = $f->getContentFileList(@$request['ip'],$request['pg'], @$request['ui'], @$request['pui'], true, @$search, @$params);
                
                unset($_SESSION['CurrentParent']);
                @$output['html'] .= div(@$f->CcContentFileTopList.$childTableData['html'].@$f->CcContentFileBottomList, 'ContentFileTableCntnr','class="child-wrapper"');
                if(empty($request['js']) || $request['js'] != 'none'){
                    @$output['onReadyJs'] .=$childTableData['onReadyJs'];
                    @$output['js'] .= $childTableData['js'];
                }
            }
        break;

        case 'getBlockList':
            if($_SESSION[_AUTH_VAR]->hasRights("ContentBlock",'r')){
                $listChild=true;

                $_SESSION['memoire']['onglet']['Content']['child']['list'][$request['ip']]= 'Block';
                if(!empty($request['ip'])){$IdCurrentContent = $request['ip'];}
                $IdSplit=""; 
                if(isset($request['ms']) and $request['ms'] == 'clear'){
                    $request['ms'] = '';$request['order'] = '';
                    unset($_SESSION['memoire']['search']['formMsContentBlock'.$IdSplit]);
                    unset($_SESSION['memoire']['search']['formOrderContentBlock']);
                    unset($_SESSION['memoire']['onglet']['ContentBlock']['pg']);
                    
                }
                if(!empty($request['order'])){
                    $search['order'] = json_decode($request['order'], true);
                    $_SESSION['memoire']['search']['formOrderContentBlock'][$search['order']['col']] = $search['order']['sens'];
                    $search['order']= $_SESSION['memoire']['search']['formOrderContentBlock'];
                }else if(!empty($_SESSION['memoire']['search']['formOrderContentBlock'])){
                    $search['order']=$_SESSION['memoire']['search']['formOrderContentBlock'];
                }
                if(!empty($request['ms'])){
                    parse_str($request['ms'], $search['ms']);
                    if($_SESSION['memoire']['search']['formMsContentBlock'.$IdSplit] != $request['ms']){
                        unset($_SESSION['memoire']['onglet']['ContentBlock']['pg']);
                    }
                    $_SESSION['memoire']['search']['formMsContentBlock'.$IdSplit] = $request['ms'];
                }else if(!empty($_SESSION['memoire']['search']['formMsContentBlock'.$IdSplit])){
                    parse_str($_SESSION['memoire']['search']['formMsContentBlock'.$IdSplit], $search['ms']);
                }
                if(!empty($request['pg'])){ $_SESSION['memoire']['onglet']['ContentBlock']['pg'] = $request['pg'];}
                
                $f = new ContentForm();
                $f->Block['request'] = $request;
                if(!empty($request['ip'])){
                    $f->Block['parentId'] = $request['ip'];
                    $data['IdContent'] = $request['ip'];
                }
                
                if(!empty($request['noHeader'])){$params['noHeader'] = $request['noHeader'];}
                $_SESSION['CurrentParent'] = 'Content';
                $childTableData = $f->getBlockList(@$request['ip'],$request['pg'], @$request['ui'], @$request['pui'], true, @$search, @$params);
                
                unset($_SESSION['CurrentParent']);
                @$output['html'] .= div(@$f->CcBlockTopList.$childTableData['html'].@$f->CcBlockBottomList, 'BlockTableCntnr','class="child-wrapper"');
                if(empty($request['js']) || $request['js'] != 'none'){
                    @$output['onReadyJs'] .=$childTableData['onReadyJs'];
                    @$output['js'] .= $childTableData['js'];
                }
            }
        break;

        
        
    }
    if($request['a'] == 'edit'){
        ##############	##############
        #	Main Object Form call
        #		include child list
        #	$request['d'] : data to insert for new object
        #
        if($_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."Content",'w')
            or $_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."Content",'a')
            or $_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."Content",'r')
            or ($_SESSION[_AUTH_VAR]->hasRights(@$request['pc'].$request['SelectTableName']."SelectBox".$request['SelectChamps'],'a') and !$request['i'])
            or ($_SESSION[_AUTH_VAR]->hasRights(@$request['pc'].$request['SelectTableName']."SelectBox".$request['SelectChamps'],'w') and $request['i'])
        ){
            $f = new ContentForm();
            $f->Content['request'] = $request;
            if(!empty($request['ip'])){$f->Content['parentId'] = $request['ip'];}
            
            
            if(!empty($request['d']) and is_array($request['d'])){ $relData = $request['d'];}
            $relData['req'] = $request;
            if(function_exists('beforeForm')){beforeForm($f,$request,$output, $relData);}
            
        $output = $f->getEditForm(@$request['i'], @$request['ui'], $relData, '', @$request['je'], @$request['jet']);
        $siteTitle =$f->siteTitle;
    
        }
    }
    if($request['a'] == 'list'){
        if($_SESSION[_AUTH_VAR]->hasRights("Content",'r')){
            init_list_base($request,$search,'Content','','','','');
            $e = new ContentForm();
            $e->Content['request'] = $request;
            if(!empty($request['ip'])){$e->Content['parentId'] = $request['ip'];}
            
            $output = $e->getList(@$request['ui'],$request['pg'], json_decode(@$request['ip']), @$pmpoData, @$search);
            $siteTitle =$e->siteTitle;
            if($e->searchOrder){ $_SESSION['memoire']['search']['formOrderContent']=$e->searchOrder;}
            if($e->searchMs){ $_SESSION['memoire']['search']['formMsContent'] = http_build_query($e->searchMs);}
        }
    }
    
    function save_update_Content($data, $request=array()){
        $e = new ContentForm();
        $e->Content['request'] = $request;
        return $e->save_update_Content($data);
    }
    function save_create_Content($data, $request=array()){
        $e = new ContentForm();
        $e->Content['request'] = $request;
        return $e->save_create_Content($data);
    }
    if(file_exists(_BASE_DIR.'inc/ControlBase_after.php') and !$request['Autoc']['SelId'] and $request['a'] != 'select' and $request['a'] != 'quickForm' and $request['jet'] != 'sel' and $request['jet'] != 'id_popup'){ include _BASE_DIR.'inc/ControlBase_after.php';}
