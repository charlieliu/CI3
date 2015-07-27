<div id="body">
    <p>{current_page}/{current_fun}</p>

    <div class="content_block">
        <input id="check1" type="checkbox">
        <label for="check1">Check me</label>
        <p id="show_me1"></p>
        <button id="attr_me">attr_me</button>
        <button id="prop_me">prop_me</button>
    </div>

    <div>
        $('#attr_me').click(function(){<br>
        &nbsp;&nbsp;&nbsp;&nbsp;if( $("#check1").attr( "disabled" )!=undefined ) $("#check1").removeAttr("disabled").change();<br>
        &nbsp;&nbsp;&nbsp;&nbsp;else $("#check1").attr( "disabled", "disabled" ).change();<br>
        });<br>
    </div>

    <div>
        $('#prop_me').click(function(){<br>
        &nbsp;&nbsp;&nbsp;&nbsp;if( $("#check1").prop( "disabled" )==true ) $("#check1").prop("disabled",false).change();<br>
        &nbsp;&nbsp;&nbsp;&nbsp;else $("#check1").prop( "disabled", true ).change();<br>
        });<br>
    </div>
</div>