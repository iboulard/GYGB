
$(document).ready(function() {
   $('div.home-column').live("click", function(e){
       e.preventDefault();
       
       var href = $(this).find('a').attr('href');
       
       document.location = href;
   });
    
});