<?php


#@0.1@#########################
#	Progexpert
###############################

    if($request['ot'] != 's')
        $request = $_REQUEST;


    if(_BASE_DIR != '_BASE_DIR'){
        include 'inc/init.php';
    }else{
        include '../../inc/init.php';
    }

	switch($request['a']) {
		case 'importConcours':
			if (!empty($_FILES) || !$_FILES["file"]["error"]) {
				$path = pathinfo($_FILES["file"]["name"]);
				$name = 'concours';
				$ext = $path['extension'];

				$return['error'] = true;
				$return['message'] = 'Une erreur est survenue.';

				$file = _INSTALL_PATH.'mod/file/concours.'.$ext;

				if(file_exists(_INSTALL_PATH.'mod/file/concours.xlsx')) { unlink(_INSTALL_PATH.'mod/file/concours.xlsx'); }
				else if(file_exists(_INSTALL_PATH.'mod/file/concours.csv')) { unlink(_INSTALL_PATH.'mod/file/concours.xlsx'); }

				move_uploaded_file($_FILES["file"]["tmp_name"],$file);

				include _INSTALL_PATH.'mod/Classes/PHPExcel/IOFactory.php';

                if(false) { $file = _INSTALL_PATH.'mod/file/debug.xlsx'; }

				$objReader = PHPExcel_IOFactory::createReaderForFile($file);
				$objReader->setReadDataOnly(false);
				/** @var PHPExcel $objPHPExcel */
				$objPHPExcel = $objReader->load($file);

				foreach ($objPHPExcel->getWorksheetIterator() as $key => $worksheet) {
					if($key == 0) {
						$highestRow = $worksheet->getHighestRow();
						$highestColumn = $worksheet->getHighestColumn();
						$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

						for ($row = 2; $row <= $highestRow; $row++) {
                            $range = 'A'.$row.':E'.$row;

							$importConcours = array();
							$importConcoursLang = array();

							for ($col = 0; $col < $highestColumnIndex; $col++) {
								$cell = $worksheet->getCellByColumnAndRow($col, $row);
								$val = $cell->getValue();

								switch($col) {
									case 0:
										$importConcours['Title'] = $val;
										$importConcoursLang['Name'] = $val;
									break;

									case 1:
										$importConcours['Price'] = $val;
									break;

									case 2:
                                        if(PHPExcel_Shared_Date::isDateTime($cell)) {
                                            $importConcours['Date'] = date($format = "Y-m-d", strtotime('+1 day', PHPExcel_Shared_Date::ExcelToPHP($val)));
                                        } 
									break;

									case 3:
										$importConcoursLang['Text'] = $val;
									break;

									case 4:
										$importConcours['Url'] = $val;
									break;
								}
							}

							if(! $importConcours['Title'] or ! $importConcours['Price']){
								continue; //Skip empty rows
							}

							$concours = new Concours();
							$importConcours['Online'] = 'Oui';

							$concours->fromArray($importConcours);
							$concours->save();

							$primaryKey = $concours->getPrimaryKey();
							if($primaryKey) {
								$concoursLang = new ConcoursI18n();

								$importConcoursLang['IdConcours'] = $primaryKey;
								$importConcoursLang['Locale'] = 'fr_CA';

								$concoursLang->fromArray($importConcoursLang);
								$concoursLang->save();
							}
						}
						$return['error'] = false;
						$return['message'] = 'Importation terminée.';
					}
				}
			}else{
				$return = returnDefault("Erreur lors de l'envoi du fichier", true);
			}

			echo json_encode($return);
			die();
		break;

	}


    if(!$_SESSION[_AUTH_VAR]->isConnected()){
        security_redirect(true);
    }

    #@custom##############
    #		reset $request['a'] after new case


    $printJs = loadJs(_SRC_URL."js/jquery/jquery-1.7.1.min.js");
    $printCss = loadCss(_SITE_URL."css/print.css");


    include 'ConcoursActBase.php';

    if(file_exists(_BASE_DIR.'mod/act/actOuput.php'))
        include _BASE_DIR.'mod/act/actOuput.php';
    function eventHook($event, &$obj='', &$request, &$output){}

    function customDataFormat ($date, $format = 'Y-m-d'){
		$dateTime = new DateTime($date);
		return $dateTime->format($format);
	}
