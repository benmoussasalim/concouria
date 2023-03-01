$(document).ready(function(){
	/*
	* Adds events on the dial buttons
	*/
	$('.payment .cash-form button').unbind('click.dial');
	$('.payment .cash-form button').bind('click.dial', function() {
		if (!locked) {
			var value = $(this).data('value');
			if ($(this).hasClass('js-add-button')) {
				clickIndex = mapMontant.length;
				/* Presetted values of the 5, 10 and 20 buttons */
				if ($(this).hasClass('default-button')) {
					switch($(this).attr('data-value')) {
					    case '5':
					    	value = [5,0,0];
					        break;
					    case '10':
					    	value = [1,0,0,0];
					        break;
					    case '20':
					    	value = [2,0,0,0];
					        break;
					}
					mapMontant = new Array();
					mapMontant = value;
					clickIndex = mapMontant.length;
				}
				else {					
					if (value === '00') {
						mapMontant[clickIndex] = '0';
						clickIndex++;
						mapMontant[clickIndex] = '0';
						clickIndex++;
					}
					else {
						mapMontant[clickIndex] = value;
						clickIndex++;					
					}
				}
				$('.payment .js-cash-paid-amount').val(updatePrice(mapMontant));
			}
			else if ($(this).hasClass('js-remove-button')) {
				/*mapMontant.splice(-1,1);
				if (clickIndex > 0) {
					clickIndex--;
				}*/
				mapMontant = new Array();
				clickIndex = 0;
				$('.payment .js-cash-paid-amount').val(updatePrice(mapMontant));
			}
		}
	});

	/*
	* Adds a payment from the dial
	*/
	$('.payment form .js-charge-button').unbind('click.Charge');
	$('.payment form .js-charge-button').bind('click.Charge', function() {
		if (!locked) {
			$('.payment .js-popup-close').click();
			var amount = parseFloat($('.payment form .js-cash-paid-amount').val()), total = parseFloat($('.prices-form #total').val());
			if (amount > 0 && total > 0) {
				$('.right .js-finish-button').addClass('active');

				$.post(_SITE_URL+'mod/act/SaleAct.php',
				{'a':'newPayment', amount:parseFloat(amount).toFixed(2), total:parseFloat(total).toFixed(2), type:'Comptant', index:new Date().getTime()},
				function(data){
					mapMontant = new Array();
					mapMontant[0] = 0;
					clickIndex = 0;
					$('.payment .js-cash-paid-amount').val(updatePrice(mapMontant));

					/* Updates the totals */
					$('.right .payment-line.handed').fadeIn();
					$(data.payment).hide().css('opacity',0.0).appendTo('.right .payment-line.handed').slideDown(200).animate({opacity: 1.0});
					$(data.input).appendTo('.prices-form');
					$('.prices-form .input-balance').val(data.balance);
					$('.prices-form .input-monnaie').val(data.monnaie);

					/* Updates the credit card to the left over amount if the balance is higher than 0 */
					if (data.balance >= 0) {
						$('.js-card-input').val(parseFloat(data.balance).toFixed(2));
						$('.right .payment-line.left-over .left-over-payment span').text(parseFloat(data.balance).toFixed(2));
						$('.right .payment-line.handed-back').slideUp();
						$('.right .payment-line.left-over').slideDown();
					}
					else {
						$('.js-card-input').val('0.00');
						$('.right .payment-line.left-over .left-over-payment span').text('0');	
						$('.right .payment-line.handed-back .handed-back-payment span').text(parseFloat(data.monnaie).toFixed(2));
						$('.right .payment-line.handed-back').slideDown();		
						$('.right .payment-line.left-over').slideDown();
					}
				}, 'json');
			}
		}
	});
	
	/*
	* Adds a credit card payment
	*/
	$('.payment form .js-charge-card').unbind('click.ChargeCard');
	$('.payment form .js-charge-card').bind('click.ChargeCard', function() {
		if (!locked) {
			$('.payment .js-popup-close').click();
			var amount = parseFloat($('.payment form .js-card-input[data-type=\"'+$(this).data('target')+'\"]').val()), 
				total = parseFloat($('.prices-form #total').val()),
				type = $(this).data('target');
			if (amount > 0 && total > 0) {
				$('.right .js-finish-button').addClass('active');

				$.post(_SITE_URL+'mod/act/SaleAct.php',
				{'a':'newPayment', amount:parseFloat(amount).toFixed(2), total:parseFloat(total).toFixed(2), type:type, index:new Date().getTime()},
				function(data){
					$('.right .payment-line.handed').fadeIn();
					$(data.payment).hide().css('opacity',0.0).appendTo('.right .payment-line.handed').slideDown(200).animate({opacity: 1.0});
					$(data.input).appendTo('.prices-form');
					$('.prices-form .input-balance').val(data.balance);
					$('.prices-form .input-monnaie').val(data.monnaie);

					/* Updates the credit card to the left over amount if the balance is higher than 0 */
					if (data.balance >= 0) {
						$('.js-card-input').val(parseFloat(data.balance).toFixed(2));
						$('.right .payment-line.left-over .left-over-payment span').text(parseFloat(data.balance).toFixed(2));
						$('.right .payment-line.handed-back').slideUp();
						$('.right .payment-line.left-over').slideDown();
					}
					else {
						$('.js-card-input').val('0.00');
						$('.right .payment-line.left-over .left-over-payment span').text('0');	
						$('.right .payment-line.handed-back .handed-back-payment span').text(parseFloat(data.monnaie).toFixed(2));
						$('.right .payment-line.handed-back').slideDown();		
						$('.right .payment-line.left-over').slideDown();
					}
				}, 'json');
			}
		}
	});
	
	/*
	* Adds a gift card payment
	*/
	$('.payment form .js-charge-gift-card').unbind('click.ChargeGiftCard');
	$('.payment form .js-charge-gift-card').bind('click.ChargeGiftCard', function() {
		if (!locked) {
			$('.payment .js-popup-close').click();
			var cardCode = $('.payment form .js-gift-card-payment').val(), 
				total = parseFloat($('.prices-form #total').val()),
				type = 'GiftCard';
			if (cardCode != '' && total > 0) {
				$.post(_SITE_URL+'mod/act/SaleAct.php',
				{'a':'newPayment', cardCode:cardCode, total:parseFloat(total).toFixed(2), type:type, index:new Date().getTime()},
				function(data){
					$('.right .js-finish-button').addClass('active');

					$('.right .payment-line.handed').fadeIn();
					$(data.payment).hide().css('opacity',0.0).appendTo('.right .payment-line.handed').slideDown(200).animate({opacity: 1.0});
					$(data.input).appendTo('.prices-form');
					$('.prices-form .input-balance').val(data.balance);
					$('.prices-form .input-monnaie').val(data.monnaie);

					/* Updates the credit card to the left over amount if the balance is higher than 0 */
					if (data.balance >= 0) {
						$('.js-card-input').val(parseFloat(data.balance).toFixed(2));
						$('.right .payment-line.left-over .left-over-payment span').text(parseFloat(data.balance).toFixed(2));
						$('.right .payment-line.handed-back').slideUp();
						$('.right .payment-line.left-over').slideDown();
					}
					else {
						$('.js-card-input').val('0.00');
						$('.right .payment-line.left-over .left-over-payment span').text('0');	
						$('.right .payment-line.handed-back .handed-back-payment span').text(parseFloat(data.monnaie).toFixed(2));
						$('.right .payment-line.handed-back').slideDown();		
						$('.right .payment-line.left-over').slideDown();
					}
				}, 'json');
			}
		}
	});

	/*
	* Toggle the payments options
	*/
	$('.payment .payment-buttons button').unbind('click.showPayment');
	$('.payment .payment-buttons button').bind('click.showPayment', function() {
		if (!locked) {
			if (!$(this).hasClass('current')) {
				var oldTarget = $('.payment .payment-buttons .current').data('target'), target = $(this).data('target');
				$('.payment .payment-buttons .current').removeClass('current');
				$(this).addClass('current');
				if ($('.payment .'+oldTarget).length > 0) {
					$('.payment .'+oldTarget).fadeOut(200, function() {
						$('.payment .'+target).fadeIn(200);
					});
				}
				else {
					$('.payment .payment-form-wrapper').animate({width: '600px'}, function() {
						$('.payment .'+target).fadeIn(200);					
					});
				}
			}
		}
	});

	/*
	* Selects the amount if we focus in the dial input
	*/
	$('.payment .js-cash-paid-amount').unbind('focus.PaidAmountFocus');
	$('.payment .js-cash-paid-amount').bind('focus.PaidAmountFocus', function(e) {
		$('.js-cash-paid-amount').select();
	});
	
	/*
	* Updates price on keyup in the dial input
	*/
	$('.payment .js-cash-paid-amount').unbind('keyup.PaidAmount');
	$('.payment .js-cash-paid-amount').bind('keyup.PaidAmount', function(e) {
		if (!locked) {
			if (e.which != 37 && e.which != 39) {
				var val = $(this).val().replace('.', '');
				mapMontant = new Array();
				clickIndex = val.length;

				if (val.length == 4 && parseInt(val[0]) == 0) {
					val = val.substr(1);
					clickIndex--;
				}
				for (i=val.length-1; i >= 0; i--) {
					mapMontant[i] = parseInt(val[i]);
				}
				$('.payment .js-cash-paid-amount').val(updatePrice(mapMontant));
			}
		}
	});
});