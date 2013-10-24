<?php 

function EscreveJavascriptContadorCaracteres()
{ ?>
<script>
jQuery(function($)
    {
        $("#comment").keyup(function() {
            
            var contador = parseInt($("#comment").val().length);

            $('#contadorcaracteres').html(contador+' '+(contador>1?'caracteres':'caracter'));          
          });

        $('#comment').focus(); 
     
    });               
</script>

<?php } ?>