$(function(){
    $("#goTop").click(function(){
        jQuery("html,body").animate({
            scrollTop:0
        },500);
    });
    $(window).scroll(function() {
        if ( $(this).scrollTop() > 300){
            $('#goTop').fadeIn("fast");
        } else {
            $('#goTop').stop().fadeOut("fast");
        }
    });
    console.log(navigator.userAgent.toLowerCase());
});