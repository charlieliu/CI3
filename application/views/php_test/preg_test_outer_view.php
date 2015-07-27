<div id="body">
    <p>{current_page}/{current_fun}</p>

    <form method="POST">
        <input id="str" type="text" value="">
        <input id="seach" type="button" value="查詢">
    </form>

    <!-- Variable Pairs -->
    <table id="table-transform" data-toolbar="#transform-buttons" border="1" style="margin:1em;">
        <thead>
            <tr>
                <th>說明</th>
                <th>正規表達式</th>
                <th>測試結果</th>
                <th>正規表達式</th>
                <th>測試結果</th>
            </tr>
        </thead>
        <tbody id="grid_view">
            {grid_view}
        </tbody>
    </table>
    <!-- Variable Pairs -->
</div>