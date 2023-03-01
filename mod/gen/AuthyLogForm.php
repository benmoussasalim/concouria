<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'AuthyLog' table.
 *
 */
class AuthyLogForm extends AuthyLog{
public $tableName="AuthyLog";
public $CcToFormBottom;
public $CcToFormTop;
public $CcEvalToForm;
public $CcToFormJs;
public $CcToFormEndJs;
public $forceInlineEdit;
public $forcePopUpEdit;

public $arrayData;
public $CcToListTop;
public $CcToListBottom;
public $CcToListJs;
public $CcEvalToList;

public $CcToFormRoTop;
public $CcToFormRoBottom;
public $CcCustomControl;
public $CcToChildTableRoTop;
public $CcToChildTableRoBottom;
public $CcToPageBottom;
public $CcEvalToFormRo;
public $cCajaxPageAct;
public $ajaxPageAct;
public $CcButtonName;
public $cCajaxPageActParent;
public $ajaxPageActParent;
public $CcToSearchMsPost;
public $CcToSearchMsForm;
public $CcToSearchList;
public $searchAr;
public $searchMs;
public $searchOrder;
public $searchOrderParse;
public $pmpoData;
public $siteTitle;

    #@############	##############
    #	produce a list of table items
    #	@param	string $uiTabsId	html destination container Id
    #	@param	string $page		nbr. of line per pages
    #	@param	string $IdParent	Parent id (if necessary)
    #	@param	obj $pmpoData		PropelModelPager reference to show instead of default search
    #									OR a standard propel collection
    #	@param	array $search		search params for custom search query
    #						[ms]	pre set with progXform/search_items behavior
    #					custom search
    #						[f]	filter	[v]	value	use by progXform/child_menu_query
    #						[u]	use		[f]	filter	[uv] use filter value
    #	@return
    ##############	##############
    public function getListSearch($IdParent='', $search=''){
        $maxPerPage = _paging_nbr_per_page;
        $q = AuthyLogQuery::create();
        if($this->CcToSearchList){ getSelectFilter($this->CcToSearchList,$q);}
        if(is_array($this->searchAr)){
            array_walk_recursive ($this->searchAr, function (&$v){$v=trim($v);});
            ## query sub-Menu
            if(@$this->searchAr['v'] && !$this->searchAr['uv']){
                $filterStr = "filterBy".$this->searchAr['f'];
                $q
                    ->$filterStr($this->searchAr['v']);
                    
                    
            }elseif(@$this->searchAr['u'] && $this->searchAr['uv']){
                $useStr = "use".$this->searchAr['u']."Query";
                $filterStr = "filterBy".$this->searchAr['f'];
                $q->$useStr()->$filterStr($this->searchAr['uv'])->endUse()
                    ;
            }else{
                $q;
            }
        }else{
            if(is_array($this->searchMs )){
                array_walk_recursive($this->searchMs, function (&$v){$v=trim($v);});
                $q;
            }else{
                
                $hasParent = json_decode($IdParent);
                if(empty($hasParent)){
                    $q;
                }
            }
        }
        
        if(!empty($this->searchOrder)){
            $f=0;
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $tOrdJoin = explode('>',$col);
                    $col = str_replace('>','.',$col);
                    $tOrd = explode('.',$col);
                    if(!empty($tOrd[1])){
                        if(!empty($tOrdJoin[1])){
                            $q->join($tOrd[0]);
                        }else{
                            $q->join($tOrd[0]." order".$f);
                        }                            
                        $orderBy = "use".$tOrd[0]."Query";
                        $q->$orderBy("order".$f,'left join')->orderBy($tOrd[1],$sens)->endUse();
                    }else{
                        if($this->searchOrderParse and $this->searchOrderParse[$col] ==1){
                            $q->withColumn('CAST('.$col.' AS UNSIGNED)',$col.'Cast');
                            $q->orderBy($col.'Cast',$sens);
                        }else{
                            $q->orderBy($col,$sens);
                        }
                        
                    }
                }$f++;
            }
        }
        
        
        
        $this->pmpoData =  $q;
        //echo $q->toString();
        //$q->paginate($page, $maxPerPage);
        return $this->pmpoData;
    }
    public function getListHeader($act){
        switch($act){
            case 'head':
            ###### TH
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Date"), " th='sorted'  rcColone='Timestamp' c='Timestamp'  ").th(_("Nom d'usager"), " th='sorted'  rcColone='Login' c='Login'  ").th(_("Ip"), " th='sorted'  rcColone='Ip' c='Ip'  ").th(_("Compte"), " th='sorted'  rcColone='Count' c='Count'  "). $this->cCmoreColsHeader;
                if(empty($this->search['Autoc']['SelList']) and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                    $trHead .= th('&nbsp;',' class="actionrow delete" ');
                }
                $trHead = thead(tr($trHead));/*semble plus utilisé.$trHeadMod*/
                return $trHead;
            break;
            case 'list-button':
                $listButton = '';
                
                
                return $listButton;
            break;
            case 'search':
                ###### SEARCH
                $array_search_tb = array();
                
                
                
                 
                $trSearch = '';
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('AuthyLog', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."AuthyLog/edit/", "id='addAuthyLog' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addAuthyLogAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
                }
            }else{
                $add_button = '';
            }

            $trAdd = @$this->head['AddButton']['Start'].$add_button.@$this->head['AddButton']['End'];
            return $trAdd;
            break;
            /*case 'quickadd': return $trHeadMod; break; semble plus utilisé*/
        }
    }
    
    public function getList( $uiTabsId= "tabsContain", $page='1', $IdParent='', $pmpoDataIn='', $search=''){
        if($page == ""){ $page = 1; }
        
        $this->siteTitle .=_("Liste Usagers Log");
        if(is_array($search)) $this->search = $search;
        
        $variableAutoc ="";
        if(isset($this->search['Autoc'])){
            $variableAutoc = preg_replace("/\s+/", " ",trim("  
                ,Autoc :{
                    SelActAfter:'".$this->search['Autoc']['SelActAfter']."'
                    ,SelActBefore:'".$this->search['Autoc']['SelActBefore']."'
                    ,SelList:'".$this->search['Autoc']['SelList']."'
                    ,IdTemp:'".$this->search['Autoc']['IdTemp']."'
                    ,SelIdAuto:'".$this->search['Autoc']['SelIdAuto']."'
                    ,SelParent:'".$this->search['Autoc']['SelParent']."'
                    ,SelId:'".$this->search['Autoc']['SelId']."'
                    ,SelEnt:'".$this->search['Autoc']['SelEnt']."'
                    ,SelRel:'".$this->search['Autoc']['SelRel']."'
                }
            "));
        }
    
        $this->IdParent = $IdParent;
        if(!empty($_SESSION['memoire']['onglet']['AuthyLog']['pg'])){
            $page = $_SESSION['memoire']['onglet']['AuthyLog']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'AuthyLogAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'AuthyLogAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#AuthyLogListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#AuthyLogListForm [th='sorted'][c='".$col."']\").attr('order','on');
                    ";
                }
            }
        }
        if(empty($search['ms'])){$this->searchAr = $search;}else{$this->searchMs = $search['ms'];}
        
        
        
        
        $maxPerPage = _paging_nbr_per_page;
        if(empty($pmpoDataIn)){
            try {
                $pmpoData = $this->getListSearch($IdParent, $search);
                $pmpoData = $pmpoData->paginate($page, $maxPerPage);
                $resultsCount = $pmpoData->getNbResults();
            } catch (Exception $e) { /* echo 'Exception reçue : ',  $e->getMessage(), "<br>";*/ }
        }else{$pmpoData = $pmpoDataIn;}
        $trHead = $this->getListHeader('head');
        if(empty($pmpoData) || !method_exists($pmpoData,'isEmpty')){
            @$tr .= tr(	td(p(span(_("Une erreur est survenue veuillez vider votre recherche.")."<br>".$e->getMessage()),'class="no-results"'), "t='empty' colspan='100%' "));
        }else if($pmpoData->isEmpty()){
            @$tr .= tr(	td(p(span(_("Aucun enregistrement pour le moment")),'class="no-results"'), "t='empty' colspan='100%' "));
        }else{
            if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){ $pcData = $pmpoData->getResults();}else{$pcData = $pmpoData;}
            
            $i=0;
            
            /**Main list loop**/
            foreach($pcData as $data){
                
                
                $this->ListActionRow = '';
                
            if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
            
                $CheckAction = "";
                if(!$_SESSION[_AUTH_VAR]->hasRights('AuthyLog', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('AuthyLog', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('AuthyLog', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteAuthyLog' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
                
                
                
                 $titreRaccour =''; $titreRaccour .= _('Usagers Log');
                if($this->ListActionRow){
                    $addClass='';
                    $cnt = substr_count($this->ListActionRow,'<a');
                    if($cnt){ $addClass=' actionrow'.$cnt; }
                    $this->ListActionRow = td($this->ListActionRow, " class='actionrow ".$addClass."' ");
                }
                if(isset($this->setReadOnly) and $this->setReadOnly=='all'){ $this->ListActionRow ="";}
                
                 
                $edit_columns_filter ="1";

                    
                /*
                    Commentaire ancienne version des attribut dans le tr rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$pcData->getPosition()."'
                */
                
                @$tr .= 
                tr(
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['Timestamp']) and $altValue['Timestamp'])?$altValue['Timestamp']:$data->getTimestamp()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Date").":\" j='editAuthyLog'  i='".json_encode($data->getPrimaryKey())."' c='Timestamp'  ")
                            .td(span(strip_tags((isset($altValue['Login']) and $altValue['Login'])?$altValue['Login']:$data->getLogin()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Nom d'usager").":\" j='editAuthyLog'  i='".json_encode($data->getPrimaryKey())."' c='Login'  ")
                            .td(span(strip_tags((isset($altValue['Ip']) and $altValue['Ip'])?$altValue['Ip']:$data->getIp()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Ip").":\" j='editAuthyLog'  i='".json_encode($data->getPrimaryKey())."' c='Ip'  ")
                            .td(span(strip_tags((isset($altValue['Count']) and $altValue['Count'])?$altValue['Count']:$data->getCount()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Compte").":\" j='editAuthyLog'  i='".json_encode($data->getPrimaryKey())."' c='Count'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='AuthyLogRow".$data->getPrimaryKey()."'
                    data-table='AuthyLog' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountAuthyLog', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Usagers Log';

            if($pmpoData->haveToPaginate()){
                $pages = $pmpoData->getLinks();
                if(!$page or !is_numeric($page)){$page=1;}
                
                if($page > $pmpoData->getLastPage()) { $page = $pmpoData->getLastPage(); }

                $pagerRow =
                    div(
                        button(span(_('Retourner en haut')),"class='scroll-top button-link-blue'")
                        .div(
                            p(span(_paging_nbr_per_page).' '._('par page').' - '.span($resultsCount).' '._('Résultat(s)').' ')
                            .div(
                                href(span(_('Précédent')),'#',"class='prev' data-direction='prev'")
                                .input('text','page',$page,'data-total="'.$pmpoData->getLastPage().'"')
                                .p('/ '.$pmpoData->getLastPage())
                                .href(span(_('Suivant')),'#',"class='next' data-direction='next'")
                            ,'','id="AuthyLogPagination"')
                        ,'',"class='pagination-wrapper' ")
                    ,'cntPagerRow',"class='navigation-wrapper has-pagination'");
            } else {
                $pagerRow =
                div(
                    button(span(_('Retourner en haut')),"class='scroll-top button-link-blue'")
                    .div(
                        p(span($resultsCount).' '._('résultat(s)').' ')
                    ,'',"class='pagination-wrapper'")
                ,'cntPagerRow',"class='navigation-wrapper'");
            }
        }
        $botoomRow ='';
        if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
            $return['pagerRow'] = $pagerRow;
        }else{
            $bottomRow = div($pagerRow,'bottomPagerRow', "class='tablesorter'");
        }

        if(!empty($this->CcEvalToList)){eval($this->CcEvalToList);}
        
        
            

        $controlsContent = $this->getListHeader('list-button');
        
        

        if($controlsContent) { $hasControls = 'has-controls'; }
        
        $return['html'] =
            $this->CcToListTop
            .div(
                div(
                    href(span(_('Ouvrir/Fermer le menu')),'javascript:','class="toggle-menu button-link-blue trigger-menu"')
                    
                    .$this->getListHeader('add')
                ,'','class="default-controls"')
                .div($controlsContent.$this->CcCustomControl,'AuthyLogControlsList', "class='custom-controls ".@$hasControls."'")
                .button(span(_("Afficher le menu")),'class="btn-custom-controls"')
            ,'','class="sw-header"')

            .$this->getListHeader('search')
            /*.div(
                $this->getListHeader('add')
                .button('', 'class="scroll-top ac-scroll-top " type="button"')
            , '' ,'class="ac-list-form-header ac-show-scroll"')*/
            .div(
                input('hidden', 'rowCount', @$i, "s='d'")
                .input('hidden', 'ip', $IdParent, "s='d'")
                 .div(
                     div(
                        table($trHead.$tr, "id='AuthyLogTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'AuthyLogListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#AuthyLogListForm [j='deleteAuthyLog']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Usagers Log'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msAuthyLogBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msAuthyLogBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#AuthyLogListForm tr[ecf=1] td[j='editAuthyLog']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."AuthyLog/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."AuthyLog/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'AuthyLog'
                ,'IdAuthyLog'
                ,'".$uiTabsId."'
                ,'".$autoconePageAct."'
                ,'".$this->search['Autoc']['SelRel']."'
                ,'".$this->search['Autoc']['child']."'
                ,'".$this->search['Autoc']['SelEnt']."'
                ,'".$this->search['Autoc']['SelId']."'
                ,'".addslashes($this->search['Autoc']['SelActBefore'])."'
                ,'".$this->search['Autoc']['SelIdAuto']."'
                ,'".addslashes($this->search['Autoc']['SelActAfter'])."'
                ,'selectNext(\'\', $(\'#cnt".$this->search['Autoc']['SelEnt']."\'+div+\' #".$this->search['Autoc']['SelIdAuto']."\'),1);'
                ,'".addslashes($this->search['Autoc']['formParentFull'])."'
            );
    ";
            }
        }else{
            $editEvent = "
        $(\"#AuthyLogListForm [j='deleteAuthyLog']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Usagers Log'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msAuthyLogBt\').length>0){ $(\'#msAuthyLogBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'AuthyLogTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntAuthyLogListForm #addAuthyLog').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'AuthyLogTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#AuthyLogListForm tr[ecf=1] td[j='editAuthyLog']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'AuthyLogTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'AuthyLog'
                ,'IdAuthyLog'
                ,'".$uiTabsId."'
                ,'".$autoconePageAct."'
                ,'".$this->search['Autoc']['SelRel']."'
                ,'".$this->search['Autoc']['child']."'
                ,'".$this->search['Autoc']['SelEnt']."'
                ,'".$this->search['Autoc']['SelId']."'
                ,'".addslashes($this->search['Autoc']['SelActBefore'])."'
                ,'".$this->search['Autoc']['SelIdAuto']."'
                ,'".addslashes($this->search['Autoc']['SelActAfter'])."'
                ,'selectNext(\'\', $(\'#cnt".$this->search['Autoc']['SelEnt']."\'+div+\' #".$this->search['Autoc']['SelIdAuto']."\'),1);'
                ,'".addslashes($this->search['Autoc']['formParentFull'])."'
            );
    ";
            }
        }
        $editEvent .= "
        pagination_bind('AuthyLog','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(\"#AuthyLogListForm [j='deleteAuthyLog']\").unbind('click');
        $('#AuthyLogListForm #addAuthyLog').unbind('click');
        $(\"#AuthyLogListForm tr[ecf=1] td[j='editAuthyLog']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#AuthyLogListForm [j='button']\").unbind();   
        pagination_sorted_bind('AuthyLog','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('AuthyLog','".addslashes($variableAutoc)."');
        
        
        
        
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_AuthyLog($data){

        unset($data['IdAuthyLog']);
        $e = new AuthyLog();
        
        
        if(isset($data['Timestamp'])){$e->setTimestamp(($data['Timestamp']=='')?null:$data['Timestamp']);}
        if(isset($data['Userid'])){$e->setUserid(($data['Userid']=='')?null:$data['Userid']);}
        if(isset($data['Count'])){$e->setCount(($data['Count']=='')?null:$data['Count']);}
        $e->fromArray($data );
        
        $e->setIdAuthy(($data['IdAuthy']=='')?null:$data['IdAuthy']);
        $e->setTimestamp(($data['Timestamp']=='')?null:$data['Timestamp']);
        $e->setLogin(($data['Login']=='')?null:$data['Login']);
        $e->setUserid(($data['Userid']=='')?null:$data['Userid']);
        $e->setResult(($data['Result']=='')?null:$data['Result']);
        $e->setIp(($data['Ip']=='')?null:$data['Ip']);
        $e->setCount(($data['Count']=='')?null:$data['Count']);
        return $e;
    }
    public function save_update_AuthyLog($data){

        
        $e = AuthyLogQuery::create()->findPk(json_decode($data['i']));
        
        
        if(isset($data['Timestamp'])){$e->setTimestamp(($data['Timestamp']=='')?null:$data['Timestamp']);}
        if(isset($data['Userid'])){$e->setUserid(($data['Userid']=='')?null:$data['Userid']);}
        if(isset($data['Count'])){$e->setCount(($data['Count']=='')?null:$data['Count']);}
        $e->fromArray($data );
        
        if(isset($data['IdAuthy'])){$e->setIdAuthy(($data['IdAuthy']=='')?null:$data['IdAuthy']);}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of AuthyLog
     * @param	string $id			PrimaryKey of the record to show
     * @param	string $uiTabsId	Present everywhere, javascript id of the html container
     * @param	string $data 		If present, will skip the query and show the data
     * @param	array $error			Error to display
     * @param	array $jsElement		container to append new event results
     * @param	array $jsElementType	container type to append new event results
     * @return	array standard html retrun array
    */
    public function getEditForm($id, $uiTabsId= "tabsContain", $data=array(), $error='', $jsElement='', $jsElementType='', $params=''){
        if(!isset($data['pc'])){$data['pc']="";}
        
        $variableAutoc ="";
        if(isset($this->search['Autoc'])){
            $variableAutoc = preg_replace("/\s+/", " ",trim("  
                ,Autoc :{
                    SelActAfter:'".$this->search['Autoc']['SelActAfter']."'
                    ,SelActBefore:'".$this->search['Autoc']['SelActBefore']."'
                    ,SelList:'".$this->search['Autoc']['SelList']."'
                    ,IdTemp:'".$this->search['Autoc']['IdTemp']."'
                    ,SelIdAuto:'".$this->search['Autoc']['SelIdAuto']."'
                    ,SelParent:'".$this->search['Autoc']['SelParent']."'
                    ,SelId:'".$this->search['Autoc']['SelId']."'
                    ,SelEnt:'".$this->search['Autoc']['SelEnt']."'
                    ,SelRel:'".$this->search['Autoc']['SelRel']."'
                }
            "));
        }
    
        $this->SaveButtonJs="";
        $je= "AuthyLogTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['AuthyLog']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['AuthyLog']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addAuthyLog_child').bind('click.addAuthyLog', function (){
                    $.post('"._SITE_URL."mod/act/AuthyLogAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addAuthyLog_child').bind('click.addAuthyLog', function (){
                document.location= '"._SITE_URL."AuthyLog/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = AuthyLogQuery::create();
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'AuthyLog', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'AuthyLog','w',$dataObj)) 
            || ($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].$data['req']['SelectTableName'],'w',$dataObj)
                    and $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].$data['req']['SelectTableName']."SelectBox".$data['req']['SelectChamps'],'a') and !$id)
            || ($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].$data['req']['SelectTableName'],'w',$dataObj) 
                    and $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].$data['req']['SelectTableName']."SelectBox".$data['req']['SelectChamps'],'w',$dataObj))    
            ||$this->setReadOnly){
            $otherParam="";
            if(!empty($data['req']['SelectTableName'])){ $otherParam.=",SelectTableName:'".addslashes($data['req']['SelectTableName'])."'";}
            if(!empty($data['req']['SelectChamps'])){ $otherParam.=",SelectChamps:'".addslashes($data['req']['SelectChamps'])."'";}
            
            if(!empty($this->ccAfterSaveJs)){$ActionSaveJs =$this->ccAfterSaveJs;
            }else{
                $ActionSaveJs ="
                    $('#formAuthyLog #saveAuthyLog').removeAttr('disabled');
                    $('#formAuthyLog #saveAuthyLog').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formAuthyLog #saveAuthyLog').css('cursor', 'default');
                    if($('#formAuthyLog #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formAuthyLog #saveAuthyLog').bind('click.saveAuthyLog', function (data){
                    $('#formAuthyLog #saveAuthyLog').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formAuthyLog #saveAuthyLog').css('cursor', 'progress');
                    $('#formAuthyLog #saveAuthyLog').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formAuthyLog .tinymce').each(function(index) {
                        eval(' $(\"#formAuthyLog #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formAuthyLog select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formAuthyLog\").find(\"[s='d']\").serializeArray();
                        $('#formAuthyLog select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formAuthyLog\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/AuthyLogAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formAuthyLog #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formAuthyLog #formChangedAuthyLog').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formAuthyLog #saveAuthyLog').unbind('click.saveAuthyLog');
                $('#formAuthyLog #saveAuthyLog').remove();";
        }
        
        if($dataObj == null){
            $this->AuthyLog['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new AuthyLog();
            $this->AuthyLog['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }


        
        
        
        
        
        
        

            $this->fields['AuthyLog']['Timestamp']['html'] = stdFieldRow(_("Date"), input('number', 'Timestamp',$dataObj->getTimestamp(), " step='10' placeholder='".str_replace("'","&#39;",_('Date'))."' v='TIMESTAMP' size='0' otherTabs=1 s='d' class='' otherTabs=1 "), 'Timestamp', "", @$this->commentsTimestamp, @$this->commentsTimestamp_css, '', ' ','no','');

            $this->fields['AuthyLog']['Login']['html'] = stdFieldRow(_("Nom d'usager"), input('text', 'Login',str_replace('"','&quot;',$dataObj->getLogin()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Nom d\'usager'))."' size='35'  v='LOGIN' s='d' class=''")."", 'Login', "", @$this->commentsLogin, @$this->commentsLogin_css, '', ' ','no','');

            $this->fields['AuthyLog']['Ip']['html'] = stdFieldRow(_("Ip"), input('text', 'Ip',str_replace('"','&quot;',$dataObj->getIp()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Ip'))."' size='15'  v='IP' s='d' class=''")."", 'Ip', "", @$this->commentsIp, @$this->commentsIp_css, '', ' ','no','');

            $this->fields['AuthyLog']['Count']['html'] = stdFieldRow(_("Compte"), input('number', 'Count',$dataObj->getCount(), " step='10' placeholder='".str_replace("'","&#39;",_('Compte'))."' v='COUNT' size='0' otherTabs=1 s='d' class='' otherTabs=1 "), 'Count', "", @$this->commentsCount, @$this->commentsCount_css, '', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->AuthyLog['request']['ChildHide']) ){
            
        }
        
        
        if($dataObj->getIdAuthyLog()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'AuthyLogControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = '';
            }

        }
        
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addAuthyLog_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveAuthyLog',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedAuthyLog','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdAuthyLog', $dataObj->getIdAuthyLog(), " otherTabs=1 s='d' pk").input('hidden', 'IdAuthy', $dataObj->getIdAuthy(), " otherTabs=1 s='d' nodesc").input('hidden', 'Userid',$dataObj->getUserid(), "   v='USERID' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'AuthyLogControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formAuthyLog');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['AuthyLog']['tog']) and 
            $_SESSION['memoire']['onglet']['AuthyLog']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
        $header_top = 
                div(
                    div(href(span(_('Ouvrir/Fermer le menu')),'javascript:','class="toggle-menu button-link-blue trigger-menu"')
                    
                    .$this->add_button,'','class="default-controls"')
                    .$this->printLink
                    .button(span(_("Afficher le menu")),'class="btn-custom-controls"')
                , '', 'class="sw-header"');
        $header_top_onglet = @$this->formTitle.@$ongletf;
        
        $return['html'] =
        $this->CcToFormTop
        .@$mceInclude
        .@$header_top
        .form(
            $header_top_onglet
            
            .div(
                @$this->CcToInnerFormTop
                .@$this->fields['AuthyLog']['Start']['html']
                
                .
$this->fields['AuthyLog']['Timestamp']['html']
.$this->fields['AuthyLog']['Login']['html']
.$this->fields['AuthyLog']['Ip']['html']
.$this->fields['AuthyLog']['Count']['html']
                
                .@$this->fields['AuthyLog']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntAuthyLog", "class='divStdform' CntTabs=1 ")
        , "id='formAuthyLog' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Usagers Log"); }
        # if not new, show child table
        if($dataObj->getIdAuthyLog()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelAuthyLog', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntAuthyLogChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['AuthyLog']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['AuthyLog']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['AuthyLog']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    
    ".$jqueryDatePicker."
    bind_ui_active('AuthyLog');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    ".@$childTable['onReadyJs']."
    ".@$error['onReadyJs']."
    ".@$removeEditChild."
    /*try {afterFormLoad();}catch(e){}*/
    if($('#loader').css('display') == 'block') $('#loader').hide();
    $('[j=sftr]').hide();
    ".@$tabs_act."
    ".$this->CcToFormJs
    .@$script_autoc_one."
     setTimeout(function(){ bind_othertabs_std('#divCntAuthyLog');},500); 
    ".$toggleForm."
    bind_form('AuthyLog','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
            
        $this->fieldsRo['AuthyLog']['Timestamp']['html'] = stdFieldRow(_("Date"), input('text','Timestamp',$dataObj->getTimestamp()," readonly s='d'"), 'Timestamp', "", @$this->commentsTimestamp, @$this->commentsTimestamp_css, 'readonly', ' ','no','');
$this->fieldsRo['AuthyLog']['Login']['html'] = stdFieldRow(_("Nom d'usager"), input('text','Login',$dataObj->getLogin()," readonly s='d'"), 'Login', "", @$this->commentsLogin, @$this->commentsLogin_css, 'readonly', ' ','no','');
$this->fieldsRo['AuthyLog']['Ip']['html'] = stdFieldRow(_("Ip"), input('text','Ip',$dataObj->getIp()," readonly s='d'"), 'Ip', "", @$this->commentsIp, @$this->commentsIp_css, 'readonly', ' ','no','');
$this->fieldsRo['AuthyLog']['Count']['html'] = stdFieldRow(_("Compte"), input('text','Count',$dataObj->getCount()," readonly s='d'"), 'Count', "", @$this->commentsCount, @$this->commentsCount_css, 'readonly', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['AuthyLog'] as $field=>$ar){
                $this->fields['AuthyLog'][$field]['html'] = $this->fieldsRo['AuthyLog'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['AuthyLog'][$field]['html'] = $this->fieldsRo['AuthyLog'][$field]['html'];
            }
        }
    }
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = AuthyLogQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdAuthyLog'));
            
        
        }else{
            $q->select(array('Name', 'IdAuthyLog'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = AuthyLogQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdAuthyLog'));
            
        
        }else{
            $q->select(array('Name', 'IdAuthyLog'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Usagers Log')), $selected);
        }


        return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'AuthyLogAct.php';
    $this->cCajaxPageActParent = '';
    $this->cCajaxPageAct = '';
    $this->cCListActionRow = '';
    $this->cCmoreColsHeader = '';
    $this->cCmoreCols = '';
    $this->CcToListTop = '';
    $this->CcToListBottom = '';
    $this->CcToListJs = '';
    $this->queryObj = '';
    $this->search = array();
    $this->search = array('Autoc'=> array( 'SelParent' => '', 'SelList' => '','SelEnt' => '', 'SelIdAuto' => '', 'IdTemp' => '', 'SelId' => '',
                                            'SelRel' => '', 'SelEnt' => '', 'SelActAfter' => '', 'SelActBefore' => '' ) ) ;
    
    # Edit form
    $this->CcToFormBottom = '';
    $this->CcToFormJs='';
    }

    
}
