// popover sidebar
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});

$('.popover-dismiss').popover({
    trigger: 'focus'
})

// apply select2 to multiple select inputs
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

// button collaps for search
$(document).ready(function(){
    $("#toggle-btn").click(function(){
        $("#toggle-example").collapse('toggle'); // toggle collapse
    });
});
