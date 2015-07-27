$(document).ready(function(){
    $(".contact1").submit(function() {
        var this_results = $(this).find('.results');
        $.ajax({
            type: "POST",
            url: '',
            data:$(this).serialize(),
            success: function (data) {
                // Inserting html into the result div on success
                this_results.html(data);
            },
            error: function(jqXHR, text, error){
                // Displaying if there are any errors
                this_results.html(error);
            }
        });
        return false;
    });
});