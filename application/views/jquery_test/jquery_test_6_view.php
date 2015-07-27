<div id="body">
    <p>{current_page}/{current_fun}</p>

    <div>
        <ul id="menu" class="ul_1">
            <li class="li_1">level 1</li>
            <li class="li_1">
                <ul class="ul_2">
                    <li class="li_2">level 2</li>
                </ul>
            </li>
             <li class="li_1">
                <ul class="ul_2">
                    <li class="li_2">
                        <ul class="ul_3">
                            <li class="li_3">level 3</li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="li_1">
                <ul class="ul_2">
                    <li class="li_2">level 2</li>
                    <li class="li_2">
                        <ul class="ul_3">
                            <li>level 3</li>
                            <li>javascript : <label><input type="checkbox" id="parent">$(this).parent("label").parent("li").parent("ul").css("background", "yellow");</label></li>
                            <li>level 3</li>
                        </ul>
                    </li>
                    <li class="li_2">level 2</li>
                    <li class="li_2">
                        <ul class="ul_3">
                            <li class="li_3">level 3</li>
                            <li class="li_3">javascript : <label><input type="checkbox" id="parents">$(this).parents("ul").css("background", "blue");</label></li>
                            <li class="li_3">level 3</li>
                        </ul>
                    </li>
                    <li class="li_2">
                        <ul class="ul_3">
                            <li class="li_3">level 3</li>
                            <li class="li_3">javascript : <label><input type="checkbox" id="closest">$(this).closest("ul").css("background", "red");</label></li>
                            <li class="li_3">level 3</li>
                        </ul>
                    </li>
                    <li class="li_2">level 2</li>
                    <li class="li_2">javascript : <label><input type="checkbox" id="parents2">$(this).parents("ul").css("background", "green");</label></li>
                    <li class="li_2">level 2</li>
                </ul>
            </li>
        </ul>
    </div>

    <div id="showobj_info"></div>
</div>