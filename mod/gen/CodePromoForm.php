<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'CodePromo' table.
 *
 */
class CodePromoForm extends CodePromo{
public $tableName="CodePromo";
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
        $q = CodePromoQuery::create();
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
                if(isset($this->searchMs['Used']) and $this->searchMs['Used'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Used']) and strpos($this->searchMs['Used'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Used'] != '%DoNothing%' AND $this->searchMs['Used'][0] != '%DoNothing%'){
                        $q ->filterByUsed($this->searchMs['Used'],$criteria);
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
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Code"), " th='sorted'  rcColone='Code' c='Code'  ").th(_("Date de début"), " th='sorted'  rcColone='DateDebut' c='DateDebut'  ").th(_("Date de fin"), " th='sorted'  rcColone='DateFin' c='DateFin'  ").th(_("Utilisation"), " th='sorted'  rcColone='Type' c='Type'  ").th(_("Utilisé"), " th='sorted'  rcColone='Used' c='Used'  ").th(_("Montant"), " th='sorted'  rcColone='Montant' c='Montant'  ").th(_("Pourcent"), " th='sorted'  rcColone='Pourcent' c='Pourcent'  "). $this->cCmoreColsHeader;
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
                $array_search_tb = array('Title','Used');
                
                unset($data);$data['Title'] = (!empty($this->searchMs['Title']))?$this->searchMs['Title']:'';
        $data['Used'] = (!empty($this->searchMs['Used']))?$this->searchMs['Used']:'';
        
                
        @$this->fieldsSearch['CodePromo']['Title'] = div(input('text', 'Title', $this->searchMs['Title'], ' othertabs=1  placeholder="'._('Code').'"',''),'','class="ac-search-item ms-Title"');
        @$this->fieldsSearch['CodePromo']['Used'] =div(selectboxCustomArray('Used', array( '0' => array('0'=>_("Actif"), '1'=>'Actif'),'1' => array('0'=>_("Inactif"), '1'=>'Inactif'), ), _('Utilisé'), '  size="1" t="1"   ', $this->searchMs['Used']), '', '  class=" ac-search-item ms-Used"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msCodePromoAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['CodePromo']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msCodePromoBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msCodePromoBtClear" class="icon clear"')
               .@$this->fieldsSearch['CodePromo']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['CodePromo']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-CodePromoSearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['CodePromo']['Start'].
                    $this->fieldsSearch['CodePromo']['Title'].
                    $this->fieldsSearch['CodePromo']['Used'].
                @$this->fieldsSearch['CodePromo']['End'].
            $this->fieldsSearch['CodePromo']['Button']
            ,"id='formMsCodePromo' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('CodePromo', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."CodePromo/edit/", "id='addCodePromo' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addCodePromoAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Code Promotion");
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
        if(!empty($_SESSION['memoire']['onglet']['CodePromo']['pg'])){
            $page = $_SESSION['memoire']['onglet']['CodePromo']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'CodePromoAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'CodePromoAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
            $search_child_default['DateFin']='desc';
        if(empty($this->searchOrder)){$this->searchOrder = $search_child_default;}
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#CodePromoListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#CodePromoListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('CodePromo', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('CodePromo', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('CodePromo', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteCodePromo' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
                
                
                
                 $titreRaccour =''; $titreRaccour .= _('Code Promotion');
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['Code']) and $altValue['Code'])?$altValue['Code']:$data->getCode()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Code").":\" j='editCodePromo'  i='".json_encode($data->getPrimaryKey())."' c='Code'  ")
                            .td(span(strip_tags((isset($altValue['DateDebut']) and $altValue['DateDebut'])?$altValue['DateDebut']:$data->getDateDebut()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Date de début").":\" j='editCodePromo'  i='".json_encode($data->getPrimaryKey())."' c='DateDebut'  ")
                            .td(span(strip_tags((isset($altValue['DateFin']) and $altValue['DateFin'])?$altValue['DateFin']:$data->getDateFin()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Date de fin").":\" j='editCodePromo'  i='".json_encode($data->getPrimaryKey())."' c='DateFin'  ")
                            .td(span(strip_tags((isset($altValue['Type']) and $altValue['Type'])?$altValue['Type']:isntPo($data->getType())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Utilisation").":\" j='editCodePromo'  i='".json_encode($data->getPrimaryKey())."' c='Type'  ")
                            .td(span(strip_tags((isset($altValue['Used']) and $altValue['Used'])?$altValue['Used']:isntPo($data->getUsed())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Utilisé").":\" j='editCodePromo'  i='".json_encode($data->getPrimaryKey())."' c='Used'  ")
                            .td(span(strip_tags((isset($altValue['Montant']) and $altValue['Montant'])?$altValue['Montant']:str_replace(',','.',$data->getMontant())." $"),'class="ac-list-td-content"'),"  data-responsive=\""._("Montant").":\" j='editCodePromo'  i='".json_encode($data->getPrimaryKey())."' c='Montant'  ")
                            .td(span(strip_tags((isset($altValue['Pourcent']) and $altValue['Pourcent'])?$altValue['Pourcent']:$data->getPourcent()." %"),'class="ac-list-td-content"'),"  data-responsive=\""._("Pourcent").":\" j='editCodePromo'  i='".json_encode($data->getPrimaryKey())."' c='Pourcent'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='CodePromoRow".$data->getPrimaryKey()."'
                    data-table='CodePromo' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountCodePromo', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Code Promotion';

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
                            ,'','id="CodePromoPagination"')
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
                .div($controlsContent.$this->CcCustomControl,'CodePromoControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='CodePromoTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'CodePromoListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#CodePromoListForm [j='deleteCodePromo']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Code Promotion'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msCodePromoBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msCodePromoBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#CodePromoListForm tr[ecf=1] td[j='editCodePromo']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."CodePromo/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."CodePromo/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'CodePromo'
                ,'IdCodePromo'
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
        $(\"#CodePromoListForm [j='deleteCodePromo']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Code Promotion'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msCodePromoBt\').length>0){ $(\'#msCodePromoBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'CodePromoTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntCodePromoListForm #addCodePromo').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'CodePromoTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#CodePromoListForm tr[ecf=1] td[j='editCodePromo']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'CodePromoTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'CodePromo'
                ,'IdCodePromo'
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
        pagination_bind('CodePromo','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#CodePromoListForm [j='deleteCodePromo']\").unbind('click');
        $('#CodePromoListForm #addCodePromo').unbind('click');
        $(\"#CodePromoListForm tr[ecf=1] td[j='editCodePromo']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#CodePromoListForm [j='button']\").unbind();   
        pagination_sorted_bind('CodePromo','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('CodePromo','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('CodePromo','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_CodePromo($data){

        unset($data['IdCodePromo']);
        $e = new CodePromo();
        
        
        if(!@$data['Type']){$data['Type'] = "Non unique";} 
        if(!@$data['Used']){$data['Used'] = "Actif";} 
        if(isset($data['Pourcent'])){$e->setPourcent(($data['Pourcent']=='')?null:$data['Pourcent']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setDateDebut( ($data['DateDebut'] == '' || $data['DateDebut'] == 'null' || substr($data['DateDebut'],0,10) == '-0001-11-30')?null:$data['DateDebut'] );
        $e->setDateFin( ($data['DateFin'] == '' || $data['DateFin'] == 'null' || substr($data['DateFin'],0,10) == '-0001-11-30')?null:$data['DateFin'] );
        $e->setMontant(($data['Montant']=='')?null:$data['Montant']);
        $e->setPourcent(($data['Pourcent']=='')?null:$data['Pourcent']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_CodePromo($data){

        
        $e = CodePromoQuery::create()->findPk(json_decode($data['i']));
        
        
        if(!@$data['Type']){$data['Type'] = "Non unique";} 
        if(!@$data['Used']){$data['Used'] = "Actif";} 
        if(isset($data['Pourcent'])){$e->setPourcent(($data['Pourcent']=='')?null:$data['Pourcent']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['DateDebut'])){$e->setDateDebut( ($data['DateDebut'] == '' || $data['DateDebut'] == 'null' || substr($data['DateDebut'],0,10) == '-0001-11-30')?NULL:$data['DateDebut'] );}
        if(isset($data['DateFin'])){$e->setDateFin( ($data['DateFin'] == '' || $data['DateFin'] == 'null' || substr($data['DateFin'],0,10) == '-0001-11-30')?NULL:$data['DateFin'] );}
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of CodePromo
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
        $je= "CodePromoTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['CodePromo']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['CodePromo']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addCodePromo_child').bind('click.addCodePromo', function (){
                    $.post('"._SITE_URL."mod/act/CodePromoAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addCodePromo_child').bind('click.addCodePromo', function (){
                document.location= '"._SITE_URL."CodePromo/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = CodePromoQuery::create();
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'CodePromo', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'CodePromo','w',$dataObj)) 
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
                    $('#formCodePromo #saveCodePromo').removeAttr('disabled');
                    $('#formCodePromo #saveCodePromo').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formCodePromo #saveCodePromo').css('cursor', 'default');
                    if($('#formCodePromo #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formCodePromo #saveCodePromo').bind('click.saveCodePromo', function (data){
                    $('#formCodePromo #saveCodePromo').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formCodePromo #saveCodePromo').css('cursor', 'progress');
                    $('#formCodePromo #saveCodePromo').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formCodePromo .tinymce').each(function(index) {
                        eval(' $(\"#formCodePromo #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formCodePromo select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formCodePromo\").find(\"[s='d']\").serializeArray();
                        $('#formCodePromo select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formCodePromo\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/CodePromoAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formCodePromo #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formCodePromo #formChangedCodePromo').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formCodePromo #saveCodePromo').unbind('click.saveCodePromo');
                $('#formCodePromo #saveCodePromo').remove();";
        }
        
        if($dataObj == null){
            $this->CodePromo['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new CodePromo();
            $this->CodePromo['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }


        
        
        
        
        
        
        

            $this->fields['CodePromo']['Code']['html'] = stdFieldRow(_("Code"), input('text', 'Code',str_replace('"','&quot;',$dataObj->getCode()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Code'))."' size='35'  v='CODE' s='d' class=''")."", 'Code', "", @$this->commentsCode, @$this->commentsCode_css, '', ' ','no','');

            $this->fields['CodePromo']['DateDebut']['html'] = stdFieldRow(_("Date de début"), input('date', 'DateDebut', $dataObj->getDateDebut(), "  otherTabs=1 j='date' placeholder='YYYY-MM-DD' size='10' otherTabs=1  s='d' class=''"), 'DateDebut', "", @$this->commentsDateDebut, @$this->commentsDateDebut_css, '', ' ','no','');

            $this->fields['CodePromo']['DateFin']['html'] = stdFieldRow(_("Date de fin"), input('date', 'DateFin', $dataObj->getDateFin(), "  otherTabs=1 j='date' placeholder='YYYY-MM-DD' size='10' otherTabs=1  s='d' class=''"), 'DateFin', "", @$this->commentsDateFin, @$this->commentsDateFin_css, '', ' ','no','');

            $this->fields['CodePromo']['Type']['html'] = stdFieldRow(_("Utilisation"), selectboxCustomArray('Type', array( '0' => array('0'=>_("Non unique"), '1'=>'Non unique'),'1' => array('0'=>_("Unique"), '1'=>'Unique'), ), "", "s='d' otherTabs=1  ", $dataObj->getType()), 'Type', "", @$this->commentsType, @$this->commentsType_css, '', ' ','no','');

            $this->fields['CodePromo']['Used']['html'] = stdFieldRow(_("Utilisé"), selectboxCustomArray('Used', array( '0' => array('0'=>_("Actif"), '1'=>'Actif'),'1' => array('0'=>_("Inactif"), '1'=>'Inactif'), ), "", "s='d' otherTabs=1  ", $dataObj->getUsed()), 'Used', "", @$this->commentsUsed, @$this->commentsUsed_css, '', ' ','no','');

            $this->fields['CodePromo']['Montant']['html'] = stdFieldRow(_("Montant"), input('text', 'Montant',$dataObj->getMontant(), "  placeholder='".str_replace("'","&#39;",_('Montant'))."'  v='MONTANT' otherTabs=1 size='5'    s='d' class='' otherTabs=1 "), 'Montant', span('$', 'class="ac-input-sup"'), @$this->commentsMontant, @$this->commentsMontant_css, '', ' ','no','');

            $this->fields['CodePromo']['Pourcent']['html'] = stdFieldRow(_("Pourcent"), input('number', 'Pourcent',$dataObj->getPourcent(), " step='10' placeholder='".str_replace("'","&#39;",_('Pourcent'))."' v='POURCENT' size='0' otherTabs=1 s='d' class='' otherTabs=1 "), 'Pourcent', span('%', 'class="ac-input-sup"'), @$this->commentsPourcent, @$this->commentsPourcent_css, '', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->CodePromo['request']['ChildHide']) ){
            
        }
        
        
        if($dataObj->getIdCodePromo()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'CodePromoControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = '';
            }

        }
        
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addCodePromo_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveCodePromo',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedCodePromo','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdCodePromo', $dataObj->getIdCodePromo(), " otherTabs=1 s='d' pk").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'CodePromoControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formCodePromo');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['CodePromo']['tog']) and 
            $_SESSION['memoire']['onglet']['CodePromo']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['CodePromo']['Start']['html']
                
                .
$this->fields['CodePromo']['Code']['html']
.$this->fields['CodePromo']['DateDebut']['html']
.$this->fields['CodePromo']['DateFin']['html']
.$this->fields['CodePromo']['Type']['html']
.$this->fields['CodePromo']['Used']['html']
.$this->fields['CodePromo']['Montant']['html']
.$this->fields['CodePromo']['Pourcent']['html']
                
                .@$this->fields['CodePromo']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntCodePromo", "class='divStdform' CntTabs=1 ")
        , "id='formCodePromo' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Code Promotion"); }
        # if not new, show child table
        if($dataObj->getIdCodePromo()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelCodePromo', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntCodePromoChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['CodePromo']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['CodePromo']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['CodePromo']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    
    ".$jqueryDatePicker."
    bind_ui_active('CodePromo');
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
     setTimeout(function(){ bind_othertabs_std('#divCntCodePromo');},500); 
    ".$toggleForm."
    bind_form('CodePromo','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
            
        $this->fieldsRo['CodePromo']['Code']['html'] = stdFieldRow(_("Code"), input('text','Code',$dataObj->getCode()," readonly s='d'"), 'Code', "", @$this->commentsCode, @$this->commentsCode_css, 'readonly', ' ','no','');
$this->fieldsRo['CodePromo']['DateDebut']['html'] = stdFieldRow(_("Date de début"), input('text','DateDebut',$dataObj->getDateDebut()," readonly s='d'"), 'DateDebut', "", @$this->commentsDateDebut, @$this->commentsDateDebut_css, 'readonly', ' ','no','');
$this->fieldsRo['CodePromo']['DateFin']['html'] = stdFieldRow(_("Date de fin"), input('text','DateFin',$dataObj->getDateFin()," readonly s='d'"), 'DateFin', "", @$this->commentsDateFin, @$this->commentsDateFin_css, 'readonly', ' ','no','');
$this->fieldsRo['CodePromo']['Type']['html'] = stdFieldRow(_("Utilisation"), input('text','Type',$dataObj->getType()," readonly s='d'"), 'Type', "", @$this->commentsType, @$this->commentsType_css, 'readonly', ' ','no','');
$this->fieldsRo['CodePromo']['Used']['html'] = stdFieldRow(_("Utilisé"), input('text','Used',$dataObj->getUsed()," readonly s='d'"), 'Used', "", @$this->commentsUsed, @$this->commentsUsed_css, 'readonly', ' ','no','');
$this->fieldsRo['CodePromo']['Montant']['html'] = stdFieldRow(_("Montant"), input('text','Montant',$dataObj->getMontant()," readonly s='d'"), 'Montant', span('$', 'class="ac-input-sup"'), @$this->commentsMontant, @$this->commentsMontant_css, 'readonly', ' ','no','');
$this->fieldsRo['CodePromo']['Pourcent']['html'] = stdFieldRow(_("Pourcent"), input('text','Pourcent',$dataObj->getPourcent()," readonly s='d'"), 'Pourcent', span('%', 'class="ac-input-sup"'), @$this->commentsPourcent, @$this->commentsPourcent_css, 'readonly', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['CodePromo'] as $field=>$ar){
                $this->fields['CodePromo'][$field]['html'] = $this->fieldsRo['CodePromo'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['CodePromo'][$field]['html'] = $this->fieldsRo['CodePromo'][$field]['html'];
            }
        }
    }
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = CodePromoQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdCodePromo'));
            
        
        }else{
            $q->select(array('Name', 'IdCodePromo'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = CodePromoQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdCodePromo'));
            
        
        }else{
            $q->select(array('Name', 'IdCodePromo'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Code Promotion')), $selected);
        }


        return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'CodePromoAct.php';
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
