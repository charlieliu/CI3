$(function(){
    $('.more').click(function(){
        $(this).parents('div').find('ul').addClass('my-class');
    });
});