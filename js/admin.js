
/*###############################
#	Progexpert
###############################*/

var menu_change = false, menu_index = 0, primary_menu = 0;
var isSelected_IarcAutoc = 0; var isSelected_IarcAutoccShow = 0;var CCautocSuccessIarc='';var CCautocChangeIarc='';var CCautocSearchIarc=''; var CCautocFocusIarc='';
var default_width = 0;
var default_height = 0;
var fullscreen_timer;
var fullscreen_click = false;
var build_timer = [],build_delay = 200;

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) { vars[key] = value;});
    return vars;
}

function buildStart(target) {
    build_timer['start'] = new Date().getTime();
    $(target).addClass('toggle-build');
}
function clear_act_selectbox(){
    $('.js-select-label.show').each(function( index, value ) {
        $(this).unbindMouseMultiple();
        $(this).close();
    });
}

function buildEnd() {
    build_timer['end'] = new Date().getTime();
    build_timer['duration'] = build_timer['end'] - build_timer['start'];

    build_timer['delay'] = 0;
    if(build_timer['duration'] < build_delay) { build_timer['delay'] = build_delay - build_timer['duration']; }

    return build_timer['delay'] + 30;
}
function checkSupport(){
    if((_lastSupportCheck + 3600) < Date.now()){
        $.post(_SITE_URL+'mod/support.php', { action:'checkMessage' },function(data){
            if(data){
                _lastSupportCheck = data.time;
                $('.support-link').addClass(data.class);
            }
        }, 'json');
        return true;
    }
    return false;
}
function buildDelay(target) { setTimeout(function() { $(target).removeClass('toggle-build'); },50);}

function dialogFullscreen() {
    var _this = $('.ui-fullscreen');
    if(_this.hasClass('default-size')) {
        var top = ($(window).height() / 2) - (default_height / 2);
        if(default_height > $(window).height()) { top = 0; }

        $('.ui-dialog.ui-widget-content').css({
            'width': default_width,
            'max-width': '60%',
            'height': default_height,
            'top': top,
            'left': ($(window).width() / 2) - (default_width / 2)
        });
    }else{
        $('.ui-dialog').each(function() {
            $('.ui-dialog').each(function() {
                if($(this).is(':visible')) {
                    default_width = $(this).width();
                    default_height = $(this).height();
                }
            });
        });

        $('.ui-dialog.ui-widget-content').css({
            'width': $(window).width(),
            'max-width': $(window).width(),
            'height': $(window).height(),
            'top': '0px',
            'left': '0px',
        });
    }
    _this.toggleClass('default-size');
}
function scroll_to(element){
    var in_popup = false;
    $('.ui-dialog').each(function() {
        if($(this).is(':visible')) {
            in_popup = true;
            $(this).find('.ui-dialog-content').animate({scrollTop: 0}, 250);
        }
    });

    if(in_popup == false) {
        if(element){
            $('body,html').animate({scrollTop: $(element).offset().top}, 250);
        }else{

            $('body,html').animate({scrollTop: 0}, 250);
        }
    }
}

$(document).ready(function() {
    if(_CONNECTED=='YES'){ setTimeout(function() { checkSupport(); },2000);}
    $('body').on('click','.close-popup',function(e) {  if(e.target === this) { popup(); return false; } });

    $('body').on('click','.sw-header .controls-button',function() {
        $('.custom-controls').toggleClass('toggle-sw-options');
        return false;
    });

    $('body').on('click','.ui-widget-overlay',function() {
        var upperZ=0;var dialogId;
        $('.ui-dialog:visible').each(function() {
            if(upperZ < $(this).css('z-index')){upperZ = $(this).css('z-index');dialogId =$(this).find('.ui-dialog-content').attr('id');}
        });

        if( dialogId != 'confirmDialog' && dialogId != 'loadingDialog' ){
            if($('#'+dialogId+' .can-save').length>0  ){
                sw_message(_CANT_CLOSE_POPOP,true,'overlay-try',false);
            }else{
                if($('#'+dialogId).length>0){
                    $('#'+dialogId).dialog('close');
                }else{
                    $('#editDialog:visible').dialog('close');
                }
            }
        }
        return false;
    });

    $('.ui-dialog-titlebar.ui-widget-header').on('click',function() {
        if(fullscreen_click == true) {
            dialogFullscreen();
            clearTimeout(fullscreen_timer);
            fullscreen_click = false;
        } else {
            fullscreen_click = true;
            fullscreen_timer = setTimeout(function() {
                fullscreen_click = false;
                clearTimeout(fullscreen_timer);
            },300);
        }
    });

    $('.ui-dialog .ui-dialog-titlebar .ui-dialog-title').before('<a class="ui-fullscreen" href="#" title="Plein écran">Plein écran</a>');
    $('.ui-fullscreen').click(function() {
        dialogFullscreen();
        return false;
    });

    wrap_autoc('Iarc','Authy','Iarc','','','','std',",'Username': request.term,'Email': request.term",'','select-box-');
    $('.left-panel-wrapper #Iarc').change(function(){
         if($('#select-box-Authy').data('authy') != $(this).val() && $(this).val() != ''){
            document.location = _SITE_URL + 'admin?iarc=' + $(this).val();
        }
    });

    $('body').on('submit','#sw-support',function() {
        if($('#support-text').val() == '') { sw_message(_SUPPORT_INSERT_MESSAGE,true,'sw-support'); }
        else if(!$('#accept-fee').is(':checked')) { sw_message(_SUPPORT_POSSI_FRAIS,true,'sw-support'); }
        else{
            $.post(_SITE_URL + 'mod/act/AuthyAct.php',{ a: 'sendSupport', text: $('#support-text').val() },function(data) {
                sw_message(data.message,data.error,data.class);
                if(data.error == false) { $('#editDialog').dialog('close'); }
            },'json');
        }
        return false;
    });


    $('body').on('click','.scroll-top',function() {
        scroll_to('');
        return false;
    });

    $('.sw-admin .left-panel .disconnect').click(function() {
       confirm('Voulez-vous vraiment vous déconnecter?',function() { window.location.href = _SITE_URL + 'disconnect'; });
       return false;
     });

    $(document).mousedown(function() { menu_change = true; primary_menu = 0; }).mouseup(function() { menu_change = false; });

    $(".ac-menu > li > a").click(function(e) {
        var hasClass = $(this).parent().hasClass("active");
        $(".ac-menu > li").removeClass("active");
        if(!hasClass) { $(".ac-menu > li ul").slideUp(); }

        $(this).next("ul.sub-menu").slideDown();
        $(this).parent().addClass("active");
    });

    $('.ac-alerts-popup').dialog({ modal: true, autoOpen:false, width:'auto', height:'auto', autoResize:true , overlay: { backgroundColor: '#000', opacity: 0.5 }
        ,open: function(event, ui) { $('.ui-dialog-titlebar-close .ui-corner-all').focus();  try {return beforeDialogOpen();}catch(e){} }
        ,beforeClose: function(event, ui) {  try { return onDialogBeforeClose(event, ui); }catch(e){} }
        ,focus: function(event, ui) {  try {return onDialogFocus();}catch(e){} }
        ,close: function(event, ui) {  try {return onDialogClose();}catch(e){} }
    });

    if ($(".ac-menu li .active").parents("ul").hasClass("sub-menu")) {
        $(".ac-menu li .active").parents("ul").show().parent().addClass("active");
    }
    var location = document.location.href.replace("'._SITE_URL.'","").split("#");
    if(location[1]){
        if($("[jhref='#"+location[1]+"']").length > 0){
            $("[jhref='#"+location[1]+"']").parent().addClass("active").find("ul").show();
        }
    }
});


var update_count = 0, update_ready = true, default_delay = 300,sw_class = [];
function build(filter) {
    if(update_count >= 10) {
        sw_message(traduction['pending_query'],true,'query-count');
        return false;
    }

    update_ready = false;
    update_count++;

    if(filter != null) {
        if(filter.sw_class != null) {
            sw_class = filter.sw_class;
            delete filter.sw_class;
        }

        filter = Object.assign(request,filter);
    } else { filter = request; }

    build_timer['start'] = new Date().getTime();

    if(filter.module) {
        $.each(filter.module,function(key,value) {
            if(key == value) {
                var section_class = sw_class[key] || 'toggle-section';
                $('[data-section=\"'+ key +'\"]').addClass(section_class);
            }
        });
    }

    $.post(_SITE_URL + 'mod/act/BuildAct.php', { filter: Object.assign({},filter)},function(data) {
        console.log(data);

        update_count--;
        if(data.message != null) { sw_message(data.message,data.error,data.class); }
        if(data.title != null) { document.title = data.title; }
        if(data.filter != null) { request = data.filter; }

        if(data.section != null && data.module != null) {
            if(data.module != null) {
                module = data.module;
                delete data.module;
            }

            build_timer['end'] = new Date().getTime();
            build_timer['duration'] = build_timer['end'] - build_timer['start'];

            $.each(data.section,function(include,value) {
                var case_found = true;

                delay_timer[include] = swDelay(section_delay[include]);

                case_found = buildModule(include,value,data);

                if(case_found == false) {
                    setTimeout(function() {
                        $('[data-section=\"'+ include +'\"]').html(value);
                        bufferClass(include);
                    },delay_timer[include]);
                }

            });
        }

        request['module'] = {};

        update_ready = true;
    },'json').fail(function() {
        update_count--;

        $('[data-section].toggle-section').removeClass('toggle-section');
        if(sw_class.length >= 1) { $.each(sw_class,function(section,class_name) { $('[data-section=\"'+ section +'\"]').removeClass(class_name); }); }

        sw_message(traduction['query_error'],true,'alert');

        update_ready = true;
    });

}

function buildModule(include,value,data) {
    var case_found = false;

    return case_found;
}
/*##########Form############*/
function bind_form(className,CcToFormEndJs){
    setTimeout(function(){
        $('#form'+className).bind('mouseleave', function (){
            $('#form'+className+' #formChanged'+className).attr('data-mouse', 'out');
        });
        $('#form'+className).bind('mouseenter', function (){
            $('#form'+className+' #formChanged'+className).attr('data-mouse', 'in');
        });
        $("#form"+className+" [s='d'],#form"+className+" .js-select-label,#form"+className+" [j='autocomplete']")
            .bind('change.form'+className+' keypress.form'+className, function (data){
                $(this).removeClass('error_field');
                $(this).parent('.js-select-label').children('.select-label-span').removeClass('error_field');
                $('#form'+className+' #save'+className).addClass('can-save');
                $('#form'+className+' #formChanged'+className).val('unsaved');
        });
        $('#form'+className+' .js-select-label').SelectBox();
        setDivContent();
        if(CcToFormEndJs){eval(CcToFormEndJs);}
    },400);
}


/*##########Liste############*/
function bulk_update_bind(className){
    $('#bulkUpdateForm').click(function (){
        if( $('[j=check_multi_'+className+']:checked').length > 0 ){
            $.post(_SITE_URL+'mod/act/'+className+'Act.php', { a:'bulkUpdateForm', ui:'editDialog', i:$('[j=check_multi_'+className+']:checked').serialize() }
            , function (data){
                $('#editDialog').html(data);
                beforeOpenDialog('editDialog');
            });
        }else{
            $('#ui-dialog-title-alertDialog').html(traductionList['attention']);
            $('#alert_texte').html(traductionList['cocherMin']);
            beforeOpenDialog('alertDialog');
        }return false;
    });
}
function robot_mgr_add_autoc(className,variableAutoc){
    if($('#add'+className+'Autoc').length > 0){
        $('#add'+className+'Autoc').bind('click', function (){
            eval('dataParam={a:\'ixmemautoc\',p:'+className+variableAutoc+'};');
            $.post(_SITE_URL+'mod/robotMgr.php',dataParam,function(data){document.location = _SITE_URL+className+'/edit/';});
        });
    }
}
function bind_ui_active(className){
    if($('#form'+className+' #idPk').length > 0 && $('#form'+className+' #idPk').val()){
        idPk=$('#form'+className+' #idPk').val();
        if($('.ui-state-active').attr('i') =='' ||$('.ui-state-active').attr('i') =='0' ){
            $('.ui-state-active').attr('i',idPk);
            $('.ui-state-active #onglet_'+className).html($('.ui-state-active #onglet_'+className+'').html()+' #'+idPk);
            $('.ui-state-active #onglet_'+className).attr('href',_SITE_URL+className+'/edit/'+idPk);
            $('.ui-state-active #onglet_'+className).attr('link',_SITE_URL+className+'/edit/'+idPk);
        }
    }
}
function bind_close_form(){
    $('#close_form').off();
    $('#toggle-form').on('click',function (){
        $('.toggle-form').fadeOut(300,function() {
             if($('#toggle-form').is(':checked')) {
                $('#toggle-form').parents('.toggle-form').addClass('toggle');
                $('.divStdform,.product-preview').slideUp(300,function() { $('.toggle-form').fadeIn(300); });
                $('.cntOnglet li').fadeOut(300);
            }else {
                $('#toggle-form').parents('.toggle-form').removeClass('toggle');
                $('.divStdform,.product-preview').slideDown(300,function() { $('.toggle-form').fadeIn(300); });
                $('.cntOnglet li').fadeIn(300).css('display','inline-block');
            }
        });
        p =$(this).parent().attr('p');tog=$(this).prop('checked');
        $.post(_SITE_URL+'mod/robotMgr.php', {a:'ixtog',p:p,tog:tog},function(data){});
    });
}
function bind_js_retract(){
    $('.js-retract').off('click');
    $('.js-retract').on('click',function() {
        var th = $(this).parent();
        var index = parseInt(th.index() + 1);
        var td = $('.tablesorter tbody tr td:nth-of-type('+ index +'), .tablesorter thead tr th:nth-of-type('+ index +')').addClass('retract');
        return false;
    });
}
function bind_autoc_list(className,pkName,uiTabsId,autoconePageAct,SelRel,child,SelEnt,SelId,SelActBefore,SelIdAuto,SelActAfter,bind_othertabs_autoc_on,formParentFull){
    $("#"+className+"ListForm tr[ecf=1] td[j='edit"+className+"']").bind('click.autocList', function (){
        eval('dataParam ={a:\'autocOne\','+pkName+':'+$(this).attr('i')+',t:\''+SelRel+'\'};');
        $.post(_SITE_URL+'mod/act/'+autoconePageAct+'Act.php', dataParam
            ,function(data){if(data.data){
                idData = data.data[0]['id'];
                var div='';if(child == 1 && $('#divCnt'+SelEnt+div+' #'+SelId+'').lenght >0){ div='divChild';}
                if(SelActBefore !=''){ eval(SelActBefore);}
                if($('#divCnt'+SelEnt+div+' #'+SelId+'').length > 0){
                    $('#divCnt'+SelEnt+div+' #'+SelId+'').val(data.data[0]['id']);
                    $('#divCnt'+SelEnt+div+' #'+SelIdAuto+'').val(data.data[0]['show']);
                    $('#divCnt'+SelEnt+div+' #'+SelIdAuto+'').focus();
                    $('#divCnt'+SelEnt+div+' #'+SelId+'').change();
                    if(bind_othertabs_autoc_on !=''){ eval(bind_othertabs_autoc_on);}
                }else if($('#formMs'+SelEnt+div+' #'+SelId+'').length > 0){
                    $('#formMs'+SelEnt+div+' #'+SelId+'').val(data.data[0]['id']);
                    $('#formMs'+SelEnt+div+' #'+SelIdAuto+'').val(data.data[0]['show']);
                    $('#formMs'+SelEnt+div+' #'+SelIdAuto+'').focus();
                    $('#formMs'+SelEnt+div+' #'+SelId+'').change();
                }else if($('#'+formParentFull+' #'+SelId+'').length > 0){
                    $('#'+formParentFull+' #'+SelId+'').val(data.data[0]['id']);
                    $('#'+formParentFull+' #'+SelIdAuto+'').val(data.data[0]['show']);
                    $('#'+formParentFull+' #'+SelIdAuto+'').focus();
                    $('#'+formParentFull+' #'+SelId+'').change();
                }
                $('#'+uiTabsId).dialog('close');
                if(SelActAfter !=''){ eval(SelActAfter);}
                $('body').css('cursor', 'auto');
            }
        });
    });
}
function do_select_funct_nc(CntParent,isChild,phpName,className,childSelectJsChampsBefore,childSelectJsChampsNothing,selectFirst,dataParam,todoAfter){
    if( $(CntParent+' .NC'+isChild+phpName+':not([readonly])').length>0){
        if( $(CntParent+' .NC'+isChild+phpName+'').val()){
            eval(childSelectJsChampsBefore);
            eval('dataParam ={'+dataParam+',ip:\"'+$(CntParent+' .NC'+isChild+phpName).val()+'\",i:\"'+$(CntParent+' #idPk').val()+'\"};');
            $.post(_SITE_URL+'mod/act/'+className+'Act.php',dataParam
            ,function(data){
                $.each(data, function (key, select) {
                    if($(CntParent+' #'+key+'Label[readonly]').length==0){
                        (function(){ parentObj = $(CntParent+' [in="in'+key+'"]');
                            if($(CntParent+' .NC'+key).length> 0 && $(parentObj).length == 0 ){ parentObj = $(CntParent+' .NC'+key).parents('.ac-search-item');}
                            if($(CntParent+' #comments'+key).length> 0){parentObj = $(CntParent+' #comments'+key);}
                        }()),
                        (function(){ $(CntParent+' [data-child-select="'+key+'"]').remove();}()),
                        (function(){
                            if( $(parentObj).children('.ac-comment-div').length > 0 && $(parentObj).children('.ac-comment-div').attr('id') != 'comments'+key ){
                                $(parentObj).children('.ac-comment-div').before(select);
                            }else{ $(parentObj).append(select);}
                        }()),
                        (function(){ eval("if(typeof sel"+key+" !== 'undefined'){ $(CntParent+' .NC"+key+"').val(sel"+key+");}");}());
                        (function(){if(todoAfter){eval(todoAfter);}}());
                        eval(selectFirst);
                    }
                });
                $(CntParent+' .js-select-label').unbind('change');
                $(CntParent+' .js-select-label').unbind('keypress');
                $(CntParent+' .js-select-label').SelectBox();
                $(CntParent+' .js-select-label').bind('change.form'+className+' keypress.form'+className+'', function (data){
                    $(this).removeClass('error_field');
                    $(this).parent('.js-select-label').children('.select-label-span').removeClass('error_field');
                    $(CntParent+' #save'+className+'').addClass('can-save');
                    $(CntParent+' #formChanged'+className+'').val('unsaved');
                });
            },'json');
        }else{eval(childSelectJsChampsNothing);}
    }
}
function bind_select_nc(CntParent,phpName,isChild){
    if($(CntParent+' .NC'+isChild+phpName).length ==0){ $(CntParent+' #'+phpName).addClass('NC'+isChild+phpName);}
    if($(CntParent+' .NC'+isChild+phpName).val()){ eval('ChildSelect'+isChild+phpName+'(\'\');');}
    $('body').off('change.childSelect'+isChild+phpName+'','.NC'+isChild+phpName);
    $('body').on('change.childSelect'+isChild+phpName+'','.NC'+isChild+phpName,function(){
        eval('ChildSelect'+isChild+phpName+'(\'\');');
    });
}
function bind_masse_action(className,upload_entite_child){
    $('#mass-action-'+className).on('click', function(){
        if( $(this).prop('checked')){ $('[j=check_multi_'+className+']').prop('checked', true);}else{ $('[j=check_multi_'+className+']').prop('checked', false);}
        $('#form'+className+' #save'+className+'').addClass('can-save');
        if(upload_entite_child != ''){eval(upload_entite_child);}
    });
    var $chkboxes = $('.actionrow label[j=check_multi_label_'+className+']');
    var $chkboxesInput = $('.actionrow input[j=check_multi_'+className+']');
    var lastChecked;
    $chkboxes.click(function(e) {
        if(!lastChecked) {
            lastChecked = this;
            return;
        }
        if(e.shiftKey) {
            e.preventDefault();
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);
            lastCheck = $('.actionrow input[id='+$(lastChecked).attr('for')+']').prop('checked');
            $chkboxesInput.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked',lastCheck);
        }
        lastChecked = this;
    });
}
function bind_button_list(className,uiTabsId,variableAutoc,ajaxPageActParent,CcToSearchMsPost,traductionList){
    if($('.js-toggle-'+className+'Search').length >0){
        $('.js-toggle-'+className+'Search').off('click');
        $('.js-toggle-'+className+'Search').on('click',function() {
            $(this).next().slideToggle(200);
            $(this).toggleClass('toggle');
            return false;
        });
    }
    if($('#formMs'+className+' #ms'+className+'BtClear').length >0){
        $('#formMs'+className+' #ms'+className+'BtClear').unbind('click.search');
        $('#formMs'+className+' #ms'+className+'BtClear').bind('click.search', function (){
            var search_open = $('.btn-toggle-search').hasClass('toggle') ? true : false;
            buildStart('#'+uiTabsId);
            sw_message(traductionList['messageClear'],false,'search-reset');
            eval('dataParam={a:\'list\',ui:uiTabsId'+variableAutoc+',ms:\'clear\''+CcToSearchMsPost+'};');
            $.post(_SITE_URL+'mod/act/'+ajaxPageActParent,dataParam,function(data){
                    setTimeout(function() {
                        buildDelay('#'+uiTabsId);
                        $('#'+uiTabsId).html(data);
                        $('#formMs'+className).show();
                        $('#formMs'+className+' input[type=text][j!=date]').first().focus();
                        $('#formMs'+className+' input[type=text][j!=date]').first().putCursorAtEnd();
                        if(search_open == true) { $('.msSearchCtnr').show();$('.btn-toggle-search').addClass('toggle');}
                        setTimeout(function() { removeMessage('search-reset');$(window).resize();},500);
                    },buildEnd());
            });
            clear_act_selectbox();
            return false;
        });
    }
    if($('#formMs'+className+' #ms'+className+'Bt').length >0){
        $('#formMs'+className+' #ms'+className+'Bt').unbind('click.search');
        $('#formMs'+className+' #ms'+className+'Bt').bind('click.search',function() {
            var search_open = $('.btn-toggle-search').hasClass('toggle') ? true : false;
            buildStart('#'+uiTabsId);
            sw_message(traductionList['messageBt'],false,'search-progress');
            $(this).attr('disabled', 'disabled');
            eval('dataParam={a:\'list\',ui:uiTabsId'+variableAutoc+',ms:$(\'#formMs'+className+'\').serialize()'+CcToSearchMsPost+'};');
            $.post(_SITE_URL+'mod/act/'+ajaxPageActParent,dataParam,function(data){
                setTimeout(function() {
                    buildDelay('#'+uiTabsId);
                    $('#'+uiTabsId).html(data);
                    $('#formMs'+className).show();
                    $('#formMs'+className+' .js-select-label').SelectBox();
                    $(this).removeAttr('disabled');
                    if(search_open == true) { $('.msSearchCtnr').show();$('.btn-toggle-search').addClass('toggle');}
                    setTimeout(function() {
                        removeMessage('search-progress');
                        $(window).resize();
                        $('#formMs'+className+' input[type=text][j!=date]').first().focus();
                        $('#formMs'+className+' input[type=text][j!=date]').first().putCursorAtEnd();
                    },300);
                 },buildEnd());
            });
            clear_act_selectbox();
            return false;
        });
        $('#formMs'+className).keydown(function(e){ if(e.which == 13){ $('#formMs'+className+' #ms'+className+'Bt').click(); }  });
    }
    if($('#formMs'+className+' #ms'+className+'AddShortcut').length >0){
        $('#formMs'+className+' #ms'+className+'AddShortcut').unbind('click.shortcut');
        $('#editPopupDialog #ms'+className+'FormShortcut').unbind('click.shortcut');
        $('#formMs'+className+' #ms'+className+'AddShortcut').bind('click.shortcut',function() {
            $(this).parents('.msSearchCtnr').addClass('current-shortcut');
            $('#editPopupDialog').html('<form data-table=\''+className+'\' class=\'shortcut-form\' id=\'ms'+className+'FormShortcut\'><input type=\'text\' name=\'shortcut-name\' id=\'shortcut-name\' placeholder=\''+traductionList['messageIdentifiant']+'\' /><button class=\'button-link-blue\'>'+traductionList['confirm']+'</button></form>');
            $('#editPopupDialog').dialog('option','width',400);
            beforeOpenDialog('editPopupDialog');
            $('#editPopupDialog #ms'+className+'FormShortcut').bind('submit.shortcut', function(){
                if($('#shortcut-name').val() == '') {
                    sw_message(traductionList['insertIdentifiant'],true,'shortcut-name');
                }else {
                    var color = $('.ac-menu .disconnect').css('color');
                    var url = _SITE_URL +className+'?ms=';
                    var name = $('#shortcut-name').val();
                    $('.msSearchCtnr.current-shortcut input').each(function() { url += $(this).attr('name') + '%3D' + $(this).val() + '%26';});
                    $.post(_SITE_URL + 'SimpleWeb/EditContent.php', {a:'stickIt',table:className,search:url,name:name,color:color,url:window.location.href},function(data){
                        if(!$('ul#sw-shortcut li.shortcut-title[data-type=\"search\"]').length) {
                            $('.sw-shortcut-content #sw-shortcut').prepend('<li class=\"shortcut-title\" data-type=\"search\">'+traductionList['recherche']+'</li>'+data.url);
                        } else {
                            $('.sw-shortcut-content #sw-shortcut li.shortcut-title[data-type=\"search\"]').after(data.url);
                        }
                        sw_message(data.message,data.error,data.class);
                        if(data.error == false) {
                            $('#editPopupDialog').dialog('close');
                            $('.sw-shortcut-wrapper').addClass('show-shortcut');
                            setTimeout(function() { $('.sw-shortcut-wrapper').removeClass('show-shortcut'); },2000);
                        }
                    },'json');
                }
                clear_act_selectbox();
                return false;
            });return false;
        });
    }
}
function pagination_sorted_bind(className,uiTabsId,variableAutoc,ajaxPageActParent,CcToSearchMsPost){
    $("#"+className+"ListForm [th='sorted']").unbind();
    $("#"+className+"ListForm [th='sorted']").bind('click', function (){
        col = $(this).attr('c');
        colR = col;
        if($(this).attr('sens') !== undefined) {
            if($(this).attr('sens') =='asc') { sens ='desc'; } else if($(this).attr('sens') == 'desc') {sens = '';} else{ sens = $(this).attr('sens'); }
        } else { sens = 'asc'; }
        if($(this).attr('rc') !== undefined){ col = $(this).attr('rc');}
        order = '{\"col\":\"'+col+'\",\"sens\":\"'+sens.toLowerCase()+'\"}';
        eval('dataParam={a:\'list\',ui:uiTabsId'+variableAutoc+',order:order, ms:$("#formMs'+className+'").serialize()'+CcToSearchMsPost+'};');
        $.post(_SITE_URL+'mod/act/'+ajaxPageActParent,dataParam,
            function(data){ $('#'+uiTabsId).html(data);$(window).resize();
        });
    });
}
function pagination_bind(className,uiTabsId,variableAutoc,ajaxPageActParent,scrooTop){
    $('#'+className+'Pagination a').off();
    $('#'+className+'Pagination a').on('click', function (){
        current_page = parseInt($('#'+className+'Pagination #page').val());
        total_page = parseInt($('#'+className+'Pagination #page').data('total'));
        if($(this).data('direction') == 'prev') { if(current_page > 1) { current_page--; } }
        else if(current_page < total_page) { current_page++; }
        $('.pagination-wrapper #page').attr('value',current_page);
        eval('dataParam={a:\'list\',ui:uiTabsId, pg:current_page'+variableAutoc+'};');
        $.post(_SITE_URL+'mod/act/'+ajaxPageActParent,dataParam, function(data){
            $('#'+uiTabsId).html(data);
            $(window).resize();
            if(scrooTop){ setTimeout(function(){ $('.scroll-top').click();},100);}
        });
    });
    $('#'+className+'Pagination #page').off();
    $('#'+className+'Pagination #page').on('keyup', function (e){
        current_page = parseInt($('#'+className+'Pagination #page').val());
        total_page = parseInt($('#'+className+'Pagination #page').data('total'));
        if(e.keyCode == 13) {
            current_page = parseInt($(this).val());
            if(current_page >= 1 && current_page <= total_page) {
                $(this).attr('value',current_page);
                eval('dataParam={a:\'list\',ui:uiTabsId, pg:current_page'+variableAutoc+'};');
                $.post(_SITE_URL+'mod/act/'+ajaxPageActParent,dataParam, function(data){
                    $('#'+uiTabsId).html(data);
                    $(window).resize();
                    if(scrooTop){ setTimeout(function(){ $('.scroll-top').click();},100);}
                });
            }
        }
    });
}
/*#####ChildBind########*/
function child_pagination_sorted_bind(className,parent,uiTabsId,pkName,CcToSearchMsPost){
    $("#cnt"+parent+"Child [th='sorted']").unbind();
    $("#cnt"+parent+"Child [th='sorted']").bind('click', function (){
        col = $(this).attr('c');colR = col;
        if($(this).attr('sens') !== undefined){ if($(this).attr('sens') == 'asc'){sens = 'desc';}else{sens = '';}}else{sens='asc';}
        if($(this).attr('rc') !== undefined){ col =$(this).attr('rc');}
        order = '{"col":"'+col+'","sens":"'+sens+'"}';
        eval('dataParam={a:\'get'+className+'List\',ui:uiTabsId,ip:pkName,order:order, ms:$("#formMs'+className+'").serialize()'+CcToSearchMsPost+'};');
        $.post(_SITE_URL+'mod/act/'+parent+'Act.php',dataParam, function(data){
            $('#'+className+'TableCntnr').html(data);
        });
    });

}
function child_bulk_update_bind(className,parent,parentId,parentContainer){
    $('#bulkUpdateForm').click(function (){
        if( $('[j=check_multi_'+className+']:checked').length > 0 ){
            $.post(_SITE_URL+'mod/act/'+parent+'Act.php', {a:'bulkUpdateForm'+className, ip:parentId, i:$('[j=check_multi_'+className+']:checked').serialize(),ui:parentContainer}
            ,function(data){
                $('#editDialog').html(data);
                beforeOpenDialog('editDialog');
            });
        }else{
            $('#ui-dialog-title-alertDialog').html(traductionList['attention']);
            $('#alert_texte').html(traductionList['cocherMin']);
            beforeOpenDialog('alertDialog');
        }return false;
    });
}
function child_button_bind(className){
    if($('#cnt'+className+'divChild .childCntClass .ac-right-action-buttons').length) {
        var child_controls=0;
        var search_width=0;
        var block_child=false;
        $(window).resize(function() {
            search_width = $('.childCntClass .msSearchCtnr form').outerWidth() - 50;
            if($('.childCntClass .msSearchCtnr form .custom-child-left').length) { search_width -= $('.childCntClass .msSearchCtnr form .custom-child-left').outerWidth(); }
            if(block_child == false) { child_controls = $('.childCntClass .ac-right-action-buttons').outerWidth();  }
            $('.contentHolderList .msSearchCtnr .ac-search-item').each(function() { search_width -= $(this).outerWidth(); });
            if(search_width < child_controls) { block_child = true; $('.childCntClass .msSearchCtnr .ac-right-action-buttons').addClass('toggle-child-nav'); }
            else if(block_child == true) {  block_child = false; $('.childCntClass .msSearchCtnr .ac-right-action-buttons').removeClass('toggle-child-nav'); }
        });
        setTimeout(function() { $(window).resize(); },300);
        $('body').off('click.ChildMenu','.toggle-child-nav-btn');
        $('body').on('click.ChildMenu','.toggle-child-nav-btn',function() {
            $('.childCntClass .msSearchCtnr .ac-right-action-buttons').toggleClass('toggle');
            return false;
        });
    }
}
function child_pagination_bind(className,parentName,uiTabsId,pkName,scrolltopChild,CcToSearchMsPost){
    $('#'+className+'Pagination #page').off();
    $('#'+className+'Pagination #page').on('keyup', function (e){
        current_page = parseInt($('#'+className+'Pagination #page').val());
        total_page = parseInt($('#'+className+'Pagination #page').data('total'));
        if(e.keyCode == 13) {
            current_page = parseInt($(this).val());
            if(current_page >= 1 && current_page <= total_page) {
                $(this).attr('value',current_page);
                eval('dataParam={a:\'get'+className+'List\',ui:uiTabsId,pg:current_page,ip:pkName,ms:$("#formMs"+className).serialize()'+CcToSearchMsPost+'};');
                $.post(_SITE_URL+'mod/act/'+parentName+'Act.php',dataParam,function(data){
                    $('#'+className+'TableCntnr').html(data);
                    eval(scrolltopChild);
                });
            }
        }
    });
    $('#'+className+'Pagination a').off();
    $('#'+className+'Pagination a').on('click', function (){
        current_page = parseInt($('#'+className+'Pagination #page').val());
        total_page = parseInt($('#'+className+'Pagination #page').data('total'));
        if($(this).data('direction') == 'prev') { if(current_page > 1) { current_page--; } }
        else if(current_page < total_page) { current_page++; }
        $('.pagination-wrapper #page').attr('value',current_page);
        eval('dataParam={a:\'get'+className+'List\',ui:uiTabsId,pg:current_page,ip:pkName,ms:$("#formMs"+className).serialize()'+CcToSearchMsPost+'};');
        $.post(_SITE_URL+'mod/act/'+parentName+'Act.php',dataParam,function(data){
            $('#'+className+'TableCntnr').html(data);
            eval(scrolltopChild);
        });
        return false;
    });
}

function child_bind_button_list(className,parentName,pkName,IdPkName,parentContainer,CcToSearchMsPost,traductionList){
    $('#'+className+'ListForm #formMs'+className).keypress(function(e){
        if(e.which ==13){
            buildStart('#'+className+'TableCntnr');
            sw_message(traductionList['messageBt'],false,'search-progress');
            eval('dataParam={a:\'get'+className+'List\',ui:\''+className+'Table\',ip:IdPkName,ms:$("#formMs"+className).serialize()'+CcToSearchMsPost+'};');
            $.post(_SITE_URL+'mod/act/'+parentName+'Act.php',dataParam
            ,function(data){
                setTimeout(function() {
                    buildDelay('#'+className+'TableCntnr');
                    $('#'+className+'TableCntnr').html(data);
                },buildEnd());
            });
            e.preventDefault();
        }
    });
    if($('#formMs'+className+' #ms'+className+'BtClear').length >0){
        $('#formMs'+className+' #ms'+className+'BtClear').unbind('click.search');
        $('#formMs'+className+' #ms'+className+'BtClear').bind('click.search', function (){
            buildStart('#'+className+'TableCntnr');
            sw_message(traductionList['messageClear'],false,'search-reset');
            eval('dataParam={a:\'get'+className+'List\',ui:\''+className+'Table\',pui:parentContainer,ip:IdPkName,ms:\'clear\''+CcToSearchMsPost+'};');
            $.post(_SITE_URL+'mod/act/'+parentName+'Act.php',dataParam,function(data){
                setTimeout(function() {
                    buildDelay('#'+className+'TableCntnr');
                    $('#'+className+'TableCntnr').html(data);
                    setTimeout(function() { removeMessage('search-reset');$(window).resize();},500);
                },buildEnd());
            }); return false;
        });
    }
    if($('#formMs'+className+' #ms'+className+'Bt').length >0){
        $('#formMs'+className+' #ms'+className+'Bt').unbind('click.search');
        $('#formMs'+className+' #ms'+className+'Bt').bind('click.search', function (){
            buildStart('#'+className+'TableCntnr');
            sw_message(traductionList['messageBt'],false,'search-reset');
            $(this).attr('disabled', 'disabled');
            eval('dataParam={a:\'get'+className+'List\',ui:\''+className+'Table\',pui:parentContainer,ip:IdPkName,ms:$("#formMs'+className+'").serialize()'+CcToSearchMsPost+'};');
            $.post(_SITE_URL+'mod/act/'+parentName+'Act.php',dataParam,function(data){
                setTimeout(function() {
                    buildDelay('#'+className+'TableCntnr');
                    $('#'+className+'TableCntnr').html(data);
                    $(this).removeAttr('disabled');
                    setTimeout(function() { removeMessage('search-reset');$(window).resize();},500);
                },buildEnd());
            }); return false;
        });
    }
    $('.js-toggle-'+pkName+'_'+className+'Search').on('click',function() {
        $(this).next().slideToggle(200);
        $(this).toggleClass('toggle');
        return false;
    });
 }
function changePic(then,childTableName){
    if($(then).length>0){
        var src = $(then).attr('src');
        var i = $(then).attr('i');
        src = src.replace('_thumb','');
        var ext = src.split('.').pop();
        ext = ext.split('?').shift();

        if($('.popup-container:visible').length >0 ){
            $('.popup-container:visible .thumbnail-open').attr('src',src).stop(true,true).hide().fadeIn('slow');
        }else{
            /*popup(
                '<button data-nav="prev" class="js-nav-lightbox btn-lightbox"></button>'
                +'<img i="'+i+'" class="open-image-link '+ext+' thumbnail-open" src="'+src+'" />'
                +'<button data-nav="next" class="js-nav-lightbox btn-lightbox"></button>'
                +'<div class="button-wrapper">'
                    +'<button class="button-link js-close">'+_VAR_FERMER+'</button>'
                    +'<button class="button-link js-copy-clipboard">'+traductionList['copylink']+'</button>'
                    +'<button i="'+i+'" class="js-copy-dowload button-link">'+traductionList['telecharger']+'</button>'
                +'</div>'
            ,false);*/

            if (typeof _isMobile !== 'undefined' && _isMobile!=0) {
                popup(
                    '<div class="img-wrapper"><img i="'+i+'" class="open-image-link '+ext+' thumbnail-open" src="'+src+'" /></div>'
                    +'<div class="button-wrapper">'
                        +'<button class="button-link close-popup js-close">'+_VAR_FERMER+'</button>'
                        +'<button class="button-link js-copy-clipboard">'+traductionList['copylink']+'</button>'
                        +'<button i="'+i+'" class="js-copy-dowload button-link">'+traductionList['telecharger']+'</button>'
                        +'<button data-nav="prev" style="display:none!important;" class="js-nav-lightbox btn-lightbox button-link">'+traductionList['lightbox_prev']+'</button>'
                        +'<button data-nav="next" style="display:none!important;" class="js-nav-lightbox btn-lightbox button-link">'+traductionList['lightbox_next']+'</button>'
                    +'</div>'
                ,false);
            }else{
                 popup(
                    '<div class="img-wrapper"><img i="'+i+'" class="open-image-link '+ext+' thumbnail-open" src="'+src+'" /></div>'
                    +'<div class="button-wrapper">'
                        +'<button class="button-link close-popup js-close">'+_VAR_FERMER+'</button>'
                        +'<button class="button-link js-copy-clipboard">'+traductionList['copylink']+'</button>'
                        +'<button i="'+i+'" class="js-copy-dowload button-link">'+traductionList['telecharger']+'</button>'
                        +'<button data-nav="prev" class="js-nav-lightbox btn-lightbox button-link">'+traductionList['lightbox_prev']+'</button>'
                        +'<button data-nav="next" class="js-nav-lightbox btn-lightbox button-link">'+traductionList['lightbox_next']+'</button>'
                    +'</div>'
                ,false);
            }
        }
        var ii = $(then).attr('ii');
        iii = parseInt(ii)+1;iiii = parseInt(ii)-1;
        if($('#listFormChild .actionrow [j=image'+childTableName+'] [ii='+(iii)+']').length){
            $('.popup-container [data-nav=next]').prop('disabled','');
            $('.popup-container [data-nav=next]').attr('i',$('#listFormChild .actionrow [j=image'+childTableName+'] [ii='+(iii)+']').attr('i'));
        }else{
            $('.popup-container [data-nav=next]').prop('disabled','disabled');
            $('.popup-container [data-nav=next]').attr('i','');
        }
        if($('#listFormChild .actionrow [j=image'+childTableName+'] [ii='+(iiii)+']').length){
            $('.popup-container [data-nav=prev]').prop('disabled','');
            $('.popup-container [data-nav=prev]').attr('i',$('#listFormChild .actionrow [j=image'+childTableName+'] [ii='+(iiii)+']').attr('i'));
        }else{
            $('.popup-container [data-nav=prev]').prop('disabled','disabled');
            $('.popup-container [data-nav=prev]').attr('i','');
        }
    }
}
function checkKeyThumb(e) {
    if($('body .popup-container:visible').length>0){
        e = e || window.event;
        if (e.keyCode == '37') {
            if($('body .popup-container [data-nav=prev]:visible').length>0){ $('body .popup-container [data-nav=prev]:visible').click();}
        }else if (e.keyCode == '39') {
            if($('body .popup-container [data-nav=next]:visible').length>0){ $('body .popup-container [data-nav=next]:visible').click();}
        }
   }
}
var swipe=0;
function bindChangePic(childTableName,ParentClassname){
    document.onkeydown = checkKeyThumb;
    if (typeof _isMobile !== 'undefined' && _isMobile!=0) {
        $.getScriptOnce(_SRC_URL+'js/swipe.jquery.js', function(data,textStatus,jqxhr) {
            $('body')
                .swipeDetector()
                .on('swipeLeft.sd swipeRight.sd', function(event) {
                    swipe=1;
                    if (event.type === 'swipeLeft') {
                        if($('body .popup-container [data-nav=next]').length>0){
                            changePic($('#listFormChild .actionrow [j=image'+childTableName+'][i='+$('body .popup-container [data-nav=next]').attr('i')+'] .thumbnail-file'),childTableName);
                        }
                    }else if (event.type === 'swipeRight') {
                        if($('body .popup-container [data-nav=prev]').length>0){
                            changePic($('#listFormChild .actionrow [j=image'+childTableName+'][i='+$('body .popup-container [data-nav=prev]').attr('i')+'] .thumbnail-file'),childTableName);
                        } 
                    }
                    setTimeout(function() {swipe=0; },100);
                    return false;
            });
        });
    }
    $('body').off('click.Thumbnail','.thumbnail-file');
    $('body').on('click.Thumbnail','.thumbnail-file',function() { 
        changePic($(this),childTableName);
        return false;
    });
    $('body').on('click.next','.popup-container [data-nav=next],.popup-container [data-nav=prev]',function() {
        if($(this).attr('i') && $('#listFormChild .actionrow [j=image'+childTableName+'][i='+$(this).attr('i')+'] .thumbnail-file').length>0 && !swipe){
            changePic($('#listFormChild .actionrow [j=image'+childTableName+'][i='+$(this).attr('i')+'] .thumbnail-file'),childTableName);
        }return false;
    });
    $('body').on('click.ThumbnailLink','.open-image-link',function(event) {
        event.stopPropagation();
        var src = $('img.thumbnail-open').attr('src');
        window.open(src);
        return false;
    });
    $('body').on('click.Thumbnail','.js-close',function(event) {event.stopPropagation();popup();return false;});
    
    $('body').on('click.Thumbnail','.js-copy-dowload',function(event) {
        event.stopPropagation();
        var src = $('img.thumbnail-open').attr('src');
        document.location.href=_SITE_URL+'mod/act/'+childTableName+'Act.php?a=ForceDl&pc='+ParentClassname+'&i='+$('#'+childTableName+'Table .thumbnail-file[src="'+src+'"]').attr('i');
        return false;
    });
    $('body').on('click.Thumbnail','.js-copy-clipboard',function() {
        var src = $('img.thumbnail-open ').attr('src');
        var targetId = 'copy-text';
        var target = document.createElement('textarea');
        target.style.position = 'absolute';
        target.style.left = '-9999px';
        target.style.top = '0';
        target.id = targetId;
        document.body.appendChild(target);
        target.textContent = src;
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);
        try {
            document.execCommand('copy');
            sw_message(traductionList['liencopie'],false,'copy-success');
            popup();
        } catch(e) {
            sw_message(traductionList['impliencopie'],true,'copy-error');
        }
        $('#copy-text').remove();
        target.textContent = '';
        return false;
    });
}
