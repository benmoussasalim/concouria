<?php
$allStats = StatistiqueQuery::create()->filterByOnline('Oui')->orderByOrder()->find();
if($allStats) {
    foreach($allStats as $stats) {
        $statsContent .=
            div(
                h2($stats->getTranslation($lang_sql)->getName(),swEdit('Name'))
                .p($stats->getTranslation($lang_sql)->getText(),swEdit('Text'))
            , '',['class="stats-box"',swEdit('Statistique',$stats->getIdStatistique(),$stats->getTitle())])
        ;
    }
}

$htmlOutput =
        div(
            h1(_('Des statistiques'))
        , '', 'class="title"')
        .$statsContent;

?>