$(document).ready(function(){
	/*
	* Changes the sales list from the tabbed button
	*/
	$('.popup-sale-list').undelegate('.js-old-sale-list-button', 'click.oldSaleList');
	$('.popup-sale-list').delegate('.js-old-sale-list-button', 'click.oldSaleList', function() {
		var target = $(this).data('target');
		if (!$(this).hasClass('selected')) {
			$('.popup-sale-list .js-old-sale-list-button.selected').removeClass('selected');
			$('.popup-sale-list .js-old-sale-list-button[data-target="'+target+'"]').addClass('selected');
			$('.popup-sale-list .item-list.selected').fadeOut(function() {
				$(this).removeClass('selected');
				$('.popup-sale-list .item-list.'+target).fadeIn(function() {
					$(this).addClass('selected');
				});
			});
		}
	});
	
	/*
	* Shows more sales in the list
	*/
	$('.popup-sale-list').undelegate('.js-show-more-sales', 'click.moreSaleList');
	$('.popup-sale-list').delegate('.js-show-more-sales', 'click.moreSaleList', function() {
		$(this).parents('.item-list').find('.item.older').slideToggle();
		$(this).find('span').toggleClass('show');
	});

	/*
	* Adds click event on the sales
	*/
	$('.popup-sale-list .sales-list').undelegate('.item-list .item:not(.gift-card-add-form.new,.default)', 'click.itemClick');
	$('.popup-sale-list .sales-list').delegate('.item-list .item:not(.gift-card-add-form.new,.default)', 'click.itemClick', function(e) {
		if (!locked) {
			/* Toggle the active state */
			if (!$(e.target).hasClass('js-list-item-action') && !$(e.target).parent().hasClass('js-list-item-action')) {
				$(this).toggleClass('active').removeClass('multiple');
				var activeAmount = $('.popup-sale-list .item-list .item.active').length;
				if (activeAmount > 1) {
					$('.popup-sale-list .item-list .item.active').addClass('multiple');
				}
				else {
					$('.popup-sale-list .item-list .item.active').removeClass('multiple');
				}
			}
			else {
				/* Reuse the sale if the list-item-action button is clicked */
				var id = $(e.target).parents('.item').data('sale-id');
				$.post(_SITE_URL+'mod/act/SaleAct.php',
				{'a':'reuseSale','id':id},
				function(data){
					calcTotals();
					if (data) {
						$('.popup-sale-list.js-side-popup .js-popup-close').click();
						$('.left .item-list .item:not(.default), .right .item-list .item:not(.default), .right .payment-line .single-payment-line, .popup-sale-list.js-side-popup .sales-list ul, .popup-sale-list.js-side-popup .sales-list button').fadeOut(function() {
							$(this).remove();
						});
						$('.left .item-list .item.default').fadeOut(function() {
							$(data.left).hide().css('opacity',0.0).appendTo('.left .item-list').slideDown(200).animate({opacity: 1.0});
						});
						$('.right .item-list .item.default').fadeOut(function() {
							$(data.right).hide().css('opacity',0.0).appendTo('.right .item-list').slideDown(200).animate({opacity: 1.0});			
						});
						$(data.oldSalesButtons).hide().css('opacity',0.0).appendTo('.popup-sale-list.js-side-popup .sales-list').slideDown(200).animate({opacity: 1.0});
						$(data.oldSalesList).hide().css('opacity',0.0).appendTo('.popup-sale-list.js-side-popup .sales-list').animate({opacity: 1.0}).eq(0).slideDown(200);
						if (data.payment) {
							$('.right .payment-line.handed').fadeIn();
							$(data.payment).hide().css('opacity',0.0).appendTo('.right .payment-line.handed').slideDown(200).animate({opacity: 1.0});
							$(data.input).appendTo('.prices-form');
							$('.prices-form .input-balance').val(data.balance);
							$('.prices-form .input-monnaie').val(data.monnaie);

							if (data.balance >= 0) {
								$('.js-card-input').val(parseFloat(data.balance).toFixed(2));
								$('.right .payment-line.left-over .left-over-payment span').text(parseFloat(data.balance).toFixed(2));
								$('.right .payment-line.left-over').slideDown();
							}
							else {
								$('.js-card-input').val('0.00');
								$('.right .payment-line.left-over .left-over-payment span').text('0');	
								$('.right .payment-line.left-over').slideDown();
							}
							$('.right .payment-line.handed-back .handed-back-payment span').text(parseFloat(data.monnaie).toFixed(2));
							if (data.monnaie > 0) {
								$('.right .payment-line.handed-back').slideDown();
							}
							else {
								$('.right .payment-line.handed-back').slideUp();								
							}
						}
						else {
							$('.right .payment-line.handed').fadeOut();
							$('.right .payment-line.handed-back').slideUp();
							$('.right .payment-line.left-over').slideUp();
						}
					}
				}, 'json');
			}
		}
	});
});