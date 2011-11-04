
$(document).ready(function() {
   $('a#commit-to-this-step').live("click", function(e){
        $('div#commit-form-container').show();                
   });  
   $('a#commit-form-cancel').live("click", function(e){
        e.preventDefault();
        
        $('div#commit-form-container').hide();                
   });  
   
});