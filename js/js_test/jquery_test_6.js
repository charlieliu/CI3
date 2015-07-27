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

    $("#parent").change(function(){
        var tag = $(this).parent("label").parent("li").parent("ul");
        tag.addClass('parent');
        showobj(tag);
        if( $(this).prop('checked') )
           tag.css("background", "yellow");
        else
            tag.css("background", "white");
    });
    $("#parents").click(function(){
        var tag = $(this).parents("ul");
        tag.addClass('parents');
        showobj(tag);
        if( $(this).prop('checked') )
            tag.css("background", "blue");
        else
            tag.css("background", "white");
    });
    $("#parents2").click(function(){
        var tag = $(this).parents("ul");
        tag.addClass('parents2');
        showobj(tag);
        if( $(this).prop('checked') )
            tag.css("background", "green");
        else
            tag.css("background", "white");
    });
    $("#closest").click(function(){
        var tag = $(this).closest("ul");
        tag.addClass('closest');
        showobj(tag);
        if( $(this).prop('checked') )
           tag.css("background", "red");
        else
            tag.css("background", "white");
    });
});