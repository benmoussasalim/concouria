<?php

if($request['ot'] != 's')
    $request = $_REQUEST;

if(_BASE_DIR != '_BASE_DIR'){
    include 'inc/init.php';
}else{
    include '../../inc/init.php';
}

include(_INSTALL_PATH."mod/template_func.php");

//if($request['a'] == 'exportCSV') { $request['a'] = 'importCSV'; }

switch($request['a']) {
    case 'createAccount':
		parse_str($request['form'],$data);

		$return['error'] = true;
		$return['class'] = 'create-account';
		$return['message'] = _("Une erreur est survenue. Veuillez réessayer plus tard.");

		if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$checkAuthy = AuthyQuery::create()->filterByEmail($data['email'])->findOne();
			if(count($checkAuthy) > 0) { $return['message'] = _("Ce courriel est déjà utilisé."); }
			else {
				$createAuthy = new Authy();

				$authyForm['Username'] = $data['email'];
				$authyForm['Email'] = $data['email'];
				$authyForm['PasswdHash'] = md5($data['password']);

				$authyForm['IsRoot'] = 'Non';
				$authyForm['Deactivate'] = 'Oui';
				$authyForm['Group'] = 'Normal';

				$createAuthy->fromArray($authyForm);
				$createAuthy->save();

				$idAuthy = $createAuthy->getPrimaryKey();

				if($idAuthy) {
                    if($data['region'] == 'all') { $data['region'] = null; }
                    
					$createAccount = new Account();

					$account['IdAuthy'] = $idAuthy;
					$account['Sexe'] = $data['sexe'];
					$account['Firstname'] = $data['firstname'];
					$account['Lastname'] = $data['lastname'];
					$account['Email'] = $data['email'];
					$account['Address'] = $data['address'];
					$account['PostalCode'] = $data['postal_code'];
					$account['HomePhone'] = $data['home_phone'];
					$account['OtherPhone'] = $data['other_phone'];
					$account['ExtPhone'] = $data['ext_phone'];
					$account['Cellphone'] = $data['cellulaire'];
					$account['BirthDate'] = $data['birth_date'];
					$account['Reference'] = $data['reference'];
					$account['IdProvince'] = $data['province'];
					$account['IdRegion'] = $data['region'];

					$location = checkCity($request['ville'],$data['province'],$lang_sql);
					$account['IdVille'] = $location['city'];
					$account['IdPays'] = 1;

					$createAccount->fromArray($account);
					$createAccount->save();

					$mail = MailQuery::create()->findPk(3);
					if($mail) {
						$cley = md5($data['firstname']." ".$data['lastname']." ".$idAuthy);

						$title = $mail->getTranslation($lang_sql)->getTitle();
						$body = $mail->getTranslation($lang_sql)->getText();

						$body = str_replace('%%Firstname%%',$data['firstname'],$body);
						$body = str_replace('%%Lastname%%',$data['lastname'],$body);
						$body = str_replace('%%linkActivation%%',_SITE_URL."?cley=".$cley,$body);

						sendHTMLemail($body,_FROM,$data['email'],$title,_FROM);

						$return['error'] = false;
						$return['class'] = 'create-account-success';
						$return['message'] = _("Compte créé. Vous recevrez un courriel pour confirmer votre inscription. Veuillez vérifier vos courriels indésirables.");
					}
				}
			}


		} else {
			$return['message'] = _("Format de courriel invalide.");
		}

		echo json_encode($return);
		die();

    break;

	case 'exportCSV':

        if(is_file(_INSTALL_PATH.'mod/file/client.csv')){ unlink(_INSTALL_PATH.'mod/file/client.csv'); }

        $output = fopen(_INSTALL_PATH.'mod/file/client.csv', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        /*fputcsv($output,
			array(
				'Numéro membre', //1 A
				'Participation Couple',//2 B
				'Sexe',//3 C
				'Prénom',//4 D
				'Nom',//5 E
				'Numéro Civique',//6 F
				'Rue',//7 G
				'Appartement',//8 H
				'Code Postal',//9 I
				'Téléphone',//10 J
				'Ville',//11 K
				'Ville registraire avec accent',//12 L
				'Région',//13 M
				'Province',//14 N
				'Pays',//15 O
				'Adresse courriel personnelle',//16 P
				'Adresse courriel pour les concours',//17 Q
				'Jour de naissance',//18 R
				'Mois de naissance',//19 S
				'Année de naissance',//20 U
				'Date de naissance',//21 V
				'Âge',//22 W
				'Compte utilisateur',//23 X
				'',//24 Y
				'Mot de passe',//25 Z
				'Mot de passe pour Cinoche',//26 AA
				'Propriétaire ou Locataire',//27 AB
				'',//28 AC
				'Carte Air Miles',//29 AD
				'',//30 AE
				'',//31 AF
				'Compte utilisateur Hershey',//32 AG
				'Mot de passe compte utilisateur Hershey',//33 AH
				'Compte Canton de l\'Est',//34 AI
				'',//35 AJ
				'',//36 AK
				'Compte La Presse',//37 AL
				'Compte Cinoche',//38 AM
				'',//39 AN
				'Entreprise où le client travaille',//40 AO
				'Titre d\'emploi ou métier',//41 AP
				'Autre numéro de téléphone',//42 AQ
				'Extension de téléphone au travail'//43 AR
			)
		);*/


        $clients = AccountQuery::create()->filterByExportReady('Oui');
        switch($request['type']) {
			case 'new': $clients->filterByExportStatus('Non'); break;
			case 'old': $clients->filterByStatus('Ancien'); break;
			case 'regular': $clients->filterByStatus('Nouveau');  break;
        }

        $clients = 
        $clients
        //->where('Account.DateExpire > NOW()') /* @@REMOVE */
        ->orderBy('IdAccount','ASC')
        ->groupBy('IdAccount')
        ->find();
        
        /*fputcsv($output,array(NULL));
        fputcsv($output,array(NULL));
         //fputcsv ( resource $handle , array $fields [, string $delimiter = "," [, string $enclosure = '"' [, string $escape_char = "\" ]]] )
        $exportArray = 
         array(
            "Numéro Membre","Participation Couple","Sexe"
            ,"Prénom","Nom","Numero Civique"
            ,"Rue","Appartement","Code Postal","Téléphone"
            ,"Ville","Ville Registraire avec accent","Région","Province","Pays","Courriel Personnel du CLIENT","Courriel pour les concours","Année de naissance"
            ,"","","Année de naissance(YYYY-MM-JJ)","Age","Compte Utilisateur","Mot de passe Hotmail","Mot de Passe","Mot de passe (Cinoche Seulement)"
            ,"Propriétaire ou Locataire","Carte HBC","Carte Air Miles","Carte Milliplein","Carte Métro","Compte Utilisateur Hershey","Mot de passe Hershey"
            ,"Compte Canton de l'Est","Compte FACEBOOK","Mot de passe FACEBOOK","Compte La Presse","Compte Cinoche"
            ,"Compte Casa","Entreprise ou le client travaille","Titre d'emploi","Téléphone Cellulaire ou travail","Extension"
            );
       // fputcsv($output,$exportArray,',',NULL);
        fputs($output, implode($exportArray, ',')."\n");
        $exportArray = 
         array(
            "","","","","","","","","","","","","","","","","","Jour","Mois","Année","","","","",""
             ,"À détruire plus tard","","","","","","","","","","","","","","","","",""
            );
        fputs($output, implode($exportArray, ',')."\n");
         fputcsv($output,array(NULL));*/
        if($clients){
            foreach($clients as $client){
				$lang = 'fr_CA';
				$civique = ""; $address = ""; $annee = ""; $month = ""; $day = "";

                $tabAdr = explode(",",$client->getAddress());

                if($tabAdr[1]){
                    $address = $tabAdr[1];
                    $civique = trim($tabAdr[0]);
                } else {
                    $tabAdr = explode(" ",$client->getAddress());
                    
                     if($tabAdr[1]){
                        $address = str_replace($tabAdr[0],'',$client->getAddress());
                        $civique = trim($tabAdr[0]);
                    }
                }
                
                $birth = str_replace('/','-',$client->getBirthDate());

                $client->setFirstname(str_replace(" ",'-',trim($client->getFirstname())));
                $client->setLastname(str_replace(" ",'-',trim($client->getLastname())));


                ($client->getVille())?'':$client->setVille( new Ville() );
                ($client->getRegion())?'':$client->setRegion( new Region() );
                ($client->getProvince())?'':$client->setProvince( new Province() );
                ($client->getPays())?'':$client->setPays( new Pays() );

                $annee = ""; $month = ""; $day = "";
                if($birth){
					$annee = date('Y',strtotime($birth));
					$month = date('m',strtotime($birth));
					$day = date('d',strtotime($birth));
                }
                
                if(!$client->getOtherPhone()){
                   $client->setOtherPhone($client->getHomePhone());
                }
                
                if(!$client->getUsernameContest()) {
					-
					$username = substr(stripe_accent(str_replace('-','',$client->getFirstname())),0,3);
					$username .= substr(stripe_accent(str_replace('-','',$client->getLastname())),0,3);
					$username .= substr(stripe_accent($client->getVille()->getTitle()),0,3);
					$username .= substr(str_replace('/','',$client->getBirthDate()),-2).substr(str_replace('/','',$client->getBirthDate()),0,4);
					$username =  strtolower($username);
                    
                    $username = str_replace('-','',$username);
                    $username = str_replace('_','',$username);
                    
                    $client->getUsernameContest($username);
                    $client->save();
				}

				$checkAdresses = AccountQuery::create()->filterByPostalCode($client->getPostalCode())->filterByApp($client->getApp())->filterByAddress($client->getAddress())->find();
				if(count($checkAdresses) > 0) {
					foreach($checkAdresses as $checkAdresse) {
						$checkAdresse->setCouple('Non');
						$checkAdresse->save();
					}
				}
                //echo $client->getIdAccount()."<br>";
                $client->setCouple('Oui');
                $client->save();
                
                $exportArray = 
                array(
                    $client->getIdAccount(),//1 - A
                    parse_csv($client->getCouple()),//2 - B
                    parse_csv($client->getSexe()),//3 - C
                    formatName($client->getFirstname()),//4 - D
                    formatName($client->getLastname()),//5 - E
                    trim($civique),//6 - F
                    trim($address),//7 - G
                    $client->getApp(),//8 - H
                    str_replace(' ','',trim(mb_strtoupper($client->getPostalCode(),'UTF-8'))),//9 - I
                    formatPhone($client->getHomePhone()),//10 - J
                    stripe_accent($client->getVille()->getTranslation($lang_sql)->getName()),//11 - K
                    $client->getVille()->getTranslation($lang)->getName(),//12 - L
                    $client->getRegion()->getTranslation($lang)->getName(),//13 - M
                    $client->getProvince()->getTranslation($lang)->getName(),//14 - N
                    $client->getPays()->getTranslation($lang)->getName(),//15 - O
                    $client->getEmail(),//16 - P
                    $client->getEmailContest(),//17 - Q
                    $day,//18 - R
                    $month,//19 - S
                    $annee,//20 - T
                    date('Y-m-d',strtotime($birth)),//21 - U
                    age($birth),//22 - V
                    $client->getUsernameContest(),//23 - W
					NULL,
					/*$client->getHotmailPassword(),//23 - W*/
                    $client->getPasswordContest(),//25 - Y
                    $client->getCinochePassword(),//26 - Z
                    parse_csv($client->getProprietaire()),//27 - AA
                   // $client->getHbcCard(),//29 - AC
                    NULL,
                    $client->getAirMiles(),//29 - AC
                    NULL,
                    NULL,
                   // $client->getMillipleinCard(),//29 - AC
                  //  $client->getMetroCard(),//29 - AC
                    $client->getHersheyUsername() ? $client->getHersheyUsername() : $client->getUsernameContest(),//32 - AF
                    $client->getHersheyPassword() ? $client->getHersheyPassword() : $client->getPasswordContest(),//33 - AG
                    $client->getCantonUsername() ? $client->getCantonUsername() : $client->getUsernameContest(),//34 - AH
                    NULL,
                    NULL,
                    // $client->getFacebookUsername() ? $client->getFacebookUsername() : $client->getFacebookUsername(),//34 - AH
                   // $client->getFacebookPassword() ? $client->getFacebookPassword() : $client->getFacebookPassword(),//34 - AH  
                    $client->getPresseUsername() ? $client->getPresseUsername() : $client->getUsernameContest(),//37 - AK
                    $client->getCinocheUsername() ? $client->getCinocheUsername() : $client->getUsernameContest(),//38 - AL
                    NULL,
                   // $client->getCasaUsername() ? $client->getCasaUsername() : $client->getCasaUsername(),//38 - AL
                    $client->getWorkplace(),//40 - AN
                    $client->getWork(),//41 - AO
                    formatPhone($client->getOtherPhone() ? $client->getOtherPhone() : $client->getHomePhone()),//42 - AP
                    $client->getExtPhone(),//43 - AQ

                );
                
               // fputcsv($output,$exportArray);
                fputs($output, implode($exportArray, ',')."\r\n");
               // fputs($output, implode($exportArray, ',')."0x0d 0x0a");
			//	fputcsv($output,array(NULL));
                if($client->getIdAccount()){ AccountQuery::create()->filterByIdAccount($client->getIdAccount())->update(array('ExportStatus'=>'1')); }
            }
        }

        fclose($output);
        
        $subject=" Envoie d'exportation CSV ".$request['type']." ".date('Y-m-d');
        $message=" Envoie d'exportation CSV ".$request['type']." ".date('Y-m-d');
        $filename ="client.csv"; 
		//$to = "yan@progexpert.ca";
		
		$to = "robertoveilleux@globetrotter.net";
		$attachment['name'] =$filename;
		$file =_INSTALL_PATH."mod/file/client.csv";
		$file_size = filesize($file);
		$handle = fopen($file, "r");
		$content = fread($handle, $file_size);
		fclose($handle);
		$attachment['data'] =$content;
		$attachment['mime'] ='csv';
		
		
		
		//die();
		sendHTMLemail($message, 'info@concouria.com', $to, $subject,$from_mail, $attachment);
		
		$to = 'info@concouria.com';
		sendHTMLemail($message, 'info@concouria.com', $to, $subject,$from_mail, $attachment);
		echo "courriel envoyé ... OK"; 
        
		//$to = "yan@progexpert.ca";
		//sendHTMLemail($message, 'info@concouria.com', $to, $subject,$from_mail, $attachment);
		//echo "courriel envoyé ... OK"; 
		
       // echo  "$.fileDownload('"._SITE_URL."mod/file/client.csv');";

        die();

	break;

	case 'getCity':
		$lang_sql = 'fr_CA';

		$villes = VilleQuery::create()->useVilleI18nQuery()->filterByLocale($lang_sql)->endUse()->join('VilleI18n')->where('VilleI18n.Name like "%'.$request['ville'].'%"')->groupBy('IdVille')->find();

		if(count($villes) > 0) { foreach($villes as $ville) { $listVille .= li($ville->getTranslation($lang_sql)->getName(),'class="city-result" data-ville="'.$ville->getIdVille().'" data-region="'.$ville->getIdRegion().'" data-province="'.$ville->getRegion()->getIdProvince().'" data-pays="'.$ville->getRegion()->getProvince()->getIdPays().'"'); } }
		if($listVille) { $blockVille = ul($listVille,'class="city-list"'); }

		echo $blockVille;
	break;

	case 'promoCode':
		$return['error'] = true;
		$return['class'] = 'promo-error';

		$_SESSION['Price'] = (_PRIX_ABONNEMENT/100);

		$code = CodePromoQuery::create()->filterByCode(mb_strtoupper($request['code'],'UTF-8'))->findOne();
		if(count($code) > 0) {

			if($code->getUsed() == 'Actif') {
				$date = strtotime(date('Y-m-d'));
				$return['error'] = false;

				if($date < strtotime($code->getDateDebut())) {
					$return['message'] = _("Le code promo commence le")." ".$code->getDateDebut().".";
					$return['error'] = true;
				}

				if($date > strtotime($code->getDateFin())) {
					$return['message'] = _("Le code promo est expiré.");
					$return['error'] = true;
				}

				if($return['error'] == false) {

					$return['message'] = _("Code promo trouvé.");
					$return['error'] = false;
					$return['class'] = 'promo-success';

					if($code->getMontant() != '' OR $code->getMontant() != 0) { $_SESSION['Price'] = (_PRIX_ABONNEMENT/100) - $code->getMontant(); $return['amount'] = '-'.$code->getMontant().'$'; }
					else if($code->getPourcent() != '' OR $code->getPourcent() != 0) {
						$_SESSION['Price'] = number_format(((_PRIX_ABONNEMENT/100) * $code->getPourcent() / 100),2,'.',' ');
						$_SESSION['Price'] = (_PRIX_ABONNEMENT/100) - $_SESSION['Price'];

						$return['amount'] = '-'.$code->getPourcent().'%';
					}
					else {
						$return['message'] = _("Erreur de réduction de montant. Veuillez contactez un administrateur.");
						$return['error'] = true;
					}

					$_SESSION['Promo']['Amount'] = $return['amount'];
					$_SESSION['Promo']['Code'] = $request['code'];

					include _INSTALL_PATH.'mod/page/inc/AbonnementPrice.php';

					if($code->getType() == 'Unique' && $return['error'] == false) { $code->setUsed() == 'Inactif'; $code->save(); }
				}

			} else { $return['message'] = _("Code promo déjà utilisé."); }

		} else { $return['message'] = _("Code promo invalide."); }

		$return['price'] = $_SESSION['Price'];

		echo json_encode($return);
		die();
	break;

	case 'saveAccount':
		parse_str($request['form'],$form);

		if($form['personnal-email'] AND !filter_var($form['personnal-email'], FILTER_VALIDATE_EMAIL)) {
			$return[0]['error'] = true;
			$return[0]['message'] = _("Votre adresse courriel personnelle est invalide.");
			$return[0]['class'] = 'personnal-email';
		}

		if($form['email-contest'] AND !filter_var($form['email-contest'], FILTER_VALIDATE_EMAIL)) {
			$return[1]['error'] = true;
			$return[1]['message'] = _("Votre adresse courriel pour les concours est invalide.");
			$return[1]['class'] = 'contest-email';
		}

		/*if(!preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $form['phone-number'])) {
			$return[2]['error'] = true;
			$return[2]['message'] = _("Votre numéro de téléphone est invalide.");
			$return[2]['class'] = 'personal-phone';
		}*/

		/*if(!preg_match('/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/', $form['code-postal'])) {
			$return[3]['error'] = true;
			$return[3]['message'] = _("Code postal est invalide.");
			$return[3]['class'] = 'postal-code';
		}*/

		if(!$return) {
			$checkAdresses = AccountQuery::create()->filterByPostalCode($form['code-postal'])->filterByApp($form['app'])->filterByAddress($form['adresse-civique'])->filterByCouple('Oui')->find();
			if(count($checkAdresses) > 0) {
				foreach($checkAdresses as $checkAdresse) { $checkAdresse->setCouple('Non'); $checkAdresse->save(); }
				$accountSave['Couple'] = 'Non';
			} else { $accountSave['Couple'] = 'Oui'; }

			$account = AccountQuery::create()->findPk($form['id-account']);

			if($account) {
				//CRÉATION USERNAME UNIQUE
				if($account->getUsernameContest() == '') {
					$form['username-contest'] = substr(stripe_accent(str_replace('-','',$account->getFirstname())),0,3);
					$form['username-contest'] .= substr(stripe_accent(str_replace('-','',$account->getLastname())),0,3);
					$form['username-contest'] .= substr(stripe_accent($account->getVille()->getTitle()),0,3);
					$form['username-contest'] .= substr(str_replace('/','',$account->getBirthDate()),-2).substr(str_replace('/','',$account->getBirthDate()),0,4);
					$form['username-contest'] =  strtolower($form['username-contest']);
                    
                    $form['username-contest'] = str_replace('-','',$form['username-contest']);
                    $form['username-contest'] = str_replace('_','',$form['username-contest']);
				}

				if($form['password'] != '') {
					$authy = AuthyQuery::create()->findPk($account->getIdAuthy());
					$authySave['PasswdHash'] = md5($form['password']);
					$authy->fromArray($authySave);
					$authy->save();
				}
                
                /* CRÉATION DU MOT DE PASSE */
                if($account->getPasswordContest() == '') {
                    $accountSave['PasswordContest'] = createRandomKey(12);
                }
                
                if($form['region'] == 'all') { $form['region'] = null; }

				$accountSave['Sexe'] = $form['sexe'];
				$accountSave['BirthDate'] = $form['birth-date'];
				$accountSave['Firstname'] = $form['firstname'];
				$accountSave['Lastname'] = $form['lastname'];
				$accountSave['Email'] = $form['personnal-email'];
				$accountSave['HomePhone'] = $form['phone-number'];
				$accountSave['OtherPhone'] = ($form['other-phone']) ? $form['other-phone'] : $form['phone-number'];
				$accountSave['Address'] = $form['adresse-civique'];
				$accountSave['App'] = $form['app'];
				$accountSave['PostalCode'] = $form['code-postal'];
				$accountSave['IdRegion'] = $form['region'];
				$accountSave['IdProvince'] = $form['province'];
				$accountSave['IdPays'] = $form['pays'];
				$accountSave['Workplace'] = $form['workplace'];
				$accountSave['Work'] = $form['work'];
				$accountSave['UsernameContest'] = $form['username-contest'];
				$accountSave['EmailContest'] = $form['email-contest'];
				$accountSave['PasswordEmailContest'] = $form['password-email-contest'];
				$accountSave['AirMiles'] = $form['air-miles'];
				$accountSave['Proprietaire'] = $form['propriete'];
				$accountSave['Cellphone'] = $form['cellulaire'];
				$accountSave['ExtPhone'] = $form['ext_phone'];
                
				$accountSave['ExportReady'] = $request['export_ready'];

				$location = checkCity($request['ville'],$form['province'],$lang_sql);

				$accountSave['IdVille'] = $location['city'];

				$accountSave['HersheyUsername'] = $form['username-contest'];
				$accountSave['CantonUsername'] = $form['username-contest'];
				$accountSave['PresseUsername'] = $form['username-contest'];
				$accountSave['CinocheUsername'] = $form['username-contest'];

				$accountSave['HotmailPassword'] = ($account->getHotmailPassword()) ? $account->getHotmailPassword() : randomPassword();
				$accountSave['HersheyPassword'] = $accountSave['HotmailPassword'];

				$account->fromArray($accountSave);
				$account->save();

				$return[0]['error'] = false;
				$return[0]['message'] = _("Profil enregistré.");
				$return[0]['class'] = 'success-save';
			}
		}

		echo json_encode($return);
		die();

	break;

	case 'saveInput':
		if($request['name'] AND $request['value']) { $_SESSION['form'][$request['name']] = $request['value']; }
		die();
	break;

	case 'SelectLocation':
		include _INSTALL_PATH.'mod/page/inc/SelectLocation.php';

		echo json_encode($output);
		die();
	break;

	case 'contest-list':
		ConcoursQuery::create()->deleteAll();

		$file = _INSTALL_PATH.'mod/file/contest-list.csv';
		//$type = "OOCalc";

		include _INSTALL_PATH.'mod/Classes/PHPExcel/IOFactory.php';
		//$objPHPExcel = PHPExcel_IOFactory::load($file);

		$objReader = PHPExcel_IOFactory::createReaderForFile($file);
		$objReader->setReadDataOnly(false);
		$objPHPExcel = $objReader->load($file);

		//if($objPHPExcel->getWorksheetIterator()) {
		foreach ($objPHPExcel->getWorksheetIterator() as $key => $worksheet) {
			if($key == 0) {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

				for ($row = 2; $row <= $highestRow; ++ $row) {
					$importContest = '';
					$contest = new Concours();
					$contestFr = new ConcoursI18n();

					for ($col = 0; $col < $highestColumnIndex; ++ $col) {
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						$val = $cell->getValue();

						switch($col) {
							case 0:
								$contest->setTitle($val);
								$contestFr->setName($val);
							break;
							case 1:
								$date = date('Y-m-d',strtotime($val));
								$contest->setDate($date);
							break;
							case 2: $contestFr->setText($val); break;
							case 3:
								$price = str_replace('$','',$val);
								$price = str_replace(',','',$price);
								$price = number_format(floatval($price),0,'.',' ');

								$contest->setPrice($price);
							break;
						}

					}

					$contest->setOnline('Oui');
					$contest->save();

					$contestFr->setLocale('fr_CA');
					$contestFr->setIdConcours($contest->getPrimaryKey());
					$contestFr->save();
				}
			}
		}
	break;

    case 'importCSV':
        //POUR LES TESTS
        $deleteAccount = AccountQuery::create()->where(' Account.IdAuthy > 1347 ')->delete();
        $deleteAuthy = AuthyQuery::create()->filterByGroup('Normal')->delete();

        $file = _INSTALL_PATH.'mod/file/client_import.csv';
        //$type = "OOCalc";

        include _INSTALL_PATH.'mod/Classes/PHPExcel/IOFactory.php';
        //$objPHPExcel = PHPExcel_IOFactory::load($file);

        $objReader = PHPExcel_IOFactory::createReaderForFile($file);
        $objReader->setReadDataOnly(false);
        $objPHPExcel = $objReader->load($file);

        foreach ($objPHPExcel->getWorksheetIterator() as $key => $worksheet) {
            if($key == 0) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                for ($row = 1; $row <= $highestRow; ++ $row) {
                    $importAccount = '';
                    $importAuthy = '';
                    
                    $createCity = '';
                    $createRegion = '';
                    $createProvice = '';
                    $createPays = '';

                    for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                        $cell = $worksheet->getCellByColumnAndRow($col, $row);
                        $val = $cell->getValue();
                        
                        //var_dump($row.' - '.($col +1).' = '.$val);

                        switch($col) {
                            //case 0: /* A */ $importAccount['IdAccount'] = $val; break;
                            case 1: /* B */ if($val == 'oui' OR $val == 'non') { $importAccount['Couple'] = ucfirst($val); } break;
                            case 2: /* C */ if($val == 'femme' OR $val == 'homme') { $importAccount['Sexe'] = ucfirst($val); } break;
                            case 3: /* D */ $importAccount['Firstname'] = $val; break;
                            case 4: /* E */ $importAccount['Lastname'] = $val; break;
                            case 5: /* F */ $importAccount['Address'] = $val;  break; 
                            case 6: /* G */ $importAccount['Address'] .= ", ".$val; break;
                            case 7: /* H */ $importAccount['App'] = $val; break;
                            case 8: /* I */ $importAccount['PostalCode'] = $val; break;
                            case 9: /* J */ $importAccount['HomePhone'] = $val; break;
                            case 10: /* K */ /* VILLE SANS ACCENT QUE L'ON TRAITE SEULEMENT DANS L'EXPORT */ break;
                            case 11: /* L */ 
                                $city = VilleQuery::create()->filterByTitle($val)->findOne();
                                if(count($city) > 0) { 
                                    $importAccount['IdVille'] = $city->getIdVille(); 
                                    $importAccount['IdRegion'] = $city->getIdRegion(); 
                                    $importAccount['IdProvince'] = $city->getRegion()->getIdProvince(); 
                                    $importAccount['IdPays'] = $city->getRegion()->getProvince()->getIdPays(); 
                                } else { $createCity = $val; }
                            break;
                            case 12: /* M */ if($createCity != '') { $createRegion = $val; } break;
                            case 13: /* N */ if($createCity != '') { $createProvice = $val; } break;
                            case 14: /* O */ if($createCity != '') { $createPays = $val; } break;
                            case 15: /* P */ $importAccount['Email'] = $val; $importAuthy['Email'] = $val; $importAuthy['Username'] = $val; break;
                            case 16: /* Q */  $importAccount['EmailContest'] = $cell->getFormattedValue();  break;
                            case 17: /* R */  /* JOUR */ break;
                            case 18: /* S */  /* MOIS */ break;
                            case 19: /* T */  /* ANNÉE */ break;
                            case 20: /* U */  $importAccount['BirthDate'] = date('Y-m-d',strtotime($val)); break;
                            case 21: /* V */  /* ÂGE */ break;
                            case 22: /* W */ $importAccount['UsernameContest'] = $val; break;
                            case 23: /* W */ $importAccount['HotmailPassword'] = $val; break;
                            case 24: /* Y */ $importAuthy['PasswdHash'] = $val; $importAccount['PasswordContest'] = $val; break;
                            case 25: /* Z */ $importAccount['CinochePassword'] = $val; break;
                            case 26: /* AA */ if($val == 'proprietaire') { $importAccount['Proprietaire'] = 'Propriétaire'; } else { $importAccount['Proprietaire'] = 'Locataire'; } break;
                            case 27: /* AC */ $importAccount['HbcCard'] = $val; break;
                            case 28: /* AC */ $importAccount['AirMiles'] = $val; break;
                            case 29: /* AC */ $importAccount['MillipleinCard'] = $val; break;
                            case 30: /* AC */ $importAccount['MetroCard'] = $val; break;
                            case 31: /* AF */ $importAccount['HersheyUsername'] = $val; break;
                            case 32: /* AG */ $importAccount['HersheyPassword'] = $val; break;
                            case 33: /* AH */ $importAccount['CantonUsername'] = $val; break;
                            case 34: /* AH */ $importAccount['FacebookUsername'] = $val; break;
                            case 35: /* AH */ $importAccount['FacebookPassword'] = $val; break;
                            case 36: /* AK */ $importAccount['PresseUsername'] = $val; break;
                            case 37: /* AL */ $importAccount['CinocheUsername'] = $val; break;
                            case 38: /* AL */ $importAccount['CasaUsername'] = $val; break;
                            case 39: /* AN */ $importAccount['Workplace'] = $val; break;
                            case 40: /* AO */ $importAccount['Work'] = $val; break;
                            case 41: /* AP */ $importAccount['OtherPhone'] = $val; break;
                            case 42: /* AQ */ $importAccount['ExtPhone'] = $val; break;
                        }

                    }

                    if($createCity != '') {
                        $paysCheck = PaysQuery::create()->filterByTitle($createPays)->findOne();
                        if($paysCheck) { $idPays = $paysCheck->getIdPays(); }
                        else {
                            $pays = new Pays();
                            $pays->setTitle($createPays);
                            $pays->save();
                            $idPays = $pays->getPrimaryKey();
                        }
                        
                        $provinceCheck = ProvinceQuery::create()->filterByTitle($createProvice)->findOne();
                        if($provinceCheck) { $idProvince = $provinceCheck->getIdProvince(); }
                        else {
                            $province = new Province();
                            $province->setTitle($createProvice);
                            $province->setIdPays($idPays);
                            $province->setIdGrpTaxe(1);
                            $province->save();
                            $idProvince = $province->getPrimaryKey();
                        }
                        
                        $regionCheck = RegionQuery::create()->filterByTitle($createRegion)->findOne();
                        if($regionCheck) { $idRegion = $regionCheck->getIdRegion(); }
                        else {
                            $region = new Region();
                            $region->setTitle($createRegion);
                            $region->setIdProvince($idProvince);
                            $region->save();
                            $idRegion = $region->getPrimaryKey();
                        }
                        

                        $ville = new Ville();
                        $ville->setTitle($createCity);
                        $ville->setIdRegion($idRegion);
                        $ville->setIdProvince($idProvince);
                        $ville->save();
                        $idVille = $ville->getPrimaryKey();
                        
                        $importAccount['IdVille'] = $idVille; 
                        $importAccount['IdRegion'] = $idRegion; 
                        $importAccount['IdProvince'] = $idProvince; 
                        $importAccount['IdPays'] = $idPays; 
                    }

                    if($importAccount['Couple'] != '') {
                        $importAuthy['IsRoot'] = 'Non';
                        $importAuthy['Group'] = 'Normal';
                        $importAuthy['Deactivate'] = 'Non';
                        $authySave = New Authy();
                        $authySave->fromArray($importAuthy);
                        $authySave->save();
                        $importAccount['IdAuthy'] = $authySave->getPrimaryKey();

                        if($importAccount['IdAuthy']) {
                            $importAccount['Status'] = 'Ancien';
                            $importAccount['ExportStatus'] = 'Oui';
                            $importAccount['ExportReady'] = 'Oui';
                            $importAccount['DateExpire'] = '2018-01-01';

                            $accountSave = New Account();
                            $accountSave->fromArray($importAccount);
                            $accountSave->save();
                        }
                    }
                }
            }
        }

        $return['message'] = _("Importation réussie.");
        $return['error'] = false;

        //echo json_encode($return);
        die();
    break;
}

function stripe_accent($str){
    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

    return $str;
}


function parse_csv($str){
    $str = mb_strtolower($str,'UTF-8');
    return $str;
}
function age($date){
  if($date){
    $d = strtotime($date);
    return (int) ((time() - $d) / 3600 / 24 / 365.242);
  }return NULL;
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 12; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function formatPhone($phone) {
    $phone = substr(str_replace(' ','',trim(str_replace('-','',$phone))),-10);
    return $phone;
}

function formatName($name) {
    $name = str_replace(' ','-',trim(ucfirst(mb_strtolower($name,'UTF-8'))));
    return $name;
}