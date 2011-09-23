
$(document).ready(function() {
    $('div.step-choice').live("click", function(e){
        e.preventDefault();
        $('textarea[name="form[step]"]').val($(this).children('div.choice-text').html());
    });
   
    if($.trim($('div#highlightStepBool').html()) == 'true')
    {
        var firstStep = $('div.step:first');
        firstStep.animate({
            backgroundColor: '#ffffcc'
        }, 1500).delay('1000').animate({
            backgroundColor: 'white'
        }, 1500);
    }
    
    var headerMessage = $('div.header-message');
    headerMessage.delay(5000).fadeOut(1000);
    
    
    $('div.category-selection').live("click", function(e){
        e.preventDefault();
        $('div.category-selection').removeClass('selected');
        $(this).addClass('selected');
        
        $('input#form_category').val($(this).attr('id'));
    });
    
    $('div.savings-selection').live("click", function(e){
        e.preventDefault();
        $('div.savings-selection').removeClass('selected');
        $(this).addClass('selected');

        $('input#form_savings').val($(this).attr('id'));
    });
       
});