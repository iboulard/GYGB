
$(document).ready(function() {
   $('a#commit-to-this-step').live("click", function(e){
        e.preventDefault();
        
        $('div#commit-form').show();                
   });  
});