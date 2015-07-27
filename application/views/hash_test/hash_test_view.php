<div id="body">
    <p>{current_page}/{current_fun}</p>

    <form method="POST">
        <input type="text" id="{hash_str}" value="{hash_str}">
        <input type="hidden" id="{csrf_name}" name="{csrf_name}" value="{csrf_value}">
        <input type="hidden" id="{hidden_text}" name="{hidden_text}" value="{hidden_text}">
        <span id="btn_show"><input type="button" id="btn_submit" value="查詢"></span>
        <span id="btn_disp" style="display:none;">查詢.....</span>
    </form>

    <script type="text/javascript" src="{base_url}hash_test/get_url?v={version}"></script>
    <script type="text/javascript" src="{base_url}hash_test/get_js?v={version}"></script>
</div>