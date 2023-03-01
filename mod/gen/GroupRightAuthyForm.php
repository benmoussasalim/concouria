<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'GroupRightAuthy' table.
 *
 */
class GroupRightAuthyForm extends GroupRightAuthy{
public $tableName="GroupRightAuthy";
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
        $q = GroupRightAuthyQuery::create();
        if($this->CcToSearchList){ getSelectFilter($this->CcToSearchList,$q);}
        if(is_array($this->searchAr)){
            array_walk_recursive ($this->searchAr, function (&$v){$v=trim($v);});
            ## query sub-Menu
            if(@$this->searchAr['v'] && !$this->searchAr['uv']){
                $filterStr = "filterBy".$this->searchAr['f'];
                $q 
->joinWith('GroupRight')
                    ->$filterStr($this->searchAr['v']);
                    
                    
            }elseif(@$this->searchAr['u'] && $this->searchAr['uv']){
                $useStr = "use".$this->searchAr['u']."Query";
                $filterStr = "filterBy".$this->searchAr['f'];
                $q->$useStr()->$filterStr($this->searchAr['uv'])->endUse()
                     
->joinWith('GroupRight');
            }else{
                $q 
->joinWith('GroupRight');
            }
        }else{
            if(is_array($this->searchMs )){
                array_walk_recursive($this->searchMs, function (&$v){$v=trim($v);});
                $q 
->joinWith('GroupRight');
            }else{
                
            if(json_decode($IdParent)){
                $pmpoData = GroupRightAuthyQuery::create()->filterByIdAuthy(json_decode($IdParent))
                     
->joinWith('GroupRight')
                    
                    ->paginate($page, $maxPerPage);
            }
                $hasParent = json_decode($IdParent);
                if(empty($hasParent)){
                    $q 
->joinWith('GroupRight');
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
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Groupe"), " th='sorted'  rcColone='IdGroupRight' c='GroupRight.Name' rc='GroupRight.Name' ").th(_("Membre"), " th='sorted'  rcColone='IsSet' c='IsSet'  ").th(_("Primaire"), " th='sorted'  rcColone='Primary' c='Primary'  "). $this->cCmoreColsHeader;
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
                
        if(in_array('IdGroupRight',$array_search_tb)){$this->arrayIdGroupRightOptions = $this->selectBoxGroupRightAuthy_IdGroupRight(@$dataObj, @$data);}
                
                
                 
                $trSearch = '';
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('GroupRightAuthy', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."GroupRightAuthy/edit/", "id='addGroupRightAuthy' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addGroupRightAuthyAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Group");
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
        if(!empty($_SESSION['memoire']['onglet']['GroupRightAuthy']['pg'])){
            $page = $_SESSION['memoire']['onglet']['GroupRightAuthy']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'GroupRightAuthyAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'GroupRightAuthyAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#GroupRightAuthyListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#GroupRightAuthyListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('GroupRightAuthy', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('GroupRightAuthy', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('GroupRightAuthy', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteGroupRightAuthy' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
        $altValue['GroupRight_Name'] = "";
        if($data->getGroupRight()){
            $altValue['GroupRight_Name'] = $data->getGroupRight()->getName();
        }
                
                
                
                 $titreRaccour =''; $titreRaccour .= _('Group');
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['IdGroupRight']) and $altValue['IdGroupRight'])?$altValue['IdGroupRight']:$altValue['GroupRight_Name']." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Groupe").":\" j='editGroupRightAuthy'  i='".json_encode($data->getPrimaryKey())."' c='IdGroupRight'  ")
                            .td(span(strip_tags((isset($altValue['IsSet']) and $altValue['IsSet'])?$altValue['IsSet']:isntPo($data->getIsSet())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Membre").":\" j='editGroupRightAuthy'  i='".json_encode($data->getPrimaryKey())."' c='IsSet'  ")
                            .td(span(strip_tags((isset($altValue['Primary']) and $altValue['Primary'])?$altValue['Primary']:isntPo($data->getPrimary())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Primaire").":\" j='editGroupRightAuthy'  i='".json_encode($data->getPrimaryKey())."' c='Primary'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='GroupRightAuthyRow".$data->getPrimaryKey()."'
                    data-table='GroupRightAuthy' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountGroupRightAuthy', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Group';

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
                            ,'','id="GroupRightAuthyPagination"')
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
                .div($controlsContent.$this->CcCustomControl,'GroupRightAuthyControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='GroupRightAuthyTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'GroupRightAuthyListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#GroupRightAuthyListForm [j='deleteGroupRightAuthy']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Group'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msGroupRightAuthyBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msGroupRightAuthyBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#GroupRightAuthyListForm tr[ecf=1] td[j='editGroupRightAuthy']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."GroupRightAuthy/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."GroupRightAuthy/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'GroupRightAuthy'
                ,'IdAuthy'
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
        $(\"#GroupRightAuthyListForm [j='deleteGroupRightAuthy']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Group'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msGroupRightAuthyBt\').length>0){ $(\'#msGroupRightAuthyBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'GroupRightAuthyTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntGroupRightAuthyListForm #addGroupRightAuthy').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'GroupRightAuthyTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#GroupRightAuthyListForm tr[ecf=1] td[j='editGroupRightAuthy']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'GroupRightAuthyTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'GroupRightAuthy'
                ,'IdAuthy'
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
        pagination_bind('GroupRightAuthy','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(\"#GroupRightAuthyListForm [j='deleteGroupRightAuthy']\").unbind('click');
        $('#GroupRightAuthyListForm #addGroupRightAuthy').unbind('click');
        $(\"#GroupRightAuthyListForm tr[ecf=1] td[j='editGroupRightAuthy']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#GroupRightAuthyListForm [j='button']\").unbind();   
        pagination_sorted_bind('GroupRightAuthy','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('GroupRightAuthy','".addslashes($variableAutoc)."');
        
        
        
        
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_GroupRightAuthy($data){

        $data['IdAuthy'] = $request['ip'];
        $e = new GroupRightAuthy();
        
        
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        if(!@$data['IsSet']){$data['IsSet'] = "Non Membre";} 
        if($data['Primary'] == ''){unset($data['Primary']);}
        $e->fromArray($data );
        
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?date('Y-m-d'):$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?date('Y-m-d'):$data['DateModification'] );
        $e->setPrimary(($data['Primary']=='')?null:$data['Primary']);
        return $e;
    }
    public function save_update_GroupRightAuthy($data){

        
        $e = GroupRightAuthyQuery::create()->findPk(json_decode($data['i']));
        
        
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        if(!@$data['IsSet']){$data['IsSet'] = "Non Membre";} 
        if($data['Primary'] == ''){unset($data['Primary']);}
        $e->fromArray($data );
        
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        if(isset($data['Primary'])){$e->setPrimary(($data['Primary']=='')?null:$data['Primary']);}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of GroupRightAuthy
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
        $je= "GroupRightAuthyTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['GroupRightAuthy']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['GroupRightAuthy']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addGroupRightAuthy_child').bind('click.addGroupRightAuthy', function (){
                    $.post('"._SITE_URL."mod/act/GroupRightAuthyAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addGroupRightAuthy_child').bind('click.addGroupRightAuthy', function (){
                document.location= '"._SITE_URL."GroupRightAuthy/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = GroupRightAuthyQuery::create()->joinWith('GroupRight');
            
            
            $dataObj = $q->filterByPrimaryKey(json_decode($id))->findOne();
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'GroupRightAuthy', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'GroupRightAuthy','w',$dataObj)) 
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
                    $('#formGroupRightAuthy #saveGroupRightAuthy').removeAttr('disabled');
                    $('#formGroupRightAuthy #saveGroupRightAuthy').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formGroupRightAuthy #saveGroupRightAuthy').css('cursor', 'default');
                    if($('#formGroupRightAuthy #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formGroupRightAuthy #saveGroupRightAuthy').bind('click.saveGroupRightAuthy', function (data){
                    $('#formGroupRightAuthy #saveGroupRightAuthy').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formGroupRightAuthy #saveGroupRightAuthy').css('cursor', 'progress');
                    $('#formGroupRightAuthy #saveGroupRightAuthy').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formGroupRightAuthy .tinymce').each(function(index) {
                        eval(' $(\"#formGroupRightAuthy #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formGroupRightAuthy select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formGroupRightAuthy\").find(\"[s='d']\").serializeArray();
                        $('#formGroupRightAuthy select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formGroupRightAuthy\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/GroupRightAuthyAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formGroupRightAuthy #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formGroupRightAuthy #formChangedGroupRightAuthy').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formGroupRightAuthy #saveGroupRightAuthy').unbind('click.saveGroupRightAuthy');
                $('#formGroupRightAuthy #saveGroupRightAuthy').remove();";
        }
        
        if($dataObj == null){
            $this->GroupRightAuthy['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new GroupRightAuthy();
            $this->GroupRightAuthy['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
            if($data['ip']){
                $strPkParent = "setIdAuthy";
                $dataObj->$strPkParent($data['ip']);
            }
        }

        ($dataObj->getGroupRight())?'':$dataObj->setGroupRight( new GroupRight() );

        
        $this->arrayIdGroupRightOptions = $this->selectBoxGroupRightAuthy_IdGroupRight(@$dataObj, @$data);
        
        
        
        
        
        

            $this->fields['GroupRightAuthy']['IdGroupRight']['html'] = stdFieldRow(htmlLink(_('Groupe'),'javascript:','  label_lien="IdGroupRight"  class="label_link js-label-link" '), selectboxCustomArray('IdGroupRight', $this->arrayIdGroupRightOptions, _(""), "v='ID_GROUP_RIGHT'  s='d' otherTabs=1  val='".$dataObj->getIdGroupRight()."'", $dataObj->getIdGroupRight()), 'IdGroupRight', "", @$this->commentsIdGroupRight, @$this->commentsIdGroupRight_css, '', '  style=\'display:none; \'','no','');

            $this->fields['GroupRightAuthy']['IsSet']['html'] = stdFieldRow(_("Membre"), selectboxCustomArray('IsSet', array( '0' => array('0'=>_("Non Membre"), '1'=>'Non Membre'),'1' => array('0'=>_("Membre"), '1'=>'Membre'), ), "", "s='d' otherTabs=1  ", $dataObj->getIsSet()), 'IsSet', "", @$this->commentsIsSet, @$this->commentsIsSet_css, '', ' ','no','');

            $this->fields['GroupRightAuthy']['Primary']['html'] = stdFieldRow(_("Primaire"), selectboxCustomArray('Primary', array( '0' => array('0'=>_("Non"), '1'=>'Non'),'1' => array('0'=>_("Oui"), '1'=>'Oui'), ), _('Primaire'), "s='d' otherTabs=1  ", $dataObj->getPrimary()), 'Primary', "", @$this->commentsPrimary, @$this->commentsPrimary_css, '', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->GroupRightAuthy['request']['ChildHide']) ){
            
        }
        
        
        if($dataObj->getIdAuthy()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'GroupRightAuthyControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = '';
            }

        }
        
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addGroupRightAuthy_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveGroupRightAuthy',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedGroupRightAuthy','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdAuthy', $dataObj->getIdAuthy(), " otherTabs=1 s='d' nodesc")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'GroupRightAuthyControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formGroupRightAuthy');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['GroupRightAuthy']['tog']) and 
            $_SESSION['memoire']['onglet']['GroupRightAuthy']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['GroupRightAuthy']['Start']['html']
                
                .
$this->fields['GroupRightAuthy']['IdGroupRight']['html']
.$this->fields['GroupRightAuthy']['IsSet']['html']
.$this->fields['GroupRightAuthy']['Primary']['html']
                
                .@$this->fields['GroupRightAuthy']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntGroupRightAuthy", "class='divStdform' CntTabs=1 ")
        , "id='formGroupRightAuthy' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Group"); }
        # if not new, show child table
        if($dataObj->getIdAuthy()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelGroupRightAuthy', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntGroupRightAuthyChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['GroupRightAuthy']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['GroupRightAuthy']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['GroupRightAuthy']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    
    ".$jqueryDatePicker."
    bind_ui_active('GroupRightAuthy');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    $(\"[label_lien='IdGroupRight']\").bind('click', function (){
        if($('#IdGroupRight').val()){ window.open('"._SITE_URL."GroupRight/edit/'+$('#IdGroupRight').val());}else{window.open('"._SITE_URL."GroupRight/list/');}
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
     setTimeout(function(){ bind_othertabs_std('#divCntGroupRightAuthy');},500); 
    ".$toggleForm."
    bind_form('GroupRightAuthy','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
        ($dataObj->getGroupRight())?'':$dataObj->setGroupRight( new GroupRight() );
            
        $this->fieldsRo['GroupRightAuthy']['IdGroupRight']['html'] = stdFieldRow(htmlLink(_('Groupe'),'javascript:','  label_lien="IdGroupRight"  class="label_link js-label-link" '), 
                    input('text','IdGroupRightLabel',$dataObj->getGroupRight()->getName(),"  readonly s='d'")
                    .input('hidden','IdGroupRight',$dataObj->getIdGroupRight()," readonly s='d'"), 'IdGroupRight', "", @$this->commentsIdGroupRight, @$this->commentsIdGroupRight_css, 'readonly', '  style=\'display:none; \'','no','');
$this->fieldsRo['GroupRightAuthy']['IsSet']['html'] = stdFieldRow(_("Membre"), input('text','IsSet',$dataObj->getIsSet()," readonly s='d'"), 'IsSet', "", @$this->commentsIsSet, @$this->commentsIsSet_css, 'readonly', ' ','no','');
$this->fieldsRo['GroupRightAuthy']['Primary']['html'] = stdFieldRow(_("Primaire"), input('text','Primary',$dataObj->getPrimary()," readonly s='d'"), 'Primary', "", @$this->commentsPrimary, @$this->commentsPrimary_css, 'readonly', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['GroupRightAuthy'] as $field=>$ar){
                $this->fields['GroupRightAuthy'][$field]['html'] = $this->fieldsRo['GroupRightAuthy'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['GroupRightAuthy'][$field]['html'] = $this->fieldsRo['GroupRightAuthy'][$field]['html'];
            }
        }
    }
    /*Option function for GroupRightAuthy_IdGroupRight selectBox */
    public function selectBoxGroupRightAuthy_IdGroupRight($dataObj='',$data='', $emptyVal=false,$array=true){
$q = GroupRightQuery::create();

    $q->addAsColumn('selDisplay', 'CONCAT_WS ( " ", group_right.name, "" )');
    $q->select(array('selDisplay', 'IdGroupRight'));
    $q->orderBy('selDisplay', 'ASC');
if(!$array){return $q;}else{$pcDataO = $q->find();}


$arrayOpt = $pcDataO->toArray();
return assocToNum($arrayOpt , true);
}
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = GroupRightAuthyQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdAuthy'));
            
            $pcData = $q->filterByIdAuthy($IdParent);
        
        }else{
            $q->select(array('Name', 'IdAuthy'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = GroupRightAuthyQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdAuthy'));
            
            $pcData = $q->filterByIdAuthy($IdParent);
        
        }else{
            $q->select(array('Name', 'IdAuthy'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Group')), $selected);
        }


        return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'GroupRightAuthyAct.php';
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
