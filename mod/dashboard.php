<?php

###############################
#	Progexpert
###############################

$bodyClass .= ' dashboard ';

$_SESSION['dashboard']['dashboard']  = 'website';

if($_POST['a'] == 'getDashboard') {
    include_once '../inc/init.php'; 
    $request = $_POST;

    $_SESSION['dashboard']['dashboard'] = $request['dashboard'];
    $_SESSION['dashboard']['range'] = $request['range'];

}
$hosting="";


$headJs .=
    loadJS(_SRC_URL.'js/jqplot/jquery.jqplot.min.js')
    .loadJS(_SRC_URL.'js/jqplot/plugins/jqplot.dateAxisRenderer.js')
    .loadJS(_SRC_URL.'js/jqplot/plugins/jqplot.highlighter.js')
    .loadCSS(_SRC_URL.'js/jqplot/jquery.jqplot.min.css');

if(!$request['dashboard'] AND !$_SESSION['dashboard']['dashboard']) { $_SESSION['dashboard']['dashboard'] = 'website'; }
if(!$request['range'] AND !$_SESSION['dashboard']['range']) { $_SESSION['dashboard']['range'] = '-1 month'; }

$rangeData['-1 week']['label'] = 'Dernière semaine';
$rangeData['-1 week']['analytic'] = '7';
$rangeData['-1 week']['box'] = 'de la dernière semaine';
$rangeData['-1 week']['tick'] = '1 days';
$rangeData['-1 week']['format'] = '%e %b';
$rangeData['-1 week']['class'] = 'week';

$rangeData['-1 month']['label'] = 'Dernier mois';
$rangeData['-1 month']['analytic'] = '30';
$rangeData['-1 month']['box'] = 'du dernier mois';
$rangeData['-1 month']['tick'] = '5 days';
$rangeData['-1 month']['format'] = '%e %b';
$rangeData['-1 month']['class'] = 'month';

$rangeData['-1 year']['label'] = 'Dernière année';
$rangeData['-1 year']['analytic'] = '365';
$rangeData['-1 year']['box'] = 'de la dernière année';
$rangeData['-1 year']['tick'] = '1 month';
$rangeData['-1 year']['format'] = '%b';
$rangeData['-1 year']['class'] = 'year';

$currentDashboard[ $_SESSION['dashboard']['dashboard']] = 'current';
if(count($rangeData)>0){
    foreach($rangeData as $key => $label) {
        $current = '';
        if($key ==  $_SESSION['dashboard']['range']) { $current = 'current'; }
        $listRange .= li(href($label['label'],'#','class="'.$current.'" data-range="'.$key.'"')); 
    }
}

$swHeader =
    div(
        href(span(_("Ouvrir/Fermer le menu")),'javascript:','class="toggle-menu trigger-menu"')
        
    ,'','class="sw-header"');

$return['first_day'] = date('Y-m-d H:i:s',strtotime( $_SESSION['dashboard']['range']));
$return['last_day'] = date('Y-m-d H:i:s');

if( $_SESSION['dashboard']['dashboard'] == 'sales') {
    
}else{
    $return['highlighter'] = 'visite(s)';
    if(is_file('/opt/google-api-php-client-master/vendor/autoload.php')){
        require_once '/opt/google-api-php-client-master/vendor/autoload.php';
    
        $activeUser = 0;
        $analytics = initializeAnalytics();
        if($analytics){
            $profile = getFirstProfileId($analytics);

            if($profile !== false) {
                $results = getResults($analytics, $profile,$rangeData[$_SESSION['dashboard']['range']]['analytic']);
                $contentAnalytics = printResults($results,$rangeData[$_SESSION['dashboard']['range']]['box']);

                $resultsLive = $analytics->data_realtime->get(
                    'ga:'.$profile,
                    'rt:activeUsers',
                    array('dimensions' => 'rt:medium')
                );

                if(count($resultsLive->getRows()) > 0) {
                    foreach($resultsLive->getRows() as $row) {
                        foreach($row as $cell) {
                            if($cell != '(none)') {
                                $activeUser = $cell;
                            }
                        }
                    }
                }
            } else { $contentAnalytics['content'] = p(_("Compte non associé.")); }

            $output['html'] =
            $swHeader
            .$hosting
            .h2(_("Statistiques du traffic"),'class="'.$_SESSION['dashboard']['dashboard'].'"')
            .div(p(
                span($activeUser).' '
                .span(_("utilisateur").($activeUser > 1 ? 's' : '')." en ligne")
            ,'class="amount-'.$activeUser.'"'),'','class="active-users"')
            .div(
                p(span($rangeData[ $_SESSION['dashboard']['range']]['label']))
                .ul($listRange)
            ,'','class="range-select"')

            .div($contentAnalytics['content'],'','class="tab-stats"')

            .h2(_("Visites").htmlSpace(1).$rangeData[$_SESSION['dashboard']['range']]['box'])
            .div('','analytics-chart','class="'.$rangeData[$_SESSION['dashboard']['range']]['class'].'"');
        }
    }

    /*.div(
        p(_("Pour voir plus de statistiques"))
        .href(_("Google Analytics"),'https://www.google.com/analytics/','target="_blank"')
    ,'','class="analytics-link"')*/
}

$return['first_day'] = date('Y-m-d',strtotime($return['first_day']));
$return['last_day'] = date('Y-m-d',strtotime($return['last_day']));

/* DÉCLARATION DES VARIABLES */
$output['js'] .= "
    var fill_color = 'rgba(138,197,63,0.5)',
    text_color = '#8ac53f',
    first_day = '".$return['first_day']."',
    last_day = '".$return['last_day']."',
    highlighter_data = '".$return['highlighter']."',
    tick_interval = '".$rangeData[$_SESSION['dashboard']['range']]['tick']."',
    tick_format = '".$rangeData[$_SESSION['dashboard']['range']]['format']."';
";

if($contentAnalytics['visit']) {
    $output['onReadyJs'] .= "
        var graph_content = [".rtrim($contentAnalytics['visit'],',')."];
        initGraph(graph_content);
    ";
}

$output['js'] .= "
    var plot;

    function initGraph(graph_content) {
        var highlight_tooltip = highlighter_data;
        var highlight_axis = highlighter_data;
        var split_format = tick_format.split(' ');
        first_day = graph_content[0][0],
        last_day = graph_content[graph_content.length-1][0];

        if(highlight_axis == 'visite(s)') { highlight_axis = ''; }

        if($(window).width() <= 768) { split_format[1] = ''; }
        if(!split_format[1]) { split_format[1] = ''; }    

        plot = $.jqplot('analytics-chart',[graph_content], {
            highlighter: { 
                show: true,
                sizeAdjust: 2,
                tooltipAxes: 'y',
                tooltipFormatString: '%.5P ' + highlight_tooltip,
                useAxesFormatters: false
            },
            grid: {
                background: '#FFF',
                drawBorder: false,
                shadow: false,
                gridLineColor: '#CCC',
                gridLineWidth: 1
            },
            seriesDefaults: {
                rendererOptions: {
                    animation: {
                        show: true,
                        speed: 750
                    }
                }
            },
            series: [
                {
                    color: '#000',
                    fill: true,
                    fillAndStroke: true,
                    fillColor: fill_color
                }
            ],
            axes:{
                xaxis:{
                    renderer: $.jqplot.DateAxisRenderer,
                     tickOptions: {
                        formatString: tick_format,
                        textColor: '#FFF',
                        fontSize: '14px'
                    },
                    tickInterval: tick_interval,
                    min: first_day,
                    max: last_day,
                    drawMajorGridlines: true
                },
                yaxis: {
                    tickOptions: {
                        formatString: '%\'d ' + highlight_axis,
                        showMark: false,
                        textColor: text_color,
                        fontSize: '14px'
                    }
                }
            }
        });
    }
";

$output['js'] .= "
    var header_width = 0, default_controls = 0;
";

if($_POST['a'] == 'getDashboard') {
    $return['content'] = $output['html'];
    $return['graph'] = "[".rtrim($contentAnalytics['visit'],',')."]";
    $return['tick'] = $rangeData[$_SESSION['dashboard']['range']]['tick'];
    $return['format'] = $rangeData[$_SESSION['dashboard']['range']]['format'];
    echo json_encode($return);
    die();
}

$output['onReadyJs'] .= "
    $('.dashboard-wrapper').on('click','.custom-controls button[data-dashboard], .range-select a[data-range]',function() {
        if($(this).data('dashboard')) { $('.custom-controls button').removeClass('current'); } 
        else if($(this).data('range')) { $('.range-select a[data-range]').removeClass('current'); }
        $(this).addClass('current');

        $('.custom-controls').removeClass('toggle-sw-options');
        $('#loadingDialog').dialog('open');

        $.post(_SITE_URL + 'mod/dashboard.php'
            ,{ a:'getDashboard', dashboard: $('button[data-dashboard].current').data('dashboard')
            , range: $('.range-select a[data-range].current').data('range') },function(data) {
                $('.dashboard-wrapper').html(data.content);
                $('#loadingDialog').dialog('close');


                tick_interval = data.tick;
                tick_format = data.format;
                highlighter_data = data.highlighter;

                initGraph(JSON.parse(data.graph.replace(/'/g , '\"')));

                $(window).resize();
        },'json');

        return false;
    });
";

function getResults($analytics, $profileId,$range) {
    return $analytics->data_ga->get(
        'ga:'.$profileId,
        $range.'daysAgo',
        'today',
        'ga:sessions,ga:avgSessionDuration', //,ga:deviceCategory 'ga:date'
        array('dimensions' => 'ga:date','samplingLevel' => 'HIGHER_PRECISION')
    );
}

function printResults($results,$boxText) {
    if (count($results->getRows()) > 0) {
        $content = '';
        $profileName = $results->getProfileInfo()->getProfileName();

        $totalSessions = 0;
        $totalAvgTime = 0;
        $totalDay = 0;
        $totalDay = 0;

        $rows = $results->getRows();
        if(count($rows)){
            foreach($rows as $data) {
                $date = date('Y-m-d',strtotime($data[0]));

                $sessions = $data[1];
                $averageTime = $data[2];
                $totalSessions += $sessions;

                if($averageTime > 0) {
                    $totalAvgTime += $averageTime;
                    $totalDay++;
                }

                $return['visit'] .= "['".$date."',".$sessions."],";
            }
        }

        $secondAvgTime = ($totalAvgTime / $totalDay) / 60;
        $secondAvgTime = explode('.',$secondAvgTime);
        $secondAvgTime[1] = substr(ceil($secondAvgTime[1] * 60 / 100),0,2);

        $return['content'] .=
        div(
            h3(_("Nombre de visites").htmlSpace(1).$boxText)
            .p($totalSessions.'<sup>vis.</sup>')
        ,'','class="stat-wrapper"');

        $seconds = floor($secondAvgTime[1] / 60);

        $secondAvgTime[0] += $seconds;
        $secondAvgTime[1] -= $seconds * 60;

        $return['content'] .=
        div(
            h3(_("Durée moyenne des visites"))
            .p(sprintf('%02d',$secondAvgTime[0]).':'.sprintf('%02d',$secondAvgTime[1]).'<sup>min.</sup>')
        ,'','class="stat-wrapper"');
    } else {
        $return['content'] = p(_('Aucune données trouvées.'));
    }
    return $return;
}

function initializeAnalytics() {
    $KEY_FILE_LOCATION = _INSTALL_PATH.'/mod/dashboard/service-account-credentials.json';
    if(file_exists($KEY_FILE_LOCATION)){
        $client = new Google_Client();
        $client->setApplicationName(_PROJECT_NAME);
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new Google_Service_Analytics($client);
    }
    return $analytics;
}

function getFirstProfileId($analytics) {
    try { $accounts = $analytics->management_accounts->listManagementAccounts(); }
    catch (Exception $e) { return false; }

    if (count($accounts->getItems()) > 0) {
      $items = $accounts->getItems();
      $firstAccountId = $items[0]->getId();

      $properties = $analytics->management_webproperties->listManagementWebproperties($firstAccountId);

      if (count($properties->getItems()) > 0) {
          $items = $properties->getItems();
          $firstPropertyId = $items[0]->getId();

          $profiles = $analytics->management_profiles->listManagementProfiles($firstAccountId, $firstPropertyId);

          if (count($profiles->getItems()) > 0) {

              $items = $profiles->getItems();
              return $items[0]->getId();

          } else { throw new Exception(_('No views (profiles) found for this user.')); }
      } else { throw new Exception(_('No properties found for this user.')); }
  } else { throw new Exception(_('No accounts found for this user.')); }
}
