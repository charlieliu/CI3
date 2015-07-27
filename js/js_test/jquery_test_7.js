$(document).ready(function(){
    function showobj(obj){
        var str = '';
        for(var n in obj)
        {
            if( obj.n!=undefined )
                str += '{' + n + ':' + obj.n + '}<br>' ;
        }
        $('#showobj_info').html(str);
    };

    $("#siblings").click(function(){
        var tag = $(this).parent("label").parent("li").siblings("li");
        tag.addClass('siblings');
        showobj(tag);
        if( $(this).prop('checked') )
            tag.css("background", "#DDD");
        else
            tag.css("background", "white");
    });
    $("#siblings2").click(function(){
        var tag = $(this).parent("label").parent("li").siblings("li");
        tag.addClass('siblings2');
        showobj(tag);
        if( $(this).prop('checked') )
            tag.css("background", "#DDD");
        else
            tag.css("background", "white");
    });
    $("#next").click(function(){
        var tag = $(this).parent("label").parent("li").next("li");
        tag.addClass('next');
        showobj(tag);
        if( $(this).prop('checked') )
            tag.css("background", "#888");
        else
            tag.css("background", "white");
    });
    $("#nextAll").click(function(){
        var tag = $(this).parent("label").parent("li").nextAll("li");
        tag.addClass('nextAll');
        showobj(tag);
        if( $(this).prop('checked') )
            tag.css("background", "#AAA");
        else
            tag.css("background", "white");
    });
    $("#prev").click(function(){
        var tag = $(this).parent("label").parent("li").prev("li");
        tag.addClass('prev');
        showobj(tag);
        if( $(this).prop('checked') )
            tag.css("background", "#888");
        else
            tag.css("background", "white");
    });
    $("#prevAll").click(function(){
        var tag = $(this).parent("label").parent("li").prevAll("li");
        tag.addClass('prevAll');
        showobj(tag);
        if( $(this).prop('checked') )
            tag.css("background", "#AAA");
        else
            tag.css("background", "white");
    });
});