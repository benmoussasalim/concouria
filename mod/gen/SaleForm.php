<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'Sale' table.
 *
 */
class SaleForm extends Sale{
public $tableName="Sale";
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
        $q = SaleQuery::create();
        if($this->CcToSearchList){ getSelectFilter($this->CcToSearchList,$q);}
        if(is_array($this->searchAr)){
            array_walk_recursive ($this->searchAr, function (&$v){$v=trim($v);});
            ## query sub-Menu
            if(@$this->searchAr['v'] && !$this->searchAr['uv']){
                $filterStr = "filterBy".$this->searchAr['f'];
                $q 
->joinWith('Account')
                    ->$filterStr($this->searchAr['v']);
                    
                    
            }elseif(@$this->searchAr['u'] && $this->searchAr['uv']){
                $useStr = "use".$this->searchAr['u']."Query";
                $filterStr = "filterBy".$this->searchAr['f'];
                $q->$useStr()->$filterStr($this->searchAr['uv'])->endUse()
                     
->joinWith('Account');
            }else{
                $q 
->joinWith('Account');
            }
        }else{
            if(is_array($this->searchMs )){
                array_walk_recursive($this->searchMs, function (&$v){$v=trim($v);});
                $q 
->joinWith('Account');
                if(isset($this->searchMs['IdAccount']) and $this->searchMs['IdAccount'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['IdAccount']) and strpos($this->searchMs['IdAccount'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['IdAccount'] != '%DoNothing%' AND $this->searchMs['IdAccount'][0] != '%DoNothing%'){
                        $q ->filterByIdAccount($this->searchMs['IdAccount'],$criteria);
                    }
                }
            }else{
                
            if(json_decode($IdParent)){
                $pmpoData = SaleQuery::create()->filterByIdAccount(json_decode($IdParent))
                     
->joinWith('Account')
                    
                    ->paginate($page, $maxPerPage);
            }
                $hasParent = json_decode($IdParent);
                if(empty($hasParent)){
                    $q 
->joinWith('Account');
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
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Compte"), " th='sorted'  rcColone='IdAccount' c='Account.Email' rc='Account.Email' ").th(_("Date de création"), " th='sorted'  rcColone='Date' c='Date'  ").th(_("Statut"), " th='sorted'  rcColone='Statut' c='Statut'  "). $this->cCmoreColsHeader;
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
                $array_search_tb = array('IdAccount');
                
        if(in_array('IdAccount',$array_search_tb)){$this->arrayIdAccountOptions = $this->selectBoxSale_IdAccount(@$dataObj, @$data);}
                unset($data);$data['IdAccount'] = (!empty($this->searchMs['IdAccount']))?$this->searchMs['IdAccount']:'';
        
                
        @$this->fieldsSearch['Sale']['IdAccount'] = div(selectboxCustomArray('IdAccount', $this->arrayIdAccountOptions, _('Compte') , "v='ID_ACCOUNT'  s='d' otherTabs=1 ", $this->searchMs['IdAccount']), '', ' class="ac-search-item  ms-IdAccount"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msSaleAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['Sale']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msSaleBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msSaleBtClear" class="icon clear"')
               .@$this->fieldsSearch['Sale']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['Sale']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-SaleSearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['Sale']['Start'].
                    $this->fieldsSearch['Sale']['IdAccount'].
                @$this->fieldsSearch['Sale']['End'].
            $this->fieldsSearch['Sale']['Button']
            ,"id='formMsSale' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('Sale', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."Sale/edit/", "id='addSale' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addSaleAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Abonnement");
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
        if(!empty($_SESSION['memoire']['onglet']['Sale']['pg'])){
            $page = $_SESSION['memoire']['onglet']['Sale']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'SaleAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'SaleAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
            $search_child_default['IdAccount']='ASC';
        if(empty($this->searchOrder)){$this->searchOrder = $search_child_default;}
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#SaleListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#SaleListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('Sale', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('Sale', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('Sale', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteSale' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
        $altValue['Account_Email'] = "";
        if($data->getAccount()){
            $altValue['Account_Email'] = $data->getAccount()->getEmail();
        }
                
                
                
                 $titreRaccour =''; $titreRaccour .= _('Abonnement');
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['IdAccount']) and $altValue['IdAccount'])?$altValue['IdAccount']:$altValue['Account_Email']." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Compte").":\" j='editSale'  i='".json_encode($data->getPrimaryKey())."' c='IdAccount'  ")
                            .td(span(strip_tags((isset($altValue['Date']) and $altValue['Date'])?$altValue['Date']:$data->getDate()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Date de création").":\" j='editSale'  i='".json_encode($data->getPrimaryKey())."' c='Date'  ")
                            .td(span(strip_tags((isset($altValue['Statut']) and $altValue['Statut'])?$altValue['Statut']:isntPo($data->getStatut())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Statut").":\" j='editSale'  i='".json_encode($data->getPrimaryKey())."' c='Statut'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='SaleRow".$data->getPrimaryKey()."'
                    data-table='Sale' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountSale', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Abonnement';

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
                            ,'','id="SalePagination"')
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
                .div($controlsContent.$this->CcCustomControl,'SaleControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='SaleTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'SaleListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#SaleListForm [j='deleteSale']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Abonnement'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msSaleBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msSaleBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#SaleListForm tr[ecf=1] td[j='editSale']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."Sale/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."Sale/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Sale'
                ,'IdSale'
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
        $(\"#SaleListForm [j='deleteSale']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Abonnement'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msSaleBt\').length>0){ $(\'#msSaleBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'SaleTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntSaleListForm #addSale').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'SaleTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#SaleListForm tr[ecf=1] td[j='editSale']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'SaleTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Sale'
                ,'IdSale'
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
        pagination_bind('Sale','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#SaleListForm [j='deleteSale']\").unbind('click');
        $('#SaleListForm #addSale').unbind('click');
        $(\"#SaleListForm tr[ecf=1] td[j='editSale']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#SaleListForm [j='button']\").unbind();   
        pagination_sorted_bind('Sale','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('Sale','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('Sale','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_Sale($data){

        unset($data['IdSale']);
        $e = new Sale();
        
        
        if($data['Statut'] == ''){unset($data['Statut']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setDate( ($data['Date'] == '' || $data['Date'] == 'null' || substr($data['Date'],0,10) == '-0001-11-30')?null:$data['Date'] );
        $e->setStatut(($data['Statut']=='')?null:$data['Statut']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_Sale($data){

        
        $e = SaleQuery::create()->findPk(json_decode($data['i']));
        
        
        if($data['Statut'] == ''){unset($data['Statut']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['Date'])){$e->setDate( ($data['Date'] == '' || $data['Date'] == 'null' || substr($data['Date'],0,10) == '-0001-11-30')?NULL:$data['Date'] );}
        if(isset($data['Statut'])){$e->setStatut(($data['Statut']=='')?null:$data['Statut']);}
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of Sale
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
        $je= "SaleTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['Sale']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['Sale']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addSale_child').bind('click.addSale', function (){
                    $.post('"._SITE_URL."mod/act/SaleAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addSale_child').bind('click.addSale', function (){
                document.location= '"._SITE_URL."Sale/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = SaleQuery::create()->joinWith('Account');
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Sale', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Sale','w',$dataObj)) 
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
                    $('#formSale #saveSale').removeAttr('disabled');
                    $('#formSale #saveSale').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formSale #saveSale').css('cursor', 'default');
                    if($('#formSale #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formSale #saveSale').bind('click.saveSale', function (data){
                    $('#formSale #saveSale').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formSale #saveSale').css('cursor', 'progress');
                    $('#formSale #saveSale').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formSale .tinymce').each(function(index) {
                        eval(' $(\"#formSale #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formSale select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formSale\").find(\"[s='d']\").serializeArray();
                        $('#formSale select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formSale\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/SaleAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formSale #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formSale #formChangedSale').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formSale #saveSale').unbind('click.saveSale');
                $('#formSale #saveSale').remove();";
        }
        
        if($dataObj == null){
            $this->Sale['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Sale();
            $this->Sale['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
            if($data['ip']){
                $strPkParent = "setIdAccount";
                $dataObj->$strPkParent($data['ip']);
            }
        }

        ($dataObj->getAccount())?'':$dataObj->setAccount( new Account() );

        
        $this->arrayIdAccountOptions = $this->selectBoxSale_IdAccount(@$dataObj, @$data);
        
        
        
        
        
        

            $this->fields['Sale']['IdAccount']['html'] = stdFieldRow(htmlLink(_('Compte'),'javascript:','  label_lien="IdAccount"  class="label_link js-label-link" '), selectboxCustomArray('IdAccount', $this->arrayIdAccountOptions, _(""), "v='ID_ACCOUNT'  s='d' otherTabs=1  val='".$dataObj->getIdAccount()."'", $dataObj->getIdAccount()), 'IdAccount', "", @$this->commentsIdAccount, @$this->commentsIdAccount_css, '', ' ','no','');

            $this->fields['Sale']['Date']['html'] = stdFieldRow(_("Date de création"), input('text', 'Date', $dataObj->getDate(), "  otherTabs=1 j='date' placeholder='YYYY-MM-DD hh:mm:ss' size='20' otherTabs=1  s='d' class=''"), 'Date', "", @$this->commentsDate, @$this->commentsDate_css, '', ' ','no','');

            $this->fields['Sale']['Statut']['html'] = stdFieldRow(_("Statut"), selectboxCustomArray('Statut', array( '0' => array('0'=>_("Acceptée"), '1'=>'Acceptée'),'1' => array('0'=>_("Refusée"), '1'=>'Refusée'), ), _('Statut'), "s='d' otherTabs=1  ", $dataObj->getStatut()), 'Statut', "", @$this->commentsStatut, @$this->commentsStatut_css, '', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->Sale['request']['ChildHide']) ){
            
            $ongletTab['0']['t'] = _('Renouvellement');
            $ongletTab['0']['p'] = 'Abonnement';
            $ongletTab['0']['lkey'] = 'IdSale';
            $ongletTab['0']['fkey'] = 'IdSale';
        if(!empty($ongletTab) and $dataObj->getIdSale()){
            foreach($ongletTab as $value){
                if($_SESSION[_AUTH_VAR]->hasRights('Sale'.$value['p'], 'r')){
                    
                    $getLocalKey = "get".$value['lkey']."";
                    if($dataObj->$getLocalKey()){
                        @$ChildOnglet .= 
                            li(
 htmlLink(_($value['t']),'javascript:',"p='".$value['p']."' act='list' j=conglet_Sale ip='".$dataObj->$getLocalKey()."' class='ui-corner-top ui-state-default' ") 						,"  class='".@$class_has_child."' j=sm  ");
                    }
                }
            }
            if(!empty($ChildOnglet)){
                $childTable['onReadyJs'] ="
                    $('[j=conglet_Sale]').unbind('click');
                    $('[j=conglet_Sale]').bind('click', function (data){
                         pp = $(this).attr('p');
                         $.post('"._SITE_URL."mod/act/SaleAct.php', {a:'get'+pp+'List', ip:$(this).attr('ip'), ui:  pp+'Table','pui':'".$uiTabsId."',pushPGet:'".json_encode($_GET)."',pushPPOST:'".json_encode($_POST)."'}, function(data){
                            $('#cntSaleChild').html(data).show();;
                            $('[j=conglet_Sale]').parent().attr('class','ui-corner-top ui-state-default');
                            $('[j=conglet_Sale][p=\"'+pp+'\"]').parent().attr('class','ui-corner-top ui-state-default ui-state-active');
                         });
                    });

                ";
                if(@$_SESSION['memoire']['onglet']['Sale']['child']['list'][$dataObj->$getLocalKey()]){
                    $onglet_p = $_SESSION['memoire']['onglet']['Sale']['child']['list'][$dataObj->$getLocalKey()];
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Sale][p=".$onglet_p."]').first().click();";
                }else{
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Sale]').first().click();";
                }


            }
        }
        }
        
        
        if($dataObj->getIdSale()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'SaleControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = 
            div(
                input('checkbox','toggle-form',' p="Sale" ')
                .label(span(_('Afficher/Cacher le formulaire')),'for="toggle-form"')
            ,'','class="toggle-form" p="Sale" data-tooltip="'._('Cacher le formulaire').'"');
            }

        }
        
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addSale_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveSale',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedSale','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdSale', $dataObj->getIdSale(), " otherTabs=1 s='d' pk").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'SaleControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formSale');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['Sale']['tog']) and 
            $_SESSION['memoire']['onglet']['Sale']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['Sale']['Start']['html']
                
                .
$this->fields['Sale']['IdAccount']['html']
.$this->fields['Sale']['Date']['html']
.$this->fields['Sale']['Statut']['html']
                
                .@$this->fields['Sale']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntSale", "class='divStdform' CntTabs=1 ")
        , "id='formSale' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Abonnement"); }
        # if not new, show child table
        if($dataObj->getIdSale()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelSale', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntSaleChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['Sale']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['Sale']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['Sale']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    bind_close_form();
    
    ".$jqueryDatePicker."
    bind_ui_active('Sale');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    $(\"[label_lien='IdAccount']\").bind('click', function (){
        if($('#IdAccount').val()){ window.open('"._SITE_URL."Account/edit/'+$('#IdAccount').val());}else{window.open('"._SITE_URL."Account/list/');}
    });
    ".@$childTable['onReadyJs']."
    ".@$error['onReadyJs']."
    ".@$removeEditChild."
    /*try {afterFormLoad();}catch(e){}*/
    if($('#loader').css('display') == 'block') $('#loader').hide();
    $('[j=sftr]').hide();
    ".@$tabs_act."
    ".$this->CcToFormJs
    .@$script_autoc_one."
     setTimeout(function(){ bind_othertabs_std('#divCntSale');},500); 
    ".$toggleForm."
    bind_form('Sale','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
        ($dataObj->getAccount())?'':$dataObj->setAccount( new Account() );
            
        $this->fieldsRo['Sale']['IdAccount']['html'] = stdFieldRow(htmlLink(_('Compte'),'javascript:','  label_lien="IdAccount"  class="label_link js-label-link" '), 
                    input('text','IdAccountLabel',$dataObj->getAccount()->getEmail(),"  readonly s='d'")
                    .input('hidden','IdAccount',$dataObj->getIdAccount()," readonly s='d'"), 'IdAccount', "", @$this->commentsIdAccount, @$this->commentsIdAccount_css, 'readonly', ' ','no','');
$this->fieldsRo['Sale']['Date']['html'] = stdFieldRow(_("Date de création"), input('text','Date',$dataObj->getDate()," readonly s='d'"), 'Date', "", @$this->commentsDate, @$this->commentsDate_css, 'readonly', ' ','no','');
$this->fieldsRo['Sale']['Statut']['html'] = stdFieldRow(_("Statut"), input('text','Statut',$dataObj->getStatut()," readonly s='d'"), 'Statut', "", @$this->commentsStatut, @$this->commentsStatut_css, 'readonly', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['Sale'] as $field=>$ar){
                $this->fields['Sale'][$field]['html'] = $this->fieldsRo['Sale'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['Sale'][$field]['html'] = $this->fieldsRo['Sale'][$field]['html'];
            }
        }
    }
    /*Option function for Sale_IdAccount selectBox */
    public function selectBoxSale_IdAccount($dataObj='',$data='', $emptyVal=false,$array=true){
$q = AccountQuery::create();

    $q->addAsColumn('selDisplay', 'CONCAT_WS ( " ", account.email, "" )');
    $q->select(array('selDisplay', 'IdAccount'));
    $q->orderBy('selDisplay', 'ASC');
if(!$array){return $q;}else{$pcDataO = $q->find();}


$arrayOpt = $pcDataO->toArray();
return assocToNum($arrayOpt , true);
}
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = SaleQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdSale'));
            
            $pcData = $q->filterByIdAccount($IdParent);
        
        }else{
            $q->select(array('Name', 'IdSale'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = SaleQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdSale'));
            
            $pcData = $q->filterByIdAccount($IdParent);
        
        }else{
            $q->select(array('Name', 'IdSale'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Abonnement')), $selected);
        }


        return $return;
    }	#@#############
    #	getChildList
    ###############
    public function getAbonnementList($IdSale, $page='1', $uiTabsId='AbonnementTableCntnr', $parentContainer='', $mja_list='', $search='', $params = ''){
        /*init var*/
        global $request;
        if(empty($page)){$page=1;}$param=array();
        if(!empty($_SESSION['memoire']['onglet']['SaleAbonnement']['pg'])){$page = $_SESSION['memoire']['onglet']['SaleAbonnement']['pg'];}
        if(!empty($search['order'])){$this->searchOrder = $search['order'];}
        
        if(empty($search['ms'])){ $searchAr =$search;}else{$this->searchMs = $search['ms']; }

        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    @$child_order .="
                        $(\"#cntSaleChild [th='sorted'][c='".$col."'],#cntSaleChild [th='sorted'][rc='".$col."']\").attr('sens','".$sens."');
                        $(\"#cntSaleChild [th='sorted'][c='".$col."'],#cntSaleChild [th='sorted'][rc='".$col."']\").attr('order','on');
                    ";
                }
            }
        }
        
        if($parentContainer == 'editDialog'){$diagNoClose = "diag:\"noclose\", ";$diagNoCloseEscaped = "diag:\\\"noclose\\\", ";}
        if(isset($this->Sale['request']['noHeader']) && $this->Sale['request']['noHeader'] == 'true'){$noHeader = "'noHeader':'true',";}
        $data['IdSale'] = $IdSale;

        $dataObj = SaleQuery::create()->findPk($IdSale);
        if($dataObj == null){$dataObj = new Sale();$dataObj->setIdSale($IdSale);}
        $this->dataObj =$dataObj;
        

        $this->Abonnement['list_add'] = "
        $('#addAbonnement').click(function(){
            $.post('"._SITE_URL."mod/act/AbonnementAct.php', {a:'edit', ui:'editDialog',pc:'Sale', je:'AbonnementTableCntnr', jet:'tr', tp:'Abonnement', ip:'".$IdSale."'},
                function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); $('#editDialog').dialog('option','title','".addSlashes(_('Renouvellement'))."'); });
        });";
        $this->Abonnement['list_delete'] = "
        $(\"[j='deleteAbonnement']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Renouvellement'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."','$.post(\""._SITE_URL."mod/act/AbonnementAct.php\", {".@$diagNoCloseEscaped.@$diagNoClose." a:\"delete\", ui:\"".$uiTabsId."\", i:'+$(this).attr('i')+', ip:\"".$IdSale."\", pc:\"Sale\", je:\"AbonnementTableCntnr\", jet:\"tr\"}, function(data){ if(data)$(\"#AbonnementTableCntnr\").append(data);});');
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('SaleAbonnement', 'r')){ $this->Abonnement['list_edit'] = "
        $(\"#AbonnementTable[listchild=1] tr[ecf=1] td[j='editAbonnement']\").bind('click', function (){
            location.href = '"._SITE_URL."Abonnement/edit/'+$(this).attr('i')+'?tp=Abonnement&ip=".$IdSale."&pc=Sale';
        });";}
        $rigthButtonAction="";
        if($_SESSION[_AUTH_VAR]->hasRights('SaleAbonnement', 'w')){
            $rigthButtonAction='';
        }
        $filterKey = $IdSale;
        
        $maxPerPage = (!empty($this->Abonnement['request']['maxperpage']))?$this->Abonnement['request']['maxperpage']:_paging_nbr_per_page;
        try{
            $q = AbonnementQuery::create();
            
            
            $q ->filterByIdSale( $filterKey );;  
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
        
        
        
        
        
        
        if(isset($this->Sale['request']['noHeader']) && $this->Sale['request']['noHeader'] == 'true'){
            $header_search = "";
        }else{
            $header_search = ''
        .div(
            
            form('' , " CntTabs=1 id='formMsAbonnement'")
        ,'',' class="msSearchCtnr"')
        .div($rigthButtonAction, '', 'class="ac-right-action-buttons"')
        .button(span(_("Afficher le menu"),'data-tooltip="'.addslashes("Afficher le menu").'" '),'class="toggle-child-nav-btn"');
        }
        
        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('SaleAbonnement', 'd') and empty($this->readOnlyFilter)){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( @$this->cCmoreColsHeaderFirstAbonnement.th(_("Date de paiement"), " th='sorted'  rcColone='DatePaiement' c='DatePaiement'  ").th(_("Total"), " th='sorted'  rcColone='Amount' c='Amount'  ").$this->cCmoreColsHeaderAbonnement.$actionRowHeader, " ln='Abonnement' class=''");
        $i=0;
        if(empty($pmpoData) || !method_exists($pmpoData,'isEmpty')){
            @$tr .= tr(	td(p(span(_("Une erreur est survenue veuillez vider votre recherche.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='Abonnement' colspan='100%' "));
            
        }else if( $pmpoData->isEmpty() ){
            @$tr .= tr(	td(p(span(_("Aucun enregistrement pour le moment.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='Abonnement' colspan='100%' "));
            
        }else{
            
            foreach($pmpoData as $data){
                
                
                $actionRow = '';
                
                $this->ListActionRowAbonnement = (!empty($this->cCListActionRowAbonnement))?str_replace('%idpk%', json_encode($data->getPrimaryKey()), $this->cCListActionRowAbonnement):$this->ListActionRowAbonnement;
                $this->ListActionRowAbonnement = (!empty($this->cCListActionRowAbonnement))?str_replace('%i%', $i, $this->ListActionRowAbonnement):$this->ListActionRowAbonnement;
                
                if($_SESSION[_AUTH_VAR]->hasRights('SaleAbonnement', 'd') and empty($this->readOnlyFilter) ){$actionRow = htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteAbonnement' i='".json_encode($data->getPrimaryKey())."'");}
                
                
                
                

                $actionRow = $actionRow;
                $addClass='';
                $cnt= substr_count($actionRow,'<a');
                if($cnt){ $addClass=' actionrow'.$cnt;}
                $actionRow = (!empty($actionRow))?td($this->ListActionRowAbonnement.$actionRow," class='actionrow ".$addClass."'"):"";
                
                
                
                ;
                
                if(isset($this->search['highlight']) && is_array($this->search['highlight'])){
                    $highlight = (in_array(json_encode($data->getPrimaryKey()), $this->search['highlight']))?'highlight':'';
                }
                
                $child_edit_columns_filter ="1";
    
                @$tr .= 
                        tr(
                            @$cCmoreColsAbonnementFirst.
                            td(span(strip_tags((isset($altValue['DatePaiement']) and $altValue['DatePaiement'])?$altValue['DatePaiement']:$data->getDatePaiement()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Date de paiement").":\" j='editAbonnement'  i='".json_encode($data->getPrimaryKey())."' c='DatePaiement'  ")
                            .td(span(strip_tags((isset($altValue['Amount']) and $altValue['Amount'])?$altValue['Amount']:$data->getAmount()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Total").":\" j='editAbonnement'  i='".json_encode($data->getPrimaryKey())."' c='Amount'  ")
                            .
                            
                            @$cCmoreColsAbonnement.
                            @$actionRow
                        ,"id='AbonnementRow".$data->getPrimaryKey()."' data-id='".$data->getPrimaryKey()."' data-pc-table='Sale' data-table='Abonnement' data-edit='Renouvellement #".$data->getPrimaryKey()."' ecf='".$child_edit_columns_filter."' ln='Abonnement' class=' ".@$highlight.@$param['class']."'  ")
                        ;
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(div(@$total_child,'','class="nolink"')
                            ,'trAbonnement'," style='".@$hide_Abonnement."' ln='Abonnement' class=''").@$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    
    if(($_SESSION[_AUTH_VAR]->hasRights('SaleAbonnement', 'a')) ){
        $add_button_child =htmlLink(span(_("Ajouter")), "Javascript:","id='addAbonnement' class='button-link-blue add-button'");
    }
    
    
    //@PAGINATION
    if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
        $ext = '';
        $table_name = 'renouvellement';
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
                    ,'','id="AbonnementPagination"')
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
                 $this->CcToAbonnementListTop
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
                                    .$this->CcToAbonnementTableFooter
                                , "id='AbonnementTable' listchild=1 class='tablesorter'")
                            , 'formAbonnement')
                            .$this->CcToAbonnementListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list contentHolderList" ')

                    .@$pagerRow
                ,'AbonnementListForm')
            ,'cntAbonnementdivChild',' class="" ');
            
            
            $jqueryDatePickerChild = "beforeDatePicker('');";
            @$return['js'] .= "
                
                
            ";
            $return['onReadyJs'] =
                @$this->CcToAbonnementListJsFirst
                .$this->Abonnement['list_add']
                .$this->Abonnement['list_delete']
                .$this->Abonnement['list_edit']
            ."
                
                
            ".@$total_child_js."
            
            
            
            child_button_bind('Abonnement');
            child_pagination_bind('Abonnement','Sale','".$uiTabsId."','".$IdSale."','','".$this->CcToSearchMsPost."');
            child_pagination_sorted_bind('Abonnement','Sale','".$uiTabsId."','".$IdSale."','".$this->CcToSearchMsPost."');
               
            $('#cntSaleChild .js-select-label').SelectBox();
            
            ".@$child_order."
            
            
            ".$jqueryDatePickerChild."
            ";
            $return['onReadyJs'] .= "".$this->CcToAbonnementListJs;
            return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'SaleAct.php';
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
        $this->cCmoreColsHeaderAbonnement = '';
        $this->ListActionRowAbonnement = '';
        $this->cCmoreColsAbonnement = '';
        $this->CcToAbonnementTableFooter = '';
        $this->CcToAbonnementListTop = '';
        $this->CcToAbonnementListBottom = '';
        $this->CcToAbonnementListJs = '';
        
    }

    
}
