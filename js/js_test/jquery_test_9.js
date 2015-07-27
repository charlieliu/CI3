$(document).ready(function(){
    var arr = [undefined,0,'1','2',3,null,function(){}], str = '', res = '';

    function show_arr(){
        str += 'var arr = [ ';
        var num = 0;
        for(var n in arr){
            if( num!=0 ) str += ', ';
            str += n+' : ('+typeof(arr[n])+')'+arr[n];
            num++;
        }
        str += ' ];<br>';
    };

    show_arr();

    str += '<br>// push 從後面添加新元素 回傳元素個數<br>';
    show_arr();
    res = arr.push('push') ;
    str += 'arr.push(\'push\') === ('+typeof(res)+')'+res+'<br>';
    show_arr();
    str += '<br>// pop 從後面拿掉元素 回傳拿掉元素<br>';
    show_arr();
    res = arr.pop() ;
    str += 'arr.pop() === ('+typeof(res)+')'+res+'<br>';
    show_arr();
    res = arr.pop() ;
    str += 'arr.pop() === ('+typeof(res)+')'+res+'<br>';
    show_arr();
    res = arr.pop() ;
    str += 'arr.pop() === ('+typeof(res)+')'+res+'<br>';
    show_arr();
    str += '<br>// unshift 從前面添加新元素 回傳元素個數<br>';
    show_arr();
    res = arr.unshift('unshift') ;
    str += 'arr.unshift(\'unshift\') === ('+typeof(res)+')'+res+'<br>';
    show_arr();
    str += '<br>// shift 從前面拿掉元素 回傳拿掉元素<br>';
    show_arr();
    res = arr.shift() ;
    str += 'arr.shift() === ('+typeof(res)+')'+res+'<br>';
    show_arr();
    res = arr.shift() ;
    str += 'arr.shift() === ('+typeof(res)+')'+res+'<br>';
    show_arr();
    res = arr.shift() ;
    str += 'arr.shift() === ('+typeof(res)+')'+res+'<br>';
    show_arr();

    $('#show_info').html(str);
});