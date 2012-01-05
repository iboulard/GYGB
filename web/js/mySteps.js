
$(document).ready(function() {

tinyMCE.init({
        // General options
        mode : "specific_textareas",
        editor_selector : "tinymce",
        theme : "advanced",
        plugins : ",advimage,iespell,inlinepopups,insertdatetime,paste",

        theme_advanced_buttons1 : "bold,italic,underline,strikethrough",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,image",
        theme_advanced_buttons3 : "",
        theme_advanced_buttons4 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_resizing : true

  
});

    if($('div.input textarea#form_story').length > 0) {
        // listen for keyups to update counter
        $('div.input textarea#form_story').live("keyup", function(e) {
            updateTextareaCharacterCounter('textarea#form_story', '.story-char-counter');
        });     
        // init counter
        updateTextareaCharacterCounter('textarea#form_story', '.story-char-counter');
    } else {
        // listen for keyups to update counter
        $('div.input input#form_commitment').live("keyup", function(e) {
            updateTextareaCharacterCounter('input#form_commitment', '.commitment-char-counter');
        });     
        // init counter
        updateTextareaCharacterCounter('input#form_commitment', '.commitment-char-counter');        
    }
        
     
});

