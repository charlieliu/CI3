<div id="body">
    <p>{current_page}/{current_fun}</p>

    <div style="margin:1em;">
        <p>執行順序(後面蓋前面)</p>
        <ul>
            <li>$(function(){});&nbsp;/&nbsp;$(document).ready(function(){});</li>
            <li>$(window).load(function(){});</li>
            <li>window.onload = function(){};</li>
        </ul>
        <div id="show_info"></div>
    </div>
    <div>
        <ul style="color:red;">
            <li>jQuery(document).ready(function() { … }) 《  或簡寫為 $(function() { … });  》
                <ul style="color:blue;">
                    <li>當 document 物件下所有 DOM 物件都可以正確取得時，就會觸發 jQuery.ready() 註冊的 function，這時雖然後 &lt;img src="…" /&gt; 定義的圖片正在下載，但由於 &lt;img&gt; 這個 DOM 物件已經都 ready 了，所以 jQuery 並不會等圖片全部下載完畢才執行 ready 事件。</li>
                </ul>
            </li>
            <li>jQuery(window).load(function() { … })
                <ul style="color:blue;">
                    <li>而使用 window 的 load 事件，卻是完全不同的行為，jQuery 裡的 window 的 load 事件與 JavaScript 裡的 window.onload 事件一模一樣，註冊在這裡面的事件都會等到整個視窗裡所有資源都已經全部下載後才會執行，例如該頁面有 100 張圖片就會等 100 圖片都下載完才會執行，其中也包括所有 iframe 子頁面的內容必須完整載入。</li>
                </ul>
            </li>
        </ul>
    </div>
</div>