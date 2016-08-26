<div id="body">
    <p>{current_page}/{current_fun}</p>
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Autocomplete</a></li>
            <li><a href="#tabs-2">Datepicker</a></li>
            <li><a href="#tabs-3">Spinner</a></li>
            <li><a href="#tabs-4">Timepicker</a></li>
        </ul>
        <div id="tabs-1">
            <h3>Autocomplete</h3>
            <div class="ui-widget">
                <label for="tags">label:
                    <input type="text" id="tags">
                </label>
            </div>
        </div>

        <div id="tabs-2">
            <h3>Datepicker</h3>
            <a herf="https://jqueryui.com/datepicker/">jquery-datepicker</a>
            <p>Date: <input type="text" id="datepicker"></p>
            <div>Methods getDate: <span id="date_value"></span></div>
            <h3>Ymd</h3>
            <div><input type="text" class="format_datepicker" disabled="disabled" data-dateformat="yy/mm/dd" value="2016/07/31"><span class="date_value"></span></div>
            <div><input type="text" class="format_datepicker" disabled="disabled" data-dateformat="yy-mm-dd" value="2016-07-31"><span class="date_value"></span></div>
            <h3>mdY</h3>
            <div><input type="text" class="format_datepicker" disabled="disabled" data-dateformat="mm/dd/yy" value="07/31/2016"><span class="date_value"></span></div>
            <div><input type="text" class="format_datepicker" disabled="disabled" data-dateformat="mm-dd-yy" value="07-31-2016"><span class="date_value"></span></div>
            <div><input type="text" class="format_datepicker" disabled="disabled" data-dateformat="mm/dd/yy" value="07/01/2016"><span class="date_value"></span></div>
            <div><input type="text" class="format_datepicker" disabled="disabled" data-dateformat="mm-dd-yy" value="07-01-2016"><span class="date_value"></span></div>
            <h3>dmY</h3>
            <div><input type="text" class="format_datepicker" disabled="disabled" data-dateformat="dd/mm/yy" value="31/07/2016"><span class="date_value"></span></div>
            <div><input type="text" class="format_datepicker" disabled="disabled" data-dateformat="dd-mm-yy" value="31-07-2016"><span class="date_value"></span></div>
            <div><input type="text" class="format_datepicker" disabled="disabled" data-dateformat="dd/mm/yy" value="01/07/2016"><span class="date_value"></span></div>
            <div><input type="text" class="format_datepicker" disabled="disabled" data-dateformat="dd-mm-yy" value="01-07-2016"><span class="date_value"></span></div>
        </div>

        <div id="tabs-3">
            <h3>Spinner</h3>
            <p>
                <label for="spinner">Select a value:
                    <input id="spinner" name="value">
                </label>
            </p>
            <p>
                <button id="disable">Toggle disable/enable</button>
                <button id="destroy">Toggle widget</button>
                <button id="getvalue">Get value</button>
                <button id="setvalue">Set value to 5</button>
            </p>
        </div>

        <div id="tabs-4">
            <h3>Timepicker</h3>
            <a herf="http://jonthornton.github.io/jquery-timepicker/">jquery-timepicker</a>
            <p>Time: <input type="text" id="timepicker"></p>
            <div><button id="time_value">setTime</button></div>
        </div>
    </div>
</div>