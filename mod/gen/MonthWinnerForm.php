<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'MonthWinner' table.
 *
 */
class MonthWinnerForm extends MonthWinner{
public $tableName="MonthWinner";
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
        $q = MonthWinnerQuery::create();
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
                if(isset($this->searchMs['Title']) and $this->searchMs['Title'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Title']) and strpos($this->searchMs['Title'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Title'] != '%DoNothing%' AND $this->searchMs['Title'][0] != '%DoNothing%'){
                        $q->filterByTitle("%".$this->searchMs['Title']."%", Criteria::LIKE);
                    }
                }
            }else{
                
            if(json_decode($IdParent)){
                $pmpoData = MonthWinnerQuery::create()->filterByIdWinner(json_decode($IdParent))
                    
                    
                    ->paginate($page, $maxPerPage);
            }
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
                    
            if(strpos($col,"I18n.") !== false){
                $q->joinI18n($tOrd[2]);
                $orderBy = "use".$tOrd[0]."Query";
                $q->$orderBy('','left join')->orderBy($tOrd[1],$sens)->endUse();
            }elseif(!empty($tOrd[1])){
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
        
         $q->groupBy('IdMonthWinner');
        
        $this->pmpoData =  $q;
        //echo $q->toString();
        //$q->paginate($page, $maxPerPage);
        return $this->pmpoData;
    }
    public function getListHeader($act){
        switch($act){
            case 'head':
            ###### TH
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Identifiant"), " th='sorted'  rcColone='Title' c='Title'  ").th(_("Ordre d'affichage"), " th='sorted'  rcColone='Order' c='Order'  "). $this->cCmoreColsHeader;
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
                $array_search_tb = array('Title');
                
                unset($data);$data['Title'] = (!empty($this->searchMs['Title']))?$this->searchMs['Title']:'';
        
                
        @$this->fieldsSearch['MonthWinner']['Title'] = div(input('text', 'Title', $this->searchMs['Title'], ' othertabs=1  placeholder="'._('Nom').'"',''),'','class="ac-search-item ms-Title"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msMonthWinnerAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['MonthWinner']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msMonthWinnerBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msMonthWinnerBtClear" class="icon clear"')
               .@$this->fieldsSearch['MonthWinner']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['MonthWinner']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-MonthWinnerSearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['MonthWinner']['Start'].
                    $this->fieldsSearch['MonthWinner']['Title'].
                @$this->fieldsSearch['MonthWinner']['End'].
            $this->fieldsSearch['MonthWinner']['Button']
            ,"id='formMsMonthWinner' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('MonthWinner', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."MonthWinner/edit/", "id='addMonthWinner' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addMonthWinnerAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Mois");
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
        if(!empty($_SESSION['memoire']['onglet']['MonthWinner']['pg'])){
            $page = $_SESSION['memoire']['onglet']['MonthWinner']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'MonthWinnerAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'MonthWinnerAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
            $search_child_default['Order']='ASC';
        if(empty($this->searchOrder)){$this->searchOrder = $search_child_default;}
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#MonthWinnerListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#MonthWinnerListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('MonthWinner', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('MonthWinner', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('MonthWinner', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteMonthWinner' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
                
                
                
                 $titreRaccour =''; $titreRaccour .= _('Mois');
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['Title']) and $altValue['Title'])?$altValue['Title']:$data->getTitle()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Identifiant").":\" j='editMonthWinner'  i='".json_encode($data->getPrimaryKey())."' c='Title'  ")
                            .td(span(strip_tags((isset($altValue['Order']) and $altValue['Order'])?$altValue['Order']:$data->getOrder()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Ordre d'affichage").":\" j='editMonthWinner'  i='".json_encode($data->getPrimaryKey())."' c='Order'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='MonthWinnerRow".$data->getPrimaryKey()."'
                    data-table='MonthWinner' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountMonthWinner', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Mois';

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
                            ,'','id="MonthWinnerPagination"')
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
                .div($controlsContent.$this->CcCustomControl,'MonthWinnerControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='MonthWinnerTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'MonthWinnerListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#MonthWinnerListForm [j='deleteMonthWinner']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Mois'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msMonthWinnerBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msMonthWinnerBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#MonthWinnerListForm tr[ecf=1] td[j='editMonthWinner']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."MonthWinner/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."MonthWinner/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'MonthWinner'
                ,'IdMonthWinner'
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
        $(\"#MonthWinnerListForm [j='deleteMonthWinner']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Mois'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msMonthWinnerBt\').length>0){ $(\'#msMonthWinnerBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'MonthWinnerTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntMonthWinnerListForm #addMonthWinner').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'MonthWinnerTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#MonthWinnerListForm tr[ecf=1] td[j='editMonthWinner']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'MonthWinnerTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'MonthWinner'
                ,'IdMonthWinner'
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
        pagination_bind('MonthWinner','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#MonthWinnerListForm [j='deleteMonthWinner']\").unbind('click');
        $('#MonthWinnerListForm #addMonthWinner').unbind('click');
        $(\"#MonthWinnerListForm tr[ecf=1] td[j='editMonthWinner']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#MonthWinnerListForm [j='button']\").unbind();   
        pagination_sorted_bind('MonthWinner','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('MonthWinner','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('MonthWinner','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_MonthWinner($data){

        unset($data['IdMonthWinner']);
        $e = new MonthWinner();
        
        
        if(!@$data['Onlune']){$data['Onlune'] = "Oui";} 
        if(isset($data['Order'])){$e->setOrder(($data['Order']=='')?null:$data['Order']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setOrder(($data['Order']=='')?null:$data['Order']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_MonthWinner($data){

        
        $e = MonthWinnerQuery::create()->findPk(json_decode($data['i']));
        
        
        if(!@$data['Onlune']){$data['Onlune'] = "Oui";} 
        if(isset($data['Order'])){$e->setOrder(($data['Order']=='')?null:$data['Order']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of MonthWinner
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
        $je= "MonthWinnerTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['MonthWinner']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['MonthWinner']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addMonthWinner_child').bind('click.addMonthWinner', function (){
                    $.post('"._SITE_URL."mod/act/MonthWinnerAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addMonthWinner_child').bind('click.addMonthWinner', function (){
                document.location= '"._SITE_URL."MonthWinner/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = MonthWinnerQuery::create();
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'MonthWinner', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'MonthWinner','w',$dataObj)) 
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
                    $('#formMonthWinner #saveMonthWinner').removeAttr('disabled');
                    $('#formMonthWinner #saveMonthWinner').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formMonthWinner #saveMonthWinner').css('cursor', 'default');
                    if($('#formMonthWinner #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formMonthWinner #saveMonthWinner').bind('click.saveMonthWinner', function (data){
                    $('#formMonthWinner #saveMonthWinner').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formMonthWinner #saveMonthWinner').css('cursor', 'progress');
                    $('#formMonthWinner #saveMonthWinner').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formMonthWinner .tinymce').each(function(index) {
                        eval(' $(\"#formMonthWinner #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formMonthWinner select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formMonthWinner\").find(\"[s='d']\").serializeArray();
                        $('#formMonthWinner select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formMonthWinner\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/MonthWinnerAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formMonthWinner #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formMonthWinner #formChangedMonthWinner').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formMonthWinner #saveMonthWinner').unbind('click.saveMonthWinner');
                $('#formMonthWinner #saveMonthWinner').remove();";
        }
        
        if($dataObj == null){
            $this->MonthWinner['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new MonthWinner();
            $this->MonthWinner['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
            if($data['ip']){
                $strPkParent = "setIdWinner";
                $dataObj->$strPkParent($data['ip']);
            }
        }

try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new MonthWinnerI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addMonthWinnerI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new MonthWinnerI18n();$mt->setLocale('en_US')->setText('');$dataObj->addMonthWinnerI18n($mt)->save();}

        
        
        
        
        
        
        

            $this->fields['MonthWinner']['Title']['html'] = stdFieldRow(_("Identifiant"), input('text', 'Title',str_replace('"','&quot;',$dataObj->getTitle()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Identifiant'))."' size='69'  v='TITLE' s='d' class=''")."", 'Title', "", @$this->commentsTitle, @$this->commentsTitle_css, '', ' ','no','');

            $this->fields['MonthWinner']['Onlune']['html'] = stdFieldRow(_("En ligne"), selectboxCustomArray('Onlune', array( '0' => array('0'=>_("Oui"), '1'=>'Oui'),'1' => array('0'=>_("Non"), '1'=>'Non'), ), "", "s='d' otherTabs=1  ", $dataObj->getOnlune()), 'Onlune', "", @$this->commentsOnlune, @$this->commentsOnlune_css, '', ' ','no','');

            $this->fields['MonthWinner']['Order']['html'] = stdFieldRow(_("Ordre d'affichage"), input('number', 'Order',$dataObj->getOrder(), " step='10' placeholder='".str_replace("'","&#39;",_('Ordre d\'affichage'))."' v='ORDER' size='0' otherTabs=1 s='d' class='' otherTabs=1 "), 'Order', "", @$this->commentsOrder, @$this->commentsOrder_css, '', ' ','no','');

            $this->fields['MonthWinner']['MonthWinnerI18n_Name_frCA']['html'] = stdFieldRow(_("Titre français"), input('text', 'MonthWinnerI18n_Name_frCA',str_replace('"','&quot;',$dataObj->getTranslation('fr_CA')->getName()), "placeholder='".str_replace("'","&#39;",_('Titre fr_CA'))."' size='69' otherTabs=1  v='MONTHWINNERI18N_NAME_FRCA' s='d'  class=''")."", 'MonthWinnerI18n_Name_frCA', "", @$this->commentsMonthWinnerI18n_Name_frCA, @$this->commentsMonthWinnerI18n_Name_frCA_css, '', ' ','no','');

            $this->fields['MonthWinner']['MonthWinnerI18n_Text_frCA']['html'] = stdFieldRow(_("Liste de gagnants français"), 
        textarea('MonthWinnerI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText() ,"placeholder='".str_replace("'","&#39;",_('Liste de gagnants fr_CA'))."' cols='71' v='MONTHWINNERI18N_TEXT_FRCA' otherTabs=1 s='d'  class='tinymce'  class='' style='' spellcheck='false'"), 'MonthWinnerI18n_Text_frCA', "", @$this->commentsMonthWinnerI18n_Text_frCA, @$this->commentsMonthWinnerI18n_Text_frCA_css, ' istinymce', ' ','no','');

            $this->fields['MonthWinner']['MonthWinnerI18n_Name_enUS']['html'] = stdFieldRow(_("Titre anglais"), input('text', 'MonthWinnerI18n_Name_enUS',str_replace('"','&quot;',$dataObj->getTranslation('en_US')->getName()), "placeholder='".str_replace("'","&#39;",_('Titre en_US'))."' size='69' otherTabs=1  v='MONTHWINNERI18N_NAME_ENUS' s='d'  class=''")."", 'MonthWinnerI18n_Name_enUS', "", @$this->commentsMonthWinnerI18n_Name_enUS, @$this->commentsMonthWinnerI18n_Name_enUS_css, '', ' ','no','');

            $this->fields['MonthWinner']['MonthWinnerI18n_Text_enUS']['html'] = stdFieldRow(_("Liste de gagnants anglais"), 
        textarea('MonthWinnerI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText() ,"placeholder='".str_replace("'","&#39;",_('Liste de gagnants en_US'))."' cols='71' v='MONTHWINNERI18N_TEXT_ENUS' otherTabs=1 s='d'  class='tinymce'  class='' style='' spellcheck='false'"), 'MonthWinnerI18n_Text_enUS', "", @$this->commentsMonthWinnerI18n_Text_enUS, @$this->commentsMonthWinnerI18n_Text_enUS_css, ' istinymce', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->MonthWinner['request']['ChildHide']) ){
            
        }
        
        
        if($dataObj->getIdMonthWinner()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'MonthWinnerControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = '';
            }

        }
        
        $ongletf =
            div(
                ul(li(htmlLink(_('Mois'),'#ogf_MonthWinner',' j="ogf" p="MonthWinner" class="ui-tabs-anchor button-link-blue" ')).li(htmlLink(_('Français'),'#ogf_Monthwinneri18nNameFrca',' j="ogf" class="ui-tabs-anchor button-link-blue" p="MonthWinner" ')).li(htmlLink(_('Anglais'),'#ogf_Monthwinneri18nNameEnus',' j="ogf" class="ui-tabs-anchor button-link-blue" p="MonthWinner" ')))
            ,'cntOngletMonthWinner',' class="cntOnglet"')
            .@$close_form
        ;
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addMonthWinner_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveMonthWinner',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedMonthWinner','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdMonthWinner', $dataObj->getIdMonthWinner(), " otherTabs=1 s='d' pk").input('hidden', 'IdWinner', $dataObj->getIdWinner(), " otherTabs=1 s='d' nodesc").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        $mceInclude = loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/ckeditor.js")
            .loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/adapters/jquery.js");
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'MonthWinnerControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formMonthWinner');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['MonthWinner']['tog']) and 
            $_SESSION['memoire']['onglet']['MonthWinner']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['MonthWinner']['Start']['html']
                
                .
                    '<div id="ogf_MonthWinner">'.
$this->fields['MonthWinner']['Title']['html']
.$this->fields['MonthWinner']['Onlune']['html']
.$this->fields['MonthWinner']['Order']['html']
.'</div><div id="ogf_Monthwinneri18nNameFrca"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['MonthWinner']['MonthWinnerI18n_Name_frCA']['html']
.$this->fields['MonthWinner']['MonthWinnerI18n_Text_frCA']['html']
.'</div><div id="ogf_Monthwinneri18nNameEnus"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['MonthWinner']['MonthWinnerI18n_Name_enUS']['html']
.$this->fields['MonthWinner']['MonthWinnerI18n_Text_enUS']['html'].'</div>'
                
                .@$this->fields['MonthWinner']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntMonthWinner", "class='divStdform' CntTabs=1 ")
        , "id='formMonthWinner' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Mois"); }
        # if not new, show child table
        if($dataObj->getIdMonthWinner()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelMonthWinner', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntMonthWinnerChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['MonthWinner']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['MonthWinner']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['MonthWinner']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    
    ".$jqueryDatePicker."
    bind_ui_active('MonthWinner');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    $('#formMonthWinner .tinymce').each(function() {
        if (CKEDITOR.instances[$(this).attr('Id')]){
            CKEDITOR.instances[$(this).attr('Id')].destroy();
        }
        ckeTemp = CKEDITOR.replace($(this).attr('Id'), {
            extraAllowedContent: '*(*)[*];sup(*)[*];article(*)[*];section(*)[*];div(*)[*];span(*)'
            ".@$this->ccAddCkeditorInit."
        });
        ckeTemp.on('change',function( evt ){ $('.divtd input[type=\"button\"]').addClass('can-save');});
        ckeTemp.on('key',function( event ){ if(event.data.keyCode ==1114195){ $('form [act=save]').click(); return false;}});
    });$('#cntOngletMonthWinner').parent().tabs();$('#cntOngletMonthWinner').show();
    ".@$childTable['onReadyJs']."
    ".@$error['onReadyJs']."
    ".@$removeEditChild."
    /*try {afterFormLoad();}catch(e){}*/
    if($('#loader').css('display') == 'block') $('#loader').hide();
    $('[j=sftr]').hide();
    ".@$tabs_act."
    ".$this->CcToFormJs
    .@$script_autoc_one."
     setTimeout(function(){ bind_othertabs_std('#divCntMonthWinner');},500); 
    ".$toggleForm."
    bind_form('MonthWinner','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new MonthWinnerI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addMonthWinnerI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new MonthWinnerI18n();$mt->setLocale('en_US')->setText('');$dataObj->addMonthWinnerI18n($mt)->save();}
            
        $this->fieldsRo['MonthWinner']['Title']['html'] = stdFieldRow(_("Identifiant"), input('text','Title',$dataObj->getTitle()," readonly s='d'"), 'Title', "", @$this->commentsTitle, @$this->commentsTitle_css, 'readonly', ' ','no','');
$this->fieldsRo['MonthWinner']['Onlune']['html'] = stdFieldRow(_("En ligne"), input('text','Onlune',$dataObj->getOnlune()," readonly s='d'"), 'Onlune', "", @$this->commentsOnlune, @$this->commentsOnlune_css, 'readonly', ' ','no','');
$this->fieldsRo['MonthWinner']['Order']['html'] = stdFieldRow(_("Ordre d'affichage"), input('text','Order',$dataObj->getOrder()," readonly s='d'"), 'Order', "", @$this->commentsOrder, @$this->commentsOrder_css, 'readonly', ' ','no','');
$this->fieldsRo['MonthWinner']['MonthWinnerI18n_Name_frCA']['html'] = stdFieldRow(_("Titre français"), input('text','MonthWinnerI18n_Name_frCA',$dataObj->getTranslation('fr_CA')->getName()," readonly s='d'"), 'MonthWinnerI18n_Name_frCA', "", @$this->commentsMonthWinnerI18n_Name_frCA, @$this->commentsMonthWinnerI18n_Name_frCA_css, 'readonly', ' ','no','');
$this->fieldsRo['MonthWinner']['MonthWinnerI18n_Text_frCA']['html'] = stdFieldRow(_("Liste de gagnants français"), textarea('MonthWinnerI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText()," readonly class='tinymce'    s='d'"), 'MonthWinnerI18n_Text_frCA', "", @$this->commentsMonthWinnerI18n_Text_frCA, @$this->commentsMonthWinnerI18n_Text_frCA_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['MonthWinner']['MonthWinnerI18n_Name_enUS']['html'] = stdFieldRow(_("Titre anglais"), input('text','MonthWinnerI18n_Name_enUS',$dataObj->getTranslation('en_US')->getName()," readonly s='d'"), 'MonthWinnerI18n_Name_enUS', "", @$this->commentsMonthWinnerI18n_Name_enUS, @$this->commentsMonthWinnerI18n_Name_enUS_css, 'readonly', ' ','no','');
$this->fieldsRo['MonthWinner']['MonthWinnerI18n_Text_enUS']['html'] = stdFieldRow(_("Liste de gagnants anglais"), textarea('MonthWinnerI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText()," readonly class='tinymce'    s='d'"), 'MonthWinnerI18n_Text_enUS', "", @$this->commentsMonthWinnerI18n_Text_enUS, @$this->commentsMonthWinnerI18n_Text_enUS_css, 'readonly istinymce', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['MonthWinner'] as $field=>$ar){
                $this->fields['MonthWinner'][$field]['html'] = $this->fieldsRo['MonthWinner'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['MonthWinner'][$field]['html'] = $this->fieldsRo['MonthWinner'][$field]['html'];
            }
        }
    }
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = MonthWinnerQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdMonthWinner'));
            
            $pcData = $q->filterByIdWinner($IdParent);
        
        }else{
            $q->select(array('Name', 'IdMonthWinner'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = MonthWinnerQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdMonthWinner'));
            
            $pcData = $q->filterByIdWinner($IdParent);
        
        }else{
            $q->select(array('Name', 'IdMonthWinner'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Mois')), $selected);
        }


        return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'MonthWinnerAct.php';
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
