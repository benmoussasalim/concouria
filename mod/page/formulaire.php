<?php

//unset($_SESSION['Price']);
//unset($_SESSION['Promo']);

//$_SESSION['payment_method'] = $_SESSION['payment_method'] ? $_SESSION['payment_method'] : 'year';
$_SESSION['payment_method'] = $_SESSION['payment_method'] ? $_SESSION['payment_method'] : 'month';

if($request['i'] AND $request['i'] != '' AND $_SESSION[_AUTH_VAR]->get('isConnected') != 'YES') {
    $autoConnect = AccountQuery::create()->where(" md5(concat('"._PROJECT_NAME."',Account.IdAccount)) = ? ",$request['i'])->findOne();
    if($autoConnect) {
        $form = new AuthyForm();
        $form->tryLog($autoConnect->getAuthy()->getUsername(), $autoConnect->getAuthy()->getPasswdHash());
        header('Location:'._SITE_URL.'formulaire');
    }
}

$siteTitle = _("Mon profil").' - '._SITE_TITLE;

$blockArray = [3];

$headJs .= loadJs(_SITE_URL.'js/selectBox/selectbox.js').'
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script type="text/javascript">Stripe.setPublishableKey("'.($_SESSION[_AUTH_VAR]->get('group') == 'Admin' ? 'pk_test_Y752ZJBVg9CIB1oow9HYrr2w' : _PK_LIVE).'");</script>
';

$account = AccountQuery::create()->filterByIdAuthy($_SESSION[_AUTH_VAR]->get('id'))->findOne();

if($account) {
    $swMenu[] = ['Modifier le compte',_SITE_URL.'Account/edit/'.$account->getIdAccount()];
    
	if($request['payment'] == 'required') { $output['onReadyJs'] .= "setTimeout(function() { $('.step-header.abonnement').click(); },250);"; }

	if(!$_SESSION['Price'] AND !$_SESSION['Promo']['Free']) { $_SESSION['Price'] = (_PRIX_ABONNEMENT/100); }

	/*$basePrice = $_SESSION['Price'];

    if(!$_SESSION['Promo']['Free']) {
        $taxes = TaxeQuery::create()->useGrpTaxeQuery()->filterByIdGroupTaxeSup($account->getProvince()->getIdGrpTaxe())->endUse()->find();
        if($taxes) {
            foreach($taxes as $taxe) {
                $amount = number_format(($_SESSION['Price'] * $taxe->getPourcent()) / 100,2,'.',' ');

                $basePrice += $amount;

                $listTaxe .=
                div(
                    h3($taxe->getCode()."(".number_format($taxe->getPourcent(),3,'.',' ')."%)")
                    .p($amount."$")
                ,'','class="tax-wrapper"');
            }
        }
    }

	$_SESSION['FinalPrice'] = $basePrice;*/

	if($request['stripeToken']) {
		require_once(_INSTALL_PATH.'mod/stripe/init.php');

		\Stripe\Stripe::setApiKey($_SESSION[_AUTH_VAR]->get('group') =='Admin' ? 'sk_test_gUdNqyBWn0x948Y2l1L6OEBu' : _SK_LIVE);

		try {
			$charge = \Stripe\Charge::create(array(
				"amount" => ($_SESSION['FinalPrice'] * 100),
				"currency" => "cad",
				"source" => $request['stripeToken'],
				"description" => "Frais d'abonnement de ".$account->getFirstname()." ".$account->getLastname()
			));
            
            include _INSTALL_PATH.'mod/page/inc/ConfirmSale.php';

			$output['onReadyJs'] .= "throwMessage('"._("Paiement reçu. Merci")."',false,'card-success');";
			

		} catch(\Stripe\Error\Card $e) {
		  $output['onReadyJs'] .= "throwMessage('"._("Une erreur est survenu. Veuillez réessayer.")."',true,'card-error');";
		}
	}
    
	$today = strtotime('now');
	$paidDate = strtotime($account->getDateExpire());
	$expire = ceil(($paidDate - $today)/(60*60*24));

	$abonnementState = 'abonnement';
	$sectionState = 'disable';
	$abonnementMsg = $_SESSION['Price']."$";
    
    $noPayment = false;
    
	if($expire >= 0 && $account->getDateExpire() != '') {
        $blockArray[] = 8;

		$abonnementMsg = $abonnementNotice = abs($expire)." "._("jours restants.");
		$abonnementState = '';
		$sectionState = '';

		$sales = AbonnementQuery::create()->useSaleQuery()->filterByIdAccount($account->getIdAccount())->filterByStatut('Acceptée')->endUse()->orderBy('DatePaiement','DESC')->find();

		if($sales) {
			foreach($sales as $sale) {
                $typeLabel = _("Annuel");
                if($sale->getType() == 'Mensuel') { $typeLabel = _("Mensuel"); }
                
				$listSale .= li(href(span($typeLabel.' - '.$sale->getDatePaiement()).span(str_replace(',','.',$sale->getAmount()).'$'),_SITE_URL.'invoice?cmd='.md5($sale->getIdAbonnement()."CONCOURIA"),'target="_blank"'));
			}

			if($listSale) {
				$contentAbonnement =
				h3(_("Info abonnement"))
				.ul($listSale);
			}
		}
        
        $noPayment = true;
        
        if($expire <= 30 OR $account->getExportReady() == 'À renouveler') {
            $abonnementText = $contentAbonnement;
            $noPayment = false;
        }
	}
    
    if($account->getExportReady() == 'À renouveler') {
        $abonnementNotice = _("À renouveler");
        $abonnementState = 'abonnement';
        $noPayment = false;
        unset($blockArray[1]);
    }
    
    if($noPayment == false){
        $blockArray[] = 7;

		include _INSTALL_PATH.'mod/page/inc/AbonnementPrice.php';
        
        $currentMethod[$_SESSION['payment_method']] = 'checked';

		$contentAbonnement =
			
            /*h3(_("Méthode de paiement"))
            .div(
                div(
                    input('radio','payment_method','year',$currentMethod['year'],'year')
                    .label(_("Annuel"),'for="year"')
                ,'','class="checkbox-wrapper"')
                .div(
                    input('radio','payment_method','month',$currentMethod['month'],'month')
                    .label(_("Mensuel"),'for="month"')
                ,'','class="checkbox-wrapper"')
            ,'','class="payment-selection"')

			.*/$return['AbonnementPrice']

			.button(span(_("Procéder au paiement")),'class="'.$_SESSION['Promo']['Free'].' goto-paiement button-link gold"');
	}
    

    $blocks = BlockQuery::create()->filterByStatus('Publié')->filterByIdBlock($blockArray)->find();

    if($blocks) {
        foreach($blocks as $block) {
            $blockContent[$block->getIdBlock()] = div(div($block->getTranslation($lang_sql)->getText(),'',swEdit('Text',true)),'',['class="sw-block" data-block="'.$block->getIdBlock().'"',swEdit('Block',$block->getIdBlock(),$block->getTitle())]);
        }
    }
    
    if($blockContent[3] AND !$abonnementText) {
        $abonnementText =
            $blockContent[3]
            .div(
                img(_SITE_URL.'css/img/stripe.png')
                .p(_("Paiement sécuritaire"))
            ,'','class="paiement-method"')  
        ;
    }

	$request['IdPays'] = $account->getIdPays();
	$request['IdProvince'] = $account->getIdProvince();
	$request['IdRegion'] = $account->getIdRegion();
	$request['IdVille'] = $account->getIdVille();

	include _INSTALL_PATH.'mod/page/inc/SelectLocation.php';
    
    $currentSexe[$account->getSexe()] = 'selected';

	$content =
	div(
		div($blockContent[7].$blockContent[8],'','class="form-header wrapper"')

		.form(
			div(
				div(
					div(
						h2(span(_("Mes informations d'utilisateur")))

						.ul(
							li('','class="progression"')
							.li("",'class="step-status"')
						)
					,'','class="header-content"')
				,'','class="step-header trigger"')

				.div(
					div(
						label(_("Sexe"),'for="sexe"')
						.div(
							select('sexe',
								option(_("Homme"),'Homme',$currentSexe['Homme'])
								.option(_("Femme"),'Femme',$currentSexe['Femme'])
							,'class="progress required"')
						,'','class="input-wrapper select"')
					,'','class="input-block"')

					.div(
						label(_("Date de naissance"),'for="birth-date"')
						.div(input('text','birth-date',($_SESSION['form']['birth-date']) ? $_SESSION['form']['birth-date'] : $account->getBirthDate(),'class="required progress" placeholder="JJ/MM/AAAA"'),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Prénom"),'for="firstname"')
						.div(input('text','firstname',($_SESSION['form']['firstname']) ? $_SESSION['form']['firstname'] : $account->getFirstname(),'class="required progress"'),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Nom"),'for="lastname"')
						.div(input('text','lastname',($_SESSION['form']['lastname']) ? $_SESSION['form']['lastname'] : $account->getLastname(),'class="required progress"'),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Mot de passe"),'for="password"')
						.div(input('password','password',''),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Confirmer le mot de passe"),'for="confirm-password"')
						.div(input('password','confirm-password',''),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Adresse courriel personnelle"),'for="personnal-email"')
						.div(input('text','personnal-email',($_SESSION['form']['personnal-email']) ? $_SESSION['form']['personnal-email'] : $account->getEmail(),'class="required progress"'),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Numéro de téléphone"),'for="phone-number"')
						.div(input('text','phone-number',($_SESSION['form']['phone-number']) ? $_SESSION['form']['phone-number'] : $account->getHomePhone(),'class="required progress"'),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Autre numéro de téléphone"),'for="phone-number"')
						.div(input('text','other-phone',($_SESSION['form']['other-phone']) ? $_SESSION['form']['other-phone'] : $account->getOtherPhone(),'class="progress"'),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Numéro de téléphone cellulaire"),'for="cellulaire"')
						.div(input('text','cellulaire',($_SESSION['form']['cellulaire']) ? $_SESSION['form']['cellulaire'] : $account->getCellphone()),'','class="input-wrapper"')
					,'','class="input-block"')
                    
                    .div(
						label(_('Extension de téléphone au travail'),'for="ext_phone"')
						.div(input('text','ext_phone',($_SESSION['form']['ext_phone']) ? $_SESSION['form']['ext_phone'] : $account->getExtPhone(),'class="progress"'),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("La compagnie pour laquelle vous travaillez"),'for="workplace"')
						.div(input('text','workplace',($_SESSION['form']['workplace']) ? $_SESSION['form']['workplace'] : $account->getWorkplace(),'class="progress"'),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Emploi"),'for="work"')
						.div(input('text','work',($_SESSION['form']['work']) ? $_SESSION['form']['work'] : $account->getWork(),'class="progress"'),'','class="input-wrapper"')
					,'','class="input-block"')

				,'','class="step-content"')

			,'','class="step-wrapper"')

			.div(
				div(
					div(
						h2(span(_("Mon abonnement")))

						.ul(
							li($abonnementNotice,'class="abonnement-status"')
							.li("",'class="step-status"')
						)
					,'','class="header-content"')
				,'','class="step-header trigger '.$abonnementState.'"')

				.div(
					div(

						div($abonnementText,'','class="section-paiement"')

						.div($contentAbonnement,'','class="section-paiement resume"')
						.div(
                            div(
                                label(_("Numéro de carte"),'for="firstname-pay"')
                                .div(input('text','','','class="required js-prevent-key" data-stripe="number" placeholder="0000 0000 0000 0000"'),'','class="input-wrapper"')
                            ,'','class="input-block"')

                            .div(
                                label(_("Expiration (Mois / Année)"))
                                .div(input('text','','','class="required js-prevent-key" data-stripe="exp_month" placeholder="00"'),'','class="input-wrapper"')
                                .div(input('text','','','class="required js-prevent-key" data-stripe="exp_year" placeholder="00"'),'','class="input-wrapper"')
                            ,'','class="input-block"')

                            .div(
                                label(_("CVC"),'for="email-pay"')
                                .div(input('text','','','class="required js-prevent-key" data-stripe="cvc" placeholder="000"'),'','class="input-wrapper"')
                            ,'','class="input-block"')

                            .div(
                                input('checkbox','conditions')
                                .label(_("J'ai lu et j'accepte les ".href(_("conditions et termes du contrat"),_SITE_URL.'termes-du-contrat','target="_blank"')."."),'for="conditions"')
                            ,'','class="checkbox-wrapper"')

                            .button(span(_("Payer mon abonnement")),'class="complete-paiement button-link green"')
                        ,'','class="section-paiement paiement"')
					,'','class="section-wrapper"')

				,'','class="step-content"')

			,'','class="step-wrapper abonnement"')

			.div(
				div(
					div(
						h2(span(_("Lieu de résidence")))

						.ul(
							li('','class="progression"')
							.li("",'class="step-status"')
						)
					,'','class="header-content"')
				,'','class="step-header trigger '.$sectionState.'"')

				.div(
					div(
						label(_("Adresse civique"),'for="adresse-civique"')
						.div(input('text','adresse-civique',($_SESSION['form']['adresse-civique']) ? $_SESSION['form']['adresse-civique'] : $account->getAddress(),'class="required progress"'),'','class="input-wrapper"')
					,'','class="input-block address"')

					.div(
						label(_("App."),'for="app"')
						.div(input('text','app',($_SESSION['form']['app']) ? $_SESSION['form']['app'] : $account->getApp(),'class="progress"'),'','class="input-wrapper"')
					,'','class="input-block app"')

					.div(
						label(_("Code postal"),'for="code-postal"')
						.div(input('text','code-postal',($_SESSION['form']['code-postal']) ? $_SESSION['form']['code-postal'] : $account->getPostalCode(),'class="required progress"'),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Vous êtes..."),'for="propriete"')
						.div(
							select('propriete',
								option(_("Locataire"),'Locataire',$account->getProprietaire() == 'Locataire' ? 'selected' : '')
								.option(_("Propriétaire"),'Propriétaire',$account->getProprietaire() == 'Propriétaire' ? 'selected' : '')
							)
						,'','class="input-wrapper select"')
					,'','class="input-block"')
                    
                    .div(
						label(_("Ville"),'for="ville"')
						.div(input('text','ville',($_SESSION['form']['ville']) ? $_SESSION['form']['ville'] : $account->getVille()->getTranslation($lang_sql)->getName(),'class="required progress"'),'','class="input-wrapper"')
					,'','class="input-block"')
                    
                    .div(
						label(_("Région"),'for="region"')
						.div(
							$output['SelectRegion']
						,'','class="input-wrapper select"')
					,'','class="input-block"')
                    
                    .div(
						label(_("Province"),'for="province"')
						.div(
							$output['SelectProvince']
						,'','class="input-wrapper select"')
					,'','class="input-block"')

					.div(
						label(_("Pays"),'for="pays"')
						.div(
							$output['SelectPays']
						,'','class="input-wrapper select"')
					,'','class="input-block"')
					

					/*.div(
						label(_("Région"),'for="region"')
						.div(
							$output['SelectRegion']
						,'','class="input-wrapper select"')
					,'','class="input-block"')*/

					/*.div(
						label(_("Ville"),'for="ville"')
						.div(
							$output['SelectVille']
						,'','class="input-wrapper select"')
					,'','class="input-block ville"')*/
				,'','class="step-content"')

			,'','class="step-wrapper"')

			.div(
				div(
					div(
						h2(span(_("Informations pour les concours")))

						.ul(
							li('','class="progression"')
							.li("",'class="step-status"')
						)
					,'','class="header-content"')
				,'','class="step-header trigger '.$sectionState.'"')

				.div(
					div(
						label(_("Adresse courriel pour les concours*"),'for="email-contest"')
						.div(input('text','email-contest',($_SESSION['form']['email-contest']) ? $_SESSION['form']['email-contest'] : $account->getEmailContest(),'class="required progress"'),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Mot de passe de cette adresse courriel"),'for="password-contest"')
						.div(input('text','password-email-contest',($_SESSION['form']['password-email-contest']) ? $_SESSION['form']['password-email-contest'] : $account->getPasswordEmailContest(),'class="required progress"'),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Compte utilisateur pour les concours"),'for="username-contest"')
						.div(input('text','username-contest',($_SESSION['form']['username-contest']) ? $_SESSION['form']['username-contest'] : $account->getUsernameContest(),'readonly placeholder="'._("Généré par le système").'"'),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Carte Air Miles"),'for="air-miles"')
						.div(input('text','air-miles',($_SESSION['form']['air-miles']) ? $_SESSION['form']['air-miles'] : $account->getAirMiles(),'class="progress"'),'','class="input-wrapper"')
					,'','class="input-block"')
                    
                    .div(
						label(_("Êtes-vous le seul membre Concouria à cette adresse civique?"),'for="couple"')
						.div(
                            select('couple',
                               option('Oui','Non',$account->getCouple() == 'Non' ? 'selected' : '')
                               .option('Non','Oui',$account->getCouple() == 'Oui' ? 'selected' : '')
                            )
                        ,'','class="input-wrapper select"')
					,'','class="input-block"')
                    
                    .div(
                        p(_("*Concouria doit absolument avoir accès au compte de messagerie de concours des abonnés."))
                    ,'','class="step-notice"')

				,'','class="step-content"')

			,'','class="step-wrapper"')

			.button(span(_("Enregistrer")),'class="button-link green save-change"')

			.input('hidden','id-account',$account->getIdAccount())
			.input('hidden','id-authy',$account->getIdAuthy())

		,'class="wrapper" id="form-complete" method="POST"')
	,'',['class="form-page"',swEdit('bg')]);
    
    /*ANNULATION DE L'ABONNEMENT
    $output['onReadyJs'] .= "
        $('.js-cancel-payment').click(function() {
            $.post(_SITE_URL + 'mod/act_p/AccountAct.php', {a:'CancelPlan'},function(data) {
                throwMessage(data.message,data.error,data.class);
            },'json');
            return false;
        });
    ";*/

    /*PAIEMENT RÉCURRENT
    $output['onReadyJs'] .= "
        $('.js-plan-payment').click(function() {
            if(payment_rdy == true) {
                payment_rdy = false;

                $('.section-paiement.paiement .input-block input').each(function() {
                    if($(this).val() == '') {
                        $(this).parent().addClass('form-error');
                        throwMessage('"._('Veuillez remplir tous les champs de paiement.')."',true,'facturation-error');
                    } else { $(this).parent().removeClass('form-error'); }
                });

                if(!$('.section-paiement #conditions').is(':checked')) { throwMessage('"._("Veuillez accepter les termes du contrat.")."', true,'contrat'); }

                if(!$('.section-paiement .input-wrapper.form-error').length && $('.section-paiement #conditions').is(':checked')) { 
                    Stripe.card.createToken($('#form-complete'), function(status, response) {
                        if(response.error) {
                            payment_rdy = true;
                            throwMessage('"._("Informations non valide.")."',true,'token-error');
                        } else {
                            payment_rdy = false;
                            
                            $.post(_SITE_URL + 'mod/act_p/AccountAct.php',{a:'PlanPayment', 'token': response.id, 'form': $('#form-complete').serialize() },function(data) {
                                console.log(data);
                            },'json');
                        }
                    }); 

                } else { payment_rdy = true; }

            } else {
                throwMessage('".addslashes(_("Paiement en cours. Veuillez patienter."))."',true,'payment-pending');
            }
            
            return false;
        });
    ";*/
    
    $coupleInput =
        div(
            label(_("Quel est le courriel personnel associé au membre résident à la même adresse?"),'for="couple_address"')
            .div(input('text','couple_address',($_SESSION['form']['couple_address']) ? $_SESSION['form']['couple_address'] : '','class="progress required"'),'','class="input-wrapper"')
        ,'','class="input-block couple" style="display: none;"')
    ;
    
    //PARTICIPATION COUPLE 
    $output['onReadyJs'] .= "
		$('.input-wrapper select#couple').change(function() {
			if($(this).val() == 'Oui') {
                $(this).parents('.input-block').after('".addslashes($coupleInput)."');
                $('.input-block.couple').fadeIn(200);
                checkProgression();
            } else {
                $('.input-block.couple').fadeOut(200,function() {
                    $('.input-block.couple').remove();
                    checkProgression();
                });               
            }
		});
	";
        
	//KEYUP SUR L'EXPIRATION
	$output['onReadyJs'] .= "
		$('.input-wrapper input[data-stripe=\"exp_month\"]').keyup(function() {
			if($(this).val().length == 2) { $('.input-wrapper input[data-stripe=\"exp_year\"]').focus(); }
		});
	";

	$output['windowScroll'] .= "
		var footer_top = $('.sw-footer').offset().top, header_height = $('.sw-header').outerHeight(), btn_top = $('.save-change').offset().top, btn_height = $('.save-change').outerHeight(), window_top = $(window).scrollTop(), window_height = $(window).height();

		if(window_top + window_height <= footer_top) {
			$('.save-change').css({'top': (window_top - header_height + (window_height - btn_height - 20)) + 'px'});
		}
	";

	$output['onReadyJs'] .= "
		$('#form-complete').delegate('#region,#province,#pays','change', function() {
			var IdPays = $('#form-complete #pays').val();
			var IdRegion = $('#form-complete #region').val();
			var IdProvince = $('#form-complete #province').val();
			var IdVille = $('#form-complete #ville').val();

			$.post('"._SITE_URL."mod/act_p/AccountAct.php', { a: 'SelectLocation', IdPays:IdPays, IdRegion:IdRegion, IdProvince:IdProvince, IdVille:IdVille },function(data) {

				$('#form-complete #pays').parent().html(data.SelectPays);
				$('#form-complete #province').parent().html(data.SelectProvince);
				$('#form-complete #region').parent().html(data.SelectRegion);
				$('#form-complete #ville').parent().html(data.SelectVille);
			},'json');
		});
	";

	$output['onReadyJs'] .= "
		$('.goto-paiement').click(function() {
            if($(this).hasClass('free-subscription')) {
                $.post(_SITE_URL + 'mod/act_p/AccountAct.php',{a:'bypassPayment'},function(data) {
                    throwMessage(data.message,data.error,data.class);
                    if(data.error == false) { setTimeout(function() { window.location.reload(false); },1500); }
                },'json');
            } else {
                $('.section-wrapper').toggleClass('paiement');
                if($( window ).width() < 1024){
                    $('.section-paiement.paiement').slideToggle();
                }
            }
			
			return false;
		});

		$('#form-complete #birth-date').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy',
			yearRange: \"-100:+0\",
			showAnim: 'slideDown'
		});
		$('#form-complete #birth-date').datepicker('setDate','".str_replace('/','-',$account->getBirthDate())."');


		$('.step-header').click(function() {
			if($(this).hasClass('disable')) {
				throwMessage('".addslashes(_("Veuillez compléter le paiement tout d'abord."))."',true,'not-paid');
				$('.step-header.abonnement').next('.step-content').slideDown();
				$('.step-header.abonnement').removeClass('trigger');

				$('body,html').animate({scrollTop: $('.step-header.abonnement').offset().top},1500,function() { $(window).scroll(); });
			} else {
				$(this).next('.step-content').slideToggle();
				$(this).toggleClass('trigger');
			}

			$(window).scroll();

			return false;
		});

		$('.save-change').click(function() {
            var export_ready = 'Non';

			checkStep();
			checkProgression();

			if($('#form-complete #confirm-password').val() == $('#form-complete #password').val()) {
				var geocoder = new google.maps.Geocoder();
				var address = $('#form-complete #ville').val() + ' ' + $('#form-complete #code-postal').val();

				geocoder.geocode({'address': address}, function(results, status) {
					if(status == google.maps.GeocoderStatus.OK) {
                        if(!$('.step-header.not-complete').length) { export_ready = 'Oui'; }

						$.post('"._SITE_URL."mod/act_p/AccountAct.php', { a:'saveAccount', export_ready: export_ready, form: $('#form-complete').serialize(), ville: results[0].address_components }, function(data) {
						$.each(data, function(index,value) {
							throwMessage(value.message,value.error,value.class);
							if(value.error == false) {
								$('body,html').animate({ scrollTop: $('.form-header').offset().top });

								$('.step-content').slideUp();
								$('.step-header').removeClass('trigger');
							}
						});
					},'json');
					} else { throwMessage('Ville introuvable. Veuillez réessayer.',true,'no-location'); }
				});

			} else { throwMessage('"._("Les mots de passe ne sont pas identiques.")."',true,'password'); }

			return false;
		});

        var key_timer;
		$('#form-complete').on('keyup', 'input:not(.js-prevent-key)', function(e) {
            clearTimeout(key_timer);
            var _this = $(this);
            key_timer = setTimeout(function() {
                var keyCode = e.keyCode || e.which;
                saveField(_this);
            },300);
		});

		$('#form-complete').on('focusout', 'input:not(.js-prevent-key)', function(e) { saveField($(this)); });

		$('.complete-paiement').click(function() {
            if(payment_rdy == true) {
                payment_rdy = false;

                $('.section-paiement.paiement .input-block input').each(function() {
                    if($(this).val() == '') {
                        $(this).parent().addClass('form-error');
                        throwMessage('"._('Veuillez remplir tous les champs de paiement.')."',true,'facturation-error');
                    } else { $(this).parent().removeClass('form-error'); }
                });

                if(!$('.section-paiement #conditions').is(':checked')) { throwMessage('"._("Veuillez accepter les termes du contrat.")."', true,'contrat'); }

                if(!$('.section-paiement .input-wrapper.form-error').length && $('.section-paiement #conditions').is(':checked')) { 
                    Stripe.card.createToken($('#form-complete'), function(status, response) {
                        if(response.error) {
                            payment_rdy = true;
                            throwMessage('"._("Informations non valide.")."',true,'token-error');
                        } else {
                            payment_rdy = false;
                            
                            loadingOverlay('".addslashes(_("Paiement en cours. Veuillez patienter."))."');
                            $.post(_SITE_URL + 'mod/act_p/AccountAct.php',{a:'PlanPayment', 'token': response.id, 'form': $('#form-complete').serialize() },function(data) {
                                throwMessage(data.message,data.error,data.class);
                                loadingOverlay();
                                if(data.error == false) { setTimeout(function() { location.reload(); },2000); }
                            },'json').fail(function() {
                                loadingOverlay();
                                payment_rdy = true;
                            });
                        }
                    }); 
                } else { payment_rdy = true; }

                /*if(data.error == false) {
                    $('.step-header.abonnement').click();
                    $('.step-header').removeClass('disable abonnement');

                    $('.section-paiement .price-wrapper .price, .step-header .abonnement-status').fadeOut(250, function() {
                        $('.section-paiement .price-wrapper .price, .step-header .abonnement-status').text(data.date);
                        $('.section-paiement .price-wrapper .price, .step-header .abonnement-status').fadeIn(250);
                    });
                }*/
            } else {
                throwMessage('".addslashes(_("Paiement en cours. Veuillez patienter."))."',true,'payment-pending');
            }

			return false;
		});

		checkProgression();
	";

	$output['js'] .= "
        var payment_rdy = true;

		function stripeResponseHandler(status, response) {
			if(response.error) {
                payment_rdy = true;
				throwMessage('"._("Informations non valide.")."',true,'token-error');
			} else {
                payment_rdy = false;
				var token = response.id;

				$('#form-complete').append('<input type=\"hidden\" name=\"stripeToken\" value=\"' + token + '\" />');
				$('#form-complete').get(0).submit();
			}
		}

		function saveField(input) {
			$.post('"._SITE_URL."mod/act_p/AccountAct.php',{ a: 'saveInput', name: input.attr('name'), value: input.val() });
		}

		function checkProgression() {
			$('.step-wrapper').each(function() {
				var input_fill = 0, input_nbr = 0, input_required = 0, header = $(this).find('.step-header');
				$(this).find('input.progress,textarea.progress,select.progress').each(function() {
					if($(this).val() != '' && $(this).val() != 'all') { input_fill++; }
					if($(this).val() == '' && $(this).hasClass('required') || $(this).val() == 'all' && $(this).hasClass('required')) { input_required++; header.addClass('not-complete');  }
					input_nbr++;
				});
                
                if(input_required == 0) { $(this).find('.step-header').removeClass('not-complete'); }

				$(this).find('.step-header li.progression').html(input_required + ' "._("champ(s) manquant(s)")." ['+ input_fill +'/'+ input_nbr +']');
			});
		}

		function checkStep() {
			$('.step-wrapper:not(.abonnement)').each(function() {
				var i = 1;
				$(this).find('input,textarea,select').each(function() {
					if($(this).hasClass('required') && ($(this).val() == '' || $(this).val() == 'all')) {
						$(this).addClass('form-error');
					}
					i++;
				});

				var validate = validateForm($(this));

				if(validate == false) { 
                    $(this).find('.step-header').addClass('not-complete'); throwMessage('"._("Votre inscription est incomplète.")."',true,'not-complete'); 
                } else { $(this).find('.step-header').removeClass('not-complete'); }
			});
		}
	";
    
    //MÉTHODE DE PAIEMENT
	$output['onReadyJs'] .= "
		$('.payment-selection input[name=\"payment_method\"]').on('change',function() {
            $.post(_SITE_URL + 'mod/act_p/AccountAct.php',{ a: 'refreshPayment', method: $(this).val() },function(data) {
                $('[data-section=\"AbonnementPrice\"]').html(data);
            });
        });
	";

	//CODE PROMO
	$output['onReadyJs'] .= "
		$('#form-complete').on('focusout','#promo-code',function() {
			promoCode();
		});

		$('#form-complete').on('keydown','#promo-code',function() {
			if(event.keyCode == 13) {
				promoCode();
				event.preventDefault();
				return false;
			 }
		});
	";
    
	$output['js'] .= "
		var promo = '';
		var pending_promo = false;

		function promoCode() {
			if($('#promo-code').val() != '' && promo != $('#promo-code').val() && pending_promo == false) {
				pending_promo = true;
				promo = $('#promo-code').val();

				$.post('"._SITE_URL."mod/act_p/AccountAct.php',{ a: 'promoCode', code: $('#promo-code').val(), IdGrpTaxe: ".$account->getProvince()->getIdGrpTaxe()."}, function(data) {
					pending_promo = false;
					throwMessage(data.message,data.error,data.class);
                    
                    if(data.free) { $('.goto-paiement').addClass(data.free); }

					if(data.error == false) {
						$('.section-paiement .block-price').fadeOut(250, function() {
							$('[data-section=\"AbonnementPrice\"]').html(data.AbonnementPrice);
							$('.section-paiement .block-price').fadeIn(250);
						});

						$('.promo-code .input-wrapper').after('<p><span>'+ data.amount +'</span></p>');
						$('.promo-code input').attr('disabled','disabled');
						setTimeout(function() { $('.promo-code').addClass('active-promo'); },100);
					}
				},'json');
			}
		}
	";
} else { header('Location:'._SITE_URL.'404?error=account'); }

