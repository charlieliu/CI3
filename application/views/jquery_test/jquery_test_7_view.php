<div id="body">
    <p>{current_page}/{current_fun}</p>

    <div>
        <ul id="menu" class="ul_1">
            <li class="li_1">level 1</li>
            <li class="li_1">
                <ul class="ul_2">
                    <li class="li_2">level 2</li>
                    <li class="li_2">javascript : <label><input type="checkbox" id="siblings2">$(this).parent("label").parent("li").siblings("li").css("background", "#DDD");</label></li>
                    <li class="li_2">level 2</li>
                </ul>
            </li>
             <li class="li_1">
                <ul class="ul_2">
                    <li class="li_2">
                        <ul class="ul_3">
                            <li class="li_3">level 3</li>
                            <li class="li_3">javascript : <label><input type="checkbox" id="prev">$(this).parent("label").parent("li").prev("li").css("background", "#888");</label></li>
                            <li class="li_3">level 3</li>
                            <li class="li_3">javascript : <label><input type="checkbox" id="prevAll">$(this).parent("label").parent("li").prevAll("li").css("background", "#AAA");</label></li>
                            <li class="li_3">level 3</li>
                            <li class="li_3">javascript : <label><input type="checkbox" id="siblings">$(this).parent("label").parent("li").siblings("li").css("background", "#DDD");</label></li>
                            <li class="li_3">level 3</li>
                            <li class="li_3">javascript : <label><input type="checkbox" id="nextAll">$(this).parent("label").parent("li").nextAll("li").css("background", "#AAA");</label></li>
                            <li class="li_3">level 3</li>
                            <li class="li_3">javascript : <label><input type="checkbox" id="next">$(this).parent("label").parent("li").next("li").css("background", "#888");</label></li>
                            <li class="li_3">level 3</li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <div id="showobj_info"></div>
</div>