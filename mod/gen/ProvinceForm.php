<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'Province' table.
 *
 */
class ProvinceForm extends Province{
public $tableName="Province";
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
        $q = ProvinceQuery::create();
        if($this->CcToSearchList){ getSelectFilter($this->CcToSearchList,$q);}
        if(is_array($this->searchAr)){
            array_walk_recursive ($this->searchAr, function (&$v){$v=trim($v);});
            ## query sub-Menu
            if(@$this->searchAr['v'] && !$this->searchAr['uv']){
                $filterStr = "filterBy".$this->searchAr['f'];
                $q 
->joinWith('Pays') 
->joinWith('GrpTaxe')
                    ->$filterStr($this->searchAr['v']);
                    
                    
            }elseif(@$this->searchAr['u'] && $this->searchAr['uv']){
                $useStr = "use".$this->searchAr['u']."Query";
                $filterStr = "filterBy".$this->searchAr['f'];
                $q->$useStr()->$filterStr($this->searchAr['uv'])->endUse()
                     
->joinWith('Pays') 
->joinWith('GrpTaxe');
            }else{
                $q 
->joinWith('Pays') 
->joinWith('GrpTaxe');
            }
        }else{
            if(is_array($this->searchMs )){
                array_walk_recursive($this->searchMs, function (&$v){$v=trim($v);});
                $q 
->joinWith('Pays') 
->joinWith('GrpTaxe');
                if(isset($this->searchMs['Title']) and $this->searchMs['Title'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Title']) and strpos($this->searchMs['Title'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Title'] != '%DoNothing%' AND $this->searchMs['Title'][0] != '%DoNothing%'){
                        $q->filterByTitle("%".$this->searchMs['Title']."%", Criteria::LIKE);
                    }
                }
                if(isset($this->searchMs['IdPays']) and $this->searchMs['IdPays'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['IdPays']) and strpos($this->searchMs['IdPays'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['IdPays'] != '%DoNothing%' AND $this->searchMs['IdPays'][0] != '%DoNothing%'){
                        $q ->filterByIdPays($this->searchMs['IdPays'],$criteria);
                    }
                }
            }else{
                
                $hasParent = json_decode($IdParent);
                if(empty($hasParent)){
                    $q 
->joinWith('Pays') 
->joinWith('GrpTaxe');
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
        
         $q->groupBy('IdProvince');
        
        $this->pmpoData =  $q;
        //echo $q->toString();
        //$q->paginate($page, $maxPerPage);
        return $this->pmpoData;
    }
    public function getListHeader($act){
        switch($act){
            case 'head':
            ###### TH
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Pays"), " th='sorted'  rcColone='IdPays' c='Pays.Title' rc='Pays.Title' ").th(_("Identifiant"), " th='sorted'  rcColone='Title' c='Title'  "). $this->cCmoreColsHeader;
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
                $array_search_tb = array('Title','IdPays');
                
        if(in_array('IdPays',$array_search_tb)){$this->arrayIdPaysOptions = $this->selectBoxProvince_IdPays(@$dataObj, @$data);}
        if(in_array('IdGrpTaxe',$array_search_tb)){$this->arrayIdGrpTaxeOptions = $this->selectBoxProvince_IdGrpTaxe(@$dataObj, @$data);}
                unset($data);$data['Title'] = (!empty($this->searchMs['Title']))?$this->searchMs['Title']:'';
        $data['IdPays'] = (!empty($this->searchMs['IdPays']))?$this->searchMs['IdPays']:'';
        
                
        @$this->fieldsSearch['Province']['Title'] = div(input('text', 'Title', $this->searchMs['Title'], ' othertabs=1  placeholder="'._('Province').'"',''),'','class="ac-search-item ms-Title"');
        @$this->fieldsSearch['Province']['IdPays'] = div(selectboxCustomArray('IdPays', $this->arrayIdPaysOptions, _('Pays') , "v='ID_PAYS'  s='d' otherTabs=1 ", $this->searchMs['IdPays']), '', ' class="ac-search-item  ms-IdPays"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msProvinceAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['Province']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msProvinceBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msProvinceBtClear" class="icon clear"')
               .@$this->fieldsSearch['Province']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['Province']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-ProvinceSearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['Province']['Start'].
                    $this->fieldsSearch['Province']['Title'].
                    $this->fieldsSearch['Province']['IdPays'].
                @$this->fieldsSearch['Province']['End'].
            $this->fieldsSearch['Province']['Button']
            ,"id='formMsProvince' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('Province', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."Province/edit/", "id='addProvince' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addProvinceAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Province");
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
        if(!empty($_SESSION['memoire']['onglet']['Province']['pg'])){
            $page = $_SESSION['memoire']['onglet']['Province']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'ProvinceAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'ProvinceAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#ProvinceListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#ProvinceListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('Province', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('Province', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('Province', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteProvince' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
        $altValue['Pays_Title'] = "";
        if($data->getPays()){
            $altValue['Pays_Title'] = $data->getPays()->getTitle();
        }
                
                
                
                 $titreRaccour =''; $titreRaccour .= _('Province');
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['IdPays']) and $altValue['IdPays'])?$altValue['IdPays']:$altValue['Pays_Title']." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Pays").":\" j='editProvince'  i='".json_encode($data->getPrimaryKey())."' c='IdPays'  ")
                            .td(span(strip_tags((isset($altValue['Title']) and $altValue['Title'])?$altValue['Title']:$data->getTitle()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Identifiant").":\" j='editProvince'  i='".json_encode($data->getPrimaryKey())."' c='Title'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='ProvinceRow".$data->getPrimaryKey()."'
                    data-table='Province' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountProvince', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Province';

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
                            ,'','id="ProvincePagination"')
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
                .div($controlsContent.$this->CcCustomControl,'ProvinceControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='ProvinceTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'ProvinceListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#ProvinceListForm [j='deleteProvince']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Province'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msProvinceBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msProvinceBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#ProvinceListForm tr[ecf=1] td[j='editProvince']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."Province/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."Province/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Province'
                ,'IdProvince'
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
        $(\"#ProvinceListForm [j='deleteProvince']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Province'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msProvinceBt\').length>0){ $(\'#msProvinceBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'ProvinceTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntProvinceListForm #addProvince').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'ProvinceTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#ProvinceListForm tr[ecf=1] td[j='editProvince']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'ProvinceTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Province'
                ,'IdProvince'
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
        pagination_bind('Province','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#ProvinceListForm [j='deleteProvince']\").unbind('click');
        $('#ProvinceListForm #addProvince').unbind('click');
        $(\"#ProvinceListForm tr[ecf=1] td[j='editProvince']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#ProvinceListForm [j='button']\").unbind();   
        pagination_sorted_bind('Province','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('Province','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('Province','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_Province($data){

        unset($data['IdProvince']);
        $e = new Province();
        
        
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_Province($data){

        
        $e = ProvinceQuery::create()->findPk(json_decode($data['i']));
        
        
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of Province
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
        $je= "ProvinceTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['Province']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['Province']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addProvince_child').bind('click.addProvince', function (){
                    $.post('"._SITE_URL."mod/act/ProvinceAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addProvince_child').bind('click.addProvince', function (){
                document.location= '"._SITE_URL."Province/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = ProvinceQuery::create()->joinWith('Pays') ->joinWith('GrpTaxe');
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Province', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Province','w',$dataObj)) 
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
                    $('#formProvince #saveProvince').removeAttr('disabled');
                    $('#formProvince #saveProvince').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formProvince #saveProvince').css('cursor', 'default');
                    if($('#formProvince #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formProvince #saveProvince').bind('click.saveProvince', function (data){
                    $('#formProvince #saveProvince').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formProvince #saveProvince').css('cursor', 'progress');
                    $('#formProvince #saveProvince').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formProvince .tinymce').each(function(index) {
                        eval(' $(\"#formProvince #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formProvince select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formProvince\").find(\"[s='d']\").serializeArray();
                        $('#formProvince select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formProvince\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/ProvinceAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formProvince #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formProvince #formChangedProvince').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formProvince #saveProvince').unbind('click.saveProvince');
                $('#formProvince #saveProvince').remove();";
        }
        
        if($dataObj == null){
            $this->Province['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Province();
            $this->Province['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }

        ($dataObj->getPays())?'':$dataObj->setPays( new Pays() );
        ($dataObj->getGrpTaxe())?'':$dataObj->setGrpTaxe( new GrpTaxe() );

        
        $this->arrayIdPaysOptions = $this->selectBoxProvince_IdPays(@$dataObj, @$data);
        $this->arrayIdGrpTaxeOptions = $this->selectBoxProvince_IdGrpTaxe(@$dataObj, @$data);
        
        
        
        
        
        

            $this->fields['Province']['IdPays']['html'] = stdFieldRow(htmlLink(_('Pays'),'javascript:','  label_lien="IdPays"  class="label_link js-label-link" '), selectboxCustomArray('IdPays', $this->arrayIdPaysOptions, _(""), "v='ID_PAYS'  s='d' otherTabs=1  val='".$dataObj->getIdPays()."'", $dataObj->getIdPays()), 'IdPays', "", @$this->commentsIdPays, @$this->commentsIdPays_css, '', ' ','no','');

            $this->fields['Province']['IdGrpTaxe']['html'] = stdFieldRow(htmlLink(_('Groupe de taxes'),'javascript:','  label_lien="IdGrpTaxe"  class="label_link js-label-link" '), selectboxCustomArray('IdGrpTaxe', $this->arrayIdGrpTaxeOptions, _(""), "v='ID_GRP_TAXE'  s='d' otherTabs=1  val='".$dataObj->getIdGrpTaxe()."'", $dataObj->getIdGrpTaxe()), 'IdGrpTaxe', "", @$this->commentsIdGrpTaxe, @$this->commentsIdGrpTaxe_css, '', ' ','no','');

            $this->fields['Province']['Title']['html'] = stdFieldRow(_("Identifiant"), input('text', 'Title',str_replace('"','&quot;',$dataObj->getTitle()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Identifiant'))."' size='69'  v='TITLE' s='d' class=''")."", 'Title', "", @$this->commentsTitle, @$this->commentsTitle_css, '', ' ','no','');

            $this->fields['Province']['ProvinceI18n_Name_frCA']['html'] = stdFieldRow(_("Province français"), input('text', 'ProvinceI18n_Name_frCA',str_replace('"','&quot;',$dataObj->getTranslation('fr_CA')->getName()), "placeholder='".str_replace("'","&#39;",_('Province fr_CA'))."' size='69' otherTabs=1  v='PROVINCEI18N_NAME_FRCA' s='d'  class=''")."", 'ProvinceI18n_Name_frCA', "", @$this->commentsProvinceI18n_Name_frCA, @$this->commentsProvinceI18n_Name_frCA_css, '', ' ','no','');

            $this->fields['Province']['ProvinceI18n_Name_enUS']['html'] = stdFieldRow(_("Province anglais"), input('text', 'ProvinceI18n_Name_enUS',str_replace('"','&quot;',$dataObj->getTranslation('en_US')->getName()), "placeholder='".str_replace("'","&#39;",_('Province en_US'))."' size='69' otherTabs=1  v='PROVINCEI18N_NAME_ENUS' s='d'  class=''")."", 'ProvinceI18n_Name_enUS', "", @$this->commentsProvinceI18n_Name_enUS, @$this->commentsProvinceI18n_Name_enUS_css, '', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->Province['request']['ChildHide']) ){
            
        }
        
        
        if($dataObj->getIdProvince()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'ProvinceControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = '';
            }

        }
        
        $ongletf =
            div(
                ul(li(htmlLink(_('Province'),'#ogf_Province',' j="ogf" p="Province" class="ui-tabs-anchor button-link-blue" ')).li(htmlLink(_('Français'),'#ogf_Provincei18nNameFrca',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Province" ')).li(htmlLink(_('Anglais'),'#ogf_Provincei18nNameEnus',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Province" ')))
            ,'cntOngletProvince',' class="cntOnglet"')
            .@$close_form
        ;
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addProvince_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveProvince',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedProvince','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdProvince', $dataObj->getIdProvince(), " otherTabs=1 s='d' pk").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'ProvinceControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formProvince');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['Province']['tog']) and 
            $_SESSION['memoire']['onglet']['Province']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['Province']['Start']['html']
                
                .
                    '<div id="ogf_Province">'.
$this->fields['Province']['IdPays']['html']
.$this->fields['Province']['IdGrpTaxe']['html']
.$this->fields['Province']['Title']['html']
.'</div><div id="ogf_Provincei18nNameFrca"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Province']['ProvinceI18n_Name_frCA']['html']
.'</div><div id="ogf_Provincei18nNameEnus"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Province']['ProvinceI18n_Name_enUS']['html'].'</div>'
                
                .@$this->fields['Province']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntProvince", "class='divStdform' CntTabs=1 ")
        , "id='formProvince' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Province"); }
        # if not new, show child table
        if($dataObj->getIdProvince()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelProvince', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntProvinceChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['Province']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['Province']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['Province']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    
    ".$jqueryDatePicker."
    bind_ui_active('Province');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    $(\"[label_lien='IdPays']\").bind('click', function (){
        if($('#IdPays').val()){ window.open('"._SITE_URL."Pays/edit/'+$('#IdPays').val());}else{window.open('"._SITE_URL."Pays/list/');}
    });
    $(\"[label_lien='IdGrpTaxe']\").bind('click', function (){
        if($('#IdGrpTaxe').val()){ window.open('"._SITE_URL."GrpTaxe/edit/'+$('#IdGrpTaxe').val());}else{window.open('"._SITE_URL."GrpTaxe/list/');}
    });$('#cntOngletProvince').parent().tabs();$('#cntOngletProvince').show();
    ".@$childTable['onReadyJs']."
    ".@$error['onReadyJs']."
    ".@$removeEditChild."
    /*try {afterFormLoad();}catch(e){}*/
    if($('#loader').css('display') == 'block') $('#loader').hide();
    $('[j=sftr]').hide();
    ".@$tabs_act."
    ".$this->CcToFormJs
    .@$script_autoc_one."
     setTimeout(function(){ bind_othertabs_std('#divCntProvince');},500); 
    ".$toggleForm."
    bind_form('Province','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
        ($dataObj->getPays())?'':$dataObj->setPays( new Pays() );
        ($dataObj->getGrpTaxe())?'':$dataObj->setGrpTaxe( new GrpTaxe() );
            
        $this->fieldsRo['Province']['IdPays']['html'] = stdFieldRow(htmlLink(_('Pays'),'javascript:','  label_lien="IdPays"  class="label_link js-label-link" '), 
                    input('text','IdPaysLabel',$dataObj->getPays()->getTitle(),"  readonly s='d'")
                    .input('hidden','IdPays',$dataObj->getIdPays()," readonly s='d'"), 'IdPays', "", @$this->commentsIdPays, @$this->commentsIdPays_css, 'readonly', ' ','no','');
$this->fieldsRo['Province']['IdGrpTaxe']['html'] = stdFieldRow(htmlLink(_('Groupe de taxes'),'javascript:','  label_lien="IdGrpTaxe"  class="label_link js-label-link" '), 
                    input('text','IdGrpTaxeLabel',$dataObj->getGrpTaxe()->getName(),"  readonly s='d'")
                    .input('hidden','IdGrpTaxe',$dataObj->getIdGrpTaxe()," readonly s='d'"), 'IdGrpTaxe', "", @$this->commentsIdGrpTaxe, @$this->commentsIdGrpTaxe_css, 'readonly', ' ','no','');
$this->fieldsRo['Province']['Title']['html'] = stdFieldRow(_("Identifiant"), input('text','Title',$dataObj->getTitle()," readonly s='d'"), 'Title', "", @$this->commentsTitle, @$this->commentsTitle_css, 'readonly', ' ','no','');
$this->fieldsRo['Province']['ProvinceI18n_Name_frCA']['html'] = stdFieldRow(_("Province français"), input('text','ProvinceI18n_Name_frCA',$dataObj->getTranslation('fr_CA')->getName()," readonly s='d'"), 'ProvinceI18n_Name_frCA', "", @$this->commentsProvinceI18n_Name_frCA, @$this->commentsProvinceI18n_Name_frCA_css, 'readonly', ' ','no','');
$this->fieldsRo['Province']['ProvinceI18n_Name_enUS']['html'] = stdFieldRow(_("Province anglais"), input('text','ProvinceI18n_Name_enUS',$dataObj->getTranslation('en_US')->getName()," readonly s='d'"), 'ProvinceI18n_Name_enUS', "", @$this->commentsProvinceI18n_Name_enUS, @$this->commentsProvinceI18n_Name_enUS_css, 'readonly', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['Province'] as $field=>$ar){
                $this->fields['Province'][$field]['html'] = $this->fieldsRo['Province'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['Province'][$field]['html'] = $this->fieldsRo['Province'][$field]['html'];
            }
        }
    }
    /*Option function for Province_IdPays selectBox */
    public function selectBoxProvince_IdPays($dataObj='',$data='', $emptyVal=false,$array=true){
$q = PaysQuery::create();

    $q->addAsColumn('selDisplay', 'CONCAT_WS ( " ", pays.title, "" )');
    $q->select(array('selDisplay', 'IdPays'));
    $q->orderBy('selDisplay', 'ASC');
if(!$array){return $q;}else{$pcDataO = $q->find();}


$arrayOpt = $pcDataO->toArray();
return assocToNum($arrayOpt , true);
}
    /*Option function for Province_IdGrpTaxe selectBox */
    public function selectBoxProvince_IdGrpTaxe($dataObj='',$data='', $emptyVal=false,$array=true){
$q = GrpTaxeQuery::create();

    $q->addAsColumn('selDisplay', 'CONCAT_WS ( " ", grp_taxe.name, "" )');
    $q->select(array('selDisplay', 'IdGroupTaxeSup'));
    $q->orderBy('selDisplay', 'ASC');
if(!$array){return $q;}else{$pcDataO = $q->find();}


$arrayOpt = $pcDataO->toArray();
return assocToNum($arrayOpt , true);
}
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = ProvinceQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Title', 'IdProvince'));
            
        
        }else{
            $q->select(array('Title', 'IdProvince'));
        }
        $pcData = $q->orderBy('Title', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = ProvinceQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Title', 'IdProvince'));
            
        
        }else{
            $q->select(array('Title', 'IdProvince'));
        }
        $pcData = $q->orderBy('Title', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Province')), $selected);
        }


        return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'ProvinceAct.php';
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
