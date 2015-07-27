<div id="body">
    <p>{current_page}/{current_fun}</p>

    <!-- 反轉 -->
    <div class="content_block">
        <h3>用CSS反轉</h3>
        <div>transform:rotate(180deg)</div>
        <ol class="ul_rotate">
            {content}
            <li class="li_rotate">{ol_li}</li>
            {/content}
        </ol>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/css_test_2.css" />
    </div>
    <!-- 反轉 -->
</div>