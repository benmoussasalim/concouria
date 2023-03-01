<?php

$mail = MailQuery::create()->findPk(8); //9 EN PROD

if($mail) {    
    $title = $mail->getTranslation($lang_sql)->getTitle();
    
    $date = date('Y-m-d',strtotime('+ 30 days',time()));
    
    $accounts = AccountQuery::create()->filterByExportReady('Oui')->filterByDateExpire($date)->find();
    if($accounts) {
        foreach($accounts as $account) {
            $body = $mail->getTranslation($lang_sql)->getText();
            
            $body = str_replace('%%lien_website%%',_SITE_URL_HTTP,$body);
                
            $body = str_replace('%%Firstname%%',$account->getFirstname(),$body);
            $body = str_replace('%%Lastname%%',$account->getLastname(),$body);
            $body = str_replace('%%DateExpire%%',$account->getDateExpire(),$body);
            $body = str_replace('%%SubscribeLink%%',_SITE_URL_HTTP.'formulaire/'.md5(_PROJECT_NAME.$account->getIdAccount()),$body);
            
            var_dump('Message envoyé à '.$account->getFirstname().' '.$account->getLastname());

            sendHTMLemail($body,_FROM,$account->getEmail(),$title,_FROM);
            //sendHTMLemail($body,_FROM,'david@progexpert.com',$title,_FROM);
        }
    }
}