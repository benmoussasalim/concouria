<?php

$pays = PaysQuery::create();
$pcDataO = $pays->usePaysI18nQuery('','join')->filterByLocale($lang_sql)->endUse()
		->select(array('PaysI18n.Name', 'IdPays'))
		->orderBy('PaysI18n.Name', 'ASC')->find();
$arrayPaysOptions = assocToNumDef($pcDataO->toArray(), false);
array_unshift($arrayPaysOptions, ['Sélectionnez un pays','all']);

$province = ProvinceQuery::create();
if($request['IdPays'] AND $request['IdPays'] != 'all') { $province->filterByIdPays($request['IdPays']); }
$pcDataO = $province->useProvinceI18nQuery('','join')->filterByLocale($lang_sql)->endUse()
		->select(array('ProvinceI18n.Name', 'IdProvince'))
		->orderBy('ProvinceI18n.Name', 'ASC')->find();
$arrayProvinceOptions = assocToNumDef($pcDataO->toArray(), false);
array_unshift($arrayProvinceOptions, ['Sélectionner une province','all']);



$region = RegionQuery::create();
if($request['IdProvince'] AND $request['IdProvince'] != 'all') { $region->filterByIdProvince($request['IdProvince']); }
$pcDataO = $region->useRegionI18nQuery('','join')->filterByLocale($lang_sql)->endUse()
		->select(array('RegionI18n.Name', 'IdRegion'))
		->orderBy('RegionI18n.Name', 'ASC')->find();
$arrayRegionOptions = assocToNumDef($pcDataO->toArray(), false);
if($arrayRegionOptions) { array_unshift($arrayRegionOptions, ['Sélectionner une région','all']); } else { $arrayRegionOptions[0] = ['Aucune région trouvé','all']; }

/*$city = VilleQuery::create();
if($request['IdProvince'] AND $request['IdProvince'] != 'all') { $city->filterByIdProvince($request['IdProvince']); }
$pcDataO = $city->join('VilleI18n')
		->select(array('VilleI18n.Name', 'IdVille'))
		->orderBy('VilleI18n.Name', 'ASC')->find();
$arrayCityOptions = assocToNumDef($pcDataO->toArray(), false);
array_unshift($arrayCityOptions, ['Sélectionner une ville','all']);*/

$output['SelectPays'] = select('pays',$arrayPaysOptions, "v='ID_PAYS' s='d' obli=1 val='' data-error='pays' class='progress required' data-next='province'",$request['IdPays']);
$output['SelectProvince'] = select('province',$arrayProvinceOptions, "v='ID_PROVINCE' s='d' obli=1 val='' class='progress required' data-error='province' data-next='region'",$request['IdProvince']);
$output['SelectRegion'] = select('region',$arrayRegionOptions, "v='ID_REGION' s='d' obli=1 val='' class='progress required' data-error='région' data-next='ville'",$request['IdRegion']);
//$output['SelectVille'] = select('ville',$arrayCityOptions, "v='ID_VILLE' s='d' obli=1 val='' class='progress required' data-error='ville' data-next='none'",$request['IdVille']);

