
/*############################### # Progexpert ###############################*/ var sw_message_delay; function sw_message(message,error,id,stick) { if (sw_message_delay === undefined) {sw_message_delay=1750;} if(message === true) { sw_rm_message(error); } else { if(!stick) { stick = false; } var class_error = 'success'; if(error == true) { class_error = 'error'; } if(!$('.sw-message').length) { $('body').append('<ul class=\'sw-message\'></ul>'); } if(id == null || !$('.sw-message li.' + id).length) { $('.sw-message').append('<li class=\'new '+ id +' '+ class_error +'\'><span class=\"message-icon\"></span><p>'+ message +'</p></li>'); } setTimeout(function() { $('.sw-message li.new').each(function() { var line = $(this); line.removeClass('new'); if(stick == false) { var timer = setTimeout(function() { sw_rm_message(id); },sw_message_delay); } }); },10); } } function removeMessage(id) { $('.sw-message li.' + id).addClass('new'); setTimeout(function() { $('.sw-message li.' + id).remove(); if(!$('.sw-message li').length) { $('.sw-message').slideUp(250, function() { $('.sw-message').remove(); }); } },250); } function loadingOverlay(message) { var timer; if($('.loading-overlay').length || message === true) { $('.loading-overlay').removeClass('toggle'); timer = setTimeout(function() { clearTimeout(timer); $('.loading-overlay').remove(); },500); } else { $('#body').append('<div class=\"loading-overlay\"><div class=\"loading-wrapper\"><div class=\"loading-animation\"> <svg class=\"hourglass\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 120 206\" preserveAspectRatio=\"none\"><path class=\"middle\" d=\"M120 0H0v206h120V0zM77.1 133.2C87.5 140.9 92 145 92 152.6V178H28v-25.4c0-7.6 4.5-11.7 14.9-19.4 6-4.5 13-9.6 17.1-17 4.1 7.4 11.1 12.6 17.1 17zM60 89.7c-4.1-7.3-11.1-12.5-17.1-17C32.5 65.1 28 61 28 53.4V28h64v25.4c0 7.6-4.5 11.7-14.9 19.4-6 4.4-13 9.6-17.1 16.9z\"/><path class=\"outer\" d=\"M93.7 95.3c10.5-7.7 26.3-19.4 26.3-41.9V0H0v53.4c0 22.5 15.8 34.2 26.3 41.9 3 2.2 7.9 5.8 9 7.7-1.1 1.9-6 5.5-9 7.7C15.8 118.4 0 130.1 0 152.6V206h120v-53.4c0-22.5-15.8-34.2-26.3-41.9-3-2.2-7.9-5.8-9-7.7 1.1-2 6-5.5 9-7.7zM70.6 103c0 18 35.4 21.8 35.4 49.6V192H14v-39.4c0-27.9 35.4-31.6 35.4-49.6S14 81.2 14 53.4V14h92v39.4C106 81.2 70.6 85 70.6 103z\"/></svg></div><div class=\"loading-content\"><p>'+ message +'</p></div></div>'); timer = setTimeout(function() { clearTimeout(timer); $('.loading-overlay').addClass('toggle'); },50); } } function deferImg(delay){ setTimeout(function(){ $('[data-defer]:not([data-defer=""])').each(function() { var defer = $(this).data('defer'); if($(this).is('img')) { $(this).attr('src',defer); } else { $(this).css('background-image',"url('"+ defer +"')"); } $(this).attr('data-defer',''); }); },delay); } function popup(message,clic_close,more_class) { clic_close = (typeof clic_close !== 'undefined') ? clic_close : false; more_class = (typeof more_class !== 'undefined') ? more_class : ''; var class_selector = '.' + more_class, close_class = ''; if(more_class == '') { class_selector = ''; } if(clic_close == true) { close_class = ' js-close-popup'; } if(!message) { if($('.popup-overlay'+ class_selector).length) { $('.popup-overlay'+ class_selector +',body').removeClass('trigger'); setTimeout(function() { $('.popup-overlay' + class_selector).remove(); }, 500); } } else { if($('.popup-overlay.trigger' + class_selector).length) { $('.popup-overlay' + class_selector).removeClass('trigger'); setTimeout(function() { $('.popup-overlay' + class_selector).remove(); $('body').append('<div class="popup-overlay '+ more_class + close_class +'"><div class="popup-container"><div class="popup-content">'+ message +'</div></div></div>'); setTimeout(function() { $('.popup-overlay' + class_selector).addClass('trigger');deferImg(0); }, 100); }, 500); } else { $('body').append('<div class="popup-overlay '+ more_class + close_class +'"><div class="popup-container"><div class="popup-content">'+ message +'</div></div></div>'); setTimeout(function() { $('.popup-overlay,body').addClass('trigger');deferImg(0); }, 100); } } } function sw_rm_message(id){ removeMessage(id);} $(document).ready(function() { $('.sw-version button, .hide-optional-wrapper button').click(function() { if($('.top-nav').hasClass('toggle-panel') || $('.top-nav').hasClass('toggle')) { $('.top-nav').removeClass('toggle-panel'); $('.top-nav').addClass('advanced-toggle'); $('.left-panel .nav, .trigger-sw-menu').slideUp(250,function () { $('.top-nav').removeClass('toggle'); $('.top-nav').addClass('minimize'); }); var show = 'minimize'; }else if($('.top-nav').hasClass('advanced-toggle') || $('.top-nav').hasClass('minimize')){ $('.top-nav').removeClass('advanced-toggle'); $('.optional-panel, .left-panel .nav').slideDown(250,function () { $('.top-nav').removeClass('minimize'); }); var show = 'show'; } else { $('.top-nav').addClass('toggle-panel'); $('.optional-panel').slideUp(250); var show = 'toggle'; } var type = 'public'; if($('body').hasClass('sw-admin')) { type = 'admin'; } $.post(_SITE_URL + 'mod/robotMgr.php', {a:'ixoptional', sw:show, type:type }, function(data){}); return false; }); $('body').on('mouseover.shortcut','.sw-shortcut-wrapper',function() { $('body').off('mouseover.shortcut'); $.post(_SITE_URL + 'SimpleWeb/EditContent.php',{'a':'getShortcut'},function(data) { if(data) { $('.sw-shortcut-content').html(data); } }); }); $('body').on('click','.sw-shortcut-btn',function(e) { $('.sw-shortcut-wrapper').toggleClass('show-shortcut'); e.preventDefault(); }); $('html').unbind('DOMSubtreeModified'); $('html').bind('DOMSubtreeModified', function(){deferImg();}); });
