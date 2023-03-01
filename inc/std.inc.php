<?php
$realPath = dirname(__file__);
require_once $realPath.'/config.php';
require_once $realPath.'/database_fct.php';
require_once $realPath.'/global_html.php';
require_once $realPath.'/config.db.php';
//require_once $realPath.'/../mod/inc/imageResize.php';




global $gAuthyForm;

$adminCss = loadCss(_SITE_URL.'css/custom.css')
            //  .loadCss(_SITE_URL.'css/admin.css')
              .loadCss(_SITE_URL.'js/selectBox/css/selectBox.css');

$adminJs =   loadJs(_SRC_URL."js/date/date_format_fr.js")
               // .loadJs(_SITE_URL."js/ZeroClipboard.min.js")
            .loadJs(_SRC_URL."js/jquery/datepicker/jquery.ui.datepicker-fr.js")
            .loadJs(_SITE_URL.'js/putCursorAtEnd.js')
            .loadJs(_SITE_URL.'js/func.js')
            .loadJs(_SITE_URL.'js/index.js')
            .loadJs(_SITE_URL.'js/admin.js')
				
			.loadJs(_SRC_URL.'js/plupload/plupload.full.min.js')
			.loadJs(_SRC_URL.'js/plupload/plupload.dev.js')
			.loadJs(_SRC_URL.'js/plupload/jquery.plupload.queue/jquery.plupload.queue.min.js')
			.loadJs(_SRC_URL.'js/plupload/moxie.js')
             .loadJs(_SITE_URL.'js/selectBox/selectbox.js');

$headJs .=
  loadJs(_SRC_URL."js/jquery/jquery-3.5.0.min.js",false,false)
  .loadJs(_SRC_URL."js/jquery/ui-1.12.1/jquery-ui.min.js",false,false)
;
$jscript .= 	
            loadJs(_SRC_URL."js/lib/jquery.md5.js")
            .loadJs(_SITE_URL."js/common.js")
            .loadJs(_SITE_URL."js/jquery.fileDownload.js");
