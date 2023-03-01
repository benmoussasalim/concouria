<?php

if($_SESSION[_AUTH_VAR]->get('isConnected') == 'NO') {
	$loginFooter = href(_("Connexion"),'#','class="trigger-login" title="Connexion"');

} else {
	$loginFooter = href(_("Déconnexion"),_SITE_URL.'disconnect', 'title="Déconnexion"');
}

$htmlOutput =
	div(
		href(img(_SITE_URL.'css/img/logo.png', NULL, NULL,swEdit('img'),true),_SITE_URL,'class="logo"','Concouria')

		.div(
			ul(
				li(href(_("Concept"),_SITE_URL.'la-compagnie', 'title="Concept"'))
				.li(href(_("Accueil"),_SITE_URL, 'title="Accueil"'))
				.li(
					href(_("Concours"),_SITE_URL.'concours', 'title="Concours"')
					//.href("À vendre",_SITE_URL,'class="additionnal-link"')
					//.href("Potentiels",_SITE_URL,'class="additionnal-link"')
				)
				.li(href(_("Faq"),_SITE_URL.'faq', 'title="FAQ"'))
				.li(href(_("Statistiques"),_SITE_URL.'statistiques', 'title="Statistique"'))
				.li(href(_("Contact"),'#body', 'class="trigger-contact" title="Contact"'))
				.li(href(_("Inscription"),'#','class="trigger-subscribe" title="Inscription"'))
			,'class="menu"')

			.div(
				$loginFooter

				.p(_("Tous droits réservés &copy; 2016 CONCOURIA"))
				.p(_("Propulsé par ").href(_("Progexpert"),'http://progexpert.com/','','Progexpert'))
			,'','class="right-footer"')
		,'','class="content-footer"')
	,'','class="wrapper"');

?>