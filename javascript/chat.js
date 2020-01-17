var messages;
var conversations;
$(document).ready(function(){

    $.ajax({
        type: "post",
        url: '../functiondb/get_conversations.php',
        dataType: 'json',
        success: function(data){
            changeconversations(data);
        }
    });

    $(".chatwith").live('click', function(){
        $("#available-chats").css('display', 'none');
        $("#chat").css('display', 'block');
        var chat_id = $(this).find('input[name=id]').val();
        var chat_flag = $(this).find('input[name=flag]').val();
        $('#chat').find('input[name=id]').val(chat_id);
        $('#chat').find('input[name=flag]').val(chat_flag);
        $.ajax({
            type: "post",
            data: {
                id: chat_id,
            },
            dataType: 'json',
            url: '../functiondb/getchat.php',
            success: function(data){
                changedivs2(data);
            }
        });
    });

    $("#retour").click(function(){
        $("#available-chats").css('display', 'block');
        $("#chat").css('display', 'none');
        $('#chat').find('input[name=id]').val('');
        $('#chat').find('input[name=flag]').val('');
        $('#chat').find('textarea[name=message]').val('');
        $("div.message").remove();
        messages = null;
    });

    $("#envoyer").click(function(){
        var chat_id = $('#chat').find('input[name=id]').val();
        var chat_flag = $('#chat').find('input[name=flag]').val();
        var message_tosend = $('#chat').find('textarea[name=message]').val();
        if (!(!message_tosend || /^\s*$/.test(message_tosend)))
        {
            $.ajax({
                type: "post",
                data: {
                    id: chat_id,
                    message : message_tosend,
                    notif : chat_flag,
                },
                url: '../functiondb/message.php',
                success: function(data){
                    if (data != "OK")
                        $('#chat').find('#error').html(data);
                }
            });
            $('#chat').find('textarea[name=message]').val('');
            $.ajax({
                type: "post",
                data: {
                    id: chat_id,
                },
                dataType: 'json',
                url: '../functiondb/getchat.php',
                success: function(data){
                    changedivs2(data);
                },
                error: function(){
                    $('#chat').find('#error').html("Echec de l'envoi");
                 }
            });
        }
        else
            $('#chat').find('#error').html("Merci d'envoyer un message valide");
    });

    $("#bottombutton").click(function(){
        if ($("#mychat").css('display') == 'none')
            $("#mychat").css('display', 'block');
        else
            $("#mychat").css('display', 'none');
    });    
});

function changeconversations(data)
{
    if (JSON.stringify(messages) != JSON.stringify(data))
    {
        conversations = data;
        $("#available-chats").empty();
        if (data == -1)
        {
            var div = document.createElement('div');
            div.textContent = "Vous n'avez aucun matchs";
            $('#available-chats').prepend(div);
        }
        else
        {
            data.forEach((item) => {
                var input1 = document.createElement('input');
                input1.setAttribute('type', 'hidden');
                input1.setAttribute('name', 'id');
                input1.setAttribute('value', item['id']);
        
                var input2 = document.createElement('input');
                input2.setAttribute('type', 'hidden');
                input2.setAttribute('name', 'flag');
                input2.setAttribute('value', item['flag']);

                var div = document.createElement('div');
                div.textContent = "Chat avec: " + item['prenom'] + " " + item['nom'];
                div.setAttribute('class', 'chatwith');
                div.append(input1);
                div.append(input2);
                $('#available-chats').prepend(div);
            })
        }
    }
}

function changedivs2(data)
{
    messages = data;
    $("div.message").remove();
    data.forEach((item) => {
        var div = document.createElement('div');
        div.textContent = item['username'] + " : " + item['message'];
        div.setAttribute('class', 'message');
        $('#chat').prepend(div);
    })
}

function updateChat()
{
    if ($("#chat").css('display') == 'block')
    {
        var chat_id = $('#chat').find('input[name=id]').val();
        $.ajax({
            type: "post",
            data: {
                id: chat_id,
            },
            dataType: 'json',
            url: '../functiondb/getchat.php',
            success: function(data){
                if (!(JSON.stringify(messages) == JSON.stringify(data)))
                    changedivs2(data);
            },
        });
    }
    else
    {
        $.ajax({
            type: "post",
            url: '../functiondb/get_conversations.php',
            dataType: 'json',
            success: function(data){
                changeconversations(data);
            }
        });       
    }
}

setInterval("updateChat()",3000);
