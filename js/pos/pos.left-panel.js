$(document).ready(function(){
	/*
	* Remove all active items
	*/
	$('.left .right-item-list-buttons .js-bulk-remove-item').unbind('click.removeAllSelectedItems');
	$('.left .right-item-list-buttons .js-bulk-remove-item').bind('click.removeAllSelectedItems', function() {
		var arrayIdProd = new Array(), arrayIdGiftCard = new Array();
		$('.left .right-item-list-buttons').slideUp();
		$('.left .item-list .item.active.multiple').each(function () {
			var target = $(this), id = $(this).data('prod-id') || $(this).data('gift-card-id'), type = ($(this).data('prod-id') ? 'prod' : 'gift-card');
			$.post(_SITE_URL+'mod/act/SaleAct.php',
			{'a':'removeItem','id':id,'type':type},
			function(data){
				calcTotals();
				var classType = type == 'prod' ? '.right .item-list .item[data-prod-id="'+id+'"]' : '.right .item-list .item[data-gift-card-id="'+id+'"]';
				$(classType).css({opacity: 1.0}).animate({opacity: 0.0}).slideUp(200, function() {
					$(this).remove();
					if ($('.right .item-list .item:not(.default)').length == 0) {
						$('.left .item-list .item.default, .right .item-list .item.default').fadeIn();
					}
				});
				target.css({opacity: 1.0}).animate({opacity: 0.0}).slideUp(200, function() {
					$(this).remove();
				});
			});
		});
	});

	/*
	* Adds events on click of items in the list
	*/
	$('.left .item-list').undelegate('.item:not(.gift-card-add-form.new,.default)', 'click.itemClick');
	$('.left .item-list').delegate('.item:not(.gift-card-add-form.new,.default)', 'click.itemClick', function(e) {
		if (!locked) {
			if (!$(e.target).hasClass('js-list-item-action') && !$(e.target).parent().hasClass('js-list-item-action')) {
				/* Set or unset active state on the clicked item */
				$(this).toggleClass('active').removeClass('multiple');
				var activeAmount = $('.left .item-list .item.active').length;
				if (activeAmount > 1) {
					$('.left .item-list .item.active').addClass('multiple');
					$('.left .right-item-list-buttons').slideDown();
				}
				else {
					$('.left .item-list .item.active').removeClass('multiple');
					$('.left .right-item-list-buttons').slideUp();
				}
			}
			else if ($(e.target).hasClass('js-remove-one-item') || $(e.target).parent().hasClass('js-remove-one-item')) {
				/* Remove one of the item of the clicked remove button */
				var target = $(e.target).parents('.item'),id = target.data('prod-id') || target.data('gift-card-id'), type = (target.data('prod-id') ? 'prod' : 'gift-card');
				
				$.post(_SITE_URL+'mod/act/SaleAct.php',
					{'a':'oneLessQty','id':target.data('prod-id')},
					function(data){
						calcTotals();
						if (data) {
							$('.left .item-list .item[data-prod-id=\"'+data.prodId+'\"] .qty').text(data.qty);
							$('.right .item-list .item[data-prod-id=\"'+data.prodId+'\"] strong').text(data.totalPrice);
						}
					}
				, 'json');
			}
			else if ($(e.target).hasClass('js-add-one-item') || $(e.target).parent().hasClass('js-add-one-item')) {
				/* Adds one of the item of the clicked add button */
				var target = $(e.target).parents('.item'),id = target.data('prod-id') || target.data('gift-card-id'), type = (target.data('prod-id') ? 'prod' : 'gift-card');

				$.post(_SITE_URL+'mod/act/SaleAct.php',
					{'a':'addItem','search':target.data('barcode')},
					function(data){
						calcTotals();
						if (data) {
							$('.left .item-list .item.default').fadeOut(function() {
								if (data.replace) {
									$('.left .item-list .item[data-prod-id=\"'+data.prodId+'\"] .qty').text(data.qty);
								}
								else {
									$(data.left).hide().css('opacity',0.0).appendTo('.left .item-list').slideDown(200).animate({opacity: 1.0});
								}				
								$('html,body').animate({scrollTop:$('.left .item-list .item').last().offset().top}, 1000);
							});
							$('.right .item-list .item.default').fadeOut(function() {
								if (data.replace) {
									$('.right .item-list .item[data-prod-id=\"'+data.prodId+'\"] strong').text(data.totalPrice);
								}
								else {
									$(data.right).hide().css('opacity',0.0).appendTo('.right .item-list').slideDown(200).animate({opacity: 1.0});
								}				
							});
							$('.add-form-container .js-barcode-input, .add-form-container .js-hidden-barcode-input').val('');
						}
					}
				, 'json');
			}
			else {
				var target = $(e.target).parents('.item'),id = target.data('prod-id') || target.data('gift-card-id'), type = (target.data('prod-id') ? 'prod' : 'gift-card');
				/* Removes the item of the clicked remove button */
				$.post(_SITE_URL+'mod/act/SaleAct.php',
				{'a':'removeItem','id':id,'type':type},
				function(data){
					calcTotals();
					var classType = type == 'prod' ? '.right .item-list .item[data-prod-id="'+id+'"]' : '.right .item-list .item[data-gift-card-id="'+id+'"]';
					$(classType).css({opacity: 1.0}).animate({opacity: 0.0}).slideUp(200, function() {
						$(this).remove();
						if ($('.right .item-list .item:not(.default)').length == 0) {
							$('.left .item-list .item.default, .right .item-list .item.default').fadeIn();
						}
					});
					target.css({opacity: 1.0}).animate({opacity: 0.0}).slideUp(200, function() {
						$(this).remove();
						var activeAmount = $('.left .item-list .item.active').length;
						if (activeAmount > 1) {
							$('.left .item-list .item.active').addClass('multiple');
							$('.left .right-item-list-buttons').slideDown();
						}
						else {
							$('.left .item-list .item.active').removeClass('multiple');
							$('.left .right-item-list-buttons').slideUp();
						}
					});
				});
			}
		}
	});

	/*
	* Adds events on focusout of gift card items in the list
	*/
	$('.left .item-list').undelegate('.item.gift-card-add-form.new input', 'focusout.GiftCardFocusOut');
	$('.left .item-list').delegate('.item.gift-card-add-form.new input', 'focusout.GiftCardFocusOut', function() {
		if (!locked) {
			var parent = $(this).parents('.item'), code = parent.find('.js-new-gift-card-input').val(), amount = parent.find('.js-gift-card-amount-input').val();
			/* Creates the gift card if the code and the price aren't empty */
			if (code != "" && amount != "") {
				$.post(_SITE_URL+'mod/act/SaleAct.php',
				{'a':'addGiftCard','code':code,'amount':amount},
				function(data){
					calcTotals();
					parent.replaceWith(data.left);
					$('.right .item-list .item.default').fadeOut(function() {
						$(data.right).hide().css('opacity',0.0).appendTo('.right .item-list').slideDown(200).animate({opacity: 1.0});							
					});
				}, 'json');
			}
		}
	});
});