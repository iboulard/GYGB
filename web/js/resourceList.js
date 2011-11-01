
$(document).ready(function() {
    $('div.organizations div.organization').live("click", function(e){
       // do not respond to clicks on the steps
       if($(e.target).is('div.step') || $(e.target).parent().is('.step'))
       {
           return;
       }

       e.preventDefault();

       // use href from any link clicked
       if($(e.target).is('a'))
       {
           var href = $(e.target).attr('href');
       }
       // use href from any part of any link clickted
       else if($(e.target).parent().is('a'))
       {
           var href = $(e.target).parent().attr('href');          
       }
       // otherwise use the href of the box-link
       else {
            var href = $(this).find('a.box-link').attr('href');
       }
       
       window.open(href,'_blank');

   });
     
});
