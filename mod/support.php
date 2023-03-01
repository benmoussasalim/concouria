<?php

###############################
#	Progexpert
###############################


if($_POST['action']) {
    include_once '../inc/init.php';
    include(_INSTALL_PATH."mod/template_func.php");
    if($_SESSION[_AUTH_VAR]->get('group') != 'Admin') {die();}
    $request = $_POST;
    $closeTicketMsg = button(span(_("Ouvrir"))._("un ticket"),'class="button-link-blue open-ticket"');
    function checkTicketState($id) {
        $ticket = TicketQuery::create()->filterByOnline('Ouvert')->filterByIdTicket($id)->findOne();
        if(count($ticket) >= 1) {
            $return['error'] = false;
        }else{
            $return['error'] = true;
            $return['content'] = $closeTicketMsg;
        }

        return $return;
    }

    $authy = AuthyQuery::create()->findPk($_SESSION[_AUTH_VAR]->get('id'));
    if($authy) {
        switch($request['action']) {
            case 'checkChat':
                $chat = checkTicketState($_SESSION['ticket']['current']);

                if($chat['error'] == false) {
                    $msgs = TicketChatQuery::create()->filterByIdTicket($_SESSION['ticket']['current'])->orderBy('IdTicketChat','ASC');
                    if($request['last_msg']) { $msgs->where("id_ticket_chat > '".$request['last_msg']."'"); }
                    $msgs = $msgs->find();

                    if($msgs) {
                        foreach($msgs as $msg) {
                            $author = '';
                            if($msg->getAuthor() == $authy->getUsername()) { $author = 'author'; }

                            $chat['content'] .=
                            div(
                                p(span($msg->getAuthor())." - ".$msg->getDateCreation(),'class="author"')
                                .p($msg->getMessage(),'class="message"')
                            ,'','class="message '.$author.'" data-message="'.$msg->getIdTicketChat().'"');
                        }
                    }
                }

                echo json_encode($chat);
                die();
            break;
            case 'closeTicket':
                $close = TicketQuery::create()->filterByIdTicket($_SESSION['ticket']['current'])->update(array('Online' => 1));
                $return['buttonText'] = span(_("Ouvrir"))._("un ticket");
                $return['buttonClass'] = 'open-ticket';
                unset($_SESSION['ticket']);
                echo json_encode($return);
                die();
            break;
            case 'openTicket':
                $authy = AuthyQuery::create()->findPk($_SESSION[_AUTH_VAR]->get('id'));

                if($authy) {
                    $ticket = new TicketForm();

                    $ticketData['Online'] = 'Ouvert';
                    $ticketData['Date'] = date('Y-m-d');
                    $ticketData['Author'] = $authy->getUsername();
                    $ticketData['Project'] = _PROJECT_NAME;
                    $ticketSave = $ticket->save_create_Ticket($ticketData);
                    $ticketSave->save();

                    $_SESSION['ticket']['current'] = $ticketSave->getPrimaryKey();

                    $authyTicket = AuthyQuery::create()->findPk($_SESSION[_AUTH_VAR]->get('id'));
                    if($authyTicket) {
                        $email =["support@progexpert.com"];
                        foreach($email as $support) {
                            sendHTMLemail(href('Ticket #'.$_SESSION['ticket']['current'],_SITE_URL_HTTP.'Support/list/?user='.md5($support)), 'support@progexpert.com', $support,$request['urgence'].'['._PROJECT_NAME.'] Nouveau ticket(#'.$_SESSION['ticket']['current'].') créé par '.$authyTicket->getUsername());
                        }
                    }

                    if(in_array($authyTicket->getEmail(),["support@progexpert.com"])) {
                        $return['buttonText'] = span(_("Fermer"))._("le ticket");
                        $return['buttonClass'] = 'close-ticket';
                    } else {
                        $return['buttonText'] = span(_("Ticket"))._("en cours");
                        $return['buttonClass'] = 'denied-action';
                    }

                    $return['id'] = $_SESSION['ticket']['current'];

                    echo json_encode($return);
                 }
                die();
            break;
            case 'sendMessage':
                $chat = checkTicketState($_SESSION['ticket']['current']);
                if($chat['error'] == false) {
                    $_SESSION[_AUTH_VAR]->lastSupportCheck = 0;
                    $_SESSION[_AUTH_VAR]->support = '';

                    $message = new TicketChatForm();
                    $messageData['Author'] = $authy->getUsername();
                    $messageData['Message'] = $request['message'];
                    $messageData['IdTicket'] = $_SESSION['ticket']['current'];
                    $messageSave = $message->save_create_TicketChat($messageData);
                    $messageSave->save();
                    $lastMsgId = $messageSave->getPrimaryKey();
                    $msgs = TicketChatQuery::create()->filterByIdTicket($_SESSION['ticket']['current'])->orderBy('IdTicketChat','ASC')->where("id_ticket_chat > '".$request['last_msg']."'")->find();
                    if($msgs) {
                        foreach($msgs as $msg) {
                            $author = '';
                             if($msg->getAuthor() == $authy->getUsername()) { $author = 'author'; }

                            $chat['content'] .=
                            div(
                                p(span($msg->getAuthor())." - ".$msg->getDateCreation(),'class="author"')
                                .p($msg->getMessage(),'class="message"')
                            ,'','class="message '.$author.'" data-message="'.$msg->getIdTicketChat().'"');
                        }
                    }
                }
                echo json_encode($chat);
                die();
            break;
            //@@SUPPORT | DÉTECTION DE NOUVEAU MESSAGES DU SUPPORT
            case 'checkMessage':
                $now = time();
                $newTicket = TicketQuery::create()->filterByOnline('Ouvert')->filterByProject('MyFirstProject')->orderBy('IdTicket','DESC')->findOne();
                $authyMenu = AuthyQuery::create()->findPk($_SESSION[_AUTH_VAR]->get('id'));
                if($newTicket AND $authyMenu) {
                    $lastMsgTicket = TicketChatQuery::create()->filterByIdTicket($newTicket->getIdTicket())->orderBy('IdTicketChat','DESC')->findOne();
                    if($lastMsgTicket) {
                        if($lastMsgTicket->getAuthor() != $authyMenu->getUsername()) {
                            $_SESSION[_AUTH_VAR]->set('support', 'new-message');
                        }
                    }
                }

                $_SESSION[_AUTH_VAR]->set('lastSupportCheck', $now);

                if(@$_SESSION[_AUTH_VAR]->support) { $return['class'] = $_SESSION[_AUTH_VAR]->support; }
                $return['time'] = $now;

                die(json_encode($return));
            break;
        }
    }
}

if($request['user'] AND $_SESSION[_AUTH_VAR]->get('isConnected') != 'YES') {
    $authyConnect = AuthyQuery::create()->filterByGroup('Admin')->where('md5(email) = "'.$request['user'].'"')->findOne();
    if($authyConnect) {
        $connect = new AuthyForm();
        $connect->tryLog($authyConnect->getUsername(), $authyConnect->getPasswdHash());
    }
}

$authyTicket = AuthyQuery::create()->findPk($_SESSION[_AUTH_VAR]->get('id'));
if($authyTicket) {
    $bodyClass = 'sw-support';
    unset($_SESSION['ticket']);
    if(in_array($authyTicket->getEmail(),["support@progexpert.com"])) { $bodyClass .= ' is-admin'; }

    $closeTicketMsg = button(span(_("Ouvrir"))._("un ticket"),'class="button-link-blue open-ticket"');

    /*ON PREND LE DERNIER TICKET*/
    if($request['ticket']) { $_SESSION['ticket']['current'] = $request['ticket']; }
    else {
        $openTicket = TicketQuery::create()->filterByProject(_PROJECT_NAME)->orderBy('IdTicket','DESC')->findOne();
        if($openTicket) {
            $_SESSION['ticket']['current'] = $openTicket->getIdTicket();

            if($openTicket->getOnline() == 'Fermé') {
                $newTicket['Toggle'] = 'toggle';
                $newTicket['Content'] = $closeTicketMsg;
                $closeDate = p(_("Ticket du").' '.strong(date('Y-m-d',strtotime($openTicket->getDateModification()))),'class="last-edit"');
            }else{
                if(in_array($authyTicket->getEmail(),["support@progexpert.com"])) { $closeTicketMsg = button(span(_("Fermer"))._("le ticket"),'class="button-link-blue close-ticket"'); }
                else { $closeTicketMsg = button(span(_("Ticket"))._("en cours"),'class="button-link-blue denied-action"'); }
                $output['onReadyJs'] .= "initCheck();";
            }

        }else{
            $newTicket['Content'] = button(span(_("Ouvrir"))._("un ticket"),'class="button-link-blue open-ticket"');
            $newTicket['Toggle'] = 'toggle';
        }
    }

    $emergencyBtn =
        div(
            input('checkbox','urgence','')
            .label(span(_("Urgence")),'for="urgence"')
        ,'','class="emergency-wrapper"');

    if($_SESSION['ticket']) {
        $ticketTitle = 'Ticket #'.$_SESSION['ticket']['current'];
        $messages = TicketChatQuery::create()->filterByIdTicket($_SESSION['ticket']['current'])->orderBy('IdTicketChat','ASC')->find();
        if($messages) {
            foreach($messages as $message) {
                $author = '';
                if($message->getAuthor() == $authyTicket->getUsername()) { $author = 'author'; }

                $chat .=
                div(
                    p(span($message->getAuthor())." - ".$message->getDateCreation(),'class="author"')
                    .p($message->getMessage(),'class="message"')
                ,'','class="message '.$author.'" data-message="'.$message->getIdTicketChat().'"');
            }
        }
    }

    $howItWorks = "<div class=\"support-content\"><h2>Fonctionnement de la zone support</h2><p>C'est ici que vous pouvez créer un ticket de support. Lorsque vous ouvrez un ticket, votre chargé de projet et/ou le programmeur en charge de votre site reçoit une notification par courriel l’avisant de votre demande. Une zone de discussion est alors activé et vous pouvez alors nous faire de votre demande. Les «logs» du ticket sont enregistrés à des fins de consultation ultérieure. <span>Des frais d’un minimum de 0,25 hr peuvent s’appliquer lors de l’ouverture d’un ticket et sera prélevé à même votre banque de support/bug.</span>  À noter qu’en cas de demande en dehors des heures de bureau, nous vous réponderons dès que possible. <span>En cas d’urgence, vous avez accès à notre mode URGENT. N’hésitez pas à vous en servirpour accélérer la répondre. Des frais de minimum 1 heure sur les urgences en dehors des heures de bureaux pourraient être appliqué.</span></p></div>";

    $output['html'] =
        div(
            href(span(_("Ouvrir/Fermer le menu")),'javascript:','class="toggle-menu trigger-menu"')
        ,'','class="sw-header"')
        .div(
            h1(_("Zone de support"))
            .h2(_("Bienvenue dans la zone de support de votre site web"))

            .div(
                button(_("Comment ça fonctionne?"),'class="how-it-works button-link-blue"')
            )
        ,'','class="support-description"')

        .div(
            $closeTicketMsg
            .$emergencyBtn
            .p($ticketTitle,'class="ticket"')
        ,'','class="support-controls"')

        .div(
            $closeDate
            .div($chat,'','class="chat-messages"')
            .form(
                input('text','chat','','placeholder="'._("Votre message ici...").'"')
                .button(_("Envoyer"),'class="button-link-blue"')
            ,'id="chat-controls"')
        ,'','class="chat-wrapper '.$newTicket['Toggle'].'"');

    /* ENVOI D'UN MESSAGE */
    $output['onReadyJs'] .= "
        $('#chat-controls').submit(function() {
            var message =  $('#chat-controls #chat').val();
            $('#chat-controls #chat').val('');

            if(message != '') {
                $.post(_SITE_URL + 'mod/support.php', { action: 'sendMessage', message: message, last_msg: $('.chat-messages [data-message]:last-of-type').data('message')  }, function(data) {
                    clearTimeout(idle_timer);
                    if(data.error == false) {
                        $('.chat-messages').append(data.content);
                        $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);
                    } else {
                        chat_popup(data.content);
                        clearInterval(chat_interval);
                    }
                },'json');
            }

            return false;
        });
    ";

    /*OUVERTURE D'UN TICKET*/
    $output['onReadyJs'] .= "
        $('.sw-support').on('click','.open-ticket',function() {
            var urgence = '';
            if($('#urgence').is(':checked')) { urgence = '[URGENCE]'; }

            $.post(_SITE_URL + 'mod/support.php', { action: 'openTicket', urgence: urgence },function(data) {
                $('.chat-messages').html('');
                $('.support-controls .ticket').text('Ticket #' + data.id);
                if(data.buttonText) {
                    changeButton(data.buttonText,data.buttonClass);
                }
                $('.chat-wrapper').removeClass('toggle');
                $('.last-edit').remove();

                initCheck();
            },'json');

            return false;
        });
    ";

    /*FERMETURE DU TICKET*/
    $output['onReadyJs'] .= "
        $('.sw-support').on('click','.close-ticket',function() {
            $.post(_SITE_URL + 'mod/support.php', { action: 'closeTicket' },function(data) {
                changeButton(data.buttonText,data.buttonClass);
                $('.chat-wrapper').addClass('toggle');
                clearInterval(chat_interval);
            },'json');

            return false;
        });
    ";

    /*GESTION DE L'AFFICHAGE
    $output['windowResize'] .= "
       $('.chat-wrapper').css('height',$(window).height() - $('.sw-header').outerHeight() - $('.support-description').outerHeight() - 110);
    ";*/

    $output['onReadyJs'] .= "
        $('.left-panel li.new-message').removeClass('new-message');

        setTimeout(function() { $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight); }, 200);

        $('.how-it-works').click(function() {
            $('#editPopupDialog').html('".addslashes($howItWorks)."');
            beforeOpenDialog('editPopupDialog');

            return false;
        });

        $('.sw-support').on('click','.denied-action',function() {
            sw_message('".addslashes(_("Seul les administrateurs peuvent fermer le ticket."))."',true,'support-rights');
            return false;
        });
    ";

    /*CHANGEMENT DU BOUTON*/
    $output['js'] .= "
        function changeButton(text,class_name) {
            $('.support-controls').addClass('hide-content');
            setTimeout(function() {
                $('.support-controls button').attr('class','button-link-blue ' + class_name);
                $('.support-controls button').html(text);
                setTimeout(function() { $('.support-controls').removeClass('hide-content'); },250);
            },250);
        }
    ";

    /*FUNCTION*/
    $output['js'] .= "
        function chat_popup(message) {
            $('.chat-overlay').html(message);
            $('.chat-wrapper').addClass('toggle');
        }

        var chat_interval;
        function initCheck() {
             chat_interval = setInterval(function() {
                $.post(_SITE_URL + 'mod/support.php', { action: 'checkChat', last_msg: $('.chat-messages [data-message]:last-of-type').data('message') }, function(data) {
                   if(data.error == false) {
                       if(data.content) {
                           $('.chat-messages').append(data.content);
                           $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);
                           initDrag(true);
                       }
                   } else {
                       /*clearInterval(chat_interval);
                       chat_popup(data.content); */
                   }
               },'json');
           },5000);
        }
    ";

    /*DROP UN RACCOURCI*/
    $output['onReadyJs'] .= "
        initDrag(true);

        $('#sw-shortcut li').draggable({
            helper: 'clone',
            scroll: false
        });

        $('.chat-messages').droppable({
            tolerance: 'pointer',
            accept: 'li',
            drop: function(event,ui) {
                var element = $(ui.draggable),
                link = element.find('a').data('origin');
                name = element.find('a').text(),
                table = element.find('button').data('tabletodelete'),
                id = element.find('button').data('idtoremove'),
                 message = '<a href=\"'+ link +'\" class=\"sw-link button-link-blue\" target=\"_blank\" data-table=\"'+table+'\" data-id=\"'+id+'\" data-edit=\"'+name+'\">'+ name +'</a>';

                $.post(_SITE_URL + 'mod/support.php', { action: 'sendMessage', message: message, last_msg: $('.chat-messages [data-message]:last-of-type').data('message')  }, function(data) {
                    clearTimeout(idle_timer);
                    if(data.error == false) {
                        $('.chat-messages').append(data.content);
                        $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);
                        initDrag(true);
                    }
                },'json');
            }
        });
    ";

    /*DÉSACTIVATION DU CHAT APRÈS 2 MINUTES */
    $output['js'] .= "
        var idle_timer;
    ";

    $output['onReadyJs'] .= "
        var timer = 60000 * 1;

        $('#body').mousemove(function() {
            if(!$('.support-controls button.active-chat').length) {
                clearTimeout(idle_timer);
                idle_timer = setTimeout(function() {

                    clearInterval(chat_interval);
                    changeButton('".addslashes(_("Réactiver"))."','active-chat');
                    $('.chat-wrapper').addClass('toggle');
                },timer);
            }
        });

        $('#body').on('click','.active-chat',function() {
            clearTimeout(idle_timer);
            initCheck();
            $('.chat-wrapper').removeClass('toggle');

            if($('.sw-support').hasClass('is-admin')) { changeButton('".span(_("Fermer"))._("le ticket")."','close-ticket'); }
            else { changeButton('".span(_("Ticket"))._("en cours")."','denied-action'); }

            return false;
        });
    ";
}
