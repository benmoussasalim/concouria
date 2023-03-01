<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'Slider' table.
 *
 */
class SliderForm extends Slider{
public $tableName="Slider";
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
        $q = SliderQuery::create();
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
        
         $q->groupBy('IdSlider');
        
        $this->pmpoData =  $q;
        //echo $q->toString();
        //$q->paginate($page, $maxPerPage);
        return $this->pmpoData;
    }
    public function getListHeader($act){
        switch($act){
            case 'head':
            ###### TH
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Titre"), " th='sorted'  rcColone='Title' c='Title'  ").th(_("En ligne"), " th='sorted'  rcColone='Online' c='Online'  ").th(_("Ordre d'affichage"), " th='sorted'  rcColone='Order' c='Order'  "). $this->cCmoreColsHeader;
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
                $array_search_tb = array('Title','Online');
                
                unset($data);$data['Title'] = (!empty($this->searchMs['Title']))?$this->searchMs['Title']:'';
        $data['Online'] = (!empty($this->searchMs['Online']))?$this->searchMs['Online']:'';
        
                
        @$this->fieldsSearch['Slider']['Title'] = div(input('text', 'Title', $this->searchMs['Title'], ' othertabs=1  placeholder="'._('Nom').'"',''),'','class="ac-search-item ms-Title"');
        @$this->fieldsSearch['Slider']['Online'] =div(selectboxCustomArray('Online', array( '0' => array('0'=>_("Oui"), '1'=>'Oui'),'1' => array('0'=>_("Non"), '1'=>'Non'), ), _('En ligne'), '  size="1" t="1"   ', $this->searchMs['Online']), '', '  class=" ac-search-item ms-Online"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msSliderAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['Slider']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msSliderBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msSliderBtClear" class="icon clear"')
               .@$this->fieldsSearch['Slider']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['Slider']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-SliderSearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['Slider']['Start'].
                    $this->fieldsSearch['Slider']['Title'].
                    $this->fieldsSearch['Slider']['Online'].
                @$this->fieldsSearch['Slider']['End'].
            $this->fieldsSearch['Slider']['Button']
            ,"id='formMsSlider' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('Slider', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."Slider/edit/", "id='addSlider' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addSliderAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Slider");
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
        if(!empty($_SESSION['memoire']['onglet']['Slider']['pg'])){
            $page = $_SESSION['memoire']['onglet']['Slider']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'SliderAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'SliderAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
            $search_child_default['Order']='ASC';
        if(empty($this->searchOrder)){$this->searchOrder = $search_child_default;}
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#SliderListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#SliderListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('Slider', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('Slider', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('Slider', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteSlider' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
                
                
                
                 $titreRaccour =''; $titreRaccour .= _('Slider');
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['Title']) and $altValue['Title'])?$altValue['Title']:$data->getTitle()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Titre").":\" j='editSlider'  i='".json_encode($data->getPrimaryKey())."' c='Title'  ")
                            .td(span(strip_tags((isset($altValue['Online']) and $altValue['Online'])?$altValue['Online']:isntPo($data->getOnline())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("En ligne").":\" j='editSlider'  i='".json_encode($data->getPrimaryKey())."' c='Online'  ")
                            .td(span(strip_tags((isset($altValue['Order']) and $altValue['Order'])?$altValue['Order']:$data->getOrder()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Ordre d'affichage").":\" j='editSlider'  i='".json_encode($data->getPrimaryKey())."' c='Order'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='SliderRow".$data->getPrimaryKey()."'
                    data-table='Slider' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountSlider', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Slider';

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
                            ,'','id="SliderPagination"')
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
                .div($controlsContent.$this->CcCustomControl,'SliderControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='SliderTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'SliderListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#SliderListForm [j='deleteSlider']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Slider'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msSliderBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msSliderBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#SliderListForm tr[ecf=1] td[j='editSlider']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."Slider/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."Slider/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Slider'
                ,'IdSlider'
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
        $(\"#SliderListForm [j='deleteSlider']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Slider'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msSliderBt\').length>0){ $(\'#msSliderBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'SliderTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntSliderListForm #addSlider').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'SliderTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#SliderListForm tr[ecf=1] td[j='editSlider']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'SliderTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Slider'
                ,'IdSlider'
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
        pagination_bind('Slider','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#SliderListForm [j='deleteSlider']\").unbind('click');
        $('#SliderListForm #addSlider').unbind('click');
        $(\"#SliderListForm tr[ecf=1] td[j='editSlider']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#SliderListForm [j='button']\").unbind();   
        pagination_sorted_bind('Slider','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('Slider','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('Slider','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_Slider($data){

        unset($data['IdSlider']);
        $e = new Slider();
        
        
        if(!@$data['Online']){$data['Online'] = "Oui";} 
        if(isset($data['Order'])){$e->setOrder(($data['Order']=='')?null:$data['Order']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setUrl(($data['Url']=='')?null:$data['Url']);
        $e->setOrder(($data['Order']=='')?null:$data['Order']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_Slider($data){

        
        $e = SliderQuery::create()->findPk(json_decode($data['i']));
        
        
        if(!@$data['Online']){$data['Online'] = "Oui";} 
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
     * Produce a formated form of Slider
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
        $je= "SliderTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['Slider']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['Slider']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addSlider_child').bind('click.addSlider', function (){
                    $.post('"._SITE_URL."mod/act/SliderAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addSlider_child').bind('click.addSlider', function (){
                document.location= '"._SITE_URL."Slider/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = SliderQuery::create();
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Slider', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Slider','w',$dataObj)) 
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
                    $('#formSlider #saveSlider').removeAttr('disabled');
                    $('#formSlider #saveSlider').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formSlider #saveSlider').css('cursor', 'default');
                    if($('#formSlider #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formSlider #saveSlider').bind('click.saveSlider', function (data){
                    $('#formSlider #saveSlider').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formSlider #saveSlider').css('cursor', 'progress');
                    $('#formSlider #saveSlider').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formSlider .tinymce').each(function(index) {
                        eval(' $(\"#formSlider #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formSlider select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formSlider\").find(\"[s='d']\").serializeArray();
                        $('#formSlider select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formSlider\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/SliderAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formSlider #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formSlider #formChangedSlider').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formSlider #saveSlider').unbind('click.saveSlider');
                $('#formSlider #saveSlider').remove();";
        }
        
        if($dataObj == null){
            $this->Slider['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Slider();
            $this->Slider['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }

try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new SliderI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addSliderI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new SliderI18n();$mt->setLocale('en_US')->setText('');$dataObj->addSliderI18n($mt)->save();}

        
        
        
        
        
        
        

            $this->fields['Slider']['Title']['html'] = stdFieldRow(_("Titre"), input('text', 'Title',str_replace('"','&quot;',$dataObj->getTitle()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Titre'))."' size='69'  v='TITLE' s='d' class=''")."", 'Title', "", @$this->commentsTitle, @$this->commentsTitle_css, '', ' ','no','');

            $this->fields['Slider']['Online']['html'] = stdFieldRow(_("En ligne"), selectboxCustomArray('Online', array( '0' => array('0'=>_("Oui"), '1'=>'Oui'),'1' => array('0'=>_("Non"), '1'=>'Non'), ), "", "s='d' otherTabs=1  ", $dataObj->getOnline()), 'Online', "", @$this->commentsOnline, @$this->commentsOnline_css, '', ' ','no','');

            $this->fields['Slider']['Order']['html'] = stdFieldRow(_("Ordre d'affichage"), input('number', 'Order',$dataObj->getOrder(), " step='10' placeholder='".str_replace("'","&#39;",_('Ordre d\'affichage'))."' v='ORDER' size='0' otherTabs=1 s='d' class='' otherTabs=1 "), 'Order', "", @$this->commentsOrder, @$this->commentsOrder_css, '', ' ','no','');

            $this->fields['Slider']['SliderI18n_Text_frCA']['html'] = stdFieldRow(_("Texte français"), 
        textarea('SliderI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText() ,"placeholder='".str_replace("'","&#39;",_('Texte fr_CA'))."' cols='71' v='SLIDERI18N_TEXT_FRCA' otherTabs=1 s='d'  class='tinymce'  class='' style='' spellcheck='false'"), 'SliderI18n_Text_frCA', "", @$this->commentsSliderI18n_Text_frCA, @$this->commentsSliderI18n_Text_frCA_css, ' istinymce', ' ','no','');

            $this->fields['Slider']['SliderI18n_Text_enUS']['html'] = stdFieldRow(_("Texte anglais"), 
        textarea('SliderI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText() ,"placeholder='".str_replace("'","&#39;",_('Texte en_US'))."' cols='71' v='SLIDERI18N_TEXT_ENUS' otherTabs=1 s='d'  class='tinymce'  class='' style='' spellcheck='false'"), 'SliderI18n_Text_enUS', "", @$this->commentsSliderI18n_Text_enUS, @$this->commentsSliderI18n_Text_enUS_css, ' istinymce', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->Slider['request']['ChildHide']) ){
            
            $ongletTab['0']['t'] = _('Upload d\'images');
            $ongletTab['0']['p'] = 'SliderFile';
            $ongletTab['0']['lkey'] = 'IdSlider';
            $ongletTab['0']['fkey'] = 'IdSlider';
        if(!empty($ongletTab) and $dataObj->getIdSlider()){
            foreach($ongletTab as $value){
                if($_SESSION[_AUTH_VAR]->hasRights('Slider'.$value['p'], 'r')){
                    
                    $getLocalKey = "get".$value['lkey']."";
                    if($dataObj->$getLocalKey()){
                        @$ChildOnglet .= 
                            li(
 htmlLink(_($value['t']),'javascript:',"p='".$value['p']."' act='list' j=conglet_Slider ip='".$dataObj->$getLocalKey()."' class='ui-corner-top ui-state-default' ") 						,"  class='".@$class_has_child."' j=sm  ");
                    }
                }
            }
            if(!empty($ChildOnglet)){
                $childTable['onReadyJs'] ="
                    $('[j=conglet_Slider]').unbind('click');
                    $('[j=conglet_Slider]').bind('click', function (data){
                         pp = $(this).attr('p');
                         $.post('"._SITE_URL."mod/act/SliderAct.php', {a:'get'+pp+'List', ip:$(this).attr('ip'), ui:  pp+'Table','pui':'".$uiTabsId."',pushPGet:'".json_encode($_GET)."',pushPPOST:'".json_encode($_POST)."'}, function(data){
                            $('#cntSliderChild').html(data).show();;
                            $('[j=conglet_Slider]').parent().attr('class','ui-corner-top ui-state-default');
                            $('[j=conglet_Slider][p=\"'+pp+'\"]').parent().attr('class','ui-corner-top ui-state-default ui-state-active');
                         });
                    });

                ";
                if(@$_SESSION['memoire']['onglet']['Slider']['child']['list'][$dataObj->$getLocalKey()]){
                    $onglet_p = $_SESSION['memoire']['onglet']['Slider']['child']['list'][$dataObj->$getLocalKey()];
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Slider][p=".$onglet_p."]').first().click();";
                }else{
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Slider]').first().click();";
                }


            }
        }
        }
        
        
        if($dataObj->getIdSlider()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'SliderControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = 
            div(
                input('checkbox','toggle-form',' p="Slider" ')
                .label(span(_('Afficher/Cacher le formulaire')),'for="toggle-form"')
            ,'','class="toggle-form" p="Slider" data-tooltip="'._('Cacher le formulaire').'"');
            }

        }
        
        $ongletf =
            div(
                ul(li(htmlLink(_('Slider'),'#ogf_Slider',' j="ogf" p="Slider" class="ui-tabs-anchor button-link-blue" ')).li(htmlLink(_('Français'),'#ogf_Slideri18nTextFrca',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Slider" ')).li(htmlLink(_('Anglais'),'#ogf_Slideri18nTextEnus',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Slider" ')))
            ,'cntOngletSlider',' class="cntOnglet"')
            .@$close_form
        ;
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addSlider_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveSlider',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedSlider','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdSlider', $dataObj->getIdSlider(), " otherTabs=1 s='d' pk").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        $mceInclude = loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/ckeditor.js")
            .loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/adapters/jquery.js");
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'SliderControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formSlider');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['Slider']['tog']) and 
            $_SESSION['memoire']['onglet']['Slider']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['Slider']['Start']['html']
                
                .
                    '<div id="ogf_Slider">'.
$this->fields['Slider']['Title']['html']
.$this->fields['Slider']['Online']['html']
.$this->fields['Slider']['Order']['html']
.'</div><div id="ogf_Slideri18nTextFrca"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Slider']['SliderI18n_Text_frCA']['html']
.'</div><div id="ogf_Slideri18nTextEnus"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Slider']['SliderI18n_Text_enUS']['html'].'</div>'
                
                .@$this->fields['Slider']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntSlider", "class='divStdform' CntTabs=1 ")
        , "id='formSlider' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Slider"); }
        # if not new, show child table
        if($dataObj->getIdSlider()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelSlider', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntSliderChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['Slider']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['Slider']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['Slider']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    bind_close_form();
    
    ".$jqueryDatePicker."
    bind_ui_active('Slider');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    $('#formSlider .tinymce').each(function() {
        if (CKEDITOR.instances[$(this).attr('Id')]){
            CKEDITOR.instances[$(this).attr('Id')].destroy();
        }
        ckeTemp = CKEDITOR.replace($(this).attr('Id'), {
            extraAllowedContent: '*(*)[*];sup(*)[*];article(*)[*];section(*)[*];div(*)[*];span(*)'
            ".@$this->ccAddCkeditorInit."
        });
        ckeTemp.on('change',function( evt ){ $('.divtd input[type=\"button\"]').addClass('can-save');});
        ckeTemp.on('key',function( event ){ if(event.data.keyCode ==1114195){ $('form [act=save]').click(); return false;}});
    });$('#cntOngletSlider').parent().tabs();$('#cntOngletSlider').show();
    ".@$childTable['onReadyJs']."
    ".@$error['onReadyJs']."
    ".@$removeEditChild."
    /*try {afterFormLoad();}catch(e){}*/
    if($('#loader').css('display') == 'block') $('#loader').hide();
    $('[j=sftr]').hide();
    ".@$tabs_act."
    ".$this->CcToFormJs
    .@$script_autoc_one."
     setTimeout(function(){ bind_othertabs_std('#divCntSlider');},500); 
    ".$toggleForm."
    bind_form('Slider','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new SliderI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addSliderI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new SliderI18n();$mt->setLocale('en_US')->setText('');$dataObj->addSliderI18n($mt)->save();}
            
        $this->fieldsRo['Slider']['Title']['html'] = stdFieldRow(_("Titre"), input('text','Title',$dataObj->getTitle()," readonly s='d'"), 'Title', "", @$this->commentsTitle, @$this->commentsTitle_css, 'readonly', ' ','no','');
$this->fieldsRo['Slider']['Online']['html'] = stdFieldRow(_("En ligne"), input('text','Online',$dataObj->getOnline()," readonly s='d'"), 'Online', "", @$this->commentsOnline, @$this->commentsOnline_css, 'readonly', ' ','no','');
$this->fieldsRo['Slider']['Order']['html'] = stdFieldRow(_("Ordre d'affichage"), input('text','Order',$dataObj->getOrder()," readonly s='d'"), 'Order', "", @$this->commentsOrder, @$this->commentsOrder_css, 'readonly', ' ','no','');
$this->fieldsRo['Slider']['SliderI18n_Text_frCA']['html'] = stdFieldRow(_("Texte français"), textarea('SliderI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText()," readonly class='tinymce'    s='d'"), 'SliderI18n_Text_frCA', "", @$this->commentsSliderI18n_Text_frCA, @$this->commentsSliderI18n_Text_frCA_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Slider']['SliderI18n_Text_enUS']['html'] = stdFieldRow(_("Texte anglais"), textarea('SliderI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText()," readonly class='tinymce'    s='d'"), 'SliderI18n_Text_enUS', "", @$this->commentsSliderI18n_Text_enUS, @$this->commentsSliderI18n_Text_enUS_css, 'readonly istinymce', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['Slider'] as $field=>$ar){
                $this->fields['Slider'][$field]['html'] = $this->fieldsRo['Slider'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['Slider'][$field]['html'] = $this->fieldsRo['Slider'][$field]['html'];
            }
        }
    }
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = SliderQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdSlider'));
            
        
        }else{
            $q->select(array('Name', 'IdSlider'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = SliderQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdSlider'));
            
        
        }else{
            $q->select(array('Name', 'IdSlider'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Slider')), $selected);
        }


        return $return;
    }	#@#############
    #	getChildList
    ###############
    public function getSliderFileList($IdSlider, $page='1', $uiTabsId='SliderFileTableCntnr', $parentContainer='', $mja_list='', $search='', $params = ''){
        /*init var*/
        global $request;
        if(empty($page)){$page=1;}$param=array();
        if(!empty($_SESSION['memoire']['onglet']['SliderSliderFile']['pg'])){$page = $_SESSION['memoire']['onglet']['SliderSliderFile']['pg'];}
        if(!empty($search['order'])){$this->searchOrder = $search['order'];}
        
        if(empty($search['ms'])){ $searchAr =$search;}else{$this->searchMs = $search['ms']; }

        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    @$child_order .="
                        $(\"#cntSliderChild [th='sorted'][c='".$col."'],#cntSliderChild [th='sorted'][rc='".$col."']\").attr('sens','".$sens."');
                        $(\"#cntSliderChild [th='sorted'][c='".$col."'],#cntSliderChild [th='sorted'][rc='".$col."']\").attr('order','on');
                    ";
                }
            }
        }
        
        if($parentContainer == 'editDialog'){$diagNoClose = "diag:\"noclose\", ";$diagNoCloseEscaped = "diag:\\\"noclose\\\", ";}
        if(isset($this->Slider['request']['noHeader']) && $this->Slider['request']['noHeader'] == 'true'){$noHeader = "'noHeader':'true',";}
        $data['IdSlider'] = $IdSlider;

        $dataObj = SliderQuery::create()->findPk($IdSlider);
        if($dataObj == null){$dataObj = new Slider();$dataObj->setIdSlider($IdSlider);}
        $this->dataObj =$dataObj;
        

        $this->SliderFile['list_add'] = "
        $('#addSliderFile').click(function(){
            $.post('"._SITE_URL."mod/act/SliderFileAct.php', {a:'edit', ui:'editDialog',pc:'Slider', je:'SliderFileTableCntnr', jet:'tr', tp:'SliderFile', ip:'".$IdSlider."'},
                function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); $('#editDialog').dialog('option','title','".addSlashes(_('Upload d\'images'))."'); });
        });";
        $this->SliderFile['list_delete'] = "
        $(\"[j='deleteSliderFile']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Upload d\'images'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."','$.post(\""._SITE_URL."mod/act/SliderFileAct.php\", {".@$diagNoCloseEscaped.@$diagNoClose." a:\"delete\", ui:\"".$uiTabsId."\", i:'+$(this).attr('i')+', ip:\"".$IdSlider."\", pc:\"Slider\", je:\"SliderFileTableCntnr\", jet:\"tr\"}, function(data){ if(data)$(\"#SliderFileTableCntnr\").append(data);});');
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('SliderSliderFile', 'r')){ $this->SliderFile['list_edit'] = "
        $(\"#SliderFileTable[listchild=1] tr[ecf=1] td[j='editSliderFile']\").bind('click', function (){
            
        $.post('"._SITE_URL."mod/act/SliderFileAct.php',
                {a:'edit', i:$(this).attr('i'), ip:'".$IdSlider."', ui:'editDialog',pc:'Slider', je:'SliderFileTableCntnr', jet:'tr', 'it-pos':$(this).data('iterator-pos') },
            function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";}
        $rigthButtonAction="";
        if($_SESSION[_AUTH_VAR]->hasRights('SliderSliderFile', 'w')){
            $rigthButtonAction='';
        }
        $filterKey = $IdSlider;
        
        $maxPerPage = (!empty($this->SliderFile['request']['maxperpage']))?$this->SliderFile['request']['maxperpage']:_paging_nbr_per_page;
        try{
            $q = SliderFileQuery::create();
            
            
            $q ->filterByIdSlider( $filterKey );;  
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
        
        
        
        
        
        
        if(isset($this->Slider['request']['noHeader']) && $this->Slider['request']['noHeader'] == 'true'){
            $header_search = "";
        }else{
            $header_search = ''
        .div(
            
            form('' , " CntTabs=1 id='formMsSliderFile'")
        ,'',' class="msSearchCtnr"')
        .div($rigthButtonAction, '', 'class="ac-right-action-buttons"')
        .button(span(_("Afficher le menu"),'data-tooltip="'.addslashes("Afficher le menu").'" '),'class="toggle-child-nav-btn"');
        }
        
        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('SliderSliderFile', 'd') and empty($this->readOnlyFilter)){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( @$this->cCmoreColsHeaderFirstSliderFile.th(_("Name"), " th='sorted'  rcColone='Name' c='Name'  ").th(_("Poids"), " th='sorted'  rcColone='Size' c='Size'  ").$this->cCmoreColsHeaderSliderFile.$actionRowHeader, " ln='SliderFile' class=''");
        $i=0;
        if(empty($pmpoData) || !method_exists($pmpoData,'isEmpty')){
            @$tr .= tr(	td(p(span(_("Une erreur est survenue veuillez vider votre recherche.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='SliderFile' colspan='100%' "));
            
        }else if( $pmpoData->isEmpty() ){
            @$tr .= tr(	td(p(span(_("Aucun enregistrement pour le moment.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='SliderFile' colspan='100%' "));
            
        }else{
            
            foreach($pmpoData as $data){
                
                
                $actionRow = '';
                
                $this->ListActionRowSliderFile = (!empty($this->cCListActionRowSliderFile))?str_replace('%idpk%', json_encode($data->getPrimaryKey()), $this->cCListActionRowSliderFile):$this->ListActionRowSliderFile;
                $this->ListActionRowSliderFile = (!empty($this->cCListActionRowSliderFile))?str_replace('%i%', $i, $this->ListActionRowSliderFile):$this->ListActionRowSliderFile;
                
                if($_SESSION[_AUTH_VAR]->hasRights('SliderSliderFile', 'd') and empty($this->readOnlyFilter) ){$actionRow = htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteSliderFile' i='".json_encode($data->getPrimaryKey())."'");}
                
                $imgPath = $data->getFichier()."?pc=Slider&token=".MD5(_ENCODE.$data->getPrimaryKey())."|".MD5(_ENCODE.$_SESSION[_AUTH_VAR]->get('id'));
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
        $url = _SITE_URL.$data->getFichier()."?pc=Slider&token=".MD5(_ENCODE.$data->getPrimaryKey())."|".MD5(_ENCODE.$_SESSION[_AUTH_VAR]->get('id'));
    $actionRow .= htmlLink($imgPath,$url, "  j='imageSliderFile' i='".$data->getPrimaryKey()."' ");
                
                

                $actionRow = $actionRow;
                $addClass='';
                $cnt= substr_count($actionRow,'<a');
                if($cnt){ $addClass=' actionrow'.$cnt;}
                $actionRow = (!empty($actionRow))?td($this->ListActionRowSliderFile.$actionRow," class='actionrow ".$addClass."'"):"";
                
                
                
                ;
                
                if(isset($this->search['highlight']) && is_array($this->search['highlight'])){
                    $highlight = (in_array(json_encode($data->getPrimaryKey()), $this->search['highlight']))?'highlight':'';
                }
                
                $child_edit_columns_filter ="1";
    
                @$tr .= 
                        tr(
                            @$cCmoreColsSliderFileFirst.
                            td(span(strip_tags((isset($altValue['Name']) and $altValue['Name'])?$altValue['Name']:$data->getName()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Name").":\" j='editSliderFile'  i='".json_encode($data->getPrimaryKey())."' c='Name'  ")
                            .td(span(strip_tags((isset($altValue['Size']) and $altValue['Size'])?$altValue['Size']:$data->getSize()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Poids").":\" j='editSliderFile'  i='".json_encode($data->getPrimaryKey())."' c='Size'  ")
                            .
                            
                            @$cCmoreColsSliderFile.
                            @$actionRow
                        ,"id='SliderFileRow".$data->getPrimaryKey()."' data-id='".$data->getPrimaryKey()."' data-pc-table='Slider' data-table='SliderFile' data-edit='Upload d'images #".$data->getPrimaryKey()."' ecf='".$child_edit_columns_filter."' ln='SliderFile' class=' ".@$highlight.@$param['class']."'  ")
                        ;
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(div(@$total_child,'','class="nolink"')
                            ,'trSliderFile'," style='".@$hide_SliderFile."' ln='SliderFile' class=''").@$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    
    if(($_SESSION[_AUTH_VAR]->hasRights('SliderSliderFile', 'a')) ){
        $add_button_child =""
            .div(
                htmlLink(
                    span(_("Ajouter"))
                , "Javascript:","id='pickfiles' class='button-link-blue add-button'")

            .div('', 'filelist')
            ,'upload-SliderFile',' class="listHeaderItem " ');
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
                    ,'','id="SliderFilePagination"')
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
                 $this->CcToSliderFileListTop
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
                                    .$this->CcToSliderFileTableFooter
                                , "id='SliderFileTable' listchild=1 class='tablesorter'")
                            , 'formSliderFile')
                            .$this->CcToSliderFileListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list contentHolderList" ')

                    .@$pagerRow
                ,'SliderFileListForm')
            ,'cntSliderFiledivChild',' class="" ');
            

                    @$return['js'] .= "
bindChangePic('SliderFile','Slider');
$(function(){
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,html4',
        browse_button : 'pickfiles',
        container: document.getElementById('upload-SliderFile'),
        url: '"._SITE_URL_NO_S."mod/act/SliderFileAct.php?a=file&pc=Slider&ip=".$filterKey."&IdUser=".$_SESSION[_AUTH_VAR]->get('id')."&blob=',
        flash_swf_url : '"._SITE_URL."/js/plupload/Moxie.swf',
        drop_element : 'pickfiles',

        filters : {\"max_file_size\":\"10mb\",\"mime_types\":[{\"title\":\"images\",\"extensions\":\"jpg,png\"}]},
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
                $('[j=conglet_Slider][p=\"SliderFile\"]').click();

            }
        }
    });
    uploader.init();
});";

            $jqueryDatePickerChild = "beforeDatePicker('');";
            @$return['js'] .= "
                
                
            ";
            $return['onReadyJs'] =
                @$this->CcToSliderFileListJsFirst
                .$this->SliderFile['list_add']
                .$this->SliderFile['list_delete']
                .$this->SliderFile['list_edit']
            ."
                
                
            ".@$total_child_js."
            
            
            
            child_button_bind('SliderFile');
            child_pagination_bind('SliderFile','Slider','".$uiTabsId."','".$IdSlider."','','".$this->CcToSearchMsPost."');
            child_pagination_sorted_bind('SliderFile','Slider','".$uiTabsId."','".$IdSlider."','".$this->CcToSearchMsPost."');
               
            $('#cntSliderChild .js-select-label').SelectBox();
            
            ".@$child_order."
            
            
            ".$jqueryDatePickerChild."
            ";
            $return['onReadyJs'] .= "".$this->CcToSliderFileListJs;
            return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'SliderAct.php';
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
        $this->cCmoreColsHeaderSliderFile = '';
        $this->ListActionRowSliderFile = '';
        $this->cCmoreColsSliderFile = '';
        $this->CcToSliderFileTableFooter = '';
        $this->CcToSliderFileListTop = '';
        $this->CcToSliderFileListBottom = '';
        $this->CcToSliderFileListJs = '';
        
    }

    
}
