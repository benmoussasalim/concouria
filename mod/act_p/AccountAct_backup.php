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
					$account['BirthDate'] = $data['birth_date'];
					$account['Reference'] = $data['reference'];
					$account['IdProvince'] = $data['province'];

					$account['IdVille'] = checkCity($request['ville'],$data['province'],$lang_sql);
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
						$return['message'] = _("Compte créé. Vous recevrez un courriel pour confirmer votre inscription.");
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

        fputcsv($output,
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
				'Mot de passe pour concours',//25 Z
				'Mot de passe pour Cinoche',//26 AA
				'Propriéte',//27 AB
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
				'Numero de téléphone cellulaire'//42 AQ
			)
		);


        $clients = AccountQuery::create();
        switch($request['type']) {
			case 'new': $clients->filterByExportStatus('Non'); break;
			case 'old': $clients->filterByStatus('Ancien'); break;
			case 'regular': $clients->filterByStatus('Nouveau');  break;
        }

        $clients = $clients->orderBy('IdAccount','DESC')->find();
        if($clients){
            foreach($clients as $client){
				$lang = 'fr_CA';
				$civique = ""; $address = ""; $annee = ""; $month = ""; $day = "";

                $tabAdr = explode(",",$client->getAddress());

				/*if($client->getIdAccount() == 2387) {
					//var_dump(stripe_accent($client->getVille()->getTranslation($lang_sql)->getName()));
					var_dump($client);
					die();
				}*/

                if($tabAdr[1]){
                    $address = $tabAdr[1];
                    $civique = trim($tabAdr[0]);
                }

                $client->setFirstname(str_replace(" ",'-',trim($client->getFirstname())));
                $client->setLastname(str_replace(" ",'-',trim($client->getLastname())));


                ($client->getVille())?'':$client->setVille( new Ville() );
                ($client->getRegion())?'':$client->setRegion( new Region() );
                ($client->getProvince())?'':$client->setProvince( new Province() );
                ($client->getPays())?'':$client->setPays( new Pays() );

                $annee = ""; $month = ""; $day = "";
                if($client->getBirthDate()){
					$annee = date('Y',strtotime($client->getBirthDate()));
					$month = date('m',strtotime($client->getBirthDate()));
					$day = date('d',strtotime($client->getBirthDate()));
                }
                if(!$client->getOtherPhone()){
                   $client->setOtherPhone($client->getHomePhone());
                }

                fputcsv($output,
                    array(
                        $client->getIdAccount(),//1
						parse_csv($client->getCouple()),//2
						parse_csv($client->getSexe()),//3
						$client->getFirstname(),//4
						$client->getLastname(),//5
						trim($civique),//6
						trim($address),//7
						$client->getApp(),//8
						mb_strtoupper($client->getPostalCode(),'UTF-8'),//9
						$client->getHomePhone(),//10
						stripe_accent($client->getVille()->getTranslation($lang_sql)->getName()),//11
						$client->getVille()->getTranslation($lang)->getName(),//12
						$client->getRegion()->getTranslation($lang)->getName(),//13
						$client->getProvince()->getTranslation($lang)->getName(),//14
						$client->getPays()->getTranslation($lang)->getName(),//15
						$client->getEmail(),//16
						$client->getEmailContest(),//17
						$day,//18
						$month,//19
						$annee,//20
						date('Y-m-d',strtotime($client->getBirthDate())),//21
						age($client->getBirthDate()),//22
						$client->getUsernameContest(),//23
						$client->getHotmailPassword(),//24
						$client->getPasswordContest(),//25
						$client->getCinochePassword(),//26
						parse_csv($client->getProprietaire()),//27
						'',//28
						$client->getAirMiles(),//29
						'',//30
						'',//31
						$client->getHersheyUsername(),//32
						$client->getHersheyPassword(),//33
						$client->getCantonUsername(),//34
						'',//35
						'',//36
						$client->getPresseUsername(),//37
						$client->getCinocheUsername(),//38
						'',//39
						$client->getWorkplace(),//40
						$client->getWork(),//41
						$client->getOtherPhone()//42
                    ));
                if($client->getIdAccount()){ AccountQuery::create()->filterByIdAccount($client->getIdAccount())->update(array('ExportStatus'=>'1')); }
            }
        }


        fclose($output);
        echo  "$.fileDownload('"._SITE_URL."mod/file/client.csv');";

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

		if(!preg_match('/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/', $form['code-postal'])) {
			$return[3]['error'] = true;
			$return[3]['message'] = _("Code postal est invalide.");
			$return[3]['class'] = 'postal-code';
		}

		if(!$return) {
			$checkAdresses = AccountQuery::create()->filterByPostalCode($form['code-postal'])->filterByApp($form['app'])->filterByAddress($form['adresse-civique'])->filterByParticipationCouple('Oui')->find();
			if(count($checkAdresses) > 0) {
				foreach($checkAdresses as $checkAdresse) { $checkAdresse->setParticipationCouple('Non'); $checkAdresse->save(); }
				$accountSave['ParticipationCouple'] = 'Non';
			} else { $accountSave['ParticipationCouple'] = 'Oui'; }

			$account = AccountQuery::create()->findPk($form['id-account']);

			if($account) {

				if($form['password'] != '') {
					$authy = AuthyQuery::create()->findPk($account->getIdAuthy());
					$authySave['PasswdHash'] = md5($form['password']);
					$authy->fromArray($authySave);
					$authy->save();
				}

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
				$accountSave['IdVille'] = checkCity($request['ville'],$form['province'],$lang_sql);
				$accountSave['IdRegion'] = $form['region'];
				$accountSave['IdProvince'] = $form['province'];
				$accountSave['IdPays'] = $form['pays'];
				$accountSave['Workplace'] = $form['workplace'];
				$accountSave['Work'] = $form['work'];
				$accountSave['UsernameContest'] = $form['username-contest'];
				$accountSave['EmailContest'] = $form['email-contest'];
				$accountSave['PasswordContest'] = $form['password-contest'];
				$accountSave['AirMiles'] = $form['air-miles'];
				$accountSave['Proprietaire'] = $form['propriete'];

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

//POUR LES TESTS
/*$deleteAccount = AccountQuery::create()->filterByStatus('Ancien')->delete();
$deleteAuthy = AuthyQuery::create()->filterByGroup('Normal')->delete();

$file = _INSTALL_PATH.'mod/file/client.csv';
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
			$importAccount = '';
			$importAuthy = '';

			for ($col = 0; $col < $highestColumnIndex; ++ $col) {
				$cell = $worksheet->getCellByColumnAndRow($col, $row);
				$val = $cell->getValue();

				switch($col) {
					case 1: if($val == 'oui' OR $val == 'non') { $importAccount['Couple'] = ucfirst($val); } break;
					case 2: if($val == 'femme' OR $val == 'homme') { $importAccount['Sexe'] = ucfirst($val); } break;
					case 3: $importAccount['Firstname'] = $val; break;
					case 4: $importAccount['Lastname'] = $val; break;

					case 5: $importAccount['Address'] = $val;  break;
					case 6: $importAccount['Address'] .= ", ".$val; break;

					case 7: $importAccount['App'] = $val; break;
					case 8: $importAccount['PostalCode'] = $val; break;
					case 9: $importAccount['HomePhone'] = $val; break;

					case 10:
						$city = VilleQuery::create()->where('Ville.Title like "%'.$val.'%"')->findOne();
						if(count($city) == 0) { $importAccount['IdVille'] = 1690; $importAccount['IdRegion'] = 17; } else { $importAccount['IdVille'] = $city->getIdVille(); $importAccount['IdRegion'] = $city->getIdRegion(); }

					break;
					case 11:
						//VILLE SANS ACCENT
					break;

					case 13: $importAccount['IdProvince'] = 1; break;
					case 14: $importAccount['IdPays'] = 1; break;

					case 15: $importAccount['Email'] = $val; $importAuthy['Email'] = $val; $importAuthy['Username'] = $val; break;

					//NE TROUVE PAS LE COURRIEL POUR LES CONCOURS
					case 16: $importAccount['EmailContest'] = $cell->getFormattedValue();  break;

					//DIVISION DE LA DATE DE NAISSANCE
					//case 17: $importAccount['Lastname'] = $val; break;
					//case 18: $importAccount['Lastname'] = $val; break;
					case 20:
						$importAccount['BirthDate'] = date('Y-m-d',strtotime($val));
					break;
					case 22: $importAccount['UsernameContest'] = $val; break;
					case 23: $importAccount['HotmailPassword'] = $val; break;
					case 24: $importAuthy['PasswdHash'] = $val; break;
					case 25: $importAccount['CinochePassword'] = $val; break;
					case 26:
						//PROPRIÉTAIRE OU LOCATAIRE
					break;
					case 27: $importAccount['HbcCard'] = $val; break;
					case 28: $importAccount['AirMiles'] = $val; break;
					case 29: $importAccount['MillipleinCard'] = $val; break;
					case 30: $importAccount['MetroCard'] = $val; break;
					case 31: $importAccount['HersheyUsername'] = $val; break;
					case 32: $importAccount['HersheyPassword'] = $val; break;
					case 33: $importAccount['CantonUsername'] = $val; break;
					case 34: $importAccount['FacebookUsername'] = $cell->getHyperlink()->getUrl(); break;
					case 35: $importAccount['FacebookPassword'] = $val; break;
					case 36: $importAccount['PresseUsername'] = $val; break;
					case 37: $importAccount['CinocheUsername'] = $val; break;
					case 38: $importAccount['CasaUsername'] = $val; break;
					case 39: $importAccount['Workplace'] = $val; break;
					case 40: $importAccount['Work'] = $val; break;
				}

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

echo json_encode($return);
die();*/