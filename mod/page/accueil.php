<?php

$reviews = TemoignageQuery::create()->filterByOnline('Oui')->orderBy('Order','ASC')->limit(3)->find();
if($reviews) {
	foreach($reviews as $review) {
		$listReview .=
		div(
			div(
				p($review->getTitle(),['class="name"',swEdit('Title')])

				.div($review->getTranslation($lang_sql)->getResume(),'',['class="text"',swEdit('Resume',true)])

				.href(span("+"),_SITE_URL.'temoignages#temoignage-'.$review->getIdTemoignage(),'class="link" title="Voir le témoignage au complet"')
			,'','class="circle-content"')
		,'',['class="temoignage"',swEdit('Temoignage',$review->getIdTemoignage(),$review->getTitle())]);
	}
}

$nbrAccount = AccountQuery::create()->filterByExportReady('Oui')->count();

$output['onReadyJs'] .= "
	$('.video-content iframe').css({'width': ($(window).width() * 0.8),'height': ($(window).height() * 0.8)});

	$('.trigger-video').click(function(e) {
		if(e.target === this) {
			$('.video-overlay').fadeOut(500,function() { $('.video-overlay').remove(); });
		}
		return false;
	});
";

/*
if($_SESSION[_AUTH_VAR]->get('isConnected') != 'YES') {
    $blockVideo =
    div(
        button("Fermer",'class="close-video trigger-video"')
        .div(
            '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/D_oZR5ar9a8?rel=0&autoplay=1&VQ=HD720" frameborder="0" allowfullscreen></iframe>'
        ,'','class="video-content"')
    ,'','class="video-overlay trigger-video"');
}*/

$sliders = SliderQuery::create()->filterByOnline('Oui')->orderBy('Order','ASC')->find();
if($sliders) {
    $i = 1;
    foreach($sliders as $slider) {
        if($slider->getSliderFiles()[0]) {
            $sliderLg = $slider->getTranslation($lang_sql);
            
            $listSlider .= 
                li(
                    img(_SITE_URL.'css/img/promo-pog.png',null,null,['class="promo-pog"',swEdit('img')],_("Promo de lancement! 199.99$"))
                    
                    .div(
                        img(_SITE_URL.$slider->getSliderFiles()[0]->getFichier(), NULL, NULL,swEdit('img'),$slider->getTitle())
                    ,'','class="image-wrapper"')
                    .div($sliderLg->getText(),'',['class="caption"',swEdit('Text',true)])
                ,['class="wrapper slide" data-slide="'.$i.'"',swEdit('Slider',$slider->getIdSlider(),$slider->getTitle())])
            ;
            
            $i++;
        }
    }
}

$audioLabel = _PLAYER_TEXT_FR;
if($lang_sql == 'en_US') { $audioLabel = _PLAYER_TEXT_EN; }

$htmlOutput =
section(
	/*ul(
        img(_SITE_URL.'css/img/promo-pog.png',null,null,['class="promo-pog"',swEdit('img')],_("Promo de lancement! 199.99$"))

		.div(
			img(_SITE_URL.'css/img/guy-intro.png', NULL, NULL,swEdit('img'),_("Nous participons pour vous à des milliers de concours"))
		,'','class="image-wrapper"')
        .$blockContent[9]
    ,'class="wrapper slider-wrapper"')*/
    
    ul(
        $listSlider
    ,'class="wrapper slider-wrapper"')
,['class="intro"',swEdit('bg')])

.div(
	div(
		href(strip_tags($blockContent[10],'<div><span><sup>'),'javascript:','class="block win trigger-subscribe" title="'.addslashes(_("Maximisez vos chances de gagner")).'"')

		.href(strip_tags($blockContent[11],'<div><span><sup>'),_SITE_URL.'la-compagnie','class="block excellence" title="'.addslashes(_("Nous sommes le site par excellence pour les concours")).'"')

		.href(strip_tags($blockContent[12],'<div><span><sup>'),_SITE_URL.'abonnement','class="block subscribe trigger-subscribe" title="'.addslashes(_("Inscrivez-vous et laissez-nous vous faire gagner")).'"')
	,'#','class="three-block wrapper"')

	.div(
		div(
			$blockContent[13]
			.$blockContent[14]
		,'','class="wrapper"')
	,'','class="content-promo"')
,'',['class="section-promo"',swEdit('bg')])

.div(
	div(
		button(_("Continuer"))
		.$blockContent[15]
	,'','class="header-user"')

	.div(
        str_replace('%%AccountCount%%',$nbrAccount,$blockContent[16])
	,'',['class="content-user"',swEdit('bg')])

,'','class="section-user"')

.div(
	div(
		h2(_("Quelques témoignages"))
		.$listReview
	,'','class="wrapper"')

,'','class="section-temoignage"')

.$blockVideo
    
.div(
    div(div('','','class="audio-progress"'),'','class="progress-wrapper"')
    .button(span(''),'class="js-play-btn stop"')
    .p($audioLabel)
    .'<audio>
        <source src="'._SITE_URL.'mod/file/pub-radio.mp3" type="audio/mpeg">
    </audio>'
,'','class="clip-wrapper"')
    
;

$output['onReadyJs'] .= "
    var nbr_slide = 0,current_slide = 1,slider_delay;

    clearInterval(slider_delay);
    nbr_slide = $('.slider-wrapper [data-slide]').length;
    $('.slider-wrapper [data-slide=\"'+ current_slide +'\"]').addClass('current');
    
    if(nbr_slide > 1) {
        slider_delay = setInterval(function() {
            $('.slider-wrapper [data-slide].current').removeClass('current');
            if(current_slide == nbr_slide) { current_slide = 1; } else { current_slide++; }
            $('.slider-wrapper [data-slide=\"'+ current_slide +'\"]').addClass('current');
        },"._SLIDER_DELAY.");
    }
";

$output['onReadyJs'] .= "
    $('.intro .promo-pog').click(function() {
        if(!swActive()) {
            console.log($('.clip-wrapper audio')[0].duration);

            $('.clip-wrapper').addClass('toggle');
            $('.clip-wrapper audio')[0].play();
            return false;
        }
    });
    
    $('.clip-wrapper .js-play-btn').click(function() {
        $('.clip-wrapper').toggleClass('toggle');
        $('.clip-wrapper audio')[0].pause();
        $('.clip-wrapper audio')[0].currentTime = 0;
        return false;
    });
";

//CLIP AUDIO
if($request['pub'] == 'on') { $output['onReadyJs'] .= "setTimeout(function() { $('.intro .promo-pog').click(); },500);"; }