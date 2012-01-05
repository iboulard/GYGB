
$(document).ready(function() {
    // make  header message fade out
    var headerMessage = $('div.header-message');
    headerMessage.delay(5000).fadeOut(1000);
});

function updateTextareaCharacterCounter(inputSelector, counterSelector) {
    var maxLength = $(inputSelector).attr('maxlength');
    var curLength = $(inputSelector).val().length;
    var difference = maxLength - curLength;

    $(counterSelector).html(difference + " characters left");
}
    
    