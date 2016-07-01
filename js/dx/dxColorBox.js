$(document).ready(function(){
    $("#colorBox").dxColorBox({
        value: 'rgba(255, 144, 0, 0.3)',
        editAlphaChannel: true,
        onValueChanged: function(e){
            console.log(e);
        }
    }).css('margin','2%');
});