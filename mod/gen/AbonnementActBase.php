<?php


#@0.1@#########################
#	Progexpert
###############################
    if($_SESSION[_AUTH_VAR]->get('connected') !== 'YES' AND $request['a'] != 'auth' AND $request['a'] != 'passReset' AND $request['a'] != 'file'){ security_redirect(false);}
    $CurrentClass= 'Abonnement';
    
    
    switch($request['a']){
        
            case 'selectBox':
                if($request['who'] AND $request['ctb_name'] and $request['ch_name'] and $request['chp_name']){
                    $ctb_name =json_decode($request['ctb_name']);
                    $e = new AbonnementForm();
                    $whos =json_decode($request['who']);
                    $ch_name =json_decode($request['ch_name']);
                    $chp_name =json_decode($request['chp_name']);
                    $ch_desc =json_decode($request['ch_desc']);
                    if($whos){
                        $fw=0;
                        $dataObj = AbonnementQuery::create()->findPk($request['i']);
                        if(!$dataObj){ $dataObj = new Abonnement();}
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
                if($request['jet'] != 'id_popup'){ $_SESSION['CurrentRights'][]=$request['pc'].'Abonnement';}
                if(!empty($pkPresent)){
                    
                    ## Save
                    
                    
                     $e = save_update_Abonnement($data, $request);
                    
                     
                    
                    
                    
                    
                    if ($e->validate() && !$extValidationErr && !@$error) {
                        
                        $e->save();
                        
                        $data['i'] = json_encode($e->getPrimaryKey());
                        $error = handleOkResponse(" "._('Enregistré à')." <span>".date("H:i:s")."</span>",$request['ui'],'',_('Renouvellement'));
                        
                        
                    }else{
                        $error = handleValidationError($e, $request['ui'],_('Renouvellement'), $extValidationErr);
                        $previousData = $data;
                    }
                    
                    
                    
                    
                }else{
                    ## Create
                    
                    
                    $e = save_create_Abonnement($data, $request);
                    
                    
                        
                        
                        
                    if ($e->validate() && !$extValidationErr && !@$error) {
                        $e->save();
                        
                        unset($_SESSION['memoire']['onglet']['Abonnement']['mem']);
                        $returnMem =rmv_var($_SESSION['memoire']['onglet']['Abonnement']['i'],0,',',false);
                        if($returnMem ){$_SESSION['memoire']['onglet']['Abonnement']['i']=$returnMem;}
                        if(!$data['ip']){
                               $_SESSION['memoire']['onglet']['Abonnement']['i'] = set_var($_SESSION['memoire']['onglet']['Abonnement']['i'],$e->getPrimaryKey(),',',false,true,_onglet_formulaire);

                        }
                        
                        
                        $data['i'] = json_encode($e->getPrimaryKey());
                        $data['IdSale'] = json_encode($e->getIdSale());
                        
                        if(@$_REQUEST['sa'] != 'qf'){
                            $error = handleOkResponse(" "._('Ajouté à')." <span>".date("H:i:s")."</span>",$request['ui'],'',_('Renouvellement'));
                        }

                    }else{
                        $error = handleValidationError($e, $request['ui'],_('Renouvellement'), $extValidationErr);
                        $previousData = $data;
                    }
                    
                    
                    if($request['ui'] == 'tabsContain'){ $request['je'] = 'created';$request['jet'] = 'createReload';}
                    if(!$request['pathEntite']){ $request['pathEntite'] = 'Abonnement';}
                }
                #	Child Form Return, Ajax update
                ##############	##############
                if(empty($error['error']) && !empty($request['je'])){
                    switch($request['jet']){
                        
                    case 'tr':
                        /*What! $data exists meme pas ...*//* sa dois dependre tu dois le setter dans le act surment une patch pour TZ*/
                        if(!$data['IdSale'] && !$request['ip'] or ($request['je'] =='AbonnementTable' and !$request['ip']) ){
                            $output['onReadyJs'] .= "$('#formMsAbonnement #msAbonnementBt').click();".$closeDiag."";
                        }else{
                            $output['onReadyJs'] .= "$('.child_pannel [p=\"Abonnement\"]').click();".$closeDiag."";
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
                                $e = new AbonnementForm();
                                $e->Abonnement['request'] = $request;
                                $e->Abonnement['parentId'] = $request['ip'];
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
                $f = new AbonnementForm();
                $f->Abonnement['request'] = $request;
                if(!empty($request['ip'])){$f->Abonnement['parentId'] = $request['ip'];}
                
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
                if(empty($error['error']) and @$_SESSION['memoire']['onglet']['Abonnement']['ixmemautoc']){
                    $autoc_temp = @$_SESSION['memoire']['onglet']['Abonnement']['ixmemautoc'];
                    $autoc_temp['i'] = $data['i'];
                    $autoc_temp['pk'] = 'IdAbonnement';
                    if($autoc_temp['SelParent']){
                        $SelEntit=$autoc_temp['SelParent'];}else{$SelEntit = $autoc_temp['SelEnt'];
                    }
                    $_SESSION['memoire']['onglet'][$SelEntit]['ixmemautocapp'] = $autoc_temp;
                    $output['onReadyJs'] .= "
                        confirm('".message_label('redirect_autoc_champ')."','document.location=\""._SITE_URL.$SelEntit."/edit/".$autoc_temp['IdTemp']."?Autocapp=1\";');";
                    unset($_SESSION['memoire']['onglet']['Abonnement']['ixmemautoc']);
                }

        
                    }else{
                        if($error){echo script($error['onReadyJs']);}
                        die();
                    }
                }
                $IdCurrentAbonnement = $data['i'];
                
                $output['onReadyJs'] .= "$('body').css('cursor', 'auto');";
                $output['onReadyJs'] =  preg_replace ("/\s+/", " ",trim($output['onReadyJs']));
                $output['js'] = preg_replace ("/\s+/", " ",trim(@$output['js']));
                $output['html'] = preg_replace ("/\s+/", " ",trim(@$output['html']));
            break;
            ##############	##############
            #	supression
            case 'delete':
                if($request['pc']){ $_SESSION['CurrentParent'] = $request['pc'];}
                
                $obj = AbonnementQuery::create()->findPk($request['i']);
                
                
                
                
                $_SESSION['CurrentRights'] = $_SESSION['CurrentParent'].'Abonnement';
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
                        if(!$data['IdSale'] && !$request['ip'] or ($request['je'] =='AbonnementTable' and !$request['ip']) ){
                            $output['onReadyJs'] .= "$('#formMsAbonnement #msAbonnementBt').click();".$closeDiag."";
                        }else{
                            $output['onReadyJs'] .= "$('.child_pannel [p=\"Abonnement\"]').click();".$closeDiag."";
                        }
                    break;
                    
                }
                if($output['onReadyJs'] =='' and $output['html'] =='' ){die();}
            break;
        ##############	##############
        #	Main Object Select Options call
        case 'select':
            $e = new AbonnementForm();
            $e->Abonnement['request'] = $request;
            $e->Abonnement['parentId'] = $request['ip'];
            $output['html'] = $e->getSelectOptions($request['ip'], $request['sel']);
        break;
        case 'select2':
            $e = new AbonnementForm();
            $e->Abonnement['request'] = $request;
            $e->Abonnement['parentId'] = $request['ip'];
            $json = $e->getSelectJson($request['ip'], $request['sel']);
            header('Content-Type: application/json');
            die($json);
        break;
        $listChild=false;
        
        case 'getSaleTaxeList':
            if($_SESSION[_AUTH_VAR]->hasRights("AbonnementSaleTaxe",'r')){
                $listChild=true;

                $_SESSION['memoire']['onglet']['Abonnement']['child']['list'][$request['ip']]= 'SaleTaxe';
                if(!empty($request['ip'])){$IdCurrentAbonnement = $request['ip'];}
                $IdSplit=""; 
                if(isset($request['ms']) and $request['ms'] == 'clear'){
                    $request['ms'] = '';$request['order'] = '';
                    unset($_SESSION['memoire']['search']['formMsAbonnementSaleTaxe'.$IdSplit]);
                    unset($_SESSION['memoire']['search']['formOrderAbonnementSaleTaxe']);
                    unset($_SESSION['memoire']['onglet']['AbonnementSaleTaxe']['pg']);
                    
                }
                if(!empty($request['order'])){
                    $search['order'] = json_decode($request['order'], true);
                    $_SESSION['memoire']['search']['formOrderAbonnementSaleTaxe'][$search['order']['col']] = $search['order']['sens'];
                    $search['order']= $_SESSION['memoire']['search']['formOrderAbonnementSaleTaxe'];
                }else if(!empty($_SESSION['memoire']['search']['formOrderAbonnementSaleTaxe'])){
                    $search['order']=$_SESSION['memoire']['search']['formOrderAbonnementSaleTaxe'];
                }
                if(!empty($request['ms'])){
                    parse_str($request['ms'], $search['ms']);
                    if($_SESSION['memoire']['search']['formMsAbonnementSaleTaxe'.$IdSplit] != $request['ms']){
                        unset($_SESSION['memoire']['onglet']['AbonnementSaleTaxe']['pg']);
                    }
                    $_SESSION['memoire']['search']['formMsAbonnementSaleTaxe'.$IdSplit] = $request['ms'];
                }else if(!empty($_SESSION['memoire']['search']['formMsAbonnementSaleTaxe'.$IdSplit])){
                    parse_str($_SESSION['memoire']['search']['formMsAbonnementSaleTaxe'.$IdSplit], $search['ms']);
                }
                if(!empty($request['pg'])){ $_SESSION['memoire']['onglet']['AbonnementSaleTaxe']['pg'] = $request['pg'];}
                
                $f = new AbonnementForm();
                $f->SaleTaxe['request'] = $request;
                if(!empty($request['ip'])){
                    $f->SaleTaxe['parentId'] = $request['ip'];
                    $data['IdAbonnement'] = $request['ip'];
                }
                
                if(!empty($request['noHeader'])){$params['noHeader'] = $request['noHeader'];}
                $_SESSION['CurrentParent'] = 'Abonnement';
                $childTableData = $f->getSaleTaxeList(@$request['ip'],$request['pg'], @$request['ui'], @$request['pui'], true, @$search, @$params);
                
                unset($_SESSION['CurrentParent']);
                @$output['html'] .= div(@$f->CcSaleTaxeTopList.$childTableData['html'].@$f->CcSaleTaxeBottomList, 'SaleTaxeTableCntnr','class="child-wrapper"');
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
        if($_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."Abonnement",'w')
            or $_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."Abonnement",'a')
            or $_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."Abonnement",'r')
            or ($_SESSION[_AUTH_VAR]->hasRights(@$request['pc'].$request['SelectTableName']."SelectBox".$request['SelectChamps'],'a') and !$request['i'])
            or ($_SESSION[_AUTH_VAR]->hasRights(@$request['pc'].$request['SelectTableName']."SelectBox".$request['SelectChamps'],'w') and $request['i'])
        ){
            $f = new AbonnementForm();
            $f->Abonnement['request'] = $request;
            if(!empty($request['ip'])){$f->Abonnement['parentId'] = $request['ip'];}
            
            if(!empty($request['ip'])){
                $relData['IdSale'] = $request['ip'];
                /* pour savoir qu'elle est l'ip dans l'action ajouter */
                $relData['ip'] = json_decode($request['ip']);
                $relData['pc'] = $request['pc'];
            }
            
            if(!empty($request['d']) and is_array($request['d'])){ $relData = $request['d'];}
            $relData['req'] = $request;
            if(function_exists('beforeForm')){beforeForm($f,$request,$output, $relData);}
            
        $output = $f->getEditForm(@$request['i'], @$request['ui'], $relData, '', @$request['je'], @$request['jet']);
        $siteTitle =$f->siteTitle;
    
        }
    }
    if($request['a'] == 'list'){
        if($_SESSION[_AUTH_VAR]->hasRights("Abonnement",'r')){
            init_list_base($request,$search,'Abonnement','','','','');
            $e = new AbonnementForm();
            $e->Abonnement['request'] = $request;
            if(!empty($request['ip'])){$e->Abonnement['parentId'] = $request['ip'];}
            
            $output = $e->getList(@$request['ui'],$request['pg'], json_decode(@$request['ip']), @$pmpoData, @$search);
            $siteTitle =$e->siteTitle;
            if($e->searchOrder){ $_SESSION['memoire']['search']['formOrderAbonnement']=$e->searchOrder;}
            if($e->searchMs){ $_SESSION['memoire']['search']['formMsAbonnement'] = http_build_query($e->searchMs);}
        }
    }
    
    function save_update_Abonnement($data, $request=array()){
        $e = new AbonnementForm();
        $e->Abonnement['request'] = $request;
        return $e->save_update_Abonnement($data);
    }
    function save_create_Abonnement($data, $request=array()){
        $e = new AbonnementForm();
        $e->Abonnement['request'] = $request;
        return $e->save_create_Abonnement($data);
    }
    if(file_exists(_BASE_DIR.'inc/ControlBase_after.php') and !$request['Autoc']['SelId'] and $request['a'] != 'select' and $request['a'] != 'quickForm' and $request['jet'] != 'sel' and $request['jet'] != 'id_popup'){ include _BASE_DIR.'inc/ControlBase_after.php';}
