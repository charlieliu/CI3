<div id="body">
    <p>{current_page}/{current_fun}</p>

    <form method="POST">
        <input type="text" name="hash_str" value="{hash_str}">
        <input type="hidden" id="{csrf_name}" name="{csrf_name}" value="{csrf_value}">
        <input type="submit" value="查詢">
    </form>

    <!-- Variable Pairs -->
    <table id="table-transform" data-toolbar="#transform-buttons" border="1" style="margin:1em;z">
        <thead>
            <tr>
                <th>方式</th>
                <th>編碼</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>原文</td>
                <td>{hash_str}</td>
            </tr>
            {content}
            <tr>
                <td>{content_title}</td>
                <td>{content_value}</td>
            </tr>
            {/content}
        </tbody>
    </table>
    <!-- Variable Pairs -->
</div>