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
    case 'login':
		$return['error'] = true;
		$return['class'] = 'login-error';

		if($_SESSION[_AUTH_VAR]->get('isConnected') == 'NO') {
			$authy = AuthyQuery::create()->where('(passwd_hash = "'.md5($request['password']).'" OR passwd_hash_temp = "'.md5($request['password']).'")')->filterByUsername($request['username'])->filterByDeactivate('Non')->findOne();

			if(count($authy) > 0){
				$form = new AuthyForm();
				$form->tryLog($authy->getUsername(), $authy->getPasswdHash());

				$return['error'] = false;
				$return['class'] = 'login-success';
				$return['message'] = _("Connexion réussi. Redirection en cours.");
			} else {
				$return['error'] = true;
				$return['class'] = 'login-error';
				$return['message'] = _("Nom d'usager / mot de passe non valide.");
			 }
		 } else {
			$return['error'] = true;
			$return['class'] = 'login-error';
			$return['message'] = _("Vous êtes déjà connecté.");
		 }

		echo json_encode($return);
		die();
    break;

	case 'forgot_password':
		$return['error'] = true;
		$return['class'] = 'password-return';
		$return['message'] = _("Aucun compte associé à ce courriel.");

		$data_user = AccountQuery::create()->filterByEmail($request['username'])->findOne();

		if($data_user && $data_user->getAuthy()->getDeactivate() == 'Non'){
			$newTmpPass = createRandomKey(8);
            
            AuthyQuery::create()->filterByIdAuthy($data_user->getIdAuthy())->update(array('PasswdHashTemp' => md5($newTmpPass)));

			$data_courriel = MailQuery::create()->findPk(6);
			$title = $data_courriel->getTranslation($lang_sql)->getTitle();
			$body = $data_courriel->getTranslation($lang_sql)->getText();

			if($data_courriel) {
				$body = str_replace('%%Prenom%%', $data_user->getFirstname(),$body);
				$body = str_replace('%%Nom%%', $data_user->getLastname(),$body);
				$body = str_replace('%%PasswordTemporaire%%', $newTmpPass ,$body);
				$body = str_replace('%%lien_website%%', _SITE_URL_HTTP,$body);

				sendHTMLemail($body, _FROM, $request['username'], $title, _FROM);

				$return['error'] = false;
				$return['message'] = _("Nous vous avons envoyé un courriel avec votre nouveau mot de passe.");
			}
		}

		echo json_encode($return);
		die();
	break;
}

