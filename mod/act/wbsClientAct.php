<?php

#@0.1@#########################
#	ProgXform version 0.7
#	Propel version 1.7
#	Prgxpert, Frederic Vezina 2011
#	build_time: 2013-12-14 12:40:42
###############################

/*if(!is_array($_SESSION['_AUTH_VAR']))
    die();*/

if($request['ot'] != 's')
    $request = $_REQUEST;


if(_BASE_DIR != '_BASE_DIR'){
    include 'inc/init.php';
}else{
    include '../../inc/init.php';
}
ini_set("display_errors", 1); 
include __DIR__.'/../gen/wbsInit.php';
/* pour les processus de webservice mailexpert */



if($request){
    switch($request['a']){
        case 'addMail': 
            if($request['mail']){
                $mail =  $request['mail'];
                $param = array('Courriel'=>$mail,'Descriptions'=>'Ajouter par WBS','List'=>'Site web','OptinDesc'=>'WBS ACCUEIL','LastInvoice'=>'');
                if($client)
                    $response = $crypt->jsonDecodeDeCryp($client->myAddEmail($crypt->jsonEncodeCryp($param)));
                
                
                $response = $response['etat'];
                //echo $response;
                if($response==1){
                    /*ajouter*/
                    $str = "$('#infolettre_mail').val('');
                            $('#msg_erreur_texte').html('".addslashes(_('Vous êtes maintenant inscrit a l\'infolettre !'))."');
                            $('#msg_erreur').dialog('open');";
                }else if($response==2){
                    /*deja inscrit*/	
                    $str = "$('#msg_erreur_texte').html('".addslashes(_('Vous êtes déjà inscrit a l\'infolettre !'))."');$('#msg_erreur').dialog('open');";				
                }else if($response==3){
                    /* erreur format courriel*/
                    $str = "$('#msg_erreur_texte').html('".addslashes(_('Votre courriel est invalide!'))."');$('#msg_erreur').dialog('open');";
                }else{
                    $str = "$('#msg_erreur_texte').html('".addslashes(_('Une erreur est survenue veuillez ressayer plustard!'))."');$('#msg_erreur').dialog('open');";
                }
                echo $str;
            }
            die();
        break;
        case 'Unsub': 
            if($request['mail']){
                $mail =  $request['mail'];
                $param = array('Courriel'=>$mail);
                if($client)
                    $response = $client->myUnsubEmail($crypt->jsonEncodeCryp($param));
            }
            die();
        break;
        case 'Sub': 
            if($request['mail']){
                $mail =  $request['mail'];
                $param = array('Courriel'=>$mail);
                if($client)
                    $response = $client->mySubEmail($crypt->jsonEncodeCryp($param));
            }
            die();
        break;
        case 'createCampaign':
            echo 'create';
            if($request['mailContent']){
                $param = array('Contenu'=>urlencode($request['mailContent']),'List'=>'20','Sujet'=>'Ce midi au Galopin', 'Name'=>'SiteWeb - '.date('Y-m-d H:i'), 'Random'=>'2',
                                'SendingEmail'=>'info@restaurantgalopin.com', 'ReplyEmail'=>'info@restaurantgalopin.com'
                                );
                if($client){
                        echo 'sending';
                    $response = $crypt->jsonDecodeDeCryp($client->createCampaign($crypt->jsonEncodeCryp($param)));
                    
                }
                var_dump($response);
            }
            die();
        break;
        case 'getStates':
            if($request['mails']){
                $mails =  json_decode($request['mails'], true);
                $param = array('Courriels'=>$mails);
                if($client)
                    $response = $client->getStatesEmail($crypt->jsonEncodeCryp($param));
            }
            die();
        break;
    }
}
