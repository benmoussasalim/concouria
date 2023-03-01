<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'Ticket' table.
 *
 */
class TicketForm extends Ticket{
public $tableName="Ticket";
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
        $q = TicketQuery::create();
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
                if(isset($this->searchMs['IdTicket']) and $this->searchMs['IdTicket'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['IdTicket']) and strpos($this->searchMs['IdTicket'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['IdTicket'] != '%DoNothing%' AND $this->searchMs['IdTicket'][0] != '%DoNothing%'){
                        $q->filterByIdTicket("%".$this->searchMs['IdTicket']."%", Criteria::LIKE);
                    }
                }
                if(isset($this->searchMs['IdTicket']) and $this->searchMs['IdTicket'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['IdTicket']) and strpos($this->searchMs['IdTicket'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['IdTicket'] != '%DoNothing%' AND $this->searchMs['IdTicket'][0] != '%DoNothing%'){
                        $q->filterByIdTicket("%".$this->searchMs['IdTicket']."%", Criteria::LIKE);
                    }
                }
                if(isset($this->searchMs['Project']) and $this->searchMs['Project'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Project']) and strpos($this->searchMs['Project'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Project'] != '%DoNothing%' AND $this->searchMs['Project'][0] != '%DoNothing%'){
                        $q->filterByProject("%".$this->searchMs['Project']."%", Criteria::LIKE);
                    }
                }
                if(isset($this->searchMs['Online']) and $this->searchMs['Online'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Online']) and strpos($this->searchMs['Online'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Online'] != '%DoNothing%' AND $this->searchMs['Online'][0] != '%DoNothing%'){
                        $q ->filterByOnline($this->searchMs['Online'],$criteria);
                    }
                }
                if(isset($this->searchMs['Date']) and $this->searchMs['Date'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Date']) and strpos($this->searchMs['Date'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Date'] != '%DoNothing%' AND $this->searchMs['Date'][0] != '%DoNothing%'){
                        $q ->filterByDate($this->searchMs['Date'],$criteria);
                    }
                }
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
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Numéro de ticket"), " th='sorted'  rcColone='IdTicket' c='IdTicket'  ").th(_("Auteur"), " th='sorted'  rcColone='Author' c='Author'  ").th(_("Projet"), " th='sorted'  rcColone='Project' c='Project'  ").th(_("Date d'ouverture"), " th='sorted'  rcColone='Date' c='Date'  ").th(_("Status"), " th='sorted'  rcColone='Online' c='Online'  "). $this->cCmoreColsHeader;
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
                $array_search_tb = array('IdTicket','IdTicket','Project','Online','Date');
                
                unset($data);$data['IdTicket'] = (!empty($this->searchMs['IdTicket']))?$this->searchMs['IdTicket']:'';
        $data['IdTicket'] = (!empty($this->searchMs['IdTicket']))?$this->searchMs['IdTicket']:'';
        $data['Project'] = (!empty($this->searchMs['Project']))?$this->searchMs['Project']:'';
        $data['Online'] = (!empty($this->searchMs['Online']))?$this->searchMs['Online']:'';
        $data['Date'] = (!empty($this->searchMs['Date']))?$this->searchMs['Date']:'';
        
                
        @$this->fieldsSearch['Ticket']['IdTicket'] = div(input('text', 'IdTicket', $this->searchMs['IdTicket'], ' othertabs=1  placeholder="'._('Numéro de ticket').'"',''),'','class="ac-search-item ms-IdTicket"');
        @$this->fieldsSearch['Ticket']['IdTicket'] = div(input('text', 'IdTicket', $this->searchMs['IdTicket'], ' othertabs=1  placeholder="'._('Auteur').'"',''),'','class="ac-search-item ms-IdTicket"');
        @$this->fieldsSearch['Ticket']['Project'] = div(input('text', 'Project', $this->searchMs['Project'], ' othertabs=1  placeholder="'._('Projet').'"',''),'','class="ac-search-item ms-Project"');
        @$this->fieldsSearch['Ticket']['Online'] =div(selectboxCustomArray('Online', array( '0' => array('0'=>_("Ouvert"), '1'=>'Ouvert'),'1' => array('0'=>_("Fermé"), '1'=>'Fermé'), ), _('Status'), '  size="1" t="1"   ', $this->searchMs['Online']), '', '  class=" ac-search-item ms-Online"');
        @$this->fieldsSearch['Ticket']['Date'] = div(input('text', 'Date', $this->searchMs['Date'], ' othertabs=1  j="date"  placeholder="'._('Date').'"',''),'','class="ac-search-item ms-Date"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msTicketAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['Ticket']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msTicketBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msTicketBtClear" class="icon clear"')
               .@$this->fieldsSearch['Ticket']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['Ticket']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-TicketSearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['Ticket']['Start'].
                    $this->fieldsSearch['Ticket']['IdTicket'].
                    $this->fieldsSearch['Ticket']['IdTicket'].
                    $this->fieldsSearch['Ticket']['Project'].
                    $this->fieldsSearch['Ticket']['Online'].
                    $this->fieldsSearch['Ticket']['Date'].
                @$this->fieldsSearch['Ticket']['End'].
            $this->fieldsSearch['Ticket']['Button']
            ,"id='formMsTicket' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('Ticket', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."Ticket/edit/", "id='addTicket' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addTicketAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Ticket");
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
        if(!empty($_SESSION['memoire']['onglet']['Ticket']['pg'])){
            $page = $_SESSION['memoire']['onglet']['Ticket']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'TicketAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'TicketAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#TicketListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#TicketListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('Ticket', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('Ticket', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('Ticket', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteTicket' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
                
                
                
                 @$titreRaccour =strip_tags($titreRaccour);
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['IdTicket']) and $altValue['IdTicket'])?$altValue['IdTicket']:$data->getIdTicket()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Numéro de ticket").":\" j='editTicket'  i='".json_encode($data->getPrimaryKey())."' c='IdTicket'  ")
                            .td(span(strip_tags((isset($altValue['Author']) and $altValue['Author'])?$altValue['Author']:$data->getAuthor()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Auteur").":\" j='editTicket'  i='".json_encode($data->getPrimaryKey())."' c='Author'  ")
                            .td(span(strip_tags((isset($altValue['Project']) and $altValue['Project'])?$altValue['Project']:$data->getProject()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Projet").":\" j='editTicket'  i='".json_encode($data->getPrimaryKey())."' c='Project'  ")
                            .td(span(strip_tags((isset($altValue['Date']) and $altValue['Date'])?$altValue['Date']:$data->getDate()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Date d'ouverture").":\" j='editTicket'  i='".json_encode($data->getPrimaryKey())."' c='Date'  ")
                            .td(span(strip_tags((isset($altValue['Online']) and $altValue['Online'])?$altValue['Online']:isntPo($data->getOnline())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Status").":\" j='editTicket'  i='".json_encode($data->getPrimaryKey())."' c='Online'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='TicketRow".$data->getPrimaryKey()."'
                    data-table='Ticket' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountTicket', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Ticket';

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
                            ,'','id="TicketPagination"')
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
                .div($controlsContent.$this->CcCustomControl,'TicketControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='TicketTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'TicketListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#TicketListForm [j='deleteTicket']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Ticket'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msTicketBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msTicketBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#TicketListForm tr[ecf=1] td[j='editTicket']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."Ticket/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."Ticket/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Ticket'
                ,'IdTicket'
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
        $(\"#TicketListForm [j='deleteTicket']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Ticket'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msTicketBt\').length>0){ $(\'#msTicketBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'TicketTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntTicketListForm #addTicket').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'TicketTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#TicketListForm tr[ecf=1] td[j='editTicket']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'TicketTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Ticket'
                ,'IdTicket'
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
        pagination_bind('Ticket','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#TicketListForm [j='deleteTicket']\").unbind('click');
        $('#TicketListForm #addTicket').unbind('click');
        $(\"#TicketListForm tr[ecf=1] td[j='editTicket']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#TicketListForm [j='button']\").unbind();   
        pagination_sorted_bind('Ticket','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('Ticket','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('Ticket','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_Ticket($data){

        unset($data['IdTicket']);
        $e = new Ticket();
        
        
        if(!@$data['Online']){$data['Online'] = "Ouvert";} 
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setDate( ($data['Date'] == '' || $data['Date'] == 'null' || substr($data['Date'],0,10) == '-0001-11-30')?date('Y-m-d'):$data['Date'] );
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_Ticket($data){

        
        $e = TicketQuery::create()->findPk(json_decode($data['i']));
        
        
        if(!@$data['Online']){$data['Online'] = "Ouvert";} 
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['Date'])){$e->setDate( ($data['Date'] == '' || $data['Date'] == 'null' || substr($data['Date'],0,10) == '-0001-11-30')?NULL:$data['Date'] );}
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of Ticket
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
        $je= "TicketTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['Ticket']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['Ticket']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addTicket_child').bind('click.addTicket', function (){
                    $.post('"._SITE_URL."mod/act/TicketAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addTicket_child').bind('click.addTicket', function (){
                document.location= '"._SITE_URL."Ticket/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = TicketQuery::create();
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Ticket', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Ticket','w',$dataObj)) 
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
                    $('#formTicket #saveTicket').removeAttr('disabled');
                    $('#formTicket #saveTicket').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formTicket #saveTicket').css('cursor', 'default');
                    if($('#formTicket #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formTicket #saveTicket').bind('click.saveTicket', function (data){
                    $('#formTicket #saveTicket').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formTicket #saveTicket').css('cursor', 'progress');
                    $('#formTicket #saveTicket').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formTicket .tinymce').each(function(index) {
                        eval(' $(\"#formTicket #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formTicket select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formTicket\").find(\"[s='d']\").serializeArray();
                        $('#formTicket select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formTicket\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/TicketAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formTicket #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formTicket #formChangedTicket').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formTicket #saveTicket').unbind('click.saveTicket');
                $('#formTicket #saveTicket').remove();";
        }
        
        if($dataObj == null){
            $this->Ticket['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Ticket();
            $this->Ticket['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }


        
        
        
        
        
        
        

            $this->fields['Ticket']['IdTicket']['html'] = stdFieldRow(_("Numéro de ticket"), $dataObj->getIdTicket(), 'IdTicket', "", @$this->commentsIdTicket, @$this->commentsIdTicket_css, '', ' ','no','');

            $this->fields['Ticket']['Author']['html'] = stdFieldRow(_("Auteur"), input('text', 'Author',str_replace('"','&quot;',$dataObj->getAuthor()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Auteur'))."' size='69'  v='AUTHOR' s='d' class=''")."", 'Author', "", @$this->commentsAuthor, @$this->commentsAuthor_css, '', ' ','no','');

            $this->fields['Ticket']['Project']['html'] = stdFieldRow(_("Projet"), input('text', 'Project',str_replace('"','&quot;',$dataObj->getProject()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Projet'))."' size='69'  v='PROJECT' s='d' class=''")."", 'Project', "", @$this->commentsProject, @$this->commentsProject_css, '', ' ','no','');

            $this->fields['Ticket']['Date']['html'] = stdFieldRow(_("Date d'ouverture"), input('date', 'Date', $dataObj->getDate(), "  otherTabs=1 j='date' placeholder='YYYY-MM-DD' size='10' otherTabs=1  s='d' class=''"), 'Date', "", @$this->commentsDate, @$this->commentsDate_css, '', ' ','no','');

            $this->fields['Ticket']['Online']['html'] = stdFieldRow(_("Status"), selectboxCustomArray('Online', array( '0' => array('0'=>_("Ouvert"), '1'=>'Ouvert'),'1' => array('0'=>_("Fermé"), '1'=>'Fermé'), ), "", "s='d' otherTabs=1  ", $dataObj->getOnline()), 'Online', "", @$this->commentsOnline, @$this->commentsOnline_css, '', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->Ticket['request']['ChildHide']) ){
            
            $ongletTab['0']['t'] = _('Conversation');
            $ongletTab['0']['p'] = 'TicketChat';
            $ongletTab['0']['lkey'] = 'IdTicket';
            $ongletTab['0']['fkey'] = 'IdTicket';
        if(!empty($ongletTab) and $dataObj->getIdTicket()){
            foreach($ongletTab as $value){
                if($_SESSION[_AUTH_VAR]->hasRights('Ticket'.$value['p'], 'r')){
                    
                    $getLocalKey = "get".$value['lkey']."";
                    if($dataObj->$getLocalKey()){
                        @$ChildOnglet .= 
                            li(
 htmlLink(_($value['t']),'javascript:',"p='".$value['p']."' act='list' j=conglet_Ticket ip='".$dataObj->$getLocalKey()."' class='ui-corner-top ui-state-default' ") 						,"  class='".@$class_has_child."' j=sm  ");
                    }
                }
            }
            if(!empty($ChildOnglet)){
                $childTable['onReadyJs'] ="
                    $('[j=conglet_Ticket]').unbind('click');
                    $('[j=conglet_Ticket]').bind('click', function (data){
                         pp = $(this).attr('p');
                         $.post('"._SITE_URL."mod/act/TicketAct.php', {a:'get'+pp+'List', ip:$(this).attr('ip'), ui:  pp+'Table','pui':'".$uiTabsId."',pushPGet:'".json_encode($_GET)."',pushPPOST:'".json_encode($_POST)."'}, function(data){
                            $('#cntTicketChild').html(data).show();;
                            $('[j=conglet_Ticket]').parent().attr('class','ui-corner-top ui-state-default');
                            $('[j=conglet_Ticket][p=\"'+pp+'\"]').parent().attr('class','ui-corner-top ui-state-default ui-state-active');
                         });
                    });

                ";
                if(@$_SESSION['memoire']['onglet']['Ticket']['child']['list'][$dataObj->$getLocalKey()]){
                    $onglet_p = $_SESSION['memoire']['onglet']['Ticket']['child']['list'][$dataObj->$getLocalKey()];
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Ticket][p=".$onglet_p."]').first().click();";
                }else{
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Ticket]').first().click();";
                }


            }
        }
        }
        
        
        if($dataObj->getIdTicket()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'TicketControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = 
            div(
                input('checkbox','toggle-form',' p="Ticket" ')
                .label(span(_('Afficher/Cacher le formulaire')),'for="toggle-form"')
            ,'','class="toggle-form" p="Ticket" data-tooltip="'._('Cacher le formulaire').'"');
            }

        }
        
        
        $titre_form_str = '';
        if($dataObj->getIdTicket()){
                   $titre_form_str .= span(strip_tags(_($dataObj->getIdTicket()))," data-name='id_ticket' ");
                   $this->siteTitle =set_var($this->siteTitle,strip_tags(_($dataObj->getIdTicket())),' ',false,NULL,false,true);}
        $this->formTitle = p(href("Ticket",_SITE_URL.'Ticket').$titre_form_str, 'class="breadcrumb"'); 
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addTicket_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveTicket',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedTicket','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdTicket', $dataObj->getIdTicket(), " otherTabs=1 s='d' pk").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'TicketControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formTicket');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['Ticket']['tog']) and 
            $_SESSION['memoire']['onglet']['Ticket']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['Ticket']['Start']['html']
                
                .
$this->fields['Ticket']['IdTicket']['html']
.$this->fields['Ticket']['Author']['html']
.$this->fields['Ticket']['Project']['html']
.$this->fields['Ticket']['Date']['html']
.$this->fields['Ticket']['Online']['html']
                
                .@$this->fields['Ticket']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntTicket", "class='divStdform' CntTabs=1 ")
        , "id='formTicket' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Ticket"); }
        # if not new, show child table
        if($dataObj->getIdTicket()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelTicket', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntTicketChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['Ticket']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['Ticket']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['Ticket']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    bind_close_form();
    
    ".$jqueryDatePicker."
    bind_ui_active('Ticket');
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
     setTimeout(function(){ bind_othertabs_std('#divCntTicket');},500); 
    ".$toggleForm."
    bind_form('Ticket','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
            
        $this->fieldsRo['Ticket']['IdTicket']['html'] = stdFieldRow(_("Numéro de ticket"), input('text','IdTicket',$dataObj->getIdTicket()," readonly s='d'"), 'IdTicket', "", @$this->commentsIdTicket, @$this->commentsIdTicket_css, 'readonly', ' ','no','');
$this->fieldsRo['Ticket']['Author']['html'] = stdFieldRow(_("Auteur"), input('text','Author',$dataObj->getAuthor()," readonly s='d'"), 'Author', "", @$this->commentsAuthor, @$this->commentsAuthor_css, 'readonly', ' ','no','');
$this->fieldsRo['Ticket']['Project']['html'] = stdFieldRow(_("Projet"), input('text','Project',$dataObj->getProject()," readonly s='d'"), 'Project', "", @$this->commentsProject, @$this->commentsProject_css, 'readonly', ' ','no','');
$this->fieldsRo['Ticket']['Date']['html'] = stdFieldRow(_("Date d'ouverture"), input('text','Date',$dataObj->getDate()," readonly s='d'"), 'Date', "", @$this->commentsDate, @$this->commentsDate_css, 'readonly', ' ','no','');
$this->fieldsRo['Ticket']['Online']['html'] = stdFieldRow(_("Status"), input('text','Online',$dataObj->getOnline()," readonly s='d'"), 'Online', "", @$this->commentsOnline, @$this->commentsOnline_css, 'readonly', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['Ticket'] as $field=>$ar){
                $this->fields['Ticket'][$field]['html'] = $this->fieldsRo['Ticket'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['Ticket'][$field]['html'] = $this->fieldsRo['Ticket'][$field]['html'];
            }
        }
    }
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = TicketQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdTicket'));
            
        
        }else{
            $q->select(array('Name', 'IdTicket'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = TicketQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdTicket'));
            
        
        }else{
            $q->select(array('Name', 'IdTicket'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Ticket')), $selected);
        }


        return $return;
    }	#@#############
    #	getChildList
    ###############
    public function getTicketChatList($IdTicket, $page='1', $uiTabsId='TicketChatTableCntnr', $parentContainer='', $mja_list='', $search='', $params = ''){
        /*init var*/
        global $request;
        if(empty($page)){$page=1;}$param=array();
        if(!empty($_SESSION['memoire']['onglet']['TicketTicketChat']['pg'])){$page = $_SESSION['memoire']['onglet']['TicketTicketChat']['pg'];}
        if(!empty($search['order'])){$this->searchOrder = $search['order'];}
        
        if(empty($search['ms'])){ $searchAr =$search;}else{$this->searchMs = $search['ms']; }

        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    @$child_order .="
                        $(\"#cntTicketChild [th='sorted'][c='".$col."'],#cntTicketChild [th='sorted'][rc='".$col."']\").attr('sens','".$sens."');
                        $(\"#cntTicketChild [th='sorted'][c='".$col."'],#cntTicketChild [th='sorted'][rc='".$col."']\").attr('order','on');
                    ";
                }
            }
        }
        
        if($parentContainer == 'editDialog'){$diagNoClose = "diag:\"noclose\", ";$diagNoCloseEscaped = "diag:\\\"noclose\\\", ";}
        if(isset($this->Ticket['request']['noHeader']) && $this->Ticket['request']['noHeader'] == 'true'){$noHeader = "'noHeader':'true',";}
        $data['IdTicket'] = $IdTicket;

        $dataObj = TicketQuery::create()->findPk($IdTicket);
        if($dataObj == null){$dataObj = new Ticket();$dataObj->setIdTicket($IdTicket);}
        $this->dataObj =$dataObj;
        

        $this->TicketChat['list_add'] = "
        $('#addTicketChat').click(function(){
            $.post('"._SITE_URL."mod/act/TicketChatAct.php', {a:'edit', ui:'editDialog',pc:'Ticket', je:'TicketChatTableCntnr', jet:'tr', tp:'TicketChat', ip:'".$IdTicket."'},
                function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); $('#editDialog').dialog('option','title','".addSlashes(_('Conversation'))."'); });
        });";
        $this->TicketChat['list_delete'] = "
        $(\"[j='deleteTicketChat']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Conversation'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."','$.post(\""._SITE_URL."mod/act/TicketChatAct.php\", {".@$diagNoCloseEscaped.@$diagNoClose." a:\"delete\", ui:\"".$uiTabsId."\", i:'+$(this).attr('i')+', ip:\"".$IdTicket."\", pc:\"Ticket\", je:\"TicketChatTableCntnr\", jet:\"tr\"}, function(data){ if(data)$(\"#TicketChatTableCntnr\").append(data);});');
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('TicketTicketChat', 'r')){ $this->TicketChat['list_edit'] = "
        $(\"#TicketChatTable[listchild=1] tr[ecf=1] td[j='editTicketChat']\").bind('click', function (){
            
        $.post('"._SITE_URL."mod/act/TicketChatAct.php',
                {a:'edit', i:$(this).attr('i'), ip:'".$IdTicket."', ui:'editDialog',pc:'Ticket', je:'TicketChatTableCntnr', jet:'tr', 'it-pos':$(this).data('iterator-pos') },
            function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";}
        $rigthButtonAction="";
        if($_SESSION[_AUTH_VAR]->hasRights('TicketTicketChat', 'w')){
            $rigthButtonAction='';
        }
        $filterKey = $IdTicket;
        
        $maxPerPage = (!empty($this->TicketChat['request']['maxperpage']))?$this->TicketChat['request']['maxperpage']:_paging_nbr_per_page;
        try{
            $q = TicketChatQuery::create();
            
            
            $q ->filterByIdTicket( $filterKey );;  
        if(!empty($this->searchOrder)){
            $alphabet = range('A', 'Z');$aNumber=1;
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $tOrd = explode('.',$col);
                    if(!empty($tOrd[2])){
                        $orderByCnt = "use".$tOrd[0]."Query";
                        $orderBy = "use".$tOrd[1]."Query";
                        $q->$orderByCnt('','left join')->$orderBy($alphabet[$aNumber],Criteria::LEFT_JOIN)->orderBy($alphabet[$aNumber].".".$tOrd[2],$sens)->endUse()->endUse();
                        $aNumber++;
                    }else if(!empty($tOrd[1])){
                        $orderBy = "use".$tOrd[0]."Query";
                        $q->$orderBy('','left join')->orderBy($tOrd[1],$sens)->endUse();
                    }else{
                        $q->orderBy($col,$sens);
                    }
                }
            }
        } 
            $this->queryObj = $q;
            
            $pmpoData =$q->paginate($page, $maxPerPage);
            $resultsCount = $pmpoData->getNbResults();

        } catch (Exception $e) { /* echo 'Exception reçue : ',  $e->getMessage(), "<br>";*/ }
        
        
        
        
        
        
        if(isset($this->Ticket['request']['noHeader']) && $this->Ticket['request']['noHeader'] == 'true'){
            $header_search = "";
        }else{
            $header_search = ''
        .div(
            
            form('' , " CntTabs=1 id='formMsTicketChat'")
        ,'',' class="msSearchCtnr"')
        .div($rigthButtonAction, '', 'class="ac-right-action-buttons"')
        .button(span(_("Afficher le menu"),'data-tooltip="'.addslashes("Afficher le menu").'" '),'class="toggle-child-nav-btn"');
        }
        
        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('TicketTicketChat', 'd') and empty($this->readOnlyFilter)){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( @$this->cCmoreColsHeaderFirstTicketChat.th(_("Auteur"), " th='sorted'  rcColone='Author' c='Author'  ").th(_("Message"), " th='sorted'  rcColone='Message' c='Message'  ").$this->cCmoreColsHeaderTicketChat.$actionRowHeader, " ln='TicketChat' class=''");
        $i=0;
        if(empty($pmpoData) || !method_exists($pmpoData,'isEmpty')){
            @$tr .= tr(	td(p(span(_("Une erreur est survenue veuillez vider votre recherche.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='TicketChat' colspan='100%' "));
            
        }else if( $pmpoData->isEmpty() ){
            @$tr .= tr(	td(p(span(_("Aucun enregistrement pour le moment.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='TicketChat' colspan='100%' "));
            
        }else{
            
            foreach($pmpoData as $data){
                
                
                $actionRow = '';
                
                $this->ListActionRowTicketChat = (!empty($this->cCListActionRowTicketChat))?str_replace('%idpk%', json_encode($data->getPrimaryKey()), $this->cCListActionRowTicketChat):$this->ListActionRowTicketChat;
                $this->ListActionRowTicketChat = (!empty($this->cCListActionRowTicketChat))?str_replace('%i%', $i, $this->ListActionRowTicketChat):$this->ListActionRowTicketChat;
                
                if($_SESSION[_AUTH_VAR]->hasRights('TicketTicketChat', 'd') and empty($this->readOnlyFilter) ){$actionRow = htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteTicketChat' i='".json_encode($data->getPrimaryKey())."'");}
                
                
                
                

                $actionRow = $actionRow;
                $addClass='';
                $cnt= substr_count($actionRow,'<a');
                if($cnt){ $addClass=' actionrow'.$cnt;}
                $actionRow = (!empty($actionRow))?td($this->ListActionRowTicketChat.$actionRow," class='actionrow ".$addClass."'"):"";
                
                
                
                ;
                
                if(isset($this->search['highlight']) && is_array($this->search['highlight'])){
                    $highlight = (in_array(json_encode($data->getPrimaryKey()), $this->search['highlight']))?'highlight':'';
                }
                
                $child_edit_columns_filter ="1";
    
                @$tr .= 
                        tr(
                            @$cCmoreColsTicketChatFirst.
                            td(span(strip_tags((isset($altValue['Author']) and $altValue['Author'])?$altValue['Author']:$data->getAuthor()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Auteur").":\" j='editTicketChat'  i='".json_encode($data->getPrimaryKey())."' c='Author'  ")
                            .td(span(strip_tags((isset($altValue['Message']) and $altValue['Message'])?$altValue['Message']:mb_substr(strip_tags($data->getMessage()),0,50, 'UTF-8')." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Message").":\" j='editTicketChat'  i='".json_encode($data->getPrimaryKey())."' c='Message'  ")
                            .
                            
                            @$cCmoreColsTicketChat.
                            @$actionRow
                        ,"id='TicketChatRow".$data->getPrimaryKey()."' data-id='".$data->getPrimaryKey()."' data-pc-table='Ticket' data-table='TicketChat' data-edit='Conversation #".$data->getPrimaryKey()."' ecf='".$child_edit_columns_filter."' ln='TicketChat' class=' ".@$highlight.@$param['class']."'  ")
                        ;
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(div(@$total_child,'','class="nolink"')
                            ,'trTicketChat'," style='".@$hide_TicketChat."' ln='TicketChat' class=''").@$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    
    if(($_SESSION[_AUTH_VAR]->hasRights('TicketTicketChat', 'a')) ){
        $add_button_child =htmlLink(span(_("Ajouter")), "Javascript:","id='addTicketChat' class='button-link-blue add-button'");
    }
    
    
    //@PAGINATION
    if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
        $ext = '';
        $table_name = 'conversation';
        if($resultsCount > 1 AND substr($table_name, -1) != 's') { $ext = 's'; }

        if($pmpoData->haveToPaginate()){
            $pages = $pmpoData->getLinks();
            if(!$page or !is_numeric($page)){$page=1;}

            $pagerRow =
                div(
                    p(span(_paging_nbr_per_page).' '._('par page').' - '.span($resultsCount).' '._('Résultat(s)'))
                    .div(
                        href(span(_('Précédent')),'#',"class='prev' data-direction='prev'")
                        .input('text','page',$page,'data-total="'.$pmpoData->getLastPage().'"')
                        .p('/ '.$pmpoData->getLastPage())
                        .href(span(_('Suivant')),'#',"class='next' data-direction='next'")
                    ,'','id="TicketChatPagination"')
                ,'',"class='pagination-wrapper' ");
        }else{
            $pagerRow =
                div(
                    p(span($resultsCount).' '._('résultat(s)'))
                ,'',"class='pagination-wrapper'");
        }
    }
    if(!empty($this->readOnlyFilter)){
        $add_button_child="";
    }
    
    if(!empty($this->CcEval)){eval($this->CcEval);}
    
    $return['html'] =
            div(
                 $this->CcToTicketChatListTop
                .div(
                    
        div(
            div(
                $add_button_child
                
            ,'',' class="ac-left-action-buttons" ')
            .$header_search
        , '' ,'class="ac-list-form-header-child"').
                    div(
                        div(
                            div(
                                table(	thead($header)
                                    .$tr
                                    .$this->CcToTicketChatTableFooter
                                , "id='TicketChatTable' listchild=1 class='tablesorter'")
                            , 'formTicketChat')
                            .$this->CcToTicketChatListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list contentHolderList" ')

                    .@$pagerRow
                ,'TicketChatListForm')
            ,'cntTicketChatdivChild',' class="" ');
            
            
            $jqueryDatePickerChild = "beforeDatePicker('');";
            @$return['js'] .= "
                
                
            ";
            $return['onReadyJs'] =
                @$this->CcToTicketChatListJsFirst
                .$this->TicketChat['list_add']
                .$this->TicketChat['list_delete']
                .$this->TicketChat['list_edit']
            ."
                
                
            ".@$total_child_js."
            
            
            
            child_button_bind('TicketChat');
            child_pagination_bind('TicketChat','Ticket','".$uiTabsId."','".$IdTicket."','','".$this->CcToSearchMsPost."');
            child_pagination_sorted_bind('TicketChat','Ticket','".$uiTabsId."','".$IdTicket."','".$this->CcToSearchMsPost."');
               
            $('#cntTicketChild .js-select-label').SelectBox();
            
            ".@$child_order."
            
            
            ".$jqueryDatePickerChild."
            ";
            $return['onReadyJs'] .= "".$this->CcToTicketChatListJs;
            return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'TicketAct.php';
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
        # child list
        $this->cCmoreColsHeaderTicketChat = '';
        $this->ListActionRowTicketChat = '';
        $this->cCmoreColsTicketChat = '';
        $this->CcToTicketChatTableFooter = '';
        $this->CcToTicketChatListTop = '';
        $this->CcToTicketChatListBottom = '';
        $this->CcToTicketChatListJs = '';
        
    }

    
}
