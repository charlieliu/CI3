$(document).ready(function(){
    var readyToRender = $.Deferred();
    //A function in which readyToRender is resolved
    //...
    $("#deferRendering").dxDeferRendering({
        renderWhen: readyToRender.promise()
    }).css('margin','2%');
    console.log($("#deferRendering"));
});