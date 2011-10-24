

$(document).ready(function() {
    // general
    var headerMessage = $('div.header-message');
    headerMessage.delay(5000).fadeOut(1000);
    
    $('div#filters .filter input').attr('checked', true);

    // Step Form
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

    $('div.category-selections#organization').find('div.category-selection').live("click", function(e){
        e.preventDefault();
        $('div.category-selections#organization').find('div.category-selection').removeClass('selected');
        $(this).addClass('selected');
        
        $('input#form_org-category').val($(this).attr('id'));
    });

    $('div.savings-selection').live("click", function(e){
        e.preventDefault();
        $('div.savings-selection').removeClass('selected');
        $(this).addClass('selected');

        $('input#form_savings').val($(this).attr('id'));
    });
    
    // step list links
    $('div.step-container').live("click", function(e) {
        e.preventDefault();
        if($(this).find('a.step-link').size() > 0) {
            document.location = $(this).find('a.step-link').attr('href');            
        }
    });
    
    // step filters
    $('div#filters div.filter-group a.see-all').live("click", function(e){
        e.preventDefault();
        
        var filterType = $(this).attr('id');
        
        // check all the checkboxes
        $('div.filter.' + filterType + ' input').attr('checked', true);
        
        // show all the steps
        $('div.step-container.' + filterType + '-hidden').removeClass(filterType + '-hidden');
        
        // mark all the filters "current"
        $('div.filter.' + filterType).addClass('current');
        
        // if categories, show all the ads
        /*if(filterType == 'category') {
            $('div#ads div.logo-container').show();
        }*/
        
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
        
        // if categories, show all the ads for this category
        /*if(filterType == 'category') {
            $('div#ads div.logo-container').hide();
            $('div#ads div.logo-container.' + filterClass).show();
        }*/
        
        fixLastStep();
    });

    $('div#filters div.filter input').live("click", function(e){
//        e.preventDefault();
        
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
            // uncheck the box if something besides the box was checked
            //if(!$(e.target).is('input')) input.attr('checked', false);
//            input.attr('checked', false);

            // since there are multiple filters, there are multiple ways a filter can be hidden, so mark how it was hidden
            $('div.step-container.' + filterClass).addClass(filterType + '-hidden');

            // hide relevant adds if a category is deselected
            /*if(filterType == 'category') {
                $('div#ads div.logo-container.' + filterClass).hide();
            }*/
        }
        else {
            filter.addClass('current');
            // check the box if something besides the box was checked
            //if(!$(e.target).is('input')) input.attr('checked', true);
//            input.attr('checked', true);

            // since there are multiple filters, there are multiple ways a filter can be hidden, so mark how it was hidden
            $('div.step-container.' + filterClass).removeClass(filterType + '-hidden');

            // show relevant adds if a category is selected
            /*if(filterType == 'category') {
                $('div#ads div.logo-container.' + filterClass).show();
            }*/
        }
        
        fixLastStep();
                        
    });
    
   
    
    // sort
    $('div#sort-options a#recent').live("click", function(e){
        e.preventDefault();
        
        $('div#sort-options a#popular').removeClass('current');
        if(!$(this).hasClass('current')) $(this).addClass('current');
        $("div.step-list-container>div.step-container").tsort('', {attr:"id"});
        
        fixLastStep();
    });
    
    $('div#sort-options a#popular').live("click", function(e){
        e.preventDefault();
        
        $('div#sort-options a#recent').removeClass('current');
        if(!$(this).hasClass('current')) $(this).addClass('current');
        $("div.step-list-container>div.step-container").tsort('span.count', {order: 'desc'});

        fixLastStep();
    });
    
   // home
   $('div.home-column').live("click", function(e){
       e.preventDefault();
       
       var href = $(this).find('a').attr('href');
       
       document.location = href;
   });
   
   $('div.organizations div.organization').live("click", function(e){
       if($(e.target).is('div.step') || $(e.target).parent().is('.step'))
       {
           return;
       }

       
       if($(e.target).is('a'))
       {
           var href = $(e.target).attr('href');
       }
       else if($(e.target).parent().is('a'))
       {
           var href = $(e.target).parent().attr('href');          
            e.preventDefault();
       }
       else {
            e.preventDefault();
            var href = $(this).find('a.box-link').attr('href');
       }
       
       window.open(href,'_blank');

   });
   
   $('a#commit-to-this-step').live("click", function(e){
        e.preventDefault();
        
        $('div#commit-form').show();                
   });
   
});

function fixLastStep()
    {
        $("div.step-list-container div.step-container").removeClass('last');
        $("div.step-list-container div.step-container:visible").filter(':last').addClass('last');        
    }