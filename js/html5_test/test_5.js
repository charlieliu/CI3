$(document).ready(function(){
    $('li').click(function(){
        var str = '';
        $(this).each(function() {
            $.each(this.attributes, function() {
                // this.attributes is not a plain object, but an array
                // of attribute nodes, which contain both the name and value
                if(this.specified) {
                    //console.log(this.name, this.value);
                    str += this.name+' => ('+typeof(this.value)+')'+this.value+'<br>';
                }
            });
        });
        str += '<br>// attr() v.s. prop()<br>';
        str += 'attr(\'id\') => ('+typeof($(this).attr('id'))+')'+$(this).attr('id')+'<br>';
        str += 'attr(\'data-animal-type\') => ('+typeof($(this).attr('data-animal-type'))+')'+$(this).attr('data-animal-type')+'<br>';
        str += 'attr(\'disabled\') => ('+typeof($(this).attr('disabled'))+')'+$(this).attr('disabled')+'<br>';
        str += 'attr(\'clicked\') => ('+typeof($(this).attr('clicked'))+')'+$(this).attr('clicked')+'<br>';
        str += 'prop(\'disabled\') => ('+typeof($(this).prop('disabled'))+')'+$(this).prop('disabled')+'<br>';
        str += 'prop(\'clicked\') => ('+typeof($(this).prop('clicked'))+')'+$(this).prop('clicked')+'<br>';
        $('#results').html(str);
    });
});