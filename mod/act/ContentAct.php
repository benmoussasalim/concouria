<?php


#@0.1@#########################
#   ProgXform version 0.861
#   Propel version 1.6
#   Prgxpert, Frederic Vezina 2011
#   build_time: 2014-08-26 12:06:21
###############################

    if($request['ot'] != 's')
        $request = $_REQUEST;


    if(_BASE_DIR != '_BASE_DIR'){
        include 'inc/init.php';
    }else{
        include '../../inc/init.php';
    }

    switch($request['a']) {
        case 'publie':
            if(isset($_SESSION[_AUTH_VAR]) && $_SESSION[_AUTH_VAR]->get('isConnected') == 'YES'){
                ContentQuery::create()->filterByIdContent($request['p'])->update(array('Status' => 1));
                $content = ContentQuery::create()->filterByIdContent($request['p'])->findOne();
                if ($content->getType() == 'Contenu dynamique') {
                    if (!file_exists(_BASE_DIR.'mod/page/'.$content->getSlug().'.php')) {
                        $myfile = fopen(_BASE_DIR.'mod/page/'.$content->getSlug().'.php', "w") or die("Unable to open file!");
                        $fileBase = "<?php\r\n\r\n  \$htmlOutput = \"\";\r\n\r\n?>";
                        fwrite($myfile, $fileBase);
                        fclose($myfile);
                    }
                }
            }

            die();
        break;
        case 'slug':
            if(isset($_SESSION[_AUTH_VAR]) && $_SESSION[_AUTH_VAR]->get('isConnected') == 'YES'){
                ContentQuery::create()->filterByIdContent($request['p'])->update(array('Slug' => slugify($request['slug'])));
            }

            die();
        break;
        case 'return':

            if(isset($_SESSION[_AUTH_VAR]) && $_SESSION[_AUTH_VAR]->get('isConnected') == 'YES'){
                $currentContent = ContentQuery::create()->filterByIdContent($request['p'])->findOne();

                ContentQuery::create()->filterByIdContent($request['p'])->update(array('IdParent' => NULL, 'Status' => 1));

                ContentQuery::create()->filterByIdContent($currentContent->getIdParent())->update(array('IdParent' => $request['p'], 'Status' => 2));

                ContentQuery::create()->filterByIdParent($currentContent->getIdParent())->update(array('IdParent' => $request['p']));

            }

            die();
        break;

        case 'desactivate':

            if(isset($_SESSION[_AUTH_VAR]) && $_SESSION[_AUTH_VAR]->get('isConnected') == 'YES'){
                ContentQuery::create()->filterByIdContent($request['p'])->update(array('Status' => 2));
            }

            die();
        break;


    }

    #@custom##############
    #       reset $request['a'] after new case

    $printJs = loadJs(_SRC_URL."js/jquery/jquery-1.7.1.min.js");
    $printCss = loadCss(_SITE_URL."css/print.css");

    include 'ContentRelatedAct.php';
    include 'ContentActBase.php';

    if(file_exists(_BASE_DIR.'mod/act/actOuput.php'))
        include _BASE_DIR.'mod/act/actOuput.php';


    function beforeSave(&$obj, &$data, $isNew, &$output){
        if (empty($data['Status']) || !isset($data['Status'])) {
            $data['Status'] = 'Brouillon';
        }
    }

    function beforeForm(&$obj, &$data, &$output, &$dataset){
        /*  CcToFormRoBottom, CcToFormRoTop, CcToChildTableRoTop, CcToFormTop, CcToFormBottom, CcToFormJs, CcTo[childTableName]ListTop, CcTo[childTableName]ListBottom
        $obj->CcToChildTableRoBottom
        */
        if (empty($dataset['Status']))
            $dataset['Status'] = "Brouillon";

		if(isset($data["i"])) {
			$urlQ = ContentQuery::create()->filterByStatus('Publié')->filterByIdContent($data["i"])->findOne();
			if($urlQ) { $url = htmlLink(_('Visualiser le contenu'), _SITE_URL.$urlQ->getSlug(),"class='ac-button ac-light-red' target='_blank' "); }
		}


        $obj->CcPrintLinkDiv.=
            htmlLink(_('Publier'), 'javascript:',"class='ac-button ac-light-red' id='publier' j='button' ")
            .' '
            .htmlLink(_('Désactiver'), 'javascript:',"class='ac-button ac-light-red' id='desactivate' j='button'")
            .' '
            .htmlLink(_('Recréer le lien'), 'javascript:',"class='ac-button ac-light-red' id='slug' j='button' ")
			.' '
            .$url;


        $obj->CcToFormJs .= "

            if ($('#cntContentdiv #Status').val() == 'Publié') {
                $('#ContentPrintLinkDiv #publier').remove();
            }

            if ($('#cntContentdiv #Status').val() == 'Désactivé' || $('#cntContentdiv #Status').val() == 'Brouillon') {
                $('#ContentPrintLinkDiv #desactivate').remove();
            }

            if ($('#cntContentdiv #Type').val() != 'Contenu fixe') {
                $('div[in=\"inContentI18n.Text.fr\"], div[in=\"inContentI18n.Text.en\"]').parent().hide();
                /*$('#pannelContent').hide();*/
            }
            else {
                $('div[in=\"inContentI18n.Text.fr\"], div[in=\"inContentI18n.Text.en\"]').parent().show();
                $('#pannelContent').show();
            }

            $('#cntContentdiv #Type').change(function() {
                if ($(this).val() != 'Contenu fixe') {
                    $('div[in=\"inContentI18n.Text.fr\"]').parent().hide();
                    $('div[in=\"inContentI18n.Text.en\"]').parent().hide();
                }
                else {
                    $('div[in=\"inContentI18n.Text.fr\"]').parent().show();
                    $('div[in=\"inContentI18n.Text.en\"]').parent().show();
                }
            });

            setTimeout(function(){
              $('.mce-tinymce.mce-container').css('width','90%');
              $('.mceEditor').css('width','100%').css('minHeight','500px');
              $('.mceLayout').css('width','100%').css('minHeight','500px');
              $('.mceIframeContainer').css('width','100%').css('minHeight','500px');
              $('#TextFr_ifr, #TextEn_ifr').css('width','100%').css('minHeight','500px');
            },700);

            $('.dPrintLink #publier').click(function(){
                var IdContent = $('#cntContentdiv #idPk').val();
                $.post('"._SITE_URL."mod/act/ContentAct.php',
                    {
                        a:'publie',
                        p:IdContent
                    },
                    function(data){
                        if (data.length == 0) {
                                window.location = '"._SITE_URL."Content/edit/'+IdContent;
                        }
                    }
                );
            });

            $('.dPrintLink #slug').click(function(){
                var IdContent = $('#cntContentdiv #idPk').val(), NameMenu = $('#cntContentdiv #NameMenu').val();
                $.post('"._SITE_URL."mod/act/ContentAct.php',
                    {
                        a:'slug',
                        p:IdContent,
                        slug:NameMenu
                    },
                    function(data){
                        if (data.length == 0) {
                                window.location = '"._SITE_URL."Content/edit/'+IdContent;
                        }
                    }
                );
            });

            $('.dPrintLink #desactivate').click(function(){
                $.post('"._SITE_URL."mod/act/ContentAct.php',
                    {
                        a:'desactivate',
                        p:$('#cntContentdiv #idPk').val()
                    },
                    function(data){
                        if (data.length == 0) {
                            window.top.location.reload();
                        }
                    }
                );
            });
        ";
        if (!empty($data['i'])) {
            $obj->CcToFormJs .= "
                var typeVal = $('#cntContentdiv #Type').val();
                $('#cntContentdiv #Type').parent().append(typeVal);
                $('#cntContentdiv [in=\"inType\"] .select-label, #cntContentdiv #Type').hide();
            ";
        }
    }

    function beforeChildContentDocList($q, $filterKey, $obj) {


    }

    function beforeChildContentFileList($q, $filterKey, $obj) {

       /* $obj->cCmoreColsHeaderContentFile = th('');
        $obj->cCmoreColsContentFile = td("<input type=button value=\""._('Copier le lien')."\" data-clipboard-text=\""._SITE_URL."%Fichier%\" title=\"Click to copy me.\" i=\"%IdContentFile%\"  j=\"copy_link\" f=button >");

        $obj->CcToContentFileListJs .= "
            $('#formContentFile [f=button]').button();

            if ($('#cntContentdiv #Type').val() != 'Contenu fixe') {
                $('#ContentFileTableCntnr').hide();
            }
            else {
                $('#ContentFileTableCntnr').show();
            }
        ";*/
    }