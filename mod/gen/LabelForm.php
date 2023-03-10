<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'Label' table.
 *
 */
class LabelForm extends Label{
public $tableName="Label";
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
        $q = LabelQuery::create();
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
                if(isset($this->searchMs['LabelText']) and $this->searchMs['LabelText'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['LabelText']) and strpos($this->searchMs['LabelText'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['LabelText'] != '%DoNothing%' AND $this->searchMs['LabelText'][0] != '%DoNothing%'){
                        $q->filterByLabelText("%".$this->searchMs['LabelText']."%", Criteria::LIKE);
                    }
                }
                if(isset($this->searchMs['Etat']) and $this->searchMs['Etat'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Etat']) and strpos($this->searchMs['Etat'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Etat'] != '%DoNothing%' AND $this->searchMs['Etat'][0] != '%DoNothing%'){
                        $q ->filterByEtat($this->searchMs['Etat'],$criteria);
                    }
                }
                if(isset($this->searchMs['Text']) and $this->searchMs['Text'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Text']) and strpos($this->searchMs['Text'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Text'] != '%DoNothing%' AND $this->searchMs['Text'][0] != '%DoNothing%'){
                        $q->filterByText("%".$this->searchMs['Text']."%", Criteria::LIKE);
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
        
         $q->groupBy('IdLabel');
        
        $this->pmpoData =  $q;
        //echo $q->toString();
        //$q->paginate($page, $maxPerPage);
        return $this->pmpoData;
    }
    public function getListHeader($act){
        switch($act){
            case 'head':
            ###### TH
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("ID"), " th='sorted'  rcColone='IdLabel' c='IdLabel'  ").th(_("Label"), " th='sorted'  rcColone='LabelText' c='LabelText'  ").th(_("Reference"), " th='sorted'  rcColone='Reference' c='Reference'  ").th(_("Statut"), " th='sorted'  rcColone='Etat' c='Etat'  ").th(_("Label fr_CA"), " th='sorted'  rcColone='Labeli18nTextFrca' c='LabelI18n.Text'  ").th(_("Label en_US"), " th='sorted'  rcColone='Labeli18nTextEnus' c='LabelI18n.Text'  "). $this->cCmoreColsHeader;
                if(empty($this->search['Autoc']['SelList']) and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                    $trHead .= th('&nbsp;',' class="actionrow delete" ');
                }
                $trHead = thead(tr($trHead));/*semble plus utilis??.$trHeadMod*/
                return $trHead;
            break;
            case 'list-button':
                $listButton = '';
                
                
                return $listButton;
            break;
            case 'search':
                ###### SEARCH
                $array_search_tb = array('LabelText','Etat','Text');
                
                unset($data);$data['LabelText'] = (!empty($this->searchMs['LabelText']))?$this->searchMs['LabelText']:'';
        $data['Etat'] = (!empty($this->searchMs['Etat']))?$this->searchMs['Etat']:'';
        $data['Text'] = (!empty($this->searchMs['Text']))?$this->searchMs['Text']:'';
        
                
        @$this->fieldsSearch['Label']['LabelText'] = div(input('text', 'LabelText', $this->searchMs['LabelText'], ' othertabs=1  placeholder="'._('Label').'"',''),'','class="ac-search-item ms-LabelText"');
        @$this->fieldsSearch['Label']['Etat'] =div(selectboxCustomArray('Etat', array( '0' => array('0'=>_("Actif"), '1'=>'Actif'),'1' => array('0'=>_("Nouveau"), '1'=>'Nouveau'),'2' => array('0'=>_("Inactif"), '1'=>'Inactif'), ), _('Etat'), '  size="1" t="1"   ', $this->searchMs['Etat']), '', '  class=" ac-search-item ms-Etat"');
        @$this->fieldsSearch['Label']['Text'] = div(input('text', 'Text', $this->searchMs['Text'], ' othertabs=1  placeholder="'._('Text').'"',''),'','class="ac-search-item ms-Text"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msLabelAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['Label']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msLabelBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msLabelBtClear" class="icon clear"')
               .@$this->fieldsSearch['Label']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['Label']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-LabelSearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['Label']['Start'].
                    $this->fieldsSearch['Label']['LabelText'].
                    $this->fieldsSearch['Label']['Etat'].
                    $this->fieldsSearch['Label']['Text'].
                @$this->fieldsSearch['Label']['End'].
            $this->fieldsSearch['Label']['Button']
            ,"id='formMsLabel' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('Label', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."Label/edit/", "id='addLabel' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addLabelAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
                }
            }else{
                $add_button = '';
            }

            $trAdd = @$this->head['AddButton']['Start'].$add_button.@$this->head['AddButton']['End'];
            return $trAdd;
            break;
            /*case 'quickadd': return $trHeadMod; break; semble plus utilis??*/
        }
    }
    
    public function getList( $uiTabsId= "tabsContain", $page='1', $IdParent='', $pmpoDataIn='', $search=''){
        if($page == ""){ $page = 1; }
        
        $this->siteTitle .=_("Liste Label");
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
        if(!empty($_SESSION['memoire']['onglet']['Label']['pg'])){
            $page = $_SESSION['memoire']['onglet']['Label']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'LabelAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'LabelAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
            $search_child_default['LabelText']='ASC';
        if(empty($this->searchOrder)){$this->searchOrder = $search_child_default;}
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#LabelListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#LabelListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
            } catch (Exception $e) { /* echo 'Exception re??ue : ',  $e->getMessage(), "<br>";*/ }
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('Label', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('Label', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('Label', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteLabel' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
try{$data->getTranslation('fr_CA');}catch (Exception $exep){$mt = new LabelI18n();$mt->setLocale('fr_CA')->setText('');$data->addLabelI18n($mt)->save();}
try{$data->getTranslation('en_US');}catch (Exception $exep){$mt = new LabelI18n();$mt->setLocale('en_US')->setText('');$data->addLabelI18n($mt)->save();}
                
                
                
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['IdLabel']) and $altValue['IdLabel'])?$altValue['IdLabel']:$data->getIdLabel()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("ID").":\" j='editLabel'  i='".json_encode($data->getPrimaryKey())."' c='IdLabel'  ")
                            .td(span(strip_tags((isset($altValue['LabelText']) and $altValue['LabelText'])?$altValue['LabelText']:mb_substr(strip_tags($data->getLabelText()),0,50, 'UTF-8')." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Label").":\" j='editLabel'  i='".json_encode($data->getPrimaryKey())."' c='LabelText'  ")
                            .td(span(strip_tags((isset($altValue['Reference']) and $altValue['Reference'])?$altValue['Reference']:mb_substr(strip_tags($data->getReference()),0,50, 'UTF-8')." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Reference").":\" j='editLabel'  i='".json_encode($data->getPrimaryKey())."' c='Reference'  ")
                            .td(span(strip_tags((isset($altValue['Etat']) and $altValue['Etat'])?$altValue['Etat']:isntPo($data->getEtat())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Statut").":\" j='editLabel'  i='".json_encode($data->getPrimaryKey())."' c='Etat'  ")
                            .td(span(strip_tags((isset($altValue['LabelI18n_Text_frCA']) and $altValue['LabelI18n_Text_frCA'])?$altValue['LabelI18n_Text_frCA']:$data->getTranslation('fr_CA')->getText()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Label fr_CA").":\" j='editLabel'  i='".json_encode($data->getPrimaryKey())."' c='LabelI18n_Text_frCA'  ")
                            .td(span(strip_tags((isset($altValue['LabelI18n_Text_enUS']) and $altValue['LabelI18n_Text_enUS'])?$altValue['LabelI18n_Text_enUS']:$data->getTranslation('en_US')->getText()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Label en_US").":\" j='editLabel'  i='".json_encode($data->getPrimaryKey())."' c='LabelI18n_Text_enUS'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='LabelRow".$data->getPrimaryKey()."'
                    data-table='Label' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountLabel', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Label';

            if($pmpoData->haveToPaginate()){
                $pages = $pmpoData->getLinks();
                if(!$page or !is_numeric($page)){$page=1;}
                
                if($page > $pmpoData->getLastPage()) { $page = $pmpoData->getLastPage(); }

                $pagerRow =
                    div(
                        button(span(_('Retourner en haut')),"class='scroll-top button-link-blue'")
                        .div(
                            p(span(_paging_nbr_per_page).' '._('par page').' - '.span($resultsCount).' '._('R??sultat(s)').' ')
                            .div(
                                href(span(_('Pr??c??dent')),'#',"class='prev' data-direction='prev'")
                                .input('text','page',$page,'data-total="'.$pmpoData->getLastPage().'"')
                                .p('/ '.$pmpoData->getLastPage())
                                .href(span(_('Suivant')),'#',"class='next' data-direction='next'")
                            ,'','id="LabelPagination"')
                        ,'',"class='pagination-wrapper' ")
                    ,'cntPagerRow',"class='navigation-wrapper has-pagination'");
            } else {
                $pagerRow =
                div(
                    button(span(_('Retourner en haut')),"class='scroll-top button-link-blue'")
                    .div(
                        p(span($resultsCount).' '._('r??sultat(s)').' ')
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
                .div($controlsContent.$this->CcCustomControl,'LabelControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='LabelTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'LabelListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#LabelListForm [j='deleteLabel']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Label'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msLabelBt\').length>0){ sw_message(\'".addslashes(_('Suppression compl??t??.'))."\',false,\'search-progress\'); $(\'#msLabelBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#LabelListForm tr[ecf=1] td[j='editLabel']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."Label/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."Label/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Label'
                ,'IdLabel'
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
        $(\"#LabelListForm [j='deleteLabel']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Label'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msLabelBt\').length>0){ $(\'#msLabelBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'LabelTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntLabelListForm #addLabel').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'LabelTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#LabelListForm tr[ecf=1] td[j='editLabel']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'LabelTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Label'
                ,'IdLabel'
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
        pagination_bind('Label','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#LabelListForm [j='deleteLabel']\").unbind('click');
        $('#LabelListForm #addLabel').unbind('click');
        $(\"#LabelListForm tr[ecf=1] td[j='editLabel']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#LabelListForm [j='button']\").unbind();   
        pagination_sorted_bind('Label','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('Label','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('Label','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_Label($data){

        unset($data['IdLabel']);
        $e = new Label();
        
        
        if(!@$data['Etat']){$data['Etat'] = "Actif";} 
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_Label($data){

        
        $e = LabelQuery::create()->findPk(json_decode($data['i']));
        
        
        if(!@$data['Etat']){$data['Etat'] = "Actif";} 
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of Label
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
        $je= "LabelTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['Label']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['Label']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addLabel_child').bind('click.addLabel', function (){
                    $.post('"._SITE_URL."mod/act/LabelAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addLabel_child').bind('click.addLabel', function (){
                document.location= '"._SITE_URL."Label/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = LabelQuery::create();
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Label', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Label','w',$dataObj)) 
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
                    $('#formLabel #saveLabel').removeAttr('disabled');
                    $('#formLabel #saveLabel').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formLabel #saveLabel').css('cursor', 'default');
                    if($('#formLabel #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formLabel #saveLabel').bind('click.saveLabel', function (data){
                    $('#formLabel #saveLabel').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formLabel #saveLabel').css('cursor', 'progress');
                    $('#formLabel #saveLabel').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formLabel .tinymce').each(function(index) {
                        eval(' $(\"#formLabel #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formLabel select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formLabel\").find(\"[s='d']\").serializeArray();
                        $('#formLabel select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formLabel\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/LabelAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formLabel #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formLabel #formChangedLabel').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formLabel #saveLabel').unbind('click.saveLabel');
                $('#formLabel #saveLabel').remove();";
        }
        
        if($dataObj == null){
            $this->Label['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Label();
            $this->Label['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }

try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new LabelI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addLabelI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new LabelI18n();$mt->setLocale('en_US')->setText('');$dataObj->addLabelI18n($mt)->save();}

        
        
        
        
        
        
        

            $this->fields['Label']['IdLabel']['html'] = stdFieldRow(_("ID"), $dataObj->getIdLabel(), 'IdLabel', "", @$this->commentsIdLabel, @$this->commentsIdLabel_css, '', ' ','no','');

            $this->fields['Label']['LabelText']['html'] = stdFieldRow(_("Label"), 
        textarea('LabelText',$dataObj->getLabelText() ,"placeholder='".str_replace("'","&#39;",_('Label'))."' cols='71' otherTabs=1 v='LABEL_TEXT' s='d'  class='' style='' spellcheck='false'"), 'LabelText', "", @$this->commentsLabelText, @$this->commentsLabelText_css, ' istinymce', ' ','no','');

            $this->fields['Label']['Reference']['html'] = stdFieldRow(_("Reference"), 
        textarea('Reference',$dataObj->getReference() ,"placeholder='".str_replace("'","&#39;",_('Reference'))."' cols='71' otherTabs=1 v='REFERENCE' s='d'  class='' style='' spellcheck='false'"), 'Reference', "", @$this->commentsReference, @$this->commentsReference_css, ' istinymce', ' ','no','');

            $this->fields['Label']['Etat']['html'] = stdFieldRow(_("Statut"), selectboxCustomArray('Etat', array( '0' => array('0'=>_("Actif"), '1'=>'Actif'),'1' => array('0'=>_("Nouveau"), '1'=>'Nouveau'),'2' => array('0'=>_("Inactif"), '1'=>'Inactif'), ), "", "s='d' otherTabs=1  ", $dataObj->getEtat()), 'Etat', "", @$this->commentsEtat, @$this->commentsEtat_css, '', ' ','no','');

            $this->fields['Label']['LabelI18n_Text_frCA']['html'] = stdFieldRow(_("Label fran??ais"), 
        textarea('LabelI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText() ,"placeholder='".str_replace("'","&#39;",_('Label fr_CA'))."' cols='71' v='LABELI18N_TEXT_FRCA' otherTabs=1 s='d'   class='' style='' spellcheck='false'"), 'LabelI18n_Text_frCA', "", @$this->commentsLabelI18n_Text_frCA, @$this->commentsLabelI18n_Text_frCA_css, ' istinymce', ' ','no','');

            $this->fields['Label']['LabelI18n_Text_enUS']['html'] = stdFieldRow(_("Label anglais"), 
        textarea('LabelI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText() ,"placeholder='".str_replace("'","&#39;",_('Label en_US'))."' cols='71' v='LABELI18N_TEXT_ENUS' otherTabs=1 s='d'   class='' style='' spellcheck='false'"), 'LabelI18n_Text_enUS', "", @$this->commentsLabelI18n_Text_enUS, @$this->commentsLabelI18n_Text_enUS_css, ' istinymce', ' ','no','');

        $this->lockFormField(array(0=>'LabelText',), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->Label['request']['ChildHide']) ){
            
        }
        
        
        if($dataObj->getIdLabel()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    .htmlLink('Impression', _SITE_URL."Label/print/".urlencode($id), "target='_blank' j='button' class='ac-button ac-light-blue' id='printLabel'").$print_pdf
                    
                .div(
                    button(span(_("Pr??c??dent")),'id="previous_item"')
                    .button(span(_("Suivant")),'id="next_item"')
                ,'','class="nav-btn"')
            
                    
                    .@$this->CcCustomControl
                ,'LabelControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = '';
            }

        }
        
        
        $titre_form_str = '';
        if($dataObj->getIdLabel()){
                   $titre_form_str .= span(strip_tags(_($dataObj->getLabelText()))," data-name='label_text' ");
                   $this->siteTitle =set_var($this->siteTitle,strip_tags(_($dataObj->getLabelText())),' ',false,NULL,false,true);}
        $this->formTitle = p(href("Label",_SITE_URL.'Label').$titre_form_str, 'class="breadcrumb"'); 
        $ongletf =
            div(
                ul(li(htmlLink(_('Label'),'#ogf_Label',' j="ogf" p="Label" class="ui-tabs-anchor button-link-blue" ')).li(htmlLink(_('Fran??ais'),'#ogf_Labeli18nTextFrca',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Label" ')).li(htmlLink(_('Anglais'),'#ogf_Labeli18nTextEnus',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Label" ')))
            ,'cntOngletLabel',' class="cntOnglet"')
            .@$close_form
        ;
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addLabel_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveLabel',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedLabel','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdLabel', $dataObj->getIdLabel(), " otherTabs=1 s='d' pk").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'LabelControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formLabel');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['Label']['tog']) and 
            $_SESSION['memoire']['onglet']['Label']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['Label']['Start']['html']
                
                .
                    '<div id="ogf_Label">'.
$this->fields['Label']['IdLabel']['html']
.$this->fields['Label']['LabelText']['html']
.$this->fields['Label']['Reference']['html']
.$this->fields['Label']['Etat']['html']
.'</div><div id="ogf_Labeli18nTextFrca"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Label']['LabelI18n_Text_frCA']['html']
.'</div><div id="ogf_Labeli18nTextEnus"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Label']['LabelI18n_Text_enUS']['html'].'</div>'
                
                .@$this->fields['Label']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntLabel", "class='divStdform' CntTabs=1 ")
        , "id='formLabel' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Label"); }
        # if not new, show child table
        if($dataObj->getIdLabel()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelLabel', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntLabelChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['Label']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['Label']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['Label']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    
    ".$jqueryDatePicker."
    bind_ui_active('Label');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    $('#cntOngletLabel').parent().tabs();$('#cntOngletLabel').show();
                 $('#next_item').unbind();
                 $('#next_item').bind('click', function (){
                     $.post('"._SITE_URL."mod/act/LabelAct.php', {a:'next', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', i:'".$id."'},
                         function(data){ if(isNumber(data)){document.location = '"._SITE_URL."Label/edit/'+data;}else{ $('#next_item').hide();} });
                 });
                 $('#previous_item').unbind();
                 $('#previous_item').bind('click', function (){
                     $.post('"._SITE_URL."mod/act/LabelAct.php', {a:'previous', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', i:'".$id."'},
                         function(data){ if(isNumber(data)){document.location = '"._SITE_URL."Label/edit/'+data;}else{ $('#previous_item').hide();} });
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
     setTimeout(function(){ bind_othertabs_std('#divCntLabel');},500); 
    ".$toggleForm."
    bind_form('Label','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new LabelI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addLabelI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new LabelI18n();$mt->setLocale('en_US')->setText('');$dataObj->addLabelI18n($mt)->save();}
            
        $this->fieldsRo['Label']['IdLabel']['html'] = stdFieldRow(_("ID"), input('text','IdLabel',$dataObj->getIdLabel()," readonly s='d'"), 'IdLabel', "", @$this->commentsIdLabel, @$this->commentsIdLabel_css, 'readonly', ' ','no','');
$this->fieldsRo['Label']['LabelText']['html'] = stdFieldRow(_("Label"), textarea('LabelText',$dataObj->getLabelText()," readonly class=''    s='d'"), 'LabelText', "", @$this->commentsLabelText, @$this->commentsLabelText_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Label']['Reference']['html'] = stdFieldRow(_("Reference"), textarea('Reference',$dataObj->getReference()," readonly class=''    s='d'"), 'Reference', "", @$this->commentsReference, @$this->commentsReference_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Label']['Etat']['html'] = stdFieldRow(_("Statut"), input('text','Etat',$dataObj->getEtat()," readonly s='d'"), 'Etat', "", @$this->commentsEtat, @$this->commentsEtat_css, 'readonly', ' ','no','');
$this->fieldsRo['Label']['LabelI18n_Text_frCA']['html'] = stdFieldRow(_("Label fran??ais"), textarea('LabelI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText()," readonly class=''    s='d'"), 'LabelI18n_Text_frCA', "", @$this->commentsLabelI18n_Text_frCA, @$this->commentsLabelI18n_Text_frCA_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Label']['LabelI18n_Text_enUS']['html'] = stdFieldRow(_("Label anglais"), textarea('LabelI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText()," readonly class=''    s='d'"), 'LabelI18n_Text_enUS', "", @$this->commentsLabelI18n_Text_enUS, @$this->commentsLabelI18n_Text_enUS_css, 'readonly istinymce', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['Label'] as $field=>$ar){
                $this->fields['Label'][$field]['html'] = $this->fieldsRo['Label'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['Label'][$field]['html'] = $this->fieldsRo['Label'][$field]['html'];
            }
        }
    }
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = LabelQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdLabel'));
            
        
        }else{
            $q->select(array('Name', 'IdLabel'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = LabelQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdLabel'));
            
        
        }else{
            $q->select(array('Name', 'IdLabel'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Label')), $selected);
        }


        return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'LabelAct.php';
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
