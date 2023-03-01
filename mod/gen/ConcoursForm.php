<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'Concours' table.
 *
 */
class ConcoursForm extends Concours{
public $tableName="Concours";
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
        $q = ConcoursQuery::create();
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
                if(isset($this->searchMs['Date']) and $this->searchMs['Date'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Date']) and strpos($this->searchMs['Date'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Date'] != '%DoNothing%' AND $this->searchMs['Date'][0] != '%DoNothing%'){
                        $q ->filterByDate($this->searchMs['Date'],$criteria);
                    }
                }
                if(isset($this->searchMs['Online']) and $this->searchMs['Online'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Online']) and strpos($this->searchMs['Online'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Online'] != '%DoNothing%' AND $this->searchMs['Online'][0] != '%DoNothing%'){
                        $q ->filterByOnline($this->searchMs['Online'],$criteria);
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
        
         $q->groupBy('IdConcours');
        
        $this->pmpoData =  $q;
        //echo $q->toString();
        //$q->paginate($page, $maxPerPage);
        return $this->pmpoData;
    }
    public function getListHeader($act){
        switch($act){
            case 'head':
            ###### TH
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Identifiant"), " th='sorted'  rcColone='Title' c='Title'  ").th(_("Valeur"), " th='sorted'  rcColone='Price' c='Price'  ").th(_("Date du tirage"), " th='sorted'  rcColone='Date' c='Date'  ").th(_("En ligne"), " th='sorted'  rcColone='Online' c='Online'  ").th(_("Ordre d'affichage"), " th='sorted'  rcColone='Order' c='Order'  "). $this->cCmoreColsHeader;
                if(empty($this->search['Autoc']['SelList']) and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                    $trHead .= th('&nbsp;',' class="actionrow delete" ');
                }
                $trHead = thead(tr($trHead));/*semble plus utilisé.$trHeadMod*/
                return $trHead;
            break;
            case 'list-button':
                $listButton = '';
                
                
            if($_SESSION[_AUTH_VAR]->hasRights('Concours', 'b')){ $modMass = button(_('Bulk update'),'id="bulkUpdateForm" class="ac-button ac-light-red"');}
            if($_SESSION[_AUTH_VAR]->hasRights('Concours', 'r')){ $suppMass = button(_('Supprimer'),' id="del_all" class="ac-button ac-light-red"');}
            if($_SESSION[_AUTH_VAR]->hasRights('Concours', 'r') or $_SESSION[_AUTH_VAR]->hasRights('Concours', 'r') ){
                $cocherTous = 
                    input('checkbox','mass-action-Concours')
                    .label(_('Décocher/Cocher'),'for="mass-action-Concours"');
            }
            $listButton .=  $cocherTous.$modMass.$suppMass;
        
                return $listButton;
            break;
            case 'search':
                ###### SEARCH
                $array_search_tb = array('Title','Date','Online');
                
                unset($data);$data['Title'] = (!empty($this->searchMs['Title']))?$this->searchMs['Title']:'';
        $data['Date'] = (!empty($this->searchMs['Date']))?$this->searchMs['Date']:'';
        $data['Online'] = (!empty($this->searchMs['Online']))?$this->searchMs['Online']:'';
        
                
        @$this->fieldsSearch['Concours']['Title'] = div(input('text', 'Title', $this->searchMs['Title'], ' othertabs=1  placeholder="'._('Nom').'"',''),'','class="ac-search-item ms-Title"');
        @$this->fieldsSearch['Concours']['Date'] = div(input('text', 'Date', $this->searchMs['Date'], ' othertabs=1  j="date"  placeholder="'._('Date du tirage').'"',''),'','class="ac-search-item ms-Date"');
        @$this->fieldsSearch['Concours']['Online'] =div(selectboxCustomArray('Online', array( '0' => array('0'=>_("Oui"), '1'=>'Oui'),'1' => array('0'=>_("Non"), '1'=>'Non'), ), _('En ligne'), '  size="1" t="1"   ', $this->searchMs['Online']), '', '  class=" ac-search-item ms-Online"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msConcoursAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['Concours']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msConcoursBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msConcoursBtClear" class="icon clear"')
               .@$this->fieldsSearch['Concours']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['Concours']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-ConcoursSearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['Concours']['Start'].
                    $this->fieldsSearch['Concours']['Title'].
                    $this->fieldsSearch['Concours']['Date'].
                    $this->fieldsSearch['Concours']['Online'].
                @$this->fieldsSearch['Concours']['End'].
            $this->fieldsSearch['Concours']['Button']
            ,"id='formMsConcours' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('Concours', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."Concours/edit/", "id='addConcours' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addConcoursAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Concours");
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
        if(!empty($_SESSION['memoire']['onglet']['Concours']['pg'])){
            $page = $_SESSION['memoire']['onglet']['Concours']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'ConcoursAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'ConcoursAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
            $search_child_default['Order']='ASC';
        if(empty($this->searchOrder)){$this->searchOrder = $search_child_default;}
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#ConcoursListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#ConcoursListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
            
                $CheckAction = 
            input('checkbox','check_'.$data->getPrimaryKey(),$data->getPrimaryKey()," i='".json_encode($data->getPrimaryKey())."' class='hand checkbox' j='check_multi_Concours' ").label(span(''),' j="check_multi_label_Concours" for="check_'.$data->getPrimaryKey().'"')
        ;
                if(!$_SESSION[_AUTH_VAR]->hasRights('Concours', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('Concours', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('Concours', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteConcours' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
                
                
                
                 $titreRaccour =''; $titreRaccour .= _('Concours');
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['Title']) and $altValue['Title'])?$altValue['Title']:$data->getTitle()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Identifiant").":\" j='editConcours'  i='".json_encode($data->getPrimaryKey())."' c='Title'  ")
                            .td(span(strip_tags((isset($altValue['Price']) and $altValue['Price'])?$altValue['Price']:$data->getPrice()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Valeur").":\" j='editConcours'  i='".json_encode($data->getPrimaryKey())."' c='Price'  ")
                            .td(span(strip_tags((isset($altValue['Date']) and $altValue['Date'])?$altValue['Date']:$data->getDate()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Date du tirage").":\" j='editConcours'  i='".json_encode($data->getPrimaryKey())."' c='Date'  ")
                            .td(span(strip_tags((isset($altValue['Online']) and $altValue['Online'])?$altValue['Online']:isntPo($data->getOnline())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("En ligne").":\" j='editConcours'  i='".json_encode($data->getPrimaryKey())."' c='Online'  ")
                            .td(span(strip_tags((isset($altValue['Order']) and $altValue['Order'])?$altValue['Order']:$data->getOrder()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Ordre d'affichage").":\" j='editConcours'  i='".json_encode($data->getPrimaryKey())."' c='Order'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='ConcoursRow".$data->getPrimaryKey()."'
                    data-table='Concours' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountConcours', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Concours';

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
                            ,'','id="ConcoursPagination"')
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
                .div($controlsContent.$this->CcCustomControl,'ConcoursControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='ConcoursTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'ConcoursListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#ConcoursListForm [j='deleteConcours']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Concours'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msConcoursBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msConcoursBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#ConcoursListForm tr[ecf=1] td[j='editConcours']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."Concours/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."Concours/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Concours'
                ,'IdConcours'
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
        $(\"#ConcoursListForm [j='deleteConcours']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Concours'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msConcoursBt\').length>0){ $(\'#msConcoursBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'ConcoursTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntConcoursListForm #addConcours').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'ConcoursTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#ConcoursListForm tr[ecf=1] td[j='editConcours']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'ConcoursTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Concours'
                ,'IdConcours'
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
        pagination_bind('Concours','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#ConcoursListForm [j='deleteConcours']\").unbind('click');
        $('#ConcoursListForm #addConcours').unbind('click');
        $(\"#ConcoursListForm tr[ecf=1] td[j='editConcours']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#ConcoursListForm [j='button']\").unbind();   
        pagination_sorted_bind('Concours','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('Concours','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('Concours','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        bind_masse_action('Concours','');
                $('#del_all').click(function (){
                    if( $('[j=check_multi_Concours]:checked').length > 0 ){
                        $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Concours'))."');confirm('".addslashes(message_label('supp_ces_entrers'))."',function (){ $.post('"._SITE_URL."mod/act/ConcoursAct.php', {a:'del_all_Concours',i:$('[j=check_multi_Concours]:checked').serialize(),ui:'".$parentContainer."' }, function (data){ if(data){ $('#tabsContain').append(data)}else{ $.post('"._SITE_URL."mod/act/".$this->ajaxPageActParent."', {a:'list', ui:'".$uiTabsId."'".$variableAutoc."}, function(data){ $('#".$uiTabsId."').html(data); $(window).resize(); }); } });});
                    }else{
                        $('#ui-dialog-title-alertDialog').html('"._('Attention')."');
                        $('#alert_texte').html('"._('Cocher au moins une ligne a supprimer.')."');
                        beforeOpenDialog('alertDialog');
                    }
                });

            
        
        
        
        
        
        
        
        bulk_update_bind('Concours');
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_Concours($data){

        unset($data['IdConcours']);
        $e = new Concours();
        
        
        if(!@$data['Online']){$data['Online'] = "Oui";} 
        if(isset($data['Order'])){$e->setOrder(($data['Order']=='')?null:$data['Order']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setUrl(($data['Url']=='')?null:$data['Url']);
        $e->setDate( ($data['Date'] == '' || $data['Date'] == 'null' || substr($data['Date'],0,10) == '-0001-11-30')?date('Y-m-d'):$data['Date'] );
        $e->setOrder(($data['Order']=='')?null:$data['Order']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_Concours($data){

        
        $e = ConcoursQuery::create()->findPk(json_decode($data['i']));
        
        
        if(!@$data['Online']){$data['Online'] = "Oui";} 
        if(isset($data['Order'])){$e->setOrder(($data['Order']=='')?null:$data['Order']);}
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
     * Produce a formated bulk add form of Concours
     * List existing elements to be added in bulk
     * @param	string $id			PrimaryKey of the record to show
     * @param	string $uiTabsId	Present everywhere, javascript id of the html container
     * @param	string $data 		If present, will skip the query and show the data
     * @param	array $error			Error to display
     * @param	array $jsElement		container to append new event results
     * @param	array $jsElementType	container type to append new event results
     * @return	array standard html retrun array
    */
    function bulkUpdateForm( $data='', $uiTabsId= "editDialog", $params=''){
        
        $return['html'] =
        $this->CcToFormTop
        .form(
            div(
                
                
                table(
                    thead(tr(
                            th(b(_("Champs")))
                            .th(b(_("Valeur")))
                            .th(b(_("Changer ou non")))
                         ))
                            .
                                tr(
                                    td(_("En ligne")," ")
                                    .td(selectboxCustomArray('Online', array( '0' => array('0'=>_("Oui"), '1'=>'Oui'),'1' => array('0'=>_("Non"), '1'=>'Non'), ), "", "s='d' otherTabs=1  ", $data['Online']) ."" .@$this->commentsOnline, "  class='clinlineform'  in='inOnline'")
                                    .td(input('checkbox', 'ck_Online', 'up', "j='ck_bulkUP' i='".$phpName."' otherTabs=1 s='d'").label('','for="ck_Online"'), " class='clinlineform-checkbox' ")
                                ,"    " )
                ,' class="tablesorter" ').
                div(div( input('button', 'saveConcours', _('Sauvegarder'), ' act="save" class="button-link-blue"')
                            .input('hidden', 'idPk', urlencode($data['i']), "s='d'")
                    ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut bulk-update' ")
            ,"divCntBuConcours", "class='ac-list' CntTabs=1 ")
        , "id='formBuConcours' class='mainForm' ")
        .$this->CcToFormBottom;
      
        $jqueryDatePicker = "beforeDatePicker('#divCntBuConcours');";
        $return['js'] = "
            
        ";
        $return['onReadyJs'] = @$this->CcToFormJsFirst.$jqueryDatePicker."
            $('#formBuConcours .tinymce').each(function() {
                if (!CKEDITOR.instances[$(this).attr('Id')]){
                    ckeTemp = CKEDITOR.replace($(this).attr('Id'), { extraAllowedContent: '*(*)[*];sup(*)[*];article(*)[*];section(*)[*];div(*)[*];span(*)'});
                    ckeTemp.on( 'change', function( evt ) { $('.divtd input[type=\"button\"]').addClass('can-save');});
                }
            });
            $('#divCntBuConcours .js-select-label').SelectBox();
             setTimeout(function(){ bind_othertabs_std('#divCntBuConcours');},500); 
        $(\"#formBuConcours [s='d'],#formBuConcours .js-select-label,#formBuConcours [j='autocomplete']\")
            .bind('change.formBuConcours keypress.formBuConcours', function (data){
                $(this).removeClass('error_field');
                $(this).parent('.js-select-label').children('.select-label-span').removeClass('error_field');
                $('#formBuConcours #saveConcours').addClass('can-save');
                $('#formBuConcours #formChangedConcours').val('unsaved');
        });

        $('#formBuConcours [data-group=addChildPopup]').hide();
        $('#formBuConcours [s=d]').not('[j=ck_bulkUP]').unbind('change.bulkUP');
        
        $('#formBuConcours [s=d]').not('[j=ck_bulkUP]').unbind('change.bulkUP');
        $('#formBuConcours [s=d]').not('[j=ck_bulkUP]').bind('change.bulkUP',function (){
            $('#ck_'+$(this).attr('id')).attr('checked', 'checked');
        });
        
        $('#formBuConcours #saveConcours').unbind('click.saveBu');
        $('#formBuConcours #saveConcours').bind('click.saveBu', function (data){
            
            $('#formBuConcours .tinymce').each(function(index) {
                eval(' $(\"#formBuConcours #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
            });

            $('body').css('cursor', 'progress');
            $('#formBuConcours #saveConcours').css('cursor', 'progress');
            $.post('"._SITE_URL."mod/act/ConcoursAct.php',
                    {'a':'BUsave',d:$(\"#formBuConcours [s='d']\").serialize(), ui:'".$uiTabsId."' ".$ip_save.", dialog:'".$dialog."'},function(data){
                        if(data['ok'] == 'ok'){
                            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'list', highlight:data['updated'],  ui: 'tabsContain'".$variableAutoc.",ms:$(\"#formMsConcours\").serialize() ".$this->CcToSearchMsPost."},
                                function(data){
                                    $('body').css('cursor', 'default');
                                    $('#formBuConcours #saveConcours').css('cursor', 'default');
                                    $('#".$uiTabsId."').dialog('close');
                                    $('#ConcoursListForm').parent().html(data);
                                    $(window).resize();
                                    $('#formMsConcours input[type=text]').first().focus();
                                    $('#formMsConcours input[type=text]').first().putCursorAtEnd();
                                });
                        }
                    }, 'json');
        });
        ".@$this->CcToFormJs;
        return $return;
    }
    
    /**
     * Produce a formated form of Concours
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
        $je= "ConcoursTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['Concours']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['Concours']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addConcours_child').bind('click.addConcours', function (){
                    $.post('"._SITE_URL."mod/act/ConcoursAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addConcours_child').bind('click.addConcours', function (){
                document.location= '"._SITE_URL."Concours/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = ConcoursQuery::create();
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Concours', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Concours','w',$dataObj)) 
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
                    $('#formConcours #saveConcours').removeAttr('disabled');
                    $('#formConcours #saveConcours').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formConcours #saveConcours').css('cursor', 'default');
                    if($('#formConcours #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formConcours #saveConcours').bind('click.saveConcours', function (data){
                    $('#formConcours #saveConcours').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formConcours #saveConcours').css('cursor', 'progress');
                    $('#formConcours #saveConcours').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formConcours .tinymce').each(function(index) {
                        eval(' $(\"#formConcours #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formConcours select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formConcours\").find(\"[s='d']\").serializeArray();
                        $('#formConcours select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formConcours\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/ConcoursAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formConcours #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formConcours #formChangedConcours').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formConcours #saveConcours').unbind('click.saveConcours');
                $('#formConcours #saveConcours').remove();";
        }
        
        if($dataObj == null){
            $this->Concours['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Concours();
            $this->Concours['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }

try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new ConcoursI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addConcoursI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new ConcoursI18n();$mt->setLocale('en_US')->setText('');$dataObj->addConcoursI18n($mt)->save();}

        
        
        
        
        
        
        

            $this->fields['Concours']['Title']['html'] = stdFieldRow(_("Identifiant"), input('text', 'Title',str_replace('"','&quot;',$dataObj->getTitle()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Identifiant'))."' size='69'  v='TITLE' s='d' class=''")."", 'Title', "", @$this->commentsTitle, @$this->commentsTitle_css, '', ' ','no','');

            $this->fields['Concours']['Url']['html'] = stdFieldRow(_("Lien du concours"), input('text', 'Url',str_replace('"','&quot;',$dataObj->getUrl()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Lien du concours'))."' size='69'  v='URL' s='d' class=''")."", 'Url', "", @$this->commentsUrl, @$this->commentsUrl_css, '', ' ','no','');

            $this->fields['Concours']['Price']['html'] = stdFieldRow(_("Valeur"), input('text', 'Price',str_replace('"','&quot;',$dataObj->getPrice()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Valeur'))."' size='35'  v='PRICE' s='d' class=''")."", 'Price', "", @$this->commentsPrice, @$this->commentsPrice_css, '', ' ','no','');

            $this->fields['Concours']['Date']['html'] = stdFieldRow(_("Date du tirage"), input('date', 'Date', $dataObj->getDate(), "  otherTabs=1 j='date' placeholder='YYYY-MM-DD' size='10' otherTabs=1  s='d' class=''"), 'Date', "", @$this->commentsDate, @$this->commentsDate_css, '', ' ','no','');

            $this->fields['Concours']['Online']['html'] = stdFieldRow(_("En ligne"), selectboxCustomArray('Online', array( '0' => array('0'=>_("Oui"), '1'=>'Oui'),'1' => array('0'=>_("Non"), '1'=>'Non'), ), "", "s='d' otherTabs=1  ", $dataObj->getOnline()), 'Online', "", @$this->commentsOnline, @$this->commentsOnline_css, '', ' ','no','');

            $this->fields['Concours']['Order']['html'] = stdFieldRow(_("Ordre d'affichage"), input('number', 'Order',$dataObj->getOrder(), " step='10' placeholder='".str_replace("'","&#39;",_('Ordre d\'affichage'))."' v='ORDER' size='0' otherTabs=1 s='d' class='' otherTabs=1 "), 'Order', "", @$this->commentsOrder, @$this->commentsOrder_css, '', ' ','no','');

            $this->fields['Concours']['ConcoursI18n_Name_frCA']['html'] = stdFieldRow(_("Nom du concours français"), input('text', 'ConcoursI18n_Name_frCA',str_replace('"','&quot;',$dataObj->getTranslation('fr_CA')->getName()), "placeholder='".str_replace("'","&#39;",_('Nom du concours fr_CA'))."' size='69' otherTabs=1  v='CONCOURSI18N_NAME_FRCA' s='d'  class=''")."", 'ConcoursI18n_Name_frCA', "", @$this->commentsConcoursI18n_Name_frCA, @$this->commentsConcoursI18n_Name_frCA_css, '', ' ','no','');

            $this->fields['Concours']['ConcoursI18n_Text_frCA']['html'] = stdFieldRow(_("Description français"), 
        textarea('ConcoursI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText() ,"placeholder='".str_replace("'","&#39;",_('Description fr_CA'))."' cols='71' v='CONCOURSI18N_TEXT_FRCA' otherTabs=1 s='d'  class='tinymce'  class='' style='' spellcheck='false'"), 'ConcoursI18n_Text_frCA', "", @$this->commentsConcoursI18n_Text_frCA, @$this->commentsConcoursI18n_Text_frCA_css, ' istinymce', ' ','no','');

            $this->fields['Concours']['ConcoursI18n_Name_enUS']['html'] = stdFieldRow(_("Nom du concours anglais"), input('text', 'ConcoursI18n_Name_enUS',str_replace('"','&quot;',$dataObj->getTranslation('en_US')->getName()), "placeholder='".str_replace("'","&#39;",_('Nom du concours en_US'))."' size='69' otherTabs=1  v='CONCOURSI18N_NAME_ENUS' s='d'  class=''")."", 'ConcoursI18n_Name_enUS', "", @$this->commentsConcoursI18n_Name_enUS, @$this->commentsConcoursI18n_Name_enUS_css, '', ' ','no','');

            $this->fields['Concours']['ConcoursI18n_Text_enUS']['html'] = stdFieldRow(_("Description anglais"), 
        textarea('ConcoursI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText() ,"placeholder='".str_replace("'","&#39;",_('Description en_US'))."' cols='71' v='CONCOURSI18N_TEXT_ENUS' otherTabs=1 s='d'  class='tinymce'  class='' style='' spellcheck='false'"), 'ConcoursI18n_Text_enUS', "", @$this->commentsConcoursI18n_Text_enUS, @$this->commentsConcoursI18n_Text_enUS_css, ' istinymce', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->Concours['request']['ChildHide']) ){
            
            $ongletTab['0']['t'] = _('Photo');
            $ongletTab['0']['p'] = 'ConcoursFile';
            $ongletTab['0']['lkey'] = 'IdConcours';
            $ongletTab['0']['fkey'] = 'IdConcours';
        if(!empty($ongletTab) and $dataObj->getIdConcours()){
            foreach($ongletTab as $value){
                if($_SESSION[_AUTH_VAR]->hasRights('Concours'.$value['p'], 'r')){
                    
                    $getLocalKey = "get".$value['lkey']."";
                    if($dataObj->$getLocalKey()){
                        @$ChildOnglet .= 
                            li(
 htmlLink(_($value['t']),'javascript:',"p='".$value['p']."' act='list' j=conglet_Concours ip='".$dataObj->$getLocalKey()."' class='ui-corner-top ui-state-default' ") 						,"  class='".@$class_has_child."' j=sm  ");
                    }
                }
            }
            if(!empty($ChildOnglet)){
                $childTable['onReadyJs'] ="
                    $('[j=conglet_Concours]').unbind('click');
                    $('[j=conglet_Concours]').bind('click', function (data){
                         pp = $(this).attr('p');
                         $.post('"._SITE_URL."mod/act/ConcoursAct.php', {a:'get'+pp+'List', ip:$(this).attr('ip'), ui:  pp+'Table','pui':'".$uiTabsId."',pushPGet:'".json_encode($_GET)."',pushPPOST:'".json_encode($_POST)."'}, function(data){
                            $('#cntConcoursChild').html(data).show();;
                            $('[j=conglet_Concours]').parent().attr('class','ui-corner-top ui-state-default');
                            $('[j=conglet_Concours][p=\"'+pp+'\"]').parent().attr('class','ui-corner-top ui-state-default ui-state-active');
                         });
                    });

                ";
                if(@$_SESSION['memoire']['onglet']['Concours']['child']['list'][$dataObj->$getLocalKey()]){
                    $onglet_p = $_SESSION['memoire']['onglet']['Concours']['child']['list'][$dataObj->$getLocalKey()];
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Concours][p=".$onglet_p."]').first().click();";
                }else{
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Concours]').first().click();";
                }


            }
        }
        }
        
        
        if($dataObj->getIdConcours()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'ConcoursControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = 
            div(
                input('checkbox','toggle-form',' p="Concours" ')
                .label(span(_('Afficher/Cacher le formulaire')),'for="toggle-form"')
            ,'','class="toggle-form" p="Concours" data-tooltip="'._('Cacher le formulaire').'"');
            }

        }
        
        $ongletf =
            div(
                ul(li(htmlLink(_('Concours'),'#ogf_Concours',' j="ogf" p="Concours" class="ui-tabs-anchor button-link-blue" ')).li(htmlLink(_('Français'),'#ogf_Concoursi18nNameFrca',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Concours" ')).li(htmlLink(_('Anglais'),'#ogf_Concoursi18nNameEnus',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Concours" ')))
            ,'cntOngletConcours',' class="cntOnglet"')
            .@$close_form
        ;
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addConcours_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveConcours',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedConcours','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdConcours', $dataObj->getIdConcours(), " otherTabs=1 s='d' pk").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        $mceInclude = loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/ckeditor.js")
            .loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/adapters/jquery.js");
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'ConcoursControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formConcours');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['Concours']['tog']) and 
            $_SESSION['memoire']['onglet']['Concours']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['Concours']['Start']['html']
                
                .
                    '<div id="ogf_Concours">'.
$this->fields['Concours']['Title']['html']
.$this->fields['Concours']['Url']['html']
.$this->fields['Concours']['Price']['html']
.$this->fields['Concours']['Date']['html']
.$this->fields['Concours']['Online']['html']
.$this->fields['Concours']['Order']['html']
.'</div><div id="ogf_Concoursi18nNameFrca"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Concours']['ConcoursI18n_Name_frCA']['html']
.$this->fields['Concours']['ConcoursI18n_Text_frCA']['html']
.'</div><div id="ogf_Concoursi18nNameEnus"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Concours']['ConcoursI18n_Name_enUS']['html']
.$this->fields['Concours']['ConcoursI18n_Text_enUS']['html'].'</div>'
                
                .@$this->fields['Concours']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntConcours", "class='divStdform' CntTabs=1 ")
        , "id='formConcours' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Concours"); }
        # if not new, show child table
        if($dataObj->getIdConcours()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelConcours', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntConcoursChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['Concours']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['Concours']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['Concours']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    bind_close_form();
    
    ".$jqueryDatePicker."
    bind_ui_active('Concours');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    $('#formConcours .tinymce').each(function() {
        if (CKEDITOR.instances[$(this).attr('Id')]){
            CKEDITOR.instances[$(this).attr('Id')].destroy();
        }
        ckeTemp = CKEDITOR.replace($(this).attr('Id'), {
            extraAllowedContent: '*(*)[*];sup(*)[*];article(*)[*];section(*)[*];div(*)[*];span(*)'
            ".@$this->ccAddCkeditorInit."
        });
        ckeTemp.on('change',function( evt ){ $('.divtd input[type=\"button\"]').addClass('can-save');});
        ckeTemp.on('key',function( event ){ if(event.data.keyCode ==1114195){ $('form [act=save]').click(); return false;}});
    });$('#cntOngletConcours').parent().tabs();$('#cntOngletConcours').show();
    ".@$childTable['onReadyJs']."
    ".@$error['onReadyJs']."
    ".@$removeEditChild."
    /*try {afterFormLoad();}catch(e){}*/
    if($('#loader').css('display') == 'block') $('#loader').hide();
    $('[j=sftr]').hide();
    ".@$tabs_act."
    ".$this->CcToFormJs
    .@$script_autoc_one."
     setTimeout(function(){ bind_othertabs_std('#divCntConcours');},500); 
    ".$toggleForm."
    bind_form('Concours','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new ConcoursI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addConcoursI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new ConcoursI18n();$mt->setLocale('en_US')->setText('');$dataObj->addConcoursI18n($mt)->save();}
            
        $this->fieldsRo['Concours']['Title']['html'] = stdFieldRow(_("Identifiant"), input('text','Title',$dataObj->getTitle()," readonly s='d'"), 'Title', "", @$this->commentsTitle, @$this->commentsTitle_css, 'readonly', ' ','no','');
$this->fieldsRo['Concours']['Url']['html'] = stdFieldRow(_("Lien du concours"), input('text','Url',$dataObj->getUrl()," readonly s='d'"), 'Url', "", @$this->commentsUrl, @$this->commentsUrl_css, 'readonly', ' ','no','');
$this->fieldsRo['Concours']['Price']['html'] = stdFieldRow(_("Valeur"), input('text','Price',$dataObj->getPrice()," readonly s='d'"), 'Price', "", @$this->commentsPrice, @$this->commentsPrice_css, 'readonly', ' ','no','');
$this->fieldsRo['Concours']['Date']['html'] = stdFieldRow(_("Date du tirage"), input('text','Date',$dataObj->getDate()," readonly s='d'"), 'Date', "", @$this->commentsDate, @$this->commentsDate_css, 'readonly', ' ','no','');
$this->fieldsRo['Concours']['Online']['html'] = stdFieldRow(_("En ligne"), input('text','Online',$dataObj->getOnline()," readonly s='d'"), 'Online', "", @$this->commentsOnline, @$this->commentsOnline_css, 'readonly', ' ','no','');
$this->fieldsRo['Concours']['Order']['html'] = stdFieldRow(_("Ordre d'affichage"), input('text','Order',$dataObj->getOrder()," readonly s='d'"), 'Order', "", @$this->commentsOrder, @$this->commentsOrder_css, 'readonly', ' ','no','');
$this->fieldsRo['Concours']['ConcoursI18n_Name_frCA']['html'] = stdFieldRow(_("Nom du concours français"), input('text','ConcoursI18n_Name_frCA',$dataObj->getTranslation('fr_CA')->getName()," readonly s='d'"), 'ConcoursI18n_Name_frCA', "", @$this->commentsConcoursI18n_Name_frCA, @$this->commentsConcoursI18n_Name_frCA_css, 'readonly', ' ','no','');
$this->fieldsRo['Concours']['ConcoursI18n_Text_frCA']['html'] = stdFieldRow(_("Description français"), textarea('ConcoursI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText()," readonly class='tinymce'    s='d'"), 'ConcoursI18n_Text_frCA', "", @$this->commentsConcoursI18n_Text_frCA, @$this->commentsConcoursI18n_Text_frCA_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Concours']['ConcoursI18n_Name_enUS']['html'] = stdFieldRow(_("Nom du concours anglais"), input('text','ConcoursI18n_Name_enUS',$dataObj->getTranslation('en_US')->getName()," readonly s='d'"), 'ConcoursI18n_Name_enUS', "", @$this->commentsConcoursI18n_Name_enUS, @$this->commentsConcoursI18n_Name_enUS_css, 'readonly', ' ','no','');
$this->fieldsRo['Concours']['ConcoursI18n_Text_enUS']['html'] = stdFieldRow(_("Description anglais"), textarea('ConcoursI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText()," readonly class='tinymce'    s='d'"), 'ConcoursI18n_Text_enUS', "", @$this->commentsConcoursI18n_Text_enUS, @$this->commentsConcoursI18n_Text_enUS_css, 'readonly istinymce', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['Concours'] as $field=>$ar){
                $this->fields['Concours'][$field]['html'] = $this->fieldsRo['Concours'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['Concours'][$field]['html'] = $this->fieldsRo['Concours'][$field]['html'];
            }
        }
    }
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = ConcoursQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdConcours'));
            
        
        }else{
            $q->select(array('Name', 'IdConcours'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = ConcoursQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdConcours'));
            
        
        }else{
            $q->select(array('Name', 'IdConcours'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Concours')), $selected);
        }


        return $return;
    }	#@#############
    #	getChildList
    ###############
    public function getConcoursFileList($IdConcours, $page='1', $uiTabsId='ConcoursFileTableCntnr', $parentContainer='', $mja_list='', $search='', $params = ''){
        /*init var*/
        global $request;
        if(empty($page)){$page=1;}$param=array();
        if(!empty($_SESSION['memoire']['onglet']['ConcoursConcoursFile']['pg'])){$page = $_SESSION['memoire']['onglet']['ConcoursConcoursFile']['pg'];}
        if(!empty($search['order'])){$this->searchOrder = $search['order'];}
        
        if(empty($search['ms'])){ $searchAr =$search;}else{$this->searchMs = $search['ms']; }

        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    @$child_order .="
                        $(\"#cntConcoursChild [th='sorted'][c='".$col."'],#cntConcoursChild [th='sorted'][rc='".$col."']\").attr('sens','".$sens."');
                        $(\"#cntConcoursChild [th='sorted'][c='".$col."'],#cntConcoursChild [th='sorted'][rc='".$col."']\").attr('order','on');
                    ";
                }
            }
        }
        
        if($parentContainer == 'editDialog'){$diagNoClose = "diag:\"noclose\", ";$diagNoCloseEscaped = "diag:\\\"noclose\\\", ";}
        if(isset($this->Concours['request']['noHeader']) && $this->Concours['request']['noHeader'] == 'true'){$noHeader = "'noHeader':'true',";}
        $data['IdConcours'] = $IdConcours;

        $dataObj = ConcoursQuery::create()->findPk($IdConcours);
        if($dataObj == null){$dataObj = new Concours();$dataObj->setIdConcours($IdConcours);}
        $this->dataObj =$dataObj;
        

        $this->ConcoursFile['list_add'] = "
        $('#addConcoursFile').click(function(){
            $.post('"._SITE_URL."mod/act/ConcoursFileAct.php', {a:'edit', ui:'editDialog',pc:'Concours', je:'ConcoursFileTableCntnr', jet:'tr', tp:'ConcoursFile', ip:'".$IdConcours."'},
                function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); $('#editDialog').dialog('option','title','".addSlashes(_('Photo'))."'); });
        });";
        $this->ConcoursFile['list_delete'] = "
        $(\"[j='deleteConcoursFile']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Photo'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."','$.post(\""._SITE_URL."mod/act/ConcoursFileAct.php\", {".@$diagNoCloseEscaped.@$diagNoClose." a:\"delete\", ui:\"".$uiTabsId."\", i:'+$(this).attr('i')+', ip:\"".$IdConcours."\", pc:\"Concours\", je:\"ConcoursFileTableCntnr\", jet:\"tr\"}, function(data){ if(data)$(\"#ConcoursFileTableCntnr\").append(data);});');
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('ConcoursConcoursFile', 'r')){ $this->ConcoursFile['list_edit'] = "
        $(\"#ConcoursFileTable[listchild=1] tr[ecf=1] td[j='editConcoursFile']\").bind('click', function (){
            
        $.post('"._SITE_URL."mod/act/ConcoursFileAct.php',
                {a:'edit', i:$(this).attr('i'), ip:'".$IdConcours."', ui:'editDialog',pc:'Concours', je:'ConcoursFileTableCntnr', jet:'tr', 'it-pos':$(this).data('iterator-pos') },
            function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";}
        $rigthButtonAction="";
        if($_SESSION[_AUTH_VAR]->hasRights('ConcoursConcoursFile', 'w')){
            $rigthButtonAction='';
        }
        $filterKey = $IdConcours;
        
        $maxPerPage = (!empty($this->ConcoursFile['request']['maxperpage']))?$this->ConcoursFile['request']['maxperpage']:_paging_nbr_per_page;
        try{
            $q = ConcoursFileQuery::create();
            
            
            $q ->filterByIdConcours( $filterKey );;  
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
        
        
        
        
        
        
        if(isset($this->Concours['request']['noHeader']) && $this->Concours['request']['noHeader'] == 'true'){
            $header_search = "";
        }else{
            $header_search = ''
        .div(
            
            form('' , " CntTabs=1 id='formMsConcoursFile'")
        ,'',' class="msSearchCtnr"')
        .div($rigthButtonAction, '', 'class="ac-right-action-buttons"')
        .button(span(_("Afficher le menu"),'data-tooltip="'.addslashes("Afficher le menu").'" '),'class="toggle-child-nav-btn"');
        }
        
        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('ConcoursConcoursFile', 'd') and empty($this->readOnlyFilter)){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( @$this->cCmoreColsHeaderFirstConcoursFile.th(_("Name"), " th='sorted'  rcColone='Name' c='Name'  ").th(_("Poids"), " th='sorted'  rcColone='Size' c='Size'  ").$this->cCmoreColsHeaderConcoursFile.$actionRowHeader, " ln='ConcoursFile' class=''");
        $i=0;
        if(empty($pmpoData) || !method_exists($pmpoData,'isEmpty')){
            @$tr .= tr(	td(p(span(_("Une erreur est survenue veuillez vider votre recherche.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='ConcoursFile' colspan='100%' "));
            
        }else if( $pmpoData->isEmpty() ){
            @$tr .= tr(	td(p(span(_("Aucun enregistrement pour le moment.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='ConcoursFile' colspan='100%' "));
            
        }else{
            
            foreach($pmpoData as $data){
                
                
                $actionRow = '';
                
                $this->ListActionRowConcoursFile = (!empty($this->cCListActionRowConcoursFile))?str_replace('%idpk%', json_encode($data->getPrimaryKey()), $this->cCListActionRowConcoursFile):$this->ListActionRowConcoursFile;
                $this->ListActionRowConcoursFile = (!empty($this->cCListActionRowConcoursFile))?str_replace('%i%', $i, $this->ListActionRowConcoursFile):$this->ListActionRowConcoursFile;
                
                if($_SESSION[_AUTH_VAR]->hasRights('ConcoursConcoursFile', 'd') and empty($this->readOnlyFilter) ){$actionRow = htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteConcoursFile' i='".json_encode($data->getPrimaryKey())."'");}
                
                $imgPath = $data->getFichier()."?pc=Concours&token=".MD5(_ENCODE.$data->getPrimaryKey())."|".MD5(_ENCODE.$_SESSION[_AUTH_VAR]->get('id'));
        unset($path_parts,$fileExt);

        $childFile = explode('?',_INSTALL_PATH.$imgPath)[0];

        $imgPath = str_replace(array('#',' '),array('%23','%20'),$imgPath);

        if(is_file($childFile)){
            $path_parts = pathinfo($childFile);
            if($path_parts['extension']){ $fileExt = $path_parts['extension'];}
        }

        if(is_array(getimagesize($childFile))){
            $imgPath = img(_SITE_URL.$imgPath,40,null,' title="'._('Aperçu').'" i="'.$data->getPrimaryKey().'" ii="'.$i.'" class="thumbnail-file"');
        } else {
            $imgPath = span(@$fileExt,'class="thumbnail-ext"');
        }
        $url = _SITE_URL.$data->getFichier()."?pc=Concours&token=".MD5(_ENCODE.$data->getPrimaryKey())."|".MD5(_ENCODE.$_SESSION[_AUTH_VAR]->get('id'));
    $actionRow .= htmlLink($imgPath,$url, "  j='imageConcoursFile' i='".$data->getPrimaryKey()."' ");
                
                

                $actionRow = $actionRow;
                $addClass='';
                $cnt= substr_count($actionRow,'<a');
                if($cnt){ $addClass=' actionrow'.$cnt;}
                $actionRow = (!empty($actionRow))?td($this->ListActionRowConcoursFile.$actionRow," class='actionrow ".$addClass."'"):"";
                
                
                
                ;
                
                if(isset($this->search['highlight']) && is_array($this->search['highlight'])){
                    $highlight = (in_array(json_encode($data->getPrimaryKey()), $this->search['highlight']))?'highlight':'';
                }
                
                $child_edit_columns_filter ="1";
    
                @$tr .= 
                        tr(
                            @$cCmoreColsConcoursFileFirst.
                            td(span(strip_tags((isset($altValue['Name']) and $altValue['Name'])?$altValue['Name']:$data->getName()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Name").":\" j='editConcoursFile'  i='".json_encode($data->getPrimaryKey())."' c='Name'  ")
                            .td(span(strip_tags((isset($altValue['Size']) and $altValue['Size'])?$altValue['Size']:$data->getSize()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Poids").":\" j='editConcoursFile'  i='".json_encode($data->getPrimaryKey())."' c='Size'  ")
                            .
                            
                            @$cCmoreColsConcoursFile.
                            @$actionRow
                        ,"id='ConcoursFileRow".$data->getPrimaryKey()."' data-id='".$data->getPrimaryKey()."' data-pc-table='Concours' data-table='ConcoursFile' data-edit='Photo #".$data->getPrimaryKey()."' ecf='".$child_edit_columns_filter."' ln='ConcoursFile' class=' ".@$highlight.@$param['class']."'  ")
                        ;
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(div(@$total_child,'','class="nolink"')
                            ,'trConcoursFile'," style='".@$hide_ConcoursFile."' ln='ConcoursFile' class=''").@$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    
    if(($_SESSION[_AUTH_VAR]->hasRights('ConcoursConcoursFile', 'a')) ){
        $add_button_child =""
            .div(
                htmlLink(
                    span(_("Ajouter"))
                , "Javascript:","id='pickfiles' class='button-link-blue add-button'")

            .div('', 'filelist')
            ,'upload-ConcoursFile',' class="listHeaderItem " ');
        ;
    }
    
    
    //@PAGINATION
    if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
        $ext = '';
        $table_name = 'photo';
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
                    ,'','id="ConcoursFilePagination"')
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
                 $this->CcToConcoursFileListTop
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
                                    .$this->CcToConcoursFileTableFooter
                                , "id='ConcoursFileTable' listchild=1 class='tablesorter'")
                            , 'formConcoursFile')
                            .$this->CcToConcoursFileListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list contentHolderList" ')

                    .@$pagerRow
                ,'ConcoursFileListForm')
            ,'cntConcoursFiledivChild',' class="" ');
            

                    @$return['js'] .= "
bindChangePic('ConcoursFile','Concours');
$(function(){
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,html4',
        browse_button : 'pickfiles',
        container: document.getElementById('upload-ConcoursFile'),
        url: '"._SITE_URL_NO_S."mod/act/ConcoursFileAct.php?a=file&pc=Concours&ip=".$filterKey."&IdUser=".$_SESSION[_AUTH_VAR]->get('id')."&blob=',
        flash_swf_url : '"._SITE_URL."/js/plupload/Moxie.swf',
        drop_element : 'pickfiles',

        filters : {\"max_file_size\":\"20mb\",\"mime_types\":[{\"title\":\"images\",\"extensions\":\"jpg,png\"}]},
        init: {
            PostInit: function() {
                document.getElementById('filelist').innerHTML = '';
            },
            FilesAdded: function(up, files) {
                $('#loadingDialog p').html('Téléversement en cours... (<span></span>%)');
    beforeOpenDialog('loadingDialog');
    plupload.each(files, function(file) {
        uploader.start();
        return false;
    });
            },
            UploadProgress: function(up, file) {
                $('#loadingDialog p span').text(file.percent);
            },
            Error: function(up, err) {
                $('#loadingDialog p').text('Erreur #' + err.message);
            },
            UploadComplete: function(up, files) {
                $('#loadingDialog').dialog('close');
                $('body').css('cursor', 'default');
                $('[j=conglet_Concours][p=\"ConcoursFile\"]').click();

            }
        }
    });
    uploader.init();
});";

            $jqueryDatePickerChild = "beforeDatePicker('');";
            @$return['js'] .= "
                
                
            ";
            $return['onReadyJs'] =
                @$this->CcToConcoursFileListJsFirst
                .$this->ConcoursFile['list_add']
                .$this->ConcoursFile['list_delete']
                .$this->ConcoursFile['list_edit']
            ."
                
                
            ".@$total_child_js."
            
            
            
            child_button_bind('ConcoursFile');
            child_pagination_bind('ConcoursFile','Concours','".$uiTabsId."','".$IdConcours."','','".$this->CcToSearchMsPost."');
            child_pagination_sorted_bind('ConcoursFile','Concours','".$uiTabsId."','".$IdConcours."','".$this->CcToSearchMsPost."');
               
            $('#cntConcoursChild .js-select-label').SelectBox();
            
            ".@$child_order."
            
            
            ".$jqueryDatePickerChild."
            ";
            $return['onReadyJs'] .= "".$this->CcToConcoursFileListJs;
            return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'ConcoursAct.php';
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
        $this->cCmoreColsHeaderConcoursFile = '';
        $this->ListActionRowConcoursFile = '';
        $this->cCmoreColsConcoursFile = '';
        $this->CcToConcoursFileTableFooter = '';
        $this->CcToConcoursFileListTop = '';
        $this->CcToConcoursFileListBottom = '';
        $this->CcToConcoursFileListJs = '';
        
    }

    
}
