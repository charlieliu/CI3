$(document).ready(function(){

    var result  = '危險！',
        def_css = {
            'background':'#ddd',
            'width':'50px',
            'height':'24px',
            'display':'inline-block',
            'margin':'0'
        };

    //CharMode函數
    //測試某個字符是屬於哪一類.
    function CharMode(iN)
    {
        if (iN>=48 && iN <=57) //數字
            return 1;// 二進位 0001
        if (iN>=65 && iN <=90) //大寫字母
            return 2;// 二進位 0010
        if (iN>=97 && iN <=122) //小寫
            return 4;// 二進位 0100
        else//特殊字符
            return 8;// 二進位 1000
    }

    //bitTotal函數
    //計算出當前密碼當中一共有多少種模式
    function bitTotal(num)
    {
        modes=0;
        for (i=0;i<4;i++)
        {
            if (num & 1) modes++;
            /*
                位元運算子 a>>>b 往右移動 a 的二進制表示法 b 位元，丟棄移出的位元，並從左邊補 0。
                例如 1111>>>1 = 0111
            */
            num>>>=1;
        }
        return modes;
    }

    //checkStrong函數
    //返回密碼的強度級別
    function checkStrong(sPW)
    {
        var is_top_pwds = false ;
        for (var i = 0; i<top_pwds.length; i++) {
            if( top_pwds[i]==sPW )
            {
                is_top_pwds = true ;
            }
        };
        if( sPW.length<=4 )
        {
            return 0; //密碼太短
        }
        else if( is_top_pwds )
        {
            return 0;
        }
        Modes=0;
        for (i=0;i<sPW.length;i++){
            //測試每一個字符的類別並統計一共有多少種模式.
            /*
                位元運算子 a|b 每一個對應至同一位元位置的兩個運算元兩者或其中一者為 1 時，返回 1。
                例如 0001|0010 = 0011
            */
            Modes |= CharMode(sPW.charCodeAt(i));
        }
        return bitTotal(Modes);
    }

    //pwStrength函數
    //當用戶放開鍵盤或密碼輸入框失去焦點時,根據不同的級別顯示不同的級別
    function pwStrength(pwd,usna)
    {
        var S_level = 0,
            O_color = '#ddd',
            L_color = T_color = '#f00',
            M_color = '#f90',
            H_color = '#3c0',
            Lcolor  = Mcolor = Hcolor = '#ddd',
            off_set = $('#strongth_L').offset().left;
        if ( pwd!=null && pwd!=usna )
        {
            S_level=checkStrong(pwd);
        }
        switch(S_level) {
            case 0:
                result='危險！';
                break;
            case 1:
                T_color = '#fff' ;
                Lcolor = L_color ;
                result='弱';
                break;
            case 2:
                T_color = '#333' ;
                Lcolor = Mcolor = M_color ;
                result='中';
                off_set = $('#strongth_M').offset().left;
                break;
            default:
                T_color = '#000' ;
                Hcolor = Mcolor = Lcolor = H_color ;
                result='強';
                off_set = $('#strongth_H').offset().left;
                break;
        }
        $("#strongth_L").css('background', Lcolor);
        $("#strongth_M").css('background', Mcolor);
        $("#strongth_H").css('background', Hcolor);
        $("#strongth_status").html(result).css({'color':T_color,'left':off_set});
        return S_level;
    }

    $("#strongth_L").css(def_css);
    $("#strongth_M").css(def_css);
    $("#strongth_H").css(def_css);
    $("#strongth_status").css({
        'position':'absolute',
        'z-index':'1',
        'width':'150px',
        'height':'20px',
        'margin':'0',
        'left':$('#strongth_L').offset().left,
        'top':$('#strongth_L').offset().top
    });

    $('#pwd').keyup(function(){
        pwStrength($(this).val(),$('#usr').val());
    }).blur(function(){
        pwStrength($(this).val(),$('#usr').val());
    }).change(function(){
        pwStrength($(this).val(),$('#usr').val());
    });

    $('#send').click(function(event){
        if( pwStrength($('#pwd').val(),$('#usr').val())<2 )
        {
            if( event.preventDefault ) event.preventDefault(); else event.returnValue = false;
            alert('密碼強度 : '+result);
        }
    });
});