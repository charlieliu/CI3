<div id="body">
    <p>{current_page}/{current_fun}</p>

    <div class="content_block">
        <p>informations:</p>
        <ol>
            <li>Top 500 web passwords</li>
            <li>Top 500 icloud passwords</li>
            <li>Some passwords from  hack tool(john)</li>
            <li>Sometime icloud passwords is same as web passwords</li>
        </ol>
    </div>

    <div class="content_block">
        <form id="frm1" method="post" target="ifm_exp" action="get_pwd_excel">
            <input type="text" id="hash_str" name="hash_str" style="width:80%;" value="">
            <input type="button" id="frm1_submit" value="查詢">
            <input type="reset" id="frm1_reset" value="清除表單">
            <input type="button" id="down_xls" value="downloads xls">
            <input type="hidden" id="frm1_page" name="page" value="">
            <input type="hidden" id="frm1_page_max" name="page_max" value="{page_max}">
            <input type="hidden" id="{csrf_name}" name="{csrf_name}" value="{csrf_value}">
        </form>
        <iframe id="ifm_exp" name="ifm_exp" style="display:none;"></iframe>
    </div>

    <div class="content_block" style="overflow-x:scroll;width:100%;">
        <table class="mg1em" border="1" style="text-align:center;">
            {table_grid_view}
        </table>
    </div>

    <div class="content_block">
        <a class="prev-page btn disable" href="javascript:prev();" >prev</a>
        <input class="current-page" id="pageNow" name="pageNow" value="{page}" style="width:50px;" >/<span class="current-page" id="pageCnt" name="pageCnt">{pagecnt}</span>
        <a class="next-page btn disable" href="javascript:next();" >next</a>
        <span id="pageDropdown" name="pageDropdown">{page_dropdown}</span>
    </div>

    <script type="text/javascript" src="{base_url}php_test/get_url/get_top_500_pwd"></script>

</div>