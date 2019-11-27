var messages;

$(document).ready(function(){
    $(".notif").live('click', function(){
        if ($("#shownotif").css('display') == 'none')
            $("#shownotif").css('display', 'block');
        else
            $("#shownotif").css('display', 'none');
    });

});