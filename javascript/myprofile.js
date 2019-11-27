
$(document).ready(function(){
    $("img").click(function(){
        if (confirm("Etes vous sur de vouloir supprimer cette photo ?"))
        {
            $(this).remove();
            $.ajax({
                type: "post",
                data: {
                    image: this.getAttribute('src'),
                },
                url: '../functiondb/deleteimage.php',
            });
        }
    });
    
});
