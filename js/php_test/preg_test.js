function colorful()
{
    $('.content_value').each(function(){
        if( $(this).html()=='1' ) { $(this).css('color','blue'); $(this).parents('tr').css('background-color','#DDDDDD'); return; }
        if( $(this).html()=='0' ) { $(this).css('color','red'); }
    });
}

$(document).ready(function(){
    colorful();
    $('#seach').off('click').on('click',function(event){
        event.preventDefault();
        $.post(
            "",
            {'str':$('#str').val(),csrf_test_name:$('#csrf_test_name').val()},
            function( data ) { $('#grid_view').html( data.grid_view ); colorful(); },
            'json'
        );
    });
    $('#btn_cancel').click(function(event){
        event.preventDefault();
        $('#frm1')[0].reset();
        // document.getElementById("frm1").reset();
    });
});