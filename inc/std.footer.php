<?php



if(file_exists(_BASE_DIR.'inc/std.footer.custom.php'))
    include _BASE_DIR.'inc/std.footer.custom.php';

 if($_SESSION[_AUTH_VAR]->get('connected') != 'YES'){
    $stdFooter['html'] =
        div(
            div(
                div(htmlSpace(1),'','class="separateur" style="height:30px;left:49.9%;position:absolute;border-left: 1px solid #56747f;" ')
                .div(
                    div(_('Tous droits réservés © 2016'),'',' style="margin-left:3px;color:#164b5d;font-size:0.875em;vertical-align:TOP;text-align:right;padding-top:10px;" ')
                ,'','class="left"')

                .div(
                    div(_('Propulsé par'),'','c style="color:#164b5d;font-size:0.875em;float:left;vertical-align:TOP;padding-top:10px;" ')
                    .img(_SRC_URL.'img/builder/progexpert_propulse.jpg',NULL,NULL,' style="float:right;margin:0px;" ')
                ,'','class="right"')
            ,'','class="ac-login-footer-wrapper"')
        , '', 'class="clearfix ac-login-footer" style="width:100%;margin-top:60px;" ');
}
