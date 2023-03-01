<?php


###############################
#	Progexpert
###############################
/**
 * Form class on the 'Authy' table.
 *
 */
class AuthyForm extends Authy{
public $tableName="Authy";
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

public $omMap;
public $isConnected;
public $lang;
public $group;
public $userRights;
public $groupRights;
public $adminRights;
public $loginFormClass;
# custom variables
public $sessVar = array();
public function logForm($username='', $mobile=false){
    ## VÉRIFICATION SI L'IMAGE DE L'ADMIN EXISTE
    if(file_exists(_INSTALL_PATH.'css/img/logo-admin.png')) { $logoAdmin = _SITE_URL.'css/img/logo-admin.png'; }
    if(
        (@$_SESSION['CNT_HTTP_REFERER']<1 or @$_SESSION['CNT_HTTP_REFERER'] != NULL)
            AND strpos(@$_SERVER['HTTP_REFERER'],str_replace(array('https://','http://','//'),'',_SITE_URL))!==false
            AND str_replace(array('Deconnection','Disconnect','deconnection','deconnexion','disconnect','logout'),'',@$_SERVER['HTTP_REFERER']) == @$_SERVER['HTTP_REFERER']
       ){
        $_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
        $_SESSION['CNT_HTTP_REFERER']=$_SESSION['CNT_HTTP_REFERER']++;
    }else{
        unset($_SESSION['referer']);
    }
    
    $stay="";
    $parsedUrl = parse_url(_SITE_URL);
    $host = explode('.', $parsedUrl['host']);
    $subdomains = array_slice($host,0,count($host)- 2);
    if(!@$_SESSION['token'] and @$subdomains[0] != "apps"){
       $stay=
            div(
                input('checkbox','stay')
                .label(span(_("Rester connecté")),'for="stay"')
            ,'','class="checkbox-wrapper"');
    }

    $return['html'] =
            div(
                div(
                    href(
                        img($logoAdmin)
                    ,_SITE_URL,'class="ac-client-logo"')
                    .p(span("Simple Web +"),'class="sw-version"')
                    .form(
                        div(
                            input('text','user','','placeholder="Nom d\'usager"')
                            .input('password','passwd','','placeholder="Mot de passe"')
                            .input('password','new_passwd','','placeholder="Nouveau mot de passe" style="display: none;"')
                            .input('password','new_passwd_confirm','','placeholder="Confirmer le mot de passe" style="display: none;"')
                        ,'','class="input-wrapper"')
                        .$stay
                        .button(_("Connexion"),'id="logMe"')
                        .href(_("Mot de passe oublié?"),'#','class="lost-password"')
                    ,'id="login-form"')
                ,'','class="login-content"')

                .p(strong("Simple Web + 2020")." - Tous droits réservés",'class="copyright"')
                .href(_("Progexpert"),'http://progexpert.com','class="progexpert" target="_blank"')
            ,'logMeContainer','class="login-wrapper"');

    @$headJs .= loadJs(_SITE_URL.'js/admin.js');
    @$return['onReadyJs'] .= "

    $('#login-form #user').focus();
    $('#login-form .lost-password').click(function() {
        if(!$('#login-form').hasClass('forgot-password')) {
            $('#login-form').addClass('forgot-password');
            $('#login-form .lost-password,#login-form #logMe').fadeOut(250,function() {
                $('#login-form #passwd').slideUp(250);
                $('#login-form #user').attr('placeholder','".addslashes(_("Adresse courriel"))."');
                $('#login-form input').val('');
                $('#login-form .lost-password').text('".addslashes(_("Annuler"))."');
                $('#login-form #logMe').text('".addslashes(_("Récupérer"))."');
                $('#login-form #user,#login-form .lost-password,#login-form #logMe').fadeIn(250);
                
                $('#login-form #new_passwd').slideUp(100);
                $('#login-form #new_passwd_confirm').slideUp(100);
            });
        } else {
            $('#login-form').removeClass('change-password');
            $('#login-form').removeClass('forgot-password');
            $('#login-form .lost-password,#login-form #logMe').fadeOut(250,function() {
                $('#login-form #passwd').slideDown(250);
                $('#login-form #user').attr('placeholder','".addslashes(_("Nom d'usager"))."');
                $('#login-form .lost-password').text('".addslashes(_("Mot de passe oublié?"))."');
                $('#login-form #logMe').text('".addslashes(_("Connexion"))."');
                $('#login-form #user,#login-form .lost-password,#login-form #logMe').fadeIn(250);
                
                $('#login-form #new_passwd').slideUp(100);
                $('#login-form #new_passwd_confirm').slideUp(100);
            });
        }
    });

    var login_ready = true;
    $('#logMeContainer').on('submit','#login-form',function() {
        if((!$(this).hasClass('forgot-password') && ($('#user').val() == '' || $('#passwd').val() == '')) || ($(this).hasClass('forgot-password') && $('#user').val() == '') || 
        ($(this).hasClass('change-password') && ($('#user').val() == '' || $('#passwd').val() == '' || $('#new_passwd').val() == '' || $('#new_passwd_confirm').val() == ''))){ 
            sw_message('".addslashes(_('Tous les champs sont requis.'))."',true,'form-error');
        } else {
            if(login_ready == true) {
                login_ready = false;
                if($(this).hasClass('forgot-password')) {
                   $.post('"._SITE_URL."mod/act/AuthyAct.php', {a:'passReset', 'c':$('#login-form #user').val()}, function (data){
                        authMeReturned(data);
                        login_ready = true;
                    }, 'json');
                }else if($(this).hasClass('change-password')) {
                    passwdHash = $.md5($('#passwd').val());
                    passwdV1Hash = $.md5($('#new_passwd').val());
                    passwdVHash = $.md5($('#new_passwd_confirm').val());
                    if(passwdV1Hash == passwdVHash){
                        $.post('"._SITE_URL."mod/act/AuthyAct.php', {a:'auth', 'u':$('#user').val(), 'p':passwdHash, 'pv':passwdVHash,'stay':$('#login-form #stay').prop('checked')}, function (data){
                            authMeReturned(data);
                            login_ready = true;
                        }, 'json');
                    } else {
                        sw_message('".addslashes(_('Les deux mot de passe son différent. Veuillez réessayer.'))."',true,'form-error');
                        login_ready = true;
                    }
                }else{
                     passwdHash = $.md5($('#passwd').val());
                    $.post('"._SITE_URL."mod/act/AuthyAct.php', {a:'auth', 'u':$('#user').val(), 'p':passwdHash,'stay':$('#login-form #stay').prop('checked')}, function (data){
                        authMeReturned(data);
                        login_ready = true;
                    }, 'json');
                }
            }
        }                
        return false;
    });

     setTimeout(function(){ bind_othertabs_std('');},500); 
    ";
    $return['js'] = "
var delay;
function authMeReturned(data){
    clearTimeout(delay);
    sw_message(data.message,data.error,data.class);
    
    if(data.error == false) {
        if(data.method == 'login') {
            if(typeof data.referer !== 'undefined' && data.referer != ''){
                setTimeout(function(){ window.location.href = data.referer; }, 1000);
            }else{
                setTimeout(function(){ window.location.href = '"._SITE_URL."admin'; }, 1000);
            }
        }else{ $('.lost-password').click(); }
    } else {
        if(data.expired == true) {
            $('#login-form .lost-password,#login-form #logMe').fadeOut(250,function() {
                $('#login-form').addClass('change-password');
                $('#login-form #passwd').slideUp(100);
                
                $('#login-form #new_passwd').slideDown(250);
                $('#login-form #new_passwd_confirm').slideDown(250);
                $('#login-form #new_passwd').select();
                   
                $('#login-form .lost-password').text('".addslashes(_("Annuler"))."');
                $('#login-form #logMe').text('".addslashes(_("Changer le mot de passe"))."');
                $('#login-form #user,#login-form .lost-password,#login-form #logMe').fadeIn(250);
            });
        }
    }
}";
    if(function_exists('beforeLogForm')){beforeLogForm($return, $username, $mobile);}
    return $return;
}

function myAccountForm(){
    if($uiTabsId = ''){ $uiTabsId = 'tabsContain';}
    $Obj = AuthyQuery::create();
    $dataObj = $Obj->findPk($_SESSION[_AUTH_VAR]->get('id'));
    $form['html'] = div(
            form(
                div(htmlLink(_('Mon compte'), 'Javascript:'),'' ," class='title_bare'")
                .div('', '', "class='cntActForm'")
                .div(div(_("Mot de passe"), '', "class='divtdl'")
            .div(input('password', 'PasswdHash',str_replace('"','&quot;',$dataObj->getPasswdHash()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Mot de passe'))."' size='35'  v='PASSWD_HASH' s='d' class='req'").button(span(_("Afficher le mot de passe"),'data-tooltip="'.addslashes(_("Afficher le mot de passe")).'"'),'class="show-password button-link-blue"').input('hidden', "PasswdHash_dflt", $dataObj->getPasswdHash(), " otherTabs=1 s='d' class='req'"), '', "class='divtd'")
                , '', "class='divtr'")
                . div(
                    input('button', 'saveCompte', _('Sauvegarder'), "j='but' class='ac-button ac-light-red'")
                ,''," class='divtr divbut' ")
            , "id='myAccountForm' class='formContent'")
            , '', "class='divStdform cntform'");
    $form['onReadyJs'] = "
        $('#myAccountForm #saveCompte').click(function (){
            $('body').css('cursor', 'progress');
            $(this).css('cursor', 'progress');
            $.post('"._SITE_URL."mod/act/AuthyAct.php',
            {'a':'saveMe',d:$(\"#myAccountForm [s='d']\").serialize(),ui:'".$uiTabsId."'
            ,je:'".$jsElement."',jet:'".$jsElementType."'".$ip_save.", dialog:'".$dialog."'},
                    function(data){ $('body').css('cursor', 'default');});
        });";
    return $form;
}

public function tryLog($username, $passHash, $isWs=false,$stay=true ){
    if($stay=='true'){
        $en_de_txt = en_de('encrypt',json_encode(array($username,$passHash)));
        setcookie("authy",NULL,-1, '/', $_SERVER['SERVER_NAME']);
        setcookie(""._PROJECT_NAME."_authy",$en_de_txt,time() + (10 * 365 * 24 * 60 * 60), '/');
    }
    $q = new AuthyQuery();
    $q
        ->where(' ((LOWER(Authy.Username) = "'.addslashes(strtolower(trim($username))).'") or (LOWER(Authy.Email) = "'.addslashes(strtolower(trim($username))).'")) ') 
        ->filterByPasswdHash(addslashes(trim($passHash)))->_or()->filterByPasswdHashTemp(addslashes(trim($passHash)))
        ->filterByDeactivate('Non')->_or()->filterByDeactivate(null, Criteria::EQUAL)
        ;
    $CcToSearchList = $this->CcToSearchList;
    if($CcToSearchList)
        foreach($CcToSearchList as $ccsearch){
            if($ccsearch['f']){
                if($ccsearch['vf'] =='or')
                    $q->_or();
                $filterStr = "filterBy".$ccsearch['f'];
                $q->$filterStr($ccsearch['v']);
            }
        }
    $pmpoData =  $q->findOne();
    $this->setSession($pmpoData, $username, $isWs);
    $this->lastTry = time();
    /*$this->logAuth($username);*/
}
public function setSession($pmpoData, $username, $isWs=false){
    if( !empty($pmpoData) && ( strtolower($pmpoData->getUsername()) === strtolower(trim($username)) || strtolower($pmpoData->getEmail()) === strtolower(trim($username)) )){
        $passHash = $pmpoData->getPasswdHashTemp();
        if(($pmpoData->getExpire() != null && $pmpoData->getExpire() <= date('Y-m-d')) and $isWs != true){
            $_SESSION[_AUTH_VAR]->set('isConnected','NO');
            $_SESSION[_AUTH_VAR]->set('lastMsg',_("Usager expiré depuis ".$pmpoData->getExpire()));
        }else{
            $_SESSION[_AUTH_VAR]->set('sess_id', md5(session_id()));
            $_SESSION[_AUTH_VAR]->set('isConnected','YES');
            $_SESSION[_AUTH_VAR]->set('isRoot',($pmpoData->getIsRoot() == 'Oui')?true:false);
            $_SESSION[_AUTH_VAR]->set('group',$pmpoData->getGroup());
            $_SESSION[_AUTH_VAR]->set('passHash',$passHash);
            $_SESSION[_AUTH_VAR]->set('username',$pmpoData->getUsername());
            
            $_SESSION[_AUTH_VAR]->set('userRights',$pmpoData->getRights());
            $_SESSION[_AUTH_VAR]->set('email',$pmpoData->getEmail());
            $_SESSION[_AUTH_VAR]->set('id',$pmpoData->getIdAuthy());
            if(!$_SESSION[_AUTH_VAR]->get('id_logged')){ $_SESSION[_AUTH_VAR]->set('id_logged',$pmpoData->getIdAuthy());}
            $_SESSION[_AUTH_VAR]->set('lastMsg', _("Vous êtes connecté."));
            
            
            $_SESSION['memoire']=unserialize($pmpoData->getOnglet());
            
        }
    }else{
        $_SESSION[_AUTH_VAR]->set('isConnected','NO');
        $_SESSION[_AUTH_VAR]->set('lastMsg',_("Nom d'usager et/ou mot de passe incorrect."));
    }
}

public function getRightsArray($arrayRights){ return json_decode($arrayRights, true);}
public function isConnected(){
    if($this->isConnected == 'YES'){return true;}else{return false;}
}
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
        $q = AuthyQuery::create();
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
                if(isset($this->searchMs['Username']) and $this->searchMs['Username'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Username']) and strpos($this->searchMs['Username'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Username'] != '%DoNothing%' AND $this->searchMs['Username'][0] != '%DoNothing%'){
                        $q->filterByUsername("%".$this->searchMs['Username']."%", Criteria::LIKE);
                    }
                }
                if(isset($this->searchMs['Email']) and $this->searchMs['Email'] !=""){
                    $criteria = Criteria::EQUAL;
                    if(is_string($this->searchMs['Email']) and strpos($this->searchMs['Email'],'!') !== false){$criteria = Criteria::NOT_EQUAL;}
                    if($this->searchMs['Email'] != '%DoNothing%' AND $this->searchMs['Email'][0] != '%DoNothing%'){
                        $q->filterByEmail("%".$this->searchMs['Email']."%", Criteria::LIKE);
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
                $trHead = @$this->cCmoreColsHeaderFirst.th(_("Nom d'usager"), " th='sorted'  rcColone='Username' c='Username'  ").th(_("Courriel"), " th='sorted'  rcColone='Email' c='Email'  ").th(_("Root"), " th='sorted'  rcColone='IsRoot' c='IsRoot'  ").th(_("Groupe"), " th='sorted'  rcColone='Group' c='Group'  ").th(_("Expiration"), " th='sorted'  rcColone='Expire' c='Expire'  ").th(_("Désactive"), " th='sorted'  rcColone='Deactivate' c='Deactivate'  "). $this->cCmoreColsHeader;
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
                $array_search_tb = array('Username','Email');
                
                unset($data);$data['Username'] = (!empty($this->searchMs['Username']))?$this->searchMs['Username']:'';
        $data['Email'] = (!empty($this->searchMs['Email']))?$this->searchMs['Email']:'';
        
                
        @$this->fieldsSearch['Authy']['Username'] = div(input('text', 'Username', $this->searchMs['Username'], ' othertabs=1  placeholder="'._('Nom').'"',''),'','class="ac-search-item ms-Username"');
        @$this->fieldsSearch['Authy']['Email'] = div(input('text', 'Email', $this->searchMs['Email'], ' othertabs=1  placeholder="'._('Courriel').'"',''),'','class="ac-search-item ms-Email"');
            
        $AddShortcut =button(span(_("Ajouter aux raccourcis"),'data-tooltip="'._('Ajouter aux raccourcis').'"'),'class="icon shortcut" title="'._('Ajouter aux raccourcis').'" id="msAuthyAddShortcut"');
        if(!empty($this->search['Autoc']['SelId'])){$AddShortcut="";}

        $this->fieldsSearch['Authy']['Button'] = 
            $this->CcToSearchMsForm
            .div(
               button(span(_("Rechercher"),'data-tooltip="'._('Rechercher').'"'),'id="msAuthyBt" title="'._('Lancer la recherche').'" class="icon search"')
               .button(span(_("Vider"),'data-tooltip="'._('Vider la recherche').'"'),' title="'._('Vider la recherche').'" id="msAuthyBtClear" class="icon clear"')
               .@$this->fieldsSearch['Authy']['BShortEnd']
               .@$AddShortcut
               .@$this->fieldsSearch['Authy']['BEnd']
            ,'','class="ac-action-buttons"');
                 
                $trSearch = ''
            .div(
                button(span(_("Afficher la recherche")),'class="js-toggle-AuthySearch btn-toggle-search" data-toggle="'._("Cacher la recherche").'"')
                .form(@$this->fieldsSearch['Authy']['Start'].
                    $this->fieldsSearch['Authy']['Username'].
                    $this->fieldsSearch['Authy']['Email'].
                @$this->fieldsSearch['Authy']['End'].
            $this->fieldsSearch['Authy']['Button']
            ,"id='formMsAuthy' CntTabs=1 ")
            ,"", "  class='msSearchCtnr'");
                return $trSearch;
            break;
            case 'add':
            ###### ADD
                
            if(
                $_SESSION[_AUTH_VAR]->hasRights('Authy', 'a') 
                    and (!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList'])  
                    and (!isset($this->setReadOnly) || $this->setReadOnly !='all')){
                if(!isset($this->search['Autoc']['SelList']) || !$this->search['Autoc']['SelList']){
                    $add_button = htmlLink(_("Ajouter"),_SITE_URL."Authy/edit/", "id='addAuthy' title='"._('Ajouter')."' class='button-link-blue add-button'");
                }else{
                    $add_button = div(
                htmlLink(span(_("Ajouter")),"javascript:", "id='addAuthyAutoc' class='addButton'").$this->cCMainTableHeader, '', "class='listHeaderItem'");
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
        
        $this->siteTitle .=_("Liste Usagers");
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
        if(!empty($_SESSION['memoire']['onglet']['Authy']['pg'])){
            $page = $_SESSION['memoire']['onglet']['Authy']['pg'];
        }
        $this->uiTabsId = $uiTabsId;
        $this->ajaxPageActParent = (empty($this->cCajaxPageActParent))?'AuthyAct.php':$this->cCajaxPageActParent;
        $this->ajaxPageAct = (empty($this->cCajaxPageAct))?'AuthyAct.php':$this->cCajaxPageAct;
        if(!empty($search['order'])){$this->searchOrder =$search['order'];}
        
        $pOrder ='';
        if($this->searchOrder){
            foreach($this->searchOrder as $col=>$sens){
                if($sens){
                    $pOrder .="
                        $(\"#AuthyListForm [th='sorted'][c='".$col."']\").attr('sens','".strtolower($sens)."');
                         $(\"#AuthyListForm [th='sorted'][c='".$col."']\").attr('order','on');
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
                if(!$_SESSION[_AUTH_VAR]->hasRights('Authy', 'd') && !$_SESSION[_AUTH_VAR]->hasRights('Authy', 'b')){
                    $CheckAction ='';
                }

                if($_SESSION[_AUTH_VAR]->hasRights('Authy', 'd')){
                    $this->ListActionRow = $this->ListActionRow.
        htmlLink(span(_("Supprimer"), 'class="ac-delete-label"'),"Javascript:","class='ac-delete-link' j='deleteAuthy' i='".json_encode($data->getPrimaryKey())."'  ").$CheckAction;
                }else{
                    $this->ListActionRow = $this->ListActionRow."".$CheckAction;
                }
            }
        
                ;
                
                
                
                
                
                
                 $titreRaccour =''; $titreRaccour .= _('Usagers');
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
                    @$cCmoreColsFirst.td(span(strip_tags((isset($altValue['Username']) and $altValue['Username'])?$altValue['Username']:$data->getUsername()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Nom d'usager").":\" j='editAuthy'  i='".json_encode($data->getPrimaryKey())."' c='Username'  ")
                            .td(span(strip_tags((isset($altValue['Email']) and $altValue['Email'])?$altValue['Email']:$data->getEmail()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Courriel").":\" j='editAuthy'  i='".json_encode($data->getPrimaryKey())."' c='Email'  ")
                            .td(span(strip_tags((isset($altValue['IsRoot']) and $altValue['IsRoot'])?$altValue['IsRoot']:isntPo($data->getIsRoot())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Root").":\" j='editAuthy'  i='".json_encode($data->getPrimaryKey())."' c='IsRoot'  ")
                            .td(span(strip_tags((isset($altValue['Group']) and $altValue['Group'])?$altValue['Group']:isntPo($data->getGroup())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Groupe").":\" j='editAuthy'  i='".json_encode($data->getPrimaryKey())."' c='Group'  ")
                            .td(span(strip_tags((isset($altValue['Expire']) and $altValue['Expire'])?$altValue['Expire']:$data->getExpire()." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Expiration").":\" j='editAuthy'  i='".json_encode($data->getPrimaryKey())."' c='Expire'  ")
                            .td(span(strip_tags((isset($altValue['Deactivate']) and $altValue['Deactivate'])?$altValue['Deactivate']:isntPo($data->getDeactivate())." "),'class="ac-list-td-content"'),"  data-responsive=\""._("Désactive").":\" j='editAuthy'  i='".json_encode($data->getPrimaryKey())."' c='Deactivate'  ")
                            .$cCmoreCols.$this->ListActionRow
                ," 
                    
                   
                    rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$i."'
                    r='data'
                    ecf='".$edit_columns_filter."'
                    class='".@$highlight." '
                    id='AuthyRow".$data->getPrimaryKey()."'
                    data-table='Authy' 
                    data-edit='".@$titreRaccour." #".json_encode($data->getPrimaryKey())."'
                    data-id='".$data->getPrimaryKey()."'
                ")
                ;
                
                
                $i++;
            }
            $tr .= input('hidden', 'rowCountAuthy', $i);
            
            
        }

        // @PAGINATION
        if(!empty($pmpoData) and strpos(get_class($pmpoData),'PropelModelPager') !== false){
            $table_name = 'Usagers';

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
                            ,'','id="AuthyPagination"')
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
                .div($controlsContent.$this->CcCustomControl,'AuthyControlsList', "class='custom-controls ".@$hasControls."'")
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
                        table($trHead.$tr, "id='AuthyTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list contentHolderListP" ')
                .$this->CcToListBottom
                .@$bottomRow
            , 'AuthyListForm');
        
        $hasParent = json_decode($IdParent);
        if(empty($hasParent)){
            $editEvent = "
        $(\"#AuthyListForm [j='deleteAuthy']\").bind('click', function (){
            $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Usagers'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msAuthyBt\').length>0){ sw_message(\'".addslashes(_('Suppression complété.'))."\',false,\'search-progress\'); $(\'#msAuthyBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageActParent."\', {a:\'list\', ui:\'".$uiTabsId."\', p:$(this).attr(\'i\')}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#AuthyListForm tr[ecf=1] td[j='editAuthy']\").bind('click', function (e){
            if (e.which == 2) {  window.open('"._SITE_URL."Authy/edit/'+$(this).attr('i'), '_blank'); }
            else { document.location = '"._SITE_URL."Authy/edit/'+$(this).attr('i'); }
        });
        ";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Authy'
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
        $(\"#AuthyListForm [j='deleteAuthy']\").bind('click', function (){
                $('#ui-dialog-title-confirmDialog').html('".addslashes(_('Usagers'))."');confirm('".addslashes(message_label('supp_cette_entrer'))."',' $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'delete\', ui:\'".$uiTabsId."\', i:'+$(this).attr('i')+'}, function(data){ if(data){ $(\'#".$uiTabsId."\').append(data); }else if($(\'#msAuthyBt\').length>0){ $(\'#msAuthyBt\').click(); }else{ $.post(\'"._SITE_URL."mod/act/".$this->ajaxPageAct."\', {a:\'list\', ui:\'AuthyTable\', p:$(this).attr(\'i\'), ui:\'".$uiTabsId."\',ip:\'".json_encode($IdParent)."\'}, function(data){ $(\'#".$uiTabsId."\').html(data); }); } }); ');
            });

        $('#cntAuthyListForm #addAuthy').click(function(){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."',{a:'edit', ui:'editDialog', je:'AuthyTable', jet:'tr', ip:'".json_encode($IdParent)."'},function(data){
                $('#editDialog').html(data); beforeOpenDialog('editDialog');
            });
        });
        ";
            if(empty($this->search['Autoc']['SelList'])){
                $editEvent .= "
        $(\"#AuthyListForm tr[ecf=1] td[j='editAuthy']\").bind('click', function (){
            $.post('"._SITE_URL."mod/act/".$this->ajaxPageAct."', {a:'edit', i:$(this).attr('i'), ui:'editDialog', je:'AuthyTable', jet:'tr'},  function(data){
                $('#loader').show(); $('#editDialog').html(data); beforeOpenDialog('editDialog'); });
        });";
            }else{
                $autoconePageAct = ($this->search['Autoc']['SelAct'])?$this->search['Autoc']['SelAct']:$this->search['Autoc']['SelEnt'];
                if($this->search['Autoc']['formBu']){ $this->search['Autoc']['SelEnt'] = 'Bu'.$this->search['Autoc']['SelEnt'];}
                $editEvent .= "
            bind_autoc_list(
                'Authy'
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
        pagination_bind('Authy','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','');";
        
        $jqueryDatePicker = "beforeDatePicker('');";
        $return['onReadyJs'] ="
            
            
        $('#tabsContain .js-select-label,#editPopupDialog .js-select-label').SelectBox();
         setTimeout(function(){ bind_othertabs_std('');},500); 
            
        $(document).scroll(function() {
            if($('#body .sw-header').length) { topW = parseFloat($('#body .sw-header').height())+parseFloat($('#body .sw-header').position().top); }
        });
        $(\"#AuthyListForm [j='deleteAuthy']\").unbind('click');
        $('#AuthyListForm #addAuthy').unbind('click');
        $(\"#AuthyListForm tr[ecf=1] td[j='editAuthy']\").unbind('click');
    ".@$this->CcToListJsFirst.$editEvent."
        $(\"#AuthyListForm [j='button']\").unbind();   
        pagination_sorted_bind('Authy','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."');
        bind_js_retract();
        robot_mgr_add_autoc('Authy','".addslashes($variableAutoc)."');
        
        
        
        
        bind_button_list('Authy','".$uiTabsId."','".addslashes($variableAutoc)."','".$this->ajaxPageActParent."','".$this->CcToSearchMsPost."',traductionList);
        
        
        
        
        
        
        
        ".$jqueryDatePicker."
        ".$pOrder."
        ".$this->CcToListJs;
        @$return['js'] .= "
         ";
        return $return;
    }
    public function save_create_Authy($data){

        unset($data['IdAuthy']);
        $e = new Authy();
        
                    if(@$data['noRights'] != 'y'){
                       
                    $data['Rights'] = serializeRights($data, 'Rights');
                    }
        if(@$data['PasswdHash'] != @$data['PasswdHash_dflt'])
            $data['PasswdHash'] = md5($data['PasswdHash']);
        if(@$data['PasswdHashTemp'] != @$data['PasswdHashTemp_dflt'])
            $data['PasswdHashTemp'] = md5($data['PasswdHashTemp']);
        
        if(isset($data['IdGroupCreation'])){$e->setIdGroupCreation(($data['IdGroupCreation']=='')?null:$data['IdGroupCreation']);}
        if($data['IsRoot'] == ''){unset($data['IsRoot']);}
        if($data['Group'] == ''){unset($data['Group']);}
        if(!@$data['Deactivate']){$data['Deactivate'] = "Oui";} 
        if(!@$data['Language']){$data['Language'] = "Francais";} 
        if(isset($data['LastPoke'])){$e->setLastPoke(($data['LastPoke']=='')?null:$data['LastPoke']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        $e->setIdGroupCreation(($data['IdGroupCreation']=='')?null:$data['IdGroupCreation']);
        $e->setValidationKey(($data['ValidationKey']=='')?null:$data['ValidationKey']);
        $e->setIsRoot(($data['IsRoot']=='')?null:$data['IsRoot']);
        $e->setGroup(($data['Group']=='')?null:$data['Group']);
        $e->setExpire( ($data['Expire'] == '' || $data['Expire'] == 'null' || substr($data['Expire'],0,10) == '-0001-11-30')?null:$data['Expire'] );
        $e->setDateRequested( ($data['DateRequested'] == '' || $data['DateRequested'] == 'null' || substr($data['DateRequested'],0,10) == '-0001-11-30')?null:$data['DateRequested'] );
        $e->setLastPoke(($data['LastPoke']=='')?null:$data['LastPoke']);
        $e->setLastPokeIp(($data['LastPokeIp']=='')?null:$data['LastPokeIp']);
        $e->setRights(($data['Rights']=='')?null:$data['Rights']);
        $e->setWbsPublic(($data['WbsPublic']=='')?null:$data['WbsPublic']);
        $e->setWbsPrivate(($data['WbsPrivate']=='')?null:$data['WbsPrivate']);
        $e->setOnglet(($data['Onglet']=='')?null:$data['Onglet']);
        $e->setPasswdHashTemp(($data['PasswdHashTemp']=='')?null:$data['PasswdHashTemp']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?null:$data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?null:$data['DateModification'] );
        $e->setPasswdDate( ($data['PasswdDate'] == '' || $data['PasswdDate'] == 'null' || substr($data['PasswdDate'],0,10) == '-0001-11-30')?null:$data['PasswdDate'] );
        $e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);
        $e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);
        return $e;
    }
    public function save_update_Authy($data){

        
        $e = AuthyQuery::create()->findPk(json_decode($data['i']));
        
                    if(@$data['noRights'] != 'y'){
                       
                    $data['Rights'] = serializeRights($data, 'Rights');
                    }
        if(@$data['PasswdHash'] != @$data['PasswdHash_dflt'])
            $data['PasswdHash'] = md5($data['PasswdHash']);
        if(@$data['PasswdHashTemp'] != @$data['PasswdHashTemp_dflt'])
            $data['PasswdHashTemp'] = md5($data['PasswdHashTemp']);
        
        if(isset($data['IdGroupCreation'])){$e->setIdGroupCreation(($data['IdGroupCreation']=='')?null:$data['IdGroupCreation']);}
        if($data['IsRoot'] == ''){unset($data['IsRoot']);}
        if($data['Group'] == ''){unset($data['Group']);}
        if(!@$data['Deactivate']){$data['Deactivate'] = "Oui";} 
        if(!@$data['Language']){$data['Language'] = "Francais";} 
        if(isset($data['LastPoke'])){$e->setLastPoke(($data['LastPoke']=='')?null:$data['LastPoke']);}
        if(isset($data['IdCreation'])){$e->setIdCreation(($data['IdCreation']=='')?null:$data['IdCreation']);}
        if(isset($data['IdModification'])){$e->setIdModification(($data['IdModification']=='')?null:$data['IdModification']);}
        $e->fromArray($data );
        
        if(isset($data['IsRoot'])){$e->setIsRoot(($data['IsRoot']=='')?null:$data['IsRoot']);}
        if(isset($data['Group'])){$e->setGroup(($data['Group']=='')?null:$data['Group']);}
        if(isset($data['Expire'])){$e->setExpire( ($data['Expire'] == '' || $data['Expire'] == 'null' || substr($data['Expire'],0,10) == '-0001-11-30')?NULL:$data['Expire'] );}
        if(isset($data['DateRequested'])){$e->setDateRequested( ($data['DateRequested'] == '' || $data['DateRequested'] == 'null' || substr($data['DateRequested'],0,10) == '-0001-11-30')?NULL:$data['DateRequested'] );}
        if(isset($data['DateCreation'])){$e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30')?NULL:$data['DateCreation'] );}
        if(isset($data['DateModification'])){$e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30')?NULL:$data['DateModification'] );}
        if(isset($data['PasswdDate'])){$e->setPasswdDate( ($data['PasswdDate'] == '' || $data['PasswdDate'] == 'null' || substr($data['PasswdDate'],0,10) == '-0001-11-30')?NULL:$data['PasswdDate'] );}
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of Authy
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
        $je= "AuthyTable";
        if($jsElement){ $je=$jsElement; }
        if($jsElementType){ $jet=$jsElementType; }
        $IdParent = @$data['ip'];
        $jet = "tr";
        $editDialog="editDialog";
        if($uiTabsId){ $editDialog=$uiTabsId; }
        if($id and @$_SESSION['memoire']['onglet']['Authy']['ogf']){
            $tabs_act = "$('[href=\"".$_SESSION['memoire']['onglet']['Authy']['ogf']."\"]').click();";
        }
        $ip_save="";
        ################/* l'action doit savoir si st'en child ou pas */
        if($uiTabsId != "tabsContain"){
            $this->AddButtonJs = "
            $('#addAuthy_child').bind('click.addAuthy', function (){
                    $.post('"._SITE_URL."mod/act/AuthyAct.php', {a:'edit', ui:'".$editDialog."', je:'".$je."', jet:'".$jet."', ip:'".$data['ip']."',pc:'".$data['pc']."'},
                    function(data){  $('#".$uiTabsId."').html(data); });
            }); ";
            $ip_save = ",ip:'".json_encode($data['ip'])."'";
        }else{
              $this->AddButtonJs = "$('#addAuthy_child').bind('click.addAuthy', function (){
                document.location= '"._SITE_URL."Authy/edit/';
            });";
        }
        ################
        #	need 'reload' to load form from data
        if($id && empty($data['reload'])){
            $ip=0;
            if(!empty($data['ip'])){ $ip=$data['ip']; }
            if(!empty($data['dialog'])){ $dialog=$data['dialog']; }
            
            $q = AuthyQuery::create();
            
            
            $dataObj = $q->findPk($id);
            
            $idPk = $id;if($ip){$data['ip']=$ip;}
        }
        if(($_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Authy', 'a') and !$id ) 
            || ( $_SESSION[_AUTH_VAR]->hasRights(@$data['req']['pc'].'Authy','w',$dataObj)) 
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
                    $('#formAuthy #saveAuthy').removeAttr('disabled');
                    $('#formAuthy #saveAuthy').removeClass('can-save');
                    $('body').css('cursor', 'default');
                    $('#formAuthy #saveAuthy').css('cursor', 'default');
                    if($('#formAuthy #idPk').val() ==''){
                        $(\"#".$uiTabsId."\").html(data);
                    }else{ $(\"#".$uiTabsId."\").append(data); }
                ";
            }
            $this->SaveButtonJs = "
                $('#formAuthy #saveAuthy').bind('click.saveAuthy', function (data){
                    $('#formAuthy #saveAuthy').attr('disabled', 'disabled');
                    
                    $('body').css('cursor', 'progress');
                    $('#formAuthy #saveAuthy').css('cursor', 'progress');
                    $('#formAuthy #saveAuthy').switchClass('ac-light-red','ac-light-blue',1000,'easeInOutQuad');
                    $('#formAuthy .tinymce').each(function(index) {
                        eval(' $(\"#formAuthy #'+$(this).attr('Id')+'\").val(CKEDITOR.instances.'+$(this).attr('Id')+'.getData());');
                    });
                    var strSerialize;
                    if($('#formAuthy select[multiple]').length>0){
                        var strSerialize =$(this).parents(\"#formAuthy\").find(\"[s='d']\").serializeArray();
                        $('#formAuthy select[multiple]').each(function(){
                            Name =$(this).attr('id');Name = Name.replace('[]', '');
                            if($(this).hasAttr('val') && Name){ strSerialize.push({name:Name+'Multi', value:$(this).attr('val')})};
                        });
                        strSerialize = $.param(strSerialize);
                    }else{
                        strSerialize =$(this).parents(\"#formAuthy\").find(\"[s='d']\").serialize();
                    }
                    $.post('"._SITE_URL."mod/act/AuthyAct.php',{
                            'a':'save',d:strSerialize".$otherParam."
                            , ui:'".$uiTabsId."',pc:'".@$data['req']['pc']."',ip:'".@$data['ip']."', je:'".$jsElement."'
                            , jet:'".$jsElementType."'".$ip_save.", dialog:'".@$dialog."', tp:$('#formAuthy #tp').val()
                        },
                        function(data){
                            ".$ActionSaveJs."
                        }
                    );$('#formAuthy #formChangedAuthy').val('');
                });
            ";
        }else{
            $this->setReadOnly='all';
            $this->SaveButtonJs = "
                $('#formAuthy #saveAuthy').unbind('click.saveAuthy');
                $('#formAuthy #saveAuthy').remove();";
        }
        
        if($dataObj == null){
            $this->Authy['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Authy();
            $this->Authy['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }


        
        
        
        
        ## Rights for Rights
        $this->primary = 'Oui';
        $userRightsAr = json_decode($dataObj->getRights(), true);
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
                    $td=$this->show_rights($oMentry,'Rights',@$userRightsAr[@$oMentry['name']]);
                    @$trRights .=
                        tr(
                            td(
                                htmlLink($this->desc_right(@$SpaceAdd._($oMentry['desc'])), 'Javascript:', 'class="bld-rights-modules-link"')
                            , "j='chkRights' i='".$oMentry['name']."'").$td
                         ," child='".slugify(trim(@$currentParent))."' class='".@$hide."' ");
                    unset($td);
                    foreach($omMapSubMenu as $key => $row){ $name[$key]=$row['parent_menu'];$sub_menu[$key]=$row['sub_menu']; }
                    array_multisort($name,SORT_ASC,$sub_menu,SORT_ASC,$omMapSubMenu);
                    foreach($omMapSubMenu as $oSubMenu){
                        if($oSubMenu['parent_menu'] == $oMentry['name'] || (camelize($oSubMenu['parent_table'],true) == $oMentry['name'])){
                            $omMapChild[$oSubMenu['name_table']]['F']=1;
                            $td=$this->show_rights($oSubMenu,'Rights',@$userRightsAr[@$oSubMenu['name']]);
                            $trRights .=
                                tr(
                                    td(
                                        htmlLink($this->desc_right(htmlSpace(10)._($oSubMenu['desc']),$oMentry['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                    , "j='chkRights' i='".$oSubMenu['name']."'").$td
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
                                                    , "j='chkRights' i='".$info['name']."'")
                                                        .$this->show_rights($info,'Rights',$userRightsAr[$info['name']],null,$write)
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
                                        $td=$this->show_rights($childMenu,'Rights',$userRightsAr[$nameRight],true);
                                        $trRights .=
                                            tr(
                                                td(
                                                    htmlLink($this->desc_right(htmlSpace(20)._($childMenu['desc']),$oMentry['desc']), 'Javascript:', 'class="bld-rights-modules-link"')
                                                , "j='chkRights' i='".$nameRight."'").$td
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
                                                                , "j='chkRights' i='".$info['name']."'")
                                                                    .$this->show_rights($info,'Rights',$userRightsAr[$info['name']],null,$write)
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
                            , "j='chkRights' i='".$oMentry['name']."'")
                            .$this->show_rights($oMentry,'Rights',$userRightsAr[$oMentry['name']],null,$oMentry['rights'])
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
                                    ," j='parent_chkRights' parent='NonVisible' class='bld-parent-rights-modules-link' colspan=100%")
                                );
                        }
                        $td=$this->show_rights(@$Child,'Rights',@$userRightsAr[@$Child['name']]);
                        $trRights .=
                            tr(
                                td(
                                    htmlLink($this->desc_right(_($Child['desc'])), 'Javascript:', 'class="bld-rights-modules-link"')
                                , "j='chkRights' i='".$Child['name']."'").$td
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
        $rightInputRights =
            input('checkbox','mass-action-Rights','')
            .label(_('Décocher/Cocher'),'for="mass-action-Rights"')
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

        
        
        
        

            $this->fields['Authy']['Username']['html'] = stdFieldRow(_("Nom d'usager"), input('text', 'Username',str_replace('"','&quot;',$dataObj->getUsername()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Nom d\'usager'))."' size='35'  v='USERNAME' s='d' class='req'")."", 'Username', "", @$this->commentsUsername, @$this->commentsUsername_css, '', ' ','no','');

            $this->fields['Authy']['PasswdHash']['html'] = stdFieldRow(_("Mot de passe"), input('password', 'PasswdHash',str_replace('"','&quot;',$dataObj->getPasswdHash()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Mot de passe'))."' size='35'  v='PASSWD_HASH' s='d' class='req'").button(span(_("Afficher le mot de passe"),'data-tooltip="'.addslashes(_("Afficher le mot de passe")).'"'),'class="show-password button-link-blue"').input('hidden', "PasswdHash_dflt", $dataObj->getPasswdHash(), " otherTabs=1 s='d' class='req'"), 'PasswdHash', "", @$this->commentsPasswdHash, @$this->commentsPasswdHash_css, '', ' ','no','');

            $this->fields['Authy']['Email']['html'] = stdFieldRow(_("Courriel"), input('text', 'Email',str_replace('"','&quot;',$dataObj->getEmail()), " otherTabs=1   placeholder='".str_replace("'","&#39;",_('Courriel'))."' size='35'  v='EMAIL' s='d' class=''")."", 'Email', "", @$this->commentsEmail, @$this->commentsEmail_css, '', ' ','no','');

            if($_SESSION[_AUTH_VAR]->get('isRoot')){
                $this->fields['Authy']['IsRoot']['html'] = stdFieldRow(_("Root"), selectboxCustomArray('IsRoot', array( '0' => array('0'=>_("Non"), '1'=>'Non'),'1' => array('0'=>_("Oui"), '1'=>'Oui'), ), _('Root'), "s='d' otherTabs=1  ", $dataObj->getIsRoot()), 'IsRoot', "", @$this->commentsIsRoot, @$this->commentsIsRoot_css, '', ' ','no','');

            }
            $this->fields['Authy']['Group']['html'] = stdFieldRow(_("Groupe"), selectboxCustomArray('Group', array( '0' => array('0'=>_("Normal"), '1'=>'Normal'),'1' => array('0'=>_("Admin"), '1'=>'Admin'), ), _('Groupe'), "s='d' otherTabs=1  ", $dataObj->getGroup()), 'Group', "", @$this->commentsGroup, @$this->commentsGroup_css, '', ' ','no','');

            $this->fields['Authy']['Expire']['html'] = stdFieldRow(_("Expiration"), input('date', 'Expire', $dataObj->getExpire(), "  otherTabs=1 j='date' placeholder='YYYY-MM-DD' size='10' otherTabs=1  s='d' class=''"), 'Expire', "", @$this->commentsExpire, @$this->commentsExpire_css, '', ' ','no','');

            $this->fields['Authy']['Deactivate']['html'] = stdFieldRow(_("Désactive"), selectboxCustomArray('Deactivate', array( '0' => array('0'=>_("Oui"), '1'=>'Oui'),'1' => array('0'=>_("Non"), '1'=>'Non'), ), "", "s='d' otherTabs=1  ", $dataObj->getDeactivate()), 'Deactivate', "", @$this->commentsDeactivate, @$this->commentsDeactivate_css, '', ' ','no','');

            $this->fields['Authy']['Rights']['html'] = stdFieldRow(_("Droits"), $rightInputRights, 'Rights', "", @$this->commentsRights, @$this->commentsRights_css, '', ' ','no','');

        $this->lockFormField(array(), $dataObj);
        if(!empty($this->setReadOnly) and $this->setReadOnly == 'all' ){ $this->lockFormField('all', $dataObj); }
        if(!isset($params['ChildHide'])  and !isset($this->Authy['request']['ChildHide']) ){
            
        }
        
        
        if($dataObj->getIdAuthy()){
            $this->printLink =
                div(
                    ""
                    .@$this->CcPrintLinkDiv
                    
                    
                    
                    .@$this->CcCustomControl
                ,'AuthyControls', "class='custom-controls'");
            
            if(!empty($ChildOnglet)){
                $close_form = '';
            }

        }
        
        $ongletf =
            div(
                ul(li(htmlLink(_('Usagers'),'#ogf_Authy',' j="ogf" p="Authy" class="ui-tabs-anchor button-link-blue" ')).li(htmlLink(_('Droits'),'#ogf_rights',' j="ogf" class="ui-tabs-anchor button-link-blue" p="Authy" ')))
            ,'cntOngletAuthy',' class="cntOnglet"')
            .@$close_form
        ;
        $this->add_button= '';
        if($_SESSION[_AUTH_VAR]->hasRights($data['pc'].$this->tableName, 'a') && empty($this->setReadOnly)){
            
            $this->add_button = 
                
                htmlLink(_("Ajouter"), 'Javascript:;' , "id='addAuthy_child' title='"._('Ajouter')."' class='button-link-blue add-button'");
        }
        
        if(empty($this->setReadOnly)){
            $this->formSaveBar = div(	div( input('button', 'saveAuthy',$this->CcButtonName,' act="save" otherTabs="1" class="button-link-blue"')
                                .input('hidden', 'formChangedAuthy','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($idPk), "s='d'")
                            .input('hidden', 'IdAuthy', $dataObj->getIdAuthy(), " otherTabs=1 s='d' pk").input('hidden', 'IdGroupCreation',$dataObj->getIdGroupCreation(), "   v='ID_GROUP_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'LastPoke',$dataObj->getLastPoke(), "   v='LAST_POKE' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdCreation',$dataObj->getIdCreation(), "   v='ID_CREATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ").input('hidden', 'IdModification',$dataObj->getIdModification(), "   v='ID_MODIFICATION' size='0' otherTabs=1 s='d' class='' otherTabs=1 ")
                            .@$this->CcToFormButtons
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        if(!isset($error['txt'])){@$error['txt']='';}
        
        //@@PRINTLINK
        if(!$this->printLink){ $this->printLink = div($this->CcCustomControl,'AuthyControls', "class='custom-controls'");}
        $jqueryDatePicker = "beforeDatePicker('#formAuthy');";
        
        $toggleForm="";
        if(!empty($_SESSION['memoire']['onglet']['Authy']['tog']) and 
            $_SESSION['memoire']['onglet']['Authy']['tog']=='true'){$toggleForm="$('#toggle-form').click();";}
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
                .@$this->fields['Authy']['Start']['html']
                
                .
                    '<div id="ogf_Authy">'.
$this->fields['Authy']['Username']['html']
.$this->fields['Authy']['PasswdHash']['html']
.$this->fields['Authy']['Email']['html']
.$this->fields['Authy']['IsRoot']['html']
.$this->fields['Authy']['Group']['html']
.$this->fields['Authy']['Expire']['html']
.$this->fields['Authy']['Deactivate']['html']
.'</div><div id="ogf_rights"  class="ui-widget-content ui-tabs-panel">'
.$this->fields['Authy']['Rights']['html'].'</div>'
                
                .@$this->fields['Authy']['End']['html']
                .$this->formSaveBar
                .@$this->CcToInnerFormBottom
            ,"divCntAuthy", "class='divStdform' CntTabs=1 ")
        , "id='formAuthy' data-pc='".addslashes($data['pc'])."' class='mainForm formContent ".@$this->CcToClassForm."' ")
        .$this->CcToFormBottom;
         
             
        if(!$this->siteTitle){ $this->siteTitle .=_("Formulaire Usagers"); }
        # if not new, show child table
        if($dataObj->getIdAuthy()){
            if(!empty($ChildOnglet)){
                $return['html'] .= div(ul($ChildOnglet, " class=' ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all' "), 'pannelAuthy', " class='child_pannel ui-tabs ui-widget ui-widget-content ui-corner-all'");
                $return['html'] .= div('','cntAuthyChild',' class="childCntClass" ');
            }
        }
        if(!empty($this->CcEvalToForm)){eval($this->CcEvalToForm);}
        if(!empty($_SESSION['memoire']['onglet']['Authy']['ixmemautocapp']) and $_GET['Autocapp'] == 1){
            $Autocapp = $_SESSION['memoire']['onglet']['Authy']['ixmemautocapp'];
            
            unset($_SESSION['memoire']['onglet']['Authy']['ixmemautocapp']);
        }
        
        
        @$return['data'] .= @$data;
        @$return['js'] .= @$childTable['js'].@$this->CcToFormScript."";
        if($uiTabsId == 'editDialog'){$removeEditChild = " $(\"#childadd\").remove();";}
        if(!isset($childTable['onReadyJs'])){$childTable['onReadyJs']='';}

    $return['onReadyJs'] = @$this->CcToFormJsFirst.@$callChildItem."
    
    
    
    ".$jqueryDatePicker."
    bind_ui_active('Authy');
    ".$this->AddButtonJs."
    ".$this->SaveButtonJs."
    
    $('[j=appliquer-group]').bind('click', function(){
        if($('#GroupAuthy').val()){
            $.post('"._SITE_URL."mod/act/AuthyAct.php', {a:'app_write', i:$('#GroupAuthy').val()}, function(data){
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
    $('#mass-action-Rights').bind('click', function(){
        if( $(this).prop('checked')){
            $(\"[j='rcRights']\").prop('checked',true);
        }else{
            $(\"[j='rcRights']\").prop('checked',false);
        }
        $('#formRights #saveRights').addClass('can-save');
    });
    $(\".bld-parent-rights-modules-link\").click(function(){
        $(\"[child=\"+$(this).attr('parent')+\"]\").toggle();
        /*if($(\"[parent=\"+$(this).attr('parent')+\"] input\").prop('checked')){
            $(\"[parent=\"+$(this).attr('parent')+\"] input\").prop('checked',false);
        }else{
            $(\"[parent=\"+$(this).attr('parent')+\"] input\").prop('checked',true);
        }*/
    });

    $(\"[j='chkRights']\").click(function(){
        if($(\"[ent='Rights\"+$(this).attr('i')+\"']\").prop('checked')){
            $(\"[ent='Rights\"+$(this).attr('i')+\"']\").prop('checked',false);
        }else{
            $(\"[ent='Rights\"+$(this).attr('i')+\"']\").prop('checked',true);
        }
    });
    if($('#formAuthy #Group').val() == 'Admin'){ $('#formAuthy #genRightsCtnr').hide(); }else{ $('#formAuthy #genRightsCtnr').show(); }
    $('#formAuthy #Group').change(function (){
        if($('#formAuthy #Group').val() == 'Admin'){ $('#formAuthy #genRightsCtnr').hide(); }else{ $('#formAuthy #genRightsCtnr').show(); }
    });

    $('#cntOngletAuthy').parent().tabs();$('#cntOngletAuthy').show();
    ".@$childTable['onReadyJs']."
    ".@$error['onReadyJs']."
    ".@$removeEditChild."
    /*try {afterFormLoad();}catch(e){}*/
    if($('#loader').css('display') == 'block') $('#loader').hide();
    $('[j=sftr]').hide();
    ".@$tabs_act."
    ".$this->CcToFormJs
    .@$script_autoc_one."
     setTimeout(function(){ bind_othertabs_std('');},500); 
    ".$toggleForm."
    bind_form('Authy','".addslashes($this->CcToFormEndJs)."');
    ";
        return $return;
    }

    function lockFormField($fields, $dataObj){
        
            
        $this->fieldsRo['Authy']['Username']['html'] = stdFieldRow(_("Nom d'usager"), input('text','Username',$dataObj->getUsername()," readonly s='d'"), 'Username', "", @$this->commentsUsername, @$this->commentsUsername_css, 'readonly', ' ','no','');
$this->fieldsRo['Authy']['PasswdHash']['html'] = stdFieldRow(_("Mot de passe"), input('password','PasswdHash',$dataObj->getPasswdHash(),"readonly s='d'"), 'PasswdHash', "", @$this->commentsPasswdHash, @$this->commentsPasswdHash_css, 'readonly', ' ','no','');
$this->fieldsRo['Authy']['Email']['html'] = stdFieldRow(_("Courriel"), input('text','Email',$dataObj->getEmail()," readonly s='d'"), 'Email', "", @$this->commentsEmail, @$this->commentsEmail_css, 'readonly', ' ','no','');
$this->fieldsRo['Authy']['IsRoot']['html'] = stdFieldRow(_("Root"), input('text','IsRoot',$dataObj->getIsRoot()," readonly s='d'"), 'IsRoot', "", @$this->commentsIsRoot, @$this->commentsIsRoot_css, 'readonly', ' ','no','');
$this->fieldsRo['Authy']['Group']['html'] = stdFieldRow(_("Groupe"), input('text','Group',$dataObj->getGroup()," readonly s='d'"), 'Group', "", @$this->commentsGroup, @$this->commentsGroup_css, 'readonly', ' ','no','');
$this->fieldsRo['Authy']['Expire']['html'] = stdFieldRow(_("Expiration"), input('text','Expire',$dataObj->getExpire()," readonly s='d'"), 'Expire', "", @$this->commentsExpire, @$this->commentsExpire_css, 'readonly', ' ','no','');
$this->fieldsRo['Authy']['Deactivate']['html'] = stdFieldRow(_("Désactive"), input('text','Deactivate',$dataObj->getDeactivate()," readonly s='d'"), 'Deactivate', "", @$this->commentsDeactivate, @$this->commentsDeactivate_css, 'readonly', ' ','no','');
$this->fieldsRo['Authy']['Rights']['html'] = stdFieldRow(_("Droits"), textarea('Rights',$dataObj->getRights()," readonly class=''    s='d'"), 'Rights', "", @$this->commentsRights, @$this->commentsRights_css, 'readonly istinymce', ' ','no','');


        if($fields == 'all'){
            foreach($this->fields['Authy'] as $field=>$ar){
                $this->fields['Authy'][$field]['html'] = $this->fieldsRo['Authy'][$field]['html'];
            }
        }elseif(is_array($fields)){
            foreach($fields as $field){
                $this->fields['Authy'][$field]['html'] = $this->fieldsRo['Authy'][$field]['html'];
            }
        }
    }
    /**
     * Produce Options in Html format to update a Select
    */
    public function getSelectOptions($IdParent='', $selected='',$arrayOnly=false){
        $q = AuthyQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Username', 'IdAuthy'));
            
        
        }else{
            $q->select(array('Username', 'IdAuthy'));
        }
        $pcData = $q->orderBy('Username', 'ASC')->find();

        if($arrayOnly){ return assocToNum($pcData->toArray()); }
        $return = arrayToOptions(assocToNum($pcData->toArray()), $selected);
        

        return $return;
    }

    public function getSelectJson($IdParent='', $selected=''){
        $q = AuthyQuery::create();
        if(!empty($IdParent)){
            
             $q->select(array('Username', 'IdAuthy'));
            
        
        }else{
            $q->select(array('Username', 'IdAuthy'));
        }
        $pcData = $q->orderBy('Username', 'ASC')->find();

        if($pcData->count()){
            $return = arrayToJson(assocToNum($pcData->toArray()), $selected);
        }else{
            $return = arrayToJson(array(array('0'=>'Aucun Usagers')), $selected);
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
        
require _BASE_DIR."inc/AddOmMap.php";
$this->omMap = $omMap;
if($this->isConnected != 'YES'){
    $this->isConnected = 'NO';
    if(empty($this->lang)){$this->lang = DEFAULT_LOCALE;}
}

    # list
    $this->CcButtonName = _('Sauvegarder');
    $this->ajaxPageAct = 'AuthyAct.php';
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
