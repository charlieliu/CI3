$(document).ready(function(){
        var str = '';

        /* Numbers */
        str += '<br>// Numbers <br>';
        str += '// 在 JavaScript 中，整數和浮點值之間沒有任何差異，JavaScript 數字可以是整數或浮點值 (在內部，JavaScript 會將所有數字表示為浮點值)。<br>';
        str += 'typeof 37 === '+typeof(37)+'<br>';
        str += 'typeof 3.14 === '+typeof(3.14)+'<br>';
        str += 'typeof Math.LN2 === '+typeof(Math.LN2)+'<br>';
        str += 'typeof Infinity === '+typeof(Infinity)+'<br>';
        str += 'typeof NaN === '+typeof(NaN)+'// 雖然是 "Not-A-Number"<br>';
        str += 'typeof Number(1) === '+typeof(Number(1))+'// 但是不要使用這種方式!<br>';

        /* Strings */
        str += '<br>// Strings<br>';
        str += 'typeof "" === '+typeof("")+'<br>';
        str += 'typeof "bla" === '+typeof("bla")+'<br>';
        str += 'typeof typeof 1 === '+typeof(typeof 1)+'// typeof 一律會傳回一個字串<br>';
        str += 'typeof String("abc") === '+typeof(String("abc"))+'// 但是不要使用這種方式!<br>';

        /* Booleans */
        str += '<br>// Booleans<br>';
        str += 'typeof true === '+typeof(true)+'<br>';
        str += 'typeof false === '+typeof(false)+'<br>';
        str += 'typeof Boolean(true) === '+typeof(Boolean(true))+'// 但是不要使用這種方式!<br>';

        /* Undefined */
        str += '<br>// Undefined<br>';
        str += '// 是 JavaScript 中特殊的值，當你試圖取得某個沒指定任何值的變數（也沒指定 null）或特性（Properties）時，就會出現 undefined 的結果。<br>';
        str += '// 對 undefined 使用 typeof 的結果是 \'undefined\'。在 Node.js 中，undefined 會顯示 undefined。<br>';
        str += 'typeof undefined === '+typeof(undefined)+'<br>';
        str += 'typeof blabla === '+typeof(blabla)+'// 一個 undefined 變數<br>';

        /* Objects*/
        str += '<br>// Objects<br>';
        str += 'typeof {a:1} === '+typeof({a:1})+'<br>';
        str += 'typeof [1, 2, 4] === '+typeof([1, 2, 4])+'// 請使用 Array.isArray 或者 Object.prototype.toString.call 以區分正規運算式和陣列<br>';
        str += 'typeof new Date() === '+typeof(new Date())+'<br>';

        str += 'typeof new Boolean(true) === '+typeof(new Boolean(true))+'// 這樣會令人混淆。不要這樣用!<br>';
        str += 'typeof new Number(1) === '+typeof(new Number(1))+'// 這樣會令人混淆。不要這樣用!<br>';
        str += 'typeof new String("abc") === '+typeof(new String("abc"))+'// 這樣會令人混淆。不要這樣用!<br>';

        /* Functions */
        str += '<br>// Functions<br>';
        str += 'typeof function(){} === '+typeof(function(){})+'<br>';
        str += 'typeof Math.sind === '+typeof(Math.sind)+'<br>';

        /* null */
        str += '<br>// null <br>';
        str += '// 是 JavaScript 中特殊的值，表示沒有任何東西。應用的時機就是在變數不參考至任何物件時，可以指定變數為 null<br>';
        str += '// 對 null 使用 typeof 的結果會是 \'object\'，這很怪（只能強記），因為用 instanceof 測試 null 是否為 Object 的實例，結果卻是 false<br>';
        str += 'typeof null === '+typeof(null)+'<br>';
        str += 'null instanceof Object === ';
        str += null instanceof Object;
        str += '<br>';

        /* 正規表示式 (Regular expressions) */
        str += '<br>// 正規表示式 (Regular expressions)<br>';
        str += '// Chrome 1-12 ... \'function\' 不符合 ECMAScript 5.1 (譯註: 在新版 Chrome 已修正為 \'object\') <br>';
        str += '// Firefox 5+ ... \'object\' 符合 ECMAScript 5.1<br>';
        str += 'typeof /s/ === '+typeof(/s/)+'<br>';

        /* 其它怪異輸入 (quirks) */
        str += '<br>// 其它怪異輸入 (quirks)<br>';
        str += '// 在 IE 6, 7 和 8, typeof alert === \'object\'<br>';
        str += '// 註: 這並不怪異。這是實情。在許多較舊的 IE 中, 主機端物件的確是物件, 而非函數<br>';
        str += 'typeof alert === '+typeof(alert)+'<br>';

        /* isNaN() Not-A-Number */
        str += '<br>// isNaN() Not-A-Number<br>';
        str += '// 無法自動型態轉換至數字的值，都會讓 isNaN 的結果為 true，像是非數字格式且非空的字串、undefined 等。<br>';
        str += 'isNaN NaN === '+isNaN(NaN)+'<br>';
        str += 'isNaN 1/\'two\' === '+isNaN(1/'two')+'<br>';
        str += 'isNaN \'caterpillar\' === '+isNaN('caterpillar')+'<br>';
        str += 'isNaN undefined === '+isNaN(undefined)+'<br>';
        str += 'isNaN 0 === '+isNaN(0)+'<br>';

        $('#show_info').html(str);
    });