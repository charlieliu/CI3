$(document).ready(function(){

    $('#c').val($('#a').val());

    $('#x').css('padding','0').val(parseInt($('#a').val())+parseInt($('#b').val()));
    $('#e').css('padding','0').val(parseInt($('#d').val()));

    $('#a').change(function(){
        $('#c').val(parseInt($('#a').val()));
    });
    $('#b').change(function(){
        $('#x').val(parseInt($('#a').val())+parseInt($('#b').val()));
    });

    $('#g').val(parseInt($('#d').val())+parseInt($('#f').val()));

    $('#d').change(function(){
        $('#g').val(parseInt($('#d').val())+parseInt($('#f').val()));
    });
    $('#f').change(function(){
        $('#g').val(parseInt($('#d').val())+parseInt($('#f').val()));
    });
    $('#g').change(function(){
        $('#d').val(parseInt($('#g').val())-parseInt($('#f').val()));
        $('#e').val(parseInt($('#d').val()));
    });


});