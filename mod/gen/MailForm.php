<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'Mail' table.
 *
 */
class MailForm extends Mail{
public $tableName="Mail";
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
        $q = MailQuery::create();
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
                if(isset($this->searchMs['Name']) and $this->searchMs['Name'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Name']) and strpos($this->searchMs['Name'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Name'] != '%DoNothing%' AND $this->searchMs['Name'][0] != '%DoNothing%'){
                        $q->filterByName("%".$this->searchMs['Name']."%", Criteria::LIKE);
                    }
                }
                if(isset($this->searchMs['Title']) and $this->searchMs['Title'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Title']) and strpos($this->searchMs['Title'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Title'] != '%DoNothing%' AND $this->searchMs['Title'][0] != '%DoNothing%'){
                        $q->filterByTitle("%".$this->searchMs['Title']."%", Criteria::LIKE);
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
        
         $q->groupBy('IdMail');
        
        $this->pmpoData =  $q;
        //echo $q->toString();
        //$q->paginate($page, $maxPerPage);
        return $this->pmpoData;
    }
    public function getListHeader($act){
        switch($act){
            case 'head':
            ###### TH
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Mail #"), " th='sorted'  rcColone='CalcId' c='CalcId'  ").th(_("Status"), " th='sorted'  rcColone='Status' c='Status'  ").th(_("Nom"), " th='sorted'  rcColone='Name' c='Name'  ").th(_("Title fr_CA"), " th='sorted'  rcColone='Maili18nTitleFrca' c='MailI18n.Title'  ").th(_("Contenu  fr_CA"), " th='sorted'  rcColone='Maili18nTextFrca' c='MailI18n.Text'  ").th(_("Title en_US"), " th='sorted'  rcColone='Maili18nTitleEnus' c='MailI18n.Title'  ").th(_("Contenu  en_US"), " th='sorted'  rcColone='Maili18nTextEnus' c='MailI18n.Text'  "). $this->cCmoreColsHeader;
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
                $array_search_tb = array('Name','Title','Text');
                
                unset($data);$data['Name'] = (!empty($this->searchMs['Name']))?$this->searchMs['Name']:'';
        $data['Title'] = (!empty($this->searchMs['Title']))?$this->searchMs['Title']:'';
        $data['Text'] = (!empty($this->searchMs['Text']))?$this->searchMs['Text']:'';
        
                
        @$this->fieldsSearch['Mail']['Name'] = div(input('text', 'Name', $this->searchMs['Name'], ' othertabs=1  placeholder="'._('Name').'"',''),'','class="ac-search-item ms-Name"');
        @$this->fieldsSearch['Mail']['Title'] = div(input('text', 'Title', $this->searchMs['Title'], ' othertabs=1  placeholder="'._('Title').'"',''),'','class="ac-search-item ms-Title"');
        @$this->fieldsSearch['Mail']['Text'] = div(input('text', 'Text', $this->searchMs['Text'], ' othertabs=1  placeholder="'._('Text').'"',''),'','class="ac-search-item ms-Text"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msMailAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['Mail']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msMailBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msMailBtClear" class="icon clear"')
               .@$this->fieldsSearch['Mail']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['Mail']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-MailSearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['Mail']['Start'].
                    $this->fieldsSearch['Mail']['Name'].
                    $this->fieldsSearch['Mail']['Title'].
                    $this->fieldsSearch['Mail']['Text'].
                @$this->fieldsSearch['Mail']['End'].
            $this->fieldsSearch['Mail']['Button']
            ,"id='formMsMail' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('Mail', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."Mail/edit/", "id='addMail' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addMailAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Courriel");
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
        if(!empty($_SESSION['memoire']['onglet']['Mail']['pg'])){
            $page = $_SESSION['memoire']['onglet']['Mail']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'MailAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'MailAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#MailListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#MailListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('Mail', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('Mail', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('Mail', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteMail' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
try{$data->getTranslation('fr_CA');}catch (Exception $exep){$mt = new MailI18n();$mt->setLocale('fr_CA')->setTitle('');$data->addMailI18n($mt)->save();}
try{$data->getTranslation('fr_CA');}catch (Exception $exep){$mt = new MailI18n();$mt->setLocale('fr_CA')->setText('');$data->addMailI18n($mt)->save();}
try{$data->getTranslation('en_US');}catch (Exception $exep){$mt = new MailI18n();$mt->setLocale('en_US')->setTitle('');$data->addMailI18n($mt)->save();}
try{$data->getTranslation('en_US');}catch (Exception $exep){$mt = new MailI18n();$mt->setLocale('en_US')->setText('');$data->addMailI18n($mt)->save();}
                
                
                
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['CalcId']) and $altValue['CalcId'])?$altValue['CalcId']:$data->getCalcId()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Mail #").":\" j='editMail'  i='".json_encode($data->getPrimaryKey())."' c='CalcId'  ")
                            .td(span(strip_tags((isset($altValue['Status']) and $altValue['Status'])?$altValue['Status']:isntPo($data->getStatus())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Status").":\" j='editMail'  i='".json_encode($data->getPrimaryKey())."' c='Status'  ")
                            .td(span(strip_tags((isset($altValue['Name']) and $altValue['Name'])?$altValue['Name']:$data->getName()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Nom").":\" j='editMail'  i='".json_encode($data->getPrimaryKey())."' c='Name'  ")
                            .td(span(strip_tags((isset($altValue['MailI18n_Title_frCA']) and $altValue['MailI18n_Title_frCA'])?$altValue['MailI18n_Title_frCA']:$data->getTranslation('fr_CA')->getTitle()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Title fr_CA").":\" j='editMail'  i='".json_encode($data->getPrimaryKey())."' c='MailI18n_Title_frCA'  ")
                            .td(span(strip_tags((isset($altValue['MailI18n_Text_frCA']) and $altValue['MailI18n_Text_frCA'])?$altValue['MailI18n_Text_frCA']:$data->getTranslation('fr_CA')->getText()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Contenu  fr_CA").":\" j='editMail'  i='".json_encode($data->getPrimaryKey())."' c='MailI18n_Text_frCA'  ")
                            .td(span(strip_tags((isset($altValue['MailI18n_Title_enUS']) and $altValue['MailI18n_Title_enUS'])?$altValue['MailI18n_Title_enUS']:$data->getTranslation('en_US')->getTitle()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Title en_US").":\" j='editMail'  i='".json_encode($data->getPrimaryKey())."' c='MailI18n_Title_enUS'  ")
                            .td(span(strip_tags((isset($altValue['MailI18n_Text_enUS']) and $altValue['MailI18n_Text_enUS'])?$altValue['MailI18n_Text_enUS']:$data->getTranslation('en_US')->getText()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Contenu  en_US").":\" j='editMail'  i='".json_encode($data->getPrimaryKey())."' c='MailI18n_Text_enUS'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='MailRow".$data->getPrimaryKey()."'
                    data-table='Mail' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountMail', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Courriel';

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
                            ,'','id="MailPagination"')
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
                .div($controlsContent.$this->CcCustomControl,'MailControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='MailTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'MailListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#MailListForm [j='deleteMail']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Courriel'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msMailBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msMailBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#MailListForm tr[ecf=1] td[j='editMail']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."Mail/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."Mail/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Mail'
                ,'IdMail'
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
        $(\"#MailListForm [j='deleteMail']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Courriel'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msMailBt\').length>0){ $(\'#msMailBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'MailTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntMailListForm #addMail').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'MailTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#MailListForm tr[ecf=1] td[j='editMail']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'MailTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Mail'
                ,'IdMail'
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
        pagination_bind('Mail','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#MailListForm [j='deleteMail']\").unbind('click');
        $('#MailListForm #addMail').unbind('click');
        $(\"#MailListForm tr[ecf=1] td[j='editMail']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#MailListForm [j='button']\").unbind();   
        pagination_sorted_bind('Mail','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('Mail','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('Mail','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_Mail($data){

        unset($data['IdMail']);
        $e = new Mail();
        
        
        if($data['Status'] == ''){unset($data['Status']);}
        $e->fromArray($data );
        
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?date('Y-m-d'):$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?date('Y-m-d'):$data['DateModification'] );
        $e->setStatus(($data['Status']=='')?null:$data['Status']);
        return $e;
    }
    public function save_update_Mail($data){

        
        $e = MailQuery::create()->findPk(json_decode($data['i']));
        
        
        if($data['Status'] == ''){unset($data['Status']);}
        $e->fromArray($data );
        
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        if(isset($data['Status'])){$e->setStatus(($data['Status']=='')?null:$data['Status']);}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of Mail
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
        $je= "MailTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['Mail']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['Mail']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addMail_child').bind('click.addMail', function (){
                    $.post('"._SITE_URL."mod/act/MailAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addMail_child').bind('click.addMail', function (){
                document.location= '"._SITE_URL."Mail/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = MailQuery::create();
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Mail', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Mail','w',$dataObj)) 
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
                    $('#formMail #saveMail').removeAttr('disabled');
                    $('#formMail #saveMail').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formMail #saveMail').css('cursor', 'default');
                    if($('#formMail #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formMail #saveMail').bind('click.saveMail', function (data){
                    $('#formMail #saveMail').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formMail #saveMail').css('cursor', 'progress');
                    $('#formMail #saveMail').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formMail .tinymce').each(function(index) {
                        eval(' $(\"#formMail #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formMail select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formMail\").find(\"[s='d']\").serializeArray();
                        $('#formMail select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formMail\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/MailAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formMail #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formMail #formChangedMail').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formMail #saveMail').unbind('click.saveMail');
                $('#formMail #saveMail').remove();";
        }
        
        if($dataObj == null){
            $this->Mail['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Mail();
            $this->Mail['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }

try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new MailI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addMailI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new MailI18n();$mt->setLocale('en_US')->setText('');$dataObj->addMailI18n($mt)->save();}

        
        
        
        
        
        
        

            $this->fields['Mail']['CalcId']['html'] = stdFieldRow(_("Mail #"), input('text', 'CalcId',str_replace('"','&quot;',$dataObj->getCalcId()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Mail #'))."' size='15'  v='CALC_ID' s='d' class=''")."", 'CalcId', "", @$this->commentsCalcId, @$this->commentsCalcId_css, '', ' ','no','');

            $this->fields['Mail']['Status']['html'] = stdFieldRow(_("Status"), selectboxCustomArray('Status', array( '0' => array('0'=>_("Publie"), '1'=>'Publie'),'1' => array('0'=>_("Archive"), '1'=>'Archive'), ), _('Status'), "s='d' otherTabs=1  ", $dataObj->getStatus()), 'Status', "", @$this->commentsStatus, @$this->commentsStatus_css, '', ' ','no','');

            $this->fields['Mail']['Name']['html'] = stdFieldRow(_("Nom"), input('text', 'Name',str_replace('"','&quot;',$dataObj->getName()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Nom'))."' size='35'  v='NAME' s='d' class=''")."", 'Name', "", @$this->commentsName, @$this->commentsName_css, '', ' ','no','');

            $this->fields['Mail']['MailI18n_Title_frCA']['html'] = stdFieldRow(_("Title français"), input('text', 'MailI18n_Title_frCA',str_replace('"','&quot;',$dataObj->getTranslation('fr_CA')->getTitle()), "placeholder='".str_replace("'","&#39;",_('Title fr_CA'))."' size='69' otherTabs=1  v='MAILI18N_TITLE_FRCA' s='d'  class=''")."", 'MailI18n_Title_frCA', "", @$this->commentsMailI18n_Title_frCA, @$this->commentsMailI18n_Title_frCA_css, '', ' ','no','');

            $this->fields['Mail']['MailI18n_Text_frCA']['html'] = stdFieldRow(_("Contenu  français"), 
        textarea('MailI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText() ,"placeholder='".str_replace("'","&#39;",_('Contenu  fr_CA'))."' cols='71' v='MAILI18N_TEXT_FRCA' otherTabs=1 s='d'  class='tinymce'  class='' style='' spellcheck='false'"), 'MailI18n_Text_frCA', "", @$this->commentsMailI18n_Text_frCA, @$this->commentsMailI18n_Text_frCA_css, ' istinymce', ' ','no','');

            $this->fields['Mail']['MailI18n_Title_enUS']['html'] = stdFieldRow(_("Title anglais"), input('text', 'MailI18n_Title_enUS',str_replace('"','&quot;',$dataObj->getTranslation('en_US')->getTitle()), "placeholder='".str_replace("'","&#39;",_('Title en_US'))."' size='69' otherTabs=1  v='MAILI18N_TITLE_ENUS' s='d'  class=''")."", 'MailI18n_Title_enUS', "", @$this->commentsMailI18n_Title_enUS, @$this->commentsMailI18n_Title_enUS_css, '', ' ','no','');

            $this->fields['Mail']['MailI18n_Text_enUS']['html'] = stdFieldRow(_("Contenu  anglais"), 
        textarea('MailI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText() ,"placeholder='".str_replace("'","&#39;",_('Contenu  en_US'))."' cols='71' v='MAILI18N_TEXT_ENUS' otherTabs=1 s='d'  class='tinymce'  class='' style='' spellcheck='false'"), 'MailI18n_Text_enUS', "", @$this->commentsMailI18n_Text_enUS, @$this->commentsMailI18n_Text_enUS_css, ' istinymce', ' ','no','');

        $this->lockFormField(array(0=>'IdMail',), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->Mail['request']['ChildHide']) ){
            
        }
        
        
        if($dataObj->getIdMail()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'MailControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = '';
            }

        }
        
        
        $titre_form_str = '';
        if($dataObj->getIdMail()){
                   $titre_form_str .= span(strip_tags(_($dataObj->getName()))," data-name='Name' ");
                   $this->siteTitle =set_var($this->siteTitle,strip_tags(_($dataObj->getName())),' ',false,NULL,false,true);}
        $this->formTitle = p(href("Courriel",_SITE_URL.'Mail').$titre_form_str, 'class="breadcrumb"'); 
        $ongletf =
            div(
                ul(li(htmlLink(_('Courriel'),'#ogf_Mail',' j="ogf" p="Mail" class="ui-tabs-anchor button-link-blue" ')).li(htmlLink(_('Français'),'#ogf_Maili18nTitleFrca',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Mail" ')).li(htmlLink(_('Anglais'),'#ogf_Maili18nTitleEnus',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Mail" ')))
            ,'cntOngletMail',' class="cntOnglet"')
            .@$close_form
        ;
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addMail_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveMail',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedMail','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdMail', $dataObj->getIdMail(), " otherTabs=1 s='d' pk").input('hidden', 'IdCreation', $dataObj->getIdCreation(), " otherTabs=1 s='d' nodesc").input('hidden', 'IdModification', $dataObj->getIdModification(), " otherTabs=1 s='d' nodesc")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        $mceInclude = loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/ckeditor.js")
            .loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/adapters/jquery.js");
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'MailControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formMail');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['Mail']['tog']) and 
            $_SESSION['memoire']['onglet']['Mail']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['Mail']['Start']['html']
                
                .
                    '<div id="ogf_Mail">'.
$this->fields['Mail']['CalcId']['html']
.$this->fields['Mail']['Status']['html']
.$this->fields['Mail']['Name']['html']
.'</div><div id="ogf_Maili18nTitleFrca"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Mail']['MailI18n_Title_frCA']['html']
.$this->fields['Mail']['MailI18n_Text_frCA']['html']
.'</div><div id="ogf_Maili18nTitleEnus"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Mail']['MailI18n_Title_enUS']['html']
.$this->fields['Mail']['MailI18n_Text_enUS']['html'].'</div>'
                
                .@$this->fields['Mail']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntMail", "class='divStdform' CntTabs=1 ")
        , "id='formMail' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Courriel"); }
        # if not new, show child table
        if($dataObj->getIdMail()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelMail', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntMailChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['Mail']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['Mail']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['Mail']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    
    ".$jqueryDatePicker."
    bind_ui_active('Mail');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    $('#formMail .tinymce').each(function() {
        if (CKEDITOR.instances[$(this).attr('Id')]){
            CKEDITOR.instances[$(this).attr('Id')].destroy();
        }
        ckeTemp = CKEDITOR.replace($(this).attr('Id'), {
            extraAllowedContent: '*(*)[*];sup(*)[*];article(*)[*];section(*)[*];div(*)[*];span(*)'
            ".@$this->ccAddCkeditorInit."
        });
        ckeTemp.on('change',function( evt ){ $('.divtd input[type=\"button\"]').addClass('can-save');});
        ckeTemp.on('key',function( event ){ if(event.data.keyCode ==1114195){ $('form [act=save]').click(); return false;}});
    });$('#cntOngletMail').parent().tabs();$('#cntOngletMail').show();
    ".@$childTable['onReadyJs']."
    ".@$error['onReadyJs']."
    ".@$removeEditChild."
    /*try {afterFormLoad();}catch(e){}*/
    if($('#loader').css('display') == 'block') $('#loader').hide();
    $('[j=sftr]').hide();
    ".@$tabs_act."
    ".$this->CcToFormJs
    .@$script_autoc_one."
     setTimeout(function(){ bind_othertabs_std('#divCntMail');},500); 
    ".$toggleForm."
    bind_form('Mail','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
try{$dataObj->getTranslation('fr_CA');}catch (Exception $exep){$mt = new MailI18n();$mt->setLocale('fr_CA')->setText('');$dataObj->addMailI18n($mt)->save();}
try{$dataObj->getTranslation('en_US');}catch (Exception $exep){$mt = new MailI18n();$mt->setLocale('en_US')->setText('');$dataObj->addMailI18n($mt)->save();}
            
        $this->fieldsRo['Mail']['CalcId']['html'] = stdFieldRow(_("Mail #"), input('text','CalcId',$dataObj->getCalcId()," readonly s='d'"), 'CalcId', "", @$this->commentsCalcId, @$this->commentsCalcId_css, 'readonly', ' ','no','');
$this->fieldsRo['Mail']['Status']['html'] = stdFieldRow(_("Status"), input('text','Status',$dataObj->getStatus()," readonly s='d'"), 'Status', "", @$this->commentsStatus, @$this->commentsStatus_css, 'readonly', ' ','no','');
$this->fieldsRo['Mail']['Name']['html'] = stdFieldRow(_("Nom"), input('text','Name',$dataObj->getName()," readonly s='d'"), 'Name', "", @$this->commentsName, @$this->commentsName_css, 'readonly', ' ','no','');
$this->fieldsRo['Mail']['MailI18n_Title_frCA']['html'] = stdFieldRow(_("Title français"), input('text','MailI18n_Title_frCA',$dataObj->getTranslation('fr_CA')->getTitle()," readonly s='d'"), 'MailI18n_Title_frCA', "", @$this->commentsMailI18n_Title_frCA, @$this->commentsMailI18n_Title_frCA_css, 'readonly', ' ','no','');
$this->fieldsRo['Mail']['MailI18n_Text_frCA']['html'] = stdFieldRow(_("Contenu  français"), textarea('MailI18n_Text_frCA',$dataObj->getTranslation('fr_CA')->getText()," readonly class='tinymce'    s='d'"), 'MailI18n_Text_frCA', "", @$this->commentsMailI18n_Text_frCA, @$this->commentsMailI18n_Text_frCA_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Mail']['MailI18n_Title_enUS']['html'] = stdFieldRow(_("Title anglais"), input('text','MailI18n_Title_enUS',$dataObj->getTranslation('en_US')->getTitle()," readonly s='d'"), 'MailI18n_Title_enUS', "", @$this->commentsMailI18n_Title_enUS, @$this->commentsMailI18n_Title_enUS_css, 'readonly', ' ','no','');
$this->fieldsRo['Mail']['MailI18n_Text_enUS']['html'] = stdFieldRow(_("Contenu  anglais"), textarea('MailI18n_Text_enUS',$dataObj->getTranslation('en_US')->getText()," readonly class='tinymce'    s='d'"), 'MailI18n_Text_enUS', "", @$this->commentsMailI18n_Text_enUS, @$this->commentsMailI18n_Text_enUS_css, 'readonly istinymce', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['Mail'] as $field=>$ar){
                $this->fields['Mail'][$field]['html'] = $this->fieldsRo['Mail'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['Mail'][$field]['html'] = $this->fieldsRo['Mail'][$field]['html'];
            }
        }
    }
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = MailQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdMail'));
            
        
        }else{
            $q->select(array('Name', 'IdMail'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = MailQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Name', 'IdMail'));
            
        
        }else{
            $q->select(array('Name', 'IdMail'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucune Courriel')), $selected);
        }


        return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'MailAct.php';
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
