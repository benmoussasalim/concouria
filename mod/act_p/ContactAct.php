<?php

if($request['ot'] != 's')
    $request = $_REQUEST;

if(_BASE_DIR != '_BASE_DIR'){
    include 'inc/init.php';
}else{
    include '../../inc/init.php';
}

include(_INSTALL_PATH."mod/template_func.php");

switch($request['a']) {
	case 'sendForm':
		parse_str($request['form'],$data);

		$return['error'] = true;
		$return['class'] = 'return-error';

		if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$mail = MailQuery::create()->findPk(7);

			if(count($mail) > 0) {
				$title = $mail->getTranslation($lang_sql)->getTitle();
				$body = $mail->getTranslation($lang_sql)->getText();

				$body = str_replace('%%Email%%',$data['email'],$body);
				$body = str_replace('%%Firstname%%',$data['firstname'],$body);
				$body = str_replace('%%Lastname%%',$data['lastname'],$body);
				$body = str_replace('%%Message%%',$data['message'],$body);
				$body = str_replace('%%Phone%%',$data['phone'],$body);

				sendHTMLemail($body,'info@concouria.ca',_CONTACT_EMAIL,$title,$data['email']);

				$return['error'] = false;
				$return['class'] = 'return-success';
				$return['message'] = _("Message soumis. Merci.");

			} else { $return['message'] = _("Erreur. Veuillez réessayer plus tard."); }

		} else { $return['message'] = _("Format de courriel invalide."); }

		echo json_encode($return);
		die();
	break;
    
    case 'SignalForm':
        $block = BlockQuery::create()->filterByStatus('Publié')->filterByIdBlock(20)->findOne();
        if(count($block) >= 1) {
            $blockContent = div(div($block->getTranslation($lang_sql)->getText(),'',swEdit('Text',true)),'',swEdit('Block',$block->getIdBlock(),$block->getTitle()));

        } else { $sectionClass = 'no-block'; }

        $sectionClass = $sectionClass ? 'class="'.$sectionClass.'"' : '';

        if($_SESSION[_AUTH_VAR]->get('isConnected') == 'YES') {
            $authy = AuthyQuery::create()->findPk($_SESSION[_AUTH_VAR]->get('id'));
            if($authy) { $userMail = $authy->getEmail(); }
        }

        $return['SignalForm'] =
            div(
                $blockContent
                .form(
                    input('text','email',$userMail,'placeholder="'.addslashes(_("Votre adresse courriel")).'" class="required"')
                    .textarea('message','','placeholder="'.addslashes(_("Votre message")).'" class="required"')
                    .button(_("Soumettre"),'class="button-link blue"')
                    .href(_("Annuler"),'javascript:','class="close-popup"')
                ,'id="signal-form"')
            ,'','data-section="SignalForm" '.$sectionClass)
        ;
        
        echo $return['SignalForm'];
        die();
    break;
    
    case 'SubmitSignal':
        parse_str($request['form'],$form);
        
        if(filter_var($form['email'], FILTER_VALIDATE_EMAIL)){
            include _INSTALL_PATH.'inc/Mobile_Detect.php';

            $detect = new Mobile_Detect;
            if($detect->isMobile() == true) {
                $mobile = p(strong("Mobile: ").'Oui');

                if($detect->isiOS() == true){ $mobile = p(strong("Type de mobile: ").'Iphone'); } 
                else { $mobile = p(strong("Type de mobile: ").'Android'); }
            } else { $mobile = p(strong("Mobile: ").'Non'); }

            $title = '[Site web] Signalement de problème';
            $message =
                p(strong("Courriel: ").$form['email'])
                .'<br/>'
                .p(strong("Message: ").$form['message'])
                .'<br/>'
                .p(strong("Navigateur: ").$request['browser_name'].' (Version '.$request['browser_version'].')')
                .'<br/>'
                .$mobile
            ;

            //sendHTMLemail($message,_FROM,'jo@progexpert.com',$title,$form['email']);
            sendHTMLemail($message,_FROM,'info@progexpert.com',$title,$form['email']);

            $return = returnDefault(_("Problème signalé. Merci."),false,'success');
        } else {
            $return = returnDefault(_("Format de courriel invalide."),true,'alert');
        }
        
        echo json_encode($return);
        die();
    break;
}

