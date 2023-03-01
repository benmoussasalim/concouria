<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'Account' table.
 *
 */
class AccountForm extends Account{
public $tableName="Account";
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
        $q = AccountQuery::create();
        if($this->CcToSearchList){ getSelectFilter($this->CcToSearchList,$q);}
        if(is_array($this->searchAr)){
            array_walk_recursive ($this->searchAr, function (&$v){$v=trim($v);});
            ## query sub-Menu
            if(@$this->searchAr['v'] && !$this->searchAr['uv']){
                $filterStr = "filterBy".$this->searchAr['f'];
                $q 
->joinWith('Authy') 
->joinWith('Ville')
->leftJoin('Region') 
->joinWith('Province') 
->joinWith('Pays')
                    ->$filterStr($this->searchAr['v']);
                    
                    
            }elseif(@$this->searchAr['u'] && $this->searchAr['uv']){
                $useStr = "use".$this->searchAr['u']."Query";
                $filterStr = "filterBy".$this->searchAr['f'];
                $q->$useStr()->$filterStr($this->searchAr['uv'])->endUse()
                     
->joinWith('Authy') 
->joinWith('Ville')
->leftJoin('Region') 
->joinWith('Province') 
->joinWith('Pays');
            }else{
                $q 
->joinWith('Authy') 
->joinWith('Ville')
->leftJoin('Region') 
->joinWith('Province') 
->joinWith('Pays');
            }
        }else{
            if(is_array($this->searchMs )){
                array_walk_recursive($this->searchMs, function (&$v){$v=trim($v);});
                $q 
->joinWith('Authy') 
->joinWith('Ville')
->leftJoin('Region') 
->joinWith('Province') 
->joinWith('Pays');
                if(isset($this->searchMs['Sexe']) and $this->searchMs['Sexe'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Sexe']) and strpos($this->searchMs['Sexe'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Sexe'] != '%DoNothing%' AND $this->searchMs['Sexe'][0] != '%DoNothing%'){
                        $q ->filterBySexe($this->searchMs['Sexe'],$criteria);
                    }
                }
                if(isset($this->searchMs['Firstname']) and $this->searchMs['Firstname'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Firstname']) and strpos($this->searchMs['Firstname'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Firstname'] != '%DoNothing%' AND $this->searchMs['Firstname'][0] != '%DoNothing%'){
                        $q->filterByFirstname("%".$this->searchMs['Firstname']."%", Criteria::LIKE);
                    }
                }
                if(isset($this->searchMs['Lastname']) and $this->searchMs['Lastname'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Lastname']) and strpos($this->searchMs['Lastname'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Lastname'] != '%DoNothing%' AND $this->searchMs['Lastname'][0] != '%DoNothing%'){
                        $q->filterByLastname("%".$this->searchMs['Lastname']."%", Criteria::LIKE);
                    }
                }
                if(isset($this->searchMs['Email']) and $this->searchMs['Email'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Email']) and strpos($this->searchMs['Email'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Email'] != '%DoNothing%' AND $this->searchMs['Email'][0] != '%DoNothing%'){
                        $q->filterByEmail("%".$this->searchMs['Email']."%", Criteria::LIKE);
                    }
                }
                if(isset($this->searchMs['Status']) and $this->searchMs['Status'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Status']) and strpos($this->searchMs['Status'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Status'] != '%DoNothing%' AND $this->searchMs['Status'][0] != '%DoNothing%'){
                        $q ->filterByStatus($this->searchMs['Status'],$criteria);
                    }
                }
                if(isset($this->searchMs['IdVille']) and $this->searchMs['IdVille'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['IdVille']) and strpos($this->searchMs['IdVille'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['IdVille'] != '%DoNothing%' AND $this->searchMs['IdVille'][0] != '%DoNothing%'){
                        $q ->filterByIdVille($this->searchMs['IdVille'],$criteria);
                    }
                }
                if(isset($this->searchMs['ExportReady']) and $this->searchMs['ExportReady'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['ExportReady']) and strpos($this->searchMs['ExportReady'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['ExportReady'] != '%DoNothing%' AND $this->searchMs['ExportReady'][0] != '%DoNothing%'){
                        $q ->filterByExportReady($this->searchMs['ExportReady'],$criteria);
                    }
                }
            }else{
                
                $hasParent = json_decode($IdParent);
                if(empty($hasParent)){
                    $q 
->joinWith('Authy') 
->joinWith('Ville')
->leftJoin('Region') 
->joinWith('Province') 
->joinWith('Pays');
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
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Valide pour les concours"), " th='sorted'  rcColone='ExportReady' c='ExportReady'  ").th(_("Prénom"), " th='sorted'  rcColone='Firstname' c='Firstname'  ").th(_("Nom"), " th='sorted'  rcColone='Lastname' c='Lastname'  ").th(_("Courriel"), " th='sorted'  rcColone='Email' c='Email'  ").th(_("Date d'expiration"), " th='sorted'  rcColone='DateExpire' c='DateExpire'  "). $this->cCmoreColsHeader;
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
                $array_search_tb = array('Sexe','Firstname','Lastname','Email','Status','IdVille','ExportReady');
                
        if(in_array('IdAuthy',$array_search_tb)){$this->arrayIdAuthyOptions = $this->selectBoxAccount_IdAuthy(@$dataObj, @$data);}
        if(in_array('IdVille',$array_search_tb)){$this->arrayIdVilleOptions = $this->selectBoxAccount_IdVille(@$dataObj, @$data);}
        if(in_array('IdRegion',$array_search_tb)){$this->arrayIdRegionOptions = $this->selectBoxAccount_IdRegion(@$dataObj, @$data);}
        if(in_array('IdProvince',$array_search_tb)){$this->arrayIdProvinceOptions = $this->selectBoxAccount_IdProvince(@$dataObj, @$data);}
        if(in_array('IdPays',$array_search_tb)){$this->arrayIdPaysOptions = $this->selectBoxAccount_IdPays(@$dataObj, @$data);}
                unset($data);$data['Sexe'] = (!empty($this->searchMs['Sexe']))?$this->searchMs['Sexe']:'';
        $data['Firstname'] = (!empty($this->searchMs['Firstname']))?$this->searchMs['Firstname']:'';
        $data['Lastname'] = (!empty($this->searchMs['Lastname']))?$this->searchMs['Lastname']:'';
        $data['Email'] = (!empty($this->searchMs['Email']))?$this->searchMs['Email']:'';
        $data['Status'] = (!empty($this->searchMs['Status']))?$this->searchMs['Status']:'';
        $data['IdVille'] = (!empty($this->searchMs['IdVille']))?$this->searchMs['IdVille']:'';
        $data['ExportReady'] = (!empty($this->searchMs['ExportReady']))?$this->searchMs['ExportReady']:'';
        
                
        @$this->fieldsSearch['Account']['Sexe'] =div(selectboxCustomArray('Sexe', array( '0' => array('0'=>_("Homme"), '1'=>'Homme'),'1' => array('0'=>_("Femme"), '1'=>'Femme'), ), _('Sexe'), '  size="1" t="1"   ', $this->searchMs['Sexe']), '', '  class=" ac-search-item ms-Sexe"');
        @$this->fieldsSearch['Account']['Firstname'] = div(input('text', 'Firstname', $this->searchMs['Firstname'], ' othertabs=1  placeholder="'._('Prénom').'"',''),'','class="ac-search-item ms-Firstname"');
        @$this->fieldsSearch['Account']['Lastname'] = div(input('text', 'Lastname', $this->searchMs['Lastname'], ' othertabs=1  placeholder="'._('Nom').'"',''),'','class="ac-search-item ms-Lastname"');
        @$this->fieldsSearch['Account']['Email'] = div(input('text', 'Email', $this->searchMs['Email'], ' othertabs=1  placeholder="'._('Courriel').'"',''),'','class="ac-search-item ms-Email"');
        @$this->fieldsSearch['Account']['Status'] =div(selectboxCustomArray('Status', array( '0' => array('0'=>_("Nouveau"), '1'=>'Nouveau'),'1' => array('0'=>_("Ancien"), '1'=>'Ancien'), ), _('Status'), '  size="1" t="1"   ', $this->searchMs['Status']), '', '  class=" ac-search-item ms-Status"');
        @$this->fieldsSearch['Account']['IdVille'] = div(selectboxCustomArray('IdVille', $this->arrayIdVilleOptions, _('Ville') , "v='ID_VILLE'  s='d' otherTabs=1 ", $this->searchMs['IdVille']), '', ' class="ac-search-item  ms-IdVille"');
        @$this->fieldsSearch['Account']['ExportReady'] =div(selectboxCustomArray('ExportReady', array( '0' => array('0'=>_("Non"), '1'=>'Non'),'1' => array('0'=>_("Oui"), '1'=>'Oui'),'2' => array('0'=>_("À renouveler"), '1'=>'À renouveler'), ), _('Valide pour les concours'), '  size="1" t="1"   ', $this->searchMs['ExportReady']), '', '  class=" ac-search-item ms-ExportReady"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msAccountAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['Account']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msAccountBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msAccountBtClear" class="icon clear"')
               .@$this->fieldsSearch['Account']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['Account']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-AccountSearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['Account']['Start'].
                    $this->fieldsSearch['Account']['Sexe'].
                    $this->fieldsSearch['Account']['Firstname'].
                    $this->fieldsSearch['Account']['Lastname'].
                    $this->fieldsSearch['Account']['Email'].
                    $this->fieldsSearch['Account']['Status'].
                    $this->fieldsSearch['Account']['IdVille'].
                    $this->fieldsSearch['Account']['ExportReady'].
                @$this->fieldsSearch['Account']['End'].
            $this->fieldsSearch['Account']['Button']
            ,"id='formMsAccount' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('Account', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."Account/edit/", "id='addAccount' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addAccountAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Compte");
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
        if(!empty($_SESSION['memoire']['onglet']['Account']['pg'])){
            $page = $_SESSION['memoire']['onglet']['Account']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'AccountAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'AccountAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#AccountListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#AccountListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('Account', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('Account', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('Account', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteAccount' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
                
                
                
                 $titreRaccour =''; $titreRaccour .= _('Compte');
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['ExportReady']) and $altValue['ExportReady'])?$altValue['ExportReady']:isntPo($data->getExportReady())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Valide pour les concours").":\" j='editAccount'  i='".json_encode($data->getPrimaryKey())."' c='ExportReady'  ")
                            .td(span(strip_tags((isset($altValue['Firstname']) and $altValue['Firstname'])?$altValue['Firstname']:$data->getFirstname()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Prénom").":\" j='editAccount'  i='".json_encode($data->getPrimaryKey())."' c='Firstname'  ")
                            .td(span(strip_tags((isset($altValue['Lastname']) and $altValue['Lastname'])?$altValue['Lastname']:$data->getLastname()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Nom").":\" j='editAccount'  i='".json_encode($data->getPrimaryKey())."' c='Lastname'  ")
                            .td(span(strip_tags((isset($altValue['Email']) and $altValue['Email'])?$altValue['Email']:$data->getEmail()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Courriel").":\" j='editAccount'  i='".json_encode($data->getPrimaryKey())."' c='Email'  ")
                            .td(span(strip_tags((isset($altValue['DateExpire']) and $altValue['DateExpire'])?$altValue['DateExpire']:$data->getDateExpire()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Date d'expiration").":\" j='editAccount'  i='".json_encode($data->getPrimaryKey())."' c='DateExpire'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='AccountRow".$data->getPrimaryKey()."'
                    data-table='Account' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountAccount', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Compte';

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
                            ,'','id="AccountPagination"')
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
                .div($controlsContent.$this->CcCustomControl,'AccountControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='AccountTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'AccountListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#AccountListForm [j='deleteAccount']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Compte'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msAccountBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msAccountBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#AccountListForm tr[ecf=1] td[j='editAccount']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."Account/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."Account/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Account'
                ,'IdAccount'
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
        $(\"#AccountListForm [j='deleteAccount']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Compte'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msAccountBt\').length>0){ $(\'#msAccountBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'AccountTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntAccountListForm #addAccount').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'AccountTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#AccountListForm tr[ecf=1] td[j='editAccount']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'AccountTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Account'
                ,'IdAccount'
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
        pagination_bind('Account','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#AccountListForm [j='deleteAccount']\").unbind('click');
        $('#AccountListForm #addAccount').unbind('click');
        $(\"#AccountListForm tr[ecf=1] td[j='editAccount']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#AccountListForm [j='button']\").unbind();   
        pagination_sorted_bind('Account','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('Account','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('Account','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_Account($data){

        unset($data['IdAccount']);
        $e = new Account();
        
        
        if($data['Couple'] == ''){unset($data['Couple']);}
        if(!@$data['Status']){$data['Status'] = "Nouveau";} 
        if(!@$data['ExportReady']){$data['ExportReady'] = "Non";} 
        if(!@$data['ExportStatus']){$data['ExportStatus'] = "Non";} 
        if($data['Sexe'] == ''){unset($data['Sexe']);}
        if(!@$data['Proprietaire']){$data['Proprietaire'] = "Propriétaire";} 
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setStripeCustomer(($data['StripeCustomer']=='')?null:$data['StripeCustomer']);
        $e->setStripeSubscription(($data['StripeSubscription']=='')?null:$data['StripeSubscription']);
        $e->setCouple(($data['Couple']=='')?null:$data['Couple']);
        $e->setSexe(($data['Sexe']=='')?null:$data['Sexe']);
        $e->setDateExpire( ($data['DateExpire'] == '' || $data['DateExpire'] == 'null' || substr($data['DateExpire'],0,10) == '-0001-11-30')?null:$data['DateExpire'] );
        $e->setOtherPhone(($data['OtherPhone']=='')?null:$data['OtherPhone']);
        $e->setCellphone(($data['Cellphone']=='')?null:$data['Cellphone']);
        $e->setExtPhone(($data['ExtPhone']=='')?null:$data['ExtPhone']);
        $e->setApp(($data['App']=='')?null:$data['App']);
        $e->setIdRegion(($data['IdRegion']=='')?null:$data['IdRegion']);
        $e->setNote(($data['Note']=='')?null:$data['Note']);
        $e->setWorkplace(($data['Workplace']=='')?null:$data['Workplace']);
        $e->setWork(($data['Work']=='')?null:$data['Work']);
        $e->setPasswordContest(($data['PasswordContest']=='')?null:$data['PasswordContest']);
        $e->setCinocheUsername(($data['CinocheUsername']=='')?null:$data['CinocheUsername']);
        $e->setHersheyUsername(($data['HersheyUsername']=='')?null:$data['HersheyUsername']);
        $e->setHersheyPassword(($data['HersheyPassword']=='')?null:$data['HersheyPassword']);
        $e->setCantonUsername(($data['CantonUsername']=='')?null:$data['CantonUsername']);
        $e->setPresseUsername(($data['PresseUsername']=='')?null:$data['PresseUsername']);
        $e->setHbcCard(($data['HbcCard']=='')?null:$data['HbcCard']);
        $e->setMillipleinCard(($data['MillipleinCard']=='')?null:$data['MillipleinCard']);
        $e->setMetroCard(($data['MetroCard']=='')?null:$data['MetroCard']);
        $e->setCinochePassword(($data['CinochePassword']=='')?null:$data['CinochePassword']);
        $e->setHotmailPassword(($data['HotmailPassword']=='')?null:$data['HotmailPassword']);
        $e->setFacebookUsername(($data['FacebookUsername']=='')?null:$data['FacebookUsername']);
        $e->setFacebookPassword(($data['FacebookPassword']=='')?null:$data['FacebookPassword']);
        $e->setCasaUsername(($data['CasaUsername']=='')?null:$data['CasaUsername']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_Account($data){

        
        $e = AccountQuery::create()->findPk(json_decode($data['i']));
        
        
        if($data['Couple'] == ''){unset($data['Couple']);}
        if(!@$data['Status']){$data['Status'] = "Nouveau";} 
        if(!@$data['ExportReady']){$data['ExportReady'] = "Non";} 
        if(!@$data['ExportStatus']){$data['ExportStatus'] = "Non";} 
        if($data['Sexe'] == ''){unset($data['Sexe']);}
        if(!@$data['Proprietaire']){$data['Proprietaire'] = "Propriétaire";} 
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['Couple'])){$e->setCouple(($data['Couple']=='')?null:$data['Couple']);}
        if(isset($data['Sexe'])){$e->setSexe(($data['Sexe']=='')?null:$data['Sexe']);}
        if(isset($data['DateExpire'])){$e->setDateExpire( ($data['DateExpire'] == '' || $data['DateExpire'] == 'null' || substr($data['DateExpire'],0,10) == '-0001-11-30')?NULL:$data['DateExpire'] );}
        if(isset($data['IdRegion'])){$e->setIdRegion(($data['IdRegion']=='')?null:$data['IdRegion']);}
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of Account
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
        $je= "AccountTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['Account']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['Account']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addAccount_child').bind('click.addAccount', function (){
                    $.post('"._SITE_URL."mod/act/AccountAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addAccount_child').bind('click.addAccount', function (){
                document.location= '"._SITE_URL."Account/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = AccountQuery::create()->joinWith('Authy') ->joinWith('Ville') ->leftJoin('Region') ->joinWith('Province') ->joinWith('Pays');
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Account', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Account','w',$dataObj)) 
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
                    $('#formAccount #saveAccount').removeAttr('disabled');
                    $('#formAccount #saveAccount').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formAccount #saveAccount').css('cursor', 'default');
                    if($('#formAccount #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formAccount #saveAccount').bind('click.saveAccount', function (data){
                    $('#formAccount #saveAccount').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formAccount #saveAccount').css('cursor', 'progress');
                    $('#formAccount #saveAccount').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formAccount .tinymce').each(function(index) {
                        eval(' $(\"#formAccount #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formAccount select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formAccount\").find(\"[s='d']\").serializeArray();
                        $('#formAccount select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formAccount\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/AccountAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formAccount #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formAccount #formChangedAccount').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formAccount #saveAccount').unbind('click.saveAccount');
                $('#formAccount #saveAccount').remove();";
        }
        
        if($dataObj == null){
            $this->Account['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Account();
            $this->Account['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }

        ($dataObj->getAuthy())?'':$dataObj->setAuthy( new Authy() );
        ($dataObj->getVille())?'':$dataObj->setVille( new Ville() );
        ($dataObj->getRegion())?'':$dataObj->setRegion( new Region() );
        ($dataObj->getProvince())?'':$dataObj->setProvince( new Province() );
        ($dataObj->getPays())?'':$dataObj->setPays( new Pays() );

        
        $this->arrayIdAuthyOptions = $this->selectBoxAccount_IdAuthy(@$dataObj, @$data);
        $this->arrayIdVilleOptions = $this->selectBoxAccount_IdVille(@$dataObj, @$data);
        $this->arrayIdRegionOptions = $this->selectBoxAccount_IdRegion(@$dataObj, @$data);
        $this->arrayIdProvinceOptions = $this->selectBoxAccount_IdProvince(@$dataObj, @$data);
        $this->arrayIdPaysOptions = $this->selectBoxAccount_IdPays(@$dataObj, @$data);
        
        
        
        
        
        

            $this->fields['Account']['IdAuthy']['html'] = stdFieldRow(htmlLink(_('Usager associé'),'javascript:','  label_lien="IdAuthy"  class="label_link js-label-link" '), selectboxCustomArray('IdAuthy', $this->arrayIdAuthyOptions, _(""), "v='ID_AUTHY'  s='d' otherTabs=1  val='".$dataObj->getIdAuthy()."'", $dataObj->getIdAuthy()), 'IdAuthy', "", @$this->commentsIdAuthy, @$this->commentsIdAuthy_css, '', ' ','no','');

            $this->fields['Account']['Couple']['html'] = stdFieldRow(_("Participation couple"), selectboxCustomArray('Couple', array( '0' => array('0'=>_("Non"), '1'=>'Non'),'1' => array('0'=>_("Oui"), '1'=>'Oui'), ), _('Participation couple'), "s='d' otherTabs=1  ", $dataObj->getCouple()), 'Couple', "", @$this->commentsCouple, @$this->commentsCouple_css, '', ' ','no','');

            $this->fields['Account']['Status']['html'] = stdFieldRow(_("Status"), selectboxCustomArray('Status', array( '0' => array('0'=>_("Nouveau"), '1'=>'Nouveau'),'1' => array('0'=>_("Ancien"), '1'=>'Ancien'), ), "", "s='d' otherTabs=1  ", $dataObj->getStatus()), 'Status', "", @$this->commentsStatus, @$this->commentsStatus_css, '', ' ','no','');

            $this->fields['Account']['ExportReady']['html'] = stdFieldRow(_("Valide pour les concours"), selectboxCustomArray('ExportReady', array( '0' => array('0'=>_("Non"), '1'=>'Non'),'1' => array('0'=>_("Oui"), '1'=>'Oui'),'2' => array('0'=>_("À renouveler"), '1'=>'À renouveler'), ), "", "s='d' otherTabs=1  ", $dataObj->getExportReady()), 'ExportReady', "", @$this->commentsExportReady, @$this->commentsExportReady_css, '', ' ','no','');

            $this->fields['Account']['ExportStatus']['html'] = stdFieldRow(_("Déjà exporté"), selectboxCustomArray('ExportStatus', array( '0' => array('0'=>_("Non"), '1'=>'Non'),'1' => array('0'=>_("Oui"), '1'=>'Oui'), ), "", "s='d' otherTabs=1  ", $dataObj->getExportStatus()), 'ExportStatus', "", @$this->commentsExportStatus, @$this->commentsExportStatus_css, '', ' ','no','');

            $this->fields['Account']['Sexe']['html'] = stdFieldRow(_("Sexe"), selectboxCustomArray('Sexe', array( '0' => array('0'=>_("Homme"), '1'=>'Homme'),'1' => array('0'=>_("Femme"), '1'=>'Femme'), ), _('Sexe'), "s='d' otherTabs=1  ", $dataObj->getSexe()), 'Sexe', "", @$this->commentsSexe, @$this->commentsSexe_css, '', ' ','no','');

            $this->fields['Account']['BirthDate']['html'] = stdFieldRow(_("Date de naissance"), input('text', 'BirthDate',str_replace('"','&quot;',$dataObj->getBirthDate()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Date de naissance'))."' size='35'  v='BIRTH_DATE' s='d' class=''")."", 'BirthDate', "", @$this->commentsBirthDate, @$this->commentsBirthDate_css, '', ' ','no','');

            $this->fields['Account']['Firstname']['html'] = stdFieldRow(_("Prénom"), input('text', 'Firstname',str_replace('"','&quot;',$dataObj->getFirstname()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Prénom'))."' size='69'  v='FIRSTNAME' s='d' class=''")."", 'Firstname', "", @$this->commentsFirstname, @$this->commentsFirstname_css, '', ' ','no','');

            $this->fields['Account']['Lastname']['html'] = stdFieldRow(_("Nom"), input('text', 'Lastname',str_replace('"','&quot;',$dataObj->getLastname()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Nom'))."' size='69'  v='LASTNAME' s='d' class=''")."", 'Lastname', "", @$this->commentsLastname, @$this->commentsLastname_css, '', ' ','no','');

            $this->fields['Account']['Email']['html'] = stdFieldRow(_("Courriel"), input('text', 'Email',str_replace('"','&quot;',$dataObj->getEmail()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Courriel'))."' size='69'  v='EMAIL' s='d' class=''")."", 'Email', "", @$this->commentsEmail, @$this->commentsEmail_css, '', ' ','no','');

            $this->fields['Account']['DateExpire']['html'] = stdFieldRow(_("Date d'expiration"), input('date', 'DateExpire', $dataObj->getDateExpire(), "  otherTabs=1 j='date' placeholder='YYYY-MM-DD' size='10' otherTabs=1  s='d' class=''"), 'DateExpire', "", @$this->commentsDateExpire, @$this->commentsDateExpire_css, '', ' ','no','');

            $this->fields['Account']['HomePhone']['html'] = stdFieldRow(_("Téléphone résidence"), input('text', 'HomePhone',str_replace('"','&quot;',$dataObj->getHomePhone()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Téléphone résidence'))."' size='35'  v='HOME_PHONE' s='d' class=''")."", 'HomePhone', "", @$this->commentsHomePhone, @$this->commentsHomePhone_css, '', ' ','no','');

            $this->fields['Account']['OtherPhone']['html'] = stdFieldRow(_("Autre téléphone"), input('text', 'OtherPhone',str_replace('"','&quot;',$dataObj->getOtherPhone()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Autre téléphone'))."' size='35'  v='OTHER_PHONE' s='d' class=''")."", 'OtherPhone', "", @$this->commentsOtherPhone, @$this->commentsOtherPhone_css, '', ' ','no','');

            $this->fields['Account']['Cellphone']['html'] = stdFieldRow(_("Téléphone cellulaire"), input('text', 'Cellphone',str_replace('"','&quot;',$dataObj->getCellphone()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Téléphone cellulaire'))."' size='35'  v='CELLPHONE' s='d' class=''")."", 'Cellphone', "", @$this->commentsCellphone, @$this->commentsCellphone_css, '', ' ','no','');

            $this->fields['Account']['ExtPhone']['html'] = stdFieldRow(_("Extension"), input('text', 'ExtPhone',str_replace('"','&quot;',$dataObj->getExtPhone()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Extension'))."' size='35'  v='EXT_PHONE' s='d' class=''")."", 'ExtPhone', "", @$this->commentsExtPhone, @$this->commentsExtPhone_css, '', ' ','no','');

            $this->fields['Account']['Reference']['html'] = stdFieldRow(_("Référence"), input('text', 'Reference',str_replace('"','&quot;',$dataObj->getReference()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Référence'))."' size='69'  v='REFERENCE' s='d' class=''")."", 'Reference', "", @$this->commentsReference, @$this->commentsReference_css, '', ' ','no','');

            $this->fields['Account']['Address']['html'] = stdFieldRow(_("Adresse"), input('text', 'Address',str_replace('"','&quot;',$dataObj->getAddress()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Adresse'))."' size='69'  v='ADDRESS' s='d' class=''")."", 'Address', "", @$this->commentsAddress, @$this->commentsAddress_css, '', ' ','no','');

            $this->fields['Account']['App']['html'] = stdFieldRow(_("Appartement"), input('text', 'App',str_replace('"','&quot;',$dataObj->getApp()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Appartement'))."' size='15'  v='APP' s='d' class=''")."", 'App', "", @$this->commentsApp, @$this->commentsApp_css, '', ' ','no','');

            $this->fields['Account']['PostalCode']['html'] = stdFieldRow(_("Code Postal"), input('text', 'PostalCode',str_replace('"','&quot;',$dataObj->getPostalCode()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Code Postal'))."' size='15'  v='POSTAL_CODE' s='d' class=''")."", 'PostalCode', "", @$this->commentsPostalCode, @$this->commentsPostalCode_css, '', ' ','no','');

            $this->fields['Account']['Proprietaire']['html'] = stdFieldRow(_("Propriété"), selectboxCustomArray('Proprietaire', array( '0' => array('0'=>_("Propriétaire"), '1'=>'Propriétaire'),'1' => array('0'=>_("Locataire"), '1'=>'Locataire'), ), "", "s='d' otherTabs=1  ", $dataObj->getProprietaire()), 'Proprietaire', "", @$this->commentsProprietaire, @$this->commentsProprietaire_css, '', ' ','no','');

            $this->fields['Account']['IdVille']['html'] = stdFieldRow(htmlLink(_('Ville'),'javascript:','  label_lien="IdVille"  class="label_link js-label-link" '), selectboxCustomArray('IdVille', $this->arrayIdVilleOptions, _(""), "v='ID_VILLE'  s='d' otherTabs=1  val='".$dataObj->getIdVille()."'", $dataObj->getIdVille()), 'IdVille', "", @$this->commentsIdVille, @$this->commentsIdVille_css, '', ' ','no','');

            $this->fields['Account']['IdRegion']['html'] = stdFieldRow(htmlLink(_('Région'),'javascript:','  label_lien="IdRegion"  class="label_link js-label-link" '), selectboxCustomArray('IdRegion', $this->arrayIdRegionOptions, _(_('Région')), "v='ID_REGION'  s='d' otherTabs=1  val='".$dataObj->getIdRegion()."'", $dataObj->getIdRegion()), 'IdRegion', "", @$this->commentsIdRegion, @$this->commentsIdRegion_css, '', ' ','no','');

            $this->fields['Account']['IdProvince']['html'] = stdFieldRow(htmlLink(_('Province'),'javascript:','  label_lien="IdProvince"  class="label_link js-label-link" '), selectboxCustomArray('IdProvince', $this->arrayIdProvinceOptions, _(""), "v='ID_PROVINCE'  s='d' otherTabs=1  val='".$dataObj->getIdProvince()."'", $dataObj->getIdProvince()), 'IdProvince', "", @$this->commentsIdProvince, @$this->commentsIdProvince_css, '', ' ','no','');

            $this->fields['Account']['IdPays']['html'] = stdFieldRow(htmlLink(_('Pays'),'javascript:','  label_lien="IdPays"  class="label_link js-label-link" '), selectboxCustomArray('IdPays', $this->arrayIdPaysOptions, _(""), "v='ID_PAYS'  s='d' otherTabs=1  val='".$dataObj->getIdPays()."'", $dataObj->getIdPays()), 'IdPays', "", @$this->commentsIdPays, @$this->commentsIdPays_css, '', ' ','no','');

            $this->fields['Account']['Note']['html'] = stdFieldRow(_("Note(s)"), 
        textarea('Note',$dataObj->getNote() ,"placeholder='".str_replace("'","&#39;",_('Note(s)'))."' cols='71' otherTabs=1 v='NOTE' s='d'  class='tinymce' class='' style='' spellcheck='false'"), 'Note', "", @$this->commentsNote, @$this->commentsNote_css, ' istinymce', ' ','no','');

            $this->fields['Account']['Workplace']['html'] = stdFieldRow(_("Lieu de travail"), input('text', 'Workplace',str_replace('"','&quot;',$dataObj->getWorkplace()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Lieu de travail'))."' size='69'  v='WORKPLACE' s='d' class=''")."", 'Workplace', "", @$this->commentsWorkplace, @$this->commentsWorkplace_css, '', ' ','no','');

            $this->fields['Account']['Work']['html'] = stdFieldRow(_("Emploi"), input('text', 'Work',str_replace('"','&quot;',$dataObj->getWork()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Emploi'))."' size='69'  v='WORK' s='d' class=''")."", 'Work', "", @$this->commentsWork, @$this->commentsWork_css, '', ' ','no','');

            $this->fields['Account']['UsernameContest']['html'] = stdFieldRow(_("Compte utilisateur"), input('text', 'UsernameContest',str_replace('"','&quot;',$dataObj->getUsernameContest()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Compte utilisateur'))."' size='69'  v='USERNAME_CONTEST' s='d' class=''")."", 'UsernameContest', "", @$this->commentsUsernameContest, @$this->commentsUsernameContest_css, '', ' ','no','');

            $this->fields['Account']['EmailContest']['html'] = stdFieldRow(_("Courriel pour les concours"), input('text', 'EmailContest',str_replace('"','&quot;',$dataObj->getEmailContest()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Courriel pour les concours'))."' size='69'  v='EMAIL_CONTEST' s='d' class=''")."", 'EmailContest', "", @$this->commentsEmailContest, @$this->commentsEmailContest_css, '', ' ','no','');

            $this->fields['Account']['PasswordEmailContest']['html'] = stdFieldRow(_("Mot de passe du courriel"), input('text', 'PasswordEmailContest',str_replace('"','&quot;',$dataObj->getPasswordEmailContest()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Mot de passe du courriel'))."' size='69'  v='PASSWORD_EMAIL_CONTEST' s='d' class=''")."", 'PasswordEmailContest', "", @$this->commentsPasswordEmailContest, @$this->commentsPasswordEmailContest_css, '', ' ','no','');

            $this->fields['Account']['PasswordContest']['html'] = stdFieldRow(_("Mot de passe pour les concours"), input('text', 'PasswordContest',str_replace('"','&quot;',$dataObj->getPasswordContest()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Mot de passe pour les concours'))."' size='35'  v='PASSWORD_CONTEST' s='d' class=''")."", 'PasswordContest', "", @$this->commentsPasswordContest, @$this->commentsPasswordContest_css, '', ' ','no','');

            $this->fields['Account']['AirMiles']['html'] = stdFieldRow(_("Carte Air Miles"), input('text', 'AirMiles',str_replace('"','&quot;',$dataObj->getAirMiles()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Carte Air Miles'))."' size='69'  v='AIR_MILES' s='d' class=''")."", 'AirMiles', "", @$this->commentsAirMiles, @$this->commentsAirMiles_css, '', ' ','no','');

            $this->fields['Account']['CinocheUsername']['html'] = stdFieldRow(_("Compte Cinoche"), input('text', 'CinocheUsername',str_replace('"','&quot;',$dataObj->getCinocheUsername()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Compte Cinoche'))."' size='69'  v='CINOCHE_USERNAME' s='d' class=''")."", 'CinocheUsername', "", @$this->commentsCinocheUsername, @$this->commentsCinocheUsername_css, '', ' ','no','');

            $this->fields['Account']['HersheyUsername']['html'] = stdFieldRow(_("Compte Hershey"), input('text', 'HersheyUsername',str_replace('"','&quot;',$dataObj->getHersheyUsername()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Compte Hershey'))."' size='69'  v='HERSHEY_USERNAME' s='d' class=''")."", 'HersheyUsername', "", @$this->commentsHersheyUsername, @$this->commentsHersheyUsername_css, '', ' ','no','');

            $this->fields['Account']['HersheyPassword']['html'] = stdFieldRow(_("Mot de passe Hershey"), input('text', 'HersheyPassword',str_replace('"','&quot;',$dataObj->getHersheyPassword()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Mot de passe Hershey'))."' size='35'  v='HERSHEY_PASSWORD' s='d' class=''")."", 'HersheyPassword', "", @$this->commentsHersheyPassword, @$this->commentsHersheyPassword_css, '', ' ','no','');

            $this->fields['Account']['CantonUsername']['html'] = stdFieldRow(_("Compte Canton de l'Est"), input('text', 'CantonUsername',str_replace('"','&quot;',$dataObj->getCantonUsername()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Compte Canton de l\'Est'))."' size='69'  v='CANTON_USERNAME' s='d' class=''")."", 'CantonUsername', "", @$this->commentsCantonUsername, @$this->commentsCantonUsername_css, '', ' ','no','');

            $this->fields['Account']['PresseUsername']['html'] = stdFieldRow(_("Compte La Presse"), input('text', 'PresseUsername',str_replace('"','&quot;',$dataObj->getPresseUsername()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Compte La Presse'))."' size='69'  v='PRESSE_USERNAME' s='d' class=''")."", 'PresseUsername', "", @$this->commentsPresseUsername, @$this->commentsPresseUsername_css, '', ' ','no','');

            $this->fields['Account']['HbcCard']['html'] = stdFieldRow(_("Carte HBC"), input('text', 'HbcCard',str_replace('"','&quot;',$dataObj->getHbcCard()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Carte HBC'))."' size='69'  v='HBC_CARD' s='d' class=''")."", 'HbcCard', "", @$this->commentsHbcCard, @$this->commentsHbcCard_css, '', ' ','no','');

            $this->fields['Account']['MillipleinCard']['html'] = stdFieldRow(_("Carte Milliplein"), input('text', 'MillipleinCard',str_replace('"','&quot;',$dataObj->getMillipleinCard()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Carte Milliplein'))."' size='69'  v='MILLIPLEIN_CARD' s='d' class=''")."", 'MillipleinCard', "", @$this->commentsMillipleinCard, @$this->commentsMillipleinCard_css, '', ' ','no','');

            $this->fields['Account']['MetroCard']['html'] = stdFieldRow(_("Carte Métro"), 
        textarea('MetroCard',$dataObj->getMetroCard() ,"placeholder='".str_replace("'","&#39;",_('Carte Métro'))."' cols='71' otherTabs=1 v='METRO_CARD' s='d'  class='' style='' spellcheck='false'"), 'MetroCard', "", @$this->commentsMetroCard, @$this->commentsMetroCard_css, ' istinymce', ' ','no','');

            $this->fields['Account']['CinochePassword']['html'] = stdFieldRow(_("Mot de passe (Cinoche)"), input('text', 'CinochePassword',str_replace('"','&quot;',$dataObj->getCinochePassword()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Mot de passe (Cinoche)'))."' size='35'  v='CINOCHE_PASSWORD' s='d' class=''")."", 'CinochePassword', "", @$this->commentsCinochePassword, @$this->commentsCinochePassword_css, '', ' ','no','');

            $this->fields['Account']['HotmailPassword']['html'] = stdFieldRow(_("Mot de passe hotmail"), input('text', 'HotmailPassword',str_replace('"','&quot;',$dataObj->getHotmailPassword()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Mot de passe hotmail'))."' size='35'  v='HOTMAIL_PASSWORD' s='d' class=''")."", 'HotmailPassword', "", @$this->commentsHotmailPassword, @$this->commentsHotmailPassword_css, '', ' ','no','');

            $this->fields['Account']['FacebookUsername']['html'] = stdFieldRow(_("Compte Facebook"), input('text', 'FacebookUsername',str_replace('"','&quot;',$dataObj->getFacebookUsername()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Compte Facebook'))."' size='69'  v='FACEBOOK_USERNAME' s='d' class=''")."", 'FacebookUsername', "", @$this->commentsFacebookUsername, @$this->commentsFacebookUsername_css, '', ' ','no','');

            $this->fields['Account']['FacebookPassword']['html'] = stdFieldRow(_("Mot de passe Facebook"), input('text', 'FacebookPassword',str_replace('"','&quot;',$dataObj->getFacebookPassword()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Mot de passe Facebook'))."' size='35'  v='FACEBOOK_PASSWORD' s='d' class=''")."", 'FacebookPassword', "", @$this->commentsFacebookPassword, @$this->commentsFacebookPassword_css, '', ' ','no','');

            $this->fields['Account']['CasaUsername']['html'] = stdFieldRow(_("Compte Casa"), input('text', 'CasaUsername',str_replace('"','&quot;',$dataObj->getCasaUsername()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Compte Casa'))."' size='69'  v='CASA_USERNAME' s='d' class=''")."", 'CasaUsername', "", @$this->commentsCasaUsername, @$this->commentsCasaUsername_css, '', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->Account['request']['ChildHide']) ){
            
            $ongletTab['0']['t'] = _('Abonnement');
            $ongletTab['0']['p'] = 'Sale';
            $ongletTab['0']['lkey'] = 'IdAccount';
            $ongletTab['0']['fkey'] = 'IdAccount';
        if(!empty($ongletTab) and $dataObj->getIdAccount()){
            foreach($ongletTab as $value){
                if($_SESSION[_AUTH_VAR]->hasRights('Account'.$value['p'], 'r')){
                    
                    $getLocalKey = "get".$value['lkey']."";
                    if($dataObj->$getLocalKey()){
                        @$ChildOnglet .= 
                            li(
 htmlLink(_($value['t']),'javascript:',"p='".$value['p']."' act='list' j=conglet_Account ip='".$dataObj->$getLocalKey()."' class='ui-corner-top ui-state-default' ") 						,"  class='".@$class_has_child."' j=sm  ");
                    }
                }
            }
            if(!empty($ChildOnglet)){
                $childTable['onReadyJs'] ="
                    $('[j=conglet_Account]').unbind('click');
                    $('[j=conglet_Account]').bind('click', function (data){
                         pp = $(this).attr('p');
                         $.post('"._SITE_URL."mod/act/AccountAct.php', {a:'get'+pp+'List', ip:$(this).attr('ip'), ui:  pp+'Table','pui':'".$uiTabsId."',pushPGet:'".json_encode($_GET)."',pushPPOST:'".json_encode($_POST)."'}, function(data){
                            $('#cntAccountChild').html(data).show();;
                            $('[j=conglet_Account]').parent().attr('class','ui-corner-top ui-state-default');
                            $('[j=conglet_Account][p=\"'+pp+'\"]').parent().attr('class','ui-corner-top ui-state-default ui-state-active');
                         });
                    });

                ";
                if(@$_SESSION['memoire']['onglet']['Account']['child']['list'][$dataObj->$getLocalKey()]){
                    $onglet_p = $_SESSION['memoire']['onglet']['Account']['child']['list'][$dataObj->$getLocalKey()];
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Account][p=".$onglet_p."]').first().click();";
                }else{
                    @$childTable['onReadyJs'] .= " $('[j=conglet_Account]').first().click();";
                }


            }
        }
        }
        
        
        if($dataObj->getIdAccount()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'AccountControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = 
            div(
                input('checkbox','toggle-form',' p="Account" ')
                .label(span(_('Afficher/Cacher le formulaire')),'for="toggle-form"')
            ,'','class="toggle-form" p="Account" data-tooltip="'._('Cacher le formulaire').'"');
            }

        }
        
        $ongletf =
            div(
                ul(li(htmlLink(_('Compte'),'#ogf_Account',' j="ogf" p="Account" class="ui-tabs-anchor button-link-blue" ')).li(htmlLink(_('Lieu de résidence'),'#ogf_address',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Account" ')).li(htmlLink(_('Travail'),'#ogf_workplace',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Account" ')).li(htmlLink(_('Informations pour les concours'),'#ogf_username_contest',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Account" ')).li(htmlLink(_('Ancien membre'),'#ogf_hbc_card',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Account" ')))
            ,'cntOngletAccount',' class="cntOnglet"')
            .@$close_form
        ;
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addAccount_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveAccount',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedAccount','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdAccount', $dataObj->getIdAccount(), " otherTabs=1 s='d' pk").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        $mceInclude = loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/ckeditor.js")
            .loadJs(_SRC_URL."js/ckeditor/ckeditor_4.4.5_standard/adapters/jquery.js");
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'AccountControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formAccount');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['Account']['tog']) and 
            $_SESSION['memoire']['onglet']['Account']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['Account']['Start']['html']
                
                .
                    '<div id="ogf_Account">'.
$this->fields['Account']['IdAuthy']['html']
.$this->fields['Account']['Couple']['html']
.$this->fields['Account']['Status']['html']
.$this->fields['Account']['ExportReady']['html']
.$this->fields['Account']['ExportStatus']['html']
.$this->fields['Account']['Sexe']['html']
.$this->fields['Account']['BirthDate']['html']
.$this->fields['Account']['Firstname']['html']
.$this->fields['Account']['Lastname']['html']
.$this->fields['Account']['Email']['html']
.$this->fields['Account']['DateExpire']['html']
.$this->fields['Account']['HomePhone']['html']
.$this->fields['Account']['OtherPhone']['html']
.$this->fields['Account']['Cellphone']['html']
.$this->fields['Account']['ExtPhone']['html']
.$this->fields['Account']['Reference']['html']
.'</div><div id="ogf_address"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Account']['Address']['html']
.$this->fields['Account']['App']['html']
.$this->fields['Account']['PostalCode']['html']
.$this->fields['Account']['Proprietaire']['html']
.$this->fields['Account']['IdVille']['html']
.$this->fields['Account']['IdRegion']['html']
.$this->fields['Account']['IdProvince']['html']
.$this->fields['Account']['IdPays']['html']
.$this->fields['Account']['Note']['html']
.'</div><div id="ogf_workplace"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Account']['Workplace']['html']
.$this->fields['Account']['Work']['html']
.'</div><div id="ogf_username_contest"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Account']['UsernameContest']['html']
.$this->fields['Account']['EmailContest']['html']
.$this->fields['Account']['PasswordEmailContest']['html']
.$this->fields['Account']['PasswordContest']['html']
.$this->fields['Account']['AirMiles']['html']
.$this->fields['Account']['CinocheUsername']['html']
.$this->fields['Account']['HersheyUsername']['html']
.$this->fields['Account']['HersheyPassword']['html']
.$this->fields['Account']['CantonUsername']['html']
.$this->fields['Account']['PresseUsername']['html']
.'</div><div id="ogf_hbc_card"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Account']['HbcCard']['html']
.$this->fields['Account']['MillipleinCard']['html']
.$this->fields['Account']['MetroCard']['html']
.$this->fields['Account']['CinochePassword']['html']
.$this->fields['Account']['HotmailPassword']['html']
.$this->fields['Account']['FacebookUsername']['html']
.$this->fields['Account']['FacebookPassword']['html']
.$this->fields['Account']['CasaUsername']['html'].'</div>'
                
                .@$this->fields['Account']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntAccount", "class='divStdform' CntTabs=1 ")
        , "id='formAccount' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Compte"); }
        # if not new, show child table
        if($dataObj->getIdAccount()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelAccount', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntAccountChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['Account']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['Account']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['Account']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    bind_close_form();
    
    ".$jqueryDatePicker."
    bind_ui_active('Account');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    $('#formAccount .tinymce').each(function() {
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
    $(\"[label_lien='IdAuthy']\").bind('click', function (){
        if($('#IdAuthy').val()){ window.open('"._SITE_URL."Authy/edit/'+$('#IdAuthy').val());}else{window.open('"._SITE_URL."Authy/list/');}
    });
    $(\"[label_lien='IdVille']\").bind('click', function (){
        if($('#IdVille').val()){ window.open('"._SITE_URL."Ville/edit/'+$('#IdVille').val());}else{window.open('"._SITE_URL."Ville/list/');}
    });
    $(\"[label_lien='IdRegion']\").bind('click', function (){
        if($('#IdRegion').val()){ window.open('"._SITE_URL."Region/edit/'+$('#IdRegion').val());}else{window.open('"._SITE_URL."Region/list/');}
    });
    $(\"[label_lien='IdProvince']\").bind('click', function (){
        if($('#IdProvince').val()){ window.open('"._SITE_URL."Province/edit/'+$('#IdProvince').val());}else{window.open('"._SITE_URL."Province/list/');}
    });
    $(\"[label_lien='IdPays']\").bind('click', function (){
        if($('#IdPays').val()){ window.open('"._SITE_URL."Pays/edit/'+$('#IdPays').val());}else{window.open('"._SITE_URL."Pays/list/');}
    });$('#cntOngletAccount').parent().tabs();$('#cntOngletAccount').show();
    ".@$childTable['onReadyJs']."
    ".@$error['onReadyJs']."
    ".@$removeEditChild."
    /*try {afterFormLoad();}catch(e){}*/
    if($('#loader').css('display') == 'block') $('#loader').hide();
    $('[j=sftr]').hide();
    ".@$tabs_act."
    ".$this->CcToFormJs
    .@$script_autoc_one."
     setTimeout(function(){ bind_othertabs_std('#divCntAccount');},500); 
    ".$toggleForm."
    bind_form('Account','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
        ($dataObj->getAuthy())?'':$dataObj->setAuthy( new Authy() );
        ($dataObj->getVille())?'':$dataObj->setVille( new Ville() );
        ($dataObj->getRegion())?'':$dataObj->setRegion( new Region() );
        ($dataObj->getProvince())?'':$dataObj->setProvince( new Province() );
        ($dataObj->getPays())?'':$dataObj->setPays( new Pays() );
            
        $this->fieldsRo['Account']['IdAuthy']['html'] = stdFieldRow(htmlLink(_('Usager associé'),'javascript:','  label_lien="IdAuthy"  class="label_link js-label-link" '), 
                    input('text','IdAuthyLabel',$dataObj->getAuthy()->getUsername(),"  readonly s='d'")
                    .input('hidden','IdAuthy',$dataObj->getIdAuthy()," readonly s='d'"), 'IdAuthy', "", @$this->commentsIdAuthy, @$this->commentsIdAuthy_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['Couple']['html'] = stdFieldRow(_("Participation couple"), input('text','Couple',$dataObj->getCouple()," readonly s='d'"), 'Couple', "", @$this->commentsCouple, @$this->commentsCouple_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['Status']['html'] = stdFieldRow(_("Status"), input('text','Status',$dataObj->getStatus()," readonly s='d'"), 'Status', "", @$this->commentsStatus, @$this->commentsStatus_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['ExportReady']['html'] = stdFieldRow(_("Valide pour les concours"), input('text','ExportReady',$dataObj->getExportReady()," readonly s='d'"), 'ExportReady', "", @$this->commentsExportReady, @$this->commentsExportReady_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['ExportStatus']['html'] = stdFieldRow(_("Déjà exporté"), input('text','ExportStatus',$dataObj->getExportStatus()," readonly s='d'"), 'ExportStatus', "", @$this->commentsExportStatus, @$this->commentsExportStatus_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['Sexe']['html'] = stdFieldRow(_("Sexe"), input('text','Sexe',$dataObj->getSexe()," readonly s='d'"), 'Sexe', "", @$this->commentsSexe, @$this->commentsSexe_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['BirthDate']['html'] = stdFieldRow(_("Date de naissance"), input('text','BirthDate',$dataObj->getBirthDate()," readonly s='d'"), 'BirthDate', "", @$this->commentsBirthDate, @$this->commentsBirthDate_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['Firstname']['html'] = stdFieldRow(_("Prénom"), input('text','Firstname',$dataObj->getFirstname()," readonly s='d'"), 'Firstname', "", @$this->commentsFirstname, @$this->commentsFirstname_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['Lastname']['html'] = stdFieldRow(_("Nom"), input('text','Lastname',$dataObj->getLastname()," readonly s='d'"), 'Lastname', "", @$this->commentsLastname, @$this->commentsLastname_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['Email']['html'] = stdFieldRow(_("Courriel"), input('text','Email',$dataObj->getEmail()," readonly s='d'"), 'Email', "", @$this->commentsEmail, @$this->commentsEmail_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['DateExpire']['html'] = stdFieldRow(_("Date d'expiration"), input('text','DateExpire',$dataObj->getDateExpire()," readonly s='d'"), 'DateExpire', "", @$this->commentsDateExpire, @$this->commentsDateExpire_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['HomePhone']['html'] = stdFieldRow(_("Téléphone résidence"), input('text','HomePhone',$dataObj->getHomePhone()," readonly s='d'"), 'HomePhone', "", @$this->commentsHomePhone, @$this->commentsHomePhone_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['OtherPhone']['html'] = stdFieldRow(_("Autre téléphone"), input('text','OtherPhone',$dataObj->getOtherPhone()," readonly s='d'"), 'OtherPhone', "", @$this->commentsOtherPhone, @$this->commentsOtherPhone_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['Cellphone']['html'] = stdFieldRow(_("Téléphone cellulaire"), input('text','Cellphone',$dataObj->getCellphone()," readonly s='d'"), 'Cellphone', "", @$this->commentsCellphone, @$this->commentsCellphone_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['ExtPhone']['html'] = stdFieldRow(_("Extension"), input('text','ExtPhone',$dataObj->getExtPhone()," readonly s='d'"), 'ExtPhone', "", @$this->commentsExtPhone, @$this->commentsExtPhone_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['Reference']['html'] = stdFieldRow(_("Référence"), input('text','Reference',$dataObj->getReference()," readonly s='d'"), 'Reference', "", @$this->commentsReference, @$this->commentsReference_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['Address']['html'] = stdFieldRow(_("Adresse"), input('text','Address',$dataObj->getAddress()," readonly s='d'"), 'Address', "", @$this->commentsAddress, @$this->commentsAddress_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['App']['html'] = stdFieldRow(_("Appartement"), input('text','App',$dataObj->getApp()," readonly s='d'"), 'App', "", @$this->commentsApp, @$this->commentsApp_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['PostalCode']['html'] = stdFieldRow(_("Code Postal"), input('text','PostalCode',$dataObj->getPostalCode()," readonly s='d'"), 'PostalCode', "", @$this->commentsPostalCode, @$this->commentsPostalCode_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['Proprietaire']['html'] = stdFieldRow(_("Propriété"), input('text','Proprietaire',$dataObj->getProprietaire()," readonly s='d'"), 'Proprietaire', "", @$this->commentsProprietaire, @$this->commentsProprietaire_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['IdVille']['html'] = stdFieldRow(htmlLink(_('Ville'),'javascript:','  label_lien="IdVille"  class="label_link js-label-link" '), 
                    input('text','IdVilleLabel',$dataObj->getVille()->getTitle(),"  readonly s='d'")
                    .input('hidden','IdVille',$dataObj->getIdVille()," readonly s='d'"), 'IdVille', "", @$this->commentsIdVille, @$this->commentsIdVille_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['IdRegion']['html'] = stdFieldRow(htmlLink(_('Région'),'javascript:','  label_lien="IdRegion"  class="label_link js-label-link" '), 
                    input('text','IdRegionLabel',$dataObj->getRegion()->getTitle(),"  readonly s='d'")
                    .input('hidden','IdRegion',$dataObj->getIdRegion()," readonly s='d'"), 'IdRegion', "", @$this->commentsIdRegion, @$this->commentsIdRegion_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['IdProvince']['html'] = stdFieldRow(htmlLink(_('Province'),'javascript:','  label_lien="IdProvince"  class="label_link js-label-link" '), 
                    input('text','IdProvinceLabel',$dataObj->getProvince()->getTitle(),"  readonly s='d'")
                    .input('hidden','IdProvince',$dataObj->getIdProvince()," readonly s='d'"), 'IdProvince', "", @$this->commentsIdProvince, @$this->commentsIdProvince_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['IdPays']['html'] = stdFieldRow(htmlLink(_('Pays'),'javascript:','  label_lien="IdPays"  class="label_link js-label-link" '), 
                    input('text','IdPaysLabel',$dataObj->getPays()->getTitle(),"  readonly s='d'")
                    .input('hidden','IdPays',$dataObj->getIdPays()," readonly s='d'"), 'IdPays', "", @$this->commentsIdPays, @$this->commentsIdPays_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['Note']['html'] = stdFieldRow(_("Note(s)"), textarea('Note',$dataObj->getNote()," readonly class='tinymce'    s='d'"), 'Note', "", @$this->commentsNote, @$this->commentsNote_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Account']['Workplace']['html'] = stdFieldRow(_("Lieu de travail"), input('text','Workplace',$dataObj->getWorkplace()," readonly s='d'"), 'Workplace', "", @$this->commentsWorkplace, @$this->commentsWorkplace_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['Work']['html'] = stdFieldRow(_("Emploi"), input('text','Work',$dataObj->getWork()," readonly s='d'"), 'Work', "", @$this->commentsWork, @$this->commentsWork_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['UsernameContest']['html'] = stdFieldRow(_("Compte utilisateur"), input('text','UsernameContest',$dataObj->getUsernameContest()," readonly s='d'"), 'UsernameContest', "", @$this->commentsUsernameContest, @$this->commentsUsernameContest_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['EmailContest']['html'] = stdFieldRow(_("Courriel pour les concours"), input('text','EmailContest',$dataObj->getEmailContest()," readonly s='d'"), 'EmailContest', "", @$this->commentsEmailContest, @$this->commentsEmailContest_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['PasswordEmailContest']['html'] = stdFieldRow(_("Mot de passe du courriel"), input('text','PasswordEmailContest',$dataObj->getPasswordEmailContest()," readonly s='d'"), 'PasswordEmailContest', "", @$this->commentsPasswordEmailContest, @$this->commentsPasswordEmailContest_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['PasswordContest']['html'] = stdFieldRow(_("Mot de passe pour les concours"), input('text','PasswordContest',$dataObj->getPasswordContest()," readonly s='d'"), 'PasswordContest', "", @$this->commentsPasswordContest, @$this->commentsPasswordContest_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['AirMiles']['html'] = stdFieldRow(_("Carte Air Miles"), input('text','AirMiles',$dataObj->getAirMiles()," readonly s='d'"), 'AirMiles', "", @$this->commentsAirMiles, @$this->commentsAirMiles_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['CinocheUsername']['html'] = stdFieldRow(_("Compte Cinoche"), input('text','CinocheUsername',$dataObj->getCinocheUsername()," readonly s='d'"), 'CinocheUsername', "", @$this->commentsCinocheUsername, @$this->commentsCinocheUsername_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['HersheyUsername']['html'] = stdFieldRow(_("Compte Hershey"), input('text','HersheyUsername',$dataObj->getHersheyUsername()," readonly s='d'"), 'HersheyUsername', "", @$this->commentsHersheyUsername, @$this->commentsHersheyUsername_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['HersheyPassword']['html'] = stdFieldRow(_("Mot de passe Hershey"), input('text','HersheyPassword',$dataObj->getHersheyPassword()," readonly s='d'"), 'HersheyPassword', "", @$this->commentsHersheyPassword, @$this->commentsHersheyPassword_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['CantonUsername']['html'] = stdFieldRow(_("Compte Canton de l'Est"), input('text','CantonUsername',$dataObj->getCantonUsername()," readonly s='d'"), 'CantonUsername', "", @$this->commentsCantonUsername, @$this->commentsCantonUsername_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['PresseUsername']['html'] = stdFieldRow(_("Compte La Presse"), input('text','PresseUsername',$dataObj->getPresseUsername()," readonly s='d'"), 'PresseUsername', "", @$this->commentsPresseUsername, @$this->commentsPresseUsername_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['HbcCard']['html'] = stdFieldRow(_("Carte HBC"), input('text','HbcCard',$dataObj->getHbcCard()," readonly s='d'"), 'HbcCard', "", @$this->commentsHbcCard, @$this->commentsHbcCard_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['MillipleinCard']['html'] = stdFieldRow(_("Carte Milliplein"), input('text','MillipleinCard',$dataObj->getMillipleinCard()," readonly s='d'"), 'MillipleinCard', "", @$this->commentsMillipleinCard, @$this->commentsMillipleinCard_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['MetroCard']['html'] = stdFieldRow(_("Carte Métro"), textarea('MetroCard',$dataObj->getMetroCard()," readonly class=''    s='d'"), 'MetroCard', "", @$this->commentsMetroCard, @$this->commentsMetroCard_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['Account']['CinochePassword']['html'] = stdFieldRow(_("Mot de passe (Cinoche)"), input('text','CinochePassword',$dataObj->getCinochePassword()," readonly s='d'"), 'CinochePassword', "", @$this->commentsCinochePassword, @$this->commentsCinochePassword_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['HotmailPassword']['html'] = stdFieldRow(_("Mot de passe hotmail"), input('text','HotmailPassword',$dataObj->getHotmailPassword()," readonly s='d'"), 'HotmailPassword', "", @$this->commentsHotmailPassword, @$this->commentsHotmailPassword_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['FacebookUsername']['html'] = stdFieldRow(_("Compte Facebook"), input('text','FacebookUsername',$dataObj->getFacebookUsername()," readonly s='d'"), 'FacebookUsername', "", @$this->commentsFacebookUsername, @$this->commentsFacebookUsername_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['FacebookPassword']['html'] = stdFieldRow(_("Mot de passe Facebook"), input('text','FacebookPassword',$dataObj->getFacebookPassword()," readonly s='d'"), 'FacebookPassword', "", @$this->commentsFacebookPassword, @$this->commentsFacebookPassword_css, 'readonly', ' ','no','');
$this->fieldsRo['Account']['CasaUsername']['html'] = stdFieldRow(_("Compte Casa"), input('text','CasaUsername',$dataObj->getCasaUsername()," readonly s='d'"), 'CasaUsername', "", @$this->commentsCasaUsername, @$this->commentsCasaUsername_css, 'readonly', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['Account'] as $field=>$ar){
                $this->fields['Account'][$field]['html'] = $this->fieldsRo['Account'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['Account'][$field]['html'] = $this->fieldsRo['Account'][$field]['html'];
            }
        }
    }
    /*Option function for Account_IdAuthy selectBox */
    public function selectBoxAccount_IdAuthy($dataObj='',$data='', $emptyVal=false,$array=true){
$q = AuthyQuery::create();

    $q->addAsColumn('selDisplay', 'CONCAT_WS ( " ", authy.username, "" )');
    $q->select(array('selDisplay', 'IdAuthy'));
    $q->orderBy('selDisplay', 'ASC');
if(!$array){return $q;}else{$pcDataO = $q->find();}


$arrayOpt = $pcDataO->toArray();
return assocToNum($arrayOpt , true);
}
    /*Option function for Account_IdVille selectBox */
    public function selectBoxAccount_IdVille($dataObj='',$data='', $emptyVal=false,$array=true){
$q = VilleQuery::create();

    $q->addAsColumn('selDisplay', 'CONCAT_WS ( " ", ville.title, "" )');
    $q->select(array('selDisplay', 'IdVille'));
    $q->orderBy('selDisplay', 'ASC');
if(!$array){return $q;}else{$pcDataO = $q->find();}


$arrayOpt = $pcDataO->toArray();
return assocToNum($arrayOpt , true);
}
    /*Option function for Account_IdRegion selectBox */
    public function selectBoxAccount_IdRegion($dataObj='',$data='', $emptyVal=false,$array=true){
$q = RegionQuery::create();

    $q->addAsColumn('selDisplay', 'CONCAT_WS ( " ", region.title, "" )');
    $q->select(array('selDisplay', 'IdRegion'));
    $q->orderBy('selDisplay', 'ASC');
if(!$array){return $q;}else{$pcDataO = $q->find();}


$arrayOpt = $pcDataO->toArray();
return assocToNum($arrayOpt , true);
}
    /*Option function for Account_IdProvince selectBox */
    public function selectBoxAccount_IdProvince($dataObj='',$data='', $emptyVal=false,$array=true){
$q = ProvinceQuery::create();

    $q->addAsColumn('selDisplay', 'CONCAT_WS ( " ", province.title, "" )');
    $q->select(array('selDisplay', 'IdProvince'));
    $q->orderBy('selDisplay', 'ASC');
if(!$array){return $q;}else{$pcDataO = $q->find();}


$arrayOpt = $pcDataO->toArray();
return assocToNum($arrayOpt , true);
}
    /*Option function for Account_IdPays selectBox */
    public function selectBoxAccount_IdPays($dataObj='',$data='', $emptyVal=false,$array=true){
$q = PaysQuery::create();

    $q->addAsColumn('selDisplay', 'CONCAT_WS ( " ", pays.title, "" )');
    $q->select(array('selDisplay', 'IdPays'));
    $q->orderBy('selDisplay', 'ASC');
if(!$array){return $q;}else{$pcDataO = $q->find();}


$arrayOpt = $pcDataO->toArray();
return assocToNum($arrayOpt , true);
}
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = AccountQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Email', 'IdAccount'));
            
        
        }else{
            $q->select(array('Email', 'IdAccount'));
        }
        $pcData = $q->orderBy('Email', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = AccountQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Email', 'IdAccount'));
            
        
        }else{
            $q->select(array('Email', 'IdAccount'));
        }
        $pcData = $q->orderBy('Email', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Compte')), $selected);
        }


        return $return;
    }	#@#############
    #	getChildList
    ###############
    public function getSaleList($IdAccount, $page='1', $uiTabsId='SaleTableCntnr', $parentContainer='', $mja_list='', $search='', $params = ''){
        /*init var*/
        global $request;
        if(empty($page)){$page=1;}$param=array();
        if(!empty($_SESSION['memoire']['onglet']['AccountSale']['pg'])){$page = $_SESSION['memoire']['onglet']['AccountSale']['pg'];}
        if(!empty($search['order'])){$this->searchOrder = $search['order'];}
        
        if(empty($search['ms'])){ $searchAr =$search;}else{$this->searchMs = $search['ms']; }

        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    @$child_order .="
                        $(\"#cntAccountChild [th='sorted'][c='".$col."'],#cntAccountChild [th='sorted'][rc='".$col."']\").attr('sens','".$sens."');
                        $(\"#cntAccountChild [th='sorted'][c='".$col."'],#cntAccountChild [th='sorted'][rc='".$col."']\").attr('order','on');
                    ";
                }
            }
        }
        
        if($parentContainer == 'editDialog'){$diagNoClose = "diag:\"noclose\", ";$diagNoCloseEscaped = "diag:\\\"noclose\\\", ";}
        if(isset($this->Account['request']['noHeader']) && $this->Account['request']['noHeader'] == 'true'){$noHeader = "'noHeader':'true',";}
        $data['IdAccount'] = $IdAccount;

        $dataObj = AccountQuery::create()->findPk($IdAccount);
        if($dataObj == null){$dataObj = new Account();$dataObj->setIdAccount($IdAccount);}
        $this->dataObj =$dataObj;
        

        $this->Sale['list_add'] = "
        $('#addSale').click(function(){
            $.post('"._SITE_URL."mod/act/SaleAct.php', {a:'edit', ui:'editDialog',pc:'Account', je:'SaleTableCntnr', jet:'tr', tp:'Sale', ip:'".$IdAccount."'},
                function(data){ $('#editDialog').html(data); beforeOpenDialog('editDialog'); $('#editDialog').dialog('option','title','".addSlashes(_('Abonnement'))."'); });
        });";
        $this->Sale['list_delete'] = "
        $(\"[j='deleteSale']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Abonnement'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."','$.post(\""._SITE_URL."mod/act/SaleAct.php\", {".@$diagNoCloseEscaped.@$diagNoClose." a:\"delete\", ui:\"".$uiTabsId."\", i:'+$(this).attr('i')+', ip:\"".$IdAccount."\", pc:\"Account\", je:\"SaleTableCntnr\", jet:\"tr\"}, function(data){ if(data)$(\"#SaleTableCntnr\").append(data);});');
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('AccountSale', 'r')){ $this->Sale['list_edit'] = "
        $(\"#SaleTable[listchild=1] tr[ecf=1] td[j='editSale']\").bind('click', function (){
            location.href = '"._SITE_URL."Sale/edit/'+$(this).attr('i')+'?tp=Sale&ip=".$IdAccount."&pc=Account';
        });";}
        $rigthButtonAction="";
        if($_SESSION[_AUTH_VAR]->hasRights('AccountSale', 'w')){
            $rigthButtonAction='';
        }
        $filterKey = $IdAccount;
        
        $maxPerPage = (!empty($this->Sale['request']['maxperpage']))?$this->Sale['request']['maxperpage']:_paging_nbr_per_page;
        try{
            $q = SaleQuery::create();
            
            
            $q 
->joinWith('Account') ->filterByIdAccount( $filterKey );;  
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
        
        
        
        
        
        
        if(isset($this->Account['request']['noHeader']) && $this->Account['request']['noHeader'] == 'true'){
            $header_search = "";
        }else{
            $header_search = ''
        .div(
            
            form('' , " CntTabs=1 id='formMsSale'")
        ,'',' class="msSearchCtnr"')
        .div($rigthButtonAction, '', 'class="ac-right-action-buttons"')
        .button(span(_("Afficher le menu"),'data-tooltip="'.addslashes("Afficher le menu").'" '),'class="toggle-child-nav-btn"');
        }
        
        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('AccountSale', 'd') and empty($this->readOnlyFilter)){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( @$this->cCmoreColsHeaderFirstSale.th(_("Compte"), " th='sorted'  rcColone='IdAccount' c='Account.Email' rc='Account.Email' ").th(_("Date de création"), " th='sorted'  rcColone='Date' c='Date'  ").th(_("Statut"), " th='sorted'  rcColone='Statut' c='Statut'  ").$this->cCmoreColsHeaderSale.$actionRowHeader, " ln='Sale' class=''");
        $i=0;
        if(empty($pmpoData) || !method_exists($pmpoData,'isEmpty')){
            @$tr .= tr(	td(p(span(_("Une erreur est survenue veuillez vider votre recherche.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='Sale' colspan='100%' "));
            
        }else if( $pmpoData->isEmpty() ){
            @$tr .= tr(	td(p(span(_("Aucun enregistrement pour le moment.")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='Sale' colspan='100%' "));
            
        }else{
            
            foreach($pmpoData as $data){
                
                
                $actionRow = '';
                
                $this->ListActionRowSale = (!empty($this->cCListActionRowSale))?str_replace('%idpk%', json_encode($data->getPrimaryKey()), $this->cCListActionRowSale):$this->ListActionRowSale;
                $this->ListActionRowSale = (!empty($this->cCListActionRowSale))?str_replace('%i%', $i, $this->ListActionRowSale):$this->ListActionRowSale;
                
                if($_SESSION[_AUTH_VAR]->hasRights('AccountSale', 'd') and empty($this->readOnlyFilter) ){$actionRow = htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteSale' i='".json_encode($data->getPrimaryKey())."'");}
                
                
                
                

                $actionRow = $actionRow;
                $addClass='';
                $cnt= substr_count($actionRow,'<a');
                if($cnt){ $addClass=' actionrow'.$cnt;}
                $actionRow = (!empty($actionRow))?td($this->ListActionRowSale.$actionRow," class='actionrow ".$addClass."'"):"";
                
        $altValue['Account_Email'] = "";
        if($data->getAccount()){
            $altValue['Account_Email'] = $data->getAccount()->getEmail();
        }
                
                
                ;
                
                if(isset($this->search['highlight']) && is_array($this->search['highlight'])){
                    $highlight = (in_array(json_encode($data->getPrimaryKey()), $this->search['highlight']))?'highlight':'';
                }
                
                $child_edit_columns_filter ="1";
    
                @$tr .= 
                        tr(
                            @$cCmoreColsSaleFirst.
                            td(span(strip_tags((isset($altValue['IdAccount']) and $altValue['IdAccount'])?$altValue['IdAccount']:$altValue['Account_Email']." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Compte").":\" j='editSale'  i='".json_encode($data->getPrimaryKey())."' c='IdAccount'  ")
                            .td(span(strip_tags((isset($altValue['Date']) and $altValue['Date'])?$altValue['Date']:$data->getDate()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Date de création").":\" j='editSale'  i='".json_encode($data->getPrimaryKey())."' c='Date'  ")
                            .td(span(strip_tags((isset($altValue['Statut']) and $altValue['Statut'])?$altValue['Statut']:isntPo($data->getStatut())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Statut").":\" j='editSale'  i='".json_encode($data->getPrimaryKey())."' c='Statut'  ")
                            .
                            
                            @$cCmoreColsSale.
                            @$actionRow
                        ,"id='SaleRow".$data->getPrimaryKey()."' data-id='".$data->getPrimaryKey()."' data-pc-table='Account' data-table='Sale' data-edit='Abonnement #".$data->getPrimaryKey()."' ecf='".$child_edit_columns_filter."' ln='Sale' class=' ".@$highlight.@$param['class']."'  ")
                        ;
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(div(@$total_child,'','class="nolink"')
                            ,'trSale'," style='".@$hide_Sale."' ln='Sale' class=''").@$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    
    if(($_SESSION[_AUTH_VAR]->hasRights('AccountSale', 'a')) ){
        $add_button_child =htmlLink(span(_("Ajouter")), "Javascript:","id='addSale' class='button-link-blue add-button'");
    }
    
    
    //@PAGINATION
    if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
        $ext = '';
        $table_name = 'abonnement';
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
                    ,'','id="SalePagination"')
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
                 $this->CcToSaleListTop
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
                                    .$this->CcToSaleTableFooter
                                , "id='SaleTable' listchild=1 class='tablesorter'")
                            , 'formSale')
                            .$this->CcToSaleListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list contentHolderList" ')

                    .@$pagerRow
                ,'SaleListForm')
            ,'cntSaledivChild',' class="" ');
            
            
            $jqueryDatePickerChild = "beforeDatePicker('');";
            @$return['js'] .= "
                
                
            ";
            $return['onReadyJs'] =
                @$this->CcToSaleListJsFirst
                .$this->Sale['list_add']
                .$this->Sale['list_delete']
                .$this->Sale['list_edit']
            ."
                
                
            ".@$total_child_js."
            
            
            
            child_button_bind('Sale');
            child_pagination_bind('Sale','Account','".$uiTabsId."','".$IdAccount."','','".$this->CcToSearchMsPost."');
            child_pagination_sorted_bind('Sale','Account','".$uiTabsId."','".$IdAccount."','".$this->CcToSearchMsPost."');
               
            $('#cntAccountChild .js-select-label').SelectBox();
            
            ".@$child_order."
            
            
            ".$jqueryDatePickerChild."
            ";
            $return['onReadyJs'] .= "".$this->CcToSaleListJs;
            return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'AccountAct.php';
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
        $this->cCmoreColsHeaderSale = '';
        $this->ListActionRowSale = '';
        $this->cCmoreColsSale = '';
        $this->CcToSaleTableFooter = '';
        $this->CcToSaleListTop = '';
        $this->CcToSaleListBottom = '';
        $this->CcToSaleListJs = '';
        
    }

    
}
