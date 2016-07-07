<div id="body">
    <p>{current_page}/{current_fun}</p>

    <form method="POST">
        <input id="str" name="str" type="text" value="{str}">
        <input type="hidden" name="{csrf_name}" value="{csrf_value}">
        <button type="submit">查詢</button>
    </form>

    <!-- Variable Pairs -->
    <table id="table-transform" data-toolbar="#transform-buttons" border="1" style="margin:1em;">
        <thead>
            <tr>
                <th>說明</th>
                <th>結果</th>
            </tr>
        </thead>
        <tbody id="grid_view">
            {grid_view}
        </tbody>
    </table>
    <!-- Variable Pairs -->
</div>