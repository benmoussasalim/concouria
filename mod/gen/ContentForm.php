<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'Content' table.
 *
 */
class ContentForm extends Content{
public $tableName="Content";
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
        $q = ContentQuery::create();
        if($this->CcToSearchList){ getSelectFilter($this->CcToSearchList,$q);}
        if(is_array($this->searchAr)){
            array_walk_recursive ($this->searchAr, function (&$v){$v=trim($v);});
            ## query sub-Menu
            if(@$this->searchAr['v'] && !$this->searchAr['uv']){
                $filterStr = "filterBy".$this->searchAr['f'];
                $q
->leftJoin('Menu')
                    ->$filterStr($this->searchAr['v']);
                    
                    
            }elseif(@$this->searchAr['u'] && $this->searchAr['uv']){
                $useStr = "use".$this->searchAr['u']."Query";
                $filterStr = "filterBy".$this->searchAr['f'];
                $q->$useStr()->$filterStr($this->searchAr['uv'])->endUse()
                    
->leftJoin('Menu');
            }else{
                $q
->leftJoin('Menu');
            }
        }else{
            if(is_array($this->searchMs )){
                array_walk_recursive($this->searchMs, function (&$v){$v=trim($v);});
                $q
->leftJoin('Menu');
                if(isset($this->searchMs['NameMenu']) and $this->searchMs['NameMenu'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['NameMenu']) and strpos($this->searchMs['NameMenu'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['NameMenu'] != '%DoNothing%' AND $this->searchMs['NameMenu'][0] != '%DoNothing%'){
                        $q->filterByNameMenu("%".$this->searchMs['NameMenu']."%", Criteria::LIKE);
                    }
                }
                if(isset($this->searchMs['Status']) and $this->searchMs['Status'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Status']) and strpos($this->searchMs['Status'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Status'] != '%DoNothing%' AND $this->searchMs['Status'][0] != '%DoNothing%'){
                        $q ->filterByStatus($this->searchMs['Status'],$criteria);
                    }
                }
            }else{
                
                $hasParent = json_decode($IdParent);
                if(empty($hasParent)){
                    $q
->leftJoin('Menu');
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
        
         $q->groupBy('IdContent');
        
        $this->pmpoData =  $q;
        //echo $q->toString();
        //$q->paginate($page, $maxPerPage);
        return $this->pmpoData;
    }
    public function getListHeader($act){
        switch($act){
            case 'head':
            ###### TH
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Status"), " th='sorted'  rcColone='Status' c='Status'  ").th(_("Ordre du menu"), " th='sorted'  rcColone='Order' c='Order'  ").th(_("Nom menu"), " th='sorted'  rcColone='NameMenu' c='NameMenu'  ").th(_("Type de contenu"), " th='sorted'  rcColone='Type' c='Type'  "). $this->cCmoreColsHeader;
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
                $array_search_tb = array('NameMenu','Status');
                
        if(in_array('IdMenu',$array_search_tb)){$this->arrayIdMenuOptions = $this->selectBoxContent_IdMenu(@$dataObj, @$data);}
                unset($data);$data['NameMenu'] = (!empty($this->searchMs['NameMenu']))?$this->searchMs['NameMenu']:'';
        $data['Status'] = (!empty($this->searchMs['Status']))?$this->searchMs['Status']:'';
        
                
        @$this->fieldsSearch['Content']['NameMenu'] = div(input('text', 'NameMenu', $this->searchMs['NameMenu'], ' othertabs=1  placeholder="'._('Nom').'"',''),'','class="ac-search-item ms-NameMenu"');
        @$this->fieldsSearch['Content']['Status'] =div(selectboxCustomArray('Status', array( '0' => array('0'=>_("Brouillon"), '1'=>'Brouillon'),'1' => array('0'=>_("Publié"), '1'=>'Publié'),'2' => array('0'=>_("Désactivé"), '1'=>'Désactivé'), ), _('Status'), '  size="1" t="1"   ', $this->searchMs['Status']), '', '  class=" ac-search-item ms-Status"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msContentAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['Content']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msContentBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msContentBtClear" class="icon clear"')
               .@$this->fieldsSearch['Content']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['Content']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-ContentSearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['Content']['Start'].
                    $this->fieldsSearch['Content']['NameMenu'].
                    $this->fieldsSearch['Content']['Status'].
                @$this->fieldsSearch['Content']['End'].
            $this->fieldsSearch['Content']['Button']
            ,"id='formMsContent' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('Content', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."Content/edit/", "id='addContent' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addContentAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Contenu");
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
        if(!empty($_SESSION['memoire']['onglet']['Content']['pg'])){
            $page = $_SESSION['memoire']['onglet']['Content']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'ContentAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'ContentAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
            $search_child_default['Order']='ASC';
        if(empty($this->searchOrder)){$this->searchOrder = $search_child_default;}
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#ContentListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#ContentListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('Content', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('Content', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('Content', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteContent' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['Status']) and $altValue['Status'])?$altValue['Status']:isntPo($data->getStatus())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Status").":\" j='editContent'  i='".json_encode($data->getPrimaryKey())."' c='Status'  ")
                            .td(span(strip_tags((isset($altValue['Order']) and $altValue['Order'])?$altValue['Order']:$data->getOrder()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Ordre du menu").":\" j='editContent'  i='".json_encode($data->getPrimaryKey())."' c='Order'  ")
                            .td(span(strip_tags((isset($altValue['NameMenu']) and $altValue['NameMenu'])?$altValue['NameMenu']:$data->getNameMenu()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Nom menu").":\" j='editContent'  i='".json_encode($data->getPrimaryKey())."' c='NameMenu'  ")
                            .td(span(strip_tags((isset($altValue['Type']) and $altValue['Type'])?$altValue['Type']:isntPo($data->getType())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Type de contenu").":\" j='editContent'  i='".json_encode($data->getPrimaryKey())."' c='Type'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='ContentRow".$data->getPrimaryKey()."'
                    data-table='Content' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountContent', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Contenu';

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
                            ,'','id="ContentPagination"')
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
                .div($controlsContent.$this->CcCustomControl,'ContentControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='ContentTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'ContentListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#ContentListForm [j='deleteContent']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Contenu'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msContentBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msContentBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#ContentListForm tr[ecf=1] td[j='editContent']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."Content/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."Content/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Content'
                ,'IdContent'
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
        $(\"#ContentListForm [j='deleteContent']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Contenu'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msContentBt\').length>0){ $(\'#msContentBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'ContentTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntContentListForm #addContent').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'ContentTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#ContentListForm tr[ecf=1] td[j='editContent']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'ContentTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Content'
                ,'IdContent'
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
        pagination_bind('Content','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#ContentListForm [j='deleteContent']\").unbind('click');
        $('#ContentListForm #addContent').unbind('click');
        $(\"#ContentListForm tr[ecf=1] td[j='editContent']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#ContentListForm [j='button']\").unbind();   
        pagination_sorted_bind('Content','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('Content','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('Content','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_Content($data){

        unset($data['IdContent']);
        $e = new Content();
        
        
        if($data['Status'] == ''){unset($data['Status']);}
        if($data['MenuVisible'] == ''){unset($data['MenuVisible']);}
        if(!@$data['Home']){$data['Home'] = "Non";} 
        if($data['Type'] == ''){unset($data['Type']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setStatus(($data['Status']=='')?null:$data['Status']);
        $e->setMenuVisible(($data['MenuVisible']=='')?null:$data['MenuVisible']);
        $e->setIdMenu(($data['IdMenu']=='')?null:$data['IdMenu']);
        $e->setType(($data['Type']=='')?null:$data['Type']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_Content($data){

        
        $e = ContentQuery::create()->findPk(json_decode($data['i']));
        
        
        if($data['Status'] == ''){unset($data['Status']);}
        if($data['MenuVisible'] == ''){unset($data['MenuVisible']);}
        if(!@$data['Home']){$data['Home'] = "Non";} 
        if($data['Type'] == ''){unset($data['Type']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['Status'])){$e->setStatus(($data['Status']=='')?null:$data['Status']);}
        if(isset($data['MenuVisible'])){$e->setMenuVisible(($data['MenuVisible']=='')?null:$data['MenuVisible']);}
        if(isset($data['IdMenu'])){$e->setIdMenu(($data['IdMenu']=='')?null:$data['IdMenu']);}
        if(isset($data['Type'])){$e->setType(($data['Type']=='')?null:$data['Type']);}
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of Content
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
        $je= "ContentTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['Content']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['Content']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addContent_child').bind('click.addContent', function (){
                    $.post('"._SITE_URL."mod/act/ContentAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addContent_child').bind('click.addContent', function (){
                document.location= '"._SITE_URL."Content/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = ContentQuery::create()->leftJoin('Menu');
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Content', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Content','w',$dataObj)) 
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
                    $('#formContent #saveContent').removeAttr('disabled');
                    $('#formContent #saveContent').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formContent #saveContent').css('cursor', 'default');
                    if($('#formContent #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formContent #saveContent').bind('click.saveContent', function (data){
                    $('#formContent #saveContent').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formContent #saveContent').css('cursor', 'progress');
                    $('#formContent #saveContent').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formContent .tinymce').each(function(index) {
                        eval(' $(\"#formContent #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formContent select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formContent\").find(\"[s='d']\").serializeArray();
                        $('#formContent select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formContent\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/ContentAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formContent #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formContent #formChangedContent').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formContent #saveContent').unbind('click.saveContent');
                $('#formContent #saveContent').remove();";
        }
        
        if($dataObj == null){
            $this->Content['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Content();
            $this->Content['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }

        ($dataObj->getMenu())?'':$dataObj->setMenu( new Menu() );
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('fr_CA')->setMetaKeyword('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('fr_CA')->setMetaDescription('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('fr_CA')->setMetaTitle('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('en_US')->setText('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('en_US')->setMetaKeyword('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('en_US')->setMetaDescription('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('en_US')->setMetaTitle('');$dataObj->addContentI18n($mt)->save();}

        
        $this->arrayIdMenuOptions = $this->selectBoxContent_IdMenu(@$dataObj, @$data);
        
        
        
        
        
        

            $this->fields['Content']['Status']['html'] = stdFieldRow(_("Status"), selectboxCustomArray('Status', array( '0' => array('0'=>_("Brouillon"), '1'=>'Brouillon'),'1' => array('0'=>_("Publié"), '1'=>'Publié'),'2' => array('0'=>_("Désactivé"), '1'=>'Désactivé'), ), _('Status'), "s='d' otherTabs=1  ", $dataObj->getStatus()), 'Status', "", @$this->commentsStatus, @$this->commentsStatus_css, '', ' ','no','');

            $this->fields['Content']['MenuVisible']['html'] = stdFieldRow(_("menu Visible"), selectboxCustomArray('MenuVisible', array( '0' => array('0'=>_("Oui"), '1'=>'Oui'),'1' => array('0'=>_("Non"), '1'=>'Non'), ), _('menu Visible'), "s='d' otherTabs=1  ", $dataObj->getMenuVisible()), 'MenuVisible', "", @$this->commentsMenuVisible, @$this->commentsMenuVisible_css, '', ' ','no','');

            $this->fields['Content']['Slug']['html'] = stdFieldRow(_("Lien de la page"), input('text', 'Slug',str_replace('"','&quot;',$dataObj->getSlug()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Lien de la page'))."' size='35'  v='SLUG' s='d' class=''")."", 'Slug', "", @$this->commentsSlug, @$this->commentsSlug_css, '', ' ','no','');

            $this->fields['Content']['Home']['html'] = stdFieldRow(_("Accueil"), selectboxCustomArray('Home', array( '0' => array('0'=>_("Non"), '1'=>'Non'),'1' => array('0'=>_("Oui"), '1'=>'Oui'), ), "", "s='d' otherTabs=1  ", $dataObj->getHome()), 'Home', "", @$this->commentsHome, @$this->commentsHome_css, '', ' ','no','');

            $this->fields['Content']['Order']['html'] = stdFieldRow(_("Ordre du menu"), input('number', 'Order',$dataObj->getOrder(), " step='10' placeholder='".str_replace("'","&#39;",_('Ordre du menu'))."' v='ORDER' size='0' otherTabs=1 s='d' class='' otherTabs=1 "), 'Order', "", @$this->commentsOrder, @$this->commentsOrder_css, '', ' ','no','');

            $this->fields['Content']['IdMenu']['html'] = stdFieldRow(htmlLink(_('Hiérarchie'),'javascript:','  label_lien="IdMenu"  class="label_link js-label-link" '), selectboxCustomArray('IdMenu', $this->arrayIdMenuOptions, _(_('Hiérarchie')), "v='ID_MENU'  s='d' otherTabs=1  val='".$dataObj->getIdMenu()."'", $dataObj->getIdMenu()), 'IdMenu', "", @$this->commentsIdMenu, @$this->commentsIdMenu_css, '', ' ','no','');

            $this->fields['Content']['NameMenu']['html'] = stdFieldRow(_("Nom menu"), input('text', 'NameMenu',str_replace('"','&quot;',$dataObj->getNameMenu()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Nom menu'))."' size='35'  v='NAME_MENU' s='d' class=''")."", 'NameMenu', "", @$this->commentsNameMenu, @$this->commentsNameMenu_css, '', ' ','no','');

            $this->fields['Content']['Type']['html'] = stdFieldRow(_("Type de contenu"), selectboxCustomArray('Type', array( '0' => array('0'=>_("Contenu fixe"), '1'=>'Contenu fixe'),'1' => array('0'=>_("Contenu dynamique"), '1'=>'Contenu dynamique'),'2' => array('0'=>_("Nouvelles"), '1'=>'Nouvelles'), ), _('Type de contenu'), "s='d' otherTabs=1  ", $dataObj->getType()), 'Type', "", @$this->commentsType, @$this->commentsType_css, '', ' ','no','');

            $this->fields['Content']['ContentI18n_Name_frCA']['html'] = stdFieldRow(_("Titre français"), input('text', 'ContentI18n_Name_frCA',str_replace('"','&quot;',$dataObj->getTranslation('fr_CA')->getName()), "placeholder='".str_replace("'","&#39;",_('Titre fr_CA'))."' size='69' otherTabs=1  v='CONTENTI18N_NAME_FRCA' s='d'  class=''")."", 'ContentI18n_Name_frCA', "", @$this->commentsContentI18n_Name_frCA, @$this->commentsContentI18n_Name_frCA_css, '', ' ','no','');

            $this->fields['Content']['ContentI18n_Text_frCA']['html'] = stdFieldRow(_("Contenu français"), 
        textarea('ContentI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText() ,"placeholder='".str_replace("'","&#39;",_('Contenu fr_CA'))."' cols='71' v='CONTENTI18N_TEXT_FRCA' otherTabs=1 s='d'  class='tinymce'  class='' style='' spellcheck='false'"), 'ContentI18n_Text_frCA', "", @$this->commentsContentI18n_Text_frCA, @$this->commentsContentI18n_Text_frCA_css, ' istinymce', ' ','no','');

            $this->fields['Content']['ContentI18n_MetaKeyword_frCA']['html'] = stdFieldRow(_("Meta Keyword français"), 
        textarea('ContentI18n_MetaKeyword_frCA',$dataObj->getTranslation('fr_CA')->getMetaKeyword() ,"placeholder='".str_replace("'","&#39;",_('Meta Keyword fr_CA'))."' cols='71' v='CONTENTI18N_METAKEYWORD_FRCA' otherTabs=1 s='d'   class='' style='' spellcheck='false'"), 'ContentI18n_MetaKeyword_frCA', "", @$this->commentsContentI18n_MetaKeyword_frCA, @$this->commentsContentI18n_MetaKeyword_frCA_css, ' istinymce', ' ','no','');

            $this->fields['Content']['ContentI18n_MetaDescription_frCA']['html'] = stdFieldRow(_("Meta Description français"), 
        textarea('ContentI18n_MetaDescription_frCA',$dataObj->getTranslation('fr_CA')->getMetaDescription() ,"placeholder='".str_replace("'","&#39;",_('Meta Description fr_CA'))."' cols='71' v='CONTENTI18N_METADESCRIPTION_FRCA' otherTabs=1 s='d'   class='' style='' spellcheck='false'"), 'ContentI18n_MetaDescription_frCA', "", @$this->commentsContentI18n_MetaDescription_frCA, @$this->commentsContentI18n_MetaDescription_frCA_css, ' istinymce', ' ','no','');

            $this->fields['Content']['ContentI18n_MetaTitle_frCA']['html'] = stdFieldRow(_("Meta Title français"), 
        textarea('ContentI18n_MetaTitle_frCA',$dataObj->getTranslation('fr_CA')->getMetaTitle() ,"placeholder='".str_replace("'","&#39;",_('Meta Title fr_CA'))."' cols='71' v='CONTENTI18N_METATITLE_FRCA' otherTabs=1 s='d'   class='' style='' spellcheck='false'"), 'ContentI18n_MetaTitle_frCA', "", @$this->commentsContentI18n_MetaTitle_frCA, @$this->commentsContentI18n_MetaTitle_frCA_css, ' istinymce', ' ','no','');

            $this->fields['Content']['ContentI18n_Name_enUS']['html'] = stdFieldRow(_("Titre anglais"), input('text', 'ContentI18n_Name_enUS',str_replace('"','&quot;',$dataObj->getTranslation('en_US')->getName()), "placeholder='".str_replace("'","&#39;",_('Titre en_US'))."' size='69' otherTabs=1  v='CONTENTI18N_NAME_ENUS' s='d'  class=''")."", 'ContentI18n_Name_enUS', "", @$this->commentsContentI18n_Name_enUS, @$this->commentsContentI18n_Name_enUS_css, '', ' ','no','');

            $this->fields['Content']['ContentI18n_Text_enUS']['html'] = stdFieldRow(_("Contenu anglais"), 
        textarea('ContentI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText() ,"placeholder='".str_replace("'","&#39;",_('Contenu en_US'))."' cols='71' v='CONTENTI18N_TEXT_ENUS' otherTabs=1 s='d'  class='tinymce'  class='' style='' spellcheck='false'"), 'ContentI18n_Text_enUS', "", @$this->commentsContentI18n_Text_enUS, @$this->commentsContentI18n_Text_enUS_css, ' istinymce', ' ','no','');

            $this->fields['Content']['ContentI18n_MetaKeyword_enUS']['html'] = stdFieldRow(_("Meta Keyword anglais"), 
        textarea('ContentI18n_MetaKeyword_enUS',$dataObj->getTranslation('en_US')->getMetaKeyword() ,"placeholder='".str_replace("'","&#39;",_('Meta Keyword en_US'))."' cols='71' v='CONTENTI18N_METAKEYWORD_ENUS' otherTabs=1 s='d'   class='' style='' spellcheck='false'"), 'ContentI18n_MetaKeyword_enUS', "", @$this->commentsContentI18n_MetaKeyword_enUS, @$this->commentsContentI18n_MetaKeyword_enUS_css, ' istinymce', ' ','no','');

            $this->fields['Content']['ContentI18n_MetaDescription_enUS']['html'] = stdFieldRow(_("Meta Description anglais"), 
        textarea('ContentI18n_MetaDescription_enUS',$dataObj->getTranslation('en_US')->getMetaDescription() ,"placeholder='".str_replace("'","&#39;",_('Meta Description en_US'))."' cols='71' v='CONTENTI18N_METADESCRIPTION_ENUS' otherTabs=1 s='d'   class='' style='' spellcheck='false'"), 'ContentI18n_MetaDescription_enUS', "", @$this->commentsContentI18n_MetaDescription_enUS, @$this->commentsContentI18n_MetaDescription_enUS_css, ' istinymce', ' ','no','');

            $this->fields['Content']['ContentI18n_MetaTitle_enUS']['html'] = stdFieldRow(_("Meta Title anglais"), 
        textarea('ContentI18n_MetaTitle_enUS',$dataObj->getTranslation('en_US')->getMetaTitle() ,"placeholder='".str_replace("'","&#39;",_('Meta Title en_US'))."' cols='71' v='CONTENTI18N_METATITLE_ENUS' otherTabs=1 s='d'   class='' style='' spellcheck='false'"), 'ContentI18n_MetaTitle_enUS', "", @$this->commentsContentI18n_MetaTitle_enUS, @$this->commentsContentI18n_MetaTitle_enUS_css, ' istinymce', ' ','no','');

        $this->lockFormField(array(0=>'Slug',1=>'Status',2=>'IdContent',), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->Content['request']['ChildHide']) ){
            
            $ongletTab['0']['t'] = _('Upload d\'images');
            $ongletTab['0']['p'] = 'ContentFile';
            $ongletTab['0']['lkey'] = 'IdContent';
            $ongletTab['0']['fkey'] = 'IdContent';
            $ongletTab['1']['t'] = _('Block');
            $ongletTab['1']['p'] = 'Block';
            $ongletTab['1']['lkey'] = 'IdContent';
            $ongletTab['1']['fkey'] = 'IdContent';
        if(!empty($ongletTab) and $dataObj->getIdContent()){
            foreach($ongletTab as $value){
                if($_SESSION[_AUTH_VAR]->hasRights('Content'.$value['p'], 'r')){
                    
                    $getLocalKey = "get".$value['lkey']."";
                    if($dataObj->$getLocalKey()){
                        @$ChildOnglet .= 
                            li(
 htmlLink(_($value['t']),'javascript:',"p='".$value['p']."' act='list' j=conglet_Content ip='".$dataObj->$getLocalKey()."' class='ui-corner-top ui-state-default' ") 						,"  class='".@$class_has_child."' j=sm  ");
                    }
                }
            }
            if(!empty($ChildOnglet)){
                $childTable['onReadyJs'] ="
                    $('[j=conglet_Content]').unbind('click');
                    $('[j=conglet_Content]').bind('click', function (data){
                         pp = $(this).attr('p');
                         $.post('"._SITE_URL."mod/act/ContentAct.php', {a:'get'+pp+'List', ip:$(this).attr('ip'), ui:  pp+'Table','pui':'".$uiTabsId."',pushPGet:'".json_encode($_GET)."',pushPPOST:'".json_encode($_POST)."'}, function(data){
                            $('#cntContentChild').html(data).show();;
                            $('[j=conglet_Content]').parent().attr('class','ui-corner-top ui-state-default');
                            $('[j=conglet_Content][p=\"'+pp+'\"]').parent().attr('class','ui-corner-top ui-state-default ui-state-active');
                         });
                    });

                ";
                if(@$_SESSION['memoire']['onglet']['Content']['child']['list'][$dataObj->$getLocalKey()]){
                    $onglet_p = $_SESSION['memoire']['onglet']['Content']['child']['list'][$dataObj->$getLocalKey()];
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Content][p=".$onglet_p."]').first().click();";
                }else{
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Content]').first().click();";
                }


            }
        }
        }
        
        
        if($dataObj->getIdContent()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'ContentControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = 
            div(
                input('checkbox','toggle-form',' p="Content" ')
                .label(span(_('Afficher/Cacher le formulaire')),'for="toggle-form"')
            ,'','class="toggle-form" p="Content" data-tooltip="'._('Cacher le formulaire').'"');
            }

        }
        
        
        $titre_form_str = '';
        if($dataObj->getIdContent()){
                   $titre_form_str .= span(strip_tags(_($dataObj->getNameMenu()))," data-name='name_menu' ");
                   $this->siteTitle =set_var($this->siteTitle,strip_tags(_($dataObj->getNameMenu())),' ',false,NULL,false,true);}
        $this->formTitle = p(href("Contenu",_SITE_URL.'Content').$titre_form_str, 'class="breadcrumb"'); 
        $ongletf =
            div(
                ul(li(htmlLink(_('Contenu'),'#ogf_Content',' j="ogf" p="Content" class="ui-tabs-anchor button-link-blue" ')).li(htmlLink(_('Français'),'#ogf_Contenti18nNameFrca',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Content" ')).li(htmlLink(_('Anglais'),'#ogf_Contenti18nNameEnus',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Content" ')))
            ,'cntOngletContent',' class="cntOnglet"')
            .@$close_form
        ;
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addContent_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveContent',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedContent','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdContent', $dataObj->getIdContent(), " otherTabs=1 s='d' pk").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        $mceInclude = loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/ckeditor.js")
            .loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/adapters/jquery.js");
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'ContentControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formContent');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['Content']['tog']) and 
            $_SESSION['memoire']['onglet']['Content']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['Content']['Start']['html']
                
                .
                    '<div id="ogf_Content">'.
$this->fields['Content']['Status']['html']
.$this->fields['Content']['MenuVisible']['html']
.$this->fields['Content']['Slug']['html']
.$this->fields['Content']['Home']['html']
.$this->fields['Content']['Order']['html']
.$this->fields['Content']['IdMenu']['html']
.$this->fields['Content']['NameMenu']['html']
.$this->fields['Content']['Type']['html']
.'</div><div id="ogf_Contenti18nNameFrca"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Content']['ContentI18n_Name_frCA']['html']
.$this->fields['Content']['ContentI18n_Text_frCA']['html']
.$this->fields['Content']['ContentI18n_MetaKeyword_frCA']['html']
.$this->fields['Content']['ContentI18n_MetaDescription_frCA']['html']
.$this->fields['Content']['ContentI18n_MetaTitle_frCA']['html']
.'</div><div id="ogf_Contenti18nNameEnus"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Content']['ContentI18n_Name_enUS']['html']
.$this->fields['Content']['ContentI18n_Text_enUS']['html']
.$this->fields['Content']['ContentI18n_MetaKeyword_enUS']['html']
.$this->fields['Content']['ContentI18n_MetaDescription_enUS']['html']
.$this->fields['Content']['ContentI18n_MetaTitle_enUS']['html'].'</div>'
                
                .@$this->fields['Content']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntContent", "class='divStdform' CntTabs=1 ")
        , "id='formContent' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Contenu"); }
        # if not new, show child table
        if($dataObj->getIdContent()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelContent', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntContentChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['Content']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['Content']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['Content']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    bind_close_form();
    
    ".$jqueryDatePicker."
    bind_ui_active('Content');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    $('#formContent .tinymce').each(function() {
        if (CKEDITOR.instances[$(this).attr('Id')]){
            CKEDITOR.instances[$(this).attr('Id')].destroy();
        }
        ckeTemp = CKEDITOR.replace($(this).attr('Id'), {
            extraAllowedContent: '*(*)[*];sup(*)[*];article(*)[*];section(*)[*];div(*)[*];span(*)'
            ".@$this->ccAddCkeditorInit."
        });
        ckeTemp.on('change',function( evt ){ $('.divtd input[type=\"button\"]').addClass('can-save');});
        ckeTemp.on('key',function( event ){ if(event.data.keyCode ==1114195){ $('form [act=save]').click(); return false;}});
    });
    $(\"[label_lien='IdMenu']\").bind('click', function (){
        if($('#IdMenu').val()){ window.open('"._SITE_URL."Menu/edit/'+$('#IdMenu').val());}else{window.open('"._SITE_URL."Menu/list/');}
    });$('#cntOngletContent').parent().tabs();$('#cntOngletContent').show();
    ".@$childTable['onReadyJs']."
    ".@$error['onReadyJs']."
    ".@$removeEditChild."
    /*try {afterFormLoad();}catch(e){}*/
    if($('#loader').css('display') == 'block') $('#loader').hide();
    $('[j=sftr]').hide();
    ".@$tabs_act."
    ".$this->CcToFormJs
    .@$script_autoc_one."
     setTimeout(function(){ bind_othertabs_std('#divCntContent');},500); 
    ".$toggleForm."
    bind_form('Content','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
        ($dataObj->getMenu())?'':$dataObj->setMenu( new Menu() );
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('fr_CA')->setMetaKeyword('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('fr_CA')->setMetaDescription('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('fr_CA')->setMetaTitle('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('en_US')->setText('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('en_US')->setMetaKeyword('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('en_US')->setMetaDescription('');$dataObj->addContentI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new ContentI18n();$mt->setLocale('en_US')->setMetaTitle('');$dataObj->addContentI18n($mt)->save();}
            
        $this->fieldsRo['Content']['Status']['html'] = stdFieldRow(_("Status"), input('text','Status',$dataObj->getStatus()," readonly s='d'"), 'Status', "", @$this->commentsStatus, @$this->commentsStatus_css, 'readonly', ' ','no','');
$this->fieldsRo['Content']['MenuVisible']['html'] = stdFieldRow(_("menu Visible"), input('text','MenuVisible',$dataObj->getMenuVisible()," readonly s='d'"), 'MenuVisible', "", @$this->commentsMenuVisible, @$this->commentsMenuVisible_css, 'readonly', ' ','no','');
$this->fieldsRo['Content']['Slug']['html'] = stdFieldRow(_("Lien de la page"), input('text','Slug',$dataObj->getSlug()," readonly s='d'"), 'Slug', "", @$this->commentsSlug, @$this->commentsSlug_css, 'readonly', ' ','no','');
$this->fieldsRo['Content']['Home']['html'] = stdFieldRow(_("Accueil"), input('text','Home',$dataObj->getHome()," readonly s='d'"), 'Home', "", @$this->commentsHome, @$this->commentsHome_css, 'readonly', ' ','no','');
$this->fieldsRo['Content']['Order']['html'] = stdFieldRow(_("Ordre du menu"), input('text','Order',$dataObj->getOrder()," readonly s='d'"), 'Order', "", @$this->commentsOrder, @$this->commentsOrder_css, 'readonly', ' ','no','');
$this->fieldsRo['Content']['IdMenu']['html'] = stdFieldRow(htmlLink(_('Hiérarchie'),'javascript:','  label_lien="IdMenu"  class="label_link js-label-link" '), 
                    input('text','IdMenuLabel',$dataObj->getMenu()->getTitle(),"  readonly s='d'")
                    .input('hidden','IdMenu',$dataObj->getIdMenu()," readonly s='d'"), 'IdMenu', "", @$this->commentsIdMenu, @$this->commentsIdMenu_css, 'readonly', ' ','no','');
$this->fieldsRo['Content']['NameMenu']['html'] = stdFieldRow(_("Nom menu"), input('text','NameMenu',$dataObj->getNameMenu()," readonly s='d'"), 'NameMenu', "", @$this->commentsNameMenu, @$this->commentsNameMenu_css, 'readonly', ' ','no','');
$this->fieldsRo['Content']['Type']['html'] = stdFieldRow(_("Type de contenu"), input('text','Type',$dataObj->getType()," readonly s='d'"), 'Type', "", @$this->commentsType, @$this->commentsType_css, 'readonly', ' ','no','');
$this->fieldsRo['Content']['ContentI18n_Name_frCA']['html'] = stdFieldRow(_("Titre français"), input('text','ContentI18n_Name_frCA',$dataObj->getTranslation('fr_CA')->getName()," readonly s='d'"), 'ContentI18n_Name_frCA', "", @$this->commentsContentI18n_Name_frCA, @$this->commentsContentI18n_Name_frCA_css, 'readonly', ' ','no','');
$this->fieldsRo['Content']['ContentI18n_Text_frCA']['html'] = stdFieldRow(_("Contenu français"), textarea('ContentI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText()," readonly class='tinymce'    s='d'"), 'ContentI18n_Text_frCA', "", @$this->commentsContentI18n_Text_frCA, @$this->commentsContentI18n_Text_frCA_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Content']['ContentI18n_MetaKeyword_frCA']['html'] = stdFieldRow(_("Meta Keyword français"), textarea('ContentI18n_MetaKeyword_frCA',$dataObj->getTranslation('fr_CA')->getMetaKeyword()," readonly class=''    s='d'"), 'ContentI18n_MetaKeyword_frCA', "", @$this->commentsContentI18n_MetaKeyword_frCA, @$this->commentsContentI18n_MetaKeyword_frCA_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Content']['ContentI18n_MetaDescription_frCA']['html'] = stdFieldRow(_("Meta Description français"), textarea('ContentI18n_MetaDescription_frCA',$dataObj->getTranslation('fr_CA')->getMetaDescription()," readonly class=''    s='d'"), 'ContentI18n_MetaDescription_frCA', "", @$this->commentsContentI18n_MetaDescription_frCA, @$this->commentsContentI18n_MetaDescription_frCA_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Content']['ContentI18n_MetaTitle_frCA']['html'] = stdFieldRow(_("Meta Title français"), textarea('ContentI18n_MetaTitle_frCA',$dataObj->getTranslation('fr_CA')->getMetaTitle()," readonly class=''    s='d'"), 'ContentI18n_MetaTitle_frCA', "", @$this->commentsContentI18n_MetaTitle_frCA, @$this->commentsContentI18n_MetaTitle_frCA_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Content']['ContentI18n_Name_enUS']['html'] = stdFieldRow(_("Titre anglais"), input('text','ContentI18n_Name_enUS',$dataObj->getTranslation('en_US')->getName()," readonly s='d'"), 'ContentI18n_Name_enUS', "", @$this->commentsContentI18n_Name_enUS, @$this->commentsContentI18n_Name_enUS_css, 'readonly', ' ','no','');
$this->fieldsRo['Content']['ContentI18n_Text_enUS']['html'] = stdFieldRow(_("Contenu anglais"), textarea('ContentI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText()," readonly class='tinymce'    s='d'"), 'ContentI18n_Text_enUS', "", @$this->commentsContentI18n_Text_enUS, @$this->commentsContentI18n_Text_enUS_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Content']['ContentI18n_MetaKeyword_enUS']['html'] = stdFieldRow(_("Meta Keyword anglais"), textarea('ContentI18n_MetaKeyword_enUS',$dataObj->getTranslation('en_US')->getMetaKeyword()," readonly class=''    s='d'"), 'ContentI18n_MetaKeyword_enUS', "", @$this->commentsContentI18n_MetaKeyword_enUS, @$this->commentsContentI18n_MetaKeyword_enUS_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Content']['ContentI18n_MetaDescription_enUS']['html'] = stdFieldRow(_("Meta Description anglais"), textarea('ContentI18n_MetaDescription_enUS',$dataObj->getTranslation('en_US')->getMetaDescription()," readonly class=''    s='d'"), 'ContentI18n_MetaDescription_enUS', "", @$this->commentsContentI18n_MetaDescription_enUS, @$this->commentsContentI18n_MetaDescription_enUS_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Content']['ContentI18n_MetaTitle_enUS']['html'] = stdFieldRow(_("Meta Title anglais"), textarea('ContentI18n_MetaTitle_enUS',$dataObj->getTranslation('en_US')->getMetaTitle()," readonly class=''    s='d'"), 'ContentI18n_MetaTitle_enUS', "", @$this->commentsContentI18n_MetaTitle_enUS, @$this->commentsContentI18n_MetaTitle_enUS_css, 'readonly istinymce', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['Content'] as $field=>$ar){
                $this->fields['Content'][$field]['html'] = $this->fieldsRo['Content'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['Content'][$field]['html'] = $this->fieldsRo['Content'][$field]['html'];
            }
        }
    }
    /*Option function for Content_IdMenu selectBox */
    public function selectBoxContent_IdMenu($dataObj='',$data='', $emptyVal=false,$array=true){
$q = MenuQuery::create();

    $q->addAsColumn('selDisplay', 'CONCAT_WS ( " ", menu.title, "" )');
    $q->select(array('selDisplay', 'IdMenu'));
    $q->orderBy('selDisplay', 'ASC');
if(!$array){return $q;}else{$pcDataO = $q->find();}


$arrayOpt = $pcDataO->toArray();
return assocToNum($arrayOpt , true);
}
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = ContentQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('NameMenu', 'IdContent'));
            
        
        }else{
            $q->select(array('NameMenu', 'IdContent'));
        }
        $pcData = $q->orderBy('NameMenu', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = ContentQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('NameMenu', 'IdContent'));
            
        
        }else{
            $q->select(array('NameMenu', 'IdContent'));
        }
        $pcData = $q->orderBy('NameMenu', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Contenu')), $selected);
        }


        return $return;
    }	#@#############
    #	getChildList
    ###############
    public function getContentFileList($IdContent, $page='1', $uiTabsId='ContentFileTableCntnr', $parentContainer='', $mja_list='', $search='', $params = ''){
        /*init var*/
        global $request;
        if(empty($page)){$page=1;}$param=array();
        if(!empty($_SESSION['memoire']['onglet']['ContentContentFile']['pg'])){$page = $_SESSION['memoire']['onglet']['ContentContentFile']['pg'];}
        if(!empty($search['order'])){$this->searchOrder = $search['order'];}
        
        if(empty($search['ms'])){ $searchAr =$search;}else{$this->searchMs = $search['ms']; }

        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    @$child_order .="
                        $(\"#cntContentChild [th='sorted'][c='".$col."'],#cntContentChild [th='sorted'][rc='".$col."']\").attr('sens','".$sens."');
                        $(\"#cntContentChild [th='sorted'][c='".$col."'],#cntContentChild [th='sorted'][rc='".$col."']\").attr('order','on');
                    ";
                }
            }
        }
        
        if($parentContainer == 'editDialog'){$diagNoClose = "diag:\"noclose\", ";$diagNoCloseEscaped = "diag:\\\"noclose\\\", ";}
        if(isset($this->Content['request']['noHeader']) && $this->Content['request']['noHeader'] == 'true'){$noHeader = "'noHeader':'true',";}
        $data['IdContent'] = $IdContent;

        $dataObj = ContentQuery::create()->findPk($IdContent);
        if($dataObj == null){$dataObj = new Content();$dataObj->setIdContent($IdContent);}
        $this->dataObj =$dataObj;
        

        $this->ContentFile['list_add'] = "
        $('#addContentFile').click(function(){
            $.post('"._SITE_URL."mod/act/ContentFileAct.php', {a:'edit', ui:'editDialog',pc:'Content', je:'ContentFileTableCntnr', jet:'tr', tp:'ContentFile', ip:'".$IdContent."'},
                function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); $('#editDialog').dialog('option','title','".addSlashes(_('Upload d\'images'))."'); });
        });";
        $this->ContentFile['list_delete'] = "
        $(\"[j='deleteContentFile']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Upload d\'images'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."','$.post(\""._SITE_URL."mod/act/ContentFileAct.php\", {".@$diagNoCloseEscaped.@$diagNoClose." a:\"delete\", ui:\"".$uiTabsId."\", i:'+$(this).attr('i')+', ip:\"".$IdContent."\", pc:\"Content\", je:\"ContentFileTableCntnr\", jet:\"tr\"}, function(data){ if(data)$(\"#ContentFileTableCntnr\").append(data);});');
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('ContentContentFile', 'r')){ $this->ContentFile['list_edit'] = "
        $(\"#ContentFileTable[listchild=1] tr[ecf=1] td[j='editContentFile']\").bind('click', function (){
            
        $.post('"._SITE_URL."mod/act/ContentFileAct.php',
                {a:'edit', i:$(this).attr('i'), ip:'".$IdContent."', ui:'editDialog',pc:'Content', je:'ContentFileTableCntnr', jet:'tr', 'it-pos':$(this).data('iterator-pos') },
            function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";}
        $rigthButtonAction="";
        if($_SESSION[_AUTH_VAR]->hasRights('ContentContentFile', 'w')){
            $rigthButtonAction='';
        }
        $filterKey = $IdContent;
        
        $maxPerPage = (!empty($this->ContentFile['request']['maxperpage']))?$this->ContentFile['request']['maxperpage']:_paging_nbr_per_page;
        try{
            $q = ContentFileQuery::create();
            
            
            $q ->filterByIdContent( $filterKey );;  
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
        
        
        
        
        
        
        if(isset($this->Content['request']['noHeader']) && $this->Content['request']['noHeader'] == 'true'){
            $header_search = "";
        }else{
            $header_search = ''
        .div(
            
            form('' , " CntTabs=1 id='formMsContentFile'")
        ,'',' class="msSearchCtnr"')
        .div($rigthButtonAction, '', 'class="ac-right-action-buttons"')
        .button(span(_("Afficher le menu"),'data-tooltip="'.addslashes("Afficher le menu").'" '),'class="toggle-child-nav-btn"');
        }
        
        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('ContentContentFile', 'd') and empty($this->readOnlyFilter)){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( @$this->cCmoreColsHeaderFirstContentFile.th(_("Name"), " th='sorted'  rcColone='Name' c='Name'  ").th(_("Description"), " th='sorted'  rcColone='Desc' c='Desc'  ").th(_("Ordre"), " th='sorted'  rcColone='Index' c='Index'  ").th(_("Visible"), " th='sorted'  rcColone='Current' c='Current'  ").th(_("Poids"), " th='sorted'  rcColone='Size' c='Size'  ").$this->cCmoreColsHeaderContentFile.th('Fichier', "id='bulkOpTh'").$actionRowHeader, " ln='ContentFile' class=''");
        $i=0;
        if(empty($pmpoData) || !method_exists($pmpoData,'isEmpty')){
            @$tr .= tr(	td(p(span(_("Une erreur est survenue veuillez vider votre recherche.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='ContentFile' colspan='100%' "));
            
        }else if( $pmpoData->isEmpty() ){
            @$tr .= tr(	td(p(span(_("Aucun enregistrement pour le moment.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='ContentFile' colspan='100%' "));
            
        }else{
            
            foreach($pmpoData as $data){
                
                
                if(function_exists("mime_content_type")){
                    $fileMime = mime_content_type(_BASE_DIR.$data->getFichier());
                    $fileType = substr($fileMime, 0, strpos($fileMime, '/'));
                    switch($fileType){
                        case 'image': $fileIcon = img(_SITE_URL.str_replace(array('#',' '),array('%23','%20'),$data->getFichier()),'','',' style="max-height:50px;"'); break;
                        default: $fileIcon = span(_("Fichier"),'class="icon file"'); break;
                    }
                }else{
                    $fileIcon = img(_SITE_URL.$data->getFichier()."?pc=Content&token=".MD5(_ENCODE.$data->getPrimaryKey())."|".MD5(_ENCODE.$_SESSION[_AUTH_VAR]->get('id')),'','',' style="max-height:50px;"');
                }
                
                $actionRow = '';
                
                $this->ListActionRowContentFile = (!empty($this->cCListActionRowContentFile))?str_replace('%idpk%', json_encode($data->getPrimaryKey()), $this->cCListActionRowContentFile):$this->ListActionRowContentFile;
                $this->ListActionRowContentFile = (!empty($this->cCListActionRowContentFile))?str_replace('%i%', $i, $this->ListActionRowContentFile):$this->ListActionRowContentFile;
                
                if($_SESSION[_AUTH_VAR]->hasRights('ContentContentFile', 'd') and empty($this->readOnlyFilter) ){$actionRow = htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteContentFile' i='".json_encode($data->getPrimaryKey())."'");}
                
                $imgPath = $data->getFichier()."?pc=Content&token=".MD5(_ENCODE.$data->getPrimaryKey())."|".MD5(_ENCODE.$_SESSION[_AUTH_VAR]->get('id'));
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
        $url = _SITE_URL.$data->getFichier()."?pc=Content&token=".MD5(_ENCODE.$data->getPrimaryKey())."|".MD5(_ENCODE.$_SESSION[_AUTH_VAR]->get('id'));
    $actionRow .= htmlLink($imgPath,$url, "  j='imageContentFile' i='".$data->getPrimaryKey()."' ");
                
                

                $actionRow = $actionRow;
                $addClass='';
                $cnt= substr_count($actionRow,'<a');
                if($cnt){ $addClass=' actionrow'.$cnt;}
                $actionRow = (!empty($actionRow))?td($this->ListActionRowContentFile.$actionRow," class='actionrow ".$addClass."'"):"";
                
                
                
                ;
                
                if(isset($this->search['highlight']) && is_array($this->search['highlight'])){
                    $highlight = (in_array(json_encode($data->getPrimaryKey()), $this->search['highlight']))?'highlight':'';
                }
                
                $child_edit_columns_filter ="1";
    
                @$tr .= 
                        tr(
                            @$cCmoreColsContentFileFirst.
                            td(span(strip_tags((isset($altValue['Name']) and $altValue['Name'])?$altValue['Name']:$data->getName()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Name").":\" j='editContentFile'  i='".json_encode($data->getPrimaryKey())."' c='Name'  ")
                            .td(span(strip_tags((isset($altValue['Desc']) and $altValue['Desc'])?$altValue['Desc']:mb_substr(strip_tags($data->getDesc()),0,50, 'UTF-8')." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Description").":\" j='editContentFile'  i='".json_encode($data->getPrimaryKey())."' c='Desc'  ")
                            .td(span(strip_tags((isset($altValue['Index']) and $altValue['Index'])?$altValue['Index']:$data->getIndex()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Ordre").":\" j='editContentFile'  i='".json_encode($data->getPrimaryKey())."' c='Index'  ")
                            .td(span(strip_tags((isset($altValue['Current']) and $altValue['Current'])?$altValue['Current']:isntPo($data->getCurrent())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Visible").":\" j='editContentFile'  i='".json_encode($data->getPrimaryKey())."' c='Current'  ")
                            .td(span(strip_tags((isset($altValue['Size']) and $altValue['Size'])?$altValue['Size']:$data->getSize()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Poids").":\" j='editContentFile'  i='".json_encode($data->getPrimaryKey())."' c='Size'  ")
                            .
                            
                            @$cCmoreColsContentFile.td(htmlLink($fileIcon, _SITE_URL.str_replace(array('#',' '),array('%23','%20'),$data->getFichier())."?pc=Content&token=".MD5(_ENCODE.$data->getPrimaryKey())."|".MD5(_ENCODE.$_SESSION[_AUTH_VAR]->get('id')), "class='file-link' target='_blank'"),'class="file-row"').
                            @$actionRow
                        ,"id='ContentFileRow".$data->getPrimaryKey()."' data-id='".$data->getPrimaryKey()."' data-pc-table='Content' data-table='ContentFile' data-edit='Upload d'images #".$data->getPrimaryKey()."' ecf='".$child_edit_columns_filter."' ln='ContentFile' class=' ".@$highlight.@$param['class']."'  ")
                        ;
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(div(@$total_child,'','class="nolink"')
                            ,'trContentFile'," style='".@$hide_ContentFile."' ln='ContentFile' class=''").@$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    
    if(($_SESSION[_AUTH_VAR]->hasRights('ContentContentFile', 'a')) ){
        $add_button_child =""
            .div(
                htmlLink(
                    span(_("Ajouter"))
                , "Javascript:","id='pickfiles' class='button-link-blue add-button'")

            .div('', 'filelist')
            ,'upload-ContentFile',' class="listHeaderItem " ');
        ;
    }
    
    
    //@PAGINATION
    if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
        $ext = '';
        $table_name = 'upload d\'images';
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
                    ,'','id="ContentFilePagination"')
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
                 $this->CcToContentFileListTop
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
                                    .$this->CcToContentFileTableFooter
                                , "id='ContentFileTable' listchild=1 class='tablesorter'")
                            , 'formContentFile')
                            .$this->CcToContentFileListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list contentHolderList" ')

                    .@$pagerRow
                ,'ContentFileListForm')
            ,'cntContentFiledivChild',' class="" ');
            

                    @$return['js'] .= "
bindChangePic('ContentFile','Content');
$(function(){
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,html4',
        browse_button : 'pickfiles',
        container: document.getElementById('upload-ContentFile'),
        url: '"._SITE_URL_NO_S."mod/act/ContentFileAct.php?a=file&pc=Content&ip=".$filterKey."&IdUser=".$_SESSION[_AUTH_VAR]->get('id')."&blob=',
        flash_swf_url : '"._SITE_URL."/js/plupload/Moxie.swf',
        drop_element : 'pickfiles',

        filters : {\"max_file_size\":\"10mb\",\"mime_types\":[{\"title\":\"images\",\"extensions\":\"jpg,png,pdf,doc,docx\"}]},
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
                $('[j=conglet_Content][p=\"ContentFile\"]').click();

            }
        }
    });
    uploader.init();
});";

            $jqueryDatePickerChild = "beforeDatePicker('');";
            @$return['js'] .= "
                
                
            ";
            $return['onReadyJs'] =
                @$this->CcToContentFileListJsFirst
                .$this->ContentFile['list_add']
                .$this->ContentFile['list_delete']
                .$this->ContentFile['list_edit']
            ."
                
                
            ".@$total_child_js."
            
            
            
            child_button_bind('ContentFile');
            child_pagination_bind('ContentFile','Content','".$uiTabsId."','".$IdContent."','','".$this->CcToSearchMsPost."');
            child_pagination_sorted_bind('ContentFile','Content','".$uiTabsId."','".$IdContent."','".$this->CcToSearchMsPost."');
               
            $('#cntContentChild .js-select-label').SelectBox();
            
            ".@$child_order."
            
            
            $('#formContent .divtr.readonly .divtd[in=\"inSlug\"] label.readonly').text('".addslashes($dataObj->getSlug())."');
            $('#formContent #Slug').val('".addslashes($dataObj->getSlug())."');
            $('#formContent .divtr.readonly .divtd[in=\"inStatus\"] label.readonly').text('".addslashes($dataObj->getStatus())."');
            $('#formContent #Status').val('".addslashes($dataObj->getStatus())."');
            $('#formContent .divtr.readonly .divtd[in=\"inIdContent\"] label.readonly').text('".addslashes($dataObj->getIdContent())."');
            $('#formContent #IdContent').val('".addslashes($dataObj->getIdContent())."');
            ".$jqueryDatePickerChild."
            ";
            $return['onReadyJs'] .= "".$this->CcToContentFileListJs;
            return $return;
    }	#@#############
    #	getChildList
    ###############
    public function getBlockList($IdContent, $page='1', $uiTabsId='BlockTableCntnr', $parentContainer='', $mja_list='', $search='', $params = ''){
        /*init var*/
        global $request;
        if(empty($page)){$page=1;}$param=array();
        if(!empty($_SESSION['memoire']['onglet']['ContentBlock']['pg'])){$page = $_SESSION['memoire']['onglet']['ContentBlock']['pg'];}
        if(!empty($search['order'])){$this->searchOrder = $search['order'];}
        
        if(empty($search['ms'])){ $searchAr =$search;}else{$this->searchMs = $search['ms']; }

        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    @$child_order .="
                        $(\"#cntContentChild [th='sorted'][c='".$col."'],#cntContentChild [th='sorted'][rc='".$col."']\").attr('sens','".$sens."');
                        $(\"#cntContentChild [th='sorted'][c='".$col."'],#cntContentChild [th='sorted'][rc='".$col."']\").attr('order','on');
                    ";
                }
            }
        }
        
        if($parentContainer == 'editDialog'){$diagNoClose = "diag:\"noclose\", ";$diagNoCloseEscaped = "diag:\\\"noclose\\\", ";}
        if(isset($this->Content['request']['noHeader']) && $this->Content['request']['noHeader'] == 'true'){$noHeader = "'noHeader':'true',";}
        $data['IdContent'] = $IdContent;

        $dataObj = ContentQuery::create()->findPk($IdContent);
        if($dataObj == null){$dataObj = new Content();$dataObj->setIdContent($IdContent);}
        $this->dataObj =$dataObj;
        

        $this->Block['list_add'] = "
        $('#addBlock').click(function(){
            $.post('"._SITE_URL."mod/act/BlockAct.php', {a:'edit', ui:'editDialog',pc:'Content', je:'BlockTableCntnr', jet:'tr', tp:'Block', ip:'".$IdContent."'},
                function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); $('#editDialog').dialog('option','title','".addSlashes(_('Block'))."'); });
        });";
        $this->Block['list_delete'] = "
        $(\"[j='deleteBlock']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Block'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."','$.post(\""._SITE_URL."mod/act/BlockAct.php\", {".@$diagNoCloseEscaped.@$diagNoClose." a:\"delete\", ui:\"".$uiTabsId."\", i:'+$(this).attr('i')+', ip:\"".$IdContent."\", pc:\"Content\", je:\"BlockTableCntnr\", jet:\"tr\"}, function(data){ if(data)$(\"#BlockTableCntnr\").append(data);});');
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('ContentBlock', 'r')){ $this->Block['list_edit'] = "
        $(\"#BlockTable[listchild=1] tr[ecf=1] td[j='editBlock']\").bind('click', function (){
            location.href = '"._SITE_URL."Block/edit/'+$(this).attr('i')+'?tp=Block&ip=".$IdContent."&pc=Content';
        });";}
        $rigthButtonAction="";
        if($_SESSION[_AUTH_VAR]->hasRights('ContentBlock', 'w')){
            $rigthButtonAction='';
        }
        $filterKey = $IdContent;
        
        $maxPerPage = (!empty($this->Block['request']['maxperpage']))?$this->Block['request']['maxperpage']:_paging_nbr_per_page;
        try{
            $q = BlockQuery::create();
            
            
            $q
->leftJoin('Content')
        ->leftJoin('BlockRelatedByIdParent a4') ->filterByIdContent( $filterKey );;  
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
        
        
        
        
        
        
        if(isset($this->Content['request']['noHeader']) && $this->Content['request']['noHeader'] == 'true'){
            $header_search = "";
        }else{
            $header_search = ''
        .div(
            
            form('' , " CntTabs=1 id='formMsBlock'")
        ,'',' class="msSearchCtnr"')
        .div($rigthButtonAction, '', 'class="ac-right-action-buttons"')
        .button(span(_("Afficher le menu"),'data-tooltip="'.addslashes("Afficher le menu").'" '),'class="toggle-child-nav-btn"');
        }
        
        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('ContentBlock', 'd') and empty($this->readOnlyFilter)){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( @$this->cCmoreColsHeaderFirstBlock.th(_("Titre"), " th='sorted'  rcColone='Title' c='Title'  ").th(_("Status"), " th='sorted'  rcColone='Status' c='Status'  ").th(_("Type de block"), " th='sorted'  rcColone='Type' c='Type'  ").th(_("Block parent"), " th='sorted'  rcColone='IdParent' c='BlockRelatedByIdParent.Title' rc='BlockRelatedByIdParent.Title' ").th(_("Ordre d'affichage"), " th='sorted'  rcColone='Order' c='Order'  ").th(_("Affichage"), " th='sorted'  rcColone='Display' c='Display'  ").$this->cCmoreColsHeaderBlock.$actionRowHeader, " ln='Block' class=''");
        $i=0;
        if(empty($pmpoData) || !method_exists($pmpoData,'isEmpty')){
            @$tr .= tr(	td(p(span(_("Une erreur est survenue veuillez vider votre recherche.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='Block' colspan='100%' "));
            
        }else if( $pmpoData->isEmpty() ){
            @$tr .= tr(	td(p(span(_("Aucun enregistrement pour le moment.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='Block' colspan='100%' "));
            
        }else{
            
            foreach($pmpoData as $data){
                
                
                $actionRow = '';
                
                $this->ListActionRowBlock = (!empty($this->cCListActionRowBlock))?str_replace('%idpk%', json_encode($data->getPrimaryKey()), $this->cCListActionRowBlock):$this->ListActionRowBlock;
                $this->ListActionRowBlock = (!empty($this->cCListActionRowBlock))?str_replace('%i%', $i, $this->ListActionRowBlock):$this->ListActionRowBlock;
                
                if($_SESSION[_AUTH_VAR]->hasRights('ContentBlock', 'd') and empty($this->readOnlyFilter) ){$actionRow = htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteBlock' i='".json_encode($data->getPrimaryKey())."'");}
                
                
                
                

                $actionRow = $actionRow;
                $addClass='';
                $cnt= substr_count($actionRow,'<a');
                if($cnt){ $addClass=' actionrow'.$cnt;}
                $actionRow = (!empty($actionRow))?td($this->ListActionRowBlock.$actionRow," class='actionrow ".$addClass."'"):"";
                
        $altValue['BlockRelatedByIdParent_Title'] = "";
        if($data->getBlockRelatedByIdParent()){
            $altValue['BlockRelatedByIdParent_Title'] = $data->getBlockRelatedByIdParent()->getTitle();
        }
                
                
                ;
                
                if(isset($this->search['highlight']) && is_array($this->search['highlight'])){
                    $highlight = (in_array(json_encode($data->getPrimaryKey()), $this->search['highlight']))?'highlight':'';
                }
                
                $child_edit_columns_filter ="1";
    
                @$tr .= 
                        tr(
                            @$cCmoreColsBlockFirst.
                            td(span(strip_tags((isset($altValue['Title']) and $altValue['Title'])?$altValue['Title']:$data->getTitle()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Titre").":\" j='editBlock'  i='".json_encode($data->getPrimaryKey())."' c='Title'  ")
                            .td(span(strip_tags((isset($altValue['Status']) and $altValue['Status'])?$altValue['Status']:isntPo($data->getStatus())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Status").":\" j='editBlock'  i='".json_encode($data->getPrimaryKey())."' c='Status'  ")
                            .td(span(strip_tags((isset($altValue['Type']) and $altValue['Type'])?$altValue['Type']:isntPo($data->getType())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Type de block").":\" j='editBlock'  i='".json_encode($data->getPrimaryKey())."' c='Type'  ")
                            .td(span(strip_tags((isset($altValue['IdParent']) and $altValue['IdParent'])?$altValue['IdParent']:$altValue['BlockRelatedByIdParent_Title']." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Block parent").":\" j='editBlock'  i='".json_encode($data->getPrimaryKey())."' c='IdParent'  ")
                            .td(span(strip_tags((isset($altValue['Order']) and $altValue['Order'])?$altValue['Order']:$data->getOrder()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Ordre d'affichage").":\" j='editBlock'  i='".json_encode($data->getPrimaryKey())."' c='Order'  ")
                            .td(span(strip_tags((isset($altValue['Display']) and $altValue['Display'])?$altValue['Display']:isntPo($data->getDisplay())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Affichage").":\" j='editBlock'  i='".json_encode($data->getPrimaryKey())."' c='Display'  ")
                            .
                            
                            @$cCmoreColsBlock.
                            @$actionRow
                        ,"id='BlockRow".$data->getPrimaryKey()."' data-id='".$data->getPrimaryKey()."' data-pc-table='Content' data-table='Block' data-edit='Block #".$data->getPrimaryKey()."' ecf='".$child_edit_columns_filter."' ln='Block' class=' ".@$highlight.@$param['class']."'  ")
                        ;
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(div(@$total_child,'','class="nolink"')
                            ,'trBlock'," style='".@$hide_Block."' ln='Block' class=''").@$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    
    if(($_SESSION[_AUTH_VAR]->hasRights('ContentBlock', 'a')) ){
        $add_button_child =htmlLink(span(_("Ajouter")), "Javascript:","id='addBlock' class='button-link-blue add-button'");
    }
    
    
    //@PAGINATION
    if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
        $ext = '';
        $table_name = 'block';
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
                    ,'','id="BlockPagination"')
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
                 $this->CcToBlockListTop
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
                                    .$this->CcToBlockTableFooter
                                , "id='BlockTable' listchild=1 class='tablesorter'")
                            , 'formBlock')
                            .$this->CcToBlockListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list contentHolderList" ')

                    .@$pagerRow
                ,'BlockListForm')
            ,'cntBlockdivChild',' class="" ');
            

                    @$return['js'] .= "
bindChangePic('ContentFile','Content');
$(function(){
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,html4',
        browse_button : 'pickfiles',
        container: document.getElementById('upload-ContentFile'),
        url: '"._SITE_URL_NO_S."mod/act/ContentFileAct.php?a=file&pc=Content&ip=".$filterKey."&IdUser=".$_SESSION[_AUTH_VAR]->get('id')."&blob=',
        flash_swf_url : '"._SITE_URL."/js/plupload/Moxie.swf',
        drop_element : 'pickfiles',

        filters : {\"max_file_size\":\"10mb\",\"mime_types\":[{\"title\":\"images\",\"extensions\":\"jpg,png,pdf,doc,docx\"}]},
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
                $('[j=conglet_Content][p=\"ContentFile\"]').click();

            }
        }
    });
    uploader.init();
});";

            $jqueryDatePickerChild = "beforeDatePicker('');";
            @$return['js'] .= "
                
                
            ";
            $return['onReadyJs'] =
                @$this->CcToBlockListJsFirst
                .$this->Block['list_add']
                .$this->Block['list_delete']
                .$this->Block['list_edit']
            ."
                
                
            ".@$total_child_js."
            
            
            
            child_button_bind('Block');
            child_pagination_bind('Block','Content','".$uiTabsId."','".$IdContent."','','".$this->CcToSearchMsPost."');
            child_pagination_sorted_bind('Block','Content','".$uiTabsId."','".$IdContent."','".$this->CcToSearchMsPost."');
               
            $('#cntContentChild .js-select-label').SelectBox();
            
            ".@$child_order."
            
            
            $('#formContent .divtr.readonly .divtd[in=\"inSlug\"] label.readonly').text('".addslashes($dataObj->getSlug())."');
            $('#formContent #Slug').val('".addslashes($dataObj->getSlug())."');
            $('#formContent .divtr.readonly .divtd[in=\"inStatus\"] label.readonly').text('".addslashes($dataObj->getStatus())."');
            $('#formContent #Status').val('".addslashes($dataObj->getStatus())."');
            $('#formContent .divtr.readonly .divtd[in=\"inIdContent\"] label.readonly').text('".addslashes($dataObj->getIdContent())."');
            $('#formContent #IdContent').val('".addslashes($dataObj->getIdContent())."');
            ".$jqueryDatePickerChild."
            ";
            $return['onReadyJs'] .= "".$this->CcToBlockListJs;
            return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'ContentAct.php';
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
        $this->cCmoreColsHeaderContentFile = '';
        $this->ListActionRowContentFile = '';
        $this->cCmoreColsContentFile = '';
        $this->CcToContentFileTableFooter = '';
        $this->CcToContentFileListTop = '';
        $this->CcToContentFileListBottom = '';
        $this->CcToContentFileListJs = '';
        
        # child list
        $this->cCmoreColsHeaderBlock = '';
        $this->ListActionRowBlock = '';
        $this->cCmoreColsBlock = '';
        $this->CcToBlockTableFooter = '';
        $this->CcToBlockListTop = '';
        $this->CcToBlockListBottom = '';
        $this->CcToBlockListJs = '';
        
    }

    
}
