<div id="body">
    <p>{current_page}/{current_fun}</p>

    <div class="content_block mg1em padding1em">
        &lt;input&nbsp;<span style="color:red;">list="browsers"</span>&nbsp;name="browser"&gt;<br>
        &lt;datalist&nbsp;<span style="color:red;">id="browsers"</span>&gt;<br>
        <?php foreach ($browsers as $val): ?>{space_4}&lt;option value="<?=$val?>"&gt;<br><?PHP endforeach; ?>
        &lt;/datalist&gt;<br>
        &lt;input type="submit"&gt;<br>
        <form id="contact1">
            <input list="browsers" name="browser">
            <datalist id="browsers">
                <?php foreach ($browsers as $val): ?><option value="<?=$val?>"><?PHP endforeach; ?>
            </datalist>
            <input type="hidden" id="{csrf_name}" name="{csrf_name}" value="{csrf_value}">
            <input type="submit">
        </form>

        <p><strong>Note:</strong> The datalist tag is not supported in Internet Explorer 9 and earlier versions, or in Safari.</p>
    </div>

    <div id="results" class="mg1em"></div>

    <script type="text/javascript" src="{base_url}html5_test/get_url/3"></script>

</div>