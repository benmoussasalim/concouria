<?php

if($_SESSION[_AUTH_VAR]->get('isConnected') == 'YES' AND $_SESSION[_AUTH_VAR]->get('group') == 'Admin') {
	$output['onReadyJs'] .= "
		$('.export-csv').click(function() {
			$('#editDialog').html('<div class=\"export-option\"><p>Sélectionnez une option</p><ul>\<li><a class=\"ac-button ac-light-red\" href=\"\" data-type=\"all\">Tous</a></li><li><a class=\"ac-button ac-light-red\" href=\"\" data-type=\"new\">Nouveau membre</a></li>\<li><a class=\"ac-button ac-light-blue\" href=\"\" data-type=\"old\">Ancien membre</a></li><li><a class=\"ac-button ac-light-blue\" href=\"\" data-type=\"regular\">Membre</a></li></ul></div><style>.export-option{ text-align: center; padding: 20px; } .export-option ul{ margin-top: 20px;} .export-option li{ margin: 0 10px; display: inline-block; } .export-option li a{ padding: 10px 20px;} .export-option p{ font-weight: bold;}</style>').dialog('open');
             beforeOpenDialog('editDialog');

            return false;
		});
        
        /* exportCSV importCSV */
		$('#body').delegate('.export-option li a','click',function() {
			var type = $(this).data('type');
            $('#loadingDialog').dialog('open');
			$.post('"._SITE_URL."mod/act_p/AccountAct.php', { a:'exportCSV', type: type }, function(data) {
                $('#loadingDialog').dialog('close');
                if(data){
                    $('#editDialog').dialog('close');
                    sw_message(data,false);
                }
			});
			return false;
		});

		var uploaderContest = new plupload.Uploader({
			browse_button: 'import-concours',
			unique_names : true,
			dragdrop : true,
			multiple_queues : false,
			multi_selection : false,
			max_file_count : 1,
			url: _SITE_URL + 'mod/act/ConcoursAct.php',
			multipart_params: {
				'a': 'importConcours'
			}
		  });

		uploaderContest.init();
		uploaderContest.bind('FilesAdded', function(up, files) {
			uploaderContest.start();
            $('#loadingDialog').dialog('open');
		});


		uploaderContest.bind('FileUploaded', function(upldr, file, object) {
			var myData;
			try {
				myData = eval(object.response);
			} catch(err) {
				myData = eval('(' + object.response + ')');
			}

			sw_message(myData.message,myData.error);
            $('#loadingDialog').dialog('close');
		});
	";
}