$(document).ready(function(){
	/*
	* Starts the day
	*/
	$('.main .left .js-start-day').unbind('click.StartDay');
	$('.main .left .js-start-day').bind('click.StartDay', function() {
		if (!locked) {
			$('.popup-overlay, .start-end-popup, .start-end-popup .start-day').fadeIn();
			$('.popup-overlay, .js-start-end-popup .js-close-popup').unbind('click.closeStartDay');
			$('.popup-overlay, .js-start-end-popup .js-close-popup').bind('click.closeStartDay', function() {
				$('.popup-overlay, .start-end-popup, .start-end-popup .start-day').fadeOut();			
			});	
		}
	});

	/*
	* Ends the day
	*/
	$('.main .left .js-end-day').unbind('click.EndDay');
	$('.main .left .js-end-day').bind('click.EndDay', function() {
		if (!locked) {
			$('.popup-overlay, .start-end-popup, .start-end-popup .end-day').fadeIn();
			$('.popup-overlay, .js-start-end-popup .js-close-popup').unbind('click.closeEndDay');
			$('.popup-overlay, .js-start-end-popup .js-close-popup').bind('click.closeEndDay', function() {
				$('.popup-overlay, .start-end-popup, .start-end-popup .end-day').fadeOut();			
			});
		}	
	});

	/*
	* Changes the list type between list and pictures list
	*/
	$('.main .list-type button').unbind('click.listType');
	$('.main .list-type button').bind('click.listType', function() {
		if (!locked && !$(this).hasClass('current') && !$(this).hasClass('js-empty-items')) {
			$('.main .left .item-list').removeClass($('.main .list-type button.current').data('type')+'-list').addClass($(this).data('type')+'-list');
			$('.main .list-type button.current').removeClass('current');
			$(this).addClass('current');
			$.post(_SITE_URL+'mod/act/SaleAct.php',
			{'a':'listType',type:$(this).data('type')},
			function(data){
				
			});
		}
	});

	/*
	* Reset the sale
	*/
	$('.js-empty-items').unbind('click.Empty');
	$('.js-empty-items').bind('click.Empty', function() {
		if (!locked) {
			$.post(_SITE_URL+'mod/act/SaleAct.php',
			{'a':'emptySale'},
			function(data){
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
			});
		}
	});

	/*
	* Shows the add item input
	*/
	$('.add-forms-show-buttons .js-show-form').unbind('click.showAdd');
	$('.add-forms-show-buttons .js-show-form').bind('click.showAdd', function() {
		if (!locked) {
			$('.add-form-container form').fadeToggle().toggleClass('active');
			$('.add-form-container form .js-barcode-input').focus();
		}
	});

	/*
	* Adds a gift card line
	*/
	$('.add-forms-show-buttons .js-show-add-gift-card-form').unbind('click.showAddGiftCard');
	$('.add-forms-show-buttons .js-show-add-gift-card-form').bind('click.showAddGiftCard', function() {
		if (!locked) {
			$.post(_SITE_URL+'mod/act/SaleAct.php',
			{'a':'addGiftCardLine'},
			function(data){
				$('.left .item-list .item.default').fadeOut();
				if ($('.left .item-list .item.gift-card-add-form').length > 0) {
					var element = $('.left .item-list .item.gift-card-add-form').last();
					$(data.left).hide().css('opacity',0.0).insertAfter(element).slideDown(200).animate({opacity: 1.0}, function() {
						$(this).find('.barcode input').focus();
						$('html,body').stop().animate({scrollTop:$(this).offset().top}, 1000);
					});
				}
				else {
					$(data.left).hide().css('opacity',0.0).insertAfter('.left .item-list .right-item-list-buttons').slideDown(200).animate({opacity: 1.0}, function() {
						$(this).find('.barcode input').focus();
					});
				}				
			}, 'json');
		}
	});
	
	/*
	* Adds the item on enter keypress
	*/
	$('.add-form-container .js-barcode-input').off('keydown.Barcode');
	$('.add-form-container .js-barcode-input').on('keydown.Barcode', function(e) {
		if (!locked) {
			if (e.which == 13) {
				e.preventDefault();
				if ($('.add-form-container .js-barcode-input').val() != '') {
					$('.add-form-container .js-hidden-barcode-input').val($('.add-form-container .js-barcode-input').val());
				}
				addItem();
			}
		}
	});

	/*
	* Item barcord input autocomplete
	*/
	var autocTimer = '';
	$('.add-form-container .js-barcode-input').off('keyup.barcodeAutoc');
	$('.add-form-container .js-barcode-input').on('keyup.barcodeAutoc', function(e) {
		if (!locked) {
			clearTimeout(autocTimer);
			autocTimer = setTimeout(function() {
				var val = $('.add-form-container .js-barcode-input').val();
				if (val != '') {
						$.post(_SITE_URL+'mod/act/SaleAct.php',
						{'a':'itemAutocomplete',search:val},
						function(data){
							$('.add-form-container .autocomplete-list').html(data).fadeIn();
						});
				}
				else {
					$('.add-form-container .autocomplete-list').fadeOut(function() {
						$(this).html('');
					});
				}
			}, 250);
		}
	});

	/*
	* Adds item on autocomplete item click
	*/
	$('.add-form-container .autocomplete-list').undelegate('li', 'click.autocompleteOption');
	$('.add-form-container .autocomplete-list').delegate('li', 'click.autocompleteOption', function() {
		if (!locked) {
			$('.add-form-container .js-hidden-barcode-input').val($(this).data('barcode'));
			addItem();
			$('.add-form-container .autocomplete-list').fadeOut(function() {
				$(this).html('');
			});
		}
	});
});	