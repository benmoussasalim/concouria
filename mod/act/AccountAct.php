<?php


#@0.1@#########################
#	ProgXform version 0.9
#	Propel version 1.6
#	Progexpert
#	build_time: 2016-07-15 08:02:22
###############################

    if($request['ot'] != 's')
        $request = $_REQUEST;


    if(_BASE_DIR != '_BASE_DIR'){
        include 'inc/init.php';
    }else{
        include '../../inc/init.php';
    }

    
    if(!$_SESSION[_AUTH_VAR]->isConnected()){
        security_redirect(true);
    }

    #@custom##############
    #		reset $request['a'] after new case
    switch($request['a']) {
        case 'confirmSubscription':
            $return['message'] = _("Erreur lors de l'envoi.");
            $return['error'] = true;
            $return['class'] = 'error';
            
            $account = AccountQuery::create()->findPk($request['i']);
            
            $mail = MailQuery::create()->findPk(8);
            if($mail AND $account) {
                $lang_sql = 'fr_CA';
                
                $title = $mail->getTranslation($lang_sql)->getTitle();
                $body = $mail->getTranslation($lang_sql)->getText();
                
                $body = str_replace('%%lien_website%%',_SITE_URL_HTTP,$body);
                
                $body = str_replace('%%Firstname%%',$account->getFirstname(),$body);
                $body = str_replace('%%Lastname%%',$account->getLastname(),$body);
                $body = str_replace('%%DateExpire%%',$account->getDateExpire(),$body);
                $body = str_replace('%%SubscribeLink%%',_SITE_URL_HTTP.'formulaire/'.md5(_PROJECT_NAME.$account->getIdAccount()),$body);
                
                sendHTMLemail($body,_FROM,$request['email'],$title);
                
                $return['message'] = _("Rappel envoyé avec succès.");
                $return['error'] = false;
                $return['class'] = 'success';
            }
            
            echo json_encode($return);
            die();
        break;
    }

    
    $printJs = loadJs(_SRC_URL."js/jquery/jquery-1.7.1.min.js");
    $printCss = loadCss(_SITE_URL."css/print.css");

    
    include 'AccountActBase.php';

    if(file_exists(_BASE_DIR.'mod/act/actOuput.php'))
        include _BASE_DIR.'mod/act/actOuput.php';
    function eventHook($event, &$obj='', &$request, &$output){}
    
    function beforeForm(&$obj, &$data, &$output, &$dataset){
        if($data['i']) {
            $account = AccountQuery::create()->findPk($data['i']);
            if($account) {
                $obj->CcPrintLinkDiv .= htmlLink(_('Envoyer renouvellement de l\'abonnement'),'javascript:',"class='js-subscription'");
                
                $confirmSubscription =
                    div(
                        div(
                            div(
                                label(_("Confirmer le courriel"),'for="email"')
                                .div(
                                    input('text','email',$account->getEmail(),'placeholder="'.addslashes(_("Courriel")).'"')
                                ,'','class="divtd"')
                            ,'','class="divtr"')
                            
                            .div(
                                div(
                                    input('button','ConfirmEmail',_("Confirmer"),'class="button-link-blue can-save"')
                                ,'','class="divtd"')
                            ,'','class="divtr divbut"')
                        ,'','class="divStdform"')
                    ,'','class="mainForm"')
                ;
                
                $obj->CcToFormJs .= "
                    $('.js-subscription').off('click');
                    $('.js-subscription').on('click',function() {
                        $('#editDialog').html('".addslashes($confirmSubscription)."');
                        beforeOpenDialog('editDialog');
                        return false;
                    });
                    
                    $('body').on('click','#ConfirmEmail',function() {
                        var email = $('#editDialog #email').val();

                        if(!email) {
                            sw_message('".addslashes(_("Veuillez entrer un courriel"))."',true,'error');
                        } else {
                            $.post(_SITE_URL + 'mod/act/AccountAct.php', { a: 'confirmSubscription', email: $('#editDialog #email').val(), i: ".$data['i']." },function(data) {
                                if(data.error == false) { $('#editDialog').dialog('close'); }
                                sw_message(data.message,data.error,data.class);
                            },'json');
                        }

                        return false;
                    });
                ";
            }
        }
    }
    
    function beforeList(&$obj, &$data, &$search, &$pcol){
		$obj->CcToListTop .= style("
			table.tablesorter tbody tr td { background: #fff7b2 !important; border-color: #FFF !important; }
			table.tablesorter tbody tr.green td {background: #e0f7c4 !important;}
			table.tablesorter tbody tr.red td {background: #ffb2b2 !important;}
		
		");
        
        $today = date('Y-m-d');
        $obj->CcToListJs .= "
            var today = new Date('".$today."').getTime();

            $('#AccountTable tr td[c=\"ExportReady\"] .ac-list-td-content:contains(\"Non \")').parents('tr').addClass('red');
            
            $('#AccountTable tr td[c=\"ExportReady\"] .ac-list-td-content:contains(\"Oui \")').each(function() {
                var parent = $(this).parents('tr');
                var account_expire = new Date(parent.find('td[c=\"DateExpire\"] .ac-list-td-content').text()).getTime();
                var class_name = 'yellow';
                if(account_expire > today) { class_name = 'green'; }
                parent.addClass(class_name);
            });
		";
	}
