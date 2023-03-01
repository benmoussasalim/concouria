<?php

if($_SESSION[_AUTH_VAR]->get('group') == 'Admin') {
    $topNav[] = li(href(span(_("Importer des concours")),'javascript:','id="import-concours" class="icon book"'),'data-tooltip="'._("Importer des concours").'"');
    $topNav[] = li(href(span(_("Exporter CSV")),'javascript:','class="icon report export-csv"'),'data-tooltip="'._("Exporter CSV").'"');    
}

 