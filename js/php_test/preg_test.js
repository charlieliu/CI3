function colorful()
{
    $('.content_value').each(function(){
        if( $(this).html()=='1' )
        {
            $(this).css('color','blue');
            $(this).parents('tr').css('background-color','#DDDDDD');
        }
        else if( $(this).html()=='0' )
        {
            $(this).css('color','red');
        }
    });
}

$(document).ready(function(){

    colorful();

    $('#seach').off('click').on('click',function(event){
        event.preventDefault();
        $.post(
            "",
            {'str':$('#str').val()},
            function( data ) {
                $('#grid_view').html( data.grid_view );
                colorful();
            },
            'json'
        );
    });
});