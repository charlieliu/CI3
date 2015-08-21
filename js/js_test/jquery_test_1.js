$(document).ready(function(){
    $('#jq_hide').click(function(){
        $('#jq_hide_show').hide();
    });
    $('#jq_show').click(function(){
        $('#jq_hide_show').show();
    });
    $('#jq_fadeIn').click(function(){
        $('#jq_fading').fadeIn("slow");
    });
    $('#jq_fadeOut').click(function(){
        $('#jq_fading').fadeOut("slow");
    });
    $('#jq_fadeToggle').click(function(){
        $('#jq_fading').fadeToggle("slow");
    });
    $('#jq_fadeTo').click(function(){
        $('#jq_fading').fadeTo("slow",0.4);
    });
    $('#jq_slideDown').click(function(){
        $('#jq_text').slideDown();
    });
    $('#jq_slideUp').click(function(){
        $('#jq_text').slideUp();
    });
    $('#jq_slideToggle').click(function(){
        $('#jq_text').slideToggle();
    });
    $('#jq_html').click(function(){
        $('#jq_text').html('又文熱量有上限');
    });
});