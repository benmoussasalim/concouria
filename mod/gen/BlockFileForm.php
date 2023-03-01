<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'BlockFile' table.
 *
 */
class BlockFileForm extends BlockFile{
public $tableName="BlockFile";
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
        $q = BlockFileQuery::create();
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
                
            if(json_decode($IdParent)){
                $pmpoData = BlockFileQuery::create()->filterByIdBlock(json_decode($IdParent))
                    
                    
                    ->paginate($page, $maxPerPage);
            }
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
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Name"), " th='sorted'  rcColone='Name' c='Name'  ").th(_("Description"), " th='sorted'  rcColone='Desc' c='Desc'  ").th(_("Ordre"), " th='sorted'  rcColone='Index' c='Index'  ").th(_("Poids"), " th='sorted'  rcColone='Size' c='Size'  "). $this->cCmoreColsHeader;
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
                $_SESSION[_AUTH_VAR]->hasRights('BlockFile', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = 
                    $this->add_button .=
                                    div(
                                        htmlLink(
                                            span(_("Ajouter"))
                                        , "Javascript:","id='pickfilesForm' title='"._('Ajouter')."' class='button-link-blue add-button'")
                                    .div('', 'filelist')
                                    ,'upload-BlockFile',' class="ac-left-action-buttons" ');
                                        $add_button=$this->add_button;
                    ;
                }else{
                    $add_button = '';;
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
        
        $this->siteTitle .=_("Liste Upload d'images");
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
        if(!empty($_SESSION['memoire']['onglet']['BlockFile']['pg'])){
            $page = $_SESSION['memoire']['onglet']['BlockFile']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'BlockFileAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'BlockFileAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
            $search_child_default['Name']='ASC';
        if(empty($this->searchOrder)){$this->searchOrder = $search_child_default;}
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#BlockFileListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#BlockFileListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('BlockFile', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('BlockFile', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('BlockFile', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteBlockFile' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['Name']) and $altValue['Name'])?$altValue['Name']:$data->getName()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Name").":\" j='editBlockFile'  i='".json_encode($data->getPrimaryKey())."' c='Name'  ")
                            .td(span(strip_tags((isset($altValue['Desc']) and $altValue['Desc'])?$altValue['Desc']:mb_substr(strip_tags($data->getDesc()),0,50, 'UTF-8')." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Description").":\" j='editBlockFile'  i='".json_encode($data->getPrimaryKey())."' c='Desc'  ")
                            .td(span(strip_tags((isset($altValue['Index']) and $altValue['Index'])?$altValue['Index']:$data->getIndex()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Ordre").":\" j='editBlockFile'  i='".json_encode($data->getPrimaryKey())."' c='Index'  ")
                            .td(span(strip_tags((isset($altValue['Size']) and $altValue['Size'])?$altValue['Size']:$data->getSize()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Poids").":\" j='editBlockFile'  i='".json_encode($data->getPrimaryKey())."' c='Size'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='BlockFileRow".$data->getPrimaryKey()."'
                    data-table='BlockFile' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountBlockFile', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Upload d\'images';

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
                            ,'','id="BlockFilePagination"')
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
                .div($controlsContent.$this->CcCustomControl,'BlockFileControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='BlockFileTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'BlockFileListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#BlockFileListForm [j='deleteBlockFile']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Upload d\'images'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msBlockFileBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msBlockFileBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#BlockFileListForm tr[ecf=1] td[j='editBlockFile']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."BlockFile/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."BlockFile/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'BlockFile'
                ,'IdBlockFile'
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
        $(\"#BlockFileListForm [j='deleteBlockFile']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Upload d\'images'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msBlockFileBt\').length>0){ $(\'#msBlockFileBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'BlockFileTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntBlockFileListForm #addBlockFile').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'BlockFileTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#BlockFileListForm tr[ecf=1] td[j='editBlockFile']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'BlockFileTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'BlockFile'
                ,'IdBlockFile'
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
        pagination_bind('BlockFile','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
                    $return['js'] .= "
$(function(){
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,html4',
        browse_button : 'pickfilesForm',
        container: document.getElementById('upload-BlockFile'),
        url: '"._SITE_URL_NO_S."mod/act/BlockFileAct.php?a=file&ip=".$filterKey."&IdUser=".$_SESSION[_AUTH_VAR]->get('id')."&blob=',
        flash_swf_url : '"._SITE_URL."/js/plupload/Moxie.swf',
        drop_element : 'pickfilesForm',
        
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
                ".$this->ccToSwfuploadAfter."
                document.location = '"._SITE_URL."BlockFile/list/';
            },
            FileUploaded:function(up, files, object) {
                ".$this->ccToSwfuploadAfterFile."
            }
        }
    });
    uploader.init();
});";

        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(\"#BlockFileListForm [j='deleteBlockFile']\").unbind('click');
        $('#BlockFileListForm #addBlockFile').unbind('click');
        $(\"#BlockFileListForm tr[ecf=1] td[j='editBlockFile']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#BlockFileListForm [j='button']\").unbind();   
        pagination_sorted_bind('BlockFile','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('BlockFile','".addslashes($variableAutoc)."');
        
        
        
        
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_BlockFile($data){

        unset($data['IdBlockFile']);
        $e = new BlockFile();
        
        
        if(isset($data['Size'])){$e->setSize(($data['Size']=='')?null:$data['Size']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setExt(($data['Ext']=='')?null:$data['Ext']);
        $e->setName(($data['Name']=='')?null:$data['Name']);
        $e->setDesc(($data['Desc']=='')?null:$data['Desc']);
        $e->setSize(($data['Size']=='')?null:$data['Size']);
        $e->setFichier(($data['Fichier']=='')?null:$data['Fichier']);
        $e->setBlob(($data['Blob']=='')?null:$data['Blob']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_BlockFile($data){

        
        $e = BlockFileQuery::create()->findPk(json_decode($data['i']));
        
        
        if(isset($data['Size'])){$e->setSize(($data['Size']=='')?null:$data['Size']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of BlockFile
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
        $je= "BlockFileTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['BlockFile']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['BlockFile']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addBlockFile_child').bind('click.addBlockFile', function (){
                    $.post('"._SITE_URL."mod/act/BlockFileAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
           
                    $return['js'] .= "
$(function(){
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,html4',
        browse_button : 'pickfilesForm',
        container: document.getElementById('upload-BlockFile'),
        url: '"._SITE_URL_NO_S."mod/act/BlockFileAct.php?a=file&ip=".$filterKey."&IdUser=".$_SESSION[_AUTH_VAR]->get('id')."&blob=',
        flash_swf_url : '"._SITE_URL."/js/plupload/Moxie.swf',
        drop_element : 'pickfilesForm',
        
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
                ".$this->ccToSwfuploadAfter."
                document.location = '"._SITE_URL."BlockFile/list/';
            },
            FileUploaded:function(up, files, object) {
                ".$this->ccToSwfuploadAfterFile."
            }
        }
    });
    uploader.init();
});";

        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = BlockFileQuery::create();
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'BlockFile', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'BlockFile','w',$dataObj)) 
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
                    $('#formBlockFile #saveBlockFile').removeAttr('disabled');
                    $('#formBlockFile #saveBlockFile').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formBlockFile #saveBlockFile').css('cursor', 'default');
                    if($('#formBlockFile #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formBlockFile #saveBlockFile').bind('click.saveBlockFile', function (data){
                    $('#formBlockFile #saveBlockFile').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formBlockFile #saveBlockFile').css('cursor', 'progress');
                    $('#formBlockFile #saveBlockFile').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formBlockFile .tinymce').each(function(index) {
                        eval(' $(\"#formBlockFile #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formBlockFile select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formBlockFile\").find(\"[s='d']\").serializeArray();
                        $('#formBlockFile select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formBlockFile\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/BlockFileAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formBlockFile #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formBlockFile #formChangedBlockFile').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formBlockFile #saveBlockFile').unbind('click.saveBlockFile');
                $('#formBlockFile #saveBlockFile').remove();";
        }
        
        if($dataObj == null){
            $this->BlockFile['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new BlockFile();
            $this->BlockFile['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
            if($data['ip']){
                $strPkParent = "setIdBlock";
                $dataObj->$strPkParent($data['ip']);
            }
        }


        
        
        
        
        
        
        

            $this->fields['BlockFile']['Name']['html'] = stdFieldRow(_("Name"), input('text', 'Name',str_replace('"','&quot;',$dataObj->getName()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Name'))."' size='35'  v='NAME' s='d' class=''")."", 'Name', "", @$this->commentsName, @$this->commentsName_css, '', ' ','no','');

            $this->fields['BlockFile']['Desc']['html'] = stdFieldRow(_("Description"), 
        textarea('Desc',$dataObj->getDesc() ,"placeholder='".str_replace("'","&#39;",_('Description'))."' cols='71' otherTabs=1 v='DESC' s='d'  class='' style='' spellcheck='false'"), 'Desc', "", @$this->commentsDesc, @$this->commentsDesc_css, ' istinymce', ' ','no','');

            $this->fields['BlockFile']['Index']['html'] = stdFieldRow(_("Ordre"), input('number', 'Index',$dataObj->getIndex(), " step='10' placeholder='".str_replace("'","&#39;",_('Ordre'))."' v='INDEX' size='0' otherTabs=1 s='d' class='' otherTabs=1 "), 'Index', "", @$this->commentsIndex, @$this->commentsIndex_css, '', ' ','no','');

            $this->fields['BlockFile']['Size']['html'] = stdFieldRow(_("Poids"), input('number', 'Size',$dataObj->getSize(), " step='10' placeholder='".str_replace("'","&#39;",_('Poids'))."' v='SIZE' size='0' otherTabs=1 s='d' class='' otherTabs=1 "), 'Size', "", @$this->commentsSize, @$this->commentsSize_css, '', ' ','no','');

        $this->lockFormField(array(0=>'Size',1=>'Name',), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->BlockFile['request']['ChildHide']) ){
            
        }
        
        
        if($dataObj->getIdBlockFile()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'BlockFileControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = '';
            }

        }
        
        
        $linkParent="Block";
        $titre_form_str = '';
        if($dataObj->getIdBlockFile()){
                   $titre_form_str .= span(strip_tags(_($dataObj->getName()))," data-name='Name' ");
                   $this->siteTitle =set_var($this->siteTitle,strip_tags(_($dataObj->getName())),' ',false,NULL,false,true);}
        $this->formTitle = p(href($linkParent,_SITE_URL."Block/edit/".$dataObj->getIdBlock()).htmlSpace(1).href("Upload d'images",_SITE_URL.'BlockFile').$titre_form_str, 'class="breadcrumb"'); 
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
                    $this->add_button .=
                                    div(
                                        htmlLink(
                                            span(_("Ajouter"))
                                        , "Javascript:","id='pickfilesForm' title='"._('Ajouter')."' class='button-link-blue add-button'")
                                    .div('', 'filelist')
                                    ,'upload-BlockFile',' class="ac-left-action-buttons" ');
                                        $add_button=$this->add_button;
                    
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveBlockFile',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedBlockFile','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdBlockFile', $dataObj->getIdBlockFile(), " otherTabs=1 s='d' pk").input('hidden', 'IdBlock', $dataObj->getIdBlock(), " otherTabs=1 s='d' nodesc").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'BlockFileControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formBlockFile');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['BlockFile']['tog']) and 
            $_SESSION['memoire']['onglet']['BlockFile']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['BlockFile']['Start']['html']
                
                .
$this->fields['BlockFile']['Name']['html']
.$this->fields['BlockFile']['Desc']['html']
.$this->fields['BlockFile']['Index']['html']
.$this->fields['BlockFile']['Size']['html']
                
                .@$this->fields['BlockFile']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntBlockFile", "class='divStdform' CntTabs=1 ")
        , "id='formBlockFile' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Upload d'images"); }
        # if not new, show child table
        if($dataObj->getIdBlockFile()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelBlockFile', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntBlockFileChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['BlockFile']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['BlockFile']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['BlockFile']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    
    ".$jqueryDatePicker."
    bind_ui_active('BlockFile');
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
     setTimeout(function(){ bind_othertabs_std('#divCntBlockFile');},500); 
    ".$toggleForm."
    bind_form('BlockFile','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
            
        $this->fieldsRo['BlockFile']['Name']['html'] = stdFieldRow(_("Name"), input('text','Name',$dataObj->getName()," readonly s='d'"), 'Name', "", @$this->commentsName, @$this->commentsName_css, 'readonly', ' ','no','');
$this->fieldsRo['BlockFile']['Desc']['html'] = stdFieldRow(_("Description"), textarea('Desc',$dataObj->getDesc()," readonly class=''    s='d'"), 'Desc', "", @$this->commentsDesc, @$this->commentsDesc_css, 'readonly istinymce', ' ','no','');
$this->fieldsRo['BlockFile']['Index']['html'] = stdFieldRow(_("Ordre"), input('text','Index',$dataObj->getIndex()," readonly s='d'"), 'Index', "", @$this->commentsIndex, @$this->commentsIndex_css, 'readonly', ' ','no','');
$this->fieldsRo['BlockFile']['Size']['html'] = stdFieldRow(_("Poids"), input('text','Size',$dataObj->getSize()," readonly s='d'"), 'Size', "", @$this->commentsSize, @$this->commentsSize_css, 'readonly', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['BlockFile'] as $field=>$ar){
                $this->fields['BlockFile'][$field]['html'] = $this->fieldsRo['BlockFile'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['BlockFile'][$field]['html'] = $this->fieldsRo['BlockFile'][$field]['html'];
            }
        }
    }
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = BlockFileQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdBlockFile'));
            
            $pcData = $q->filterByIdBlock($IdParent);
        
        }else{
            $q->select(array('Name', 'IdBlockFile'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = BlockFileQuery::create();
        if(!empty($IdParent)){
            
            $q->select(array('Name', 'IdBlockFile'));
            
            $pcData = $q->filterByIdBlock($IdParent);
        
        }else{
            $q->select(array('Name', 'IdBlockFile'));
        }
        $pcData = $q->orderBy('Name', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Upload d\'images')), $selected);
        }


        return $return;
    }  
        
    

    function __construct(){
        
    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'BlockFileAct.php';
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
