<?php
    $customOutputIndex = true;
	$hf_client = 1;
	$adminJs = "";
    
    $css .= loadCss(_SITE_URL.'css/cms/global.css');

	$headJs .= "<script type='text/javascript' src='https://maps.google.com/maps/api/js?key=AIzaSyDem2Mge4-g3Ue1Bbbyy-QwJxL0TRHZjFs'></script>";
    
   //['siteDescription'] = "Bénéficier du maximum d’opportunités de gagner un concours sans avoir les soucis de vous y inscrire. Nous le faisons pour vous! Inscrivez-vous à Concouria et nous vous inscrirons à des milliers de concours en ligne.";
    //$output['siteKeywords'] = "Concouria, Inscription, Adresse courriel, Opportunités, Prix, Concours, Gagnants, Abonnement, Voyages, Auto, Véhicule, Automobile, Voiture, Carte cadeau, Argent comptant, Essence, Meubles et éléctroménagers";
	
    if($request['cley']){
		$dataCley = AccountQuery::create()->leftJoinWith('Authy')->where('md5(concat(account.Firstname," ",account.Lastname," ",Authy.IdAuthy)) = ?',$request['cley'])->setFormatter(ModelCriteria::FORMAT_ARRAY)->findOne();

		if($dataCley['Authy']['IdAuthy'] and $dataCley['Authy']['Deactivate'] =='Oui'){
			AuthyQuery::create()->filterByIdAuthy($dataCley['Authy']['IdAuthy'])->update(array('Deactivate' => '1'));

			if(!empty($dataCley['Authy']['Email']) && !empty($dataCley['Authy']['PasswdHash'])) {
				$e = new AuthyForm();
				if($_SESSION[_AUTH_VAR]->get('isConnected') == 'NO') {
					$e->tryLog($dataCley['Authy']['Email'], $dataCley['Authy']['PasswdHash']);
				}

				$output['onReadyJs'] .= "document.location = '"._SITE_URL."formulaire?payment=required';";
			}
		}
    }

	if($request['subscription'] == 'success') { $output['onReadyJs'] .= "throwMessage('".addslashes(_("Votre compte est activé."))."', false,'success-inscription');"; }

	$lgCatpcha = 'fr_CA';
	if($lang_sql != 'fr_CA') { $lgCatpcha = 'en'; }

	$headJs .= "<script src='https://www.google.com/recaptcha/api.js?hl=".$lgCatpcha."'></script>";

	//$headBalise .= "<meta name='msvalidate.01' content='4E8C0560C2A2E3C49664C390EE26FFAC' />";

    $customFile = ['header','footer'];
	if($customFile) {
		foreach($customFile as $file) {
			if (file_exists(_BASE_DIR.'mod/page/'.$file.'.php')) {
				include _BASE_DIR.'mod/page/'.$file.'.php';
				$swContent[$file] = div($htmlOutput,'','class="sw-'.$file.'"');
			}
		}
	}

	if ($page){
		$output['html'] = "";
        
        //$siteTitle = $page->getTranslation($lang_sql)->getName();
        //$output['siteTitle'] = $siteTitle." - Concouria - Des milliers de concours en ligne à un seul endroit!";

		if($page->getType() == 'Contenu fixe') { $fixClass = 'fix-content custom-text wrapper'; }

		$blocks = BlockQuery::create()->filterByIdContent($page->getIdContent())->filterByStatus('Publié')->find();
		if($blocks) {
			foreach($blocks as $block) {
				$content = str_replace('%%Block#'.$block->getIdBlock().'%%',$block->getTranslation($lang_sql)->getText(),$content);

			}
		}
        
        $slug = $page->getSlug();

    }
    
    if($request['p'] != 'invoice'  AND $request['p'] != '404') {
        $output['html'] .=
                $swContent['header']
                .div($content, '', 'data-type="content" data-slug="'.$slug.'" class="'.$slug.' '.$fixClass.' '.' block-content'.$editableClass.'"')
                .$swContent['footer']
                .div('','','class="black-overlay"')
                .button(span(_("Signaler un problème")),'class="js-signal-problem btn-signal-problem"');

        $output['html'] .=
            div('','','class="overlay"');
    }

	/*if(!$_COOKIE['video_concouria']) {
		setcookie("video_concouria",true,time() + strtotime('+1 months'));

		$output['html'] .=
		div(
			button("Fermer",'class="close-video trigger-video"')
			.div(
				'<iframe width="100%" height="100%" src="https://www.youtube.com/embed/LP5WEzKNkIc?rel=0&autoplay=1" frameborder="0" allowfullscreen></iframe>'
			,'','class="video-content"')
		,'','class="video-overlay trigger-video"');

		$output['onReadyJs'] .= "
			$('.video-content iframe').css({'width': ($(window).width() * 0.8),'height': ($(window).height() * 0.8)});

			$('.trigger-video').click(function(e) {
				if(e.target === this) {
					$('.video-overlay').fadeOut(500,function() { $('.video-overlay').remove(); });
				}
				return false;
			});
		";
	}*/

    //SIGNALEMENT DE PROBLÈME
    $output['onReadyJs'] .= "
        $('body').on('click','.js-signal-problem',function() {
            $.post(_SITE_URL + 'mod/act_p/ContactAct.php',{a:'SignalForm'},function(data) {
                popup(data);
            });
            return false;
        });

        $('body').on('submit','#signal-form',function() {
            if(validateForm('#signal-form',true)) {
                var browser = get_browser();

                $.post(_SITE_URL + 'mod/act_p/ContactAct.php',{a:'SubmitSignal','form':$(this).serialize(),'browser_name':browser.name,'browser_version':browser.version },function(data) {
                    throwMessage(data.message,data.error,data.class);
                    if(data.error == false) { popup(); }
                },'json');
            }
            return false;
        });
    ";
    
    $output['js'] .= "
        function get_browser() {
            var ua=navigator.userAgent,tem,M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
            if(/trident/i.test(M[1])){
                tem=/\brv[ :]+(\d+)/g.exec(ua) || [];
                return {name:'IE',version:(tem[1]||'')};
            }
            if(M[1]==='Chrome'){
                tem=ua.match(/\bOPR|Edge\/(\d+)/);
                if(tem!=null)   {return {name:'Opera', version:tem[1]};}
            }
            M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
            if((tem=ua.match(/version\/(\d+)/i))!=null) {M.splice(1,1,tem[1]);}

            return {
                name: M[0],
                version: M[1]
            };
        }
    ";

	$output['js'] .= "
        function swActive() { if($('#body').hasClass('sw-edit-content') || $('#body').hasClass('sw-edit-image')) { return true; } else { return false; } }

		function emptyForm(form) {
			$(form).find('input, textarea').each(function() {
				$(this).val('');
			});
		}

		function validateForm(form) {
			var form_array = [];

			$(form).find('.required').each(function() {
				if($(this).val() == '') {

					if(form == '#inscription-form' || 'form-complete') { $(this).parent().addClass('form-error'); }
					else { $(this).addClass('form-error'); }

					form_array.push($(this).attr('name'));
				} else  {
					if(form == '#inscription-form' || 'form-complete') { $(this).parent().removeClass('form-error'); }
					else { $(this).removeClass('form-error'); }
				}
			});

			if(form_array.length == 0) { return true; }
			else { return false; }
		}

		function throwMessage(message,error,id) {
            var class_error = 'success';
            if(error == true) { class_error = 'error'; }
            if(!$('.message-box').length) { $(body).append('".addslashes(ul('',"class='message-box'"))."'); }
            if(id == null || $('.message-box li.' + id).length < 2) { $('.message-box').append('<li class=\"new '+ id +' '+ class_error +'\"><span class=\"message-icon\"></span><p>'+ message +'</p></li>'); }


            setTimeout(function() {
                $('.message-box li.new').each(function() {

                    var line = $(this);
                    line.removeClass('new');
                    var timer = setTimeout(function() {
                        line.addClass('new');
                        setTimeout(function() {
                            line.remove();
                            if(!$('.message-box li').length) { $('.message-box').slideUp(250, function() {  $('.message-box').remove(); });  }
                        },250);
                    },5000);
                });
            },10);
        }
	";
        $output['onReadyJs'] .= "onScroll();";

        $output['windowScroll'] .= "onScroll();";

        $output['js'] .= "
            function onScroll() {
                if(!$(document).scrollLeft() == 0){
                    $(document).scrollLeft(0);
                }
            }
            ";
        
        //POPUP
$output['js'] .= "
    function popup(message,clic_close) {
        clic_close = (typeof clic_close !== 'undefined') ?  clic_close : false;

        var close_class = 'close-popup';
        if(clic_close == false) { close_class = ''; }

        if(!message) {
            $('.popup-overlay,body').removeClass('trigger');
            setTimeout(function() { $('.popup-overlay').remove(); }, 500);
        } else {
            if($('.popup-overlay.trigger').length) {
                $('.popup-overlay').removeClass('trigger');
                setTimeout(function() {
                    $('.popup-overlay').remove();
                    $('body').append('<div class=\"popup-overlay '+close_class+'\"><div class=\"popup-container\"><div class=\"popup-content\">'+ message +'</div></div></div>');
                    setTimeout(function() { $('.popup-overlay').addClass('trigger'); }, 100);
                }, 500);
            } else {
                $('body').append('<div class=\"popup-overlay '+close_class+'\"><div class=\"popup-container\"><div class=\"popup-content\">'+ message +'</div></div></div>');
                setTimeout(function() { $('.popup-overlay,body').addClass('trigger'); }, 100);
            }

        }
    }
";

//LOADING OVERLAY
$output['js'] .= "
    function loadingOverlay(message) {
        var timer;

        if($('.loading-overlay').length || message === true) {
            $('.loading-overlay').removeClass('toggle');
            timer = setTimeout(function() {
                clearTimeout(timer);
                $('.loading-overlay').remove();
            },500);
        } else {
            $('#body').append('<div class=\"loading-overlay\"><div class=\"loading-wrapper\"><div class=\"loading-animation\"> <svg class=\"hourglass\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 120 206\" preserveAspectRatio=\"none\"><path class=\"middle\" d=\"M120 0H0v206h120V0zM77.1 133.2C87.5 140.9 92 145 92 152.6V178H28v-25.4c0-7.6 4.5-11.7 14.9-19.4 6-4.5 13-9.6 17.1-17 4.1 7.4 11.1 12.6 17.1 17zM60 89.7c-4.1-7.3-11.1-12.5-17.1-17C32.5 65.1 28 61 28 53.4V28h64v25.4c0 7.6-4.5 11.7-14.9 19.4-6 4.4-13 9.6-17.1 16.9z\"/><path class=\"outer\" d=\"M93.7 95.3c10.5-7.7 26.3-19.4 26.3-41.9V0H0v53.4c0 22.5 15.8 34.2 26.3 41.9 3 2.2 7.9 5.8 9 7.7-1.1 1.9-6 5.5-9 7.7C15.8 118.4 0 130.1 0 152.6V206h120v-53.4c0-22.5-15.8-34.2-26.3-41.9-3-2.2-7.9-5.8-9-7.7 1.1-2 6-5.5 9-7.7zM70.6 103c0 18 35.4 21.8 35.4 49.6V192H14v-39.4c0-27.9 35.4-31.6 35.4-49.6S14 81.2 14 53.4V14h92v39.4C106 81.2 70.6 85 70.6 103z\"/></svg></div><div class=\"loading-content\"><p>'+ message +'</p></div></div>');

            timer = setTimeout(function() {
                clearTimeout(timer);
                $('.loading-overlay').addClass('toggle');
            },50);
        }
    }
";

$output['onReadyJs'] .= " $('body').on('click','.close-popup',function(e) {  if(e.target === this) { popup(); return false; } }); ";
