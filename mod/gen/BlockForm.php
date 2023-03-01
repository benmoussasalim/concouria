<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'Block' table.
 *
 */
class BlockForm extends Block{
public $tableName="Block";
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
        $q = BlockQuery::create();
        if($this->CcToSearchList){ getSelectFilter($this->CcToSearchList,$q);}
        if(is_array($this->searchAr)){
            array_walk_recursive ($this->searchAr, function (&$v){$v=trim($v);});
            ## query sub-Menu
            if(@$this->searchAr['v'] && !$this->searchAr['uv']){
                $filterStr = "filterBy".$this->searchAr['f'];
                $q
->leftJoin('Content')
        ->leftJoin('BlockRelatedByIdParent a4')
                    ->$filterStr($this->searchAr['v']);
                    
                    
            }elseif(@$this->searchAr['u'] && $this->searchAr['uv']){
                $useStr = "use".$this->searchAr['u']."Query";
                $filterStr = "filterBy".$this->searchAr['f'];
                $q->$useStr()->$filterStr($this->searchAr['uv'])->endUse()
                    
->leftJoin('Content')
        ->leftJoin('BlockRelatedByIdParent a4');
            }else{
                $q
->leftJoin('Content')
        ->leftJoin('BlockRelatedByIdParent a4');
            }
        }else{
            if(is_array($this->searchMs )){
                array_walk_recursive($this->searchMs, function (&$v){$v=trim($v);});
                $q
->leftJoin('Content')
        ->leftJoin('BlockRelatedByIdParent a4');
                if(isset($this->searchMs['Title']) and $this->searchMs['Title'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Title']) and strpos($this->searchMs['Title'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Title'] != '%DoNothing%' AND $this->searchMs['Title'][0] != '%DoNothing%'){
                        $q->filterByTitle("%".$this->searchMs['Title']."%", Criteria::LIKE);
                    }
                }
            }else{
                
            if(json_decode($IdParent)){
                $pmpoData = BlockQuery::create()->filterByIdContent(json_decode($IdParent))
                    
->leftJoin('Content')
        ->leftJoin('BlockRelatedByIdParent a4')
                    
                    ->paginate($page, $maxPerPage);
            }
                $hasParent = json_decode($IdParent);
                if(empty($hasParent)){
                    $q
->leftJoin('Content')
        ->leftJoin('BlockRelatedByIdParent a4');
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
        
         $q->groupBy('IdBlock');
        
        $this->pmpoData =  $q;
        //echo $q->toString();
        //$q->paginate($page, $maxPerPage);
        return $this->pmpoData;
    }
    public function getListHeader($act){
        switch($act){
            case 'head':
            ###### TH
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Titre"), " th='sorted'  rcColone='Title' c='Title'  ").th(_("Status"), " th='sorted'  rcColone='Status' c='Status'  ").th(_("Type de block"), " th='sorted'  rcColone='Type' c='Type'  ").th(_("Block parent"), " th='sorted'  rcColone='IdParent' c='BlockRelatedByIdParent.Title' rc='BlockRelatedByIdParent.Title' ").th(_("Ordre d'affichage"), " th='sorted'  rcColone='Order' c='Order'  ").th(_("Affichage"), " th='sorted'  rcColone='Display' c='Display'  "). $this->cCmoreColsHeader;
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
                
        if(in_array('IdContent',$array_search_tb)){$this->arrayIdContentOptions = $this->selectBoxBlock_IdContent(@$dataObj, @$data);}
        if(in_array('IdParent',$array_search_tb)){$this->arrayIdParentOptions = $this->selectBoxBlock_IdParent(@$dataObj, @$data);}
                unset($data);$data['Title'] = (!empty($this->searchMs['Title']))?$this->searchMs['Title']:'';
        
                
        @$this->fieldsSearch['Block']['Title'] = div(input('text', 'Title', $this->searchMs['Title'], ' othertabs=1  placeholder="'._('Nom').'"',''),'','class="ac-search-item ms-Title"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msBlockAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['Block']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msBlockBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msBlockBtClear" class="icon clear"')
               .@$this->fieldsSearch['Block']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['Block']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-BlockSearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['Block']['Start'].
                    $this->fieldsSearch['Block']['Title'].
                @$this->fieldsSearch['Block']['End'].
            $this->fieldsSearch['Block']['Button']
            ,"id='formMsBlock' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('Block', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."Block/edit/", "id='addBlock' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addBlockAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Block");
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
        if(!empty($_SESSION['memoire']['onglet']['Block']['pg'])){
            $page = $_SESSION['memoire']['onglet']['Block']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'BlockAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'BlockAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
            $search_child_default['Order']='ASC';
        if(empty($this->searchOrder)){$this->searchOrder = $search_child_default;}
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#BlockListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#BlockListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('Block', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('Block', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('Block', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteBlock' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
        $altValue['BlockRelatedByIdParent_Title'] = "";
        if($data->getBlockRelatedByIdParent()){
            $altValue['BlockRelatedByIdParent_Title'] = $data->getBlockRelatedByIdParent()->getTitle();
        }
                
                
                
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['Title']) and $altValue['Title'])?$altValue['Title']:$data->getTitle()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Titre").":\" j='editBlock'  i='".json_encode($data->getPrimaryKey())."' c='Title'  ")
                            .td(span(strip_tags((isset($altValue['Status']) and $altValue['Status'])?$altValue['Status']:isntPo($data->getStatus())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Status").":\" j='editBlock'  i='".json_encode($data->getPrimaryKey())."' c='Status'  ")
                            .td(span(strip_tags((isset($altValue['Type']) and $altValue['Type'])?$altValue['Type']:isntPo($data->getType())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Type de block").":\" j='editBlock'  i='".json_encode($data->getPrimaryKey())."' c='Type'  ")
                            .td(span(strip_tags((isset($altValue['IdParent']) and $altValue['IdParent'])?$altValue['IdParent']:$altValue['BlockRelatedByIdParent_Title']." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Block parent").":\" j='editBlock'  i='".json_encode($data->getPrimaryKey())."' c='IdParent'  ")
                            .td(span(strip_tags((isset($altValue['Order']) and $altValue['Order'])?$altValue['Order']:$data->getOrder()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Ordre d'affichage").":\" j='editBlock'  i='".json_encode($data->getPrimaryKey())."' c='Order'  ")
                            .td(span(strip_tags((isset($altValue['Display']) and $altValue['Display'])?$altValue['Display']:isntPo($data->getDisplay())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Affichage").":\" j='editBlock'  i='".json_encode($data->getPrimaryKey())."' c='Display'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='BlockRow".$data->getPrimaryKey()."'
                    data-table='Block' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountBlock', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Block';

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
                            ,'','id="BlockPagination"')
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
                .div($controlsContent.$this->CcCustomControl,'BlockControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='BlockTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'BlockListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#BlockListForm [j='deleteBlock']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Block'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msBlockBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msBlockBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#BlockListForm tr[ecf=1] td[j='editBlock']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."Block/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."Block/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Block'
                ,'IdBlock'
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
        $(\"#BlockListForm [j='deleteBlock']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Block'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msBlockBt\').length>0){ $(\'#msBlockBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'BlockTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntBlockListForm #addBlock').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'BlockTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#BlockListForm tr[ecf=1] td[j='editBlock']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'BlockTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Block'
                ,'IdBlock'
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
        pagination_bind('Block','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#BlockListForm [j='deleteBlock']\").unbind('click');
        $('#BlockListForm #addBlock').unbind('click');
        $(\"#BlockListForm tr[ecf=1] td[j='editBlock']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#BlockListForm [j='button']\").unbind();   
        pagination_sorted_bind('Block','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('Block','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('Block','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_Block($data){

        unset($data['IdBlock']);
        $e = new Block();
        
        
        if($data['Status'] == ''){unset($data['Status']);}
        if($data['Type'] == ''){unset($data['Type']);}
        if($data['Position'] == ''){unset($data['Position']);}
        if($data['Display'] == ''){unset($data['Display']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setIdContent(($data['IdContent']=='')?null:$data['IdContent']);
        $e->setStatus(($data['Status']=='')?null:$data['Status']);
        $e->setType(($data['Type']=='')?null:$data['Type']);
        $e->setIdParent(($data['IdParent']=='')?null:$data['IdParent']);
        $e->setPosition(($data['Position']=='')?null:$data['Position']);
        $e->setDisplay(($data['Display']=='')?null:$data['Display']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_Block($data){

        
        $e = BlockQuery::create()->findPk(json_decode($data['i']));
        
        
        if($data['Status'] == ''){unset($data['Status']);}
        if($data['Type'] == ''){unset($data['Type']);}
        if($data['Position'] == ''){unset($data['Position']);}
        if($data['Display'] == ''){unset($data['Display']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['IdContent'])){$e->setIdContent(($data['IdContent']=='')?null:$data['IdContent']);}
        if(isset($data['Status'])){$e->setStatus(($data['Status']=='')?null:$data['Status']);}
        if(isset($data['Type'])){$e->setType(($data['Type']=='')?null:$data['Type']);}
        if(isset($data['IdParent'])){$e->setIdParent(($data['IdParent']=='')?null:$data['IdParent']);}
        if(isset($data['Position'])){$e->setPosition(($data['Position']=='')?null:$data['Position']);}
        if(isset($data['Display'])){$e->setDisplay(($data['Display']=='')?null:$data['Display']);}
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of Block
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
        $je= "BlockTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['Block']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['Block']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addBlock_child').bind('click.addBlock', function (){
                    $.post('"._SITE_URL."mod/act/BlockAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addBlock_child').bind('click.addBlock', function (){
                document.location= '"._SITE_URL."Block/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = BlockQuery::create()->leftJoin('Content') ->leftJoin('BlockRelatedByIdParent a4');
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Block', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Block','w',$dataObj)) 
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
                    $('#formBlock #saveBlock').removeAttr('disabled');
                    $('#formBlock #saveBlock').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formBlock #saveBlock').css('cursor', 'default');
                    if($('#formBlock #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formBlock #saveBlock').bind('click.saveBlock', function (data){
                    $('#formBlock #saveBlock').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formBlock #saveBlock').css('cursor', 'progress');
                    $('#formBlock #saveBlock').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formBlock .tinymce').each(function(index) {
                        eval(' $(\"#formBlock #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formBlock select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formBlock\").find(\"[s='d']\").serializeArray();
                        $('#formBlock select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formBlock\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/BlockAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formBlock #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formBlock #formChangedBlock').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formBlock #saveBlock').unbind('click.saveBlock');
                $('#formBlock #saveBlock').remove();";
        }
        
        if($dataObj == null){
            $this->Block['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Block();
            $this->Block['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
            if($data['ip']){
                $strPkParent = "setIdContent";
                $dataObj->$strPkParent($data['ip']);
            }
        }

        ($dataObj->getContent())?'':$dataObj->setContent( new Content() );
        ($dataObj->getBlockRelatedByIdParent())?'':$dataObj->setBlockRelatedByIdParent( new Block() );
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new BlockI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addBlockI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new BlockI18n();$mt->setLocale('en_US')->setText('');$dataObj->addBlockI18n($mt)->save();}

        
        $this->arrayIdContentOptions = $this->selectBoxBlock_IdContent(@$dataObj, @$data);
        $this->arrayIdParentOptions = $this->selectBoxBlock_IdParent(@$dataObj, @$data);
        
        
        
        
        
        

            $this->fields['Block']['IdContent']['html'] = stdFieldRow(htmlLink(_('Contenu associé'),'javascript:','  label_lien="IdContent"  class="label_link js-label-link" '), selectboxCustomArray('IdContent', $this->arrayIdContentOptions, _(_('Contenu associé')), "v='ID_CONTENT'  s='d' otherTabs=1  val='".$dataObj->getIdContent()."'", $dataObj->getIdContent()), 'IdContent', "", @$this->commentsIdContent, @$this->commentsIdContent_css, '', ' ','no','');

            $this->fields['Block']['Title']['html'] = stdFieldRow(_("Titre"), input('text', 'Title',str_replace('"','&quot;',$dataObj->getTitle()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Titre'))."' size='69'  v='TITLE' s='d' class=''")."", 'Title', "", @$this->commentsTitle, @$this->commentsTitle_css, '', ' ','no','');

            $this->fields['Block']['Status']['html'] = stdFieldRow(_("Status"), selectboxCustomArray('Status', array( '0' => array('0'=>_("Brouillon"), '1'=>'Brouillon'),'1' => array('0'=>_("Publié"), '1'=>'Publié'),'2' => array('0'=>_("Désactivé"), '1'=>'Désactivé'), ), _('Status'), "s='d' otherTabs=1  ", $dataObj->getStatus()), 'Status', "", @$this->commentsStatus, @$this->commentsStatus_css, '', ' ','no','');

            $this->fields['Block']['Type']['html'] = stdFieldRow(_("Type de block"), selectboxCustomArray('Type', array( '0' => array('0'=>_("Contenu fixe"), '1'=>'Contenu fixe'),'1' => array('0'=>_("Contenu dynamique"), '1'=>'Contenu dynamique'),'2' => array('0'=>_("Slideshow"), '1'=>'Slideshow'),'3' => array('0'=>_("Menu"), '1'=>'Menu'),'4' => array('0'=>_("Conteneur"), '1'=>'Conteneur'), ), _('Type de block'), "s='d' otherTabs=1  ", $dataObj->getType()), 'Type', "", @$this->commentsType, @$this->commentsType_css, '', ' ','no','');

            $this->fields['Block']['IdParent']['html'] = stdFieldRow(htmlLink(_('Block parent'),'javascript:','  label_lien="IdParent"  class="label_link js-label-link" '), selectboxCustomArray('IdParent', $this->arrayIdParentOptions, _(_('Block parent')), "v='ID_PARENT'  s='d' otherTabs=1  val='".$dataObj->getIdParent()."'", $dataObj->getIdParent()), 'IdParent', "", @$this->commentsIdParent, @$this->commentsIdParent_css, '', ' ','no','');

            $this->fields['Block']['Position']['html'] = stdFieldRow(_("Positionnement"), selectboxCustomArray('Position', array( '0' => array('0'=>_("En haut"), '1'=>'En haut'),'1' => array('0'=>_("En bas"), '1'=>'En bas'), ), _('Positionnement'), "s='d' otherTabs=1  ", $dataObj->getPosition()), 'Position', "", @$this->commentsPosition, @$this->commentsPosition_css, '', ' ','no','');

            $this->fields['Block']['Order']['html'] = stdFieldRow(_("Ordre d'affichage"), input('number', 'Order',$dataObj->getOrder(), " step='10' placeholder='".str_replace("'","&#39;",_('Ordre d\'affichage'))."' v='ORDER' size='0' otherTabs=1 s='d' class='' otherTabs=1 "), 'Order', "", @$this->commentsOrder, @$this->commentsOrder_css, '', ' ','no','');

            $this->fields['Block']['Display']['html'] = stdFieldRow(_("Affichage"), selectboxCustomArray('Display', array( '0' => array('0'=>_("Toutes les pages"), '1'=>'Toutes les pages'),'1' => array('0'=>_("Accueil seulement"), '1'=>'Accueil seulement'),'2' => array('0'=>_("Manuel"), '1'=>'Manuel'), ), _('Affichage'), "s='d' otherTabs=1  ", $dataObj->getDisplay()), 'Display', "", @$this->commentsDisplay, @$this->commentsDisplay_css, '', ' ','no','');

            $this->fields['Block']['Slug']['html'] = stdFieldRow(_("Class du block"), input('text', 'Slug',str_replace('"','&quot;',$dataObj->getSlug()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Class du block'))."' size='35'  v='SLUG' s='d' class=''")."", 'Slug', "", @$this->commentsSlug, @$this->commentsSlug_css, '', ' ','no','');

            $this->fields['Block']['BlockI18n_Text_frCA']['html'] = stdFieldRow(_("Contenu français"), 
        textarea('BlockI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText() ,"placeholder='".str_replace("'","&#39;",_('Contenu fr_CA'))."' cols='71' v='BLOCKI18N_TEXT_FRCA' otherTabs=1 s='d'  class='tinymce'  class='' style='' spellcheck='false'"), 'BlockI18n_Text_frCA', "", @$this->commentsBlockI18n_Text_frCA, @$this->commentsBlockI18n_Text_frCA_css, ' istinymce', ' ','no','');

            $this->fields['Block']['BlockI18n_Text_enUS']['html'] = stdFieldRow(_("Contenu anglais"), 
        textarea('BlockI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText() ,"placeholder='".str_replace("'","&#39;",_('Contenu en_US'))."' cols='71' v='BLOCKI18N_TEXT_ENUS' otherTabs=1 s='d'  class='tinymce'  class='' style='' spellcheck='false'"), 'BlockI18n_Text_enUS', "", @$this->commentsBlockI18n_Text_enUS, @$this->commentsBlockI18n_Text_enUS_css, ' istinymce', ' ','no','');

        $this->lockFormField(array(0=>'Slug',1=>'Status',2=>'IdBlock',), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->Block['request']['ChildHide']) ){
            
            $ongletTab['0']['t'] = _('Upload d\'images');
            $ongletTab['0']['p'] = 'BlockFile';
            $ongletTab['0']['lkey'] = 'IdBlock';
            $ongletTab['0']['fkey'] = 'IdBlock';
        if(!empty($ongletTab) and $dataObj->getIdBlock()){
            foreach($ongletTab as $value){
                if($_SESSION[_AUTH_VAR]->hasRights('Block'.$value['p'], 'r')){
                    
                    $getLocalKey = "get".$value['lkey']."";
                    if($dataObj->$getLocalKey()){
                        @$ChildOnglet .= 
                            li(
 htmlLink(_($value['t']),'javascript:',"p='".$value['p']."' act='list' j=conglet_Block ip='".$dataObj->$getLocalKey()."' class='ui-corner-top ui-state-default' ") 						,"  class='".@$class_has_child."' j=sm  ");
                    }
                }
            }
            if(!empty($ChildOnglet)){
                $childTable['onReadyJs'] ="
                    $('[j=conglet_Block]').unbind('click');
                    $('[j=conglet_Block]').bind('click', function (data){
                         pp = $(this).attr('p');
                         $.post('"._SITE_URL."mod/act/BlockAct.php', {a:'get'+pp+'List', ip:$(this).attr('ip'), ui:  pp+'Table','pui':'".$uiTabsId."',pushPGet:'".json_encode($_GET)."',pushPPOST:'".json_encode($_POST)."'}, function(data){
                            $('#cntBlockChild').html(data).show();;
                            $('[j=conglet_Block]').parent().attr('class','ui-corner-top ui-state-default');
                            $('[j=conglet_Block][p=\"'+pp+'\"]').parent().attr('class','ui-corner-top ui-state-default ui-state-active');
                         });
                    });

                ";
                if(@$_SESSION['memoire']['onglet']['Block']['child']['list'][$dataObj->$getLocalKey()]){
                    $onglet_p = $_SESSION['memoire']['onglet']['Block']['child']['list'][$dataObj->$getLocalKey()];
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Block][p=".$onglet_p."]').first().click();";
                }else{
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Block]').first().click();";
                }


            }
        }
        }
        
        
        if($dataObj->getIdBlock()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'BlockControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = 
            div(
                input('checkbox','toggle-form',' p="Block" ')
                .label(span(_('Afficher/Cacher le formulaire')),'for="toggle-form"')
            ,'','class="toggle-form" p="Block" data-tooltip="'._('Cacher le formulaire').'"');
            }

        }
        
        
        $linkParent="Contenu";
        $titre_form_str = '';
        if($dataObj->getIdBlock()){
                   $titre_form_str .= span(strip_tags(_($dataObj->getTitle()))," data-name='title' ");
                   $this->siteTitle =set_var($this->siteTitle,strip_tags(_($dataObj->getTitle())),' ',false,NULL,false,true);}
        $this->formTitle = p(href($linkParent,_SITE_URL."Content/edit/".$dataObj->getIdContent()).htmlSpace(1).href("Block",_SITE_URL.'Block').$titre_form_str, 'class="breadcrumb"'); 
        $ongletf =
            div(
                ul(li(htmlLink(_('Block'),'#ogf_Block',' j="ogf" p="Block" class="ui-tabs-anchor button-link-blue" ')).li(htmlLink(_('Avancé'),'#ogf_slug',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Block" ')).li(htmlLink(_('Français'),'#ogf_Blocki18nTextFrca',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Block" ')).li(htmlLink(_('Anglais'),'#ogf_Blocki18nTextEnus',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Block" ')))
            ,'cntOngletBlock',' class="cntOnglet"')
            .@$close_form
        ;
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addBlock_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveBlock',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedBlock','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdBlock', $dataObj->getIdBlock(), " otherTabs=1 s='d' pk").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        $mceInclude = loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/ckeditor.js")
            .loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/adapters/jquery.js");
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'BlockControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formBlock');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['Block']['tog']) and 
            $_SESSION['memoire']['onglet']['Block']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['Block']['Start']['html']
                
                .
                    '<div id="ogf_Block">'.
$this->fields['Block']['IdContent']['html']
.$this->fields['Block']['Title']['html']
.$this->fields['Block']['Status']['html']
.$this->fields['Block']['Type']['html']
.$this->fields['Block']['IdParent']['html']
.$this->fields['Block']['Position']['html']
.$this->fields['Block']['Order']['html']
.$this->fields['Block']['Display']['html']
.'</div><div id="ogf_slug"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Block']['Slug']['html']
.'</div><div id="ogf_Blocki18nTextFrca"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Block']['BlockI18n_Text_frCA']['html']
.'</div><div id="ogf_Blocki18nTextEnus"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Block']['BlockI18n_Text_enUS']['html'].'</div>'
                
                .@$this->fields['Block']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntBlock", "class='divStdform' CntTabs=1 ")
        , "id='formBlock' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Block"); }
        # if not new, show child table
        if($dataObj->getIdBlock()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelBlock', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntBlockChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['Block']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['Block']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['Block']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    bind_close_form();
    
    ".$jqueryDatePicker."
    bind_ui_active('Block');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    $('#formBlock .tinymce').each(function() {
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
    $(\"[label_lien='IdContent']\").bind('click', function (){
        if($('#IdContent').val()){ window.open('"._SITE_URL."Content/edit/'+$('#IdContent').val());}else{window.open('"._SITE_URL."Content/list/');}
    });
    $(\"[label_lien='IdParent']\").bind('click', function (){
        if($('#IdParent').val()){ window.open('"._SITE_URL."Block/edit/'+$('#IdParent').val());}else{window.open('"._SITE_URL."Block/list/');}
    });$('#cntOngletBlock').parent().tabs();$('#cntOngletBlock').show();
    ".@$childTable['onReadyJs']."
    ".@$error['onReadyJs']."
    ".@$removeEditChild."
    /*try {afterFormLoad();}catch(e){}*/
    if($('#loader').css('display') == 'block') $('#loader').hide();
    $('[j=sftr]').hide();
    ".@$tabs_act."
    ".$this->CcToFormJs
    .@$script_autoc_one."
     setTimeout(function(){ bind_othertabs_std('#divCntBlock');},500); 
    ".$toggleForm."
    bind_form('Block','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
        ($dataObj->getContent())?'':$dataObj->setContent( new Content() );
        ($dataObj->getBlockRelatedByIdParent())?'':$dataObj->setBlockRelatedByIdParent( new Block() );
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new BlockI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addBlockI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new BlockI18n();$mt->setLocale('en_US')->setText('');$dataObj->addBlockI18n($mt)->save();}
            
        $this->fieldsRo['Block']['IdContent']['html'] = stdFieldRow(htmlLink(_('Contenu associé'),'javascript:','  label_lien="IdContent"  class="label_link js-label-link" '), 
                    input('text','IdContentLabel',$dataObj->getContent()->getNameMenu(),"  readonly s='d'")
                    .input('hidden','IdContent',$dataObj->getIdContent()," readonly s='d'"), 'IdContent', "", @$this->commentsIdContent, @$this->commentsIdContent_css, 'readonly', ' ','no','');
$this->fieldsRo['Block']['Title']['html'] = stdFieldRow(_("Titre"), input('text','Title',$dataObj->getTitle()," readonly s='d'"), 'Title', "", @$this->commentsTitle, @$this->commentsTitle_css, 'readonly', ' ','no','');
$this->fieldsRo['Block']['Status']['html'] = stdFieldRow(_("Status"), input('text','Status',$dataObj->getStatus()," readonly s='d'"), 'Status', "", @$this->commentsStatus, @$this->commentsStatus_css, 'readonly', ' ','no','');
$this->fieldsRo['Block']['Type']['html'] = stdFieldRow(_("Type de block"), input('text','Type',$dataObj->getType()," readonly s='d'"), 'Type', "", @$this->commentsType, @$this->commentsType_css, 'readonly', ' ','no','');
$this->fieldsRo['Block']['IdParent']['html'] = stdFieldRow(htmlLink(_('Block parent'),'javascript:','  label_lien="IdParent"  class="label_link js-label-link" '), 
                    input('text','IdParentLabel',$dataObj->getBlockRelatedByIdParent()->getTitle(),"  readonly s='d'")
                    .input('hidden','IdParent',$dataObj->getIdParent()," readonly s='d'"), 'IdParent', "", @$this->commentsIdParent, @$this->commentsIdParent_css, 'readonly', ' ','no','');
$this->fieldsRo['Block']['Position']['html'] = stdFieldRow(_("Positionnement"), input('text','Position',$dataObj->getPosition()," readonly s='d'"), 'Position', "", @$this->commentsPosition, @$this->commentsPosition_css, 'readonly', ' ','no','');
$this->fieldsRo['Block']['Order']['html'] = stdFieldRow(_("Ordre d'affichage"), input('text','Order',$dataObj->getOrder()," readonly s='d'"), 'Order', "", @$this->commentsOrder, @$this->commentsOrder_css, 'readonly', ' ','no','');
$this->fieldsRo['Block']['Display']['html'] = stdFieldRow(_("Affichage"), input('text','Display',$dataObj->getDisplay()," readonly s='d'"), 'Display', "", @$this->commentsDisplay, @$this->commentsDisplay_css, 'readonly', ' ','no','');
$this->fieldsRo['Block']['Slug']['html'] = stdFieldRow(_("Class du block"), input('text','Slug',$dataObj->getSlug()," readonly s='d'"), 'Slug', "", @$this->commentsSlug, @$this->commentsSlug_css, 'readonly', ' ','no','');
$this->fieldsRo['Block']['BlockI18n_Text_frCA']['html'] = stdFieldRow(_("Contenu français"), textarea('BlockI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText()," readonly class='tinymce'    s='d'"), 'BlockI18n_Text_frCA', "", @$this->commentsBlockI18n_Text_frCA, @$this->commentsBlockI18n_Text_frCA_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Block']['BlockI18n_Text_enUS']['html'] = stdFieldRow(_("Contenu anglais"), textarea('BlockI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText()," readonly class='tinymce'    s='d'"), 'BlockI18n_Text_enUS', "", @$this->commentsBlockI18n_Text_enUS, @$this->commentsBlockI18n_Text_enUS_css, 'readonly istinymce', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['Block'] as $field=>$ar){
                $this->fields['Block'][$field]['html'] = $this->fieldsRo['Block'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['Block'][$field]['html'] = $this->fieldsRo['Block'][$field]['html'];
            }
        }
    }
    /*Option function for Block_IdContent selectBox */
    public function selectBoxBlock_IdContent($dataObj='',$data='', $emptyVal=false,$array=true){
$q = ContentQuery::create();

    $q->addAsColumn('selDisplay', 'CONCAT_WS ( " ", content.name_menu, "" )');
    $q->select(array('selDisplay', 'IdContent'));
    $q->orderBy('selDisplay', 'ASC');
if(!$array){return $q;}else{$pcDataO = $q->find();}


$arrayOpt = $pcDataO->toArray();
return assocToNum($arrayOpt , true);
}
    /*Option function for Block_IdParent selectBox */
    public function selectBoxBlock_IdParent($dataObj='',$data='', $emptyVal=false,$array=true){
$q = BlockQuery::create();

    $q->addAsColumn('selDisplay', 'CONCAT_WS ( " ", block.title, "" )');
    $q->select(array('selDisplay', 'IdBlock'));
    $q->orderBy('selDisplay', 'ASC');
if(!$array){return $q;}else{$pcDataO = $q->find();}


$arrayOpt = $pcDataO->toArray();
return assocToNum($arrayOpt , true);
}
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = BlockQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdBlock'));
            
            $pcData = $q->filterByIdContent($IdParent);
        
        }else{
            $q->select(array('Name', 'IdBlock'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = BlockQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdBlock'));
            
            $pcData = $q->filterByIdContent($IdParent);
        
        }else{
            $q->select(array('Name', 'IdBlock'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Block')), $selected);
        }


        return $return;
    }	#@#############
    #	getChildList
    ###############
    public function getBlockFileList($IdBlock, $page='1', $uiTabsId='BlockFileTableCntnr', $parentContainer='', $mja_list='', $search='', $params = ''){
        /*init var*/
        global $request;
        if(empty($page)){$page=1;}$param=array();
        if(!empty($_SESSION['memoire']['onglet']['BlockBlockFile']['pg'])){$page = $_SESSION['memoire']['onglet']['BlockBlockFile']['pg'];}
        if(!empty($search['order'])){$this->searchOrder = $search['order'];}
        
        if(empty($search['ms'])){ $searchAr =$search;}else{$this->searchMs = $search['ms']; }

        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    @$child_order .="
                        $(\"#cntBlockChild [th='sorted'][c='".$col."'],#cntBlockChild [th='sorted'][rc='".$col."']\").attr('sens','".$sens."');
                        $(\"#cntBlockChild [th='sorted'][c='".$col."'],#cntBlockChild [th='sorted'][rc='".$col."']\").attr('order','on');
                    ";
                }
            }
        }
        
        if($parentContainer == 'editDialog'){$diagNoClose = "diag:\"noclose\", ";$diagNoCloseEscaped = "diag:\\\"noclose\\\", ";}
        if(isset($this->Block['request']['noHeader']) && $this->Block['request']['noHeader'] == 'true'){$noHeader = "'noHeader':'true',";}
        $data['IdBlock'] = $IdBlock;

        $dataObj = BlockQuery::create()->findPk($IdBlock);
        if($dataObj == null){$dataObj = new Block();$dataObj->setIdBlock($IdBlock);}
        $this->dataObj =$dataObj;
        

        $this->BlockFile['list_add'] = "
        $('#addBlockFile').click(function(){
            $.post('"._SITE_URL."mod/act/BlockFileAct.php', {a:'edit', ui:'editDialog',pc:'Block', je:'BlockFileTableCntnr', jet:'tr', tp:'BlockFile', ip:'".$IdBlock."'},
                function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); $('#editDialog').dialog('option','title','".addSlashes(_('Upload d\'images'))."'); });
        });";
        $this->BlockFile['list_delete'] = "
        $(\"[j='deleteBlockFile']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Upload d\'images'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."','$.post(\""._SITE_URL."mod/act/BlockFileAct.php\", {".@$diagNoCloseEscaped.@$diagNoClose." a:\"delete\", ui:\"".$uiTabsId."\", i:'+$(this).attr('i')+', ip:\"".$IdBlock."\", pc:\"Block\", je:\"BlockFileTableCntnr\", jet:\"tr\"}, function(data){ if(data)$(\"#BlockFileTableCntnr\").append(data);});');
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('BlockBlockFile', 'r')){ $this->BlockFile['list_edit'] = "
        $(\"#BlockFileTable[listchild=1] tr[ecf=1] td[j='editBlockFile']\").bind('click', function (){
            
        $.post('"._SITE_URL."mod/act/BlockFileAct.php',
                {a:'edit', i:$(this).attr('i'), ip:'".$IdBlock."', ui:'editDialog',pc:'Block', je:'BlockFileTableCntnr', jet:'tr', 'it-pos':$(this).data('iterator-pos') },
            function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";}
        $rigthButtonAction="";
        if($_SESSION[_AUTH_VAR]->hasRights('BlockBlockFile', 'w')){
            $rigthButtonAction='';
        }
        $filterKey = $IdBlock;
        
        $maxPerPage = (!empty($this->BlockFile['request']['maxperpage']))?$this->BlockFile['request']['maxperpage']:_paging_nbr_per_page;
        try{
            $q = BlockFileQuery::create();
            
            
            $q ->filterByIdBlock( $filterKey );;  
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
        
        
        
        
        
        
        if(isset($this->Block['request']['noHeader']) && $this->Block['request']['noHeader'] == 'true'){
            $header_search = "";
        }else{
            $header_search = ''
        .div(
            
            form('' , " CntTabs=1 id='formMsBlockFile'")
        ,'',' class="msSearchCtnr"')
        .div($rigthButtonAction, '', 'class="ac-right-action-buttons"')
        .button(span(_("Afficher le menu"),'data-tooltip="'.addslashes("Afficher le menu").'" '),'class="toggle-child-nav-btn"');
        }
        
        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('BlockBlockFile', 'd') and empty($this->readOnlyFilter)){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( @$this->cCmoreColsHeaderFirstBlockFile.th(_("Name"), " th='sorted'  rcColone='Name' c='Name'  ").th(_("Description"), " th='sorted'  rcColone='Desc' c='Desc'  ").th(_("Ordre"), " th='sorted'  rcColone='Index' c='Index'  ").th(_("Poids"), " th='sorted'  rcColone='Size' c='Size'  ").$this->cCmoreColsHeaderBlockFile.th('Fichier', "id='bulkOpTh'").$actionRowHeader, " ln='BlockFile' class=''");
        $i=0;
        if(empty($pmpoData) || !method_exists($pmpoData,'isEmpty')){
            @$tr .= tr(	td(p(span(_("Une erreur est survenue veuillez vider votre recherche.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='BlockFile' colspan='100%' "));
            
        }else if( $pmpoData->isEmpty() ){
            @$tr .= tr(	td(p(span(_("Aucun enregistrement pour le moment.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='BlockFile' colspan='100%' "));
            
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
                    $fileIcon = img(_SITE_URL.$data->getFichier()."?pc=Block&token=".MD5(_ENCODE.$data->getPrimaryKey())."|".MD5(_ENCODE.$_SESSION[_AUTH_VAR]->get('id')),'','',' style="max-height:50px;"');
                }
                
                $actionRow = '';
                
                $this->ListActionRowBlockFile = (!empty($this->cCListActionRowBlockFile))?str_replace('%idpk%', json_encode($data->getPrimaryKey()), $this->cCListActionRowBlockFile):$this->ListActionRowBlockFile;
                $this->ListActionRowBlockFile = (!empty($this->cCListActionRowBlockFile))?str_replace('%i%', $i, $this->ListActionRowBlockFile):$this->ListActionRowBlockFile;
                
                if($_SESSION[_AUTH_VAR]->hasRights('BlockBlockFile', 'd') and empty($this->readOnlyFilter) ){$actionRow = htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteBlockFile' i='".json_encode($data->getPrimaryKey())."'");}
                
                $imgPath = $data->getFichier()."?pc=Block&token=".MD5(_ENCODE.$data->getPrimaryKey())."|".MD5(_ENCODE.$_SESSION[_AUTH_VAR]->get('id'));
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
        $url = _SITE_URL.$data->getFichier()."?pc=Block&token=".MD5(_ENCODE.$data->getPrimaryKey())."|".MD5(_ENCODE.$_SESSION[_AUTH_VAR]->get('id'));
    $actionRow .= htmlLink($imgPath,$url, "  j='imageBlockFile' i='".$data->getPrimaryKey()."' ");
                
                

                $actionRow = $actionRow;
                $addClass='';
                $cnt= substr_count($actionRow,'<a');
                if($cnt){ $addClass=' actionrow'.$cnt;}
                $actionRow = (!empty($actionRow))?td($this->ListActionRowBlockFile.$actionRow," class='actionrow ".$addClass."'"):"";
                
                
                
                ;
                
                if(isset($this->search['highlight']) && is_array($this->search['highlight'])){
                    $highlight = (in_array(json_encode($data->getPrimaryKey()), $this->search['highlight']))?'highlight':'';
                }
                
                $child_edit_columns_filter ="1";
    
                @$tr .= 
                        tr(
                            @$cCmoreColsBlockFileFirst.
                            td(span(strip_tags((isset($altValue['Name']) and $altValue['Name'])?$altValue['Name']:$data->getName()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Name").":\" j='editBlockFile'  i='".json_encode($data->getPrimaryKey())."' c='Name'  ")
                            .td(span(strip_tags((isset($altValue['Desc']) and $altValue['Desc'])?$altValue['Desc']:mb_substr(strip_tags($data->getDesc()),0,50, 'UTF-8')." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Description").":\" j='editBlockFile'  i='".json_encode($data->getPrimaryKey())."' c='Desc'  ")
                            .td(span(strip_tags((isset($altValue['Index']) and $altValue['Index'])?$altValue['Index']:$data->getIndex()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Ordre").":\" j='editBlockFile'  i='".json_encode($data->getPrimaryKey())."' c='Index'  ")
                            .td(span(strip_tags((isset($altValue['Size']) and $altValue['Size'])?$altValue['Size']:$data->getSize()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Poids").":\" j='editBlockFile'  i='".json_encode($data->getPrimaryKey())."' c='Size'  ")
                            .
                            
                            @$cCmoreColsBlockFile.td(htmlLink($fileIcon, _SITE_URL.str_replace(array('#',' '),array('%23','%20'),$data->getFichier())."?pc=Block&token=".MD5(_ENCODE.$data->getPrimaryKey())."|".MD5(_ENCODE.$_SESSION[_AUTH_VAR]->get('id')), "class='file-link' target='_blank'"),'class="file-row"').
                            @$actionRow
                        ,"id='BlockFileRow".$data->getPrimaryKey()."' data-id='".$data->getPrimaryKey()."' data-pc-table='Block' data-table='BlockFile' data-edit='Upload d'images #".$data->getPrimaryKey()."' ecf='".$child_edit_columns_filter."' ln='BlockFile' class=' ".@$highlight.@$param['class']."'  ")
                        ;
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(div(@$total_child,'','class="nolink"')
                            ,'trBlockFile'," style='".@$hide_BlockFile."' ln='BlockFile' class=''").@$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    
    if(($_SESSION[_AUTH_VAR]->hasRights('BlockBlockFile', 'a')) ){
        $add_button_child =""
            .div(
                htmlLink(
                    span(_("Ajouter"))
                , "Javascript:","id='pickfiles' class='button-link-blue add-button'")

            .div('', 'filelist')
            ,'upload-BlockFile',' class="listHeaderItem " ');
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
                    ,'','id="BlockFilePagination"')
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
                 $this->CcToBlockFileListTop
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
                                    .$this->CcToBlockFileTableFooter
                                , "id='BlockFileTable' listchild=1 class='tablesorter'")
                            , 'formBlockFile')
                            .$this->CcToBlockFileListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list contentHolderList" ')

                    .@$pagerRow
                ,'BlockFileListForm')
            ,'cntBlockFiledivChild',' class="" ');
            

                    @$return['js'] .= "
bindChangePic('BlockFile','Block');
$(function(){
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,html4',
        browse_button : 'pickfiles',
        container: document.getElementById('upload-BlockFile'),
        url: '"._SITE_URL_NO_S."mod/act/BlockFileAct.php?a=file&pc=Block&ip=".$filterKey."&IdUser=".$_SESSION[_AUTH_VAR]->get('id')."&blob=',
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
                $('[j=conglet_Block][p=\"BlockFile\"]').click();

            }
        }
    });
    uploader.init();
});";

            $jqueryDatePickerChild = "beforeDatePicker('');";
            @$return['js'] .= "
                
                
            ";
            $return['onReadyJs'] =
                @$this->CcToBlockFileListJsFirst
                .$this->BlockFile['list_add']
                .$this->BlockFile['list_delete']
                .$this->BlockFile['list_edit']
            ."
                
                
            ".@$total_child_js."
            
            
            
            child_button_bind('BlockFile');
            child_pagination_bind('BlockFile','Block','".$uiTabsId."','".$IdBlock."','','".$this->CcToSearchMsPost."');
            child_pagination_sorted_bind('BlockFile','Block','".$uiTabsId."','".$IdBlock."','".$this->CcToSearchMsPost."');
               
            $('#cntBlockChild .js-select-label').SelectBox();
            
            ".@$child_order."
            
            
            $('#formBlock .divtr.readonly .divtd[in=\"inSlug\"] label.readonly').text('".addslashes($dataObj->getSlug())."');
            $('#formBlock #Slug').val('".addslashes($dataObj->getSlug())."');
            $('#formBlock .divtr.readonly .divtd[in=\"inStatus\"] label.readonly').text('".addslashes($dataObj->getStatus())."');
            $('#formBlock #Status').val('".addslashes($dataObj->getStatus())."');
            $('#formBlock .divtr.readonly .divtd[in=\"inIdBlock\"] label.readonly').text('".addslashes($dataObj->getIdBlock())."');
            $('#formBlock #IdBlock').val('".addslashes($dataObj->getIdBlock())."');
            ".$jqueryDatePickerChild."
            ";
            $return['onReadyJs'] .= "".$this->CcToBlockFileListJs;
            return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'BlockAct.php';
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
        $this->cCmoreColsHeaderBlockFile = '';
        $this->ListActionRowBlockFile = '';
        $this->cCmoreColsBlockFile = '';
        $this->CcToBlockFileTableFooter = '';
        $this->CcToBlockFileListTop = '';
        $this->CcToBlockFileListBottom = '';
        $this->CcToBlockFileListJs = '';
        
    }

    
}
