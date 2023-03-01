<?php


#@0.1@#########################
#	Progexpert
###############################
    if($_SESSION[_AUTH_VAR]->get('connected') !== 'YES' AND $request['a'] != 'auth' AND $request['a'] != 'passReset' AND $request['a'] != 'file'){ security_redirect(false);}
    $CurrentClass= 'Authy';
    
    
    switch($request['a']){
        
            case 'selectBox':
                if($request['who'] AND $request['ctb_name'] and $request['ch_name'] and $request['chp_name']){
                    $ctb_name =json_decode($request['ctb_name']);
                    $e = new AuthyForm();
                    $whos =json_decode($request['who']);
                    $ch_name =json_decode($request['ch_name']);
                    $chp_name =json_decode($request['chp_name']);
                    $ch_desc =json_decode($request['ch_desc']);
                    if($whos){
                        $fw=0;
                        $dataObj = AuthyQuery::create()->findPk($request['i']);
                        if(!$dataObj){ $dataObj = new Authy();}
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
        
    case 'auth':
        $return['message'] = _("Nom d'usager et/ou mot de passe inconnu.");
        $return['error'] = true;
        $return['class'] = 'fail-connect';

        if($_SESSION[_AUTH_VAR]->get('isConnected') == 'YES'){
            $return['username'] = $_SESSION[_AUTH_VAR]->get('username');
            $return['message'] = _("Vous êtes déjà connecté.");
            $return['error'] = true;
            $return['class'] = 'user-connected';
        } else {

            $authyCheck =
                    AuthyQuery::create()
                    ->where(" (( LOWER(username)=LOWER('".trim($request['u'])."') or  LOWER(email)=LOWER('".trim($request['u'])."') ) and (passwd_hash = '".trim($request['p'])."' OR passwd_hash_temp = '".trim($request['p'])."')) ")
                    ->findOne();
            $data_log['Result'] = 'Échec';
            $bruteforce = false;
            $nbMinutes = '1'; if(defined('_BRUTEFORCE_DELAY') and _BRUTEFORCE_DELAY!='' ){ $nbMinutes = _BRUTEFORCE_DELAY; }
            $nbRetry = '5'; if(defined('_BRUTEFORCE_RETRY') and _BRUTEFORCE_RETRY!='' ){ $nbRetry = _BRUTEFORCE_RETRY; }
            $bruteForceCheck = AuthyLogQuery::create()->filterByIp($_SERVER['REMOTE_ADDR'])->filterByResult('Échec')->where('timestamp between \''.strtotime("-".$nbMinutes." minutes").'\' and \''.time()."'")->find();
            $nbFails = count($bruteForceCheck);
            if($nbFails >= $nbRetry) { $bruteforce = true; }

            if($authyCheck && !$bruteforce) {
                $idAuthy = $authyCheck->getIdAuthy();
                if($authyCheck->getDeactivate() == 'Oui') {
                    $return['message'] = _("Votre compte a été désactivé.");
                    $data_log['Result'] = 'Désactivé';
                } else if( strtotime($authyCheck->getExpire()) < strtotime('now') and $authyCheck->getExpire() != null) {
                    $return['message'] = _("Votre compte est expiré.");
                    $data_log['Result'] = 'Compte Expirée';
                } else if( strtotime($authyCheck->getPasswdDate()) < strtotime('-90 days') and !strlen($request['pv']) == 32 and false) {
                    $return['message'] = _("Votre mot de passe à expirée.");
                    $data_log['Result'] = 'Password Expirée';
                    $return['expired'] = true;
                } else if( strtotime($authyCheck->getPasswdDate()) < strtotime('-90 days') and strlen($request['pv']) == 32 and ($request['pv'] == $request['p']) and false) {
                    $return['message'] = _("Les mot de passe doivent être différent.");
                    $data_log['Result'] = 'NO_LOG';
                } else {
                    if(false){
                        if(strlen($request['pv']) == 32 && ($request['pv'] != $request['p']) && strtotime($authyCheck->getPasswdDate()) < strtotime('-90 days')){
                            $authyCheck->setPasswdHash($request['pv']);
                            $authyCheck->setPasswdDate(time());
                            $authyCheck->save();
                            $request['p'] = $request['pv'];
                        }
                    }

                    $e = new AuthyForm();
                    
                    $e->tryLog($request['u'], $request['p'],null, $request['stay']);
                    

                    if($_SESSION[_AUTH_VAR]->get('isConnected') == 'YES'){
                        $data_log['Result'] = 'Réussit';
                        
                        if($_SESSION[_AUTH_VAR]->get('connected') == 'YES' ){
                            $q = new AuthyQuery();
                            $data22 = $q::create()
                                ->setFormatter(ModelCriteria::FORMAT_ARRAY)
                                ->findPk(json_decode($_SESSION[_AUTH_VAR]->get('id')));
                            if($data22['LastPoke'] > (time() - 3*60) and $data22['LastPokeIp'] != $_SERVER['REMOTE_ADDR']  ){
                                session_destroy();
                                $return['msg'] = _("Vous êtes déjà connecté sur un autre ip!");
                                $e->reload();
                                sleep(1);die(json_encode($return));
                            }
                        }
                        $return['username'] = $_SESSION[_AUTH_VAR]->get('username');
                        $return['message'] = "Connexion réussi. Redirection en cours.";
                        $return['error'] = false;
                        $return['class'] = 'success-connect';
                        if($_SESSION['referer']){ $return['referer'] = $_SESSION['referer']; }
                        unset($_SESSION['referer']);
                    } else {
                        $data_log['Result'] = 'Échec';
                    }
                }
            } else {
                if($bruteforce) {
                    $return['message'] = _("Tentative de connexion élevée, connexion désactivé.");
                    $data_log['Result'] = 'Bruteforce';
                } else {
                    $return['message'] = _("Nom d'usager et/ou mot de passe incorrect.");
                    $return['remain_retry'] = $nbRetry-$nbFails;
                }
            }

            
            if($data_log['Result'] != "NO_LOG"){
                $e = new AuthyLogForm();
                $data_log['IdAuthy'] = @$idAuthy;
                $data_log['Ip'] = $_SERVER['REMOTE_ADDR'];
                $data_log['Timestamp'] = time();
                $data_log['Login'] = $request['u'];
                $data_log['Type'] = 'Connexion';
                $e->fromArray($data_log );
                $e->save();
            }
        }


        $return['method'] = 'login';
        echo json_encode($return);
        die();
    break;
    case 'passReset':
        $data_user = AuthyQuery::create()
            ->filterByEmail($request['c'])
            ->findOne();

        if(count($data_user)>0){
            $newTmpPass = createRandomKey(8);
            $data_user->setPasswdHashTemp( md5($newTmpPass) );
            $data_user->save();
        }
        if($data_user && ($data_user->getDeactivate() == 'Non' || $data_user->getDeactivate() == NULL)){
            if(defined('_MAIL_RECOVERY')){
                $mail = MailQuery::create()->joinWithI18n($_SESSION[_AUTH_VAR]->lang)->findPk(_MAIL_RECOVERY);
                if($mail){
                    $title = $mail->getTranslation($lang_sql)->getName();
                    $body = $mail->getTranslation($lang_sql)->getText();
                    $body = str_replace('%%newTmpPass%%',$newTmpPass,$body);
                }
                    
            }else{
                $body =
                '
                    <html>
                        <head>
                            <style type="text/css">
                                @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800); table a:hover { text-decoration: underline !important; } .table tr td phone-fix-top, .table tr td phone-fix-top a { color: #FFF !important; text-decoration: none !important; } .phone-fix, .phone-fix a { color: #2f2f2f !important; text-decoration: none !important; }

                                @media screen and (max-width: 600px) {
                                    .container { width: 100% !important; padding: 0 !important; }
                                    * { text-align: center !important; }
                                    table td{ display: block; width: 100% !important; padding: 20px 0 !important; }
                                }

                                a:hover { text-decoration: underline !important; }
                            </style>
                            <meta name="viewport" content="width=device-width, initial-scale=1">
                        </head>
                        <body>
                            <div>
                                <center>
                                    <div style="background: #0f1013; padding: 0; font-family: \'Roboto\', sans-serif;">
                                        <div class="container" style="width: 680px; margin: 0 auto; padding: 0 20px;">
                                            <table bgcolor="#0f1013" style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding: 20px 0 20px 20px; width: 50%; vertical-align: middle;"><a href="'._SITE_URL.'"><img src="http://lebuilder.com/p/NewSimpleWeb/css/img/logo-progexpert.png" width="165" /></a></td>
                                                        <td style="padding: 20px 20px 20px 0; width: 50%; vertical-align: middle; text-align: right; color: #00a4de; font-size: 20px; text-transform: uppercase; font-weight: 800;">Récupération <span style="display: block;">de mot de passe</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="container" style="width: 600px; margin: 50px auto; text-align: left;">

                                        <p style="font-size: 16px; font-family: \'Open Sans\', sans-serif;">Une demande de mot de passe a été demandé pour cette adresse courriel.</p>

                                        <p style="font-size: 16px; font-family: \'Open Sans\', sans-serif;">Voici votre nouveau mot passe: <strong>'.$newTmpPass.'</strong>.</p>

                                        <p style="font-size: 16px; font-family: \'Open Sans\', sans-serif; dispaly: block; padding-bottom: 40px; border-bottom: 1px solid #000;">Si vous n\'avez pas fait cette demande, veuillez nous contactez à l\'adresse courriel suivante: <a style="text-decoration: none; color: #00a4de;" href="mailto:support@progexpert.com">support@progexpert.com</a>.</p>

                                        <a style="font-size: 16px; font-family: \'Open Sans\', sans-serif; margin: 10px 0 0 0; font-weight: 800; text-decoration: none; color: #00a4de; font-size: 18px;" href="http://www.progexpert.com/">Progexpert - Simplement performant</a>

                                    </div>
                                </center>
                            </div>
                        </body>
                    </html>
                ';
                $title = _("Récupération de mot de passe");
            }
            $from =  "support@progexpert.com";
            if(defined('_FROM') and _FROM !=""){ $from = _FROM;}
            if($body){
                sendHTMLemail($body,$from, $request['c'], $title, _FROM);
                $return['error'] = false;
                $return['message'] = _('Nouveau mot de passe envoyé.');
            }
        }else if ($data_user && $data_user->getDeactivate() == 'Oui') {
            $return['error'] = true;
            $return['message'] = _("Votre compte n'est pas activé.");
        }else {
            $return['error'] = true;
            $return['message'] = _('Aucun compte relié à ce courriel.');
        }

         $return['method'] = 'restore';
        echo json_encode($return);
        die();
    break;
        ##############	##############
        #	Main Object Setter
            case 'save':
                
            case 'saveMe':
        if($request['a'] == 'saveMe')
            $request['d'] .= '&IdAuthy='.$_SESSION[_AUTH_VAR]->get('id').'&idPk='.$_SESSION[_AUTH_VAR]->get('id').'&noRights=y';
            
                $extValidationErr = false;
                parse_str ($request['d'],$data );
                
        if(!$_SESSION[_AUTH_VAR]->get('isRoot')){
            unset($data['IsRoot']);
        }

            
                $edialog = 'editDialog';
                if($request['ui']){ $edialog = $request['ui'];}
                if(@$request['diag'] != 'noclose'){
                    $closeDiag = "$('body').css('cursor', 'auto'); $('#".$edialog."').dialog('close');";
                }else{if($request['ui']){ $closeDiag = "$('body').css('cursor', 'auto');";}$parentContainer = $edialog;}
                
                if($_SESSION[_AUTH_VAR]->get('group')!="Admin"){
                    unset($data['Root']);
                }
            
                
                $data['i'] = urldecode($data['idPk']);
                $data['ip'] = urldecode($request['ip']);
                $data['pc'] = urldecode($request['pc']);
                $pkPresent = json_decode($data['i']);

                unset($_SESSION['CurrentRights']);
                if($request['jet'] == 'id_popup'){ $_SESSION['CurrentRights'][]=$request['pc'].$request['SelectTableName']."SelectBox".$request['SelectChamps'];}
                if($request['jet'] == 'id_popup'){ $_SESSION['CurrentRights'][]=$request['pc'].$request['req']['SelectTableName'];}
                if($request['jet'] != 'id_popup'){ $_SESSION['CurrentRights'][]=$request['pc'].'Authy';}
                if(!empty($pkPresent)){
                    
                    ## Save
                    
                    
                     $e = save_update_Authy($data, $request);
                    
                     
                    
                    
                    
                    
                    if ($e->validate() && !$extValidationErr && !@$error) {
                        
                        $e->save();
                        
                        $data['i'] = json_encode($e->getPrimaryKey());
                        $error = handleOkResponse(" "._('Enregistré à')." <span>".date("H:i:s")."</span>",$request['ui'],'',_('Usagers'));
                        
                        
                    }else{
                        $error = handleValidationError($e, $request['ui'],_('Usagers'), $extValidationErr);
                        $previousData = $data;
                    }
                    
                    
                    
            if(!is_dir(_INSTALL_PATH.'mod/tmp')){mkdir(_INSTALL_PATH.'mod/tmp');}
            $IdPrimaryKey= $e->getPrimaryKey();
            if(is_array($IdPrimaryKey)){
                $IdPrimaryKey= $IdPrimaryKey[0];
            }
            fopen(_INSTALL_PATH.'mod/tmp/'.$IdPrimaryKey.'.authy','w');
        
                    
                }else{
                    ## Create
                    
                    
                    $e = save_create_Authy($data, $request);
                    
                    
                        
                        
                        
                    if ($e->validate() && !$extValidationErr && !@$error) {
                        $e->save();
                        
                        unset($_SESSION['memoire']['onglet']['Authy']['mem']);
                        $returnMem =rmv_var($_SESSION['memoire']['onglet']['Authy']['i'],0,',',false);
                        if($returnMem ){$_SESSION['memoire']['onglet']['Authy']['i']=$returnMem;}
                        if(!$data['ip']){
                               $_SESSION['memoire']['onglet']['Authy']['i'] = set_var($_SESSION['memoire']['onglet']['Authy']['i'],$e->getPrimaryKey(),',',false,true,_onglet_formulaire);

                        }
                        
                        
                        $data['i'] = json_encode($e->getPrimaryKey());
                        
                        
                        if(@$_REQUEST['sa'] != 'qf'){
                            $error = handleOkResponse(" "._('Ajouté à')." <span>".date("H:i:s")."</span>",$request['ui'],'',_('Usagers'));
                        }

                    }else{
                        $error = handleValidationError($e, $request['ui'],_('Usagers'), $extValidationErr);
                        $previousData = $data;
                    }
                    
                    
                    if($request['ui'] == 'tabsContain'){ $request['je'] = 'created';$request['jet'] = 'createReload';}
                    if(!$request['pathEntite']){ $request['pathEntite'] = 'Authy';}
                }
                #	Child Form Return, Ajax update
                ##############	##############
                if(empty($error['error']) && !empty($request['je'])){
                    switch($request['jet']){
                        
                        
                    case 'tr':
                        $request['a'] = 'list';
                        $request['highlight'] .= '['.$data['IdAuthy'].']';
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
                                $e = new AuthyForm();
                                $e->Authy['request'] = $request;
                                $e->Authy['parentId'] = $request['ip'];
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
                $f = new AuthyForm();
                $f->Authy['request'] = $request;
                if(!empty($request['ip'])){$f->Authy['parentId'] = $request['ip'];}
                
                
                if(!empty($pkPresent)){
                    @$output['onReadyJs'] .=  $error['onReadyJs'];
                }else{
                    $tmpReadyJs = $output['onReadyJs'];
                    $previousData['req'] = $request;
                    $output = $f->getEditForm(@$data['i'], @$request['ui'], @$previousData, $error, @$request['je'], @$request['jet']);
                    $siteTitle =$f->siteTitle;
                    $output['onReadyJs'] = $tmpReadyJs.$output['onReadyJs'];
                }
                if(empty($error['error']) and @$_SESSION['memoire']['onglet']['Authy']['ixmemautoc']){
                    $autoc_temp = @$_SESSION['memoire']['onglet']['Authy']['ixmemautoc'];
                    $autoc_temp['i'] = $data['i'];
                    $autoc_temp['pk'] = 'IdAuthy';
                    if($autoc_temp['SelParent']){
                        $SelEntit=$autoc_temp['SelParent'];}else{$SelEntit = $autoc_temp['SelEnt'];
                    }
                    $_SESSION['memoire']['onglet'][$SelEntit]['ixmemautocapp'] = $autoc_temp;
                    $output['onReadyJs'] .= "
                        confirm('".message_label('redirect_autoc_champ')."','document.location=\""._SITE_URL.$SelEntit."/edit/".$autoc_temp['IdTemp']."?Autocapp=1\";');";
                    unset($_SESSION['memoire']['onglet']['Authy']['ixmemautoc']);
                }

        
                    }else{
                        if($error){echo script($error['onReadyJs']);}
                        die();
                    }
                }
                $IdCurrentAuthy = $data['i'];
                
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
                $obj = AuthyQuery::create()->findPk($request['i']);
                
            if($obj->countMailsRelatedByIdModification()){ $error = handleNotOkResponse(_("Cette entrée ne peut être supprimée car elle est présentement utilisée dans")." 'Courriel'. ", '', true,'Usagers'); die( $error['onReadyJs'] ); }
            if($obj->countMailsRelatedByIdCreation()){ $error = handleNotOkResponse(_("Cette entrée ne peut être supprimée car elle est présentement utilisée dans")." 'Courriel'. ", '', true,'Usagers'); die( $error['onReadyJs'] ); }
                
                
                
                $_SESSION['CurrentRights'] = $_SESSION['CurrentParent'].'Authy';
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
                        $request['highlight'] .= '['.$data['IdAuthy'].']';
                    break;
                }
                if($output['onReadyJs'] =='' and $output['html'] =='' ){die();}
            break;
        ##############	##############
        #	Autocompele getter
        case 'autoc':
            
        if($_SESSION[_AUTH_VAR]->get('isConnected') == 'YES' AND $_SESSION[_AUTH_VAR]->get('isRoot') AND $request['t']=='Iarc'){
            if(_MAX_ROW_AUTOC and !$request['maxRows']){$request['maxRows'] = _MAX_ROW_AUTOC;}
            $q = AuthyQuery::create()
                ->filterByUsername("%".$request['Username']."%", Criteria::LIKE)
                ->_or()->filterByUsername("".$request['Username']."%", Criteria::LIKE);
                 $q->select(array('Username','IdAuthy'))
                ->orderBy('Username', 'ASC')
                ->limit($request['maxRows']);

            $pcData =  $q->find();
            $shownColumn[] = array('Username');
            header('Content-type: application/json;charset=UTF-8');
            $return['count'] = $pcData->count();
            $data = $pcData->toArray();
            foreach($data as $row){
                $show='';
                foreach($shownColumn as $column){
                    if($show)
                        $show .= " ";
                    if($column[1] == 'yes')
                        $show .= ${$column[0]}[$row[$column[0]]];
                    else
                        $show .= $row[$column[0]];
                }
                $idItem = array_pop($row);
                $return['data'][] =  array('show' =>$show, 'id'=>$idItem);
            }
            die(json_encode($return));
        }

            die();
        break;
        ##############	##############
        #	Main Object Select Options call
        case 'select':
            $e = new AuthyForm();
            $e->Authy['request'] = $request;
            $e->Authy['parentId'] = $request['ip'];
            $output['html'] = $e->getSelectOptions($request['ip'], $request['sel']);
        break;
        case 'select2':
            $e = new AuthyForm();
            $e->Authy['request'] = $request;
            $e->Authy['parentId'] = $request['ip'];
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
        if($_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."Authy",'w')
            or $_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."Authy",'a')
            or $_SESSION[_AUTH_VAR]->hasRights(@$request['pc']."Authy",'r')
            or ($_SESSION[_AUTH_VAR]->hasRights(@$request['pc'].$request['SelectTableName']."SelectBox".$request['SelectChamps'],'a') and !$request['i'])
            or ($_SESSION[_AUTH_VAR]->hasRights(@$request['pc'].$request['SelectTableName']."SelectBox".$request['SelectChamps'],'w') and $request['i'])
        ){
            $f = new AuthyForm();
            $f->Authy['request'] = $request;
            if(!empty($request['ip'])){$f->Authy['parentId'] = $request['ip'];}
            
            
            if(!empty($request['d']) and is_array($request['d'])){ $relData = $request['d'];}
            $relData['req'] = $request;
            
            
        $output = $f->getEditForm(@$request['i'], @$request['ui'], $relData, '', @$request['je'], @$request['jet']);
        $siteTitle =$f->siteTitle;
    
        }
    }
    if($request['a'] == 'list'){
        if($_SESSION[_AUTH_VAR]->hasRights("Authy",'r')){
            init_list_base($request,$search,'Authy','','','','');
            $e = new AuthyForm();
            $e->Authy['request'] = $request;
            if(!empty($request['ip'])){$e->Authy['parentId'] = $request['ip'];}
            
            $output = $e->getList(@$request['ui'],$request['pg'], json_decode(@$request['ip']), @$pmpoData, @$search);
            $siteTitle =$e->siteTitle;
            if($e->searchOrder){ $_SESSION['memoire']['search']['formOrderAuthy']=$e->searchOrder;}
            if($e->searchMs){ $_SESSION['memoire']['search']['formMsAuthy'] = http_build_query($e->searchMs);}
        }
    }
    
    function save_update_Authy($data, $request=array()){
        $e = new AuthyForm();
        $e->Authy['request'] = $request;
        return $e->save_update_Authy($data);
    }
    function save_create_Authy($data, $request=array()){
        $e = new AuthyForm();
        $e->Authy['request'] = $request;
        return $e->save_create_Authy($data);
    }
    if(file_exists(_BASE_DIR.'inc/ControlBase_after.php') and !$request['Autoc']['SelId'] and $request['a'] != 'select' and $request['a'] != 'quickForm' and $request['jet'] != 'sel' and $request['jet'] != 'id_popup'){ include _BASE_DIR.'inc/ControlBase_after.php';}
