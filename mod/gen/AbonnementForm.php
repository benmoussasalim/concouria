<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'Abonnement' table.
 *
 */
class AbonnementForm extends Abonnement{
public $tableName="Abonnement";
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
        $q = AbonnementQuery::create();
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
                if(isset($this->searchMs['DatePaiement']) and $this->searchMs['DatePaiement'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['DatePaiement']) and strpos($this->searchMs['DatePaiement'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['DatePaiement'] != '%DoNothing%' AND $this->searchMs['DatePaiement'][0] != '%DoNothing%'){
                        $q ->filterByDatePaiement($this->searchMs['DatePaiement'],$criteria);
                    }
                }
            }else{
                
            if(json_decode($IdParent)){
                $pmpoData = AbonnementQuery::create()->filterByIdSale(json_decode($IdParent))
                    
                    
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
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Date de paiement"), " th='sorted'  rcColone='DatePaiement' c='DatePaiement'  ").th(_("Total"), " th='sorted'  rcColone='Amount' c='Amount'  "). $this->cCmoreColsHeader;
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
                $array_search_tb = array('DatePaiement');
                
                unset($data);$data['DatePaiement'] = (!empty($this->searchMs['DatePaiement']))?$this->searchMs['DatePaiement']:'';
        
                
        @$this->fieldsSearch['Abonnement']['DatePaiement'] = div(input('text', 'DatePaiement', $this->searchMs['DatePaiement'], ' othertabs=1  j="date"  placeholder="'._('Date').'"',''),'','class="ac-search-item ms-DatePaiement"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msAbonnementAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['Abonnement']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msAbonnementBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msAbonnementBtClear" class="icon clear"')
               .@$this->fieldsSearch['Abonnement']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['Abonnement']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-AbonnementSearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['Abonnement']['Start'].
                    $this->fieldsSearch['Abonnement']['DatePaiement'].
                @$this->fieldsSearch['Abonnement']['End'].
            $this->fieldsSearch['Abonnement']['Button']
            ,"id='formMsAbonnement' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('Abonnement', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."Abonnement/edit/", "id='addAbonnement' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addAbonnementAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Renouvellement");
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
        if(!empty($_SESSION['memoire']['onglet']['Abonnement']['pg'])){
            $page = $_SESSION['memoire']['onglet']['Abonnement']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'AbonnementAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'AbonnementAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
            $search_child_default['DatePaiement']='DESC';
        if(empty($this->searchOrder)){$this->searchOrder = $search_child_default;}
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#AbonnementListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#AbonnementListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('Abonnement', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('Abonnement', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('Abonnement', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteAbonnement' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
                
                
                
                 $titreRaccour =''; $titreRaccour .= _('Renouvellement');
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['DatePaiement']) and $altValue['DatePaiement'])?$altValue['DatePaiement']:$data->getDatePaiement()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Date de paiement").":\" j='editAbonnement'  i='".json_encode($data->getPrimaryKey())."' c='DatePaiement'  ")
                            .td(span(strip_tags((isset($altValue['Amount']) and $altValue['Amount'])?$altValue['Amount']:$data->getAmount()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Total").":\" j='editAbonnement'  i='".json_encode($data->getPrimaryKey())."' c='Amount'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='AbonnementRow".$data->getPrimaryKey()."'
                    data-table='Abonnement' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountAbonnement', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Renouvellement';

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
                            ,'','id="AbonnementPagination"')
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
                .div($controlsContent.$this->CcCustomControl,'AbonnementControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='AbonnementTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'AbonnementListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#AbonnementListForm [j='deleteAbonnement']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Renouvellement'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msAbonnementBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msAbonnementBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#AbonnementListForm tr[ecf=1] td[j='editAbonnement']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."Abonnement/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."Abonnement/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Abonnement'
                ,'IdAbonnement'
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
        $(\"#AbonnementListForm [j='deleteAbonnement']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Renouvellement'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msAbonnementBt\').length>0){ $(\'#msAbonnementBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'AbonnementTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntAbonnementListForm #addAbonnement').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'AbonnementTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#AbonnementListForm tr[ecf=1] td[j='editAbonnement']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'AbonnementTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Abonnement'
                ,'IdAbonnement'
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
        pagination_bind('Abonnement','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#AbonnementListForm [j='deleteAbonnement']\").unbind('click');
        $('#AbonnementListForm #addAbonnement').unbind('click');
        $(\"#AbonnementListForm tr[ecf=1] td[j='editAbonnement']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#AbonnementListForm [j='button']\").unbind();   
        pagination_sorted_bind('Abonnement','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('Abonnement','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('Abonnement','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_Abonnement($data){

        unset($data['IdAbonnement']);
        $e = new Abonnement();
        
        
        if(!@$data['Type']){$data['Type'] = "Annuel";} 
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setDatePaiement( ($data['DatePaiement'] == '' || $data['DatePaiement'] == 'null' || substr($data['DatePaiement'],0,10) == '-0001-11-30')?date('Y-m-d'):$data['DatePaiement'] );
        $e->setStripeResponse(($data['StripeResponse']=='')?null:$data['StripeResponse']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_Abonnement($data){

        
        $e = AbonnementQuery::create()->findPk(json_decode($data['i']));
        
        
        if(!@$data['Type']){$data['Type'] = "Annuel";} 
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['DatePaiement'])){$e->setDatePaiement( ($data['DatePaiement'] == '' || $data['DatePaiement'] == 'null' || substr($data['DatePaiement'],0,10) == '-0001-11-30')?NULL:$data['DatePaiement'] );}
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of Abonnement
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
        $je= "AbonnementTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['Abonnement']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['Abonnement']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addAbonnement_child').bind('click.addAbonnement', function (){
                    $.post('"._SITE_URL."mod/act/AbonnementAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addAbonnement_child').bind('click.addAbonnement', function (){
                document.location= '"._SITE_URL."Abonnement/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = AbonnementQuery::create();
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Abonnement', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Abonnement','w',$dataObj)) 
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
                    $('#formAbonnement #saveAbonnement').removeAttr('disabled');
                    $('#formAbonnement #saveAbonnement').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formAbonnement #saveAbonnement').css('cursor', 'default');
                    if($('#formAbonnement #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formAbonnement #saveAbonnement').bind('click.saveAbonnement', function (data){
                    $('#formAbonnement #saveAbonnement').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formAbonnement #saveAbonnement').css('cursor', 'progress');
                    $('#formAbonnement #saveAbonnement').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formAbonnement .tinymce').each(function(index) {
                        eval(' $(\"#formAbonnement #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formAbonnement select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formAbonnement\").find(\"[s='d']\").serializeArray();
                        $('#formAbonnement select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formAbonnement\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/AbonnementAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formAbonnement #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formAbonnement #formChangedAbonnement').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formAbonnement #saveAbonnement').unbind('click.saveAbonnement');
                $('#formAbonnement #saveAbonnement').remove();";
        }
        
        if($dataObj == null){
            $this->Abonnement['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Abonnement();
            $this->Abonnement['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
            if($data['ip']){
                $strPkParent = "setIdSale";
                $dataObj->$strPkParent($data['ip']);
            }
        }


        
        
        
        
        
        
        

            $this->fields['Abonnement']['DatePaiement']['html'] = stdFieldRow(_("Date de paiement"), input('text', 'DatePaiement', $dataObj->getDatePaiement(), "  otherTabs=1 j='date' placeholder='YYYY-MM-DD hh:mm:ss' size='20' otherTabs=1  s='d' class=''"), 'DatePaiement', "", @$this->commentsDatePaiement, @$this->commentsDatePaiement_css, '', ' ','no','');

            $this->fields['Abonnement']['SubAmount']['html'] = stdFieldRow(_("Sous-total"), input('text', 'SubAmount',str_replace('"','&quot;',$dataObj->getSubAmount()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Sous-total'))."' size='35'  v='SUB_AMOUNT' s='d' class=''")."", 'SubAmount', "", @$this->commentsSubAmount, @$this->commentsSubAmount_css, '', ' ','no','');

            $this->fields['Abonnement']['Amount']['html'] = stdFieldRow(_("Total"), input('text', 'Amount',str_replace('"','&quot;',$dataObj->getAmount()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Total'))."' size='35'  v='AMOUNT' s='d' class=''")."", 'Amount', "", @$this->commentsAmount, @$this->commentsAmount_css, '', ' ','no','');

            $this->fields['Abonnement']['StripeResponse']['html'] = stdFieldRow(_("Réponse Stripe"), input('text', 'StripeResponse',str_replace('"','&quot;',$dataObj->getStripeResponse()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Réponse Stripe'))."' size='35'  v='STRIPE_RESPONSE' s='d' class=''")."", 'StripeResponse', "", @$this->commentsStripeResponse, @$this->commentsStripeResponse_css, '', ' ','no','');

            $this->fields['Abonnement']['Type']['html'] = stdFieldRow(_("Type d'abonnement"), selectboxCustomArray('Type', array( '0' => array('0'=>_("Annuel"), '1'=>'Annuel'),'1' => array('0'=>_("Mensuel"), '1'=>'Mensuel'), ), "", "s='d' otherTabs=1  ", $dataObj->getType()), 'Type', "", @$this->commentsType, @$this->commentsType_css, '', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->Abonnement['request']['ChildHide']) ){
            
            $ongletTab['0']['t'] = _('Taxe');
            $ongletTab['0']['p'] = 'SaleTaxe';
            $ongletTab['0']['lkey'] = 'IdAbonnement';
            $ongletTab['0']['fkey'] = 'IdAbonnement';
        if(!empty($ongletTab) and $dataObj->getIdAbonnement()){
            foreach($ongletTab as $value){
                if($_SESSION[_AUTH_VAR]->hasRights('Abonnement'.$value['p'], 'r')){
                    
                    $getLocalKey = "get".$value['lkey']."";
                    if($dataObj->$getLocalKey()){
                        @$ChildOnglet .= 
                            li(
 htmlLink(_($value['t']),'javascript:',"p='".$value['p']."' act='list' j=conglet_Abonnement ip='".$dataObj->$getLocalKey()."' class='ui-corner-top ui-state-default' ") 						,"  class='".@$class_has_child."' j=sm  ");
                    }
                }
            }
            if(!empty($ChildOnglet)){
                $childTable['onReadyJs'] ="
                    $('[j=conglet_Abonnement]').unbind('click');
                    $('[j=conglet_Abonnement]').bind('click', function (data){
                         pp = $(this).attr('p');
                         $.post('"._SITE_URL."mod/act/AbonnementAct.php', {a:'get'+pp+'List', ip:$(this).attr('ip'), ui:  pp+'Table','pui':'".$uiTabsId."',pushPGet:'".json_encode($_GET)."',pushPPOST:'".json_encode($_POST)."'}, function(data){
                            $('#cntAbonnementChild').html(data).show();;
                            $('[j=conglet_Abonnement]').parent().attr('class','ui-corner-top ui-state-default');
                            $('[j=conglet_Abonnement][p=\"'+pp+'\"]').parent().attr('class','ui-corner-top ui-state-default ui-state-active');
                         });
                    });

                ";
                if(@$_SESSION['memoire']['onglet']['Abonnement']['child']['list'][$dataObj->$getLocalKey()]){
                    $onglet_p = $_SESSION['memoire']['onglet']['Abonnement']['child']['list'][$dataObj->$getLocalKey()];
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Abonnement][p=".$onglet_p."]').first().click();";
                }else{
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Abonnement]').first().click();";
                }


            }
        }
        }
        
        
        if($dataObj->getIdAbonnement()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'AbonnementControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = 
            div(
                input('checkbox','toggle-form',' p="Abonnement" ')
                .label(span(_('Afficher/Cacher le formulaire')),'for="toggle-form"')
            ,'','class="toggle-form" p="Abonnement" data-tooltip="'._('Cacher le formulaire').'"');
            }

        }
        
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addAbonnement_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveAbonnement',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedAbonnement','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdAbonnement', $dataObj->getIdAbonnement(), " otherTabs=1 s='d' pk").input('hidden', 'IdSale', $dataObj->getIdSale(), " otherTabs=1 s='d' nodesc").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'AbonnementControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formAbonnement');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['Abonnement']['tog']) and 
            $_SESSION['memoire']['onglet']['Abonnement']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['Abonnement']['Start']['html']
                
                .
$this->fields['Abonnement']['DatePaiement']['html']
.$this->fields['Abonnement']['SubAmount']['html']
.$this->fields['Abonnement']['Amount']['html']
.$this->fields['Abonnement']['StripeResponse']['html']
.$this->fields['Abonnement']['Type']['html']
                
                .@$this->fields['Abonnement']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntAbonnement", "class='divStdform' CntTabs=1 ")
        , "id='formAbonnement' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Renouvellement"); }
        # if not new, show child table
        if($dataObj->getIdAbonnement()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelAbonnement', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntAbonnementChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['Abonnement']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['Abonnement']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['Abonnement']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    bind_close_form();
    
    ".$jqueryDatePicker."
    bind_ui_active('Abonnement');
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
     setTimeout(function(){ bind_othertabs_std('#divCntAbonnement');},500); 
    ".$toggleForm."
    bind_form('Abonnement','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
            
        $this->fieldsRo['Abonnement']['DatePaiement']['html'] = stdFieldRow(_("Date de paiement"), input('text','DatePaiement',$dataObj->getDatePaiement()," readonly s='d'"), 'DatePaiement', "", @$this->commentsDatePaiement, @$this->commentsDatePaiement_css, 'readonly', ' ','no','');
$this->fieldsRo['Abonnement']['SubAmount']['html'] = stdFieldRow(_("Sous-total"), input('text','SubAmount',$dataObj->getSubAmount()," readonly s='d'"), 'SubAmount', "", @$this->commentsSubAmount, @$this->commentsSubAmount_css, 'readonly', ' ','no','');
$this->fieldsRo['Abonnement']['Amount']['html'] = stdFieldRow(_("Total"), input('text','Amount',$dataObj->getAmount()," readonly s='d'"), 'Amount', "", @$this->commentsAmount, @$this->commentsAmount_css, 'readonly', ' ','no','');
$this->fieldsRo['Abonnement']['StripeResponse']['html'] = stdFieldRow(_("Réponse Stripe"), input('text','StripeResponse',$dataObj->getStripeResponse()," readonly s='d'"), 'StripeResponse', "", @$this->commentsStripeResponse, @$this->commentsStripeResponse_css, 'readonly', ' ','no','');
$this->fieldsRo['Abonnement']['Type']['html'] = stdFieldRow(_("Type d'abonnement"), input('text','Type',$dataObj->getType()," readonly s='d'"), 'Type', "", @$this->commentsType, @$this->commentsType_css, 'readonly', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['Abonnement'] as $field=>$ar){
                $this->fields['Abonnement'][$field]['html'] = $this->fieldsRo['Abonnement'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['Abonnement'][$field]['html'] = $this->fieldsRo['Abonnement'][$field]['html'];
            }
        }
    }
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = AbonnementQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdAbonnement'));
            
            $pcData = $q->filterByIdSale($IdParent);
        
        }else{
            $q->select(array('Name', 'IdAbonnement'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = AbonnementQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdAbonnement'));
            
            $pcData = $q->filterByIdSale($IdParent);
        
        }else{
            $q->select(array('Name', 'IdAbonnement'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Renouvellement')), $selected);
        }


        return $return;
    }	#@#############
    #	getChildList
    ###############
    public function getSaleTaxeList($IdAbonnement, $page='1', $uiTabsId='SaleTaxeTableCntnr', $parentContainer='', $mja_list='', $search='', $params = ''){
        /*init var*/
        global $request;
        if(empty($page)){$page=1;}$param=array();
        if(!empty($_SESSION['memoire']['onglet']['AbonnementSaleTaxe']['pg'])){$page = $_SESSION['memoire']['onglet']['AbonnementSaleTaxe']['pg'];}
        if(!empty($search['order'])){$this->searchOrder = $search['order'];}
        
        if(empty($search['ms'])){ $searchAr =$search;}else{$this->searchMs = $search['ms']; }

        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    @$child_order .="
                        $(\"#cntAbonnementChild [th='sorted'][c='".$col."'],#cntAbonnementChild [th='sorted'][rc='".$col."']\").attr('sens','".$sens."');
                        $(\"#cntAbonnementChild [th='sorted'][c='".$col."'],#cntAbonnementChild [th='sorted'][rc='".$col."']\").attr('order','on');
                    ";
                }
            }
        }
        
        if($parentContainer == 'editDialog'){$diagNoClose = "diag:\"noclose\", ";$diagNoCloseEscaped = "diag:\\\"noclose\\\", ";}
        if(isset($this->Abonnement['request']['noHeader']) && $this->Abonnement['request']['noHeader'] == 'true'){$noHeader = "'noHeader':'true',";}
        $data['IdAbonnement'] = $IdAbonnement;

        $dataObj = AbonnementQuery::create()->findPk($IdAbonnement);
        if($dataObj == null){$dataObj = new Abonnement();$dataObj->setIdAbonnement($IdAbonnement);}
        $this->dataObj =$dataObj;
        

        $this->SaleTaxe['list_add'] = "
        $('#addSaleTaxe').click(function(){
            $.post('"._SITE_URL."mod/act/SaleTaxeAct.php', {a:'edit', ui:'editDialog',pc:'Abonnement', je:'SaleTaxeTableCntnr', jet:'tr', tp:'SaleTaxe', ip:'".$IdAbonnement."'},
                function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); $('#editDialog').dialog('option','title','".addSlashes(_('Taxe'))."'); });
        });";
        $this->SaleTaxe['list_delete'] = "
        $(\"[j='deleteSaleTaxe']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Taxe'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."','$.post(\""._SITE_URL."mod/act/SaleTaxeAct.php\", {".@$diagNoCloseEscaped.@$diagNoClose." a:\"delete\", ui:\"".$uiTabsId."\", i:'+$(this).attr('i')+', ip:\"".$IdAbonnement."\", pc:\"Abonnement\", je:\"SaleTaxeTableCntnr\", jet:\"tr\"}, function(data){ if(data)$(\"#SaleTaxeTableCntnr\").append(data);});');
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('AbonnementSaleTaxe', 'r')){ $this->SaleTaxe['list_edit'] = "
        $(\"#SaleTaxeTable[listchild=1] tr[ecf=1] td[j='editSaleTaxe']\").bind('click', function (){
            
        $.post('"._SITE_URL."mod/act/SaleTaxeAct.php',
                {a:'edit', i:$(this).attr('i'), ip:'".$IdAbonnement."', ui:'editDialog',pc:'Abonnement', je:'SaleTaxeTableCntnr', jet:'tr', 'it-pos':$(this).data('iterator-pos') },
            function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";}
        $rigthButtonAction="";
        if($_SESSION[_AUTH_VAR]->hasRights('AbonnementSaleTaxe', 'w')){
            $rigthButtonAction='';
        }
        $filterKey = $IdAbonnement;
        
        $maxPerPage = (!empty($this->SaleTaxe['request']['maxperpage']))?$this->SaleTaxe['request']['maxperpage']:_paging_nbr_per_page;
        try{
            $q = SaleTaxeQuery::create();
            
            
            $q
->leftJoin('Taxe') ->filterByIdAbonnement( $filterKey );;  
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
        
        
        
        
        
        
        if(isset($this->Abonnement['request']['noHeader']) && $this->Abonnement['request']['noHeader'] == 'true'){
            $header_search = "";
        }else{
            $header_search = ''
        .div(
            
            form('' , " CntTabs=1 id='formMsSaleTaxe'")
        ,'',' class="msSearchCtnr"')
        .div($rigthButtonAction, '', 'class="ac-right-action-buttons"')
        .button(span(_("Afficher le menu"),'data-tooltip="'.addslashes("Afficher le menu").'" '),'class="toggle-child-nav-btn"');
        }
        
        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('AbonnementSaleTaxe', 'd') and empty($this->readOnlyFilter)){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( @$this->cCmoreColsHeaderFirstSaleTaxe.th(_("Taxe"), " th='sorted'  rcColone='IdTaxe' c='IdTaxe'  ").th(_("Name Taxe"), " th='sorted'  rcColone='Name' c='Name'  ").th(_("%"), " th='sorted'  rcColone='Pourcent' c='Pourcent'  ").th(_("Montant"), " th='sorted'  rcColone='Montant' c='Montant'  ").$this->cCmoreColsHeaderSaleTaxe.$actionRowHeader, " ln='SaleTaxe' class=''");
        $i=0;
        if(empty($pmpoData) || !method_exists($pmpoData,'isEmpty')){
            @$tr .= tr(	td(p(span(_("Une erreur est survenue veuillez vider votre recherche.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='SaleTaxe' colspan='100%' "));
            
        }else if( $pmpoData->isEmpty() ){
            @$tr .= tr(	td(p(span(_("Aucun enregistrement pour le moment.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='SaleTaxe' colspan='100%' "));
            
        }else{
            
            foreach($pmpoData as $data){
                
                
                $actionRow = '';
                
                $this->ListActionRowSaleTaxe = (!empty($this->cCListActionRowSaleTaxe))?str_replace('%idpk%', json_encode($data->getPrimaryKey()), $this->cCListActionRowSaleTaxe):$this->ListActionRowSaleTaxe;
                $this->ListActionRowSaleTaxe = (!empty($this->cCListActionRowSaleTaxe))?str_replace('%i%', $i, $this->ListActionRowSaleTaxe):$this->ListActionRowSaleTaxe;
                
                if($_SESSION[_AUTH_VAR]->hasRights('AbonnementSaleTaxe', 'd') and empty($this->readOnlyFilter) ){$actionRow = htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteSaleTaxe' i='".json_encode($data->getPrimaryKey())."'");}
                
                
                
                

                $actionRow = $actionRow;
                $addClass='';
                $cnt= substr_count($actionRow,'<a');
                if($cnt){ $addClass=' actionrow'.$cnt;}
                $actionRow = (!empty($actionRow))?td($this->ListActionRowSaleTaxe.$actionRow," class='actionrow ".$addClass."'"):"";
                
                                    $Taxe_Name ="";
                                    if($data->getTaxe()){
                                        $Taxe_Name = $data->getTaxe()->getName();
                                    }
                
                
                ;
                
                if(isset($this->search['highlight']) && is_array($this->search['highlight'])){
                    $highlight = (in_array(json_encode($data->getPrimaryKey()), $this->search['highlight']))?'highlight':'';
                }
                
                $child_edit_columns_filter ="1";
    
                @$tr .= 
                        tr(
                            @$cCmoreColsSaleTaxeFirst.
                            td(span(strip_tags((isset($altValue['IdTaxe']) and $altValue['IdTaxe'])?$altValue['IdTaxe']:$Taxe_Name." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Taxe").":\" j='editSaleTaxe'  i='".json_encode($data->getPrimaryKey())."' c='IdTaxe'  ")
                            .td(span(strip_tags((isset($altValue['Name']) and $altValue['Name'])?$altValue['Name']:$data->getName()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Name Taxe").":\" j='editSaleTaxe'  i='".json_encode($data->getPrimaryKey())."' c='Name'  ")
                            .td(span(strip_tags((isset($altValue['Pourcent']) and $altValue['Pourcent'])?$altValue['Pourcent']:str_replace(',','.',$data->getPourcent())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("%").":\" j='editSaleTaxe'  i='".json_encode($data->getPrimaryKey())."' c='Pourcent'  ")
                            .td(span(strip_tags((isset($altValue['Montant']) and $altValue['Montant'])?$altValue['Montant']:str_replace(',','.',$data->getMontant())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Montant").":\" j='editSaleTaxe'  i='".json_encode($data->getPrimaryKey())."' c='Montant'  ")
                            .
                            
                            @$cCmoreColsSaleTaxe.
                            @$actionRow
                        ,"id='SaleTaxeRow".$data->getPrimaryKey()."' data-id='".$data->getPrimaryKey()."' data-pc-table='Abonnement' data-table='SaleTaxe' data-edit='Taxe #".$data->getPrimaryKey()."' ecf='".$child_edit_columns_filter."' ln='SaleTaxe' class=' ".@$highlight.@$param['class']."'  ")
                        ;
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(div(@$total_child,'','class="nolink"')
                            ,'trSaleTaxe'," style='".@$hide_SaleTaxe."' ln='SaleTaxe' class=''").@$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    
    if(($_SESSION[_AUTH_VAR]->hasRights('AbonnementSaleTaxe', 'a')) ){
        $add_button_child =htmlLink(span(_("Ajouter")), "Javascript:","id='addSaleTaxe' class='button-link-blue add-button'");
    }
    
    
    //@PAGINATION
    if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
        $ext = '';
        $table_name = 'taxe';
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
                    ,'','id="SaleTaxePagination"')
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
                 $this->CcToSaleTaxeListTop
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
                                    .$this->CcToSaleTaxeTableFooter
                                , "id='SaleTaxeTable' listchild=1 class='tablesorter'")
                            , 'formSaleTaxe')
                            .$this->CcToSaleTaxeListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list contentHolderList" ')

                    .@$pagerRow
                ,'SaleTaxeListForm')
            ,'cntSaleTaxedivChild',' class="" ');
            
            
            $jqueryDatePickerChild = "beforeDatePicker('');";
            @$return['js'] .= "
                
                
            ";
            $return['onReadyJs'] =
                @$this->CcToSaleTaxeListJsFirst
                .$this->SaleTaxe['list_add']
                .$this->SaleTaxe['list_delete']
                .$this->SaleTaxe['list_edit']
            ."
                
                
            ".@$total_child_js."
            
            
            
            child_button_bind('SaleTaxe');
            child_pagination_bind('SaleTaxe','Abonnement','".$uiTabsId."','".$IdAbonnement."','','".$this->CcToSearchMsPost."');
            child_pagination_sorted_bind('SaleTaxe','Abonnement','".$uiTabsId."','".$IdAbonnement."','".$this->CcToSearchMsPost."');
               
            $('#cntAbonnementChild .js-select-label').SelectBox();
            
            ".@$child_order."
            
            
            ".$jqueryDatePickerChild."
            ";
            $return['onReadyJs'] .= "".$this->CcToSaleTaxeListJs;
            return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'AbonnementAct.php';
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
        $this->cCmoreColsHeaderSaleTaxe = '';
        $this->ListActionRowSaleTaxe = '';
        $this->cCmoreColsSaleTaxe = '';
        $this->CcToSaleTaxeTableFooter = '';
        $this->CcToSaleTaxeListTop = '';
        $this->CcToSaleTaxeListBottom = '';
        $this->CcToSaleTaxeListJs = '';
        
    }

    
}
