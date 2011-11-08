
$(document).ready(function() {
    
    $('div.step-container').live("click", function(e) {
        if($(e.target).hasClass('btn')) return;
        if(!$(this).hasClass('not-linked')) e.preventDefault();
        
        
        if($(this).find('a.step-link').size() > 0) {
            document.location = $(this).find('a.step-link').attr('href');            
        }
    });
        
});