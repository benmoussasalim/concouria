<?php


            $bodyClass .= 'trigger-error';

            $siteTitle = _("Erreur 404 - Page non trouvée");
            if(_SITE_TITLE != '_SITE_TITLE') { $siteTitle .= ' | '._SITE_TITLE; }

            if(file_exists(_INSTALL_PATH.'css/img/logo-admin.png')) { $logoAdmin = _SITE_URL.'css/img/logo-admin.png'; }

            if($request['error'] AND $errorArray[$request['error']]) { $errorNotice = $errorArray[$request['error']]; } else { $errorNotice = _("Page non trouvée."); }

            $output['html'] =
            div(
                div(
                    img($logoAdmin,null,null,'',(_SITE_TITLE != '_SITE_TITLE') ? _SITE_TITLE : '')
                    .div(
                        div(
                            h1(_("Erreur 404"))
                            .p($errorNotice)
                        )
                    )
                    .href(_("Retourner à l'accueil"),_SITE_URL,'',true)
                    .href(_("Page précédente"),_SITE_URL,'class="go-back"',true)
                )
            ,'','class="page-404"');


            $output['onReadyJs'] .= "
                $('.page-404 a.go-back').click(function() {
                    window.history.go(-1);
                    return false;
                });
            ";
