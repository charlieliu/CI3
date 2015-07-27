<div id="body">
    <p>{current_page}/{current_fun}</p>

    <form id="frm1" action="{base_url}login/{btn_url}" method="POST">
        <table>
            <tr>
                <th><label for="username">帳號 : </label></th>
                <td><input type="text" id="username" name="username" placeholder="username"></td>
            </tr>
            <tr>
                <th><label for="pwd">密碼 : </label></th>
                <td><input type="password" id="pwd" name="pwd" placeholder="password" AUTOCOMPLETE="OFF"></td>
            </tr>
            <tr>
                <th><label for="repwd">確認密碼 : </label></th>
                <td><input type="password" id="repwd" name="repwd" placeholder="re-password" AUTOCOMPLETE="OFF"></td>
            </tr>
            <tr>
                <th><label for="email">Enail : </label></th>
                <td><input type="text" id="email" name="email" placeholder="email"></td>
            </tr>
            <tr>
                <th><label for="addr">地址 : </label></th>
                <td><textarea id="addr" name="addr" placeholder="address"></textarea></td>
            </tr>
            <tr>
                <th><label for=""></label></th>
                <td></td>
            </tr>
        </table>
        <input type="hidden" id="{csrf_name}" name="{csrf_name}" value="{csrf_value}">
        <input id="btn_submit" type="submit" value="{btn_value}">
    </form>
    <script type="text/javascript" src="{base_url}login/get_url/register"></script>
</div>