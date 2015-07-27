<div id="body">
    <p>{current_page}/{current_fun}</p>

    <div class="demonstrate">
        <table>
            <tr>
                <td>
                    <div class="demo">
                        <span class="front"><img title="翻轉" alt="图片" src="{base_url}images/j.jpg" ></span>
                        <span class="behind"><img title="翻轉" alt="图片" src="{base_url}images/joba.jpg" ></span>
                    </div>
                </td>
                <td>
                    <div class="demo">
                        <span class="front"><img title="翻轉" alt="图片" src="{base_url}images/q.jpg" ></span>
                        <span class="behind"><img title="翻轉" alt="图片" src="{base_url}images/joba.jpg" ></span>
                    </div>
                </td>
                <td>
                    <div class="demo">
                        <span class="front"><img title="翻轉" alt="图片" src="{base_url}images/u.jpg" ></span>
                        <span class="behind"><img title="翻轉" alt="图片" src="{base_url}images/joba.jpg" ></span>
                    </div>
                </td>
                <td>
                    <div class="demo">
                        <span class="front"><img title="翻轉" alt="图片" src="{base_url}images/e.jpg" ></span>
                        <span class="behind"><img title="翻轉" alt="图片" src="{base_url}images/joba.jpg" ></span>
                    </div>
                </td>
                <td>
                    <div class="demo">
                        <span class="front"><img title="翻轉" alt="图片" src="{base_url}images/r.jpg" ></span>
                        <span class="behind"><img title="翻轉" alt="图片" src="{base_url}images/joba.jpg" ></span>
                    </div>
                </td>
                <td>
                    <div class="demo">
                        <span class="front"><img title="翻轉" alt="图片" src="{base_url}images/y.jpg" ></span>
                        <span class="behind"><img title="翻轉" alt="图片" src="{base_url}images/joba.jpg" ></span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".demo").click(function(){
                var tag_front = $(this).find('.front'), tag_behind = $(this).find('.behind');
                if( tag_front.hasClass('hover') )
                {
                    tag_front.removeClass('hover');
                    tag_behind.removeClass('hover');
                }
                else
                {
                    tag_front.addClass('hover');
                    tag_behind.addClass('hover');
                }
                /* for old IE */
                if( /msie/.test(navigator.userAgent.toLowerCase()) )
                {
                    tag_front.fadeToggle();
                    tag_behind.fadeToggle();
                    tag_front = null;
                    tag_behind = null;
                }
            });
        });
    </script>

</div>