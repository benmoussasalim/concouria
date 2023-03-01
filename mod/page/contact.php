<?php

$htmlOutput =
div(
	div(
		h2(_("Contact"))
		.p("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel neque at nunc tempor consequat eu et mi. Etiam eu felis non nibh ornare ultricies. Nunc vel nibh at nunc suscipit imperdiet et sit amet ex. Ut nulla odio, ornare et egestas non, egestas sit amet sapien. Aenean sagittis accumsan efficitur. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent nec semper velit. Fusce quis auctor nisl. Mauris efficitur arcu id risus aliquam, sed rutrum quam ultrices. Praesent et tempus mauris. Suspendisse quis lobortis nisi, ac pellentesque tellus. Cras accumsan consequat sagittis. Vestibulum molestie fringilla lacinia. Maecenas varius id massa in interdum.")
		.p("*Champs requis",'class="required"')
	,'','class="wrapper"')
,'','class="intro-contact"')

.div(
	form(
		div(
			label(_("Prénom*"),'for="firstname"')
			.div(input('text','firstname','','class="required"'),'','class="input-wrapper"')
		,'','class="input-block"')

		.div(
			label(_("Nom*"),'for="lastname"')
			.div(input('text','lastname','','class="required"'),'','class="input-wrapper"')
		,'','class="input-block"')

		.div(
			label(_("Courriel*"),'for="email"')
			.div(input('text','email','','class="required"'),'','class="input-wrapper"')
		,'','class="input-block"')

		.div(
			label(_("Numéro de téléphone"),'for="phone"')
			.div(input('text','phone',''),'','class="input-wrapper"')
		,'','class="input-block"')

		.div(
			label(_("Message*"),'for="message"')
			.div(textarea('message','','class="required"'),'','class="input-wrapper"')
		,'','class="input-block message"')

		.button(span(_("Soumettre")),'class="button-link green"')


	,'id="form-contact"')
,'','class="wrapper"');

$output['onReadyJs'] .= "
	$('#form-contact').submit(function() {
		var validate = validateForm($(this));

		if(validate == false) { throwMessage('"._("Veuillez remplir les champs obligatoires.")."',true,'form-error'); }
		else {
			$.post('"._SITE_URL."mod/act_p/ContactAct.php',{ a: 'sendForm', form: $('#form-contact').serialize() }, function(data) {
				throwMessage(data.message,data.error,data.class);
			},'json');
		}

		return false;
	});
";

?>