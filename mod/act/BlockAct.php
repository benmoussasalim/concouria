<?php


#@0.1@#########################
#   ProgXform version 0.861
#   Propel version 1.6
#   Prgxpert, Frederic Vezina 2011
#   build_time: 2014-08-26 11:36:53
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
                BlockQuery::create()->filterByIdBlock($request['p'])->update(array('Status' => 1)); 
                $block = BlockQuery::create()->filterByIdBlock($request['p'])->findOne();
                if ($block->getType() == 'Contenu dynamique') {
                    if (!file_exists(_BASE_DIR.'mod/page/'.$block->getSlug().'.php')) {
                        $myfile = fopen(_BASE_DIR.'mod/page/'.$block->getSlug().'.php', "w") or die("Unable to open file!");
                        $fileBase = "<?php\r\n\r\n  \$htmlOutput = \"\";\r\n\r\n?>";
                        fwrite($myfile, $fileBase);
                        fclose($myfile);
                    }
                }
            }

            die();
        break;

        case 'desactivate':

            if(isset($_SESSION[_AUTH_VAR]) && $_SESSION[_AUTH_VAR]->get('isConnected') == 'YES'){
                BlockQuery::create()->filterByIdBlock($request['p'])->update(array('Status' => 2));
            }

            die();
        break;
    }
    
    #@custom##############
    #       reset $request['a'] after new case

    $printJs = loadJs(_SRC_URL."js/jquery/jquery-1.7.1.min.js");
    $printCss = loadCss(_SITE_URL."css/print.css");
    
    include 'BlockActBase.php';
        
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

        $obj->CcPrintLinkDiv.= htmlLink(_('Publier'), 'javascript:',"class='ac-button ac-light-red' id='publier' j='button' ");

        $obj->CcPrintLinkDiv.= htmlLink(_('Désactiver'), 'javascript:',"class='ac-button ac-light-red' id='desactivate' j='button' ");

        $contentBlocks = BlockQuery::create()
                        ->filterByType('Conteneur')
                        ->find();

        $obj->CcToFormJs .= "var arrayBlocks = [''";
            foreach ($contentBlocks as $contentBlock) {
                $obj->CcToFormJs .= ",'".$contentBlock->getIdBlock()."'";
            }
        $obj->CcToFormJs .= "];";
        
        $obj->CcToFormJs .= "
                if ($('#divCntBlock #Status').val() == 'Publié') {
                    $('#BlockPrintLinkDiv #publier').remove();
                }

                if ($('#divCntBlock #Status').val() == 'Désactivé' || $('#divCntBlock #Status').val() == 'Brouillon') {
                    $('#BlockPrintLinkDiv #desactivate').remove();
                }

                if ($('#divCntBlock #Type').val() != 'Contenu fixe') {
                    $('li[aria-controls=\"ogf_BlockI18n.Text.fr\"], li[aria-controls=\"ogf_BlockI18n.Text.en\"], #pannelBlock').hide();
                }
                else {
                    $('li[aria-controls=\"ogf_BlockI18n.Text.fr\"], li[aria-controls=\"ogf_BlockI18n.Text.en\"], #pannelBlock').show();
                }
                
                $('#divCntBlock #Type').change(function() {
                    if ($(this).val() != 'Contenu fixe') {
                        $('li[aria-controls=\"ogf_BlockI18n.Text.fr\"], #cntBlockChild').hide();
                        $('li[aria-controls=\"ogf_BlockI18n.Text.en\"]').hide();
                    }
                    else {
                        $('li[aria-controls=\"ogf_BlockI18n.Text.fr\"]').show();
                        $('li[aria-controls=\"ogf_BlockI18n.Text.en\"]').show();
                    }
                });

                $('#IdParent option').each(function() {
                    if (arrayBlocks.indexOf($(this).val()) < 0) {
                        $(this).remove();
                    }
                });

                setTimeout(function(){ 
                  $('.mce-tinymce.mce-container').css('width','90%');
                  $('.mceEditor').css('width','100%').css('minHeight','500px');
                  $('.mceLayout').css('width','100%').css('minHeight','500px');
                  $('.mceIframeContainer').css('width','100%').css('minHeight','500px');
                  $('#TextFr_ifr, #TextEn_ifr').css('width','100%').css('minHeight','500px');
                },700); 
                
               $('#tabsContain #publier').click(function(){
                    var IdBlock = $('#divCntBlock #idPk').val();
                    $.post('"._SITE_URL."mod/act/BlockAct.php', 
                        {
                            a:'publie', 
                            p:IdBlock
                        }, 
                        function(data){ 
                            if (data.length == 0) {
                                window.location = '"._SITE_URL."Block/edit/'+IdBlock;
                            }
                    });
                });

                $('#tabsContain #desactivate').click(function(){
                    $.post('"._SITE_URL."mod/act/BlockAct.php', 
                        {
                            a:'desactivate', 
                            p:$('#divCntBlock #idPk').val()
                        }, 
                        function(data){ 
                            if (data.length == 0) {
                                window.top.location.reload();
                            }
                    });
                });

                $('#divCntBlock #Type option[value=\"Contenu fixe\"]').attr('title', 'Un contenu html qui se retrouvera dans la page.');
                $('#divCntBlock #Type option[value=\"Contenu dynamique\"]').attr('title', 'Contenu qui sera généré à partir d\'un autre entité.');
                $('#divCntBlock #Type option[value=\"Slideshow\"]').attr('title', 'Slider d\'images.');
                $('#divCntBlock #Type option[value=\"Menu\"]').attr('title', 'Navigation du site.');
                $('#divCntBlock #Type option[value=\"Conteneur\"]').attr('title', 'Défini un espace où d\'autres blocks seront placé.');
                
                $('#divCntBlock #Type').parent().css('width', '200px').parent().append('<div class=\"description\" style=\"margin: 10px 0;\"></div>');
                
                $('#divCntBlock .divtr .description').html($('#divCntBlock #Type option:selected').attr('title'));

                $('#divCntBlock #Type').change(function () {
                    $('#divCntBlock .divtr .description').html($(this).find('option:selected').attr('title'));
                });
            ";
        if (!empty($data['i'])) {
            $obj->CcToFormJs .= "
                var typeVal = $('#divCntBlock #Type').val();
                $('#divCntBlock #Type').parent().append(typeVal);
                $('#divCntBlock #Type').hide();
            ";
        }
    }
    function beforeChildBlockFileList($q, $filterKey, $obj) {
        $obj->CcToBlockFileListJs .= "
            if ($('#divCntBlock #Type').val() != 'Contenu fixe') {

                $('#BlockFileTableCntnr').hide();
            }
            else {
                $('#BlockFileTableCntnr').show();
            }
        ";
    }