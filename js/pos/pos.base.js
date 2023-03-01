/*
* Locks the screen and asks for the seller number if there's no activity for x amount of time
*/
var activityTimer = window.setTimeout(function() {
	window.clearTimeout(activityTimer);
	setInactivity();
}, inactivityTime),
/*
* Formats the price when using the number pad so it starts from the end instead of the beginning
*/
updatePrice = function (mapMontant) {
	var output = '';
	if (mapMontant.length >= 4 && parseInt(mapMontant[0]) == 0) {
		mapMontant.splice(0, 1);
	}
	for (i=mapMontant.length-1; i >= 0; i--) {
		output = mapMontant[i] + output;
	}
	output = output.insert(2, '.');
	return output;
},
/*
* Calculates totals and updates them
*/
calcTotals = function () {
	$.post(_SITE_URL+'mod/act/SaleAct.php',
	{'a':'calcTotals'},
	function(data){
		$('.right .prices-list').html(data.prices);
		$('.right .total-price').html(data.total);
		$('.right .payment-line.left-over .left-over-payment span').text(parseFloat(data.balance).toFixed(2));

		$('.js-card-input').val(parseFloat(data.balance).toFixed(2));

		if ($('.prices-form .input-sub-total').length == 0) {
			$('.prices-form').append(data.form.subTotal);			
		}
		else {
			$('.prices-form .input-sub-total').replaceWith(data.form.subTotal);
		}
		if ($('.prices-form .input-taxes').length == 0) {
			$('.prices-form').append(data.form.taxes);
        }
		else {
			$('.prices-form .input-taxes').replaceWith(data.form.taxes);
		}
		if ($('.prices-form .input-total').length == 0) {
			$('.prices-form').append(data.form.total);
        }
		else {
			$('.prices-form .input-total').replaceWith(data.form.total);
		}
		if ($('.prices-form .input-total-cash').length == 0) {
			$('.prices-form').append(data.form.totalCash);
        }
		else {
			$('.prices-form .input-total-cash').replaceWith(data.form.totalCash);
		}
	}, 'json');
},
/*
* Adds a new item to the left and right lists or update the qty if the item is already in the list
*/
addItem = function () {
	$('.add-form-container .autocomplete-list').fadeOut(function() {
		$(this).html('');
	});
	$.post(_SITE_URL+'mod/act/SaleAct.php',
		{'a':'addItem','search':$('.add-form-container .js-hidden-barcode-input').val()},
		function(data){
			/*
			* Updates totals
			*/
			calcTotals();
			if (data) {
				/*
				* Hides the default "No articles" label in the left list and adds the item or increment the qty of an existing one
				*/
				$('.left .item-list .item.default').fadeOut(function() {
					if (data.replace) {
						$('.left .item-list .item[data-prod-id=\"'+data.prodId+'\"] .qty').text(data.qty);
					}
					else {
						$(data.left).hide().css('opacity',0.0).appendTo('.left .item-list').slideDown(200).animate({opacity: 1.0});
					}				
					$('html,body').animate({scrollTop:$('.left .item-list .item').last().offset().top}, 1000);
				});
				/*
				* Hides the default "No articles" label in the right list and adds the item or increment the qty of an existing one
				*/
				$('.right .item-list .item.default').fadeOut(function() {
					if (data.replace) {
						$('.right .item-list .item[data-prod-id=\"'+data.prodId+'\"] strong').text(data.totalPrice);
					}
					else {
						$(data.right).hide().css('opacity',0.0).appendTo('.right .item-list').slideDown(200).animate({opacity: 1.0});
					}				
				});
				/*
				* Sets barcode input value to nothing
				*/
				$('.add-form-container .js-barcode-input, .add-form-container .js-hidden-barcode-input').val('');
			}
		}
	, 'json');
},
/*
* Locks the app and shows the seller number input
*/
setInactivity = function () {
	window.clearTimeout(activityTimer);
	if (!$('.main').hasClass('inactivity')) {
		$('.main').addClass('inactivity');
		locked = true;
		$('.popup-overlay').css({top:59+'px'}).fadeIn();
		$('.popup-seller .js-cashier-user').val($('.header .right .cashier-user-container form input').val());
		$('.popup-seller').fadeIn();
		$('.popup-seller .js-cashier-user').focus();

		$('.cashier-user-container').removeClass('correct');

		$.post(_SITE_URL+'mod/act/SaleAct.php',{'a':'unsetSeller'},function(data){});
	}
};
String.prototype.insert = function (index, string) {
	var str = this.slice(0, -index), otherStr = this.slice(-index);
	if (str.length <= 0) {
		str = 0;
	}
	if (otherStr.length == 0) {
		otherStr = '00';
	}
	else if (otherStr.length == 1) {
		otherStr = 0 + otherStr;
	}
	return str+string+otherStr;
};

$(window).scroll(function() {
	var scrollTop = $(this).scrollTop();
	if (scrollTop <= 60) {
		$('.js-side-popup').css({top: (60 - scrollTop)+'px'});
	}
	else if (scrollTop > 60) {
		$('.js-side-popup').css({top: 0});	
	}
});
$(window).scroll();
var locked = false, mapMontant = new Array(), clickIndex = 0, compteAutocomplete;
$(document).ready(function(){
	/* Resets inactivity timer when an action is done */
	$(document).bind('mousemove keypress', function(e) {
		window.clearTimeout(activityTimer);
		activityTimer = window.setTimeout(function() {
			setInactivity();
		}, inactivityTime);
	});

	calcTotals();
	
	/* Add the listener for the barcode scanner given the first character is $ */
	var string = "", stringTimer, scannerStarter = false;
	$(window).off('keydown.Barcode');
	$(window).on('keydown.Barcode', function(e) {
		if ((e.which == 52 && e.shiftKey || e.keyCode == 52 && e.shiftKey)) {
			scannerStarter = true;
			string = "";
		}
		else if (scannerStarter && e.which != 13 && e.keyCode != 13) {
			clearTimeout(stringTimer);
			if (String.fromCharCode(e.which || e.keyCode) != '') {
				string = string + String.fromCharCode(e.which || e.keyCode);
			}
			stringTimer = setTimeout(function() {
				/* If the focus was in the gif card input the scan goes in it */
				if ($('*:focus').hasClass('js-gift-card-payment')) {
					$('form.gift-card-form .js-gift-card-payment').val(string);
				}
				/* If the focus was anywhere else the scan goes in the barcode input */
				else {
					$('.add-form-container .js-barcode-input').val(string.trim().replace(/[^ -~]+/g, ""));
					$('.add-form-container .js-barcode-input').trigger(jQuery.Event('keydown', {which: 13}));
				}
				scannerStarter = false;
				string = "";
			}, 20);
		}
		else if (e.which == 13 || e.keyCode == 13) {
			e.preventDefault();
		}
	});

	/*
	* Confirm the opening and closing of the cash register
	*/
	$('.js-start-end-popup .js-confirm-button').unbind('click.confirmPopup');
	$('.js-start-end-popup .js-confirm-button').bind('click.confirmPopup', function() {
		if (!locked) {
			$.post(_SITE_URL+'mod/act/SaleAct.php',
			{'a':'cashierLog', type:$(this).data('type'), amount:$(this).prev().val()},
			function(data){
				$('.popup-overlay').click();
			});
		}
	});

	/*
	* Shows the popup which is linked with the "data-target" on the button
	*/
	$('.js-show-side-popup').unbind('click.showSidePopup');
	$('.js-show-side-popup').bind('click.showSidePopup', function() {
		if (!locked) {
			var _this = $(this);
			$('.main').addClass('blured');
			$('.js-side-popup').removeClass('shown').stop().animate({left: '-'+($('.js-side-popup').width()+50)+'px'}, 500);
			$('.js-side-popup.'+_this.data('target')).addClass('shown').stop().animate({left: 0}, 500, function() {
				$(document).unbind('click.Blured');
				$(document).bind('click.Blured', function(e) {
					if ($(e.target).parents('.js-side-popup').length == 0 && !$(e.target).hasClass('js-side-popup')) {
						$(document).unbind('click.Blured');
						var width = $('.js-side-popup.shown').width() + 50;
						$('.main').removeClass('blured');
						$('.js-side-popup.shown').removeClass('shown').stop().animate({left: '-'+width+'px'}, 500);
					}
				});
			});
		}
	});

	/*
	* Closes the popup
	*/
	$('.js-popup-close').unbind('click.hideSidePopup');
	$('.js-popup-close').bind('click.hideSidePopup', function() {
		if (!locked) {
			$(document).unbind('click.Blured');
			$('.main').removeClass('blured');
			$(this).parents('.js-side-popup').removeClass('shown').stop().animate({left: '-'+($(this).parents('.js-side-popup').outerWidth()+$(this).outerWidth())+'px'}, 500);
		}
	});
});