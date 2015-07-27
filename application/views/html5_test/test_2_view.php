<div id="body">
    <p>{current_page}/{current_fun}</p>

    <div class="content_block mg1em padding1em">
        測試日期&nbsp;:&nbsp;{test_date}
    </div>

    <ul>
        {grid_view}
        <li>
            <form class="contact1">
                <div class="content_block mg1em padding1em">
                    &lt;input&nbsp;<span style="color:red;">type="range"</span>&nbsp;name="range" id="range" min="0" max="100" step="5" required&gt;<br>
                </div>
                <table class="mg1em" border="1" style="text-align:center;">
                    <tr>
                        <th>Arora</th>
                        <th>Chrome</th>
                        <th>Dillo</th>
                        <th>Elinks</th>
                        <th>Epiphany</th>
                        <th>Firefox</th>
                        <th>IE11</th>
                        <th>Midori</th>
                        <th>Opera</th>
                        <th>QupZilla</th>
                        <th>Safari</th>
                    </tr>
                    <tr>
                        <td>O</td>
                        <td>O</td>
                        <td>X</td>
                        <td>X</td>
                        <td>O</td>
                        <td>O</td>
                        <td>O</td>
                        <td>O</td>
                        <td>O</td>
                        <td>O</td>
                        <td>O</td>
                    </tr>
                </table>
                <div class="mg1em">
                    <input type="range" name="range" id="range" min="0" max="100" step="5" required>
                    <input type="hidden" name="{csrf_name}" value="{csrf_value}">
                    <input type="submit" name="submit" value="Submit">
                </div>
                <div class="mg1em results"></div>
            </form>
        </li>
        <li>
            <form class="contact1">
                <div class="content_block mg1em padding1em">
                    &lt;input type="text" name="country_code"&nbsp;<span style="color:red;">pattern="[A-Za-z]{3}"</span>&nbsp;title="Three letter country code" placeholder="Three letter country code" required&gt;<br>
                    &lt;input&nbsp;<span style="color:red;">type="submit"</span>&nbsp;name="submit" value="Submit"&gt;
                </div><table class="mg1em" border="1" style="text-align:center;">
                    <tr>
                        <th>Arora</th>
                        <th>Chrome</th>
                        <th>Dillo</th>
                        <th>Elinks</th>
                        <th>Epiphany</th>
                        <th>Firefox</th>
                        <th>IE11</th>
                        <th>Midori</th>
                        <th>Opera</th>
                        <th>QupZilla</th>
                        <th>Safari</th>
                    </tr>
                    <tr>
                        <td>X</td>
                        <td>O</td>
                        <td>X</td>
                        <td>X</td>
                        <td>X</td>
                        <td>O</td>
                        <td>O</td>
                        <td>X</td>
                        <td>O</td>
                        <td>X</td>
                        <td>X</td>
                    </tr>
                </table>
                <div class="mg1em">
                    <input type="text" name="country_code" pattern="[A-Za-z]{3}" title="Three letter country code" placeholder="Three letter country code" required>
                    <input type="hidden" name="{csrf_name}" value="{csrf_value}">
                    <input type="submit" name="submit" value="Submit">
                </div>
                <div class="mg1em results"></div>
            </form>
        </li>
        <li>
            <form method="POST" enctype="multipart/form-data">
                <div class="content_block mg1em padding1em">
                    &lt;keygen name="security"&gt;
                </div>
                <div class="mg1em">
                    Username: <input type="text" name="usr_name">
                    Encryption: <keygen name="security" autofocus>
                    <input type="hidden" name="{csrf_name}" value="{csrf_value}">
                    <input type="submit" name="submit" value="Submit">
                </div>
                <div class="mg1em results"></div>
            </form>
        </li>
    </ul>
</div>