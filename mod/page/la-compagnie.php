<?php

$reviews = TemoignageQuery::create()->filterByOnline('Oui')->orderBy('Order','ASC')->limit(6)->find();
if($reviews) {
	foreach($reviews as $review) {
		$listReview .=
		div(
			div(
				p($review->getTitle(),['class="name"',swEdit('Title')])
				.div($review->getTranslation($lang_sql)->getResume(),'',['class="text"',swEdit('Resume',true)])

				.href(span("+"),_SITE_URL.'temoignages#temoignage-'.$review->getIdTemoignage(),'class="link" title="Voir le témoignage au complet"')
			,'','class="circle-content"')
		,'temoignage-'.$review->getIdTemoignage(),['class="temoignage"',swEdit('Temoignage',$review->getIdTemoignage(),$review->getTitle())]);
	}
}

$htmlOutput =
div(
	div(
		div(
			img(_SITE_URL.'css/img/bg-concept.png', NULL, NULL,swEdit('img'),_("Un concept unique"))
		,'','class="image-wrapper"')
		.$blockContent[4]
	,'','class="wrapper"')
,'',['class="concept"',swEdit('bg')])

.div(
	div(
		$blockContent[5]

		.div(
			img(_SITE_URL.'css/img/bg-monthly.png', NULL, NULL,swEdit('img'),_("Des centaines de concours à tous les mois"))
		,'','class="image-wrapper"')
	,'','class="wrapper"')
,'',['class="monthly-contest"',swEdit('bg')])

.div(
	div($blockContent[6],'','class="wrapper"')
,'',['class="simple-concept"',swEdit('bg')])

.div(
	div(
	h2(_("Quelques témoignages"))

	.$listReview
	,'','class="wrapper"')
,'','class="temoignage-concept"')

;


?>