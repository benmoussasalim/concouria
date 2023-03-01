<?php


    #@0.1@#########################
    #	ProgXform version 0.861
    #	Propel version 1.6
    #	Prgxpert, Frederic Vezina 2011
    #	build_time: 2014-08-26 12:06:21
    ###############################
    
    include 'ContentRelatedActBase.php';

	function eventHook($event, &$obj='', &$request, &$output,&$search=array()){
    	switch($event){	
		    case 'beforeContentFileList':
		    	$obj->cCmoreColsHeaderContentFile = th(_('Inserer'), " style='width:80px;' ");
		        $obj->cCmoreColsContentFile  = td("<input type=buttton value=\""._('Inserer le fichier')."\" style=\"width:50px;\" fichier=\"%Fichier%\" i=\"%IdContentFile%\" ext=\"%ext%\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" j=\"but_add\" >");

		        $obj->CcToContentFileListJs ="
	                $('[j=but_add]').click(function (event){

	                    ext  =$(this).attr('ext');
	                    i  =$(this).attr('i');
	                    url = $(this).attr('fichier');
	                    Name = $('[c=Name][i='+i+']').html();
	                    Height = $('[c=Height][i='+i+']').html();
	                    Width = $('[c=Width][i='+i+']').html();
	                    if(ext =='jpg' || ext == 'png' ){
	                            contenu='<img style=\"height:'+Height+';width:'+Width+';\" src=\""._SITE_URL."'+url+'\" />';
	                    }else{
	                            contenu='<a href=\""._SITE_URL."'+url+'\" >'+Name+'</a>';
	                    }
	                    data = tinyMCE.activeEditor.getContent();
	                    tinyMCE.activeEditor.setContent(data+contenu);
                    	
                    	$('#formChangedContent').val(true)
	                    
	                    $('#ui-dialog-title-alertDialog').html('".addslashes(_('Mail'))."');
	                    $('#alert_texte').html('".addslashes(_('Le contenue a été ajouté a votre contenu')."<br>"._('Il vous suffit d\'enregistrer'))."');
	                    $('#alertDialog').dialog('open');
	                    event.stopPropagation();
	                });
		        ";
	        break;
	    }
    }