var messages;
var longueur;

$(document).ready(function(){
    changedivs();

    $(".read").live('click', function(){
        var parentdiv = $(this).parent();
        var id = $(this).parent().find('input[name=id]').val();

        $.ajax({
            type: "post",
            data: {
                todel: id,
            },
            url: '../functiondb/notification.php',
            success: function(data){
                if (data == "1")
                {
                  changedivs();
                }
            },
        }); 
    });

    $("#readall").live('click', function(){
        $.ajax({
            type: "post",
            data: {
                delall: 1,
            },
            url: '../functiondb/notification.php',
            success: function(data){
                if (data == "1")
                {
                    $("div.notification").empty();
                    var div = document.createElement('div');
                    div.textContent = "Aucune notification";
                    $('.notification').prepend(div);

                    $("#longueur").remove();
                    var span = document.createElement('span');
                    span.textContent = 0;
                    span.setAttribute('id', 'longueur');
                    $('.list-nav.notif').prepend(span);

                    messages = '';
                    longueur = 0;
                }
            },
        }); 
    });
});

function changedivs()
{
    $.ajax({
        type: "post",
        data: {
            getnotif: 1,
        },
        dataType: 'json',
        url: '../functiondb/notification.php',
        success: function(data){
            if (!(JSON.stringify(messages) == JSON.stringify(data)))
            {
                messages = data;

                $("div.notification").empty();
                if (data == null)
                {
                    var div = document.createElement('div');
                    div.textContent = "Aucune notification";
                    $('.notification').prepend(div);
                    $("#longueur").remove();
                    var span = document.createElement('span');
                    span.textContent = 0;
                    span.setAttribute('id', 'longueur');
                    $('.list-nav.notif').prepend(span);
                }
                else
                {
                    data.forEach((item) => {
                        var button = document.createElement('div');
                        button.textContent = 'X';
                        button.setAttribute('class', 'read');

                        var input = document.createElement('input');
                        input.setAttribute('type', 'hidden');
                        input.setAttribute('name', 'id');
                        input.setAttribute('value', item['id']);

                        var a = document.createElement('a');
                        a.textContent = item['message'];
                        a.href =  "../pages/profileuser.php?user=" + item['user'];
                        a.setAttribute('id', 'anotif');

                        var div = document.createElement('div');
                        div.setAttribute('class', item['type']);
                        div.prepend(button);
                        div.append(input);
                        div.append(a);

                        $('.notification').prepend(div);
                        $('.notification').prepend(div);
                        
                    })
                    if (longueur != data.length)
                    {
                        $("#longueur").remove();
                        var span = document.createElement('span');
                        span.textContent = data.length;
                        span.setAttribute('id', 'longueur');
                        $('.list-nav.notif').prepend(span);
                    }
                    longueur = data.length;
                }

            }
    
        },
    });  
}

setInterval("changedivs()",3000);
