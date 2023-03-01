<?php

	global $lang_sql;
	$lang_sql =$lang_sql =$_SESSION[_AUTH_VAR]->lang != 'fr_CA' && $_SESSION[_AUTH_VAR]->lang != 'en_US' ? ucfirst($_SESSION[_AUTH_VAR]->lang) == 'Fr' ? 'fr_CA' : 'en_US' : $_SESSION[_AUTH_VAR]->lang;

	function priceTranslate($price, $lang_sql = 'fr_CA') {
		$return = $price.' $ CAD';
		if ($lang_sql != 'fr_CA') {
			$return = 'CAD $ '.$price;
		}
		return $return;
	}
    
    $errorArray['account'] = _("Compte introuvable. Veuillez contacter un administrateur.");

	function checkCity($ville,$province,$lang_sql) {
		foreach($ville as $location) {
			if($location['types'][0] == 'locality') { $villeData = $location; }
			if($location['types'][0] == 'administrative_area_level_1') { $regionData = $location; }
		}

		if($villeData AND $regionData) {
			$region = RegionQuery::create()->filterByTitle($regionData['long_name'])->findOne();
			if(count($region) > 0) {
				$return['region'] = $region->getIdRegion();
			} else {
				$newRegion = new Region();

				$newRegionData['IdProvince'] = $province;
				$newRegionData['Title'] = $regionData['long_name'];

				$newRegion->fromArray($newRegionData);
				$newRegion->save();

				$return['region'] = $newRegion->getPrimaryKey();
				if($return['region']) {
					$regionLang = new RegionI18n();

					$regionLangData['IdRegion'] = $return['region'];
					$regionLangData['Locale'] = $lang_sql;
					$regionLangData['Name'] = $regionData['long_name'];

					$regionLang->fromArray($regionLangData);
					$regionLang->save();
				}
			}



			$city = VilleQuery::create()->filterByTitle($villeData['short_name'])->findOne();
			if(count($city) > 0) {
				$return['city'] = $city->getIdVille();
			} else {
				$newCity = new Ville();

				$newCityData['IdProvince'] = $province;
				$newCityData['IdRegion'] = $return['region'];
				$newCityData['Title'] = $villeData['short_name'];

				$newCity->fromArray($newCityData);
				$newCity->save();

				$key = $newCity->getPrimaryKey();
				if($key) {
					$cityLang = new VilleI18n();

					$cityLangData['IdVille'] = $key;
					$cityLangData['Locale'] = $lang_sql;
					$cityLangData['Name'] = $villeData['short_name'];

					$cityLang->fromArray($cityLangData);
					$cityLang->save();

					$return['city'] = $key;
				}
			}
		}

		return $return;
	}
    
    function swLabel() {
        return false;
    }