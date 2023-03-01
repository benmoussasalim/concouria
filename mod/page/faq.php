<?php

$faqs = FaqQuery::create()->filterByOnlune('Oui')->orderBy('Order','ASC')->find();

if($faqs) {
	foreach($faqs as $faq) {
		$faqIndex .= li(href($faq->getTranslation($lang_sql)->getName(),'javascript:',['data-faq="'.$faq->getIdFaq().'" title="'.$faq->getTranslation($lang_sql)->getName().'"',swEdit('Name')]),swEdit('Faq',$faq->getIdFaq(),$faq->getTitle()));

		$listFaq .=
		div(
			h3($faq->getTranslation($lang_sql)->getName(),swEdit('Name'))

			.div(
				$faq->getTranslation($lang_sql)->getText()
			,'',['class="answer custom-text"',swEdit('Text',true)])
		,'',['class="question" data-faq="'.$faq->getIdFaq().'"',swEdit('Faq',$faq->getIdFaq(),$faq->getTitle())]);
	}
}


$htmlOutput =
div(
	div(
		h2(_("Foire aux questions"))
		.p(_("La FAQ vous permettra de trouver réponses à vos questions."))

		.ul($faqIndex,'class="faq-index"')
	,'','class="wrapper"')
,'',['class="faq-intro"',swEdit('bg')])

.div($listFaq,'','class="faq-content wrapper"')

.button(_("Retourner en haut"),'class="scroll-top"');

$output['onReadyJs'] .= "
	$('.faq-index a').click(function() {
        if(!swActive()) {
            var data = $(this).data('faq');

            $('.faq-content .question').removeClass('current');
            $('.faq-content .question[data-faq=\"'+data+'\"]').addClass('current');

            $('body,html').animate({scrollTop: $('.faq-content .question[data-faq=\"'+data+'\"]').offset().top },1000);

            return false;
        }
	});

	$('.scroll-top').click(function() {
		$('body,html').animate({scrollTop: 0 },1500);

		return false;
	});
";

?>