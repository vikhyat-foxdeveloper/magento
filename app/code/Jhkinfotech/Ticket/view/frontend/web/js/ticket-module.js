require([
    'jquery',
    'jquery/ui'
  ], function($){
    $(document).ready(function(){ 
        $('form').submit(function () {
            $(this).find(':submit').attr('disabled', 'disabled');
        });
        $("form").bind("invalid-form.validate", function () {
            $(this).find(':submit').prop('disabled', false);
        });
    
        $("#image").change(function(){
            var filename = $("#image").val().length;
            if (filename <= 90){
                $('#save-post').removeAttr('disabled');
                $("#GFG_DOWN").css("display", "none");
            }else{
                $("#GFG_DOWN").css("display", "block");
                $('#save-post').attr('disabled','disabled');
            }
        });
    });
  }); 