$(document).ready(function(){
	/*
	* Activates the "Add" button in the promo-code section
	*/
	$('.promo-code .js-promo-code-input').off('keyup.PromoCode');
	$('.promo-code .js-promo-code-input').on('keyup.PromoCode', function(e) {
		if (!locked) {
			var val = $('.promo-code .js-promo-code-input').val();
			if (val != '') {
				$('.promo-code .js-add-promo-code').addClass('active');
			}
			else {
				$('.promo-code .js-add-promo-code').removeClass('active');
			}
		}
	});	

	$('.promo-code .js-promo-code-input').off('keydown.PromoCode');
	$('.promo-code .js-promo-code-input').on('keydown.PromoCode', function(e) {
		if (!locked) {
			if (e.which == 13) {
				e.preventDefault();
				$('.promo-code .js-add-promo-code').click();
			}
		}
	});
	
	/*
	* Adds the promo code and recalc the totals
	*/
	$('.promo-code .js-add-promo-code').unbind('click.AddPromoCode');
	$('.promo-code .js-add-promo-code').bind('click.AddPromoCode', function() {
		if (!locked) {
			if ($(this).hasClass('active')) {
				$.post(_SITE_URL+'mod/act/SaleAct.php',
				{'a':'promoCode','code':$('.promo-code .js-promo-code-input').val()},
				function(data){
					calcTotals();
				}, 'json');
			}
		}
	});
});