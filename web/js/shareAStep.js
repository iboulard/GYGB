
$(document).ready(function() {
    $('a.share-your-own').live("click", function(e){
        e.preventDefault();
        $('div.select-a-step').hide();
        
        $('div.share-your-own-container').show();
    });
    
    $('a.share-your-own-cancel').live("click", function(e){
        e.preventDefault();
        $('div.select-a-step').show();
        
        $('div.share-your-own-container').hide();
        
        $('input#form_step').val("");
    });
    
    $('div.category-selections#step').find('div.category-selection').live("click", function(e){
        e.preventDefault();
        $('div.category-selections#step').find('div.category-selection').removeClass('selected');
        $(this).addClass('selected');
        
        $('input#form_category').val($(this).attr('id'));
    });

});
