//定義一個全域變數pig
var pig = "我是豬";
$(function(){
    // 3 functions call / apply =================================================================
    //範例1:丟進去一個jQuery物件，因此funciton裡面的this就代表jQuery物件。
    // 接著就可用jQuery.attr()叫出物件屬性
    function TestApply1(){
        alert(this.attr('href'));
    };
    $("#TestApply1").click(function(){
       TestApply1.apply($('#link'));
    });
    $("#TestCall1").click(function(){
       TestApply1.call($('#link'));
    });
    //-----------------------------------------------------------

    //範例2:丟進去一個windows物件，因此function裡面的this代表window
    //  因為我增加了一個全域變數叫pig，所以用this.pig得到的值就是"我是豬"
    function TestApply2(){
        alert(this.pig);
    };
    $("#TestApply2").click(function(){
       TestApply2.apply(window);
    });
    $("#TestCall2").click(function(){
       TestApply2.call(window);
    });
    // 結論：吃什麼拉什麼，丟進去什麼，裡面的this就是什麼
    //----------------------------------------------------------

    //範例3:順便介紹一下第二個參數的用法
    //  我新增了一個物件叫obj，他內含一個屬性叫myName
    //  當我new 一個 obj丟進去，this就代表obj這個物件，
    //  因此可以用this.myName點出obj的屬性。
    //  第二個參數傳一個陣列進去。
    //  TestApply3這個function有兩個參數，所以我丟進一個有兩個值的陣列進去。
    function obj() {this.myName = "部落";};
    function TestApply3(arg1, arg2){
        alert(this.myName+' '+arg1+' '+arg2);
    };
    $("#TestApply3").click(function(){
        TestApply3.apply(new obj(), ['是個', '好地方']);
    });
    $("#TestCall3").click(function(){
        TestApply3.call(new obj(), ['是個', '好地方']);
    });
    //----------------------------------------------------------
    /*
    $('#link').off('click').on('click',function(){
        //alert($(this).attr('id'));
        //$.TestApply1.apply($(this));
        alert(window);
    });
    */

    //彈出按鈕的value，並判斷如果有參數的話彈出參數值。
    function AlertValue(){
        var str = '';
        str += 'this.value('+typeof(this.value)+')'+this.value+'\n';
        if( arguments.length>0 )
        {
            for (var i = 0; i < arguments.length; i++){
                str += 'arguments['+i+']('+typeof(arguments[i])+')'+arguments[i]+'\n' ;
            }
        }
        alert(str);
    };

    //當A按鈕click時，執行AlertValue這個function，跳出按鈕的value
    $("#A").click(AlertValue);

    //當B按鈕click時，一樣執行AlertValue，執行時function內部的this
    //會變成B按鈕，並且可用一個陣列傳入參數。
    $("#B").click(function(){
        AlertValue.apply(this, ["1", "2", "3"]);
    });
    $("#C").click(function(){
        AlertValue.call(this, ["1", "2", "3"]);
    });
    $("#D").click(function(){
        AlertValue.apply(this);
    });
    $("#E").click(function(){
        AlertValue.call(this);
    });
    $("#F").click(function(){
        AlertValue.apply({value:'0'});
    });
    $("#G").click(function(){
        AlertValue.call({value:'0'});
    });
    // 3 functions call / apply =================================================================

    // object call / apply =================================================================
    function showobj(obj){
        var str = '';
        str += '{ name : ' + obj.name + ' }<br>' ;
        str += '{ category : ' + obj.category + ' }<br>' ;
        str += '{ showName : ' + obj.showName + ' }<br>' ;
        str += '{ setName : ' + obj.setName + ' }<br>' ;
        str += '{ prototype_parent : ' + obj.prototype_parent + ' }<br>' ;
        str += '{ skills : ' + obj.skills + ' }<br>' ;
        $('.showobj_info').html(str);
    };
    $('#showobj').click(function(){
        showobj('');
    });
    showobj('');

    function return_info(obj){
        var str = '';
        str += 'name : ' + obj.name + '<br>' ;
        str += 'category : ' + obj.category + '<br>' ;
        str += 'showName : ' + obj.showName + '<br>' ;
        str += 'setName : ' + obj.setName + '<br>' ;
        str += 'skills : ' + obj.skills + '<br>' ;
        return str;
    };

    function Animal(){
        this.name = 'Animal';
        // this.name = this.name || 'Animal';
        this.category = 'Creature';
        this.showName = function(){showobj(this);};
        this.setName = function(str){this.name=str;};
    };
    var animal = new Animal();

    $('#Animal').click(function(){
        animal.showName();
    });

    // 不繼承
    function Cat(){
        this.name = 'Cat';
    };
    var cat = new Cat();
    $('#Cat_call').click(function(){
        animal.showName.call(cat);
    });
    $('#Cat_apply').click(function(){
        animal.showName.apply(cat);
    });
    $('#showobj_cat').click(function(){
        showobj(cat);
    });

    // 繼承
    function Dog_call(){
        Animal.call(this);
        this.setName('Dog');
    };
    Dog_call.prototype = { prototype_parent : 'Animal' };
    var dog_call = new Dog_call();

    function Dog_apply(){
        Animal.apply(this);
        this.setName('Dog');
    };
    Dog_apply.prototype = { prototype_parent : 'Animal' };
    var dog_apply = new Dog_apply();

    $('#Dog_call').click(function(){
        dog_call.showName();
    });
    $('#Dog_apply').click(function(){
        dog_apply.showName();
    });

    // 繼承
    function Birds(){
        this.name = 'Birds';
        Animal.call(this);
    };
    Birds.prototype = {
        name : 'Birds',
        skills : 'fly'
    };
    var birds = new Birds;

    function Duck(){
        Birds.call(this);
        this.setName('Duck');
    };
    var duck = new Duck;


    function Ostrich(){
        Birds.call(this);
        this.setName('Ostrich');
        this.skills = 'run';
    };
    var ostrich = new Ostrich;

    function Chicken(){
        Birds.call(this);
        this.name = 'Chicken';
    };
    Chicken.prototype = {
        skills : 'run',
    };
    var chicken = new Chicken;

    function show_return_info(){
        $('#animal').html(return_info(animal));
        $('#birds').html(return_info(birds));
        $('#duck').html(return_info(duck));
        $('#ostrich').html(return_info(ostrich));
        $('#chicken').html(return_info(chicken));
    }
    show_return_info();
    // object call / apply =================================================================

    // Array.prototype.slice.call(arguments) =================================================================
    var list_count = 1;
    function list(){
        var row = $('<tr></tr>').append($('<th></th>').html('list'+list_count))
                                .append($('<th></th>').html('typeof'))
                                .append($('<th></th>').html('length'))
                                .append($('<th></th>').html('object'));
        var table = $('<table border="1"></table>').css({'margin':'1em','background':'#'+list_count+list_count+list_count,'color':'white'}).append(row) ;
        function str_maker(tag,title){
            row = $('<tr></tr>').append($('<td></td>').html(title))
                                .append($('<td></td>').html(typeof(tag)))
                                .append($('<td></td>').html(tag.length))
                                .append('<td>'+tag+'</td>');// $('<td></td>').html(tag)會有問題tag是object;
            table.append(row);
        }
        str_maker(arguments,'arguments');
        str_maker(Array.prototype.slice.call(arguments),'Array.prototype.slice.call(arguments)');
        str_maker(Array.prototype.slice.apply(arguments),'Array.prototype.slice.apply(arguments)');
        str_maker(Array.prototype.slice.call(arguments, 0, 2),'Array.prototype.slice.call(arguments, 0, 2)');
        str_maker(Array.prototype.slice.apply(arguments, [0, 2]),'Array.prototype.slice.apply(arguments, [0, 2])');
        str_maker(Array.prototype.slice.call(arguments, 1),'Array.prototype.slice.call(arguments, 1)');
        str_maker(Array.prototype.slice.apply(arguments, [1]),'Array.prototype.slice.apply(arguments, [1])');
        str_maker(Array.prototype.slice.call(arguments, 2),'Array.prototype.slice.call(arguments, 2)');
        $('#list_info').append(table);
        list_count++;
    }

    var list1 = list('a', 'b', 'c', 'd');

    //  Create a function with a preset leading argument
    var leadingZeroList = list.bind(undefined, 37);

    var list2 = leadingZeroList();
    var list3 = leadingZeroList('X', 'Y', 'Z');
    // Array.prototype.slice.call(arguments) =================================================================
});