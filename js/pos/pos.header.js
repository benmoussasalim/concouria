$(document).ready(function(){
	/*
	* Changes the seller number
	*/
	$('.js-cashier-user').off('keydown.userChange');
	$('.js-cashier-user').on('keydown.userChange', function(e) {
		if (e.which == 13) {
			e.preventDefault();
			var val = $(this).val();

			$.post(_SITE_URL+'mod/act/SaleAct.php',
			{'a':'changeSeller', val:val},
			function(data){
				if (data != 'error') {
					$('.main').removeClass('inactivity');
					locked = false;
					$('.popup-overlay').fadeOut(function() {
						$(this).removeAttr('style');
					});
					$('.popup-seller').fadeOut();
					$('.cashier-user-container').removeClass('wrong').addClass('correct');
					$('.js-cashier-user').val(val);
				}
				else {
					setInactivity();
					$('.cashier-user-container').addClass('wrong');
				}
			});
		}
	});
});