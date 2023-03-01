$(document).ready(function(){
	/*
	* Updates the client infos on change
	*/
	$('.client .client-form input').unbind('change.updateCompte');
	$('.client .client-form input').bind('change.updateCompte', function() {
		if (!locked) {
			$.post(_SITE_URL+'mod/act/SaleAct.php',
			{'a':'saveCompte', compte:$('.payment .client-form input').serialize()},
			function(data){});
		}
	});

	/*
	* Unlink the client from the sale and shows the client search bar
	*/
	$('.client .js-remove-client').unbind('click.resetCompte');
	$('.client .js-remove-client').bind('click.resetCompte', function() {
		$('.client .client-form').slideUp();
		$('.client .js-client-autocomplete-input').val('').slideDown();
	});

	/*
	* Client search bar autocomplete
	*/
	var clientAutocTimer = '';
	$('.client .js-client-autocomplete-input').off('keyup.clientAutoc');
	$('.client .js-client-autocomplete-input').on('keyup.clientAutoc', function(e) {
		if (!locked) {
			clearTimeout(clientAutocTimer);
			var val = $('.client .js-client-autocomplete-input').val();
			if (val != '') {
				clientAutocTimer = setTimeout(function() {
					$.post(_SITE_URL+'mod/act/SaleAct.php',
					{'a':'clientAutocomplete',search:val},
					function(data){
						$('.client .autocomplete-list').html(data.autoCompleteList).fadeIn();
						compteAutocomplete = data.data;
					}, 'json');
				}, 250);
				$('.client .js-add-button').addClass('active');
			}
			else {
				$('.client .js-add-button').removeClass('active');
				$('.client .autocomplete-list').fadeOut(function() {
					$(this).html('');
				});
			}
		}
	});

	/*
	* Adds the client infos to the form on the auto complete click
	*/
	$('.client .autocomplete-list').undelegate('li', 'click.clientAutocompleteOption');
	$('.client .autocomplete-list').delegate('li', 'click.clientAutocompleteOption', function() {
		if (!locked) {
			var IdCompte = $(this).data('id-compte');
			$('.client .client-form').slideDown();
			$('.client .js-client-autocomplete-input').slideUp();
			$('.client .js-client-autocomplete-input').val($(this).data('value'));
			$('.client .client-form input.js-IdCompte-input').val(IdCompte);
			/* Use client infos if not create new client */
			if (IdCompte != '') {
				for (key in compteAutocomplete[IdCompte]) {
					$('.client .client-form input#'+key).val(compteAutocomplete[IdCompte][key]);
				}
			}
			else {
				$('.client .client-form input').val('');
			}
			$('.client .client-form input').eq(0).change();
			$('.client .autocomplete-list').fadeOut(function() {
				$(this).html('');
			});
		}
	});
});