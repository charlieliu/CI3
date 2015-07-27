<div id="body">
    <p>{current_page}/{current_fun}</p>

    <!-- Variable Pairs -->
    <form name="form1" action="" >
        <p><label>Username&nbsp;:&nbsp;<input id="usr" name="u" required type="text"></label>
        <p><label>Password&nbsp;:&nbsp;<input id="pwd" name="p" required type="password" AUTOCOMPLETE="OFF"></label>
        <div>
            <dd id="result">
                <dl>
                    <dd id="strongth_L"></dd>
                    <dd id="strongth_M"></dd>
                    <dd id="strongth_H"></dd>
                    <span id="strongth_status" class="status"></span>
                </dl>
            </dd>
        </div>
        <button id="send" type="submit">Send</button>
    </form>
    <!-- Variable Pairs -->

    <script type="text/javascript" src="{base_url}js_test/get_top_pwds"></script>
</div>