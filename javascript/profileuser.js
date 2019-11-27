
$(document).ready(function(){

    $.ajax({
        type: "post",
        data: {
            reported: $('input[name=liked]').val(),
            get : "get",
        },
        url: '../functiondb/report.php',
        success: function(data){
            if (data == "YES")
            {
                $("#report").attr("disabled", true);
            }
        }
    });

    $.ajax({
        type: "post",
        data: {
            blocked: $('input[name=liked]').val(),
            get : "get",
        },
        url: '../functiondb/block.php',
        success: function(data){
            if (data == "YES")
            {
                $("#block").html("Debloquer l'utilisateur");
            }
        }
    });

    $("#like").click(function(){
        $.ajax({
            type: "post",
            data: {
                liked: $('input[name=liked]').val(),
            },
            url: '../functiondb/likes.php',
            success: function(data){
                console.log(data);
            }
        });
        $(this).html() == 'Like' ? $(this).html('Dislike') : $(this).html('Like');
        $(this).html() == 'Dislike' ? $("#pop").html(+($("#pop").html()) + 1) : $("#pop").html(+($("#pop").html()) - 1);

    });
 
    $("#report").click(function(){
        $.ajax({
            type: "post",
            data: {
                reported: $('input[name=liked]').val(),
            },
            url: '../functiondb/report.php',
            success: function(data){
                $("#report").attr("disabled", true);
            }
        });
    });

    $("#block").click(function(){
        $.ajax({
            type: "post",
            data: {
                blocked: $('input[name=liked]').val(),
            },
            url: '../functiondb/block.php',
            success: function(){
                $("#block").html() == "Bloquer l'utilisateur" ? $("#block").html('Debloquer l\'utilisateur') : $("#block").html('Bloquer l\'utilisateur');
            }
        });
    });
});
