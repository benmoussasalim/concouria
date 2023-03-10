
/*###############################
#	Progexpert
###############################*/
if (typeof _isMobile === "undefined") {var _isMobile=0;}           
var act_confirm ='';/*sans le passé en paramettre*/
var alert_close ='';/*sans le passé en paramettre*/
var act_negatif ='';window.confirm = function(obj,act_t){
    act_confirm =act_t;
    $('#confirm_text').html(obj);
    beforeOpenDialog('confirmDialog');
};
$(document).ready(function() {
    $('body').on('keyup','[type=password]',function(e) {
        $(this).parents('.divtr').addClass('show-password-btn');
        $(this).parents('.divtr').find('.show-password').show();
    });
    if(_isMobile == 0) {
        $('body').on('mousedown','.show-password',function() {
            $(this).prev().addClass('active-password');
            $(this).prev().attr('type','text');

            $(document).off('mouseup.show-password');
            $(document).on('mouseup.show-password',function() {
                $('input.active-password').attr('type','password');
                $('input.active-password').removeClass('active-password');
            });
        });
    } else {
        $('body').on('click','.show-password',function() {
            if($(this).prev().hasClass('active-password')) {
                $('input.active-password').attr('type','password');
                $('input.active-password').removeClass('active-password');
            } else {
                $(this).prev().addClass('active-password');
                $(this).prev().attr('type','text');
            }            
        });
    }
    $('body').on('click.selectbox',function(e) {
        if(e.originalEvent !== undefined){
            if(!$(e.originalEvent.target).hasClass('select-label-span') && $(e.originalEvent.target).parents(".select-element").length ==0){
                $('.js-select-label.show').each(function( index, value ) {
                    $(this).close();
                });
            } 
        } 
    });
    $('body').on('click','.show-password',function() { return false; });
    
    $('body').on('mouseup','.show-password',function() {
        $(this).prev().attr('type','password');
        return false;
    });

    $('body').on('click','.trigger-menu',function() {
        $('#body').toggleClass('toggle-left-panel');
        $.post(_SITE_URL+'mod/robotMgr.php',{a:'ixmenu',v:$('#body').hasClass('toggle-left-panel')},function(data){ });
        return false;
    });
    $('body').on('click','[j=info-button-parent]',function() {
        var info =$(this).data('info');
        if(!info && $('#cntOnglet'+$(this).data('info-table')+" ul li.ui-tabs-active").length >0){
            info =$(this).data('info')+'_'+$('#cntOnglet'+$(this).data('info-table')+" ul li.ui-tabs-active a").html();
        }
        
        $.post(_SITE_URL+'mod/robotMgr.php',{a:'ml',ml:info},function(data){ 
            if(data){
                $('#alertDialog').parent().find('.ui-dialog-title').html(_TITLE_MESSAGE_INFO);
                $('#alertDialog #alert_texte').html(data);
                beforeOpenDialog('alertDialog');
            }
        });
        return false;
    });   
    $('body').on('click','[j=info-button]',function() {

        $.post(_SITE_URL+'mod/robotMgr.php',{a:'ml',ml:$(this).data('info')},function(data){ 
            if(data){
                $('#alertDialog').parent().find('.ui-dialog-title').html(_TITLE_MESSAGE_INFO);
                $('#alertDialog #alert_texte').html(data);
                beforeOpenDialog('alertDialog');
            }
        });
        return false;
    });

    var has_search = true;
    $('body').on('click','.trigger-search',function() {
        if(has_search == true) {
            has_search = false;
            $('.msSearchCtnr').slideUp(500);
            $('.trigger-search span').text('Afficher la recherche');
        } else {
            has_search = true;
            $('.msSearchCtnr').slideDown(500);
            $('.trigger-search span').text('Masquer la recherche');
        }

        return false;
    });

    $('.ui-tabs .ui-tabs-nav').css('padding', '0');
    $('.ui-widget').css('font-size', '.8em');
    /* dialog*/
    $('#editDialog').dialog({
        modal: true, autoOpen:false, width:'auto', height:'auto', autoResize:true , overlay: { backgroundColor: '#000', opacity: 0.5 }
        ,open: function(event, ui) { 
            dialogWidthClass($(this)); 
            $('.ui-dialog-titlebar-close .ui-corner-all').focus();  
           
        }
        ,beforeClose: function(event, ui) {  
            try { remove_open_box(); return onDialogBeforeClose(event, ui); }catch(e){} 
        }
        ,focus: function(event, ui) {  try {return onDialogFocus();}catch(e){} }
        ,resize: function(event, ui) { dialogMem($(this)); }
        ,dragStart: function( event, ui ) {$('.js-select-label.show').close();}
        ,dragStop: function( event, ui ) { dialogMem($(this)); }
        ,close: function(event, ui) {  try {return onDialogClose();}catch(e){} } });

    $('#loadingDialog').dialog({
        resizable: false,closeText: 'hide',dialogClass: 'no-close', modal: true, autoOpen:false, width:'80', autoResize:false
        ,overlay: { backgroundColor: '#000', opacity: 0.5 }
        ,beforeClose: function(event, ui) {  try { remove_open_box(); return onDialogBeforeClose(event, ui); }catch(e){} }
        ,resize: function(event, ui) { dialogMem($(this)); }
        ,dragStart: function( event, ui ) {$('.js-select-label.show').close();}
        ,dragStop: function( event, ui ) { dialogMem($(this)); }
        ,open: function(event, ui) { dialogWidthClass($(this));$(this).parent().children('.ui-dialog-titlebar').hide();},
    });

    $('#editPopupDialog').dialog({
        modal: true, autoOpen:false, width:'auto', height:'auto', autoResize:true
        ,overlay: { backgroundColor: '#000', opacity: 0.5 }
        ,open: function(event, ui) { dialogWidthClass($(this)); $('.ui-dialog-titlebar-close .ui-corner-all').focus();  }
        ,beforeClose: function(event, ui) {  try { remove_open_box(); return onDialogBeforeClose(event, ui); }catch(e){} }
        ,focus: function(event, ui) {  try {return onDialogFocus();}catch(e){} }
        ,resize: function(event, ui) { dialogMem($(this)); }
        ,dragStart: function( event, ui ) {$('.js-select-label.show').close();}
        ,dragStop: function( event, ui ) { dialogMem($(this)); }
        ,close: function(event, ui) {
            try {
                if ($(this).hasClass('ac-autocomplete')) {
                    $(body).removeClass('ac-no-overflow');
                    $('#editPopupDialog').removeClass('ac-autocomplete').height('auto');
                }
                return onDialogClose();
            }catch(e){}
        }
    });


    $('#confirmDialog').dialog({
        create: function( event, ui ) { $('#confirmDialog').parents('.ui-dialog').find('.ui-dialog-title').attr('id','ui-dialog-title-confirmDialog');}
        ,dialogClass: 'dialog-message',resizable: false,modal: true, autoOpen:false, width:'430', height:'auto', autoResize:false , overlay: { backgroundColor: '#000', opacity: 0.5 }
        ,open: function(event, ui) {
            dialogWidthClass($(this));
            $('.ui-dialog-titlebar-close .ui-corner-all').focus();
            
        }
        ,beforeClose: function(event, ui) {  try { remove_open_box(); return onDialogBeforeClose(event, ui); }catch(e){} }
        ,focus: function(event, ui) {  try {return onDialogFocus();}catch(e){} }
        ,close: function(event, ui) {
            try {
                $('[role=\\"button\\"][type=\\"button\\"]').show();
                $('#title_confirm').html('Message');
                $('#confirm_text').html('');
                remove_open_box();
               
                return onDialogClose();
            }catch(e){}
        }
        ,resize: function(event, ui) { dialogMem($(this)); }
        ,dragStart: function( event, ui ) {$('.js-select-label.show').close();}
        ,dragStop: function( event, ui ) { dialogMem($(this)); }
        ,buttons:[
            {
                text:_VAR_OUI,'class':'button-link-blue',click: function() {
                    if($.isFunction(act_confirm)) { act_confirm(); } else { eval(act_confirm); };
                    setTimeout(function(){ $('#confirmDialog').dialog('close');}, 100);
                }
            },
            {
            text:_VAR_NON,'class':'button-link-gray',click: function() {
                if($.isFunction(act_negatif)) { act_negatif(); } else { eval(act_negatif);  }
                setTimeout(function(){ $('#confirmDialog').dialog('close');}, 100);
            }}
            ]
    });

    $('#alertDialog').dialog({
        create: function( event, ui ) { 
            $('#alertDialog').parents('.ui-dialog').find('.ui-dialog-title').attr('id','ui-dialog-title-alertDialog');
        }
        , dialogClass: 'dialog-message'
        , resizable: false
        , modal: true
        , autoOpen:false, width:'430'
        , height:'auto'
        , autoResize:false 
        , overlay: { backgroundColor: '#000', opacity: 0.5 }
        , open: function(event, ui) { 
            dialogWidthClass($(this)); 
            $('.ui-dialog-titlebar-close .ui-corner-all').focus();  
        }
        ,beforeClose: function(event, ui) {  
            try {
                remove_open_box();
                return onDialogBeforeClose(event, ui); 
            }catch(e){
                
            } 
        },
        focus: function(event, ui) {  
            try {return onDialogFocus();}catch(e){} 
        },
        resize: function(event, ui) { dialogMem($(this)); },
        dragStart: function( event, ui ) {$('.js-select-label.show').close();},
        dragStop: function( event, ui ) { dialogMem($(this)); },
        close: function(event, ui) {  try {return onDialogClose();}catch(e){}
            $('[role=\\"button\\"][type=\\"button\\"]').show();
            $('#title_alert').html('Message');
            $('#confirm_text').html('');
        }
        
        ,buttons:[
            {
                text:_VAR_FERMER,'class':'button-link-blue',click: function() {
                    $('#alertDialog').dialog('close');
                    if($.isFunction(alert_close)){
                        alert_close();
                    }else if(alert_close){
                        eval(alert_close);
                    }
                    delete alert_close;
                }
            }
        ]


    });
    $(window).resize(function() {
        if(timerResizeControls){clearTimeout(timerResizeControls);}
        timerResizeControls=setTimeout(function(){ 
            $('.sw-header').each(function( index, value ) {
                if(!$(this).hasClass('toggle-custom-menu') && $(this).parent().find('.sw-header .custom-controls').children().length > 1){
                    parent = $(this).parent();
                    var header_width = $(this).width();
                    var default_controls =  $(this).parent().find('.sw-header .default-controls').outerWidth();
                    var custom_controls = $(this).parent().find('.sw-header .custom-controls').outerWidth();
                    if (header_width === undefined) { header_width=100; }
                    if (default_controls === undefined) { default_controls=20; }
                    if (custom_controls === undefined) { custom_controls=20; }
                    if(custom_controls >= (header_width - default_controls)) {
                        $(this).addClass('toggle-custom-menu');
                    }else{
                        $(this).removeClass('toggle-custom-menu');
                    }
                }
            });
            $('.custom-controls').fadeIn(100);
            $('textarea:not(.tinymce)').each(function(){ 
                $(this).css({'height':'','overflow-y':''});
                this.setAttribute('style','height:'+(this.scrollHeight)+'px;overflow-y:hidden;'+$(this).attr('style'));
            });
        },500);
    });
    $(window).resize();
    $('body').on('click','select[multiple] option', function(){
        var str =$(this).parent().attr('val');
          if(str){ var res = str.split(","); 
        }else{ var res =[];}
        if(
            $(this).parent().find('option:selected').length==1
            && $(this).attr('selected') != "selected"
        ){
            $(this).parent().children('option').removeAttr('selected');
            $(this).attr('selected','selected');
            $(this).prop('selected', true);
            $(this).parent().attr('val',$(this).val());
        }else{
            if($(this).attr('selected')){
                $(this).removeAttr('selected');
                index = res.indexOf($(this).val());
                res.splice(index,1);  
            }else{
                $(this).attr('selected','selected');
                res.push($(this).val());
            }
            $(this).parent().attr('val',res);
        }
        return false;
    }); 
    $('body').on('click','.btn-custom-controls',function() {
        $(this).parents('.sw-header').find('.custom-controls').toggleClass('toggle');
        return false;
    });
    
    $(document).bind('keydown', function(event) {
    if (event.ctrlKey || event.metaKey) {
            if(String.fromCharCode(event.which).toLowerCase() == 's') {
                if($('.ui-dialog [act=save]').first().length>0){
                    $('.ui-dialog [act=save]').first().trigger('click');
                }else{
                    $('form [act=save]').first().trigger('click');
                }event.preventDefault();
            }
        }
    });
    $('body').on('click','.formContent .js-btn-info',function() {
        if($(this).children('span').hasClass('toggle')) {
            $(this).children('span').removeClass('toggle');
            $('.js-btn-info span').removeClass('toggle');
        } else {
            $(this).children('span').removeClass('toggle');
            $('.js-btn-info span').removeClass('toggle');
            $(this).children('span').addClass('toggle');
        }      
        return false;
    });
    $('textarea:not(.tinymce)').each(function(){ this.setAttribute('style','height:'+(this.scrollHeight)+'px;overflow-y:hidden;');});
    $("body").on( "input", "textarea:not(.tinymce)", function(){
        this.style.height='auto';
        this.style.height=(this.scrollHeight)+'px';
    });
});





function bind_othertabs_std(conteneur){
    $('[otherTabs=1],[otherTabs=2]').unbind('keydown.bind_othertabs_std');
    $('[otherTabs=1],[otherTabs=2]').bind('keydown.bind_othertabs_std', function(e) {
        if($('label.js-select-label.show').length ==0){
            if(e.keyCode == 13 && !$(this).is('textarea')) {
                if($(this).parents('.msSearchCtnr[CntTabs=1]').attr('class')){
                    var id = $(this).parents('.msSearchCtnr[CntTabs=1]').children('form').attr('id');
                    if($(this).parents('.msSearchCtnr[CntTabs=1]').find('#ms'+id.replace('formMs','')+'Bt')){
                        $(this).parents('.msSearchCtnr[CntTabs=1]').find('#ms'+id.replace('formMs','')+'Bt').click();e.preventDefault();return 0;
                    }
                }
            }
            if((e.keyCode == 13 && !$(this).is('textarea') && e.shiftKey === true ) || (e.keyCode == 9 && e.shiftKey === true) ) {
                selectNext(e, $(this),0);
            }else if((e.keyCode == 13 && !$(this).is('textarea') && e.shiftKey !== true  ) || (e.keyCode == 9 && e.shiftKey !== true ) ) {
                selectNext(e, $(this),1);
            }
        }else{
            if((e.keyCode == 9 && e.shiftKey === true) ) {
                selectNext(e, $(this),0);
            }else if((e.keyCode == 9 && e.shiftKey !== true ) ) {
                selectNext(e, $(this),1);
            }
        }
    });
    if(conteneur){ var inputs = $(""+conteneur+"[CntTabs=1]").find('[otherTabs=1]:visible,[otherTabs=2]:visible');
    }else{ var inputs = $("div.divStdform[CntTabs=1]").find('[otherTabs=1]:visible,[otherTabs=2]:visible'); }

}
var last_enter = null;
function selectNext(e, elem,act){
    if(e)
        e.preventDefault();
    var now = new Date().getTime(), diff;
    if( last_enter != null ) {
        diff = now - last_enter;
        if( diff < 200 ) {
            return false;
        }
    }
    /* postal code validation */
    if(act && $(elem).attr('PostalCode') == 1){
        if($(elem).attr('vpcode') != 1){
            $(elem).val('');
            return;
        }
    }
    /* phone number validation */
    if(act && $(elem).attr('PhoneNumber') == 1){
        if($(elem).attr('vphone') != 1){
            $(elem).val('');
            return;
        }
    }
    /* block ValueNeeded tab */
    if(act && $(elem).attr('ValueNeeded') == 1){
        if(!$(elem).val()){
            $(elem).focus();
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
    }
    last_enter = now;
    /* [class!=inputCourantName] */
    var inputs = $(elem).parents("[CntTabs=1]").find('[otherTabs=1]:visible,[otherTabs=2]:visible');
    if(act){
        var next = inputs.eq( inputs.index(elem)+ 1);
        if(next.length ==0){ var next = inputs.eq(0);}
    }else{ var next = inputs.eq(inputs.index(elem)- 1);}
    if( ($(elem).attr('type') == 'button' || $(elem).attr('type') == 'submit') && e.keyCode == 13 ){
        $(elem).trigger('click');
        return;
    }
    if($(next).is('select')){
        $(next).focus();
        $(next).select().trigger('click');
    }else if($(next).is('td')){
        $(next).focus();
        $(next).trigger('click');
    }else{
        $(next).focus().select();
    }
    if($(elem).hasClass('hasDatepicker')){
        if($(elem).datepicker( "widget" ).is(":visible")){
            $(elem).datepicker("hide");
        }
    }
    $(elem).trigger('onchange');
    return;
}
                

var timerResizeControls;
var timerdialogWidthClass =0;
var changeDialog =false;
var box_open = false;

var _iOSDevice = !!navigator.platform.match(/iPhone|iPod|iPad/);
var freeze = function(e) {if (!document.getElementsByClassName("fixed-element")[0].contains(e.target)) {e.preventDefault();}};
function remove_open_box(){
    if($('.ui-dialog:visible').length < 2){
        box_open = false;
        /*$('body,html').removeClass('open-box');*/
        /*if(_iOSDevice){enableScroll();}*/
    }  
}
function append_open_box(){
    box_open = true;
    /*$('body,html').addClass('open-box');
    if(_iOSDevice){disableScroll();}*/
}

function clear_act_selectbox(){
    $('.js-select-label.show').each(function( index, value ) {
        $(this).unbindMouseMultiple();
        $(this).close();
    });
}

function dialogMem(element) {
    dialogWidthClass($(element));
    var w=$(element).parent('.ui-dialog').width();
    var h=$(element).parent('.ui-dialog').height();
    var position=$(element).parent('.ui-dialog').position();
    var y=position.top;
    var x=position.left;
    y = y-$(window).scrollTop();
    if(y<0){y=0;}
    var win=$(element).attr('id');
    clearTimeout(timerdialogWidthClass);
    timerdialogWidthClass=setTimeout(function(){ $.post(_SITE_URL+'mod/robotMgr.php', { a:'uiED',w:w,h:h,cc:CurrentClass,act:currentA,win:win,y:y,x:x},function(data){});},500);
}
var currentA;var CurrentClass;var curVal;var openDialog;
_isMobile='';
function beforeDatePicker(name){
    if(!name){name='#body';}
    $(name+' [j=date]').each(function( index ) {
       if(!$(this).parent().hasClass("has-unit") && !$(this).prop('readonly')){ 
           $(this).parent().addClass('date-calendar');
       }
    });	
    
    $('#body .date-calendar').on('click.bind-reset','.btn-reset',function(){
        $(this).parent().children('[j=date]').val('').change();
        return false;
    });

    $(name+' [j=date]').unbind('change.value-color');
    $(name+' [j=date]').bind('change.value-color',function(){
            $(this).addClass('gray');
            $(this).parent().addClass('gray');
        if($(this).val() != ''){ 
            if($(this).parent().find('.btn-reset').length ==0){ 
                $(this).parent().append('<button class=btn-reset></button>');  
            }
            $(this).removeClass('gray');
            $(this).parent().removeClass('gray');
        }
    });
    $(name+' [j=date]').change();
    $(name+' [j=date]').attr('type', 'text');
    $(name+' [j=date]')
        .datepicker({
            beforeShow: function(){ if(_isMobile==1){ $(this).attr('readonly','readonly'); $(this).blur();}}
            ,dateFormat: 'yy-mm-dd'
            ,changeYear: true
            , changeMonth: true
            , yearRange: '1940:2050'
            , showOtherMonths: true
            , selectOtherMonths: true
            , onSelect: function(dateText,inst) {
                $(this).change();
                if($('[id='+$(this).attr('id')+']').length>1){
                    var upperZ=0;var dialogId;
                    $('.ui-dialog:visible').each(function() {
                        if(upperZ < $(this).css('z-index')){upperZ = $(this).css('z-index');dialogId =$(this).find('.ui-dialog-content').attr('id');}
                    });
                    if( dialogId != 'confirmDialog' && dialogId != 'loadingDialog' ){
                        if($('#'+dialogId+' #'+$(this).attr('id')).length>0){
                            $('#'+dialogId+' #'+$(this).attr('id')).val($(this).val());
                            if( $(this).data('previous') != dateText ){
                                $(this).val($(this).data('previous'));
                            }
                        }
                    }
                }
            }
        });
    $(name+' [j=date]').attr('autocomplete', 'off');
}
function beforeOpenDialog(name){
    if(_isMobile==1 || $(window).width() <= 1024){
        append_open_box();
        $('body #css_'+name+'').remove();
       
        if(name != 'loadingDialog' && name != 'confirmDialog' && name != 'alertDialog' ){
            $('body').append('<style id="css_'+name+'">.css_'+name+'_class{max-width: 100%!important;margin:auto 0;left:0px!important;width:100vw!important;min-height:90vh!important;}</style>'); 
        }else{ $('body').append('<style id="css_'+name+'">.css_'+name+'_class{margin:auto 0;left:0px!important;width:'+$(window).width()+'px!important;}</style>');}
        $('#'+name).parent('.ui-dialog').addClass('css_'+name+'_class'); 
        $('#'+name).dialog('option','width','100vw');
        $('#'+name).dialog( "option", "position", { my: "top", at: "top", of: window});
        $('#'+name).dialog('open');
        if(name != 'loadingDialog' && name != 'confirmDialog' && name != 'alertDialog' ){
            setTimeout(function(){
                $('#'+name+'.ui-dialog-content').css('height','90vh');
                $('body #css_'+name+'').remove();
            },500);
        }
    }else{
        if(name != 'loadingDialog' && name != 'confirmDialog' && name != 'alertDialog' ){
            then =$('#'+name).dialog();
            openDialog=false;
            $.post(_SITE_URL+'mod/robotMgr.php', {a:'getUiED'},function(winsConf){
                if(winsConf){
                    $.each(winsConf, function(name, win) {
                        if(typeof win !== 'undefined'){
                            eval('curVal= win.'+currentA+';');
                            if(curVal){
                                eval('curVal= curVal.'+CurrentClass+';');
                                if(curVal && $(then).length > 0 && $(then).attr('id') == name){
                                    curVal.y = parseFloat(curVal.y)+$(window).scrollTop();if(curVal.y < 0){curVal.y =0;}
                                    if(curVal.y > ($(window).height()+$(window).scrollTop())){curVal.y =0;}
                                    if(($(window).height()*0.15) < curVal.h){ curVal.h=$(window).height()-($(window).height()*0.15);}
                                    if($(window).width() < curVal.w){curVal.w=$(window).width(); }
                                    if(curVal.w){ $('#'+name).dialog('option','width',curVal.w);}
                                    if(curVal.h){ $('#'+name).dialog('option','height',curVal.h);}
                                    dialogWidthClass($('#'+name));
                                    $('#'+name).parent('.ui-dialog').addClass('css_'+name+'_class');
                                    $('body #css_'+name+'').remove();
                                    $('body').append('<style id="css_'+name+'">.css_'+name+'_class{left:'+curVal.x+'px!important;top:'+curVal.y+'px!important;}</style>');
                                    openDialog=true;
                                    $('#'+name).dialog('open');
                                    if($(window).height() && curVal.h > $(window).height()){
                                        curVal.h =($(window).height())-($(window).height()*0.15);
                                    }
                                    var curValFun=curVal;
                                    setTimeout(function(){ 
                                        if(curValFun && curValFun.x && curValFun.y){
                                            $('#'+name).parent('.ui-dialog').css('left',curValFun.x+'px');
                                            $('#'+name).parent('.ui-dialog').css('top',curValFun.y+'px');
                                            $('body #css_'+name+'').remove();
                                        }
                                    },500);

                                }
                            }
                        } 
                    }); 
                }
                if(!openDialog){ 
                    if(($(window).height()*0.15) < $('#'+name).dialog('option','height')){
                        $('#'+name).dialog('option','height',($(window).height())-($(window).height()*0.15));
                    }
                    $('#'+name).dialog('option','maxHeight',($(window).height())-($(window).height()*0.15));
                    $('#'+name).dialog('open');
                }
            },'json')
            .fail(function(xhr, status, error) {
                if(($(window).height()*0.15) < $('#'+name).dialog('option','height')){
                    $('#'+name).dialog('option','height',($(window).height())-($(window).height()*0.15));
                }
                $('#'+name).dialog('option','maxHeight',($(window).height())-($(window).height()*0.15));
                $('#'+name).dialog('open');
            });
        } else { 
            if(($(window).height()*0.15) < $('#'+name).dialog('option','height')){
                $('#'+name).dialog('option','height',($(window).height())-($(window).height()*0.15));
            };
            $('#'+name).dialog('open'); 
        }
    }
    $(window).resize();
}
function dialogWidthClass (element) {
    $('.js-select-label.show').close();
    var width = element.width(), elementMedia = 'no-media';

    if(width <= 1024) {
        if (width >= 768) { elementMedia = '1024'; }
        else if (width >= 640) { elementMedia = '768'; }
        else { elementMedia = '480'; }
    } else { elementMedia = 'none'; }
    element.attr('data-media', elementMedia);
}
var timerDivContent =0;var noPerfectScroll;var noSetHeight;
setDivContent();
function setDivContent(){
    $('html#html_build .ui-tabs-nav li').unbind('click.hideTabs');
    $('html#html_build .ui-tabs-nav li').bind('click.hideTabs', function() {
            $(this).parent().removeClass('shown');
    });

    $('.formContent [j=ogf]').unbind('click.ogf');
    $('.formContent [j=ogf]').bind('click.ogf',function(event){
        dialogWidthClass($(this).parents('.ui-dialog-content'));
        p =$(this).attr('p');ogf=$(this).attr('href');
        i=$('#pannelList .ui-state-active[p='+p+'][act=edit]').attr('i');
        $.post(_SITE_URL+'mod/robotMgr.php', {a:'ixogf',p:p,i:i,ogf:ogf},function(data){});
    });
    $(document).unbind('keydown.raccourcie');
    $(document).bind('keydown.raccourcie',function(e) {
        if(e.keyCode == 76 && e.altKey === true){
            $('.left-panel .ac-open-left-panel-button').click();
        }else if(e.keyCode == 82 && e.altKey === true){
            $('.ac-open-right-panel-button').click();
        }else if(e.keyCode == 87 && e.altKey === true){
            $('.ac-open-top-panel-button').click();
        }else if(e.keyCode == 122 && e.altKey === true){
            $('.ac-open-top-panel-button,.ac-open-right-panel-button,.ac-open-left-panel-button').click();
        }
    });
}
/*function throwMessage(message,error,id) {
    var class_error = 'success';
    if(error == true) { class_error = 'error'; }
    if(!$('.message-box').length) { $('body').append('<ul class=\'message-box\'></ul>'); }
    if(id == null || !$('.message-box li.' + id).length) { $('.message-box').append('<li class=\'new '+ id +' '+ class_error +'\'>'+ message +'</li>'); }

    setTimeout(function() {
        $('.message-box li.new').each(function() {
            var line = $(this);
            line.removeClass('new');
            var timer = setTimeout(function() {
                line.addClass('new');
                setTimeout(function() {
                    line.remove();
                    if(!$('.message-box li').length) { $('.message-box').slideUp(250, function() {  $('.message-box').remove(); });  }
                },250);
            },2000);
        });
    },10);
}*/



var textvals = [];
function getMultipleSelectVals(then){var val = '';$(then).find('option:selected').each( function( i, selected ){if(val){val+=','+$( selected ).text();}else{val+=$( selected ).text();}});return val;}

function setListeHeight(){
    if(noSetHeight == 'nops')
        return;
    var hmoin=0;
    if($('#msSearch').length > 0){
        hmoin = $('#msSearch').height();
    }
    $('#leftContain,#Menuleft').css('height',(parseInt($(window).height())*0.65)-+"px");
    if($('#listForm').length > 0 && $('#listForm').parent().parent().parent().attr('id') !='editPopupDialog' && $('#listForm').parent().parent().parent().attr('id') !='editDialog')
        $('#listForm').css('height',(parseInt($(window).height())*0.80)-hmoin+"px");

    if($('#listFormChild').length > 0 && $('[id=listFormChild]').length < 2 && $('#listFormChild').parent().parent().parent().attr('id') !='editPopupDialog' && $('#listFormChild').parent().parent().parent().attr('id') !='editDialog' ){
        hei =  ((parseInt($(window).height())*0.80) - parseInt($('#listFormChild').position().top));
        if(hei > '300'){ $('#listFormChild').height(hei);}
    }else{
        $('.childCntClass .ac-list').css('height','100%');
    }
}
function number_format(number, decimals, dec_point, thousands_sep){
    number = (number+'').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number, prec = !isFinite(+decimals) ? 0 : Math.abs(decimals), sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep, dec = (typeof dec_point === 'undefined') ? '.' : dec_point,s = '', toFixedFix = function (n, prec) { var k = Math.pow(10, prec);
    return '' + Math.round(n * k) / k; }; s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
function setFrmHeight(){
    frheight=(document.documentElement.offsetHeight);document.getElementById("FRAME_ID").style.height=(frheight+"px");
    document.getElementById("FRAMEDIV_ID").style.display='block';
}


window.onload = function () {if (location.hash) {window.scrollTo(0, 0);}};
function sleep(milliseconds) {var start = new Date().getTime();for (var i = 0; i < 1e7; i++) {if ((new Date().getTime() - start) > milliseconds){break;}}}
/*var y;var x;
$("#body").mouseleave(function(event){x=0;y=0;});
$("#body").mouseenter(function(event){x=1;y=1;});
window.onbeforeunload = closeIt;
$(document).click(function(event){ clearTimeout(savemem); if(nbsavemem==0){statmemesave();}});
function closeIt(event){if(!x && !y){ memsave()}}
*/
var savemem=0;
var nbsavemem=0;
function statmemesave(){ nbsavemem=0;clearTimeout(savemem); savemem = setTimeout(function(){ memsave()}, 2000);}
function memsave(){ nbsavemem++; clearTimeout(savemem); $.post(_SITE_URL+'mod/robotMgr.php', {a:"ixsamem"});}
function isNumber(n) { return !isNaN(parseFloat(n)) && isFinite(n);}

(function($) {
    var splitVersion = $.fn.jquery.split(".");
    var major = parseInt(splitVersion[0]);
    var minor = parseInt(splitVersion[1]);
    var JQ_LT_17 = (major < 1) || (major == 1 && minor < 7);
    function eventsData($el) {
        return JQ_LT_17 ? $el.data('events') : $._data($el[0]).events;
    }
    function moveHandlerToTop($el, eventName, isDelegated) {
        var data = eventsData($el);
        var events = data[eventName];
        if (!JQ_LT_17) {
            var handler = isDelegated ? events.splice(events.delegateCount - 1, 1)[0] : events.pop();
            events.splice(isDelegated ? 0 : (events.delegateCount || 0), 0, handler);
            return;
        }
        if (isDelegated) {
            data.live.unshift(data.live.pop());
        } else {
            events.unshift(events.pop());
        }
    }
    function moveEventHandlers($elems, eventsString, isDelegate) {
        var events = eventsString.split(/\s+/);
        $elems.each(function() {
            for (var i = 0; i < events.length; ++i) {
                var pureEventName = $.trim(events[i]).match(/[^\.]+/i)[0];
                moveHandlerToTop($(this), pureEventName, isDelegate);
            }
        });
    }
    $.fn.bindFirst = function() {
        var args = $.makeArray(arguments);
        var eventsString = args.shift();
        if (eventsString) {
            $.fn.bind.apply(this, arguments);
            moveEventHandlers(this, eventsString);
        }
        return this;
    };

    $.fn.delegateFirst = function() {
        var args = $.makeArray(arguments);
        var eventsString = args[1];
        if (eventsString) {
            args.splice(0, 2);
            $.fn.delegate.apply(this, arguments);
            moveEventHandlers(this, eventsString, true);
        }
        return this;
    };
    $.fn.liveFirst = function() {
        var args = $.makeArray(arguments);
        args.unshift(this.selector);
        $.fn.delegateFirst.apply($(document), args);
        return this;
    };
    if (!JQ_LT_17) {
        $.fn.onFirst = function(types, selector) {
            var $el = $(this);
            var isDelegated = typeof selector === 'string';
            $.fn.on.apply($el, arguments);
            if (typeof types === 'object') {
                for (type in types)
                    if (types.hasOwnProperty(type)) {
                        moveEventHandlers($el, type, isDelegated);
                    }
            } else if (typeof types === 'string') {
                moveEventHandlers($el, types, isDelegated);
            }
            return $el;
        };
    }


})(jQuery);

(function($) {
    $.fn.extend( {
        limiter: function(limit) {
            $(this).on('keyup focus', function() {
                setCount(this);
            });
            function setCount(src) {
                var chars = src.value.length;
                if (chars > limit) {
                    src.value = src.value.substr(0, limit);
                    chars = limit;
                }
            }
        }
    });
})(jQuery);

(function($){
    jQuery.fn.putCursorAtEnd = function(){
    return this.each(function(){
        $(this).focus();
        if (this.setSelectionRange){
            var len = $(this).val().length * 2;
            this.setSelectionRange(len, len);
        }else{
            $(this).val($(this).val());
        }
        this.scrollTop = 999999;
    });
    };
})(jQuery);
$.fn.hasAttr = function(name) {  
    return this.attr(name) !== undefined;
 };
function disable_autocomplete(id, parent_selector_id){
    $('#'+parent_selector_id+' #'+id+'Autoc').attr('disabled', 'disabled');
    $('#'+parent_selector_id+' [in=in'+id+'] .autocomplete-icon').hide();
    $('#'+parent_selector_id+' [in=in'+id+'] .addSelectPopup').hide();
    $('#'+parent_selector_id+' [in=in'+id+'] .addSelectPopup').hide();
}

function alertb(title, msg){
    $('#alertDialog').parent().find('.ui-dialog-title').html(title);
    $('#alertDialog #alert_texte').html(msg);
    beforeOpenDialog('alertDialog');
}

function addslashes(str){
    return  (str + '').replace(/[\\\\"']/g, '\\\$&').replace(/\u0000/g, '\\\\0');
}

function set_arJquerySet(arJquerySet,parent,getAsTemplate,cntTitreColums){
    if(arJquerySet){
        var arJquerySet = JSON.parse(arJquerySet);
        var strChildSelect='';
        parent =parent.replace('#','');
        if(parent){ parent = '#'+parent+' ';}
        if(arJquerySet){
            $(parent+'.breadcrumb').remove();
            $(parent).prepend(cntTitreColums);
            $.each(arJquerySet, function(key, val){
                if(getAsTemplate==1){
                    if($(parent+'#'+key).length > 0 && val['v'] != ''){
                        if($(parent+'#'+key).prop('tagName') == 'INPUT'){
                            $(parent+'#'+key).val(val['v']);
                        }else{
                            $(parent+'#'+key).html(val['v']);
                        }
                    }
                }else{
                    if($(parent+'#'+key).length > 0){
                        if($(parent+'#'+key).prop('tagName') == 'INPUT'){
                            $(parent+'#'+key).val(val['v']);
                        }else{
                            $(parent+'#'+key).html(val['v']);
                        }
                    }
                }
                var functionString = 'ChildSelect'+key;
                if (eval('typeof ' + functionString)== 'function'){
                    strChildSelect += 'ChildSelect'+key+'(\'\');';
                }
            });
            eval(strChildSelect);
        }
    }
}
var isListAutoc;
function wrap_autoc(name,table,childTable,IdParent,Id,autoCpJsVar,version,paramD,ms,formParentStr,formParentFull){
    var formParent = 'form'+table;
    if(formParentFull){ 
         formParent = formParentFull;
    }else if(formParentStr){ 
        formParent = formParentStr+table;
    }else if(ms==1){
        formParent = 'formMs'+table;
    }

    $('#'+formParent+' #'+name+'Autoc').autocomplete({
        delay: 120,
        position:{collision: 'flip'}
        ,source:function(request, response ) {
            var dataParam;
            eval('isListAutoc_'+name+'_wait=1;');
            eval('dataParam={maxRows:12,ip:"'+IdParent+'",formS:$("#'+formParent+' #'+name+'Autoc").parents("form").serialize(),ipP:$("#'+formParent+' #'+name+'Autoc").parents("form").attr("id"),a:"autoc",t:childTable'+paramD+'};');
            $.ajax({
                url: _SITE_URL+'mod/act/'+table+'Act.php'
                    , dataType: 'json'
                    , autoFocus: true
                    , data: dataParam,
                success: function( data ) {
                        eval('CCautocSuccess'+name+';');
                        eval('isListAutoc_'+name+'_wait=0;');
                        eval('isListAutoc_'+name+' =data;');
                        if(data.count == 1){ 
                            $( '#'+formParent+' #'+name+'Autoc' ).val( data.data[0]['show'] );
                            $( '#'+formParent+' #'+name+'' ).val( data.data[0]['id'] );
                            $( '#'+formParent+' #'+name+'' ).change();
                            eval('isSelected_'+name+'AutocShow=0;');
                        }
                        if(data.count != 0){
                            resp = $.map( data.data, function( item ) {
                            return { label: item.show, value: item.id } });
                            response(resp);
                        }else{
                            if( $('.ui-menu-item :visible').length < 1 ){
                                var resp = [{value: 0, label: 'Aucun Résultat'}];
                                response(resp);
                                eval('isSelected_'+name+'Autoc=0;');
                            }
                        }
                },error: function(){eval('isListAutoc_'+name+' ="";');$( '#'+formParent+' #'+name+'Autoc' ).val('Erreur');eval('isListAutoc_'+name+'_wait=0;');}
            });
        },
        select: function(event,ui){
            if(ui.item.value != 0){
                $('#'+formParent+' #'+name+'Autoc').val(ui.item.label);
                $('#'+formParent+' #'+name+'').val(ui.item.value);
                $('#'+formParent+' #'+name+'').change();
                setTimeout('$("#'+formParent+' #'+name+'Autoc").val("'+ui.item.label+'");','50');
            }else{
                eval('isSelected_'+name+'Autoc=0;');
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
            eval('CCautocChange'+name+';');
        },
        change: function(event,ui){
            eval('CCautocChange'+name+';');
            if( $('#'+formParent+' #'+name+'Autoc').val()==''){ $('#'+formParent+' #'+name+'').val('');}
        },
        search: function(event,ui){ eval('CCautocSearch'+name+';');},
        focus: function(event,ui){
            eval('CCautocFocus'+name+';');
            if(ui.item.value != 0){
                eval('isSelected_'+name+'Autoc="'+ui.item.value+'";');
                eval('isSelected_'+name+'AutocShow="'+ui.item.label+'";');
                setTimeout(function (){ $( '#'+formParent+' #'+name+'Autoc' ).val(ui.item.label);}, 10);
            }else{
                event.preventDefault();
                event.stopPropagation();
                eval('isSelected_'+name+'Autoc=0;');
                return false;
            }
        },
        minLength: 2
        ,open: function() {  $( this ).removeClass( 'ui-corner-all' ).addClass( 'ui-corner-top' );}
        ,close: function() { $( this ).removeClass( 'ui-corner-top' ).addClass( 'ui-corner-top' );}
    });
    $('#'+formParent+' #'+name+'Autoc').click( function(event){ 
        event.preventDefault();
        event.stopPropagation();
        $( '#'+formParent+' #'+name+'Autoc' ).select();
    });
    $('#'+formParent+' #'+name+'Autoc').bind('focusout', function (event){
        event.preventDefault();
        event.stopPropagation();
        if($('#'+formParent+' #'+name+'').val() == '' && $('#'+formParent+' #'+name+'Autoc').val()!=''){
           console.log('#'+formParent+' #'+name+'Autoc focusout');
           $(this).autocomplete('search');
        }
    });
    if(version != 'QuickForm'){
        $('#'+formParent+' #autoCoImg'+name+'').click( function(){
            var child=0;if(childTable){child=1; }
            var formBu=0;if(formParentStr=='formBu'){formBu=1;}
            $.post(_SITE_URL+'mod/act/'+childTable+'Act.php'
            , {a:'list'
                ,i:$(this).attr('i')
                ,ui:'editPopupDialog'
                ,pc:$('#'+formParent+'.mainForm').data('pc')
                ,je:childTable+'Table', jet:'tr'
                ,Autoc :{ ip:IdParent, SelList:1, IdTemp:Id, SelIdAuto:''+name+'Autoc', SelId:name, SelEnt:table, SelRel:childTable, child:child,formBu:formBu,formParentFull:formParentFull}
                ,form:$('#'+formParent+' input').serialize()
            },  function(data){
                $('#loader').show();
                $('#editPopupDialog').addClass('ac-autocomplete').html(data);
                beforeOpenDialog('editPopupDialog');
                $('#editPopupDialog').height($(window).height() - 200);
                $(body).addClass('ac-no-overflow');
            });
        });
    }
    setTimeout(function (){
        $('#'+formParent+' #'+name+'Autoc').unbind('keydown.Autoc');
         $('#'+formParent+' #'+name+'Autoc').bind('keydown.Autoc',function(e) {
            var coded = e.which;
            if(coded == 13 || coded == 9 ){
                var isSelectedAutoc;
                var isSelectedAutocShow;
                eval('isSelectedAutoc = isSelected_'+name+'Autoc;');
                eval('isSelectedAutocShow = isSelected_'+name+'AutocShow;');
                if(isSelectedAutoc){
                    $('#'+formParent+' #'+name+'Autoc').val(isSelectedAutocShow).change();
                    $('#'+formParent+' #'+name).val(isSelectedAutoc).change();
                }else if($('#'+formParent+' #'+name+'Autoc').val()=='' || $('#'+formParent+' #'+name).val() ==''){
                    eval('isListAutoc = isListAutoc_'+name+';');
                    if( typeof isListAutoc !== 'undefined' 
                        && typeof isListAutoc.data !== 'undefined' 
                        && isListAutoc.data[0] 
                        && isListAutoc.data[0].id 
                        && isListAutoc.data[0].show
                    ){
                        eval('isListAutoc_wait = isListAutoc_'+name+'_wait;');
                        if(isListAutoc_wait){ setTimeout(function (){ autoc_wait(name,formParent);}, 300);
                        }else{autoc_wait(name,formParent);}
                    }else{
                        $('#'+formParent+' #'+name).val('');
                        $('#'+formParent+' #'+name+'Autoc').val('');
                        $('#'+formParent+' #'+name).change();  
                    }  
                }
            }else{
                $('#'+formParent+' #'+name).val('').change();
            }
        });
    }, 1000);
    eval(autoCpJsVar);
}
function autoc_wait(name,formParent){
    eval('isListAutoc = isListAutoc_'+name+';');
    if( 
        typeof isListAutoc !== 'null' 
        && typeof isListAutoc !== 'undefined' 
        && typeof isListAutoc.data !== 'undefined' 
        && isListAutoc.data[0] 
        && isListAutoc.data[0].id 
        && isListAutoc.data[0].show
    ){
        $('#'+formParent+' #'+name+'Autoc').val(isListAutoc.data[0].show);
        $('#'+formParent+' #'+name).val(isListAutoc.data[0].id);
        $('#'+formParent+' #'+name).change();
    }else{
        $('#'+formParent+' #'+name).val('');
        $('#'+formParent+' #'+name+'Autoc').val('');
        $('#'+formParent+' #'+name).change();  
    }  
    setTimeout(function (){eval('isListAutoc_'+name+'="";isListAutoc="";')}, 500);
}
function formatNumProjet(num_projet) {
    num_projet = num_projet.toUpperCase();
    return  num_projet.replace(/ /g,"");
}
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
function formatPostalcode(pcode) {
    var regexObj = /^\s*([a-ceghj-npr-tvxy]\d[a-ceghj-npr-tv-z])(\s)?(\d[a-ceghj-npr-tv-z]\d)\s*$/i;
    if (regexObj.test(pcode)) {
        var parts = pcode.match(regexObj);
        var pc = parts[1] + " " + parts[3];
        return pc.toUpperCase();
    }
    else {
        return pcode;
    }
}
function upload_file(browse_button,container,act_url,drop_element,filters,label,supp_button){
    var uploader_path='';
    var uploader = new plupload.Uploader({
        runtimes : 'html5,html4',
        browse_button : browse_button,
        container: document.getElementById(container),
        url: act_url,
        drop_element : drop_element,
        multi_selection:false,
        filters : filters,
        init: {
            FileUploaded: function(up, file, response) {
                uploader_path=response.response;
            },
            FilesAdded: function(up, files) {
                $('#loadingDialog p').html(_UPLOAD_MESSAGE);
                beforeOpenDialog('loadingDialog');
                plupload.each(files, function(file) { 
                    uploader.start(); 
                    return false;
                });
            },
            UploadComplete: function(up, files) {
                $('#loadingDialog').dialog('close');
                $('body').css('cursor', 'default');
                if(label && uploader_path){ $(label+' a').removeClass('hide'); $(label+' a img').attr('src',uploader_path);}
                if(label){ $(label+' input').val(files[files.length-1].name);}
                if(label && $(label+' a').html()){ $(supp_button).show();}
            }
        }
    });
    uploader.init();
    if($(supp_button).length>0 ){
        if(label && $(label+' a').html()){ $(supp_button).show();}
        $(supp_button).bind('click',function() {
            $.post(act_url+'&del=1', function(data){
                $(supp_button).hide(); 
                if(label){ 
                    $(label+' a').addClass('hide');
                }
            });
        });
    }
    return uploader;
}
function dateDiff(date1, date2){
    var diff = {};
    var tmp = date2 - date1;
    tmp = Math.floor(tmp/1000);
    diff.sec = tmp % 60;
    tmp = Math.floor((tmp-diff.sec)/60);
    diff.min = tmp % 60;
    tmp = Math.floor((tmp-diff.min)/60);
    diff.hour = tmp % 24;
    tmp = Math.floor((tmp-diff.hour)/24);
    diff.day = tmp;
    return diff;
}
function findPosition( oElement ) {
  function getNextAncestor( oElement ) {
    var actualStyle;
    if( window.getComputedStyle ) {
      actualStyle = getComputedStyle(oElement,null).position;
    } else if( oElement.currentStyle ) {
      actualStyle = oElement.currentStyle.position;
    } else {
      actualStyle = oElement.style.position;
    }
    if( actualStyle == 'absolute' || actualStyle == 'fixed' ) {
      return oElement.offsetParent;
    }
    return oElement.parentNode;
  }
  if( typeof( oElement.offsetParent ) != 'undefined' ) {
    var originalElement = oElement;
    for( var posX = 0, posY = 0; oElement; oElement = oElement.offsetParent ) {
      posX += oElement.offsetLeft;
      posY += oElement.offsetTop;
    }
    if( !originalElement.parentNode || !originalElement.style || typeof( originalElement.scrollTop ) =='undefined' ) {
      return [ posX, posY ];
    }
    oElement = getNextAncestor(originalElement);
    while( oElement && oElement != document.body && oElement != document.documentElement ) {
      posX -= oElement.scrollLeft;
      posY -= oElement.scrollTop;
      oElement = getNextAncestor(oElement);
    }
    return [ posX, posY ];
  } else {
    return [ oElement.x, oElement.y ];
  }
}
function findPosX(obj){
    var curleft = 0;
    if(obj)
        if(obj.offsetParent)
        while(1)
        {
          curleft += obj.offsetLeft;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.x)
        curleft += obj.x;
    return curleft;
}
function findPosY(obj){
    var curtop = 0;
    if(obj)
    if(obj.offsetParent)
        while(1)
        {
          curtop += obj.offsetTop;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.y)
        curtop += obj.y;
    return curtop;
}
if (!String.prototype.trim) {
 String.prototype.trim = function() {
  return this.replace(/^\s+|\s+$/g,'');
 };
}
function formate_date(element){
    var str = $(element).val();   
    str= replaceAll(str,"-","");
    if(str.length >=8){
        str = str.substr(0, 4)+'-'+str.substr(4,2)+'-'+str.substr(6,2);
    }else if(str.length == 6){
        str = str.substr(0, 4)+'-'+str.substr(4,2);
    }else if(str.length == 4){
        str = str.substr(0, 4);
    }
    $(element).val(str); 
}
function formate_nas(element){
    var str = $(element).val();   
    str= replaceAll(str,"-","");
    if(str.length >=9){
        str = str.substr(0, 3)+'-'+str.substr(3,3)+'-'+str.substr(6,3);
    }else if(str.length == 6){
        str = str.substr(0, 3)+'-'+str.substr(3,3);
    }else if(str.length == 3){
        str = str.substr(0, 3);
    }
    $(element).val(str); 
}
function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}
function ucfirst(str,force){
    str=force ? str.toLowerCase() : str;
    return str.replace(/(\b)([a-zA-Z])/,
             function(firstLetter){
                return   firstLetter.toUpperCase();
             });
}
function formatPhoneNumber(element) {
    if(typeof(element) == 'object'){ if(element.which == 9){ return; } element = $(element.target); }
    if(typeof(element) == 'object'){
        s = $(element).val();

        s = s.replace(/[^0-9]/g, '');
        s2 = s.substr(0,10);
        ext = s.substr(10);
        var m = s2.match(/^(\d{3})(\d{3})(\d{4})$/);
        tell = (!m) ? null : "(" + m[1] + ") " + m[2] + "-" + m[3];
        if(tell){
            if(ext){ tell +="x"+ext;}
            $(element).val(tell);
            $(element).attr('vphone','1');
        }else{
            $(element).attr('vphone','0');
        }
    }
}
function isNumeric(s) {
    return !isNaN(s - parseFloat(s));
}
function copyToClipboard(text){
    var temp = $("<input style='display:hidden;'>");
    $('body').append(temp);
    temp.val(text).select();
    document.execCommand('copy');
    temp.remove();
    sw_message(_COPY_MESSAGE,0,0,0);
}


$.getScriptOnce = function(url, successhandler) {
    if ($.getScriptOnce.loaded.indexOf(url) === -1) {
         $.getScriptOnce.loaded.push(url); 
         if (successhandler === undefined) {
             return $.getScript(url);
         } else {
             return $.getScript(url, function(script, textStatus, jqXHR) {
                 successhandler(script, textStatus, jqXHR);
             });
         }
    } else {
        return false;
    }

};$.getScriptOnce.loaded = [];
