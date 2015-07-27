<div id="body">
    <p>{current_page}/{current_fun}</p>

    <div>
        <h3>
            call([thisObj[, arg1[, arg2[,  [, argN]]]]])<br>
            apply( thisArg, argArray );
        </h3>
        <div style="color:blue;">
            thisObj 選擇項。 為目前的使用物件。<br>
            arg1, arg2, , argN 選擇項。 要傳遞給方法的引數清單。<br>
            call 方法是用來代替另一個物件呼叫方法。 此方法可讓您將函式的 this 物件從原始內容變成由 thisObj 所指定的新物件。<br>
            如果未提供 thisObj 的話，將使用 global 物件做為 thisObj。<br>
        </div>
        <div style="color:red;">
            call()與apply()用途相同，唯一的差別在於，call()必須一一明列出參數，例如funcName.call(thisArg, arg1, arg2, ...)。
            apply()第二個參數必須是個Array，否則會產生參數型態錯誤的Error
        </dvi>
    </div>

    <!--<a id="link" href="<?=base_url()?>js_test/jquery_test/5">call / apply</a>-->
    <div class="content_block">
        <h3>3 functions call / apply</h3>
        <div>
            function TestApply1(){
                alert(this.attr('href'));
            };
        </div>
        <div>
            <button id="TestApply1" style="margin:1em;">TestApply1.apply($('#link'));</button>
            <button id="TestCall1" style="margin:1em;">TestApply1.call($('#link'));</button>
        </div>
        <div>
            function TestApply2(){
                alert(this.pig);
            };
        </div>
        <div>
            <button id="TestApply2" style="margin:1em;">TestApply2.apply(window);</button>
            <button id="TestCall2" style="margin:1em;">TestApply2.call(window);</button>
        </div>
        <div>
            function TestApply3(arg1, arg2){
                alert(this.myName+' '+arg1+' '+arg2);
            };
        </div>
        <div>
            <button id="TestApply3" style="margin:1em;">TestApply3.apply(new obj(), ['是個', '好地方']);</button>
            <button id="TestCall3" style="margin:1em;">TestApply3.call(new obj(), ['是個', '好地方']);</button>
        </div>
    </div>

    <div class="content_block">
        <h3>a function call / apply</h3>
        <div>
            function AlertValue() {
                alert(this.value);
                if( arguments.length>0 )
                {
                    for (var i = 0; i &lt; arguments.length; i++) {
                        if (typeof (arguments[i]) != "object") alert(arguments[i]);
                    }
                }
            };
        </div>
        <div><button id="A" style="margin:1em;">AlertValue</button></div>
        <div>
            <button id="B" style="margin:1em;">AlertValue.apply(this, ["1", "2", "3"]);</button>
            <button id="C" style="margin:1em;">AlertValue.call(this, ["1", "2", "3"]);</button>
        </div>
        <div>
            <button id="D" style="margin:1em;">AlertValue.apply(this);</button>
            <button id="E" style="margin:1em;">AlertValue.call(this);</button>
        </div>
        <div>
            <button id="F" style="margin:1em;">AlertValue.apply({value:'0'});</button>
            <button id="G" style="margin:1em;">AlertValue.call({value:'0'});</button>
        </div>
    </div>

    <div class="content_block">
        <h3>object call / apply</h3>
        <div class="showobj_info" style="color:green;"></div>
        <div>
            <div>
                function Animal(){
                    this.name = 'Animal';
                    this.category = 'Creature';
                    this.showName = function(){showobj(this)};
                    this.setName = function(str){this.name=str;};
                };<br>
                var animal = new Animal();
            </div>
            <button id="Animal" style="margin:1em;">animal.showName();</button>
            <button id="showobj" style="margin:1em;">showobj('');</button>
        </div>
        <div>
            <div>
                // Cat不繼承Animal<br>
                function Cat(){
                    this.name = 'Cat';
                };<br>
            </div>
            <button id="Cat_call" style="margin:1em;">animal.showName.call(cat);</button>
            <button id="Cat_apply" style="margin:1em;">animal.showName.apply(cat);</button>
            <button id="showobj_cat" style="margin:1em;">showobj(cat);</button>
        </div>
        <div>
            <div>
                // Dog繼承Animal<br>
                function Dog_call(){
                    <span style="color:green;">Animal.call(this);</span>
                    <span style="color:blue;">this.setName('Dog');</span>
                };<br>
                Dog_call.prototype = { <span style="color:blue;">prototype_parent : 'Animal'</span> };<br>
                var dog_call = new Dog_call();<br>
                <br>
                function Dog_apply(){
                    <span style="color:green;">Animal.apply(this);</span>
                    <span style="color:blue;">this.setName('Dog');</span>
                };<br>
                Dog_apply.prototype = { <span style="color:blue;">prototype_parent : 'Animal'</span> };<br>
                var dog_apply = new Dog_apply();<br>
            </div>
            <button id="Dog_call" style="margin:1em;">dog_call.showName();</button>
            <button id="Dog_apply" style="margin:1em;">dog_apply.showName();</button>
        </div>
    </div>

    <div class="content_block">
        <h3>繼承延伸測試</h3>
        <div style="overflow:auto;" >
            <table border='1' style="min-width:1420px;width:100%;">
                <thead>
                    <tr>
                        <th></th>
                        <th>animal</th>
                        <th>birds</th>
                        <th>duck</th>
                        <th>ostrich</th>
                        <th>chicken</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>繼承</td>
                        <td>無</td>
                        <td>Birds繼承Animal</td>
                        <td>Duck繼承Birds</td>
                        <td>Ostrich繼承Birds</td>
                        <td>Chicken繼承Birds</td>
                    </tr>
                    <tr>
                        <td>code</td>
                        <td>
                            function Animal(){<br>
                            {space_4}this.name = 'Animal';<br>
                            {space_4}this.category = 'Creature';<br>
                            {space_4}this.showName = function(){showobj(this)};<br>
                            {space_4}this.setName = function(str){this.name=str;};<br>
                            };<br>
                            <br>
                            var animal = new Animal();<br>
                        </td>
                        <td>
                            function Birds(){<br>
                            {space_4}<span style="color:red;">this.name = 'Birds';</span><br>
                            {space_4}Animal.call(this);<br>
                            };<br>
                            <br>
                            Birds.prototype = {<br>
                            {space_4}<span style="color:red;">name : 'Birds',</span><br>
                            {space_4}<span style="color:blue;">skills : 'fly'</span><br>
                            };<br>
                            <br>
                            var birds = new Birds;<br>
                        </td>
                        <td>
                            function Duck(){<br>
                            {space_4}Birds.call(this);<br>
                            {space_4}this.setName('Duck');<br>
                            };<br>
                            <br>
                            var duck = new Duck;<br>
                        </td>
                        <td>
                            function Ostrich(){<br>
                            {space_4}Birds.call(this);<br>
                            {space_4}<span style="color:blue;">this.setName('Ostrich');</span><br>
                            {space_4}<span style="color:blue;">this.skills = 'run';</span><br>
                            };<br>
                            <br>
                            var ostrich = new Ostrich;<br>
                        </td>
                        <td>
                            function Chicken(){<br>
                            {space_4}Birds.call(this);<br>
                            {space_4}<span style="color:blue;">this.name = 'Chicken';</span><br>
                            };<br>
                            <br>
                            Chicken.prototype = {<br>
                            {space_4}<span style="color:blue;">skills : 'run',</span><br>
                            };<br>
                            <br>
                            var chicken = new Chicken;<br>
                        </td>
                    </tr>
                    <tr style="color:red;">
                        <td>錯誤</td>
                        <td></td>
                        <td>
                            Birds.name 被 Animal.mane 覆蓋<br>
                            Birds.prototype.name 未作用
                        </td>
                        <td>Birds.prototype.skills 未繼承到 Duck</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="color:blue;">
                        <td>注意</td>
                        <td>
                            this.name = this.name || 'Animal';<br>
                            可修正 this.name覆蓋問題
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Chicken.prototype.skills 需再綁定一次</td>
                    </tr>
                    <tr style="color:green;">
                        <td>output</td>
                        <td id="animal"></td>
                        <td id="birds"></td>
                        <td id="duck"></td>
                        <td id="ostrich"></td>
                        <td id="chicken"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="content_block">
        <h3>Array.prototype.slice.call(arguments)</h3>
        <div>
            <ul style="color:blue;">
                <li>array.slice(begin[, end]) : The slice() method returns a shallow copy of a portion of an array into a new array object.</li>
                <li>arguments : 可用來取得function傳入的實際變數Array。這個變數特別適合用在撰寫”多形”(Polymorphism)函式上，即可以根據不同的傳入參數做不同的處理。</li>
                <li>P.S. arguments, caller, callee, this都是用在函式(function)內的特殊內定物件。而apply()及call()則是用來呼叫函式的不同作法。</li>
            </ul>
            <br>
            function list(){<br>
            {space_4}var table = $('&lt;table border="1"&gt;&lt;/table&gt;').css('margin','1em').append(row);......<br>
            {space_4}$('#list_info').append(table);<br>
            }<br>
            <br>
            var list1 = list(1, 2, 3);<br>
            var leadingZeroList = list.bind(undefined, 37);<br>
            var list2 = leadingZeroList();<br>
            var list3 = leadingZeroList('X', 'Y', 'Z');<br>
            var list4 = list.apply(undefined, ['X', 'Y', 'Z']);
        </div>
        <div id="list_info"></div>
    </div>

</div>