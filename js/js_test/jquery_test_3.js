$(function(){
    $('div.test').on({
        click: function(event){
            $(this).toggleClass('active');
            $('#locl').text( "( " + event.pageX + ", " + event.pageY + " )" );
        },
        mouseenter: function(){
            $(this).addClass('inside');
        },
        mouseleave: function(){
            $(this).removeClass('inside');
        }
    });
    $('div.test2').bind({
        click: function(event){
            $(this).toggleClass('active');
            $('#locl2').text( "( " + event.pageX + ", " + event.pageY + " )" );
        },
        mouseenter: function(){
            $(this).addClass('inside');
        },
        mouseleave: function(){
            $(this).removeClass('inside');
        }
    });
});