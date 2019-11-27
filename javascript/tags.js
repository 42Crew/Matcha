$(document).ready(function(){
    $("#tags input").on({
        focusout : function() {
            var txt= this.value.replace(/[^a-zA-Z0-9\+\-\.\#]/g,''); // allowed characters list
            var myvalues =  $('input[name=tag]').attr("value");
            if(txt && myvalues.indexOf(txt) == -1) 
            {
                $(this).before('<span class="tag">'+ txt +'</span>');
                myvalues = myvalues + txt + "," ;
                $('input[name=tag]').val(myvalues);
            }
            this.value="";
        },
        keyup : function(ev) {
          if(/(188|13|32)/.test(ev.which)) 
            $(this).focusout(); 
        }
      });
      $('#tags').on('click','.tag',function(){
        if( confirm("Really delete this tag?") ) 
        {
            $(this).remove();
           var myvalues =  $('input[name=tag]').attr("value");
           myvalues = myvalues.replace(this.innerHTML + ",", "");
           $('input[name=tag]').val(myvalues);
        }
     });
});
