
$(document).ready(function() {
    $('div.step-choice').live("click", function(e){
        e.preventDefault();
        $('textarea[name="form[step]"]').val($(this).children('div.choice-text').html());
    });
   
   
    if($.trim($('div#stepTakenBool').html()) == 'true')
    {
        var firstStep = $('div.step:first');
        firstStep.animate({
            backgroundColor: '#ffffcc'
        }, 1500).delay('1000').animate({
            backgroundColor: 'white'
        }, 1500);
    }
    
var headerMessage = $('div.header-message');
headerMessage.delay(3500).fadeOut(1000);
    
    
    $('div.category-selection').live("click", function(e){
        e.preventDefault();
        $('div.category-selection').removeClass('selected');
        $(this).addClass('selected');
        
        $('input#form_category').val($(this).attr('id'));
    });
    
    $('a#commit-your-organization').live("click", function(e){
        e.preventDefault();
        $('a#commit-your-organization').removeClass('button');
        $('a#commit-your-organization').addClass('commitLinkClicked');
        $("div#org-form").show();
    });
    
    $('div.savings-selection').live("click", function(e){
        e.preventDefault();
        $('div.savings-selection').removeClass('selected');
        $(this).addClass('selected');

        $('input#form_savings').val($(this).attr('id'));
    });
       
});