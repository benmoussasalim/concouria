<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'GroupRight' table.
 *
 */
class GroupRightForm extends GroupRight{
public $tableName="GroupRight";
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
        $q = GroupRightQuery::create();
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
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Nom"), " th='sorted'  rcColone='Name' c='Name'  ").th(_("Description"), " th='sorted'  rcColone='Desc' c='Desc'  ").th(_("Droits admin"), " th='sorted'  rcColone='RightsAdmin' c='RightsAdmin'  ").th(_("Droits propriétaire"), " th='sorted'  rcColone='RightsOwner' c='RightsOwner'  ").th(_("Droits groupe"), " th='sorted'  rcColone='RightsGroup' c='RightsGroup'  "). $this->cCmoreColsHeader;
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
                
                
                
                 
                $trSearch = '';
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('GroupRight', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."GroupRight/edit/", "id='addGroupRight' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addGroupRightAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Groupe");
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
        if(!empty($_SESSION['memoire']['onglet']['GroupRight']['pg'])){
            $page = $_SESSION['memoire']['onglet']['GroupRight']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'GroupRightAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'GroupRightAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#GroupRightListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#GroupRightListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('GroupRight', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('GroupRight', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('GroupRight', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteGroupRight' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['Name']) and $altValue['Name'])?$altValue['Name']:$data->getName()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Nom").":\" j='editGroupRight'  i='".json_encode($data->getPrimaryKey())."' c='Name'  ")
                            .td(span(strip_tags((isset($altValue['Desc']) and $altValue['Desc'])?$altValue['Desc']:$data->getDesc()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Description").":\" j='editGroupRight'  i='".json_encode($data->getPrimaryKey())."' c='Desc'  ")
                            .td(span(strip_tags((isset($altValue['RightsAdmin']) and $altValue['RightsAdmin'])?$altValue['RightsAdmin']:$data->getRightsAdmin()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Droits admin").":\" j='editGroupRight'  i='".json_encode($data->getPrimaryKey())."' c='RightsAdmin'  ")
                            .td(span(strip_tags((isset($altValue['RightsOwner']) and $altValue['RightsOwner'])?$altValue['RightsOwner']:$data->getRightsOwner()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Droits propriétaire").":\" j='editGroupRight'  i='".json_encode($data->getPrimaryKey())."' c='RightsOwner'  ")
                            .td(span(strip_tags((isset($altValue['RightsGroup']) and $altValue['RightsGroup'])?$altValue['RightsGroup']:$data->getRightsGroup()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Droits groupe").":\" j='editGroupRight'  i='".json_encode($data->getPrimaryKey())."' c='RightsGroup'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='GroupRightRow".$data->getPrimaryKey()."'
                    data-table='GroupRight' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountGroupRight', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Groupe';

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
                            ,'','id="GroupRightPagination"')
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
                .div($controlsContent.$this->CcCustomControl,'GroupRightControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='GroupRightTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'GroupRightListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#GroupRightListForm [j='deleteGroupRight']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Groupe'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msGroupRightBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msGroupRightBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#GroupRightListForm tr[ecf=1] td[j='editGroupRight']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."GroupRight/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."GroupRight/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'GroupRight'
                ,'IdGroupRight'
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
        $(\"#GroupRightListForm [j='deleteGroupRight']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Groupe'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msGroupRightBt\').length>0){ $(\'#msGroupRightBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'GroupRightTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntGroupRightListForm #addGroupRight').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'GroupRightTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#GroupRightListForm tr[ecf=1] td[j='editGroupRight']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'GroupRightTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'GroupRight'
                ,'IdGroupRight'
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
        pagination_bind('GroupRight','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(\"#GroupRightListForm [j='deleteGroupRight']\").unbind('click');
        $('#GroupRightListForm #addGroupRight').unbind('click');
        $(\"#GroupRightListForm tr[ecf=1] td[j='editGroupRight']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#GroupRightListForm [j='button']\").unbind();   
        pagination_sorted_bind('GroupRight','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('GroupRight','".addslashes($variableAutoc)."');
        
        
        
        
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_GroupRight($data){

        unset($data['IdGroupRight']);
        $e = new GroupRight();
        
                    if(@$data['noRights'] != 'y'){
                       
                    $data['RightsAdmin'] = serializeRights($data, 'RightsAdmin');
                    $data['RightsOwner'] = serializeRights($data, 'RightsOwner');
                    $data['RightsGroup'] = serializeRights($data, 'RightsGroup');
                    }
        
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        return $e;
    }
    public function save_update_GroupRight($data){

        
        $e = GroupRightQuery::create()->findPk(json_decode($data['i']));
        
                    if(@$data['noRights'] != 'y'){
                       
                    $data['RightsAdmin'] = serializeRights($data, 'RightsAdmin');
                    $data['RightsOwner'] = serializeRights($data, 'RightsOwner');
                    $data['RightsGroup'] = serializeRights($data, 'RightsGroup');
                    }
        
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of GroupRight
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
        $je= "GroupRightTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['GroupRight']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['GroupRight']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addGroupRight_child').bind('click.addGroupRight', function (){
                    $.post('"._SITE_URL."mod/act/GroupRightAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addGroupRight_child').bind('click.addGroupRight', function (){
                document.location= '"._SITE_URL."GroupRight/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = GroupRightQuery::create();
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'GroupRight', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'GroupRight','w',$dataObj)) 
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
                    $('#formGroupRight #saveGroupRight').removeAttr('disabled');
                    $('#formGroupRight #saveGroupRight').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formGroupRight #saveGroupRight').css('cursor', 'default');
                    if($('#formGroupRight #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formGroupRight #saveGroupRight').bind('click.saveGroupRight', function (data){
                    $('#formGroupRight #saveGroupRight').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formGroupRight #saveGroupRight').css('cursor', 'progress');
                    $('#formGroupRight #saveGroupRight').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formGroupRight .tinymce').each(function(index) {
                        eval(' $(\"#formGroupRight #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formGroupRight select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formGroupRight\").find(\"[s='d']\").serializeArray();
                        $('#formGroupRight select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formGroupRight\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/GroupRightAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formGroupRight #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formGroupRight #formChangedGroupRight').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formGroupRight #saveGroupRight').unbind('click.saveGroupRight');
                $('#formGroupRight #saveGroupRight').remove();";
        }
        
        if($dataObj == null){
            $this->GroupRight['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new GroupRight();
            $this->GroupRight['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }


        
        
        
        
        ## Rights for RightsAdmin
        $this->primary = 'Oui';
        $userRightsAr = json_decode($dataObj->getRightsAdmin(), true);
        if(!isset($this->omMap)){require _BASE_DIR."inc/AddOmMap.php";$this->omMap = $omMap;}
        unset($trRights);
        foreach($this->omMap as $c=>$key) { $index[] = $key['index'];	}
        array_multisort($index, SORT_ASC, $this->omMap,SORT_NUMERIC);
        $omMapSubMenu= $this->omMap;
        $omMapChild = array_combine(array_column($this->omMap, 'name_table'), $this->omMap);
        if($this->omMap){
            foreach($this->omMap as $oMentry){
                if($oMentry['index'] and empty($oMentry['cright'])){
                    $omMapChild[$oMentry['name_table']]['F']=1;
                    $td=$this->show_rights($oMentry,'RightsAdmin',@$userRightsAr[@$oMentry['name']]);
                    @$trRights .=
                        tr(
                            td(
                                htmlLink($this->desc_right(@$SpaceAdd._($oMentry['desc'])), 'Javascript:', 'class="bld-rights-modules-link"')
                            , "j='chkRightsAdmin' i='".$oMentry['name']."'").$td
                         ," child='".slugify(trim(@$currentParent))."' class='".@$hide."' ");
                    unset($td);
                    foreach($omMapSubMenu as $key => $row){ $name[$key]=$row['parent_menu'];$sub_menu[$key]=$row['sub_menu']; }
                    array_multisort($name,SORT_ASC,$sub_menu,SORT_ASC,$omMapSubMenu);
                    foreach($omMapSubMenu as $oSubMenu){
                        if($oSubMenu['parent_menu'] == $oMentry['name'] || (camelize($oSubMenu['parent_table'],true) == $oMentry['name'])){
                            $omMapChild[$oSubMenu['name_table']]['F']=1;
                            $td=$this->show_rights($oSubMenu,'RightsAdmin',@$userRightsAr[@$oSubMenu['name']]);
                            $trRights .=
                                tr(
                                    td(
                                        htmlLink($this->desc_right(htmlSpace(10)._($oSubMenu['desc']),$oMentry['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                    , "j='chkRightsAdmin' i='".$oSubMenu['name']."'").$td
                                 ,"   ");
                            if($oSubMenu['add_select_popup']){
                                $ArrAddSelect= json_decode($oSubMenu['add_select_popup'], true);
                                if(count($ArrAddSelect)){
                                    foreach($ArrAddSelect as $key => $select){
                                        if($key){
                                            unset($info);$write="";
                                            $info['name']=camelize($oSubMenu['name'],true)."SelectBox".camelize(_($key),true);
                                            if(in_array("add",$select)){$write.='a';}
                                            if(in_array("edit",$select)){$write.='w';}
                                            if(in_array("supp",$select)){$write.='d';}
                                            $trRights .=
                                                tr(
                                                    td(
                                                        htmlLink($this->desc_right(htmlSpace(30)._('Selection').htmlSpace(1)._($select['desc']),$oMentry['desc'].$oSubMenu['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                                    , "j='chkRightsAdmin' i='".$info['name']."'")
                                                        .$this->show_rights($info,'RightsAdmin',$userRightsAr[$info['name']],null,$write)
                                                 ,"  ");
                                        }
                                    }
                                }
                            }
                            unset($td);
                            if(is_array(json_decode($oSubMenu['child_table']))){
                            foreach(json_decode($oSubMenu['child_table']) as $child){
                                if($omMapChild[$child]){
                                    $childMenu = $omMapChild[$child];
                                    $omMapChild[$child]['F']=1;
                                    if( $childMenu['parent_table']
                                        /*and camelize($childMenu['parent_table'],true) == $oSubMenu['name']*/){
                                        /*$nameRight = camelize($childMenu['parent_table'],true).$childMenu['name'];*/
                                        $childMenu['parent_table'] = $oSubMenu['name'];
                                        $nameRight = camelize($childMenu['parent_table'],true).$childMenu['name'];
                                        $td=$this->show_rights($childMenu,'RightsAdmin',$userRightsAr[$nameRight],true);
                                        $trRights .=
                                            tr(
                                                td(
                                                    htmlLink($this->desc_right(htmlSpace(20)._($childMenu['desc']),$oMentry['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                                , "j='chkRightsAdmin' i='".$nameRight."'").$td
                                             ,"   ");
                                        if($childMenu['add_select_popup']){
                                            $ArrAddSelect= json_decode($childMenu['add_select_popup'], true);
                                            if(count($ArrAddSelect)){
                                                foreach($ArrAddSelect as $key => $select){
                                                    if($key){
                                                        unset($info);$write="";
                                                        $info['name']=camelize($childMenu['parent_table'],true).camelize($childMenu['name'],true)."SelectBox".camelize(_($key),true);
                                                        if(in_array("add",$select)){$write.='a';}
                                                        if(in_array("edit",$select)){$write.='w';}
                                                        if(in_array("supp",$select)){$write.='d';}
                                                        $trRights .=
                                                            tr(
                                                                td(
                                                                    htmlLink($this->desc_right(htmlSpace(30)._('Selection').htmlSpace(1)._($select['desc']),$oMentry['desc'].$childMenu['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                                                , "j='chkRightsAdmin' i='".$info['name']."'")
                                                                    .$this->show_rights($info,'RightsAdmin',$userRightsAr[$info['name']],null,$write)
                                                             ,"  ");
                                                    }
                                                }
                                            }
                                        }
                                        unset($td);
                                    }
                                }
                            }
                            }
                        }
                    }
                }else if(@$oMentry['cright']){
                    $omMapChild[$oMentry['name_table']]['F']=1;
                    $trRightsCustom .=
                        tr(
                            td(
                                htmlLink($this->desc_right(message_label($oMentry['desc'])), 'Javascript:', 'class="bld-rights-modules-link"')
                            , "j='chkRightsAdmin' i='".$oMentry['name']."'")
                            .$this->show_rights($oMentry,'RightsAdmin',$userRightsAr[$oMentry['name']],null,$oMentry['rights'])
                        );
                }
            }
            unset($td);
            foreach($omMapChild as $Child){
                if(@$Child['F']!=1 and str_replace('I18n','',$Child['name']) ==$Child['name'] ){
                    if($Child['name'] and $Child['desc']){
                        if(!@$td){
                            $trRights .=
                                tr(
                                   td(htmlLink(_("Entité non visible"), 'Javascript:'," class='title-right' ")
                                    ," j='parent_chkRightsAdmin' parent='NonVisible' class='bld-parent-rights-modules-link' colspan=100%")
                                );
                        }
                        $td=$this->show_rights(@$Child,'RightsAdmin',@$userRightsAr[@$Child['name']]);
                        $trRights .=
                            tr(
                                td(
                                    htmlLink($this->desc_right(_($Child['desc'])), 'Javascript:', 'class="bld-rights-modules-link"')
                                , "j='chkRightsAdmin' i='".$Child['name']."'").$td
                             ," child='NonVisible' child='NonVisible' class='' ");
                    }
                }
            }
            if(@$trRightsCustom){
                $trRightsCustom
                    =
                    tr(
                        td(htmlLink(_("Droit Custom"), 'Javascript:'," class='title-right' ")
                        ," j='parent_chkRights' parent='NonVisible' class='bld-parent-rights-modules-link' colspan=100%")
                    ).$trRightsCustom;
            }
        }
        $menu = '';$menu = th(_('Menu'), "style='width:50px;' class='actionrow'");
        $rightInputRightsAdmin =
            input('checkbox','mass-action-RightsAdmin','')
            .label(_('Décocher/Cocher'),'for="mass-action-RightsAdmin"')
            .table(
                thead(
                    tr(
                        th(_('Module'), "style='' class='actionrow' ")
                        .$menu
                        .th(_('Lecture'), "style='width:50px;' class='actionrow'")
                        .th(_('Ajout'), "style='width:50px;' class='actionrow'")
                        .th(_('Modif.'), "style='width:50px;' class='actionrow'")
                        .th(_('Sup.'), "style='width:50px;' class='actionrow'")
                        .th(_('BkUp.'), "style='width:50px;' class='actionrow'")
                    )
                )
                .$trRights
                .@$trRightsCustom
            , "class='rights-table tablesorter'");

        
        ## Rights for RightsOwner
        $this->primary = 'Oui';
        $userRightsAr = json_decode($dataObj->getRightsOwner(), true);
        if(!isset($this->omMap)){require _BASE_DIR."inc/AddOmMap.php";$this->omMap = $omMap;}
        unset($trRights);
        foreach($this->omMap as $c=>$key) { $index[] = $key['index'];	}
        array_multisort($index, SORT_ASC, $this->omMap,SORT_NUMERIC);
        $omMapSubMenu= $this->omMap;
        $omMapChild = array_combine(array_column($this->omMap, 'name_table'), $this->omMap);
        if($this->omMap){
            foreach($this->omMap as $oMentry){
                if($oMentry['index'] and empty($oMentry['cright'])){
                    $omMapChild[$oMentry['name_table']]['F']=1;
                    $td=$this->show_rights($oMentry,'RightsOwner',@$userRightsAr[@$oMentry['name']]);
                    @$trRights .=
                        tr(
                            td(
                                htmlLink($this->desc_right(@$SpaceAdd._($oMentry['desc'])), 'Javascript:', 'class="bld-rights-modules-link"')
                            , "j='chkRightsOwner' i='".$oMentry['name']."'").$td
                         ," child='".slugify(trim(@$currentParent))."' class='".@$hide."' ");
                    unset($td);
                    foreach($omMapSubMenu as $key => $row){ $name[$key]=$row['parent_menu'];$sub_menu[$key]=$row['sub_menu']; }
                    array_multisort($name,SORT_ASC,$sub_menu,SORT_ASC,$omMapSubMenu);
                    foreach($omMapSubMenu as $oSubMenu){
                        if($oSubMenu['parent_menu'] == $oMentry['name'] || (camelize($oSubMenu['parent_table'],true) == $oMentry['name'])){
                            $omMapChild[$oSubMenu['name_table']]['F']=1;
                            $td=$this->show_rights($oSubMenu,'RightsOwner',@$userRightsAr[@$oSubMenu['name']]);
                            $trRights .=
                                tr(
                                    td(
                                        htmlLink($this->desc_right(htmlSpace(10)._($oSubMenu['desc']),$oMentry['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                    , "j='chkRightsOwner' i='".$oSubMenu['name']."'").$td
                                 ,"   ");
                            if($oSubMenu['add_select_popup']){
                                $ArrAddSelect= json_decode($oSubMenu['add_select_popup'], true);
                                if(count($ArrAddSelect)){
                                    foreach($ArrAddSelect as $key => $select){
                                        if($key){
                                            unset($info);$write="";
                                            $info['name']=camelize($oSubMenu['name'],true)."SelectBox".camelize(_($key),true);
                                            if(in_array("add",$select)){$write.='a';}
                                            if(in_array("edit",$select)){$write.='w';}
                                            if(in_array("supp",$select)){$write.='d';}
                                            $trRights .=
                                                tr(
                                                    td(
                                                        htmlLink($this->desc_right(htmlSpace(30)._('Selection').htmlSpace(1)._($select['desc']),$oMentry['desc'].$oSubMenu['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                                    , "j='chkRightsOwner' i='".$info['name']."'")
                                                        .$this->show_rights($info,'RightsOwner',$userRightsAr[$info['name']],null,$write)
                                                 ,"  ");
                                        }
                                    }
                                }
                            }
                            unset($td);
                            if(is_array(json_decode($oSubMenu['child_table']))){
                            foreach(json_decode($oSubMenu['child_table']) as $child){
                                if($omMapChild[$child]){
                                    $childMenu = $omMapChild[$child];
                                    $omMapChild[$child]['F']=1;
                                    if( $childMenu['parent_table']
                                        /*and camelize($childMenu['parent_table'],true) == $oSubMenu['name']*/){
                                        /*$nameRight = camelize($childMenu['parent_table'],true).$childMenu['name'];*/
                                        $childMenu['parent_table'] = $oSubMenu['name'];
                                        $nameRight = camelize($childMenu['parent_table'],true).$childMenu['name'];
                                        $td=$this->show_rights($childMenu,'RightsOwner',$userRightsAr[$nameRight],true);
                                        $trRights .=
                                            tr(
                                                td(
                                                    htmlLink($this->desc_right(htmlSpace(20)._($childMenu['desc']),$oMentry['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                                , "j='chkRightsOwner' i='".$nameRight."'").$td
                                             ,"   ");
                                        if($childMenu['add_select_popup']){
                                            $ArrAddSelect= json_decode($childMenu['add_select_popup'], true);
                                            if(count($ArrAddSelect)){
                                                foreach($ArrAddSelect as $key => $select){
                                                    if($key){
                                                        unset($info);$write="";
                                                        $info['name']=camelize($childMenu['parent_table'],true).camelize($childMenu['name'],true)."SelectBox".camelize(_($key),true);
                                                        if(in_array("add",$select)){$write.='a';}
                                                        if(in_array("edit",$select)){$write.='w';}
                                                        if(in_array("supp",$select)){$write.='d';}
                                                        $trRights .=
                                                            tr(
                                                                td(
                                                                    htmlLink($this->desc_right(htmlSpace(30)._('Selection').htmlSpace(1)._($select['desc']),$oMentry['desc'].$childMenu['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                                                , "j='chkRightsOwner' i='".$info['name']."'")
                                                                    .$this->show_rights($info,'RightsOwner',$userRightsAr[$info['name']],null,$write)
                                                             ,"  ");
                                                    }
                                                }
                                            }
                                        }
                                        unset($td);
                                    }
                                }
                            }
                            }
                        }
                    }
                }else if(@$oMentry['cright']){
                    $omMapChild[$oMentry['name_table']]['F']=1;
                    $trRightsCustom .=
                        tr(
                            td(
                                htmlLink($this->desc_right(message_label($oMentry['desc'])), 'Javascript:', 'class="bld-rights-modules-link"')
                            , "j='chkRightsOwner' i='".$oMentry['name']."'")
                            .$this->show_rights($oMentry,'RightsOwner',$userRightsAr[$oMentry['name']],null,$oMentry['rights'])
                        );
                }
            }
            unset($td);
            foreach($omMapChild as $Child){
                if(@$Child['F']!=1 and str_replace('I18n','',$Child['name']) ==$Child['name'] ){
                    if($Child['name'] and $Child['desc']){
                        if(!@$td){
                            $trRights .=
                                tr(
                                   td(htmlLink(_("Entité non visible"), 'Javascript:'," class='title-right' ")
                                    ," j='parent_chkRightsOwner' parent='NonVisible' class='bld-parent-rights-modules-link' colspan=100%")
                                );
                        }
                        $td=$this->show_rights(@$Child,'RightsOwner',@$userRightsAr[@$Child['name']]);
                        $trRights .=
                            tr(
                                td(
                                    htmlLink($this->desc_right(_($Child['desc'])), 'Javascript:', 'class="bld-rights-modules-link"')
                                , "j='chkRightsOwner' i='".$Child['name']."'").$td
                             ," child='NonVisible' child='NonVisible' class='' ");
                    }
                }
            }
            if(@$trRightsCustom){
                $trRightsCustom
                    =
                    tr(
                        td(htmlLink(_("Droit Custom"), 'Javascript:'," class='title-right' ")
                        ," j='parent_chkRights' parent='NonVisible' class='bld-parent-rights-modules-link' colspan=100%")
                    ).$trRightsCustom;
            }
        }
        $menu = '';$menu = th(_('Menu'), "style='width:50px;' class='actionrow'");
        $rightInputRightsOwner =
            input('checkbox','mass-action-RightsOwner','')
            .label(_('Décocher/Cocher'),'for="mass-action-RightsOwner"')
            .table(
                thead(
                    tr(
                        th(_('Module'), "style='' class='actionrow' ")
                        .$menu
                        .th(_('Lecture'), "style='width:50px;' class='actionrow'")
                        .th(_('Ajout'), "style='width:50px;' class='actionrow'")
                        .th(_('Modif.'), "style='width:50px;' class='actionrow'")
                        .th(_('Sup.'), "style='width:50px;' class='actionrow'")
                        .th(_('BkUp.'), "style='width:50px;' class='actionrow'")
                    )
                )
                .$trRights
                .@$trRightsCustom
            , "class='rights-table tablesorter'");

        
        ## Rights for RightsGroup
        $this->primary = 'Oui';
        $userRightsAr = json_decode($dataObj->getRightsGroup(), true);
        if(!isset($this->omMap)){require _BASE_DIR."inc/AddOmMap.php";$this->omMap = $omMap;}
        unset($trRights);
        foreach($this->omMap as $c=>$key) { $index[] = $key['index'];	}
        array_multisort($index, SORT_ASC, $this->omMap,SORT_NUMERIC);
        $omMapSubMenu= $this->omMap;
        $omMapChild = array_combine(array_column($this->omMap, 'name_table'), $this->omMap);
        if($this->omMap){
            foreach($this->omMap as $oMentry){
                if($oMentry['index'] and empty($oMentry['cright'])){
                    $omMapChild[$oMentry['name_table']]['F']=1;
                    $td=$this->show_rights($oMentry,'RightsGroup',@$userRightsAr[@$oMentry['name']]);
                    @$trRights .=
                        tr(
                            td(
                                htmlLink($this->desc_right(@$SpaceAdd._($oMentry['desc'])), 'Javascript:', 'class="bld-rights-modules-link"')
                            , "j='chkRightsGroup' i='".$oMentry['name']."'").$td
                         ," child='".slugify(trim(@$currentParent))."' class='".@$hide."' ");
                    unset($td);
                    foreach($omMapSubMenu as $key => $row){ $name[$key]=$row['parent_menu'];$sub_menu[$key]=$row['sub_menu']; }
                    array_multisort($name,SORT_ASC,$sub_menu,SORT_ASC,$omMapSubMenu);
                    foreach($omMapSubMenu as $oSubMenu){
                        if($oSubMenu['parent_menu'] == $oMentry['name'] || (camelize($oSubMenu['parent_table'],true) == $oMentry['name'])){
                            $omMapChild[$oSubMenu['name_table']]['F']=1;
                            $td=$this->show_rights($oSubMenu,'RightsGroup',@$userRightsAr[@$oSubMenu['name']]);
                            $trRights .=
                                tr(
                                    td(
                                        htmlLink($this->desc_right(htmlSpace(10)._($oSubMenu['desc']),$oMentry['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                    , "j='chkRightsGroup' i='".$oSubMenu['name']."'").$td
                                 ,"   ");
                            if($oSubMenu['add_select_popup']){
                                $ArrAddSelect= json_decode($oSubMenu['add_select_popup'], true);
                                if(count($ArrAddSelect)){
                                    foreach($ArrAddSelect as $key => $select){
                                        if($key){
                                            unset($info);$write="";
                                            $info['name']=camelize($oSubMenu['name'],true)."SelectBox".camelize(_($key),true);
                                            if(in_array("add",$select)){$write.='a';}
                                            if(in_array("edit",$select)){$write.='w';}
                                            if(in_array("supp",$select)){$write.='d';}
                                            $trRights .=
                                                tr(
                                                    td(
                                                        htmlLink($this->desc_right(htmlSpace(30)._('Selection').htmlSpace(1)._($select['desc']),$oMentry['desc'].$oSubMenu['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                                    , "j='chkRightsGroup' i='".$info['name']."'")
                                                        .$this->show_rights($info,'RightsGroup',$userRightsAr[$info['name']],null,$write)
                                                 ,"  ");
                                        }
                                    }
                                }
                            }
                            unset($td);
                            if(is_array(json_decode($oSubMenu['child_table']))){
                            foreach(json_decode($oSubMenu['child_table']) as $child){
                                if($omMapChild[$child]){
                                    $childMenu = $omMapChild[$child];
                                    $omMapChild[$child]['F']=1;
                                    if( $childMenu['parent_table']
                                        /*and camelize($childMenu['parent_table'],true) == $oSubMenu['name']*/){
                                        /*$nameRight = camelize($childMenu['parent_table'],true).$childMenu['name'];*/
                                        $childMenu['parent_table'] = $oSubMenu['name'];
                                        $nameRight = camelize($childMenu['parent_table'],true).$childMenu['name'];
                                        $td=$this->show_rights($childMenu,'RightsGroup',$userRightsAr[$nameRight],true);
                                        $trRights .=
                                            tr(
                                                td(
                                                    htmlLink($this->desc_right(htmlSpace(20)._($childMenu['desc']),$oMentry['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                                , "j='chkRightsGroup' i='".$nameRight."'").$td
                                             ,"   ");
                                        if($childMenu['add_select_popup']){
                                            $ArrAddSelect= json_decode($childMenu['add_select_popup'], true);
                                            if(count($ArrAddSelect)){
                                                foreach($ArrAddSelect as $key => $select){
                                                    if($key){
                                                        unset($info);$write="";
                                                        $info['name']=camelize($childMenu['parent_table'],true).camelize($childMenu['name'],true)."SelectBox".camelize(_($key),true);
                                                        if(in_array("add",$select)){$write.='a';}
                                                        if(in_array("edit",$select)){$write.='w';}
                                                        if(in_array("supp",$select)){$write.='d';}
                                                        $trRights .=
                                                            tr(
                                                                td(
                                                                    htmlLink($this->desc_right(htmlSpace(30)._('Selection').htmlSpace(1)._($select['desc']),$oMentry['desc'].$childMenu['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                                                , "j='chkRightsGroup' i='".$info['name']."'")
                                                                    .$this->show_rights($info,'RightsGroup',$userRightsAr[$info['name']],null,$write)
                                                             ,"  ");
                                                    }
                                                }
                                            }
                                        }
                                        unset($td);
                                    }
                                }
                            }
                            }
                        }
                    }
                }else if(@$oMentry['cright']){
                    $omMapChild[$oMentry['name_table']]['F']=1;
                    $trRightsCustom .=
                        tr(
                            td(
                                htmlLink($this->desc_right(message_label($oMentry['desc'])), 'Javascript:', 'class="bld-rights-modules-link"')
                            , "j='chkRightsGroup' i='".$oMentry['name']."'")
                            .$this->show_rights($oMentry,'RightsGroup',$userRightsAr[$oMentry['name']],null,$oMentry['rights'])
                        );
                }
            }
            unset($td);
            foreach($omMapChild as $Child){
                if(@$Child['F']!=1 and str_replace('I18n','',$Child['name']) ==$Child['name'] ){
                    if($Child['name'] and $Child['desc']){
                        if(!@$td){
                            $trRights .=
                                tr(
                                   td(htmlLink(_("Entité non visible"), 'Javascript:'," class='title-right' ")
                                    ," j='parent_chkRightsGroup' parent='NonVisible' class='bld-parent-rights-modules-link' colspan=100%")
                                );
                        }
                        $td=$this->show_rights(@$Child,'RightsGroup',@$userRightsAr[@$Child['name']]);
                        $trRights .=
                            tr(
                                td(
                                    htmlLink($this->desc_right(_($Child['desc'])), 'Javascript:', 'class="bld-rights-modules-link"')
                                , "j='chkRightsGroup' i='".$Child['name']."'").$td
                             ," child='NonVisible' child='NonVisible' class='' ");
                    }
                }
            }
            if(@$trRightsCustom){
                $trRightsCustom
                    =
                    tr(
                        td(htmlLink(_("Droit Custom"), 'Javascript:'," class='title-right' ")
                        ," j='parent_chkRights' parent='NonVisible' class='bld-parent-rights-modules-link' colspan=100%")
                    ).$trRightsCustom;
            }
        }
        $menu = '';$menu = th(_('Menu'), "style='width:50px;' class='actionrow'");
        $rightInputRightsGroup =
            input('checkbox','mass-action-RightsGroup','')
            .label(_('Décocher/Cocher'),'for="mass-action-RightsGroup"')
            .table(
                thead(
                    tr(
                        th(_('Module'), "style='' class='actionrow' ")
                        .$menu
                        .th(_('Lecture'), "style='width:50px;' class='actionrow'")
                        .th(_('Ajout'), "style='width:50px;' class='actionrow'")
                        .th(_('Modif.'), "style='width:50px;' class='actionrow'")
                        .th(_('Sup.'), "style='width:50px;' class='actionrow'")
                        .th(_('BkUp.'), "style='width:50px;' class='actionrow'")
                    )
                )
                .$trRights
                .@$trRightsCustom
            , "class='rights-table tablesorter'");

        
        
        
        

            $this->fields['GroupRight']['Name']['html'] = stdFieldRow(_("Nom"), input('text', 'Name',str_replace('"','&quot;',$dataObj->getName()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Nom'))."' size='35'  v='NAME' s='d' class='req'")."", 'Name', "", @$this->commentsName, @$this->commentsName_css, '', ' ','no','');

            $this->fields['GroupRight']['Desc']['html'] = stdFieldRow(_("Description"), input('text', 'Desc',str_replace('"','&quot;',$dataObj->getDesc()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Description'))."' size='35'  v='DESC' s='d' class=''")."", 'Desc', "", @$this->commentsDesc, @$this->commentsDesc_css, '', ' ','no','');

            $this->fields['GroupRight']['RightsAdmin']['html'] = stdFieldRow(_("Droits admin"), $rightInputRightsAdmin, 'RightsAdmin', "", @$this->commentsRightsAdmin, @$this->commentsRightsAdmin_css, '', ' ','no','');

            $this->fields['GroupRight']['RightsOwner']['html'] = stdFieldRow(_("Droits propriétaire"), $rightInputRightsOwner, 'RightsOwner', "", @$this->commentsRightsOwner, @$this->commentsRightsOwner_css, '', ' ','no','');

            $this->fields['GroupRight']['RightsGroup']['html'] = stdFieldRow(_("Droits groupe"), $rightInputRightsGroup, 'RightsGroup', "", @$this->commentsRightsGroup, @$this->commentsRightsGroup_css, '', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->GroupRight['request']['ChildHide']) ){
            
        }
        
        
        if($dataObj->getIdGroupRight()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'GroupRightControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = '';
            }

        }
        
        
        $titre_form_str = '';
        if($dataObj->getIdGroupRight()){
                   $titre_form_str .= span(strip_tags(_($dataObj->getName()))," data-name='Name' ");
                   $this->siteTitle =set_var($this->siteTitle,strip_tags(_($dataObj->getName())),' ',false,NULL,false,true);}
        $this->formTitle = p(href("Groupe",_SITE_URL.'GroupRight').$titre_form_str, 'class="breadcrumb"'); 
        $ongletf =
            div(
                ul(li(htmlLink(_('Groupe'),'#ogf_GroupRight',' j="ogf" p="GroupRight" class="ui-tabs-anchor button-link-blue" ')).li(htmlLink(_('Droits admin'),'#ogf_rights_admin',' j="ogf" class="ui-tabs-anchor button-link-blue" p="GroupRight" ')).li(htmlLink(_('Droits propriétaire'),'#ogf_rights_owner',' j="ogf" class="ui-tabs-anchor button-link-blue" p="GroupRight" ')).li(htmlLink(_('Droits groupe'),'#ogf_rights_group',' j="ogf" class="ui-tabs-anchor button-link-blue" p="GroupRight" ')))
            ,'cntOngletGroupRight',' class="cntOnglet"')
            .@$close_form
        ;
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addGroupRight_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveGroupRight',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedGroupRight','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdGroupRight', $dataObj->getIdGroupRight(), " otherTabs=1 s='d' pk").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'GroupRightControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formGroupRight');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['GroupRight']['tog']) and 
            $_SESSION['memoire']['onglet']['GroupRight']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['GroupRight']['Start']['html']
                
                .
                    '<div id="ogf_GroupRight">'.
$this->fields['GroupRight']['Name']['html']
.$this->fields['GroupRight']['Desc']['html']
.'</div><div id="ogf_rights_admin"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['GroupRight']['RightsAdmin']['html']
.'</div><div id="ogf_rights_owner"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['GroupRight']['RightsOwner']['html']
.'</div><div id="ogf_rights_group"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['GroupRight']['RightsGroup']['html'].'</div>'
                
                .@$this->fields['GroupRight']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntGroupRight", "class='divStdform' CntTabs=1 ")
        , "id='formGroupRight' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Groupe"); }
        # if not new, show child table
        if($dataObj->getIdGroupRight()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelGroupRight', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntGroupRightChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['GroupRight']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['GroupRight']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['GroupRight']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    
    ".$jqueryDatePicker."
    bind_ui_active('GroupRight');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    $('[j=appliquer-group]').bind('click', function(){
        if($('#GroupAuthy').val()){
            $.post('"._SITE_URL."mod/act/GroupRightAct.php', {a:'app_write', i:$('#GroupAuthy').val()}, function(data){
                if(data){
                    $.each(data, function(i, item) {
                        if(item.indexOf('m') != '-1'){
                            $('[name=Rights-'+i+'m]').prop('checked',true);
                        }
                        if(item.indexOf('r') != '-1'){
                            $('[name=Rights-'+i+'r]').prop('checked',true);
                        }
                        if(item.indexOf('w') != '-1'){
                            $('[name=Rights-'+i+'w]').prop('checked',true);
                        }
                        if(item.indexOf('a') != '-1'){
                            $('[name=Rights-'+i+'a]').prop('checked',true);
                        }
                        if(item.indexOf('d') != '-1'){
                            $('[name=Rights-'+i+'d]').prop('checked',true);
                        }
                        if(item.indexOf('b') != '-1'){
                            $('[name=Rights-'+i+'b]').prop('checked',true);
                        }
                    });
                }
            },'json');
        }
        return false;
    });
    $('#mass-action-RightsAdmin').bind('click', function(){
        if( $(this).prop('checked')){
            $(\"[j='rcRightsAdmin']\").prop('checked',true);
        }else{
            $(\"[j='rcRightsAdmin']\").prop('checked',false);
        }
        $('#formRightsAdmin #saveRightsAdmin').addClass('can-save');
    });
    $(\".bld-parent-rights-modules-link\").click(function(){
        $(\"[child=\"+$(this).attr('parent')+\"]\").toggle();
        /*if($(\"[parent=\"+$(this).attr('parent')+\"] input\").prop('checked')){
            $(\"[parent=\"+$(this).attr('parent')+\"] input\").prop('checked',false);
        }else{
            $(\"[parent=\"+$(this).attr('parent')+\"] input\").prop('checked',true);
        }*/
    });

    $(\"[j='chkRightsAdmin']\").click(function(){
        if($(\"[ent='RightsAdmin\"+$(this).attr('i')+\"']\").prop('checked')){
            $(\"[ent='RightsAdmin\"+$(this).attr('i')+\"']\").prop('checked',false);
        }else{
            $(\"[ent='RightsAdmin\"+$(this).attr('i')+\"']\").prop('checked',true);
        }
    });
    if($('#formAuthy #Group').val() == 'Admin'){ $('#formAuthy #genRightsCtnr').hide(); }else{ $('#formAuthy #genRightsCtnr').show(); }
    $('#formAuthy #Group').change(function (){
        if($('#formAuthy #Group').val() == 'Admin'){ $('#formAuthy #genRightsCtnr').hide(); }else{ $('#formAuthy #genRightsCtnr').show(); }
    });

    
    $('[j=appliquer-group]').bind('click', function(){
        if($('#GroupAuthy').val()){
            $.post('"._SITE_URL."mod/act/GroupRightAct.php', {a:'app_write', i:$('#GroupAuthy').val()}, function(data){
                if(data){
                    $.each(data, function(i, item) {
                        if(item.indexOf('m') != '-1'){
                            $('[name=Rights-'+i+'m]').prop('checked',true);
                        }
                        if(item.indexOf('r') != '-1'){
                            $('[name=Rights-'+i+'r]').prop('checked',true);
                        }
                        if(item.indexOf('w') != '-1'){
                            $('[name=Rights-'+i+'w]').prop('checked',true);
                        }
                        if(item.indexOf('a') != '-1'){
                            $('[name=Rights-'+i+'a]').prop('checked',true);
                        }
                        if(item.indexOf('d') != '-1'){
                            $('[name=Rights-'+i+'d]').prop('checked',true);
                        }
                        if(item.indexOf('b') != '-1'){
                            $('[name=Rights-'+i+'b]').prop('checked',true);
                        }
                    });
                }
            },'json');
        }
        return false;
    });
    $('#mass-action-RightsOwner').bind('click', function(){
        if( $(this).prop('checked')){
            $(\"[j='rcRightsOwner']\").prop('checked',true);
        }else{
            $(\"[j='rcRightsOwner']\").prop('checked',false);
        }
        $('#formRightsOwner #saveRightsOwner').addClass('can-save');
    });
    $(\".bld-parent-rights-modules-link\").click(function(){
        $(\"[child=\"+$(this).attr('parent')+\"]\").toggle();
        /*if($(\"[parent=\"+$(this).attr('parent')+\"] input\").prop('checked')){
            $(\"[parent=\"+$(this).attr('parent')+\"] input\").prop('checked',false);
        }else{
            $(\"[parent=\"+$(this).attr('parent')+\"] input\").prop('checked',true);
        }*/
    });

    $(\"[j='chkRightsOwner']\").click(function(){
        if($(\"[ent='RightsOwner\"+$(this).attr('i')+\"']\").prop('checked')){
            $(\"[ent='RightsOwner\"+$(this).attr('i')+\"']\").prop('checked',false);
        }else{
            $(\"[ent='RightsOwner\"+$(this).attr('i')+\"']\").prop('checked',true);
        }
    });
    if($('#formAuthy #Group').val() == 'Admin'){ $('#formAuthy #genRightsCtnr').hide(); }else{ $('#formAuthy #genRightsCtnr').show(); }
    $('#formAuthy #Group').change(function (){
        if($('#formAuthy #Group').val() == 'Admin'){ $('#formAuthy #genRightsCtnr').hide(); }else{ $('#formAuthy #genRightsCtnr').show(); }
    });

    
    $('[j=appliquer-group]').bind('click', function(){
        if($('#GroupAuthy').val()){
            $.post('"._SITE_URL."mod/act/GroupRightAct.php', {a:'app_write', i:$('#GroupAuthy').val()}, function(data){
                if(data){
                    $.each(data, function(i, item) {
                        if(item.indexOf('m') != '-1'){
                            $('[name=Rights-'+i+'m]').prop('checked',true);
                        }
                        if(item.indexOf('r') != '-1'){
                            $('[name=Rights-'+i+'r]').prop('checked',true);
                        }
                        if(item.indexOf('w') != '-1'){
                            $('[name=Rights-'+i+'w]').prop('checked',true);
                        }
                        if(item.indexOf('a') != '-1'){
                            $('[name=Rights-'+i+'a]').prop('checked',true);
                        }
                        if(item.indexOf('d') != '-1'){
                            $('[name=Rights-'+i+'d]').prop('checked',true);
                        }
                        if(item.indexOf('b') != '-1'){
                            $('[name=Rights-'+i+'b]').prop('checked',true);
                        }
                    });
                }
            },'json');
        }
        return false;
    });
    $('#mass-action-RightsGroup').bind('click', function(){
        if( $(this).prop('checked')){
            $(\"[j='rcRightsGroup']\").prop('checked',true);
        }else{
            $(\"[j='rcRightsGroup']\").prop('checked',false);
        }
        $('#formRightsGroup #saveRightsGroup').addClass('can-save');
    });
    $(\".bld-parent-rights-modules-link\").click(function(){
        $(\"[child=\"+$(this).attr('parent')+\"]\").toggle();
        /*if($(\"[parent=\"+$(this).attr('parent')+\"] input\").prop('checked')){
            $(\"[parent=\"+$(this).attr('parent')+\"] input\").prop('checked',false);
        }else{
            $(\"[parent=\"+$(this).attr('parent')+\"] input\").prop('checked',true);
        }*/
    });

    $(\"[j='chkRightsGroup']\").click(function(){
        if($(\"[ent='RightsGroup\"+$(this).attr('i')+\"']\").prop('checked')){
            $(\"[ent='RightsGroup\"+$(this).attr('i')+\"']\").prop('checked',false);
        }else{
            $(\"[ent='RightsGroup\"+$(this).attr('i')+\"']\").prop('checked',true);
        }
    });
    if($('#formAuthy #Group').val() == 'Admin'){ $('#formAuthy #genRightsCtnr').hide(); }else{ $('#formAuthy #genRightsCtnr').show(); }
    $('#formAuthy #Group').change(function (){
        if($('#formAuthy #Group').val() == 'Admin'){ $('#formAuthy #genRightsCtnr').hide(); }else{ $('#formAuthy #genRightsCtnr').show(); }
    });

    $('#cntOngletGroupRight').parent().tabs();$('#cntOngletGroupRight').show();
    ".@$childTable['onReadyJs']."
    ".@$error['onReadyJs']."
    ".@$removeEditChild."
    /*try {afterFormLoad();}catch(e){}*/
    if($('#loader').css('display') == 'block') $('#loader').hide();
    $('[j=sftr]').hide();
    ".@$tabs_act."
    ".$this->CcToFormJs
    .@$script_autoc_one."
     setTimeout(function(){ bind_othertabs_std('#divCntGroupRight');},500); 
    ".$toggleForm."
    bind_form('GroupRight','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
            
        $this->fieldsRo['GroupRight']['Name']['html'] = stdFieldRow(_("Nom"), input('text','Name',$dataObj->getName()," readonly s='d'"), 'Name', "", @$this->commentsName, @$this->commentsName_css, 'readonly', ' ','no','');
$this->fieldsRo['GroupRight']['Desc']['html'] = stdFieldRow(_("Description"), input('text','Desc',$dataObj->getDesc()," readonly s='d'"), 'Desc', "", @$this->commentsDesc, @$this->commentsDesc_css, 'readonly', ' ','no','');
$this->fieldsRo['GroupRight']['RightsAdmin']['html'] = stdFieldRow(_("Droits admin"), input('text','RightsAdmin',$dataObj->getRightsAdmin()," readonly s='d'"), 'RightsAdmin', "", @$this->commentsRightsAdmin, @$this->commentsRightsAdmin_css, 'readonly', ' ','no','');
$this->fieldsRo['GroupRight']['RightsOwner']['html'] = stdFieldRow(_("Droits propriétaire"), input('text','RightsOwner',$dataObj->getRightsOwner()," readonly s='d'"), 'RightsOwner', "", @$this->commentsRightsOwner, @$this->commentsRightsOwner_css, 'readonly', ' ','no','');
$this->fieldsRo['GroupRight']['RightsGroup']['html'] = stdFieldRow(_("Droits groupe"), input('text','RightsGroup',$dataObj->getRightsGroup()," readonly s='d'"), 'RightsGroup', "", @$this->commentsRightsGroup, @$this->commentsRightsGroup_css, 'readonly', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['GroupRight'] as $field=>$ar){
                $this->fields['GroupRight'][$field]['html'] = $this->fieldsRo['GroupRight'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['GroupRight'][$field]['html'] = $this->fieldsRo['GroupRight'][$field]['html'];
            }
        }
    }
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = GroupRightQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdGroupRight'));
            
        
        }else{
            $q->select(array('Name', 'IdGroupRight'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = GroupRightQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdGroupRight'));
            
        
        }else{
            $q->select(array('Name', 'IdGroupRight'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Groupe')), $selected);
        }


        return $return;
    }  
        
    
    private function desc_right($name,$parent=''){
        $str = 'RG_'.str_replace(' ','_',trim(str_replace(htmlSpace(1),'',$name)));
        if($parent){$str .= '_'.str_replace(' ','_',trim(str_replace(htmlSpace(1),'',$parent)));}
        $str = strtolower($str);
        if(message_label($str) !=$str || (defined('_DROIT_SHOW_MESSAGE') && _DROIT_SHOW_MESSAGE ==1) ){
            $name = $name.div(message_label($str),'','style="margin-top:10px;color:black;font-size:12px;"');
        }return $name;
    }
    private function show_rights($oMentry,$prefix,$right,$parent=false,$write="mrawdcg"){
        $name =$oMentry['name'];
        if(@$oMentry['bkup']==1){ $write=$write."b";}
        if($parent){ $name =camelize($oMentry['parent_table'],true)."".$oMentry['name'];}
        
            if(($oMentry['index'] or ($oMentry['sub_menu'] and !$parent) or @$oMentry['action']=="add") and !$parent and empty($oMentry['cright']) ){
                if(strstr($right,  'm')){
        @$td .= td(input('checkbox', $prefix."-".$name."m", 'm', "checked='checked' j='rc".$prefix."' s='d' ent='".$prefix.$name."'").label('',"for='".$prefix."-".$name."m'"));
                }else{
        @$td .= td(input('checkbox', $prefix."-".$name."m", 'm', "j='rc".$prefix."' s='d' ent='".$prefix.$name."'").label('',"for='".$prefix."-".$name."m'"));
                }
            }else{@$td .=td(htmlSpace(1),"");}
        
        if(@$oMentry['action']!="add"){
            if(strstr($write,'r')){
                if(strstr($right,  'r')){
        @$td .= td(input('checkbox', $prefix."-".$name."r", 'r', "checked='checked' j='rc".$prefix."' s='d' ent='".$prefix.$name."'").label('',"for='".$prefix."-".$name."r'"));
                }else{
        @$td .= td(input('checkbox', $prefix."-".$name."r", 'r', "j='rc".$prefix."' s='d' ent='".$prefix.$name."'").label('',"for='".$prefix."-".$name."r'"));
                }
            }else{@$td .= td(htmlSpace(1));}
            if(strstr($write,'a')){
                if(strstr($right,  'a')){
        @$td .= td(input('checkbox', $prefix."-".$name."a", 'a', "checked='checked' j='rc".$prefix."' s='d' ent='".$prefix.$name."'").label('',"for='".$prefix."-".$name."a'"));
                }else{
        @$td .= td(input('checkbox', $prefix."-".$name."a", 'a', "j='rc".$prefix."' s='d' ent='".$prefix.$name."'").label('',"for='".$prefix."-".$name."a'"));
                }
            }else{@$td .= td(htmlSpace(1));}
            if(strstr($write,'w')){
                if(strstr($right,  'w')){
        @$td .= td(input('checkbox', $prefix."-".$name."w", 'w', "checked='checked' j='rc".$prefix."' s='d' ent='".$prefix.$name."'").label('',"for='".$prefix."-".$name."w'"));
                }else{
        @$td .= td(input('checkbox', $prefix."-".$name."w", 'w', "j='rc".$prefix."' s='d' ent='".$prefix.$name."'").label('',"for='".$prefix."-".$name."w'"));
                }
            }else{@$td .= td(htmlSpace(1));}
            if(strstr($write,'d')){
                if(strstr($right,  'd')){
        @$td .= td(input('checkbox', $prefix."-".$name."d", 'd', "checked='checked' j='rc".$prefix."' s='d' ent='".$prefix.$name."'")
                    .label('',"for='".$prefix."-".$name."d'"));
                }else{
        @$td .= td(input('checkbox', $prefix."-".$name."d", 'd', "j='rc".$prefix."' s='d' ent='".$prefix.$name."'")
                     .label('',"for='".$prefix."-".$name."d'"));
                }
            }else{@$td .= td(htmlSpace(1));}

            if(strstr($write,'b')){
                if(strstr($right,  'b')){
        @$td .= td(input('checkbox', $prefix."-".$name."b", 'b', "checked='checked' j='rc".$prefix."' s='d' ent='".$prefix.$name."'")
                    .label('',"for='".$prefix."-".$name."b'"));
                }else{
        @$td .= td(input('checkbox', $prefix."-".$name."b", 'b', "j='rc".$prefix."' s='d' ent='".$prefix.$name."'")
                     .label('',"for='".$prefix."-".$name."b'"));
                }
            }else{@$td .= td(htmlSpace(1));}

        }else{
            @$td .=td(htmlSpace(1)).td(htmlSpace(1)).td(htmlSpace(1)).td(htmlSpace(1)).td(htmlSpace(1));
        }
        return $td;
    }
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'GroupRightAct.php';
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
