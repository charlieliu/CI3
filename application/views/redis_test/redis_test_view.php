<div id="body">
    <p>{current_page}/{current_fun}</p>

    {grid_view}

    <div class="content_block">
        <p>MULTI</p>
        <ol>
            <li>MULTI</li>
            <li>SET key 1</li>
            <li>SET key {class}</li>
            <li>EXEC</li>
        </ol>
        <form class="redis_test" >
            <input type="hidden" name="redis_act" value="MULTI">
            <input type="hidden" name="{csrf_name}" value="{csrf_value}">
            <input type="submit" value="MULTI TEST">
        </form>
    </div>

    <div class="content_block" id="redis_log">{redis_log}</div>

    <div class="content_block" id="xhprof_dif"></div>

    <script type="text/javascript" src="{base_url}{class}/get_url/redis_get"></script>
</div>