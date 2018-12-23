<div id="body">
    <p>{current_page}/{current_fun}</p>

    <!-- Variable Pairs -->
    <table id="table-transform" border="1" style="margin:1em;font-size:24px;">
        <thead>
            <tr>
                <th style="min-width:200px">題目</th>
                <th>答案</th>
            </tr>
        </thead>
        <tbody id="grid_view">
            <form method="POST">
                {grid_view}
            </form>
        </tbody>
    </table>
    <!-- Variable Pairs -->
</div>