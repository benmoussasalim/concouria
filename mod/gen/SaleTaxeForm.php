<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'SaleTaxe' table.
 *
 */
class SaleTaxeForm extends SaleTaxe{
public $tableName="SaleTaxe";
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
        $q = SaleTaxeQuery::create();
        if($this->CcToSearchList){ getSelectFilter($this->CcToSearchList,$q);}
        if(is_array($this->searchAr)){
            array_walk_recursive ($this->searchAr, function (&$v){$v=trim($v);});
            ## query sub-Menu
            if(@$this->searchAr['v'] && !$this->searchAr['uv']){
                $filterStr = "filterBy".$this->searchAr['f'];
                $q
->leftJoin('Taxe')
                    ->$filterStr($this->searchAr['v']);
                    
                    
            }elseif(@$this->searchAr['u'] && $this->searchAr['uv']){
                $useStr = "use".$this->searchAr['u']."Query";
                $filterStr = "filterBy".$this->searchAr['f'];
                $q->$useStr()->$filterStr($this->searchAr['uv'])->endUse()
                    
->leftJoin('Taxe');
            }else{
                $q
->leftJoin('Taxe');
            }
        }else{
            if(is_array($this->searchMs )){
                array_walk_recursive($this->searchMs, function (&$v){$v=trim($v);});
                $q
->leftJoin('Taxe');
            }else{
                
            if(json_decode($IdParent)){
                $pmpoData = SaleTaxeQuery::create()->filterByIdAbonnement(json_decode($IdParent))
                    
->leftJoin('Taxe')
                    
                    ->paginate($page, $maxPerPage);
            }
                $hasParent = json_decode($IdParent);
                if(empty($hasParent)){
                    $q
->leftJoin('Taxe');
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
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Taxe"), " th='sorted'  rcColone='IdTaxe' c='IdTaxe'  ").th(_("Name Taxe"), " th='sorted'  rcColone='Name' c='Name'  ").th(_("%"), " th='sorted'  rcColone='Pourcent' c='Pourcent'  ").th(_("Montant"), " th='sorted'  rcColone='Montant' c='Montant'  "). $this->cCmoreColsHeader;
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
                $array_search_tb = array();
                
        if(in_array('IdTaxe',$array_search_tb)){$this->arrayIdTaxeOptions = $this->selectBoxSaleTaxe_IdTaxe(@$dataObj, @$data);}
                
                
                 
                $trSearch = '';
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('SaleTaxe', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."SaleTaxe/edit/", "id='addSaleTaxe' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addSaleTaxeAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Taxe");
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
        if(!empty($_SESSION['memoire']['onglet']['SaleTaxe']['pg'])){
            $page = $_SESSION['memoire']['onglet']['SaleTaxe']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'SaleTaxeAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'SaleTaxeAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
            $search_child_default['Name']='asc';
        if(empty($this->searchOrder)){$this->searchOrder = $search_child_default;}
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#SaleTaxeListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#SaleTaxeListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('SaleTaxe', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('SaleTaxe', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('SaleTaxe', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteSaleTaxe' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
                                    $Taxe_Name ="";
                                    if($data->getTaxe()){
                                        $Taxe_Name = $data->getTaxe()->getName();
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['IdTaxe']) and $altValue['IdTaxe'])?$altValue['IdTaxe']:$Taxe_Name." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Taxe").":\" j='editSaleTaxe'  i='".json_encode($data->getPrimaryKey())."' c='IdTaxe'  ")
                            .td(span(strip_tags((isset($altValue['Name']) and $altValue['Name'])?$altValue['Name']:$data->getName()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Name Taxe").":\" j='editSaleTaxe'  i='".json_encode($data->getPrimaryKey())."' c='Name'  ")
                            .td(span(strip_tags((isset($altValue['Pourcent']) and $altValue['Pourcent'])?$altValue['Pourcent']:str_replace(',','.',$data->getPourcent())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("%").":\" j='editSaleTaxe'  i='".json_encode($data->getPrimaryKey())."' c='Pourcent'  ")
                            .td(span(strip_tags((isset($altValue['Montant']) and $altValue['Montant'])?$altValue['Montant']:str_replace(',','.',$data->getMontant())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Montant").":\" j='editSaleTaxe'  i='".json_encode($data->getPrimaryKey())."' c='Montant'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='SaleTaxeRow".$data->getPrimaryKey()."'
                    data-table='SaleTaxe' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountSaleTaxe', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Taxe';

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
                            ,'','id="SaleTaxePagination"')
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
                .div($controlsContent.$this->CcCustomControl,'SaleTaxeControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='SaleTaxeTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'SaleTaxeListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#SaleTaxeListForm [j='deleteSaleTaxe']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Taxe'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msSaleTaxeBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msSaleTaxeBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#SaleTaxeListForm tr[ecf=1] td[j='editSaleTaxe']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."SaleTaxe/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."SaleTaxe/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'SaleTaxe'
                ,'IdSaleTaxe'
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
        $(\"#SaleTaxeListForm [j='deleteSaleTaxe']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Taxe'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msSaleTaxeBt\').length>0){ $(\'#msSaleTaxeBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'SaleTaxeTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntSaleTaxeListForm #addSaleTaxe').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'SaleTaxeTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#SaleTaxeListForm tr[ecf=1] td[j='editSaleTaxe']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'SaleTaxeTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'SaleTaxe'
                ,'IdSaleTaxe'
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
        pagination_bind('SaleTaxe','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(\"#SaleTaxeListForm [j='deleteSaleTaxe']\").unbind('click');
        $('#SaleTaxeListForm #addSaleTaxe').unbind('click');
        $(\"#SaleTaxeListForm tr[ecf=1] td[j='editSaleTaxe']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#SaleTaxeListForm [j='button']\").unbind();   
        pagination_sorted_bind('SaleTaxe','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('SaleTaxe','".addslashes($variableAutoc)."');
        
        
        
        
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_SaleTaxe($data){

        unset($data['IdSaleTaxe']);
        $e = new SaleTaxe();
        
        
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setIdTaxe(($data['IdTaxe']=='')?null:$data['IdTaxe']);
        $e->setName(($data['Name']=='')?null:$data['Name']);
        $e->setPourcent(($data['Pourcent']=='')?null:$data['Pourcent']);
        $e->setMontant(($data['Montant']=='')?null:$data['Montant']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_SaleTaxe($data){

        
        $e = SaleTaxeQuery::create()->findPk(json_decode($data['i']));
        
        
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['IdTaxe'])){$e->setIdTaxe(($data['IdTaxe']=='')?null:$data['IdTaxe']);}
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of SaleTaxe
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
        $je= "SaleTaxeTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['SaleTaxe']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['SaleTaxe']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addSaleTaxe_child').bind('click.addSaleTaxe', function (){
                    $.post('"._SITE_URL."mod/act/SaleTaxeAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addSaleTaxe_child').bind('click.addSaleTaxe', function (){
                document.location= '"._SITE_URL."SaleTaxe/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = SaleTaxeQuery::create()->leftJoin('Taxe');
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'SaleTaxe', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'SaleTaxe','w',$dataObj)) 
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
                    $('#formSaleTaxe #saveSaleTaxe').removeAttr('disabled');
                    $('#formSaleTaxe #saveSaleTaxe').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formSaleTaxe #saveSaleTaxe').css('cursor', 'default');
                    if($('#formSaleTaxe #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formSaleTaxe #saveSaleTaxe').bind('click.saveSaleTaxe', function (data){
                    $('#formSaleTaxe #saveSaleTaxe').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formSaleTaxe #saveSaleTaxe').css('cursor', 'progress');
                    $('#formSaleTaxe #saveSaleTaxe').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formSaleTaxe .tinymce').each(function(index) {
                        eval(' $(\"#formSaleTaxe #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formSaleTaxe select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formSaleTaxe\").find(\"[s='d']\").serializeArray();
                        $('#formSaleTaxe select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formSaleTaxe\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/SaleTaxeAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formSaleTaxe #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formSaleTaxe #formChangedSaleTaxe').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formSaleTaxe #saveSaleTaxe').unbind('click.saveSaleTaxe');
                $('#formSaleTaxe #saveSaleTaxe').remove();";
        }
        
        if($dataObj == null){
            $this->SaleTaxe['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new SaleTaxe();
            $this->SaleTaxe['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
            if($data['ip']){
                $strPkParent = "setIdAbonnement";
                $dataObj->$strPkParent($data['ip']);
            }
        }

        ($dataObj->getTaxe())?'':$dataObj->setTaxe( new Taxe() );

        
        $this->arrayIdTaxeOptions = $this->selectBoxSaleTaxe_IdTaxe(@$dataObj, @$data);
        
        
        
        
        
        

            $this->fields['SaleTaxe']['IdTaxe']['html'] = stdFieldRow(htmlLink(_('Taxe'),'javascript:','  label_lien="IdTaxe"  class="label_link js-label-link" '), selectboxCustomArray('IdTaxe', $this->arrayIdTaxeOptions, _(_('Taxe')), "v='ID_TAXE'  s='d' otherTabs=1  val='".$dataObj->getIdTaxe()."'", $dataObj->getIdTaxe()), 'IdTaxe', "", @$this->commentsIdTaxe, @$this->commentsIdTaxe_css, '', ' ','no','');

            $this->fields['SaleTaxe']['Name']['html'] = stdFieldRow(_("Name Taxe"), input('text', 'Name',str_replace('"','&quot;',$dataObj->getName()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Name Taxe'))."' size='35'  v='NAME' s='d' class=''")."", 'Name', "", @$this->commentsName, @$this->commentsName_css, '', ' ','no','');

            $this->fields['SaleTaxe']['Pourcent']['html'] = stdFieldRow(_("%"), input('text', 'Pourcent',$dataObj->getPourcent(), "  placeholder='".str_replace("'","&#39;",_('%'))."'  v='POURCENT' otherTabs=1 size='5'    s='d' class='' otherTabs=1 "), 'Pourcent', "", @$this->commentsPourcent, @$this->commentsPourcent_css, '', ' ','no','');

            $this->fields['SaleTaxe']['Montant']['html'] = stdFieldRow(_("Montant"), input('text', 'Montant',$dataObj->getMontant(), "  placeholder='".str_replace("'","&#39;",_('Montant'))."'  v='MONTANT' otherTabs=1 size='5'    s='d' class='' otherTabs=1 "), 'Montant', "", @$this->commentsMontant, @$this->commentsMontant_css, '', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->SaleTaxe['request']['ChildHide']) ){
            
        }
        
        
        if($dataObj->getIdSaleTaxe()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'SaleTaxeControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = '';
            }

        }
        
        
        $linkParent="Renouvellement";
        $titre_form_str = '';
        if($dataObj->getIdSaleTaxe()){
                   $titre_form_str .= span(strip_tags(_($dataObj->getName()))," data-name='Name' ");
                   $this->siteTitle =set_var($this->siteTitle,strip_tags(_($dataObj->getName())),' ',false,NULL,false,true);}
        $this->formTitle = p(href($linkParent,_SITE_URL."Abonnement/edit/".$dataObj->getIdAbonnement()).htmlSpace(1).href("Taxe",_SITE_URL.'SaleTaxe').$titre_form_str, 'class="breadcrumb"'); 
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addSaleTaxe_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveSaleTaxe',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedSaleTaxe','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdSaleTaxe', $dataObj->getIdSaleTaxe(), " otherTabs=1 s='d' pk").input('hidden', 'IdAbonnement', $dataObj->getIdAbonnement(), " otherTabs=1 s='d' nodesc").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'SaleTaxeControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formSaleTaxe');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['SaleTaxe']['tog']) and 
            $_SESSION['memoire']['onglet']['SaleTaxe']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['SaleTaxe']['Start']['html']
                
                .
$this->fields['SaleTaxe']['IdTaxe']['html']
.$this->fields['SaleTaxe']['Name']['html']
.$this->fields['SaleTaxe']['Pourcent']['html']
.$this->fields['SaleTaxe']['Montant']['html']
                
                .@$this->fields['SaleTaxe']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntSaleTaxe", "class='divStdform' CntTabs=1 ")
        , "id='formSaleTaxe' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Taxe"); }
        # if not new, show child table
        if($dataObj->getIdSaleTaxe()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelSaleTaxe', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntSaleTaxeChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['SaleTaxe']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['SaleTaxe']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['SaleTaxe']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    
    ".$jqueryDatePicker."
    bind_ui_active('SaleTaxe');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    $(\"[label_lien='IdTaxe']\").bind('click', function (){
        if($('#IdTaxe').val()){ window.open('"._SITE_URL."Taxe/edit/'+$('#IdTaxe').val());}else{window.open('"._SITE_URL."Taxe/list/');}
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
     setTimeout(function(){ bind_othertabs_std('#divCntSaleTaxe');},500); 
    ".$toggleForm."
    bind_form('SaleTaxe','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
        ($dataObj->getTaxe())?'':$dataObj->setTaxe( new Taxe() );
            
        $this->fieldsRo['SaleTaxe']['IdTaxe']['html'] = stdFieldRow(htmlLink(_('Taxe'),'javascript:','  label_lien="IdTaxe"  class="label_link js-label-link" '), 
                    input('text','IdTaxeLabel',$dataObj->getTaxe()->getName(),"  readonly s='d'")
                    .input('hidden','IdTaxe',$dataObj->getIdTaxe()," readonly s='d'"), 'IdTaxe', "", @$this->commentsIdTaxe, @$this->commentsIdTaxe_css, 'readonly', ' ','no','');
$this->fieldsRo['SaleTaxe']['Name']['html'] = stdFieldRow(_("Name Taxe"), input('text','Name',$dataObj->getName()," readonly s='d'"), 'Name', "", @$this->commentsName, @$this->commentsName_css, 'readonly', ' ','no','');
$this->fieldsRo['SaleTaxe']['Pourcent']['html'] = stdFieldRow(_("%"), input('text','Pourcent',$dataObj->getPourcent()," readonly s='d'"), 'Pourcent', "", @$this->commentsPourcent, @$this->commentsPourcent_css, 'readonly', ' ','no','');
$this->fieldsRo['SaleTaxe']['Montant']['html'] = stdFieldRow(_("Montant"), input('text','Montant',$dataObj->getMontant()," readonly s='d'"), 'Montant', "", @$this->commentsMontant, @$this->commentsMontant_css, 'readonly', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['SaleTaxe'] as $field=>$ar){
                $this->fields['SaleTaxe'][$field]['html'] = $this->fieldsRo['SaleTaxe'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['SaleTaxe'][$field]['html'] = $this->fieldsRo['SaleTaxe'][$field]['html'];
            }
        }
    }
    /*Option function for SaleTaxe_IdTaxe selectBox */
    public function selectBoxSaleTaxe_IdTaxe($dataObj='',$data='', $emptyVal=false,$array=true){
$q = TaxeQuery::create();

    $q->addAsColumn('selDisplay', 'CONCAT_WS ( " ",taxe.name,"" )');
    $q->select(array('selDisplay', 'IdTaxe'));
    $q->orderBy('Name', 'ASC');
if(!$array){return $q;}else{$pcDataO = $q->find();}


$arrayOpt = $pcDataO->toArray();
return assocToNum($arrayOpt , true);
}
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = SaleTaxeQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdSaleTaxe'));
            
            $pcData = $q->filterByIdAbonnement($IdParent);
        
        }else{
            $q->select(array('Name', 'IdSaleTaxe'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = SaleTaxeQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdSaleTaxe'));
            
            $pcData = $q->filterByIdAbonnement($IdParent);
        
        }else{
            $q->select(array('Name', 'IdSaleTaxe'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Taxe')), $selected);
        }


        return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'SaleTaxeAct.php';
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
