<?php

$reviews = TemoignageQuery::create()->filterByOnline('Oui')->orderBy('Order','ASC')->find();
if($reviews) {
	foreach($reviews as $review) {
            if(strpos($review->getTranslation($lang_sql)->getText(), '<p>') == false){
                $description = '<p>'.$review->getTranslation($lang_sql)->getText().'</p>';
            }
            else{
                $description = $review->getTranslation($lang_sql)->getText();
            }
            $listReview .=
                div(
                    div(
                        h3($review->getTitle(),swEdit('Title'))
                        .div($description,'',swEdit('Text',true))
                    ,'','class="description review"')
                ,'temoignage-'.$review->getIdTemoignage(),['class="concours"',swEdit('Temoignage',$review->getIdTemoignage(),$review->getTitle())])
            ;
	}
}

$htmlOutput =
div(
	div($blockContent[18],'','class="wrapper"')
,'',['class="concours-intro"',swEdit('bg')])
.div(div($listReview),'','class="wrapper"');

?>