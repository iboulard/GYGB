
$(document).ready(function() {
    // check filters (brower remembers what was checked on reload, but page loads with step from all filters)
    $('div#filters .filter input').attr('checked', true);

    $('div#filters div.filter-group a.see-all').live("click", function(e){
        e.preventDefault();
        
        var filterType = $(this).attr('id');
        
        // check all the checkboxes
        $('div.filter.' + filterType + ' input').attr('checked', true);
        
        // show all the steps
        $('div.step-container.' + filterType + '-hidden').removeClass(filterType + '-hidden');
        
        // mark all the filters "current"
        $('div.filter.' + filterType).addClass('current');
        
        fixLastStep();
    });

    $('div#filters div.filter').live("click", function(e){
        if($(e.target).is('div.filter input')) return;
        
        e.preventDefault();
        
        var filter = $(this);
        filter = $(filter);
        
        var filterClass = filter.attr('id'); 
        
        var filterType;
        
        if(filter.hasClass('category')) filterType = 'category';
        else if(filter.hasClass('savings')) filterType = 'savings';
        else filterType = 'type';
        
        // check other checkboxes of this type
        $('div.filter.' + filterType + ' input').attr('checked', false);
        filter.children('input').attr('checked', true)
        
        // hide other steps of this type
        $('div.step-container').addClass(filterType + '-hidden');
        $('div.step-container.' + filterClass).removeClass(filterType + '-hidden');
        
        // UNmark all the other filters of this type as "current"
        $('div.filter.' + filterType).removeClass('current');
        filter.addClass('current');
        
        fixLastStep();
    });

    $('div#filters div.filter input').live("click", function(e){
        var filter = $(this).parent();
        filter = $(filter);
        var filterClass = filter.attr('id');
        var input = $(this);
        input = $(input);
        
        var filterType;
        
        if(filter.hasClass('category')) filterType = 'category';
        else if(filter.hasClass('savings')) filterType = 'savings';
        else filterType = 'type';
        
        if(filter.hasClass('current')) {
            filter.removeClass('current');
            // since there are multiple filters, there are multiple ways a filter can be hidden, so mark how it was hidden
            $('div.step-container.' + filterClass).addClass(filterType + '-hidden');
        } else {
            filter.addClass('current');
            // since there are multiple filters, there are multiple ways a filter can be hidden, so mark how it was hidden
            $('div.step-container.' + filterClass).removeClass(filterType + '-hidden');
        }
        
        fixLastStep();
    });
   
    $('div#sort-options a#recent').live("click", function(e){
        e.preventDefault();
        
        $('div#sort-options a').removeClass('current');
        if(!$(this).hasClass('current')) $(this).addClass('current');
        $("div.step-list-container>div.step-container").tsort('', {attr:"id"});
        
        fixLastStep();
    });
    
    $('div#sort-options a#steps').live("click", function(e){
        e.preventDefault();
        
        $('div#sort-options a').removeClass('current');
        if(!$(this).hasClass('current')) $(this).addClass('current');
        $("div.step-list-container>div.step-container").tsort('span.step-count', {order: 'desc'});

        fixLastStep();
    });
    $('div#sort-options a#commitments').live("click", function(e){
        e.preventDefault();
        
        $('div#sort-options a').removeClass('current');
        if(!$(this).hasClass('current')) $(this).addClass('current');
        $("div.step-list-container>div.step-container").tsort('span.commitment-count', {order: 'desc'});

        fixLastStep();
    });
});

function fixLastStep()
{
    $("div.step-list-container div.step-container").removeClass('last');
    $("div.step-list-container div.step-container:visible").filter(':last').addClass('last');        
}