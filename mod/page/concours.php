<?php

$minPrice = '';
$maxPrice = '';

if(!$request['i']) { $request['i'] = 'all'; }

$concourss = 
    ConcoursQuery::create()->filterByOnline('Oui');
    
    switch($request['i']) {
        case 'toss':
            $concourss->where('date <= (CURDATE() + INTERVAL 1 WEEK) AND date >= CURDATE()');
        break;
    
        case 'new':
            $concourss->where('(date_creation + INTERVAL 2 WEEK) > CURDATE()');
        break;
    
        case 'all': 
            $concourss->where('(CURDATE() - INTERVAL 2 WEEK) < date');
        break;
    }
    
    if($request['i'] != 'all') { $concourss/*->orderBy('Order','ASC')*/->orderBy('Date','DESC')->where('(date >= CURDATE())'); } else { $concourss = $concourss/*->orderBy('Order','ASC')*/->orderBy('Date','ASC'); }
    $concourss = $concourss->find();
if($concourss) {
	$i = 0;
    $totalConcours = 0;
    
    $newYearConcours = 0;
    $newYearPrice = 0;

	foreach($concourss as $concours) {
        $position = 0;
        
		$creation = 'old';
		if(strtotime($concours->getDateCreation()) > strtotime('-2 weeks')) {  $creation = 'new'; }

		$img = ''; $price = ''; $expired = ''; $expireClass = '';
		foreach($concours->getConcoursFiles() as $imgFile) { $img = img(_SITE_URL.$imgFile->getFichier(),null,null,'',$concours->getTranslation($lang_sql)->getName()); }
		if($img == '') { $img = img(_SITE_URL.'css/img/logo.png',null,null,'class="concouria" title="'.$concours->getTranslation($lang_sql)->getName().'" alt="'.$concours->getTranslation($lang_sql)->getName().'"'); }

		$price = str_replace(' ','',$concours->getPrice());

		if($price <= $minPrice OR !$minPrice) { $minPrice = $price; }
		if($price >= $maxPrice OR !$maxPrice) { $maxPrice = $price; }

		$url = '';
		if($concours->getUrl()) {
			$url = href($concours->getUrl(),$concours->getUrl(),'target="_blank"',true);
		}

		if(strtotime($concours->getDate()) < strtotime('now')) {
            $position = 1;
			$expired = p(_("Concours terminé."),'class="expired"');
			$expireClass = 'date-expired';
		}

        if(strpos($concours->getTranslation($lang_sql)->getText(), '<p>') == false){
            $description = '<p>'.$concours->getTranslation($lang_sql)->getText().'</p>';
        }
        else{
            $description = $concours->getTranslation($lang_sql)->getText();
        }

        $totalConcours += $concours->getPrice();
        
        $price = 0;
        if($concours->getPrice()) { $price = $concours->getPrice(); }

		$listConcours[$position] .=
            div(
                div($img,'','class="image-wrapper"')
                .div(
                    h3($concours->getTranslation($lang_sql)->getName().span(span(number_format($price,0,'',' '))."$",'class="price"'))
                    .p(_("Date du tirage:")." ".span(date('Y/m/d',strtotime($concours->getDate()))),'class="date '.$expireClass.'"')
                    .$expired
                    .div($description)
                    .$url
                    //.span($concours->getPrice(),'class="sw-hide" style="margin-top: 15px; font-size: 20px;"')
                ,'','class="description"')
            ,'',['class="concours"',swEdit('Concours',$concours->getIdConcours(),$concours->getTitle())])
        ;

		$i++;
	}
    
    if($request['i'] == 'all') {
        unset($concourss);
        
        $concourss = ConcoursQuery::create()->filterByOnline('Oui')->where('(date > CURDATE())')->find();
        if($concourss) {
            $totalConcours = 0;
            $i = 0;
            unset($minPrice);
            unset($maxPrice);
            
            foreach($concourss as $concours) {
                $price = $concours->getPrice();
                
                if($price <= $minPrice OR !$minPrice) { $minPrice = $price; }
                if($price >= $maxPrice OR !$maxPrice) { $maxPrice = $price; }
                
                $totalConcours += $concours->getPrice();
                $i++;
            }
        }
        
        unset($concourss);
        $concourss = ConcoursQuery::create()->filterByOnline('Oui')->where('(DATE_FORMAT(date,\'%Y\') = \''.date('Y').'\')')->find();
        if($concourss) {
            foreach($concourss as $concours) {
                $newYearConcours++;
                $newYearPrice += $concours->getPrice();
            }
        }
    }
    
    switch($request['i']) {
        case 'toss':
            $pageHeader = h1(_("Concours tirés cette semaine"));
            
            if($listConcours[0]) {
                $pageHeader .= 
                p(span($i)." "._("concours cette semaine pour").' '.span(number_format($totalConcours,0,'.',' ').'$').' '._("à gagner."))
                .p(_("De")." ".span(number_format($minPrice,0,'',' ')."$")." "._("à")." ".span(number_format($maxPrice,0,'',' ')."$").".",'class="price-range"');
            } else { $listConcours[0] = p(_("Aucun concours à afficher."),'class="no-contest"'); }
        break;

        case 'new':
             $pageHeader = h1(_("Concours récemment ajoutés"));
            
            $plural = '';
            if($i > 1) { $plural = 's'; }
            
            if($listConcours[0]) {
                $pageHeader .= 
                p(span($i)." "._("concours récemment ajouté").$plural.' '.("pour").' '.span(number_format($totalConcours,0,'.',' ').'$').' '._("à gagner."))
                .p(_("De")." ".span(number_format($minPrice,0,'',' ')."$")." "._("à")." ".span(number_format($maxPrice,0,'',' ')."$").".",'class="price-range"');
            } else { $listConcours[0] = p(_("Aucun concours à afficher."),'class="no-contest"'); }
        break;

        case 'all':
             $pageHeader = h1(_("Liste complète des concours"));
            
            if($listConcours[0]) {
                $pageHeader .= 
                p(span($i)." "._("concours en vigueur totalisant").' '.span(number_format($totalConcours,0,'.',' ').'$').' '._("à gagner."))
                .p(_("De")." ".span(number_format($minPrice,0,'',' ')."$")." "._("à")." ".span(number_format($maxPrice,0,'',' ')."$").".",'class="price-range"')
                    
                .p(_("En").' '.date('Y').', '.span($newYearConcours)." "._("concours totalisant").' '.span(number_format($newYearPrice,0,'.',' ').'$').'.');
            } else { $listConcours[0] = p(_("Aucun concours à afficher."),'class="no-contest"'); }
        break;
    }
    
}

$htmlOutput =
	div(
		div(
			$pageHeader
		,'','class="wrapper"')
	,'','class="concours-intro"')
	.div(
		div(
            $listConcours[0]
            .$listConcours[1]
        )
	,'','class="wrapper"')
;
