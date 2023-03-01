<?php

$winners = WinnerQuery::create()->filterByOnline('Oui')->orderBy('Order','DESC')->find();
if($winners) {
	foreach($winners as $winner) {
		$listMonth = '';
		$months = MonthWinnerQuery::create()->filterByIdWinner($winner->getIdWinner())->filterByOnlune('Oui')->orderBy('Order','DESC')->find();
		if($months) {
			foreach($months as $month) {
				$listMonth .= div(h3(span($month->getTranslation($lang_sql)->getName(),swEdit('Name'))." ".$winner->getTitle()).div($month->getTranslation($lang_sql)->getText(),'',swEdit('Text',true)),'',['class="description"',swEdit('MonthWinner',$month->getIdMonthWinner(),$month->getTitle())]);
			}
		}
		$listYear .= div(h2($winner->getTitle(),swEdit('Title')).$listMonth,'',['class="year-container" data-year="'.$winner->getIdWinner().'"',swEdit('Winner',$winner->getIdWinner(),$winner->getTitle())]);
		$yearIndex .= li(href($winner->getTitle(),'javascript:',['data-year="'.$winner->getIdWinner().'"',swEdit('Title')],true),swEdit('Winner',$winner->getIdWinner(),$winner->getTitle()));
	}
}

$htmlOutput =
div(
	div(
		$blockContent[17]
		.ul($yearIndex,'class="faq-index"')
	,'','class="wrapper"')
,'',['class="faq-intro"',swEdit('bg')])
.div($listYear,'','class="faq-content wrapper"')
.button(_("Retourner en haut"),'class="scroll-top"');


$output['onReadyJs'] .= "
	$('.faq-index a').click(function() {
        if(!swActive()) {
            var data = $(this).data('year');

            $('.faq-content .question').removeClass('current');
            $('.faq-content .question[data-year=\"'+data+'\"]').addClass('current');

            $('body,html').animate({scrollTop: $('.year-container[data-year=\"'+data+'\"]').offset().top },1000);

            return false;
        }
	});

	$('.scroll-top').click(function() {
		$('body,html').animate({scrollTop: 0 },1500);

		return false;
	});
";

?>