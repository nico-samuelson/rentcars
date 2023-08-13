$(document).ready(function() {
    $(".change-schedule-dropdown").hide();
    
    $(document.body).on('click', '#dropdown-toggler', function() {
        $('.change-schedule-dropdown').slideToggle(400);
    })
})