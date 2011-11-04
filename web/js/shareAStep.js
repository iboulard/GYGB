
$(document).ready(function() {
    $('a.share-your-own').live("click", function(e){
        e.preventDefault();
        $('fieldset#select-a-step').hide();
        
        $('fieldset#share-your-own').show();
    });
    
    $('a.share-your-own-cancel').live("click", function(e){
        e.preventDefault();
        $('fieldset#select-a-step').show();
        
        $('fieldset#share-your-own').hide();
        
        $('input#form_step').val("");
    });
    
    $('div.category-selections#step').find('div.category-selection').live("click", function(e){
        e.preventDefault();
        $('div.category-selections#step').find('div.category-selection').removeClass('selected');
        $(this).addClass('selected');
        
        $('input#form_category').val($(this).attr('id'));
    });
    
    initializeSubmissionMap();


});
