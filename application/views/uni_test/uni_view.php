<div id="body">
    <p>{current_page}/{current_fun}</p>
    <!-- Variable Pairs -->
    <form method="POST">
        <input type="text" name="uni_no" placeholder="統一編號"></input>
        <input type="hidden" id="{csrf_name}" name="{csrf_name}" value="{csrf_value}">
        <input id="submit_btn" type="submit" value="查詢"></input>
    </form>
    <table border="1" style="margin:1em;">
        <thead>
            <tr>
                <th>編號</th>
                <th>A</th>
                <th>B</th>
                <th>C</th>
                <th>D</th>
                <th>E</th>
                <th>F</th>
                <th>G</th>
                <th style="color:red;">H</th>
                <th>SUM</th>
                <th>結果</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>特定倍數</td>
                <td>1</td>
                <td>2</td>
                <td>1</td>
                <td>2</td>
                <td>1</td>
                <td>2</td>
                <td>4</td>
                <td style="color:red;">1</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td >乘上特定倍數</td>
                <td id="cx_0">A x 1</td>
                <td id="cx_1">B x 2</td>
                <td id="cx_2">C x 1</td>
                <td id="cx_3">D x 2</td>
                <td id="cx_4">E x 1</td>
                <td id="cx_5">F x 2</td>
                <td id="cx_6">G x 4</td>
                <td id="cx_7" style="color:red;">H x 1</td>
                <td id="cx_SUM"></td>
                <td id="cx_res"></td>
            </tr>
            <tr>
                <td >十位數和個位數相加</td>
                <td id="cc_0"></td>
                <td id="cc_1"></td>
                <td id="cc_2"></td>
                <td id="cc_3"></td>
                <td id="cc_4"></td>
                <td id="cc_5"></td>
                <td id="cc_6"></td>
                <td id="cc_7" style="color:red;"></td>
                <td id="cc_SUM"></td>
                <td id="cc_res"></td>
            </tr>
        </tbody>
    </table>
    <ul>
        <li>假設統一編號為 A B C D E F G H</li>
        <li>A - G 為編號, H 為檢查碼</li>
        <li>A - G 個別乘上特定倍數, 若乘出來的值為二位數則將十位數和個位數相加</li>
        <li>最後將所有數值加總, 被 10 整除就為正確</li>
        <li>若上述演算不正確並且 G 為 7 得話, 再加上 1 被 10 整除也為正確</li>
    </ul>
    <!-- Variable Pairs -->
</div>
<script type="text/javascript">
var cx = new Array, NO='', SUM=0;
cx[0] = 1;
cx[1] = 2;
cx[2] = 1;
cx[3] = 2;
cx[4] = 1;
cx[5] = 2;
cx[6] = 4;
cx[7] = 1;
function cc(n){
    if(n > 9){
        var s = n + "";
        n1 = s.substring(0,1) * 1;
        n2 = s.substring(1,2) * 1;
        n = n1 + n2;
    }
    return n;
}
$(document).ready(function(){
    $('#submit_btn').off('click').click(function(){
        if(event.preventDefault)event.preventDefault();else event.returnValue = false;
        NO = $('input[name="uni_no"]').val();
        SUM = 0;
        if (NO.length != 8) $('#cx_res').html("統編錯誤，要有 8 個數字"); else $('#cx_res').html("");
        var cnum = NO.split("");
        for (i=0; i<=7; i++){
            if (cnum[i].charCodeAt() < 48 || cnum[i].charCodeAt() > 57) {
                $('#cx_'+i).html(cnum[i]);
                $('#cx_res').html("統編錯誤，要有 8 個 0-9 數字組合");
                return;
            }
            console.log(cnum[i].charCodeAt());
            $('#cx_'+i).html(cnum[i] * cx[i]);
            $('#cc_'+i).html(cc(cnum[i] * cx[i]));
            SUM += cc(cnum[i] * cx[i]);
        }
        if (SUM % 10 == 0) var res = "統一編號："+NO+" 正確!";
        else if (cnum[6] == 7 && (SUM + 1) % 10 == 0) var res = "統一編號："+NO+" 正確!";
        else var res = "統一編號："+NO+" 錯誤!";
        $('#cc_SUM').html(SUM);
        $('#cc_res').html(res);
    });
});
</script>