$(document).ready(function(){
	/*
	* Removes a payment
	*/
	$('.right .payment-line.handed').undelegate('.js-remove-payment', 'click.removePayment');
	$('.right .payment-line.handed').delegate('.js-remove-payment', 'click.removePayment', function() {
		if (!locked) {
			var currElement = $(this).parent(), index = currElement.data('index'), type = currElement.data('type');
			$.post(_SITE_URL+'mod/act/SaleAct.php',
			{'a':'removePayment', amount:parseFloat($('.js-handed-payment-input[data-index=\"'+index+'\"]').val()), type: type, total:parseFloat($('.prices-form #total').val()), index:index},
			function(data){
				if ($('.right .payment-line.handed .single-payment-line').length <= 1) {
					$('.right .payment-line.handed-back, .right .payment-line.handed, .right .payment-line.left-over').slideUp();
					$('.right .js-finish-button').removeClass('active');
				}
				currElement.slideUp(200).animate({opacity: 0}, function() {
					$(this).remove();
				});
				/* Update prices */
				$('.js-handed-payment-input[data-index=\"'+index+'\"]').remove();
				$('.prices-form .input-balance').val(data.balance);
				$('.prices-form .input-monnaie').val(data.monnaie);

				/* Updates the credit card to the left over amount if the balance is higher than 0 */
				if (data.balance >= 0) {
					$('.js-card-input').val(parseFloat(data.balance).toFixed(2));
					$('.right .payment-line.left-over .left-over-payment span').text(parseFloat(data.balance).toFixed(2));
					$('.right .payment-line.handed-back').slideUp();
				}
				else {
					$('.js-card-input').val('0.00');
					$('.right .payment-line.left-over .left-over-payment span').text('0');	
					$('.right .payment-line.handed-back .handed-back-payment span').text(parseFloat(data.monnaie).toFixed(2));
					$('.right .payment-line.handed-back').slideDown();						
				}
			}, 'json');
		}
	});
	
	/*
	* Confirm sale
	*/
	$('.right .js-finish-button').unbind('click.finishSale');
	$('.right .js-finish-button').bind('click.finishSale', function() {
		if (!locked) {
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');

				/* Completes the sale if the balance is 0 */
				if ($('.prices-form .input-balance').val() <= 0) {
					$.post(_SITE_URL+'mod/act/SaleAct.php',
					{'a':'createSale', payment:'Completee'},
					function(data){
						/* Shows completed sale popup and reset the sale */
						$('.right .js-finish-button').removeClass('active');
						$('.popup-finish, .popup-overlay').fadeIn().delay(1000).fadeOut();
						$('.right .item-list .item:not(.default), .left .item-list .item:not(.default)').animate({opacity: 0}).slideUp(function() {
							$(this).remove();
							calcTotals();
							$('.item-list .item.default').slideDown();
						});
						$('.right .payment-line .single-payment-line').animate({opacity: 0}).slideUp(function() {
							$(this).remove();
						});
						if ($('.right .payment-line.handed .single-payment-line').length <= 1) {
							$('.right .payment-line.handed-back, .right .payment-line.handed, .right .payment-line.left-over').slideUp();
							$('.right .js-finish-button').removeClass('active');
						}
					}, 'json');
				}
				else {
					/* Shows unfinished sale confirmation */
					$('.right .unfinished-sale-confirmation').css('opacity',0.0).slideDown(200).animate({opacity: 1.0});
					$('html,body').animate({scrollTop:$('.right .unfinished-sale-confirmation').offset().top});
				}
			}
		}
	});
	
	/*
	* Puts the sale aside if the cashier says yes
	*/
	$('.right .unfinished-sale-confirmation .js-put-aside').unbind('click.putAside');
	$('.right .unfinished-sale-confirmation .js-put-aside').bind('click.putAside', function() {
		if (!locked) {
			if ($(this).data('value') == 'yes') {
				$.post(_SITE_URL+'mod/act/SaleAct.php',
				{'a':'createSale', payment:'Mise de cote'},
				function(data){
					$('.right .js-finish-button').addClass('active');
					$('.right .unfinished-sale-confirmation').slideUp(200).animate({opacity: 0});
				}, 'json');
			}
			else {
				$('.right .js-finish-button').addClass('active');
				$('.right .unfinished-sale-confirmation').slideUp(200).animate({opacity: 0});
			}
		}
	});
	
	/*
	* Removes the promo code
	*/
	$('.right .prices-list').undelegate('.js-remove-promo-code', 'click.removePromocode');
	$('.right .prices-list').delegate('.js-remove-promo-code', 'click.removePromocode', function() {
		if (!locked) {
			$.post(_SITE_URL+'mod/act/SaleAct.php',
			{'a':'promoCode','code':''},
			function(data){
				calcTotals();
				$('.promo-code .js-promo-code-input').val('');
				$('.promo-code .js-add-promo-code').removeClass('active');
			}, 'json');
		}
	});
});