<?php

include 'inc/init.php';
$lang_sql = ucfirst($_SESSION[_AUTH_VAR]->lang);
$champSqlUrl = 'filterByUrl'.$lang_sql;
$champSqlName = 'filterByName'.$lang_sql;
$champSqlDescri= 'filterByDescription'.$lang_sql;
$lang_full_sql_two="Francais-Anglais";

$lang_sql = "fr_CA";

$i=0;
$map[$i]['url'] = _SITE_URL;
$map[$i++]['prio'] = '';

$pages = ContentQuery::create()
	->filterByStatus('Publié')
	->setFormatter(ModelCriteria::FORMAT_ARRAY)->find();
if($pages){
	foreach($pages as $page){//name_fr description_fr
		if ($page['Slug'] != 'accueil') {
			$page['DateModification'] = explode(' ', $page['DateModification']);
			$map[$i]['url'] = _SITE_URL.$page['Slug'];
			$map[$i]['dateModif'] = $page['DateModification'][0];
			$map[$i]['freq'] = 'weekly';
			$map[$i]['prio'] = '0.6';
			#image produit
			$map[$i]['img'] = '';
			$i++;
		}
	}
}

# do xml
$xmls = genXml($map);
$i=0;
foreach($xmls as $xml){
	if($xml){
		writeXml($xml,$i);
		$i++;
	}
}
$xml = genXmlIndex($i--);
writeXml($xml,'');

//echo $xml;

function genXmlIndex($o){
	$xml= '<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

	for($i=0;$i<$o;$i++){
		$xml .= "<sitemap>
<loc>"._SITE_URL."sitemap".$i.".xml</loc>
<lastmod>".date('c')."</lastmod>
</sitemap>";
	}
	return $xml."</sitemapindex>";
}

############
#functions
############
function writeXml($xml,$i){
	$fp = fopen('sitemap'.$i.'.xml', 'w');
	fwrite($fp, $xml);
	fclose($fp);
}
function genXml($map){
	$url_debut= '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
	';
	$url_end .= '</urlset>';
	$i=0;$f=0;
	//echo count($tab);
	while($map[$i]['url']){
		if($i%1000 == 0 and $i !=0){
			$urlTab[$f] = $url_debut.$url_link.$url_end;
			$url_link="";
			$f++;
		}
		$dateMod = (!empty($map[$i]['dateModif']))?"<lastmod>".$map[$i]['dateModif']."</lastmod>":"<lastmod>".date('Y-m-d')."</lastmod>";
		$priority = (empty($map[$i]['prio']))?"":"<priority>".$map[$i]['prio']."</priority>";
		$changefreq = (empty($map[$i]['freq']))?"<changefreq>yearly</changefreq>":"<changefreq>".$map[$i]['freq']."</changefreq>";
		$gooImage = (!empty($map[$i]['img']))?"<image:image><image:loc>".$map[$i]['img']."</image:loc></image:image>":"";
		$gooVideo = (!empty($map[$i]['vid']))?"<video:video><video:content_loc>".$map[$i]['vid']."</video:content_loc></video:video>":"";
		$url_link .= "<url><loc>".$map[$i]['url']."</loc>".$dateMod.$changefreq.$priority.$gooImage.$gooVideo."</url>";
		$i++;
	}

	$urlTab[$f] = $url_debut.$url_link.$url_end;
	$url_link="";
	$f++;


	$urlTab[$f] = str_replace('&','%26',$urlTab[$f]);
	//return preg_replace ("/\s+/", " ", $url);
	return $urlTab;
}
