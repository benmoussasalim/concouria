<?php

//include _INSTALL_PATH.'mod/page/inc/SelectLocation.php';

$ville = VilleQuery::create()->join('VilleI18n')->useVilleI18nQuery('', 'join')->groupBy('Name')->filterByLocale($lang_sql)->endUse()->select(array('VilleI18n.Name', 'IdVille'))->orderBy('VilleI18n.Name', 'ASC')->find();
$villeSelect = assocToNumDef($ville->toArray(), false);

$province = ProvinceQuery::create();
$pcDataO = $province->useProvinceI18nQuery('','join')->filterByLocale($lang_sql)->endUse()
		->select(array('ProvinceI18n.Name', 'IdProvince'))
		->orderBy('ProvinceI18n.Name', 'ASC')->find();
$arrayProvinceOptions = assocToNumDef($pcDataO->toArray(), false);

$region = 
    RegionQuery::create()
    ->join('RegionI18n')
    ->addJoinCondition("RegionI18n","RegionI18n.Locale = '".$lang_sql."'")
    ->select(array('RegionI18n.Name', 'IdRegion'))
    ->orderBy('RegionI18n.Name', 'ASC')
    ->groupBy('RegionI18n.Name')
    ->find()
;
$arrayRegionOptions = assocToNumDef($region->toArray(), false);

if($_SESSION[_AUTH_VAR]->get('isConnected') == 'NO') {
	$loginLink = href(_("Connexion"),_SITE_URL,'class="login-link trigger-login" title="Connexion"');

} else {
    $jsLogin = 'js-disable-login';
    
	$loginLink =
		href(_("Mon profil"),_SITE_URL.'formulaire','class="login-link connected" title="Mon profil"')
		. href(_("Déconnexion"),_SITE_URL.'disconnect','class="disconnect" title="Déconnexion"');
}

$langArray['fr_CA']['current'] = href(span('English'),_SITE_URL.'?lg=en_US');
$langArray['fr_CA']['label'] = li(href(span('Français'),_SITE_URL.'?lg=fr_CA','class="flag quebec"',_("Français")));

$langArray['en_US']['current'] = href(span('Français'),_SITE_URL.'?lg=fr_CA');
$langArray['en_US']['label'] = li(href(span('English'),_SITE_URL.'?lg=en_US','class="flag canada"',_("English")));

foreach($langArray as $lang => $contentLang) {
    if($lang == $lang_sql) { $currentLang = $contentLang['current']; }
}

$currentFlag = p(_("Canada"),'class="flag canada"');
$langList = 
    li(p(_("Québec"),'class="flag quebec"'))
    .li(p(_("Terre-Neuve"),'class="flag newfoundland"'))
    .li(p(_("Ontario"),'class="flag ontario"'))
    .li(p(_("Manitoba"),'class="flag manitoba"'))
    .li(p(_("Colombie-Britannique"),'class="flag british-columbia"'))
    .li(p(_("Saskatchewan"),'class="flag saskatchewan"'))
    .li(p(_("Nouvelle-Écosse"),'class="flag new-scotia"'))
    .li(p(_("Nouveau-Brunswick"),'class="flag new-brunswick"'))
    .li(p(_("Alberta"),'class="flag alberta"'));

$conceptContentQuery = ContentQuery::create()->filterBySlug('abonnement')->findOne();
if($conceptContentQuery) { $conceptContent = div(div($conceptContentQuery->getTranslation($lang_sql)->getText(),'',swEdit('Text',true)),'',swEdit('Content',$conceptContentQuery->getIdContent(),$conceptContentQuery->getNameMenu())); }

$contactBlock = BlockQuery::create()->filterByStatus('Publié')->filterByIdBlock(19)->findOne();
if($contactBlock) {
    $contactBlockContent = div(div($contactBlock->getTranslation($lang_sql)->getText(),'',swEdit('Text',true)),'',['class="input-block contact"',swEdit('Block',$contactBlock->getIdBlock(),$contactBlock->getTitle())]);
}


$htmlOutput =
	div(
		div(
			$loginLink
			.ul(
                li(
                    $currentFlag
                    .ul($langList)
                ,'class="language-selection"')
                .li($currentLang)
				.li(href(_("Accueil"),_SITE_URL, 'title="Accueil"'))
				.li(href(_("FAQ"),_SITE_URL.'faq', 'title="FAQ"'))
				.li(href(_("Contact"),'','class="trigger-contact" title="Contact"'))
			)
		,'','class="wrapper"')
	,'','class="top-nav"')

	.nav(
		div(
			ul(
				li(href(_("Le concept"),_SITE_URL.'la-compagnie', 'title="Le concept"'))
				.li(
                    href(_("Concours"),_SITE_URL.'concours', 'title="Concours"')
                    .ul(
                        li(href(_('1- Tirés cette semaine'),_SITE_URL.'concours/toss',true))
                        .li(href(_('2- Récemment ajoutés'),_SITE_URL.'concours/new',true))
                        .li(href(_('3- Tous les concours'),_SITE_URL.'concours/all',true))
                    )
                )
				.li(href(_("Prix gagnés"),_SITE_URL.'liste-des-gagnants', 'title="Prix gagnés"'))
			,'class="left-nav"')

			.href(img(_SITE_URL.'css/img/logo.png',NULL,NULL,swEdit('img'),'Concouria'),_SITE_URL,'class="logo"','Concouria')

			.ul(
				li(href(_("Statistiques"),_SITE_URL.'statistiques','',true))
				.li(href(_("Témoignages"),_SITE_URL.'temoignages','',true))
				.li(href(_("Je m'inscris"),_SITE_URL,'class="trigger-subscribe '.$jsLogin.'"',true))
			,'class="right-nav"')

			.button(_("Menu"),'class="menu-btn trigger-menu"')
		,'','class="wrapper"')

		.div(
			div(
				button(_("Fermer"),'class="trigger-login close-btn"')

				.h3(_("Connexion"))
			,'','class="login-header"')
			.form(
				div(
					div(
						label(_("Courriel"),'for="username"')
						.div(input('text','username','','class="required"'),'','class="input-wrapper"')
					,'','class="input-block"')

					.div(
						label(_("Mot de passe"),'for="password"')
						.div(input('password','password','','class="required"'),'','class="input-wrapper"')
					,'','class="input-block"')
				,'','class="login-input"')

				.href(_("Vous avez oublié votre mot de passe?"),'#','class="forgot-password"')
				.button(span(_("Connexion")),'class="button-link gold"')
			,'id="login-form"')
		,'','class="login-content"')
        
        .div(
			div(
				button(_("Fermer"),'class="trigger-subscribe close-btn"')
			,'','class="inscpription-header"')

			.div($conceptContent,'','class="concept-text"')
            .button(span(_("Je m'inscris")),'class="confirm-subscribe button-link green"')
		,'','class="concept-content"')

		.div(
			div(
				button(_("Fermer"),'class="close-subscribe close-btn"')

				.h3(_("Inscription"))
				.p(_("Préliminaire"),'class="step"')
				.p(_("Créez votre compte préliminaire (Étape 1) en complétant ce court formulaire qui vous servira à vous connecter à votre profil Concouria."))
				.p(_("Les champs marqués d'un * sont obligatoires."),'class="notice"')

			,'','class="inscpription-header"')

			.form(

				div(
					label(_("Sexe*"),'for="sexe"')
					.div(
						select('sexe',
							option(_("Homme"),'Homme')
							.option(_("Femme"),'Femme')
						)
					,'','class="input-wrapper select cut"')
				,'','class="input-block"')

				.div(
					label(_("Prénom*"),'for="firstname"')
					.div(input('text','firstname','','class="required"'),'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Nom*"),'for="lastname"')
					.div(input('text','lastname','','class="required"'),'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Adresse*"),'for="address"')
					.div(input('text','address','','class="required"'),'','class="input-wrapper"')
				,'','class="input-block"')

                .div(
					label(_("Ville*"),'for="city"')
					.div(input('text','city','','class="required"'),'','class="input-wrapper"')
					//.div(select('ville',$villeSelect,'class="required"'),'','class="input-wrapper select"')
				,'','class="input-block ville"')

                .div(
					label(_("Région*"),'for="region"')
					.div(select('region',$arrayRegionOptions,'class="required"'),'','class="input-wrapper select"')
				,'','class="input-block"')

				.div(
					label(_("Province*"),'for="province"')
					.div(select('province',$arrayProvinceOptions,'class="required"',1),'','class="input-wrapper select"') //QUÉBEC PAR DÉFAUT
				,'','class="input-block"')


				.div(
					label(_("Code postal*"),'for="postal_code"')
					.div(input('text','postal_code','','class="required"'),'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Tél. résidentiel*"),'for="home_phone"')
					.div(input('text','home_phone','','class="required"'),'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Tél. au travail"),'for="other_phone"')
					.div(input('text','other_phone',''),'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Tél. cellulaire"),'for="cellulaire"')
					.div(input('text','cellulaire',''),'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Date de naissance*"),'for="birth_date"')
					.div(input('text','birth_date','','class="required" placeholder="JJ/MM/AAAA"'),'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Courriel pour connexion Concouria*"),'for="email"')
					.div(input('text','email','','class="required"'),'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Mot de passe pour connexion Concouria*"),'for="password"')
					.div(input('password','password','','class="required"'),'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Confirmer le mot de passe*"),'for="repeat-password"')
					.div(input('password','repeat-password','','class="required"'),'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Référence"),'for="reference"')
					.div(input('text','reference',''),'','class="input-wrapper"')
				,'','class="input-block"')

				.div('<div class="g-recaptcha" data-sitekey="6LdWoCkTAAAAAC-nLOSBGMHF1riom-uVN3JZC5IY"></div>','','class="captcha-wrapper"')

				.button(span(_("S'inscrire")),'class="button-link green"')

			,'id="inscription-form"')
		,'','class="inscription-content"')

		.div(
			div(
				h3(_("Contact"))
				.button(_("Fermer"),'class="trigger-contact close-btn"')
			,'','class="contact-header"')
			.form(
				$contactBlockContent

				.div(
					label(_("Prénom"),'for="firstname"')
					.div(
						input('text','firstname','','class="required"')
					,'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Nom"),'for="lastname"')
					.div(
						input('text','lastname','','class="required"')
					,'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Adresse courriel"),'for="email"')
					.div(
						input('text','email','','class="required"')
					,'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Téléphone"),'for="phone"')
					.div(
						input('text','phone','')
					,'','class="input-wrapper"')
				,'','class="input-block"')

				.div(
					label(_("Message"),'for="message"')
					.div(
						textarea('message','','class="required"')
					,'','class="input-wrapper"')
				,'','class="input-block textarea"')

				.button(span(_("Soumettre")),'class="button-link green"')
			,'id="form-contact"')
		,'','class="contact-content"')

	,'class="main-nav"')

	.div(
		button(_("Fermer"),'class="close-btn trigger-menu"')
		.href(img(_SITE_URL.'css/img/logo.png'),_SITE_URL,'class="logo"')

		.ul(
			li(href(_("Accueil"),_SITE_URL),'class="top-nav-link"')
			.li(href(_("Le concept"),_SITE_URL.'la-compagnie', 'title="Le concept"'))
			.li(href(_("Concours"),_SITE_URL.'concours', 'title="Concours"'))
			.li(href(_("Prix gagnés"),_SITE_URL.'liste-des-gagnants', 'title="Prix gagnés"'))
			.li(href(_("Statistiques"),_SITE_URL.'statistiques', 'title="Statistiques"'))
			.li(href(_("Témoignages"),_SITE_URL.'temoignages', 'title="Témoignages"'))
			.li(href(_("Inscription"),_SITE_URL,'class="trigger-subscribe trigger-menu"'))
			.li(href(_("FAQ"),_SITE_URL.'faq'),'class="top-nav-link"')
			.li(href(_("Contact"),_SITE_URL.'contact','class="trigger-contact"'),'class="top-nav-link"')
		)
	,'','class="mobile-menu"');

//CONTACT
$output['onReadyJs'] .= "
	$('.trigger-contact').click(function() {
		$('.contact-content').toggleClass('toggle');
        $('.mobile-menu').removeClass('trigger');
		window.scrollTo(0,0);
        return false;
	});

	$('#form-contact').submit(function() {
		var validate = validateForm($(this));

		if(validate == false) { throwMessage('"._("Veuillez remplir les champs obligatoires.")."',true,'form-error'); }
		else {
			$.post('"._SITE_URL."mod/act_p/ContactAct.php',{ a: 'sendForm', form: $('#form-contact').serialize() },function(data) {
				throwMessage(data.message,data.error,data.class);

				if(data.error == false) { $('.contact-content').toggleClass('toggle'); }
			},'json');
		}

		return false;
	});
";

// GÉNÉRAL
$output['onReadyJs'] .= "
	$('.trigger-menu').click(function() {
                if($('.mobile-menu').hasClass('trigger')){
                    $('.mobile-menu').removeClass('trigger');
                    $('.mobile-menu').delay(700).fadeOut(500,function() {
                    });
                }
                else{
                    $('.mobile-menu').fadeIn(500,function() {
                        $('.mobile-menu').width($('.top-nav').width());
                        $('.mobile-menu').addClass('trigger');
                    });
                }
		return false;
	});

	$('.trigger-subscribe').click(function() {
        if(!swActive()) {
            if($(this).hasClass('js-disable-login')) {
                throwMessage('"._("Vous êtes déjà connecté.")."',true,'error');
           } else {
               if($(window).scrollTop() > $(window).height()) { $('body,html').animate({scrollTop: 0}, 1000); }
               $('.concept-content').toggleClass('trigger');
               /*$('.inscription-content').toggleClass('trigger');*/
           }
           
           return false;
        }
	});
    
    $('.confirm-subscribe').click(function() {
		$('body,html').animate({scrollTop: 0}, 1000);
		$('.concept-content').toggleClass('trigger');
		$('.inscription-content').toggleClass('trigger');
		return false;
	});
    
    $('.close-subscribe').click(function() {
		$('.inscription-content').toggleClass('trigger');
		return false;
	});
    

	$('.trigger-login').click(function() {
		$('.login-content, .black-overlay').toggleClass('trigger');
		return false;
	});

	$('.input-block input, .input-block textarea').focusin(function() {
		$(this).parent().removeClass('filled');
		$(this).parent().addClass('focus');
	});

	$('.input-block input, .input-block textarea').focusout(function() {
		if($(this).val() == '') { $(this).parent().removeClass('focus'); } else { $(this).parent().addClass('filled'); }
	});
";

// INSCRIPTION
$output['onReadyJs'] .= "
	$('#inscription-form #birth_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		yearRange: \"-100:+0\",
		showAnim: 'slideDown'
	});

	$('#inscription-form #birth_date').keydown(function() { return false; });

	var city_update = false;
	var city_val = '';
	var city_data;

	/*$('#inscription-form').delegate('#city','keyup', function() {
		if(city_update == false) {
			city_update = true;

			var _this = $(this);
			var city = $(this).val();

			$.post('"._SITE_URL."mod/act_p/AccountAct.php', { a: 'getCity', ville:city },function(data) {
				city_update = false;
				$('.input-block .city-list').remove();
				_this.parent().parent().append(data);

				console.log(data);
			});
		}
	});

	$('body').delegate('.input-block .city-list li','click',function() {
		var _this = $(this);
		var parent = _this.parent();

		var value = _this.text();
		var city = _this.data('ville');

		parent.prev().find('#city').data('ville', city);
		parent.prev().find('#city').val(value);
		parent.remove();

		return false;
	});

	$('body').delegate('.input-block #city','focus',function() {
		city_data = $(this).data('ville');
		city_val = $(this).val();
		$(this).val('');
	});

	$('body').delegate('.input-block #city','focusout',function() {
		var _this = $(this);
		var parent = _this.parent().parent();

		setTimeout(function() {
			parent.find('.city-list').remove();

			if(_this.data('ville') == city_data) {
				_this.val(city_val);
				_this.data('ville',city_data);
			} else { pending_data = _this.data('ville'); }

		},150);

	});*/

    $('#inscription-form').delegate('#region,#province','change', function() {
        var IdRegion = $('#inscription-form #region').val();
        var IdProvince = $('#inscription-form #province').val();
        var IdPays = 1;

        $.post('"._SITE_URL."mod/act_p/AccountAct.php', { a: 'SelectLocation', IdPays:IdPays, IdRegion:IdRegion, IdProvince:IdProvince },function(data) {

            $('#inscription-form #province').parent().html(data.SelectProvince);
            $('#inscription-form #region').parent().html(data.SelectRegion);
        },'json');
    });

	$('#inscription-form').submit(function() {
		var validate = validateForm('#inscription-form');

		if(validate == false) { throwMessage('".addslashes(_("Veuillez remplir les champs requis."))."',true,'inscription-form'); }
		else if($('#inscription-form #password').val() != $('#inscription-form #repeat-password').val()) { throwMessage('".addslashes(_("Vos mots de passe ne sont pas identiques."))."',true,'inscription-password'); }
		else if(!grecaptcha.getResponse()) { throwMessage('".addslashes(_("Veuillez prouvez que vous n'êtes pas un robot."))."',true,'captcha'); }
		/*else if(!$('#city').data('ville')) { throwMessage('".addslashes(_("Veuillez choisir une ville."))."',true,'choose-city'); }*/
		else {
			var geocoder = new google.maps.Geocoder();
			var address = $('#inscription-form #city').val() + ' ' + $('#inscription-form #postal_code').val();

			geocoder.geocode({'address': address}, function(results, status) {
				if(status == google.maps.GeocoderStatus.OK) {
					$.post('"._SITE_URL."mod/act_p/AccountAct.php',{ a: 'createAccount', form: $('#inscription-form').serialize(), ville: results[0].address_components }, function(data) {
						throwMessage(data.message,data.error,data.class);
						/*if(data.error == false) { $('.inscription-content').removeClass('trigger'); emptyForm('#inscription-form'); }*/
						if(data.error == false) { setTimeout(function() { window.location.href = _SITE_URL + 'formulaire'; },2000); }
					},'json');

				} else { throwMessage('Ville introuvable. Veuillez réessayer.',true,'no-location'); }
			});

		}

		return false;
	});

";

// LOGIN
$output['onReadyJs'] .= "
	$('.login-content .forgot-password').click(function() {

		if($('#login-form').hasClass('lost-password')) {
			$('#login-form').removeClass('lost-password');
			$('.login-content .input-block:last-of-type').slideDown(250);

			$('.login-content .forgot-password, .login-content .button-link, .login-content h3').fadeOut(250,function() {
				$('.login-content .forgot-password').text('"._("Vous avez oublié votre mot de passe?")."');
				$('.login-content .button-link span').text('"._("Connexion")."');
				$('.login-content h3').text('"._("Connexion")."');

				$('.login-content .forgot-password, .login-content .button-link, .login-content h3').fadeIn(250);
			});
		} else {
			$('#login-form').addClass('lost-password');
			$('.login-content .input-block:last-of-type').slideUp(250);

			$('.login-content .forgot-password, .login-content .button-link, .login-content h3').fadeOut(250,function() {
				$('.login-content .forgot-password').text('"._("Annuler la récupération")."');
				$('.login-content .button-link span').text('"._("Récupérer")."');
				$('.login-content h3').text('"._("Récupération")."');

				$('.login-content .forgot-password, .login-content .button-link, .login-content h3').fadeIn(250);
			});
		}

		return false;
	});

	$('#login-form').submit(function() {
		if($(this).hasClass('lost-password')) {
			if($('#login-form #username').val() == '') { throwMessage('".addslashes(_("Veuillez entrez votre courriel personnel."))."',true,'login-form'); }
			else {
				$.post('"._SITE_URL."mod/act_p/AuthyAct.php',{a:'forgot_password', username: $('#login-form #username').val() }, function(data) {
					throwMessage(data.message,data.error,data.class);
					if(data.error == false) { $('.login-content .forgot-password').click(); $('.trigger-login').click(); }
				},'json');
			}
		} else {
			var validate = validateForm($(this));
			if(validate == false) { throwMessage('".addslashes(_("Veuillez remplir les champs requis."))."',true,'login-form'); } else {
				$.post('"._SITE_URL."mod/act_p/AuthyAct.php',{a:'login', username: $('#login-form #username').val(), password: $('#login-form #password').val() }, function(data) {
					throwMessage(data.message,data.error,data.class);
					if(data.error == false) { setTimeout(function() { document.location.href= '"._SITE_URL."formulaire'; }, 3000); }
				},'json');
			}
		}
		return false;
	});";


?>